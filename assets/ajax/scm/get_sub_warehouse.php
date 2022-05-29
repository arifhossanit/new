<?php
include("../../../application/config/ajax_config.php");
$html =  '<div class="row justify-content-left mt-3 mb-2" style="margin-left: 0px;margin-right: 0px;">
            <div class="col-md-6">
                <select class="form-control select2" name="branch" id="branch" required>
                    <option value="">Select Branch</option>';
$branches = $mysqli->query("SELECT branch_name , branch_id from branches where `status` = 1");
while($branch = mysqli_fetch_assoc($branches)){
    $html .=        '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
}
$html .=        '</select>
            </div>';
$html .=  '<div class="col-md-6">
                <select class="form-control select2" name="department" id="department" required>
                    <option value="">Select Department</option>';
$departments = $mysqli->query("SELECT department_name , department_id from department where `status` = 1");
while($department = mysqli_fetch_assoc($departments)){
    $html .=        '<option value="'.$department['department_id'].'">'.$department['department_name'].'</option>';
}
$html .=        '</select>
            </div>
        </div>';
echo $html;
