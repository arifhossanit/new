<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'scm_product_requisition';
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
$where = "requisition_for = 1 AND department_requested_for = '".$_SESSION['user_info']['department']."'";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'requisition_id', 'dt' => 1 ),
    array( 
		'db' => 'requested_by', 
		'dt' => 2,
		'formatter' => function( $d, $row ) {global $mysqli;
            $employee = mysqli_fetch_assoc($mysqli->query("SELECT `full_name` from employee where employee_id = '".$d."'"));
            return $employee['full_name'];
        }
	),
    array( 'db' => 'department_requested_for', 'dt' => 3 ),
    array( 
		'db' => 'branch_requested_for', 
		'dt' => 4,
		'formatter' => function( $d, $row ) {global $mysqli;
            $branch = mysqli_fetch_assoc($mysqli->query("SELECT `branch_name` from branches where branch_id = '".$d."'"));
            $department = mysqli_fetch_assoc($mysqli->query("SELECT `department_name` from department where department_id = '".$row[3]."'"));
            return '<p class="mb-0">'.$branch['branch_name'].': '.$department['department_name'].'</p>';
        }
	),
    array( 'db' => 'requested_on', 'dt' => 5 ),
    array( 
		'db' => 'status', 
		'dt' => 6,
		'formatter' => function( $d, $row ) {
            if($d == '4'){
                return '<span class="badge badge-warning">Pending Department Head</span>';
            }else if($d == '5'){
                return '<span class="badge badge-success">Department Head Approved</span>';
            }else if($d == '6'){
                return '<span class="badge badge-warning">Pending Boss Approval</span>';
            }else if($d == '7'){
                return '<span class="badge badge-success">Boss Approved</span>';
            }else if($d == '8'){
                return '<span class="badge badge-warning">Sent from Department</span>';
            }else if($d == '9'){
                return '<span class="badge badge-success">Product in Use</span>';
            }
        }
	),
    array( 
		'db' => 'requisition_id', 
		'dt' => 7,
		'formatter' => function( $d, $row ) {global $mysqli;global $home;
            // $vendor = mysqli_fetch_assoc($mysqli->query("SELECT `status` from scm_pre_purchase_order where purchase_order_id = '".$d."'"));
            $html = '';
            // if($vendor['status'] == 'boss_approved'){
            //     $html .= '<abbr title="Add Vendor"><button data-target="#add_vendor" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="add_vendor(this.value)" value="'.$d.'"><i class="fas fa-user-plus"></i></button></abbr>';
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="show_approved_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }else if($vendor['status'] == 'vendor_assigned'){
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="show_approved_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }else{
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }
            if($row[6] == 4){
                $html .= '<button type="button" data-target="#approve_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="approve_products(this.value, \'Department Head Approval\', \'dep\')" value="'.$d.'"><i class="fas fa-eye"></i></button>';
            }else if($row[6] == 6){
                $html .= '<button type="button" data-target="#approve_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="approve_products(this.value, \'Boss Approval\', \'boss\')" value="'.$d.'"><i class="fas fa-eye"></i></button>';
            }else if($row[6] == 5 || $row[6] == 7){
                // $html .= '<a href="'.$home.'admin/scm/manage-requisitions/'.$d.'"><button type="button" class="btn btn-info btn-xs mr-1"><i class="fas fa-warehouse"></i></button></a>';
                $html .= '<button type="button" data-target="#show_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button>';
            }            
            // $html .= '<button data-target="#show_receipt" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_receipt(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button>';
            return $html;
        }
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>