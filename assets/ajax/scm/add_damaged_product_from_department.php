<?php
include("../../../application/config/ajax_config.php");
if(!isset($_SESSION['super_admin']['email'])){
    redirect(base_url('admin/login'));
}else{
    var_dump($_POST['receive_id']);
    if($_POST['product_type'] == 'consumable'){
        foreach($_POST['receive_id'] as $idx=>$receive_id){
            $_SESSION['damaged_product_department_receive_from_department'][$_POST['product_id']][$receive_id] = ($_POST['damaged_product'][$idx] == '') ? 0 : (int)$_POST['damaged_product'][$idx];
        }
    }else{
        if(isset($_POST['damaged_product'])){
            $_SESSION['damaged_product_department_receive_from_department'][$_POST['product_id']] = $_POST['damaged_product'];
        }else{
            unset($_SESSION['damaged_product_department_receive_from_department']);
        }
    }    
}