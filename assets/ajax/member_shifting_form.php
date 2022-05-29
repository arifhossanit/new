<?php
//error_reporting(0);
include("../../application/config/ajax_config.php");
if(isset($_POST['book_id'])){ 
$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['book_id']."'"));

$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$member_info['bed_id']."'"));
$rooms_info = mysqli_fetch_assoc($mysqli->query("select * from rooms where id = '".$bed_info['room_id']."'"));


	$bed_change_check = mysqli_fetch_assoc($mysqli->query("SELECT * FROM bed_change_info WHERE booking_id = '".$member_info['booking_id']."' AND data like '%".date('m/Y')."' ORDER BY id DESC LIMIT 01"));
	if(isset($_SESSION['super_admin']) AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){
		$can_cange = '1';
	}else{
		if(!empty($bed_change_check['booking_id'])){
			$can_cange = '0';
		}else{
			$can_cange = '1';
		}
	}	
?>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<select name="sifting_topic" onchange="return shipting_topic_change()" id="sifting_topic" class="form-control" required style="font-weight:bolder;color:red;">
						<option value="Bed Shift">Bed Shift</option>
						<?php //if($_SESSION['user_info']['department'] == '816905694932688665'){ ?>
							<option value="Package Shift">Package Shift</option>
						<?php //} ?>
						<option value="Branch Shift">Branch Shift</option>
					</select>
				</div>	
			</div>
			<div class="col-sm-4">
			</div>
			<div id="calculator_container" class="col-sm-4" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
				<div class="form-group" style="margin:0px;">
					<label style="margin-bottom:0px;"><i class="fas fa-calculator"></i> Total Amount</label>
					<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
					<div id="total_amountbed_shifting" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">
						<?php echo money('500'); ?>
					</div>
				</div>
			</div>
			<div id="calculator_container_package" class="col-sm-4" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
				<div class="form-group" style="margin:0px;">
					<label style="margin-bottom:0px;"><i class="fas fa-calculator"></i> Total Amount</label>
					<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
					<div id="total_amountbed_packge_shifting" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-12" id="package_shifting_information">
			<h5>Shifting Information:</h5>
			<div class="row">
				<div class="col-md-4">
					<p class="p-0 m-0"><span class="text-secondary">Recharge Days: </span><span id="recharge_days">  </span></p>
					<p class="p-0 m-0"><span class="text-secondary">Days Stayed: </span><span id="days_stayed">  </span></p>
					<p class="p-0 m-0"><span class="text-secondary">Available Days: </span><span id="available_days">  </span></p>
					<p class="p-0 m-0"><span class="text-secondary">Current Package Rent: </span><span id="currrent_rent">  </span></p>
					<p class="p-0 m-0"><span class="text-secondary">Consumed Rent: </span><span id="consumed_rent">  </span></p>
				</div>
				<div class="col-md-4">
					<p class="p-0 m-0"><span class="text-secondary">New Package Rent: </span><span id="new_rent">  </span></p>					
					<p class="p-0 m-0"><span class="text-secondary">Security Deposit: </span><span id="security_deposit">  </span></p>					
					<p class="p-0 m-0"><span class="text-secondary">Extra Rent: </span><span id="extra_rent">  </span></p>					
					<p class="p-0 m-0"><span class="text-secondary">Discount Amount: </span><span id="discount_amount">  </span></p>					
				</div>
			</div>
		</div>
	</div>
	
	<!--start--bed--shifting-->
	<div class="col-sm-12" id="bed_shifting_container">
		<div class="row">
			<form id="bed_shifting_form" action="#" method="post" enctype="multipart/form-data" style="width:100%;">
				<input type="hidden" name="member_bed_shifting_id" value="<?php echo $member_info['id']; ?>"/>
				<input type="hidden" name="uploader_infoe" value="<?php echo $_POST['uploader_info']; ?>"/>
				<div class="col-sm-12">
					<span id="bed_change_error_message" style="color:red;font-weight:bolder;"></span>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Old Bed</label>
								<input type="text" name="old_bed" id="" value="<?php if(!empty($bed_info['bed_name'])){ echo $bed_info['bed_name']; } ?>" class="form-control" readonly style="font-weight:bolder;font-size:28px;color:red" />
								<input type="hidden" name="old_bed_id" value="<?php if(!empty($bed_info['id'])){ echo $bed_info['id']; } ?>"/>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Choose New Bed</label>
								<input type="text" name="new_bed" id="new_bed_name" onclick="return get_avaible_bed_info()" value="" placeholder="Choose Bed" class="form-control" required style="font-weight:bolder;font-size:28px;color:green;cursor: pointer;" />
								<input type="hidden" name="new_bed_id" id="bed_id" value="" /> 
							</div>
						</div>
						<?php if($can_cange == '0'){ ?>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Amount</label>
								<input type="text" name="bed_change_amount" id="" value="<?php echo money('500'); ?>" class="form-control" readonly/>
							</div>
						</div>
						<?php } else { ?>
						<input type="hidden" name="bed_change_amount" value="0"/>
						<?php } ?>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Date (mm/dd/yyyy)</label>
								<input type="date" name="bed_changing_date" id="" value="" class="form-control" required/>
							</div>
						</div>
					</div>
					
					<div id="bed_payment_container">
					<div class="row" style="width:100%;margin-top: 20px;">
						<div class="col-sm-12">
							<h4 style="text-decoration:underline;">
								Payment Information									
								<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
									<button type="button" id='removeButton_payment_aut' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
									<button type="button" id='addButton_payment_aut' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
								</div>
							</h4>
						</div>
					</div>
					<div id='UnitBoxesGroup_payment_aut' style="width:100%;">
					<div id="UnitBoxDiv_payment_aut1" style="width:100%;">
						<div class="row" style="margin-top: 10px;">
							<div class="col-sm-3">
								<div class="form-group">
									<select onchange="return payment_function_on_change_aut()" id="payment_method_aut1" name="payment_method[]" class="form-control">
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
					
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<button type="submit" name="finally_bed_change" id="finally_bed_change" class="btn btn-success" style="float:right;">Change</button>
							</div>
						</div>
					</div>
					
				</div>
			</form>
		</div>
	</div>
