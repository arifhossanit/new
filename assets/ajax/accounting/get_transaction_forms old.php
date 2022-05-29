<?php
include("../../../application/config/ajax_config.php");
if($_POST['type'] == 'return_money'){
    $html = '<div class="card">
                <form id="return_advance_money_form" action="'.$home . ('admin/profile/urgent-expense').'" method="post">
                    <div class="modal-header btn-info">
                        <h4 class="modal-title">Return Advance Money</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                    <div class="modal-body" id="return_advance_money_result">
                        <input type="hidden" name="employee_id" value="'.$_POST['employee_id'].'"/>
                        <input type="hidden" name="return_money_form_token" value="<?php echo md5(time() * rand()); ?>"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Amount Of Return Money</label>
                                    <input value='.$_POST['balance'].' type="text" name="amount_of_money" placeholder="Amount Of Money" class="form-control number_int" required />
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea name="note" class="form-control" placeholder="Note"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger " style="float:left;" data-dismiss="modal" aria-label="Close">Close</button>
                                    <button type="submit" id="finish_booking" class="btn btn-success" style="float:right;">Send Return Request</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>';
}else{
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
                                                    <td><input type="text" data-type="productName" name="purpose[]" id="ides_1" class="form-control autocomplete_txt" autocomplete="off" required /></td>
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
}
echo $html;