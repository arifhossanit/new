<?php
include("../../../application/config/ajax_config.php");
// var_dump($_POST['pk']);
// print_r("UPDATE scm_product_barcode set id_table_name = 'scm_warehouse_product_stock' AND product_id = gg where id_table_name = 'scm_damaged_goods' AND product_id = ".$_POST['pk']);
// exit();
if($_POST['type'] == 'claim_warrenty'){
    if($mysqli->query("SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'])){
        $insert_warehouse_stock = $mysqli->query("INSERT INTO `scm_warehouse_product_stock`(`warehouse_id`, `scm_product_order_details_id`, `stock_amount`) VALUES (".$_POST['warehouse'].", ".$_POST['id'].", ".$_POST['amount'].")");
        $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_warehouse_product_stock"));
        
        $update_damaged_good = $mysqli->query("UPDATE scm_damaged_goods set `status` = 2 where id = ".$_POST['pk']);
        $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_damaged_goods', ".$_POST['pk'].", 'scm_warehouse_product_stock', ".$inserted_id['max_id'].", ".$_POST['amount'].", 'Transfer', 'Claimed warrenty from vendor!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
        
        if($_POST['type_id'] == '3'){
            $update_barcode = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_warehouse_product_stock', product_id = ".$inserted_id['max_id']." where id_table_name = 'scm_damaged_goods' AND product_id = ".$_POST['pk']);
        }
    }else{
        echo "SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'];
        return json_encode(array('error' => true));
    }
}else if($_POST['type'] == 'repair_outside'){
    if($mysqli->query("SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'])){
        $insert_warehouse_stock = $mysqli->query("INSERT INTO `scm_warehouse_product_stock`(`warehouse_id`, `scm_product_order_details_id`, `stock_amount`) VALUES (".$_POST['warehouse'].", ".$_POST['id'].", ".$_POST['amount'].")");
        $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_warehouse_product_stock"));
        
        $update_damaged_good = $mysqli->query("UPDATE scm_damaged_goods set `status` = 3, repair_fee = ".$_POST['price'].", repaired_vendor = ".$_POST['vendor']." where id = ".$_POST['pk']);
        $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_damaged_goods', ".$_POST['pk'].", 'scm_warehouse_product_stock', ".$inserted_id['max_id'].", ".$_POST['amount'].", 'Repaired', 'Claimed warrenty from vendor!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
        
        if($_POST['type_id'] == '3'){
            $update_barcode = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_warehouse_product_stock', product_id = ".$inserted_id['max_id']." where id_table_name = 'scm_damaged_goods' AND product_id = ".$_POST['pk']);
        }
    }else{
        echo "SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'];
        return json_encode(array('error' => true));
    }
}else if($_POST['type'] == 'claim_warrenty'){
    if($mysqli->query("SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'])){
        $insert_warehouse_stock = $mysqli->query("INSERT INTO `scm_warehouse_product_stock`(`warehouse_id`, `scm_product_order_details_id`, `stock_amount`) VALUES (".$_POST['warehouse'].", ".$_POST['id'].", ".$_POST['amount'].")");
        $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_warehouse_product_stock"));
        
        $update_damaged_good = $mysqli->query("UPDATE scm_damaged_goods set `status` = 2 where id = ".$_POST['pk']);
        $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_damaged_goods', ".$_POST['pk'].", 'scm_warehouse_product_stock', ".$inserted_id['max_id'].", ".$_POST['amount'].", 'Repaired', 'Repaired from vendor!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
        
        if($_POST['type_id'] == '3'){
            $update_barcode = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_warehouse_product_stock', product_id = ".$inserted_id['max_id']." where id_table_name = 'scm_damaged_goods' AND product_id = ".$_POST['pk']);
        }
    }else{
        echo "SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'];
        return json_encode(array('error' => true));
    }
}else if($_POST['type'] == 'repair_in_house'){
    if($mysqli->query("SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'])){
        $insert_warehouse_stock = $mysqli->query("INSERT INTO `scm_warehouse_product_stock`(`warehouse_id`, `scm_product_order_details_id`, `stock_amount`) VALUES (".$_POST['warehouse'].", ".$_POST['id'].", ".$_POST['amount'].")");
        $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_warehouse_product_stock"));
        
        $update_damaged_good = $mysqli->query("UPDATE scm_damaged_goods set `status` = 4 where id = ".$_POST['pk']);
        $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_damaged_goods', ".$_POST['pk'].", 'scm_warehouse_product_stock', ".$inserted_id['max_id'].", ".$_POST['amount'].", 'Repaired', 'Repaired in-house!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
        
        if($_POST['type_id'] == '3'){
            $update_barcode = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_warehouse_product_stock', product_id = ".$inserted_id['max_id']." where id_table_name = 'scm_damaged_goods' AND product_id = ".$_POST['pk']);
        }
    }else{
        echo "SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'];
        return json_encode(array('error' => true));
    }
}
// else if($_POST['type'] == 'repair_in_house'){
//     if($mysqli->query("SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'])){
//         $insert_warehouse_stock = $mysqli->query("INSERT INTO `scm_warehouse_product_stock`(`warehouse_id`, `scm_product_order_details_id`, `stock_amount`) VALUES (".$_POST['warehouse'].", ".$_POST['id'].", ".$_POST['amount'].")");
//         $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_warehouse_product_stock"));
        
//         $update_damaged_good = $mysqli->query("UPDATE scm_damaged_goods set `status` = 4 where id = ".$_POST['pk']);
//         $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_damaged_goods', ".$_POST['pk'].", 'scm_warehouse_product_stock', ".$inserted_id['max_id'].", ".$_POST['amount'].", 'Repaired', 'Repaired in-house!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
        
//         if($_POST['type_id'] == '3'){
//             $update_barcode = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_warehouse_product_stock', product_id = ".$inserted_id['max_id']." where id_table_name = 'scm_damaged_goods' AND product_id = ".$_POST['pk']);
//         }
//     }else{
//         echo "SELECT * from scm_damaged_goods where id = ".$_POST['pk']." AND amount <= ".$_POST['amount'];
//     }
// }
else if($_POST['type'] == 'out_of_order'){
    if($mysqli->query("SELECT * from scm_damaged_goods where id = ".$_POST['id'])){
        $update_damaged_good = $mysqli->query("UPDATE scm_damaged_goods set `status` = 0 where id = ".$_POST['id']);
    }else{
        echo "SELECT * from scm_damaged_goods where id = ".$_POST['id'];
        return json_encode(array('error' => true));
    }
}

return json_encode(array('error' => false));