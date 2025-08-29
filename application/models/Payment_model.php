<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {

    // Function to get all paid invoices for the current year
    public function get_paid_invoices($year) {
        // Validate year
        if (!is_numeric($year) || $year < 2000 || $year > date("Y")) {
            return []; // Return an empty array for invalid year
        }

        $this->db->select('i.student_id, i.amount_paid, c.name as class_name');
        $this->db->from('invoice i');
        $this->db->join('class c', 'i.class_id = c.class_id', 'left'); // Join with class table
        $this->db->where('i.year', $year);
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $query->result_array() : []; // Return results or empty array
    }

    // Function to get all unpaid invoices for the current year
    public function get_unpaid_invoices($year) {
        // Validate year
        if (!is_numeric($year) || $year < 2000 || $year > date("Y")) {
            return []; // Return an empty array for invalid year
        }

        $this->db->select('i.student_id, i.due, c.name as class_name');
        $this->db->from('invoice i');
        $this->db->join('class c', 'i.class_id = c.class_id', 'left'); // Join with class table
        $this->db->where('i.year', $year);
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $query->result_array() : []; // Return results or empty array
    }

   // Function to get total amount paid per month
    public function get_amount_paid_per_month($year) {
        // Validate year
        if (!is_numeric($year) || $year < 2000 || $year > date("Y")) {
            return []; // Return an empty array for invalid year
        }

        $this->db->select("MONTH(payment_date) as month, SUM(amount_paid) as total_paid");
        $this->db->from('invoice');
        $this->db->where('YEAR(payment_date)', $year);
        $this->db->group_by("MONTH(payment_date)"); // Group by month
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $query->result_array() : []; // Return results or empty array
    }

    // Function to get total amount paid grouped by class
    public function get_amount_paid_by_class() {
        $this->db->select('c.name as class_name, SUM(i.amount_paid) as total_paid');
        $this->db->from('invoice i');
        $this->db->join('class c', 'i.class_id = c.class_id', 'left'); // Join with class table
        $this->db->group_by('i.class_id'); // Group by class_id
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $query->result_array() : []; // Return results or empty array
    }

    // Function to get frequency of payments over months
    public function get_payment_frequency($year) {
        // Validate year
        if (!is_numeric($year) || $year < 2000 || $year > date("Y")) {
            return []; // Return an empty array for invalid year
        }

        $this->db->select("MONTH(payment_date) as month, COUNT(*) as payment_count");
        $this->db->from('invoice');
        $this->db->where('YEAR(payment_date)', $year);
        $this->db->group_by("MONTH(payment_date)");
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}