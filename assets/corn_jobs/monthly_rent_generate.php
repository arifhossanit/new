<?php
include("../../application/config/ajax_config.php");
$rent_mem = $mysqli->query("select * from member_directory where status = '1' order by id desc");
while($roq = mysqli_fetch_assoc($rent_mem)){
	$rnt_check = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$roq['booking_id']."' order by id desc"));
	
	
}
?>