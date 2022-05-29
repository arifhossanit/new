<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'member_login_info';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),    
	array( 
		'db' => 'member_id', 
		'dt' => 1,
		'formatter' => function($d,$row){ global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$d."'"));
			if(!empty($emp['id'])){
				return $emp['full_name'];
			}else{
				return '';
			}
		}
	),
    array( 'db' => 'type',   'dt' => 2 ),
    array( 'db' => 'time',   'dt' => 3 ),
    array( 'db' => 'ip_address',   'dt' => 4 ),
    array( 'db' => 'data',   'dt' => 5 ),	
    array( 
		'db' => 'id', 
		'dt' => 6,
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