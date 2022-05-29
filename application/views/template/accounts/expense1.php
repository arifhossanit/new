
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" id="form_body">
                        <form action="" method="post" >
                            <table id="transaction_table" class="table table-bordered table-hover item_table">
                                <thead>
                                    <tr>
                                        <th width="2%"><input id="check_all" class="formcontrol" type="checkbox" style="transform: scale(1.3);"/></th>
                                        <th width="11%">Date</th>
                                        <th width="12%">Vendor</th>
                                        <th width="12%">Item Name</th>
                                        <th width="10%">Price</th>
                                        <th width="10%">Quantity</th>
                                        <th width="10%">Sub total</th>
                                        <th width="6%">Ref#</th>
                                        <th width="12%">Attachment</th>
                                        <th width="12%">Branch</th>
                                    </tr>
                                </thead>
                                <tbody id="bulk_form">
                                </tbody>
                                
                            </table>
                            <div class="row">
                                <div class="col-sm-9">
                                    <button class="btn btn-secondary delete" type="button" onclick="remove_row()">- Delete</button>
                                    <button class="btn btn-primary addmore" type="button" onclick="add_row()">+ Add More</button>
                                </div>
                                <div class="col-sm-3">
                                    <input name="total_subtotal" type="number" class="form-control" id="subTotal" placeholder="Total" style="color:#f00;font-weight:bolder;font-size: 25px;" readonly>
                                </div>
                            </div>
                            
                            <div class="">
                                <div class="row mt-5">
                                    <div class="col-sm-12">
                                        <h4 style="text-decoration:underline;">
                                            Payment Information										
                                            <div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
                                                <button type="button" id='removeButton_payment' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
                                                <button type="button" id='addButton_payment' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
                                            </div>
                                            <div id="due_result_amount_booking" class="row d-flex" style="float:right;padding-right: 26px; color: #f00; margin-top: -4px;font-size: 20px;"> </div>
                                        </h4>
                                        <span style="color:red;font-weight:bolder;" id="document_error_message"></span>
                                    </div>
                                </div>
                                <div id='UnitBoxesGroup_payment'>
                                    <div id="UnitBoxDiv_payment1">
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <select onchange="return payment_function_on_change()" id="payment_method1" name="payment_method[]" class="form-control">
                                                        <option value="">select payment method</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Mobile Banking">Mobile / Online Booking</option>
                                                        <option value="Credit / Debit Card">Credit / Debit Card</option>
                                                        <option value="Check">Cheque</option>										
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">								
                                                <div class="row" id="mobile_banking1" style="display:none;">
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <select id="agent1" name="agent[]" class="form-control">
                                                                <option value="">select agent</option>
                                                                <option value="Bikash">bKash</option>
                                                                <option value="Rocket">Rocket</option>
                                                                <option value="Nogod">Nogod</option>														
                                                                <option value="Airbnb">Airbnb</option>
                                                                <option value="Booking.com">Booking.com</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="mobile_banking_number1" name="mobile_banking_number[]" placeholder="Banking Number" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="transaction_id1" name="transaction_id[]" placeholder="TrxID / Confirmation ID" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="mobile_amount1" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="number_int form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row" id="check_number1" style="display:none;">
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="bank_name1" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="check_number1" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="date" id="withdraw_date1" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="check_amount1" name="check_amount[]" placeholder="Amount" autocomplete="off" class="number_int form-control"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="credit_card1" style="display:none;">
                                                    <div class="col-sm-6">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="credit_card_number1" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="card_secret1" name="card_secret[]" value="0"/>

                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="Expiry_Date1" onkeyup="return card_payment_calculator()" name="Expiry_Date[]" placeholder="Amount" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="card_amount1" name="card_amount[]" id="card_result1" placeholder="Amount" autocomplete="off" class="number_int form-control" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="cash1" style="display:none;">
                                                    <div class="col-sm-9">
                                                        <div class="form-group" style="width:100%;">
                                                            <textarea id="cash_other_information_remarks1" name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>											
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="cash_amount1" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="number_int form-control" />
                                                        </div>
                                                    </div>
                                                </div>							
                                                
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>