<script>
	$("#bed_shifting_form").on("submit",function(){
		if($("#new_bed_name").val() == ''){
			$("#bed_change_error_message").html('Please choose a bed');
			return false;
		<?php if($can_cange == '0'){ ?> 
		}else if($("#payment_method_aut1").val() == ''){
			$("#bed_change_error_message").html('Please choose Payment Method');
			return false;
		<?php } ?>
		}else{
			event.preventDefault();
			var form = $('#bed_shifting_form')[0];
			var data = new FormData(form);			
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url:"<?php echo $home.'assets/ajax/form_submit/bed_shifting_submit_form.php';?>",  
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				beforeSend:function(){
					$("#finally_bed_change").prop("disabled", true);
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					var value = data.split('____');
					if(value[1] == '1'){
						$('#bed_change_error_message').html(value[0]);
						$("#finally_bed_change").prop("disabled", false);
						$('#booking_data_table').DataTable().ajax.reload( null , false);
					}else{
						$('#data_send_success_message').html(value[0]);										
						$('#Shifting_model').modal('hide');
						$("#finally_bed_change").prop("disabled", false);
						$('#booking_data_table').DataTable().ajax.reload( null , false);
						//return view_profile_from_booking(value[2]);						
					}					
				}
			});
			
			return false;
		}
	})
</script>	
	<!--end--bed--shifting-->
	
	<!--start--Package--shifting package_category        -->
<?php
$package_cat_info = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$member_info['package_category']."'")); 
$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member_info['package']."'"));
	//if($package_info['try_us'] != 1){
?>	
	<div class="col-sm-12" id="Package_shifting_container">
		<div class="row">
			<form id="package_shifting_form" action="#" method="post" enctype="multipart/form-data" style="width:100%;">
				<input type="hidden" name="member_package_shifting_id" value="<?php echo $member_info['id']; ?>"/>
				<input type="hidden" name="uploader_info" value="<?php echo $_POST['uploader_info']; ?>"/>
				<span id="package_change_error_message" style="color:red;font-weight:bolder;"></span>
				<div class="col-sm-12">	
					<div class="row">
						<div class="col-sm-5">
							<div class="row">
								<div class="col-sm-12">
									<h2 style="text-decoration:underline;">From:</h2>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Branch</label>
										<select name="old_branch" id="" class="form-control select2" readonly  style="font-weight:bolder;font-size:20px;color:red" > 
											<option value="<?php if(!empty($member_info['branch_id'])){ echo $member_info['branch_id']; } ?>"><?php if(!empty($member_info['branch_name'])){ echo $member_info['branch_name']; }  ?></option>
										</select>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Package category</label>
										<select name="old_category" id="old_category_shifting" class="form-control select2" readonly>
											<option value="<?php if(!empty($package_cat_info['id'])){ echo $package_cat_info['id']; }  ?>"><?php if(!empty($package_cat_info['package_category_name'])){ echo $package_cat_info['package_category_name']; }  ?></option>
										</select>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Package</label>
										<select name="old_package" id="" class="form-control select2" readonly> 
											<option value="<?php if(!empty($package_info['id'])){ echo $package_info['id']; }  ?>"><?php if(!empty($package_info['package_name'])){ echo $package_info['package_name']; }  ?></option>
										</select>
									</div>
								</div>								
							</div>						
						</div>
						<div class="col-sm-2"></div>
						<div class="col-sm-5">
							<div class="row">
								<div class="col-sm-12">
									<h2 style="text-decoration:underline;">To:</h2>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Branch</label>
										<select name="branch" id="branch" class="form-control select2" style="font-weight:bolder;font-size:20px;color:green;" > 
											<?php
											$br_sql = $mysqli->query("select * from branches");
											while($brw = mysqli_fetch_assoc($br_sql)){
												if($member_info['branch_id'] == $brw['branch_id']){
													$option = 'selected';
												}else{
													$option = 'disabled';
												}												
												echo '<option value="'.$brw['branch_id'].'" '.$option.'>'.$brw['branch_name'].'</option>';
											}
											?>
											
										</select>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Package category</label>
										<select name="package_category" onchange="return get_room_type()" id="package_category" class="form-control select2">										
										</select>
										<input type="hidden" name="psh_room_type" id="psh_room_type" value=""/>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Package</label>
										<select onchange="monthly_rent_calculator(this.value)" name="package_id" id="package_id" class="form-control select2" style="color:green;">
											<option>--select--</option>
										</select>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Shifting Date (mm/dd/yyyy)</label>
										<?php
											$current_month = date('Y-m').'-01';
											$next_month = date_add(date_create($current_month), date_interval_create_from_date_string('1 month'));
											$next_month = date_format($next_month, 'Y-m-d')
										?>
										<input type="date" name="shifting_date" id="" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $next_month; ?>" class="form-control" required /> <!-- min="<?php echo $next_month; ?>" max="<?php echo $next_month; ?>"-->
									</div>
								</div>
								<?php if($member_info['card_number'] != 'Unauthorized'){ ?>
									<div class="col-sm-12">
										<div class="form-group">
											<label>New Card Number</label>
											<input type="number" name="card_number" value="<?php echo $member_info['card_number']; ?>" placeholder="Card Number" required class="form-control"/>
										</div>
									</div>
								<?php }else{ ?>
									<input type="hidden" name="card_number" value="Unauthorized">
								<?php } ?>
							</div>
							<div class="row" id="psf_bed_info_container" style="display:none;">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Old Bed</label>
										<input type="text" name="old_bed" id="" value="<?php if(!empty($bed_info['bed_name'])){ echo $bed_info['bed_name']; } ?>" class="form-control" readonly style="font-weight:bolder;font-size:28px;color:red" />
										<input type="hidden" name="pack_old_bed_id" value="<?php if(!empty($bed_info['id'])){ echo $bed_info['id']; } ?>"/>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Choose New Bed</label>
										<input type="text" name="pack_new_bed" id="pack_new_bed_name" onclick="return get_avaible_bed_info_package_shifting()" value="" placeholder="Choose Bed" class="form-control" readonly style="font-weight:bolder;font-size:28px;color:green;cursor: pointer;" />
										<input type="hidden" name="pack_new_bed_id" id="pack_bed_id" value="" /> 
									</div>
								</div>
							</div>
						</div>
					</div>
