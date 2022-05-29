<?php
include("../../application/config/ajax_config.php");
$number = '01979746680';
$message = 'Corn Jobs test '. date("l, d-m-Y (h:i:sa)");
sendsms($number,$message);

$mysqli->query("insert into test values(
	'',
	'".$message."',
	'".date("l, d-m-Y (h:i:sa)")."'
)");
?>