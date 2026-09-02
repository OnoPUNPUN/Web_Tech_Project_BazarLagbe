<?php

class CategoryModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getAllCategories() {
        $sql = "SELECT c.*, COUNT(p.id) AS product_count FROM `categories` c LEFT JOIN `products` p ON c.id = p.category_id GROUP BY c.id ORDER BY c.id DESC";
        $result = $this->db->query($sql);
        $categories = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    public function getCategoryByName($name) {
        $stmt = $this->db->prepare("SELECT * FROM `categories` WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addCategory($name, $description) {
        $stmt = $this->db->prepare("INSERT INTO `categories`(name, description) VALUES(?, ?)");
        $stmt->bind_param("ss", $name, $description);
        return $stmt->execute();
    }

    public function updateCategory($id, $name, $description) {
        $stmt = $this->db->prepare("UPDATE `categories` SET name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $description, $id);
        return $stmt->execute();
    }

    public function deleteCategory($id) {
        $stmt1 = $this->db->prepare("UPDATE `products` SET category_id = NULL WHERE category_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        $stmt2 = $this->db->prepare("DELETE FROM `categories` WHERE id = ?");
        $stmt2->bind_param("i", $id);
        return $stmt2->execute();
    }
}

?>
