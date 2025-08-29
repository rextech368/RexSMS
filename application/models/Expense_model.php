<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Expense_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }


    function insertExpenseCategory(){

        $page_data = array(
            'name' => $this->input->post('name'),
			);

        $this->db->insert('expense_category', $page_data);
    }

// The function below upate expense category //
    function updateExpenseCategory($param2){
        $page_data = array(
            'name' => $this->input->post('name'),
			);

        $this->db->where('expense_category_id', $param2);
        $this->db->update('expense_category', $page_data);
    }

    function deleteExpenseCategory($param2){
        $this->db->where('expense_category_id', $param2);
        $this->db->delete('expense_category');
    }


    function insertExpense(){

        $page_data['title']                         =   $this->input->post('title');
        $page_data['expense_category_id']           =   $this->input->post('expense_category_id');
        $page_data['description']                   =   $this->input->post('description');
        $page_data['payment_type']                  =  'expense';
        $page_data['method']                        =   $this->input->post('method');
        $page_data['amount']                        =   $this->input->post('amount');
		$page_data['month'] 						= 	date('M');
        $page_data['timestamp']                     =  	strtotime($this->input->post('timestamp'));
        $page_data['year']                          =   $this->db->get_where('settings', array('type' => 'session'))->row()->description;
        $this->db->insert('payment', $page_data);
    }

    function updateExpense($param2){

        $page_data['title']                         =   $this->input->post('title');
        $page_data['expense_category_id']           =   $this->input->post('expense_category_id');
        $page_data['description']                   =   $this->input->post('description');
        $page_data['payment_type']                  =  'expense';
        $page_data['method']                        =   $this->input->post('method');
        $page_data['amount']                        =   $this->input->post('amount');
        $page_data['timestamp']                     =   strtotime($this->input->post('timestamp'));

        $this->db->where('payment_id', $param2);
        $this->db->update('payment', $page_data);
    }

    function deleteExpense($param2){
        $this->db->where('payment_id', $param2);
        $this->db->delete('payment');
    }
	

    public function getExpensesWithSalaries() {
        // Get all teachers, accountants, and librarians with their salaries
        $this->db->select('t.name AS teacher_name, a.name AS accountant_name, l.name AS librarian_name, 
                            t.joining_salary AS teacher_salary, 
                            a.joining_salary AS accountant_salary, 
                            l.joining_salary AS librarian_salary');
        
        $this->db->from('teacher t');
        $this->db->join('accountant a', 'a.accountant_id = t.department_id', 'left'); // Assuming department_id links to accountants
        $this->db->join('librarian l', 'l.librarian_id = t.department_id', 'left'); // Assuming department_id links to librarians
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function calculateTotals($expenses) {
        $totals = [
            'total_salary' => 0,
            'total_pf' => 0,
            'total_at' => 0,
            'total_pvid' => 0,
            'total_deduction' => 0,
        ];

        foreach ($expenses as $expense) {
            // Calculate deductions based on salary
            $salary = floatval($expense['teacher_salary'] ?? 0) + floatval($expense['accountant_salary'] ?? 0) + floatval($expense['librarian_salary'] ?? 0);
            $pf = $salary * 0.037;
            $at = $salary * 0.0175;
            $pvid = $salary * 0.084;
            $total_deduction = $pf + $at + $pvid;

            // Accumulate totals
            $totals['total_salary'] += $salary;
            $totals['total_pf'] += $pf;
            $totals['total_at'] += $at;
            $totals['total_pvid'] += $pvid;
            $totals['total_deduction'] += $total_deduction;
        }

        return array_merge($totals, ['expenses' => $expenses]);
    }
}
