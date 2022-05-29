<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['ipo_id'])){
	$mem_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$_POST['ipo_id']."'"));
	echo json_encode($mem_info);	
}
?>