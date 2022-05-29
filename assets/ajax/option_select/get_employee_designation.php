<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['employee_id'])){
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$_POST['employee_id']."'"));
	echo $emp['designation'];
} ?>