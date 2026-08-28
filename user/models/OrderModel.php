<?php

class OrderModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getUserOrders($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY id DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
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

    public function createOrder($user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $placed_on) {
        $stmt = $this->db->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, status, payment_status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', 'pending')");
        $stmt->bind_param("issssssds", $user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $placed_on);
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        $stmt = $this->db->prepare("INSERT INTO `order_items`(order_id, product_id, quantity, price) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $res = $stmt->execute();

        $stmt_stock = $this->db->prepare("UPDATE `products` SET stock_quantity = stock_quantity - ? WHERE id = ?");
        $stmt_stock->bind_param("ii", $quantity, $product_id);
        $stmt_stock->execute();

        $note = "Order #" . $order_id . " placed";
        $stmt_mv = $this->db->prepare("INSERT INTO `stock_movements`(product_id, employee_id, type, quantity, note) VALUES(?, NULL, 'stock_out', ?, ?)");
        $stmt_mv->bind_param("iis", $product_id, $quantity, $note);
        $stmt_mv->execute();

        return $res;
    }

    public function cancelOrder($order_id, $user_id) {
        $stmt = $this->db->prepare("SELECT * FROM `orders` WHERE id = ? AND user_id = ? AND status = 'pending'");
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();

        if ($order) {
            $stmt_items = $this->db->prepare("SELECT * FROM `order_items` WHERE order_id = ?");
            $stmt_items->bind_param("i", $order_id);
            $stmt_items->execute();
            $items_res = $stmt_items->get_result();

            if ($items_res) {
                while ($item = $items_res->fetch_assoc()) {
                    $stmt_restock = $this->db->prepare("UPDATE `products` SET stock_quantity = stock_quantity + ? WHERE id = ?");
                    $stmt_restock->bind_param("ii", $item['quantity'], $item['product_id']);
                    $stmt_restock->execute();

                    $note = "Order #" . $order_id . " cancelled";
                    $stmt_mv = $this->db->prepare("INSERT INTO `stock_movements`(product_id, employee_id, type, quantity, note) VALUES(?, NULL, 'stock_in', ?, ?)");
                    $stmt_mv->bind_param("iis", $item['product_id'], $item['quantity'], $note);
                    $stmt_mv->execute();
                }
            }

            $stmt_cancel = $this->db->prepare("UPDATE `orders` SET status = 'cancelled' WHERE id = ?");
            $stmt_cancel->bind_param("i", $order_id);
            return $stmt_cancel->execute();
        }
        return false;
    }
}

?>
