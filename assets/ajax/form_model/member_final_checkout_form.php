<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['book_id'])){ 

$member_directory_id = $_POST['book_id'];
$sql = $mysqli->query("select sub_package_category.id, sub_package_category.sub_package_name,  member_directory.full_name
	from 
	member_directory 
	left join packages on packages.id = member_directory.package 
	left join sub_package_category on packages.sub_category_id = sub_package_category.id
    where member_directory.id='$member_directory_id' and sub_package_category.id in(1,2,3,12,13,14)
");
$current_member = mysqli_fetch_assoc($sql);

$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['book_id']."'"));


$package_info = mysqli_fetch_assoc($mysqli->query("select package_category_name from booking_info where id = '".$_POST['book_id']."'"));
$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$member_info['bed_id']."'"));
$rent_info = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$member_info['booking_id']."' order by id desc"));
if($member_info['card_number'] == 'Unauthorized'){ ?>
<div class="row">
	<div class="col-sm-12">
		<h1 style="text-align:center;color:#f00;margin-top: 169px;">Account Unauthorized!<br />Please Athorized It Before Cencel Request</h1>
	</div>	
</div>		
<?php }else{
	
	?>
<div class="row">
	<div class="col-sm-12">
		<form id="withdraw_form" action="#" method="post" enctype="multipart/form-data">
			<input type="hidden" name="member_id" value="<?php echo $member_info['id']; ?>"/>
			<input type="hidden" name="bed_id" value="<?php echo $member_info['id']; ?>"/>
			<input type="hidden" name="uploader_info" value="<?php echo $_POST['uploader_info']; ?>"/>
			<input type="hidden" name="branch_id" value="<?php echo $_POST['branch_id']; ?>"/>
			<div class="row">
				<div class="col-sm-12">
					<span id="withdraw_error_message" style="color:#f00;font-weight:bolder;"></span>
				</div>
			</div>
			<div class="row">				
				<div class="col-sm-9">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Check Out Form</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<table class="table table-sm table-striped">
											<tr>
												<th>Checkout Iteams</th>
												<th>Received</th>
											</tr>
										<input type="hidden" id="diposit_js" name="diposit_js" value="0"/>
										<input type="hidden" id="cid_check" name="nai" value="0"/>
										<input type="hidden" id="addi_amunt" name="addi_amunt" value="0"/>
										<input type="hidden" id="total_amount" name="total_amount" value=""/>
										<?php
										$cql = $mysqli->query("select * from checkout_iteam where branch_id = '".$member_info['branch_id']."' and status = '1'");
										while($cow = mysqli_fetch_assoc($cql)){
										?>
											<tr>
												<td> <?php echo $cow['checkout_iteam']; ?> </td>
												<td> 
													<select name="checkout_iteam[]" id="val_men_<?php echo $cow['id']; ?>" onchange="return manage_cal_<?php echo $cow['id']; ?>(<?php echo $cow['lost_amount']; ?>)" class="form-control" required>
														<option value="0">YES</option> 
														<option value="<?php echo $cow['id']; ?>">NO</option>
													</select>
												</td>
											</tr>
										<script>
											function manage_cal_<?php echo $cow['id']; ?>(amount){
												var val = $("#val_men_<?php echo $cow['id']; ?>").val();
												
												if(val == '0'){
													var total = parseInt($("#diposit_js").val());
													var amount = parseInt("<?php echo $cow['lost_amount']; ?>");
													var ad_amt = parseInt($("#addi_amunt").val());
													var result = total - amount;
													var total_amount = result + ad_amt;													
													$("#total_amount").val(total_amount);
													$("#total_amount_large").html(total_amount);
													$("#diposit_js").val(result);
													var security_d_amt = $("#get_s_d_mww").val();
													var rst_min = security_d_amt - total_amount;
													$("#security_deposit_money").html(rst_min);
													return payment_on_off();
												}else{
													var total = parseInt($("#diposit_js").val());
													var amount = parseInt("<?php echo $cow['lost_amount']; ?>");
													var ad_amt = parseInt($("#addi_amunt").val());
													var result = total + amount;
													var total_amount = result + ad_amt;													
													$("#total_amount").val(total_amount);
													$("#total_amount_large").html(total_amount);
													$("#diposit_js").val(result);
													var security_d_amt = $("#get_s_d_mww").val();
													var rst_min = security_d_amt - total_amount;
													$("#security_deposit_money").html(rst_min);
													return payment_on_off();
												}
											}
										</script>
										<?php } ?>
										</table>										
									</div>									
									<div class="form-group">																					
										<div class="row">
											<div class="col-sm-12">
												<h4 style="text-decoration:underline;">
													Additional Fields	<span id="testaf"></span>							
													<div class="row d-flex" style="float:right;padding-right: 16px;">										
														<button type="button" id='removeButton_af' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
														<button type="button" id='addButton_af' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
													</div>
												</h4>
											</div>
										</div>
										<?php
										$check_cencalation = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where note like '%Request For Cancel for rental payment issue (auto cancel from software)%' AND booking_id = '".$member_info['booking_id']."'"));
										?>
										<div id='UnitBoxesGroup_af'>
											<div id="UnitBoxDiv_af">
												<div class="row">
													
													<?php  if(!empty($check_cencalation['id']) || !empty($current_member)){ ?>
													<div class="col-sm-6">
														<input type="text" name="af_field_name[]" id="af_field_name1" class="form-control" placeholder="Field Name" value="<?php if(!empty($check_cencalation['id'])){ echo 'Deduct Money'; } else{ echo 'Electricity Bill'; } ?>" style="margin-bottom:7px;" readonly/>
													</div>
													<div class="col-sm-6">
														<input type="number" name="af_amount[]" id="af_amount1" class="form-control" min="100" minlength="2" value="<?php if(!empty($check_cencalation['id'])){ echo $member_info['security_deposit']; } ?>" placeholder="Amount" style="margin-bottom:7px;" <?php if(!empty($check_cencalation['id'])){ echo 'readonly'; } else{ echo 'onkeyup="return aditional_amount()" required'; } ?> />
													</div>
													<?php } ?>	
													
													
													
													
													<!--
													<?php if(!empty($current_member)) { ?>
													<div class="col-sm-6">
														<input type="text" name="af_field_name[]" id="af_field_name1" class="form-control" placeholder="Field Name" value="<?php if(!empty($check_cencalation['id'])){ echo 'Deduct Money'; } else{ echo 'Electricity Bill'; } ?>" style="margin-bottom:7px;" readonly/>
													</div>
													<div class="col-sm-6">
														<input type="number" name="af_amount[]" id="af_amount1" class="form-control" minlength="2" value="<?php if(!empty($check_cencalation['id'])){ echo $member_info['security_deposit']; } ?>" placeholder="Amount" style="margin-bottom:7px;" <?php if(!empty($check_cencalation['id'])){ echo 'readonly'; } else{ echo 'onkeyup="return aditional_amount()" required'; } ?> />
													</div>
													<?php } ?>
													-->
													
													
													<?php if(strpos($package_info['package_category_name'], 'Contract') !== false){ ?>
														<?php if(!empty($check_cencalation['id'])){ ?>
															<div class="col-sm-6">
																<input type="text" name="af_field_name[]" id="af_field_name1" class="form-control" placeholder="Field Name" value="<?='Electricity Bill'?>" style="margin-bottom:7px;" readonly/>
															</div>
															<div class="col-sm-6">
																<input type="number" name="af_amount[]" id="af_amount1" class="form-control" minlength="2" placeholder="Amount" style="margin-bottom:7px;" onkeyup="return aditional_amount()" required/>
															</div>
														<?php }else{ ?>
															<?php
																$deduct_or_not = true;
																$rent_count = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as rent_count from rent_info where payment_pattern = '1' AND booking_id = '".$member_info['booking_id']."'"));
																switch($member_info['package_name']){
																	case 'Half Year':
																		if($rent_count['rent_count'] == 6){
																			$deduct_or_not = false;
																		}
																		break;
																	case 'Quarter Year':
																		if($rent_count['rent_count'] == 3){
																			$deduct_or_not = false;
																		}
																		break;
																	case 'One Year':
																		if($rent_count['rent_count'] == 12){
																			$deduct_or_not = false;
																		}
																		break;
																}
															?>
															<?php if($deduct_or_not){ ?>
																<div class="col-sm-6">
																	<input type="text" name="af_field_name[]" id="af_field_name1" class="form-control" placeholder="Field Name" value="Deduct Money" style="margin-bottom:7px;" readonly/>
																</div>
																<div class="col-sm-6">
																	<input type="number" name="af_amount[]" id="af_amount1" class="form-control" minlength="2" placeholder="Amount" style="margin-bottom:7px;"
																		value="<?= (int)$member_info['security_deposit'] > 1000
																					? (int)$member_info['security_deposit'] - 1000
																					: (int)$member_info['security_deposit']?>" readonly/>
																</div>
															<?php } ?>
														<?php } ?>
													<?php } ?>
													
												</div>
											</div>
											<div id="UnitBoxDiv_af1">
												<div class="row">
													<div class="col-sm-6">
														<input type="text" name="af_field_name[]" id="af_field_name1" class="form-control" placeholder="Field Name" value="Tea & Coffee" style="margin-bottom:7px;" readonly/>
													</div>
													<div class="col-sm-6">
														<?php
															$tea_coff = mysqli_fetch_assoc($mysqli->query("select sum(total_amount) as bill from refreshment_item_sell where buyer_id = '".$member_info['card_number']."' and payment_status = 'Due'")); //$booking_info
															if($tea_coff['bill'] > 0 ){
																$bill = $tea_coff['bill'];
															}else{
																$bill = '0';
															}
														?>
														<input type="number" name="af_amount[]" id="af_amount1" class="form-control" minlength="2" value="<?php echo $bill; ?>" placeholder="Amount" style="margin-bottom:7px;" readonly />
													</div>
												</div>
											</div>
											<?php if(!empty($check_cencalation['id'])){ ?>
											<div class="col-sm-12">
												<span style="color:#f00;font-size:10px;">
													N:B: Member is auto cancel, So Deduct Security Diposit Money!
												</span>
											</div>
											<?php } ?>
										</div>									
									</div>									
									<div class="form-group">
										<label>Note / Reason</label>
										<textarea name="note" class="form-control" <?php if(!empty($check_cencalation['id'])){ echo 'required'; } ?>></textarea>
									</div>
									
									<div class="form-group">
										<label>
											<input type="checkbox" onclick="return payment_on_off()" id="force_collect" for="">
											Collect/Receive Money
										</label>
									</div>
									
									<div class="form-group">
										
										<input type="hidden" name="send_sms" value="0"/>									
									</div>
								</div>
								<?php /* ?>
								<input type="hidden" name="get_opt" value=""/>
								<span id="otp_loader"></span>
								<div id="message_area"></div>
								<br />
										<div style="width:100%;display:none;" id="otp_area">
											<input type="text" onkeyup="return check_otp_matching()" name="write_opt" id="write_opt" class="form-control" placeholder="OTP: xxxx"/>
										</div>	
										<?php */ ?>
								<script>
								
									function aditional_amount(){
										var sum = 0;
										var val_a = 0;
										$('input[name="af_amount[]"]').each(function(){											
											val_a = $(this).val();
											if(val_a > 0){
												sum += parseInt(val_a);
											}
										})
										var total = parseInt($("#diposit_js").val());										
										$("#addi_amunt").val(sum);
										var ad_amt = parseInt($("#addi_amunt").val());
										var rst = total + ad_amt;										
										$("#total_amount_large").html(rst);
										$("#total_amount").val(rst);
										var security_d_amt = $("#get_s_d_mww").val();
										var rst_min = security_d_amt - rst;
										$("#security_deposit_money").html(rst_min);										
										return payment_on_off();
									}
								</script>
								<div class="col-sm-6">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-12" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
												<div style="width:100%;">
													<?php echo 'Security Diposit: <span style="color:#f00;" id="security_deposit_money"></span>'; ?>
												</div>
												<div class="form-group" style="margin:0px;">
													<label style="margin-bottom:0px;"><i class="fas fa-calculator"></i> Total Amount</label>
													<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
													<div id="total_amount_large" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">
														
													</div>
												</div>
											</div>
										</div>
									</div>
									
									
									<center style="margin-top:70px;">
										<p style="color:#f00;font-size:30px;">
											All Check required Recommended!
										</p>
										<p id="confrim_card_error_message" style="color:#f00;font-size:30px;display: none;">
											Card Number Did Not Match!
										</p>
									</center>
								</div>
							</div>
							<div class="row" id="payment_information">
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
														<select onchange="return payment_function_on_change()" id="payment_method1" name="payment_method[]" class="form-control">
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
														<div class="col-sm-3">
															<div class="form-group" style="width:100%;">
																<input type="text" id="credit_card_number1" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>
															</div>
														</div>
														
														<div class="col-sm-3">
															<div class="form-group" style="width:100%;">
																<input type="text" id="card_secret1" name="card_secret[]" placeholder="Card secret" autocomplete="off" class="form-control"/>
															</div>
														</div>
														
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
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group" style="display: flex; justify-content: end;">
										<button type="button" id="confirm_card_button" class="btn btn-info" onclick="confirm_checkout_card('<?php echo $member_info['card_number']; ?>')">Confirm Card Number</button>
										<button style="display: none;" id="submit_form_button" onclick=" confirm('Are you sure want to finally checkOut this member?');" type="submit" id="withdraw_button" class="btn btn-warning" style="float:right;">Checkout</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Member Details</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<?php 
									if(!empty($member_info['photo_avater'])){
										echo '<img src="'.$home.$member_info['photo_avater'].'" style="width:100%;" class="image-responsive"/>';
									}else{
										echo '<img src="'.$home.'assets/img/photo_avatar.png" style="width:100%;" class="image-responsive"/>';
									}
									?>								
								</div>
								<div class="col-sm-12">
									<p>&nbsp;</p>
									Name: <b style="float:right;"><?php echo $member_info['full_name']; ?></b><br />
									Card NO: <b style="float:right;"><?php echo $member_info['card_number']; ?></b><br />
									Bed No: <b style="float:right;"><?php echo $member_info['bed_name']; ?></b><br />
									Phone NO: <b style="float:right;"><?php echo $member_info['phone_number']; ?></b><br />
									CheckInDate: <b style="float:right;"><?php echo $member_info['check_in_date']; ?></b><br />
									Package: <b style="float:right;"><?php echo $member_info['package_name']; ?></b><br />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="get_s_d_m" value="<?php echo $member_info['security_deposit']; ?>"/>
			<input type="hidden" id="get_s_d_mww" value=""/>
		</form>
	</div>
</div>




<script>



	
$('document').ready(function(){ 
	var sd_amount = $("#get_s_d_m").val();
	$("#security_deposit_money").html(sd_amount);
	$("#get_s_d_mww").val(sd_amount);
	<?php if(!empty($check_cencalation['id'])){ ?>
	aditional_amount();
	payment_on_off();
	<?php }else{ ?>	
	aditional_amount();
	return payment_on_off();
	<?php } ?>
})
function payment_on_off(){	
	if($("#force_collect").is(':checked')){
		$("#payment_information").css({"display":"block"});
		$("#payment_method1").prop("required", true);			
	}else{
		$("#payment_information").css({"display":"none"});
		$("#payment_method1").prop("required", false);			
	}
}
$("#withdraw_form").on("submit",function(){
	event.preventDefault();
	var form = $('#withdraw_form')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?php echo $home.'assets/ajax/form_submit/check_out_withdraw_submit.php'; ?>",  
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$("#withdraw_button").prop("disabled", true);
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			var value = data.split('____');
			if(value[1] == '1'){
				$('#withdraw_error_message').html(value[0]);
				$("#withdraw_button").prop("disabled", false);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
			}else{
				$('#data_send_success_message').html(value[0]);										
				$('#final_checkout_model').modal('hide');
				$("#withdraw_button").prop("disabled", false);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
				$.ajax({
					type: "POST",
					enctype: 'multipart/form-data',
					url:"<?php echo $home.'assets/ajax/form_submit/checkout_api.php'; ?>",
					data: {card_number: value[2]},
				});
			}
			view_transaction_report(data);
		}
	});
	return false;
})


