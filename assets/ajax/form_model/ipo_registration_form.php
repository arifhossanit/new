<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['bed_id_registration_form'])){ 
	$total_number = mysqli_fetch_assoc($mysqli->query("select sum(qty) as total_number from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'"));
	if(!empty($_SESSION['cart_gen_code']) AND $total_number['total_number'] > 0){
		$total_number = mysqli_fetch_assoc($mysqli->query("select sum(qty) as total_number from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'"));
		$total_price = mysqli_fetch_assoc($mysqli->query("select sum(price) as total_price from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'"));
	include("../include/ipo_registration_payment_conditions.php");
?>
<input type="hidden" name="condition" value="<?php echo $_POST['condition']; ?>"/>	
<div class="row">
	<div class="col-sm-12">
		<div class="form-check form-check-inline">
			<input class="form-check-input" name="member_type" type="radio" value="new" id="new_ipo_member" checked required>
			<label class="form-check-label" for="new_ipo_member">
				New
			</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" name="member_type" type="radio" value="existing" id="existing_ipo_member" required>
			<label class="form-check-label" for="existing_ipo_member">
				Existing
			</label>
		</div>
	</div>
	<div class="col-sm-12"><hr></div>
	<div class="col-sm-12">
		<input type="hidden" name="ipo_registration_token" value="<?php echo md5(time()); ?>"/>
		<div class="row" id="member_personal_information">
			<div class="col-sm-4">
				<h4 style="text-decoration:underline;">Personal Info</h4>
				<div class="form-group">
					<input type="text" name="personal_full_name" class="form-control" placeholder="Full Name/Company Name" required="required"/>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="personal_phone_number" id="personal_phone_number" class="form-control" placeholder="Phone Number" required="required"/>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="date" name="personal_date_of_birth" class="form-control" title="Date of Birth" required="required"/>
						</div>
					</div>
				</div>				
				<div class="form-group">
					<input type="email" name="personal_email" class="form-control" placeholder="Email" required="required"/>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>NID/Trade Licence</label>
							<input type="text" name="personal_nid_card" class="form-control" placeholder="NID/Trade Licence" required="required"/>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Attachment</label>
							<input type="file" name="personal_nid_attachment" class="form-control" style="padding-top:3px;padding-left: 3px;" required="required"/>
						</div>	
					</div>
				</div>				
				<div class="form-group">
					<label>Choose Image</label>
					<input type="file" name="personal_images" class="form-control" style="padding-top:3px;padding-left: 3px;" accept="image/*" required />
				</div>	
				<div class="form-group">
					<label>Address</label>
					<textarea name="personal_address" class="form-control" placeholder="Address" required></textarea>
				</div>
			</div>
			<div class="col-sm-4">
				<h4 style="text-decoration:underline;">Bank Info</h4>
				<div class="form-group">
					<input type="text" name="ipo_bank_name" class="form-control" placeholder="Bank Name" required="required"/>
				</div>
				<div class="form-group">
					<input type="text" name="account_holder_name" class="form-control" placeholder="Account Holder Name" required="required"/>
				</div>
				<div class="form-group">
					<input type="text" name="account_number" class="form-control" placeholder="Account Number" required="required"/>
				</div>
				<div class="form-group">
					<input type="text" name="routing_number" class="form-control" placeholder="Routing Number" required="required"/>
				</div>
				<div class="form-group">
					<input type="text" name="bank_branch_name" class="form-control" placeholder="Bank Branch Name"/>
				</div>
				<div class="form-group">
					<label>Cheque attachment</label>
					<input type="file" name="bank_attachment[]" multiple class="form-control" style="padding-top:3px;padding-left: 3px;"/>
				</div>
				<div class="form-group">
					<label>Address</label>
					<textarea name="bank_address" class="form-control" placeholder="Bank Address"></textarea>
				</div>
			</div>
			<div class="col-sm-4">
				<h4 style="text-decoration:underline;">Nominee</h4>
				<div class="form-group">
					<input type="text" name="nominee_name" class="form-control" placeholder="Nominee Name">
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="nominee_phone_number" class="form-control" placeholder="Phone Number"/>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="date" name="nominee_date_of_birth" class="form-control" title="Date of Birth"/>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<input type="email" name="nominee_email" class="form-control" placeholder="Email"/>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>NID</label>
							<input type="text" name="nominee_nid_card" class="form-control" placeholder="NID Number"/>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Attachment</label>
							<input type="file" name="nominee_nid_attachment" class="form-control" style="padding-top:3px;padding-left: 3px;"/>
						</div>	
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Relation</label>
							<select name="nominee_relation" class="form-control select2">
								<option value="">select</option>
								<option value="Father">Father</option>
								<option value="Mother">Mother</option>
								<option value="Brother">Brother</option>
								<option value="Sister">Sister</option>
								<option value="Cousin">Cousin</option>
								<option value="Friends">Friends</option>
								<option value="Husband">Husband</option>
								<option value="Wife">Wife</option>
								<option value="Uncle">Uncle</option>
								<option value="Aunti">Aunti</option>
								<option value="Daughter">Daughter</option>
								<option value="Son">Son</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Choose Image</label>
							<input type="file" name="nominee_images" class="form-control" style="padding-top:3px;padding-left: 3px;"/>
						</div>	
					</div>
				</div>
				
				<div class="form-group">
					<label>Address</label>
					<textarea name="nominee_address" class="form-control" placeholder="Address"></textarea>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<h4 style="text-decoration:underline;">Invest Information</h4>
			</div>
			<div class="col-sm-9">
				<div class="row">					
					<div class="col-sm-4">
						<div class="form-group">
							<label>Total Amount</label>
							<input type="text" name="actual_total_amount" value="<?php echo $total_price['total_price']; ?>" class="form-control" readonly />
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group" id="card_number_div">
							<label>Card Number</label>
							<input type="text" name="card_number" id="card_number" class="form-control" placeholder="Card Number" required />
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label>Aggrement</label>
							<input type="file" name="ipo_attachment[]" class="form-control" required="required" style="padding-top:3px;padding-left: 3px;"/>
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<textarea name="note" placeholder="Note / Remarks" class="form-control"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-12" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
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
				</div>
			</div>
			
		</div>
<script>
$('document').ready(function(){
	$("#finish_booking").prop("disabled", true);
	$('#total_amount_large').html(formatCurrency("<?php echo $total_price['total_price']; ?>")); 
	$("#booking_total_amount").val(parseFloat("<?php echo $total_price['total_price']; ?>"));
	$("#booking_total_amount_c").val(parseFloat("<?php echo $total_price['total_price']; ?>"));
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
			$("#finish_booking").prop("disabled", false);
		}else{
			$("#finish_booking").prop("disabled", true);
		}
	});
})
</script>
		<input type="hidden" id="booking_total_amount" title="total" name="booking_total_amount" value=""/>
		<input type="hidden" id="booking_total_amount_c" title="total" name="booking_total_amount_c" value=""/>
		<div class="row">
			<div class="col-sm-12" style="margin-bottom:15px;">
				
			</div>			
		</div>
		
		<div class="row">
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
		
		<div class="modal-footer justify-content-between">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			<p class="ml-2" id="error_msg"></p>
			<div id="test_otp">
				<!-- <button type="submit" id="finish_booking" class="btn btn-primary">Save</button> -->
				<button type="button" id="get_otp" class="btn btn-primary" onclick="get_investment_otp()">Send Otp</button>
			</div>
			<!-- <button type="submit" id="finish_booking" class="btn btn-primary">Save</button> -->
		</div>
		
	</div>
