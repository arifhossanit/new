<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['page_id_array'])){
	$total = count($_POST['page_id_array']) + 1;
	for($i = 1; $i < $total; $i++){
		$data = (int)$i - 1;
		$mysqli->query("UPDATE manage_grade SET 
			serial = '".$i."' 
			WHERE id = '".$_POST["page_id_array"][$data]."'
		");
	}
	echo 'Table Order Update Successfully';
}
?>