<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/WishlistModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class WishlistController {
    private $wishlistModel;
    private $cartModel;
    private $productModel;
    private $userModel;

    public function __construct() {
        global $conn;
        check_auth();
        $this->wishlistModel = new WishlistModel($conn);
        $this->cartModel = new CartModel($conn);
        $this->productModel = new ProductModel($conn);
        $this->userModel = new UserModel($conn);
    }

    public function handleRequest() {
        $user_id = $_SESSION['user_id'];
        $fetch_profile = $this->userModel->getUserById($user_id);
        $message = [];

        if (isset($_POST['add_to_cart'])) {
            $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
            $p_name = filter_var($_POST['p_name'], FILTER_SANITIZE_STRING);
            $p_price = filter_var($_POST['p_price'], FILTER_SANITIZE_STRING);
            $p_image = filter_var($_POST['p_image'], FILTER_SANITIZE_STRING);
            $p_qty = filter_var($_POST['p_qty'], FILTER_SANITIZE_STRING);

            $product = $this->productModel->getProductById($pid);
            $current_stock = $product ? $product['stock_quantity'] : 0;

            if ($p_qty > $current_stock) {
                $message[] = 'insufficient stock! available: ' . $current_stock;
            } else {
                if ($this->cartModel->checkCartItem($user_id, $p_name)) {
                    $message[] = 'already added to cart!';
                } else {
                    $this->wishlistModel->deleteWishlistItemByName($user_id, $p_name);
                    $this->cartModel->addToCart($user_id, $pid, $p_name, $p_price, $p_qty, $p_image);
                    $message[] = 'added to cart!';
                }
            }
        }

        if (isset($_GET['delete'])) {
            $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
            $this->wishlistModel->deleteWishlistItem($delete_id);
            header('Location: index.php?page=wishlist');
            exit();
        }

        if (isset($_GET['delete_all'])) {
            $this->wishlistModel->deleteAllWishlistItems($user_id);
            header('Location: index.php?page=wishlist');
            exit();
        }

        $wishlist_items = $this->wishlistModel->getUserWishlist($user_id);
        $count_cart_items = $this->cartModel->countCartItems($user_id);
        $count_wishlist_items = $this->wishlistModel->countWishlistItems($user_id);

        require __DIR__ . '/../views/wishlist.php';
    }
}

?>
