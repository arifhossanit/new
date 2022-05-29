<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){
	$_SESSION['re_book_member_id'] = $_POST['member_id'];
	echo $home.'admin/booking';
}
?>