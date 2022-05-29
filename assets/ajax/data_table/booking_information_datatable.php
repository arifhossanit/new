<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

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
$where = "".$branch_user." status IN (0,1)";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'branch_name',   'dt' => 1 ),
    array( 'db' => 'card_no',   'dt' => 2 ),
    array( 'db' => 'm_name',    'dt' => 3 ),
	array( 
		'db' => 'booking_id',
		'dt' => 4 ,
		'formatter' => function( $d, $row ) { global $mysqli;		
			$info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			if(!empty($info['id_card'])){
				return $info['id_card'];
			}else{
				return '--';
			}
			
		}
	),    
    array( 'db' => 'phone_number',   'dt' => 5 ),
    array( 'db' => 'bed_name',    'dt' => 6 ),
    array( 'db' => 'checkin_date',    'dt' => 7 ),
    array( 'db' => 'checkout_date',    'dt' => 8 ),
    array( 'db' => 'package_category_name',     'dt' => 9 ),
    array( 'db' => 'package_name',     'dt' => 10 ),
	array(
		'db' => 'available_days',
		'dt' => 11,
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
		'dt' => 12 ,
		'formatter' => function( $d, $row ) {			
			if(!empty($d)){
				return money($d);
			}else{
				return $d;
			}
			
		}
	),    
    array( 'db' => 'data', 'dt' => 13 ),
	/* array(
        'db'        => 'booking_id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $mem_info['id_card'];
        }
    ),   */
    array(
        'db'        => 'id',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {
			global $mysqli;		
			$status = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$status['booking_id']."' and member_type = 'GROUP'"));
			if(!empty($mem['booking_id'])){
				$sel_grup = mysqli_fetch_assoc($mysqli->query("select * from group_member_directory where booking_id = '".$mem['booking_id']."'"));
				if(!empty($sel_grup['group_id'])){
					$group_button = '<button type="button" class="btn btn-xs btn-success">G</button>';
				}else{
					$group_button = '<button type="button" class="btn btn-xs btn-danger">G</button>';
				}
				
			}else{
				$group_button = '';
			}	
			$network = mysqli_fetch_assoc($mysqli->query("select * from member_network_manage where booking_id = '".$status['booking_id']."'"));
			$net_booking_id = "'".$status['booking_id']."'";
			if(!empty($network['booking_id'])){
				$net_button = '<button onclick="return network_active_deactive_from_booking('.$net_booking_id.')" type="button" class="btn btn-xs btn-success">Net Activated</button>';
			}else{
				$net_button = '<button onclick="return network_active_deactive_from_booking('.$net_booking_id.')" type="button" class="btn btn-xs btn-danger">Net Deactivated</button>';
			}
			if($status['status'] == '1'){
				$data = '
					<form action="#" method="post">
						<button type="button" class="btn btn-xs btn-success">Stay</button>
						'.$group_button.'
						'.$net_button.'
					</form>
				';
			}else if($status['status'] == '2'){
				$data = '
					<form action="#" method="post">
						<button type="button" class="btn btn-xs btn-warning">CheckOut</button>
						'.$group_button.'
						'.$net_button.'
					</form>
				';
			}else{
				$data = '
					<form action="#" method="post">
						<input type="hidden" name="hidden_id" value="'.$d.'"/>
						<button type="button" name="rebook" class="btn btn-xs btn-danger">
							<marquee style="width:60px;    width: 50px; height: 9px; line-height: 9px;">
								Request For Cancel
							</marquee>
						</button>
						'.$group_button.'
						'.$net_button.'
					</form>
				';
			}
			return $data;
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 15,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$Authorizes = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			if($Authorizes['card_no'] == 'Unauthorized'){
				$function_key = "'".$Authorizes['id']."','".$Authorizes['checkin_date']."','".$Authorizes['m_name']."','".$Authorizes['package_category_name']."','".$Authorizes['package_name']."','".$Authorizes['branch_name']."'";
				$function_key2 = "'".$Authorizes['id']."','".$Authorizes['security_deposit']."','".$Authorizes['m_name']."','".$Authorizes['package_category_name']."','".$Authorizes['package_name']."','".$Authorizes['branch_name']."'";
				$auth_btn = '<button type="button" onclick="return authorized_finction('.$d.')" class="btn btn-xs btn-warning" style="margin-left: 2px;">CheckIn</button>';
				
				if(check_permission('role_1615107816_44')){				
					$auth_btn .= '<button type="button" onclick="return check_in_date_management('.$function_key.')" class="btn btn-xs btn-dark" title="CheckIn Date Management" style="margin-left: 2px;"><i class="fas fa-calendar-alt"></i></button>';
				}
				
				if(check_permission('role_1614329458_64')){
					$auth_btn .= '<button type="button" onclick="return return_money_managementp('.$function_key2.')" class="btn btn-xs btn-primary" title="Return Money Management" style="margin-left: 2px;font-size: 25px;line-height: 17px;">৳</button>';
				}
			}else{
				$auth_btn = '';
			}
			if($Authorizes['status'] != '2'){
				$edit_button = '<button type="button" name="edit" class="btn btn-xs btn-success"><i class="fas fa-edit"></i></button>';
			}else{
				$edit_button = '';
			}
            $data = '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>';
				if(check_permission('role_1606370617_61')){
					$data .= '<button onclick="return view_profile_from_booking('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>';
				}if(check_permission('role_1606370618_62')){
					$data .= $auth_btn;
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