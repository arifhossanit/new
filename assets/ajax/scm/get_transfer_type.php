<?php
include("../../../application/config/ajax_config.php");
$html = '';
if($_POST['type'] == 'to_branch'){
    $branches = $mysqli->query("SELECT branch_id, branch_name from branches where status = 1");
    $html = '<input type="hidden" name="type_id" value="'.$_POST['type_id'].'">
            <fieldset style="border: 1px solid gray; border-radius: 5px;padding: 10px">
            <legend style="width:auto; margin-bottom: 0px; margin-left: 5px; padding-left: 5px; padding-right: 5px; font-size: 15px; font-weight: bold; color: #1f497d;">Branch Details</legend>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control select2" name="branch" id="recipient_type">
                            <option value="">Select Branch</option>';
    while($branch = mysqli_fetch_assoc($branches)){
        $html .= '<option value="'.rahat_encode($branch['branch_id']).'">'.$branch['branch_name'].'</option>';
    }
    $html .=           '</select>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="type_id" placeholder="Enter Proper Room Number">
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-12">';
                    if($_POST['type_id'] == '3'){
                        $html .= '<label class="mt-2">Select Products to Transfer:</label>
                                  <div class="row">';
                        $barcodes = $mysqli->query("SELECT * from scm_product_barcode where id_table_name = 'scm_product_requisition_uses' AND product_id = ".$_POST['use_id']);
                        $i = 0;
                        while($barcode = mysqli_fetch_assoc($barcodes)){
                            $html .= '<div class="col-sm-3">
                                        <input name="product_to_add[]" class="regular-checkbox" type="checkbox" value="'.$barcode['id'].'" id="product_add_'.$i.'">
                                        <label style="font-size: 20px;" class="form-check-label" for="product_add_'.$i.'"> '.$barcode['barcode'].' </label>
                                      </div>';
                            $i++;
                        }
                        $html .= '</div>';
                        
                    }else{
                        $html .= '<input class="form-control mt-3" type="number" name="amount" placeholder="Amount to Transfer" step="any" min="0" max="'.$_POST['amount'].'" required>';
                    }
    $html .=        '</div>
                </div>
            </div>
            </fieldset>
            <textarea class="form-control mt-3" name="note" rows="1" placeholder="Note"></textarea>';
}else if($_POST['type'] == 'to_employee'){
    $departments = $mysqli->query("SELECT department_id, department_name from department where status = 1");
    $html = '<input type="hidden" name="type_id" value="'.$_POST['type_id'].'">
            <fieldset style="border: 1px solid gray; border-radius: 5px;padding: 10px">
            <legend style="width:auto; margin-bottom: 0px; margin-left: 5px; padding-left: 5px; padding-right: 5px; font-size: 15px; font-weight: bold; color: #1f497d;">Employee Details</legend>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control select2" name="department" id="recipient_type" onchange="get_employee(this.value)">
                            <option value="">Select Department</option>';
    while($department = mysqli_fetch_assoc($departments)){
        $html .= '<option value="'.rahat_encode($department['department_id']).'">'.$department['department_name'].'</option>';
    }
    $html .=           '</select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control select2" name="employee_id" id="employee_id">
                            <option>Select Department First</option>
                        </select>
                    </div>                    
                    <div class="col-md-4"></div>
                    <div class="col-md-12">';
                    if($_POST['type_id'] == '3'){
                        $html .= '<label class="mt-2">Select Products to Transfer:</label>
                                  <div class="row">';
                        $barcodes = $mysqli->query("SELECT * from scm_product_barcode where id_table_name = 'scm_product_requisition_uses' AND product_id = ".$_POST['use_id']);
                        $i = 0;
                        while($barcode = mysqli_fetch_assoc($barcodes)){
                            $html .= '<div class="col-sm-3">
                                        <input name="product_to_add[]" class="regular-checkbox" type="checkbox" value="'.$barcode['id'].'" id="product_add_'.$i.'">
                                        <label style="font-size: 20px;" class="form-check-label" for="product_add_'.$i.'"> '.$barcode['barcode'].' </label>
                                      </div>';
                            $i++;
                        }
                        $html .= '</div>';
                        
                    }else{
                        $html .= '<input class="form-control mt-3" type="number" name="amount" placeholder="Amount to Transfer" step="any" min="0" max="'.$_POST['amount'].'" required>';
                    }
    $html .=        '</div>
                </div>
            </div>
            </fieldset>
            <textarea class="form-control mt-3" name="note" rows="1" placeholder="Note"></textarea>';
}else if($_POST['type'] == 'to_department'){
    $branches = $mysqli->query("SELECT branch_id, branch_name from branches where status = 1");
    $html = '<input type="hidden" name="type_id" value="'.$_POST['type_id'].'">
            <fieldset style="border: 1px solid gray; border-radius: 5px;padding: 10px">
            <legend style="width:auto; margin-bottom: 0px; margin-left: 5px; padding-left: 5px; padding-right: 5px; font-size: 15px; font-weight: bold; color: #1f497d;">Department Branch Details</legend>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5">
                        <select class="form-control select2" name="branch" id="recipient_type">
                            <option value="">Select Branch</option>';
    while($branch = mysqli_fetch_assoc($branches)){
        $html .= '<option value="'.rahat_encode($branch['branch_id']).'">'.$branch['branch_name'].'</option>';
    }
    $html .=           '</select>
                    </div>                   
                    <div class="col-md-7"></div>
                    <div class="col-md-12">';
                    if($_POST['type_id'] == '3'){
                        $html .= '<label class="mt-2">Select Products to Transfer:</label>
                                  <div class="row">';
                        $barcodes = $mysqli->query("SELECT * from scm_product_barcode where id_table_name = 'scm_product_requisition_uses' AND product_id = ".$_POST['use_id']);
                        $i = 0;
                        while($barcode = mysqli_fetch_assoc($barcodes)){
                            $html .= '<div class="col-sm-3">
                                        <input name="product_to_add[]" class="regular-checkbox" type="checkbox" value="'.$barcode['id'].'" id="product_add_'.$i.'">
                                        <label style="font-size: 20px;" class="form-check-label" for="product_add_'.$i.'"> '.$barcode['barcode'].' </label>
                                      </div>';
                            $i++;
                        }
                        $html .= '</div>';
                        
                    }else{
                        $html .= '<input class="form-control mt-3" type="number" name="amount" placeholder="Amount to Transfer" step="any" min="0" max="'.$_POST['amount'].'" required>';
                    }
    $html .=        '</div>
                </div>
            </div>
            </fieldset>
            <textarea class="form-control mt-3" name="note" rows="1" placeholder="Note"></textarea>';
}else if($_POST['type'] == 'to_damaged'){
    $branches = $mysqli->query("SELECT branch_id, branch_name from branches where status = 1");
    $html = '<input type="hidden" name="type_id" value="'.$_POST['type_id'].'">
            <fieldset style="border: 1px solid gray; border-radius: 5px;padding: 10px">
            <legend style="width:auto; margin-bottom: 0px; margin-left: 5px; padding-left: 5px; padding-right: 5px; font-size: 15px; font-weight: bold; color: #1f497d;">Department Branch Details</legend>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">';
                    if($_POST['type_id'] == '3'){
                        $html .= '<label class="mt-2">Select Products to Transfer:</label>
                                  <div class="row">';
                        $barcodes = $mysqli->query("SELECT * from scm_product_barcode where id_table_name = 'scm_product_requisition_uses' AND product_id = ".$_POST['use_id']);
                        $i = 0;
                        while($barcode = mysqli_fetch_assoc($barcodes)){
                            $html .= '<div class="col-sm-3">
                                        <input name="product_to_add[]" class="regular-checkbox" type="checkbox" value="'.$barcode['id'].'" id="product_add_'.$i.'">
                                        <label style="font-size: 20px;" class="form-check-label" for="product_add_'.$i.'"> '.$barcode['barcode'].' </label>
                                      </div>';
                            $i++;
                        }
                        $html .= '</div>';
                        
                    }else{
                        $html .= '<input class="form-control mt-3" type="number" name="amount" placeholder="Amount to Transfer" step="any" min="0" max="'.$_POST['amount'].'" required>';
                    }
    $html .=        '</div>
                </div>
            </div>
            </fieldset>
            <textarea class="form-control mt-3" name="note" rows="1" placeholder="Note"></textarea>';
}
$info = array(
    'html' => $html,
    'button' => '<button class="btn btn-success btn-sm" >Send</button>',
);
echo json_encode($info);