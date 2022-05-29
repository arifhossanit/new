<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	unset($_SESSION["cart_locker"]);
	$branch_id = $_POST['view_id'];
		echo '<option value="0">NO</option>';
	$sql = $mysqli->query("select * from locker_type where branch_id = '".$branch_id."'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['id'].'">'.$row['locker_type'].'</option>';
		}
	}
}
?>