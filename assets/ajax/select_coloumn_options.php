<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$unit_id = $_POST['view_id'];
	$row = mysqli_fetch_assoc($mysqli->query("select * from rooms where id = '".$unit_id."'"));
		echo '<option value="">Selected('.$row['room_name'].')</option>';
	$sql = $mysqli->query("select * from column_list where room_id = '".$row['id']."'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['id'].'">'.$row['column_name'].'</option>';
		}
	}
}
?>