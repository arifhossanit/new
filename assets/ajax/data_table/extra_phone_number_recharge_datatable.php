<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if(is_file($file)){
	include($file);
}
include("../../../application/config/ajax_config.php");

$table = 'add_extrarecharge_number';
$primaryKey = 'id';
$where = "status = '1'";
$columns = array(
    array(
		'db' => 'employee_id',
		'dt' => 0,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $emp_info['full_name'];
		}
	),
    array( 'db' => 'purpose',   'dt' => 1 ),
    array( 'db' => 'phone_number',    'dt' => 2 ),
    array(
		'db' => 'amount',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			return money($d);
		}
	),
    array( 'db' => 'data',    'dt' => 4 ),
    array(
		'db' => 'id',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			if(check_permission('role_1630485524_82')){
				return '<button onclick="return delete_extrarecharge_number('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>';
			}else{
				return '';
			}
		}
	)
);
$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>