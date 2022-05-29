<?php
include("../../../application/config/ajax_config.php");
$validate = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as validate from employee where MD5('{$_POST['otp']}') = `password` AND id = {$_SESSION['super_admin']['employee_id']}"));
if($validate['validate'] > 0){
    $info = array(
        'message' => 'ok',
        'button' => '<button style="float:right;" class="btn btn-primary">Generate Salary</button>'
    );
}else{
    $info = array(
        'message' => 'no_match',
        'button' => ''
    );
}
echo json_encode($info);