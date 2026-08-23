<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/AdminModel.php';

class DashboardController {
    private $adminModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->adminModel = new AdminModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->adminModel->getAdminProfile($admin_id);

        $stats = [
            'total_pendings' => $this->adminModel->getPendingSum(),
            'total_completed' => $this->adminModel->getCompletedSum(),
            'number_of_orders' => $this->adminModel->getOrderCount(),
            'number_of_products' => $this->adminModel->getProductCount(),
            'number_of_low_stock' => $this->adminModel->getLowStockCount(),
            'number_of_categories' => $this->adminModel->getCategoryCount(),
            'number_of_users' => $this->adminModel->getUserCountByType('user'),
            'number_of_stock_managers' => $this->adminModel->getUserCountByType('stock_manager'),
            'number_of_riders' => $this->adminModel->getUserCountByType('rider'),
            'number_of_admins' => $this->adminModel->getUserCountByType('admin'),
            'number_of_messages' => $this->adminModel->getMessageCount(),
            'number_of_reviews' => $this->adminModel->getReviewCount(),
        ];

        require __DIR__ . '/../views/dashboard.php';
    }
}

?>
