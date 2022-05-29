<?php
include("../../../application/config/ajax_config.php");
$html = '<div class="form-group">
            <div class="row">';
if($_POST['type'] == 'monthly'){
    $html .= '<div class="col-md-12"><p id="error_text" class="text-danger"></p></div>
            <div class="col-sm-4">
                <select name="month" id="month" class="form-control" required>
                    <option value=""> Select month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>';
}                
$html .=        '<div class="col-sm-4">
                    <select name="year" id="year" class="form-control" required>';
                        $year = (int)date('Y') - 1;
                        for($i = 1; $i <= 5; $i++){
                            if($i == 2){
                                $html .= "<option selected>$year</option>";
                            }else{
                                $html .= "<option>$year</option>";
                            }
                            $year += 1;
                        }
$html .=            '</select>
                </div>
                <div class="col-sm-4">
                    <input type="number" name="amount" id="amount" class="form-control" step="any" placeholder="Enter Amount" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <input type="file" name="document" id="document" class="form-control-file" required>
                </div>
                <div class="col-sm-8">
                    <textarea class="form-control" name="note" id="note" cols="30" rows="2" placeholder="Note"></textarea>
                </div>
            </div>
        </div>';
$info = array(
    'html' => $html,
    'button' => '<button type="submit" class="btn btn-primary" id="submit_button">Submit</button>'
);
echo json_encode($info);