<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}
	//---------Start adding branch-------------
	public function add_branch(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				if($_FILES['agreement_attachment']['name'] != '' ){
					$total = count($_FILES['agreement_attachment']['name']);
					$newFilePathw = '';
					$variable = rand()*rand();
					for( $i = 0 ; $i < $total ; $i++ ){							
						$tmpFilePath = $_FILES['agreement_attachment']['tmp_name'][$i];
						if ($tmpFilePath != ""){
							$newFilePath = "assets/uploads/" .$variable.'_'. $_FILES['agreement_attachment']['name'][$i];
							$newFilePathw .= "assets/uploads/" .$variable.'_'. $_FILES['agreement_attachment']['name'][$i].',';
							move_uploaded_file($tmpFilePath, $newFilePath);								
						}
					}
					$attacheted_file = $newFilePathw;
				}else{
					$attacheted_file = '';
				}
				
				if($_FILES['image_files']['name'] != '' ){
					$totalq = count($_FILES['image_files']['name']);
					$newFilePathqq = '';
					$variable = rand()*rand();
					for( $i = 0 ; $i < $totalq ; $i++ ){							
						$tmpFilePath = $_FILES['image_files']['tmp_name'][$i];
						if ($tmpFilePath != ""){
							$newFilePathq = "assets/uploads/" .$variable.'_'. $_FILES['image_files']['name'][$i];
							$newFilePathqq .= "assets/uploads/" .$variable.'_'. $_FILES['image_files']['name'][$i].',';
							move_uploaded_file($tmpFilePath, $newFilePathq);								
						}
					}
					$attacheted_image = $newFilePathqq;
				}else{
					$attacheted_image = '';
				}
				
				if(isset($_POST['branch_satatus'])){
					$status = 1;
				}else{
					$status = 0;
				}
				
				$data = array(
					'id' => '',
					'country' => $this->input->post('country'),
					'branch_id' => $this->input->post('branch_id'),
					'branch_name' => $this->input->post('branch_name'),
					'branch_type' => $this->input->post('branch_type'),
					'branch_code' => $this->input->post('branch_code'),
					'branch_phone_number' => $this->input->post('branch_phone_number'),
					'branch_location' => $this->input->post('branch_location'),
					'branch_rent' => $this->input->post('branch_rent'),
					'branch_owner' => $this->input->post('owner_details'),
					'file_attachment' => $attacheted_file,
					'image_attachment' => $attacheted_image,
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y'),
					'petty_cash_limit' => $this->input->post('petty_cash_limit')
				);
				
				if($this->Dashboard_model->insert('branches',$data)){
					alert('success','Successfully Saved!');
					redirect(base_url('admin/add-branch'));
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(base_url('admin/add-branch'));
				}
			}
			
			if(isset($_POST['update'])){
				$where = array('id' => $this->input->post('update_id'));
				$attasted_data = $this->Dashboard_model->select('branches',$where,'id','desc','row');
				
				$total = count($_FILES['agreement_attachment']['name']);
				if($total > 0 AND !empty($_FILES['agreement_attachment']['name'][0])){						
					$newFilePathw = '';
					$variable = rand()*rand();
					for( $i = 0 ; $i < $total ; $i++ ){							
						$tmpFilePath = $_FILES['agreement_attachment']['tmp_name'][$i];
						if ($tmpFilePath != ""){
							$newFilePath = "assets/uploads/" .$variable.'_'. $_FILES['agreement_attachment']['name'][$i];
							$newFilePathw .= "assets/uploads/" .$variable.'_'. $_FILES['agreement_attachment']['name'][$i].',';
							move_uploaded_file($tmpFilePath, $newFilePath);								
						}
					}
					$attacheted_file = $newFilePathw;
				}else{
					$attacheted_file = $attasted_data->file_attachment;
				}
				$totalq = count($_FILES['image_files']['name']);
				if($totalq > 0 AND !empty($_FILES['image_files']['name'][0])){						
					$newFilePathqq = '';
					$variable = rand()*rand();
					for( $i = 0 ; $i < $totalq ; $i++ ){							
						$tmpFilePath = $_FILES['image_files']['tmp_name'][$i];
						if ($tmpFilePath != ""){
							$newFilePathq = "assets/uploads/" .$variable.'_'. $_FILES['image_files']['name'][$i];
							$newFilePathqq .= "assets/uploads/" .$variable.'_'. $_FILES['image_files']['name'][$i].',';
							move_uploaded_file($tmpFilePath, $newFilePathq);								
						}
					}
					$attacheted_image = $newFilePathqq;
				}else{
					$attacheted_image = $attasted_data->image_attachment;
				}
				
				if(isset($_POST['branch_satatus'])){
					$status = 1;
				}else{
					$status = 0;
				}
				
				$data = array(
					'id' => $this->input->post('update_id'),
					'country' => $this->input->post('country'),
					'branch_id' => $this->input->post('branch_id'),
					'branch_name' => $this->input->post('branch_name'),
					'branch_type' => $this->input->post('branch_type'),
					'branch_phone_number' => $this->input->post('branch_phone_number'),
					'branch_code' => $this->input->post('branch_code'),
					'branch_location' => $this->input->post('branch_location'),
					'branch_rent' => $this->input->post('branch_rent'),
					'branch_owner' => $this->input->post('owner_details'),
					'file_attachment' => $attacheted_file,
					'image_attachment' => $attacheted_image,
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y'),
					'petty_cash_limit' => $this->input->post('petty_cash_limit')
				);
				if($this->Dashboard_model->update('branches',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('branches',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('branches',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('branches',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$data['title_info'] = 'Branch Management';
			$data['table'] = $this->Dashboard_model->select('branches','','id','desc','result');
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/create/add_branch',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
			
		}
	}
	//---------End adding branch-------------
	//---------Start adding Floor-------------
	public function add_floor(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $this->input->post('branch_id'),
					'branch_name' => $branch_name->branch_name,
					'floor_name' => $this->input->post('floor_name'),
					'floor_type' => $this->input->post('floor_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);					
				if($this->Dashboard_model->insert('floors',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $this->input->post('branch_id'),
					'branch_name' => $branch_name->branch_name,
					'floor_name' => $this->input->post('floor_name'),
					'floor_type' => $this->input->post('floor_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('floors',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('floors',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('floors',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			//---------Start adding Unit-------------
			if(isset($_POST['add_unit'])){
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				foreach($this->input->post('unit_name') as $row => $value){
					
					$data[] = array(
						'id' => '',
						'branch_id' => $branch_id,
						'branch_name' => $branch_name->branch_name,
						'floor_id' => $floor_id,
						'floor_name' => $floor_name->floor_name,
						'unit_id' => rand() * time(),
						'unit_name' => $this->input->post('unit_name')[$row],
						'unit_type' => $this->input->post('unit_type')[$row],
						'note' => '',
						'status' => '1',
						'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' => date('d/m/Y')
					);
				}
				if($this->Dashboard_model->insert_batch('units',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}				
			}
			
			//---------End adding Unit-------------
			
			
			//---------Start adding room-------------
			if(isset($_POST['add_room'])){
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$unit_id = $this->input->post('unit_id');
				$unit_name = $this->Dashboard_model->select('units',array('id' => $unit_id),'id','desc','row');
				foreach($this->input->post('room_name') as $row => $value){						
					$data[] = array(
						'id' => '',
						'branch_id' => $branch_id,
						'branch_name' => $branch_name->branch_name,
						'floor_id' => $floor_id,
						'floor_name' => $floor_name->floor_name,
						'unit_id' => $unit_id,
						'unit_name' => $unit_name->unit_name,
						'room_name' => $this->input->post('room_name')[$row],
						'room_type' => $this->input->post('room_type'),
						'note' => '',
						'status' => '1',
						'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' => date('d/m/Y')
					);
				}
				if($this->Dashboard_model->insert_batch('rooms',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}				
			}
			
			//---------End adding room-------------
			
			//---------Start adding beds-------------
			if(isset($_POST['add_bed'])){
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$unit_id = $this->input->post('unit_id');
				$unit_name = $this->Dashboard_model->select('units',array('id' => $unit_id),'id','desc','row');
				$room_id = $this->input->post('room_id');
				$room_name = $this->Dashboard_model->select('rooms',array('id' => $room_id),'id','desc','row');
				
				foreach($this->input->post('bed_name') as $row => $value){						
					$data[] = array(
						'id' => '',
						'branch_id' => $branch_id,
						'branch_name' => $branch_name->branch_name,
						'floor_id' => $floor_id,
						'floor_name' => $floor_name->floor_name,
						'unit_id' => $unit_id,
						'unit_name' => $unit_name->unit_name,
						'room_id' => $room_id,
						'room_name' => $room_name->room_name,
						'bed_name' => $unit_name->unit_name.''.$room_name->room_name.''.$this->input->post('bed_name')[$row],
						'note' => '',
						'uses' => '0',
						'status' => '1',
						'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' => date('d/m/Y')
					);
					$check = $unit_name->unit_name.''.$room_name->room_name.''.$this->input->post('bed_name')[$row];
					if($this->Dashboard_model->chaeck_data('beds','bed_name',$check,$branch_id)){
						alert('warning','Any Field is already exixt! Please try again');
						redirect(current_url());
					}
				}
				
				if($this->Dashboard_model->insert_batch('beds',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}						
			}
			
			//---------End adding beds-------------
			
			
			$condition = array('status' => '1');
			$data['room_type'] = $this->Dashboard_model->select('room_type',$condition,'id','ASC','result');
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
				$data['table'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
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
					$data['table'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
				}else{
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
					$data['table'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
				}				
			}			
			$data['table2'] = $this->Dashboard_model->select('floors','','id','desc','result');
			$data['title_info'] = 'Floors, Unit, Rooms, Beds Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/add_floor',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End adding Floor-------------
	//---------Start Manage Units-------------
	public function manage_units(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'floor_id' => $floor_id,
					'floor_name' => $floor_name->floor_name,
					'unit_id' => rand() * time(),
					'unit_name' => $this->input->post('unit_name'),
					'unit_type' => $this->input->post('unit_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);					
				if($this->Dashboard_model->insert('units',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'floor_id' => $floor_id,
					'floor_name' => $floor_name->floor_name,
					'unit_id' => '',
					'unit_name' => $this->input->post('unit_name'),
					'unit_type' => $this->input->post('unit_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('units',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('units',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('units',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('units',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			
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
			$data['table'] = $this->Dashboard_model->select('units','','id','desc','result');
			$data['title_info'] = 'Unit Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_unit',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage Units-------------
	//---------Start Manage Rooms-------------
	public function manage_rooms(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$unit_id = $this->input->post('unit_id');
				$unit_name = $this->Dashboard_model->select('units',array('id' => $unit_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'floor_id' => $floor_id,
					'floor_name' => $floor_name->floor_name,
					'unit_id' => $unit_id,
					'unit_name' => $unit_name->unit_name,
					'room_name' => $this->input->post('room_name'),
					'room_type' => $this->input->post('room_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);					
				if($this->Dashboard_model->insert('rooms',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$unit_id = $this->input->post('unit_id');
				$unit_name = $this->Dashboard_model->select('units',array('id' => $unit_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'floor_id' => $floor_id,
					'floor_name' => $floor_name->floor_name,
					'unit_id' => $unit_id,
					'unit_name' => $unit_name->unit_name,
					'room_name' => $this->input->post('room_name'),
					'room_type' => $this->input->post('room_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('rooms',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('rooms',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('rooms',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

				
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('rooms',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
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
			$data['table'] = $this->Dashboard_model->select('rooms','','id','desc','result');
			$data['title_info'] = 'Rooms Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_rooms',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage Rooms-------------
	//---------Start Manage Column-------------
	public function manage_column(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$unit_id = $this->input->post('unit_id');
				$unit_name = $this->Dashboard_model->select('units',array('id' => $unit_id),'id','desc','row');
				$room_id = $this->input->post('room_id');
				$room_name = $this->Dashboard_model->select('rooms',array('id' => $room_id),'id','desc','row');		
				
				$data = array(
					'id' => '',
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'floor_id' => $floor_id,
					'floor_name' => $floor_name->floor_name,
					'unit_id' => $unit_id,
					'unit_name' => $unit_name->unit_name,
					'room_id' => $room_name->id,
					'room_name' => $room_name->room_name,					
					'column_name' => $this->input->post('column_name'),					
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);					
				if($this->Dashboard_model->insert('column_list',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$unit_id = $this->input->post('unit_id');
				$unit_name = $this->Dashboard_model->select('units',array('id' => $unit_id),'id','desc','row');
				$room_id = $this->input->post('room_id');
				$room_name = $this->Dashboard_model->select('rooms',array('id' => $room_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'floor_id' => $floor_id,
					'floor_name' => $floor_name->floor_name,
					'unit_id' => $unit_id,
					'unit_name' => $unit_name->unit_name,
					'room_id' => $room_name->id,
					'room_name' => $room_name->room_name,					
					'column_name' => $this->input->post('column_name'),					
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('column_list',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('column_list',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('column_list',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('column_list',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
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
			$data['table'] = $this->Dashboard_model->select('column_list',$condition,'id','desc','result');
			$data['title_info'] = 'Rooms Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_column',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage Column-------------
	//---------Start Manage Beds-------------
	public function manage_beds(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$unit_id = $this->input->post('unit_id');
				$unit_name = $this->Dashboard_model->select('units',array('id' => $unit_id),'id','desc','row');
				$room_id = $this->input->post('room_id');
				$room_name = $this->Dashboard_model->select('rooms',array('id' => $room_id),'id','desc','row');
				$coloumn_id = $this->input->post('coloumn_id');
				$coloumn_name = $this->Dashboard_model->select('column_list',array('id' => $coloumn_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'floor_id' => $floor_id,
					'floor_name' => $floor_name->floor_name,
					'unit_id' => $unit_id,
					'unit_name' => $unit_name->unit_name,
					'room_id' => $room_id,
					'room_name' => $room_name->room_name,
					'coloumn_id' => $coloumn_id,
					'coloumn_name' => $coloumn_name->column_name,					
					'bed_name' => $unit_name->unit_name.''.$room_name->room_name.''.$this->input->post('bed_name'),
					'note' => $this->input->post('note'),
					'uses' => '0',
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				
				if($this->Dashboard_model->chaeck_data('beds','bed_name',$this->input->post('bed_name'),$branch_id)){
					alert('warning','Any Field is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('beds',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$floor_id = $this->input->post('floor_id');
				$floor_name = $this->Dashboard_model->select('floors',array('id' => $floor_id),'id','desc','row');
				$unit_id = $this->input->post('unit_id');
				$unit_name = $this->Dashboard_model->select('units',array('id' => $unit_id),'id','desc','row');
				$room_id = $this->input->post('room_id');
				$room_name = $this->Dashboard_model->select('rooms',array('id' => $room_id),'id','desc','row');
				$coloumn_id = $this->input->post('coloumn_id');
				$coloumn_name = $this->Dashboard_model->select('column_list',array('id' => $coloumn_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'floor_id' => $floor_id,
					'floor_name' => $floor_name->floor_name,
					'unit_id' => $unit_id,
					'unit_name' => $unit_name->unit_name,
					'room_id' => $room_id,
					'room_name' => $room_name->room_name,
					'coloumn_id' => $coloumn_id,
					'coloumn_name' => $coloumn_name->column_name,
					'bed_name' => $this->input->post('bed_name'),					
					'note' => $this->input->post('note'),
					'uses' => '0',
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('beds',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('beds',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('beds',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	
			
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('beds',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('beds','','id','asc','result');
			$data['title_info'] = 'Beds Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_beds',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage Beds-------------
	//---------Start room type-------------
	public function manage_room_types(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$package_category = $this->input->post('package_category');
				$package_category_name = $this->Dashboard_model->select('packages_category',array('id' => $package_category),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_name->branch_id,
					'branch_name' => $branch_name->branch_name,
					'package_category' => $package_category_name->id,
					'package_category_name' => $package_category_name->package_category_name,
					'room_type' => $this->input->post('room_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$condition = array(
					'branch_id' => $branch_name->branch_id,
					'package_category' => $package_category_name->id,
					'room_type' => $this->input->post('room_type')
				);
				$check = $this->Dashboard_model->select('room_type',$condition,'id','desc','row');
				if(!empty($check->id)){
					alert('warning',''.$check->room_type.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('room_type',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$package_category = $this->input->post('package_category');
				$package_category_name = $this->Dashboard_model->select('packages_category',array('id' => $package_category),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_name->branch_id,
					'branch_name' => $branch_name->branch_name,
					'package_category' => $package_category_name->id,
					'package_category_name' => $package_category_name->package_category_name,
					'room_type' => $this->input->post('room_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('room_type',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('room_type',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('room_type',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('room_type',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('room_type','','id','asc','result');
			$data['title_info'] = 'Room Type Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/room_type',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End room type-------------
	//---------Start manage_locker_types-------------
	public function manage_locker_types(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_name->branch_id,
					'branch_name' => $branch_name->branch_name,
					'locker_type' => $this->input->post('locker_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$condition = array(
					'branch_id' => $branch_name->branch_id,
					'locker_type' => $this->input->post('locker_type')
				);
				$check = $this->Dashboard_model->select('locker_type',$condition,'id','desc','row');
				if(!empty($check->id)){
					alert('warning',''.$check->locker_type.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('locker_type',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_name->branch_id,
					'branch_name' => $branch_name->branch_name,
					'locker_type' => $this->input->post('locker_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('locker_type',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('locker_type',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('locker_type',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('locker_type',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('locker_type','','id','asc','result');
			$data['title_info'] = 'Locker Type Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_locker_types',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End manage_locker_types-------------
	//---------Start manage_locker-------------
	public function manage_locker(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$locker_id = $this->input->post('locker_type');
				$locker_typew = $this->Dashboard_model->select('locker_type',array('id' => $locker_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_name->branch_id,
					'branch_name' => $branch_name->branch_name,
					'locker_type' => $this->input->post('locker_type'),
					'locker_type_name' => $locker_typew->locker_type,
					'locker_number' => $this->input->post('locker_number'),
					'price' => $this->input->post('price'),
					'note' => $this->input->post('note'),
					'uses' => '0',
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$condition = array(
					'branch_id' => $branch_name->branch_id,
					'locker_type' => $this->input->post('locker_type'),
					'locker_number' => $this->input->post('locker_number')
				);
				$check = $this->Dashboard_model->select('manage_locker',$condition,'id','desc','row');
				if(!empty($check->id)){
					alert('warning',''.$check->locker_type.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('manage_locker',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$locker_id = $this->input->post('locker_type');
				$locker_typew = $this->Dashboard_model->select('locker_type',array('id' => $locker_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_name->branch_id,
					'branch_name' => $branch_name->branch_name,
					'locker_type' => $this->input->post('locker_type'),
					'locker_type_name' => $locker_typew->locker_type,
					'locker_number' => $this->input->post('locker_number'),
					'price' => $this->input->post('price'),
					'note' => $this->input->post('note'),
					'uses' => '0',
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('manage_locker',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('manage_locker',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('manage_locker',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('manage_locker',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('manage_locker','','id','asc','result');
			$data['title_info'] = 'Locker Type Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_locker',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End manage_locker-------------
	//---------Start Manage Package-------------
	public function manage_package(){
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
				if(isset($_POST['try_us'])){
					$try_us = 1;
				}else{
					$try_us = 0;
				}
				if(isset($_POST['aggreement'])){
					$aggreement = 1;
				}else{
					$aggreement = 0;
				}
				if(isset($_POST['installment'])){
					$installment = 1;
				}else{
					$installment = 0;
				}
				if(isset($_POST['monthly_package'])){
					$monthly_package = 1;
				}else{
					$monthly_package = 0;
				}
				$services = implode(',', $this->input->post('services'));
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$pachage_category_id = $this->input->post('packagr_id_category');
				$package_category_name = $this->Dashboard_model->select('packages_category',array('id' => $pachage_category_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'package_category_id' => $package_category_name->id,
					'package_category_name' => $package_category_name->package_category_name,				
					'services' => $services,					
					'sub_category_id' => $this->input->post('sub_category_id'),					
					'package_name' => $this->input->post('package_name'),					
					'package_price' => $this->input->post('package_price'),
					'monthly_rent' => $this->input->post('monthly_rent'),
					'package_days' => $this->input->post('package_days'),
					'parking_amount' => $this->input->post('parking_amount'),
					'card_change_amount' => $this->input->post('card_change_amount'),					
					'discount_amount' => $this->input->post('discount_amount'),
					'group_discount_amount' => $this->input->post('group_discount_amount'),					
					'note' => $this->input->post('note'),
					'status' => $status,
					'try_us' => $try_us,
					'aggreement' => $aggreement,
					'installment' => $installment,
					'monthly_package' => $monthly_package,					
					'auto_cancel_days_half' => $this->input->post('auto_cancel_days_half'),
					'auto_cancel_days_full' => $this->input->post('auto_cancel_days_full'),
					'auto_cancel_days_checkin_date' => $this->input->post('auto_cancel_days_checkin_date'),
					'panalty_start_days_half_payment' => $this->input->post('panalty_start_days_half_payment'),
					'panalty_start_days_full_payment' => $this->input->post('panalty_start_days_full_payment'),
					'panalty_start_days_checkin_date' => $this->input->post('panalty_start_days_checkin_date'),
					'panalty_amount' => $this->input->post('panalty_amount'),					
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);				
				if($this->Dashboard_model->insert('packages',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['update'])){				
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				if(isset($_POST['try_us'])){
					$try_us = 1;
				}else{
					$try_us = 0;
				}
				if(isset($_POST['aggreement'])){
					$aggreement = 1;
				}else{
					$aggreement = 0;
				}
				if(isset($_POST['installment'])){
					$installment = 1;
				}else{
					$installment = 0;
				}
				if(isset($_POST['monthly_package'])){
					$monthly_package = 1;
				}else{
					$monthly_package = 0;
				}
				$services = implode(',', $this->input->post('services'));
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$pachage_category_id = $this->input->post('packagr_id_category');
				$package_category_name = $this->Dashboard_model->select('packages_category',array('id' => $pachage_category_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'package_category_id' => $package_category_name->id,
					'package_category_name' => $package_category_name->package_category_name,				
					'services' => $services,
					'sub_category_id' => $this->input->post('sub_category_id'),	
					'package_name' => $this->input->post('package_name'),					
					'package_price' => $this->input->post('package_price'),
					'monthly_rent' => $this->input->post('monthly_rent'),
					'package_days' => $this->input->post('package_days'),
					'parking_amount' => $this->input->post('parking_amount'),
					'card_change_amount' => $this->input->post('card_change_amount'),
					'discount_amount' => $this->input->post('discount_amount'),
					'group_discount_amount' => $this->input->post('group_discount_amount'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'try_us' => $try_us,
					'aggreement' => $aggreement,
					'installment' => $installment,
					'monthly_package' => $monthly_package,					
					'auto_cancel_days_half' => $this->input->post('auto_cancel_days_half'),
					'auto_cancel_days_full' => $this->input->post('auto_cancel_days_full'),
					'auto_cancel_days_checkin_date' => $this->input->post('auto_cancel_days_checkin_date'),
					'panalty_start_days_half_payment' => $this->input->post('panalty_start_days_half_payment'),
					'panalty_start_days_full_payment' => $this->input->post('panalty_start_days_full_payment'),
					'panalty_start_days_checkin_date' => $this->input->post('panalty_start_days_checkin_date'),
					'panalty_amount' => $this->input->post('panalty_amount'),					
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('packages',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}		
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('packages',$where,'id','desc','row');
			}			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('packages',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('packages',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['sub_category'] = $this->Dashboard_model->mysqlii("SELECT * FROM sub_package_category");
			$data['service'] = $this->Dashboard_model->select('services',$condition,'id','ASC','result');
			$data['table'] = $this->Dashboard_model->select('packages','','id','asc','result');
			$data['title_info'] = 'Package Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_package',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
		}
	}
	//---------End Manage Package-------------
	
	//---------Start manage_package_category-------------
	public function manage_package_category(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'package_category_name' => $this->input->post('package_category_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);				
				if($this->Dashboard_model->insert('packages_category',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'package_category_name' => $this->input->post('package_category_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);		
				if($this->Dashboard_model->update('packages_category',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('packages_category',$where,'id','desc','row');
			}			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('packages_category',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}				
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('packages_category',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('packages_category','','id','desc','result');
			$data['title_info'] = 'Package Category Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_package_category',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
		}
	}
	//---------End manage_package_category-------------
	
	
	//---------Start manage_ipo_category-------------
	public function manage_ipo_category(){
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
				if($_FILES['image_one']['name'] != ''){
					$image_one = image_upload_dir('image_one', '1600', '1200', '90', 'ipo/ipo_category/');
				}else{
					$image_one = '';
				}				
				if($_FILES['image_two']['name'] != ''){
					$image_two = image_upload_dir('image_two', '1600', '1200', '90', 'ipo/ipo_category/');;
				}else{
					$image_two = '';
				}				
				if($_FILES['image_three']['name'] != ''){
					$image_three = image_upload_dir('image_three', '1600', '1200', '90', 'ipo/ipo_category/');;
				}else{
					$image_three = '';
				}				
				foreach($this->input->post('branch_id') as $row){
					$branch_id = $row;
					$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
					$data[] = array(
						'id' => '',
						'branch_id' => $branch_id,
						'branch_name' => $branch_name->branch_name,
						'category_name' => $this->input->post('category_name'),
						'price' => $this->input->post('ipo_rate'),
						'ipo_profit' => $this->input->post('ipo_profit'),
						'referal_first_month' => $this->input->post('ipo_discount_first_month'),
						'referal_second_month' => $this->input->post('ipo_discount_secont_month'),
						'referal_third_month' => $this->input->post('ipo_discount_third_month'),
						'profit_first_month' => $this->input->post('referal_profit_first_month'),
						'profit_second_month' => $this->input->post('referal_profit_second_month'),
						'profit_third_month' => $this->input->post('referal_profit_third_month'),
						'image_one' => $image_one,
						'image_two' => $image_two,
						'image_three' => $image_three,						
						'note' => $this->input->post('note'),
						'status' => $status,
						'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' => date('d/m/Y')
					);
				}
				
				if($this->Dashboard_model->insert_batch('ipo_category',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}	
				$get_files = $this->Dashboard_model->select('ipo_category',array('id' => $this->input->post('update_id')),'id','desc','row');
				
				if($_FILES['image_one']['name'] != ''){
					$image_one = image_upload_dir('image_one', '1600', '1200', '90', 'ipo/ipo_category/');
				}else{
					$image_one = $get_files->image_one;
				}				
				if($_FILES['image_two']['name'] != ''){
					$image_two = image_upload_dir('image_two', '1600', '1200', '90', 'ipo/ipo_category/');;
				}else{
					$image_two = $get_files->image_two;
				}				
				if($_FILES['image_three']['name'] != ''){
					$image_three = image_upload_dir('image_three', '1600', '1200', '90', 'ipo/ipo_category/');;
				}else{
					$image_three = $get_files->image_three;
				}
				
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'category_name' => $this->input->post('category_name'),
					'price' => $this->input->post('ipo_rate'),
					'ipo_profit' => $this->input->post('ipo_profit'),
					'referal_first_month' => $this->input->post('ipo_discount_first_month'),
					'referal_second_month' => $this->input->post('ipo_discount_secont_month'),
					'referal_third_month' => $this->input->post('ipo_discount_third_month'),
					'profit_first_month' => $this->input->post('referal_profit_first_month'),
					'profit_second_month' => $this->input->post('referal_profit_second_month'),
					'profit_third_month' => $this->input->post('referal_profit_third_month'),
					'image_one' => $image_one,
					'image_two' => $image_two,
					'image_three' => $image_three,						
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);		
				if($this->Dashboard_model->update('ipo_category',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('ipo_category',$where,'id','desc','row');
			}

			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('ipo_category',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	
			
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('ipo_category',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('ipo_category','','id','desc','result');
			$data['title_info'] = 'IPO Category Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/create/manage_ipo_category',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
		}
	}
	//---------End manage_ipo_category-------------
	
	
	
	//---------Start manage_agreement_type-------------
	public function manage_agreement_type(){
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
				if($_FILES['image_one']['name'] != ''){
					$image_one = image_upload_dir('image_one', '1600', '1200', '90', 'ipo/ipo_category/');
				}else{
					$image_one = '';
				}				
				if($_FILES['image_two']['name'] != ''){
					$image_two = image_upload_dir('image_two', '1600', '1200', '90', 'ipo/ipo_category/');;
				}else{
					$image_two = '';
				}				
				if($_FILES['image_three']['name'] != ''){
					$image_three = image_upload_dir('image_three', '1600', '1200', '90', 'ipo/ipo_category/');;
				}else{
					$image_three = '';
				}				
				foreach($this->input->post('branch_id') as $row){
					$branch_id = $row;
					$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
					$data[] = array(
						'id' => '',
						'branch_id' => $branch_id,
						'branch_name' => $branch_name->branch_name,
						'category_name' => $this->input->post('category_name'),
						'price' => $this->input->post('ipo_rate'),
						'ipo_profit' => $this->input->post('ipo_profit'),
						'referal_first_month' => $this->input->post('ipo_discount_first_month'),
						'referal_second_month' => $this->input->post('ipo_discount_secont_month'),
						'referal_third_month' => $this->input->post('ipo_discount_third_month'),
						'profit_first_month' => $this->input->post('referal_profit_first_month'),
						'profit_second_month' => $this->input->post('referal_profit_second_month'),
						'profit_third_month' => $this->input->post('referal_profit_third_month'),
						'image_one' => $image_one,
						'image_two' => $image_two,
						'image_three' => $image_three,						
						'note' => $this->input->post('note'),
						'status' => $status,
						'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
						'data' => date('d/m/Y')
					);
				}
				
				if($this->Dashboard_model->insert_batch('ipo_category',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}	
				$get_files = $this->Dashboard_model->select('ipo_category',array('id' => $this->input->post('update_id')),'id','desc','row');
				
				if($_FILES['image_one']['name'] != ''){
					$image_one = image_upload_dir('image_one', '1600', '1200', '90', 'ipo/ipo_category/');
				}else{
					$image_one = $get_files->image_one;
				}				
				if($_FILES['image_two']['name'] != ''){
					$image_two = image_upload_dir('image_two', '1600', '1200', '90', 'ipo/ipo_category/');;
				}else{
					$image_two = $get_files->image_two;
				}				
				if($_FILES['image_three']['name'] != ''){
					$image_three = image_upload_dir('image_three', '1600', '1200', '90', 'ipo/ipo_category/');;
				}else{
					$image_three = $get_files->image_three;
				}
				
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $branch_id,
					'branch_name' => $branch_name->branch_name,
					'category_name' => $this->input->post('category_name'),
					'price' => $this->input->post('ipo_rate'),
					'ipo_profit' => $this->input->post('ipo_profit'),
					'referal_first_month' => $this->input->post('ipo_discount_first_month'),
					'referal_second_month' => $this->input->post('ipo_discount_secont_month'),
					'referal_third_month' => $this->input->post('ipo_discount_third_month'),
					'profit_first_month' => $this->input->post('referal_profit_first_month'),
					'profit_second_month' => $this->input->post('referal_profit_second_month'),
					'profit_third_month' => $this->input->post('referal_profit_third_month'),
					'image_one' => $image_one,
					'image_two' => $image_two,
					'image_three' => $image_three,						
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);		
				if($this->Dashboard_model->update('ipo_category',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('ipo_category',$where,'id','desc','row');
			}

			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('ipo_category',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	
			
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('ipo_category',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('ipo_category','','id','desc','result');
			$data['title_info'] = 'IPO Category Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/create/manage_agreement_type',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
		}
	}
	//---------End manage_agreement_type-------------
	
	
	
	
	
	//---------Start Manage manage_sub_category-------------
	public function manage_sub_category(){
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
					'sub_package_name' => $this->input->post('sub_package_name'),
					'booking_value' => $this->input->post('booking_value'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);				
				if($this->Dashboard_model->insert('sub_package_category',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'sub_package_name' => $this->input->post('sub_package_name'),
					'booking_value' => $this->input->post('booking_value'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);		
				if($this->Dashboard_model->update('sub_package_category',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('sub_package_category',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('sub_package_category',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}				
			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('sub_package_category',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			$condition = array('status' => '1');

			$data['table'] = $this->Dashboard_model->select('sub_package_category','','id','desc','result');
			$data['title_info'] = 'Sub Category Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_sub_category',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
		}
	}
	//---------End Manage manage_sub_category-------------
	//---------Start Manage Services-------------
	public function manage_services(){
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
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => '',
					'service_name' => $this->input->post('service_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('service_name');
				if($this->Dashboard_model->chaeck_data_b('services','service_name',$check)){
					alert('warning',''.$check.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('services',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'service_name' => $this->input->post('service_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('services',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('services',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('services',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('services',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('services','','id','desc','result');
			$data['title_info'] = 'Services Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/manage_services',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage Services-------------
	//---------Start Manage document type-------------
	public function document_type(){
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
					'document_type' => $this->input->post('document_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('document_type');
				if($this->Dashboard_model->chaeck_data_b('document_type','document_type',$check)){
					alert('warning',''.$check.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('document_type',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'document_type' => $this->input->post('document_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('document_type',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('document_type',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('document_type',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('document_type',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('document_type','','id','asc','result');
			$data['title_info'] = 'Document Type Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/document_type',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage document type-------------
	//---------Start Manage payment method-------------
	public function Payment_method(){
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
					'payment_method' => $this->input->post('payment_method'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('payment_method');
				if($this->Dashboard_model->chaeck_data_b('payment_method','payment_method',$check)){
					alert('warning',''.$check.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('payment_method',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'payment_method' => $this->input->post('payment_method'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('payment_method',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('payment_method',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('payment_method',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('payment_method',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('payment_method','','id','asc','result');
			$data['title_info'] = 'Payment method Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/payment_method',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage payment method-------------
	//---------Start card change Payment-------------
	public function card_change_amount(){
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
					'payment_method' => $this->input->post('payment_method'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('payment_method');
				if($this->Dashboard_model->chaeck_data_b('payment_method','payment_method',$check)){
					alert('warning',''.$check.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('payment_method',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'payment_method' => $this->input->post('payment_method'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('payment_method',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('payment_method',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('payment_method',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('payment_method',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('payment_method','','id','asc','result');
			$data['title_info'] = 'Payment Issue Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/card_change_amount',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End card change Payment-------------
	//---------Start checkout iteam-------------
	public function check_out_iteams(){
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
				if(isset($_POST['required'])){
					$required = 1;
				}else{
					$required = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $this->input->post('branch_id'),
					'branch_name' => $branch_name->branch_name,
					'checkout_iteam' => $this->input->post('checkout_iteam'),
					'lost_amount' => $this->input->post('lost_amount'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'required' => $required,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('checkout_iteam');
				//if($this->Dashboard_model->chaeck_data_b('checkout_iteam','checkout_iteam',$check)){
				//	alert('warning',''.$check.' is already exixt! Please try again');
				//	redirect(current_url());
				//}else{
					if($this->Dashboard_model->insert('checkout_iteam',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				//}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				if(isset($_POST['required'])){
					$required = 1;
				}else{
					$required = 0;
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => $this->input->post('update_id'),
					'branch_id' => $this->input->post('branch_id'),
					'branch_name' => $branch_name->branch_name,
					'checkout_iteam' => $this->input->post('checkout_iteam'),
					'lost_amount' => $this->input->post('lost_amount'),
					'note' => $this->input->post('note'),
					'required' => $required,
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('checkout_iteam',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('checkout_iteam',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('checkout_iteam',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('checkout_iteam',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('checkout_iteam','','id','asc','result');
			$data['title_info'] = 'CheckOut Iteam Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/check_out_iteams',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End checkout iteam-------------
	//---------Start json API create-------------
	public function api_json_api(){
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
					'table_name' => $this->input->post('table_name'),
					'security_cade' => $this->input->post('security_code'),
					'generated_link' => rahat_encode(base_url('json/data-information/'.rahat_encode($this->input->post('table_name')).'/'.$this->input->post('security_code').'')),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->insert('json_api_directory',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => '',
					'table_name' => $this->input->post('table_name'),
					'security_cade' => $this->input->post('security_code'),
					'generated_link' => rahat_encode(base_url('json/data-information/'.rahat_encode($this->input->post('table_name')).'/'.$this->input->post('security_code').'')),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('json_api_directory',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('json_api_directory',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('json_api_directory',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('json_api_directory',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['table_list'] = $this->Dashboard_model->table_list();
			
			$data['table'] = $this->Dashboard_model->select('checkout_iteam','','id','asc','result');
			$data['title_info'] = 'Json API Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/api_json_api',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End json API create-------------
	//---------Start Manage manage_payment_type type-------------
	public function manage_payment_type(){
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
					'payment_type' => $this->input->post('payment_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('payment_type');
				if($this->Dashboard_model->chaeck_data_b('payment_type','payment_type',$check)){
					alert('warning',''.$check.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('payment_type',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'payment_type' => $this->input->post('payment_type'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('payment_type',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('payment_type',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('payment_type',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('payment_type',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
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
			$data['table'] = $this->Dashboard_model->select('payment_type','','id','asc','result');
			$data['title_info'] = 'Payment Type Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/manage_payment_type',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage manage_payment_type type-------------
	
	//---------Start Manage software_learning_add_tutorials-------------
	public function software_learning_add_tutorials(){
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
					'type' => $this->input->post('type'),
					'title' => $this->input->post('title'),
					'tutorials_url' => $this->input->post('tutorials_url'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('title');
				if($this->Dashboard_model->chaeck_data_b('software_tutorials','title',$check)){
					alert('warning',''.$check.' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('software_tutorials',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'type' => $this->input->post('type'),
					'title' => $this->input->post('title'),
					'tutorials_url' => $this->input->post('tutorials_url'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('software_tutorials',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('software_tutorials',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('software_tutorials',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('software_tutorials',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			
			$data['table'] = $this->Dashboard_model->select('software_tutorials','','id','asc','result');
			$data['title_info'] = 'Software Learning Add Tutorials information Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/software_learning_add_tutorials',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage software_learning_add_tutorials-------------
	
	//---------Start Manage award_sales_award-------------
	public function award_sales_award(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$data['edit'] = $this->Dashboard_model->select('sales_award_price',array('id' => '1'),'id','desc','row');
			if(isset($_POST['update'])){					
				
				if(isset($_POST['status'])){ $status = 1; }else{ $status = 0; }
				if(isset($_POST['_1st_price'])){ $_1st_price = 1; }else{ $_1st_price = 0; }
				if(isset($_POST['_2nd_price'])){ $_2nd_price = 1; }else{ $_2nd_price = 0; }
				if(isset($_POST['_3rd_price'])){ $_3rd_price = 1; }else{ $_3rd_price = 0; }
				if(isset($_POST['_4th_price'])){ $_4th_price = 1; }else{ $_4th_price = 0; }
				if(isset($_POST['_5th_price'])){ $_5th_price = 1; }else{ $_5th_price = 0; }
				if(isset($_POST['sales_looser'])){ $sales_looser = 1; }else{ $sales_looser = 0; }

				
				$data = array(
					'id' => $this->input->post('update_id'),
					'last_day_price' => $this->input->post('last_day_price'),
					'last_day_point_limit' => $this->input->post('last_day_point_limit'),					
					'second_last_day' => $this->input->post('second_last_day'),					
					'second_last_day_point_limit' => $this->input->post('second_last_day_point_limit'),					
					'thired_last_day' => $this->input->post('thired_last_day'),					
					'thired_last_day_point_limit' => $this->input->post('thired_last_day_point_limit'),					
					'forth_last_day' => $this->input->post('forth_last_day'),					
					'forth_last_day_point_limit' => $this->input->post('forth_last_day_point_limit'),					
					'fifth_last_day' => $this->input->post('fifth_last_day'),					
					'fifth_last_day_point_limit' => $this->input->post('fifth_last_day_point_limit'),					
					'last_week_price' => $this->input->post('last_week_price'),					
					'last_week_point_limit' => $this->input->post('last_week_point_limit'),					
					'second_last_week' => $this->input->post('second_last_week'),					
					'second_last_week_point_limit' => $this->input->post('second_last_week_point_limit'),					
					'thired_last_week' => $this->input->post('thired_last_week'),					
					'thired_last_week_point_limit' => $this->input->post('thired_last_week_point_limit'),					
					'forth_last_week' => $this->input->post('forth_last_week'),					
					'forth_last_week_point_limit' => $this->input->post('forth_last_week_point_limit'),					
					'fifth_last_week' => $this->input->post('fifth_last_week'),					
					'fifth_last_week_point_limit' => $this->input->post('fifth_last_week_point_limit'),					
					'last_month_price' => $this->input->post('last_month_price'),					
					'last_month_point_limit' => $this->input->post('last_month_point_limit'),					
					'second_last_month' => $this->input->post('second_last_month'),					
					'second_last_month_point_limit' => $this->input->post('second_last_month_point_limit'),					
					'thired_last_month' => $this->input->post('thired_last_month'),					
					'thired_last_month_point_limit' => $this->input->post('thired_last_month_point_limit'),					
					'forth_last_month' => $this->input->post('forth_last_month'),					
					'forth_last_month_point_limit' => $this->input->post('forth_last_month_point_limit'),					
					'fifth_last_month' => $this->input->post('fifth_last_month'),					
					'fifth_last_month_point_limit' => $this->input->post('fifth_last_month_point_limit'),				
					
					'status' => $status,
					'_1st_price' => $_1st_price,
					'_2nd_price' => $_2nd_price,
					'_3rd_price' => $_3rd_price,
					'_4th_price' => $_4th_price,
					'_5th_price' => $_5th_price,
					'sales_looser' => $sales_looser,
					
					'note' => $this->input->post('note'),
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('sales_award_price',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$data['title_info'] = 'Sales Award Configuration';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/award_sales_award',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage award_sales_award-------------
	
	//---------Start Manage employee_ipo_commission_setup-------------
	public function employee_ipo_commission_setup(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$data['edit'] = $this->Dashboard_model->select('employee_ipo_commmission',array('id' => '1'),'id','desc','row');
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'commission_percentage' => $this->input->post('commission_percentage'),					
					'status' => $status,
					'note' => $this->input->post('note'),
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('employee_ipo_commmission',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$data['title_info'] = 'Employee IPO Commission Percentage Configuration';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/employee_ipo_commission_setup',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage employee_ipo_commission_setup-------------


	public function badge_award(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$data['badge_award'] = $this->Dashboard_model->mysqlii("SELECT * FROM badge_awards ORDER BY level ASC");
			$data['max_award_level'] = $this->Dashboard_model->mysqlii("SELECT MAX(level) as last_level FROM badge_awards");
			$data['how_many'] = $this->Dashboard_model->mysqlii("SELECT count(id) as how_many FROM badge_awards");

			if(isset($_POST['badge_level'])){
				$male_image = image_upload_dir('male_badge_image', '1600', '1200', '90', 'badge/');
				$female_image = image_upload_dir('female_badge_image', '1600', '1200', '90', 'badge/');

				$data = array(
					'level' => $this->input->post('badge_level'),
					'point_from' => $this->input->post('badge_minimum_point'),
					'point_up_to' => $this->input->post('badge_maximum_point'),
					'male_badge_image_path' => $male_image,
					'female_badge_image_path' => $female_image,
				);

				if($this->Dashboard_model->insert('badge_awards',$data)){
					alert('success','Save Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}else if(isset($_POST['badge_level_edited'])){
				for($count = 0 ; $count <  $_POST['how_many']; $count++ ){

					if(!empty($_FILES["male_badge_edited_emage"]['name'][$count])){
						$male_image_tmpFilePath = $_FILES['male_badge_edited_emage']['tmp_name'][$count];
						$male_image = "assets/uploads/badge/".date('d-m-Y-H-i-s').$_FILES['male_badge_edited_emage']['name'][$count];
						$male_image_filePath = "assets/uploads/badge/".date('d-m-Y-H-i-s').$_FILES['male_badge_edited_emage']['name'][$count];
						move_uploaded_file($male_image_tmpFilePath, $male_image_filePath);
					}

					if(!empty($_FILES["female_badge_edited_emage"]['name'][$count])){
						$female_image_tmpFilePath = $_FILES['female_badge_edited_emage']['tmp_name'][$count];
						$female_image = "assets/uploads/badge/".date('d-m-Y-H-i-s').$_FILES['female_badge_edited_emage']['name'][$count];
						$female_image_filePath = "assets/uploads/badge/".date('d-m-Y-H-i-s').$_FILES['female_badge_edited_emage']['name'][$count];
						move_uploaded_file($female_image_tmpFilePath, $female_image_filePath);
					}
					
					if(empty($_FILES["male_badge_edited_emage"]['name'][$count])){
						$male_image = $_POST['previous_male_badge_image_link_edited'][$count];
					}

					if(empty($_FILES["female_badge_edited_emage"]['name'][$count])){
						$female_image = $_POST['previous_female_badge_image_link_edited'][$count];
					}

					$level = $_POST['badge_level_edited'][$count];
					$point_start = $_POST['badge_min_point_edited'][$count];
					$point_end = $_POST['badge_max_point_edited'][$count];

					$data = array(
						'level' => $level,
						'point_from' => $point_start,
						'point_up_to' => $point_end,
						'male_badge_image_path' => $male_image,
						'female_badge_image_path' => $female_image,
					);

					$id = $_POST['update_id'][$count];
					$this->Dashboard_model->update('badge_awards',$data,$id);
				}
					alert('success','Updated Successfully!');
					redirect(current_url());
			}

			$data['title_info'] = 'Badge Award';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/badge_award',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	//---------Start Manage member_referal_award-------------
	public function member_referal_award(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$data['edit'] = $this->Dashboard_model->select('member_referal_award',array('id' => '1'),'id','desc','row');
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'amount' => $this->input->post('amount'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('member_referal_award',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$data['title_info'] = 'Member Referal Award';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/member_referal_award',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage award_sales_award-------------
	
	//---------Start Manage investor_facilities_setup-------------
	public function investor_facilities_setup(){
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
					'card_no' => $this->input->post('card_no'),
					'tea_coffee' => $this->input->post('tea_coffee'),
					'drinks' => $this->input->post('drinks'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('Y/m/d')
				);
				if($this->Dashboard_model->insert('investor_facilities_setup',$data)){
					alert('success','Save Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			if(isset($_POST['update'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'card_no' => $this->input->post('card_no'),
					'tea_coffee' => $this->input->post('tea_coffee'),
					'drinks' => $this->input->post('drinks'),
					'status' => $status,
				);
				if($this->Dashboard_model->update('investor_facilities_setup',$data,$this->input->post('update_id'))){
					alert('success','Save Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			if(isset($_POST['edit'])){
				$data['edit'] = $this->Dashboard_model->select('investor_facilities_setup',array('card_no' => $_POST['card_number_edit']),'id','desc','row');
			}
			$data['investor_infos'] = $this->Dashboard_model->mysqlii("SELECT investor_facilities_setup.*, ipo_member_directory.personal_full_name FROM investor_facilities_setup INNER JOIN ipo_member_directory on ipo_member_directory.card_number = investor_facilities_setup.
			card_no");
			foreach($data['investor_infos'] as $idx=>$investor_info){
				$uploader = explode('___',$investor_info->uploader_info);
				$uploader_name = $this->Dashboard_model->mysqlij("SELECT full_name from employee where email = '".$uploader[1]."'");
				$data['investor_infos'][$idx]->uploader_name = $uploader_name->full_name;
			}
			$data['title_info'] = 'investor_facilities_setup'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/investor_facilities_setup',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//---------End Manage investor_facilities_setup-------------
	
	//---------Start Manage network_router_configuration-------------
	public function network_router_configuration(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{			
			$data['title_info'] = 'Network Router Configuration';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/network_router_configuration',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage network_router_configuration-------------
	
	
	//---------Start Manage network_graph_configuration-------------
	public function network_graph_configuration(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			if(isset($_POST['save'])){
				$update_data = array(
					'ip_address' => $this->input->post('ip_address'),
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
					'max_speed' => $this->input->post('max_speed'),
					'interface' => $this->input->post('interface')
				);
				if($this->Dashboard_model->update('graph_config',$update_data,'1')){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$data['info'] = $this->Dashboard_model->select('graph_config',array('status' => '1'),'id','desc','row');
			$data['title_info'] = 'Network Graph Configuration';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/network_graph_configuration',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End Manage network_graph_configuration-------------
	
	
	//---------Start add_refreshment_item-------------
	public function add_refreshment_item(){
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
				
				if(isset($_POST['welcome_tea'])){
					$welcome_tea = 1;
				}else{
					$welcome_tea = 0;
				}
				
				if(isset($_POST['facebook_winner'])){
					$facebook_winner = 1;
				}else{
					$facebook_winner = 0;
				}
				if($_FILES['item_picture']['name'] != ''){
					$item_picture = image_upload('item_picture','80','80','80');
				}else{
					$item_picture = '';
				}
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $this->input->post('branch_id'),
					'code' => md5(time()),
					'branch_name' => $branch_name->branch_name,
					'item_name' => $this->input->post('item_name'),
					'item_picture' => $item_picture,
					'price' => $this->input->post('price'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'welcome_tea' => $welcome_tea,
					'facebook_winner' => $facebook_winner,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$condition = array(
					'branch_id' => $this->input->post('branch_id'),
					'item_name' => $this->input->post('item_name')
				);
				$check = $this->Dashboard_model->select('refreshment_item',$condition,'id','desc','row');
				if(!empty($check->id)){
					alert('warning',''.$this->input->post('item_name').' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('refreshment_item',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){					
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				if(isset($_POST['welcome_tea'])){
					$welcome_tea = 1;
				}else{
					$welcome_tea = 0;
				}
				
				if(isset($_POST['facebook_winner'])){
					$facebook_winner = 1;
				}else{
					$facebook_winner = 0;
				}
				$get_image = $this->Dashboard_model->select('refreshment_item',array( 'id' => $this->input->post('update_id')),'id','desc','row');
				if($_FILES['item_picture']['name'] != ''){
					$item_picture = image_upload('item_picture','80','80','80');
				}else{
					$item_picture = $get_image->item_picture;
				}				
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$data = array(
					'branch_id' => $this->input->post('branch_id'),
					'code' => md5(time()),
					'branch_name' => $branch_name->branch_name,
					'item_name' => $this->input->post('item_name'),
					'item_picture' => $item_picture,
					'price' => $this->input->post('price'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'welcome_tea' => $welcome_tea,
					'facebook_winner' => $facebook_winner,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('refreshment_item',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('refreshment_item',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('refreshment_item',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('refreshment_item',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['banches'] = $this->Dashboard_model->select('branches',$condition,'id','ASC','result');
			$data['table'] = $this->Dashboard_model->select('refreshment_item','','id','asc','result');
			$data['title_info'] = 'Refreshment Item Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/create/add_refreshment_item',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End add_refreshment_item-------------
	//---------Start music_player_add_audio-------------
	public function music_player_add_audio(){
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
				if($_FILES['track_picture']['name'] != ''){
					$track_picture = image_upload('track_picture','700','700','80');
				}else{
					$track_picture = '';
				}
				if(!empty($_FILES['mp3_file']['name'])){
					$mp3_file = file_upload('mp3_file');
				}else{
					$mp3_file = '';
				}
				$from = explode(':',$this->input->post('play_time'));
				$to = explode(':',$this->input->post('play_time_to'));
				$data = array(
					'id' => '',
					'albume_name' => $this->input->post('albume_name'),
					'track_name' => $this->input->post('track_name'),
					'track_picture' => $track_picture,
					'mp3_file' => $mp3_file,
					'play_time' => $this->input->post('play_time'),
					'play_time_to' => $this->input->post('play_time_to'),					
					'h_from' => $from[0].$from[1],
					'm_from' => $from[1],
					'h_to' => $to[0].$to[1],
					'm_to' => $to[1],					
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$condition = array(
					'albume_name' => $this->input->post('albume_name'),
					'track_name' => $this->input->post('track_name')
				);
				$check = $this->Dashboard_model->select('audio_files',$condition,'id','desc','row');
				if(!empty($check->id)){
					alert('warning',''.$this->input->post('track_name').' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('audio_files',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){
				$condition = array(
					'id' => $this->input->post('update_id')
				);
				$check = $this->Dashboard_model->select('audio_files',$condition,'id','desc','row');
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				if($_FILES['track_picture']['name'] != ''){
					$track_picture = image_upload('track_picture','700','700','80');
				}else{
					$track_picture = $check->track_picture;
				}
				if(!empty($_FILES['mp3_file']['name'])){
					$mp3_file = file_upload('mp3_file');
				}else{
					$mp3_file = $check->mp3_file;
				}	
				$from = explode(':',$this->input->post('play_time'));
				$to = explode(':',$this->input->post('play_time_to'));
				$data = array(
					'albume_name' => $this->input->post('albume_name'),
					'track_name' => $this->input->post('track_name'),
					'track_picture' => $track_picture,
					'mp3_file' => $mp3_file,
					'play_time' => $this->input->post('play_time'),
					'play_time_to' => $this->input->post('play_time_to'),
					'h_from' => $from[0].$from[1],
					'm_from' => $from[1],
					'h_to' => $to[0].$to[1],
					'm_to' => $to[1],	
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('audio_files',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('audio_files',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('audio_files',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('audio_files',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['table'] = $this->Dashboard_model->select('audio_files','','id','asc','result');
			$data['title_info'] = 'Add Audio File';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/music_player_add_audio',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End music_player_add_audio-------------
	
	
	//---------Start front_door_add_door_ips-------------
	public function front_door_add_door_ips(){
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
				$branch_info = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','desc','row');
				$data = array(
					'id' => '',
					'branch_id' => $branch_info->branch_id,
					'branch_name' => $branch_info->branch_name,
					'ip_address' => $this->input->post('ip_address'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				$condition = array(
					'ip_address' => $this->input->post('ip_address'),
					'branch_id' => $this->input->post('branch_id')
				);
				$check = $this->Dashboard_model->select('entrance_gate_ip_address',$condition,'id','desc','row');
				if(!empty($check->id)){
					alert('warning',''.$this->input->post('ip_address').' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('entrance_gate_ip_address',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){
				$condition = array(
					'id' => $this->input->post('update_id')
				);
				$check = $this->Dashboard_model->select('entrance_gate_ip_address',$condition,'id','desc','row');
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}	
				$branch_info = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','desc','row');
				$data = array(
					'branch_id' => $branch_info->branch_id,
					'branch_name' => $branch_info->branch_name,
					'ip_address' => $this->input->post('ip_address'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('entrance_gate_ip_address',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('entrance_gate_ip_address',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('entrance_gate_ip_address',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('entrance_gate_ip_address',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$data['banches'] = $this->Dashboard_model->select('branches','','id','asc','result');
			$data['table'] = $this->Dashboard_model->select('entrance_gate_ip_address','','id','asc','result');
			$data['title_info'] = 'Add Entrance Dsoor Lock IP Addresses';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/front_door_add_door_ips',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End front_door_add_door_ips-------------
	
	
	
	//---------Start music_player_add_video-------------
	public function music_player_add_video(){
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
				$from = explode(':',$this->input->post('play_time'));
				$to = explode(':',$this->input->post('play_time_to'));
				$data = array(
					'id' => '',
					'video_url' => $this->input->post('video_url'),	
					'play_time' => $this->input->post('play_time'),
					'play_time_to' => $this->input->post('play_time_to'),
					'h_from' => $from[0].$from[1],
					'h_to' => $to[0].$to[1],				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				$condition = array(
					'video_url' => $this->input->post('video_url')
				);
				$check = $this->Dashboard_model->select('music_videos',$condition,'id','desc','row');
				if(!empty($check->id)){
					alert('warning',''.$this->input->post('video_url').' is already exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('music_videos',$data)){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			
			if(isset($_POST['update'])){
				$condition = array(
					'id' => $this->input->post('update_id')
				);
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}	
				$from = explode(':',$this->input->post('play_time'));
				$to = explode(':',$this->input->post('play_time_to'));
				$data = array(
					'video_url' => $this->input->post('video_url'),			
					'h_from' => $from[0].$from[1],
					'h_to' => $to[0].$to[1],				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);	
				if($this->Dashboard_model->update('music_videos',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('music_videos',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('music_videos',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('music_videos',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['table'] = $this->Dashboard_model->select('music_videos','','id','asc','result');
			$data['title_info'] = 'Add Video URL';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/music_player_add_video',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End music_player_add_video-------------
	//---------Start add_electrict_bill-------------
	public function add_electrict_bill(){
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
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));

				$selected_date = new DateTime($this->input->post('selected_month') . '-01');
				$validate_generated = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branches_revenue_rank where month = '".$selected_date->format('Y-m')."'");
				if($validate_generated->id_count > 0){
					alert('warning','This month Rank Already Generated!');
					redirect(current_url());
				}

				$validate_existing = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branch_elictric_bill where month_year = '".$selected_date->format('m/Y')."'");
				if($validate_existing->id_count > 0){
					alert('warning','This month bill already exists!');
					redirect(current_url());
				}

				$data = array(
					'id' => '',
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->insert('branch_elictric_bill',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));
				$data = array(
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('branch_elictric_bill',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('branch_elictric_bill',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('branch_elictric_bill',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('branch_elictric_bill',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['banches'] = $this->Dashboard_model->select('branches','','id','asc','result');
			$data['table'] = $this->Dashboard_model->select('branch_elictric_bill','','id','asc','result');
			$data['title_info'] = 'Add Electricity Bill';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/add_electrict_bill',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End add_electrict_bill-------------

	//---------Start add_electrict_bill-------------
	public function add_house_rent(){
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
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));

				$selected_date = new DateTime($this->input->post('selected_month') . '-01');
				$validate_generated = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branches_revenue_rank where month = '".$selected_date->format('Y-m')."'");
				if($validate_generated->id_count > 0){
					alert('warning','This month Rank Already Generated!');
					redirect(current_url());
				}

				$validate_existing = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branch_house_rent where month_year = '".$selected_date->format('m/Y')."'");
				if($validate_existing->id_count > 0){
					alert('warning','This month bill already exists!');
					redirect(current_url());
				}

				$data = array(
					'id' => '',
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->insert('branch_house_rent',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));
				$data = array(
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('branch_house_rent',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('branch_house_rent',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('branch_house_rent',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('branch_house_rent',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['banches'] = $this->Dashboard_model->select('branches','','id','asc','result');
			$data['title_info'] = 'Add House Rent';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/add_house_rent',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End add_electrict_bill-------------

	
	//---------Start add_electrict_bill-------------
	public function add_water_bill(){
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
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));

				$selected_date = new DateTime($this->input->post('selected_month') . '-01');
				$validate_generated = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branches_revenue_rank where month = '".$selected_date->format('Y-m')."'");
				if($validate_generated->id_count > 0){
					alert('warning','This month Rank Already Generated!');
					redirect(current_url());
				}

				$validate_existing = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branch_water_bill where month_year = '".$selected_date->format('m/Y')."'");
				if($validate_existing->id_count > 0){
					alert('warning','This month bill already exists!');
					redirect(current_url());
				}

				$data = array(
					'id' => '',
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->insert('branch_water_bill',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));
				$data = array(
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('branch_water_bill',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('branch_water_bill',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('branch_water_bill',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('branch_water_bill',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['banches'] = $this->Dashboard_model->select('branches','','id','asc','result');
			$data['title_info'] = 'Add Water Bill';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/add_water_bill',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End add_electrict_bill-------------


	//---------Start add_electrict_bill-------------
	public function add_internet_bill(){
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
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));

				$selected_date = new DateTime($this->input->post('selected_month') . '-01');
				$validate_generated = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branches_revenue_rank where month = '".$selected_date->format('Y-m')."'");
				if($validate_generated->id_count > 0){
					alert('warning','This month Rank Already Generated!');
					redirect(current_url());
				}

				$validate_existing = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branch_internet_bill where month_year = '".$selected_date->format('m/Y')."'");
				if($validate_existing->id_count > 0){
					alert('warning','This month bill already exists!');
					redirect(current_url());
				}

				$data = array(
					'id' => '',
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->insert('branch_internet_bill',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));
				$data = array(
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('branch_internet_bill',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('branch_internet_bill',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('branch_internet_bill',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('branch_internet_bill',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['banches'] = $this->Dashboard_model->select('branches','','id','asc','result');
			$data['title_info'] = 'Add Internet Bill';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/add_internet_bill',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End add_electrict_bill-------------

	//---------Start add_electrict_bill-------------
	public function add_food_cost(){
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
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));

				$selected_date = new DateTime($this->input->post('selected_month') . '-01');
				$validate_generated = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branches_revenue_rank where month = '".$selected_date->format('Y-m')."'");
				if($validate_generated->id_count > 0){
					alert('warning','This month Rank Already Generated!');
					redirect(current_url());
				}

				$validate_existing = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branch_food_cost where month_year = '".$selected_date->format('m/Y')."'");
				if($validate_existing->id_count > 0){
					alert('warning','This month bill already exists!');
					redirect(current_url());
				}

				$data = array(
					'id' => '',
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->insert('branch_food_cost',$data)){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			
			if(isset($_POST['update'])){
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$branch = $this->Dashboard_model->select('branches',array('branch_id' => $this->input->post('branch_id')),'id','asc','row');
				$date = explode('-',$this->input->post('selected_month'));
				$data = array(
					'branch_id' => $branch->branch_id,	
					'branch_name' => $branch->branch_name,
					'month' => $date[1],
					'year' => $date[0],
					'month_year' => $date[1].'/'.$date[0],				
					'amount' => $this->input->post('amount'),				
					'note' => $this->input->post('note'),
					'status' => $status,
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->update('branch_food_cost',$data,$this->input->post('update_id'))){
					alert('success','Update Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}			
			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('branch_food_cost',$where,'id','desc','row');
			}
			
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('branch_food_cost',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}	

			if(isset($_POST["delete_id"])){
				$id = implode(',',$_POST["delete_id"]);
				if($this->Dashboard_model->delete_batch('branch_food_cost',$id)){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$condition = array('status' => '1');
			$data['banches'] = $this->Dashboard_model->select('branches','','id','asc','result');
			$data['title_info'] = 'Add Food Cost';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/booking/create/add_food_cost',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
	
		}
	}
	//---------End add_electrict_bill-------------

}