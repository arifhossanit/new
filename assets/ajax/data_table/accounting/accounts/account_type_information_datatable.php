<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'account_type';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 
		'db' => 'id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'code', 
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'branch_id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$d."'"));
			return $info['branch_name'];
		}
	),
	array( 
		'db' => 'name', 
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'balance', 
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			return money($d);
		}
	),
	array( 
		'db' => 'uploader_info', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 
		'db' => 'data', 
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'status', 
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Active!</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-danger">Deactive!</button>';
			}			
		}
	),

    array( 
		'db' => 'id', 
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $home;	
			$conf_message = "'Are you Sure Want To dalete Data?'";
			return '
				<form action="'.$home.'admin/accounting/accounts/manage-accounts" method="POST">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button name="edit_data" type="submit" class="btn btn-success btn-xs">Edit</button>
					<button name="delete_data" type="submit" class="btn btn-danger btn-xs" onclick="return confirm('.$conf_message.')">Delete</button>
				</form>
			';			
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>