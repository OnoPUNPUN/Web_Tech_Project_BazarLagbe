<?php

class ContactModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getAllMessages() {
        $sql = "SELECT * FROM `message` ORDER BY id DESC";
        $result = $this->db->query($sql);
        $messages = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $messages[] = $row;
            }
        }
        return $messages;
    }

    public function deleteMessage($id) {
        $stmt = $this->db->prepare("DELETE FROM `message` WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

?>
