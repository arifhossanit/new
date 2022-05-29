<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['profile_id']."'"));
$cencel_request = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where booking_id = '".$row['booking_id']."' and note = 'Request For Cancel for rental payment issue (auto cancel from software)'"));
?>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-4">
				<input type="hidden" name="money" value="<?php echo $row['security_deposit']; ?>"/>
				<input type="hidden" name="member_id" value="<?php echo $row['id']; ?>"/>
				<input type="hidden" name="uploader_info" value="<?php echo $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']; ?>"/>
				<div class="form-group">
					<label>Attachment (if need)</label>
					<input type="file" name="attachment" class="form-control" style="padding-top:3px;" />
				</div>
				<div class="form-group">
					<label>Note</label>
					<textarea name="note" placeholder="Note" class="form-control"></textarea>
				</div>
<?php if(empty($cencel_request['booking_id'])){ ?>				
				<div style="width:100%;display:none;" id="otp_area">
					<input type="hidden" name="get_opt" value=""/>
					<div class="form-group">
						<label>Write OTP <span id="otp_loader"></span></label>
						<input type="text" onkeyup="return check_otp_matching()" name="write_opt" id="write_opt" class="form-control" placeholder="OTP: xxxx" autocomplete="off"/> <!---->
					</div>
					<div id="message_area"></div>
				</div>
<?php } ?>				
			</div>
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
						<div class="form-group" style="margin:0px;">
							<label style="margin-bottom:0px;"><i class="fas fa-calculator"></i> Total Amount</label>
							<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
							<div id="total_amount_large" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">
								<?php echo money($row['security_deposit']); ?>
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
											<select id="agent1" name="agent[]" class="form-control">
												<option value="">select agent</option>
												<option value="Bikash">bKash</option>
												<option value="Rocket">Rocket</option>
												<option value="Nogod">Nogod</option>
											</select>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" id="mobile_banking_number1" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" id="transaction_id1" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="number" id="mobile_amount1" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
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
											<input type="number" id="check_amount1" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
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
											<input type="month" id="Expiry_Date1" name="Expiry_Date[]" placeholder="Expiry Date" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" class="form-control"/>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="number" id="card_amount1" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
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
											<input type="number" id="cash_amount1" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
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
	<div class="col-sm-12">
		<span id="amount_message" style="float:right;"></span>
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
		
	
	if(parseInt($('input[name="money"]').val()) == written_amount ){
		if($('input[name="get_opt"]').val() != ''){
			if($('input[name="get_opt"]').val() == $('input[name="write_opt"]').val()){
				$("#form_submit").prop("disabled", false);
				$("#amount_message").html('<b style="color:green;">Done!</b>');
			}else{
				$("#form_submit").prop("disabled", true);
				$("#amount_message").html('<b style="color:red;">OTP Not Match!</b>');
			}	
		}else{
			$("#form_submit").prop("disabled", false);
			$("#amount_message").html('<b style="color:red;">Input OTP!</b>');
		}		
	}else{
		$("#form_submit").prop("disabled", true);
		$("#amount_message").html('<b style="color:#f00;">Please Input Right Amount!</b>');
	}	

});
$(document).ready(function(){
	$("#form_submit").prop("disabled", true);
})



