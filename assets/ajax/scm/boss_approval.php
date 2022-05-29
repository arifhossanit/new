<?php
include("../../../application/config/ajax_config.php");
foreach($_POST['product_ids'] as $idx=>$product_id){
    $mysqli->query("UPDATE scm_product_order_details set `approved_amount` = ".$_POST['approved_amounts'][$idx]." where id = '$product_id'");
}
$mysqli->query("UPDATE scm_pre_purchase_order set `status` = '1' where purchase_order_id = '".$_POST['purchase_order']."'");
return 'ok';