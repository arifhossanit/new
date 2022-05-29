<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['form_submit'])){ 
	$cash_transaction = '0';
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_wallet_money_widthdraw_request where id = '".$_POST['member_id']."'"));
	$emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$info['employee_id']."'"));
	$wallet_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$info['employee_id']."'"));
	$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));
	//--------payment method------
	function payment_varient($tnsid,$branch_id,$booking_id,$payment_method,$payment_details,$card_amount,$cash_amount,$mobile_amount,$check_amount,$uploader_info,$table){ global $mysqli; global $db; $invoice_id = mysqli_fetch_assoc($mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = '".$table."'")); $inv_id = date('dmY').$invoice_id['AUTO_INCREMENT']; if($mysqli->query("insert into payment_received_method values( '', '".$mysqli->real_escape_string($tnsid)."', '".$mysqli->real_escape_string($branch_id)."', '".$mysqli->real_escape_string($booking_id)."', '".$mysqli->real_escape_string($payment_method)."', '".$mysqli->real_escape_string($payment_details)."', '".$mysqli->real_escape_string($card_amount)."', '".$mysqli->real_escape_string($cash_amount)."', '".$mysqli->real_escape_string($mobile_amount)."', '".$mysqli->real_escape_string($check_amount)."', '".$mysqli->real_escape_string($inv_id)."', '', '1', '".$mysqli->real_escape_string($uploader_info)."', '".$mysqli->real_escape_string(date('d/m/Y'))."' )")){ return true; }else{ return false; } }
	function convertNumberToWord($num = false){ $num = str_replace(array(',', ' '), '' , trim($num)); if(! $num) { return false; } $num = (int) $num; $words = array(); $list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen' ); $list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred'); $list3 = array('', 'Thousand', 'Million', 'Billion', 'Trillion', 'Quadrillion', 'Quintillion', 'Sextillion', 'Septillion', 'Octillion', 'Nonillion', 'Decillion', 'Undecillion', 'Duodecillion', 'Tredecillion', 'Quattuordecillion', 'Quindecillion', 'Sexdecillion', 'Septendecillion', 'Octodecillion', 'Novemdecillion', 'Vigintillion' ); $num_length = strlen($num); $levels = (int) (($num_length + 2) / 3); $max_length = $levels * 3; $num = substr('00' . $num, -$max_length); $num_levels = str_split($num, 3); for ($i = 0; $i < count($num_levels); $i++) { $levels--; $hundreds = (int) ($num_levels[$i] / 100); $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : ''); $tens = (int) ($num_levels[$i] % 100); $singles = ''; if ( $tens < 20 ) { $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' ); } else { $tens = (int)($tens / 10); $tens = ' ' . $list2[$tens] . ' '; $singles = (int) ($num_levels[$i] % 10); $singles = ' ' . $list1[$singles] . ' '; } $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' ); }  $commas = count($words); if ($commas > 1) { $commas = $commas - 1; } return implode(' ', $words). 'Taka Only'; }
	$utime = sprintf('%.4f', microtime(TRUE)); 
	$raw_time = DateTime::createFromFormat('U.u', $utime); 
	$today = $raw_time->format('dmy-his-u');
	$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
	$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
	$transaction_id = $bc['branch_code'].'-'.$today;
	$transaction_idO = $transaction_id;
	$payment_method = '';
	$data_one = '';
	$data_two = '';
	$data_three = '';
	$payment_details = '';
	$p_branch_id = $bc['branch_id'];
	$p_booking_id = $emp_info['employee_id'];
	$p_uploader_info = $_POST['uploader_info'];
	$p_table = 'employee_aproved_widthdraw_money_logs';
	foreach($_POST['payment_method'] as $row => $value){ if($_POST['payment_method'][$row] == 'Mobile Banking'){ $payment_details = 'Agent Name: '.$_POST['agent'][$row].', Mobile Banking Number: '.$_POST['mobile_banking_number'][$row].' Transaction Id: '.$_POST['transaction_id'][$row].''; $data_one .= $_POST['payment_method'][$row].' | Agent Name | '.$_POST['agent'][$row].','; $data_two .= $_POST['payment_method'][$row].' | Mobile Banking Number | '.$_POST['mobile_banking_number'][$row].','; $data_three .= $_POST['payment_method'][$row].' | Transaction Id | '.$_POST['transaction_id'][$row].' | Amount | '.$_POST['mobile_amount'][$row].','; $payment_method .= $_POST['payment_method'][$row].','; if($_POST['mobile_amount'][$row] > 0){ payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','',$_POST['mobile_amount'][$row],'',$p_uploader_info,$p_table); } }else if($_POST['payment_method'][$row] == 'Credit / Debit Card'){ $payment_details = 'Credit Card Number: '.$_POST['credit_card_number'][$row].' Card Secret: '.$_POST['card_secret'][$row].' Expiry Date: '.$_POST['Expiry_Date'][$row].''; $data_one .= $_POST['payment_method'][$row].' | Credit Card Number | '.$_POST['credit_card_number'][$row].','; $data_two .= $_POST['payment_method'][$row].' | Card Secret | '.$_POST['card_secret'][$row].','; $data_three .= $_POST['payment_method'][$row].' | Expiry Date | '.$_POST['Expiry_Date'][$row].' | Amount | '.$_POST['card_amount'][$row].','; $payment_method .= $_POST['payment_method'][$row].','; if($_POST['card_amount'][$row] > 0){ payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,$_POST['card_amount'][$row],'','','',$p_uploader_info,$p_table); } }else if($_POST['payment_method'][$row] == 'Check'){ $payment_details = 'Bank Name: '.$_POST['bank_name'][$row].' Check Number: '.$_POST['check_number'][$row].' Withdraw Date: '.$_POST['withdraw_date'][$row].''; $data_one .= $_POST['payment_method'][$row].' | Bank Name | '.$_POST['bank_name'][$row].','; $data_two .= $_POST['payment_method'][$row].' | Check Number | '.$_POST['check_number'][$row].','; $data_three .= $_POST['payment_method'][$row].' | Withdraw Date | '.$_POST['withdraw_date'][$row].' | Amount | '.$_POST['check_amount'][$row].','; $payment_method .= $_POST['payment_method'][$row].','; if($_POST['check_amount'][$row] > 0){ payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','','',$_POST['check_amount'][$row],$p_uploader_info,$p_table); } }else{ if(!empty($_POST['cash_other_information_remarks'][$row])){ $cash_other_information_remarks = $_POST['cash_other_information_remarks'][$row]; }else{ $cash_other_information_remarks = 'N / A'; } $data_one .= $_POST['payment_method'][$row].' | More Information | '.$_POST['cash_other_information_remarks'][$row].' | Amount | '.$_POST['cash_amount'][$row].','; $data_two .= ''; $data_three .= ''; $payment_details = 'More Information: '.$cash_other_information_remarks.''; $payment_method .= $_POST['payment_method'][$row].','; if($_POST['cash_amount'][$row] > 0){ payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'',$_POST['cash_amount'][$row],'','',$p_uploader_info,$p_table); } $cash_transaction = '1'; } }
	//--------end payment method------	
	$transaction = "insert into transaction values(
		'',
		'".$mysqli->real_escape_string($transaction_idO)."',
		'".$mysqli->real_escape_string($bc['branch_id'])."',
		'".$mysqli->real_escape_string($emp_info['employee_id'])."',
		'".$mysqli->real_escape_string($emp_info['full_name'])."',
		'Defult',
		'Defult',
		'".$mysqli->real_escape_string($_POST['money'])."',
		'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
		'Debit',
		'Employee Widthdraw Account',
		'".$mysqli->real_escape_string($payment_method)."',
		'".$mysqli->real_escape_string($data_one)."',
		'".$mysqli->real_escape_string($data_two)."',
		'".$mysqli->real_escape_string($data_three)."',
		'Employee Aproved Widthdraw Money',
		'1',
		'".$mysqli->real_escape_string($_POST['uploader_info'])."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."'
	)";	
	if($_FILES['attachment']['name'] != ''){
		$attachment = file_upload_member_dir($_FILES['attachment']['name'],$_FILES['attachment']['tmp_name'],'../../../assets/uploads/ipo/ipo_personal_document/');
	}else{
		$attachment = '';
	}
		
	$diposit_submit = "insert into employee_aproved_widthdraw_money_logs values(
		'',
		'".$_POST['member_id']."',
		'".$mysqli->real_escape_string($emp_info['employee_id'])."',
		'".$mysqli->real_escape_string($_POST['money'])."',
		'".$mysqli->real_escape_string($payment_method)."',
		'".$mysqli->real_escape_string($data_one)."',
		'".$mysqli->real_escape_string($transaction_idO)."',
		'".$mysqli->real_escape_string($data_three)."',
		'".$mysqli->real_escape_string($attachment)."',
		'".$mysqli->real_escape_string($_POST['note'])."',
		'1',
		'".$mysqli->real_escape_string($_POST['uploader_info'])."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."'
	)";	
	$set_balance = $account_info['balance'] - $_POST['money'];
	$total = (float)$wallet_balance['balance'] - (float)$_POST['money'];
	if(
		$mysqli->query($diposit_submit)
		AND
		$mysqli->query("UPDATE accounts set balance = '".$set_balance."' where id = '1'")
		AND
		$mysqli->query($transaction)
		AND
		$mysqli->query("update employee_award_wallet set balance = '".$total."' where employee_id = '".$emp_info['employee_id']."'")
		AND
		$mysqli->query("update employee_wallet_money_widthdraw_request set aproval = '1' where id = '".$_POST['member_id']."'")
	){
		if($_POST['money'] <= 1000){
			$message = 'You received Widthdraw amount '.money($_POST['money']).' from Super Home. Thank you for stay with us!';
		}else{
			$message = 'You received Widthdraw amount by '.$payment_method.' from Super Home. Thank you for stay with us!';
		}		
		if(sendsms($emp_info['personal_Phone'],$message)){
			if($_POST['payment_method'][0] == 'Check'){
				$dat = explode('-',$_POST['withdraw_date'][0]);
				$date = $dat[2].'/'.$dat[1].'/'.$dat[0];
				$mysqli->query("insert into check_print_data values(
					'',
					'".$mysqli->real_escape_string($bc['branch_id'])."',
					'".$mysqli->real_escape_string($date)."',
					'".$mysqli->real_escape_string($emp_info['full_name'])."',
					'".$mysqli->real_escape_string($_POST['money'])."',
					'".$mysqli->real_escape_string(convertNumberToWord($_POST['money']))."',
					'".$mysqli->real_escape_string($emp_info['employee_id'])."',
					'".$mysqli->real_escape_string($_POST['check_number'][0])."',
					'".$mysqli->real_escape_string($_POST['note'])."',
					'1',
					'".$mysqli->real_escape_string($_POST['uploader_info'])."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."'
				)");
				$get_id = mysqli_fetch_assoc($mysqli->query("select * from check_print_data order by id desc"));
				echo 'Check Information save successfully_____1_____'.$get_id['id'];
			}else{
				echo 'Diposit Return Successfully & sended SMS_____1';
			}			
		}else{
			echo 'Something wrong in SMS section! Widthwraw submit Successfully_____1';
		}		
	}else{
		echo 'Something wrong! Please try again_____0';
	}
}
?>