function payment_function_on_change(){
	if($("#payment_method1").val() == 'Mobile Banking'){
		$("#mobile_banking1").css({"display":"flex"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
		$('select[id="agent1"]').prop('required',true);
		$('input[id="mobile_banking_number1"]').prop('required',true);
		$('input[id="transaction_id1"]').prop('required',true);
		$('input[id="mobile_amount1"]').prop('required',true);
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		$('input[id="cash_amount1"]').prop('required',false);
	}else if($("#payment_method1").val() == 'Check'){
		$("#mobile_banking1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#check_number1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		$('select[id="bank_name1"]').prop('required',true);
		$('input[id="check_number1"]').prop('required',true);
		$('input[id="withdraw_date1"]').prop('required',true);
		$('input[id="check_amount1"]').prop('required',true);
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		$('input[id="cash_amount1"]').prop('required',false);
	}else if($("#payment_method1").val() == 'Credit / Debit Card'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		$('input[id="credit_card_number1[]"]').prop('required',true);
		$('input[id="Expiry_Date1"]').prop('required',true);
		$('input[id="cash_amount1"]').prop('required',false);
	}else if($("#payment_method1").val() == 'Cash'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"flex"});
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		$('input[id="cash_amount1"]').prop('required',true);		
	}else{
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		$('input[id="cash_amount1"]').prop('required',false);
	}
	
	if($("#payment_method12").val() == 'Mobile Banking'){
		$("#mobile_banking12").css({"display":"flex"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
		$('select[id="agent12"]').prop('required',true);
		$('input[id="mobile_banking_number12"]').prop('required',true);
		$('input[id="transaction_id12"]').prop('required',true);
		$('input[id="mobile_amount12"]').prop('required',true);
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		$('input[id="cash_amount12"]').prop('required',false);
	}else if($("#payment_method12").val() == 'Check'){
		$("#mobile_banking12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#check_number12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		$('select[id="bank_name12"]').prop('required',true);
		$('input[id="check_number12"]').prop('required',true);
		$('input[id="withdraw_date12"]').prop('required',true);
		$('input[id="check_amount12"]').prop('required',true);
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		$('input[id="cash_amount12"]').prop('required',false);		
	}else if($("#payment_method12").val() == 'Credit / Debit Card'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		$('input[id="credit_card_number12"]').prop('required',true);
		$('input[id="Expiry_Date12"]').prop('required',true);
		$('input[id="cash_amount12"]').prop('required',false);		
	}else if($("#payment_method12").val() == 'Cash'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"flex"});
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		$('input[id="cash_amount12"]').prop('required',true);		
	}else{
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		$('input[id="cash_amount12"]').prop('required',false);		
	}
	
	if($("#payment_method13").val() == 'Mobile Banking'){
		$("#mobile_banking13").css({"display":"flex"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
		$('select[id="agent13"]').prop('required',true);
		$('input[id="mobile_banking_number13"]').prop('required',true);
		$('input[id="transaction_id13"]').prop('required',true);
		$('input[id="mobile_amount13"]').prop('required',true);
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		$('input[id="cash_amount13"]').prop('required',false);		
	}else if($("#payment_method13").val() == 'Check'){
		$("#mobile_banking13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#check_number13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		$('select[id="bank_name13"]').prop('required',true);
		$('input[id="check_number13"]').prop('required',true);
		$('input[id="withdraw_date13"]').prop('required',true);
		$('input[id="check_amount13"]').prop('required',true);
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		$('input[id="cash_amount13"]').prop('required',false);		
	}else if($("#payment_method13").val() == 'Credit / Debit Card'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		$('input[id="credit_card_number13"]').prop('required',true);
		$('input[id="Expiry_Date13"]').prop('required',true);
		$('input[id="cash_amount13"]').prop('required',false);		
	}else if($("#payment_method13").val() == 'Cash'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"flex"});
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		$('input[id="cash_amount13"]').prop('required',true);		
	}else{
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		$('input[id="cash_amount13"]').prop('required',false);		
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
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="card_secret1'+counter_payment+'" name="card_secret[]" placeholder="Card secret" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
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
			dataq += '<input id="cash_amount1'+counter_payment+'" type="text" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
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
	
	//-------------------additional field-----------
	
	var counter_af = 2;
    $("#addButton_af").click(function () {	
		//if( counter_af == 4 ){
		//	alert("Sorry! Maximum number of field reached");
		//	return false;			
		//}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv_af' + counter_af ,
			class: '',
			style: ''
		});
		
		var data_af = '<div class="row">';
			data_af += '<div class="col-sm-6">';
			data_af += '<input type="text" name="af_field_name[]" id="af_field_name1" class="form-control" placeholder="Field Name" style="margin-bottom:7px;"/>';
			data_af += '</div>';
			data_af += '<div class="col-sm-6">';
			data_af += '<input type="number" name="af_amount[]" onkeyup="return aditional_amount()" id="af_amount1" class="form-control" placeholder="Amount" style="margin-bottom:7px;"/>';
			data_af += '</div>';
			data_af += '</div>';
			

		newTextBoxDiv.after().html(data_af);
		newTextBoxDiv.appendTo("#UnitBoxesGroup_af");
		counter_af++;
		return aditional_amount();
    });
    $("#removeButton_af").click(function () {
		if( counter_af == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter_af--;
        $("#UnitBoxDiv_af" + counter_af).remove();
		return aditional_amount();
    });
	
	//-------------------------------------
</script>		
<?php 
	}
}
?>