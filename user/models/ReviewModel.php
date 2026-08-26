<?php

class ReviewModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getProductReviews($product_id) {
        $stmt = $this->db->prepare("SELECT r.*, u.name AS user_name, u.image AS user_image FROM `reviews` r JOIN `users` u ON r.user_id = u.id WHERE r.product_id = ? ORDER BY r.id DESC");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }

    public function getUserDeliveredProductsForReview($user_id) {
        $sql = "SELECT DISTINCT oi.product_id, p.name, oi.order_id FROM `order_items` oi JOIN `orders` o ON oi.order_id = o.id JOIN `products` p ON oi.product_id = p.id WHERE o.user_id = ? AND o.status = 'delivered' ORDER BY o.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function addReview($user_id, $product_id, $order_id, $rating, $review) {
        $stmt = $this->db->prepare("INSERT INTO `reviews`(user_id, product_id, order_id, rating, review) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiis", $user_id, $product_id, $order_id, $rating, $review);
        return $stmt->execute();
    }

    public function getUserReviews($user_id) {
        $sql = "SELECT r.*, p.name AS product_name FROM `reviews` r JOIN `products` p ON r.product_id = p.id WHERE r.user_id = ? ORDER BY r.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }
}

?>
