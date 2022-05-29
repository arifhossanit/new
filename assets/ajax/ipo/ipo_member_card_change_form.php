<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){ 
	$row = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where id = '".$_POST['member_id']."'"));
	$card_change_amount = '100';
	include("../include/ipo_registration_payment_conditions.php");
	
	if($card_change_amount > 0){
		$cal_col = 'col-sm-4';
		$payment = 1;
	}else{
		$cal_col = 'col-sm-6';
		$payment = 0;
	}
?>

<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<span id="card_change_error_message" style="color:#f00;font-weight:bolder;"></span>
			</div>
			<div class="<?php echo $cal_col; ?>">
				<div class="form-group">
					<label>Old Card</label>
					<input type="text" name="old_card" value="<?php echo $row['card_number']; ?>" class="form-control" readonly style="font-size:26px;color:#f00;font-weight:bolder;"/> 
				</div>				
			</div>
			<div class="<?php echo $cal_col; ?>">
				<div class="form-group">
					<label>New Card</label>
					<input type="" name="new_card" class="form-control" autocomplete="off" style="font-size:26px;color:green;font-weight:bolder;" required /> 
				</div>
			</div>
			<?php if($payment == 1){ ?>
			
			<div class="col-sm-4" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
				<div class="form-group" style="margin:0px;">
					<label style="margin-bottom:0px;">
						<i class="fas fa-calculator"></i> 
						Total Amount 
						<span id="due_sudm" style="color:red;"></span>
						<span id="crd_add_sudm" style="color:red;"></span>
					</label>
					<input type="hidden" id="total_amount" name="total_amount"/>
					<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
					<div id="total_amount_large" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">0</div>
				</div>
			</div>			
			<?php } ?>
		</div>
		<?php if($payment == 1){ ?>
<script>
$('document').ready(function(){
	$('#total_amount_large').html(formatCurrency("<?php echo $card_change_amount; ?>")); 
	$("#booking_total_amount").val(parseFloat("<?php echo $card_change_amount; ?>"));
	$("#booking_total_amount_c").val(parseFloat("<?php echo $card_change_amount; ?>"));
	$("#ipo_member_card_change_form_button").prop("disabled", true);
})
</script>
<input type="hidden" id="booking_total_amount" title="total" name="booking_total_amount" value=""/>
<input type="hidden" id="booking_total_amount_c" title="total" name="booking_total_amount_c" value=""/>
<input type="hidden" name="member_id" value="<?php echo $row['id']; ?>"/>
<input type="hidden" name="total_amount" value="<?php echo $card_change_amount; ?>"/>
<input type="hidden" value="" id="amount_verify_get"/>		
<input type="hidden" name="ipo_card_change_token" value="<?php echo md5(time()); ?>"/>		
		<div class="row">
			<div class="col-sm-12" style="margin-top:30px;">
				<h4 style="text-decoration:underline;">
					Payment Information									
					<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
						<button type="button" id='removeButton_payment' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
						<button type="button" id='addButton_payment' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
					</div>
					<div id="due_result_amount_booking" class="row d-flex" style="float:right;margin-right: 26px; color: #f00; margin-top: -4px;font-size: 20px;"> </div>
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
								<option value="Check">Check</option>										
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
<script>
$(document).on('keyup', 'input[placeholder="Amount"]', function (event, data) {
	var written_amount = 0;
	$('input[placeholder="Amount"]').each(function(){
		if($(this).val() != ''){
			written_amount += parseInt($(this).val());
		}		
	})
	var due_result_amount_booking = written_amount - parseInt($('input[name="booking_total_amount"]').val());
	$("#due_result_amount_booking").html('Calculation: ' + due_result_amount_booking);	
	if(parseInt($('input[name="booking_total_amount"]').val()) <= written_amount){
		$("#amount_verify_get").val(1);
	}else{
		$("#amount_verify_get").val(0);
	}	
	if($("#amount_verify_get").val() == 1){
		$("#ipo_member_card_change_form_button").prop("disabled", false);
	}else{
		$("#ipo_member_card_change_form_button").prop("disabled", true);
	}
});
</script>		
		<?php } ?>
	</div>
</div>
<?php } ?>