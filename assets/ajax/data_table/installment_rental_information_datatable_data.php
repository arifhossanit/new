<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }

$table = 'rent_info';
$primaryKey = 'id';
if(!empty($_GET['branch_id'])){
	if($_GET['branch_id'] == '1'){
		$branch_user = "";
	}else{
		$row_b = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".rahat_decode($_GET['branch_id'])."'"));
		if(!empty($row_b['branch_id'])){
			$branch_user = " AND branch_id = '".$row_b['branch_id']."'";
		}else{
			$branch_user = "";
		}
	}
}else{
	$branch_user = "";
}
$booking_id = '';
$member_query = $mysqli->query("SELECT * FROM member_directory WHERE status = '3'");
while($member_row = mysqli_fetch_assoc($member_query)){
	if(!empty($member_row['booking_id'])){
		$booking_id .= "'".$member_row['booking_id']."',";
	}	
}
$booking_idi = '';
if(!empty($_GET['month_filter'])){	
	if($_GET['month_filter'] == '[object HTMLInputElement]'){
		$month_name = month_name(date('m'));
		$month_filteri = " AND month_name = '".$month_name."' AND data LIKE '%".date('Y')."'";
		$month_filter = "";
	}else{
		$moexp = explode('-',$_GET['month_filter']);
		$month_name = month_name($moexp[1]);
		$month_filteri = " AND month_name = '".$month_name."' AND data LIKE '%".$moexp[0]."'";
		$month_filter = " AND month_name = '".$month_name."' AND data LIKE '%".$moexp[0]."'";
	}	
}else{
	$month_filteri = "";
	$month_filter = "";
}
$member_queryc = $mysqli->query("SELECT * FROM member_directory WHERE status = '1'");
while($member_rowi = mysqli_fetch_assoc($member_queryc)){
	$rent_count = mysqli_fetch_assoc($mysqli->query("SELECT * FROM rent_info WHERE rent_status = 'Paid' AND payment_pattern = '1' AND booking_id = '".$member_rowi['booking_id']."' $month_filteri")); //id != (SELECT MAX(id) FROM rent_info)
	if(!empty($rent_count['booking_id'])){
		$booking_idi .= "'".$rent_count['booking_id']."',";
	}	
}

$s_booking_id = rtrim($booking_id,',');
$s_booking_idi = rtrim($booking_idi,',');
$where = "rent_status = 'Paid' AND payment_pattern = '0' AND booking_id NOT IN ($s_booking_id) AND booking_id NOT IN ($s_booking_idi) ".$branch_user." $month_filter ";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'branch_name', 'dt' => 1 ),
    array( 'db' => 'package_category_name', 'dt' => 2 ),
    array( 'db' => 'package_name',  'dt' => 3 ),
    array( 'db' => 'card_no',  'dt' => 4 ),
    array( 'db' => 'm_name',     'dt' => 5 ),
    array(
		'db' => 'rent_amount',
		'dt' => 6,
		'formatter' => function( $d, $row ) {			
			return money($d);
		}
	),
	array(
		'db' => 'parking',
		'dt' => 7,
		'formatter' => function( $d, $row ) {			
			if(!empty($d) AND $d != 0){
				return money($d);
			}else{
				return money(0);
			}
			
		}
	),
	array(
		'db' => 'electricity',
		'dt' => 8,
		'formatter' => function( $d, $row ) {			
			if(!empty($d) AND $d != 0){
				return money($d);
			}else{
				return money(0);
			}
		}
	),	
	array(
		'db' => 'penalty',
		'dt' => 9,
		'formatter' => function( $d, $row ) {			
			if(!empty($d) AND $d != 0){
				return money($d);
			}else{
				return money(0);
			}
		}
	),
	array(
		'db' => 'tea_coffee',
		'dt' => 10,
		'formatter' => function( $d, $row ) {			
			if(!empty($d) AND $d != 0){
				return money($d);
			}else{
				return money(0);
			}
		}
	),
	array(
		'db' => 'payment_pattern',
		'dt' => 11,
		'formatter' => function( $d, $row ) {			
			if($d == '1'){
				return 'Full/Rest of Payment';
			}else if($d == '2'){
				return 'Due Payment';
			}else if($d == '3'){
				return 'Pendamic';
			}else if($d == '0'){
				return 'Half Payment';
			}				
		}
	),
	array(
		'db' => 'recharge_days',
		'dt' => 12,
		'formatter' => function( $d, $row ) {			
			return $d.' Days';
		}
	),
	array(
		'db' => 'month_name',
		'dt' => 13,
		'formatter' => function( $d, $row ) {			
			return $d;
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 14,
		'formatter' => function( $d, $row ) {	
			global $mysqli;
			$rent = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$d."' order by id desc"));
			if($rent['rent_status'] == 'Paid'){
				return ' <button type="button" class="btn btn-xs btn-success" >'.$rent['rent_status'].'</button> ';
			}else{
				$ccard_no = "'".$rent['card_no']."'";
				return ' <button onclick="return due_rent_collection('.$ccard_no.')" type="button" class="btn btn-xs btn-danger">'.$rent['rent_status'].'</button> ';
			}				
		}
	),    
    array(
        'db'        => 'id',
        'dt'        => 15,
        'formatter' => function( $d, $row ) {
			global $home;
            $data =  '
				<form action="#" method="post">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>';					
			if(check_permission('role_1606371387_26')){
				$data .= '<button onclick="return view_rental_recipt('.$d.')" type="button" class="btn btn-xs btn-warning" style="margin-right:3px;"><i class="fa fa-eye"></i></button>';
			} if(check_permission('role_1606371388_15')){
				$data .= '<button type="submit" name="edit" class="btn btn-xs btn-success" style="margin-right:3px;"><i class="fas fa-edit"></i></button>';
			} if(check_permission('role_1606371388_50')){
				$data .= '<button type="submit" name="delete" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>';
			}
			$data .= '</form>';
			return $data;
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>