<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from employee_wallet_money_widthdraw_request where id = '".$_POST['profile_id']."'"));
//$row = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$info['ipo_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-4">
				<input type="hidden" name="money" value="<?php echo $row['amount']; ?>"/>
				<input type="hidden" name="member_id" value="<?php echo $row['id']; ?>"/>
				<input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>"/>
				<input type="hidden" name="uploader_info" value="<?php echo $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']; ?>"/>
				<div class="form-group">
					<label>Attachment (if need)</label>
					<input type="file" name="attachment" class="form-control" style="padding-top:3px;" />
				</div>
				<div class="form-group">
					<label>Note</label>
					<textarea name="note" placeholder="Note" class="form-control"></textarea>
				</div>
			</div>
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
						<div class="form-group" style="margin:0px;">
							<label style="margin-bottom:0px;"><i class="fas fa-calculator"></i> Total Amount</label>
							<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
							<div id="total_amount_large" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">
								<?php echo money($row['amount']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<h4 style="text-decoration:underline;">
							Payment Information									
							<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
								<button type="button" id='removeButton_payment' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
								<button type="button" id='addButton_payment' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
							</div>
						</h4>
						<span style="color:red;font-weight:bolder;" id="document_error_message"></span>
					</div>
				</div>
				<div id='UnitBoxesGroup_payment'>
					<div id="UnitBoxDiv_payment1">
						<div class="row" style="margin-top: 10px;">
							<div class="col-sm-3">
								<div class="form-group">
									<select onchange="return payment_function_on_change()" id="payment_method1" name="payment_method[]" class="form-control" required>
										<option value="">select payment method</option>
										<option value="Cash">Cash</option>
										<option value="Mobile Banking">Mobile Banking</option>
										<option value="Credit / Debit Card">Credit / Debit Card</option>
										<option value="Check">Check</option>										
									</select>
								</div>
							</div>
							<div class="col-sm-9">								
								<div class="row" id="mobile_banking1" style="display:none;">
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
											<input type="number" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
								</div>
								<div class="row" id="check_number1" style="display:none;">
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
											<input type="number" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
										</div>
									</div>
								</div>
								
								<div class="row" id="credit_card1" style="display:none;">
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
											<input type="number" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
										</div>
									</div>
								</div>
								
								<div class="row" id="cash1" style="display:none;">
									<div class="col-sm-9">
										<div class="form-group" style="width:100%;">
											<textarea name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>											
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="number" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
										</div>
									</div>
								</div>							
								
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function payment_function_on_change(){
	if($("#payment_method1").val() == 'Mobile Banking'){
		$("#mobile_banking1").css({"display":"flex"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
	}else if($("#payment_method1").val() == 'Check'){
		$("#mobile_banking1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#check_number1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
	}else if($("#payment_method1").val() == 'Credit / Debit Card'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
	}else if($("#payment_method1").val() == 'Cash'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"flex"});
	}else{
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
	}
	
	if($("#payment_method12").val() == 'Mobile Banking'){
		$("#mobile_banking12").css({"display":"flex"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
	}else if($("#payment_method12").val() == 'Check'){
		$("#mobile_banking12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#check_number12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
	}else if($("#payment_method12").val() == 'Credit / Debit Card'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
	}else if($("#payment_method12").val() == 'Cash'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"flex"});
	}else{
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
	}
	
	if($("#payment_method13").val() == 'Mobile Banking'){
		$("#mobile_banking13").css({"display":"flex"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
	}else if($("#payment_method13").val() == 'Check'){
		$("#mobile_banking13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#check_number13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
	}else if($("#payment_method13").val() == 'Credit / Debit Card'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
	}else if($("#payment_method13").val() == 'Cash'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"flex"});
	}else{
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
	}
}

//-------------------payment-----------
	
	var counter_payment = 2;
    $("#addButton_payment").click(function () {	
		if( counter_payment == 4 ){
			alert("Sorry! Maximum number of field reached");
			return false;			
		}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv_payment1' + counter_payment ,
			class: 'row',
			style: 'width:100%margin-top: 10px;'
		});
		
		var dataq = '<div class="col-sm-3">';
			dataq += '<div class="form-group">';
			dataq += '<select onchange="return payment_function_on_change()" id="payment_method1'+counter_payment+'" name="payment_method[]" class="form-control">';
			dataq += '<option value="">select payment method</option>';
			dataq += '<option value="Cash">Cash</option>';
			dataq += '<option value="Mobile Banking">Mobile Banking</option>';
			dataq += '<option value="Credit / Debit Card">Credit / Debit Card</option>';
			dataq += '<option value="Check">Check</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-9">	';							
			dataq += '<div class="row" id="mobile_banking1'+counter_payment+'" style="display:none;">';
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
			dataq += '<div class="row" id="check_number1'+counter_payment+'" style="display:none;">';
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
			dataq += '<div class="row" id="credit_card1'+counter_payment+'" style="display:none;">';
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
			dataq += '<div class="row" id="cash1'+counter_payment+'" style="display:none;">';
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
		newTextBoxDiv.appendTo("#UnitBoxesGroup_payment");
		counter_payment++;
    });
    $("#removeButton_payment").click(function () {
		if( counter_payment == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter_payment--;
        $("#UnitBoxDiv_payment1" + counter_payment).remove();
    });
	
	//-------------------------------------
</script>

<?php } ?>