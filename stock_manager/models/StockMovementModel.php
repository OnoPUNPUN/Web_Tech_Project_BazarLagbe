<?php

class StockMovementModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getAllStockMovements() {
        $sql = "SELECT sm.*, p.name AS product_name, p.image AS product_image, u.name AS employee_name, e.employee_type 
                FROM `stock_movements` sm 
                LEFT JOIN `products` p ON sm.product_id = p.id 
                LEFT JOIN `employees` e ON sm.employee_id = e.id 
                LEFT JOIN `users` u ON e.user_id = u.id 
                ORDER BY sm.id DESC";
        $result = $this->db->query($sql);
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
