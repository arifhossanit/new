<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'employee_fired_list ';
$primaryKey = 'id';
$where = ""; //e_db_id in(select id from employee where status = '1')
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
		'db' => 'e_db_id', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $emp['designation_name'];
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			$bran = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$emp['branch']."'"));
			return $bran['branch_name'];
			
		}
	),
	array( 
		'db' => 'reason', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			return '<b style="color:red;">'.$d.'</b>';
		}
	),
	array( 
		'db' => 'uploader_info', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),array( 
		'db' => 'data', 
		'dt' => 7,
		'formatter' => function( $d, $row ) {			
			return $d; 
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 8,
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
		'dt' => 9,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_fired_list where id = '".$d."'"));
			//$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where department = '1383007286312996344' and d_head = '1' and id = '".$_SESSION['user_info']['employee_id']."'"));
			//if(!empty($emp['id'])){
			//	if($info['aproval'] == 1 OR $info['aproval'] == 2){
			//		$check_next = mysqli_fetch_assoc($mysqli->query("select * from exit_employee_chain_aproval where exit_emp_id = '".$info['e_db_id']."'"));
			//		if(empty($check_next['id'])){
			//			$buttons = '<button type="button" onclick="return aprove_modal('.$info['e_db_id'].')" class="btn btn-xs btn-info">Next Action!</button>';
			//		}else{
			//			$buttons = '';						
			//		}					
			//	}else{
			//		$buttons = '';
			//	}
			//}else{
				if($info['aproval'] == 1 OR $info['aproval'] == 2){
					$buttons = '';
				}else{
					$buttons = '
						<form action="#" method="POST">
							<button onclick="return fired_accept_function('.$d.')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button>
							<button onclick="return fired_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>
						</form>
					';
				}			
				
			//}
			return $buttons;
			
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>