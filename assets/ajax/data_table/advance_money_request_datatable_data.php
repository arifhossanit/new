<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
$employ_id = $_GET['employee_id'];
$get_emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$employ_id."'"));
$table = 'advance_money_request';
$primaryKey = 'id';
$where = "employee_id = '".$get_emp_info['employee_id']."'";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'amount',   'dt' => 1 ),
    array( 'db' => 'note',   'dt' => 2 ),
    array( 'db' => 'data',   'dt' => 3 ),
	array(
        'db'        => 'id',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {			
			global $mysqli;
			$status = mysqli_fetch_assoc($mysqli->query("SELECT * FROM advance_money_request WHERE id = '".$d."'"));
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