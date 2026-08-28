<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/StockManagerModel.php';

class InventoryController {
    private $stockManagerModel;

    public function __construct() {
        global $conn;
        check_auth(['stock_manager']);
        $this->stockManagerModel = new StockManagerModel($conn);
    }

    public function handleRequest() {
        $sm_id = $_SESSION['user_id'];
        $fetch_profile = $this->stockManagerModel->getProfile($sm_id);
        $message = [];

        if (isset($_POST['update_stock'])) {
            $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT);
            $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
            $quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
            $low_stock_threshold = filter_var($_POST['low_stock_threshold'], FILTER_SANITIZE_NUMBER_INT);
            $note = filter_var($_POST['note'], FILTER_SANITIZE_STRING);

            if ($quantity < 0) {
                $message[] = 'Quantity cannot be negative!';
            } else {
                $res = $this->stockManagerModel->adjustStock($pid, $sm_id, $type, $quantity, $note, $low_stock_threshold);
                if ($res) {
                    $message[] = 'Stock updated and movement recorded successfully!';
                } else {
                    $message[] = 'Failed to update stock!';
                }
            }
        }

        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $products = $this->stockManagerModel->getFilteredProducts($filter);

        require __DIR__ . '/../views/inventory.php';
    }
}

?>
