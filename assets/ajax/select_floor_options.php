<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$branch_id = $_POST['view_id'];
	$row = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$branch_id."'"));
		echo '<option value="">Selected('.$row['branch_name'].')</option>';
	$sql = $mysqli->query("select * from floors where branch_id = '".$row['branch_id']."'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['id'].'">'.$row['floor_name'].'</option>';
		}
	}
}
?>