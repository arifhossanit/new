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
// if($_SESSION['super_admin'] != '2805597208697462328'){
//     $where = " department_requested_for = '".$_SESSION['user_info']['department']."'";
// }else{
//     $where = '';
// }
$where = "requisition_for = 1 AND department_requested_by = '".$_SESSION['user_info']['department']."'";
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
                return '<span class="badge badge-warning">Department Head Approved</span>';
            }else if($d == '6'){
                return '<span class="badge badge-info">Pending Boss</span>';
            }else if($d == '7'){
                return '<span class="badge badge-success">Boss Approved</span>';
            }else if($d == '8'){
                return '<span class="badge badge-success">Sent by Department</span>';
            }else if($d == '9'){
                return '<span class="badge badge-success">Received & In Use</span>';
            }
        }
	),
    array( 
		'db' => 'requisition_id', 
		'dt' => 7   ,
		'formatter' => function( $d, $row ) {global $mysqli;global $home;
            $html = '';
            if($row[6] == '9'){ // view after receiving
                $html .= '<abbr title="Show Products"><button type="button" data-target="#receive_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            }else if($row[6] == '8'){ // receive product
                $html .= '<abbr title="Receive Products"><button type="button" data-target="#receive_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="receive_products(this.value)" value="'.$d.'"><i class="fas fa-cart-plus"></i></button></abbr>';
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