<?php

class UserModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM `users` ORDER BY id DESC";
        $result = $this->db->query($sql);
        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function updateUserRole($user_id, $role) {
        $stmt = $this->db->prepare("UPDATE `users` SET user_type = ? WHERE id = ?");
        $stmt->bind_param("si", $role, $user_id);
        $res = $stmt->execute();

        $employee_roles = ['stock_manager', 'rider', 'warehouse_staff'];
        if (in_array($role, $employee_roles)) {
            $check = $this->db->prepare("SELECT id FROM `employees` WHERE user_id = ?");
            $check->bind_param("i", $user_id);
            $check->execute();
            $emp = $check->get_result()->fetch_assoc();

            if ($emp) {
                $up = $this->db->prepare("UPDATE `employees` SET employee_type = ?, status = 'active' WHERE user_id = ?");
                $up->bind_param("si", $role, $user_id);
                $up->execute();
            } else {
                $today = date('Y-m-d');
                $ins = $this->db->prepare("INSERT INTO `employees`(user_id, employee_type, salary, joining_date, status) VALUES(?, ?, 0.00, ?, 'active')");
                $ins->bind_param("iss", $user_id, $role, $today);
                $ins->execute();
            }
        } else {
            $up = $this->db->prepare("UPDATE `employees` SET status = 'inactive' WHERE user_id = ?");
            $up->bind_param("i", $user_id);
            $up->execute();
        }

        return $res;
    }

    public function deleteUser($user_id) {
        $stmt = $this->db->prepare("DELETE FROM `users` WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}

?>
