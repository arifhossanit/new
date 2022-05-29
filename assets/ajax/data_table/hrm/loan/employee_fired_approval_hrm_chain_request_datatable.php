<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'exit_employee_chain_hr ';
$primaryKey = 'id';
$where = "aproval = '0'";
$columns = array(
	array( 
		'db' => 'e_db_id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return '<a href="'.$home.$emp['photo'].'" target="_blank"><img src="'.$home.$emp['photo'].'" style="width:50px;" /></a>';
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
			$dept = mysqli_fetch_assoc($mysqli->query("select * from department where department_id = '".$emp['department']."'"));
			return $dept['department_name'];
		}
	),
	array( 
		'db' => 'uploader_info', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from exit_employee_chain_hr where id = '".$d."'"));
			if($info['aproval'] == 1){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else if($info['aproval'] == 2){
				return '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
			}else{
				$check_send_request = mysqli_fetch_assoc($mysqli->query("select * from exit_employee_chain_aproval where exit_emp_id = '".$info['e_db_id']."'"));
				if(!empty($check_send_request['id'])){
					return '<button onclick="view_pending_status('.$info['e_db_id'].')" type="button" class="btn btn-xs btn-info"><i class="far fa-eye"></i> Pending!</button>';
				}else{
					return '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
				}			
			}			
		}
	),
    array( 
		'db' => 'id', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$get_employee = mysqli_fetch_assoc($mysqli->query("SELECT last_working_date from employee where id = " . $row[0]));
			$last_date = ($get_employee['last_working_date']) ? $get_employee['last_working_date'] : 'none';
			$request_button = '';
			$info = mysqli_fetch_assoc($mysqli->query("select * from exit_employee_chain_hr where id = '".$d."'"));
			// $check_emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."' and status = '0'"));
			// if(!empty($check_emp['id'])){
			// 	return '';
			// }else{		
				$check_send_request = mysqli_fetch_assoc($mysqli->query("SELECT id, count(*) as number_of_approvals from exit_employee_chain_aproval where exit_emp_id = '".$info['e_db_id']."'"));
				if(!empty($check_send_request['id'])){
					$check_chain_approval_state = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as chain_state_count from exit_employee_chain_aproval where exit_emp_id = '".$info['e_db_id']."' AND aproval = 1"));
					if($check_chain_approval_state['chain_state_count'] == $check_send_request['number_of_approvals']){
						$request_button = '<button data-toggle="modal" data-target="#give_last_working_day" onclick="return set_id_for_release_date('.$d.', \''.$last_date.'\')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button><button onclick="return hr_fired_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>';
					}
				}else{
					$request_button = '<button onclick="return hr_request_for_chain_approval('.$info['e_db_id'].')" type="button" class="btn btn-xs btn-info"><i class="fas fa-check-circle"></i> Request for Chain approval</button>';
					$request_button .= '<button data-toggle="modal" data-target="#give_last_working_day" onclick="return set_id_for_release_date('.$d.', \''. $last_date .'\')" type="button" class="ml-1 btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button><button onclick="return hr_fired_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>';
				}
				if($info['aproval'] == 1 OR $info['aproval'] == 2){
					$request_button = '';
				}
				$buttons = '
					<form action="#" method="POST">
						'.$request_button.'
					</form>
				';			
				return $buttons;
			// }
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>