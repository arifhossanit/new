<?php
date_default_timezone_set("America/New_York");
header("Cache-Control: no-cache");
header("Content-Type: text/event-stream");

$host = 'localhost';
$user = 'root';
$pass = '!@#$%databaseserveradmin2020';
$db = 'super_hostel';
$mysqli = new mysqli($host,$user,$pass,$db);

$counter = rand(1, 10);
$statement = $mysqli->prepare("SELECT * from app_desktop_login_token where token = ? AND `status` = 1");
while (true) {
    $statement->bind_param("s", $_COOKIE['token']);
    $statement->execute();
    $result = $statement->get_result();
    $get_data = $result->fetch_assoc();

    if(!is_null($get_data)){        
        echo "data: logged_in\n\n";
        break;
    }

    echo "data: not_logged_in\n\n";

    ob_end_flush();
    flush();

    if ( connection_aborted() ) break;

    sleep(1);
}