<script>
function get_room_type(){
	var package_idd = $("#package_category").val();
	var new_package_idd = $("#old_category_shifting").val();
	if(package_idd != ''){
		$.ajax({  
			url:"<?php echo $home.'assets/ajax/option_select/get_room_type_package_shifting.php'; ?>",  
			method:"POST",  
			data:{ package_id : package_idd},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$("#psh_room_type").val(data);
				if(package_idd != new_package_idd){					
					$("#psf_bed_info_container").css({"display":"flex"});
					$("#pack_new_bed_name").attr('readonly', true);
					$("#pack_new_bed_name").attr('required', true);
				}else{
					$("#pack_bed_id").val('');
					$("#psf_bed_info_container").css({"display":"none"});
					$("#pack_new_bed_name").attr('readonly', true);
					$("#pack_new_bed_name").attr('required', false);
				}
			}  
		});
	}	
}
function get_avaible_bed_info_package_shifting(){
	var bra_id_shif = $("#branch").val();
	var bed_typ_sh = $("#psh_room_type").val();
	$.ajax({  
		url:"<?php echo $home.'assets/ajax/select_beds_options_package_shifting.php'; ?>",  
		method:"POST",  
		data:{
			bed_type : bed_typ_sh,
			branch_id : bra_id_shif
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#bed_result').html(data); 
			$('#bed_info_header').html('<i class="fas fa-check"></i> Selected Bed Information. Bed Type: '+bed_typ_sh);
			$('#Shifting_model').modal('hide');
			$('#bed_selecting_model').modal('show');   
		}
	});
}
function get_bet_info_package_shifting(id){
	var bed_id = id;				
	if(bed_id != ''){
		$.ajax({
			url:"<?php echo $home.'assets/ajax/select_beds_information.php';?>",  
			method:"POST",  
			data:{bed_id:bed_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('_');
				$("#pack_new_bed_name").val(value[1]);
				$("#pack_bed_id").val(value[0]);
				$('#bed_selecting_model').modal('hide');  
				$('#Shifting_model').modal('show');
			}  
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}		
}
</script>					
					<div id="hide_payment">
						<div class="row" style="width:100%;margin-top: 20px;">
							<div class="col-sm-12">
								<h4 style="text-decoration:underline;">
									Payment Information									
									<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
										<button type="button" id='removeButton_payment_psh' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
										<button type="button" id='addButton_payment_psh' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
									</div>
									<div id="due_result_amount_package_shift" class="row d-flex" style="float:right;padding-right: 26px; color: #f00; margin-top: -4px;font-size: 20px;"> </div>
								</h4>
							</div>
						</div>
						<div id='UnitBoxesGroup_payment_psh' style="width:100%;" class="package_change_payment_container">
							<div id="UnitBoxDiv_payment_psh1" style="width:100%;">
								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-3">
										<div class="form-group">
											<select onchange="return payment_on_shif_packg()" id="payment_method_psh1" name="payment_method[]" class="form-control">
												<option value="">select payment method</option>
												<option value="Cash">Cash</option>
												<option value="Mobile Banking">Mobile Banking</option>
												<option value="Credit / Debit Card">Credit / Debit Card</option>
												<option value="Check">Check</option>										
											</select>
										</div>
									</div>
									<div class="col-sm-9">								
										<div class="row" id="mobile_banking_psh1" style="display:none;">
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
										<div class="row" id="check_number_psh1" style="display:none;">
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
										
										<div class="row" id="credit_card_psh1" style="display:none;">
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
										
										<div class="row" id="cash_psh1" style="display:none;">
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
					
					
					
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<button type="submit" name="finally_package_change" id="finally_package_change" class="btn btn-success" style="float:right;" disabled>Change Package</button>
							</div>
						</div>
					</div>
					
				</div>
				<input type="hidden" name="total_amount_get" id="total_amount_get" value="" />
				<input type="hidden" name="total_amount_with_security_rent" id="total_amount_with_security_rent" value="" />
				<input type="hidden" name="extra_rent_amount" id="extra_rent_amount" value="" />
				
			</form>
		</div>
	</div>
<script>
$("#package_shifting_form").on("submit",function(){
	if($("#package_category").val() == ''){
		$("#package_change_error_message").html('Please select package category');
		return false;
	}else if($("#package_id").val() == ''){
		$("#package_change_error_message").html('Please choose Package');
		return false;
	}else{
		event.preventDefault();
		var form = $('#package_shifting_form')[0];
		var data = new FormData(form);			
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo $home.'assets/ajax/form_submit/package_shifting_submit_form.php';?>",
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#finally_package_change").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('____');
				if(value[1] == '1'){
					$('#package_change_error_message').html(value[0]);
					$("#finally_package_change").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}else{
					$('#data_send_success_message').html(value[0]);										
					$('#Shifting_model').modal('hide');
					$("#finally_package_change").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
					get_shifting_receipt(value[2]);
					//return view_profile_from_booking(value[2]);						
				}					
			}
		});
		return false;
	}
})

