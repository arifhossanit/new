<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipo extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->library('form_validation');
		$this->load->library('session');
	}
	
	//---------Start Add ipo-------------
	public function ipo(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			
			$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches");
			$data['title_info'] = 'Initial public offering';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/ipo/ipo',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Add ipo-------------	
	
	//---------Start ipo Member Directory-------------
	public function ipo_member_directory(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			$condition = array('status' => '1');		
			
			
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'IPO Members Directory Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/ipo/ipo_member_directory',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End ipo Member Directory-------------	
	
	
	//---------Start Demo ipo Member Directory-------------
	public function demo_ipo_member_directory(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			$condition = array('status' => '1');		
			
			
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'Demo IPO Members Directory';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/ipo/demo_ipo_member_directory',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End ipo Demo Member Directory-------------	
	
	//---------Start investment_inquery-------------
	public function investment_inquery(){
		
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			$sql = $this->db->query("select * from investment_query order by id ASC");
			$data["inqueries"] = $sql->result();
			$data['title_info'] = 'Investment Inquery';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/ipo/investment_inquery',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End investment_inquery-------------	
	
	
	//---------Start investment_inquery_note-------------
	public function investment_inquery_note(){
		
		
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			$this->form_validation->set_rules('note','note','required');
			if($this->form_validation->run() == FALSE){
				redirect(current_url());
			}else{
				$update_id = $this->input->post("inquery_id");
				$data = array(
					"note" => $this->input->post("note")
				);
				
				$update = $this->db->where('id', $update_id)->update('investment_query', $data);
				if($update){
					//alert('success','Update Successfully!');
			 		redirect(base_url('admin/ipo/investment_inquery'));
			 	}else{
			 		//alert('danger','Something Wrong! Please try Again');
			 		redirect(base_url('admin/ipo/investment_inquery'));
			 	}
			}
			
	
		}
	}
	//---------End investment_inquery_note-------------	
	
	
	
	
	
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
	
	// IPO certificate
	public function ipo_member_certificate($member_id = '')
	{
		$data = array(
			'ipo_id' => $member_id,
		);
		$data['member_information'] = $this->Dashboard_model->select('ipo_member_directory', $data, 'id', 'desc', 'row');
		$data['start_and_end_date'] = $this->Dashboard_model->mysqlij("select * from ipo_agreement_information where ipo_id = '".$data['member_information']->ipo_id."'");
		$data['total_purchase'] = $this->Dashboard_model->mysqlij("SELECT sum(payed_amount) as total_sum from ipo_purses_information where ipo_id = '$member_id'");
		$data['title_info'] = 'IPO Certificate';
		$this->load->view('certificate',$data);
	}
	// end ipo certificate
	
	


	// ----------- IPO member panel section ------------
	
	
	
	
	public function authorize_pre_ipo_member()
	{
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$authorize_id = $_POST['authorize_id'];
			$data = array(
				'card_number' => $_POST['card_number'],
			);
			// $validate_card = $this->Dashboard_model->select('ipo_member_directory_pre', $data, 'id', 'desc', 'row');
			// if($validate_card->id != ''){
			// 	alert('warning','Card already assigned! Please try again.');
			// 	redirect('admin/ipo/ipo-member-directory-pre');
			// }
			$validate_card = $this->Dashboard_model->select('ipo_member_directory', $data, 'id', 'desc', 'row');
			if($validate_card){
				alert('warning','Card already assigned! Please try again.');
				redirect('admin/ipo/ipo-member-directory-pre');
			}
			$challange = array(
				'id' => $authorize_id
			);
			$validate = $this->Dashboard_model->select('ipo_member_directory_pre', $challange, 'id', 'desc', 'row');
			if($validate->id != ''){
				$data = array(
					'card_number' => $_POST['card_number'],
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']
				);				
				if($this->Dashboard_model->update('ipo_member_directory_pre',$data,$validate->id)){
					$result = $this->Dashboard_model->mysqliq('INSERT INTO ipo_member_directory (`ipo_id`, `personal_full_name`, `personal_phone_number`, `personal_date_of_birth`, `personal_email`, `password`, `personal_nid_card`, `personal_nid_attachment`, `personal_images`, `personal_address`, `bank_name`, `account_holder_name`, `account_number`, `routing_number`, `bank_branch_name`, `bank_attachment`, `bank_address`, `nominee_name`, `nominee_phone_number`, `nominee_date_of_birth`, `nominee_email`, `nominee_nid_card`, `nominee_nid_attachment`, `nominee_relation`, `nominee_images`, `nominee_address`, `card_number`, `note`, `status`, `uploader_info`, `data`) SELECT `ipo_id`, `personal_full_name`, `personal_phone_number`, `personal_date_of_birth`, `personal_email`, `password`, `personal_nid_card`, `personal_nid_attachment`, `personal_images`, `personal_address`, `bank_name`, `account_holder_name`, `account_number`, `routing_number`, `bank_branch_name`, `bank_attachment`, `bank_address`, `nominee_name`, `nominee_phone_number`, `nominee_date_of_birth`, `nominee_email`, `nominee_nid_card`, `nominee_nid_attachment`, `nominee_relation`, `nominee_images`, `nominee_address`, `card_number`, `note`, `status`, `uploader_info`, `data` FROM ipo_member_directory_pre WHERE id = '.$validate->id);
					alert('success','Authorization Successful!!');
					redirect('admin/ipo/ipo-member-directory-pre');
				}
			}
		}
		alert('warning','Something went wrong! Please try again.');
		redirect('admin/ipo/ipo-member-directory-pre');
	}
	
	public function ipo_member_directory_pre(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			$condition = array('status' => '1');			
			$data['doc_type'] = $this->Dashboard_model->select('document_type',$condition,'id','asc','result');
			$data['title_info'] = 'IPO Members Directory Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/ipo/ipo_member_directory_pre',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	
	
	//-------start ipo_referal_aproval ---------
	public function ipo_referal_aproval(){
		$data = array();
		if(!isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member/login'));
		}else{		
			$condition = array(
				'page_type' => 'Terms & Conditions IPO Referral Approval'
			);
			$chellenge = array(
				'card_number' => $_SESSION['ipo_member_panel']['card_number'],
				'status' => 1,
			);
			$data['ipo_member_information'] = $this->Dashboard_model->select('ipo_member_directory',$chellenge,'id','desc','row');
			
			$data['agreements'] = $this->Dashboard_model->select('ipo_agreement_information',array('ipo_id' => $_SESSION['ipo_member_panel']['ipo_id']),'id','desc','result');
			$data['trems_content'] = $this->Dashboard_model->select('static_content',$condition,'id','desc','row');
			$data['ipo_member_balance'] = $this->Dashboard_model->select('ipo_member_balance',array( 'ipo_id' => $_SESSION['ipo_member_panel']['ipo_id'] ),'id','desc','row');
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'IPO Referal Approval'; 			
			$data['header'] = $this->load->view('ipo/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('ipo/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('ipo/template/ipo_referal_aproval','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--------end ipo_referal_aproval
	
	//-------start ipo_referal_member ---------
	public function ipo_referal_member(){
		$data = array();
		if(!isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member/login'));
		}else{		
			$condition = array(
				'page_type' => 'Terms & Conditions IPO Referral Approval'
			);
			$chellenge = array(
				'card_number' => $_SESSION['ipo_member_panel']['card_number'],
				'status' => 1,
			);
			$data['ipo_member_information'] = $this->Dashboard_model->select('ipo_member_directory',$chellenge,'id','desc','row');
			$data['trems_content'] = $this->Dashboard_model->select('static_content',$condition,'id','desc','row');
			$data['ipo_member_balance'] = $this->Dashboard_model->select('ipo_member_balance',array( 'ipo_id' => $_SESSION['ipo_member_panel']['ipo_id'] ),'id','desc','row');
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'IPO Referal Member'; 			
			$data['header'] = $this->load->view('ipo/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('ipo/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('ipo/template/ipo_referal_member','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--------end ipo_referal_member
	
	//-------start ipo_member_balance_widthdraw ---------
	public function ipo_member_balance_widthdraw(){
		$data = array();
		if(!isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member/login'));
		}else{		
			$condition = array(
				'page_type' => 'Terms & Conditions IPO Referral Approval'
			);			
			
			$data['trems_content'] = $this->Dashboard_model->select('static_content',$condition,'id','desc','row');
			$data['ipo_member_balance'] = $this->Dashboard_model->select('ipo_member_balance',array( 'ipo_id' => $_SESSION['ipo_member_panel']['ipo_id'] ),'id','desc','row');
			$chellenge = array(
				'card_number' => $_SESSION['ipo_member_panel']['card_number'],
				'status' => 1,
			);
			$data['ipo_member_information'] = $this->Dashboard_model->select('ipo_member_directory',$chellenge,'id','desc','row');
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'IPO Widthdraw Panel'; 			
			$data['header'] = $this->load->view('ipo/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('ipo/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('ipo/template/ipo_member_balance_widthdraw','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--------end ipo_member_balance_widthdraw
	
	public function change_password(){
		$data = array();
		if(!isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member/login'));
		}else{
			if(isset($_POST['change_password'])){
				$chellenge = array(
					'card_number' => $_SESSION['ipo_member_panel']['card_number'],
					'password' => $this->input->post('old_password'),
					'status' => 1,
				);
				$check_old_password = $this->Dashboard_model->select('ipo_member_directory',$chellenge,'id','desc','row');
				if($check_old_password->password == $this->input->post('old_password')){
					if($this->input->post('old_password') == $this->input->post('new_password')){
						alert('warning','Old & New Password are same please try with a new good password');
						redirect('ipo-member/change-password');
					}else{
						if(strlen($this->input->post('new_password')) < 6 ){
							alert('warning','Password must be minimum 6 character.');
							redirect('ipo-member/change-password');
						}else{
							if($this->input->post('new_password') == $this->input->post('confirm_password')){
								$data = array(
									'password' => $this->input->post('new_password')
								);								
								if($this->Dashboard_model->update('ipo_member_directory',$data,$check_old_password->id)){
									unset($_SESSION['ipo_member_panel']);									
									alert('success','Password Change Successfully! Please Login Again');
									redirect('ipo-member');
								}else{
									alert('warning','Something wrong! Please try again');
									redirect('ipo-member/change-password');
								}
							}else{
								alert('warning','New & Confirm Password dose not match! Please Try Again.');
								redirect('ipo-member/change-password');
							}
						}
					}
				}else{
					alert('danger','Old Password wrong! Please try again');
					redirect('ipo-member/change-password');
				}
			}
			$chellenge = array(
				'card_number' => $_SESSION['ipo_member_panel']['card_number'],
				'status' => 1,
			);
			$ipo_chellenge = array(
				'ipo_id' => $_SESSION['ipo_member_panel']['ipo_id']
			);
			$data['ipo_member_information'] = $this->Dashboard_model->select('ipo_member_directory',$chellenge,'id','desc','row');
			$data['ipo_member_balance'] = $this->Dashboard_model->select('ipo_member_balance',$ipo_chellenge,'id','desc','row');			
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Member Change Password'; 			
			$data['header'] = $this->load->view('ipo/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('ipo/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('ipo/template/change_password','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	public function view_profile()
	{
		$data = array();
		if(!isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member/login'));
		}else{
			$chellenge = array(
				'card_number' => $_SESSION['ipo_member_panel']['card_number'],
				'status' => 1,
			);
			$ipo_chellenge = array(
				'ipo_id' => $_SESSION['ipo_member_panel']['ipo_id']
			);
			$data['ipo_member_information'] = $this->Dashboard_model->select('ipo_member_directory',$chellenge,'id','desc','row');
			$data['ipo_member_balance'] = $this->Dashboard_model->select('ipo_member_balance',$ipo_chellenge,'id','desc','row');
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Member Change Password'; 			
			$data['header'] = $this->load->view('ipo/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('ipo/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('ipo/template/view_profile','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	public function exchange_ipo()
	{
		if(!isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member/login'));
		}else{
			$today = date('Y-m-d');
			$card_number_from = $_POST['card_number_from'];
			$to_card_number = $_POST['to_card_number'];
			$exchange_reason = $_POST['exchange_reason'];
			$exchange_aggrement_id = $_POST['exchange_aggrement_id'];
			// validation
			$chellenge_from = array(
				'card_number' => $card_number_from,
				'status' => 1,
			);
			$chellenge_to = array(
				'card_number' => $to_card_number,
				'status' => 1,
			);
			$chellenge_aggrement = array(
				'id' => $exchange_aggrement_id,
				'status' => 1,
			);
			$validate_from = $this->Dashboard_model->select('ipo_member_directory',$chellenge_from,'id','desc','row');
			$validate_to = $this->Dashboard_model->select('ipo_member_directory',$chellenge_to,'id','desc','row');			
			$validate_aggrement = $this->Dashboard_model->select('ipo_agreement_information',$chellenge_aggrement,'id','desc','row');
			$chellenge_purchase = array(
				'purses_code' => $validate_aggrement->purses_code,
				'status' => 1,
			);		
			$validate_purchase = $this->Dashboard_model->select('ipo_purses_information',$chellenge_purchase,'id','desc','row');			
			if(empty($validate_from) AND empty($validate_to) AND empty($validate_aggrement) AND empty($validate_purchase)){
				alert('warning','Wrong Information! Please try again');
				redirect('ipo-member');
			}
			
			// end validation
			$data = array(
				'from_member' 			=> $validate_from->ipo_id,
				'to_member' 			=> $validate_to->ipo_id,
				'exchange_aggrement_id' => $exchange_aggrement_id,
				'exchange_date' 		=> $today,
				'exchange_reason' 		=> $exchange_reason
			);		
			if($this->Dashboard_model->insert('ipo_exchange',$data)){
				$data = array(
					'note'		=> 'transferred'
				);
				if($this->Dashboard_model->update('ipo_agreement_information', $data, $exchange_aggrement_id)){
					$update_transferer_purchase = $this->Dashboard_model->mysqlij("SELECT sum(ipo_rate) as ipo_sum from ipo_agreement_information where purses_code = '$validate_aggrement->purses_code' AND note != 'transferred'");
					$purses_code = md5(rand() * time());
					// create new received purchase
					$data = array(
						'ipo_id'		=> $validate_to->ipo_id,
						'purses_code'	=> $purses_code,
						'purses_date'	=> $validate_purchase->purses_date,
						'total_amount'	=> $validate_aggrement->ipo_rate,
						'payed_amount'	=> $validate_aggrement->ipo_rate,
						'payment_method'=> $validate_purchase->payment_method,
						'data_one'		=> $validate_purchase->data_one,
						'data_two'		=> $validate_purchase->data_two,
						'data_three'	=> $validate_purchase->data_three,
						'note'			=> 'received',
						'status'		=> $validate_purchase->status,
						'uploader_info'	=> $validate_purchase->uploader_info,
						'data'			=> $validate_purchase->data
					);
					$this->Dashboard_model->insert('ipo_purses_information',$data);

					// create new received aggrement
					$data = array(
						'ipo_id'		=> $validate_to->ipo_id,
						'purses_code'	=> $purses_code,
						'branch_id'		=> $validate_aggrement->branch_id,
						'branch_name'	=> $validate_aggrement->branch_name,
						'floor_id'		=> $validate_aggrement->floor_id,
						'floor_name'	=> $validate_aggrement->floor_name,
						'unit_id'		=> $validate_aggrement->unit_id,
						'unit_name'		=> $validate_aggrement->unit_name,
						'room_id'		=> $validate_aggrement->room_id,
						'room_name'		=> $validate_aggrement->room_name,
						'bet_id'		=> $validate_aggrement->bet_id,
						'bed_name'		=> $validate_aggrement->bed_name,
						'bet_type'		=> $validate_aggrement->bet_type,
						'agreement_type'=> $validate_aggrement->agreement_type,
						'quantity'		=> $validate_aggrement->quantity,
						'ipo_commission'=> $validate_aggrement->ipo_commission,
						'ipo_rate'		=> $validate_aggrement->ipo_rate,
						'tenure'		=> $validate_aggrement->tenure,
						'expirity_date'	=> $validate_aggrement->expirity_date,
						'note'			=> 'received',
						'status'		=> $validate_aggrement->status,
						'uploader_info'	=> $validate_aggrement->uploader_info,
						'data'			=> $validate_aggrement->data
					);
					$this->Dashboard_model->insert('ipo_agreement_information', $data);
					// end update

					// update purchase table
					$data = array(
						'total_amount' => $update_transferer_purchase->ipo_sum
					);
					$this->Dashboard_model->update('ipo_purses_information', $data, $validate_purchase->id);
					// end update purchase table

					alert('success','Successfully Transferred!');
					redirect('ipo-member');
				}
			}
			alert('danger','Something went wrong. Please try again!');
			redirect('ipo-member');
		}
	}
	
	public function cancel_ipo()
	{
		if(!isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member/login'));
		}else{
			$today = date('Y-m-d');
			$withdraw_date = $_POST['withdraw_date'];
			$cancel_reason = $_POST['cancel_reason'];
			$cancel_aggrement_id = $_POST['cancel_aggrement_id'];
			$chellenge = array(
				'id' => $cancel_aggrement_id,
				'status' => 1
			);
			$canceled_aggrement = $this->Dashboard_model->select('ipo_agreement_information',$chellenge,'id','desc','row');
			$bed_id = $canceled_aggrement->bet_id;
			$data = array(
				'ipo_id' 				=> $_SESSION['ipo_member_panel']['ipo_id'],
				'withdraw_date' 		=> $withdraw_date,
				'cancel_reason' 		=> $cancel_reason,
				'canceled_aggrement_id' => $cancel_aggrement_id,
				'cration_date'			=> $today
			);
			if($this->Dashboard_model->insert('ipo_cancel',$data)){
				$data_aggrement = array(
					'status'	=> '0'
				);
				$data_bed = array(
					'ipo_uses'	=> '0'
				);
				if($this->Dashboard_model->update('ipo_agreement_information', $data_aggrement, $cancel_aggrement_id) AND $this->Dashboard_model->update('beds', $data_bed, $canceled_aggrement->bet_id)){
					alert('success','Aggrement Canceled!');
					redirect('ipo-member');
				}
			}
			alert('danger','Something went wrong. Please try again!');
			redirect('ipo-member');
		}
	}
	
	
	public function index(){
		$data = array();
		if(!isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member/login'));
		}else{
			$chellenge = array(
				'card_number' => $_SESSION['ipo_member_panel']['card_number'],
				'status' => 1,
			);			
			$ipo_member_information = $this->Dashboard_model->select('ipo_member_directory',$chellenge,'id','desc','row');
			$ipo_chellenge = array(
				'ipo_id' => $ipo_member_information->ipo_id
			);			
			$ipo_purchase_information = $this->Dashboard_model->select('ipo_purses_information',$ipo_chellenge,'id','desc','result');
			$ipo_aggrement_information = $this->Dashboard_model->select('ipo_agreement_information',$ipo_chellenge,'id','desc','result');
			$data['ipo_member_information'] = $ipo_member_information;
			$data['ipo_purchase_information'] = $ipo_purchase_information;
			$data['ipo_aggrement_information'] = $ipo_aggrement_information;
			$data['ipo_member_balance'] = $this->Dashboard_model->select('ipo_member_balance',$ipo_chellenge,'id','desc','row');			
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'IPO Member Dashboard'; 			
			$data['header'] = $this->load->view('ipo/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('ipo/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('ipo/include/article','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	public function logout(){
		unset($_SESSION['ipo_member_panel']);
		alert('success','Successfully Logout!');
		redirect(base_url('ipo-member/login'));
	}
	
	public function login(){
		$data = array();
		if(isset($_SESSION['ipo_member_panel']['card_number'])){
			redirect(base_url('ipo-member'));
		}else{
			if(isset($_POST['login'])){				
				$member_card = $this->input->post('member_card_number');
				$password = $this->input->post('password');
				$member_info = $this->Dashboard_model->select('ipo_member_directory',array('card_number' => $member_card),'id','desc','row');
				
				$card_number = $member_info->card_number;
				$chellenge = array(
					'card_number' => $card_number,
					'password' => $password,
					'status' => 1,
				);
				
				$get_data = $this->Dashboard_model->select('ipo_member_directory',$chellenge,'id','desc','row');
				if(!empty($get_data->id) AND !empty($get_data->personal_email) AND $get_data->card_number != 'Unauthorized'){
					$email = $get_data->personal_email;
					$card_number = $get_data->card_number;
					$ipo_id = $get_data->ipo_id;
					$session_data = array(
						'ipo_id' => $ipo_id,
						'card_number' => $card_number,
						'email' => $email
					);
					$_SESSION['ipo_member_panel'] = $session_data;
					alert('success','Successfully Login!');
					redirect(base_url('ipo-member'));									
				}else{
					alert('danger','Card Number or Password wrong. Please try again!');
					redirect(base_url('ipo-member/login'));
				}
			}
			$this->load->view('ipo/login',$data);
		}
	}
	//start pre_book_and_pre_booking_form  ------------- 
	public function pre_member_form(){
		$data = array();		
		$data['title_info'] = 'IPO Member Form'; 
		$data['article'] = $this->load->view('ipo/template/ipo_pre_registration.php',$data,TRUE); 
		$data['footer'] = $this->load->view('include/footer','',TRUE); 
		$this->load->view('dashboard',$data);

	}
	// ----------- END IPO member panel section ------------
}