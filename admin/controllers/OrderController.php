<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class OrderController {
    private $orderModel;
    private $adminModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->orderModel = new OrderModel($conn);
        $this->adminModel = new AdminModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->adminModel->getAdminProfile($admin_id);
        $message = [];

        if (isset($_POST['update_order'])) {
            $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
            $update_payment = filter_var($_POST['update_payment'], FILTER_SANITIZE_STRING);
            $update_status = filter_var($_POST['update_status'], FILTER_SANITIZE_STRING);
            $rider_id = filter_var($_POST['rider_id'], FILTER_SANITIZE_STRING);

            $this->orderModel->updateOrder($order_id, $update_payment, $update_status, $rider_id);
            $message[] = 'order information has been updated!';
        }

        if (isset($_GET['delete'])) {
            $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
            $this->orderModel->deleteOrder($delete_id);
            header('Location: index.php?page=orders');
            exit();
        }

        $riders = $this->orderModel->getRiders();
        $orders = $this->orderModel->getAllOrders();

        foreach ($orders as &$order) {
            $order['items'] = $this->orderModel->getOrderItems($order['id']);
        }

        require __DIR__ . '/../views/orders.php';
    }
}

?>