function f_C_g(total) {
	var neg = false;
	if(total < 0) {
		neg = true;
		total = Math.abs(total);
	}
	return (neg ? "-BDT " : 'BDT ') + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}



$(document).on('keyup', 'input[placeholder="Amount"]', function (event, data) {
	var written_amount = 0;
	$('input[placeholder="Amount"]').each(function(){
		if($(this).val() != ''){
			written_amount += parseInt($(this).val());
		}		
	})
	let security_deposit;
	if(parseInt($('#total_amount_get').val()) < 0){
		security_deposit = 0;
	}else{
		security_deposit = parseInt($('#total_amount_get').val());
	}
	let total_due = security_deposit + parseInt($('#extra_rent_amount').val());
	var due_result_amount_booking = written_amount - total_due;
	$("#due_result_amount_package_shift").html('Calculation: ' + due_result_amount_booking);	
	if(total_due <= written_amount){
		$('button[name="finally_package_change"]').prop("disabled", false);
	}else{
		$('button[name="finally_package_change"]').prop("disabled", true);
	}	
});

function package_category_loading(){
	var branch_id = $("#branch").val();
	let selected_package_days = <?php echo $package_info['package_days'] ?>;
	$.ajax({  
		url:"<?php echo $home.'assets/ajax/select_spackage_category_options.php'; ?>",
		method:"POST",  
		data:{view_id:branch_id, selected_package_days},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#package_category').html(data);  
			$('#total_amountbed_packge_shifting').html(f_c_g(0));
			$('#total_amount_get').val('0');
			$('button[name="finally_package_change"]').prop("disabled", true);
		}
	});
}
$(document).ready(function(){
	$('button[name="finally_package_change"]').prop("disabled", true);
	return package_category_loading();
})
	
	
	
$(document).ready(function(){
	$("#package_id").on("change",function(){
		var p_id = $(this).val();
		var value = p_id.split('____');
		$('#package_grant_id').val(value[0]);
		var total_amount = parseFloat(value[1]);
		$('#total_amountbed_packge_shifting').html(f_C_g(total_amount));
		$('#total_amount_get').val(total_amount);		
		if(value[2] == '1'){
			$('#hide_payment').css({"display":"none"});
			$('button[name="finally_package_change"]').prop("disabled", false);
		}else{
			$('#hide_payment').css({"display":"block"});
			$('button[name="finally_package_change"]').prop("disabled", true);
		}	
	})
	
	$("#branch").on("change",function(){
		let selected_package_days = <?php echo $package_info['package_days'] ?>;
		var branch_id = $(this).val();
		$.ajax({  
			url:"<?php echo $home.'assets/ajax/select_spackage_category_options.php'; ?>",  
			method:"POST",
			data:{view_id:branch_id, selected_package_days},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#package_category').html(data);  
			}
		});
	})
	var old_package = '<?php echo $package_info['id']; ?>';
	$("#package_category").on("change",function(){
		var id = $(this).val();
		
		$.ajax({  
			url:"<?php echo $home.'assets/ajax/option_select/select_package_options_shifting.php'; ?>",  
			method:"POST",  
			data:{
				view_id:id,
				old_package:old_package,
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){				
				$('#data-loading').html('');
				$('#package_id').html(data);
				$('#total_amountbed_packge_shifting').html(f_C_g(parseFloat(0)));
				$('#total_amount_get').val('0');
				$('button[name="finally_package_change"]').prop("disabled", true);
			}  
		});	
	})	
})



function monthly_rent_calculator (selected_package) {
	let booking_id = '<?php echo $member_info['booking_id'] ?>';
	let old_package = '<?php echo $package_info['id']; ?>';
	console.log(old_package);
	$.ajax({  
		url:"<?php echo $home.'assets/ajax/calculate_monthly_rent_for_package_shift.php'; ?>",  
		method:"POST",  
		data:{
			booking_id,
			selected_package,
			old_package
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			let info = JSON.parse(data);
			$('#recharge_days').html(info.recharge_days);
			$('#days_stayed').html(info.days_stayed);
			$('#available_days').html(info.available_days);
			$('#currrent_rent').html(info.old_rent);
			$('#new_rent').html(info.new_rent);
			$('#consumed_rent').html(info.given);
			$('#extra_rent').html(info.net_payable);
			$('#security_deposit').html($('#total_amount_get').val());
			$('#extra_rent_amount').val(info.net_payable_final);
			$('#discount_amount').html(info.dicount_amount);
			if(info.net_payable_final > 0){
				$('#hide_payment').css({"display":"block"});
				$('button[name="finally_package_change"]').prop("disabled", true);
			}
			if(parseInt($('#total_amount_get').val()) < 0){
				$('#total_amountbed_packge_shifting').html( Math.ceil(info.net_payable_final) );
				$('#total_amount_with_security_rent').val(Math.ceil(info.net_payable_final));
			}else{
				$('#total_amountbed_packge_shifting').html( Math.ceil($('#total_amount_get').val()) + Math.ceil(info.net_payable_final) );
				$('#total_amount_with_security_rent').val( Math.ceil($('#total_amount_get').val()) + Math.ceil(info.net_payable_final) );
			}
			// $('#bed_result').html(data); 
			// $('#bed_info_header').html('<i class="fas fa-check"></i> Selected Bed Information. Bed Type: '+bed_typ_sh);
			// $('#Shifting_model').modal('hide');
			// $('#bed_selecting_model').modal('show');
		}  
	});
}



