<?php

class EmployeeModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    private function getMonthVariants($month) {
        $timestamp = strtotime($month);
        if ($timestamp !== false) {
            $formatted_name = date('F Y', $timestamp);
            $formatted_date = date('Y-m-01', $timestamp);
            $formatted_ym = date('Y-m', $timestamp);
            return array_unique([$month, $formatted_name, $formatted_date, $formatted_ym]);
        }
        return [$month];
    }

    public function getAllEmployees() {
        $sql = "SELECT e.*, u.name, u.email, u.image, u.user_type FROM `employees` e JOIN `users` u ON e.user_id = u.id ORDER BY e.id DESC";
        $result = $this->db->query($sql);
        $employees = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
        }
        return $employees;
    }

    public function updateEmployee($employee_id, $salary, $status) {
        $stmt = $this->db->prepare("UPDATE `employees` SET salary = ?, status = ? WHERE id = ?");
        $stmt->bind_param("dsi", $salary, $status, $employee_id);
        return $stmt->execute();
    }

    public function getAllSalaryPayments() {
        $sql = "SELECT sp.*, u_emp.name AS employee_name, u_payer.name AS payer_name, e.employee_type 
                FROM `salary_payments` sp 
                JOIN `employees` e ON sp.employee_id = e.id 
                JOIN `users` u_emp ON e.user_id = u_emp.id 
                JOIN `users` u_payer ON sp.paid_by = u_payer.id 
                ORDER BY sp.id DESC";
        $result = $this->db->query($sql);
        $payments = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $payments[] = $row;
            }
        }
        return $payments;
    }

    public function getEmployeesPaymentStatusByMonth($month) {
        $employees = $this->getAllEmployees();
        $variants = $this->getMonthVariants($month);
        $in_clause = implode(',', array_fill(0, count($variants), '?'));
        $types = str_repeat('s', count($variants));

        foreach ($employees as &$emp) {
            $query = "SELECT sp.*, u.name AS payer_name FROM `salary_payments` sp JOIN `users` u ON sp.paid_by = u.id WHERE sp.employee_id = ? AND sp.salary_month IN ($in_clause) AND sp.status = 'paid' LIMIT 1";
            $stmt = $this->db->prepare($query);
            $bind_params = array_merge([$emp['id']], $variants);
            $bind_types = 'i' . $types;

            $stmt->bind_param($bind_types, ...$bind_params);
            $stmt->execute();
            $payment = $stmt->get_result()->fetch_assoc();
            if ($payment) {
                $emp['payment_status'] = 'PAID';
                $emp['payment_details'] = $payment;
            } else {
                $emp['payment_status'] = 'UNPAID';
                $emp['payment_details'] = null;
            }
        }
        return $employees;
    }
}

?>
