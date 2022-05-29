<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){
	$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));
	$_SESSION['re_book_member_id'] = $_POST['member_id'];
	$_SESSION['re_book_member__money'] = $mem_info['security_deposit'];
	echo $home.'admin/booking';
}
?>