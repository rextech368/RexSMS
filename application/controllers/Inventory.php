<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// *************************************************************************
// *                                                                       *
// * OPTIMUM LINKUP SCHOOL MANAGEMENT SYSTEM                               *
// * Copyright (c) OPTIMUM LINKUP. All Rights Reserved                     *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: optimumproblemsolver@gmail.com                                 *
// * Website: https://optimumlinkup.com.ng								   *
// * 		  https://optimumlinkupsoftware.com							   *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// *                                                                       *
// ************************************************************************* 

//LOCATION : application - controller - Inventory.php


class Inventory extends CI_Controller { 

    function __construct() {
        parent::__construct();
        		$this->load->database();
        		$this->load->library('session');					//Load library for session
				$this->load->model('Barcode_model');				//Load library for model (Crud Models)
				$this->load->library('phpqrcode/qrlib');			//Load library for barcode scanning
				
				/*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    /**default functin, redirects to login page if no admin logged in yet***/
    public function index() {
        	if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        	if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }

    /*Admin dashboard code to redirect to admin page if successfull login** */
    function dashboard() {
        if ($this->session->userdata('admin_login') != 1)
        redirect(base_url(), 'refresh');
       	$page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }
	
	/**************   Manage Supplier  ********************/
	function supplier($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('admin_login') != 1)
        redirect(base_url(), 'refresh');
		
		//$this->load->library('form_validation');
		//$this->form_validation->set_rules('name', 'Name', 'required');
		//if ($this->form_validation->run() == FALSE)
		//{
			//echo validation_errors();
		//}
		//else
		//{
		
    if ($param1 == 'create') {
	
		$data = array(
        'name' 				=> $this->input->post('name'),
		'address' 			=> $this->input->post('address'),
        'city' 				=> $this->input->post('city'),
		'state' 			=> $this->input->post('state'),
        'country' 			=> $this->input->post('country'),
        'phone' 			=> $this->input->post('phone'),
        'company_name' 		=> $this->input->post('company_name')
    	);
		$data['email'] = $this->input->post('email');
		$check_email = $this->db->get_where('supplier', array('email' => $data['email']))->row()->email;
		
		if($check_email != null) 
		{
		$this->session->set_flashdata('error_message', get_phrase('email_already_exist'));
        redirect(base_url() . 'inventory/supplier/', 'refresh');
		}
		else
		{
        $this->db->insert('supplier', $data);
        $supplier_id = $this->db->insert_id();
		
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'inventory/supplier/', 'refresh');
    	}}
		
