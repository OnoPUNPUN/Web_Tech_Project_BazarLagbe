<?php

class CartModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getUserCart($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $cart[] = $row;
            }
        }
        return $cart;
    }

    public function checkCartItem($user_id, $name) {
        $stmt = $this->db->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
        $stmt->bind_param("si", $name, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addToCart($user_id, $pid, $name, $price, $quantity, $image) {
        $stmt = $this->db->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdis", $user_id, $pid, $name, $price, $quantity, $image);
        return $stmt->execute();
    }

    public function updateCartQuantity($cart_id, $quantity) {
        $stmt = $this->db->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $cart_id);
        return $stmt->execute();
    }

    public function getCartProductStock($cart_id) {
        $stmt = $this->db->prepare("SELECT c.pid, p.stock_quantity FROM `cart` c JOIN `products` p ON c.pid = p.id WHERE c.id = ?");
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function deleteCartItem($cart_id) {
        $stmt = $this->db->prepare("DELETE FROM `cart` WHERE id = ?");
        $stmt->bind_param("i", $cart_id);
        return $stmt->execute();
    }

    public function deleteAllCartItems($user_id) {
        $stmt = $this->db->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    public function countCartItems($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `cart` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getCartItemsWithStock($user_id) {
        $stmt = $this->db->prepare("SELECT c.*, p.stock_quantity FROM `cart` c JOIN `products` p ON c.pid = p.id WHERE c.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $cart[] = $row;
            }
        }
        return $cart;
    }
}

?>
