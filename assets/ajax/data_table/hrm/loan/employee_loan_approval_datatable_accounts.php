<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'employee_grant_loan';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 
		'db' => 'e_db_id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $emp['full_name'].' - '.$emp['employee_id'];
		}
	),
	array( 
		'db' => 'amount', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			return '<b style="color:green;">'.money($d).'</b>';
		}
	),
	array( 
		'db' => 'uploader_info', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 
		'db' => 'aproval_account', 
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
		'db' => 'id', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_grant_loan where id = '".$d."'"));
			if($info['aproval_account'] == 1 OR $info['aproval_account'] == 2){
				$buttons = '';
			}else{
				$buttons = '
					<form action="#" method="POST">
						<button onclick="return loan_accept_function('.$d.')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button>
						<button onclick="return loan_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>
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