<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}	
	//start configure_sms  ------------- 
	public function configure_sms(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}				
				$data = array(
					'id' => '',
					'configuration_name' => $this->input->post('configuration_name'),
					'api_code' => $this->input->post('api_code'),
					'device_code' => $this->input->post('device_code'),
					'gate_way_url' => $this->input->post('gate_way_url'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				
				if($this->Dashboard_model->insert('sms_configuration',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['update'])){
				if(isset($_POST['branch_satatus'])){
					$status = 1;
				}else{
					$status = 0;
				}				
				$data = array(
					'configuration_name' => $this->input->post('configuration_name'),
					'api_code' => $this->input->post('api_code'),
					'device_code' => $this->input->post('device_code'),
					'gate_way_url' => $this->input->post('gate_way_url'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('sms_configuration',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('sms_configuration',$where,'id','desc','row');
			}			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('sms_configuration',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('sms_configuration',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$data['table'] = $this->Dashboard_model->mysqlii('SELECT * FROM sms_configuration');
			$data['title_info'] = 'SMS Configuration'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/settings/sms/configure_sms',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end configure_sms---
	
	//start sms_purpase  ------------- 
	public function sms_purpase(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}				
				$data = array(
					'id' => '',
					'purpuse_name' => $this->input->post('purpuse_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);				
				if($this->Dashboard_model->insert('sms_purpuse',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['update'])){
				if(isset($_POST['branch_satatus'])){
					$status = 1;
				}else{
					$status = 0;
				}				
				$data = array(
					'purpuse_name' => $this->input->post('purpuse_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('sms_purpuse',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('sms_purpuse',$where,'id','desc','row');
			}			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('sms_purpuse',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('sms_purpuse',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$data['table'] = $this->Dashboard_model->mysqlii('SELECT * FROM sms_purpuse');
			$data['title_info'] = 'SMS Purpases'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/settings/sms/sms_purpase',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end sms_purpase---
	
	//start sms_template  ------------- 
	public function sms_template(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}				
				$data = array(
					'id' => '',
					'configuration' => $this->input->post('configuration'),
					'purpase' => $this->input->post('purpase'),
					'message' => $this->input->post('message'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);				
				if($this->Dashboard_model->insert('sms_templates',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['update'])){
				if(isset($_POST['branch_satatus'])){
					$status = 1;
				}else{
					$status = 0;
				}				
				$data = array(
					'configuration' => $this->input->post('configuration'),
					'purpase' => $this->input->post('purpase'),
					'message' => $this->input->post('message'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('sms_templates',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('sms_templates',$where,'id','desc','row');
			}			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('sms_templates',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('sms_templates',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$data['configuration'] = $this->Dashboard_model->mysqlii('SELECT * FROM sms_configuration');
			$data['purpase'] = $this->Dashboard_model->mysqlii('SELECT * FROM sms_purpuse');
			$data['table'] = $this->Dashboard_model->mysqlii('SELECT * FROM sms_templates');
			$data['title_info'] = 'SMS Templates'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/settings/sms/sms_template',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end sms_template---
	
	
	

















































































































































	public function charsochar_error(){
		$data = array();
		$this->load->view('404',$data);
	}	
}

























