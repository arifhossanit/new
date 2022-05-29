<?php
include("../../../application/config/ajax_config.php");
$units = $mysqli->query("SELECT * from scm_unit");
$unit_html = '<option selected>Choose unit</option>';
while($unit = mysqli_fetch_assoc($units)){
    $unit_html .= '<option>'.$unit['name'].'</option>';
}
$html = '';
if($_POST['product_type'] == 'square' || $_POST['product_type'] == 'rectangle'){
    if($_POST['append'] == 'no'){
        $html ='<label for="">Measurement</label>
                <div class="row">
                    <div class="col-sm-4 col-4">
                        <input type="text" class="form-control" placeholder="Width" name="specification_one[]" required>
                    </div>
                    <div class="col-sm-4 col-4">
                        <input type="text" class="form-control" placeholder="Height" name="specification_two[]" required>
                    </div>
                    <div class="col-sm-4 col-4">
                        <select class="form-control select2" id="specification_unit" name="specification_unit[]" required>
                        '.$unit_html.'
                        </select>
                    </div>
                </div>            
                <div id="measurement_div_extra">
                </div>
                <div class="col-md-12 mt-2" id="measurement_div_extra">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger btn-sm" onclick="remove_product_measurements()"><i class="fas fa-minus"></i></button>
                        <button value="square" type="button" class="btn btn-secondary btn-sm" onclick="get_product_measurements(this.value, \'yes\')"><i class="fas fa-plus"></i></button>
                    </div>
                </div>';
    }else{
        $html ='<div class="row mt-1 extra-measurement">
                    <div class="col-sm-4 col-4">
                        <input type="text" class="form-control" placeholder="Width" name="specification_one[]" required>
                    </div>
                    <div class="col-sm-4 col-4">
                        <input type="text" class="form-control" placeholder="Height" name="specification_two[]" required>
                    </div>
                    <div class="col-sm-4 col-4">
                        <select class="form-control select2" id="specification_unit" name="specification_unit[]" required>
                        '.$unit_html.'
                        </select>
                    </div>
                </div>';
    }
    
}else if($_POST['product_type'] == 'round'){
    if($_POST['append'] == 'no'){
        $html ='<label for="">Measurement</label>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        <input type="text" class="form-control" placeholder="Radius" name="specification_one[]" required>
                    </div>
                    <div class="col-sm-6 col-6">
                        <select class="form-control select2" id="specification_unit" name="specification_unit[]" required>
                        '.$unit_html.'
                        </select>
                    </div>
                </div>
                <div id="measurement_div_extra">
                </div>
                <div class="col-md-12 mt-2" id="measurement_div_extra">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus" onclick="remove_product_measurements()"></i></button>
                        <button value="round" type="button" class="btn btn-secondary btn-sm" onclick="get_product_measurements(this.value, \'yes\')"><i class="fas fa-plus"></i></button>
                    </div>
                </div>';
    }else{
        $html ='<div class="row mt-1 extra-measurement">
                    <div class="col-sm-6 col-6">
                        <input type="text" class="form-control" placeholder="Radius" name="specification_one[]" required>
                    </div>
                    <div class="col-sm-6 col-6">
                        <select class="form-control select2" id="specification_unit" name="specification_unit[]" required>
                        '.$unit_html.'
                        </select>
                    </div>
                </div>';
    }
}else if($_POST['product_type'] == 'liquid' || $_POST['product_type'] == 'mass'){
    if($_POST['append'] == 'no'){
        $html ='<label for="">Measurement</label>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        <input type="text" class="form-control" placeholder="'.( ($_POST['product_type'] == 'liquid') ? 'Volume' : 'Mass' ).'" name="specification_one[]" required>
                    </div>
                    <div class="col-sm-6 col-6">
                        <select class="form-control select2" id="specification_unit" name="specification_unit[]" required>
                        '.$unit_html.'
                        </select>
                    </div>
                </div>
                <div id="measurement_div_extra">
                </div>
                <div class="col-md-12 mt-2" id="measurement_div_extra">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger btn-sm" onclick="remove_product_measurements()"><i class="fas fa-minus"></i></button>
                        <button value="liquid" type="button" class="btn btn-secondary btn-sm" onclick="get_product_measurements(this.value, \'yes\')"><i class="fas fa-plus"></i></button>
                    </div>
                </div>';
    }else{
        $html ='<div class="row mt-1 extra-measurement">
                    <div class="col-sm-6 col-6">
                        <input type="text" class="form-control" placeholder="'.( ($_POST['product_type'] == 'liquid') ? 'Volume' : 'Mass' ).'" name="specification_one[]" required>
                    </div>
                    <div class="col-sm-6 col-6">
                        <select class="form-control select2" id="specification_unit" name="specification_unit[]" required>
                        '.$unit_html.'
                        </select>
                    </div>
                </div>';
    }    
}else if($_POST['product_type'] == 'size'){
    if($_POST['append'] == 'no'){
        $html ='<label for="">Size</label>
            <div class="row">
                <div class="col-sm-12 col-12">
                    <select class="form-control select2" id="specification_unit" name="specification_one[]" required>
                        <option value="">Select Size</option>
                        <option>Small</option>
                        <option>Medium</option>
                        <option>Large</option>
                    </select>
                </div>
                <input type="hidden" name="specification_unit[]" value="">
            </div>
            <div id="measurement_div_extra">
            </div>
            <div class="col-md-12 mt-2" id="measurement_div_extra">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-danger btn-sm" onclick="remove_product_measurements()"><i class="fas fa-minus"></i></button>
                    <button value="size" type="button" class="btn btn-secondary btn-sm" onclick="get_product_measurements(this.value, \'yes\')"><i class="fas fa-plus"></i></button>
                </div>
            </div>';
    }else{
        $html ='<label for="">Size</label>
                <div class="row">
                    <div class="col-sm-12 col-12">
                        <select class="form-control select2" id="specification_unit" name="specification_one[]" required>
                            <option value="">Select Size</option>
                            <option>Small</option>
                            <option>Medium</option>
                            <option>Large</option>
                        </select>
                    </div>
                    <input type="hidden" name="specification_unit[]" value="">
                </div>
                <div id="measurement_div_extra">
                </div>';
    }
}else if($_POST['product_type'] == 'extra_specification'){
    if($_POST['extra_specification'] != ''){
        if($_POST['append'] == 'extra_no'){
            $html ='<label for="">Details</label>
                    <div class="row">
                        <div class="col-sm-6 col-6">
                            <input type="text" class="form-control" placeholder="Name" name="extra_specification_0[]" required>
                        </div>
                        <div class="col-sm-6 col-6">
                            <select class="form-control select2" name="extra_specification_unit[]" required>
                            '.$unit_html.'
                            </select>
                        </div>
                    </div>
                    <div id="extra_measurement_div_extra">
                    </div>
                    <div class="col-md-12 mt-2" id="measurement_div_extra">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-danger btn-sm" onclick="remove_extra_product_measurements()"><i class="fas fa-minus"></i></button>
                            <button value="extra_specification" type="button" class="btn btn-secondary btn-sm" onclick="get_product_measurements(this.value, \'extra\', \'extra_extra\')"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>';
        }else{
            $html ='<div class="row mt-1 extra-extra-measurement">
                        <div class="col-sm-6 col-6">
                            <input type="text" class="form-control" placeholder="Name" name="extra_specification_0[]" required>
                        </div>
                        <div class="col-sm-6 col-6">
                            <select class="form-control select2" name="extra_specification_unit[]" required>
                            '.$unit_html.'
                            </select>
                        </div>
                    </div>';
        }
    }
        
}
echo $html;