//var value = data.split('###');
//$('#total_amountbed_packge_shifting').html(parseFloat(value[1]));
</script>	
	<!--end--Package--shifting-->
<?php /*  } else { ?>	
	<div style="width:100%;margin-top:100px;" id="Package_shifting_container">
		<div class="col-sm-12">
			<center>
				<h1 style="color:#f00;">Sorry! (Membership: TRY US) Not Applicable.</h1>
			</center>
		</div>
	</div>
<?php } */ ?>
	
	<!--start--Branch--shifting-->
<form id="branch_shifting_form" action="#" method="post" enctype="multipart/form-data">	
	<input type="hidden" name="member_id" value="<?php echo $member_info['id']; ?>" />
	<div class="col-sm-12" id="branch_shifting_container">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<table class="table table-sm">
								<tr>
									<th>Returnable Iteams</th>
									<th>Received</th>
								</tr>
								<input type="hidden" id="diposit_js" name="diposit_js" value="0"/>
								<input type="hidden" id="cid_check" name="nai" value="0"/>
								<?php
								$cql = $mysqli->query("select * from checkout_iteam where branch_id = '".$member_info['branch_id']."' and status = '1'");
								while($cow = mysqli_fetch_assoc($cql)){
								?>
								<tr>
									<td> <?php echo $cow['checkout_iteam']; ?> </td>
									<td> 
										<select name="checkout_iteam[]" id="val_men_<?php echo $cow['id']; ?>" onchange="return manage_cal_<?php echo $cow['id']; ?>(<?php echo $cow['lost_amount']; ?>)" class="form-control" required>
											<option value="1">YES</option>
											<option value="0">NO</option>
										</select>
									</td>
								</tr>
								<script>
									function manage_cal_<?php echo $cow['id']; ?>(amount){
										var val = $("#val_men_<?php echo $cow['id']; ?>").val();
										if(val == '1'){
											var total = parseFloat($("#diposit_js").val());
											var amount = parseFloat("<?php echo $cow['lost_amount']; ?>");
											var result = total - amount;
											$("#total_amount_large").html(result);
											$("#diposit_js").val(result);
											return payment_on_off();
										}else{
											var total = parseFloat($("#diposit_js").val());
											var amount = parseFloat("<?php echo $cow['lost_amount']; ?>");
											var result = total + amount;
											$("#total_amount_large").html(result);
											$("#diposit_js").val(result);
											return payment_on_off();
										}
									}
								</script>
								<?php } ?>
							</table>
							
						</div>
					</div>
					<div class="col-sm-6">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
									<div class="form-group" style="margin:0px;">
										<label style="margin-bottom:0px;"><i class="fas fa-calculator"></i> Total Amount</label>
										<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
										<div id="total_amount_large" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);"></div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-5">
						<div class="row">
							<div class="col-sm-12">
								<h2 style="text-decoration:underline;">From:</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Branch</label>
									<select name="old_branch" id="" class="form-control select2" readonly  style="font-weight:bolder;font-size:20px;color:red" > 
										<option value="<?php echo $member_info['branch_id']; ?>"><?php echo $member_info['branch_name']; ?></option>
									</select>
								</div>
							</div>
						</div>						
					</div>
					<div class="col-sm-2"></div>
					<div class="col-sm-5">
						<div class="row">
							<div class="col-sm-12">
								<h2 style="text-decoration:underline;">To:</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Branch</label>
									<select name="new_branch" id="branch" class="form-control select2" style="font-weight:bolder;font-size:20px;color:green;" > 
										<?php
										$br_sql = $mysqli->query("select * from branches");
										while($brw = mysqli_fetch_assoc($br_sql)){
											if($member_info['branch_id'] == $brw['branch_id']){
												$option = 'style="display:none;" disabled';
											}else{
												$option = '';
											}												
											echo '<option value="'.$brw['branch_id'].'" '.$option.'>'.$brw['branch_name'].'</option>';
										}
										?>
										
									</select>
								</div>
							</div>							
							<div class="col-sm-12">
								<div class="form-group">
									<label>Shifting Date (mm/dd/yyyy)</label>
									<input type="date" name="shifting_date" id="" value="<?php echo $next_month; ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" class="form-control" readonly />
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label>Note / Reason</label>
									<textarea name="note" class="form-control"></textarea>
								</div>
							</div>
						</div>
						
					</div>
				</div>	
			</div>
			<div id="hide_payment1" class="col-sm-12">
				<div class="row" style="width:100%;margin-top: 20px;">
					<div class="col-sm-12">
						<h4 style="text-decoration:underline;">
							Payment Information									
							<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
								<button type="button" id='removeButton_payment_psh' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
								<button type="button" id='addButton_payment_psh' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
							</div>
						</h4>
					</div>
				</div>
				<div id='UnitBoxesGroup_payment_psh1' style="width:100%;">
					<div id="UnitBoxDiv_payment_psh11" style="width:100%;">
						<div class="row" style="margin-top: 10px;">
							<div class="col-sm-3">
								<div class="form-group">
									<select onchange="return payment_on_shif_branch()" id="payment_method_psh2" name="payment_method[]" class="form-control">
										<option value="">select payment method</option>
										<option value="Cash">Cash</option>
										<option value="Mobile Banking">Mobile Banking</option>
										<option value="Credit / Debit Card">Credit / Debit Card</option>
										<option value="Check">Check</option>										
									</select>
								</div>
							</div>
							<div class="col-sm-9">								
								<div class="row" id="mobile_banking_psh2" style="display:none;">
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
								<div class="row" id="check_number_psh2" style="display:none;">
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
								
								<div class="row" id="credit_card_psh2" style="display:none;">
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
								
								<div class="row" id="cash_psh2" style="display:none;">
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
			<div class="col-sm-12">
				<button name="finish_shifting_branch" type="submit" class="btn btn-success" id="finish_branch_shift" style="float:right;">Submit</button>
			</div>
			
		</div>
	</div>
	<!--end--Branch--shifting-->