    if ($param1 == 'do_update') {
	$data = array(
        'name' 			=> $this->input->post('name'),
		'address' 		=> $this->input->post('address'),
        'city' 			=> $this->input->post('city'),
		'state' 		=> $this->input->post('state'),
        'country' 		=> $this->input->post('country'),
		'email' 		=> $this->input->post('email'),
        'phone' 		=> $this->input->post('phone'),
        'company_name' 	=> $this->input->post('company_name')
    	);
		
        $this->db->where('supplier_id', $param2);
        $this->db->update('supplier', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'inventory/supplier/', 'refresh');
		
    	} 
		else if ($param1 == 'personal_profile') {
        $page_data['personal_profile'] = true;
        $page_data['current_supplier_id'] = $param2;
    	} 
		else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('supplier', array('supplier_id' => $param2))->result_array();
    	}
		
    if ($param1 == 'delete') {
        $this->db->where('supplier_id', $param2);
        $this->db->delete('supplier');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'inventory/supplier/', 'refresh');
    	}
		
    	$page_data['suppliers'] = $this->db->get('supplier')->result_array();
    	$page_data['page_name'] = 'supplier';
    	$page_data['page_title'] = get_phrase('manage_supplier');
    	$this->load->view('backend/index', $page_data);
		}
					
					
	/******************  Manage sales ***********************/
	function sales($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('admin_login') != 1)
        redirect(base_url(), 'refresh');
    if ($param1 == 'create') {
	
	$data = array(
    'student_id' 		=> $this->input->post('student_id'),
	'seller' 			=> $this->input->post('seller'),
	'description' 		=> $this->input->post('description'),
	'date' 				=> strtotime($this->input->post('date'))
    	);
		
		$data['quantity'] = $this->input->post('quantity');
		$data['item_id'] = $this->input->post('item_id');
		
		$multiply_quantity = $this->db->get_where('item', array('item_id' => $data['item_id']))->row()->sales_price;
		$data['total_amount'] = $data['quantity'] * $multiply_quantity;
		
		
		$check_quantity = $this->db->get_where('item', array('item_id' => $data['item_id']))->row()->quantity;
		if($check_quantity < 1) 
		{
		$this->session->set_flashdata('error_message', get_phrase('item_not_available_in_stock'));
        redirect(base_url() . 'inventory/sales/', 'refresh');
		}
		
		else 
		{
		$this->db->insert('sales', $data);
        $sales_id = $this->db->insert_id();
		
		$stock_quantity = $this->db->get_where('item', array('item_id' => $data['item_id']))->row()->quantity;
		$data2['quantity'] = $stock_quantity - $data['quantity'];
	
		$this->db->where('item_id', $data['item_id']);
        $this->db->update('item', $data2);
			
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'inventory/sales/', 'refresh');
			}
    		}
			

    if ($param1 == 'do_update') {
	$data = array(
    'student_id' 		=> $this->input->post('student_id'),
	'seller' 			=> $this->input->post('seller'),
	'description' 		=> $this->input->post('description'),
	'date' 				=> strtotime($this->input->post('date'))
    );
		
     $this->db->where('sales_id', $param2);
     $this->db->update('sales', $data);
     $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
     redirect(base_url() . 'inventory/sales/', 'refresh');
	 
    	} 
		
		else if ($param1 == 'personal_profile') {
        $page_data['personal_profile'] = true;
        $page_data['current_sales_id'] = $param2;
    	} 
		
		else if ($param1 == 'edit') {
    	$page_data['edit_data'] = $this->db->get_where('sales', array('sales_id' => $param2))->result_array();
    	}
	
    if ($param1 == 'delete') {
        $this->db->where('sales_id', $param2);
        $this->db->delete('sales');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'inventory/sales/', 'refresh');
    	}
		
    	$page_data['sales'] 		= $this->db->get('sales')->result_array();
    	$page_data['page_name'] 	= 'sales';
    	$page_data['page_title'] 	= get_phrase('manage_sales');
    	$this->load->view('backend/index', $page_data);
		}
						
					
	/**** Manage sales items **** */
	function item($param1 = '', $param2 = '', $param3 = '') {
    if ($this->session->userdata('admin_login') != 1)
        redirect(base_url(), 'refresh');
    if ($param1 == 'create') {
	
		$data = array(
        'supplier_id' 		=> $this->input->post('supplier_id'),
		'name' 				=> $this->input->post('name'),
        'description' 		=> $this->input->post('description'),
		'quantity' 			=> $this->input->post('quantity'),
		'purchase_price' 	=> $this->input->post('purchase_price'),
		'sales_price' 		=> $this->input->post('sales_price'),
		'alert_quantity' 	=> $this->input->post('alert_quantity'),
		'date' 				=> strtotime($this->input->post('date'))
    	);

        $this->db->insert('item', $data);
        $item_id = $this->db->insert_id();
		
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'inventory/item/', 'refresh');
    	}
			
    if ($param1 == 'do_update') {
	$data = array(
        'supplier_id' 		=> $this->input->post('supplier_id'),
		'name' 				=> $this->input->post('name'),
        'description' 		=> $this->input->post('description'),
		'quantity' 			=> $this->input->post('quantity'),
		'purchase_price' 	=> $this->input->post('purchase_price'),
		'sales_price' 		=> $this->input->post('sales_price'),
		'alert_quantity' 	=> $this->input->post('alert_quantity'),
		'date' 				=> strtotime($this->input->post('date'))
    	);
		
        		$this->db->where('item_id', $param2);
        		$this->db->update('item', $data);
        		$this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        		redirect(base_url() . 'inventory/item/', 'refresh');
				
    		} 
			else if ($param1 == 'personal_profile') {
        	$page_data['personal_profile'] = true;
        	$page_data['current_item_id'] = $param2;
    		} 
			else if ($param1 == 'edit') {
        	$page_data['edit_data'] = $this->db->get_where('item', array('item_id' => $param2))->result_array();
    		}
    		
			if ($param1 == 'delete') {
        	$this->db->where('item_id', $param2);
        	$this->db->delete('item');
        	$this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        	redirect(base_url() . 'inventory/item/', 'refresh');
    		}
			
    				$page_data['item'] 			= $this->db->get('item')->result_array();
    				$page_data['page_name'] 	= 'item';
    				$page_data['page_title'] 	= get_phrase('manage_items');
    				$this->load->view('backend/index', $page_data);
					}
	
	
	/*******Lockscreen FUNCTION *******/

	function lockscreen()
	{
		
        $data['page'] = 'lockscreen';
		$this->load->view('backend/lockscreen', $data);
	}

}
