<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Dhaka');
$host = 'localhost';
$user = 'root';
$pass = '!@#$%databaseserveradmin2020';
$db = 'super_hostel';
$mysqli = new mysqli($host,$user,$pass,$db);
$today = new DateTime();
$today->sub(new DateInterval('P1D'));
$mysqli->query("UPDATE employee_leave_logs set leave_lock = 1 where DATE(created_at) < '".$today->format('Y-m-d')."' AND ( h_aproval = 0 OR (h_id != '114' AND aproval = 0 AND h_aproval != 2))");
$mysqli->query("INSERT INTO `test`(`message`, `time`) VALUES ('Test','Test')");
$file = fopen('E:/xampp/htdocs/super_home/assets/corn_jobs/logs/log.txt', 'a');
fwrite($file, "Done at: " . $today->format('Y-m-d H:i:s') . "\n");
fclose($file);  
echo 'done';
