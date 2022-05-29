<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'employee_festiavle_awards';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array( 'db' => 'date_full',   'dt' => 1 ),
	array( 'db' => 'reliagion',   'dt' => 2 ),
	array( 'db' => 'note',   'dt' => 3 ),
	array( 'db' => 'percentage',   'dt' => 4 ),
	array( 
		'db' => 'uploader_info', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$data = explode("___",$d);
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$data['1']."'"));
			return $emp['full_name'].' - '.$emp['employee_id'];
		}
	),
	array( 'db' => 'data',   'dt' => 6 )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>