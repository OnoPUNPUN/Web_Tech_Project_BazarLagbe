<?php

class CategoryModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getCategories($limit = null) {
        $sql = "SELECT * FROM `categories` ORDER BY name ASC";
        if ($limit) {
            $sql .= " LIMIT " . intval($limit);
        }
        $result = $this->db->query($sql);
        $categories = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM `categories` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

?>
