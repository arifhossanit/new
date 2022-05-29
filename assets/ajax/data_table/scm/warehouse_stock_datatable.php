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
                e.warehouse_id, 
                e.scm_product_order_details_id,
                b.product_name,
                d.product_types_id as type_id,
                d.name as type_name,
                c.received_date,
                c.vendor_id,
                b.scale_id,
                f.received_date as food_received_date,
                a.id as order_details_id,
                a.product_size,
                a.color,
                c.purchase_order_id,
                b.product_category_id,
                b.product_image,
                b.id as product_id,
                h.department_name
            FROM scm_product_order_details a
            INNER JOIN scm_products b ON a.product_id = b.id
            INNER JOIN scm_product_has_department g on g.product_id = b.id
            INNER JOIN department h on h.department_id = g.department_id
            LEFT JOIN scm_purchase_order c ON c.purchase_order_id = a.purchase_order_id
            INNER JOIN scm_product_category d ON b.product_category_id = d.id
            INNER JOIN scm_warehouse_product_stock e ON e.scm_product_order_details_id = a.id
            INNER JOIN scm_pre_purchase_order f ON f.purchase_order_id = a.pre_purchase_order_id
            GROUP BY e.warehouse_id, b.product_category_id, b.brand_id, a.product_size
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
    // $where = 'product_status = 3 AND stock_amount > 0 AND department_requested_for = \''.$_SESSION['user_info']['department'].'\'';
$where = 'stock_amount > 0 AND type_id != 6';
// }
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array(
        'db' => 'product_image',
        'dt' => 1,
        'formatter' => function ($d, $row) {global $home;
            return '<img class="product-image" src="'.$home . $d .'"></img>';
        }
    ),
    array( 'db' => 'type_name', 'dt' => 2 ),
    array( 
        'db' => 'product_name',
        'dt' => 3,
        'formatter' => function( $d, $row){global $mysqli;
            $measurement = mysqli_fetch_assoc($mysqli->query("SELECT `width`, `height`, `unit` from scm_product_measurement where id = '".$row[7]."'"));
            $measurement_name = '';
            if(!is_null($measurement)){
                $measurement_name = ' (' . $measurement['width'] ;
                if($measurement['height'] != '0'){
                    $measurement_name .= ' x ' . $measurement['height'];
                }
                $measurement_name .= ' ' . $measurement['unit']. ') ';
            }
            if($d == $row[2]){
                return $d . $measurement_name . '( ' . $row[5] . ' )';
            }else{
                return $row[2].' - '.$d . $measurement_name . '( ' . $row[5] . ' )';
            }
        }),
    array( 
        'db' => 'stock_amount', 
        'dt' => 4,
        'formatter' => function( $d, $row ) {global $mysqli;
            $scale = mysqli_fetch_assoc($mysqli->query("SELECT `name` from scm_scales where id = '".$row[9]."'"));
            $scale_name = (is_null($scale)) ? '<span class="text-danger">' . $row[9] . '</span>' : $scale['name'];
            return $d . ' ' . $scale_name;
        }
    ),
    array( 
        'db' => 'department_name', 
        'dt' => 5,
        'formatter' => function( $d, $row ) {
            $button = '';
            if($row[6] == 3){ // storeable products
                // $button .= '<button class="btn btn-info btn-xs" onclick="show_barcode('.$d.', \''.$row[2].'\', '.$row[3].')" data-toggle="modal" data-target="#barcode_modal"><i class="fas fa-eye"></i></button>';
            }else if($row[6] == 5 OR $row[6] == 1){ // storeable products
                if($row[3] == $row[3]){
                    $name = $row[3];
                }else{
                    $name = $row[3].' - '.$row[3];
                }
                $button .= '<button class="btn btn-info btn-xs" onclick="consumeable_food_details('.$row[8].', \''.$name.'\', '.$row[7].')" ><i class="fas fa-info-circle"></i> Details</button>';
            
            }
            return $button;
        }
    ),
    array( 'db' => 'type_id', 'dt' => 6 ),
    array( 'db' => 'product_size', 'dt' => 7 ),
    array( 'db' => 'product_id', 'dt' => 8 ),
    array( 'db' => 'scale_id', 'dt' => 9 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>