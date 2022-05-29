<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
$table = 'branch_petty_cash_logs';
$primaryKey = 'id';
$where = "status = '1'";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'transaction_id',   'dt' => 1 ),
	array(
        'db'        => 'branch_id',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {			
			global $mysqli;
			$branch = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$d."'"));
			return $branch['branch_name'];
        }
    ),
	array(
        'db'        => 'amount',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>';
        }
    ),
    array( 'db' => 'given_date',   'dt' => 4 ),
    array( 'db' => 'note',    'dt' => 5 ),
    array(
		'db' => 'uploader_info',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			global $mysqli;			
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE email = '".$u[1]."'"));
					return ''.$emp['full_name'].'';
				}
			}	
		}
	),
    array( 'db' => 'data',   'dt' => 7 )	
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>