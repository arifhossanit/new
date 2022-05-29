<?php
include("../../../application/config/ajax_config.php");
$base_dir = 'E:/xampp/htdocs/super_home/';
// $base_dir = '/opt/lampp/htdocs/super_home/';
if(isset($_POST['vaccine_id_member_id'])){
    $member = mysqli_fetch_assoc($mysqli->query("SELECT id, booking_id, document_type, document_upload from member_directory where id = ".$_POST['vaccine_id_member_id']));
    $filename 		= $_FILES['vaccine_card']["name"];
    $file_tmp 		= $_FILES['vaccine_card']["tmp_name"];
    $file_ext 		= substr($filename, strripos($filename, '.'));
    $newfilename 	= 'FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
    $newfile 		= 'assets/uploads/member/member_document/' . $newfilename;
    move_uploaded_file($file_tmp,$base_dir . $newfile);
    $files = explode(',', $member['document_type']);
    $paths = explode(',', $member['document_upload']);
    if(empty($files[2])){
        $files[2] = 'Vaccine Card';
        $paths[2] = $newfile;
    }else if(empty($files[3])){
        $files[3] = 'Vaccine Card';
        $paths[3] = $newfile;
    }else{
        $files[4] = 'Vaccine Card';
        $paths[4] = $newfile;
    }
    $file_string = implode(',', $files). ',' ;
    $path_string = implode(',', $paths). ',' ;
    $comma = '';
    foreach($files as $row){
        $comma .= ',';
    }
    // var_dump($file_string);
    // var_dump("UPDATE member_directory set document_type = '$file_string', document_upload = '$path_string' where id = ".$member['id']);
    // exit();
    if(
        $mysqli->query("UPDATE member_directory set document_number = '$comma', document_type = '$file_string', document_upload = '$path_string' where id = ".$member['id']) AND
        $mysqli->query("INSERT INTO member_vaccinated (booking_id) value ('".$member['booking_id']."')")
    ){
        echo 'ok';
    }else{
        echo $mysqli->error;
    }
}