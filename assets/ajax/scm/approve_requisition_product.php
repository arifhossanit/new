<?php
include("../../../application/config/ajax_config.php");
// echo $_POST['product_id'];
foreach($_POST['product_id'] as $idx=>$product){
    $mysqli->query("UPDATE scm_product_requisition_details set `approved_amount` = ".$_POST['approved_amount'][$idx]." where id = ".$product);
}
if(isset($_POST['approval_type'])){
    if($_POST['approval_type'] == 'dep'){
        $mysqli->query("UPDATE scm_product_requisition set `status` = 5, approved_by = '".$_SESSION['super_admin']['employee_ids']."', approved_on = '".date('Y-m-d H:i:s')."' where requisition_id = '".$_POST['requisition_id_approval']."'");
    }else if($_POST['approval_type'] == 'd_head_approve'){

        foreach($_POST['product_id'] as $idx=>$product){
            $mysqli->query("UPDATE scm_product_requisition_details set `requested_amount` = {$_POST['approved_amount'][$idx]} where id = $product");
        }

        $mysqli->query("UPDATE scm_product_requisition set `status` = 0 where requisition_id = '".$_POST['requisition_id_approval']."'");        
    }else{
        $mysqli->query("UPDATE scm_product_requisition set `status` = 7, boss_approval_date = '".date('Y-m-d H:i:s')."' where requisition_id = '".$_POST['requisition_id_approval']."'");
    }
}else{
    $mysqli->query("UPDATE scm_product_requisition set `status` = 1, approved_by = '".$_SESSION['super_admin']['employee_ids']."', approved_on = '".date('Y-m-d H:i:s')."' where requisition_id = '".$_POST['requisition_id_approval']."'");
}
// $info = array(
//     'html' => $html,
// );
echo alert_for_js('success', 'Product Approved!!');
