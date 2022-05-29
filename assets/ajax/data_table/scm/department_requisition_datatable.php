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


// $where = "".$branch_user." status = '3' AND note = ''";

//print_r($_SESSION['super_admin']['email']);
$employee = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where email = '".$_SESSION['super_admin']['email']."'"));

if($employee['department'] == '2805597208697462328'){ // Branch Operation
    $where = " department_requested_by = '".$employee['department']."' AND branch_requested_for = '{$_SESSION['super_admin']['branch']}'";
}else{
    $where = " department_requested_by = '".$employee['department']."' AND branch_requested_for='{$_SESSION['super_admin']['branch']}'";
}
// $where = 'requisition_for = 0';
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'requisition_id', 'dt' => 1 ),
    array( 
		'db' => 'requested_by', 
		'dt' => 2,
		'formatter' => function( $d, $row ) {global $mysqli;
            $employee = mysqli_fetch_assoc($mysqli->query("SELECT `full_name`, `photo` from employee where employee_id = '".$d."'"));
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
		'dt' => 7   ,
		'formatter' => function( $d, $row ) {global $mysqli;global $home;
            $html = '';
            if($row[6] == '10' AND $row[8] == $_SESSION['user_info']['department'] AND $_SESSION['user_info']['d_head']){ // view after receiving
                $html .= '<abbr title="Approve Requisition"><button type="button" data-target="#d_head_approval" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="approve_products(this.value)" value="'.$d.'"><i class="fas fa-check"></i></button></abbr>';
                return $html;
            }
            if($row[6] == '3' AND $row[8] == $_SESSION['user_info']['department'] AND $_SESSION['user_info']['d_head']){ // view after receiving
                $html .= '<abbr title="Show Products"><button type="button" data-target="#receive_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
                return $html;
            }
            if($row[6] == '2' AND $row[8] == $_SESSION['user_info']['department']){ 
				//  AND $_SESSION['user_info']['d_head'] receive product
                $html .= '<abbr title="Receive Products"><button type="button" data-target="#receive_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="receive_products(this.value)" value="'.$d.'"><i class="fas fa-cart-plus"></i></button></abbr>';
                return $html;
            }
        }
	),
    array( 'db' => 'department_requested_by', 'dt' => 8 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
); 
?>