<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'booking_info';
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


if(!empty($_GET['occupation'])){
	$check_ocp = mysqli_fetch_assoc($mysqli->query("select * from member_directory where occupation = '".$_GET['occupation']."'"));
	if(!empty($check_ocp['booking_id'])){
		$opq = $mysqli->query("select * from member_directory where occupation = '".$_GET['occupation']."'");
		$oc_val = '';
		while($ocw = mysqli_fetch_assoc($opq)){
			$oc_val .= "'".$ocw['booking_id']."',";
		}
		$oc_m = rtrim($oc_val,",");
		$occupation = " AND booking_id IN (".$oc_m.")";
	}else{
		$occupation = "";
	}	
}else{
	$occupation = "";
}

if(!empty($_GET['religion'])){
	$check_relg = mysqli_fetch_assoc($mysqli->query("select * from member_directory where religion = '".$_GET['religion']."'"));
	if(!empty($check_relg['booking_id'])){
		$org = $mysqli->query("select * from member_directory where religion = '".$_GET['religion']."'");
		$rg_val = '';
		while($rgw = mysqli_fetch_assoc($org)){
			$rg_val .= "'".$rgw['booking_id']."',";
		}
		$rg_m = rtrim($rg_val,",");
		$religion = " AND booking_id IN (".$rg_m.")";
	}else{
		$religion = "";
	}	
}else{
	$religion = "";
}

if(!empty($_GET['h_t_f_u'])){
	$check_fus = mysqli_fetch_assoc($mysqli->query("select * from member_directory where h_t_f_u = '".$_GET['h_t_f_u']."'"));
	if(!empty($check_fus['booking_id'])){
		$hfs = $mysqli->query("select * from member_directory where h_t_f_u = '".$_GET['h_t_f_u']."'");
		$fs_val = '';
		while($fsw = mysqli_fetch_assoc($hfs)){
			$fs_val .= "'".$fsw['booking_id']."',";
		}
		$fs_m = rtrim($fs_val,",");
		$h_t_f_u = " AND booking_id IN (".$fs_m.")";
	}else{
		$h_t_f_u = "";
	}
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
	$check_parks = mysqli_fetch_assoc($mysqli->query("select * from member_directory where parking = '".$_GET['parking']."'"));
	if(!empty($check_parks['booking_id'])){
		$prks = $mysqli->query("select * from member_directory where parking = '".$_GET['parking']."'");
		$prk_val = '';
		while($prkw = mysqli_fetch_assoc($prks)){
			$prk_val .= "'".$prkw['booking_id']."',";
		}
		$prk_m = rtrim($prk_val,",");
		$parking = " AND booking_id IN (".$prk_m.")";
	}else{
		$parking = "";
	}
}else{
	$parking = "";
}

if(!empty($_GET['authorization'])){
	$authorization = " AND card_no ='".$_GET['authorization']."'";
}else{
	$authorization = "";
}
$checkin = " AND checkin_date = '".date('d/m/Y')."' ";
$condition = "".$checkin." ".$occupation." ".$religion." ".$h_t_f_u." ".$package_category." ".$package." ".$parking." ".$authorization."";
$where = "".$branch_user." status IN ('0','1','3')".$condition."";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'card_no',   'dt' => 1 ),
    array( 'db' => 'm_name',    'dt' => 2 ),
    array( 'db' => 'phone_number',   'dt' => 3 ),
    array( 'db' => 'bed_name',    'dt' => 4 ),
    array( 'db' => 'checkin_date',    'dt' => 5 ),
    array( 'db' => 'checkout_date',    'dt' => 6 ),
    array( 'db' => 'package_category_name',     'dt' => 7 ),
    array( 'db' => 'package_name',     'dt' => 8 ),
	array(
		'db' => 'available_days',
		'dt' => 9,
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
		'dt' => 10 ,
		'formatter' => function( $d, $row ) {			
				if(!empty($d)){
					return money($d);
				}else{
					return $d;
				}
				
			}
		),    
    array( 'db' => 'data', 'dt' => 11 ),    
    array(
        'db'        => 'id',
        'dt'        => 12,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$occupation = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$occupation['booking_id']."'"));           
			return $member['occupation'];
		}
    ),
	array(
        'db'        => 'id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$religion = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$religion['booking_id']."'"));           
			return $member['religion'];
		}
    ),
	array(
        'db'        => 'id',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$htfu = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$htfu['booking_id']."'"));           
			return $member['h_t_f_u'];
		}
    ),
	array(
        'db'        => 'id',
        'dt'        => 15,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$parking = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$parking['booking_id']."'"));           
			if($member['parking'] == '1'){
				return 'YES';
			}else{
				return 'NO';
			}
			
			
		}
    ),
	array(
        'db'        => 'id',
        'dt'        => 16,
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