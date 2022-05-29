<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'employee_decreament_logs';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 
		'db' => 'e_db_id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return '<img src="'.$home.$emp['photo'].'" style="width:50px;"/>';
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $emp['full_name'].' - '.$emp['employee_id'];
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $emp['department_name'];
		}
	),
	array( 
		'db' => 'old_designation', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from designation  where designation_id = '".$d."'"));
			return $emp['designation_name'];
		}
	),
	array( 
		'db' => 'designation', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from designation  where designation_id = '".$d."'"));
			return $emp['designation_name'];
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			$basic_salary = $emp['basic_salary'];			
			$actual = $emp['basic_salary'];
			return '<b style="color:#f00;">'.money($actual).'</b>';
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			$increament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_increament_logs where e_db_id = '".$d."' and aproval = '1'"));
			$actual = $increament['total'];
			return '<b style="color:#f00;">'.money($actual).'</b>';
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$decreament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_decreament_logs where e_db_id = '".$d."' and aproval = '1'"));
			$actual = $decreament['total'];
			return '<b style="color:#f00;">'.money($actual).'</b>';
		}
	),
	array( 
		'db' => 'amount', 
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $mysqli;
			return '<b style="color:#f00;">'.money($d).'</b>';
		}
	),
    array( 'db' => 'start_date',   'dt' => 9 ),
	array( 
		'db' => 'uploader_info', 
		'dt' => 10,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 11,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else if($d == 2){
				return '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
			}			
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>