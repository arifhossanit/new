<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'return_diposit_money';
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

$where = "".$branch_user." status IN ('1') AND note = 'Auto Refunded for Force Cancel Issue (Money Refunded for force cancel)'";
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
		'db' => 'booking_id',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			$bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$mem['bed_id']."'"));
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
		'db' => 'booking_id',
		'dt' => 10,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem['check_out_date'];	
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
				return 'Software';		
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