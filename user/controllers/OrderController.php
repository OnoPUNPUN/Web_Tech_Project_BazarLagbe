<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/WishlistModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class OrderController {
    private $orderModel;
    private $cartModel;
    private $wishlistModel;
    private $userModel;

    public function __construct() {
        global $conn;
        check_auth();
        $this->orderModel = new OrderModel($conn);
        $this->cartModel = new CartModel($conn);
        $this->wishlistModel = new WishlistModel($conn);
        $this->userModel = new UserModel($conn);
    }

    public function handleRequest() {
        $user_id = $_SESSION['user_id'];
        $fetch_profile = $this->userModel->getUserById($user_id);
        $message = [];

        if (isset($_GET['cancel'])) {
            $cancel_id = filter_var($_GET['cancel'], FILTER_SANITIZE_STRING);
            if ($this->orderModel->cancelOrder($cancel_id, $user_id)) {
                $message[] = 'order cancelled successfully!';
            } else {
                $message[] = 'unable to cancel order!';
            }
        }

        $orders = $this->orderModel->getUserOrders($user_id);
        foreach ($orders as &$order) {
            $order['items'] = $this->orderModel->getOrderItems($order['id']);
        }

        $count_cart_items = $this->cartModel->countCartItems($user_id);
        $count_wishlist_items = $this->wishlistModel->countWishlistItems($user_id);

        require __DIR__ . '/../views/orders.php';
    }
}

?>
