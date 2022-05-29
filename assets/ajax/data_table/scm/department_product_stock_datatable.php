<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = '(
            SELECT 
                e.id, 
                SUM(e.stock_amount) as stock_amount, 
                SUM(e.stolen_amount) as stolen_amount, 
                SUM(e.damaged_amount) as damaged_amount, 
                e.branch_id, 
                e.scm_product_requisition_details_id,
                b.product_name,
                b.product_image,
                c.status as product_status,
                d.product_types_id as type_id,
                c.received_date,
                c.department_requested_for,
                j.company_name,
                h.id as scm_product_order_details,
                h.unit_price,
                c.branch_requested_for,
                e.scm_product_requisition_received_id
            FROM scm_product_requisition_details a
            INNER JOIN scm_products b ON a.product_id = b.id
            INNER JOIN scm_product_requisition c ON c.requisition_id = a.requisition_id
            INNER JOIN scm_product_category d ON b.product_category_id = d.id
            INNER JOIN scm_department_stock e ON e.scm_product_requisition_details_id = a.id
            INNER JOIN scm_product_requisition_received f on f.id = e.scm_product_requisition_received_id
            INNER JOIN scm_warehouse_product_stock g on g.id = f.scm_warehouse_product_stock_id            
            INNER JOIN scm_product_order_details h on h.id = g.scm_product_order_details_id
            LEFT JOIN scm_purchase_order i on i.purchase_order_id = h.purchase_order_id
            LEFT JOIN scm_vendor j on j.id = i.vendor_id
            GROUP BY e.branch_id, b.id
        ) temp';
$primaryKey = 'id';


// if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
//     $department = "";
// }else
if($_SESSION['user_info']['department'] == '1806965207554226682'){
    $department = " AND department_requested_for = '" . $_SESSION['user_info']['department'] . "' AND branch_requested_for = '".$_SESSION['super_admin']['branch']."'";
}else{
    $department = " AND department_requested_for = '" . $_SESSION['user_info']['department'] . "'";
}

if(isset($_GET['department']) AND $_GET['department'] != ''){
    $department = " AND department_requested_for = '" . rahat_decode($_GET['department']) . "'";
}

if(isset($_GET['branch']) AND $_GET['branch'] != ''){
    $department = " AND branch_requested_for = '" . rahat_decode($_GET['branch']) . "'";
}

if(isset($_GET['department']) AND $_GET['department'] != '' AND isset($_GET['branch']) AND $_GET['branch'] != ''){
    $department = " AND department_requested_for = '" . rahat_decode($_GET['department'])  . "' AND branch_requested_for = '".rahat_decode($_GET['branch']) ."'";
}


$where = "product_status = 3 AND stock_amount > 0 $department";

$columns = array(
    array(
        'db' => 'product_image',
        'dt' => 0,
        'formatter' => function( $d, $row ) {global $home;
            return '<img class="product-image" src="' . $home . $d . '"></img>';
        }
    ),
    array( 'db' => 'product_name', 'dt' => 1 ),
    array( 'db' => 'received_date', 'dt' => 2 ),
    array( 
        'db' => 'branch_id', 
        'dt' => 3,
        'formatter' => function( $d, $row ) {global $mysqli;
            $branch_name = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$d."'"));
            return $branch_name['branch_name'];
        }
    ),
    array( 
        'db' => 'stock_amount', 
        'dt' => 4,
        'formatter' => function( $d, $row ) {
            return $d;
        }
    ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>