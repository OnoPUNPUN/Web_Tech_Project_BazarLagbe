<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/ReviewModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/WishlistModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class ReviewController {
    private $reviewModel;
    private $cartModel;
    private $wishlistModel;
    private $userModel;

    public function __construct() {
        global $conn;
        check_auth();
        $this->reviewModel = new ReviewModel($conn);
        $this->cartModel = new CartModel($conn);
        $this->wishlistModel = new WishlistModel($conn);
        $this->userModel = new UserModel($conn);
    }

    public function handleRequest() {
        $user_id = $_SESSION['user_id'];
        $fetch_profile = $this->userModel->getUserById($user_id);
        $message = [];

        if (isset($_POST['submit_review'])) {
            $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
            $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
            $rating = filter_var($_POST['rating'], FILTER_SANITIZE_STRING);
            $review_text = filter_var($_POST['review'], FILTER_SANITIZE_STRING);

            if ($this->reviewModel->addReview($user_id, $product_id, $order_id, $rating, $review_text)) {
                $message[] = 'thank you! review submitted successfully.';
            } else {
                $message[] = 'failed to submit review!';
            }
        }

        $delivered_products = $this->reviewModel->getUserDeliveredProductsForReview($user_id);
        $user_reviews = $this->reviewModel->getUserReviews($user_id);

        $count_cart_items = $this->cartModel->countCartItems($user_id);
        $count_wishlist_items = $this->wishlistModel->countWishlistItems($user_id);

        require __DIR__ . '/../views/review.php';
    }
}

?>
