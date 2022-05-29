<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'cancel_reminder';
$primaryKey = 'id';
if(isset($_GET['branch_id'])){
	if($_GET['branch_id'] == 1){
		$branch_id = "";
	}else{
		$branch_id = " AND branch_id = '".$_GET['branch_id']."'";
	}	
}else{
	$branch_id = "";
}
if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);	
	$one_ymd = explode('/',$one[0]);
	$two_ymd = explode('/',$one[1]);
	$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
	$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
	$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
}else{
	$date_filter = "";
}
$where = "status = '1' AND type = 'try_us_30_days' $branch_id $date_filter";
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
				$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem_info['full_name'])){
					return $mem_info['full_name'];	
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
				$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem_info['card_number'])){
					return $mem_info['card_number'];	
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
				$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem_info['package_category'])){
					$pcg = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages_category WHERE id = '".$mem_info['package_category']."'"));
					return $pcg['package_category_name'];	
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
				$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem_info['package_name'])){
					return $mem_info['package_name'];	
				}					
			}
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem_info['check_in_date'])){
					return $mem_info['check_in_date'];	
				}					
			}
		}
	),
    array( 'db' => 'auto_checkout',    'dt' => 7 ),	
    array( 'db' => 'message_time',    'dt' => 8 ),	
	array( 'db' => 'data',    'dt' => 9 ),	
	array(
        'db'        => 'id',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
            return '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button onclick="return view_reminder_message('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
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