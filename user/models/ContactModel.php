<?php

class ContactModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function checkMessageExists($user_id, $name, $email, $number, $msg) {
        $stmt = $this->db->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ? AND user_id = ?");
        $stmt->bind_param("ssssi", $name, $email, $number, $msg, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addMessage($user_id, $name, $email, $number, $msg) {
        $stmt = $this->db->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $name, $email, $number, $msg);
        return $stmt->execute();
    }
}

?>
