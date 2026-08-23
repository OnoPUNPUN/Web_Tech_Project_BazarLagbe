<?php

class OrderModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getAllOrders() {
        $sql = "SELECT o.*, u.name AS rider_name FROM `orders` o LEFT JOIN `users` u ON o.rider_id = u.id ORDER BY o.id DESC";
        $result = $this->db->query($sql);
        $orders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
    }

    public function getRiders() {
        $sql = "SELECT id, name FROM `users` WHERE user_type = 'rider'";
        $result = $this->db->query($sql);
        $riders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $riders[] = $row;
            }
        }
        return $riders;
    }

    public function getOrderItems($order_id) {
        $stmt = $this->db->prepare("SELECT oi.*, p.name FROM `order_items` oi JOIN `products` p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items;
    }

    public function updateOrder($order_id, $payment_status, $status, $rider_id = null) {
        if (!empty($rider_id)) {
            $stmt = $this->db->prepare("UPDATE `orders` SET payment_status = ?, status = ?, rider_id = ?, assigned_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->bind_param("ssii", $payment_status, $status, $rider_id, $order_id);
        } else {
            $stmt = $this->db->prepare("UPDATE `orders` SET payment_status = ?, status = ? WHERE id = ?");
            $stmt->bind_param("ssi", $payment_status, $status, $order_id);
        }
        return $stmt->execute();
    }

    public function deleteOrder($order_id) {
        $stmt1 = $this->db->prepare("DELETE FROM `order_items` WHERE order_id = ?");
        $stmt1->bind_param("i", $order_id);
        $stmt1->execute();

        $stmt2 = $this->db->prepare("DELETE FROM `orders` WHERE id = ?");
        $stmt2->bind_param("i", $order_id);
        return $stmt2->execute();
    }
}

?>
