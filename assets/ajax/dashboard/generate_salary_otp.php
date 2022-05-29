<?php 
include("../../../application/config/ajax_config.php");
$employee_phone = mysqli_fetch_assoc($mysqli->query("SELECT personal_Phone from employee where id = ".$_SESSION['super_admin']['employee_id']));
$phone = substr($employee_phone['personal_Phone'], 1, 10);
$last_otp = mysqli_fetch_assoc($mysqli->query("SELECT `message` from sms_logs where number like '%$phone%' and message like '%Neways Login Credential%' order by id desc LIMIT  1"));
$length = strlen($last_otp['message']);
$upper_limit = $length - 4;
$_SESSION['salary_generate_otp'] = substr($last_otp['message'],$upper_limit,$length);
echo    '<div class="row">
            <div class="col-md-4 align-self-center" id="otp_error">
                Enter Your Password!
            </div>
            <div class="col-md-4">
                <input id="confirm_salary_password" class="form-control" type="password" placeholder="Password">
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-primary" onclick="confirm_otp()">Confrim</button>
            </div>
        </div>';
?>