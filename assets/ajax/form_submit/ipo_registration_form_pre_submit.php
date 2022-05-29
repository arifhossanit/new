<?php
include("../../../application/config/ajax_config.php");
$ipo_id = date('d_m_Y__h_i_s_A').'_'.rand().'_'.rand() * time().'_'.md5(time());
$purses_code = md5(rand() * time());
$generated_password = spc_chr_mm(8);
if(!empty($_POST['nominee_name'])){ $nominee_name = $_POST['nominee_name']; }else{ $nominee_name = ''; }
if(!empty($_POST['nominee_phone_number'])){ $nominee_phone_number = $_POST['nominee_phone_number']; }else{ $nominee_phone_number = ''; }
if(!empty($_POST['nominee_date_of_birth'])){ $nominee_date_of_birth = date_converter($_POST['nominee_date_of_birth']); }else{ $nominee_date_of_birth = ''; }
if(!empty($_POST['nominee_email'])){ $nominee_email = $_POST['nominee_email']; }else{ $nominee_email = ''; }
if(!empty($_POST['nominee_nid_card'])){ $nominee_nid_card = $_POST['nominee_nid_card']; }else{ $nominee_nid_card = ''; }
if($_FILES['nominee_nid_attachment']['name'] != ''){
    $nominee_nid_attachment = ipo_image_and_file_upload('nominee_nid_attachment','ipo_nominee_document');
}else{
    $nominee_nid_attachment = '';
}
if(!empty($_POST['nominee_relation'])){ $nominee_relation = $_POST['nominee_relation']; }else{ $nominee_relation = ''; }
if($_FILES['nominee_images']['name'] != ''){
    $nominee_images = ipo_image_and_file_upload('nominee_images','ipo_nominee_document');
}else{
    $nominee_images = '';
}	
if($_FILES['personal_nid_attachment']['name'] != ''){
    $personal_nid_attachment = ipo_image_and_file_upload('personal_nid_attachment','ipo_personal_document');
}else{
    $personal_nid_attachment = '';
}	
if($_FILES['personal_images']['name'] != ''){
    $personal_images = ipo_image_and_file_upload('personal_images','ipo_personal_document');
}else{
    $personal_images = '';
}	
if(count($_FILES['bank_attachment']['name']) > 0){
    $bank_attachment_var = '';
    foreach($_FILES['bank_attachment']['name'] as $k => $v ){
        $bank_attachment_var .= ipo_image_and_file_upload_multiple($_FILES['bank_attachment']['name'][$k], $_FILES['bank_attachment']['tmp_name'][$k], 'ipo_bank_document').',';
    }
    $bank_attachment = rtrim($bank_attachment_var,',');
}else{
    $bank_attachment = '';
}

if(!empty($_POST['nominee_address'])){ $nominee_address = $_POST['nominee_address']; }else{ $nominee_address = ''; }
if(!empty($_POST['note'])){ $note = $_POST['note']; }else{ $note = ''; }
$check_data_1 = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory_pre where personal_phone_number = '".$_POST['personal_phone_number']."'"));
if(!empty($check_data_1['personal_phone_number']) AND $check_data_1['personal_phone_number'] == $_POST['personal_phone_number']){
    echo 'Phone Number already exists! Please try again.';
}else{
    $check_data_2 = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory_pre where personal_email = '".$_POST['personal_email']."'"));
    if(!empty($check_data_2['personal_email']) AND $check_data_2['personal_email'] == $_POST['personal_email']){
        echo 'Email already exists! Please try again.';
    }else{
        $ipo_member_information_sql = "insert into ipo_member_directory_pre values(
            '',
            '".$mysqli->real_escape_string($ipo_id)."',
            '".$mysqli->real_escape_string($_POST['personal_full_name'])."',
            '".$mysqli->real_escape_string($_POST['personal_phone_number'])."',
            '".$mysqli->real_escape_string(date_converter($_POST['personal_date_of_birth']))."',
            '".$mysqli->real_escape_string($_POST['personal_email'])."',
            '".$mysqli->real_escape_string($generated_password)."',
            '".$mysqli->real_escape_string($_POST['personal_nid_card'])."',
            '".$mysqli->real_escape_string($personal_nid_attachment)."',
            '".$mysqli->real_escape_string($personal_images)."',
            '".$mysqli->real_escape_string($_POST['personal_address'])."',
            '".$mysqli->real_escape_string($_POST['ipo_bank_name'])."',
            '".$mysqli->real_escape_string($_POST['account_holder_name'])."',
            '".$mysqli->real_escape_string($_POST['account_number'])."',
            '".$mysqli->real_escape_string($_POST['routing_number'])."',
            '".$mysqli->real_escape_string($_POST['bank_branch_name'])."',
            '".$mysqli->real_escape_string($bank_attachment)."',
            '".$mysqli->real_escape_string($_POST['bank_address'])."',
            '".$mysqli->real_escape_string($nominee_name)."',
            '".$mysqli->real_escape_string($nominee_phone_number)."',
            '".$mysqli->real_escape_string($nominee_date_of_birth)."',
            '".$mysqli->real_escape_string($nominee_email)."',
            '".$mysqli->real_escape_string($nominee_nid_card)."',
            '".$mysqli->real_escape_string($nominee_nid_attachment)."',
            '".$mysqli->real_escape_string($nominee_relation)."',
            '".$mysqli->real_escape_string($nominee_images)."',
            '".$mysqli->real_escape_string($nominee_address)."',
            'unauthorized',
            '".$mysqli->real_escape_string($note)."',
            '1',
            '',
            '".$mysqli->real_escape_string(date('d/m/Y'))."'
        )";
        
        if($mysqli->query($ipo_member_information_sql)){
            echo 'success';
        }else{
            echo 'Something Wrong! Please Try again.';
        }
    }
}