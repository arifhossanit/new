<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'member_directory';
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
$where = "".$branch_user." status = '3' ";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	/*array( 
		'db' => 'photo_avater', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $home;			
				return '<img src="'.$home.$d.'" style="width:30px;"/>';
			}
	),*/
    array( 'db' => 'branch_name', 'dt' => 1 ),
    array( 'db' => 'card_number', 'dt' => 2 ),
    array( 'db' => 'full_name',  'dt' => 3 ),
    array( 'db' => 'phone_number',  'dt' => 4 ),
    array( 'db' => 'email',     'dt' => 5 ),
    array( 'db' => 'bed_name',     'dt' => 6 ),
    array( 'db' => 'check_in_date',     'dt' => 7 ),
    array( 
		'db' => 'package_category', 
		'dt' => 8,
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
	array( 'db' => 'package_name',     'dt' => 9 ),
    array( 
		'db' => 'security_deposit', 
		'dt' => 10,
		'formatter' => function( $d, $row ) {			
			return money($d);
		}
	),    
        
    array(
        'db'        => 'id',
        'dt'        => 11,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select booking_id from member_directory where id = '".$d."'"));
			$ccn = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where member_id = '".$d."' AND note = 'Request For Cancel for rental payment issue (auto cancel from software)'"));
			$ccn_force = mysqli_fetch_assoc($mysqli->query("select * from return_diposit_money where booking_id = '".$mem['booking_id']."' AND note = 'Auto Refunded for Force Cancel Issue (Money Refunded for force cancel)'"));
			if(!empty($ccn['member_id']) AND $ccn['member_id'] == $d){
				$cencel_button = '
					<button type="button" class="btn btn-xs btn-danger">Auto Cancel</button>
				';
			}else if(!empty($ccn_force['id'])){
				$cencel_button = '
					<button type="button" class="btn btn-xs btn-dark">Force Cancel</button>
				';
			}else{
				$cencel_button = '
					<button type="button" class="btn btn-xs btn-success">Genaral</button>
				';
			}
            $data = '
				<form action="#" method="post" class="duallistbox">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>';
			$data .= $cencel_button;
			if(check_permission('role_1606371525_58')){	 	
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