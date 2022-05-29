<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'scm_pre_purchase_order';
$primaryKey = 'id';

// if(!empty($_GET['user_type'])){
// 	if($_GET['user_type'] == rahat_encode('Super Admin') OR $_GET['user_type'] == rahat_encode('Accounts')){
// 		$branch_user = "";
// 	}else{
// 		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND ";
// 	}
// }else{
// 	$branch_user = "";
// }


// $where = "".$branch_user." status = '3' AND note = ''";\
$where = '';
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'purchase_order_id', 'dt' => 1 ),
    array( 'db' => 'order_date', 'dt' => 2 ),
    array( 'db' => 'type', 'dt' => 3 ),
	array( 
		'db' => 'status', 
		'dt' => 4,
		'formatter' => function( $d, $row ) {
            if($d == '0'){
                return '<span class="badge badge-warning">Pending</span>';
            }else{
                return '<span class="badge badge-success">Approved</span>';
            }
        }
	),
    array( 
		'db' => 'status', 
		'dt' => 5,
		'formatter' => function( $d, $row ) {global $mysqli;
            if($d == '2'){
                return '<span class="badge badge-success">Assigned</span>';
            }else{
                return '<span class="badge badge-warning">Not Assigned</span>';
            }
            return '';
        }
	),
	array( 
		'db' => 'purchase_order_id', 
		'dt' => 6,
		'formatter' => function( $d, $row ) {global $mysqli;
            $vendor = mysqli_fetch_assoc($mysqli->query("SELECT `type`, `status` from scm_pre_purchase_order where purchase_order_id = '".$d."'"));
            $html = '';
            $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value, \''.$vendor['type'].'\')" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="show_approved_products(this.value, \''.$vendor['type'].'\')" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            if($vendor['status'] == '1'){
                $html .= '<abbr title="Add Vendor"><button data-target="#add_vendor" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="add_vendor(this.value, \''.$vendor['type'].'\')" value="'.$d.'"><i class="fas fa-user-plus"></i></button></abbr>';
            }else if($vendor['status'] == '2'){
                $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="show_approved_products(this.value, \''.$vendor['type'].'\')" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            }else{
                if($_SESSION['super_admin']['employee_id'] == '114'){
                    $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value, \''.$vendor['type'].'\')" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
                }
            }
            // $html .= '<button data-target="#show_receipt" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_receipt(this.value)" value="'.$d.'"><i class="far fa-edit"></i></button>';
            return $html;
        }
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>