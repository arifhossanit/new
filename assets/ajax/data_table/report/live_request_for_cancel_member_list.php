<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'beds';
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

$condition = "".$booking." ";
$where = "".$branch_user." uses = '4' AND status IN ('1') ".$condition."";
$columns = array(
    array(
		'db' => 'id',
		'dt' => 0,
		'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $d.'-'.$mem['id'];		
		}
	),
    array(
		'db' => 'id',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			if(!empty($mem['photo_avater'])){
				if(url_check($home.$mem['photo_avater'])){
					return '<img src="'.$home.$mem['photo_avater'].'" style="width:40px;" class="image-responsive"/>';
				}else{
					return '<img src="'.$home.'assets/img/empty-user-xs.png" style="width:40px;" class="image-responsive"/>';
				}				
			}else{
				return '<img src="'.$home.'assets/img/empty-user-xs.png" style="width:40px;" class="image-responsive"/>';
			}				
		}
	),
	array(
		'db' => 'id',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $mem['card_number'];		
		}
	),
	array(
		'db' => 'id',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $mem['branch_name'];		
		}
	),
	array(
		'db' => 'id',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $mem['full_name'];		
		}
	),
	array(
		'db' => 'id',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $mem['phone_number'];		
		}
	),
	array(
		'db' => 'id',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $mem['email'];		
		}
	),
	array(
		'db' => 'id',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$d."'"));
			return $bed['bed_name'];		
		}
	),
	array(
		'db' => 'id',
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			$pc = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$mem['package_category']."'")); 
			return $pc['package_category_name'];		
		}
	),
	array(
		'db' => 'id',
		'dt' => 9,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			$pc = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$mem['package']."'")); 
			return $pc['package_name'];			
		}
	),
	array(
		'db' => 'id',
		'dt' => 10,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $mem['check_in_date'];			
		}
	),
	array(
		'db' => 'id',
		'dt' => 11,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $mem['check_out_date'];			
		}
	),
	array(
		'db' => 'id',
		'dt' => 12,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			return $mem['note'];			
		}
	),
	array(
		'db' => 'id',
		'dt' => 13,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			$cancel_info = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where booking_id = '".$mem['booking_id']."'"));
			$info = explode('___',$cancel_info['uploader_info']);
			if(!empty($info[1])){
				return $info[1];		
			}else{
				return '';		
			}				
		}
	),
	array(
        'db'        => 'id',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$cencel_button = '';
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where bed_id = '".$d."'"));
			$ccn = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where member_id = '".$mem['id']."'"));
            
			$cencel_button .= '<form action="#" method="post" class="navbar-form">			
				<input type="hidden" name="hidden_id" value="'.$mem['id'].'"/>';
			if(!empty($ccn['member_id']) AND $ccn['member_id'] == $mem['id']){
				if(check_permission('role_1606371205_52')){
					$cencel_button .= '<button onclick="return member_final_checkout_modal('.$mem['id'].')" type="button" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Finally Check Out"><i class="fas fa-meh-rolling-eyes"></i></button>';
				}if(check_permission('role_1606371205_92')){
					$cencel_button .= '<button onclick="return member_withdraw_modal('.$mem['id'].')" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Cencel Withdraw"><i class="fas fa-user-check"></i></button>';
				}
			}
				$cencel_button .= '<button onclick="return view_member_profile('.$mem['id'].')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
			</form>';
			
			return $cencel_button;
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>