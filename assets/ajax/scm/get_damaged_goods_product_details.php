<?php
include("../../../application/config/ajax_config.php");
// unset($_SESSION['department_transfer_cart']);
// var_dump($_SESSION['department_transfer_cart']);
// print_r($_POST['rqst_id']);
// exit();
$products = $mysqli->query("SELECT scm_product_barcode.id, scm_product_barcode.barcode, scm_product_barcode.status from scm_product_barcode where id_table_name = 'scm_damaged_goods' AND scm_product_barcode.product_id = ".rahat_decode($_POST['id']));
// print_r("SELECT scm_product_barcode.id, scm_product_barcode.barcode, scm_product_barcode.status, scm_department_stock.branch_id, scm_department_stock.id as stock_id from scm_product_barcode INNER JOIN scm_department_stock on scm_department_stock.id = scm_product_barcode.product_id where id_table_name = 'scm_department_stock' AND scm_product_barcode.purchase_table_id = ".$_POST['pur_pk']);
$html = '<input type="hidden" id="rqst_id" value="'.$_POST['name'].'">
        <input type="hidden" id="product_to_add_id" value="'.$_POST['name'].'">
        <input type="hidden" id="product_to_add_name" value="'.$_POST['name'].'">
        <h4>'.$_POST['name'].'</h4>
        <table class="table table-bordered" id="product_details_datatable" style="width: 100%">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Barcode</td>
                    <td>Previous Used</td>
                </tr>
            </thead>
            <tbody>';
while($product = mysqli_fetch_assoc($products)){
    $html .=    '<tr>
                    <td>
                        <input name="product_to_add[]" class="regular-checkbox" type="checkbox" value="'.$product['id'].'">
                    </td>';
    
    $html .=        '<td>'.$product['barcode'].'</td>
                    <td>
                    <div class="row text-info">';
    if($product['status'] == 1){
        $html .=        '<div class="col-sm-2">No</div>';
    }else{
        $html .=        '<div class="col-sm-2"><p class="mb-0">Yes</p></div>';
    }
    $html .=            '<div class="col-sm-2 mb-0"><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#product_history" type="button" onclick="show_history(\''.rahat_encode('scm_damaged_goods').'\', \''.$_POST['id'].'\')"><i class="fas fa-eye"></i></div>
                    </div>
                </td>
                </tr>';
}
$html .=  '</tbody>
        </table>';
$button = '<button type="submit" class="btn btn-primary btn-sm">Submit</button>';
$info = array(
    'html' => $html,
    'button' => $button,
);
echo json_encode($info);