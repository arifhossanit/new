<?php
include("../../../application/config/ajax_config.php");
$html = '<div class="row">
            <div class="col-md-3">
                <p style="font-size: 22px;"><span class="text-secondary">Service: </span><span>'.$_POST['name'].'</span></p>
            </div>
            <div class="col-md-3">
                <p style="font-size: 22px;"><span class="text-secondary">Vendor: </span><span>'.$_POST['company'].'</span></p>
            </div>
        </div>
        <table id="billing_history_table" class="display table table-sm table-bordered table table-striped table-hover" style="width:100%;font-size: 16px;white-space: nowrap;">
            <thead>
                <tr>
                    <td>Bill Creation Date</td>
                    <td>Month</td>
                    <td>Billing Date</td>
                    <td>Amount</td>
                    <td>Document</td>
                    <td>Status</td>
                    <td>Accounts Approval Date</td>
                </tr>
            </thead>
        </table>';
$data = "?history_of=".$_POST['history_of'];
$info = array(
    'html' => $html,
    'data' => $data,
);
echo json_encode($info);