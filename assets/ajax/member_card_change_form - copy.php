<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){
$disable_status = '';

$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['profile_id']."'"));
$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member_info['package']."'")); ?>
<div class="modal-body" style="max-height:780px;overflow-y:scroll;">
<div class="row">
	<div class="col-sm-12">
<?php if($member_info['card_number'] == 'Unauthorized' ){ ?>
		<h1 style="text-align:center;color:#f00;">Account Unauthorized! Please Athorized It Before card change</h1>
	</div>	
</div>	
<?php }else{ ?>
			<span id="card_change_error_message" style="color:red;font-weight:bolder;"></span>
			<input type="hidden" name="uploader_info" id="uploader_info" value="<?php if(!empty($_POST['uploader_info'])){ echo $_POST['uploader_info']; }?>"/>
			<div class="row" style="width:100%;">
				<div class="col-sm-12">
					<h4 style="text-decoration:underline;">
						Card Information					
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-grouop">
						<label>Old Card Number</label>
						<input type="text" name="old_card_number" id="old_card_number" value="<?php if(!empty($member_info['card_number'])){ echo $member_info['card_number']; } ?>" placeholder="Old Card Number" class="form-control" style=" FONT-SIZE: 30px; font-weight: bolder;" readonly/>
					</div>
				</div>
				
				<div class="col-sm-4">
					<div class="form-grouop">
						<label>Write New Card Number</label>
						<input type="text" name="naw_card_number" id="new_card_number" minlength="8" maxlength="10" placeholder="New Card Number" class="form-control" style=" FONT-SIZE: 30px; font-weight: bolder;"/>
					</div>
				</div>
				<!-- Removed card change amount -->
			</div>
			
<?php if(0){
	//if($package_info['try_us'] != 1 and $_SESSION['super_admin']['user_type'] != 'Super Admin'){
	$disable_status = 'disabled';
?>
			<div class="row" style="margin-top:30px;">
				<input type="hidden" name="member_type" id="member_type" value="Monthly" />
				<div class="row" style="width:100%;margin-top: 20px;">
					<div class="col-sm-12">
						<h4 style="text-decoration:underline;">
							Payment Information									
							<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
								<button type="button" id='removeButton_payment_aut' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
								<button type="button" id='addButton_payment_aut' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
							</div>
							<div id="due_result_amount_package_shift" class="row d-flex" style="float:right;padding-right: 26px; color: #f00; margin-top: -4px;font-size: 20px;"> </div>
						</h4>
					</div>
				</div>
				<div id='UnitBoxesGroup_payment_aut' style="width:100%;">
					<div id="UnitBoxDiv_payment_aut1" style="width:100%;">
						<div class="row" style="margin-top: 10px;">
							<div class="col-sm-3">
								<div class="form-group">
									<select onchange="return payment_function_on_change_aut()" id="payment_method_aut1" name="payment_method[]" class="form-control" required>
										<option value="">select payment method</option>
										<option value="Cash">Cash</option>
										<option value="Mobile Banking">Mobile Banking</option>
										<option value="Credit / Debit Card">Credit / Debit Card</option>
										<option value="Check">Check</option>										
									</select>
								</div>
							</div>
							<div class="col-sm-9">								
								<div class="row" id="mobile_banking_aut1" style="display:none;">
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<select name="agent[]" class="form-control">
												<option value="">select agent</option>
												<option value="Bikash">bKash</option>
												<option value="Rocket">Rocket</option>
												<option value="Nogod">Nogod</option>
											</select>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
								</div>
								<div class="row" id="check_number_aut1" style="display:none;">
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="date" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" class="form-control"/>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
										</div>
									</div>
								</div>
								
								<div class="row" id="credit_card_aut1" style="display:none;">
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="card_secret[]" placeholder="Card secret" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="month" name="Expiry_Date[]" placeholder="Expiry Date" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" class="form-control"/>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
										</div>
									</div>
								</div>
								
								<div class="row" id="cash_aut1" style="display:none;">
									<div class="col-sm-9">
										<div class="form-group" style="width:100%;">
											<textarea name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>											
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
										</div>
									</div>
								</div>							
								
							</div>
						</div>	
					</div>
				</div>			
			</div>
<script>
function payment_function_on_change_aut(){
	if($("#payment_method_aut1").val() == 'Mobile Banking'){
		$("#mobile_banking_aut1").css({"display":"flex"});
		$("#check_number_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"none"});
		$("#cash_aut1").css({"display":"none"});
	}else if($("#payment_method_aut1").val() == 'Check'){
		$("#mobile_banking_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"none"});
		$("#check_number_aut1").css({"display":"flex"});
		$("#cash_aut1").css({"display":"none"});
	}else if($("#payment_method_aut1").val() == 'Credit / Debit Card'){
		$("#mobile_banking_aut1").css({"display":"none"});
		$("#check_number_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"flex"});
		$("#cash_aut1").css({"display":"none"});
	}else if($("#payment_method_aut1").val() == 'Cash'){
		$("#mobile_banking_aut1").css({"display":"none"});
		$("#check_number_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"none"});
		$("#cash_aut1").css({"display":"flex"});
	}else{
		$("#mobile_banking_aut1").css({"display":"none"});
		$("#check_number_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"none"});
		$("#cash_aut1").css({"display":"none"});
	}
	
	if($("#payment_method_aut12").val() == 'Mobile Banking'){
		$("#mobile_banking_aut12").css({"display":"flex"});
		$("#check_number_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"none"});
		$("#cash_aut12").css({"display":"none"});
	}else if($("#payment_method_aut12").val() == 'Check'){
		$("#mobile_banking_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"none"});
		$("#check_number_aut12").css({"display":"flex"});
		$("#cash_aut12").css({"display":"none"});
	}else if($("#payment_method_aut12").val() == 'Credit / Debit Card'){
		$("#mobile_banking_aut12").css({"display":"none"});
		$("#check_number_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"flex"});
		$("#cash_aut12").css({"display":"none"});
	}else if($("#payment_method_aut12").val() == 'Cash'){
		$("#mobile_banking_aut12").css({"display":"none"});
		$("#check_number_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"none"});
		$("#cash_aut12").css({"display":"flex"});
	}else{
		$("#mobile_banking_aut12").css({"display":"none"});
		$("#check_number_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"none"});
		$("#cash_aut12").css({"display":"none"});
	}
	
	if($("#payment_method_aut13").val() == 'Mobile Banking'){
		$("#mobile_banking_aut13").css({"display":"flex"});
		$("#check_number_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"none"});
		$("#cash_aut13").css({"display":"none"});
	}else if($("#payment_method_aut13").val() == 'Check'){
		$("#mobile_banking_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"none"});
		$("#check_number_aut13").css({"display":"flex"});
		$("#cash_aut13").css({"display":"none"});
	}else if($("#payment_method_aut13").val() == 'Credit / Debit Card'){
		$("#mobile_banking_aut13").css({"display":"none"});
		$("#check_number_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"flex"});
		$("#cash_aut13").css({"display":"none"});
	}else if($("#payment_method_aut13").val() == 'Cash'){
		$("#mobile_banking_aut13").css({"display":"none"});
		$("#check_number_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"none"});
		$("#cash_aut13").css({"display":"flex"});
	}else{
		$("#mobile_banking_aut13").css({"display":"none"});
		$("#check_number_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"none"});
		$("#cash_aut13").css({"display":"none"});
	}
}
</script>			
<script>
//-------------------payment-----------
	
	var counter_payment_aut = 2;
    $("#addButton_payment_aut").click(function () {	
		if( counter_payment_aut == 4 ){
			alert("Sorry! Maximum number of field reached");
			return false;			
		}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv_payment_aut1' + counter_payment_aut ,
			class: 'row',
			style: 'width:100%margin-top: 10px;'
		});
		
		var dataq = '<div class="col-sm-3">';
			dataq += '<div class="form-group">';
			dataq += '<select onchange="return payment_function_on_change_aut()" id="payment_method_aut1'+counter_payment_aut+'" name="payment_method[]" class="form-control">';
			dataq += '<option value="">select payment method</option>';
			dataq += '<option value="Cash">Cash</option>';
			dataq += '<option value="Mobile Banking">Mobile Banking</option>';
			dataq += '<option value="Credit / Debit Card">Credit / Debit Card</option>';
			dataq += '<option value="Check">Check</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-9">	';							
			dataq += '<div class="row" id="mobile_banking_aut1'+counter_payment_aut+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<select name="agent[]" class="form-control">';
			dataq += '<option value="">select agent</option>';
			dataq += '<option value="Bikash">bKash</option>';
			dataq += '<option value="Rocket">Rocket</option>';
			dataq += '<option value="Nogod">Nogod</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';			
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="check_number_aut1'+counter_payment_aut+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';			
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="date" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="credit_card_aut1'+counter_payment_aut+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="card_secret[]" placeholder="Card secret" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="month" name="Expiry_Date[]" placeholder="Expiry Date" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="cash_aut1'+counter_payment_aut+'" style="display:none;">';
			dataq += '<div class="col-sm-9">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<textarea name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>';											
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';

		newTextBoxDiv.after().html(dataq);
		newTextBoxDiv.appendTo("#UnitBoxesGroup_payment_aut");
		counter_payment_aut++;
    });
    $("#removeButton_payment_aut").click(function () {
		if( counter_payment_aut == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter_payment_aut--;
        $("#UnitBoxDiv_payment_aut1" + counter_payment_aut).remove();
    });

$(document).on('keyup', 'input[placeholder="Amount"]', function (event, data) {
	var written_amount = 0;
	$('input[placeholder="Amount"]').each(function(){
		if($(this).val() != ''){
			written_amount += parseInt($(this).val());
		}		
	})
	total_due = $('#card_change_amount').val();
	$("#due_result_amount_package_shift").html('Calculation: ' + ( total_due - written_amount ));	
	if(total_due <= written_amount){
		$('#change_card_submit_button').prop("disabled", false);
	}else{
		$('#change_card_submit_button').prop("disabled", true);
	}	
});
	
	//-------------------------------------
</script>			
<?php } ?>



	</div>
</div>


</div>

<div class="modal-footer justify-content-between">
	<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
	<button type="submit" id="change_card_submit_button" class="btn btn-info" <?php echo $disable_status; ?>><i class="fas fa-credit-card"></i>&nbsp;&nbsp; Change Card</button>
</div>
<?php } 
} ?>