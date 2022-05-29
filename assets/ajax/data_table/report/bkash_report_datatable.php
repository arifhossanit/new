<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = '(SELECT 
            a.id,
            a.branch_id,
            a.transaction_id,
            a.booking_id,
            a.payment_method,
            a.details,
            a.mobile_amount,
            a.invoice_number,
            a.note,
            a.status,
            a.uploader_info,
            a.data,
            b.branch_name,
            c.full_name,
            d.careof,
            d.transaction_type
            FROM payment_received_method a
            INNER JOIN branches b using(branch_id)
            INNER JOIN member_directory c using(booking_id)
            INNER JOIN transaction d using(transaction_id)
            
        ) temp';
$primaryKey = 'id';
$branch_id = '';
if($_GET['branch_id'] != 'all'){
    $branch_id = " AND transaction_id like '" . $_GET['branch_id'] . "%'";
}
$date_filter = "";
if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);	
	$one_ymd = explode('/',$one[0]);
	$two_ymd = explode('/',$one[1]);
	$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
	$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
	$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
}
$type_filter = '';
if($_GET['transaction_type'] != 'all'){
	$type_filter = " AND transaction_type = '".$_GET['transaction_type']."'";
}

$where = "payment_method LIKE 'Mobile Banking' AND details LIKE '%Bikash%' ".$branch_id.$date_filter.$type_filter;

$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'branch_name',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
            return $d;
		}
	),
    array(
		'db' => 'full_name',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
            return $d;
		}
	),
    array(
		'db' => 'careof',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
            return $d;
		}
	),
	array(
		'db' => 'transaction_id',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
            return $d;
		}
	),
	array(
		'db' => 'details',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			$info = explode(':', $d);
            return $info[3];
		}
	),
	array(
		'db' => 'mobile_amount',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			if($row[9] == 'Credit'){
				return $d;
			}
		}
	),
	array(
		'db' => 'mobile_amount',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			if($row[9] == 'Debit'){
				return $d;
			}
		}
	),
	array(
		'db' => 'data',
		'dt' => 8,
		'formatter' => function( $d, $row ) {
            return $d;
		}
	),
	array(
		'db' => 'transaction_type',
		'dt' => 9,
		'formatter' => function( $d, $row ) {
            return $d;
		}
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>