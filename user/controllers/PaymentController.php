<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/WishlistModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class PaymentController {
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
        $count_cart_items = $this->cartModel->countCartItems($user_id);
        $count_wishlist_items = $this->wishlistModel->countWishlistItems($user_id);

        $step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;
        $selected_method = isset($_REQUEST['method']) ? $_REQUEST['method'] : '';
        $amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : '500';
        $phone_number = '';
        $transaction_id = '';
        $message = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['select_gateway'])) {
                $selected_method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
                if (!empty($selected_method)) {
                    $step = 2;
                } else {
                    $message[] = 'Please select a payment gateway!';
                    $step = 1;
                }
            } elseif (isset($_POST['process_payment'])) {
                $selected_method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
                $phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_STRING);
                $amount = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);

                if (empty($phone_number)) {
                    $message[] = 'Please enter your phone number!';
                    $step = 2;
                } else {
                    $transaction_id = 'TRX' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
                    $step = 3; 
                }
            }
        } else {
            if (!empty($selected_method) && $step == 1) {
                $step = 2;
            }
        }

        require __DIR__ . '/../views/payment.php';
    }
}

?>
