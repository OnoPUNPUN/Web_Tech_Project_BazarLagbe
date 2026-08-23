<?php

class ReviewModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getAllReviews() {
        $sql = "SELECT r.*, u.name AS user_name, p.name AS product_name FROM `reviews` r JOIN `users` u ON r.user_id = u.id JOIN `products` p ON r.product_id = p.id ORDER BY r.id DESC";
        $result = $this->db->query($sql);
        $reviews = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }

    public function deleteReview($id) {
        $stmt = $this->db->prepare("DELETE FROM `reviews` WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

?>
