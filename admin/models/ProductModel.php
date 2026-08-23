<?php

class ProductModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getAllProducts() {
        $sql = "SELECT p.*, c.name AS cat_name FROM `products` p LEFT JOIN `categories` c ON p.category_id = c.id ORDER BY p.id DESC";
        $result = $this->db->query($sql);
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM `products` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getProductByName($name) {
        $stmt = $this->db->prepare("SELECT * FROM `products` WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getCategoriesList() {
        $sql = "SELECT * FROM `categories` ORDER BY name ASC";
        $result = $this->db->query($sql);
        $categories = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    public function addProduct($name, $cat_name, $category_id, $details, $price, $stock_quantity, $low_stock_threshold, $image) {
        $stmt = $this->db->prepare("INSERT INTO `products`(name, category, category_id, details, price, stock_quantity, low_stock_threshold, image) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisdiis", $name, $cat_name, $category_id, $details, $price, $stock_quantity, $low_stock_threshold, $image);
        return $stmt->execute();
    }

    public function updateProduct($id, $name, $cat_name, $category_id, $details, $price, $stock_quantity, $low_stock_threshold) {
        $stmt = $this->db->prepare("UPDATE `products` SET name = ?, category = ?, category_id = ?, details = ?, price = ?, stock_quantity = ?, low_stock_threshold = ? WHERE id = ?");
        $stmt->bind_param("ssisdiii", $name, $cat_name, $category_id, $details, $price, $stock_quantity, $low_stock_threshold, $id);
        return $stmt->execute();
    }

    public function updateProductImage($id, $image) {
        $stmt = $this->db->prepare("UPDATE `products` SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $image, $id);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM `products` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $res = $stmt->execute();

        $stmt2 = $this->db->prepare("DELETE FROM `wishlist` WHERE pid = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        $stmt3 = $this->db->prepare("DELETE FROM `cart` WHERE pid = ?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();

        return $res;
    }
}

?>
