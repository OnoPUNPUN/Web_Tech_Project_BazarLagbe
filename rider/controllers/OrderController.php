<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/RiderModel.php';

class OrderController {
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
        $message = [];

        if (isset($_POST['update_status'])) {
            $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

            $allowed_statuses = ['confirmed', 'processing', 'out_for_delivery', 'delivered'];
            if (in_array($status, $allowed_statuses)) {
                $this->riderModel->updateOrderStatus($order_id, $status, $rider_id, $is_admin);
                $message[] = 'delivery status updated successfully!';
            }
        }

        $orders = $this->riderModel->getAssignedOrders($rider_id, $is_admin);
        foreach ($orders as &$order) {
            $order['items'] = $this->riderModel->getOrderItems($order['id']);
        }

        require __DIR__ . '/../views/orders.php';
    }
}

?>
