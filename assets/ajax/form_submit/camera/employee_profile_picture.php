<?php 
include("../../../../application/config/ajax_config.php");
$image = $_POST['image'];
list($type, $image) = explode(';',$image);
list(, $image) = explode(',',$image);
$avater_name = 'FILES_IMAGE_MEMBER_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() ;
$image = base64_decode($image);
$file_ext = '.png';
$image_name = $avater_name.'.png';
$newfilenameup = '../../../../assets/uploads/employee/employee_photo/'.$avater_name. $file_ext;	
$newfilename = 'assets/uploads/employee/employee_photo/'.$avater_name. $file_ext;	
file_put_contents($newfilenameup, $image);
if($mysqli->query("update employee set photo = '".$newfilename."' where email = '".$_SESSION['super_admin']['email']."'")){
	echo $newfilename;
}else{
	
}

?>
