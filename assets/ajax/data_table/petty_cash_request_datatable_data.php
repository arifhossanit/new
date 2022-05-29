<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
$branch_id = $_GET['branch_id'];
$get_emp_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$branch_id."'"));
$table = 'petty_cash_request_logs';
$primaryKey = 'id';
$where = "branch_id = '".$get_emp_info['branch_id']."'";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
    //array( 'db' => 'amount',   'dt' => 1 ),
    array( 'db' => 'note',   'dt' => 1 ),
    array( 'db' => 'data',   'dt' => 2 ),
	array(
        'db'        => 'id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {			
			global $mysqli;
			$status = mysqli_fetch_assoc($mysqli->query("SELECT * FROM petty_cash_request_logs WHERE id = '".$d."'"));
			if($status['status'] == 1){
				return '<button type="button" class="btn btn-info btn-sm btn-block">Request Pending!</button>';
			}else if($status['status'] == 2){
				return '<button type="button" class="btn btn-success btn-sm btn-block">Request Accepted!</button>';
			}else if($status['status'] == 3){
				return '<button type="button" class="btn btn-danger btn-sm btn-block">Request Rejected!</button>';
			}else if($status['status'] == 4){
				return '<button type="button" class="btn btn-primary btn-sm btn-block">Need SMS Verify!</button>';
			}
        }
    )	
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>