</div>



<?php } else {  ?>




<div class="row">
	<div class="col-sm-12">
		<center>
			<b style="color:#f00;">Cart is Emplty!</b>
		</center>
	</div>
</div>	
<?php } } ?>










<?php
if(isset($_POST['add_qty_bed_cart'])){
	if($_POST['add_qty_bed_cart'] == 'NaN'){
?>
<style>
.qty .count_qty { color: #000; display: inline-block; vertical-align: top; font-size: 25px; font-weight: 700; line-height: 30px; padding: 0 2px; min-width: 35px; text-align: center; } .qty .plus { cursor: pointer; display: inline-block; vertical-align: top; color: white; width: 30px; height: 30px; font: 30px/1 Arial,sans-serif; text-align: center; border-radius: 50%; } .qty .minus { cursor: pointer; display: inline-block; vertical-align: top; color: white; width: 30px; height: 30px; font: 30px/1 Arial,sans-serif; text-align: center; border-radius: 50%; background-clip: padding-box; } .qty .minus:hover{ background-color: #717fe0 !important; } .qty .plus:hover{ background-color: #717fe0 !important; } .qty span{ -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; } .qty input{ border: 0;  width: 2%; } .qty input::-webkit-outer-spin-button, .qty input::-webkit-inner-spin-button { -webkit-appearance: none;  margin: 0; } .qty input:disabled{ background-color:white; }
</style>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<button class="btn btn-info" type="button" style="width:100%;font-size:23px;">General Investment</button>
		</div>
		<div>	
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Client Type</span>
					</div>
					<select name="client_type" id="client_type" onchange="return ipo_money_management()"  class="form-control select2" style="text-align-last:center;font-size:20px;color:#f00;" required>
						<option value="Clients">Clients</option>
						<option value="Employee">Employee</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Price</span>
					</div>
					<input type="text" onfocusout="return ipo_money_management()" name="ipo_price" id="ipo_price" value="50000" placeholder="Price" class="form-control" style="text-align:center;font-size:20px;color:#f00;" required />
				</div>
			</div>
		</div>
		<div class="qty" style="margin-top:15px; margin-bottom: 16px; ">
			<div class="form-group">
				<div id="qty_alert" class="text-danger"></div>
				<div class="input-group">
					<div class="input-group-prepend" style="float:left;">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Quantity</span>
					</div>
					<div style="float:left;width:316px;padding-top: 4px;">
						<center>
							<span class="minus bg-dark" onclick="return qty_remove()">-</span>
							<input type="number" class="count_qty" name="qty" value="10" min="10">
							<span class="plus bg-dark" onclick="return qty_add()">+</span>
						</center>
					</div>
				</div>
			</div>			
		</div>
		<div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Rate</span>
					</div>
					<input type="text" name="ipo_rate" id="ipo_rate" value="0" placeholder="Rate" class="form-control" style="text-align:center;font-size:20px;color:#f00;" readonly />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Interest<small>(%)</small></span>
					</div>
					<input type="text" name="ipo_commission" id="ipo_commission" value="15" placeholder="Interest" class="form-control" style="text-align:center;font-size:20px;color:#f00;" readonly />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Agreement</span>
					</div>
					<select name="agreement_type" id="agreement_type" onchange="ipo_money_management()" class="form-control select2" style="text-align-last:center;font-size:20px;color:#f00;" required>
						<option value="Yearly">Yearly</option>
						<option value="Monthly">Monthly</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Tenure</span>
					</div>
					<input type="number" name="tenure" id="tenure" value="1" min="1" class="form-control" style="text-align:center;font-size:20px;color:#f00;" required />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Exp:Date</span>
					</div>
					<input type="text" name="expirity_date" id="expirity_date" value="<?php echo date('Y-m-d', strtotime( date('Y-m-d') . ' + 1 Years' )); ?>" class="form-control"  style="text-align:center;font-size:20px;color:#f00;" readonly />
				</div>					
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight:bolder;width:150px;">Transaction Type</span>
					</div>
					<select name="transaction_type" id="transaction_type" onchange="ipo_money_management()" class="form-control select2" style="text-align-last:center;font-size:20px;color:#f00;" required>
						<option value="1">Only Profit</option>
						<?php /* ?><option value="2">Only Principal</option><?php */ ?>
						<option value="3">Principal + Profit</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<button onclick="return goto_registration_general_investment()" type="button" class="btn btn-info" style="float:right;"><i class="fas fa-forward"></i> Goto Registration</button>
			</div>
		</div>
	</div>
	
</div>
<script>
	function goto_registration_general_investment(){
		let qty_alert = false;
		var client_type = $('select[name="client_type"]').val();
		// if(client_type === 'Clients'){
		// 	if($('input[name="qty"]').val() < 10){
		// 		qty_alert = true;
		// 		$('#qty_alert').html("Minimum Amount 10!!");
		// 	}
		// }else if(client_type === 'Employee'){
		// 	if($('input[name="qty"]').val() < 2){
		// 		qty_alert = true;
		// 		$('#qty_alert').html("Minimum Amount 2!!");
		// 	}
		// }
		if(!qty_alert){
			var category = 'General Investment';		
			var ipo_price = $('input[name="ipo_price"]').val();
			var qty = $('input[name="qty"]').val();
			var ipo_rate = $('input[name="ipo_rate"]').val();		
			var ipo_commission = $('input[name="ipo_commission"]').val();
			var agreement_type = $('select[name="agreement_type"]').val();
			var tenure = $('input[name="tenure"]').val();
			var expirity_date = $('input[name="expirity_date"]').val();
			var transaction_type = $('select[name="transaction_type"]').val();
			
			return add_to_shopping_cart_v2(category, client_type, ipo_price, qty, ipo_rate, ipo_commission, agreement_type, tenure, expirity_date, transaction_type);	
		}
			
	}
	function ipo_money_management(){
		var client_type = $('select[name="client_type"]').val();
		var price = $('input[name="ipo_price"]').val();
		if(client_type == 'Clients'){
			if(price < 50000){
				$('input[name="ipo_price"]').val('50000');
				var price_c = 50000;
			}else{
				var price_c = price;
			}
		}else{
			if(price < 10000){
				$('input[name="ipo_price"]').val('10000');
				var price_c = 10000;
			}else{
				var price_c = price;
			}
		}
		
		if($("#agreement_type").val() == 'Yearly'){
			$("#transaction_type option[value='1']").hide();
			//$("#transaction_type option[value='2']").hide();
			$("#transaction_type").val(3);
		}else{
			
			$("#transaction_type option[value='1']").show();
			//$("#transaction_type option[value='2']").show();
			//$("#transaction_type").val($("#transaction_type").val());
		}
		
		if($("#agreement_type").val() == 'Monthly' && $("#transaction_type").val() == '1'){
			$('input[name="ipo_commission"]').val(14);
		}else{
			$('input[name="ipo_commission"]').val(15);
		}
		
		var qty = $('input[name="qty"]').val();
		var total = price_c * qty;
		$('input[name="ipo_rate"]').val(total);		
	}
	function qty_add(){
		$(".count_qty").val(parseInt($(".count_qty").val()) + 1 );
		ipo_money_management();
	}
	function qty_remove(){
		$(".count_qty").val(parseInt($(".count_qty").val()) - 1 );
		if ($(".count_qty").val() == 0) {
			$(".count_qty").val(1);
		}
		ipo_money_management();
	}
	$('document').ready(function(){
		ipo_money_management();
	})
</script>
<?php
		
	}else{
	$rand = rand() * time();
	$bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$_POST['add_qty_bed_cart']."'"));
	$room = mysqli_fetch_assoc($mysqli->query("select * from rooms where id = '".$bed['room_id']."'"));
	$category = mysqli_fetch_assoc($mysqli->query("select * from ipo_category where category_name = '".$room['note']."'"));
	$unique_id_rpe = $bed['id'].$rand;
?>
<?php if(!empty($category['id'])){ ?>
<style>
.qty_<?php echo $unique_id_rpe; ?> .count_qty_<?php echo $unique_id_rpe; ?> { color: #000; display: inline-block; vertical-align: top; font-size: 25px; font-weight: 700; line-height: 30px; padding: 0 2px; min-width: 35px; text-align: center; } .qty_<?php echo $unique_id_rpe; ?> .plus_<?php echo $unique_id_rpe; ?> { cursor: pointer; display: inline-block; vertical-align: top; color: white; width: 30px; height: 30px; font: 30px/1 Arial,sans-serif; text-align: center; border-radius: 50%; } .qty_<?php echo $unique_id_rpe; ?> .minus_<?php echo $unique_id_rpe; ?> { cursor: pointer; display: inline-block; vertical-align: top; color: white; width: 30px; height: 30px; font: 30px/1 Arial,sans-serif; text-align: center; border-radius: 50%; background-clip: padding-box; } .qty_<?php echo $unique_id_rpe; ?> .minus_<?php echo $unique_id_rpe; ?>:hover{ background-color: #717fe0 !important; } .qty_<?php echo $unique_id_rpe; ?> .plus_<?php echo $unique_id_rpe; ?>:hover{ background-color: #717fe0 !important; } .qty_<?php echo $unique_id_rpe; ?> span{ -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; } .qty_<?php echo $unique_id_rpe; ?> input{ border: 0;  width: 2%; } .qty_<?php echo $unique_id_rpe; ?> input::-webkit-outer-spin-button, .qty_<?php echo $unique_id_rpe; ?> input::-webkit-inner-spin-button { -webkit-appearance: none;  margin: 0; } .qty_<?php echo $unique_id_rpe; ?> input:disabled{ background-color:white; }
</style>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<button class="btn btn-info" type="button" style="width:100%;font-size:23px;"><?php echo $bed['bed_name']; ?></button>
		</div>
		<input type="hidden" id="ipo_add_cart_bed_id_<?php echo $unique_id_rpe; ?>" value="<?php echo $bed['id']; ?>"/>
		<div class="form-group">
			<div class="qty_<?php echo $unique_id_rpe; ?>" style="margin-top:15px; margin-bottom: 16px; ">
				<center>
					<span class="minus_<?php echo $unique_id_rpe; ?> bg-dark">-</span>
					<input type="number" class="count_qty_<?php echo $unique_id_rpe; ?>" name="qty_<?php echo $unique_id_rpe; ?>" value="1">
					<span class="plus_<?php echo $unique_id_rpe; ?> bg-dark" style="background-color:#eee !important;">+</span>
				</center>
			</div>
			<div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight:bolder;">Package</span>
						</div>
						<input type="text" name="bet_type_<?php echo $unique_id_rpe; ?>" id="bet_type_<?php echo $unique_id_rpe; ?>" value="<?php echo $category['category_name']; ?>" class="form-control" style="text-align:center;font-size:20px;color:#f00;" readonly />
					</div>					
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight:bolder;">Rate</span>
						</div>
						<input type="text" name="ipo_rate_<?php echo $unique_id_rpe; ?>" id="ipo_rate_<?php echo $unique_id_rpe; ?>" value="<?php echo $category['price']; ?>" placeholder="Price" class="form-control" style="text-align:center;font-size:20px;color:#f00;" readonly />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight:bolder;">Profit</span>
						</div>
						<input type="text" name="ipo_commission_<?php echo $unique_id_rpe; ?>" id="ipo_commission_<?php echo $unique_id_rpe; ?>" value="<?php echo $category['ipo_profit']; ?>%" placeholder="Commission" class="form-control" style="text-align:center;font-size:20px;color:#f00;" readonly />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight:bolder;">Agreement</span>
						</div>
						<select name="agreement_type" id="agreement_type_<?php echo $unique_id_rpe; ?>" class="form-control select2" style="text-align:center;font-size:20px;color:#f00;" required>
							<option value="Yearly">Yearly</option>
							<option value="Monthly">Monthly</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight:bolder;">Tenure</span>
						</div>
						<input type="number" name="tenure" id="tenure_<?php echo $unique_id_rpe; ?>" value="1" min="1" class="form-control" style="text-align:center;font-size:20px;color:#f00;" required />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight:bolder;">Exp:Date</span>
						</div>
						<input type="date" name="expirity_date" id="expirity_date_<?php echo $unique_id_rpe; ?>" value="<?php echo date('Y-m-d', strtotime( date('Y-m-d') . ' + 1 Years' )); ?>" class="form-control"  style="text-align:center;font-size:20px;color:#f00;" readonly />
					</div>					
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="modal-footer justify-content-between" style="padding:0px;">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			<button type="button" class="add_to_cart_ipo_<?php echo $unique_id_rpe; ?> btn btn-primary"><i class="fas fa-cart-plus"></i> Add to Cart</button>
		</div>
	</div>
</div>



<script>
$(document).ready(function(){
	$('select[name="agreement_type"]').on("change", function(){
		if($(this).val() == 'Monthly' ){
			$('input[name="tenure"]').val('1');
			$('input[name="tenure"]').prop('disabled', true);
			var year = 1;
			$.ajax({  
				url:"<?php echo $home; ?>assets/ajax/option_select/tenure_to_exoirity_date_update.php",
				method:"POST",
				data:{ year:year },
				success:function(data){
					$('input[name="expirity_date"]').val(data);
				}  
			});
		}else{
			$('input[name="tenure"]').prop('disabled', false);
		}
	})
	$('input[name="tenure"]').on("change keyup", function(){
		var year = $(this).val();
		if(year != ''){
			$.ajax({  
				url:"<?php echo $home; ?>assets/ajax/option_select/tenure_to_exoirity_date_update.php",
				method:"POST",
				data:{ year:year },
				success:function(data){
					$('input[name="expirity_date"]').val(data);
				}  
			});
		}else{
			alert('Need minimum value 1');
		}
	})
	
	$(".count_qty_<?php echo $unique_id_rpe; ?>").prop('disabled', true);
	/*
	$(document).on('click','.plus_<?php echo $unique_id_rpe; ?>',function(){		
		$(".count_qty_<?php echo $unique_id_rpe; ?>").val(parseInt($(".count_qty_<?php echo $unique_id_rpe; ?>").val()) + 1 );
		var result_<?php echo $unique_id_rpe; ?> = $(".count_qty_<?php echo $unique_id_rpe; ?>").val() * <?php echo $category['price']; ?>;
		$("#ipo_rate_<?php echo $unique_id_rpe; ?>").val(result_<?php echo $unique_id_rpe; ?>);
	});
	$(document).on('click','.minus_<?php echo $unique_id_rpe; ?>',function(){
		$(".count_qty_<?php echo $unique_id_rpe; ?>").val(parseInt($(".count_qty_<?php echo $unique_id_rpe; ?>").val()) - 1 );
		var result_<?php echo $unique_id_rpe; ?> = $(".count_qty_<?php echo $unique_id_rpe; ?>").val() * <?php echo $category['price']; ?>;
		$("#ipo_rate_<?php echo $unique_id_rpe; ?>").val(result_<?php echo $unique_id_rpe; ?>);
		if ($(".count_qty_<?php echo $unique_id_rpe; ?>").val() == 0) {
			$(".count_qty_<?php echo $unique_id_rpe; ?>").val(1);
			$("#ipo_rate_<?php echo $unique_id_rpe; ?>").val('<?php echo $category['price']; ?>');
		}		
	});
	*/
	$(document).on("click",".add_to_cart_ipo_<?php echo $unique_id_rpe; ?>",function(){
		var bed_id = $("#ipo_add_cart_bed_id_<?php echo $unique_id_rpe; ?>").val();
		var quantity = $(".count_qty_<?php echo $unique_id_rpe; ?>").val();
		var ipo_price = "<?php echo $category['price']; ?>";
		var price = $("#ipo_rate_<?php echo $unique_id_rpe; ?>").val();
		var category = $("#bet_type_<?php echo $unique_id_rpe; ?>").val();	
		
		var commission = $("#ipo_commission_<?php echo $unique_id_rpe; ?>").val();		
		var aggrement_type = $("#agreement_type_<?php echo $unique_id_rpe; ?>").val();		
		var tenure = $("#tenure_<?php echo $unique_id_rpe; ?>").val();		
		var expirity_date = $("#expirity_date_<?php echo $unique_id_rpe; ?>").val();
		
		return add_to_shopping_cart(bed_id, ipo_price, quantity, price, category, commission, aggrement_type, tenure, expirity_date);
	});
});

</script>
<?php } else { ?>
<div class="row">
	<div class="col-sm-12">
		<center>
			<b><?php echo $room['note']; ?></b>
			<br />
			<b style="font-weight:bolder;color:#f00;">Category Not Match/ Not Found in<br />Ipo Category!</b>
		</center>
	</div>
</div>
<?php
		} 
	}
} 
?>