</form>
<script>
	$('document').ready(function(){
		$("#branch_shifting_form").on("submit",function(){
			if(confirm('Ar you sure want to shifting Branch??')){
				event.preventDefault();
				var form = $('#branch_shifting_form')[0];
				var data = new FormData(form);
				$.ajax({
					type: "POST",
					enctype: 'multipart/form-data',
					url:"<?php echo $home.'assets/ajax/form_submit/member_branch_shifting_submit.php'; ?>",  
					data: data,
					processData: false,
					contentType: false,
					cache: false,
					timeout: 600000,
					beforeSend:function(){
						$("#finish_branch_shift").prop("disabled", true);
						$('#data-loading').html(data_loading);
					},
					success:function(data){
						$("#finish_branch_shift").prop("disabled", true);
						$('#data-loading').html('');
						alert(data);
						$('#Shifting_model').modal('hide'); 						
					}
				});
				return false;
			}
			return false;
		})
	})
</script>	
</div>

<script>
var bra_id_shif = '<?php echo $member_info['branch_id']; ?>';
var bed_typ_sh = '<?php echo $member_info['bet_type']; ?>';

$('document').ready(function(){
	return payment_on_off();
})
function payment_on_off(){
	if($("#diposit_js").val() > 0 ){
		$("#hide_payment1").css({"display":"block"});
		$("#payment_method_psh2").prop("required", true);			
	}else{
		$("#hide_payment1").css({"display":"none"});
		$("#payment_method_psh2").prop("required", false);			
	}
}
function get_avaible_bed_info(){
	$.ajax({  
		url:"<?php echo $home.'assets/ajax/select_beds_options.php'; ?>",  
		method:"POST",  
		data:{
			bed_type : bed_typ_sh,
			branch_id : bra_id_shif
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#bed_result').html(data); 
			$('#bed_info_header').html('<i class="fas fa-check"></i> Selected Bed Information. Bed Type: '+bed_typ_sh);
			$('#Shifting_model').modal('hide');
			$('#bed_selecting_model').modal('show');   
		}  
	});	
}

$( document ).ready(function(){
	return shipting_topic_change();
})
function shipting_topic_change(){
	if ($("#sifting_topic").val() == 'Bed Shift' ) {
		$("#bed_shifting_container").css({"display":"block"});
		$("#Package_shifting_container").css({"display":"none"});
		$("#branch_shifting_container").css({"display":"none"});
		<?php if($can_cange == '0'){ ?>
		$("#calculator_container").css({"display":"block"});
		$("#bed_payment_container").css({"display":"block"});
		<?php }else{ ?>
		$("#calculator_container").css({"display":"none"});
		$("#bed_payment_container").css({"display":"none"}); 
		<?php } ?>
		$("#calculator_container_package").css({"display":"none"});

		$("#package_shifting_information").hide();	
		
	} else if ($("#sifting_topic").val() == 'Package Shift' ) {
		$("#bed_shifting_container").css({"display":"none"});
		$("#Package_shifting_container").css({"display":"block"});
		$("#branch_shifting_container").css({"display":"none"});
		$("#calculator_container").css({"display":"none"});	
		$("#calculator_container_package").css({"display":"block"});	

		$("#package_shifting_information").show();	
		
	} else if($("#sifting_topic").val() == 'Branch Shift' ) {
		$("#bed_shifting_container").css({"display":"none"});
		$("#Package_shifting_container").css({"display":"none"});
		$("#branch_shifting_container").css({"display":"block"});
		$("#calculator_container").css({"display":"none"});	
		$("#calculator_container_package").css({"display":"none"});	
		
		$("#package_shifting_information").hide();	
		
	}
}
</script>
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


//---------paymethod package shifting---------

