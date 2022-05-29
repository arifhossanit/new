<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'booking_info';
$primaryKey = 'id';
$where = "id != '' GROUP BY data";
$i = 1;
$columns = array(
	array( 
		'db' => 'id', 'dt' => 0, 'formatter' => function( $d, $row){ global $i;
			return $i++;
		}
	),
	array( 
		'db' => 'data', 'dt' => 1, 'formatter' => function( $d, $row){
			return $d;
		}
	),
	array( 
		'db' => 'data', 'dt' => 2, 'formatter' => function( $d, $row){ global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("SELECT sum(security_deposit) as security_deposit from booking_info where data = '".$d."'"));
			return money($info['security_deposit']);
		}
	),
	array( 
		'db' => 'data', 'dt' => 3, 'formatter' => function( $d, $row){ global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("SELECT sum(security_deposit) as security_deposit from booking_info where data = '".$d."'"));
			return money($info['security_deposit']);
		}
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>