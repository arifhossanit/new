<?php 
include("../../../application/config/ajax_config.php");
function payment_varient($tnsid,$branch_id,$booking_id,$payment_method,$payment_details,$card_amount,$cash_amount,$mobile_amount,$check_amount,$uploader_info,$table){
	global $mysqli;
	global $db;
	$invoice_id = mysqli_fetch_assoc($mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = '".$table."'"));
	$inv_id = date('dmY').$invoice_id['AUTO_INCREMENT'];
	if($mysqli->query("insert into ipo_payment_received_method values(
		'',
		'".$mysqli->real_escape_string($tnsid)."',
		'".$mysqli->real_escape_string($branch_id)."',
		'".$mysqli->real_escape_string($booking_id)."',
		'".$mysqli->real_escape_string($payment_method)."',
		'".$mysqli->real_escape_string($payment_details)."',
		'".$mysqli->real_escape_string($card_amount)."',
		'".$mysqli->real_escape_string($cash_amount)."',
		'".$mysqli->real_escape_string($mobile_amount)."',
		'".$mysqli->real_escape_string($check_amount)."',
		'".$mysqli->real_escape_string($inv_id)."',
		'',
		'1',
		'".$mysqli->real_escape_string($uploader_info)."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."',
		'".$mysqli->real_escape_string($_SESSION['super_admin']['employee_ids'])."',
		'',
		''
	)")){
		return true;
	}else{
		return false;
	}		
}
if(isset($_POST['ipo_registration_token'])){ //isset post
	if($_POST['member_type'] == 'new'){
		$ipo_id = date('d_m_Y__h_i_s_A').'_'.rand().'_'.rand() * time().'_'.md5(time());
		$purses_code = md5(rand() * time());
		$generated_password = spc_chr_mm(8);
		if(!empty($_POST['nominee_name'])){ $nominee_name = $_POST['nominee_name']; }else{ $nominee_name = ''; }
		if(!empty($_POST['nominee_phone_number'])){ $nominee_phone_number = $_POST['nominee_phone_number']; }else{ $nominee_phone_number = ''; }
		if(!empty($_POST['nominee_date_of_birth'])){ $nominee_date_of_birth = date_converter($_POST['nominee_date_of_birth']); }else{ $nominee_date_of_birth = ''; }
		if(!empty($_POST['nominee_email'])){ $nominee_email = $_POST['nominee_email']; }else{ $nominee_email = ''; }
		if(!empty($_POST['nominee_nid_card'])){ $nominee_nid_card = $_POST['nominee_nid_card']; }else{ $nominee_nid_card = ''; }
		if($_FILES['nominee_nid_attachment']['name'] != ''){
			$nominee_nid_attachment = ipo_image_and_file_upload('nominee_nid_attachment','ipo_nominee_document');
		}else{
			$nominee_nid_attachment = '';
		}
		if(!empty($_POST['nominee_relation'])){ $nominee_relation = $_POST['nominee_relation']; }else{ $nominee_relation = ''; }
		if($_FILES['nominee_images']['name'] != ''){
			$nominee_images = ipo_image_and_file_upload('nominee_images','ipo_nominee_document');
		}else{
			$nominee_images = '';
		}	
		if($_FILES['personal_nid_attachment']['name'] != ''){
			$personal_nid_attachment = ipo_image_and_file_upload('personal_nid_attachment','ipo_personal_document');
		}else{
			$personal_nid_attachment = '';
		}	
		if($_FILES['personal_images']['name'] != ''){
			$personal_images = ipo_image_and_file_upload('personal_images','ipo_personal_document');
		}else{
			$personal_images = '';
		}	
		if(count($_FILES['bank_attachment']['name']) > 0){
			$bank_attachment_var = '';
			foreach($_FILES['bank_attachment']['name'] as $k => $v ){
				$bank_attachment_var .= ipo_image_and_file_upload_multiple($_FILES['bank_attachment']['name'][$k], $_FILES['bank_attachment']['tmp_name'][$k], 'ipo_bank_document').',';
			}
			$bank_attachment = rtrim($bank_attachment_var,',');
		}else{
			$bank_attachment = '';
		}		
		if(!empty($_POST['nominee_address'])){ $nominee_address = $_POST['nominee_address']; }else{ $nominee_address = ''; }
		if(!empty($_POST['note'])){ $note = $_POST['note']; }else{ $note = ''; }
		$check_data_1 = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where personal_phone_number = '".$_POST['personal_phone_number']."'"));
		if(count($_FILES['ipo_attachment']['name']) > 0 ){
			$ipo_attachment_var = '';
			foreach($_FILES['ipo_attachment']['name'] as $k => $v ){
				$ipo_attachment_var .= ipo_image_and_file_upload_multiple($_FILES['ipo_attachment']['name'][$k], $_FILES['ipo_attachment']['tmp_name'][$k], 'ipo_document').',';
			}		
			$ipo_attachment = rtrim($ipo_attachment_var,',');
		}else{
			$ipo_attachment = '';
		}
		$bed_status = '1';
		if(!empty($check_data_1['personal_phone_number']) AND $check_data_1['personal_phone_number'] == $_POST['personal_phone_number']){
			echo 'Phone Number allready Exixt! Please try again.____1';
		}else{
			$check_data_2 = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where personal_email = '".$_POST['personal_email']."'"));
			if(!empty($check_data_2['personal_email']) AND $check_data_2['personal_email'] == $_POST['personal_email']){
				echo 'Email allready Exixt! Please try again.____1';
			}else{
				$check_data_3 = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where card_number = '".$_POST['card_number']."'"));
				if(!empty($check_data_3['card_number']) AND $check_data_3['card_number'] == $_POST['card_number']){
					echo 'Card Number Exixt! Please try again.____1';
				}else{
					$check_data_4 = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where personal_nid_card = '".$_POST['personal_nid_card']."'"));
					if(!empty($check_data_4['personal_nid_card']) AND $check_data_4['personal_nid_card'] == $_POST['personal_nid_card']){
						echo 'NID Number Exixt! Please try again.____1';
					}else{				
						if(!isset($_SESSION['cart_gen_code'])){
							echo 'IPO Cart is Empty! Please try again.____1';
						}else{
							if(!isset($_SESSION['super_admin']['branch'])){
								echo 'System user session not found! Please logout & login again.____1';
							}else{
								$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));
								$utime = sprintf('%.4f', microtime(TRUE)); 
								$raw_time = DateTime::createFromFormat('U.u', $utime);  
								$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
								$today = $raw_time->format('dmy-his-u');
								$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
								$transaction_id = $bc['branch_code'].'-'.$today;
								$transaction_idO = $transaction_id;
								
								$payment_method = '';
								$data_one = '';
								$data_two = '';
								$data_three = '';
								$payment_details = '';
								$p_branch_id = $bc['branch_id'];
								$p_booking_id = $ipo_id;
								$p_uploader_info = uploader_info();
								$p_table = 'ipo_purses_information';						
								
								foreach($_POST['payment_method'] as $row => $value){		
									if($_POST['payment_method'][$row] == 'Mobile Banking'){ 
										$payment_details = 'Agent Name: '.$_POST['agent'][$row].', Mobile Banking Number: '.$_POST['mobile_banking_number'][$row].' Transaction Id: '.$_POST['transaction_id'][$row].'';			
										$data_one .= $_POST['payment_method'][$row].' | Agent Name | '.$_POST['agent'][$row].',';
										$data_two .= $_POST['payment_method'][$row].' | Mobile Banking Number | '.$_POST['mobile_banking_number'][$row].',';
										$data_three .= $_POST['payment_method'][$row].' | Transaction Id | '.$_POST['transaction_id'][$row].' | Amount | '.$_POST['mobile_amount'][$row].',';
										$payment_method .= $_POST['payment_method'][$row].',';
										if($_POST['mobile_amount'][$row] > 0){
											payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','',$_POST['mobile_amount'][$row],'',$p_uploader_info,$p_table);
										}
									}else if($_POST['payment_method'][$row] == 'Credit / Debit Card'){			
										$payment_details = 'Credit Card Number: '.$_POST['credit_card_number'][$row].' Card Secret: '.$_POST['card_secret'][$row].' Expiry Date: '.$_POST['Expiry_Date'][$row].'';			
										$data_one .= $_POST['payment_method'][$row].' | Credit Card Number | '.$_POST['credit_card_number'][$row].',';
										$data_two .= $_POST['payment_method'][$row].' | Card Secret | '.$_POST['card_secret'][$row].',';
										$data_three .= $_POST['payment_method'][$row].' | Expiry Date | '.$_POST['Expiry_Date'][$row].' | Amount | '.$_POST['card_amount'][$row].',';
										$payment_method .= $_POST['payment_method'][$row].',';
										if($_POST['Expiry_Date'][$row] > 0){
											payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,(float)$_POST['card_amount'][$row] + (float)$_POST['Expiry_Date'][$row],'','','',$p_uploader_info,$p_table);
										}
									}else if($_POST['payment_method'][$row] == 'Check'){			
										$payment_details = 'Bank Name: '.$_POST['bank_name'][$row].' Check Number: '.$_POST['check_number'][$row].' Withdraw Date: '.$_POST['withdraw_date'][$row].'';
										$data_one .= $_POST['payment_method'][$row].' | Bank Name | '.$_POST['bank_name'][$row].',';
										$data_two .= $_POST['payment_method'][$row].' | Check Number | '.$_POST['check_number'][$row].',';
										$data_three .= $_POST['payment_method'][$row].' | Withdraw Date | '.$_POST['withdraw_date'][$row].' | Amount | '.$_POST['check_amount'][$row].',';
										$payment_method .= $_POST['payment_method'][$row].',';
										if($_POST['check_amount'][$row] > 0){
											payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','','',$_POST['check_amount'][$row],$p_uploader_info,$p_table);
										}
									}else{			
										if(!empty($_POST['cash_other_information_remarks'][$row])){
											$cash_other_information_remarks = $_POST['cash_other_information_remarks'][$row];
										}else{
											$cash_other_information_remarks = 'N / A';
										}
										$data_one .= $_POST['payment_method'][$row].' | More Information | '.$_POST['cash_other_information_remarks'][$row].' | Amount | '.$_POST['cash_amount'][$row].',';
										$data_two .= '';
										$data_three .= '';	
										$payment_details = 'More Information: '.$cash_other_information_remarks.'';
										$payment_method .= $_POST['payment_method'][$row].',';
										if($_POST['cash_amount'][$row] > 0){
											payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'',$_POST['cash_amount'][$row],'','',$p_uploader_info,$p_table);
										}
									}
								}
								
								$transaction_information = "insert into transaction values(
									'',
									'".$transaction_idO."',
									'".$mysqli->real_escape_string($bc['branch_id'])."',
									'".$mysqli->real_escape_string($ipo_id)."',
									'".$mysqli->real_escape_string($_POST['personal_full_name'])."',
									'Defult',
									'Defult',
									'".$mysqli->real_escape_string((float)$_POST['booking_total_amount'])."',
									'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
									'Credit',
									'IPO Account',
									'".$mysqli->real_escape_string($payment_method)."',
									'".$mysqli->real_escape_string($data_one)."',
									'".$mysqli->real_escape_string($data_two)."',
									'".$mysqli->real_escape_string($data_three)."',
									'IPO Money Collection',
									'1',
									'".$mysqli->real_escape_string(uploader_info())."',
									'".$mysqli->real_escape_string(date('d/m/Y'))."'
								)";
								
								$ipo_member_information_sql = "insert into ipo_member_directory values(
									'',
									'".$mysqli->real_escape_string($ipo_id)."',
									'".$mysqli->real_escape_string($_POST['personal_full_name'])."',
									'".$mysqli->real_escape_string($_POST['personal_phone_number'])."',
									'".$mysqli->real_escape_string(date_converter($_POST['personal_date_of_birth']))."',
									'".$mysqli->real_escape_string($_POST['personal_email'])."',
									'".$mysqli->real_escape_string($generated_password)."',
									'".$mysqli->real_escape_string($_POST['personal_nid_card'])."',
									'".$mysqli->real_escape_string($personal_nid_attachment)."',
									'".$mysqli->real_escape_string($personal_images)."',
									'".$mysqli->real_escape_string($_POST['personal_address'])."',
									'".$mysqli->real_escape_string($_POST['ipo_bank_name'])."',
									'".$mysqli->real_escape_string($_POST['account_holder_name'])."',
									'".$mysqli->real_escape_string($_POST['account_number'])."',
									'".$mysqli->real_escape_string($_POST['routing_number'])."',
									'".$mysqli->real_escape_string($_POST['bank_branch_name'])."',
									'".$mysqli->real_escape_string($bank_attachment)."',
									'".$mysqli->real_escape_string($_POST['bank_address'])."',
									'".$mysqli->real_escape_string($nominee_name)."',
									'".$mysqli->real_escape_string($nominee_phone_number)."',
									'".$mysqli->real_escape_string($nominee_date_of_birth)."',
									'".$mysqli->real_escape_string($nominee_email)."',
									'".$mysqli->real_escape_string($nominee_nid_card)."',
									'".$mysqli->real_escape_string($nominee_nid_attachment)."',
									'".$mysqli->real_escape_string($nominee_relation)."',
									'".$mysqli->real_escape_string($nominee_images)."',
									'".$mysqli->real_escape_string($nominee_address)."',
									'".$mysqli->real_escape_string($_POST['card_number'])."',
									'".$mysqli->real_escape_string($ipo_attachment)."',
									'".$mysqli->real_escape_string($note)."',
									'1',
									'0',
									'0',
									'".$mysqli->real_escape_string(uploader_info())."',
									'".$mysqli->real_escape_string(date('d/m/Y'))."'
								)";								
								if($_POST['condition'] == 'YES'){
									$get_cart_information = $mysqli->query("select * from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'");
									while($ipo_row = mysqli_fetch_assoc($get_cart_information)){
										$exp_date = new DateTime($ipo_row['expirity_date']);
										$exp_date->sub(new DateInterval('P1D'));
										$mysqli->query("insert into ipo_agreement_information values(
											'',
											'".$mysqli->real_escape_string($ipo_id)."',
											'".$mysqli->real_escape_string($purses_code)."',											
											'".$mysqli->real_escape_string($bc['branch_id'])."',
											'".$mysqli->real_escape_string($bc['branch_name'])."',											
											'',
											'',
											'',
											'',
											'',
											'',											
											'".$mysqli->real_escape_string($ipo_row['bed_id'])."',
											'".$mysqli->real_escape_string($ipo_row['bed_name'])."',											
											'".$mysqli->real_escape_string($ipo_row['type'])."',
											'".$mysqli->real_escape_string($ipo_row['aggrement_type'])."',											
											'".$mysqli->real_escape_string($ipo_row['unit_price'])."',											
											'".$mysqli->real_escape_string($ipo_row['qty'])."',
											'".$mysqli->real_escape_string($ipo_row['commission'])."',
											'".$mysqli->real_escape_string($ipo_row['price'])."',
											'".$mysqli->real_escape_string($ipo_row['tenure'])."',
											'".$mysqli->real_escape_string($exp_date->format('d/m/Y'))."',
											'',
											'1',
											'".$mysqli->real_escape_string(uploader_info())."',
											'".$mysqli->real_escape_string(date('d/m/Y'))."'
										)");
									}
								}else{								
									$get_cart_information = $mysqli->query("select * from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'");
									while($ipo_row = mysqli_fetch_assoc($get_cart_information)){
										$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$ipo_row['bed_id']."'"));
										/**
										 * Subtracting 1 Day from expiry date!
										 */
										$expiry_date = new DateTime(date($ipo_row['expirity_date']));
										$expiry_date->sub(new DateInterval('P1D'));

										$mysqli->query("insert into ipo_agreement_information values(
											'',
											'".$mysqli->real_escape_string($ipo_id)."',
											'".$mysqli->real_escape_string($purses_code)."',
											'".$mysqli->real_escape_string($bed_info['branch_id'])."',
											'".$mysqli->real_escape_string($bed_info['branch_name'])."',
											'".$mysqli->real_escape_string($bed_info['floor_id'])."',
											'".$mysqli->real_escape_string($bed_info['floor_name'])."',
											'".$mysqli->real_escape_string($bed_info['unit_id'])."',
											'".$mysqli->real_escape_string($bed_info['unit_name'])."',
											'".$mysqli->real_escape_string($bed_info['room_id'])."',
											'".$mysqli->real_escape_string($bed_info['room_name'])."',
											'".$mysqli->real_escape_string($bed_info['id'])."',
											'".$mysqli->real_escape_string($bed_info['bed_name'])."',
											'".$mysqli->real_escape_string($ipo_row['type'])."',
											'".$mysqli->real_escape_string($ipo_row['aggrement_type'])."',
											'".$mysqli->real_escape_string($ipo_row['unit_price'])."',
											'".$mysqli->real_escape_string($ipo_row['qty'])."',
											'".$mysqli->real_escape_string($ipo_row['commission'])."',
											'".$mysqli->real_escape_string($ipo_row['price'])."',
											'".$mysqli->real_escape_string($ipo_row['tenure'])."',
											'".$mysqli->real_escape_string($expiry_date->format('d/m/Y'))."',
											'',
											'1',
											'".$mysqli->real_escape_string(uploader_info())."',
											'".$mysqli->real_escape_string(date('d/m/Y'))."'
										)");
										$mysqli->query("update beds set
											ipo_uses = '".$mysqli->real_escape_string($bed_status)."'
											where id = '".$mysqli->real_escape_string($bed_info['id'])."'
										");
									}
								}							
								$ipo_purses_information = "insert into ipo_purses_information values(
									'',
									'".$mysqli->real_escape_string($ipo_id)."',
									'".$mysqli->real_escape_string($purses_code)."',
									'".$mysqli->real_escape_string(date('d/m/Y'))."',
									'".$mysqli->real_escape_string($_POST['actual_total_amount'])."',
									'".$mysqli->real_escape_string($_POST['booking_total_amount'])."',
									'".$mysqli->real_escape_string($payment_method)."',				
									'".$mysqli->real_escape_string($data_one)."',
									'".$mysqli->real_escape_string($transaction_idO)."',
									'".$mysqli->real_escape_string($data_three)."',
									'',
									'1',
									'".$mysqli->real_escape_string(uploader_info())."',
									'".$mysqli->real_escape_string(date('d/m/Y'))."'
								)";
								$old_blnc = $account_info['balance'];
								$new_blnc = $old_blnc + $_POST['booking_total_amount'];
								$account_information = "update accounts set
									balance = '".$new_blnc."'
									where id = '1'
								";
								
								$ipo_member_balance_information = "insert into ipo_member_balance values(
									'',
									'".$mysqli->real_escape_string($ipo_id)."',
									'0',
									'".$mysqli->real_escape_string(date('d/m/Y'))."'
								)";
								
								$activity_log = "insert into activity_log values(
									'',
									'".$mysqli->real_escape_string($bc['branch_id'])."',
									'".$mysqli->real_escape_string($bc['branch_name'])."',
									'".$mysqli->real_escape_string($_POST['personal_full_name']." is IPO Registration by ".uploader_info())."',
									'".$mysqli->real_escape_string(uploader_info())."',
									'".$mysqli->real_escape_string(date('d/m/Y'))."'
								)";
								
								if(
									$mysqli->query($transaction_information)
									AND
									$mysqli->query($ipo_member_information_sql)
									AND
									$mysqli->query($ipo_purses_information)
									AND
									$mysqli->query($account_information)
									AND
									$mysqli->query($ipo_member_balance_information)
									AND
									$mysqli->query($activity_log)
								){
									if(!empty($_SESSION['cart_gen_code'])){
										$mysqli->query("delete from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'");
										unset($_SESSION['cart_gen_code']);
									}
									$number = $_POST['personal_phone_number'];
									$message = 'Dear, '.$_POST['personal_full_name'].', You have successfully registred as a Investor of SUPER HOME. Your Login Information:: Link: '.$home.'ipo-member, Username: '.$_POST['card_number'].' , Password: '.$generated_password.'';
									if(sendsms($number, $message)){
										echo 'Registration Successfeully Done .____0____'.$ipo_id.'____'.$purses_code;
									}else{
										echo 'Registration Successfeully Done, Something Wrong in SMS Section!s____1';	
									}									
								}else{
									echo 'Something wrong! Please Try again.';
								}							
							}
						}
					}
				}
			}
		}
	}else{
		$existing_member = explode('~', $_POST['existing_member']);
		$ipo_id = $existing_member[0];
		$personal_full_name = $existing_member[1];
		$purses_code = md5(rand() * time());
		if(count($_FILES['ipo_attachment']['name']) > 0 ){
			$ipo_attachment_var = '';
			foreach($_FILES['ipo_attachment']['name'] as $k => $v ){
				$ipo_attachment_var .= ipo_image_and_file_upload_multiple($_FILES['ipo_attachment']['name'][$k], $_FILES['ipo_attachment']['tmp_name'][$k], 'ipo_document').',';
			}		
			$ipo_attachment = rtrim($ipo_attachment_var,',');
		}else{
			$ipo_attachment = '';
		}
		$bed_status = '1';
		if(!isset($_SESSION['cart_gen_code'])){
			echo 'IPO Cart is Empty! Please try again.____1';
		}else{
			if(!isset($_SESSION['super_admin']['branch'])){
				echo 'System user session not found! Please logout & login again.____1';
			}else{
				$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));
				$utime = sprintf('%.4f', microtime(TRUE)); 
				$raw_time = DateTime::createFromFormat('U.u', $utime);  
				$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
				$today = $raw_time->format('dmy-his-u');
				$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
				$transaction_id = $bc['branch_code'].'-'.$today;
				$transaction_idO = $transaction_id;
				
				$payment_method = '';
				$data_one = '';
				$data_two = '';
				$data_three = '';
				$payment_details = '';
				$p_branch_id = $bc['branch_id'];
				$p_booking_id = $ipo_id;
				$p_uploader_info = uploader_info();
				$p_table = 'ipo_purses_information';						
				
				foreach($_POST['payment_method'] as $row => $value){		
					if($_POST['payment_method'][$row] == 'Mobile Banking'){ 
						$payment_details = 'Agent Name: '.$_POST['agent'][$row].', Mobile Banking Number: '.$_POST['mobile_banking_number'][$row].' Transaction Id: '.$_POST['transaction_id'][$row].'';			
						$data_one .= $_POST['payment_method'][$row].' | Agent Name | '.$_POST['agent'][$row].',';
						$data_two .= $_POST['payment_method'][$row].' | Mobile Banking Number | '.$_POST['mobile_banking_number'][$row].',';
						$data_three .= $_POST['payment_method'][$row].' | Transaction Id | '.$_POST['transaction_id'][$row].' | Amount | '.$_POST['mobile_amount'][$row].',';
						$payment_method .= $_POST['payment_method'][$row].',';
						if($_POST['mobile_amount'][$row] > 0){
							payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','',$_POST['mobile_amount'][$row],'',$p_uploader_info,$p_table);
						}
					}else if($_POST['payment_method'][$row] == 'Credit / Debit Card'){			
						$payment_details = 'Credit Card Number: '.$_POST['credit_card_number'][$row].' Card Secret: '.$_POST['card_secret'][$row].' Expiry Date: '.$_POST['Expiry_Date'][$row].'';			
						$data_one .= $_POST['payment_method'][$row].' | Credit Card Number | '.$_POST['credit_card_number'][$row].',';
						$data_two .= $_POST['payment_method'][$row].' | Card Secret | '.$_POST['card_secret'][$row].',';
						$data_three .= $_POST['payment_method'][$row].' | Expiry Date | '.$_POST['Expiry_Date'][$row].' | Amount | '.$_POST['card_amount'][$row].',';
						$payment_method .= $_POST['payment_method'][$row].',';
						if($_POST['Expiry_Date'][$row] > 0){
							payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,(float)$_POST['card_amount'][$row] + (float)$_POST['Expiry_Date'][$row],'','','',$p_uploader_info,$p_table);
						}
					}else if($_POST['payment_method'][$row] == 'Check'){			
						$payment_details = 'Bank Name: '.$_POST['bank_name'][$row].' Check Number: '.$_POST['check_number'][$row].' Withdraw Date: '.$_POST['withdraw_date'][$row].'';
						$data_one .= $_POST['payment_method'][$row].' | Bank Name | '.$_POST['bank_name'][$row].',';
						$data_two .= $_POST['payment_method'][$row].' | Check Number | '.$_POST['check_number'][$row].',';
						$data_three .= $_POST['payment_method'][$row].' | Withdraw Date | '.$_POST['withdraw_date'][$row].' | Amount | '.$_POST['check_amount'][$row].',';
						$payment_method .= $_POST['payment_method'][$row].',';
						if($_POST['check_amount'][$row] > 0){
							payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','','',$_POST['check_amount'][$row],$p_uploader_info,$p_table);
						}
					}else{			
						if(!empty($_POST['cash_other_information_remarks'][$row])){
							$cash_other_information_remarks = $_POST['cash_other_information_remarks'][$row];
						}else{
							$cash_other_information_remarks = 'N / A';
						}
						$data_one .= $_POST['payment_method'][$row].' | More Information | '.$_POST['cash_other_information_remarks'][$row].' | Amount | '.$_POST['cash_amount'][$row].',';
						$data_two .= '';
						$data_three .= '';	
						$payment_details = 'More Information: '.$cash_other_information_remarks.'';
						$payment_method .= $_POST['payment_method'][$row].',';
						if($_POST['cash_amount'][$row] > 0){
							payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'',$_POST['cash_amount'][$row],'','',$p_uploader_info,$p_table);
						}
					}
				}
				
				$transaction_information = "insert into transaction values(
					'',
					'".$transaction_idO."',
					'".$mysqli->real_escape_string($bc['branch_id'])."',
					'".$mysqli->real_escape_string($ipo_id)."',
					'".$mysqli->real_escape_string($personal_full_name)."',
					'Defult',
					'Defult',
					'".$mysqli->real_escape_string((float)$_POST['booking_total_amount'])."',
					'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
					'Credit',
					'IPO Account',
					'".$mysqli->real_escape_string($payment_method)."',
					'".$mysqli->real_escape_string($data_one)."',
					'".$mysqli->real_escape_string($data_two)."',
					'".$mysqli->real_escape_string($data_three)."',
					'IPO Money Collection',
					'1',
					'".$mysqli->real_escape_string(uploader_info())."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."'
				)";
				
				if($_POST['condition'] == 'YES'){
					$get_cart_information = $mysqli->query("select * from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'");
					while($ipo_row = mysqli_fetch_assoc($get_cart_information)){
						$mysqli->query("insert into ipo_agreement_information values(
							'',
							'".$mysqli->real_escape_string($ipo_id)."',
							'".$mysqli->real_escape_string($purses_code)."',
							'".$mysqli->real_escape_string($bc['branch_id'])."',
							'".$mysqli->real_escape_string($bc['branch_name'])."',
							'',
							'',
							'',
							'',
							'',
							'',											
							'".$mysqli->real_escape_string($ipo_row['bed_id'])."',
							'".$mysqli->real_escape_string($ipo_row['bed_name'])."',											
							'".$mysqli->real_escape_string($ipo_row['type'])."',
							'".$mysqli->real_escape_string($ipo_row['aggrement_type'])."',
							'".$mysqli->real_escape_string($ipo_row['unit_price'])."',
							'".$mysqli->real_escape_string($ipo_row['qty'])."',
							'".$mysqli->real_escape_string($ipo_row['commission'])."',
							'".$mysqli->real_escape_string($ipo_row['price'])."',
							'".$mysqli->real_escape_string($ipo_row['tenure'])."',
							'".$mysqli->real_escape_string(date_converter($ipo_row['expirity_date']))."',
							'',
							'1',
							'".$mysqli->real_escape_string(uploader_info())."',
							'".$mysqli->real_escape_string(date('d/m/Y'))."'
						)");
					}
				}else{				
					$get_cart_information = $mysqli->query("select * from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'");
					while($ipo_row = mysqli_fetch_assoc($get_cart_information)){
						$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$ipo_row['bed_id']."'"));
						/**
						 * Subtracting 1 Day from expiry date!
						 */
						$expiry_date = new DateTime(date($ipo_row['expirity_date']));
						$expiry_date->sub(new DateInterval('P1D'));
						$mysqli->query("insert into ipo_agreement_information values(
							'',
							'".$mysqli->real_escape_string($ipo_id)."',
							'".$mysqli->real_escape_string($purses_code)."',
							'".$mysqli->real_escape_string($bed_info['branch_id'])."',
							'".$mysqli->real_escape_string($bed_info['branch_name'])."',
							'".$mysqli->real_escape_string($bed_info['floor_id'])."',
							'".$mysqli->real_escape_string($bed_info['floor_name'])."',
							'".$mysqli->real_escape_string($bed_info['unit_id'])."',
							'".$mysqli->real_escape_string($bed_info['unit_name'])."',
							'".$mysqli->real_escape_string($bed_info['room_id'])."',
							'".$mysqli->real_escape_string($bed_info['room_name'])."',
							'".$mysqli->real_escape_string($bed_info['id'])."',
							'".$mysqli->real_escape_string($bed_info['bed_name'])."',
							'".$mysqli->real_escape_string($ipo_row['type'])."',
							'".$mysqli->real_escape_string($ipo_row['aggrement_type'])."',
							'".$mysqli->real_escape_string($ipo_row['unit_price'])."',
							'".$mysqli->real_escape_string($ipo_row['qty'])."',
							'".$mysqli->real_escape_string($ipo_row['commission'])."',
							'".$mysqli->real_escape_string($ipo_row['price'])."',
							'".$mysqli->real_escape_string($ipo_row['tenure'])."',
							'".$mysqli->real_escape_string($expiry_date->format('d/m/Y'))."',
							'',
							'1',
							'".$mysqli->real_escape_string(uploader_info())."',
							'".$mysqli->real_escape_string(date('d/m/Y'))."'
						)");
						$mysqli->query("update beds set
							ipo_uses = '".$mysqli->real_escape_string($bed_status)."'
							where id = '".$mysqli->real_escape_string($bed_info['id'])."'
						");
					}
				}
				$ipo_purses_information = "insert into ipo_purses_information values(
					'',
					'".$mysqli->real_escape_string($ipo_id)."',
					'".$mysqli->real_escape_string($purses_code)."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."',
					'".$mysqli->real_escape_string($_POST['actual_total_amount'])."',
					'".$mysqli->real_escape_string($_POST['booking_total_amount'])."',
					'".$mysqli->real_escape_string($payment_method)."',				
					'".$mysqli->real_escape_string($data_one)."',
					'".$mysqli->real_escape_string($transaction_idO)."',
					'".$mysqli->real_escape_string($data_three)."',
					'',
					'1',
					'".$mysqli->real_escape_string(uploader_info())."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."'
				)";
				$old_blnc = $account_info['balance'];
				$new_blnc = $old_blnc + $_POST['booking_total_amount'];
				$account_information = "update accounts set
					balance = '".$new_blnc."'
					where id = '1'
				";
				
				$activity_log = "insert into activity_log values(
					'',
					'".$mysqli->real_escape_string($bc['branch_id'])."',
					'".$mysqli->real_escape_string($bc['branch_name'])."',
					'".$mysqli->real_escape_string($personal_full_name." is IPO Registration by ".uploader_info())."',
					'".$mysqli->real_escape_string(uploader_info())."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."'
				)";
				
				if(
					$mysqli->query($transaction_information)
					AND
					$mysqli->query($ipo_purses_information)
					AND
					$mysqli->query($account_information)
					AND
					$mysqli->query($activity_log)
				){
					if(!empty($_SESSION['cart_gen_code'])){
						$mysqli->query("delete from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'");
						unset($_SESSION['cart_gen_code']);
					}
					echo 'Registration Successfeully Done .____0____'.$ipo_id.'____'.$purses_code;
				}else{
					echo 'Something Wrong! Please Try again.____1';
				}
				
			}
		}
	}	
}
?>