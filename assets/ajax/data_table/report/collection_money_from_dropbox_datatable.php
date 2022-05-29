<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'collection_money_from_dropbox';
$primaryKey = 'id';

if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin') OR $_GET['user_type'] == rahat_encode('Accounts')){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND ";
	}
}else{
	$branch_user = "";
}
$where = "";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'uniq_id', 'dt' => 1 ),
	array( 
		'db' => 'uploader_info', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;			
			$info = $up_inf = explode('___',$d);
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$info[1]."'"));
			return $emp['full_name'].' | <span style="font-weight:bolder;">'.$emp['employee_id'].'</span> | <a href="mailto:'.$emp['email'].'" target="_blank" title="Click to send mail">'.$emp['email'].'</a>';
		}
	),
	array( 'db' => 'data', 'dt' => 3 ),
	array( 'db' => 'branch_name', 'dt' => 4 ),
	array( 'db' => 'note', 'dt' => 5 ),
	array( 
		'db' => 'transaction_ids', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			$cl_amount = 0;
			$ids = explode(",",$d);
			foreach($ids as $iow){
				$dow = mysqli_fetch_assoc($mysqli->query("select *  from drop_box_data where id = '".$iow."'"));
				$cl_amount = $cl_amount + (float)$dow['amount'];				
			}
			return money($cl_amount);
		}
	),
	array( 
		'db' => 'transaction_ids', 
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$idd = "'".rahat_encode($d)."'";
			return '<button onclick="return details_collection_money('.$idd.')" class="btn btn-xs btn-success" type="button">View Details</button>';
		}
	)
);
 

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>