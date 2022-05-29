<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
$table = '';
$table = '(
	SELECT 
		a.id,
		a.created_at,
		a.updated_at,
		a.slip_id,
		a.branch_id,
		b.employee_id,
		b.full_name,
		c.branch_name
	from instant_transaction_slip_logs a
	INNER JOIN employee b using(employee_id)
	INNER JOIN branches c using(branch_id)
) temp';
$primaryKey = 'id';
$date_condition = "";
if(!empty($_GET['date_range'])){

	$date_time = explode(' - ', $_GET['date_range']);
	$from_time = DateTime::createFromFormat('d/m/Y', $date_time[0]);
	$to_time = DateTime::createFromFormat('d/m/Y', $date_time[1]);
	$date_condition = " AND created_at between '".$from_time->format('Y-m-d 00:00:00')."' AND '".$to_time->format('Y-m-d 23:59:59')."'";

}

$branch_condition = "";
if($_GET['branch_id'] != '1'){
	$branch_condition = " AND branch_id = '".$_GET['branch_id']."'";
}

$where =  "created_at != '0000-00-00' " . $branch_condition . $date_condition;
$columns = array(
	array(
		'db' => 'id',
		'dt' => 0,
	),
	array(
        'db'        => 'slip_id',
        'dt'        => 1,
    ),
	
	array(
        'db'        => 'branch_name',
        'dt'        => 2,
    ),
	array(
        'db'        => 'employee_id',
        'dt'        => 3,
    ),
	array(
        'db'        => 'full_name',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
			return $d." (".$row[3].")";
        }
    ),
	array(
        'db'        => 'created_at',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
			$date = new DateTime($d);
			return $date->format('d F, Y. h:i a');
        }
    ),
	array(
        'db'        => 'slip_id',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
			return '<button onclick="show_receipt(\''.$d.'\')" type="button" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>';
        }
    ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>