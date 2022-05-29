<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'member_meal';
$primaryKey = 'id';

$where = "booking_id = '".rahat_decode($_GET['member_id'])."'";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array( 'db' => 'days',   'dt' => 1 ),
	array(
		'db' => 'breakfast',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if(!empty($d) AND $d == '1'){
					return '<button class="btn btn-xs btn-success" type="button">YES</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">NO</button>';
				}
			}
		}
	),
	array(
		'db' => 'lunch',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d == '1'){
					return '<button class="btn btn-xs btn-success" type="button">YES</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">NO</button>';
				}
			}
		}
	),
	array(
		'db' => 'dinner',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d == '1'){
					return '<button class="btn btn-xs btn-success" type="button">YES</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">NO</button>';
				}
			}
		}
	),
	array(
		'db' => 'request',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d == '1'){
					return '<button class="btn btn-xs btn-success" type="button">YES</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">NO</button>';
				}
			}
		}
	),
	array( 'db' => 'data',    'dt' => 6 )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>