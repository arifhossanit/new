<?php
include("../../application/config/ajax_config.php");

$date = new DateTime(date('Y-m-d'));
$date->add(new DateInterval('P1D'));

$mysqli->query("UPDATE employee set status = 0 where employee_id in (SELECT employee_resign_request.employee_id FROM `employee_resign_request` INNER JOIN employee_resign_request_to_hr on employee_resign_request_to_hr.employee_id = employee_resign_request.employee_id WHERE employee_resign_request_to_hr.aproval = 1 AND employee_resign_request.resign_date <= '".$date->format('Y-m-d')."')");
?>