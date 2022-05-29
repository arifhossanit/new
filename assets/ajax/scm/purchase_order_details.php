<?php
include("../../../application/config/ajax_config.php");
$purchase_order = $_POST['purchase_order'];
$purchase_order_information = mysqli_fetch_assoc($mysqli->query("SELECT scm_vendor.email, scm_vendor.company_name, scm_vendor.contact_number, scm_vendor.address, scm_purchase_order.* from scm_purchase_order INNER JOIN scm_vendor on scm_vendor.id = scm_purchase_order.vendor_id where scm_purchase_order.purchase_order_id = '".$purchase_order."'"));
$order_date = date("d-m-Y", strtotime($purchase_order_information['order_date']));  
$html = '<div class="row justify-content-between">
            <div class="col-print-12 text-center"> <p style="font-size: 25px;text-decoration: underline;font-weight: 700;">PURCHASE ORDER</p> </div>
            <div class="col-print-4">
                <div class="row">
                    <div class="col-print-12">
                        <p style="font-size: 15px;text-decoration: underline;font-weight: 700;margin-bottom: 0px;">Vendor Name & Address</p>
                        <p style="font-size: 18px;font-weight: 700;margin-bottom: 0px;">'.$purchase_order_information['company_name'].'</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">'.$purchase_order_information['address'].'</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">Cell: '.$purchase_order_information['contact_number'].'</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">Email: '.$purchase_order_information['email'].'</p>
                    </div>
                </div>
            </div>
            <div class="col-print-3">
                <div class="row" style="border: 1px solid gray;padding: 5px">
                    <div class="col-print-12">
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;">PO# '.$purchase_order_information['purchase_order_id'].'</p>
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;">PO Date: '.$order_date.'</p>
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;">'.$purchase_order_information['company_name'].'</p>
                    </div>
                </div>
            </div>
            </div>
            <div class="row justify-content-between mt-3">
            <div class="col-print-3">
                <div class="row">
                    <div class="col-print-12">
                        <p style="font-size: 15px;text-decoration: underline;font-weight: 700;margin-bottom: 0px;">Bill To</p>
                        <p style="font-size: 18px;font-weight: 700;margin-bottom: 0px;">Neways</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">Address</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">Address</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">Address</p>
                    </div>
                </div>
            </div>
            <div class="col-print-3">
                <div class="row">
                    <div class="col-print-12">
                        <p style="font-size: 15px;text-decoration: underline;font-weight: 700;margin-bottom: 0px;">Bill To</p>
                        <p style="font-size: 18px;font-weight: 700;margin-bottom: 0px;">Neways</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">Address</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">Address</p>
                        <p style="font-size: 16px;font-weight: 500;margin-bottom: 0px;">Address</p>
                    </div>
                </div>
            </div>
            </div>
            <div class="row justify-content-between mt-3">
            <div class="col-print-12">
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <th>Sl</th>
                        <th style="width: 50%;">Item Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </thead>
                    <tbody>';
$order_details = $mysqli->query("SELECT scm_scales.name as scale_name, scm_brands.name as brand_name, scm_products.*, scm_product_order_details.approved_amount, scm_product_order_details.color, scm_product_order_details.product_size, scm_product_order_details.id as purchase_id, scm_product_order_details.purchase_order_id, scm_product_order_details.unit_price from scm_product_order_details INNER JOIN scm_products on scm_products.id = scm_product_order_details.product_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id where purchase_order_id = '".$purchase_order."'");
$i = 1;
$total_amount = 0;
while($order_detail = mysqli_fetch_assoc($order_details)){
    $html .= '  <tr>';
    if($i <= 9){
        $html .=       "<td>0$i</td>";
    }else{
        $html .=       "<td>$i</td>";
    }
    $product_name = ((is_null($order_detail['brand_name'])) ? '' : $order_detail['brand_name'].' - ').$order_detail['product_name'];
    $specification = '';
    $has_specification = $mysqli->query("SELECT * FROM `scm_has_product_specification` where product_category_id = ".$order_detail['product_category_id']);
    if($has_specification->num_rows != 0){
        $html .= '<div class="col-md-3" style="border-right: 1px solid gray;">';
        $specifications = $mysqli->query("SELECT scm_product_extra_specification.name as specification_name, scm_product_specification.name as specification FROM `scm_product_order_specification` INNER JOIN scm_product_specification on scm_product_specification.id = scm_product_order_specification.scm_product_specification_id INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where scm_product_order_pk = ".$order_detail['purchase_id']);
        if($specifications->num_rows != 0){
            $specification .= '<p class="m-0">';
            $specification_tmp = '';
            while($specification_row = mysqli_fetch_assoc($specifications)){
                $specification_tmp .= $specification_row['specification_name'].' - '.$specification_row['specification'].', ';
            }
            $specification .= rtrim($specification_tmp, ', ').'</p>';
        }        
    }
    if($order_detail['color'] != 0){
        $get_color = mysqli_fetch_assoc($mysqli->query("SELECT color from scm_product_color where id = ".$order_detail['color']));
        $specification .= '<p class="m-0">Color: '.$get_color['color'].'</p>';
    }
    if($order_detail['product_size'] != 0){
        $get_size = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_measurement where id = ".$order_detail['product_size']));
        $specification .= '<p class="m-0">Size: '.$get_size['width'].( ($get_size['height'] == 0) ? '' : ' x '.$get_size['height'] ).' '.$get_size['unit'].'</p>';
    }
    $html .=       "<td><div>$product_name</div><div class='m-0 text-secondary'>$specification</div></td>";    
    $amount = $order_detail['unit_price'] * $order_detail['approved_amount'];
    $total_amount += $amount;
    $html .=        '<td>'.$order_detail['approved_amount'].' <small class="text-secondary">'.$order_detail['scale_name'].'</td>
                    <td>'.money($order_detail['unit_price']).'</td>
                    <td>'.money($amount).'</td>
                </tr>';
    $i++;
}
$html .= '<tr>
            <td colspan="4"><p style="float: right; margin-bottom: 0px;">total</p></td>
            <td>'.money($total_amount).'</td>
          </tr>';
$html .=           '</tbody>
                </table>
            </div>
            </div>
            <div class="row justify-content-between mt-3">
            <div class="col-print-12">
                Terms & Condition
            </div>
            </div>
            <div class="row justify-content-between mt-3">
            <div class="col-print-2">
                <p class="mb-0">Prepared by</p>
                <p class="mb-0" style="margin-top: 45px;">____________</p>
                <p class="mb-0">Ibrahim Khalil</p>
                <p class="mb-0">In-charge IT</p>
            </div>
            <div class="col-print-2">
                <p class="mb-0">Checked by</p>
                <p class="mb-0" style="margin-top: 45px;">____________</p>
                <p class="mb-0">Ibrahim Khalil</p>
                <p class="mb-0">In-charge IT</p>
            </div>
            <div class="col-print-2">
                <p class="mb-0">Confirm by</p>
                <p class="mb-0" style="margin-top: 45px;">____________</p>
                <p class="mb-0">Ibrahim Khalil</p>
                <p class="mb-0">In-charge IT</p>
            </div>
            <div class="col-print-2">
                <p class="mb-0">Approved by</p>
                <p class="mb-0" style="margin-top: 45px;">____________</p>
                <p class="mb-0">Ibrahim Khalil</p>
                <p class="mb-0">In-charge IT</p>
            </div>
        </div>';
echo $html;