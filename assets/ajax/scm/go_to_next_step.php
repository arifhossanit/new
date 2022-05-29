<?php
include("../../../application/config/ajax_config.php");
$html = '<div class="card-header">
            <p style="font-weight: bold;font-size: 25px;">Ordering For:</p>
            </div>
            <div class="card-body">
            <div class="row justify-content-left mb-3" style="margin-left: 0px;margin-right: 0px;">
                <div class="col-md-8">
                    <select class="form-control select2" name="warehouse" id="warehouse" required>
                        <option value="">Select Warehouse</option>';
$warehouses = $mysqli->query("SELECT `name` , `id` from scm_warehouses where `status` = 1");
while($warehouse = mysqli_fetch_assoc($warehouses)){
    $html .=        '<option value="'.$warehouse['id'].'">'.$warehouse['name'].'</option>';
}
$html .=            '</select>
                </div>
            </div>
            <div class="row justify-content-left" style="margin-left: 0px;margin-right: 0px;">
                <div class="col-sm-xs text-center">
                    <div class="form-check">
                        <input name="bypass_warehouse" id="bypass_warehouse" class="form-check-input regular-checkbox" type="checkbox" value="bypass-warehouse" id="flexCheckChecked" onchange="bypass_warehouse_div()">
                    </div>
                </div>
                <div class="col-sm-2">
                    <p for="bypass_warehouse">Bypass Warehouse</p>
                </div>
            </div>
            <div id="bypass_data"></div>
        </div>';
$button =   '<button type="button" class="btn btn-success" style="float: left;margin-left: 15px;" onclick="goToPreviousStep()"><span class="mr-1"><i class="fas fa-arrow-left"></i></span>Go to Previous Step</button>
            <button class="btn btn-success" style="float: right;margin-right: 15px;"><span class="mr-1"><i class="fas fa-check"></i></span>Confirm Purchase</button>';
$data = array(
    'html' => $html,
    'button' => $button,
    'action' => $home.'admin/scm/confirm-product-pre-purchase'
);
echo json_encode($data);