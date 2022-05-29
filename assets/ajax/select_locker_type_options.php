<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$id = $_POST['view_id'];
		echo '<option value="">select</option>';
	$sql = $mysqli->query("select * from locker_type where branch_id = '".$id."'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['id'].'">'.$row['locker_type'].'</option>';
		}
	}
}
?>