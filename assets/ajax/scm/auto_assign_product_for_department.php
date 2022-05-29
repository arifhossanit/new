<?php
include("../../../application/config/ajax_config.php");
$requisition_id = $_POST['requisition_id'];
$products = $mysqli->query("SELECT scm_product_requisition.department_send_details_id, scm_product_requisition.branch_requested_for, scm_product_types.name as type_name, scm_products.product_name, scm_product_category.product_types_id, scm_product_category.name as category_name, scm_scales.name as scale_name, scm_brands.name as brand_name, scm_product_requisition_details.* FROM scm_product_requisition_details INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id INNER JOIN scm_product_requisition using (requisition_id) where scm_product_requisition_details.requisition_id = '$requisition_id'");
while($product = mysqli_fetch_assoc($products)){    
    $specification_count = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as specification_count from scm_product_requisition_specification where requisition_pk = ".$product['id']));
    if($specification_count['specification_count'] != 0){
        $specification_condition = ' HAVING COUNT(*) = '.$specification_count['specification_count'];
    }else{
        $specification_condition = '';
    }

    $total_stock = 0;

    // will not run without purchase order
    // $stock = mysqli_fetch_assoc($mysqli->query("SELECT sum(t2.requested_amount) as total_amount from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1, (SELECT scm_product_order_details.requested_amount, scm_product_order_details.purchase_order_id,scm_product_order_details.warehouse_id, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id where scm_product_order_details.purchase_order_id is NOT null) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id) GROUP BY t2.id HAVING COUNT(*) = ".$specification_count['specification_count']));

    // will run without purchase order
    // $get_product_ids = $mysqli->query("SELECT t2.id, t1.id as requisition_details_id from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1, (SELECT scm_product_order_details.status, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id AND t2.status = 1) GROUP BY t2.id".$specification_condition);
    $get_product_ids = $mysqli->query("SELECT t2.department_requested_for, t2.id, t2.stock_amount, t2.scm_product_requisition_details_id, t1.id as requisition_details_id from
    (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id
    FROM `scm_product_requisition_details`
    LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1,
    (SELECT scm_product_requisition.department_requested_for, scm_product_requisition.status, scm_product_requisition.requisition_for, scm_department_stock.id, scm_department_stock.stock_amount, scm_department_stock.scm_product_requisition_details_id, scm_product_requisition_details.product_id, scm_product_requisition_details.color, scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id
    FROM `scm_product_requisition_details`
    INNER JOIN scm_product_requisition using (requisition_id)
    INNER JOIN scm_department_stock on scm_department_stock.scm_product_requisition_details_id = scm_product_requisition_details.id
    LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id) t2
    where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id AND t2.status = 3 AND t2.requisition_for = 0 AND t2.stock_amount > 0 AND t2.department_requested_for = '{$_SESSION['user_info']['department']}') GROUP BY t2.id".$specification_condition);
    // print_r("SELECT t2.id, t1.id as requisition_details_id from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1, (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` INNER JOIN scm_product_requisition using (scm_product_requisition_details) LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition.requisition_for = 0 AND scm_product_requisition.status = 3) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id AND t2.status = 1) GROUP BY t2.id".$specification_condition);
    // $stocks = $mysqli->query("SELECT id, stock_amount from scm_warehouse_product_stock where stock_amount > 0 AND scm_product_order_details_id = 441");
    // var_dump(mysqli_fetch_assoc($stocks));
    // exit();
    // print_r("SELECT t2.id from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1, (SELECT scm_product_order_details.status, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id AND t2.status = 1 AND t2.) GROUP BY t2.id".$specification_condition);
    $sent_amount = 0;
    $get_send_details = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_department_send_product_details where id = ".$product['department_send_details_id']));
    $mysqli->query("START TRANSACTION");
    while($get_product_id = mysqli_fetch_assoc($get_product_ids)){
        // $stocks = $mysqli->query("SELECT id, stock_amount from scm_department_stock where stock_amount > 0 AND id = ".$get_product_id['id']);
        // while($stock = mysqli_fetch_assoc($stocks)){
            // print_r($remaining_amount_warehouse);
            // if( $stock['stock_amount'] >= $product['requested_amount']){
            //     $mysqli->query("INSERT INTO `scm_product_requisition_received`(`scm_product_requisition_details_id`, `scm_warehouse_product_stock_id`, `amount`) VALUES ('".$product['id']."', '".$stock['id']."', '".$product['requested_amount']."')");
            //     $mysqli->query("UPDATE scm_warehouse_product_stock set `stock_amount` = stock_amount - ".$product['requested_amount']." where id = ".$stock['id']);
            //     $mysqli->query("UPDATE scm_product_requisition_details set `sent_amount` = ".$product['requested_amount']." where id = ".$product['id']);
            //     if(strtolower($product['type_name']) == 'storable'){
            //         $mysqli->query("UPDATE `scm_product_barcode` SET `product_id` = '".$product['id']."', id_table_name = 'scm_product_requisition_details' WHERE product_id = ".$stock['id']." LIMIT ".$product['requested_amount']);
            //     }                
            //     break 2; // -- Sent all product
            // }else if($sent_amount < $product['requested_amount']){
            $remaining_amount_requisition = (int)$product['approved_amount'] - $sent_amount;
            // var_dump($remaining_amount_requisition);
            // exit();
            if($remaining_amount_requisition != 0){
                if($remaining_amount_requisition >= $get_product_id['stock_amount']){
                    $sent_amount += (int)$get_product_id['stock_amount'];
                    $update_product_stock = $mysqli->query("UPDATE scm_department_stock set `stock_amount` = 0 where id = ".$get_product_id['id']);
                    if(mysqli_error($mysqli)){
                        echo mysqli_error($mysqli);
                        $mysqli->query('ROLLBACK');
                    }
                    $insert_requisition_received = $mysqli->query("INSERT INTO `scm_product_requisition_received`(`scm_product_requisition_details_id`, `scm_warehouse_product_stock_id`, `amount`, `status`) VALUES ('".$product['id']."', '".$get_product_id['id']."', '".$get_product_id['stock_amount']."', 1)");
                    if(mysqli_error($mysqli)){
                        echo mysqli_error($mysqli);
                        $mysqli->query('ROLLBACK');
                    }
                    // $scm_product_requisition_uses = $mysqli->query("INSERT INTO `scm_product_requisition_uses`(`scm_department_stock_id`, `scm_product_requisition_details_id`, `type`, `branch_id`, `employee_id`, `unit_name`, `room_name`, `amount`, `updated_by`, `updated_at`, `creationDate`, `status`, `note`, `scm_product_types_id`) VALUES ('".$product['id']."', '".$product['scm_product_requisition_details_id']."', '".$get_send_details['type']."', '".$product['branch_requested_for']."', '".$get_send_details['employee_id']."', '".$get_send_details['unit_name']."', '".$get_send_details['room_name']."', '".$get_product_id['stock_amount']."', '".$_SESSION['super_admin']['employee_ids']."'), '".date('Y-m-d H:i:s')."'), '".$get_product_id['stock_amount']."', '".date('Y-m-d H:i:s')."', '1', '".$_POST['note']."', '".$product['product_types_id']."'))");
                    if(strtolower($product['type_name']) == 'storable'){
                        $update_barcode = $mysqli->query("UPDATE `scm_product_barcode` SET `product_id` = '".$product['id']."', id_table_name = 'scm_product_requisition_details' WHERE id_table_name = 'scm_department_stock' AND product_id = ".$get_product_id['id']);
                        if(mysqli_error($mysqli)){
                            echo mysqli_error($mysqli);
                            $mysqli->query('ROLLBACK');
                        }
                    }
                    $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_department_stock', ".$get_product_id['id'].", 'scm_product_requisition_details', ".$product['id'].", ".$get_product_id['stock_amount'].", 'transfer', 'Assigning Product for Department from Department!', '".date('Y-m-d H:i:s')."', ".$_SESSION['super_admin']['employee_ids'].", 1)");
                    if(mysqli_error($mysqli)){
                        echo mysqli_error($mysqli);
                        $mysqli->query('ROLLBACK');
                    }
                }else{
                    $sent_amount += (int)$remaining_amount_requisition;
                    $update_product_stock = $mysqli->query("UPDATE scm_department_stock set `stock_amount` = stock_amount - ".$remaining_amount_requisition." where id = ".$get_product_id['id']);
                    if(mysqli_error($mysqli)){
                        echo mysqli_error($mysqli);
                        $mysqli->query('ROLLBACK');
                    }
                    $insert_requisition_received = $mysqli->query("INSERT INTO `scm_product_requisition_received`(`scm_product_requisition_details_id`, `scm_warehouse_product_stock_id`, `amount`, `status`) VALUES ('".$product['id']."', '".$get_product_id['id']."', '".$remaining_amount_requisition."', 1)");
                    if(mysqli_error($mysqli)){
                        echo mysqli_error($mysqli);
                        $mysqli->query('ROLLBACK');
                    }
                    if(strtolower($product['type_name']) == 'storable'){
                        $update_barcode = $mysqli->query("UPDATE `scm_product_barcode` SET `product_id` = '".$product['id']."', id_table_name = 'scm_product_requisition_details' WHERE id_table_name = 'scm_department_stock' AND product_id = ".$get_product_id['id']." LIMIT ".$remaining_amount_requisition);
                        if(mysqli_error($mysqli)){
                            echo mysqli_error($mysqli);
                            $mysqli->query('ROLLBACK');
                        }
                    }
                    $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_department_stock', ".$get_product_id['id'].", 'scm_product_requisition_details', ".$product['id'].", ".$remaining_amount_requisition.", 'transfer', 'Assigning Product for Department from Department!', '".date('Y-m-d H:i:s')."', ".$_SESSION['super_admin']['employee_ids'].", 1)");
                    if(mysqli_error($mysqli)){
                        echo mysqli_error($mysqli);
                        $mysqli->query('ROLLBACK');
                    }
                    $mysqli->query("UPDATE scm_product_requisition_details set `sent_amount` = ".$product['requested_amount']." where id = ".$product['id']);
                    if(mysqli_error($mysqli)){
                        echo mysqli_error($mysqli);
                        $mysqli->query('ROLLBACK');
                    }
                    break; // -- Sent all product
                }
            }
        // }
    }
}
$mysqli->query("UPDATE scm_product_requisition set `status` = 8, warehouse_exit_date = '".date('Y-m-d H:i:s')."' where requisition_id = '".$requisition_id."'");
if(mysqli_error($mysqli)){
    echo mysqli_error($mysqli);
    $mysqli->query('ROLLBACK');
}
$mysqli->query('COMMIT');
$info = array(
    'alert' => alert_for_js('success', 'Product Added!!')
);
echo json_encode($info);
