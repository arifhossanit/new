<?php
include("../../../application/config/ajax_config.php");
if(!isset($_SESSION['super_admin']['email'])){
    redirect(base_url('admin/login'));
}else{
    if($_POST['product_type'] == 'consumable'){
        foreach($_POST['receive_id'] as $idx=>$receive_id){
            $_SESSION['stolen_product_department_receive'][$_POST['product_id']][$receive_id] = ($_POST['stolen_product'][$idx] == '') ? 0 : (int)$_POST['stolen_product'][$idx];
        }
    }else{
        if(isset($_POST['stolen_product'])){
            $_SESSION['stolen_product_department_receive'][$_POST['product_id']] = $_POST['stolen_product'];
        }else{
            unset($_SESSION['stolen_product_department_receive']);
        }
    }
}