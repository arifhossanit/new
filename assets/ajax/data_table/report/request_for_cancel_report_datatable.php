<?php 
error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'cencel_request';
$primaryKey = 'id';


$branch_user = "";
if(!empty($_GET['branch_id'])){
	if($_GET['branch_id'] != '1'){
		$branch_user = "AND branch_id = '".rahat_decode($_GET['branch_id'])."'";
	}
}
// if(!empty($_GET['booking_from'])){
// 	$b_f = explode('-',$_GET['booking_from']);
// 	$booking_from = $b_f[2].'/'.$b_f[1].'/'.$b_f[0];
// }else{
// 	$booking_from = '';
// }

// if(!empty($_GET['booking_to'])){
// 	$b_t = explode('-',$_GET['booking_to']);
// 	$booking_to = $b_t[2].'/'.$b_t[1].'/'.$b_t[0];
// }else{
// 	$booking_to = '';
// }

// if($booking_from != '' AND $booking_to != ''){
// 	$booking = " AND data BETWEEN '".$booking_from."' AND '".$booking_to."' ";
// }else{
// 	if($booking_from != ''){
// 		$booking = " AND data = '".$booking_from."' ";
// 	}else if($booking_to != ''){
// 		$booking = " AND data = '".$booking_to."' ";
// 	}else{
// 		$booking = "";
// 	}
// }
$booking = "";
if(isset($_GET['date_range'])){
	$date_range = explode(' - ', $_GET['date_range']);
	$date_from = DateTime::createFromFormat('d/m/Y', $date_range[0]);
	$date_to = DateTime::createFromFormat('d/m/Y', $date_range[1]);
	$booking = " AND STR_TO_DATE(data, '%d/%m/%Y') BETWEEN '".$date_from->format('Y-m-d')."' AND '".$date_to->format('Y-m-d')."' ";
}
$where = "status IN ('1') $branch_user $booking";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'booking_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return '<img src="'.$home.$mem['photo_avater'].'" style="width:40px;height:40px;" class="image-responsive"/>';		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem['card_number'];		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem['branch_name'];		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem['full_name'];		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem['phone_number'];		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem['email'];		
		}
	),
	array(
		'db' => 'bed_id',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$d."'"));
			return $bed['bed_name'];		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			$pc = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$mem['package_category']."'")); 
			return $pc['package_category_name'];		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 9,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			$pc = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$mem['package']."'")); 
			return $pc['package_category_name'];			
		}
	),
	array(
		'db' => 'checkoutdate',
		'dt' => 10,
		'formatter' => function( $d, $row ) {
			$cfr_d = explode("-",$d);
			if(!empty($d)){
				return $cfr_d[2].'/'.$cfr_d[1].'/'.$cfr_d[0];	
			}else{
				return '';	
			}
				
		}
	),
	array( 'db' => 'data',   'dt' => 11 ),
	array(
		'db' => 'note',
		'dt' => 12,
		'formatter' => function( $d, $row ) {
			return '<marquee>'.$d.'</marquee>';	
		
		}
	),
    array(
		'db' => 'uploader_info',
		'dt' => 13,
		'formatter' => function( $d, $row ) {
			$info = explode('___',$d);
			if(!empty($info[1])){
				return $info[1];		
			}else{
				return '';		
			}			
		}
	),
	array(
        'db'        => 'booking_id',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
            return '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$mem['id'].'"/>
					<button onclick="return view_member_profile('.$mem['id'].')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
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