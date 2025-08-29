
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Expense extends CI_Controller { 

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Expense_model'); // Load your expense model
    }


    function expense_category($param1 = '', $param2 = '', $param3 = ''){


    if ($param1 == 'insert'){

    $this->expense_model->insertExpenseCategory();
    $this->session->set_flashdata('flash_message', get_phrase('Data successfully saved'));
    redirect(base_url(). 'expense/expense_category', 'refresh');
    }


    if($param1 == 'update'){

        $this->expense_model->updateExpenseCategory($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data successfully updated'));
        redirect(base_url(). 'expense/expense_category', 'refresh');

    }

    if($param1 == 'delete'){
        $this->expense_model->deleteExpenseCategory($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data successfully deleted'));
        redirect(base_url(). 'expense/expense_category', 'refresh');

    }

    $page_data['page_name']         = 'expense_category';
    $page_data['page_title']        = get_phrase('Expense Category');
    $page_data['select_expense_category']        = $this->db->get('expense_category')->result_array();
    $this->load->view('backend/index', $page_data);

    }













    function index() {
        // Fetch expenses along with salaries
        $expenses = $this->Expense_model->getExpensesWithSalaries();
        
        // Calculate totals
        $data = $this->Expense_model->calculateTotals($expenses);

        // Prepare page data
        $page_data['expenses'] = $data['expenses'];
        $page_data['totals'] = [
            'total_salary' => number_format($data['total_salary'], 2),
            'total_pf' => number_format($data['total_pf'], 2),
            'total_at' => number_format($data['total_at'], 2),
            'total_pvid' => number_format($data['total_pvid'], 2),
            'total_deduction' => number_format($data['total_deduction'], 2),
        ];

        // Load view with data
        $page_data['page_name'] = 'expense';
        $page_data['page_title'] = get_phrase('Manage Expense');
        $this->load->view('backend/index', $page_data);
    }

    // The function below manage expense //
    function expense($param1 = '', $param2 = '', $param3 = ''){

        if ($param1 == 'insert'){
        
        $this->expense_model->insertExpense();
        $this->session->set_flashdata('flash_message', get_phrase('Data successfully saved'));
        redirect(base_url(). 'expense/expense', 'refresh');
        }
        
        if($param1 == 'update'){

            $this->expense_model->updateExpense($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully updated'));
            redirect(base_url(). 'expense/expense', 'refresh');
        }

        if($param1 == 'delete'){
            $this->expense_model->deleteExpense($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully deleted'));
            redirect(base_url(). 'expense/expense', 'refresh');
        }

        $page_data['page_name']         	= 'expense';
        $page_data['page_title']        	= get_phrase('Manage Expense');
        $page_data['select_expense']        = $this->db->get_where('payment', array('payment_type' => 'expense'))->result_array();
        $this->load->view('backend/index', $page_data);


    }

}