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
                c.status as product_status,
                d.product_types_id as type_id,
                c.received_date,
                c.department_requested_for,
                j.company_name,
                h.id as scm_product_order_details,
                h.unit_price,
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
            GROUP BY e.scm_product_requisition_received_id, e.branch_id, e.scm_product_requisition_details_id
        ) temp';
$primaryKey = 'id';

$where = "product_status = 3 AND stock_amount > 0 AND department_requested_for = '".$_SESSION["user_info"]["department"]."'";

$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
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
    array( 
        'db' => 'company_name', 
        'dt' => 5,
        'formatter' => function( $d, $row ) {global $mysqli;
            return $d.' P: '.$row[11];
        }
    ),
    array( 
        'db' => 'stock_amount', 
        'dt' => 6,
        'formatter' => function( $d, $row ) {global $mysqli;
            // $employee = mysqli_fetch_assoc($mysqli->query("SELECT `full_name` from employee where employee_id = '".$d."'"));
            if($row[8] == 3){
                $html = '<div class="row justify-content-center">
                            <div class="col-md-2 col-12">
                                <button type="button" data-target="#product_details" data-toggle="modal" class="btn btn-default btn-sm" onclick="show_department_product_details('.$row[0].', \''.$row[1].'\', '.$row[9].', '.$row[10].', '.$row[12].')"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>';
            }else{
                $html = '<div class="row justify-content-center">
                            <div class="col-md-8 col-12">
                                <div class="btn-group w-75" role="group" aria-label="Basic example">
                                    <button style="height: 85% !important;" type="button" class="button-counter left btn btn-default btn-sm" onclick="minus_number('.$row[0].')"><i class="fas fa-minus span-custom"></i></button>
                                    <input style="height: 31px !important;" type="number" name="product_'.$row[0].'" id="product_'.$row[0].'" class="form-control input-counter counter" placeholder="0" value="0" min="0">
                                    <button style="height: 85% !important;" type="button" class="button-counter right btn btn-default btn-sm" onclick="add_number('.$row[0].')"><i class="fas fa-plus span-custom"></i></button>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="button" class="btn btn-default btn-sm" onclick="add_department_transfer_cart('.$row[0].', \''.$row[1].'\', '.$row[8].', '.$row[9].', '.$row[10].', '.$row[12].')"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>';
            }
            
            return $html;
        }
    ),
    array( 'db' => 'stolen_amount', 'dt' => 7 ),
    array( 'db' => 'type_id', 'dt' => 8 ),
    array( 'db' => 'scm_product_requisition_details_id', 'dt' => 9 ),
    array( 'db' => 'scm_product_order_details', 'dt' => 10 ),
    array( 'db' => 'unit_price', 'dt' => 11 ),
    array( 'db' => 'scm_product_requisition_received_id', 'dt' => 12 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>