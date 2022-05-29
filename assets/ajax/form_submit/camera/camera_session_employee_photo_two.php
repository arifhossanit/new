<?php 
include("../../../../application/config/ajax_config.php");
$filename = $_FILES["webcam"]["name"];
$file_tmp = $_FILES["webcam"]["tmp_name"];
$file_ext = substr($filename, strripos($filename, '.'));
$avater_name = 'FILES_IMAGE_MEMBER_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() ;
$newfilenameup = '../../../../assets/uploads/employee/employee_document/'.$avater_name. $file_ext;	
$newfilename = 'assets/uploads/employee/employee_document/'.$avater_name. $file_ext;	
move_uploaded_file($file_tmp, $newfilenameup);
$url = $newfilename;
echo $url;
?>