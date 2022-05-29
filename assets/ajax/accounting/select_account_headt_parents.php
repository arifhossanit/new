<?php 
include("../../../application/config/ajax_config.php");
echo '<option value="">Select Parents</option>';
function printTree($level = 0, $parentID = null) { global $mysqli;															
	$sql = "SELECT * FROM account_type where status = '1' AND ";
	if($parentID == null) {
		$sql .= "parents_id = ''";
	} else {
		$sql .= "parents_id = '".$parentID."' ";
	}														
	$result = $mysqli->query($sql);
	while($row = mysqli_fetch_assoc($result)){		
		$currentID = $row['id'];
		$dashes = '';
		for($i = 0; $i < $level; $i++) {
			$dashes .= '*';
		}
		echo '<option value="'.$row['id'].'">'.$dashes.' '.$row['code'].' - '.$row['name'].'</option>';
		printTree($level+1, $currentID);
	}
}	
if(isset($_POST['signal_one'])){ 
	echo printTree();
} 
?>