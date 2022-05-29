<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontEnd extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}	
	//start terms_condition ------------- 
	public function terms_condition(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				$data = array(
					'content' => $this->input->post('content'),
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('static_content',$data,'1')){
					alert('success','Save Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$condition = array(
				'page_type' => 'Terms & Conditions'
			);
			$data['content'] = $this->Dashboard_model->select('static_content',$condition,'id','desc','row');
			$data['title_info'] = 'Terms & Conditions Management'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/fornt_end/terms_condition',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end terms_condition---
	
	//start trems_and_condition_ipo_referal_approval ------------- 
	public function trems_and_condition_ipo_referal_approval(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				$data = array(
					'content' => $this->input->post('content'),
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('static_content',$data,'2')){
					alert('success','Save Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$condition = array(
				'page_type' => 'Terms & Conditions IPO Referral Approval'
			);
			$data['content'] = $this->Dashboard_model->select('static_content',$condition,'id','desc','row');
			$data['title_info'] = 'Terms & Conditions IPO Referal Approval'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/fornt_end/trems_and_condition_ipo_referal_approval',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end trems_and_condition_ipo_referal_approval---








































































































	public function charsochar_error(){
		$data = array();
		$this->load->view('404',$data);
	}	
}

























