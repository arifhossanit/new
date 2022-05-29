<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = '(
            SELECT 
                a.id, 
                c.product_name,
                a.type,
                a.branch_id,
                a.employee_id,
                a.unit_name,
                a.room_name,
                a.amount,
                a.status,
                a.scm_product_types_id,
                a.creationDate,
                g.unit_price,
                g.id as order_details_pk,
                h.department_requested_by
            FROM scm_product_requisition_uses a
            INNER JOIN scm_product_requisition_details b ON b.id = a.scm_product_requisition_details_id
            INNER JOIN scm_products c ON b.product_id = c.id
            INNER JOIN scm_department_stock d on d.id = a.scm_department_stock_id
            INNER JOIN scm_product_requisition_received e on e.id = d.scm_product_requisition_received_id
            INNER JOIN scm_warehouse_product_stock f on f.id = e.scm_warehouse_product_stock_id
            INNER JOIN scm_product_order_details g on g.id = f.scm_product_order_details_id
            INNER JOIN scm_product_requisition h on h.requisition_id = b.requisition_id
        ) temp';
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
$where = "status = 1 AND amount > 0 AND department_requested_by = '".$_SESSION["user_info"]["department"]."'";
// }
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'product_name', 'dt' => 1 ),
    array( 'db' => 'amount', 'dt' => 2 ),
    array( 'db' => 'creationDate', 'dt' => 3 ),
    array( 'db' => 'branch_id', 'dt' => 4 ),
    array( 'db' => 'employee_id', 'dt' => 5 ),
    array( 'db' => 'unit_name', 'dt' => 6 ),
    array( 'db' => 'room_name', 'dt' => 7 ),
    array( 
        'db' => 'type', 
        'dt' => 8,
        'formatter' => function( $d, $row ) {global $mysqli;
            if($d == 'Branch'){
                $branch = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$row[4]."'"));
                return $branch['branch_name']." - ".$row[6].$row[7];
            }else if($d == 'Employee'){
                $employee = mysqli_fetch_assoc($mysqli->query("SELECT full_name from employee where employee_id = '".$row[5]."'"));
                return $employee['full_name'];
            }else if($d == 'Own'){
                $branch = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$row[4]."'"));
                return $branch['branch_name'];
            }
        }
    ),
    array( 
        'db' => 'status', 
        'dt' => 9,
        'formatter' => function( $d, $row ) {
            $html = '<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#transfer_modal" onclick="set_amount('.$row[2].', '.$row[0].', '.$row[10].', '.$row[12].')">Transfer</button>';
            return $html;
        }
    ),
    array( 'db' => 'scm_product_types_id', 'dt' => 10 ),
    array( 'db' => 'unit_price', 'dt' => 11 ),
    array( 'db' => 'order_details_pk', 'dt' => 12 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>