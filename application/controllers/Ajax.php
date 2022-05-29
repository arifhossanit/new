<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}
	
	public function employ_datatable(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin'));
		}else{		
			$columns = array(
				array( 'db' => 'employee_id', 'dt' => 0 ),
				array( 'db' => 'f_name',  'dt' => 1 ),
				array( 'db' => 'designation',   'dt' => 2 ),
				array( 'db' => 'mother_name',     'dt' => 3 ),
				
			);		
		}
	}
	
	
	
}

	
	
	
	




























































	//==========================================EMPLOY SECTION======================================
	//---------Start adding Employ-------------
	public function add_employ(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(
				$_SESSION['super_admin']['user_type'] == 'super_admin' OR
				$_SESSION['super_admin']['user_type'] == 'admin' OR 
				$_SESSION['super_admin']['user_type'] == 'hrm'
			){
				if(isset($_POST['add_employ'])){
					if(!empty($_FILES['photo']['name'])){
						$photo = image_upload('photo','240','320','100');
					}else{
						$photo = '';
					}					
					if(!empty($_FILES['emergency_attachment_1']['name'])){
						$emergency_attachment_1 = file_upload('emergency_attachment_1');
					}else{
						$emergency_attachment_1 = '';
					}
					if(!empty($_FILES['emergency_attachment_2']['name'])){
						$emergency_attachment_2 = file_upload('emergency_attachment_2');
					}else{
						$emergency_attachment_2 = '';
					}
					if(!empty($_FILES['first_doc']['name'])){
						$first_doc = file_upload('first_doc');
					}else{
						$first_doc = '';
					}
					if(!empty($_FILES['second_doc']['name'])){
						$second_doc = file_upload('second_doc');
					}else{
						$second_doc = '';
					}
					if(!empty($_FILES['forth_doc']['name'])){
						$forth_doc = file_upload('forth_doc');
					}else{
						$forth_doc = '';
					}
					$total = count($_FILES['thired_doc']['name']);
					if($total > 0 AND !empty($_FILES['thired_doc']['name'][0])){						
						$newFilePathw = '';
						$variable = rand()*rand();
						for( $i = 0 ; $i < $total ; $i++ ){							
							$tmpFilePath = $_FILES['thired_doc']['tmp_name'][$i];
							if ($tmpFilePath != ""){
								$newFilePath = "assets/uploads/" .$variable.'_'. $_FILES['thired_doc']['name'][$i];
								$newFilePathw .= "assets/uploads/" .$variable.'_'. $_FILES['thired_doc']['name'][$i].',';
								move_uploaded_file($tmpFilePath, $newFilePath);								
							}
						}
						$thired_doc = $newFilePathw;
					}else{
						$thired_doc = '';
					}
					$data = array(
						'id' => '',
						'employee_id' 		=> $this->input->post('employee_id'),
						'role' 				=> $this->input->post('role'),
						'designation' 		=> $this->input->post('designation'),
						'department' 		=> $this->input->post('department'),
						'f_name' 			=> $this->input->post('f_name'),
						'l_name' 			=> $this->input->post('l_name'),
						'father_name' 		=> $this->input->post('father_name'),
						'mother_name' 		=> $this->input->post('mother_name'),
						'gender' 			=> $this->input->post('gender'),
						'marital_status' 	=> $this->input->post('marital_status'),
						'date_of_birth' 	=> $this->input->post('date_of_birth'),
						'date_of_joining' 	=> $this->input->post('date_of_joining'),
						'blood_group' 		=> $this->input->post('blood_group'),
						'personal_Phone' 	=> $this->input->post('personal_Phone'),
						'email' 			=> $this->input->post('email'),
						'photo' 			=> $photo,
						'Company_phone' 	=> $this->input->post('Company_phone'),
						'company_email' 	=> $this->input->post('company_email'),
						'branch' 			=> $this->input->post('branch'),
						'emergency_no1' 	=> $this->input->post('emergency_no1'),
						'emergency_no2' 	=> $this->input->post('emergency_no2'),
						'emergency_attachment_1' => $emergency_attachment_1,
						'emergency_attachment_2' => $emergency_attachment_2,
						'current_address' 	=> $this->input->post('current_address'),
						'permanent_address' => $this->input->post('permanent_address'),
						'qualification' 	=> $this->input->post('qualification'),
						'work_exp' 			=> $this->input->post('work_exp'),
						'note' 				=> $this->input->post('note'),
						'facebook' 			=> $this->input->post('facebook'),
						'twitter' 			=> $this->input->post('twitter'),
						'linkedin' 			=> $this->input->post('linkedin'),
						'instagram' 		=> $this->input->post('instagram'),
						'first_doc' 		=> $first_doc,
						'second_doc' 		=> $second_doc,
						'thired_doc' 		=> $thired_doc,
						'forth_doc' 		=> $forth_doc,						
						'status' 			=> '1',
						'uploader_info' 	=> $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' 				=> date('Y-m-d h:i:s A')
					);				
					if($this->Dashboard_model->insert('employee',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
				
							
				
				if(isset($_POST['edit'])){
					$where = array('id' => $this->input->post('hidden_id'));
					$data['edit'] = $this->Dashboard_model->select('floors',$where,'id','desc','row');
				}
				
				
				
				//----------add roles-----
				if(isset($_POST['add_role'])){
					$data = array(
						'id' => '',
						'role_id' => time() * rand(),
						'role_name' => $this->input->post('role_name'),
						'status' => '1',
						'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' => date('Y-m-d h:i:s A')
					);
					if($this->Dashboard_model->insert('roles',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}					
				}
				//----------end add roles----
				
				
				//----------add Designation-----
				if(isset($_POST['add_designation'])){
					$data = array(
						'id' => '',
						'designation_id' => time() * rand(),
						'designation_name' => $this->input->post('designation_name'),
						'status' => '1',
						'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' => date('Y-m-d h:i:s A')
					);
					if($this->Dashboard_model->insert('designation',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}					
				}
				//----------end add Designation----
				
				//----------add department-----
				if(isset($_POST['add_department'])){
					$data = array(
						'id' => '',
						'department_id' => time() * rand(),
						'department_name' => $this->input->post('department_name'),
						'status' => '1',
						'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' => date('Y-m-d h:i:s A')
					);
					if($this->Dashboard_model->insert('department',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}					
				}
				//----------end add department----
				
				
				$condition = array('status' => '1');
				$data['role'] = $this->Dashboard_model->select('roles',$condition,'id','ASC','result');
				$data['designation'] = $this->Dashboard_model->select('designation',$condition,'id','ASC','result');
				$data['department'] = $this->Dashboard_model->select('department',$condition,'id','ASC','result');
				$data['banches'] = $this->Dashboard_model->select('branches',$condition,'id','ASC','result');
		
				
				$data['header'] = $this->load->view('include/header','',TRUE); 
				$data['nav'] = $this->load->view('include/nav','',TRUE); 
				$data['article'] = $this->load->view('template/hrm/add_employ',$data,TRUE); 
				$data['footer'] = $this->load->view('include/footer','',TRUE); 
				$this->load->view('dashboard',$data);
			}else{
				alert('danger','Permission Denined!!');
				redirect(base_url('admin'));
			}		
		}
	}
	//---------End adding Employ-------------
}

























