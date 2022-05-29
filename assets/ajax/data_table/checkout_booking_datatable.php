<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if(is_file($file)){
	include($file);
}
include("../../../application/config/ajax_config.php");

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
$where = "".$branch_user." status = '2'";
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
			$status = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			if($status['status'] == '1'){
				return '
					<form action="#" method="post">
						<button type="button" class="btn btn-xs btn-success">Stay</button>
					</form>
				';
			}else if($status['status'] == '2'){
				return '
					<form action="#" method="post">
						<button type="button" class="btn btn-xs btn-warning">CheckOut</button>
					</form>
				';
			}else{
				return '
					<form action="#" method="post">
						<input type="hidden" name="hidden_id" value="'.$d.'"/>
						<button type="button" name="rebook" class="btn btn-xs btn-danger">
							<marquee style="width:60px;    width: 50px; height: 9px; line-height: 9px;">
								Request For Cancel
							</marquee>
						</button>
					</form>
				';
			}            
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$Authorizes = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$d."'"));
			if($Authorizes['card_no'] == 'Unauthorized'){
				$auth_btn = '<button type="button" onclick="return authorized_finction('.$d.')" class="btn btn-xs btn-warning">Authorizes Now</button>';
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
				<input type="hidden" name="hidden_id" value="'.$d.'"/>
			';
			if(check_permission('role_1606371575_34')){	
				$data .= '<button onclick="return view_profile_from_booking('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>';
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