<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['transaction_id'])){
	$logs = mysqli_fetch_assoc($mysqli->query("select * from advance_transaction_logs where transaction_id = '".$_POST['transaction_id']."'"));
	$money = mysqli_fetch_assoc($mysqli->query("select * from advance_petty_cash where employee_id = '".$logs['employee_id']."'"));
	if(!empty($_SESSION['super_admin']['email'])){
		$balance = doubleval($money['amount']);
		$expence_money = doubleval($logs['amount']);
		$new_balance = $balance - $expence_money;
		$update_new_balance = "update advance_petty_cash set
			amount = '".$new_balance."'
			where id = '".$money['id']."'
		";
		$approval_update = "update advance_transaction_logs set
			approval = '2'
			where id = '".$logs['id']."'
		";
		$insert_checkit_logs = "insert into checkit_petty_approval_logs values(
			'',
			'".$mysqli->real_escape_string($logs['transaction_id'])."',
			'".$mysqli->real_escape_string($logs['employee_id'])."',
			'".$mysqli->real_escape_string($logs['amount'])."',
			'Approved',
			'1',
			'".$mysqli->real_escape_string($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";
		if(
			$mysqli->query($update_new_balance) AND
			$mysqli->query($approval_update) AND
			$mysqli->query($insert_checkit_logs)		
		){

			$get_employee_id = mysqli_fetch_assoc($mysqli->query("SELECT employee_id from employee where id = '".$logs['employee_id']."' "));
			$patty_cash_overview = mysqli_fetch_assoc($mysqli->query("SELECT employee_id as emp_id,id,expense,withdraw,balance from employee_petty_cash_overview where employee_id = '".$get_employee_id['employee_id']."' order by id desc"));
			$new_balance = doubleval($patty_cash_overview['balance']) - doubleval($logs['amount']);

			$mysqli->query(" INSERT into employee_petty_cash_overview (`transection_id`,`employee_id`, `expense`,`balance`) VALUES ('".$_POST['transaction_id']."','".$get_employee_id['employee_id']."','".$logs['amount']."', '".$new_balance."') ");
			

			echo 'Transaction Approved Successfully!';
		}else{
			echo 'Something Wrong! Please Tray again';
		}
	}else{
		echo 'Your Session is expired! Please Refresh your page';
	}

} ?>