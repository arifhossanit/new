<?php
include("../../../application/config/ajax_config.php");
// unset($_SESSION['department_transfer_cart']);
// var_dump($_SESSION['department_transfer_cart']);
// print_r($_POST['rqst_id']);
// exit();
$products = $mysqli->query("SELECT scm_product_barcode.product_id, scm_product_barcode.id, scm_product_barcode.barcode, scm_product_barcode.status from scm_product_barcode where id_table_name = 'scm_warehouse_product_stock' AND purchase_table_id = ".$_POST['pur_pk']);
$html = '<h4>'.$_POST['name'].'</h4>
        <table class="table table-bordered" id="warehouse_barcode_table" style="width: 100%">
            <thead>
                <tr>
                    <td>Barcode</td>
                    <td>Previous Used</td>
                </tr>
            </thead>
            <tbody>';
while($product = mysqli_fetch_assoc($products)){
    $html .=        '<td>'.$product['barcode'].'</td>';
    if($product['status'] == 1){
        $html .= '<td class="text-danger">No</td>';
    }else{
        $html .= '<td>
                    <div class="row text-info"><div class="col-sm-2"><p class="mb-0">Yes</p></div><div class="col-sm-2 mb-0"><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#product_history" type="button" onclick="show_history(\''.rahat_encode('scm_warehouse_product_stock').'\', \''.rahat_encode($product['product_id']).'\')"><i class="fas fa-eye"></i></div></div>
                  </td>';
    }
    $html .=    '</tr>';
}
$html .=  '</tbody>
        </table>';
$button = '<button type="submit" class="btn btn-primary btn-sm">Add</button>';
$info = array(
    'html' => $html,
    'button' => $button,
);
echo json_encode($info);