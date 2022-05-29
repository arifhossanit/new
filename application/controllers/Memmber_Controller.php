<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memmber_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}
	
	public function login(){
		$data = array();
		if(isset($_SESSION['member_panel']['email'])){
			redirect(base_url('member'));
		}else{
			if(isset($_POST['login'])){				
				$member_card = $this->input->post('member_card_number');
				$password = $this->input->post('password');
				$member_info = $this->Dashboard_model->select('member_directory',array('card_number' => $member_card),'id','desc','row');
				
				$card_number = $member_info->card_number;
				$chellenge = array(
					'card_number' => $card_number,
					'password' => $password,
					'status' => 1,
				);
				
				$get_data = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
				if(!empty($get_data->id) AND !empty($get_data->email) AND $get_data->card_number != 'Unauthorized'){
					$email = $get_data->email;
					$package_name = $get_data->package_name;
					$card_number = $get_data->card_number;
					$session_data = array(
						'package_name' => $package_name,
						'card_number' => $card_number,
						'email' => $email
					);
					$_SESSION['member_panel'] = $session_data;
					$login_data_to_db = array(
						'id' => '',
						'type' => 'login_success',
						'member_id' => $get_data->id,
						'ip_address' => get_client_ip(),
						'device_info' => getDeviceInfo(),
						'time' => time_full(),
						'data' => data()
					);
					if($this->Dashboard_model->insert('member_login_info',$login_data_to_db)){
						if(isset($_SESSION['tea_coffe_redirect'])){
							alert('success','Successfully Login!');
							redirect(base_url($_SESSION['tea_coffe_redirect']));
						}else{
							alert('success','Successfully Login!');
							redirect(base_url('member'));					
						}
					}else{
						alert('danger','Something wrong! Please try again');
						redirect('member/change-password');
					}									
				}else{
					alert('danger','Card Number or Password wrong. Please try again!');
					redirect(base_url('member/login'));
				}
			}
			$this->load->view('member/login',$data);
		}
	}
	
	public function forgot_password(){
		$data = array();
		if(isset($_SESSION['member_panel']['email'])){
			redirect(base_url('member'));
		}else{
			if(isset($_POST['request_new_password'])){
				
			}
			$this->load->view('member/forgot_password');
		}
	}
	
	public function logout(){
		unset($_SESSION['member_panel']);
		alert('success','Successfully Logout!');
		redirect(base_url('member/login'));
	}
	
	
	
	public function index(){
		$data = array();
		if(!isset($_SESSION['member_panel']['email'])){
			redirect(base_url('member/login'));
		}else{
			
			
			
			$chellenge = array(
				'card_number' => $_SESSION['member_panel']['card_number'],
				'status' => 1,
			);	
			$bk_id = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$chellenge2 = array(
				'booking_id' => $bk_id->booking_id,
				'status' => 1,
			);
			$chellenge_sh = array(
				'booking_id' => $bk_id->booking_id
			);
			$data['cancel_data'] = $this->Dashboard_model->select('cencel_request',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			
			$data['sh_point'] = $this->Dashboard_model->select('balance_shpoint',$chellenge_sh,'id','desc','row');
			$data['profile_picture'] = $this->Dashboard_model->select('member_directory',$chellenge2,'id','desc','row');
			
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Member Dashboard'; 			
			$data['header'] = $this->load->view('member/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('member/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('member/include/article','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function change_password(){
		$data = array();
		if(!isset($_SESSION['member_panel']['email'])){
			redirect(base_url('member/login'));
		}else{
			if(isset($_POST['change_password'])){
				$chellenge = array(
					'card_number' => $_SESSION['member_panel']['card_number'],
					'password' => $this->input->post('old_password'),
					'status' => 1,
				);
				$check_old_password = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
				if($check_old_password->password == $this->input->post('old_password')){
					if($this->input->post('old_password') == $this->input->post('new_password')){
						alert('warning','Old & New Password are same please try with a new good password');
						redirect('member/change-password');
					}else{
						if(strlen($this->input->post('new_password')) < 6 ){
							alert('warning','Password must be minimum 6 character.');
							redirect('member/change-password');
						}else{
							if($this->input->post('new_password') == $this->input->post('confirm_password')){
								$data = array(
									'password' => $this->input->post('new_password')
								);								
								if($this->Dashboard_model->update('member_directory',$data,$check_old_password->id)){
									unset($_SESSION['member_panel']);									
									alert('success','Password Change Successfully! Please Login Again');
									redirect('member/change-password');
								}else{
									alert('warning','Something wrong! Please try again');
									redirect('member/change-password');
								}
							}else{
								alert('warning','New & Confirm Password dose not match! Please Try Again.');
								redirect('member/change-password');
							}
						}
					}
				}else{
					alert('danger','Old Password wrong! Please try again');
					redirect('member/change-password');
				}
			}		
			$chellenge = array(
				'card_number' => $_SESSION['member_panel']['card_number'],
				'status' => 1,
			);	
			$bk_id = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$chellenge2 = array(
				'booking_id' => $bk_id->booking_id,
				'status' => 1,
			);
			$chellenge_sh = array(
				'booking_id' => $bk_id->booking_id
			);
			$data['cancel_data'] = $this->Dashboard_model->select('cencel_request',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['sh_point'] = $this->Dashboard_model->select('balance_shpoint',$chellenge_sh,'id','desc','row');
			$data['profile_picture'] = $this->Dashboard_model->select('member_directory',$chellenge2,'id','desc','row');
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Member Change Password'; 			
			$data['header'] = $this->load->view('member/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('member/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('member/template/change_password','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function request_for_cancel(){
		$data = array();
		if(!isset($_SESSION['member_panel']['email'])){
			redirect(base_url('member/login'));
		}else{
					
			$chellenge = array(
				'card_number' => $_SESSION['member_panel']['card_number'],
				'status' => 1,
			);	
			$bk_id = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$chellenge2 = array(
				'booking_id' => $bk_id->booking_id,
				'status' => 1,
			);
			$chellenge_sh = array(
				'booking_id' => $bk_id->booking_id
			);
			$data['cancel_data'] = $this->Dashboard_model->select('cencel_request',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['rent_info'] = $this->Dashboard_model->select('rent_info',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['booking_info'] = $this->Dashboard_model->select('booking_info',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['packages'] = $this->Dashboard_model->select('packages',array('id'=>$bk_id->package),'id','desc','row');
			$data['sh_point'] = $this->Dashboard_model->select('balance_shpoint',$chellenge_sh,'id','desc','row');
			$data['profile_picture'] = $this->Dashboard_model->select('member_directory',$chellenge2,'id','desc','row');
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Request For Cancel'; 			
			$data['header'] = $this->load->view('member/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('member/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('member/template/request_for_cancel','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	public function widthdraw_cancel_request(){
		$data = array();
		if(!isset($_SESSION['member_panel']['email'])){
			redirect(base_url('member/login'));
		}else{
					
			$chellenge = array(
				'card_number' => $_SESSION['member_panel']['card_number'],
				'status' => 1,
			);	
			$bk_id = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$chellenge2 = array(
				'booking_id' => $bk_id->booking_id,
				'status' => 1,
			);
			$chellenge_sh = array(
				'booking_id' => $bk_id->booking_id
			);
			$data['cancel_data'] = $this->Dashboard_model->select('cencel_request',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['rent_info'] = $this->Dashboard_model->select('rent_info',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['booking_info'] = $this->Dashboard_model->select('booking_info',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['packages'] = $this->Dashboard_model->select('packages',array('id'=>$bk_id->package),'id','desc','row');
			$data['sh_point'] = $this->Dashboard_model->select('balance_shpoint',$chellenge_sh,'id','desc','row');
			$data['profile_picture'] = $this->Dashboard_model->select('member_directory',$chellenge2,'id','desc','row');
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Widthdraw Cancel Request'; 			
			$data['header'] = $this->load->view('member/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('member/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('member/template/widthdraw_cancel_request','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_free_award(){
		$data = array();
		if(!isset($_SESSION['member_panel']['email'])){
			redirect(base_url('member/login'));
		}else{

			
			
			$chellenge = array( 'card_number' => $_SESSION['member_panel']['card_number'], 'status' => 1, );	
			$bk_id = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$chellenge_sh = array( 'booking_id' => $bk_id->booking_id );
			$chellenge2 = array( 'booking_id' => $bk_id->booking_id, 'status' => 1, );
			$data['sh_point'] = $this->Dashboard_model->select('balance_shpoint',$chellenge_sh,'id','desc','row');
			$data['profile_picture'] = $this->Dashboard_model->select('member_directory',$chellenge2,'id','desc','row');
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Get A Free Award'; 			
			$data['header'] = $this->load->view('member/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('member/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('member/template/get_free_award','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function view_profile(){
		$data = array();
		if(!isset($_SESSION['member_panel']['email'])){
			redirect(base_url('member/login'));
		}else{
			if(isset($_POST['change_password'])){
				$chellenge = array(
					'card_number' => $_SESSION['member_panel']['card_number'],
					'password' => $this->input->post('old_password'),
					'status' => 1,
				);
				$check_old_password = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
				if($check_old_password->password == $this->input->post('old_password')){
					if($this->input->post('old_password') == $this->input->post('new_password')){
						alert('warning','Old & New Password are same please try with a new good password');
						redirect('member/change-password');
					}else{
						if(strlen($this->input->post('new_password')) < 6 ){
							alert('warning','Password must be minimum 6 character.');
							redirect('member/change-password');
						}else{
							if($this->input->post('new_password') == $this->input->post('confirm_password')){
								$data = array(
									'password' => $this->input->post('new_password')
								);								
								if($this->Dashboard_model->update('member_directory',$data,$check_old_password->id)){
									unset($_SESSION['member_panel']);									
									alert('success','Password Change Successfully! Please Login Again');
									redirect('member/change-password');
								}else{
									alert('warning','Something wrong! Please try again');
									redirect('member/change-password');
								}
							}else{
								alert('warning','New & Confirm Password dose not match! Please Try Again.');
								redirect('member/change-password');
							}
						}
					}
				}else{
					alert('danger','Old Password wrong! Please try again');
					redirect('member/change-password');
				}
			}
						
			$chellenge = array(
				'card_number' => $_SESSION['member_panel']['card_number'],
				'status' => 1,
			);		
			$bk_id = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$chellenge2 = array(
				'booking_id' => $bk_id->booking_id,
				'status' => 1,
			);
			$chellenge_sh = array(
				'booking_id' => $bk_id->booking_id
			);
			$data['cancel_data'] = $this->Dashboard_model->select('cencel_request',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['sh_point'] = $this->Dashboard_model->select('balance_shpoint',$chellenge_sh,'id','desc','row');
			$data['profile_picture'] = $this->Dashboard_model->select('member_directory',$chellenge2,'id','desc','row');
			$data['profile_details'] = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$data['rental_info'] = $this->Dashboard_model->select('rent_info',$chellenge2,'id','desc','result');
			
			
			
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Member View Profile'; 			
			$data['header'] = $this->load->view('member/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('member/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('member/template/view_profile','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function tea_coffee( $branch = '', $ip = '', $result = ''){ //$_SESSION['member_panel']['card_number']
		$data = array();
		if(!isset($_SESSION['member_panel']['email'])){
			$_SESSION['tea_coffe_redirect'] = 'member/tea-coffee/'.$branch.'/'.$ip.'/null';
			redirect(base_url('member/login'));
		}else{
			if($result == 'tea_ok'){
				alert('success','Signal Received Succesfully! Please Wait for TEA!');
				echo "<script>window.open('".base_url()."member/tea-coffee/null/null/null','_self')</script>";
			}else if($result == 'coffee_ok'){
				alert('success','Signal Received Succesfully! Please Wait for Coffee!');
				echo "<script>window.open('".base_url()."member/tea-coffee/null/null/null','_self')</script>";
			}
			$branch_id = rahat_decode($branch);
			$ip_address = rahat_decode($ip);
			$chellenge = array(
				'card_number' => $_SESSION['member_panel']['card_number'],
				'status' => 1,
			);		
			$bk_id = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$chellenge_0 = array(
				'branch_id' => $branch_id,
				'status' => 1,
			);		
			$get_branch = $this->Dashboard_model->select('branches',$chellenge_0,'id','desc','row');
			if(!empty($get_branch->id)){
				if($bk_id->branch_id == $get_branch->branch_id){
					$data['page_view'] = 'verified';
					if(isset($_POST['tea'])){
						$data = array(
							'id' => '',
							'branch_id' => $get_branch->branch_id,
							'booking_id' => $bk_id->booking_id,
							'type' => 'TEA',
							'qty' => '1',
							'amount' => '10',
							'ip_address' => $ip_address,
							'time' => date('h:i:sa'),
							'data' => date('d/m/Y')
						);
						if($this->Dashboard_model->insert('tea_management',$data)){
							echo "<script>window.open('http://".$ip_address."/?tea','_self')</script>";							
						}else{
							alert('danger','Something wrong! Please try again.');
							redirect(current_url());
						}
					}
					
					if(isset($_POST['coffee'])){
						$data = array(
							'id' => '',
							'branch_id' => $get_branch->branch_id,
							'booking_id' => $bk_id->booking_id,
							'type' => 'COFFEE',
							'qty' => '1',
							'amount' => '15',
							'ip_address' => $ip_address,
							'time' => date('h:i:sa'),
							'data' => date('d/m/Y')
						);
						if($this->Dashboard_model->insert('tea_management',$data)){
							echo "<script>window.open('http://".$ip_address."/?coffee','_self')</script>";
						}else{
							alert('danger','Something wrong! Please try again.');
							redirect(current_url());
						}
					}
				}else{
					$data['page_view'] = 'no_branch_member';
				}
			}else{
				$data['page_view'] = 'scan';
			}
			
			
			
			
			
			$chellenge2 = array(
				'booking_id' => $bk_id->booking_id,
				'status' => 1,
			);
			$chellenge_sh = array(
				'booking_id' => $bk_id->booking_id
			);
			$data['cancel_data'] = $this->Dashboard_model->select('cencel_request',array('booking_id'=>$bk_id->booking_id),'id','desc','row');
			$data['sh_point'] = $this->Dashboard_model->select('balance_shpoint',$chellenge_sh,'id','desc','row');
			$data['profile_picture'] = $this->Dashboard_model->select('member_directory',$chellenge2,'id','desc','row');
			$data['profile_details'] = $this->Dashboard_model->select('member_directory',$chellenge,'id','desc','row');
			$data['rental_info'] = $this->Dashboard_model->select('rent_info',$chellenge2,'id','desc','result');
			
			
			
			$data['b_class'] = 'sidebar-mini'; 
			$data['title_info'] = 'Tea / Coffe Management (Member)'; 			
			$data['header'] = $this->load->view('member/include/header',$data,TRUE); 
			$data['nav'] = $this->load->view('member/include/nav',$data,TRUE); 
			$data['article'] = $this->load->view('member/template/tea_coffee','',TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	

















































































































































	public function charsochar_error(){
		$data = array();
		$this->load->view('404',$data);
	}	
}

























