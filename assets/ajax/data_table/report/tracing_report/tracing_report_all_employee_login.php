<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'login_info';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),    
	array( 
		'db' => 'employee_id', 
		'dt' => 1,
		'formatter' => function($d,$row){ global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			if(!empty($emp['id'])){
				return $emp['full_name'];
			}else{
				return '';
			}
		}
	),
	array( 
		'db' => 'employee_id', 
		'dt' => 2,
		'formatter' => function($d,$row){ global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			if(!empty($emp['id'])){
				return $emp['employee_id'];
			}else{
				return '';
			}
		}
	),
    array( 'db' => 'type',   'dt' => 3 ),
    array( 'db' => 'time',   'dt' => 4 ),
    array( 'db' => 'ip_address',   'dt' => 5 ),
    array( 'db' => 'data',   'dt' => 6 ),	
    array( 
		'db' => 'id', 
		'dt' => 7,
		'formatter' => function($d,$row){ global $home;
			return '<button onclick="return view_data('.$d.')" class="btn btn-xs btn-warning" type="button"><i class="fas fa-eye"></i></button>';			
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>