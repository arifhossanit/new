<?php
include("../../../application/config/ajax_config.php");
$get_requisition_types = mysqli_fetch_all($mysqli->query("SELECT scm_service_product_details.description, scm_service_product_details.requisition_type, scm_product_category.name, scm_service_product_details.id from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id where scm_service_product_details.product_type_id = ".$_POST['requisition_for']));
// var_dump($branches);
// exit();
$html = '<div class="row">
                <div class="col-md-5 col-8">
                    <div class="form-group">
                        <label>Select '.$get_requisition_types[0][2].'</label>
                        <select onchange="get_service_request_form(this)" name="requesting_product" class="form-control select2" required="required">
                            <option data-formtype="" value=""> -- '.$get_requisition_types[0][2].' -- </option>';
            foreach($get_requisition_types as $get_requisition_type){    
                $html .= '<option data-formtype="'.$get_requisition_type[1].'" value="'.$get_requisition_type[3].'">'.$get_requisition_type[2].' - '.$get_requisition_type[0].'</option>';    
            }
$html .=           '</select>
                    </div>
                </div>
            </div>
            <div id="requisition_form"></div>';
echo $html;