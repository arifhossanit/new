<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['re_book_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['re_book_id']."'"));
	echo''.$row['full_name'].'||'.$row['email'].'||'.$row['phone_number'].'||'.$row['occupation'].'||'.$row['religion'].'||'.$row['h_t_f_u'].'||'.$row['referance_id'].'||'.$row['photo_avater'].'||'.$row['father_name'].'||'.$row['mother_name'].'||'.$row['emergency_number_1'].'||'.$row['emergency_number_2'].'||'.$row['address'].'||'.$row['remarks'].'||'.$row['document_number'].'||'.$row['document_type'].'||'.$row['document_upload'].'';
}

if(isset($_POST['re_book_diss'])){
	unset($_SESSION['re_book_member_id']);
	unset($_SESSION['re_book_member__money']);
}
?>