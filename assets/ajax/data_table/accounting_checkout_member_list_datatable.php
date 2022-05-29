<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
$table = 'member_directory';
$primaryKey = 'id';


if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin') OR $_GET['user_type'] == rahat_encode('Accounts')){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND ";
	}
}else{
	$branch_user = "";
}


$where = "".$branch_user." status = '3' AND note = ''";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 
		'db' => 'photo_avater', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $home;			
				return '<img src="'.$home.$d.'" style="width:30px;"/>';
			}
	),
	array( 'db' => 'branch_name', 'dt' => 2 ),
    array( 'db' => 'card_number', 'dt' => 3 ),
    array( 'db' => 'full_name',  'dt' => 4 ),
    array( 'db' => 'phone_number',  'dt' => 5 ),
    array( 'db' => 'email',     'dt' => 6 ),
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
			$ccn = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where member_id = '".$d."'"));
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$d."'"));
			$chk = mysqli_fetch_assoc($mysqli->query("select * from withdraw_checkout where booking_id = '".$mem['booking_id']."'"));
			$pkg = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$mem['package']."'"));
			$confirm_ccheck = mysqli_fetch_assoc($mysqli->query("select * from checkout_confirmation where booking_id = '".$mem['booking_id']."'"));
			if(!empty($ccn['member_id']) AND $ccn['member_id'] == $d){
				$cencel_button = '
					<button onclick="return member_final_checkout_modal('.$d.')" type="button" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Finally Check Out"><i class="fas fa-meh-rolling-eyes"></i></button>
					<button onclick="return member_withdraw_modal('.$d.')" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Cencel Withdraw"><i class="fas fa-user-check"></i></button>
				';
			}else{
				$cencel_button = '
					<button onclick="return member_cancel_request_modal('.$d.')" type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Requrest for cancel"><i class="fas fa-user-times"></i></button>
					<button onclick="return member_shifting_modal('.$d.')" type="button" class="btn btn-xs btn-info" title="Member Shifting"><i class="fas fa-random"></i></button>
					<button onclick="return member_card_change_modal('.$d.')" type="button" class="btn btn-xs btn-primary" title="Card Change"><i class="far fa-credit-card"></i></button>
					<button type="submit" name="edit" class="btn btn-xs btn-success" title="Edit Member information"><i class="fas fa-edit"></i></button>
					<button type="submit" name="delete" class="btn btn-xs btn-danger" title="Remove Member from system"><i class="fas fa-trash-alt"></i></button>
				';
			}
            $data = '
				<form action="#" method="post" class="duallistbox">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>';
			//if(check_permission('role_1603977545_42')){
			if(!empty($confirm_ccheck['id']) AND $confirm_ccheck['status'] == '1'){
				$data .= '<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-success" title="Return Diposit Money"><i class="fas fa-money-check-alt"></i>&nbsp;&nbsp;&nbsp;Return Diposit Money</button>';
				if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
					if($mem['security_deposit'] > 0 AND $pkg['try_us'] == 0){
						$data .= '<button onclick="return re_check_member('.$d.')" type="button" class="btn btn-xs btn-warning" title="Re-Check Member"><i class="fas fa-user-check"></i>&nbsp;&nbsp;Re-Check Member</button>';
					}					
				}
			}else{
				if(!empty($chk['data'])){
					$gdata = explode('/',$chk['data']);
					$Datee = $gdata[2].$gdata[1].$gdata[0];
					if($Datee <= '20210331'){
						$data .= '<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-success" title="Return Diposit Money"><i class="fas fa-money-check-alt"></i>&nbsp;&nbsp;&nbsp;Return Diposit Money</button>';
						if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
							if($mem['security_deposit'] > 0 AND $pkg['try_us'] == 0){
								$data .= '<button onclick="return re_check_member('.$d.')" type="button" class="btn btn-xs btn-warning" title="Re-Check Member"><i class="fas fa-user-check"></i>&nbsp;&nbsp;Re-Check Member</button>';
							}
						}
					}else{
						$data .= '<button type="button" class="btn btn-xs btn-danger" title="Need Member Approval"><i class="fas fa-money-check-alt"></i>&nbsp;&nbsp;&nbsp;Need Member Approval</button>';
					}
				}
			}
				//$data .= '<button onclick="return re_book_this_member_with_money('.$d.')" type="button" class="btn btn-xs btn-warning" title="Re-Book this member" style="margin-left: 5px;"><i class="fas fa-trash-restore-alt"></i>&nbsp;&nbsp;&nbsp;Re-booking</button>';
			//}
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