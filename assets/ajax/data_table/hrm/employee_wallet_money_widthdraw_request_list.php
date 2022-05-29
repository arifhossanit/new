<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'employee_wallet_money_widthdraw_request';
$primaryKey = 'id';
$where = "status = '1' and employee_id = '".$_SESSION['super_admin']['employee_ids']."'";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array( 'db' => 'amount', 'dt' => 1 ),
	array( 'db' => 'note', 'dt' => 2 ),
	array( 'db' => 'data', 'dt' => 3 ),
	array(
		'db' => 'id',
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_wallet_money_widthdraw_request where id = '".$d."'"));
			if($info['aproval'] == 1){
				return '<button type="button" class="btn btn-success btn-xs">Aproved</button>';
			}else{
				return '<button type="button" class="btn btn-info btn-xs">Pending...</button>';
			}			
		}
	),
	array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_wallet_money_widthdraw_request where id = '".$d."'"));
			if($info['aproval'] == 1){
				return '----';
			}else{
				$message = "'Are you sure want to Remove this request?'";
				return '
					<form action="'.$home.'admin/profile/award-money-widthdraw" method="post">
						<input type="hidden" name="hidden_id" value="'.$d.'"/>
						----
					</form>
				'; //<button name="remove_request" onclick="return confirm('.$message.')" type="submit" class="btn btn-xs btn-danger" title="Remove Widthdraw Request"><i class="fas fa-trash"></i></button>
			}			
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>