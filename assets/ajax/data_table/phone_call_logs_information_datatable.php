<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'booking_enquery';
$primaryKey = 'id';
$branch = '';
if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
	$branch = '';
}else if($_SESSION['super_admin']['branch'] != 'BAR_011220_210463187872898170_1606780607' ){
	$branch = " AND branch_id = '".$_SESSION['super_admin']["branch"]."'";
}
$where = "n_date != ''".$branch;
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array(
		'db' => 'id',
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from booking_enquery where id = '".$d."'"));
			if($info['uploader_info'] == 'Self from priority_form'){
				$bran = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$info['branch_id']."'"));
				return $bran['branch_name'];
			}else{
				$id = explode("___",$info['uploader_info']);
				$info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$id[2]."'"));
				return $info['branch_name'];
			}
			
		}
	),
    array( 'db' => 'name',   'dt' => 2 ),
    array(
		'db' => 'phone',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			return '<a href="tel:'.$d.'">'.$d.'</a>';
		}
	),
	array(
		'db' => 'description',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
    array( 'db' => 'n_date',   'dt' => 5 ),	
    array( 'db' => 'data',   'dt' => 6 ),	
	array(
		'db' => 'uploader_info',
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$follow_up = mysqli_fetch_assoc($mysqli->query("SELECT uploader_info from followup_from_visitor_logs where enquiry_id = '".$row[0]."' ORDER BY id ASC LIMIT 1"));
			if(is_null($follow_up)){
				if($d == 'Self from priority_form'){
					return 'Self';
				}else{
					$uplaoder = explode('___', $d);
					$uploader_name = mysqli_fetch_assoc($mysqli->query("SELECT full_name from employee where email = '".$uplaoder[1]."'"));
				}
			}else{
				$uplaoder = explode('___', $follow_up['uploader_info']);
				$uploader_name = mysqli_fetch_assoc($mysqli->query("SELECT full_name from employee where email = '".$uplaoder[1]."'"));
				return $uploader_name['full_name'];
			}			
		}
	),
	array(
		'db' => 'id',
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from booking_enquery where id = '".$d."'"));			
			$follow_date = "'".$info['n_date']."'";
			$check_booking = mysqli_fetch_assoc($mysqli->query("select * from booking_info where phone_number = '".$info['phone']."'"));
			if(!empty($check_booking['id'])){
				return '<b style="color:#f00;">Booked!</b>';
			}else{
				//	<button type="button" class="btn btn-xs btn-info" onclick="return add_information('.$d.','.$follow_date.')">Add Info</button>
				return '
					<button type="button" class="btn btn-xs btn-warning" onclick="return view_information('.$d.')">View / Add Info</button>
				';
			}
		}
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>