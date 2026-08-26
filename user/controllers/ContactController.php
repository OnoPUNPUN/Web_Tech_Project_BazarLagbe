<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/ContactModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/WishlistModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class ContactController {
    private $contactModel;
    private $cartModel;
    private $wishlistModel;
    private $userModel;

    public function __construct() {
        global $conn;
        check_auth();
        $this->contactModel = new ContactModel($conn);
        $this->cartModel = new CartModel($conn);
        $this->wishlistModel = new WishlistModel($conn);
        $this->userModel = new UserModel($conn);
    }

    public function handleRequest() {
        $user_id = $_SESSION['user_id'];
        $fetch_profile = $this->userModel->getUserById($user_id);
        $message = [];

        if (isset($_POST['send'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
            $msg = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);

            if ($this->contactModel->checkMessageExists($user_id, $name, $email, $number, $msg)) {
                $message[] = 'already sent message!';
            } else {
                $this->contactModel->addMessage($user_id, $name, $email, $number, $msg);
                $message[] = 'sent message successfully!';
            }
        }

        $count_cart_items = $this->cartModel->countCartItems($user_id);
        $count_wishlist_items = $this->wishlistModel->countWishlistItems($user_id);

        require __DIR__ . '/../views/contact.php';
    }
}

?>
