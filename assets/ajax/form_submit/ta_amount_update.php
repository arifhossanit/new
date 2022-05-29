<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['info_id'])){
	if($mysqli->query("update employee_ta_da_bill_logs set
		transport_amount = '".$_POST['ta_amount']."',
		food_amount = '".$_POST['da_amount']."'
		where id = '".$_POST['info_id']."'
	")){
		echo 'Amount Update Successfully!';
	}else{
		echo 'Something Wrong! Please try Again';
	}
}
?>