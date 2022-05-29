<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");
if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
	$department = "";
	if($_SESSION['super_admin']['employee_id'] == 113){
		$department = " AND department = '687558693128511379'";
	}
}else{
	if($_SESSION['user_info']['department'] == '1806965207554226682' OR $_SESSION['user_info']['department'] == '2392358440567352112'){ // Branch filter not allicable for `Food and Beverage` & `Housekeeping` & `Security`
		$department = " AND e_db_id in (SELECT id from employee where department = '1806965207554226682' OR department = '2392358440567352112')";
	}else if($_SESSION['user_info']['department'] == '1383007286312996344' AND $_SESSION['user_info']['d_head'] == '1'){ // HR Department
		$department = " AND ( h_id = ".$_SESSION['user_info']['employee_id']." OR e_db_id in (SELECT id from employee where department = '1383007286312996344') )";
	}else{
		$department = " AND e_db_id in (SELECT id from employee where department = '".$_SESSION['user_info']['department']."')";
	}
}
//e_db_id
$table = '(
	SELECT 
		a.e_db_id,
		a.leave_lock,
		a.id,
		a.start_days,
		a.how_many_days,
		a.note,
		a.end_date,
		a.h_id,
		a.h_aproval,
		a.aproval,
		a.uploader_info,
		a.data,
		b.photo,
		a.employee_id,
		b.department_name,
		b.department,
		b.full_name,
		b.designation_name,
		c.branch_name
	from employee_leave_logs a
	INNER JOIN employee b on b.id = a.e_db_id
	INNER JOIN branches c on c.branch_id = b.branch
) temp';
$primaryKey = 'id';
$date_filter = "";
if(isset($_GET['leave_date'])){
	$date_filter = " AND '" . $_GET['leave_date'] . "' between STR_TO_DATE(start_days, '%d/%m/%Y') AND STR_TO_DATE(end_date, '%d/%m/%Y')";
}
$where = "(h_aproval = 1 OR h_aproval = 3) AND aproval = 1".$date_filter.$department;
// echo $where;
// $where = " (h_aproval = 1 OR h_aproval = 3) AND aproval = 1".$department;
$columns = array(
	array( 
		'db' => 'id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) {			
			return '<input id="leave_check" type="checkbox" value="'.$d.'" />';
		}
	),
	array( 
		'db' => 'photo',
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			return '<a href="'.$home.$d.'" target="_blank"><img src="'.$home.$d.'" style="width:50px;"/></a>';
		}
	),
	array( 
		'db' => 'full_name',
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $d.' - '.$row[17];
		}
	),
	array( 
		'db' => 'branch_name',
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
		}
	),
	array( 
		'db' => 'department_name',
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
		}
	),
	array( 
		'db' => 'designation_name',
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
		}
	),
	array(
		'db' => 'start_days',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			$time = explode('/', $d);
			return $time[2].'/'.$time[1].'/'.$time[0];	
		} 
	),
	array( 'db' => 'end_date',   'dt' => 7 ),
	array( 
		'db' => 'how_many_days', 
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			return $d.' Days';
		}
	),
	array( 'db' => 'note',   'dt' => 9 ),
	array( 
		'db' => 'h_id',
		'dt' => 10,
		'formatter' => function( $d, $row ) { global $mysqli;global $home;
			if(!empty($d)){
				$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
				return '<a href="'.$home.$emp['photo'].'" target="_blank"><img src="'.$home.$emp['photo'].'" style="width:50px;"/></a>';
			}else{
				return '';
			}
			
		}
	),
	array( 
		'db' => 'h_aproval', 
		'dt' => 11,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else if($d == 2){
				return '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
			}else if($d == 3){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
			}			
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 12,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($row[11] == '2'){

			}else if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else if($d == 2){
				return '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
			}			
		}
	),
	array( 
		'db' => 'uploader_info', 
		'dt' => 13,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 'db' => 'data',   'dt' => 14 ),
	array( 
		'db' => 'id', 
		'dt' => 15,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select `note` from employee_leave_aproval_logs where leave_id = '".$d."'"));		
			return (is_null($info)) ? ' - ' : $info['note'];
		}
	),
    array( 
		'db' => 'id', 
		'dt' => 16,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$d."'"));
			$leave_employee_information = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where id = '".$info['e_db_id']."'"));
			$top_management = mysqli_fetch_assoc($mysqli->query("SELECT d_head_reporting, department from employee where employee_id = '".$row[17]."'"));
			if(is_null($top_management)){
				$top_management_id = '114';
			}else if($top_management['d_head_reporting'] == '0'){
				$top_management_id = '114';
			}else{
				$top_management_id = $top_management['d_head_reporting'];
			}
			if($info['h_aproval'] == '0' AND $_SESSION['user_info']['d_head'] == '1' AND $info['h_id'] == $_SESSION['user_info']['employee_id']){
				if(is_null($info['leave_lock'])){
					if($_SESSION['user_info']['department'] == '2392358440567352112'){
						$buttons = '
							<form action="#" method="POST">
								<button onclick="return leave_accept_function('.$d.', \'housekeeping_head\')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle mr-1"></i>HI Approval</button>
								<button onclick="return leave_reject_function('.$d.', \'head\')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle mr-1"></i>HI Rejection</button>
							</form>
						';
					}else{
						$buttons = '
							<form action="#" method="POST">
								<button onclick="return leave_accept_function('.$d.', \'head\')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle mr-1"></i>Head Approval</button>
								<button onclick="return leave_reject_function('.$d.', \'head\')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle mr-1"></i>Head Rejection</button>
							</form>
						';
					}
				}else{
					return '<badge class="badge badge-danger">Locked</badge>';
				}
				
			}else if($info['h_aproval'] == '2' OR $info['aproval'] == 1 OR $info['aproval'] == 2){
				$buttons = '<button onclick="return view_note_function('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fas fa-eye"></i> View</button>';	
			}else if($info['h_aproval'] == '1' AND $info['aproval'] == 0 AND $top_management_id == $_SESSION['user_info']['employee_id']){
				$buttons = '
					<form action="#" method="POST">
						<button onclick="return leave_accept_function('.$d.', \'boss\')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle mr-1"></i>Boss Approval</button>
						<button onclick="return leave_reject_function('.$d.', \'boss\')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle mr-1"></i>Boss Rejection</button>
					</form>
				';		
			}else if($info['h_aproval'] == '3' AND $info['aproval'] == 0 AND $info['h_id'] == $_SESSION['user_info']['employee_id']){
				if(is_null($info['leave_lock'])){
					$buttons = '
						<form action="#" method="POST">
							<button onclick="return leave_accept_function('.$d.', \'boss\')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle mr-1"></i>BI Approval</button>
							<button onclick="return leave_reject_function('.$d.', \'boss\')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle mr-1"></i>BI Rejection</button>
						</form>
					';
				}else{
					return '<badge class="badge badge-danger">Locked</badge>';
				}	
			}else if($info['h_aproval'] == '1' AND $info['aproval'] == 0 AND $top_management_id == $_SESSION['user_info']['employee_id']){
				$buttons = '
					<form action="#" method="POST">
						<button onclick="return leave_accept_function('.$d.', \'boss\')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle mr-1"></i>Boss Approval</button>
						<button onclick="return leave_reject_function('.$d.', \'boss\')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle mr-1"></i>Boss Rejection</button>
					</form>
				';		
			}else{
				if(is_null($info['leave_lock'])){
					if($info['h_aproval'] == '0'){
						if(is_null($top_management) AND $leave_employee_information['department'] == '2392358440567352112'){
							$buttons = '<badge class="badge badge-warning">Pending HI approval</badge>';
						}else{
							$buttons = '<badge class="badge badge-warning">Pending DH approval</badge>';
						}
					}else if($info['h_aproval'] == '3'){
						$buttons = '<badge class="badge badge-info">Pending DH approval</badge>';
					}else{
						$buttons = '<badge class="badge badge-info">Pending Boss approval</badge>';
					}
				}else{
					return '<badge class="badge badge-danger">Locked</badge>';
				}
			}
			// if($info['aproval'] == 2){
			// 	$buttons = '';
			// }else{
			// 	$buttons = '<button onclick="return view_note_function('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fas fa-eye"></i> View</button>';
			// }	
			// else{
			// 	$buttons = '
			// 		<form action="#" method="POST">
			// 			<button onclick="return leave_accept_function('.$d.')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button>
			// 			<button onclick="return leave_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>
			// 		</form>
			// 	';
			// }
			return $buttons;
		}
	),
	array('db' => 'employee_id', 'dt' => 17)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>