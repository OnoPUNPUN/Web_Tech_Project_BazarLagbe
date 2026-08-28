<?php

class RiderModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getProfile($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getActiveAssignedOrdersCount($rider_id, $is_admin = false) {
        if ($is_admin) {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `orders` WHERE status NOT IN ('delivered', 'cancelled')");
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `orders` WHERE rider_id = ? AND status NOT IN ('delivered', 'cancelled')");
            $stmt->bind_param("i", $rider_id);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getCompletedDeliveriesCount($rider_id, $is_admin = false) {
        if ($is_admin) {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `orders` WHERE status = 'delivered'");
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `orders` WHERE rider_id = ? AND status = 'delivered'");
            $stmt->bind_param("i", $rider_id);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getAssignedOrders($rider_id, $is_admin = false) {
        if ($is_admin) {
            $sql = "SELECT * FROM `orders` WHERE status NOT IN ('delivered', 'cancelled') ORDER BY id DESC";
            $result = $this->db->query($sql);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM `orders` WHERE rider_id = ? AND status NOT IN ('delivered', 'cancelled') ORDER BY id DESC");
            $stmt->bind_param("i", $rider_id);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        $orders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
    }

    public function getDeliveryHistory($rider_id, $is_admin = false) {
        if ($is_admin) {
            $sql = "SELECT * FROM `orders` WHERE status = 'delivered' ORDER BY id DESC";
            $result = $this->db->query($sql);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM `orders` WHERE rider_id = ? AND status = 'delivered' ORDER BY id DESC");
            $stmt->bind_param("i", $rider_id);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        $orders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
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

    public function updateOrderStatus($order_id, $status, $rider_id, $is_admin = false) {
        if ($is_admin) {
            $stmt = $this->db->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $order_id);
        } else {
            $stmt = $this->db->prepare("UPDATE `orders` SET status = ? WHERE id = ? AND rider_id = ?");
            $stmt->bind_param("sii", $status, $order_id, $rider_id);
        }
        $res = $stmt->execute();

        if ($status === 'delivered') {
            $stmt_pay = $this->db->prepare("UPDATE `orders` SET payment_status = 'completed' WHERE id = ?");
            $stmt_pay->bind_param("i", $order_id);
            $stmt_pay->execute();
        }

        return $res;
    }
}

?>
