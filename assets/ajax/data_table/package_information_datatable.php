<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'packages';
$primaryKey = 'id';
if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin')){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND ";
	}
}else{
	$branch_user = "";
}
$where = "".$branch_user."";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array(
		'db' => 'id',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			global $home;
			$cnf_mes = "'are you sure?'";
			return '
				<form action="'.$home.'admin/manage-package" method="post">
					<input type="hidden" value="'.$d.'" name="hidden_id"/>
					<button name="edit" type="submit" class="btn btn-xs btn-success"><i class="far fa-edit"></i></button>
					<button name="delete" type="submit" onclick="return confirm('.$cnf_mes.')" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
				</form>
			';					
		}
	),
	array(
		'db' => 'status',
		'dt' => 2,
		'formatter' => function( $d, $row ){
			if($d == '1'){
				return '<button class="btn btn-xs btn-success">Active</button>';
			}else{
				return '<button class="btn btn-xs btn-danger">Deactive</button>';
			}
		}
	),
	array(
		'db' => 'try_us',
		'dt' => 3,
		'formatter' => function( $d, $row ){
			if($d == '1'){
				return '<button class="btn btn-xs btn-success">YES</button>';
			}else{
				return '<button class="btn btn-xs btn-danger">NO</button>';
			}
		}
	),
	array(
		'db' => 'aggreement',
		'dt' => 4,
		'formatter' => function( $d, $row ){
			if($d == '1'){
				return '<button class="btn btn-xs btn-warning">YES</button>';
			}else{
				return '<button class="btn btn-xs btn-danger">NO</button>';
			}
		}
	),
	array(
		'db' => 'installment',
		'dt' => 5,
		'formatter' => function( $d, $row ){
			if($d == '1'){
				return '<button class="btn btn-xs btn-success">Yes</button>';
			}else{
				return '<button class="btn btn-xs btn-danger">No</button>';
			}
		}
	),
	array(
		'db' => 'monthly_package',
		'dt' => 6,
		'formatter' => function( $d, $row ){
			if($d == '1'){
				return '<button class="btn btn-xs btn-success">Yes</button>';
			}else{
				return '<button class="btn btn-xs btn-danger">No</button>';
			}
		}
	),
    array( 'db' => 'branch_name',   'dt' => 7 ),
    array( 'db' => 'package_category_name',    'dt' => 8 ),
    array( 'db' => 'package_name',   'dt' => 9 ),
	array(
		'db' => 'package_price',
		'dt' => 10,
		'formatter' => function( $d, $row ){			
			return money($d);
		}
	),
	array(
		'db' => 'monthly_rent',
		'dt' => 11,
		'formatter' => function( $d, $row ){			
			return money($d);
		}
	),
	array(
		'db' => 'parking_amount',
		'dt' => 12,
		'formatter' => function( $d, $row ){			
			return money($d);
		}
	),
	array(
		'db' => 'card_change_amount',
		'dt' => 13,
		'formatter' => function( $d, $row ){			
			return money($d);
		}
	),
	array(
		'db' => 'discount_amount',
		'dt' => 14,
		'formatter' => function( $d, $row ){			
			if(!empty($d)){
				return money($d);
			}else{
				return '--';
			}			
		}
	),
	array(
		'db' => 'group_discount_amount',
		'dt' => 15,
		'formatter' => function( $d, $row ){			
			if(!empty($d)){
				return money($d);
			}else{
				return '--';
			}			
		}
	),
	array(
		'db' => 'panalty_amount',
		'dt' => 16,
		'formatter' => function( $d, $row ){			
			if(!empty($d)){
				return money($d);
			}else{
				return '--';
			}			
		}
	),
	array(
		'db' => 'package_days',
		'dt' => 17,
		'formatter' => function( $d, $row ){			
			return $d.' Days';
		}
	),
	array(
		'db' => 'auto_cancel_days_half',
		'dt' => 18,
		'formatter' => function( $d, $row ){			
			return $d.' Days';
		}
	),
	array(
		'db' => 'auto_cancel_days_full',
		'dt' => 19,
		'formatter' => function( $d, $row ){			
			return $d.' Days';
		}
	),
	array(
		'db' => 'auto_cancel_days_checkin_date',
		'dt' => 20,
		'formatter' => function( $d, $row ){			
			return $d.' Days';
		}
	),
	array(
		'db' => 'panalty_start_days_half_payment',
		'dt' => 21,
		'formatter' => function( $d, $row ){			
			return $d.' Days';
		}
	),
	array(
		'db' => 'panalty_start_days_full_payment',
		'dt' => 22,
		'formatter' => function( $d, $row ){			
			return $d.' Days';
		}
	),
	array(
		'db' => 'panalty_start_days_checkin_date',
		'dt' => 23,
		'formatter' => function( $d, $row ){			
			return $d.' Days';
		}
	),	
	array(
		'db' => 'data',
		'dt' => 24,
		'formatter' => function( $d, $row ){			
			return $d.' Days';
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>