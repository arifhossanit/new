<?php 
include("../../../application/config/ajax_config.php");
$sql = "
SELECT COUNT(branch_id) as nmbr, branch_name
FROM booking_info
GROUP BY branch_id
ORDER BY COUNT(branch_id) ASC
";
$bql = $mysqli->query($sql);
while($row = mysqli_fetch_assoc($bql)){	
	$data[] = array(
		'y' => $row['nmbr'],
		'label' => $row['branch_name']
	);
}
echo json_encode($data, JSON_NUMERIC_CHECK);
?>