<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontoffice extends CI_Controller { //MTBfMDRfMjAyMV9fMTFfMzVfNTVfQU1fMTgyNzYxNjU0NV8yNzcxMTM4ODY0NDgwNjQwNQ
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}
	//start dining-table  ------------- 
	public function checkout_verify($booking_id = ''){
		$data = array();		
		if(!empty($booking_id)){
			$booking_id = rahat_decode($booking_id);			
			$member_info = $this->Dashboard_model->select('member_directory',array('id' => $booking_id),'id','desc','row');
			if(!empty($member_info->booking_id)){
				if(isset($_POST['confirm_checkout'])){
					$f_value = $this->input->post('value');
					$data = array(
						'id' => '',
						'branch_id' => $member_info->branch_id,
						'booking_id' => $member_info->booking_id,
						'rating_value' => $f_value,
						'data' => date('d/m/Y')
					);					
					$confirmation_update = array(
						'status' => '1'
					);
					$checkout_confirmation = $this->Dashboard_model->select('checkout_confirmation',array('booking_id' => $member_info->booking_id),'id','desc','row');
					$whole_service_rating = $this->Dashboard_model->select('whole_service_rating',array('booking_id' => $member_info->booking_id),'id','desc','row');
					if(!empty($whole_service_rating->booking_id)){
						alert('warning','Thank you! You all ready give us Rate');
						redirect(current_url());
					}else{
						if(
							$this->Dashboard_model->insert('whole_service_rating',$data)
							AND 
							$this->Dashboard_model->update('checkout_confirmation',$confirmation_update,$checkout_confirmation->id)
						){
							alert('success','Thank you for your valuable feedback!');
							redirect(base_url());
						}else{
							alert('success','Something wrong! please Try again');
							redirect(current_url());
						}
					}
				}
				$data['title_info'] = 'Whole Service Feed back';
				$data['article'] = $this->load->view('template/front_office/member_checkout_verify',$data,TRUE); 
				$data['footer'] = $this->load->view('include/footer','',TRUE); 
				$this->load->view('dashboard',$data);
			}else{
				alert('danger','Your id in not found!');
				redirect(base_url());
			}		
		}else{
			alert('danger','404 Not Found');
			redirect(base_url());
		}
		
		
	}
	//--- end dining Table---
	
	
	//start dining-table  ------------- 
	public function dining_table(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches',$condition1,'id','ASC','result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category',$condition,'id','asc','result');
			$data['title_info'] = 'Booking Report'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/reports/booking_report',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end dining Table---
	
	//start refreshment_iteam  ------------- 
	public function refreshment_iteam(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$utime = sprintf('%.4f', microtime(TRUE)); 
			$raw_time = DateTime::createFromFormat('U.u', $utime); 
			$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka'));
			$today = $raw_time->format('dmy-his-u');
			if(!empty($_SESSION['super_admin']['branch'])){
				$bc = $this->Dashboard_model->select('branches',array('branch_id' => $_SESSION['super_admin']['branch']),'id','desc','row');
			}else{
				alert('danger','Please LogIn Again');
				redirect(current_url());
			}
			$transaction_id = $bc->branch_code.'-'.$today;
			$transaction_idO = $transaction_id;
			if(isset($_POST['save'])){
				$branch_id = $this->input->post('branch_id');
				$branch_name = $this->Dashboard_model->select('branches',array('branch_id' => $branch_id),'id','desc','row');
				$member = $this->Dashboard_model->select('member_directory',array('card_number' => $this->input->post('card_number')),'id','desc','row');
				$buyer_code = md5(time());
				if(!empty($member->booking_id)){
					$booking_id = $member->booking_id;
				}else{
					$booking_id = '';
				}
				
				
				$data = array(
					'id' => '',
					'branch_id' => $branch_name->branch_id,
					'branch_name' => $branch_name->branch_name,
					'buyer_id' => $this->input->post('card_number'),
					'booking_id' => $booking_id,
					'buying_code' => $buyer_code,
					'total_qty' => $this->input->post('total_qty'),
					'total_amount' => $this->input->post('total_amount'),
					'payment_status' => $this->input->post('payment_status'),					
					'day' => date('d'),
					'month' => date('m'),
					'year' => date('Y'),					
					'note' => $this->input->post('note'),
					'status' => '1',
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if(!empty($_SESSION["cart_item"])){
					$p_name = '';
					foreach($_SESSION["cart_item"] as $item){
						
						//updating refreshment item list start
						if($item['name'] != 'Tea' && $item['name'] != 'Coffee'){
							$get_previous_quantity_from_item_stock = $this->Dashboard_model->mysqlii("SELECT remaining_quantity from item_stocks 
							where branch_name like '%".$branch_name->branch_name."%' 
							AND product_name like '%".$item['name']."%' 
							AND remaining_quantity != '0' ORDER BY id desc limit 1 ");
						
							$previous_remainig_quantity = $get_previous_quantity_from_item_stock[0]->remaining_quantity;
							$restQuantity =  $previous_remainig_quantity - $item["quantity"];

							$this->Dashboard_model->mysqliq("UPDATE item_stocks SET remaining_quantity = '".$restQuantity."' WHERE branch_name = '".$branch_name->branch_name."' AND product_name = '".$item['name']."' order by id desc limit 1 ");
						}
						//updating refreshment item list end

						$data_iteam[] = array(
							'id' => '',
							'buer_code' => $buyer_code,
							'product_code' => $item['code'],
							'product_name' => $item['name'],
							'qty' => $item["quantity"],
							'amount' => $item["price"]*$item["quantity"],
							'data' => date('d/m/Y')
						);
						$p_name .= $item['name'].' - '.$item["quantity"].' ('.money($item["price"]*$item["quantity"]).'),';
					}
					$sms_p_info = rtrim($p_name,',');
				}
				
				
				if($this->input->post('payment_status') == 'Paid'){
					$get_account_info = $this->Dashboard_model->select('accounts',array('id' => '1'),'id','ASC','row');
					$get_money = $get_account_info->balance + $this->input->post('total_amount');
					$account = array(
						'balance' =>  $get_money
					);
					$this->Dashboard_model->update('accounts',$account,'1');
					if(!empty($member->booking_id)){
						$booking_id = $member->booking_id;
						//sh point  here 
					}else{
						$booking_id = '';
					}
					
					
					$uploader_info = $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
					$invoice_id = $this->Dashboard_model->select('refreshment_item_sell','','id','DESC','row');
					$inv_id = date('dmY').$invoice_id->id;
					$data_varient = array(
						'id' => '',
						'transaction_id' => $transaction_idO,
						'branch_id' => $branch_name->branch_id,
						'booking_id' => $booking_id,
						'payment_method' => 'Cash',
						'details' => 'Walk in Customer & Cash in hand (Shop)',
						'card_amount' => '',
						'cash_amount' => $this->input->post('total_amount'),
						'mobile_amount' => '',
						'check_amount' => '',
						'invoice_number' => $inv_id,
						'note' => '',
						'status' => '1',
						'uploader_info' => $uploader_info,
						'data' => date('d/m/Y')
					); 	
					$this->Dashboard_model->insert('payment_received_method',$data_varient);
					$transaction = array(
						'id' => '',
						'transaction_id' => $transaction_idO,
						'branch_id' => $branch_name->branch_id,
						'booking_id' => $booking_id,
						'careof' => $this->input->post('buyer_name'),
						'account_type' => 'Defult',
						'account' => 'Defult',
						'amount' => $this->input->post('total_amount'),
						'date' => date('l, d/m/Y h:i:sa'),
						'transaction_type' => 'Credit',
						'transaction_category' => 'Refreshment Iteam',
						'transaction_method' => 'Walk In Customer / Member',
						'data_one' => '',
						'data_two' => '',
						'data_three' => '',
						'note' => 'Refreshment Sell Collection',
						'status' => '1',
						'uploader_info' => $uploader_info,
						'data' => date('d/m/Y')
					);
					$this->Dashboard_model->insert('transaction',$transaction);
				}
				
				
				if(
					$this->Dashboard_model->insert('refreshment_item_sell',$data)
					AND
					$this->Dashboard_model->insert_batch('refreshment_item_list',$data_iteam)
				){
					if($this->input->post('payment_status') == 'Due'){
						$sms_body = 'Your payment status is DUE. You take '.$sms_p_info.' & Your total amount is: '.money($this->input->post('total_amount')).'. It will be add with your next payment transaction. Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/';
						sendsms($this->input->post('phone_number'),$sms_body);
					}

					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}			
			}
			if(isset($_POST['investor_refreshment'])){
				if(empty($_POST['tea_amount'])){
					$tea = 0;
				}else{
					$tea = $_POST['tea_amount'];
				}
				if(empty($_POST['drinks_amount'])){
					$drink = 0;
				}else{
					$drink = $_POST['drinks_amount'];
				}
				
				$insert_data = array(
					'tea_coffee' => $tea,
					'drinks' => $drink,
					'date' => date('Y/m/d'),
					'tea_coffee' => $tea,
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'investor_facilities_setup_id' => $_POST['investor_refreshment_id']
				);
				if(
					$this->Dashboard_model->mysqliq("UPDATE investor_facilities_setup set tea_coffee = tea_coffee - $tea, drinks = drinks - $drink where card_no = '".$_POST['investor_card_number']."'") AND
					$this->Dashboard_model->insert('investor_facilities_setup_records',$insert_data)
				){
					unset($_SESSION['investor_refreshment_otp']);
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches',$condition1,'id','ASC','result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category',$condition,'id','asc','result');
			$data['title_info'] = 'Refreshment Item'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/refreshment_iteam',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end refreshment_iteam---
	
	//start instant_transaction_buy_something  ------------- 
	public function instant_transaction_buy_something(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				$validate = $this->Dashboard_model->mysqlij("SELECT count(id) as validate from transaction where transaction_id = '".$this->input->post('transaction_id')."'");
				if($validate->validate == 0){
					$data = date('d/m/Y');
					$transactionss_id = $this->input->post('transaction_id');
					$branch_id = $this->input->post('branch_id');
					$total_amount = $this->input->post('total_subtotal');
					$balance_amount = $this->input->post('total_amount');
					$extra_note = array();
					$uploader_info = $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
					if($balance_amount >= $total_amount){
						if(!empty($this->input->post('item_name'))){
							foreach($_FILES['attachment']['name'] as $row => $value){
								$extra_note[$row] = $this->input->post('purpose')[$row];
								$item_data[] = array(
									'id' => '',
									'transaction_id' => $transactionss_id,
									'item_name' => $this->input->post('item_name')[$row],
									'purpose' => $this->input->post('purpose')[$row],
									'item_price' => $this->input->post('item_price')[$row],
									'ite_qty' => $this->input->post('ite_qty')[$row],
									'total' => $this->input->post('total_item_amount')[$row],
									'attachment' => file_upload_m($_FILES['attachment']['name'][$row],$_FILES['attachment']['tmp_name'][$row]),
									'data' => $data
								);
							}
						}					
						$invoice_id = $this->Dashboard_model->select('instant_transaction_logs','','id','DESC','row');
						if(!empty($invoice_id->id)){
							$invv_id = $invoice_id->id;
						}else{
							$invv_id = 1;
						}
						$inv_id = date('dmY').$invv_id;
						$data_varient = array(
							'id' => '',
							'transaction_id' => $transactionss_id,
							'branch_id' => $branch_id,
							'booking_id' => '',
							'payment_method' => 'Cash',
							'details' => 'Instant Transaction(Buy Something)',
							'card_amount' => '',
							'cash_amount' => $total_amount,
							'mobile_amount' => '',
							'check_amount' => '',
							'invoice_number' => $inv_id,
							'note' => '',
							'status' => '1',
							'uploader_info' => $uploader_info,
							'data' => $data
						); 
						$transaction = array(
							'id' => '',
							'transaction_id' => $transactionss_id,
							'branch_id' => $branch_id,
							'booking_id' => '',
							'careof' => '',
							'account_type' => 'Defult',
							'account' => 'Defult',
							'amount' => $total_amount,
							'date' => date('l, d/m/Y h:i:sa'),
							'transaction_type' => 'Debit',
							'transaction_category' => 'Instant Transaction(Buy Something)',
							'transaction_method' => 'Petty Cash',
							'data_one' => '',
							'data_two' => '',
							'data_three' => '',
							'note' => 'Instant Transaction(Buy Something)',
							'status' => '1',
							'uploader_info' => $uploader_info,
							'data' => $data
						);
						$petty_chash_check = $this->Dashboard_model->select('branch_petty_cash',array('branch_id' => $branch_id),'id','ASC','row');
						$get_money = $petty_chash_check->amount - (int)$total_amount;
						$petty_chash = array(
							'amount' =>  $get_money
						);	
						$transaction_data = array(
							'id' => '',
							'transaction_id' => $transactionss_id,
							'branch_id' => $branch_id,
							'amount' => $total_amount,
							'note' => implode(",", $extra_note),
							'status' => '1',
							'uploader_info' => $uploader_info,
							'data' => $data,
							'balance' => $get_money
						);				
						if(
							$this->Dashboard_model->insert_batch('instant_transaction_iteams',$item_data)
							AND
							$this->Dashboard_model->insert('instant_transaction_logs',$transaction_data)
							AND
							$this->Dashboard_model->insert('payment_received_method',$data_varient)
							AND
							$this->Dashboard_model->insert('transaction',$transaction)
							AND
							$this->Dashboard_model->update('branch_petty_cash',$petty_chash,$petty_chash_check->id)
						){
							alert('success','Successfully Saved!');
							// redirect(current_url());
						}else{
							alert('danger','Something Wrong! Please Try Again');
							// redirect(current_url());
						}					
					}else{
						alert('danger','Sorry, Insufficient Balance! Please Try Again');
						// redirect(current_url());
					}
				}
			}
			
			
			
			$data['branch_code'] = $this->Dashboard_model->select('branches',array('branch_id' => $_SESSION['super_admin']['branch']),'id','DESC','row');
			$data['petty_balance'] = $this->Dashboard_model->select('branch_petty_cash',array('branch_id' => $_SESSION['super_admin']['branch']),'id','DESC','row');
			$data['title_info'] = 'Instant Transaction'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/instant_transaction_buy_something',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end instant_transaction_buy_something---
	
	//start advance_transaction_buy_something  ------------- 
	public function advance_transaction_buy_something(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['return_money_form_token'])){
				$check_status = $this->Dashboard_model->select('advance_petty_cash_return_logs',array('employee_id' => $this->input->post('employee_id'), 'aproval' => '0'),'id','DESC','row');
				if(!empty($check_status->id)){
					echo 'Sorry! You have already pending Request';
				}else{
					$employee_id = $this->input->post('employee_id');
					$amount_of_money = $this->input->post('amount_of_money');
					$note = $this->input->post('note');
					$empl_info = $this->Dashboard_model->select('employee',array('id' => $employee_id),'id','DESC','row');
					$petty_info = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $empl_info->id),'id','DESC','row');
					if(!empty($petty_info->id)){
						if($petty_info->amount == 0){							
							echo 'Sorry! You do not have enough balance to return';
						}else{
							if($petty_info->amount >= $amount_of_money){
								$rest_of_amount = $petty_info->amount - $amount_of_money;
								$insert_data = array(
									'id' => '',
									'employee_id' => $empl_info->id,
									'in_hand' => $petty_info->amount,
									'amount' => $amount_of_money,
									'rest_of_amount' => $rest_of_amount,
									'note' => $note,
									'aproval' => '0',
									'uploader_info' => uploader_info(),
									'data' => date('d/m/Y')
								);
								if($this->Dashboard_model->insert('advance_petty_cash_return_logs',$insert_data)){
									echo 'Request Successfully Sended';
								}else{
									echo 'Something Wrong! Please Try Again';
								}
							}else{
								echo 'Sorry! You do not have enough balance to return';
							}
						}
					}else{
						echo 'Sorry! You Never Take Advance Money!';
					}
				}
			}else{
				if(isset($_POST['save'])){
					$check_pending_status = $this->Dashboard_model->select('advance_petty_cash_return_logs',array('aproval' => '0', 'employee_id' => $this->input->post('employee_id')),'id','DESC','row');
					if(!empty($check_pending_status->id)){
						alert('danger','Sorry! You can not Purses! You Have return request still Pending!');
						redirect(current_url());
					}else{
						$data = date('d/m/Y');
						$transactionss_id = $this->input->post('transaction_id');
						$employee_id = $this->input->post('employee_id');
						$branch_id = $_SESSION['super_admin']['branch'];
						$total_amount = $this->input->post('total_subtotal');
						$balance_amount = $this->input->post('total_amount');
						$extra_note = $this->input->post('extra_note');
						$uploader_info = $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
						$empl_info = $this->Dashboard_model->select('employee',array('id' => $employee_id),'id','DESC','row');
						//if($balance_amount >= $total_amount){
							if(!empty($this->input->post('item_name'))){
								foreach($_FILES['attachment']['name'] as $row => $value){
									$expense_type_split = explode('|', $_POST['expense_tpye'][$row]);
									if(count($expense_type_split) == 2){
										$expense_type = $expense_type_split[0];
										$expense_sub_type = $expense_type_split[1];
									}else{
										$expense_type = $expense_type_split[0];
										$expense_sub_type = -1;
									}
									$item_data[] = array(
										'id' => '',
										'transaction_id' => $transactionss_id,
										'item_name' => $this->input->post('item_name')[$row],
										'purpose' => $this->input->post('purpose')[$row],
										'purpose' => $expense_type,
										'sub_purpose' => $expense_sub_type,
										'item_price' => $this->input->post('item_price')[$row],
										'ite_qty' => $this->input->post('ite_qty')[$row],
										'total' => $this->input->post('total_item_amount')[$row],
										'attachment' => file_upload_m($_FILES['attachment']['name'][$row],$_FILES['attachment']['tmp_name'][$row]),
										'data' => $data
									);
								}
							}					
							$transaction_data = array(
								'id' => '',
								'transaction_id' => $transactionss_id,
								'branch_id' => $branch_id,
								'employee_id' => $employee_id,
								'amount' => $total_amount,
								'note' => $extra_note,
								'approval' => '0',
								'status' => '1',
								'uploader_info' => $uploader_info,
								'data' => $data
							);					
							$invoice_id = $this->Dashboard_model->select('advance_transaction_logs','','id','DESC','row');
							if(!empty($invoice_id->id)){
								$invv_id = $invoice_id->id;
							}else{
								$invv_id = 1;
							}
							$inv_id = date('dmY').$invv_id;
							$data_varient = array(
								'id' => '',
								'transaction_id' => $transactionss_id,
								'branch_id' => $branch_id,
								'booking_id' => '',
								'payment_method' => 'Cash',
								'details' => 'Urgent Transaction(Buy Something)',
								'card_amount' => '',
								'cash_amount' => $total_amount,
								'mobile_amount' => '',
								'check_amount' => '',
								'invoice_number' => $inv_id,
								'note' => '',
								'status' => '1',
								'uploader_info' => $uploader_info,
								'data' => $data
							); 
							$transaction = array(
								'id' => '',
								'transaction_id' => $transactionss_id,
								'branch_id' => $branch_id,
								'booking_id' => '',
								'careof' => $empl_info->full_name,
								'account_type' => 'Defult',
								'account' => 'Defult',
								'amount' => $total_amount,
								'date' => date('l, d/m/Y h:i:sa'),
								'transaction_type' => 'Debit',
								'transaction_category' => 'Urgent Transaction(Buy Something)',
								'transaction_method' => 'Petty Cash',
								'data_one' => '',
								'data_two' => '',
								'data_three' => '',
								'note' => 'Urgent Transaction(Buy Something)',
								'status' => '1',
								'uploader_info' => $uploader_info,
								'data' => $data
							);
							$petty_chash_check = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $employee_id),'id','ASC','row');
							$get_money = $petty_chash_check->amount - (int)$total_amount;
							$petty_chash = array(
								'amount' =>  $get_money
							);					
							if(
								$this->Dashboard_model->insert_batch('advance_transaction_iteams',$item_data)
								AND
								$this->Dashboard_model->insert('advance_transaction_logs',$transaction_data)
								AND
								$this->Dashboard_model->insert('payment_received_method',$data_varient)
								AND
								$this->Dashboard_model->insert('transaction',$transaction)						
							){
								//AND
								//$this->Dashboard_model->update('advance_petty_cash',$petty_chash,$petty_chash_check->id)
								alert('success','Successfully Saved!');
								redirect(current_url());
							}else{
								alert('danger','Something Wrong! Please Try Again');
								redirect(current_url());
							}					
						//}else{
						//	alert('danger','Sorry, Insufficient Balance! Please Try Again');
						//	redirect(current_url());
						//}	
					}
				}
				
				
				
			
			
			
			
				$data['branch_code'] = $this->Dashboard_model->select('branches',array('branch_id' => $_SESSION['super_admin']['branch']),'id','DESC','row');
				$data['petty_balance'] = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $_SESSION['user_info']['employee_id']),'id','DESC','row');
				$data['title_info'] = 'Urgent Expences'; 
				$data['header'] = $this->load->view('include/header','',TRUE); 
				$data['nav'] = $this->load->view('include/nav','',TRUE); 
				$data['article'] = $this->load->view('template/front_office/advance_transaction_buy_something',$data,TRUE); 
				$data['footer'] = $this->load->view('include/footer','',TRUE); 
				$this->load->view('dashboard',$data);
			}
		}
	}
	//--- end advance_transaction_buy_something---
	
	
	//start advance_money_request  ------------- 
	public function advance_money_request(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['amount'])){
				$check_pending_status = $this->Dashboard_model->select('advance_petty_cash_return_logs',array('aproval' => '0', 'employee_id' => $this->input->post('employee_id')),'id','DESC','row');
				if(!empty($check_pending_status->id)){
					alert('danger','Sorry! You can not Purses! You Have return request still Pending!');
					redirect(current_url());
				}else{
					$chellenge = array(
						'id' => $this->input->post('employee_id'),
						'status' => 1
					);				
					$get_data = $this->Dashboard_model->select('employee',$chellenge,'id','desc','row');
					$check_pending = $this->Dashboard_model->select('advance_money_request',array('employee_id'  => $get_data->employee_id,'status' => '1'),'id','desc','row');
					if(!empty($check_pending)){
						alert('info','All Ready you have a pending request! Please try again later');
						redirect(current_url());
					}else{
						$data = array(
							'id' => '',
							'employee_id' => $get_data->employee_id,
							'amount' => $this->input->post('amount'),
							'note' => $this->input->post('note'),
							'status' => '1',
							'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
							'data' => date('d/m/Y')
						);
						if($this->Dashboard_model->insert('advance_money_request',$data)){
							alert('success','Request Successfully Sent!');
							redirect(current_url());
						}else{
							alert('danger','Somwthing wrong! Please Try Again');
							redirect(current_url());
						}
					}
				}
			}			
			
			$data['branch_code'] = $this->Dashboard_model->select('branches',array('branch_id' => $_SESSION['super_admin']['branch']),'id','DESC','row');
			$data['petty_balance'] = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $_SESSION['user_info']['employee_id']),'id','DESC','row');
			$data['title_info'] = 'Advance Money Request'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/advance_money_request',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end advance_money_request---
	
	
	//start petty_cash_request  ------------- 
	public function petty_cash_request(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{			
			if(isset($_POST['send_request'])){
				$chellenge = array(
					'branch_id' => $this->input->post('branch_id'),
					'status' => 1
				);				
				$get_data = $this->Dashboard_model->select('branches',$chellenge,'id','desc','row');
				$check_pending = $this->Dashboard_model->select('petty_cash_request_logs',array('branch_id'  => $get_data->branch_id,'status' => '1'),'id','desc','row');
				if(!empty($check_pending)){
					alert('info','All Ready you have a pending request! Please try again later');
					redirect(current_url());
				}else{
					$data = array(
						'id' => '',
						'branch_id' => $get_data->branch_id,
						'amount' => $this->input->post('amount'),
						'note' => $this->input->post('note'),
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					if($this->Dashboard_model->insert('petty_cash_request_logs',$data)){
						alert('success','Request Successfully Sended!');
						redirect(current_url());
					}else{
						alert('danger','Somwthing wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}			
			
			$data['branch_code'] = $this->Dashboard_model->select('branches',array('branch_id' => $_SESSION['super_admin']['branch']),'id','DESC','row');
			$data['petty_balance'] = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $_SESSION['user_info']['employee_id']),'id','DESC','row');
			$data['title_info'] = 'Petty Cash Request'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/petty_cash_request',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end petty_cash_request---
	
	
	//start loan_money_request  ------------- 
	public function loan_money_request(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['send_request'])){
				$emp = $this->Dashboard_model->select('employee',array( 'id' => $this->input->post('employee_id')),'id','desc','row');

				$current_date = new DateTime(date('Y-m-d'));
				$advance_salary_date = new DateTime('first day of last month');

				$already_taken_advance_info = $this->Dashboard_model->mysqlij("SELECT * from employee_grant_loan where employee_id = '" . $emp->employee_id . "' AND data LIKE '%" . $current_date->format('m/Y') . "%' AND aproval != 2 AND aproval_account != 2");
				if (!is_null($already_taken_advance_info)) {
					alert('warning','Advance salary already applied for this month!');
					redirect(current_url());
				}

				$joining_date = new DateTime(date('d/m/Y', strtotime($emp->date_of_joining)));
				$joining_date_diff_till_today = $current_date->diff($joining_date);
				// if ($joining_date_diff_till_today->m <= 3) {
				// 	alert('warning','You are not yet eligible!');
				// 	redirect(current_url());
				// }
				$year_substr = substr($advance_salary_date->format('Y'), 2, 2);
				$total_attendence = $this->Dashboard_model->mysqlij("SELECT COUNT(DISTINCT(employee_attendence.days)) as total_days from employee_attendence WHERE employee_attendence.month = '" . $advance_salary_date->format('m') . "' AND employee_attendence.years = '$year_substr' AND employee_attendence.employee_id = '" . $emp->employee_id . "' AND employee_attendence.days not in (SELECT employee_everyday_leave_logs.days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_everyday_leave_logs.month = '" . $advance_salary_date->format('m') . "' AND employee_everyday_leave_logs.year = '" . $advance_salary_date->format('Y') . "' AND employee_leave_logs.employee_id = '" . $emp->employee_id . "' AND employee_everyday_leave_logs.status = 1)");
				// $total_attendence = $this->Dashboard_model->mysqlij("SELECT COUNT(DISTINCT(days)) as total_days from employee_attendence WHERE month = '" . $advance_salary_date->format('m') . "' AND years = '$year_substr' AND employee_id = '" . $emp->employee_id . "'");
				$total_abscent = $this->Dashboard_model->mysqlij("SELECT COUNT(DISTINCT(employee_leave_logs.days)) as total_days from employee_leave_logs INNER JOIN employee_everyday_leave_logs USING (unique_id) WHERE employee_leave_logs.month = '" . $advance_salary_date->format('m') . "' AND employee_leave_logs.year = '" . $advance_salary_date->format('Y') . "' AND employee_id = '" . $emp->employee_id . "' AND employee_leave_logs.aproval = '1' AND employee_everyday_leave_logs.status = '1'");
				$total_working_days = (int)$total_attendence->total_days;

				$basic_salary = $total_working_days * $emp->basic_salary;

				$total_increment = 0;
				$increments = $this->Dashboard_model->mysqlii("SELECT * from employee_increament_logs where employee_id = '" . $emp->employee_id . "' AND status = 1 AND aproval = 1");
				foreach ($increments as $increment) {
					$increment_starting_date = new DateTime(date('d/m/Y', strtotime($increment->start_date)));

					if ($increment_starting_date < $advance_salary_date) {
						$total_increment += $increment->amount * $total_working_days;
						continue;
					}

					$increment_total_days = (int)$increment_starting_date->format('t') - (int)$increment_starting_date->format('d');
					$total_increment += $increment->amount * $increment_total_days;
				}

				$total_decrement = 0;
				$decrements = $this->Dashboard_model->mysqlii("SELECT * from employee_decreament_logs where employee_id = '" . $emp->employee_id . "' AND status = 1 AND aproval = 1");
				if (!is_null($decrements)) {
					foreach ($decrements as $decrement) {
						$decrement_starting_date = new DateTime(date('d/m/Y', strtotime($decrement->start_date)));

						if ($decrement_starting_date < $advance_salary_date) {
							$total_decrement += $decrement->amount * $total_working_days;
							continue;
						}

						$decrement_total_days = (int)$decrement_starting_date->format('t') - (int)$decrement_starting_date->format('d');
						$total_decrement += $decrement->amount * $decrement_total_days;
					}
				}

				$tota_salary = $basic_salary + $total_increment + $total_decrement;
				$advance_limit = $tota_salary / 2;

				if ($advance_limit < 0) {
					$advance_limit = 0;
				}

				if ($advance_limit < $_POST['amount']) {
					alert('warning','Limit exceeded! Limit is: ' . money($advance_limit) . ". Working days ($total_working_days days)");
					// alert('warning','Limit exceeded! Limit is: ' . money($advance_limit));
					redirect(current_url());					
				}
				$insert_data = array(
					'id' => '',
					'e_db_id' => $emp->id,
					'employee_id' => $emp->employee_id,
					'amount' => $this->input->post('amount'),
					'note' => $this->input->post('note'),
					'aproval' => '3',
					'aproval_account' => '0',
					'status' => '1',
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if( $this->Dashboard_model->insert('employee_grant_loan',$insert_data) ){
					alert('success','Successfully Saved!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}			
		
			$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_grant_loan where e_db_id = '".$_SESSION['super_admin']['employee_id']."' order by id DESC limit 100");
			$data['title_info'] = 'Loan Request'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/loan_money_request',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end loan_money_request---
	
	//start attendance_adsjustment  ------------- 
	public function attendance_adsjustment(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['submit'])){
				$unique_id = time() * rand();
				$employee_id = $this->input->post('employee_id');				
				$note = $this->input->post('note');				
				$number_of_days = count($this->input->post('adj_date'));
				foreach($this->input->post('adj_date') as $key=>$row){
					$d = explode('-',$row);
					$days = $d[2];
					$month = $d[1];
					$years = $d[0];
					$adj_date = $days.'/'.$month.'/'.$years;
					$table = 'employee_missing_attendance_request_date';
					$where = "  adj_date='$adj_date' and employee_id='$employee_id'  ";
					$col_count = $this->Dashboard_model->con_count($table, $where);
					//print($col_count); exit();
					if($col_count < 1){
						$data_date[] = array(
							'id' => '',
							'unique_id' => $unique_id,
							'employee_id' => $employee_id,
							'adj_date' => $adj_date,
							'days' => $days,
							'month' => $month,
							'years' => $years,
							'adj_reason' => $this->input->post('adj_reason')[$key],
							'status' => '1',
							'is_hr_checked' => '0',						
							'hr_note' => '',						
							'aproval' => '0',
							'deduction_amount' => '0',
							'uploader_info' => uploader_info(),
							'data' => date('d/m/Y')
						);
					}
					
				}
				if(!empty($data_date)){
					$request_mange = array(
						'id' => '',
						'employee_id' => $employee_id,
						'unique_id' => $unique_id,
						'number_of_days' => $number_of_days,
						'status' => '1',
						'is_hr_checked' => '1',
						'hr_note' => '',
						'boss_note' => '',
						'aproval' => '1',
						'note' => $note,
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					if( 
						$this->Dashboard_model->insert_batch('employee_missing_attendance_request_date',$data_date) AND
						$this->Dashboard_model->insert('employee_missing_attendance_request',$request_mange)
					){
						$emp = $this->Dashboard_model->select('employee',array('employee_id' => $employee_id),'id','DESC','row');
						$emp_not = $this->Dashboard_model->select('employee',array('department' => '1383007286312996344', 'd_head' => '1'),'id','DESC','row');
						$emp_not_have = $this->Dashboard_model->select('employee',array('department' => '1383007286312996344'),'id','DESC','row');
						if(!empty($emp_not->id)){
							$user_id = $emp_not->employee_id;
						}else{
							$user_id = $emp_not_have->employee_id;
						}
						if(notification( 'Missing Attandance Request', $emp->full_name.' send missing Attendance Request', base_url().'admin/hrm/payroll/missing-attendence-request-logs-hr', $user_id, '', '1', uploader_info() )){
							notification( 'Missing Attandance Request', $emp->full_name.', Your missing Attendance Request sended Successfully to HR', base_url().'admin/profile/attendance-adsjustment', $emp->employee_id, '', '1', uploader_info() );
							alert('success','Successfully Applied!');
							redirect(current_url());
						}else{
							alert('success','Successfully Applied! But Notification not Sended!');
							redirect(current_url());
						}
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
					
			}
			
			$data['title_info'] = 'Employee Attendance Adsjustment'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/attendance_adsjustment',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end attendance_adsjustment---
	
	//start missing_attendence_request_logs_hr  ------------- 
	public function missing_attendence_request_logs_hr(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			

			$data['title_info'] = 'Employee Attendance HRM Check'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/missing_attendence_request_logs_hr',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end missing_attendence_request_logs_hr---
	
	//start attendance_adsjustment_boss_aproval  ------------- 
	public function attendance_adsjustment_boss_aproval(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			

			$data['title_info'] = 'Employee Attendance Boss Aproval'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/attendance_adsjustment_boss_aproval',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end attendance_adsjustment_boss_aproval---
	
	
	//start instant_transaction_other_transaction  ------------- 
	public function instant_transaction_other_transaction(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			
			
			
			$data['branch_code'] = $this->Dashboard_model->select('branches',array('branch_id' => $_SESSION['super_admin']['branch']),'id','DESC','row');
			$data['petty_balance'] = $this->Dashboard_model->select('branch_petty_cash',array('branch_id' => $_SESSION['super_admin']['branch']),'id','DESC','row');
			$data['title_info'] = 'Other Transaction'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/instant_transaction_other_transaction',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end instant_transaction_other_transaction---
	
	
	
	//start front_office_setup  ------------- 
	public function front_office_setup(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['add_purpose'])){
				$content_type = $this->input->post('type');
				$content_name = $this->input->post('type_name');
				$content_description = $this->input->post('note');
				$che_con = array(
					'type' => $content_type,
					'content' => $content_name
				);
				$check_item = $this->Dashboard_model->select('fornt_office_category',$che_con,'id','ASC','result');
				$data = array(
					'type' => $content_type,
					'content' => $content_name,
					'note' => $this->input->post('note'),
					'status' => '1',
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if(!empty($check_item->id)){
					alert('warning','Item All ready Exixt! Please try again');
					redirect(current_url());
				}else{
					if($this->Dashboard_model->insert('fornt_office_category',$data)){
						alert('success','Item Added successfully!');
						redirect(current_url());
					}else{
						alert('danger','something wrong! Please try again');
						redirect(current_url());
					}
				}
			}
			
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['fr_ctg'] = $this->Dashboard_model->select('fornt_office_category',$condition1,'id','ASC','result');
			$data['banches'] = $this->Dashboard_model->select('branches',$condition1,'id','ASC','result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category',$condition,'id','asc','result');
			$data['title_info'] = 'Front Office Setup'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/front_office_setup',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end front_office_setup---
	
	//start booking_enquery  ------------- 
	public function booking_enquery(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				$data = array(
					'branch_id' => rahat_decode($this->input->post('branch')),
					'generate_id' => $this->input->post('generate_id'),
					'name' => $this->input->post('name'),
					'phone' => $this->input->post('phone'),
					'email' => $this->input->post('email'),
					'address' => $this->input->post('address'),
					'description' => $this->input->post('description'),
					'note' => $this->input->post('note'),
					'date' => $this->input->post('date'),
					'n_date' => $this->input->post('n_date'),
					'referance_id' => $this->input->post('referance_id'),
					'h_t_f_u' => $this->input->post('h_t_f_u'),
					'status' => '1',
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				// var_dump($data);
				// exit();
				if($this->Dashboard_model->insert('booking_enquery',$data)){
					$sms_body = 'Thank You! Dear, '.$this->input->post('name').' for your enquery. Your Enquery ID: '.$this->input->post('generate_id').'. You Can use your id for buy anything from us. For any Query Feel free to call US +8809638666333';
					if(sendsms($this->input->post('phone'),$sms_body)){
						alert('success','Information save successfully in Enquery book');
						redirect(current_url());
					}else{ 
						alert('danger','Something Wrong in SMS section! Please Try Again');
						redirect(current_url());
					}
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches',$condition1,'id','ASC','result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category',$condition,'id','asc','result');
			$data['title_info'] = 'Booking Enquery'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/booking_enquery',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end booking_enquery---
	
	//start pre_book_and_pre_booking_form  ------------- 
	public function pre_book_and_pre_booking_form(){
		$data = array();
		$condition = array(
			'status' => '1'
		);
		if(isset($_POST['from_pkg_pln'])){
			$data['from_pkg_pln'] = 'yes';
			$data['package_id'] = $_POST['package_id'];
			$data['branch_id'] = $_POST['branch_id'];
			$data['checkin_date'] = $_POST['checkin_date'];
			if(isset($_POST['parking'])){
				$data['parking'] = $_POST['parking'];
			}else{
				$data['parking'] = '';
			}
			if(isset($_POST['locker'])){
				$data['locker'] = $_POST['locker'];
			}else{
				$data['locker'] = '';
			}
			if(isset($_POST['payment'])){
				$data['payment'] = $_POST['payment'];
			}else{
				$data['payment'] = 'full';
			}
		}
		$data['live_chat'] = 'Live chat Desiable';
		$data['banches'] = $this->Dashboard_model->select('branches',$condition,'id','ASC','result');
		$data['package_category'] = $this->Dashboard_model->select('packages_category',$condition,'id','asc','result');
		$data['title_info'] = 'Pre Booking & Police Verification Form'; 
		$data['article'] = $this->load->view('template/front_office/pre_book_and_pre_booking_form',$data,TRUE); 
		//$data['footer'] = $this->load->view('include/footer','',TRUE); 
		$this->load->view('dashboard',$data);

	}
	//--- end pre_book_and_pre_booking_form---
	
	
	//start visitor_book  ------------- 
	public function visitor_book(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				$data = array(
					'branch_id' => $_SESSION['super_admin']['branch'],
					'generate_id' => $this->input->post('generate_id'),
					'name' => $this->input->post('name'),
					'phone' => $this->input->post('phone'),
					'reason' => $this->input->post('Reason'),
					'department' => $this->input->post('department'),
					'designation' => $this->input->post('designation'),
					'note' => '',
					'status' => '1',
					'uploader_info' => $_SESSION['super_admin']['email'],
					'data' => date('d/m/Y'),
					'In_time' => date('h:i:sa'),
					'out_time' => ''
				);
				if($this->Dashboard_model->insert('visitor_book',$data)){
					if($this->input->post('Reason') == 'Mobile Visitor'){
						$sms_body = 'Thank You! Dear, '.$this->input->post('name').' for Calling us. For Booking Click Here: https://superhomebd.com For any Query Feel free to call US +8809638666333';
					} else if($this->input->post('Reason') == 'Visitor'){
						$sms_body = 'Thank You! Dear, '.$this->input->post('name').' for Visiting in our SUPER HOME. Your Visitor ID: '.$this->input->post('generate_id').'. You Can use your id for buy anything from us. For Booking Click Here: https://superhomebd.com';
					} else if($this->input->post('Reason') == 'Candidate'){
						$sms_body = 'Dear, '.$this->input->post('name').', Welcome to NEWAYS INTERNATIONAL for Interview, Best of luck. Please install our apps and Fillup Your Information here: http://erp.superhostelbd.com/downloadapp/SuperHomeApp.apk ,Your Candidate ID: '.$this->input->post('generate_id').'. You Can use your id for buy anything from us, Thank You!';
					} else if($this->input->post('Reason') == 'Vendor'){
						$sms_body = 'Thank You! Dear, '.$this->input->post('name').', Thank you for Co-oparate us. Your Visitor ID: '.$this->input->post('generate_id').'. You Can use your id for buy anything from us. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/';
					}else {
						$sms_body = 'Thank You! Dear, '.$this->input->post('name').', Welcome to SUPER HOME. Your Visitor ID: '.$this->input->post('generate_id').'. You Can use your id for buy anything from us. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/';
					}				
					if(sendsms($this->input->post('phone'),$sms_body)){
						alert('success','Information save successfully in Visitor book');
						redirect(current_url());						
					}else{ 
						alert('danger','Something Wrong in SMS section! Please Try Again');
						redirect(current_url());
					}
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['designation'] = $this->Dashboard_model->select('designation',$condition1,'id','ASC','result');
			$data['department'] = $this->Dashboard_model->select('department',$condition1,'id','ASC','result');
			$data['banches'] = $this->Dashboard_model->select('branches',$condition1,'id','ASC','result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category',$condition,'id','asc','result');
			$data['title_info'] = 'Visitor Book'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/visitor_book',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end visitor_book---
	
	//start new_employee_details_form  ------------- 
	public function new_employee_details_form(){
		$data = array();
		if(isset($_POST['save_submit'])){
			if(!empty($_POST['photo_avater'])){
				$photo = $_POST['photo_avater']; //image_upload('avater_photo','240','320','100');
			}else{
				$photo = '';
			}					
			if(!empty($_POST['photo_avater_one'])){ //photo_avater_one
				$emergency_attachment_1 = $_POST['photo_avater_one'];
			}else{
				$emergency_attachment_1 = '';
			}
			if(!empty($_POST['photo_avater_two'])){ //photo_avater_two
				$emergency_attachment_2 = $_POST['photo_avater_two'];
			}else{
				$emergency_attachment_2 = '';
			}
			if(!empty($this->input->post('qualification'))){
				$qualification = implode(",",$this->input->post('qualification'));
			}else{
				$qualification = '';
			}
			$data = array(
				'id' => '',				
				'f_name' 						=> $this->input->post('f_name'),
				'l_name' 						=> $this->input->post('l_name'),
				'full_name' 					=> $this->input->post('f_name').' '.$this->input->post('l_name'),
				'father_name' 					=> $this->input->post('father_name'),
				'mother_name' 					=> $this->input->post('mother_name'),
				'gender' 						=> $this->input->post('gender'),
				'marital_status' 				=> $this->input->post('marital_status'),
				'date_of_birth' 				=> $this->input->post('date_of_birth'),
				'date_of_joining' 				=> $this->input->post('date_of_joining'),
				'blood_group' 					=> $this->input->post('blood_group'),
				'personal_Phone' 				=> $this->input->post('personal_Phone'),
				'email' 						=> $this->input->post('email'),
				'photo' 						=> $photo,
				'nid_number' 					=> $this->input->post('nid_number'),							
				'emergency_contact_name' 		=> $this->input->post('emergency_name1'),
				'emergency_contact_relation' 	=> $this->input->post('emergency_relation1'),				
				'emergency_no1' 				=> $this->input->post('emergency_no1'),					
				'emergency_contact_name2'		=> $this->input->post('emergency_name2'),
				'emergency_contact_relation2'	=> $this->input->post('emergency_relation2'),
				'emergency_no2' 				=> $this->input->post('emergency_no2'),				
				'current_address' 				=> $this->input->post('current_address'),
				'permanent_address' 			=> $this->input->post('permanent_address'),
				'qualification' 				=> $qualification,				
				'work_exp'						=> $this->input->post('work_exp'),				
				'previus_company' 				=> $this->input->post('previus_company'),
				'previus_designation' 			=> $this->input->post('previus_designation'),
				'reason_leave' 					=> $this->input->post('reason_leave'),				
				'note' 							=> $this->input->post('note'),						
				'facebook' 						=> $this->input->post('facebook'),
				'twitter' 						=> $this->input->post('twitter'),
				'linkedin' 						=> $this->input->post('linkedin'),
				'instagram' 					=> $this->input->post('instagram'),
				'status' 						=> '1',
				'data' 							=> date('d/m/Y')
			);
			$condition = array('employee_id' => $this->input->post('employee_id'));
			$check = $this->Dashboard_model->select('employee',$condition,'id','ASC','result');
			if(empty($check->employee_id)){
				$condition2 = array('email' => $this->input->post('email'));
				$check2 = $this->Dashboard_model->select('employee',$condition2,'id','ASC','result');
				if(empty($check2->email)){
					if($this->Dashboard_model->insert('prebook_employee',$data)){
						alert('success','Successfully Submitted!');
						redirect(base_url('admin'));
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}else{
					alert('warning','Employee Email All Ready Exixt! Please Try Again');
					redirect(current_url());
				}
			}else{
				alert('warning','EmployeeID All Ready Exixt! Please Try Again');
				redirect(current_url());
			}
		}
		
		
		$condition = array(
			'status' => '1'
		);
		$data['banches'] = $this->Dashboard_model->select('branches',$condition,'id','ASC','result');
		$data['title_info'] = 'Employee Details Information Form'; 
		$data['article'] = $this->load->view('template/front_office/new_employee_details_form',$data,TRUE); 
		$data['footer'] = $this->load->view('include/footer','',TRUE); 
		$this->load->view('dashboard',$data);
	}
	//--- end new_employee_details_form---
	
	//start front_office_music_player  ------------- 
	public function front_office_music_player(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$hour = date('Hi');
			$data['time'] = $hour;
			$data['videoss'] = $this->Dashboard_model->mysqlii("SELECT * FROM music_videos where h_from <= '".$hour."' AND h_to >= '".$hour."' order by rand() desc");
			$data['title_info'] = 'Video Music Player'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/front_office_music_player',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end front_office_music_player---
	
	//start front_office_audio_music_player  ------------- 
	public function front_office_audio_music_player(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
		
			$data['title_info'] = 'Audio Music Player'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/front_office_audio_music_player',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end front_office_audio_music_player---
	
	//start add_food_menu  ------------- 
	public function add_food_menu(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				if($_FILES['food_image']['name'] != ''){
					$image_file = file_upload_food_menue('food_image');
				}else{
					$image_file = '';
				}
				// $branch = 2;
				// for($i=0; $i<$branch;$i++){
			if( isset($_POST['branch_id'])){
				foreach($_POST['branch_id'] as $branch_id){
					foreach($_POST['week'] as $week){
						foreach($_POST['day'] as $day){
							$data = array(
								'id ' => '',
								'food_code' => $this->input->post('food_code'),
								'branch_id' => $branch_id,
								'week' => $week,
								'day' => $day,
								'meal_type' => $this->input->post('meal_type'),
								'food_title' => $this->input->post('food_title'),
								'food_image' => $image_file,
								'note' => $this->input->post('note'),
								'status' => '1',
								'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
								'data' => date('d/m/Y')
							);
							if($this->Dashboard_model->insert('food_menu',$data)){
								alert('success','Successfully Submitted!');
								
							}else{
								alert('danger','Something Wrong! Please Try Again');
								redirect(current_url());
							}
						}
					}
				}
				redirect(current_url());
			}
			}
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches',$condition1,'id','ASC','result');
			
			$data['title_info'] = 'Add Food Menu'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/add_food_menu',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end add_food_menu---
	
	//start manage_food_menu  ------------- 
	public function manage_food_menu(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				if($_FILES['food_image']['name'] != ''){
					$image_file = file_upload_food_menue('food_image');
				}else{
					$image_file = '';
				}
				$data = array(
					'id ' => '',
					'food_code' => $this->input->post('food_code'),
					'branch_id' => $this->input->post('branch_id'),
					'meal_type' => $this->input->post('meal_type'),
					'food_title' => $this->input->post('food_title'),
					'food_image' => $image_file,
					'note' => $this->input->post('note'),
					'status' => '1',
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->insert('food_menu',$data)){
					alert('success','Successfully Submitted!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if(isset($_POST['update'])){					
			
				$date_time = date("Y:m:d H:i:s");
				$acc = array(
					'name' => $_POST['acc_name'],
					'present_amount' => $_POST['acc_amount'],
					'updated_at' => $date_time,
					'updated_by' => $_SESSION['super_admin']['employee_ids']
				);
				if($this->Dashboard_model->update('acc_manage',$acc,$_POST['update_id'])){
					alert('success','Account Updated!');
					redirect(base_url('admin/accounting/manage-account'));
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}			
			if(isset($_POST['edit'])){
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('food_menu',$where,'id','desc','row');
			}
			$condition1 = array(
				'status' => '1'
			);
			$data['foodmenu'] = $this->Dashboard_model->select('food_menu','','id','ASC','result');
			$data['title_info'] = 'Manage Food Menu'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/manage_food_menu',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	public function menu_delete()
    {
        if($this->Dashboard_model->delete('food_menu',$this->input->post('menu_id'))){
            alert('danger','Deleted Food Menu!');
            redirect(base_url('admin/front-office/manage-food-menu'));
        }else{
            alert('danger','Something Wrong! Please Try Again');
            redirect(current_url());
        }
    }
	public function menu_update()
    {
        $date_time = date("Y:m:d H:i:s");
        $product_type = array(
            'food_title' => $_POST['food_title'],
            'meal_type' => $_POST['meal_type'],
            'week' => $_POST['week'],
            'day' => $_POST['day'],
            // 'updated_at' => $date_time,
            // 'updated_by' => $_SESSION['super_admin']['employee_ids']
        );
        if($this->Dashboard_model->update('food_menu',$product_type,$_POST['type_id'])){
            alert('success','Updated Food Menu!');
            redirect(base_url('admin/front-office/manage-food-menu'));
        }else{
            alert('danger','Something Wrong! Please Try Again');
            redirect(current_url());
        }
    }
	//--- end manage_food_menu---
	
	//start add_feedback_emoji  ------------- 
	public function add_feedback_emoji(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				if($_FILES['emoji_image']['name'] != ''){
					$image_file = file_upload_food_menue('emoji_image');
				}else{
					$image_file = '';
				}
				$data = array(
					'id ' => '',
					'feedback_cade' => $this->input->post('feedback_cade'),
					'feed_back_value' => $this->input->post('feed_back_value'),
					'feedback_title_english' => $this->input->post('feedback_title_english'),
					'feedback_title_bangla' => $this->input->post('feedback_title_bangla'),
					'emoji_image' => $image_file,
					'note' => $this->input->post('note'),
					'status' => '1',
					'uploader_info' => $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'],
					'data' => date('d/m/Y')
				);
				if($this->Dashboard_model->insert('food_feedback_emoji',$data)){
					alert('success','Successfully Submitted!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$data['title_info'] = 'Add Feedback Emoji'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/add_feedback_emoji',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end add_feedback_emoji---
	
	//start manage_feedback_emoji  ------------- 
	public function manage_feedback_emoji(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['delete'])){
				if($this->Dashboard_model->delete('food_feedback_emoji',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			$condition1 = array(
				'status' => '1'
			);
			$data['emoji'] = $this->Dashboard_model->mysqlii("select * from food_feedback_emoji where status = '1' order by feed_back_value desc limit 05");
			$data['title_info'] = 'Manage Feedback Emoji'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/front_office/manage_feedback_emoji',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	//--- end manage_feedback_emoji---
	
	//start food_feedback_page  ------------- 
	public function food_feedback_page(){
		$data = array();
		
		$data['emoji'] = $this->Dashboard_model->select('food_feedback_emoji',array( 'status' => '1' ),'feed_back_value','ASC','result');
		$data['title_info'] = 'Member Food Feedback Hub'; 
		$data['article'] = $this->load->view('template/front_office/food_feedback_page',$data,TRUE); 
		$data['footer'] = $this->load->view('include/footer','',TRUE); 
		$this->load->view('dashboard',$data);		
	}
	//--- end food_feedback_page---
	
	//start package_plane  ------------- 
	public function package_plane(){
		$data = array();
		
		$data['title_info'] = 'Package Plane';
		$data['article'] = $this->load->view('template/front_office/package_plane',$data,TRUE); 
		$data['footer'] = $this->load->view('include/footer','',TRUE); 
		$this->load->view('dashboard',$data);

	}
	//--- end package_plane---

	//start package_plan  ------------- 
	public function package_plan(){
		$data = array();
        $data['branches'] = $this->Dashboard_model->mysqlii('SELECT packages.branch_name, branches.branch_location, branches.branch_id from packages inner join branches using (branch_id) group by branch_name');

		$data['title_info'] = 'Package Plane';
		$data['article'] = $this->load->view('template/front_office/package_plan',$data,TRUE); 
		$data['footer'] = $this->load->view('include/footer','',TRUE); 
		$this->load->view('dashboard',$data);

	}
	//--- end package_plan---
	
	
	public function attendance_adsjustment_delete($id){
		$sql = "delete employee_missing_attendance_request, employee_missing_attendance_request_date from employee_missing_attendance_request
			inner join employee_missing_attendance_request_date 
			on employee_missing_attendance_request_date.unique_id = employee_missing_attendance_request.unique_id
			where employee_missing_attendance_request.id = '$id'
		";
		$this->db->query($sql);
		
		alert('success','Request Deleted Successfully !');
		redirect("admin/profile/attendance-adsjustment");
	}
	
	
	public function attendance_adsjustment_boss_aproval_delete($id){
		
		$sql = "delete employee_missing_attendance_request, employee_missing_attendance_request_date from employee_missing_attendance_request
			inner join employee_missing_attendance_request_date 
			on employee_missing_attendance_request_date.unique_id = employee_missing_attendance_request.unique_id
			where employee_missing_attendance_request.id = '$id'
		";
		$this->db->query($sql);
		
		alert('success','Request Deleted Successfully !');
		redirect("admin/profile/attendance-adsjustment-boss-aproval");
	}
	
	public function missing_attendence_request_logs_hr_delete($id){
		$sql = "delete employee_missing_attendance_request, employee_missing_attendance_request_date from employee_missing_attendance_request
			inner join employee_missing_attendance_request_date 
			on employee_missing_attendance_request_date.unique_id = employee_missing_attendance_request.unique_id
			where employee_missing_attendance_request.id = '$id'
		";
		$this->db->query($sql);
		
		alert('success','Request Deleted Successfully !');
		redirect("admin/hrm/payroll/missing-attendence-request-logs-hr");
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
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
