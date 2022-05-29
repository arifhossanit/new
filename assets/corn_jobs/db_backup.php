<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '!@#$%databaseserveradmin2020';
    $db = 'super_hostel_';
    
    $backup_file = $db . date("Y-m-d-H-i-s") . '.sql';
    $new_command = "E:/xampp/mysql/bin/mysqldump -u root -p!@#$%databaseserveradmin2020 super_hostel > J:/php_db_backup/$backup_file";
    exec($new_command);
?>