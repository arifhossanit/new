<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Communicate extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');		
	}
	
	//==========================================EMPLOY SECTION======================================
	//---------Start adding Employ-------------
	public function send_sms(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['send_sms_custom'])){
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$numbers = explode(',',$this->input->post('numbers'));
				$phn_nmbr = '';
				$phn_nmbr_db = '';
				foreach($numbers as $row){
					//$phn_nmbr .= '&number[]=880'.$row;					
					$phn_nmbr .= '88'.$row.',';					
					$phn_nmbr_db .= $row.',';					
				}
				$phn_nmbr = rtrim($phn_nmbr, ",");
				$data = array(
					'id' => '',
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'numbers' => $phn_nmbr_db,
					'message' => $this->input->post('massage_body'),
					'send_time' => date("l, d-m-Y (h:i:sa)"),
					'note' => $this->input->post('note'),
					'status' => '1',
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('Y-m-d h:i:s A')
				);
				if($this->Dashboard_model->insert('customsendsmshistory',$data)){
					if(sendsms_multitle($phn_nmbr,$this->input->post('massage_body'))){
						alert('success','Successfully Send Custom SMS!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong in SMS API SECTION! Please Try Again');
						redirect(current_url());
					}					
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}			
				
			$condition = array('status' => '1');
			$data['role'] = $this->Dashboard_model->select('roles',$condition,'id','ASC','result');
			$data['designation'] = $this->Dashboard_model->select('designation',$condition,'id','ASC','result');
			$data['department'] = $this->Dashboard_model->select('department',$condition,'id','ASC','result');
			$data['banches'] = $this->Dashboard_model->select('branches',$condition,'id','ASC','result');
			$data['table'] = $this->Dashboard_model->select('employee','','id','ASC','result');
	
			$data['title_info'] = 'Send SMS';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/communicate/send_sms',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		
		}
	}
	
	
	
	
	
	
	
}

	
	
	
	




























































	