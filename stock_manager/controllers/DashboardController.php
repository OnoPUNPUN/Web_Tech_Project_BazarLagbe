<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/StockManagerModel.php';

class DashboardController {
    private $stockManagerModel;

    public function __construct() {
        global $conn;
        check_auth(['stock_manager']);
        $this->stockManagerModel = new StockManagerModel($conn);
    }

    public function handleRequest() {
        $sm_id = $_SESSION['user_id'];
        $fetch_profile = $this->stockManagerModel->getProfile($sm_id);

        $current_month = date('F Y');

        $stats = [
            'number_of_products' => $this->stockManagerModel->getTotalProductsCount(),
            'number_in_stock' => $this->stockManagerModel->getInStockProductsCount(),
            'number_low_stock' => $this->stockManagerModel->getLowStockProductsCount(),
            'number_out_stock' => $this->stockManagerModel->getOutOfStockProductsCount(),
            'total_employees' => $this->stockManagerModel->getTotalEmployeesCount(),
            'pending_salaries' => $this->stockManagerModel->getPendingSalaryCount($current_month),
        ];

        $recent_movements = $this->stockManagerModel->getRecentStockMovements(5);

        require __DIR__ . '/../views/dashboard.php';
    }
}

?>
