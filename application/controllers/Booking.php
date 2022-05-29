<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Booking extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}
	
	//---------Start Add Booking-------------
	public function booking(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			$condition = array('status' => '1');
			if(isset($_POST['go_to_booking'])){
				
				error_reporting(0);
				$pre_book_id = $this->input->post('hidden_id_pre_book');
				$pre_condition = array('id' => $pre_book_id,'status' => '1');
				$data['bfifpb'] = $this->Dashboard_model->select('pre_booking_directory',$pre_condition,'id','ASC','row');
				$bfifpb = $this->Dashboard_model->select('pre_booking_directory',$pre_condition,'id','ASC','row');
				$pre_condition = array('id' => $bfifpb->selected_pkg,'status' => '1');
				$data['pre_book_selected_pkg'] = $this->Dashboard_model->select('packages',$pre_condition,'id','ASC','row');
				$data['form_opening'] = 'form_opening_true';
			}
			
		
			$data['room_type'] = $this->Dashboard_model->select('room_type',$condition,'id','ASC','result');			
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'Booking related Information Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/booking',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data); 
	
		}
	}
	//---------End Add Booking-------------	
	
	//---------Start booking_target_setup-------------
	public function booking_target_setup(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['set_target'])){
				$unique_id = time() * rand() . '_' . rand() * time();
				$post_date = $this->input->post('target_month');
				$process_month = explode('-',$post_date);
				$month = $process_month[1];
				$year = $process_month[0];
				$target_month = $month.'/'.$year;
				$check_month = $this->Dashboard_model->select('booking_monthly_target',array( 'target_month' => $target_month ),'id','DESC','row');
				if(!empty($check_month->id)){
					alert('warning','Target Month Al-ready Added');
					redirect(current_url());
				}else{
					if(count($this->input->post('branch_id')) > 0 and !empty($this->input->post('branch_id'))){
						foreach($this->input->post('branch_id') as $row => $value){
							$data[] = array(
								'id' 			=> '',
								'unique_id' 	=> $unique_id,
								'branch_id' 	=> $this->input->post('branch_id')[$row],
								'target' 		=> $this->input->post('booking_target')[$row],
								'month' 		=> $month,
								'year' 			=> $year,
								'target_month' 	=> $month.'/'.$year,
								'note' 			=> $this->input->post('note'),
								'status' 		=> 1,
								'uploader_info' => uploader_info(),
								'data' 			=> date('d/m/Y')
							);
						}
					}
					$logs_data = array(
						'id' 			=> '',
						'unique_id' 	=> $unique_id,
						'target_month' 	=> $target_month,
						'status' 		=> 1,
						'uploader_info' => uploader_info(),
						'data' 			=> date('d/m/Y')
					);
					if(
						$this->Dashboard_model->insert_batch('booking_monthly_target',$data) AND
						$this->Dashboard_model->insert('booking_target_adding_logs',$logs_data)
					){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}								
			}
			$data['title_info'] = 'Booking Target Setup Information Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/booking_target_setup',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End booking_target_setup-------------	


	
	//---------Start booking_target_setup-------------
	public function update_booking_target(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(!$this->Dashboard_model->mysqliq("UPDATE booking_monthly_target set target = '" . $_POST['target'] ."' where id = " . $_POST['target_id'])){
				$current = $this->Dashboard_model->mysqlij("SELECT target from booking_monthly_target where id = ". $_POST['target_id']);
				echo json_encode(array('error' => true, 'current' => $current->target));
				return;
			}
			echo json_encode(array('error' => false));
			return;
	
		}
	}
	//---------End booking_target_setup-------------	
	
	
	
	//---------Start Add group_booking-------------
	public function group_booking(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			$condition = array('status' => '1');
			if(isset($_POST['go_to_booking'])){
				$pre_book_id = $this->input->post('hidden_id_pre_book');
				$pre_condition = array('id' => $pre_book_id,'status' => '1');
				$data['bfifpb'] = $this->Dashboard_model->select('pre_booking_directory',$pre_condition,'id','ASC','row');
				$data['form_opening'] = 'form_opening_true';
			}			
			$data['room_type'] = $this->Dashboard_model->select('room_type',$condition,'id','ASC','result');			
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'Group Booking related Information Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/group_booking',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Add group_booking-------------	
	//---------Start Checkout Booking directory-------------
	public function checkout_booking_directory(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			
			
			$condition = array('status' => '1');
			$data['room_type'] = $this->Dashboard_model->select('room_type',$condition,'id','ASC','result');
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'CheckOut Booking Directory';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/checkout_booking_directory',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Checkout Booking directory-------------	
	//---------Start Member Directory-------------
	public function member_directory(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			$condition = array('status' => '1');		
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'Members Directory Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/member_directory',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Member Directory-------------	
	//---------Start Member member_group_directory-------------
	public function member_group_directory(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			$condition = array('status' => '1');		
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'Group Members Directory Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/member_group_directory',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
		}
	}
	//---------End Member member_group_directory-------------	
	//---------Start Edit Delete Member Directory-------------
	public function edit_delete_member(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['update_member'])){
				$where = array('id' => $this->input->post('update_id'));
				$member_info = $this->Dashboard_model->select('member_directory',$where,'id','desc','row');
				$booking_id = $member_info->booking_id;
				$booking_info = $this->Dashboard_model->select('member_directory',array('booking_id' => $booking_id),'id','desc','row');
				$rental_info = $this->Dashboard_model->select('member_directory',array('booking_id' => $booking_id),'id','desc','row');
				$full_name 				= $this->input->post('full_name');
				$email 					= $this->input->post('email');
				$phone_number 			= $this->input->post('phone_number');
				$occupation 			= $this->input->post('occupation');
				$religion 				= $this->input->post('religion');
				$h_t_f_u 				= $this->input->post('h_t_f_u');
				if(!empty($this->input->post('referance_id'))){
					$referance_id 		= $this->input->post('referance_id');
				}else{
					$referance_id 		= '';
				}
				if(!empty($_POST['photo_avater'])){
					$photo_avater 		= $_POST['photo_avater'];
				}else{
					$photo_avater 		= '';
				}
				$father_name 			= $this->input->post('father_name');
				$mother_name 			= $this->input->post('mother_name');
				$emergency_number_1 	= $this->input->post('emergency_number_1');
				if(!empty($_POST['emergency_number_2'])){
					$emergency_number_2 = $this->input->post('emergency_number_2');
				}else{
					$emergency_number_2 = '';
				}
				$address 				= $this->input->post('address');
				if(!empty($_POST['remarks'])){
					$remarks 			= $this->input->post('remarks');
				}else{
					$remarks 			= '';
				}
				
				if(!empty($this->input->post('document_type')[0])){
					$doc_num1 = '';
					$doc_typ1 = '';
					$doc_upl1 = '';
					foreach($this->input->post('document_type') as $row => $value){
						$doc_num1 .= $_POST['document_number'][$row].',';
						$doc_typ1 .= $_POST['document_type'][$row].',';
						$doc_upl1 .= $_POST['document_upload'][$row].',';
					}					
					$doc_num = $this->input->post('document_number_edit') .''. $doc_num1;
					$doc_typ = $this->input->post('document_type_edit').''. $doc_typ1;
					$doc_upl = $this->input->post('document_upload_edit') .''. $doc_upl1;					
				}else{					
					$doc_num = $this->input->post('document_number_edit');
					$doc_typ = $this->input->post('document_type_edit');
					$doc_upl = $this->input->post('document_upload_edit');
					
				}				
				if($this->input->post('parking') == '1'){
					$parking_amount = '500';
				}else{
					$parking_amount = '';
				}				
				$data = array(
					'full_name' => $full_name,
					'email' => $email,
					'phone_number' => $phone_number,
					'occupation' => $occupation,
					'religion' => $religion,
					'h_t_f_u' => $h_t_f_u,
					'referance_id' => $referance_id,
					'photo_avater' => $photo_avater,
					'father_name' => $father_name,
					'mother_name' => $mother_name,
					'emergency_number_1' => $emergency_number_1,
					'emergency_number_2' => $emergency_number_2,
					'remarks' => $remarks,
					'address' => $address,
					'document_type' => $doc_typ,
					'document_number' => $doc_num,
					'document_upload' => $doc_upl,
					'parking' => $this->input->post('parking'),
					'parking_amount' => $parking_amount,
					'member_type' => $this->input->post('member_type')
				);
				$booking_data = array(
					'm_name' => $full_name,
					'parking_amount' => $parking_amount
				);
				$rental_data = array(
					'm_name' => $full_name,
					'parking' => $this->input->post('parking')
				);
				if(
					$this->Dashboard_model->update('member_directory',$data,$this->input->post('update_id')) AND
					$this->Dashboard_model->update('booking_info',$booking_data,$booking_info->id) AND
					$this->Dashboard_model->update('rent_info',$rental_data,$rental_info->id)
				){
					alert('success','Successfully Saved!');
					redirect(base_url('admin/member-directory'));
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(base_url('admin/member-directory'));
				}				
			}else{
				if(isset($_POST['edit'])){
					$where = array('id' => $this->input->post('hidden_id'));
					$data['edit'] = $this->Dashboard_model->select('member_directory',$where,'id','desc','row');
					$packageinfo = $this->Dashboard_model->select('member_directory',$where,'id','desc','row');
					$pc_con = array('id' => $packageinfo->package);
					$data['pa_amount'] = $this->Dashboard_model->select('packages',$pc_con,'id','desc','row');
				}else{
					redirect(base_url('admin/member-directory'));
				}
			}			
			$condition = array('status' => '1');		
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'Members Directory Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/edit_delete_member',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
		}
	}
	//---------End Edit delete Member Directory-------------	
	//---------Start CheckOut Member Directory-------------
	public function checkout_members_directory(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{			
			$condition = array('status' => '1');		
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'CheckOut Members Directory';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/checkout_members_directory',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End CheckOut  Member Directory-------------	
	//---------Start Rental Information-------------
	public function rental_information(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			$condition = array('status' => '1');
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			$data['payment_type'] = $this->Dashboard_model->select('payment_type',$condition,'id','asc','result');
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'Members Rental Information Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/rental_information',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Rental Information-------------	
	//---------Start Building Overview-------------
	public function building_overview(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}	
			
			$data['title_info'] = 'Building Overview';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/building_overview',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Building Overview-------------
	//---------Start pre_book_member_directory-------------
	public function pre_book_member_directory(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{			
			$condition = array('status' => '1');		
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);				
				$branch_per = $this->Dashboard_model->select('branch_permission',$condition_per,'id','desc','row');
				$branchids = explode(",",$branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){
					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}
			
			
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'PreBook Members Directory & Police Verification Form Print';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/pre_book_member_directory',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End pre_book_member_directory-------------	


	public function pre_book_member_image_reupload()
	{
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			return json_encode(array('error' => true));
		}else{	
			if(empty($_FILES['member_image']['name'])){
				return;
			}

			$new_image = $this->Dashboard_model->store('member_image', 'member/member_image');
			$this->Dashboard_model->mysqliq("UPDATE pre_booking_directory set photo_avater = '$new_image' where id = " . $_POST['update_member']);
			echo $new_image;
		}
		
	}

	public function recharge_balance($id)
	{
		$data = $this->Dashboard_model->mysqlij("SELECT * FROM member_directory WHERE id='$id'");
		?>
         <input type="hidden" name="member_get_id" class="member_get_id" value="<?php echo $data->id; ?>">
	     <div class="form-group">
		  <label for="balance_val">Balance</label>
            <input type="number" class="form-control balance_val" name="balance_val" id="balance_val" placeholder="Balance" value="<?php echo $data->balance; ?>">
	     </div>
		<?php
	}

	public function add_balance()
	{
		$balance = $_GET['balance'];
		$id = $_GET['id'];
		$this->Dashboard_model->mysqliq("UPDATE member_directory SET balance='$balance' WHERE id='$id'");
		
	}
	
	public function download_all()
	{
		$date_range = $_GET['date_range'];
		$dates = explode("-", $date_range);
		$date1 = trim($dates[0]);
		$date2 = trim($dates[1]);
		$date1_array = explode("/", $date1);
		$date2_array = explode("/", $date2);
		$formated_date1 = $date1_array[2]."-".$date1_array[1]."-".$date1_array[0];
		$formated_date2 = $date2_array[2]."-".$date2_array[1]."-".$date2_array[0];
		if(strtotime($formated_date1) < strtotime($formated_date2)){
			$later_date = $formated_date2;
			$earlier_date = $formated_date1;
		}else{
			$later_date = $formated_date1;
			$earlier_date = $formated_date2;
		}
		
		$sql = $this->db->query("select packages_category.package_category_name,  member_directory.id, member_directory.branch_name,
		member_directory.card_number, member_directory.full_name, member_directory.phone_number, member_directory.email,
		member_directory.bed_name, member_directory.check_in_date, member_directory.check_out_date, member_directory.package_name,
		member_directory.security_deposit, member_directory.emergency_number_1, member_directory.emergency_number_2
		
		from member_directory 
		left join packages_category on packages_category.id=member_directory.package_category 
		where member_directory.status='3' and  
		date_format(STR_TO_DATE(member_directory.check_out_date, '%d/%m/%Y'), '%Y-%m-%d') BETWEEN 
		'$earlier_date'
		 AND 
		 '$later_date'
		");
		
		
		$results = $sql->result();
		//echo $this->db->last_query(); exit();
		//print_r($result); exit();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'ID');
		$sheet->setCellValue('B1', 'BRANCH');
		$sheet->setCellValue('C1', 'CARD NO');
		$sheet->setCellValue('D1', 'FULL NAME');
		$sheet->setCellValue('E1', 'PHONE NUMBER');
		$sheet->setCellValue('F1', 'EMAIL');
		$sheet->setCellValue('G1', 'BED');
		$sheet->setCellValue('H1', 'CHECK IN DATE');
		$sheet->setCellValue('I1', 'CHECK OUT DATE');
		$sheet->setCellValue('J1', 'PACKAGE CATEGORY');
		$sheet->setCellValue('K1', 'PACKAGE');
		$sheet->setCellValue('L1', 'DEPOSIT');
		$sheet->setCellValue('M1', 'EMERGENCY PERSON');
		$sheet->setCellValue('N1', 'EMERGENCY NUMBER');
		
		$row = 2;
		foreach($results as $result){
			$sheet->setCellValue("A$row", $result->id);
			$sheet->setCellValue("B$row", $result->branch_name);
			$sheet->setCellValue("C$row", $result->card_number);
			$sheet->setCellValue("D$row", $result->full_name);
			$sheet->setCellValue("E$row", $result->phone_number);
			$sheet->setCellValue("F$row", $result->email);
			$sheet->setCellValue("G$row", $result->bed_name);
			$sheet->setCellValue("H$row", $result->check_in_date);
			$sheet->setCellValue("I$row", $result->check_out_date);
			$sheet->setCellValue("J$row", $result->package_category_name);
			$sheet->setCellValue("K$row", $result->package_name);
			$sheet->setCellValue("L$row", $result->security_deposit);
			$sheet->setCellValue("M$row", $result->emergency_number_1);
			$sheet->setCellValue("N$row", $result->emergency_number_2);
			
			$row++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'checkOut-member-directory';
 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		 
		$writer->save('php://output');
		
	}
	
	public function pre_book_member_directory_search(){
		$data['title_info'] = 'Pre Booking Member Search';
		$data['header'] = $this->load->view('include/header','',TRUE); 
		$data['nav'] = $this->load->view('include/nav','',TRUE); 
		$data['article'] = $this->load->view('template/booking/pre_book_member_directory_search',$data,TRUE); 
		$data['footer'] = $this->load->view('include/footer','',TRUE); 
		$this->load->view('dashboard',$data);
	}
	
	public function pre_book_member_directory_search_ajax(){
		if($_POST){
			$input_val = $this->input->post('search');
			$sql = "select pre_booking_directory.id,  pre_booking_directory.phone, pre_booking_directory.nid, 
			pre_booking_directory.email, pre_booking_directory.full_name, pre_booking_directory.occupation, 
			pre_booking_directory.permament_address, pre_booking_directory.data, pre_booking_directory.h_t_f_u,
			pre_booking_directory.branch_id, pre_booking_directory.status, pre_booking_directory.photo_avater
			from pre_booking_directory 
			inner join branches on branches.branch_id = pre_booking_directory.branch_id
			where pre_booking_directory.phone='$input_val' or pre_booking_directory.email='$input_val' or pre_booking_directory.nid='$input_val'";
			$sql2 = "select branches.branch_id, branches.branch_name from branches";
			$query = $this->db->query($sql2);
			$data['branches'] = $query->result();
			$result = $this->db->query($sql);
			$data['result'] = $result->row();
			$html = $this->load->view("template/booking/pre_book_member_directory_search_ajax", $data, true);
			
			if(!empty($data['result'])){
				echo $html;
			}else{
				echo null;
			}
			
		}
	}
	
	public function pre_book_member_directory_change_branch(){
		
		if($_POST){
			$input_val = $this->input->post('branch');
			$update_id = $this->input->post('update_id');
			$data = array(
				'branch_id' => $input_val,
			);
			
			$result = $this->db->where('id', $update_id)->update('pre_booking_directory', $data);
			if($result){
				echo 1; 
			}else{
				echo 0;
			}
		}
	}
	
	// Hellow testing.

	
}