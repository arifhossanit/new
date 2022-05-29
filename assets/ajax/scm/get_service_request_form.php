<?php
include("../../../application/config/ajax_config.php");
$branches = mysqli_fetch_all($mysqli->query("SELECT branch_name from branches where status = 1"));
if(strtolower($_POST['form_type']) == 'hourly'){
    $html = '<div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>From</label>
                        <select onchange="from_other_function(this.value)" name="destination_from" class="form-control select2" required="required">
                            <option value="">From</option>';
                            foreach($branches as $row){
                                $html .= '<option>'.$row[0].'</option>';
                            }
    $html .=                '<option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group" id="other_from" style="display:none;">
                        <input type="text" class="form-control" name="from_other" id="from_other" placeholder="Specify where from">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>To</label>
                        <select onchange="to_other_function(this.value)" name="destination_to" class="form-control select2" required="required">
                            <option value="">To</option>';
                            foreach($branches as $row){
                                $html .= '<option>'.$row[0].'</option>';
                            }
    $html .=                '<option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group" id="other_to" style="display:none;">
                        <input type="text" class="form-control" name="to_other" id="to_other" placeholder="Specify where to">
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <label for="from_time">Time from</label>
                    <input type="time" class="form-control" name="from_time" id="from_time" min="'.date('H:i').'">
                </div>
                <div class="col-md-3 col-6">
                    <label for="requisition_duration">Duration (Hours)</label>
                    <input type="number" class="form-control" name="requisition_duration" id="requisition_duration" step="any" placeholder="in Hours">
                </div>
                <div class="col-md-6 col-12 mt-2">
                    <textarea style="height: 100%;" class="form-control" name="note" id="note" cols="30" placeholder="Specify requisition purpose."></textarea>
                </div>
            </div>';
}
echo $html;