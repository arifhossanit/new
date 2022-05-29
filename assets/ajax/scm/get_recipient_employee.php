<?php
include("../../../application/config/ajax_config.php");
$html = '';
$employees = $mysqli->query("SELECT employee_id, full_name from employee where status = 1 AND department = '".rahat_decode($_POST['id'])."'");
$html = '<option value="">Select Employee</option>';
while($employee = mysqli_fetch_assoc($employees)){
    $html .= '<option value="'.rahat_encode($employee['employee_id']).'">'.$employee['full_name'].'</option>';
}
echo $html;