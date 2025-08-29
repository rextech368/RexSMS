<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Payment_model'); // Load Payment_model
    }

    // Function to display student payment report
    public function studentPaymentReport() {
        $running_year = date("Y");

        // Retrieve data using model functions
        $data['paid_invoices'] = $this->Payment_model->get_paid_invoices($running_year);
        
        log_message('debug', 'Paid Invoices Data: ' . print_r($data['paid_invoices'], true));

        $data['unpaid_invoices'] = $this->Payment_model->get_unpaid_invoices($running_year);
        
        log_message('debug', 'Unpaid Invoices Data: ' . print_r($data['unpaid_invoices'], true));

       // Retrieve amount paid by class
       $data['amount_paid_by_class'] = $this->Payment_model->get_amount_paid_by_class();
       
       log_message('debug', 'Amount Paid by Class Data: ' . print_r($data['amount_paid_by_class'], true));

       // Retrieve amount paid per month
       $data['amount_paid_per_month'] = $this->Payment_model->get_amount_paid_per_month($running_year);
       
       log_message('debug', 'Amount Paid Per Month Data: ' . print_r($data['amount_paid_per_month'], true));

       // Retrieve payment frequency over months
       $data['payment_frequency'] = $this->Payment_model->get_payment_frequency($running_year);
       
       log_message('debug', 'Payment Frequency Data: ' . print_r($data['payment_frequency'], true));

       // Prepare data for the view
       $data['running_year'] = $running_year;
       $data['page_name'] = 'studentPaymentReport';
       $data['page_title'] = get_phrase('Payment Report');

       // Load the view with all retrieved data
       $this->load->view('backend/index', $data);
    }

    // Function to display class attendance report (if needed)
    public function classAttendanceReport($class_id = NULL, $section_id = NULL, $month = NULL, $year = NULL) {
        if ($_POST) {
            redirect(base_url() . 'report/classAttendanceReport/' . 
                urlencode($class_id) . '/' . 
                urlencode($section_id) . '/' . 
                urlencode($month) . '/' . 
                urlencode($year), 'refresh');
        }

        // Fetch classes and sections
        $classes = $this->db->get('class')->result_array();
        $sections = $this->db->get('section')->result_array();

        // Initialize class and section names
        $class_name = '';
        foreach ($classes as $class) {
            if ($class_id == $class['class_id']) {
                $class_name = htmlspecialchars($class['name']);
                break;
            }
        }

        $section_name = '';
        foreach ($sections as $section) {
            if ($section_id == $section['section_id']) {
                $section_name = htmlspecialchars($section['name']);
                break;
            }
        }

        // Prepare page data
        $page_data['month']       = htmlspecialchars($month);
        $page_data['year']        = htmlspecialchars($year);
        $page_data['class_id']    = htmlspecialchars($class_id);
        $page_data['section_id']  = htmlspecialchars($section_id);

        // Set page title and load view
        if (!empty($class_name) || !empty($section_name)) {
            // Only set title if class or section names are found
            $page_data['page_title']  = "Attendance Report: " . ($class_name ?: 'N/A') . " : Section " . ($section_name ?: 'N/A');
            return $this->load->view('backend/index', $page_data);
        } else {
            show_404(); // Show 404 if class not found
            return; // Prevent further execution
        }
    }

    // Function to manage school marks report
    public function examMarkReport($exam_id = null, $class_id = null, $student_id = null) {
        
        if ($this->input->post('operation') == 'selection') {
            // Get selected values from POST
            if ($this->input->post('exam_id') > 0 && 
                $this->input->post('class_id') > 0 && 
                $this->input->post('student_id') > 0) {

                redirect(base_url() . 'report/examMarkReport/' . 
                    urlencode($this->input->post('exam_id')) . '/' . 
                    urlencode($this->input->post('class_id')) . '/' . 
                    urlencode($this->input->post('student_id')), 'refresh');
            } else {
                // Set flash message for error
                $this->session->set_flashdata('error_message', get_phrase('Please select something'));
                redirect(base_url() . 'report/examMarkReport', 'refresh');
            }
        }

       // Prepare page data for exam marks
       if ($exam_id !== null && !is_null($class_id) && !is_null($student_id)) {
           // Set page data only if IDs are provided
           $page_data['exam_id']     = htmlspecialchars($exam_id);
           $page_data['class_id']    = htmlspecialchars($class_id);
           $page_data['student_id']  = htmlspecialchars($student_id);

           // Set page title and load view
           $page_data['page_name']   = 'examMarkReport';
           $page_data['page_title']  = get_phrase('Student Marks');

           return $this->load->view('backend/index', $page_data);
       } else {
           show_404(); // Show 404 if parameters are missing
           return; // Prevent further execution
       }
    }
}