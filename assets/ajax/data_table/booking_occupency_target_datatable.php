<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'booking_target_adding_logs';
$primaryKey = 'id';
$where = "";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'unique_id',   'dt' => 1 ),
    array( 'db' => 'target_month',   'dt' => 2 ),
    array( 'db' => 'data',   'dt' => 3 ),
	array(
		'db' => 'uploader_info',
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$data = explode("___", $d);			
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$data[1]."'"));
			return $info['full_name']. ' | ' .$info['employee_id'];
		}
	),
	array(
		'db' => 'id',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			return '<button type="button" onclick="return vire_branch_target_info('.$d.')" class="btn btn-xs btn-info"><i class="far fa-eye"></i> View Details</button>';				
		}
	),


);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>