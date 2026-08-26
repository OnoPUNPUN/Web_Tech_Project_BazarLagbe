<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/WishlistModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class ShopController {
    private $productModel;
    private $categoryModel;
    private $cartModel;
    private $wishlistModel;
    private $userModel;

    public function __construct() {
        global $conn;
        check_auth();
        $this->productModel = new ProductModel($conn);
        $this->categoryModel = new CategoryModel($conn);
        $this->cartModel = new CartModel($conn);
        $this->wishlistModel = new WishlistModel($conn);
        $this->userModel = new UserModel($conn);
    }

    public function handleRequest() {
        $user_id = $_SESSION['user_id'];
        $fetch_profile = $this->userModel->getUserById($user_id);
        $message = [];

        if (isset($_POST['add_to_wishlist'])) {
            $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
            $p_name = filter_var($_POST['p_name'], FILTER_SANITIZE_STRING);
            $p_price = filter_var($_POST['p_price'], FILTER_SANITIZE_STRING);
            $p_image = filter_var($_POST['p_image'], FILTER_SANITIZE_STRING);

            if ($this->wishlistModel->checkWishlistItem($user_id, $p_name)) {
                $message[] = 'already added to wishlist!';
            } elseif ($this->cartModel->checkCartItem($user_id, $p_name)) {
                $message[] = 'already added to cart!';
            } else {
                $this->wishlistModel->addToWishlist($user_id, $pid, $p_name, $p_price, $p_image);
                $message[] = 'added to wishlist!';
            }
        }

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
                    if ($this->wishlistModel->checkWishlistItem($user_id, $p_name)) {
                        $this->wishlistModel->deleteWishlistItemByName($user_id, $p_name);
                    }
                    $this->cartModel->addToCart($user_id, $pid, $p_name, $p_price, $p_qty, $p_image);
                    $message[] = 'added to cart!';
                }
            }
        }

        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
        $products = $this->productModel->getAllProducts($sort);
        $categories = $this->categoryModel->getCategories();
        $count_cart_items = $this->cartModel->countCartItems($user_id);
        $count_wishlist_items = $this->wishlistModel->countWishlistItems($user_id);

        foreach ($products as &$prod) {
            $stats = $this->productModel->getProductReviewStats($prod['id']);
            $prod['avg_rating'] = $stats['avg_rating'];
            $prod['total_reviews'] = $stats['total_reviews'];
        }

        require __DIR__ . '/../views/shop.php';
    }
}

?>
