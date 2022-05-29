<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['package_id'])){ 
	$data = mysqli_fetch_assoc($mysqli->query("select * from room_type where package_category = '".$_POST['package_id']."'"));
	echo $data['room_type'];
}
?>