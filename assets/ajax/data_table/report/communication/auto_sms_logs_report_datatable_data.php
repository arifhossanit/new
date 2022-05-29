<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'sms_logs';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),    
	array( 
		'db' => 'number', 
		'dt' => 1,
		'formatter' => function($d,$row){
			return '<a href="tel:'.$d.'">'.$d.'</a>';
		}
	),
	array( 
		'db' => 'message', 
		'dt' => 2,
		'formatter' => function($d,$row){
			return '<p style="height:20px;width:400px;overflow: hidden;margin:0px;float:left;">'.$d.'</p>...';
		}
	),
    array( 'db' => 'time',   'dt' => 3 ),
    array( 'db' => 'data',   'dt' => 4 ),	
    array( 
		'db' => 'id', 
		'dt' => 5,
		'formatter' => function($d,$row){ 
			return '<button onclick="return view_full_sms('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fas fa-eye"></i></button>';
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>