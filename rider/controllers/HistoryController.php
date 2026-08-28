<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/RiderModel.php';

class HistoryController {
    private $riderModel;

    public function __construct() {
        global $conn;
        check_auth(['rider', 'admin']);
        $this->riderModel = new RiderModel($conn);
    }

    public function handleRequest() {
        $rider_id = $_SESSION['user_id'];
        $is_admin = ($_SESSION['user_type'] === 'admin');
        $fetch_profile = $this->riderModel->getProfile($rider_id);

        $orders = $this->riderModel->getDeliveryHistory($rider_id, $is_admin);
        foreach ($orders as &$order) {
            $order['items'] = $this->riderModel->getOrderItems($order['id']);
        }

        require __DIR__ . '/../views/history.php';
    }
}

?>
