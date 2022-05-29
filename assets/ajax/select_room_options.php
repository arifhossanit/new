<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$unit_id = $_POST['view_id'];
	$row = mysqli_fetch_assoc($mysqli->query("select * from units where id = '".$unit_id."'"));
		echo '<option value="">Selected('.$row['unit_name'].')</option>';
	$sql = $mysqli->query("select * from rooms where unit_id = '".$row['id']."'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['id'].'">'.$row['room_name'].'</option>';
		}
	}
}
?>