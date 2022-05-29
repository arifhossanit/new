<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$floor_id = $_POST['view_id'];
		echo '<option value="">select</option>';
	$sql = $mysqli->query("select * from units where floor_id = '".$floor_id."'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['id'].'">'.$row['unit_name'].'</option>';
		}
	}
}
?>