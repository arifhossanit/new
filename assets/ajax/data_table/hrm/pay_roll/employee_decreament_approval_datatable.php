<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");
if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
	$conditions = "";
}else{
	if($_SESSION['user_info']['d_head'] == 1){
		$sql = $mysqli->query("select * from employee where department = '".$_SESSION['user_info']['department']."'");
		$emp_id = '';
		while($row = mysqli_fetch_assoc($sql)){
			$emp_id .= "'".$row['id']."',";
		}
		$emp_id = rtrim($emp_id,',');
		$conditions = "e_db_id in (".$emp_id.")";
	}else{
		$conditions = "id = 0";
	}	
	$conditions .= " or (aproval = 1 and hr_check='0') ";
}
$table = 'employee_decreament_logs';
$primaryKey = 'id';
$where = "$conditions";
$columns = array(
	array( 
		'db' => 'id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) { 
			return $d;
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return '<img src="'.$home.$emp['photo'].'" style="width:50px;"/>';
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $emp['full_name'].' - '.$emp['employee_id'];
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $emp['department_name'];
		}
	),
	array( 
		'db' => 'old_designation', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from designation  where designation_id = '".$d."'"));
			return $emp['designation_name'];
		}
	),
	array( 
		'db' => 'designation', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from designation  where designation_id = '".$d."'"));
			return $emp['designation_name'];
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_decreament_logs where id = '".$d."'"));
			return '<button onclick="return view_increament_info('.$d.',2)" class="btn btn-danger btn-xs" type="button"><i class="far fa-eye"></i> View Decreament Info <b style="color:#efff00;">('.money($info['amount']).')</b></button>';
		}
	),	
    array( 'db' => 'start_date',   'dt' => 7 ),
	array( 
		'db' => 'uploader_info', 
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 9,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else if($d == 2){
				return '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
			}			
		}
	),
    array( 
		'db' => 'id', 
		'dt' => 10,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_decreament_logs where id = '".$d."'"));
			if($info['aproval'] == 1 OR $info['aproval'] == 2){
				if($info['aproval'] == 1 and $info['hr_check'] == 0){
					$buttons = "
						<form>
							<button onclick='return decreament_hr_check_done(".$d.")' type='button' class='btn btn-xs btn-primary hr_check_done'>Done</button>
						</form>
					";
				}else{
					$buttons = '';
				}
			}else{
				$buttons = '
					<form action="#" method="POST">
						<button onclick="return decreament_accept_function('.$d.')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button>
						<button onclick="return decreament_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>
					</form>
				';
			}			
			return $buttons;
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>