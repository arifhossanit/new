<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'corn_jobs_log';
$primaryKey = 'id';
$where = "reason = 'Member Available Date Manage & Rental Issue'";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),    
	array( 
		'db' => 'reason', 
		'dt' => 1,
		'formatter' => function($d,$row){
			return '<p style="height:20px;width:400px;overflow: hidden;margin:0px;float:left;">'.$d.'</p>...';
		}
	),
    array( 'db' => 'day',   'dt' => 2 ),
    array( 'db' => 'time',   'dt' => 3 ),
    array( 'db' => 'data',   'dt' => 4 )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>