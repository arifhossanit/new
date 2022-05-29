<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
$table = 'advance_petty_cash_logs';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
    array(
        'db'        => 'transaction_id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {		
			return '<span style="white-space: nowrap;">'.$d.'</span>';
        }
    ),
	array(
        'db'        => 'employee_id',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {			
			global $mysqli;
			$employee = mysqli_fetch_assoc($mysqli->query("SELECT full_name FROM employee WHERE id = '".$d."'"));
			return '<span style="white-space: nowrap;">'.$employee['full_name'].'</span>';
        }
    ),
	array(
        'db'        => 'employee_id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {			
			global $mysqli;
			$employee = mysqli_fetch_assoc($mysqli->query("SELECT department_name FROM employee WHERE id = '".$d."'"));
			return '<span>'.$employee['department_name'].'</span>';
        }
    ),
	array(
        'db'        => 'amount',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;white-space: nowrap;">'.money($d).'</span>';
        }
    ),
	array(
        'db'        => 'given_date',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {		
			return '<span style="white-space: nowrap;">'.$d.'</span>';
        }
    ),
    array( 'db' => 'note',    'dt' => 6 ),
    array(
		'db' => 'uploader_info',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			global $mysqli;			
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE email = '".$u[1]."'"));
					return '<span style="white-space: nowrap;">'.$emp['full_name'].'</span>';
				}
			}	
		}
	),
    array( 'db' => 'data',   'dt' => 8 ),
	array(
		'db' => 'id',
		'dt' => 9,
		'formatter' => function( $d, $row ){
			global $mysqli;
			$get_info = mysqli_fetch_assoc($mysqli->query("select * from advance_petty_cash_logs where id = '".$d."'"));
			if($get_info['status'] == 1){
				$employee_id = $get_info['employee_id'];
				return '<span style="white-space: nowrap;">
					<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>
					<button type="button" onclick="return resend_balance_accepted_otp('.$employee_id.', '.$d.')" class="btn btn-xs btn-success">Resend OTP!</button>
				</span>';
			}else{
				return '
					<button type="button" class="btn btn-xs btn-success"><i class="fas fa-check-square"></i></button>
				';
			}
		}
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>