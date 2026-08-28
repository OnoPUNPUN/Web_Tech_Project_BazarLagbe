<?php

class StockManagerModel {
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

    public function getEmployeeIdByUserId($user_id) {
        $stmt = $this->db->prepare("SELECT id FROM `employees` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        if ($res) {
            return $res['id'];
        }
        $today = date('Y-m-d');
        $ins = $this->db->prepare("INSERT INTO `employees`(user_id, employee_type, salary, joining_date, status) VALUES(?, 'stock_manager', 0.00, ?, 'active')");
        $ins->bind_param("is", $user_id, $today);
        $ins->execute();
        return $this->db->insert_id;
    }

    public function getTotalProductsCount() {
        $result = $this->db->query("SELECT COUNT(*) AS total FROM `products` ");
        return $result->fetch_assoc()['total'];
    }

    public function getInStockProductsCount() {
        $result = $this->db->query("SELECT COUNT(*) AS total FROM `products` WHERE stock_quantity > low_stock_threshold");
        return $result->fetch_assoc()['total'];
    }

    public function getLowStockProductsCount() {
        $result = $this->db->query("SELECT COUNT(*) AS total FROM `products` WHERE stock_quantity > 0 AND stock_quantity <= low_stock_threshold");
        return $result->fetch_assoc()['total'];
    }

    public function getOutOfStockProductsCount() {
        $result = $this->db->query("SELECT COUNT(*) AS total FROM `products` WHERE stock_quantity <= 0");
        return $result->fetch_assoc()['total'];
    }

    public function getTotalEmployeesCount() {
        $result = $this->db->query("SELECT COUNT(*) AS total FROM `employees` WHERE status = 'active'");
        return $result ? $result->fetch_assoc()['total'] : 0;
    }

    public function getPendingSalaryCount($month) {
        $sql = "SELECT COUNT(*) AS total FROM `employees` e 
                WHERE e.status = 'active' 
                AND e.id NOT IN (SELECT sp.employee_id FROM `salary_payments` sp WHERE sp.salary_month = ? AND sp.status = 'paid')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $month);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? $res['total'] : 0;
    }

    public function getFilteredProducts($filter = 'all') {
        $query = "SELECT p.*, c.name AS cat_name FROM `products` p LEFT JOIN `categories` c ON p.category_id = c.id";
        if ($filter == 'in_stock') {
            $query .= " WHERE p.stock_quantity > p.low_stock_threshold";
        } elseif ($filter == 'low_stock') {
            $query .= " WHERE p.stock_quantity > 0 AND p.stock_quantity <= p.low_stock_threshold";
        } elseif ($filter == 'out_of_stock') {
            $query .= " WHERE p.stock_quantity <= 0";
        }
        $query .= " ORDER BY p.id DESC";

        $result = $this->db->query($query);
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function adjustStock($pid, $user_id, $type, $quantity, $note, $low_stock_threshold = null) {
        $this->db->begin_transaction();

        try {
            $stmt = $this->db->prepare("SELECT stock_quantity, low_stock_threshold FROM `products` WHERE id = ? FOR UPDATE");
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            $curr = $stmt->get_result()->fetch_assoc();

            if (!$curr) {
                $this->db->rollback();
                return false;
            }

            $current_stock = (int)$curr['stock_quantity'];
            $new_threshold = ($low_stock_threshold !== null) ? (int)$low_stock_threshold : (int)$curr['low_stock_threshold'];

            if ($type === 'stock_in') {
                $new_stock = $current_stock + (int)$quantity;
            } elseif ($type === 'stock_out') {
                $new_stock = max(0, $current_stock - (int)$quantity);
            } elseif ($type === 'adjustment') {
                $new_stock = max(0, (int)$quantity);
            } else {
                $new_stock = max(0, (int)$quantity);
            }

            $up = $this->db->prepare("UPDATE `products` SET stock_quantity = ?, low_stock_threshold = ? WHERE id = ?");
            $up->bind_param("iii", $new_stock, $new_threshold, $pid);
            $up->execute();

            $employee_id = $this->getEmployeeIdByUserId($user_id);

            $ins = $this->db->prepare("INSERT INTO `stock_movements`(product_id, employee_id, type, quantity, note, created_at) VALUES(?, ?, ?, ?, ?, NOW())");
            $ins->bind_param("iisis", $pid, $employee_id, $type, $quantity, $note);
            $ins->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function getRecentStockMovements($limit = 5) {
        $sql = "SELECT sm.*, p.name AS product_name, u.name AS employee_name 
                FROM `stock_movements` sm 
                LEFT JOIN `products` p ON sm.product_id = p.id 
                LEFT JOIN `employees` e ON sm.employee_id = e.id 
                LEFT JOIN `users` u ON e.user_id = u.id 
                ORDER BY sm.id DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $movements = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $movements[] = $row;
            }
        }
        return $movements;
    }
}

?>
