<?php
include("../../../application/config/ajax_config.php");
// unset($_SESSION['department_transfer_cart']);
// var_dump($_SESSION['department_transfer_cart']);
// print_r($_POST['rqst_id']);
// exit();
$products = $mysqli->query("SELECT scm_product_barcode.id, scm_product_barcode.barcode, scm_product_barcode.status, scm_department_stock.branch_id, scm_department_stock.id as stock_id, scm_department_stock.scm_product_requisition_received_id from scm_product_barcode INNER JOIN scm_department_stock on scm_department_stock.id = scm_product_barcode.product_id where id_table_name = 'scm_department_stock' AND scm_product_barcode.purchase_table_id = ".$_POST['pur_pk']." AND scm_department_stock.id = ".$_POST['id']);
// print_r("SELECT scm_product_barcode.id, scm_product_barcode.barcode, scm_product_barcode.status, scm_department_stock.branch_id, scm_department_stock.id as stock_id from scm_product_barcode INNER JOIN scm_department_stock on scm_department_stock.id = scm_product_barcode.product_id where id_table_name = 'scm_department_stock' AND scm_product_barcode.purchase_table_id = ".$_POST['pur_pk']);
$html = '<input type="hidden" id="rqst_id" value="'.$_POST['rqst_id'].'">
        <input type="hidden" id="product_to_add_id" value="'.$_POST['id'].'">
        <input type="hidden" id="product_to_add_name" value="'.$_POST['name'].'">
        <input type="hidden" id="requisition_receive" value="'.$_POST['receive_id'].'">
        <h4>'.$_POST['name'].'</h4>
        <table class="table table-bordered" id="product_details_datatable" style="width: 100%">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Barcode</td>
                    <td>Branch</td>
                    <td>Previous Used</td>
                </tr>
            </thead>
            <tbody>';
if(isset($_SESSION['department_transfer_cart'])){
    $idx = array_search($_POST['id'], array_column($_SESSION['department_transfer_cart'], 'id'));
}else{
    $idx = false;
}
while($product = mysqli_fetch_assoc($products)){
    // $barcode = mysqli_fetch_assoc();
    if($idx !== false){
        $selected_barcode = array_search($product['id'], $_SESSION['department_transfer_cart'][$idx]['barcodes']);
        if($selected_barcode !== false){
            $html .=    '<tr>
                            <td>
                                <input name="product_to_add[]" class="regular-checkbox" type="checkbox" value="'.$product['id'].'" checked>
                            </td>';
        }else{
            $html .=    '<tr>
                            <td>
                                <input name="product_to_add[]" class="regular-checkbox" type="checkbox" value="'.$product['id'].'">
                            </td>';
        }
    }else{
        $html .=    '<tr>
                        <td>
                            <input name="product_to_add[]" class="regular-checkbox" type="checkbox" value="'.$product['id'].'">
                        </td>';
    }
    
    $html .=        '<td>'.$product['barcode'].'</td>';
    $branch_name = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$product['branch_id']."'"));
    $html .=        '<td>'.$branch_name['branch_name'].'</td>';
    if($product['status'] == 1){
        $html .= '<td class="text-danger">No</td>';
    }else{
        $html .= '<td>
                    <div class="row text-info"><div class="col-sm-2"><p class="mb-0">Yes</p></div><div class="col-sm-2 mb-0"><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#product_history" type="button" onclick="show_history(\''.rahat_encode('scm_department_stock').'\', \''.rahat_encode($product['stock_id']).'\')"><i class="fas fa-eye"></i></div></div>
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