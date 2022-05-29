<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");
$table = 'employee_missing_attendance_request';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array( 'db' => 'number_of_days',   'dt' => 1 ),
	array( 
		'db' => 'id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_missing_attendance_request where id = '".$d."'"));
			$data = '';
			$i = '1';
			$sql = $mysqli->query("select * from employee_missing_attendance_request_date where unique_id = '".$info['unique_id']."'");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['is_hr_checked'] == 1){
					$button = '<button type="button" class="btn btn-success btn-xs">Checked</button>';
				}else if($row['is_hr_checked'] == 2){
					$button = '<button type="button" class="btn btn-danger btn-xs">Rejected</button>';
				}else{
					$button = '<button type="button" class="btn btn-info btn-xs">Pending</button>';
				}
				$uid = "'".rahat_encode($info['unique_id'])."'";
				$data .= '<span>'.$i++.'. &nbsp; '.$row['adj_date'].' &nbsp; '.$button.' 
				<button type="button" onclick="return view_dates_data('.$uid.')" class="btn btn-warning btn-xs"><i class="far fa-eye"></i></button>
				</span><hr  style="margin:0px;"/>';
			}
			return $data;
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_missing_attendance_request where id = '".$d."'"));
			$data = '';
			$i = '1';
			$sql = $mysqli->query("select * from employee_missing_attendance_request_date where unique_id = '".$info['unique_id']."'");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['aproval'] == 1){
					$button = '<button type="button" class="btn btn-success btn-xs">Approved</button>';
				}else if($row['aproval'] == 2){
					$button = '<button type="button" class="btn btn-danger btn-xs">Rejected</button>';
				}else if($row['is_hr_checked'] == 2){
					$button = '<button type="button" class="btn btn-danger btn-xs">Rejected</button>';
				}else{
					$button = '<button type="button" class="btn btn-info btn-xs">Pending</button>';
				}
				$uid = "'".rahat_encode($info['unique_id'])."'";
				if($row['aproval'] == 1){
					$get_data = mysqli_fetch_assoc($mysqli->query("select * from boss_emp_missing_att_checked_logs where missing_att_id = '".$row['id']."'"));
					$deduc = '| Deduction Amount: <b>'.money($row['deduction_amount']).'</b> | Note: '.$get_data['boss_note'].'';
				}else{
					if($row['is_hr_checked'] == 1){
						$deduc = '
							<button type="button" onclick="return view_dates_data('.$uid.')" class="btn btn-success btn-xs">Accept</button>
							<button type="button" onclick="return view_dates_data('.$uid.')" class="btn btn-danger btn-xs">Reject</button>
						';
					}else{
						$deduc = '';
					}
				}
				$data .= '<span>'.$i++.'. &nbsp; '.$row['adj_date'].' &nbsp; '.$button.' '.$deduc.'</span><hr  style="margin:0px;"/>';
			}
			return $data;
		}
	),
	array( 
		'db' => 'employee_id', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $emp['department_name'];
		}
	),
	array( 
		'db' => 'employee_id', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $emp['designation_name'];
		}
	),
	array( 
		'db' => 'employee_id', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return '<img src="'.$home.$emp['photo'].'" style="width:50px;" />';
		}
	),
	array( 
		'db' => 'uploader_info', 
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$d = explode("___",$d);
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$d['1']."'"));
			return $emp['full_name'].' | '.$emp['employee_id'];
		}
	),
	array( 'db' => 'data',   'dt' => 8 ),
	array( 
		'db' => 'id', 
		'dt' => 9,
		'formatter' => function( $d, $row ) { global $mysqli;
			$data = "<a href='attendance-adsjustment-boss-aproval-delete/".$d."' class='btn btn-xs btn-danger'><i class='fas fa-trash-alt'></i></a>";
			return $data;
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>