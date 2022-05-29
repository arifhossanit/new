<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'rent_info';
$primaryKey = 'id';
if(!empty($_GET['branch_id'])){	
	if($_GET['branch_id'] == '1'){
		$branch_user = "";
	}else{
		$row_b = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".rahat_decode($_GET['branch_id'])."'"));
		if(!empty($row_b['branch_id'])){
			$branch_user = "branch_id = '".$row_b['branch_id']."' AND ";
		}else{
			$branch_user = "";
		}
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
$where = "".$branch_user." status = 1 ".$booking.""; //
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'card_no',   'dt' => 1 ),
    array( 'db' => 'm_name',    'dt' => 2 ),	
    array(
		'db' => 'id',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$rent = mysqli_fetch_assoc($mysqli->query("select * from rent_info where id = '".$d."'"));
			$phn_number = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$rent['booking_id']."'"));
			if(!empty($phn_number['phone_number'])){
				return $phn_number['phone_number'];	
			}else{
				return '----';	
			}	
		}
	),
	array(
		'db' => 'id',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$rent = mysqli_fetch_assoc($mysqli->query("select * from rent_info where id = '".$d."'"));
			$bed_name = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$rent['booking_id']."'"));
			if(!empty($bed_name['bed_name'])){
				return $bed_name['bed_name'];
			}else{
				return '----';
			}
					
		}
	),
    array( 'db' => 'package_category_name',     'dt' => 5 ),
    array( 'db' => 'package_name',     'dt' => 6 ),
	array(
		'db' => 'recharge_days',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			if($d < 1){
				return '<span style="font-weight:bolder;color:#f00;">'.$d.' Days</span>';
			}else{
				return $d.' Days';
			} 				
		}
	),
    array( 
		'db' => 'payment_method',
		'dt' => 8 ,
		'formatter' => function( $d, $row ) {			
			return rtrim($d,',');				
		}
	),    
    array(
        'db'        => 'rent_amount',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {			        
			return money($d);
		}
    ),
	array(
        'db'        => 'parking',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {			        
			return money($d);
		}
    ),
	array(
        'db'        => 'electricity',
        'dt'        => 11,
        'formatter' => function( $d, $row ) {			        
			return money($d);
		}
    ),
	array(
        'db'        => 'tea_coffee',
        'dt'        => 12,
        'formatter' => function( $d, $row ) {			        
			return money($d);
		}
    ),
	array(
        'db'        => 'penalty',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {			        
			return money($d);
		}
    ),
	array(
        'db'        => 'total_amount',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {			        
			return money($d);
		}
    ),	
	array(
        'db'        => 'rent_status',
        'dt'        => 15,
        'formatter' => function( $d, $row ) {
			if($d == 'Paid'){
				$btc = 'btn-success';
			}else{
				$btc = 'btn-danger';
			}
			return  '<button type="button" class="btn btn-xs '.$btc.'">'.$d.'</button>';			
		}
    ),
	array(
        'db'        => 'uploader_info',
        'dt'        => 16,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$email = explode("___",$d);			
			if ( ! isset($email[1])) {
				$email[1] = null;
			}
			return $email[1];		
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 17,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
            return '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button onclick="return view_profile_from_booking('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
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