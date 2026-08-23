<?php

class UserModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM `users` ORDER BY id DESC";
        $result = $this->db->query($sql);
        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function updateUserRole($user_id, $role) {
        $stmt = $this->db->prepare("UPDATE `users` SET user_type = ? WHERE id = ?");
        $stmt->bind_param("si", $role, $user_id);
        return $stmt->execute();
    }

    public function deleteUser($user_id) {
        $stmt = $this->db->prepare("DELETE FROM `users` WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}

?>
