<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'employee_wallet_money_transfer_logs';
$employee_ac_id = $_GET['employee_id'];
$primaryKey = 'id';
$where = "sender_id = '".$employee_ac_id."' or receiver_id = '".$employee_ac_id."'";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array( 'db' => 'amount', 'dt' => 1 ),
	array(
		'db' => 'sender_id',
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $info['full_name'].' | '.$info['employee_id'];
		}
	),
	array(
		'db' => 'receiver_id',
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $info['full_name'].' | '.$info['employee_id'];
		}
	),
	array(
		'db' => 'id',
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli; global $employee_ac_id;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_wallet_money_transfer_logs where id = '".$d."'"));
			if($info['sender_id'] == $employee_ac_id){
				return '<button type="button" class="btn btn-danger btn-xs">Sended Money</button>';
			}else{
				return '<button type="button" class="btn btn-success btn-xs">Received Money</button>';
			}
		}
	),
	array( 'db' => 'note', 'dt' => 5 ),
	array( 'db' => 'data', 'dt' => 6 ),
	array(
		'db' => 'uploader_info',
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$value = explode("___",$d);
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$value[1]."'"));
			return $info['full_name'].' | '.$info['employee_id'];
		}
	),
	
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>