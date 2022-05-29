<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");
function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$table = 'employee_sallary_generate_logs';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array( 
		'db' => 'month', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			return month_name($d);
		}
	),
	array( 'db' => 'year',   'dt' => 2 ),
	array( 'db' => 'full_date',   'dt' => 3 ),
	array( 'db' => 'full_time',   'dt' => 4 ),
	array( 'db' => 'employee_type',   'dt' => 5 ),
	array( 
		'db' => 'id', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_sallary_generate_logs where id = '".$d."'"));
			$data = explode("___",$info['uploader_info']);
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$data[1]."'"));
			return $emp['full_name'].' - '.$emp['employee_id'];
		}
	),
	
    array( 
		'db' => 'id', 
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_sallary_generate_logs where id = '".$d."'"));
			$unique_id = "'".$info['unique_id']."'";
			return '<button onclick="return view_employee_sallary_list('.$unique_id.')" type="button" class="btn btn-xs btn-success"><i class="far fa-eye"></i> View Sallary List</button>';
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>