
<link href="https://rawgit.com/select2/select2/master/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://rawgit.com/select2/select2/master/dist/js/select2.js"></script>
<style>
/*To remove button from IE11, thank you Matt */
select::-ms-expand {
     display: none;
}

.selectdiv:after {
  content: '+';
  font: 30px "Consolas", monospace;
  color: #333;
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
  right: 20px;
  /*Adjust for position however you want*/
  
  top: 1px;
  padding: 0 0 2px;
  /* border-bottom: 1px solid #999; */
  /*left line */
  
  position: absolute;
  pointer-events: none;
}

.selectdiv select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  /* Add some styling */
}



    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }

/* dropzone */
    .container{
    margin: 0 auto;
    width: 50%;
    }

    .content{
    padding: 5px;
    margin: 0 auto;
    }
    .content span{
    width: 250px;
    }

    .dz-message{
    text-align: center;
    font-size: 28px;
    }

    .content span {
    width: unset;
    }
</style>

<!----End edit product type modal-->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add New Expense</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounts</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Expense</a></li>
						<li class="breadcrumb-item active">Add Expense</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	<div class="toast" data-autohide="true" style="position: fixed; top: 0; right: 0; z-index: 10000;" data-delay="5000">
        <div class="toast-header">
            <strong class="mr-auto text-success">Successfull!</strong>
            <small class="text-muted"><?=date("g:i a");?></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body bg-success">
            You have done successfully!
        </div>
    </div>

	<div class="content">
		<div class="container-flud">
            <div class="mx-5 pb-3">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Record Expense</a>
                        <a class="nav-link" onclick="request_money()" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"></a>
                        <!-- <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a> -->
                    </div>
                </nav>
                <div class="tab-content card p-5 mb-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form action="<?=current_url(); ?>" id="expenseform" method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-1 col-form-label text-danger">Bill Date*</label>
                                <div class="col-sm-3">
                                <input type="date" name="bill_date" class="form-control shadow-sm" id="inputEmail3" required>
                                </div>

                                <!-- <label for="inputPassword3" class="col-sm-1 col-form-label text-danger text-center">Branch*</label>
                                <div class="col-sm-2">
                                    <select name="branch" id="" class="form-control shadow-sm" readonly>
                                        <?php foreach ($branche as $branc): ?>
                                            <option value="<?= $branc->branch_id ?>"><?= $branc->branch_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div> -->

                                <label for="inputPassword3" class="col-sm-1 col-form-label text-danger text-center">Vendor*</label>
                                <div class="col-sm-3">
                                    <div class="d-flex">
                                        <select name="" id="vendorId" class="shadow-sm form-control" required>
                                            <option selected disabled>-- select one --</option>
                                            <?php foreach ($scm_vendors as $vendor): ?>
                                                <option value="<?= $vendor->id ?>"><?= $vendor->company_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="vendor">
                                        <button id="clear" type="button" class="btn text-danger" onclick="Clear()"><i class="fas fa-times"></i></button>
                                    </div>
                                    
                                </div>

                                <label for="inputPassword3" class="col-sm-1 col-form-label text-danger text-center">Item/Service<small>*</small></label>
                                <div class="col-sm-3 selectdiv">
                                    <select name="item" id="itemId" class="form-control shadow-sm itemClass" required>
                                        <option selected disabled>-- select one --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="item-table">
                                <label for="inputPassword3" class="col-sm-1 col-form-label text-danger" style="word-spacing: 0px;">Item Table*</label>
                                <table id="" class="col-sm-11 table table-bordered itemTable">
                                    <thead>
                                        <tr>
                                            <th >Item</th>
                                            <th >Unit price</th>
                                            <th >Unit type </th>
                                            <th >Qty</th>
                                            <th >Total</th>
                                            <th >Discount</th>
                                            <th >Tax</th>
                                            <th >Net Amount</th>
                                            <th >Branch</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item-body">
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-1 col-form-label">Fix Discount</label>
                                <div class="col-sm-3">
                                    <input type="number" id="fixed_discount" name="fixed_discount" class="form-control shadow-sm number_int" oninput="calculate()">
                                </div>

                                <label class="col-sm-1 col-form-label text-center">Fixed Tax</label>
                                <div class="col-sm-3">
                                    <input type="number" id="fixed_tax" name="fixed_tax" class="form-control shadow-sm number_int" oninput="calculate()">
                                </div>

                                <label for="inputPassword3" class="col-sm-1 col-form-label text-center">Transit Fee</label>
                                <div class="col-sm-3">
                                    <input type="number" name="transit" class="form-control shadow-sm number_int" id="transit" oninput="calculate()">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-1 col-form-label">Total Amount</label>
                                <div class="col-sm-3">
                                    <input type="number" name="total" class="form-control shadow-sm" id="total" readonly>
                                </div>
                                
                                <label class="col-sm-1 col-form-label text-center">Grand Total</label>
                                <div class="col-sm-3">
                                    <input type="number" id="grandtotal" name="grandtotal" class="form-control shadow-sm" readonly>
                                </div>

                                <label for="inputPassword3" class="col-sm-1 col-form-label text-center">Ref#</label>
                                <div class="col-sm-3">
                                    <input type="text" name="ref" class="form-control shadow-sm" id="inputPassword3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-1 col-form-label">Due Amount</label>
                                <div class="col-sm-3">
                                    <input type="number" id="dueamount" name="due_amount" class="form-control shadow-sm" readonly>
                                </div>

                                <label class="col-sm-1 col-form-label text-center">Due Date</label>
                                <div class="col-sm-3">
                                    <input type="date" name="due_date" id="due_date" class="form-control shadow-sm">
                                </div>

                                <label for="inputPassword3" class="col-sm-1 col-form-label text-danger text-center">Attachment*</label>
                                <div class="col-sm-3">
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-1 col-form-label">Note</label>
                                <div class="col-sm-3">
                                    <textarea class="form-control shadow-sm" name="note" id="exampleFormControlTextarea1" rows="1"></textarea>
                                </div>

                                <label class="col-sm-1 col-form-label text-center">Adjustment <br> (if any)</label>
                                <div class="col-sm-3">
                                    <?php if ($adjsut_ability>0){
                                        echo "<small class='text-danger'>You are not eligible to use petty cash/advance money for pending bill aproval!</small>";
                                    } else{?>
                                    <select name="adjust_status" id="adjust_status" class="form-control shadow-sm" <?>
                                        <option selected value="0">-- select one --</option>
                                        <?php if ($_SESSION['super_admin']['branch']=='BAR_011220_210463187872898170_1606780607') : ?>
                                            <option value="1">Advance money</option>
                                        <?php endif; ?>
                                        <?php if ($_SESSION['user_info'] ['department']=='1806965207554226682') : ?>
                                            <option value="2">Petty cash</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php } ?>
                                </div>

                                <label for="inputPassword3" class="col-sm-1 col-form-label text-center balance_adjust">Balance</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" id="adjust_balance" name="adjust_balance" readonly required>
                                    <small class="warn text-danger"></small>
                                </div> 
                                
                            </div>


                            <!-- <div id="paySystem">
                                <div class="row mt-5">
                                    <div class="col-sm-12">
                                        <h4 style="text-decoration:underline;">
                                            Payment Information										
                                            <div class="row d-flex" style="float:right;padding-right: 16px;">										
                                                <button type="button" id='removeButton_payment2' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
                                                <button type="button" id='addButton_payment2' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
                                            </div>
                                            <div id="due_result_amount_booking2" class="row d-flex" style="float:right;padding-right: 26px; color: #f00; margin-top: -4px;font-size: 20px;"> </div>
                                        </h4>
                                        <span style="color:red;font-weight:bolder;" id="document_error_message"></span>
                                    </div>
                                </div>
                                <div id='UnitBoxesGroup_payment2'>
                                    <div id="UnitBoxDiv_payment2">
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <select onchange="return payment_function_on_change2()" id="payment_method2" name="payment_method[]" class="form-control">
                                                        <option value="">select payment method</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Mobile Banking">Mobile / Online Booking</option>
                                                        <option value="Credit / Debit Card">Credit / Debit Card</option>
                                                        <option value="Check">Cheque</option>		
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">								
                                                <div class="row" id="mobile_banking2" style="display:none;">
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <select id="agent2" name="agent[]" class="form-control">
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
                                                            <input type="text" id="mobile_banking_number2" name="mobile_banking_number[]" placeholder="Banking Number" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="transaction_id2" name="transaction_id[]" placeholder="TrxID / Confirmation ID" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="mobile_amount2" name="mobile_amount[]" placeholder="Amount2" autocomplete="off" class="number_int form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row" id="check_number2" style="display:none;">
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="bank_name2" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="check_number2" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="date" id="withdraw_date2" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?= date('Y-m-d'); ?>" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="check_amount2" name="check_amount[]" placeholder="Amount2" autocomplete="off" class="number_int form-control"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="credit_card2" style="display:none;">
                                                    <div class="col-sm-6">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="credit_card_number2" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="card_secret2" name="card_secret[]" value="0"/>

                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="Expiry_Date2" oninput="return card_payment_calculator()" name="Expiry_Date[]" placeholder="Amount2" autocomplete="off" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="card_amount2" name="card_amount[]" id="card_result2" placeholder="Amount2" autocomplete="off" class="number_int form-control" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="cash2" style="display:none;">
                                                    <div class="col-sm-9">
                                                        <div class="form-group" style="width:100%;">
                                                            <textarea id="cash_other_information_remarks2" name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>											
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="width:100%;">
                                                            <input type="text" id="cash_amount2" name="cash_amount[]" placeholder="Amount2" autocomplete="off" class="number_int form-control" />
                                                        </div>
                                                    </div>
                                                </div>							
                                                
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                            </div> -->
                        <?php if ($_SESSION['user_info'] ['department'] == '2270968637477766714') :?>
                            <div class="payment_hidden">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 style="text-decoration:underline;">
                                            Payment Information										
                                            <div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
                                                <button type="button" id='delete_payment_field' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
                                                <button type="button" id='add_payment_field' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
                                            </div>
                                            <div id="due_result_amount_booking" class="row d-flex" style="float:right;padding-right: 26px; color: #f00; margin-top: -4px;font-size: 20px;"> </div>
                                        </h4>
                                        <span style="color:red;font-weight:bolder;" id="document_error_message"></span>
                                    </div>
                                </div>
                                <div id='payment_method_groups'>
                                    <div id="payment_method_box_1">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group m-0">
                                                    <label class="m-0">Payment method</label>
                                                    <select onchange="return new_payment_method_change(1)" name="payment_method_id[]" class="payment_method_id_1 form-control">
                                                        <option value="">select payment method</option>
                                                        <?php if(!empty($payment_method)){ foreach($payment_method as $row){ echo '<option value="'.$row->id.'">'.$row->payment_method.'</option>'; } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">								
                                                <div class="row payment_method_fields_result_1"></div>
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                            <div class="form-group row mt-3">
                                <div class="col-sm-6">
                                    <input type="hidden" name="single_exp" value="single_exp">
                                    <button type="submit" name="single_exp" class="single_exp btn btn-primary" onclick="return confirm('Are you confirm to record expense?')" disabled>Save & Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- bulk expense form -->
                    <!-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div> -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus-square"></i> Add New</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalForm">
        ...
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<!--  expense view Modal -->
<div class="modal fade" id="expModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="(window.location.reload())">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalData">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick=(window.location.reload())>Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    function select2 () {
        $('.select2use').select2({
            allowClear: true,
            placeholder: 'Select'
        });
    };
    // calculation for subtotal

    //script for bulk_expense field
        // var i= Number(('table tr').length) + 1;
        // function add_row(){
        //     $.ajax({
        //         type: "POST",
        //         enctype: 'multipart/form-data',
        //         url:"<?php echo base_url('assets/ajax/accounting/bulk_expense.php'); ?>",  
        //         data: { i },
        //         beforeSend:function(){
        //             $('#data-loading').html(data_loading);
        //         },
        //         success:function(data){
        //             $('#data-loading').html('');
        //             $('tbody').append(data);
        //         }
        //     });
        //     i++;
        // };

    $(document).on('change','#check_all',function(){
    $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
    });
    function remove_row() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false); 
        calculateTotal();
    };
    var prices = ["S24_4620|1961 Chevrolet Impala|32.33"];
    $(document).on('focus','.autocomplete_txt',function(){
        type = $(this).data('type');

        if(type =='productCode' )autoTypeNo=0;
        if(type =='productName' )autoTypeNo=1;  

        $(this).autocomplete({
            source: function( request, response ) {  
                var array = $.map(prices, function (item) {
                    var code = item.split("|");
                    return {
                        label: code[autoTypeNo],
                        value: code[autoTypeNo],
                        data : item
                    }
                });
                response($.ui.autocomplete.filter(array, request.term));
            },
            autoFocus: true,            
            minLength: 2,
            select: function( event, ui ) {
                var names = ui.item.data.split("|");                        
                id_arr = $(this).attr('id');
                id = id_arr.split("_");
                $('#itemNo_'+id[1]).val(names[0]);
                $('#itemName_'+id[1]).val(names[1]);
                $('#quantity_'+id[1]).val(1);
                $('#price_'+id[1]).val(names[2]);
                $('#total_'+id[1]).val( 1*names[2] );
                calculateTotal();
            }               
        });
    });

    $(document).on('change keyup blur','.changesNo',function(){
        id_arr = $(this).attr('id');
        id = id_arr.split("_");
        qty = $('#quantity_'+id[1]).val();
        price = $('#price_'+id[1]).val();
        if( qty!='' && price !='' ) $('#total_'+id[1]).val( (parseFloat(price)*parseFloat(qty)).toFixed(2) );   
        calculateTotal();
    });
    function calculateTotal(){
        subTotal = 0 ; sub_total = 0; 
        $('.totalLinePrice').each(function(){
            if($(this).val() != '' )subTotal += parseFloat( $(this).val() );
        });
        if(subTotal.toFixed(2) > parseFloat($("#total_amount").val())){
            $("#error_message").html('You Have Not Enough Balance In Petty Cash!');
        }else{
            $("#error_message").html('');
        }
        $('#subTotal').val( subTotal.toFixed(2) );
    }

    var specialKeys = new Array();
    specialKeys.push(8,46);
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        console.log( keyCode );
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        return ret;
    }


    //hide adjust balance field in page load
    $('.balance_adjust').hide();
    $('#adjust_balance').hide();
    // adjustment status with show and hide balance adjust field
    $('#adjust_status').change(function () {
        $status=$(this).val();
        if ($status == '0') {
            $('.payment_hidden').show();
            $('.balance_adjust').hide();
            $('#adjust_balance').hide();
            $('#adjust_balance').val('');
            $('#dueamount').prop( "disabled", false );
            $('#due_date').prop( "disabled", false );
            $('.warn').html('');
        }else{
                //attribute selector in jquery
                $("input[placeholder='Amount']").val('');
                $("select[name='payment_method_id[]']").prop('selectedIndex',0);
                $('.balance_adjust').show();
                $('#adjust_balance').show();
                $('#adjust_balance').prop( "disabled", false );
                $('.payment_hidden').hide();
                $('#dueamount').prop( "disabled", true );
                $('#due_date').prop( "disabled", true );

            if ($status == '1') {
                $.ajax({
                    url: "<?=current_url()?>",
                    dataType: "HTML",
                    type: "POST",
                    async: true,
                    data: {"adjust_emp_id":'<?=$_SESSION['super_admin']['employee_ids']?>'},
                    success: function (data) {
                        $("#adjust_balance").val(data);
                    },
                    error: function (data) {
                    
                    }
                })
            }
            if ($status == '2') {
                $.ajax({
                    url: "<?=current_url()?>",
                    dataType: "HTML",
                    type: "POST",
                    async: true,
                    data: {"adjust_br_id":'<?=$_SESSION['super_admin']['branch']?>'},
                    success: function (data) {
                        // alert(data);
                        $("#adjust_balance").val(data);
                    },
                    error: function (data) {
                    
                    }
                })
            }
        }
        setInterval(() => {
            calculate();
        }, 1000);
        
    })
    // selection of item on vendor select
    $("#vendorId").change(function(){
        var vendor_id=$("#vendorId").val();
        $('input[name="vendor"]').val(vendor_id);
        $("#itemId").empty();
        $.ajax({
            url: "<?=current_url()?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"vendor_id":vendor_id},
            success: function (data) {
                $("#itemId").append(data);
            },
            error: function (data) {
            
            }
        })
    });
    //disable/hide in itialize page loading 
	// $("button.single_exp").prop("disabled", true);
    $("#item-table").hide();
    $("#clear").hide();

    // selection of item to dispaly table
    $("#itemId").change(function(){
        var itemId=$("#itemId").val();
        $( "#vendorId" ).prop( "disabled", true );
        // $("#itemId").empty();
        $("#item-table").show();
        $("#clear").show();

        $("[id^='price_']").each(function() {
            var id = $(this).attr('id');
            id = id.replace("price_",'');
            var selectItem = $('#selectItem_'+id).val();
            if (itemId==selectItem) {
                alert("Item is alrady selected!");
                process.exit(); 
            }
        });
        $.ajax({
            url: "<?=current_url()?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"item_id":itemId},
            success: function (data) {
                $("#item-body").append(data);

            },
            error: function (data) {
            
            }
        })
    })

    //add new vendor
    function vendorButton() {
        $('#vendorId').select2('close');
        $.ajax({
            url: "<?=current_url()?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"addvendor":"vendor"},
            success: function (data) {
                $("#modalForm").html(data);
            }
        })
    }

    //add new unit type
    const unitButton = () => {
        // $('#vendorId').select2('close');
        $.ajax({
            url: "<?=current_url()?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"addunit_type":"unit_type"},
            success: function (data) {
                $("#modalForm").html(data);
            }
        })
    }

    //add new tax
    const taxButton = () => {
        $.ajax({
            url: "<?=current_url()?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"addtax":"tax"},
            success: function (data) {
                $("#modalForm").html(data);
            }
        })
    }

    // add new discount
    function discountButton() {
        $.ajax({
            url: "<?=current_url()?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"adddiscount":"discount"},
            success: function (data) {
                $("#modalForm").html(data);
            }
        })
    }

    //add new branch
    function branchButton(x) {
        var qtn=$('#'+x).val();
        var branch_info =$('#branch_'+x+' input').val();
        // alert(y);
        $.ajax({
            url: "<?=current_url()?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"addbranch":x ,"qt":qtn, "branch_data":branch_info},
            success: function (data) {
                $("#modalForm").html(data);
            }
        })
    }

    //master calculation function for
    function calculate() {
        var sum = 0;
        $("[id^='price_']").each(function() {
            var id = $(this).attr('id');
            id = id.replace("price_",'');
            var price = parseFloat($('#price_'+id).val());
            var quantity = parseFloat($('#qty_'+id).val());
            var subtotal = price * quantity;
            var subtotal = price * quantity;
            $('#subtotal_'+id).val(subtotal);
            var dis_val=$('#discountId_'+id).val();
            var dis_array = dis_val.split(',');
            
            // $('#disAmount_'+id).val(subtotal);
            // alert(dis_val);
            var tax_rate=$('#taxId_'+id).val();
            // $('#taxAmount_'+id).val(subtotal);
            if (dis_array[1]=='rate') {
                var disVal=subtotal*dis_array[0]/100;
                $('#disAmount_'+id).val(disVal);
                var taxVal=subtotal*tax_rate/100
                $('#taxAmount_'+id).val(taxVal);
                $('#itemTotal_'+id).val(subtotal-disVal+taxVal);
                // $("#dueamount").val(subtotal-disVal+taxVal)  
            }else{
                var disVal=dis_array[0];
                $('#disAmount_'+id).val(disVal);
                var taxVal=subtotal*tax_rate/100;
                $('#taxAmount_'+id).val(taxVal);
                $('#itemTotal_'+id).val(subtotal-disVal+taxVal);
            }
            sum += parseFloat($('#itemTotal_'+id).val()); 
         })
         var fixedDiscount= $('#fixed_discount').val() ? parseFloat($('#fixed_discount').val()) : 0;
         var fixedTax= $('#fixed_tax').val() ? parseFloat($('#fixed_tax').val()) : 0;
         var transfee= $('#transit').val() ? parseFloat($('#transit').val()) : 0;
         $('#total').val(sum);
         $('#grandtotal').val(sum+transfee+fixedTax-fixedDiscount);
         payment_cal();
         var gt=parseFloat($('#grandtotal').val());
         var ab=parseFloat($('#adjust_balance').val());
         //empty value check in jquery
         if (ab>0) {
            if (ab<gt) {
                $('.single_exp').prop('disabled', true);
                $('.warn').html('Grand Total should be equal or less than Adjust Balance');
            }else{
                $('.single_exp').prop('disabled', false);
                $('.warn').html('');
            }
         }
    }

    // clear table data
    function Clear () {
        $("#item-body").empty();
        $( "#vendorId" ).prop( "disabled", false );
        $("#vendorId").prop('selectedIndex',0);
        $("#item-table").hide();
        $("#clear").hide();
    };
    
    //  remove item row
    $('.itemTable tbody').on('click','.removeTr',function(){
        $(this).closest('tr').remove();
    });
    
    
    $("#expenseform").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        url: "<?= base_url('admin/manage-expense');?>",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(result)
		    {
				$("#expenseform")[0].reset();
                Clear();
                $('#due_result_amount_booking').empty();
                $('.toast').toast('show');
                $("#expModal").modal('show');
                exp_detail(result);
				// window.location.reload();
		    },
		  	error: function() 
	    	{
				window.location.reload();
	    	} 	        
	   	});
	}));

    function exp_detail(trxId) {
        // alert(trxId);
        $.ajax({
            url: "<?= base_url('admin/view-expenses');?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"exp_id":trxId},
            success: function (data) {
                // alert(data);
                $("#modalData").html(data);
            }
        })
    }

    //function that prevent enter minus figure
	$(document).on("input", ".number_int",function(){
        $('.number_int').each(function(){
            var  get_value = $(this).val();
            var modified_value = get_value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            $(this).val(modified_value);
        })
	})

    //select2 for vendor
    window.onpageshow = function() {
        $('#vendorId').select2({
            placeholder: 'Select a vendor',
        })
        .on('select2:open', () => {
            <?php if ($_SESSION['user_info'] ['department'] == '2270968637477766714') :?>
            $(".select2-results:not(:has(a))").append('<a href="#" id="vendorButton" data-toggle="modal" data-target="#myModal" onclick="vendorButton()" style="padding: 6px;background-color:#f8f9fa;width:100%;height: 20px;display: inline-table;">+ Create New</a>');
            <?php endif;?>
        });
    };

    
   
