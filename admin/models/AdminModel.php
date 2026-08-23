<?php

class AdminModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getPendingSum() {
        $stmt = $this->db->prepare("SELECT SUM(total_price) AS total FROM `orders` WHERE payment_status = 'pending'");
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['total'] ? $res['total'] : 0;
    }

    public function getCompletedSum() {
        $stmt = $this->db->prepare("SELECT SUM(total_price) AS total FROM `orders` WHERE payment_status = 'completed'");
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['total'] ? $res['total'] : 0;
    }

    public function getOrderCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `orders` ");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getProductCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `products` ");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getLowStockCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `products` WHERE stock_quantity <= low_stock_threshold");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getCategoryCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `categories` ");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getUserCountByType($user_type) {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `users` WHERE user_type = ?");
        $stmt->bind_param("s", $user_type);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getMessageCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `message` ");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getReviewCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `reviews` ");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getAdminProfile($admin_id) {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

?>
