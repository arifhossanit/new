<?php 
include("../../../../../application/config/ajax_config.php");
if(isset($_POST['table']) && isset($_POST['id'])){
	$table = $_POST['table'];
	$id = $_POST['id'];
	$val = $mysqli->query("update $table set hr_check='1' where id='$id'");
	echo json_encode($val);
}