<?php
function cart_data_function(){ global $mysqli; ?>
	<?php 
	$total_number = mysqli_fetch_assoc($mysqli->query("select sum(qty) as total_number from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'"));
	if(!empty($_SESSION['cart_gen_code']) AND $total_number['total_number'] > 0){ ?>
	<div class="row">
		<div class="col-sm-12" style="max-height:400px;overflow-y:scroll;">
			<table class="table table-sm table-bordered">
				<thead>
					<tr>
						<th>Iteam</th>
						<th>Quantity</th>
						<th>Subtotal</th>
						<th><i class="fas fa-trash-alt"></i></th>
					</tr>
				</thead>
				<tbody>
<?php
$sql = $mysqli->query("select * from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'");
while($row = mysqli_fetch_assoc($sql)){
?>				
					<tr>
						<td><?php echo $row['bed_name']; ?></td>
						<td><?php echo $row['qty']; ?></td>
						<td><?php echo $row['price']; ?></td>
						<td><button onclick="return remove_ipo_cart_item(<?php echo $row['id']; ?>)" type="button" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button></td>
					</tr>
<?php } 
$total = mysqli_fetch_assoc($mysqli->query("select sum(price) as total from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'"));
?>
					<tr>
						<td></td>
						<td>Total:</td>
						<td><?php echo $total['total']; ?></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="modal-footer justify-content-between" style="padding:0px;">
				<button onclick="return ipo_cart_clear()" type="button" class="btn btn-danger"><i class="fas fa-times"></i> Clear Cart</button>
				<button onclick="return get_bet_and_open_form('NO')" type="button" class=" btn btn-primary"><i class="fas fa-forward"></i> Goto Registration</button>
			</div>
		</div>
	</div>
	__________<?php echo $total_number['total_number']; ?>
<?php } else{ ?>	
	<div class="row">
		<div class="col-sm-12">
			<center>
				<b>IPO Cart is Empty!</b>
			</center>
		</div>
	</div>__________0
<?php } ?>
<?php }
if(isset($_POST['ipo_cart_clear_single'])){
	if($mysqli->query("delete from ipo_cart where id = '".$_POST['ipo_cart_clear_single']."'")){
		echo cart_data_function();
	}
}
if(isset($_POST['ipo_cart_clear'])){
	if($mysqli->query("delete from ipo_cart where generate_id = '".$_SESSION['cart_gen_code']."'")){
		echo cart_data_function();
	}
} 
if(isset($_POST['get_cart_info'])){
	echo cart_data_function();
}
if(isset($_POST['cart_generate_code_submit'])){
	if($_POST['direct_ipo_registration'] == 'YES'){
		$code = $_POST['cart_generate_code_submit'];
		$session_id = $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
		$category = $_POST['category'];
		$client_type = $_POST['client_type'];
		$ipo_price = $_POST['ipo_price'];
		$qty = $_POST['qty'];
		$ipo_rate = $_POST['ipo_rate'];
		$ipo_commission = $_POST['ipo_commission'];
		$agreement_type = $_POST['agreement_type'];
		$tenure = $_POST['tenure'];
		$expirity_date = $_POST['expirity_date'];
		$transaction_type = $_POST['transaction_type'];
		if($mysqli->query("insert into ipo_cart values(
			'',
			'".$session_id."',
			'".$code."',
			'".$client_type."',			
			'".$transaction_type."',
			'".$ipo_price."',
			'".$qty."',
			'".$ipo_rate."',
			'".$category."',
			'".$ipo_commission."',
			'".$agreement_type."',
			'".$tenure."',
			'".$expirity_date."'
		)")){
			echo '1';
		}else{
			echo '0';
		}
	}else{
		$code = $_POST['cart_generate_code_submit'];
		$session_id = $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
		$bed_id = $_POST['bed_id_to_cart'];
		$qty = $_POST['quantity'];
		$ipo_price = $_POST['ipo_price'];	
		$price = $_POST['price'];	
		$type = $_POST['category'];
		$commission = $_POST['commission'];
		$aggrement_type = $_POST['aggrement_type'];
		$tenure = $_POST['tenure'];
		$expirity_date = $_POST['expirity_date'];
		
		$bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$bed_id."'"));
		$mysqli->query("insert into ipo_cart values (
			'',
			'".$session_id."',
			'".$code."',
			'".$bed_id."',
			'".$bed['bed_name']."',
			'".$ipo_price."',
			'".$qty."',
			'".$price."',
			'".$type."',
			'".$commission."',
			'".$aggrement_type."',
			'".$tenure."',
			'".$expirity_date."'
		)");
		echo cart_data_function();
	}
} ?>