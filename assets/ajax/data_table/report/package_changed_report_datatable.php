<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'package_change_info';
$primaryKey = 'id';

if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin')){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."'";
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
$where = "status IN ('1') ".$condition."";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'booking_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return '<img src="'.$home.$mem['photo_avater'].'" style="width:40px;" class="image-responsive"/>';		
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
			return $mem['full_name'];		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem['phone_number'];		
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem['email'];		
		}
	),
	array(
		'db' => 'old_category',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$d."'"));
			if(!empty($bed['package_category_name'])){
				return $bed['package_category_name'];	
			}else{
				return '';	
			}
				
		}
	),
	array(
		'db' => 'old_package',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$d."'"));
			return $bed['package_name'];		
		}
	),
	array(
		'db' => 'new_category',
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$d."'"));
			return $bed['package_category_name'];		
		}
	),
	array(
		'db' => 'new_package',
		'dt' => 9,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$d."'"));
			return $bed['package_name'];		
		}
	),
	array( 'db' => 'changed_date',   'dt' => 10 ),
	array( 'db' => 'data',   'dt' => 11 ),
    array(
		'db' => 'uploader_info',
		'dt' => 12,
		'formatter' => function( $d, $row ) {
			$info = explode('___',$d);
			return $info[1];		
		}
	),
	array(
        'db'        => 'booking_id',
        'dt'        => 13,
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