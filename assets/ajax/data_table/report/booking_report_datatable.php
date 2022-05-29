<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'booking_info';
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

if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);
	if(!empty($one[0]) AND !empty($one[1])){			
		$one_ymd = explode('/',$one[0]);
		$two_ymd = explode('/',$one[1]);
		$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
		$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
		if($_GET['date_type'] == 2){
			$date_filter = " AND STR_TO_DATE(checkin_date,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
		}else if($_GET['date_type'] == 3){
			$date_filter = " AND STR_TO_DATE(checkout_date,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
		}else{
			$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
		}
	}else{
		$date_filter = "";
	}	
}else{
	$date_filter = "";
}
if(!empty($_GET['occupation'])){
	$occupation = " AND booking_id IN (select booking_id from member_directory where occupation = '".$_GET['occupation']."')";
}else{
	$occupation = "";
}

if(!empty($_GET['religion'])){	
	$religion = " AND booking_id IN (select booking_id from member_directory where religion = '".$_GET['religion']."')";
}else{
	$religion = "";
}

if(!empty($_GET['h_t_f_u'])){
	$h_t_f_u = " AND booking_id IN (select booking_id from member_directory where h_t_f_u = '".$_GET['h_t_f_u']."')";
}else{
	$h_t_f_u = "";
}

if(!empty($_GET['package_category'])){
	$package_category = " AND package_category = '".$_GET['package_category']."'";
}else{
	$package_category = "";
}

if(!empty($_GET['package'])){
	$package = " AND package = '".$_GET['package']."'";
}else{
	$package = "";
}

if(!empty($_GET['parking'])){
	if($_GET['parking'] == '1'){
		$parking = " AND booking_id IN (select booking_id from member_directory where parking = '1')";
	}else{
		$parking = " AND booking_id IN (select booking_id from member_directory where parking = '0')";
	}	
}else{
	$parking = "";
}

if(!empty($_GET['authorization'])){
	$authorization = " AND card_no ='".$_GET['authorization']."'";
}else{
	$authorization = "";
}


$condition = "     ".$date_filter." ".$occupation." ".$religion." ".$h_t_f_u." ".$package_category." ".$package." ".$parking." ".$authorization."";
$where = "".$branch_user." status IN ('0','1','3','2','4')  ".$condition."";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),    
    array( 'db' => 'm_name',    'dt' => 1 ),
	array( 'db' => 'card_no',   'dt' => 2 ),
    array( 'db' => 'phone_number',   'dt' => 3 ),
    array(
        'db'        => 'id',
        'dt'        => 4,
        'formatter' => function( $d, $row ) { global $mysqli;
			$occupation = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select mother_name from member_directory where booking_id = '".$occupation['booking_id']."'"));           
			if(!empty($member['mother_name'])){
				return $member['mother_name'];
			}else{
				return '';
			}
			
		}
    ),
    array( 'db' => 'bed_name',    'dt' => 5 ),
    array( 'db' => 'checkin_date',    'dt' => 6 ),
    array( 'db' => 'checkout_date',    'dt' => 7 ),
    array( 'db' => 'package_category_name',     'dt' => 8 ),
    array( 'db' => 'package_name',     'dt' => 9 ),
	array(
		'db' => 'available_days',
		'dt' => 10,
		'formatter' => function( $d, $row ) {
			if($d < 1){
				return '<span style="font-weight:bolder;color:#f00;">'.$d.' Days</span>';
			}else{
				return $d.' Days';
			} 				
		}
	),
    array( 
		'db' => 'security_deposit',
		'dt' => 11 ,
		'formatter' => function( $d, $row ) {			
			if(!empty($d)){
				return money($d);
			}else{
				return $d;
			}
			
		}
	),    
    array( 'db' => 'data', 'dt' => 12 ),    
    array(
        'db'        => 'id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$occupation = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$occupation['booking_id']."'"));           
			if(!empty($member['occupation'])){
				return $member['occupation'];
			}else{
				return '';
			}
			
		}
    ),
	array(
        'db'        => 'id',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$religion = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$religion['booking_id']."'"));           
			if(!empty($member['religion'])){
				return $member['religion'];
			}else{
				return '';
			}			
		}
    ),
	array(
        'db'        => 'id',
        'dt'        => 15,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$htfu = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$htfu['booking_id']."'"));           
			if(!empty($member['h_t_f_u'])){
				return $member['h_t_f_u'];
			}else{
				return '';
			}			
		}
    ),
	array(
        'db'        => 'id',
        'dt'        => 16,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$parking = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$parking['booking_id']."' and parking = '1'"));           
			if(!empty($member['parking']) AND $member['parking'] == '1'){
				return 'YES';
			}else{
				return 'NO';
			}
		}
    ),
	array(
        'db'        => 'uploader_info',
        'dt'        => 17,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$email = explode("___",$d);
			$emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$email[1]."'"));
            if(!empty($emp_info['full_name'])){
				return $emp_info['full_name'];
			}else{
				return 'NULL';
			}
			
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 18,
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