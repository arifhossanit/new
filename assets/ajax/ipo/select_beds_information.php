<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['bed_id'])){
	$bed_id = $_POST['bed_id'];
	$row = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$bed_id."'"));
	echo $row['id'].'_'.$row['bed_name'];
}
?>