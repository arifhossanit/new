<?php
$utime = sprintf('%.4f', microtime(TRUE)); 
    $raw_time = DateTime::createFromFormat('U.u', $utime);  
    $raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
    $today = $raw_time->format('dmy-his-u');
    if(!empty($_POST['branch_code'])){
        $bc = $_POST['branch_code'];
    }else{
        $bc = '';
        echo "<script>window.open('".$home."admin/','_top')</script>";
    }
    $transaction_id = $bc.'-'.$today;
    $expense_types = $mysqli->query("SELECT * from expense_type");
    $html = '<div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Urgent Transaction (Buy Something)</h3>
                </div>
                <div class="card-body">
                    <form action="'.$home . ('admin/profile/urgent-expense').'" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="employee_id" value="'.$_SESSION['user_info']['employee_id'].'"/>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Transaction ID:</label>	
                                    <input type="text" id="transaction_id" name="transaction_id" class="form-control" value="'.$transaction_id.'" placeholder="Id Number" readonly/>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <span id="error_message" style="color:#f00;font-weight:bolder;float: right;"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!--------------------------------------->								
                                <div class="row">
                                    <div class="col-sm-12">
                                        <style>.item_table td{padding:4px;}</style>
                                        <table id="transaction_table" class="table table-bordered table-hover item_table">
                                            <thead>
                                                <tr>
                                                    <th width="2%"><input id="check_all" class="formcontrol" type="checkbox" style="transform: scale(1.3);"/></th>
                                                    <th width="15%">Item Name</th>
                                                    <th width="23%">Buying Purpose</th>
                                                    <th width="15%">Price</th>
                                                    <th width="15%">Quantity</th>
                                                    <th width="15%">Sub total</th>
                                                    <th width="15%">Attachment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input class="case" type="checkbox" style="transform: scale(1.3); margin-left: 8px; margin-top: 13px;"/></td>
                                                    <td><input type="text" data-type="productCode" name="item_name[]" id="ipro_1" class="form-control autocomplete_txt" autocomplete="off" required /></td>
                                                    <td>
                                                    <select class="form-control select2" name="expense_tpye[]" data-select2-id="3">
                                                    <option>Select Expense</option>';
    foreach($expense_types as $expense_type){
        $expense_sub_types = $mysqli->query("SELECT * from expense_sub_type where expense_type_id = ".$expense_type['id']);
        if($expense_sub_types->num_rows != 0){
            while($expense_sub_type = mysqli_fetch_assoc($expense_sub_types)){
                $html .= '<option value="'.$expense_type['id'].'|'.$expense_sub_type['id'].'">'.$expense_type['head_name'] . ' - '. $expense_sub_type['head_name'] .'</option>';
            }
        }else{
            $html .= '<option value="'.$expense_type['id'].'">'.$expense_type['head_name'].'</option>';
        }
    }
    $html .=                                        '</select></td>
                                                    <td><input type="text" name="item_price[]" id="price_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" step="any" ondrop="return false;" onpaste="return false;" required /></td>
                                                    <td><input type="text" name="ite_qty[]" id="quantity_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>
                                                    <td><input type="text" name="total_item_amount[]" id="total_1" class="form-control totalLinePrice" style="color:green;font-weight:bolder;font-size: 18px;" readonly /></td>
                                                    <td><input type="file" name="attachment[]" class="form-control" style="padding-top:3px;" required /></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <button class="btn btn-danger delete" type="button" onclick="remove_row()">- Delete</button>
                                                <button class="btn btn-success addmore" type="button" onclick="add_row()">+ Add More</button>
                                            </div>
                                            
                                            <div class="col-sm-6">						
                                                <input id="total_amount" type="hidden" name="total_amount" value="<?php echo $balance; ?>"/>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">														
                                                    <input name="total_subtotal" type="number" class="form-control" id="subTotal" placeholder="Total" style="color:#f00;font-weight:bolder;font-size: 25px;" readonly>
                                                </div>
                                            </div>
                                        </div>												
                                    </div>												
                                </div>													
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="extra_note" class="form-control" placeholder="Extra Note" style="height:120px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--------------------------------------->
                            </div>												
                        </div>													
                        <div class="form-group" style="margin-top:20px;">
                            <button type="submit" name="save" class="btn btn-lg btn-success" style="width:100% !important;">
                                <i class="far fa-save"></i>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>';

echo $html;