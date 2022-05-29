<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->helper('url');
        $this->load->library("pagination");
	}
	
	public function app_login()
	{
		$challenge = array(
			'token' => $_COOKIE['token'],
			'status' => 1
		);
		$get_data = $this->Dashboard_model->select('app_desktop_login_token', $challenge,'id','desc','row');
		if(!is_null($get_data)){
			$employee = $this->Dashboard_model->mysqlij("SELECT * from employee where employee_id = ".$get_data->employee_id);
			$branch_info = $this->Dashboard_model->mysqlij("SELECT * from branches where branch_id = '".$employee->branch."'");

			$email = $employee->email;
			$user_type = $employee->role_name;
			$role_id = $employee->role;
			$branch_id = $employee->branch;
			$employee_id = $employee->id;
			$employee_ids = $employee->employee_id;
			// $last_login_otp = array(
			// 	'id' => '',
			// 	'employee_id' => $employee->employee_id,
			// 	'last_otp' => $post_otp,
			// 	'time' => time_full(),
			// 	'date' => data()
			// );
			$session_data = array(
				'user_type' => $user_type,
				'role_id' => $role_id,
				'branch' => $branch_id,
				'email' => $email,
				'employee_id' => $employee_id,
				'employee_ids' => $employee_ids
			);
			$user_info = array(
				'user' => $employee->full_name,
				'employee_id' => $employee->id,
				'branch_name' => $branch_info->branch_name,
				'd_head' => $employee->d_head,
				'department' => $employee->department,
				'designation' => $employee->designation
			);
			$_SESSION['super_admin'] = $session_data;
			$_SESSION['user_info'] = $user_info;

			$login_data_to_db = array(
				'id' => '',
				'type' => 'login_success',
				'employee_id' => $employee->employee_id,
				'ip_address' => get_client_ip(),
				'device_info' => getDeviceInfo(),
				'time' => time_full(),
				'data' => data()
			);
			$this->Dashboard_model->insert('login_info',$login_data_to_db);
			// $this->Dashboard_model->mysqlij("INSERT INTO `login_info`(`type`, `employee_id`, `ip_address`, `device_info`, `time`, `data`) VALUES ('login_success', '".$employee['employee_id']."', '".get_client_ip()."', '".getDeviceInfo()."', '".time_full()."', '".data()."')");
			
			setcookie("token", "", time() - 3600);

			redirect(base_url('admin'));
		}

		redirect(base_url('admin'));
	}

	public function login(){
		$data = array();
		if(isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin'));
		}else{
			if(isset($_POST['login'])){
				$set_employee_id = 0;
				if(!empty($_POST['lock_screen_login']) AND rahat_decode(rahat_decode($_POST['lock_screen_login'])) == 'true' ){
					$set_employee_id = 1;
				}else{
					if(!empty($_SESSION['set_employee_id'])){
						$set_employee_id = 1;
					}else{
						$set_employee_id = 0;
					}
				}			
				if($set_employee_id == 1){
					$get_otp = rahat_decode($_SESSION['set_employee_id']['employee_opt']);
					$post_otp = $this->input->post('sms_otp');
					$get_otp = '1111';
					$post_otp = '1111';
					if(!empty($_POST['employee_id'])){
						$get_employee_id = rahat_decode(rahat_decode($_POST['employee_id']));
						$get_password = $this->Dashboard_model->select('employee',array('employee_id' => $get_employee_id),'id','desc','row');
						$password = $get_password->password;
					}else{
						$get_employee_id = rahat_decode($_SESSION['set_employee_id']['employee_id']);
						$pass = $this->input->post('password');
						$password = md5($pass);
					}	
					if(!empty($_POST['lock_screen_login']) AND rahat_decode(rahat_decode($_POST['lock_screen_login'])) == 'true' ){
						$get_last_otp = $this->Dashboard_model->select('employee_last_login_otp',array('employee_id' => $get_employee_id),'id','desc','row');
						if(!empty($get_last_otp) AND $get_last_otp->last_otp == $_POST['last_otp']){
							$otp_info = 1;
							$post_otp = $_POST['last_otp'];
						}else{
							$otp_info = 0;
						}						
					}else{
						if($get_otp == $post_otp){
							$otp_info = 1;
						}else{
							$otp_info = 0;
						}
					}				
					if($otp_info == 1){									
						$employee_id = $get_employee_id;						
						$employee_info = $this->Dashboard_model->select('employee',array('employee_id' => $employee_id),'id','desc','row');
						$employe_id = $employee_info->employee_id;						
						$chellenge = array(
							'employee_id' => $employe_id,
							// 'password' => $password,
							'status' => 1
						);				
						$get_data = $this->Dashboard_model->select('employee',$chellenge,'id','desc','row');
						$chellenge_1 = array(
							'role_id' => $get_data->role,
							'status' => 1
						);
						$get_role = $this->Dashboard_model->select('roles',$chellenge_1,'id','desc','row');
						$branch_info = $this->Dashboard_model->select('branches',array('branch_id' => $get_data->branch),'id','desc','row');
						if(!empty($get_data->id) AND !empty($get_data->email) AND !empty($get_role->status)){
							$login_data_to_db = array(
								'id' => '',
								'type' => 'login_success',
								'employee_id' => $get_data->employee_id,
								'ip_address' => get_client_ip(),
								'device_info' => getDeviceInfo(),
								'time' => time_full(),
								'data' => data()
							);
							$last_login_otp = array(
								'id' => '',
								'employee_id' => $get_data->employee_id,
								'last_otp' => $post_otp,
								'time' => time_full(),
								'date' => data()
							);
							if(
								$this->Dashboard_model->insert('login_info',$login_data_to_db) AND
								$this->Dashboard_model->insert('employee_last_login_otp',$last_login_otp)
							){
								$email = $get_data->email;
								$user_type = $get_data->role_name;
								$role_id = $get_data->role;
								$branch_id = $get_data->branch;
								$employee_id = $get_data->id;
								$employee_ids = $get_data->employee_id;
								$session_data = array(
									'user_type' => $user_type,
									'role_id' => $role_id,
									'branch' => $branch_id,
									'email' => $email,
									'employee_id' => $employee_id,
									'employee_ids' => $employee_ids
								);
								$user_info = array(
									'user' => $get_data->full_name,
									'employee_id' => $get_data->id,
									'branch_name' => $branch_info->branch_name,
									'd_head' => $get_data->d_head,
									'department' => $get_data->department,
									'designation' => $get_data->designation
								);
								$_SESSION['super_admin'] = $session_data;
								$_SESSION['user_info'] = $user_info;
								unset($_SESSION['set_employee_id']);						
								unset($_SESSION['employee_lock_screen_id']);						
								alert('success','Successfully Login!');
								redirect(base_url('admin'));
							}else{								
								alert('danger','Something Wrong! Please Try Again');
								redirect(current_url());
							}						
						}else{
							$login_data_to_db = array(
								'id' => '',
								'type' => 'login_failed',
								'employee_id' => rahat_decode($_SESSION['set_employee_id']['employee_id']),
								'ip_address' => get_client_ip(),
								'device_info' => getDeviceInfo(),
								'time' => time_full(),
								'data' => data()
							);
							if($this->Dashboard_model->insert('login_info',$login_data_to_db)){
								alert('danger','Employee ID or Password wrong. Please try again!');
								redirect(base_url('admin/login'));
							}else{
								alert('danger','Something Wrong! Please Try Again');
								redirect(current_url());
							}							
						}
					}else{
						$login_data_to_db = array(
							'id' => '',
							'type' => 'otp_failed',
							'employee_id' => rahat_decode($_SESSION['set_employee_id']['employee_id']),
							'ip_address' => get_client_ip(),
							'device_info' => getDeviceInfo(),
							'time' => time_full(),
							'data' => data()
						);
						if($this->Dashboard_model->insert('login_info',$login_data_to_db)){
							alert('danger','Your Login OTP is wrong! Please Try again');
							redirect(base_url('admin/login'));
						}else{
							alert('danger','Something Wrong! Please Try Again');
							redirect(current_url());
						}						
					}
				}else{
					unset($_SESSION['set_employee_id']);
					alert('danger','Your Login OTP is Expired! Please Try Again');
					redirect(base_url('admin/login'));
				}
				
				
				
			}
			if(isset($_POST['set_employee_id'])){
				$employee_info = $this->Dashboard_model->select('employee',array('employee_id' => $this->input->post('employee_id'), 'status' => '1'),'id','desc','row');
				if(!empty($employee_info->employee_id)){
					if(!empty($employee_info->personal_Phone)){
						$otp = 'i-'.rand(1111,9999);
						$number = $employee_info->personal_Phone;
						$message = 'Neways Login Credential: '.$otp.'';
						if(otp_sendsms($number,$message)){
							$user_otp = array(
								'employee_id' => rahat_encode($employee_info->employee_id),
								'employee_photo' => rahat_encode($employee_info->photo),
								'employee_opt' => rahat_encode($otp)
							);
							$_SESSION['set_employee_id'] = $user_otp;
							alert('success','Login OTP sended successfully to your phone number. ');
							redirect(base_url('admin/login'));
						}else{
							alert('danger','Something Wrong to send OTP! Please Try again');
							redirect(base_url('admin/login'));
						}					
					}else{
						alert('danger','Your Phone Number is not Found! Please Contact with HR Department');
						redirect(base_url('admin/login'));
					}					
				}else{
					alert('danger','EmployeeID not found in our record! Please Try Again');
					redirect(base_url('admin/login'));
				}
			}
			if(!empty($_SESSION['employee_lock_screen_id'])){
				$this->load->view('lockscreen',$data);
			}else{
				if(!empty($_SESSION['set_employee_id'])){
					$this->load->view('login',$data);
				}else{
					$this->load->view('login_employee_id',$data);
				}	
			}	
		}
	}
	
	public function lockscreen(){
		$data = array();
		$this->load->view('lockscreen',$data);
	}
	
	public function forgot_password(){
		$data = array();
		if(isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin'));
		}else{
			if(isset($_POST['request_new_password'])){
				$employe_id = $this->input->post('employee_id');
				$phone_number = $this->input->post('phone_number');
				$chellenge = array( 'employee_id' => $employe_id ,);
				$employee_info = $this->Dashboard_model->select('employee',$chellenge,'id','desc','row');
				if(!empty($employee_info->id)){
					if($employee_info->status == 1){
						if($employee_info->personal_Phone == $phone_number){
							$number = $phone_number;
							$eryp = rahat_encode($number.'___'.$employee_info->id);
							$message = $employee_info->full_name.', Request for password change link is :'.base_url('generated_forgot_password_link/'.$eryp.'').' N:B: Do not share it with any body. After change your password Please delete this message';
							if(otp_sendsms($number,$message)){
								$login_data_to_db = array(
									'id' => '',
									'type' => 'forgot_success',
									'employee_id' => $employee_info->employee_id,
									'ip_address' => get_client_ip(),
									'device_info' => getDeviceInfo(),
									'time' => time_full(),
									'data' => data()
								);
								if($this->Dashboard_model->insert('login_info',$login_data_to_db)){
									alert('success','Successfully Generate Password Changing Link & Send it to you by sms, Do not share it');
									redirect(current_url());
								}else{
									alert('danger','Something Wrong! Please Try Again');
									redirect(current_url());
								}								
							}else{
								alert('danger','Something Wong in SMS Section. Please Contact with IT Department / Try Again After Some time');
								redirect(current_url());
							}
						}else{
							alert('danger','Your Phone Number dose not match with your employee information, Please Contact With HRM Department / Try Again After Some time');
							redirect(current_url());
						}
					}else{
						alert('danger','You are no longar Employee of ours! For additional information Please Contact With HRM Department / Try Again After Some time');
						redirect(current_url());
					}
				}else{
					alert('danger','Your Information Not Found! Please Contact With HRM Department / Try Again After Some time');
					redirect(current_url());					
				}
			}
			$this->load->view('forgot_password');
		}
	}
	
	public function generated_forgot_password_link( $get_id = ''){
		$data = array();
		if(isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin'));
		}else{
			if(isset($_POST['change_password'])){
				$emp_id = $this->input->post('employee_id');
				$phn_nmbr = $this->input->post('phone_number');
				$new_pass = $this->input->post('new_password');
				$conf_pass = $this->input->post('confirm_password');
				if($new_pass == $conf_pass){
					$data = array(
						'password' => md5($new_pass)
					);
					if($this->Dashboard_model->update('employee',$data,$emp_id)){
						alert('success','Password Changed Successfully!');
						redirect(base_url('admin'));
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}else{
					alert('danger','New Password & Confirm Password Dose Not Match! Please Try Again');
					redirect(current_url());
				}				
			}
		}
		$get_link_id = explode('___',rahat_decode($get_id));
		$phone_number = $get_link_id[0];
		$employee_id = $get_link_id[1];
		$data['phone_number'] = $phone_number; 
		$data['employee_id'] = $employee_id; 
		$this->load->view('reset_password',$data,'');
	}
	
	public function logout(){
		$login_data_to_db = array(
			'id' => '',
			'type' => 'logout_success',
			'employee_id' => $_SESSION['super_admin']['employee_ids'],
			'ip_address' => get_client_ip(),
			'device_info' => getDeviceInfo(),
			'time' => time_full(),
			'data' => data()
		);
		if($this->Dashboard_model->insert('login_info',$login_data_to_db)){
			unset($_SESSION['super_admin']);
			unset($_SESSION['user_info']);
			unset($_SESSION['dingtalk_video_tutorials']);
			unset($_SESSION['software_video_tutorials']);
			unset($_SESSION['set_employee_id']);
			unset($_SESSION['employee_lock_screen_id']);
			alert('success','Successfully Logout!');
			redirect(base_url('admin'));
		}else{
			alert('danger','Something Wrong! Please Try Again');
			redirect(current_url());
		}
	}
	
	public function index(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			$data['title_info'] = 'Home';
			$data['notification_popup'] = '1';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('include/home',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}

	public function dashboard(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
			if(empty($_SESSION['software_video_tutorials'])){
				$_SESSION['software_video_tutorials'] = $this->Dashboard_model->mysqlii("select * from software_tutorials where type = 'Software' and status = '1'");
				$_SESSION['dingtalk_video_tutorials'] = $this->Dashboard_model->mysqlii("select * from software_tutorials where type = 'Dingtalk' and status = '1'");
			}
				
			if(isset($_POST['dashboard_bbranch_id'])){
				$form_branch_id = $_POST['dashboard_bbranch_id'];
				$data['drop_down_v_id'] = $_POST['dashboard_bbranch_id'];
			}else{
				$form_branch_id = '';
				$data['drop_down_v_id'] = '';
			}			
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){  // SUPER ADMIN=============
				if(!empty($form_branch_id)){
					$branches = "and branch_id = '".$form_branch_id."'";
					$branchewos = "WHERE branch_id = '".$form_branch_id."'";
					$pck_branches = "where branch_id = '".$form_branch_id."'";
					$pck_branches_monthly = "WHERE branch_id = '".$form_branch_id."' AND data LIKE '%".date('m/Y')."%'";
				}else{
					$branches = "";
					$branchewos = "";
					$pck_branches = "";
					$pck_branches_monthly = "WHERE data LIKE '%".date('m/Y')."%'";
				}
				$data['booked_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '2' $branches");
				$data['booked_member_dsh'] = $this->Dashboard_model->con_count('member_directory',"status = '1' and card_number = 'Unauthorized' $branches");
				
				$data['abail_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '0' $branches");
				$data['out_of_service'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '6' $branches");
				$data['number_of_disabled'] = $this->Dashboard_model->con_count('beds',"status = '0' $branches");
				$data['number_of_employee'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '5' $branches");
				
				$data['total_number_of_bed'] = $this->Dashboard_model->con_count('beds',"id != 0 $branches");
				$data['rfc_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '4' $branches");
				$data['ocp_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '3' $branches");
				
				$data['banches'] = $this->Dashboard_model->select('branches',array('status'=>'1'),'id','ASC','result');
						
				//-------------------
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
				if($ides_branch == '1'){	// BRNCH ADMIN =======================				
					if(!empty($form_branch_id)){
						$get_branch = "'".$form_branch_id."'";						
					}else{
						$get_branch = rtrim($branches,",");
					}				
					
					$data['booked_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '2' and branch_id in (".$get_branch.")");
					$data['booked_member_dsh'] = $this->Dashboard_model->con_count('member_directory',"status = '1' and card_number = 'Unauthorized' and branch_id in (".$get_branch.")");					
					
					$data['abail_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '0' and branch_id in (".$get_branch.")");
					$data['out_of_service'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '6'  and branch_id in (".$get_branch.")");
					$data['number_of_disabled'] = $this->Dashboard_model->con_count('beds',"status = '0' and branch_id in (".$get_branch.")");
					$data['number_of_employee'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '5' and branch_id in (".$get_branch.")");
					
					$data['total_number_of_bed'] = $this->Dashboard_model->con_count('beds',"branch_id in (".$get_branch.")");
					$data['rfc_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '4' and branch_id in (".$get_branch.")");
					$data['ocp_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '3' and branch_id in (".$get_branch.")");					

					$get_branch_branch = rtrim($branches,",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (".$get_branch_branch.")");
					
				}else{   // INDIVITUAL BRANCH ADMIN ================================
					$branch_id = $_SESSION['super_admin']['branch'];				
					$data['booked_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '2' and branch_id = '".$branch_id."'");
					$data['booked_member_dsh'] = $this->Dashboard_model->con_count('member_directory',"status = '1' and card_number = 'Unauthorized' and branch_id = '".$branch_id."'");					
					
					$data['abail_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '0' and branch_id = '".$branch_id."'");
					$data['out_of_service'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '6' and branch_id = '".$branch_id."'");
					$data['number_of_disabled'] = $this->Dashboard_model->con_count('beds',"status = '0' and branch_id = '".$branch_id."'");
					$data['number_of_employee'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '5' and branch_id = '".$branch_id."'");
					
					$data['total_number_of_bed'] = $this->Dashboard_model->con_count('beds',"branch_id = '".$branch_id."'");
					$data['rfc_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '4' and branch_id = '".$branch_id."'");
					$data['ocp_number'] = $this->Dashboard_model->con_count('beds',"status = '1' and uses = '3' and branch_id = '".$branch_id."'");
					

					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$branch_id."'");
					
				}				
			}	
		
			$data['daily_total_booking'] = $this->Dashboard_model->mysqlii("SELECT COUNT(id) AS total_booking FROM booking_info WHERE data = '".date('d/m/Y')."'");
			$data['monthly_total_booking'] = $this->Dashboard_model->mysqlii("SELECT COUNT(id) AS total_booking FROM booking_info WHERE data like '%".date('m/Y')."'");
						
			$role_id = $_SESSION['super_admin']['role_id'];		
			$data['award'] = $this->Dashboard_model->select('sales_award_price',array('id' => '1'),'id','desc','row');
					
			$data['title_info'] = 'Booking Dashboard'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('include/article',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	public function permission_test(){
		if(isset($_POST['field_name'])){
			$role_id = $_POST['role_id'];
			echo $this->Dashboard_model->permission($role_id,$_POST['field_name']);			
		}
	}

	public function contacts(){
		$data = array();
		if(($_SESSION['user_info']['employee_id'] != 1) && ($_SESSION['user_info']['user'] != 'Md. Ibrahim Khalil')){
			redirect(base_url('admin/login'));
		}else{		
			$data['a'] = $this->Dashboard_model->mysqlii("SELECT * FROM member_contact_information");
			$data['title_info'] = 'Home';
			$data['notification_popup'] = '0';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/reports/contacts',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}

	public function refreshment_items(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_GET['date_range'])){
				$date_range = explode(' - ', $_GET['date_range']);
				$from_date = DateTime::createFromFormat('d/m/Y', $date_range[0]);				
				$to_date = DateTime::createFromFormat('d/m/Y', $date_range[1]);				
				$data['from_date'] = $from_date->format('d/m/Y');
				$data['to_date'] = $to_date->format('d/m/Y');
				$data['branch_name'] = $_GET['branch'];
			}else{
				$filterDate = new DateTime(date('Y-m-d'));
				$data['branch_name'] = '';
				$data['from_date'] = $filterDate->format('d/m/Y');
				$data['to_date'] = $filterDate->format('d/m/Y');
				$from_date = $filterDate;
				$to_date = $filterDate;
			}

			$item_filter = "";
			if(isset($_GET['item_name'])){
				$item_filter = " AND refreshment_item.item_name like '%".$_GET["item_name"]."%'";
			}

			if(!empty($_GET['branch'])){
				$data['a'] = $this->Dashboard_model->mysqlii("SELECT				
					refreshment_item.item_name,
					refreshment_item_sell.branch_name,
					sum(refreshment_item_list.qty) as total_qty,
					sum(refreshment_item_list.amount) as total_amount,
					refreshment_item.item_name as product_name,
					refreshment_item_sell.payment_status,
					refreshment_item_sell.month,
					refreshment_item_sell.day,
					refreshment_item_sell.year
					FROM `refreshment_item_sell` 
					INNER JOIN refreshment_item_list on refreshment_item_list.buer_code = refreshment_item_sell.buying_code
					INNER JOIN refreshment_item on refreshment_item.code = refreshment_item_list.product_code
					WHERE refreshment_item_sell.branch_id = '".$_GET['branch']."'
					AND STR_TO_DATE(refreshment_item_sell.data,'%d/%m/%Y') BETWEEN '".$from_date->format('Y-m-d')."' AND '".$to_date->format('Y-m-d')."'
					$item_filter
					GROUP BY refreshment_item.code;	
				");
			}else{
				$data['a'] = $this->Dashboard_model->mysqlii("SELECT
				refreshment_item.item_name,
				refreshment_item_sell.branch_name,
				sum(refreshment_item_list.qty) as total_qty,
				sum(refreshment_item_list.amount) as total_amount,
				refreshment_item.item_name as product_name,
				refreshment_item_sell.payment_status,
				refreshment_item_sell.month,
				refreshment_item_sell.day,
				refreshment_item_sell.year
				FROM `refreshment_item_sell` 
				INNER JOIN refreshment_item_list on refreshment_item_list.buer_code = refreshment_item_sell.buying_code
				INNER JOIN refreshment_item on refreshment_item.code = refreshment_item_list.product_code
				WHERE STR_TO_DATE(refreshment_item_sell.data,'%d/%m/%Y') BETWEEN '".$from_date->format('Y-m-d')."' AND '".$to_date->format('Y-m-d')."'
				$item_filter
				GROUP BY refreshment_item.code");
			}

			if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['super_admin']['role_id'] == '1622657840330042228'){
				$data['branches'] = $this->Dashboard_model->mysqlii("SELECT distinct(branch_name), branch_id FROM refreshment_item_sell ORDER BY branch_name");
			}else{
				$data['branches'] = $this->Dashboard_model->mysqlii("SELECT distinct(branch_name), branch_id FROM refreshment_item_sell where branch_id = '".$_SESSION['super_admin']['branch']."'  ORDER BY branch_name");
			}
			$data['items'] = $this->Dashboard_model->mysqlii("SELECT distinct(item_name) as item_name FROM refreshment_item");
			$data['title_info'] = 'Home';
			$data['notification_popup'] = '0';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/reports/refreshment_items',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	

















































































































































	public function charsochar_error(){
		$data = array();
		$this->load->view('404',$data);
	}	
}

























