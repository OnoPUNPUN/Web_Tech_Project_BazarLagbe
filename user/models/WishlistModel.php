<?php

class WishlistModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getUserWishlist($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $wishlist = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $wishlist[] = $row;
            }
        }
        return $wishlist;
    }

    public function checkWishlistItem($user_id, $name) {
        $stmt = $this->db->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
        $stmt->bind_param("si", $name, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addToWishlist($user_id, $pid, $name, $price, $image) {
        $stmt = $this->db->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("iisds", $user_id, $pid, $name, $price, $image);
        return $stmt->execute();
    }

    public function deleteWishlistItem($id) {
        $stmt = $this->db->prepare("DELETE FROM `wishlist` WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function deleteWishlistItemByName($user_id, $name) {
        $stmt = $this->db->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
        $stmt->bind_param("si", $name, $user_id);
        return $stmt->execute();
    }

    public function deleteAllWishlistItems($user_id) {
        $stmt = $this->db->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    public function countWishlistItems($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM `wishlist` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }
}

?>
