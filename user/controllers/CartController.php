<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/WishlistModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class CartController {
    private $cartModel;
    private $wishlistModel;
    private $userModel;

    public function __construct() {
        global $conn;
        check_auth();
        $this->cartModel = new CartModel($conn);
        $this->wishlistModel = new WishlistModel($conn);
        $this->userModel = new UserModel($conn);
    }

    public function handleRequest() {
        $user_id = $_SESSION['user_id'];
        $fetch_profile = $this->userModel->getUserById($user_id);
        $message = [];

        if (isset($_GET['delete'])) {
            $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
            $this->cartModel->deleteCartItem($delete_id);
            header('Location: index.php?page=cart');
            exit();
        }

        if (isset($_GET['delete_all'])) {
            $this->cartModel->deleteAllCartItems($user_id);
            header('Location: index.php?page=cart');
            exit();
        }

        if (isset($_POST['update_qty'])) {
            $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_STRING);
            $p_qty = filter_var($_POST['p_qty'], FILTER_SANITIZE_STRING);

            $prod = $this->cartModel->getCartProductStock($cart_id);

            if ($prod && $p_qty > $prod['stock_quantity']) {
                $message[] = 'insufficient stock available! max: ' . $prod['stock_quantity'];
            } else {
                $this->cartModel->updateCartQuantity($cart_id, $p_qty);
                $message[] = 'cart quantity updated!';
            }
        }

        $cart_items = $this->cartModel->getUserCart($user_id);
        $count_cart_items = $this->cartModel->countCartItems($user_id);
        $count_wishlist_items = $this->wishlistModel->countWishlistItems($user_id);

        require __DIR__ . '/../views/cart.php';
    }
}

?>