function payment_on_shif_packg(){	
	
	if($("#payment_method_psh1").val() == 'Mobile Banking'){
		$("#mobile_banking_psh1").css({"display":"flex"});
		$("#check_number_psh1").css({"display":"none"});
		$("#credit_card_psh1").css({"display":"none"});
		$("#cash_psh1").css({"display":"none"});
		
		
	}else if($("#payment_method_psh1").val() == 'Check'){
		$("#mobile_banking_psh1").css({"display":"none"});
		$("#credit_card_psh1").css({"display":"none"});
		$("#check_number_psh1").css({"display":"flex"});
		$("#cash_psh1").css({"display":"none"});
		
		
	}else if($("#payment_method_psh1").val() == 'Credit / Debit Card'){
		$("#mobile_banking_psh1").css({"display":"none"});
		$("#check_number_psh1").css({"display":"none"});
		$("#credit_card_psh1").css({"display":"flex"});
		$("#cash_psh1").css({"display":"none"});
		
		
	}else if($("#payment_method_psh1").val() == 'Cash'){
		$("#mobile_banking_psh1").css({"display":"none"});
		$("#check_number_psh1").css({"display":"none"});
		$("#credit_card_psh1").css({"display":"none"});
		$("#cash_psh1").css({"display":"flex"});
	}else{
		$("#mobile_banking_psh1").css({"display":"none"});
		$("#check_number_psh1").css({"display":"none"});
		$("#credit_card_psh1").css({"display":"none"});
		$("#cash_psh1").css({"display":"none"});
	}
	
	if($("#payment_method_psh12").val() == 'Mobile Banking'){
		$("#mobile_banking_psh12").css({"display":"flex"});
		$("#check_number_psh12").css({"display":"none"});
		$("#credit_card_psh12").css({"display":"none"});
		$("#cash_psh12").css({"display":"none"});
	}else if($("#payment_method_psh12").val() == 'Check'){
		$("#mobile_banking_psh12").css({"display":"none"});
		$("#credit_card_psh12").css({"display":"none"});
		$("#check_number_psh12").css({"display":"flex"});
		$("#cash_psh12").css({"display":"none"});
	}else if($("#payment_method_psh12").val() == 'Credit / Debit Card'){
		$("#mobile_banking_psh12").css({"display":"none"});
		$("#check_number_psh12").css({"display":"none"});
		$("#credit_card_psh12").css({"display":"flex"});
		$("#cash_psh12").css({"display":"none"});
	}else if($("#payment_method_psh12").val() == 'Cash'){
		$("#mobile_banking_psh12").css({"display":"none"});
		$("#check_number_psh12").css({"display":"none"});
		$("#credit_card_psh12").css({"display":"none"});
		$("#cash_psh12").css({"display":"flex"});
	}else{
		$("#mobile_banking_psh12").css({"display":"none"});
		$("#check_number_psh12").css({"display":"none"});
		$("#credit_card_psh12").css({"display":"none"});
		$("#cash_psh12").css({"display":"none"});
	}
	
	if($("#payment_method_psh13").val() == 'Mobile Banking'){
		$("#mobile_banking_psh13").css({"display":"flex"});
		$("#check_number_psh13").css({"display":"none"});
		$("#credit_card_psh13").css({"display":"none"});
		$("#cash_psh13").css({"display":"none"});
	}else if($("#payment_method_psh13").val() == 'Check'){
		$("#mobile_banking_psh13").css({"display":"none"});
		$("#credit_card_psh13").css({"display":"none"});
		$("#check_number_psh13").css({"display":"flex"});
		$("#cash_psh13").css({"display":"none"});
	}else if($("#payment_method_psh13").val() == 'Credit / Debit Card'){
		$("#mobile_banking_psh13").css({"display":"none"});
		$("#check_number_psh13").css({"display":"none"});
		$("#credit_card_psh13").css({"display":"flex"});
		$("#cash_psh13").css({"display":"none"});
	}else if($("#payment_method_psh13").val() == 'Cash'){
		$("#mobile_banking_psh13").css({"display":"none"});
		$("#check_number_psh13").css({"display":"none"});
		$("#credit_card_psh13").css({"display":"none"});
		$("#cash_psh13").css({"display":"flex"});
	}else{
		$("#mobile_banking_psh13").css({"display":"none"});
		$("#check_number_psh13").css({"display":"none"});
		$("#credit_card_psh13").css({"display":"none"});
		$("#cash_psh13").css({"display":"none"});
	}
}

//-------------------payment-----------

//---------paymethod branch shifting---------
function payment_on_shif_branch(){
	if($("#payment_method_psh2").val() == 'Mobile Banking'){
		$("#mobile_banking_psh2").css({"display":"flex"});
		$("#check_number_psh2").css({"display":"none"});
		$("#credit_card_psh2").css({"display":"none"});
		$("#cash_psh2").css({"display":"none"});
	}else if($("#payment_method_psh2").val() == 'Check'){
		$("#mobile_banking_psh2").css({"display":"none"});
		$("#credit_card_psh2").css({"display":"none"});
		$("#check_number_psh2").css({"display":"flex"});
		$("#cash_psh2").css({"display":"none"});
	}else if($("#payment_method_psh2").val() == 'Credit / Debit Card'){
		$("#mobile_banking_psh2").css({"display":"none"});
		$("#check_number_psh2").css({"display":"none"});
		$("#credit_card_psh2").css({"display":"flex"});
		$("#cash_psh2").css({"display":"none"});
	}else if($("#payment_method_psh2").val() == 'Cash'){
		$("#mobile_banking_psh2").css({"display":"none"});
		$("#check_number_psh2").css({"display":"none"});
		$("#credit_card_psh2").css({"display":"none"});
		$("#cash_psh2").css({"display":"flex"});
	}else{
		$("#mobile_banking_psh2").css({"display":"none"});
		$("#check_number_psh2").css({"display":"none"});
		$("#credit_card_psh2").css({"display":"none"});
		$("#cash_psh2").css({"display":"none"});
	}
	
	if($("#payment_method_psh22").val() == 'Mobile Banking'){
		$("#mobile_banking_psh22").css({"display":"flex"});
		$("#check_number_psh22").css({"display":"none"});
		$("#credit_card_psh22").css({"display":"none"});
		$("#cash_psh22").css({"display":"none"});
	}else if($("#payment_method_psh22").val() == 'Check'){
		$("#mobile_banking_psh22").css({"display":"none"});
		$("#credit_card_psh22").css({"display":"none"});
		$("#check_number_psh22").css({"display":"flex"});
		$("#cash_psh22").css({"display":"none"});
	}else if($("#payment_method_psh22").val() == 'Credit / Debit Card'){
		$("#mobile_banking_psh22").css({"display":"none"});
		$("#check_number_psh22").css({"display":"none"});
		$("#credit_card_psh22").css({"display":"flex"});
		$("#cash_psh22").css({"display":"none"});
	}else if($("#payment_method_psh22").val() == 'Cash'){
		$("#mobile_banking_psh22").css({"display":"none"});
		$("#check_number_psh22").css({"display":"none"});
		$("#credit_card_psh22").css({"display":"none"});
		$("#cash_psh22").css({"display":"flex"});
	}else{
		$("#mobile_banking_psh22").css({"display":"none"});
		$("#check_number_psh22").css({"display":"none"});
		$("#credit_card_psh22").css({"display":"none"});
		$("#cash_psh12").css({"display":"none"});
	}
	
	if($("#payment_method_psh23").val() == 'Mobile Banking'){
		$("#mobile_banking_psh23").css({"display":"flex"});
		$("#check_number_psh23").css({"display":"none"});
		$("#credit_card_psh23").css({"display":"none"});
		$("#cash_psh23").css({"display":"none"});
	}else if($("#payment_method_psh23").val() == 'Check'){
		$("#mobile_banking_psh23").css({"display":"none"});
		$("#credit_card_psh23").css({"display":"none"});
		$("#check_number_psh23").css({"display":"flex"});
		$("#cash_psh23").css({"display":"none"});
	}else if($("#payment_method_psh23").val() == 'Credit / Debit Card'){
		$("#mobile_banking_psh23").css({"display":"none"});
		$("#check_number_psh23").css({"display":"none"});
		$("#credit_card_psh23").css({"display":"flex"});
		$("#cash_psh23").css({"display":"none"});
	}else if($("#payment_method_psh23").val() == 'Cash'){
		$("#mobile_banking_psh23").css({"display":"none"});
		$("#check_number_psh23").css({"display":"none"});
		$("#credit_card_psh23").css({"display":"none"});
		$("#cash_psh23").css({"display":"flex"});
	}else{
		$("#mobile_banking_psh23").css({"display":"none"});
		$("#check_number_psh23").css({"display":"none"});
		$("#credit_card_psh23").css({"display":"none"});
		$("#cash_psh23").css({"display":"none"});
	}
}

