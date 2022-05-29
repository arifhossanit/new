<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'screen_shot_logs';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),    
	array( 
		'db' => 'user_id', 
		'dt' => 1,
		'formatter' => function($d,$row){ global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$d."'"));
			if(!empty($emp['id'])){
				return $emp['full_name'];
			}else{
				return '';
			}
		}
	),
	array( 
		'db' => 'user_id', 
		'dt' => 2,
		'formatter' => function($d,$row){ global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$d."'"));
			if(!empty($emp['id'])){
				return $emp['employee_id'];
			}else{
				return '';
			}
		}
	),
	array( 
		'db' => 'branch_id', 
		'dt' => 3,
		'formatter' => function($d,$row){ global $mysqli;
			$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$d."'"));
			if(!empty($branch['id'])){
				return $branch['branch_name'];
			}else{
				return '';
			}
		}
	),
    array( 'db' => 'note',   'dt' => 4 ),
    array( 'db' => 'times',   'dt' => 5 ),
    array( 'db' => 'data',   'dt' => 6 ),	
    array( 
		'db' => 'screenshot', 
		'dt' => 7,
		'formatter' => function($d,$row){ global $home;
			$page_type = "'_blank'";
			$open_link = "'".$home.$d."'";
			if(!empty($d)){
				return '<button onclick="window.open('.$open_link.','.$page_type.')" type="button" class="btn btn-xs btn-info"><i class="fas fa-external-link-alt"></i></button>';
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