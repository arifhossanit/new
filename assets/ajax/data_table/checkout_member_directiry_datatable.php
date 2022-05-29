<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = '(SELECT 
                a.id,
                a.branch_name,
                a.branch_id,
                a.card_number,
                a.full_name,
                a.phone_number,
                a.email,
                a.bed_name,
                a.check_in_date,
                a.package_category,
                a.package_name,
                a.security_deposit,
                a.status,
                b.data as check_out_date
            FROM member_directory a
            INNER JOIN withdraw_checkout b USING (booking_id)              
        ) temp';
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
		$date_filter = " AND STR_TO_DATE(check_out_date,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
	}else{
		$date_filter = "";
	}	
}else{
	$date_filter = "";
}
$where = "".$branch_user." status = '3' ".$date_filter;
// echo $where;
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
    array( 'db' => 'check_out_date',     'dt' => 8 ),
    array( 
		'db' => 'package_category', 
		'dt' => 9,
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
	array( 'db' => 'package_name',     'dt' => 10 ),
    array( 
		'db' => 'security_deposit', 
		'dt' => 11,
		'formatter' => function( $d, $row ) {			
			return money($d);
		}
	),    
        
    array(
        'db'        => 'id',
        'dt'        => 12,
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