//-------------------payment-----------

	
	var counter_payment_aut2 = 2;
    $("#addButton_payment_aut2").click(function () {	
		if( counter_payment_aut2 == 4 ){
			alert("Sorry! Maximum number of field reached");
			return false;			
		}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv_payment_aut2' + counter_payment_aut2 ,
			class: 'row',
			style: 'width:100%margin-top: 10px;'
		});
		
		var dataq = '<div class="col-sm-3">';
			dataq += '<div class="form-group">';
			dataq += '<select onchange="return payment_on_shif_branch()" id="payment_method_aut2'+counter_payment_aut2+'" name="payment_method[]" class="form-control">';
			dataq += '<option value="">select payment method</option>';
			dataq += '<option value="Cash">Cash</option>';
			dataq += '<option value="Mobile Banking">Mobile Banking</option>';
			dataq += '<option value="Credit / Debit Card">Credit / Debit Card</option>';
			dataq += '<option value="Check">Check</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-9">	';							
			dataq += '<div class="row" id="mobile_banking_aut2'+counter_payment_aut2+'" style="display:none;">';
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
			dataq += '<div class="row" id="check_number_aut2'+counter_payment_aut2+'" style="display:none;">';
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
			dataq += '<div class="row" id="credit_card_aut2'+counter_payment_aut2+'" style="display:none;">';
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
			dataq += '<div class="row" id="cash_aut2'+counter_payment_aut2+'" style="display:none;">';
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
		newTextBoxDiv.appendTo("#UnitBoxesGroup_payment_aut2");
		counter_payment_aut2++;
    });
    $("#removeButton_payment_aut2").click(function () {
		if( counter_payment_aut2 == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter_payment_aut2--;
        $("#UnitBoxDiv_payment_aut2" + counter_payment_aut2).remove();
    });
	
	//------------------end branch shifting-------------------
	
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
	
	//------------------end package shifting-------------------
	
	
	var counter_payment_psh = 2;
    $("#addButton_payment_psh").click(function () {	
		if( counter_payment_psh == 4 ){
			alert("Sorry! Maximum number of field reached");
			return false;			
		}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv_payment_psh1' + counter_payment_psh ,
			class: 'row',
			style: 'width:100%margin-top: 10px;'
		});
		
		var dataq = '<div class="col-sm-3">';
			dataq += '<div class="form-group">';
			dataq += '<select onchange="return payment_on_shif_packg()" id="payment_method_psh1'+counter_payment_psh+'" name="payment_method[]" class="form-control">';
			dataq += '<option value="">select payment method</option>';
			dataq += '<option value="Cash">Cash</option>';
			dataq += '<option value="Mobile Banking">Mobile Banking</option>';
			dataq += '<option value="Credit / Debit Card">Credit / Debit Card</option>';
			dataq += '<option value="Check">Check</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-9">	';							
			dataq += '<div class="row" id="mobile_banking_psh1'+counter_payment_psh+'" style="display:none;">';
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
			dataq += '<div class="row" id="check_number_psh1'+counter_payment_psh+'" style="display:none;">';
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
			dataq += '<div class="row" id="credit_card_psh1'+counter_payment_psh+'" style="display:none;">';
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
			dataq += '<div class="row" id="cash_psh1'+counter_payment_psh+'" style="display:none;">';
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
		newTextBoxDiv.appendTo("#UnitBoxesGroup_payment_psh");
		counter_payment_psh++;
    });
    $("#removeButton_payment_psh").click(function () {
		if( counter_payment_psh == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter_payment_psh--;
        $("#UnitBoxDiv_payment_psh1" + counter_payment_psh).remove();
    });
	
	//-------------------------------------
	

</script>


<?php 
}
 ?>