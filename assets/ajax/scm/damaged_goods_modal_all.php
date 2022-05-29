<?php
include("../../../application/config/ajax_config.php");
$html = '<label for="warehouse">Warehouse to store</label>
        <select class="form-control select2" id="warehouse" name="warehouse" required style="width: 50% !important  ">
            <option value="">Select Warehouse</option>';
$warehosues = $mysqli->query("SELECT * FROM `scm_warehouses`");
while($warehouse = mysqli_fetch_assoc($warehosues)){
    $html .= '<option value="'.$warehouse['id'].'">'.$warehouse['name'].'</option>';
}
$html .= '</select>';
$html .= '<input type="hidden" name="amount" id="amount" value="'.$_POST['amount'].'">';
if($_POST['type'] == 'repair_outside'){
    $html .= '<div class="row">
            <div class="col-md-6">
            <label class="mt-4" for="vendor">Vendor</label>
            <select class="form-control select2" id="vendor" name="vendor" required>
                <option value="">Select Vendor</option>';
    $vendors = $mysqli->query("SELECT * FROM `scm_vendor`");
    while($vendor = mysqli_fetch_assoc($vendors)){
        $html .= '<option value="'.$vendor['id'].'">'.$vendor['company_name'].'</option>';
    }
    $html .= '</select>
            </div>';
    $html .= '<div class="col-md-6"><label class="mt-4" for="price">Price</label><input class="form-control" type="number" step="any" name="price" id="price" placeholder="Enter Repair Cost"></div>';
}
$button = '<button type="submit" class="btn btn-info btn-sm">Save</button>';
$info = array(
    'html' => $html,
    'button' => $button,
);
echo json_encode($info);
