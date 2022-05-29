<?php
include("../../../application/config/ajax_config.php");
$html = '';
if($_POST['type'] == 'Branch'){
    $branches = $mysqli->query("SELECT branch_id, branch_name from branches where status = 1");
    $html = '<div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control select2" name="branch">
                            <option value="">Select Branch</option>';
    while($branch = mysqli_fetch_assoc($branches)){
        $html .= '<option value="'.rahat_encode($branch['branch_id']).'">'.$branch['branch_name'].'</option>';
    }
    $html .=           '</select>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="type_id" placeholder="Enter Proper Room Number">
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="note" placeholder="Note..">
                    </div>
                    <div class="col-md-1">
                        <input class="btn btn-success" type="submit" name="save_branch" value="Send">
                    </div>
                </div>
            </div>';
}else if($_POST['type'] == 'Employee'){
    $departments = $mysqli->query("SELECT department_id, department_name from department where status = 1");
    $html = '<div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control select2" name="department" onchange="get_employee(this.value)">
                            <option value="">Select Department</option>';
    while($department = mysqli_fetch_assoc($departments)){
        $html .= '<option value="'.rahat_encode($department['department_id']).'">'.$department['department_name'].'</option>';
    }
    $html .=           '</select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control select2" name="employee_id" id="employee_id">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="note" placeholder="Note..">
                    </div>
                    <div class="col-md-1">
                        <input class="btn btn-success" type="submit" name="save_employee" value="Send">
                    </div>
                </div>
            </div>';
}else if($_POST['type'] == 'Damaged'){
    $warehouses = $mysqli->query("SELECT `name`, id from scm_warehouses where status = 1");
    $html = '<div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control select2" name="warehouse" onchange="get_employee(this.value)">
                            <option value="">Select Warehouse</option>';
    while($warehouse = mysqli_fetch_assoc($warehouses)){
        $html .= '<option value="'.$warehouse['id'].'">'.$warehouse['name'].'</option>';
    }
    $html .=           '</select>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="note" placeholder="Note..">
                    </div>
                    <div class="col-md-1">
                        <input class="btn btn-success" type="submit" name="save_damaged" value="Send">
                    </div>
                </div>
            </div>';
}else if($_POST['type'] == 'Stolen'){
    $html = '<div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="note" placeholder="Note..">
                    </div>
                    <div class="col-md-1">
                        <input class="btn btn-success" type="submit" name="save_damaged" value="Send">
                    </div>
                </div>
            </div>';
}else if($_POST['type'] == 'storage_branch'){
    $branches = $mysqli->query("SELECT branch_id, branch_name from branches where status = 1");
    $html = '<div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control select2" name="branch">
                            <option value="">Select Branch</option>';
    while($branch = mysqli_fetch_assoc($branches)){
        $html .= '<option value="'.rahat_encode($branch['branch_id']).'">'.$branch['branch_name'].'</option>';
    }
    $html .=           '</select>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="note" placeholder="Note..">
                    </div>
                    <div class="col-md-1">
                        <input class="btn btn-success" type="submit" name="save_damaged" value="Send">
                    </div>
                </div>
            </div>';
}
echo $html;