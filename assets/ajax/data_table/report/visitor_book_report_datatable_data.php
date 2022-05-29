<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'visitor_book';
$primaryKey = 'id';
$where = "reason  = 'Visitor' or reason  = 'Mobile Visitor'";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'name',   'dt' => 1 ),
	array( 
		'db' => 'phone', 
		'dt' => 2,
		'formatter' => function($d,$row){
			return '<a href="tel:'.$d.'">'.$d.'</a>';
		}
	),
    array( 'db' => 'In_time',   'dt' => 3 ),
    array( 'db' => 'data',   'dt' => 4 ),	
    array( 
		'db' => 'id', 
		'dt' => 5,
		'formatter' => function($d,$row){ global $home; global $mysqli;
			$visitor = mysqli_fetch_assoc($mysqli->query("select * from visitor_book where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where phone_number like '%".substr($visitor['phone'],'1')."'"));
			if(!empty($member['id'])){
				$return = '<button class="btn btn-xs btn-warning" type="button">Booked</button>';
			}else{
				$return = '----';
			}
			return $return;
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>