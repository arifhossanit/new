<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['type'])){ 
	$check_data = mysqli_fetch_assoc($mysqli->query("select * from advance_petty_cash_return_logs where id = '".$_POST['return_id']."'"));
	
	if($_POST['type'] == 1){
		if($mysqli->query("insert into advance_return_aproval_logs values(
			'',
			'".$check_data['id']."',
			'".$check_data['employee_id']."',
			'".$check_data['amount']."',
			'Approved',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)")){
			if($mysqli->query("update advance_petty_cash_return_logs set aproval = '1' where id = '".$check_data['id']."'")){
				$get_balance = mysqli_fetch_assoc($mysqli->query("select * from advance_petty_cash where employee_id = '".$check_data['employee_id']."'"));
				$result = $get_balance['amount'] - $check_data['amount'];
				if($mysqli->query("update advance_petty_cash set amount = '".$result."' where employee_id = '".$check_data['employee_id']."'")){

					$get_employee_id = mysqli_fetch_assoc($mysqli->query("SELECT employee_id from employee where id = '".$check_data['employee_id']."' "));
					$balance_employee_petty_cash_overview = mysqli_fetch_assoc($mysqli->query("SELECT balance from employee_petty_cash_overview where employee_id = '".$get_employee_id['employee_id']."' order by id desc"));
					$get_transection_id = 'advance_petty_cash_return_logs table primary key is ' .$_POST['return_id'];

					$balance = doubleval($balance_employee_petty_cash_overview['balance']) - doubleval($check_data['amount']);

					$mysqli->query(" INSERT into employee_petty_cash_overview (`transection_id`,`employee_id`, `expense`,`balance` ) VALUES ('".$get_transection_id."','".$get_employee_id['employee_id']."','".$check_data['amount']."', '".$balance."' )");

					echo 'Return Request Approved Successfully';
				}else{
					echo 'Something wrong! Please try Again';
				}
			}else{
				echo 'Something wrong! Please try Again';
			}
		}else{
			echo 'Something wrong! Please try Again';
		}
	}else if($_POST['type'] == 2){
		if($mysqli->query("insert into advance_return_aproval_logs values(
			'',
			'".$check_data['id']."',
			'".$check_data['employee_id']."',
			'".$check_data['amount']."',
			'Rejected',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)")){
			if($mysqli->query("update advance_petty_cash_return_logs set aproval = '2' where id = '".$check_data['id']."'")){
				echo 'Return Request Rejected Successfully';
			}else{
				echo 'Something wrong! Please try Again';
			}
		}else{
			echo 'Something wrong! Please try Again';
		}
	}
}
?>