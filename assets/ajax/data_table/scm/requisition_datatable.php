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
$where = 'requisition_for = 0';
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'requisition_id', 'dt' => 1 ),
    array( 
		'db' => 'requested_by', 
		'dt' => 2,
		'formatter' => function( $d, $row ) {global $mysqli;global $home;
            $employee = mysqli_fetch_assoc($mysqli->query("SELECT `full_name`, `department_name`, `photo` from employee where employee_id = '".$d."'"));
            return '<div class="row justify-content-center">
                <div class="col-md-2">
                    <a href="'.$home . $employee['photo'] .'" target="_blank"><img src="'.$home . $employee['photo'] .'" width="80px" style="border-radius: 5px;"></a>
                </div>
                <div class="col-md-5 align-self-center">' . $employee['full_name'].' - '.$employee['department_name'] . '</div>
            </div>';
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
            if($d == '0'){
                return '<span class="badge badge-warning">Pending Approval</span>';
            }else if($d == '1'){
                return '<span class="badge badge-warning">Pending SCM</span>';
            }else if($d == '2'){
                return '<span class="badge badge-info">Sent</span>';
            }else if($d == '3'){
                return '<span class="badge badge-success">Received</span>';
            }else if($d == '10'){
                return '<span class="badge badge-warning">Pending D-Head</span>';
            }
        }
	),
    array( 
		'db' => 'requisition_id', 
		'dt' => 7,
		'formatter' => function( $d, $row ) {global $mysqli;global $home;
            // $vendor = mysqli_fetch_assoc($mysqli->query("SELECT `status` from scm_pre_purchase_order where purchase_order_id = '".$d."'"));
            $html = '';
            // $html .= '<button type="button" data-target="#approve_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="approve_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button>';
            // if($vendor['status'] == 'boss_approved'){
            //     $html .= '<abbr title="Add Vendor"><button data-target="#add_vendor" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="add_vendor(this.value)" value="'.$d.'"><i class="fas fa-user-plus"></i></button></abbr>';
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="show_approved_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }else if($vendor['status'] == 'vendor_assigned'){
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="show_approved_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }else{
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }
            if($row[6] == 0){
                if($_SESSION['super_admin']['employee_id'] == '114' or $_SESSION['super_admin']['employee_id'] == '1'){
                    $html .= '<button type="button" data-target="#approve_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="approve_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button>';
                }
            }else if($row[6] == 1){
                $html .= '<a href="'.$home.'admin/scm/manage-requisitions/'.$d.'"><button type="button" class="btn btn-info btn-xs mr-1"><i class="fas fa-warehouse"></i></button></a>';
                $html .= '<button type="button" data-target="#show_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button>';
            }            
            // $html .= '<button data-target="#show_receipt" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_receipt(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button>';

            if($row[6] == 2 OR $row[6] == 3){
                $html .= '<button onclick="get_issue_slip(\''.$row[1].'\')" class="btn btn-primary btn-xs">Issue Slip</button>';
            }
            return $html;
        }
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>