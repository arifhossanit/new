<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['request_id'])){
	$get_data = mysqli_fetch_assoc($mysqli->query("SELECT * FROM advance_money_request WHERE id = '".$_POST['request_id']."'"));
	$employee = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$get_data['employee_id']."'"));
	echo $get_data['amount'].'________'.$get_data['note'].'________'.$employee['id'].'________'.$employee['department_name'];
}
?>