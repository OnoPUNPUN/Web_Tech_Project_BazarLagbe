<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/StockMovementModel.php';
require_once __DIR__ . '/../models/StockManagerModel.php';

class StockMovementController {
    private $movementModel;
    private $stockManagerModel;

    public function __construct() {
        global $conn;
        check_auth(['stock_manager']);
        $this->movementModel = new StockMovementModel($conn);
        $this->stockManagerModel = new StockManagerModel($conn);
    }

    public function handleRequest() {
        $sm_id = $_SESSION['user_id'];
        $fetch_profile = $this->stockManagerModel->getProfile($sm_id);

        $movements = $this->movementModel->getAllStockMovements();

        require __DIR__ . '/../views/stock_movements.php';
    }
}

?>
