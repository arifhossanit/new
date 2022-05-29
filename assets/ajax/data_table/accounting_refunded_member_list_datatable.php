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


$where = "".$branch_user." status = '3' AND note = 'Diposit money return'";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 
		'db' => 'photo_avater', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $home;			
				return '<img src="'.$home.$d.'" style="width:30px;"/>';
			}
	),
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
            $data = '
				<form action="#" method="post" class="duallistbox">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>';
			//if(check_permission('role_1603977545_42')){		
				$data .= '
					<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-danger" ><i class="fas fa-money-check-alt"></i>&nbsp;&nbsp;&nbsp;Sicurity Deposit is Refunded! <i class="fas fa-check-square"></i></button>
					
				';
			//}
			$data .= '</form>';
			return $data;
        }
    )
);
 /*<button onclick="return re_book_this_member('.$d.')" type="button" class="btn btn-xs btn-success" ><i class="fas fa-trash-restore"></i>&nbsp;&nbsp;&nbsp;Re-Booking</button>*/

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>