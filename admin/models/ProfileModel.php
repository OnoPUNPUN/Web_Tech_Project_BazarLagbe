<?php

class ProfileModel {
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

    public function updateProfileInfo($user_id, $name, $email) {
        $stmt = $this->db->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
        return $stmt->execute();
    }

    public function updateProfileImage($user_id, $image) {
        $stmt = $this->db->prepare("UPDATE `users` SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $image, $user_id);
        return $stmt->execute();
    }

    public function updatePassword($user_id, $hashed_password) {
        $stmt = $this->db->prepare("UPDATE `users` SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        return $stmt->execute();
    }
}

?>