</script>

<script> 
    // payment information script
    var payment_method_options = '<?php if(!empty($payment_method)){ foreach($payment_method as $row){ echo '<option value="'.$row->id.'">'.$row->payment_method.'</option>'; } } ?>'; 

    
      $(document).on('input', 'input[placeholder="Amount"]', function(){
        extra_charge();
      })						
      function extra_charge(){
        var extra_charge_payment = 0;
        $('.payment_extra_charge').each(function(e){
          extra_charge_payment = extra_charge_payment + parseFloat($(this).val());
        })
        $("#crd_add_sudm").html('(EC/CP: '+extra_charge_payment+'%)');
        var total = parseFloat($("#grandtotal").val());
        var matth = (total / 100) * extra_charge_payment;
        var grnd_total_amt = total + matth;							
        $("#booking_total_amount").val(grnd_total_amt);
        $('#total_amount_large').html(formatCurrency(grnd_total_amt));
        $("#due_result_amount_booking").html('Calculation: ' + due_result_amount_booking2);
        //alert(grnd_total_amt);
      }

      $(document).on('keyup', 'input[placeholder="Amount"]', payment_cal);

      function payment_cal (event, data) {
            var written_amount = 0;
            $('input[placeholder="Amount"]').each(function(){
                if($(this).val() != ''){
                written_amount += parseInt($(this).val());
                }    
            })
            var due_result_amount_booking = written_amount - parseInt($('#grandtotal').val());
            $("#due_result_amount_booking").html('Calculation: ' + due_result_amount_booking);
            var dueAmount= parseInt(-1*due_result_amount_booking);
            dueAmount<0 ? $("#dueamount").val(0) : $("#dueamount").val(dueAmount);  
            if(parseInt($('#grandtotal').val()) >= written_amount || parseInt(written_amount) < -1){
                $(".single_exp").prop("disabled", false);
            }else{
                $(".single_exp").prop("disabled", true);
            } 
        }

      function new_payment_method_change(counter){
        var payment_method_id = $('.payment_method_id_'+counter).val();
        if(payment_method_id != ''){
          $.ajax({  
            url: "<?=base_url('assets/ajax/option_select/get_payment_method_fields.php'); ?>",  
            method: "GET",
            data: { payment_method_id: payment_method_id },
            beforeSend: function(){ $('#data-loading').html(''); },
            success: function(data){ $('#data-loading').html('');			
              $('.payment_method_fields_result_'+counter).html(data);
              extra_charge();
            }
          });
        }else{
          $('.payment_method_fields_result_'+counter).html('');
        }
      }															
      var counter_payment = 2;
      $("#add_payment_field").on('click', function () {	
        if( counter_payment == 11 ){
          alert("Sorry! Maximum number of field reached");
          return false;			
        }								
        var payment_html = '<div id="payment_method_box_'+counter_payment+'">';
          payment_html += '<div class="row">';
          payment_html += '<div class="col-sm-3">';
          payment_html += '<div class="form-group  m-0">';
          payment_html += '<label class="m-0">Payment method</label>';
          payment_html += '<select onchange="return new_payment_method_change('+counter_payment+')" name="payment_method_id[]" class="payment_method_id_'+counter_payment+' form-control">';
          payment_html += '<option value="">select payment method</option>';
          payment_html += payment_method_options;
          payment_html += '</select>';
          payment_html += '</div>';
          payment_html += '</div>';
          payment_html += '<div class="col-sm-9">';						
          payment_html += '<div class="row payment_method_fields_result_'+counter_payment+'"></div>';
          payment_html += '</div>';
          payment_html += '</div>';
          payment_html += '</div>';
        $("#payment_method_groups").append(payment_html);
        counter_payment++;								
      });
      $("#delete_payment_field").on('click', function () {
        if( counter_payment == 2 ){
          alert("Sorry! The System Can Not Remove This field");
          return false;
        }
        counter_payment--;
        $("#payment_method_box_" + counter_payment).remove();
      });	
</script>

<!-- <script type="text/javascript" src="<?= base_url('/assets/js/accounts/ac_scripts.js'); ?>"></script> -->
<!-- <script type="text/javascript" src="<?= base_url('/assets/js/accounts/single_scripts.js'); ?>"></script> -->