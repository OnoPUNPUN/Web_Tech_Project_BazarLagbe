<?php

class AuthModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createUser($name, $email, $hashed_pass, $image) {
        $user_type = 'user';
        $stmt = $this->db->prepare("INSERT INTO `users`(name, email, password, user_type, image) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashed_pass, $user_type, $image);
        return $stmt->execute();
    }
}

?>
