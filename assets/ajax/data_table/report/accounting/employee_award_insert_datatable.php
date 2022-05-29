<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");
$table = 'award_insert_logs';
$primaryKey = 'id';
if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);	
	$one_ymd = explode('/',$one[0]);
	$two_ymd = explode('/',$one[1]);
	$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
	$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
	$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
}else{
	$date_filter = "";
}

$where = "amount != '0' $date_filter"; //
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'employee_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			if(!empty($info['id'])){
				return $info['full_name'].' - '.$info['employee_id'];
			}else{
				return 'NULL';
			}
		}
	),
	array(
		'db' => 'amount',
		'dt' => 2,
		'formatter' => function( $d, $row ) {			
			if(!empty($d)){
				return money($d);
			}else{
				return 'NULL';
			}
		}
	),
	array(
		'db' => 'id',
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where id = '".$d."'"));
			if(!empty($info['id'])){
				return $info['date_from'].' - '.$info['date_to'];
			}else{
				return 'NULL';
			}
		}
	),
	array(
		'db' => 'type',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				return '<span style="color:#a50000;font-weight:bolder;">'.$d.'</span>';
			}else{
				return 'NULL';
			}
		}
	),
	array( 'db' => 'data',    'dt' => 5 )
	
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>