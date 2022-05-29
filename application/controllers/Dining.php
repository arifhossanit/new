<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dining extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}
	//start front_door_lock  ------------- 
	public function front_door_lock($page = '', $page2 = '' ){
		$data = array();
		$branch_id = rahat_decode($page);
		$branch_info = $this->Dashboard_model->mysqlii("select * from branches where branch_id = '".$branch_id."'");
		$get_ip = $this->Dashboard_model->mysqlii("select * from entrance_gate_ip_address where branch_id = '".$branch_id."'");
		
		if(empty($get_ip[0]->ip_address)){
			echo "<script>alert('Door IP Not configure Yet!')</script>";
			exit;
		}
		
		$get_door_info = $this->Dashboard_model->mysqlii("select * from front_door_logs where branch_id = '".$branch_id."' order by id desc limit 01");
		$member_info = $this->Dashboard_model->mysqlii("select * from member_directory where booking_id = '".$get_door_info[0]->booking_id."' order by id desc limit 01");
		
		
		$data['branch_id'] = $branch_info[0]->branch_id;		
		$data['branch_id_encode'] = rahat_encode($branch_info[0]->branch_id);
		$data['branch_name'] = $branch_info[0]->branch_name;
		$data['branch_name_url'] = rahat_url($branch_info[0]->branch_name);		
		$data['ip_address'] = $get_ip[0]->ip_address;
		$data['last_member_img_url'] = base_url($member_info[0]->photo_avater);		
		$data['last_member_name'] = $member_info[0]->full_name;		
		$data['last_member_card'] = $member_info[0]->card_number;		
		
		$data['title_info'] = 'Entrance Door Lock ('.$branch_info[0]->branch_name.')'; 
		$data['logout_timer'] = 'off'; 
		$data['lock_number'] = $page; 
		$data['article'] = $this->load->view('template/dining/front_door_lock',$data,TRUE); 
		$this->load->view('dashboard',$data);

	}
	//---end front_door_lock---
	
	//start dining-table  ------------- 
	public function member_card_check($branch_id = '', $branch_name = ''){
		$data = array();
		$branch = $this->Dashboard_model->select('branches',array('branch_id' => rahat_decode($branch_id)),'id','desc','row');
		
		$data['title_info'] = $branch->branch_name.' - Dining Member Status Checker'; 
		$data['branch_id'] = $branch->branch_id;
		$branch_id = $branch->branch_id;
		$data['logout_timer'] = 'off'; 
		$data['dining_link'] = '1';
		$data['breakfast'] = $this->Dashboard_model->mysqlii("select * from member_meal where dats = '".date('d')."' AND month = '".date('m')."' AND year = '".date('Y')."' AND breakfast = '1' AND branch_id = '".$branch_id."' order by id desc");
		$data['lunch'] = $this->Dashboard_model->mysqlii("select * from member_meal where dats = '".date('d')."' AND month = '".date('m')."' AND year = '".date('Y')."' AND lunch = '1' AND branch_id = '".$branch_id."' order by id desc");
		$data['dinner'] = $this->Dashboard_model->mysqlii("select * from member_meal where dats = '".date('d')."' AND month = '".date('m')."' AND year = '".date('Y')."' AND dinner = '1' AND branch_id = '".$branch_id."' order by id desc");
		$data['article'] = $this->load->view('template/dining/member_card_check',$data,TRUE); 
		$this->load->view('dashboard',$data);

	}
	//--- end booking report---
	
	//start dining-table  ------------- 
	public function old_member_directory(){		
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$data['title_info'] = 'Old Member Directory';
			$data['table'] = $this->Dashboard_model->select('branches','','id','desc','result');
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/dining/old_member_directory',$data,TRUE);
			$data['footer'] = $this->load->view('include/footer','',TRUE);		 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end booking report---
	
	
	//start priority_form  ------------- 
	public function priority_form(){		
		$data = array();
		if(isset($_POST['submit'])){
			$data = array(
				'branch_id' => $this->input->post('branch_is'),
				'generate_id' => date('dmy').rand('11','99'),
				'name' => $this->input->post('applicant_name'),
				'phone' => $this->input->post('phone_number'),
				'email' => '',
				'address' => '',
				'description' => $this->input->post('package_name'),
				'note' => '',
				'date' => date('d/m/Y'),
				'n_date' => $this->input->post('needed_date'),
				'referance_id' => '',
				'h_t_f_u' => '',
				'status' => '1',
				'uploader_info' => 'Self from priority_form',
				'data' => date('d/m/Y')
			);
			if($this->Dashboard_model->insert('booking_enquery',$data)){
				alert('success','Information Sended successfully');
				redirect(current_url());
			}else{
				alert('danger','Something Wrong! Please Try Again');
				redirect(current_url());
			}
		}
		$data['title_info'] = 'Old Member Directory';
		$data['max_date'] = date('Y-m-d', strtotime('+1 year'));
		$data['article'] = $this->load->view('template/dining/priority_form',$data,TRUE);
		$data['footer'] = $this->load->view('include/footer','',TRUE);		 
		$this->load->view('dashboard',$data);
	}

	//--- end priority_form---
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
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

























