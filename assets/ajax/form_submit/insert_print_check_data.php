<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['save_info'])){
	$check_data = mysqli_fetch_assoc($mysqli->query("select * from check_print_data where card_invoice_no = '".$_POST['card_invoice_no']."'"));
	if(!empty($check_data['id']) AND $check_data['status'] == 1 OR $check_data['status'] == 2){
		echo 'Card / Invoice number already Exixt!_____0';
		$check_print = 0;
	}else{
		$check_print = 1;
	}	
	if($check_print == 1){
		$dat = explode('-',$_POST['date']);
		$date = $dat[2].'/'.$dat[1].'/'.$dat[0];		
		if($mysqli->query("insert into check_print_data values(
			'',
			'".$mysqli->real_escape_string($_POST['branch_id'])."',
			'".$mysqli->real_escape_string($date)."',
			'".$mysqli->real_escape_string($_POST['name'])."',
			'".$mysqli->real_escape_string($_POST['amount'])."',
			'".$mysqli->real_escape_string($_POST['description'])."',
			'".$mysqli->real_escape_string($_POST['card_invoice_no'])."',
			'".$mysqli->real_escape_string($_POST['check_no'])."',
			'".$mysqli->real_escape_string($_POST['note'])."',
			'1',
			'".$mysqli->real_escape_string(uploader_info())."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)")){
			$get_id = mysqli_fetch_assoc($mysqli->query("select * from check_print_data order by id desc"));
			echo 'Check Information save successfully_____1_____'.$get_id['id'];
		}else{
			echo 'Something wrong! Please try again_____0';
		}
	}
	
}
?>