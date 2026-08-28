<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/RiderModel.php';

class DashboardController {
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

        $stats = [
            'number_active' => $this->riderModel->getActiveAssignedOrdersCount($rider_id, $is_admin),
            'number_delivered' => $this->riderModel->getCompletedDeliveriesCount($rider_id, $is_admin),
        ];

        require __DIR__ . '/../views/dashboard.php';
    }
}

?>
