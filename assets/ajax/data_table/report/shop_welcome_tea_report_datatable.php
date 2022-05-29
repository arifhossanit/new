<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'welcome_tea_logs';
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

$where = "status = '1' $branch_id $date_filter"; //
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
					return 'Null!';
				}				
			}
		}
	),
	array(
		'db' => 'phone_number',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				return '<span style="color:#a50000;font-weight:bolder;">'.$d.'</span>';
			}
		}
	),
	array( 'db' => 'item_name', 'dt' => 4 ),
	array(
		'db' => 'uploader_info',
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$u[1]."'"));
					return $emp['full_name'].' | '.$emp['employee_id'];
				}
			}	
		}
	),
	array( 'db' => 'data',    'dt' => 6 )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>