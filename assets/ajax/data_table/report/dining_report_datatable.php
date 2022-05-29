<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'member_meal';
$primaryKey = 'id';

if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin')){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND";
	}
}else{
	$branch_user = "";
}
if(!empty($_GET['booking_from'])){
	$b_f = explode('-',$_GET['booking_from']);
	$booking_from = $b_f[2].'/'.$b_f[1].'/'.$b_f[0];
}else{
	$booking_from = '';
}

if(!empty($_GET['booking_to'])){
	$b_t = explode('-',$_GET['booking_to']);
	$booking_to = $b_t[2].'/'.$b_t[1].'/'.$b_t[0];
}else{
	$booking_to = '';
}


if($booking_from != '' AND $booking_to != ''){
	$booking = " AND data BETWEEN '".$booking_from."' AND '".$booking_to."' ";
}else{
	if($booking_from != ''){
		$booking = " AND data = '".$booking_from."' ";
	}else if($booking_to != ''){
		$booking = " AND data = '".$booking_to."' ";
	}else{
		$booking = "";
	}
}

if(!empty($_GET['meal_type_filter'])){	
	if($_GET['meal_type_filter'] == 1){
		$meal_type_filter = " AND breakfast = '1' ";
	}else if($_GET['meal_type_filter'] == 2){
		$meal_type_filter = " AND lunch = '1' ";
	}else if($_GET['meal_type_filter'] == 3){
		$meal_type_filter = " AND dinner = '1' ";
	}else{
		$meal_type_filter = "";
	}
}else{
	$meal_type_filter = "";
}

$condition = "".$booking." ".$meal_type_filter."";
$where = "status = '1' ".$condition.""; //
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'branch_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$d."'"));
				if(!empty($branch['branch_name'])){
					return $branch['branch_name'];	
				}					
			}
		}
	),	
	array(
		'db' => 'booking_id',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem['full_name'])){
					return $mem['full_name'];	
				}else{
					return '';
				}				
			}
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem['card_number'])){
					return $mem['card_number'];	
				}else{
					return '';
				}				
			}
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem['package_category'])){
					$packg = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$mem['package_category']."'"));
					return $packg['package_category_name'];	
				}else{
					return '';
				}				
			}
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem['package_name'])){					
					return $mem['package_name'];	
				}else{
					return '';
				}				
			}
		}
	),
	array( 'db' => 'days',   'dt' => 6 ),
	array(
		'db' => 'breakfast',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if(!empty($d) AND $d == '1'){
					return '<button class="btn btn-xs btn-success" type="button">YES</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">NO</button>';
				}
			}
		}
	),
	array(
		'db' => 'lunch',
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d == '1'){
					return '<button class="btn btn-xs btn-success" type="button">YES</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">NO</button>';
				}
			}
		}
	),
	array(
		'db' => 'dinner',
		'dt' => 9,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d == '1'){
					return '<button class="btn btn-xs btn-success" type="button">YES</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">NO</button>';
				}
			}
		}
	),
	array(
		'db' => 'request',
		'dt' => 10,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d == '1'){
					return '<button class="btn btn-xs btn-success" type="button">YES</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">NO</button>';
				}
			}
		}
	),	
	array(
		'db' => 'uploader_info',
		'dt' => 11,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				//$u = explode("___",$d);
				//if(!empty($u[0]) AND !empty($u[1])){
				//	return ''.$u[0].' ('.$u[1].')';
				//}
			}	
		}
	),
	array( 'db' => 'data',    'dt' => 12 ),	
	array(
        'db'        => 'id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
            return '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button onclick="return view________('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
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