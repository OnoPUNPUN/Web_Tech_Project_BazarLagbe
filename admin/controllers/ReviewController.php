<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/ReviewModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class ReviewController {
    private $reviewModel;
    private $adminModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->reviewModel = new ReviewModel($conn);
        $this->adminModel = new AdminModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->adminModel->getAdminProfile($admin_id);

        if (isset($_GET['delete'])) {
            $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
            $this->reviewModel->deleteReview($delete_id);
            header('Location: index.php?page=reviews');
            exit();
        }

        $reviews = $this->reviewModel->getAllReviews();
        require __DIR__ . '/../views/reviews.php';
    }
}

?>
