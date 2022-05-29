<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['page_id_array'])){
	for($i = 0; $i < count($_POST['page_id_array']); $i++){
		$mysqli->query("UPDATE designation SET 
			serial = '".$i."' 
			WHERE id = '".$_POST["page_id_array"][$i]."'
		");
	}
	echo 'Table Order Update Successfully';
}
?>