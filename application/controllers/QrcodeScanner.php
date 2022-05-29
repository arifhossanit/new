<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QrcodeScanner extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}	
	//start member booking information  ------------- 
	public function member_booking_information($get_number = ''){
		$data = array();
		$data['card_number'] = $get_number;
		$data['title_info'] = 'Member Booking information Check from QR:Code'; 
		$data['article'] = $this->load->view('template/qr_code/member_booking_information',$data,TRUE); 
		$this->load->view('dashboard',$data);

	}
	//--- end  member booking information---
	
	//start member rental information  ------------- 
	public function member_rental_information($get_number = ''){
		$data = array();
		$data['card_number'] = $get_number;
		$data['title_info'] = 'Member Rental information Check from QR:Code'; 
		$data['article'] = $this->load->view('template/qr_code/member_rental_information',$data,TRUE); 
		$this->load->view('dashboard',$data);

	}
	//--- end  member rental information---

	//start member booking information  ------------- 
	public function ipo_information($ipo_id = '', $purcahse_code = ''){
		$data = array();
		$data['ipo_id'] = $ipo_id;
		$data['purcahse_code'] = $purcahse_code;
		$data['title_info'] = 'IPO receipt Check from QR:Code'; 
		$data['article'] = $this->load->view('template/qr_code/member_booking_information',$data,TRUE); 
		$this->load->view('dashboard',$data);

	}
	//--- end  member booking information---
	
	//start Employee Rating  ------------- 
	public function employee_rating($get_number = ''){
		$data = array();
		$data['live_chat'] = 'Turn Off';
		$data['get_id'] = $get_number;
		$data['title_info'] = 'Employee Rating & Feedback Form QR:Code'; 
		$data['article'] = $this->load->view('template/qr_code/employee_rating',$data,TRUE); 
		$this->load->view('dashboard',$data);

	}
	//--- end  Employee Rating---
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function index(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);			
			$data['title_info'] = 'File Manager'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/file_manager/index',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	

















































































































































	public function charsochar_error(){
		$data = array();
		$this->load->view('404',$data);
	}	
}

























