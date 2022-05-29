<?php 
include("../../../../application/config/ajax_config.php");
if(isset($_POST['column'])){
	$row = mysqli_fetch_assoc($mysqli->query("select  * from pre_booking_directory where id = '".$_POST['id']."'"));
	if($row[$_POST['column']] == $mysqli->real_escape_string($_POST['editval'])){
		echo '0';
	}else{
		if($mysqli->query("insert into data_table_edit_logs values(
			'',
			'pre_booking_directory',
			'".$row['id']."',
			'".$_POST['column']."',
			'".$row[$_POST['column']]."',
			'".$mysqli->real_escape_string($_POST['editval'])."',
			'".date('h:i:sa')."',
			'".date('d/m/Y')."',
			'".uploader_info()."'
		)")){
			if($mysqli->query("update pre_booking_directory set ".$_POST['column']." = '".$mysqli->real_escape_string($_POST['editval'])."' where id = '".$_POST['id']."'")){
				echo '1';
			}else{
				echo '0';
			}
		}else{
			echo '0';
		}
	}
}
?>