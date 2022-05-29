<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'member_directory';
$primaryKey = 'id';
if(!empty($_GET['member_type'])){
	$member_type = $_GET['member_type'];
}else{
	$member_type = '';
}
if(!empty($_GET['branch_id'])){	
	if($_GET['branch_id'] == '1'){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND ";
	}
}else{
	$branch_user = "";
}
/*

$booking_id = '';
$condition_check = mysqli_fetch_assoc($mysqli->query("select * from member_directory where $branch_user status = '1'"));
if(!empty($condition_check['id'])){
	$mql = $mysqli->query("select * from member_directory where $branch_user status = '1'");
	while($mow = mysqli_fetch_assoc($mql)){
		$cenc = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where booking_id = '".$mow['booking_id']."'"));
		$check_package = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$mow['package']."'"));
		if(!empty($cenc['booking_id'])){
			$booking_id .= "'".$cenc['booking_id']."',";
		}
		if(!empty($member_type)){
			if($member_type == 'ALL'){			
				
			}elseif($member_type == 'TRYUS'){
				if($check_package['try_us'] == '0'){
					$booking_id .= "'".$mow['booking_id']."',";
				}
			}elseif($member_type == 'MEMBERSHIP'){
				if($check_package['try_us'] == '1'){
					$booking_id .= "'".$mow['booking_id']."',";
				}
			}
		}
	}
	if(!empty($booking_id)){
		$fbooking_id = rtrim($booking_id,',');
	}else{
		$fbooking_id = "'1'";
	}
}else{
	$fbooking_id = "'1'";
}
$where = "$branch_user booking_id NOT IN (".$fbooking_id.") AND status = '1'"; // 	return type == 'export' ? meta.row + 1 : data;
*/
if(!empty($member_type)){
	if($member_type == 'ALL'){			
		$m_type = "";
	}elseif($member_type == 'TRYUS'){
		$m_type = " AND package IN (SELECT id FROM packages WHERE try_us = '1')";
	}elseif($member_type == 'MEMBERSHIP'){
		$m_type = " AND package IN (SELECT id FROM packages WHERE try_us = '0')";
	}
}else{
	$m_type = "";
}
$where = "$branch_user booking_id NOT IN (SELECT booking_id FROM cencel_request WHERE booking_id = member_directory.booking_id ) AND status = '1' $m_type";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 
		'db' => 'photo_avater', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { 
			global $home;
			if(!empty($d)){
				if(url_check($home.$d)){
					return '<a href="'.$home.$d.'" target="_blank" title="Click to view!"><img src="'.$home.$d.'" style="width:35px;height:28px;" class="image-responsive"/></a>';
				}else{
					return '<img src="'.$home.'assets/img/empty-user-xs.png" style="width:35px;height:28px;" class="image-responsive"/>';
				}				
			}else{
				return '<img src="'.$home.'assets/img/empty-user-xs.png" style="width:35px;height:28px;" class="image-responsive"/>';
			}
		}
	),
	array( 
		'db' => 'branch_name', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { 			
			if(!empty($d)){
				return $d;
			}else{
				return '';
			}			
		}
	),
    array( 'db' => 'card_number', 'dt' => 3 ),
    array( 'db' => 'full_name',  'dt' => 4 ),
    array( 'db' => 'phone_number',  'dt' => 5 ),
    array( 
		'db' => 'member_type', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { 			
			if(!empty($d)){
				return $d;
			}else{
				return '';
			}
			
		}
	),	
    array( 'db' => 'bed_name',     'dt' => 7 ),
    array( 'db' => 'check_in_date',     'dt' => 8 ),
    array( 'db' => 'check_out_date',     'dt' => 9 ),
    array( 
		'db' => 'package_category', 
		'dt' => 10,
		'formatter' => function( $d, $row ) { 
			global $mysqli;
			$pc = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$d."'"));
			if(!empty($pc['package_category_name'])){
				return $pc['package_category_name'];
			}else{
				return '';
			}
			
		}
	), 
	array( 'db' => 'package_name',     'dt' => 11 ),
    array( 
		'db' => 'security_deposit', 
		'dt' => 12,
		'formatter' => function( $d, $row ) {			
			return money($d);
		}
	), 
	array( 
		'db' => 'bed_id', 
		'dt' => 13,
		'formatter' => function( $d, $row ) { 
			global $mysqli;
			$pc = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$d."'"));
			if(!empty($pc['uses'])){
				return $pc['uses'];
			}else{
				return '';
			}
			
		}
	),   

	array( 'db' => 'religion',     'dt' => 14 ),
        
    array(
        'db'        => 'id',
        'dt'        => 15,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$cencel_button = '';
			$ccn = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where member_id = '".$d."'"));
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$d."'"));
				
			if(!empty($ccn['member_id']) AND $ccn['member_id'] == $d){
				if(check_permission('role_1606371205_52')){
					$cencel_button .= '<button onclick="return member_final_checkout_modal('.$d.')" type="button" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Finally Check Out"><i class="fas fa-meh-rolling-eyes"></i></button>';


				}if(check_permission('role_1606371205_92')){
					$cencel_button .= '<button onclick="return member_withdraw_modal('.$d.')" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Cencel Withdraw"><i class="fas fa-calendar-check"></i></button>';
				}
			}else{
				if(check_permission('role_1606371205_78')){
					$cencel_button .= '<button onclick="return member_cancel_request_modal('.$d.')" type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Requrest for cancel"><i class="fas fa-user-times"></i></button>';
				}if(check_permission('role_1606371205_95')){
					if(empty($mem['package_category']) AND empty($mem['package'])){
						$cencel_button .= '<button onclick="return member_accepting_shifting_modal('.$d.')" type="button" class="btn btn-xs btn-dark" title="Accept Shifting Member From Other Branch"><i class="fas fa-user-check"></i></button>';
					}else{
						$cencel_button .= '<button onclick="return member_shifting_modal('.$d.')" type="button" class="btn btn-xs btn-info" title="Member Shifting"><i class="fas fa-random"></i></button>';
					}				
				}if(check_permission('role_1606371205_99')){
					$cencel_button .= '<button onclick="return member_card_change_modal('.$d.')" type="button" class="btn btn-xs btn-primary" title="Card Change"><i class="far fa-credit-card"></i></button>';
				}if(check_permission('role_1606371205_20')){
					$cencel_button .= '<button type="submit" name="edit" class="btn btn-xs btn-success" title="Edit Member information"><i class="fas fa-edit"></i></button>';
				}if(check_permission('role_1606371205_23')){
					$cencel_button .= '<button type="submit" name="delete" class="btn btn-xs btn-danger" title="Remove Member from system"><i class="fas fa-trash-alt"></i></button>';
				}
			}
			$data = '<form action="'.$home.'admin/member-directory/edit-delete-member" method="post" class="duallistbox btn-group btn_member_direc" style="width:100%;">
			
				<input type="hidden" name="hidden_id" value="'.$d.'"/>';
			$data .= $cencel_button;
			if(check_permission('role_1606371205_51')){ 
				
				$data .= '<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-warning" title="View member profile"><i class="fa fa-eye"></i></button>';		
			}if(check_permission('role_1630318207_46')){ 
				$data .= '<button onclick="return member_pre_check_print_model('.$d.')" type="button" class="btn btn-xs btn-primary" title="Print Pre-cheque of a many more"><i class="fa fa-print"></i></button>';		
			}
			$vaccinated = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as row_count from member_vaccinated where booking_id = '".$mem['booking_id']."'"));
			if($vaccinated['row_count'] == 0){
				$data .= '<button onclick="give_vaccine_card('.$d.')" type="button" class="btn btn-xs btn-warning" title="Upload Vaccine Card"><i class="fas fa-syringe"></i></button>';		
				
			}
            
			

			$data .= '</form>';
			return $data;
        }
    )
);
 

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>