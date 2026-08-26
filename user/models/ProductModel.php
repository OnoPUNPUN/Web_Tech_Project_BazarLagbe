<?php

class ProductModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getLatestProducts($limit = 6) {
        $stmt = $this->db->prepare("SELECT * FROM `products` ORDER BY id DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getAllProducts($sort = '') {
        $sql = "SELECT * FROM `products` ";
        if ($sort == 'price_low') {
            $sql .= "ORDER BY price ASC";
        } elseif ($sort == 'price_high') {
            $sql .= "ORDER BY price DESC";
        } elseif ($sort == 'name_asc') {
            $sql .= "ORDER BY name ASC";
        } else {
            $sql .= "ORDER BY id DESC";
        }
        $result = $this->db->query($sql);
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getProductsByCategory($cat_id_or_name, $sort = '') {
        if (is_numeric($cat_id_or_name)) {
            $sql = "SELECT * FROM `products` WHERE category_id = ? ";
            if ($sort == 'price_low') $sql .= "ORDER BY price ASC";
            elseif ($sort == 'price_high') $sql .= "ORDER BY price DESC";
            elseif ($sort == 'name_asc') $sql .= "ORDER BY name ASC";
            else $sql .= "ORDER BY id DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $cat_id_or_name);
        } else {
            $sql = "SELECT * FROM `products` WHERE category = ? ";
            if ($sort == 'price_low') $sql .= "ORDER BY price ASC";
            elseif ($sort == 'price_high') $sql .= "ORDER BY price DESC";
            elseif ($sort == 'name_asc') $sql .= "ORDER BY name ASC";
            else $sql .= "ORDER BY id DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $cat_id_or_name);
        }
        $stmt->execute();
        $result = $stmt->get_result();
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

    public function searchProducts($search_box) {
        $param = "%" . $search_box . "%";
        $stmt = $this->db->prepare("SELECT * FROM `products` WHERE name LIKE ? OR category LIKE ? OR details LIKE ?");
        $stmt->bind_param("sss", $param, $param, $param);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getProductReviewStats($product_id) {
        $stmt = $this->db->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM `reviews` WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return [
            'avg_rating' => $res['avg_rating'] ? round($res['avg_rating'], 1) : 0,
            'total_reviews' => $res['total_reviews'] ? $res['total_reviews'] : 0
        ];
    }
}

?>
