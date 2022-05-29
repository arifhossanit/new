<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileManager extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}	
	
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
	
	//---photoshop
	public function photo_shop(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);			
			$data['title_info'] = 'Photo Shop'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/file_manager/photo_shop',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//---end ohotoshop 
	
	//---bkash_link_open
	public function bkash_link_open(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);			
			$data['title_info'] = 'bKash Application'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/file_manager/bkash_link_open',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//---end bkash_link_open 
	
	//---mobilerecharge_grmeenphone
	public function mobilerecharge_grmeenphone(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);			
			$data['title_info'] = 'GrmeenPhone Mobile Recharge Application'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/file_manager/mobilerecharge_grmeenphone',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//---end mobilerecharge_grmeenphone v
	
	//---birth_certificate
	public function birth_certificate(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);			
			$data['title_info'] = 'Birth Certificate verification'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/file_manager/birth_certificate',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//---end birth_certificate
	
	//---nid_card
	public function nid_card(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);			
			$data['title_info'] = 'NID Card verification'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/file_manager/nid_card',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//---end nid_card

















































































































































	public function charsochar_error(){
		$data = array();
		$this->load->view('404',$data);
	}	
}

























