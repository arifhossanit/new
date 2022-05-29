	<?php 
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
$where = "$branch_user booking_id IN (SELECT booking_id FROM cencel_request WHERE cencel_request.booking_id = member_directory.booking_id AND note NOT IN ('Request For Cancel for rental payment issue (auto cancel from software)')) and status = '1' $m_type"; // 	return type == 'export' ? meta.row + 1 : data;
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 
		'db' => 'photo_avater', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { 
			global $home;
			if(!empty($d)){
				if(url_check($home.$d)){
					return '<img src="'.$home.$d.'" style="width:35px;" class="image-responsive"/>';
				}else{
					return '<img src="'.$home.'assets/img/empty-user-xs.png" style="width:35px;" class="image-responsive"/>';
				}				
			}else{
				return '<img src="'.$home.'assets/img/empty-user-xs.png" style="width:35px;" class="image-responsive"/>';
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
        'db'        => 'id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$cencel_button = '';
			$ccn = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where member_id = '".$d."'"));
			if(!empty($ccn['member_id']) AND $ccn['member_id'] == $d){
				if(check_permission('role_1606371205_52')){
					$cencel_button .= '<button onclick="return member_final_checkout_modal('.$d.')" type="button" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Finally Check Out"><i class="fas fa-meh-rolling-eyes"></i></button>';
				}if(check_permission('role_1626151594_38')){
					$cencel_button .= '<button onclick="return member_withdraw_modal('.$d.')" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Cencel Withdraw"><i class="fas fa-calendar-check"></i></button>';
				}
				if(check_permission('role_1606371205_99')){
					$cencel_button .= '<button onclick="return member_card_change_modal('.$d.')" type="button" class="btn btn-xs btn-primary" title="Card Change"><i class="far fa-credit-card"></i></button>';
				}
			}		

			$data = '
				<form action="'.$home.'admin/member-directory/edit-delete-member" method="post" class="duallistbox btn-group btn_member_direc" style="width:100%;">
				<input type="hidden" name="hidden_id" value="'.$d.'"/>
			';
			$data .= $cencel_button;
			if(check_permission('role_1606371205_51')){ 
				$data .= '<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-warning" title="View member profile"><i class="fa fa-eye"></i></button>';		
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