<?php 
if(empty($cencel_request['booking_id'])){
if(!empty($_POST['check_sms_verify']) AND $_POST['check_sms_verify'] == 'true'){ ?>
	function resend_otp(){
		var number = "<?php echo $row['phone_number']; ?>";
		if(number != ''){
			$.ajax({  
				url:"<?php echo $home.'assets/ajax/option_select/member_final_check_out_otp.php'; ?>",  
				method:"POST",  
				data:{number:number},
				beforeSend:function(){					
					$('#otp_loader').html('<i class="fas fa-spinner fa-pulse"></i>');		
					$("#form_submit").prop("disabled", true);
				},
				success:function(data){	
					$('#otp_loader').html('');
					var value = data.split('_____');
					if(value[0] == '1'){
						$('input[name="get_opt"]').val(value[2]);
						$("#message_area").html(value[1]);
						$("#otp_area").css({"display":"block"});
					}else{
						$('input[name="get_opt"]').val('');
						$("#message_area").html(value[1]);
						$("#otp_area").css({"display":"none"});
					}
					
				}
			}); 
		}else{
			alert('member Phone Number not Found!');
		}
	}
	function check_otp_matching(){
		$('input[placeholder="Amount"]').val('');
		/*
		if($('input[name="get_opt"]').val() != ''){
			if($('input[name="get_opt"]').val() == $('input[name="write_opt"]').val() ){
				$("#form_submit").prop("disabled", false);
			}else{
				$("#form_submit").prop("disabled", true);
			}	
		}else{
			$("#form_submit").prop("disabled", false);
		}
		*/
	}
	$('document').ready(function(){
		var number = "<?php echo $row['phone_number']; ?>";
		if(number != ''){
			$.ajax({  
				url:"<?php echo $home.'assets/ajax/option_select/member_final_check_out_otp.php'; ?>",  
				method:"POST",  
				data:{number:number},
				beforeSend:function(){					
					$('#otp_loader').html('<i class="fas fa-spinner fa-pulse"></i>');	
					$("#form_submit").prop("disabled", true);
				},
				success:function(data){	
					$('#otp_loader').html('');
					var value = data.split('_____');
					if(value[0] == '1'){
						$('input[name="get_opt"]').val(value[2]);
						$("#message_area").html(value[1]);
						$("#otp_area").css({"display":"block"});
					}else{
						$('input[name="get_opt"]').val('');
						$("#message_area").html(value[1]);
						$("#otp_area").css({"display":"none"});
					}
					
				}
			}); 
		}else{
			alert('member Phone Number not Found!');
		}
	})
<?php } } ?>
function payment_function_on_change(){
	if($("#payment_method1").val() == 'Mobile Banking'){
		$("#mobile_banking1").css({"display":"flex"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',true);
		$('input[id="mobile_banking_number1"]').prop('required',true);
		$('input[id="transaction_id1"]').prop('required',true);
		$('input[id="mobile_amount1"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---		
		
	}else if($("#payment_method1").val() == 'Check'){
		$("#mobile_banking1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#check_number1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',true);
		$('input[id="check_number1"]').prop('required',true);
		$('input[id="withdraw_date1"]').prop('required',true);
		$('input[id="check_amount1"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---		
		
	}else if($("#payment_method1").val() == 'Credit / Debit Card'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1[]"]').prop('required',true);
		$('input[id="Expiry_Date1"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---	
		
	}else if($("#payment_method1").val() == 'Cash'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"flex"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',true);
		//-----cash---
		
	}else{
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
	 //-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---
		
	}
	
	if($("#payment_method12").val() == 'Mobile Banking'){
		$("#mobile_banking12").css({"display":"flex"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',true);
		$('input[id="mobile_banking_number12"]').prop('required',true);
		$('input[id="transaction_id12"]').prop('required',true);
		$('input[id="mobile_amount12"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method12").val() == 'Check'){
		$("#mobile_banking12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#check_number12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
		
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',true);
		$('input[id="check_number12"]').prop('required',true);
		$('input[id="withdraw_date12"]').prop('required',true);
		$('input[id="check_amount12"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method12").val() == 'Credit / Debit Card'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',true);
		$('input[id="Expiry_Date12"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
		
		
	}else if($("#payment_method12").val() == 'Cash'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"flex"});
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',true);
		//-----cash---
		
	}else{
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
		
	}
	
	if($("#payment_method13").val() == 'Mobile Banking'){
		$("#mobile_banking13").css({"display":"flex"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',true);
		$('input[id="mobile_banking_number13"]').prop('required',true);
		$('input[id="transaction_id13"]').prop('required',true);
		$('input[id="mobile_amount13"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method13").val() == 'Check'){
		$("#mobile_banking13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#check_number13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',true);
		$('input[id="check_number13"]').prop('required',true);
		$('input[id="withdraw_date13"]').prop('required',true);
		$('input[id="check_amount13"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method13").val() == 'Credit / Debit Card'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',true);
		$('input[id="Expiry_Date13"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method13").val() == 'Cash'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"flex"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',true);
		//-----cash---
		
	}else{
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
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
			dataq += '<select id="agent1'+counter_payment+'" name="agent[]" class="form-control">';
			dataq += '<option value="">select agent</option>';
			dataq += '<option value="Bikash">bKash</option>';
			dataq += '<option value="Rocket">Rocket</option>';
			dataq += '<option value="Nogod">Nogod</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="mobile_banking_number1'+counter_payment+'" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';			
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="transaction_id1'+counter_payment+'" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="mobile_amount1'+counter_payment+'" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="check_number1'+counter_payment+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="bank_name1'+counter_payment+'" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';			
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="check_number1'+counter_payment+'" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="date" id="withdraw_date1'+counter_payment+'" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="check_amount1'+counter_payment+'" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="credit_card1'+counter_payment+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="credit_card_number1'+counter_payment+'" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<input type="hidden" name="card_secret[]" value="0"/>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="month" id="Expiry_Date1'+counter_payment+'" name="Expiry_Date[]" placeholder="Expiry Date" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="card_amount1'+counter_payment+'" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="cash1'+counter_payment+'" style="display:none;">';
			dataq += '<div class="col-sm-9">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<textarea id="cash_other_information_remarks1'+counter_payment+'" name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>';											
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" type="text" id="cash_amount1'+counter_payment+'" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
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