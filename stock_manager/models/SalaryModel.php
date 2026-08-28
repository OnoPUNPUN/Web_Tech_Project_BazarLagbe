<?php

class SalaryModel {
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

    public function getEmployeesSalaryStatusByMonth($month) {
        $sql = "SELECT e.*, u.name, u.email, u.image FROM `employees` e JOIN `users` u ON e.user_id = u.id WHERE e.status = 'active' ORDER BY e.id DESC";
        $result = $this->db->query($sql);
        $employees = [];

        $variants = $this->getMonthVariants($month);
        $in_clause = implode(',', array_fill(0, count($variants), '?'));
        $types = str_repeat('s', count($variants));

        if ($result) {
            while ($emp = $result->fetch_assoc()) {
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
                $employees[] = $emp;
            }
        }
        return $employees;
    }

    public function isSalaryPaid($employee_id, $salary_month) {
        $variants = $this->getMonthVariants($salary_month);
        $in_clause = implode(',', array_fill(0, count($variants), '?'));
        $types = str_repeat('s', count($variants));

        $query = "SELECT id FROM `salary_payments` WHERE employee_id = ? AND salary_month IN ($in_clause) AND status = 'paid'";
        $stmt = $this->db->prepare($query);
        $bind_params = array_merge([$employee_id], $variants);
        $bind_types = 'i' . $types;

        $stmt->bind_param($bind_types, ...$bind_params);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function paySalary($employee_id, $amount, $salary_month, $paid_by, $notes = '') {
        if ($this->isSalaryPaid($employee_id, $salary_month)) {
            return ['success' => false, 'message' => 'Salary for ' . $salary_month . ' has already been paid to this employee!'];
        }

        $chk = $this->db->prepare("SELECT id FROM `employees` WHERE id = ?");
        $chk->bind_param("i", $employee_id);
        $chk->execute();
        if ($chk->get_result()->num_rows === 0) {
            return ['success' => false, 'message' => 'Employee does not exist!'];
        }

        $this->db->begin_transaction();
        try {
            $today = date('Y-m-d');
            $stmt = $this->db->prepare("INSERT INTO `salary_payments`(employee_id, amount, payment_date, salary_month, paid_by, status, notes) VALUES(?, ?, ?, ?, ?, 'paid', ?)");
            $stmt->bind_param("idssis", $employee_id, $amount, $today, $salary_month, $paid_by, $notes);
            $stmt->execute();
            $this->db->commit();
            return ['success' => true, 'message' => 'Salary paid successfully!'];
        } catch (Exception $e) {
            $this->db->rollback();
            return ['success' => false, 'message' => 'Failed to process salary payment!'];
        }
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
}

?>
