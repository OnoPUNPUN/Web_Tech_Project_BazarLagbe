<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/WishlistModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class CheckoutController {
    private $cartModel;
    private $orderModel;
    private $wishlistModel;
    private $userModel;

    public function __construct() {
        global $conn;
        check_auth();
        $this->cartModel = new CartModel($conn);
        $this->orderModel = new OrderModel($conn);
        $this->wishlistModel = new WishlistModel($conn);
        $this->userModel = new UserModel($conn);
    }

    public function handleRequest() {
        $user_id = $_SESSION['user_id'];
        $fetch_profile = $this->userModel->getUserById($user_id);
        $message = [];

        if (isset($_POST['order'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
            $address = 'flat no. ' . $_POST['flat'] . ' ' . $_POST['street'] . ' ' . $_POST['city'] . ' ' . $_POST['state'] . ' ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
            $address = filter_var($address, FILTER_SANITIZE_STRING);
            $placed_on = date('d-M-Y');

            $cart_total = 0;
            $cart_items_data = [];
            $cart_products = [];

            $cart_items = $this->cartModel->getCartItemsWithStock($user_id);
            $stock_error = false;

            if (!empty($cart_items)) {
                foreach ($cart_items as $cart_item) {
                    if ($cart_item['quantity'] > $cart_item['stock_quantity']) {
                        $message[] = 'insufficient stock for ' . $cart_item['name'] . '! available: ' . $cart_item['stock_quantity'];
                        $stock_error = true;
                        break;
                    }
                    $cart_items_data[] = $cart_item;
                    $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
                    $sub_total = ($cart_item['price'] * $cart_item['quantity']);
                    $cart_total += $sub_total;
                }
            }

            $total_products = implode(', ', $cart_products);

            if (!$stock_error) {
                if ($cart_total == 0) {
                    $message[] = 'your cart is empty';
                } else {
                    $order_id = $this->orderModel->createOrder($user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on);

                    if ($order_id) {
                        foreach ($cart_items_data as $item) {
                            $this->orderModel->addOrderItem($order_id, $item['pid'], $item['quantity'], $item['price']);
                        }
                        $this->cartModel->deleteAllCartItems($user_id);
                        $lower_method = strtolower($method);
                        if (in_array($lower_method, ['bkash', 'nagad', 'rocket'])) {
                            header('location: index.php?page=payment&method=' . urlencode($lower_method) . '&amount=' . urlencode($cart_total) . '&step=2');
                            exit();
                        }
                        $message[] = 'order placed successfully!';
                    }
                }
            }
        }

        $cart_items = $this->cartModel->getUserCart($user_id);
        $count_cart_items = $this->cartModel->countCartItems($user_id);
        $count_wishlist_items = $this->wishlistModel->countWishlistItems($user_id);

        require __DIR__ . '/../views/checkout.php';
    }
}

?>
