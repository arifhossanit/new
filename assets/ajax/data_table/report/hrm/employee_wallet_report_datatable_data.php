<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'employee_award_wallet';
$primaryKey = 'id';
$where = "balance > 0";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),    
	array( 
		'db' => 'employee_id', 
		'dt' => 1,
		'formatter' => function($d,$row){ global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $emp['full_name'].' <b style="color:#f00;">|</b> '.$emp['employee_id'];
		}
	),
	array( 
		'db' => 'balance', 
		'dt' => 2,
		'formatter' => function($d,$row){
			if($d > 0){
				return '<b style="color:green;">'.money($d).'<b>';
			}else{
				return '<span style="color:red;">'.money($d).'<span>';
			}			
		}
	),	
    array( 
		'db' => 'id', 
		'dt' => 3,
		'formatter' => function($d,$row){ 
			return '---';
		}
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>