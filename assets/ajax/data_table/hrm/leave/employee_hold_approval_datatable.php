<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'hold_employe_logs';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 
		'db' => 'id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) {			
			return '<input id="hold_check" type="checkbox" value="'.$d.'" />';
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
			if($emp['status'] == 1){
				return '<button type="button" class="btn btn-xs btn-success">UNHOLD</button>';
			}else if($emp['status'] == 2){
				return '<button type="button" class="btn btn-xs btn-danger">HOLD</button>';
			}else{
				return '';
			}
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 3,
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
		'db' => 'uploader_info', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),	
	array( 'db' => 'data',   'dt' => 5 ),
    array( 
		'db' => 'id', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from hold_employe_logs where id = '".$d."'"));
			if(!empty($info['id'])){
				if($info['aproval'] == 1 OR $info['aproval'] == 2){
					$buttons = '';
				}else{
					$buttons = '
						<form action="#" method="POST">
							<button onclick="return hold_accept_function('.$d.')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button>
							<button onclick="return hold_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>
						</form>
					';
				}
			}else{
				$buttons = '';
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