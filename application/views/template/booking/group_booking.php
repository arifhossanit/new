<script>
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
	return card_payment_calculator();
}
</script>
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Group Booking</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Group Booking</li>
              <li class="breadcrumb-item active">
				<?php
				if(!empty($_SESSION['re_book_member_id'])){
					echo $_SESSION['re_book_member_id'];
				}
				?>
			  </li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<span id="athorization_message"></span>
					<div class="row">					
						<div class="col-sm-12" style="margin-bottom:20px;">
							<a href="<?php echo base_url('admin/booking'); ?>" class="btn btn-danger" style="float:right;margin-right:15px;color:#fff;"><i class="fas fa-arrow-left"></i> Back to Booking</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<span id="data_send_success_message"></span>
							<div class="card card-info">
								<div class="card-header">
									<h4>Group Booking Form</h4>
								</div>
								<div class="card-body">
									<style>.form_b_class .form-control:focus{border:solid 2px #f00;}</style>
									<form class="form_b_class" method="post" id="booking_form" enctype="multipart/form-data">
										<div class="modal-body" style="padding:0px;"> 
											<!----start booking information--->
											<div class="row">
												<div class="col-sm-12">
													<h4 style="text-decoration:underline;">Booking Information</h4>
													<span id="error_message_booking" style="color:#f00;font-weight:bolder;"></span>
												</div>
											</div>
											<div class="row">						
												<div class="col-sm-3">
													<div class="form-group">
														<label>Select branch</label><small class="req"> *</small>
														<select id="branch_id" name="branch_id" class="form-control select2">
															<?php
																if(!empty($banches)){
																	foreach($banches as $row){
																		echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';																										
																	}
																}
															?>	
														</select>
														
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Select package category</label><small class="req"> *</small>
														<select id="package_category" name="package_category" class="form-control select2">
															<option value="">select</option>
														</select>
													</div>
												</div>							
												<div class="col-sm-3">
													<div class="form-group">
														<label>Check in date (mm/dd/yyyy)</label><small class="req"> *</small>
														<input type="date" id="checkin_date" name="checkin_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>"/>										
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Select Membership</label><small class="req"> *</small>
														<input type="hidden" id="try_us_condition_check" name="try_us_condition_check" value=""/>
														<input type="hidden" id="try_us_days" name="try_us_days" value=""/>
														<select id="package" name="package" class="form-control select2">
														</select>
													</div>
												</div>
												
											</div>	

											<div class="row">							
												<div class="col-sm-3">
													<div class="form-group">
														<label>Select bed type</label><small class="req"> *</small>
														<select id="bet_type" name="bet_type" class="form-control select2">
															<option value="">select</option>
															<?php
															if(!empty($room_type)){
																foreach($room_type as $room){
																	echo '<option value="'.$room->room_type.'">'.$room->room_type.'</option>';
																}
															}
															?>
														</select>
													</div>
												</div>
												
												<div class="col-sm-3">
													<div class="form-group">
														<label>Selected bed</label><small class="req"> *</small>
														<input type="hidden" id="bed_id_script" name="bed_id_script"/>
														<input onclick="return bet_change_after_select()" type="text" id="selected_bed" name="selected_bed" class="form-control" readonly />
													</div>
												</div>
												
												<div class="col-sm-2">
													<div class="form-group">
														<label>Motorbike Parking</label><small class="req"> *</small>
														<select id="vicle_parking" name="vicle_parking" onchange="return money_manage_ment()" class="form-control">
															<option value="0">NO</option>
															<option value="1">YES</option>
														</select>
													</div>
												</div>							
												
												<div class="col-sm-2">
													<div class="form-group">
														<label>Locker</label><small class="req"> *</small>
														<select id="locker" name="locker" onchange="return money_manage_ment()" class="form-control">
															<option value="0">NO</option>
														</select>
														<input type="hidden" value="<?php echo date('d/m/Y  h:i:s A'); ?>" id="booking_date" name="booking_date" class="form-control" readonly />
													</div>
												</div>
												<div class="col-sm-2">
													<label>Select Locker</label><small class="req"> *</small>
													<input type="text" id="selected_locker" name="selected_locker" value="" class="form-control" readonly />
												</div>						
											</div>
											
											<div class="row">
												<div class="col-sm-5">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>Check out date</label><small class="req"> *</small>
																<input type="text" id="check_out_date" name="check_out_date" class="form-control" value="" readonly/>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label>Check out Info</label>
																<input type="text" id="check_out_info" name="check_out_info" class="form-control" value="" readonly/>
															</div>
														</div>
													</div>							
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Security deposit</label><small class="req"> *</small>
														<input type="text" id="security_deposit" name="security_deposit" class="form-control" readonly />
														<input type="hidden" id="security_money" name="security_money" value=""/>
													</div>
												</div>
												
												<div class="col-sm-4" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
													<div class="form-group" style="margin:0px;">
														<label style="margin-bottom:0px;">
															<i class="fas fa-calculator"></i> 
															Total Amount 
															<span id="due_sudm" style="color:red;"></span>
															<span id="crd_add_sudm" style="color:red;"></span>
														</label>
														<input type="hidden" id="total_amount" name="total_amount"/>
														<style>@font-face { font-family: OPTICalculator; src: url(<?=base_url('assets/font/OPTICalculator.otf'); ?>); } </style>
														<div id="total_amount_large" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);"></div>
													</div>
												</div>
											</div>
											

										
											<div class="row" id="force_rent_container">
												<div class="col-sm-12">
													<label><input type="checkbox" name="force_rent" id="force_rent"/>&nbsp;&nbsp;Force Rent</label>
												</div>
											</div>
											<div id="check_in_purpose">
												<div class="row">						
													<div class="col-sm-2">
														<div class="form-group" id="card_number_container">
															<label>Card number</label>
															<input type="number" placeholder="Card Number" name="card_number" id="card_number" class="form-control" />
														</div>
													</div>
													<div class="col-sm-2">
														<div class="form-group">
															<label>Payment pattern</label>
															<select id="payment_pattern" name="payment_pattern" onchange="return money_manage_ment()" class="form-control">
																<option value="1">Full Payment</option>
																<option value="0">Half Payment</option>
																<option value="2">Due Rent</option>
															</select>
														</div>
													</div>
													<div class="col-sm-8" >
														<div id="rental_fiels_container" style="width:100%;">
															<div class="row">									
																
																<div class="col-sm-3">
																	<div class="form-group">
																		<label>Rent</label>
																		<input type="text" id="rent_amount_show" name="rent_amount_show" class="form-control" readonly />
																		<input type="hidden" id="rent_amount" name="rent_amount" value=""/>
																		<input type="hidden" id="ac_rent_amount_1" name="ac_rent_amount_1" value=""/>
																	</div>
																</div>
																
																<div class="col-sm-3">
																	<div class="form-group">
																		<label>Discount</label>
																		<input type="text" id="discount_text" name="discount_text" class="form-control" readonly />
																		<input type="hidden" id="disccount_money" name="disccount_money" value=""/>
																	</div>
																</div>
																
																<div class="col-sm-3">
																	<div class="form-group" id="parking_purpose">
																		<label>Parking</label>
																		<input type="text" id="parking_amount" name="parking_amount" class="form-control" readonly />
																		<input type="hidden" id="parking_value" name="parking_value" value=""/>
																	</div>
																</div>
																<div class="col-sm-3">
																	<div class="form-group" id="locker_purpose" style="display:none;">
																		<label>Locker</label>
																		<input type="text" id="locker_amount" name="locker_amount" class="form-control" readonly />
																		<input type="hidden" id="locker_value" name="locker_value" value=""/>
																		<input type="hidden" id="locker_ids" name="locker_ids" value=""/>
																		<input type="hidden" id="locker_names" name="locker_names" value=""/>
																		<input type="hidden" id="locker_qty" name="locker_names" value=""/>
																	</div>
																</div>
																
															</div>
														</div>
													</div>
												</div>
											</div>
											<!---end booking information --->
											
											
											
											
											
											<div class="row">
												<div class="col-sm-12">
													<h4 style="text-decoration:underline;">Member Information &nbsp;<span id="get_member_information_loading"></span></h4>
													<span style="color:red;font-weight:bolder;" id="member_error_message"></span>
												</div>							
											</div>
											<div class="row">
												<div class="col-sm-3">
													<div class="form-group">
														<input type="text" onkeyup="return get_member_information()" id="phone_number" name="phone_number" value="<?php if(!empty($bfifpb->phone)){ echo $bfifpb->phone; } ?>" minlength="11" maxlength="11" autocomplete="off" placeholder="Phone Number" class="phone_number form-control" required />
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<input type="email" onkeyup="return get_member_information()" id="email" name="email" value="<?php if(!empty($bfifpb->email)){ echo $bfifpb->email; } ?>" autocomplete="off" placeholder="Email" class="email_address form-control" required />
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<input type="text" onkeyup="return get_member_information()" id="mother_name" name="mother_name" value="<?php if(!empty($bfifpb->nid)){ echo $bfifpb->nid; } ?>" autocomplete="off" placeholder="NID Number" class="nid_number form-control"/>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<input type="hidden" name="pre_b_id" value="<?php if(!empty($bfifpb->id)){ echo $bfifpb->id; } ?>"/>
														<input type="text" id="full_name" name="full_name" value="<?php if(!empty($bfifpb->full_name)){ echo $bfifpb->full_name; } ?>" autocomplete="off" placeholder="Full name" class="form-control" required />
													</div>
												</div>														
												<div class="col-sm-3">
													<div class="form-group">
														<select id="religion" name="religion" class="form-control" required >
															<?php if(!empty($bfifpb->religion)){ echo '<option value="'.$bfifpb->religion.'">'.$bfifpb->religion.'</option>'; } else{ echo '<option value="">select religion</option>'; } ?>
															<option value="Islam">Islam</option>
															<option value="Hindu">Hindu</option>
															<option value="Christian">Christian</option>
															<option value="Buddhist">Buddhist</option>
															<option value="Other">Other</option>
														</select>
													</div>
												</div>							
												<div class="col-sm-3">
													<div class="form-group" id="custom_field_one">
														<select id="h_t_f_u" name="h_t_f_u" class="form-control" required >
															<?php if(!empty($bfifpb->h_t_f_u)){ echo '<option value="'.$bfifpb->h_t_f_u.'">'.$bfifpb->h_t_f_u.'</option>'; } else{ echo '<option value="">How to find us</option>'; } ?>										
															<option value="News Paper">News Paper</option>
															<option value="Google">Google</option>
															<option value="Facebook">Facebook</option>
															<option value="SMS">SMS</option>
															<option value="Youtube">Youtube</option>
															<option value="Parents">Parents</option>
															<option value="TVC">TVC</option>
															<option value="Friends">Friends</option>
															<option value="Colleague">Colleague</option>
															<option value="I dont Know">I don't Know</option>
															<option value="Other">Other</option>
															<option value="Custom Text">Custom Text</option>
														</select>
													</div>
													<script>
														$('document').ready(function(){
															$("#h_t_f_u").on("change",function(){
																var h_val = $(this).val();
																if(h_val == 'Custom Text'){
																	$("#h_t_f_u").css({"display":"none"});
																	$("#custom_field_one").html('<input type="text" name="h_t_f_u" id="h_t_f_u" class="form-control" placeholder="How to find us" required />');
																	$("#h_t_f_u").focus();												
																}
															})
														})
													</script>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<input type="text" id="referance_id" name="referance_id" value="" autocomplete="off" placeholder="Reference ID" class="form-control"/>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<div class="custom-file">
															<span id="avater_image">
																<?php 
																	if(!empty($bfifpb->photo_avater)){ 
																		echo '<img src="'.base_url().$bfifpb->photo_avater.'" style="width:50px;"/>';
																	}  //width: 180px; float: right;
																?>
															</span>
															<input type="hidden" id="photo_avater_value" name="photo_avater" value="<?php if(!empty($bfifpb->photo_avater)){ echo $bfifpb->photo_avater; } ?>"/>
															<button type="button" id="photo_avater" onclick="return open_camera()" title="Upload / Select / Chapture Photo" class="form-control btn btn-info" style="height:38px;<?php if(!empty($bfifpb->photo_avater)){ echo 'width: 180px; float: right;'; } ?>"><i class="fas fa-camera"></i>  Photo Upload  <i class="fas fa-upload"></i> </button>
															<?php /* ?><input type="file" id="photo_avater" name="photo_avater"   style="padding-top:3px;" accept="image/*;capture=camera" capture="camera"><?php */ ?>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-10">
													<div class="row">
														<div class="col-sm-3">
															<div class="form-group">
																<input type="text" id="father_name" name="father_name" value="<?php if(!empty($bfifpb->father_name)){ echo $bfifpb->father_name; } ?>" autocomplete="off" placeholder="Father's Name" class="form-control"/>
															</div>
														</div>
														
														<div class="col-sm-3">
															<div class="form-group">
																<input type="text" id="emergency_number_1" name="emergency_number_1" value="<?php if(!empty($bfifpb->emergency_contact_name)){ echo $bfifpb->emergency_contact_name; } ?>" autocomplete="off" placeholder="Emergency Contact Name" class="form-control" />
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<input type="number" id="emergency_number_2" name="emergency_number_2" value="<?php if(!empty($bfifpb->emergency_contact_number)){ echo $bfifpb->emergency_contact_number; } ?>" autocomplete="off" placeholder="Emergency Number" class="form-control" />
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<select id="occupation" name="occupation" class="form-control" required >
																	<?php if(!empty($bfifpb->occupation)){ echo '<option value="'.$bfifpb->occupation.'">'.$bfifpb->occupation.'</option>'; } else{ echo '<option value="">select occupation</option>'; } ?>
																	<option value="Student">Student</option>
																	<option value="Job Holder">Job Holder</option>
																	<option value="Business Man">Business Man</option>
																	<option value="Teacher">Teacher</option>
																	<option value="Doctor">Doctor</option>										
																	<option value="Driver">Driver</option>
																	<option value="Housewife">Housewife</option>
																	<option value="Other">Other</option>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="form-group">
														<select name="member_type" class="form-control" required title="Please select Member Type">
															<option value="">Member Type</option>
															<option value="NEW">NEW Member</option>
															<option value="OLD">OLD SWF Member</option>
															<option value="GROUP">Group Member</option>
														</select>
													</div>
												</div>
												
											</div>						
											<div class="row">					
												<div class="col-sm-6">
													<div class="form-group">
														<textarea id="address" name="address" autocomplete="off" class="form-control" placeholder="Address"><?php if(!empty($bfifpb->permament_address)){ echo $bfifpb->permament_address; } ?></textarea>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<textarea id="remarks" name="remarks" autocomplete="off" class="form-control" placeholder="Remarks"></textarea>
													</div>
												</div>							
											</div>	
											
											<div class="row">
												<div class="col-sm-12">
													<h4 style="text-decoration:underline;">
														Document Information									
														<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
															<button type="button" id='removeButton' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
															<button type="button" id='addButton' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
														</div>
													</h4>
													<span style="color:red;font-weight:bolder;" id="document_error_message"></span>
												</div>
											</div>					
											
											<div class="col-sm-12" style="padding-right: 0px;">
												<div class="row" id='UnitBoxesGroup'>
													<div id="UnitBoxDiv1" class="row" style="width:100%;">
														<div class="col-sm-6">
															<div class="form-group">
																<select name="document_type[]" class="form-control">
																	<option value="">select document type</option>
																	<?php
																		if(!empty($doc_type)){
																			foreach($doc_type as $row){
																				echo '<option value="'.$row->document_type.'">'.$row->document_type.'</option>';
																			}
																		}
																	?>
																</select>
															</div>
														</div>							

														<input type="hidden" name="document_number[]" value="" placeholder="Document serial number" class="form-control" />
														
														<div class="col-sm-6">
															<div class="form-group">
																<div class="custom-file">
																	<span id="avater_image_1"></span>
																	<input type="hidden" id="document_1_avater_val" name="document_upload[]" value=""/>
																	<button id="photo_avater_1" type="button" class="btn btn-info form-control" style="height:38px;"><i class="fas fa-camera"></i> Document upload <i class="fas fa-upload"></i></button>
																	<?php /* ?><input type="file" name="document_upload[]" id="photo_avater_1" style="padding-top:3px;"><?php */ ?>
																</div>
															</div>
														</div>								
														
													</div>
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
																		<input type="number" id="card_amount1" name="card_amount[]" id="card_result1" placeholder="Amount" autocomplete="off" class="form-control" readonly/>
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
																		<input type="number" id="cash_amount1" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control" />
																	</div>
																</div>
															</div>							
															
														</div>
													</div>	
												</div>
											</div>

											
										</div>
										<input type="hidden" id="booking_security_amount" title="security" name="booking_security_amount" value=""/>
										<input type="hidden" id="booking_rent_amount" title="rent" name="booking_rent_amount" value=""/>
										<input type="hidden" id="booking_parking_amount" title="parking" name="booking_parking_amount" value=""/>
										<input type="hidden" id="booking_total_amount" title="total" name="booking_total_amount" value=""/>
										<input type="hidden" id="booking_total_amount_c" title="total" name="booking_total_amount_c" value=""/>
										<input type="hidden" id="uploader_info" title="uploader" name="uploader_info" value=""/>
										<input type="hidden" id="image_test_avater" value=""/>
										<input type="hidden" id="card_number_check" value=""/>
										<input type="hidden" id="re_book_check" value=""/>
										<div class="modal-footer justify-content-between">
											<button type="button" onclick="return booking_form_reset()" class="btn btn-warning"><i class="fas fa-trash-restore-alt"></i> Reset Form</button>
											<div>
												<button type="submit" id="finish_booking" class="btn btn-success"><i class="fas fa-save"></i> Finish Booking</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							
						</div>
					</div>		
					
				</div>
			</div>
		</div>
	</div>
</div>



<!----Booking model-->
	<div class="modal fade" id="add-booking"> <!-- oncontextmenu="return false;"-->
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				
			</div>
		</div>
	</div>	
<!----End Booking model-->	

<!-----booking from prebooking start script---->

<script>
$('document').ready(function(){
	<?php if(!empty($form_opening)){ ?>
	//alert('form opening test ok!');
	$("#add-booking").modal('show');
	<?php } ?>
})

</script>

<!-----booking from prebooking END script---->


<!----bed model-->
	<div class="modal fade" id="locker_selecting_model"> 
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title"> Select Locker</h4>
						<button type="button" onclick="return ref_bed_typ()" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="locker_result">	

						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" id="btnEmpty" class="btn btn-danger cart-action" style="float:right;" onClick="return cartAction('empty','');">Refresh</button>
						<div>
							<button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-save"></i> OK</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End bed model-->						

<script>
function cartAction(action,product_code) {
	var queryString = "";
	if(action != "") {
		if(action == 'add'){
			queryString = 'action='+action+'&code='+ product_code+'&quantity=1';
		}else if(action == 'remove'){
			queryString = 'action='+action+'&code='+ product_code;
		}else{
			queryString = 'action='+action;
		}	 
	}
	jQuery.ajax({
	url: "<?php echo base_url().'assets/ajax/form_model/locker_list_list_add_to_cart.php'; ?>",
	data:queryString,
	type: "POST",
	beforeSend:function(){					
		$('#data-loading').html(data_loading);
	},
	success:function(data){
		$('#data-loading').html('');
		var d2 = data.split('||');
		if(d2[3] > 0 ){
			$("#locker_purpose").css({"display":"block"});
			$("#locker_amount").val(d2[3]);
			$("#locker_value").val(d2[3]);
			$("#locker_ids").val(d2[0]);
			$("#locker_names").val(d2[1]);
			$("#selected_locker").val(d2[1]);
			$("#locker_qty").val(d2[2]);
		}else{
			$("#locker_purpose").css({"display":"none"});
			$("#locker_amount").val('');
			$("#locker_value").val('');
			$("#locker_ids").val('');
			$("#locker_names").val('');
			$("#selected_locker").val('');
			$("#locker_qty").val('');
		}
		money_manage_ment();
		if(action != "") {
			switch(action) {
				case "add":
					$("#add_"+product_code).hide();
					$("#added_"+product_code).show();
				break;
				case "remove":
					$("#add_"+product_code).show();
					$("#added_"+product_code).hide();
					
				break;
				case "empty":
					$(".btnAddAction").show();
					$(".btnAdded").hide();
				break;
			}	 
		}
	},
	error:function (){}
	});
}

$(document).ready(function () {
	cartAction('','');
})

$('document').ready(function(){
	$('#locker').on('change',function(){
		var branch_id_lock = $("#branch_id").val();
		var locker_type = $("#locker").val();
		if(locker_type != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/option_select/select_locker_options_extende.php');?>",  
				method:"POST",  
				data:{locker_type:locker_type,branch_id:branch_id_lock},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$('#locker_result').html(data);	
					$("#locker_purpose").css({"display":"none"});
					$("#locker_amount").val('');
					$("#locker_value").val('');
					$("#locker_ids").val('');
					$("#locker_names").val('');
					$("#selected_locker").val('');					
					$('#locker_selecting_model').modal('show');   
				}  
			});  
		}
	})
})
</script>

<!--re book script-->
<script>
var re_book_id = "<?php if(!empty($_SESSION['re_book_member_id'])){ echo $_SESSION['re_book_member_id']; }else{ echo '';} ?>";
$('document').ready(function(){
	if(re_book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/re_book_member_information.php');?>",  
			method:"POST",  
			data:{re_book_id:re_book_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var d1 = data.split('||');
				$("#full_name").val(d1[0]);
				$("#email").val(d1[1]);
				$("#phone_number").val(d1[2]);
				$("#occupation").val(d1[3]);
				$("#religion").val(d1[4]);
				$("#h_t_f_u").val(d1[5]);
				$("#referance_id").val(d1[6]);
				$("#photo_avater_value").val(d1[7]);
				$("#avater_image").html('<img src="<?php echo base_url(); ?>'+d1[7]+'" style="width:50px;" id="view_image"/>');
				$("#photo_avater").css({"width":"180px","float":"right"});
				$("#image_test_avater").val('success');				
				
				$("#father_name").val(d1[8]);
				$("#mother_name").val(d1[9]);
				$("#emergency_number_1").val(d1[10]);
				$("#emergency_number_2").val(d1[11]);
				$("#address").val(d1[12]);
				$("#remarks").val(d1[13]);
				$("#re_book_check").val('1');
				
				
				$("#add-booking").modal('show'); //image_test_avater
			}
		});		
	}else{
		$("#re_book_check").val('0');
	}
	
})
</script>
<!--end re book script-->


<!----bed model-->
	<div class="modal fade" id="bed_selecting_model"> 
		<div class="modal-dialog modal-xl" style="min-width:90%;">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title" id="bed_info_header"></h4>
						<button type="button" onclick="return ref_bed_typ()" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="bed_result">	

						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" onclick="return ref_bed_typ()" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="button" id="select_bed" class="btn btn-warning"><i class="fas fa-save"></i> Select</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End bed model-->

<!----bed at a glance model-->
	<div class="modal fade" id="bed_at_a_glance_model">
		<div class="modal-dialog modal-xl" style="min-width:90%;">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">					
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group" style="margin-bottom:0px;">
										<select id="branch_iid" class="form-control select2" onchange="return on_change_branches()">
											<?php
												if(!empty($banches)){
													foreach($banches as $row){
														echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';																										
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group" style="margin-bottom:0px;">
										<select id="package_category_at_aglance" class="form-control select2"></select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group" style="margin-bottom:0px;">
										<select id="room_type_at_glnc" class="form-control select2" onchange="return on_change_branches()"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<h4 class="modal-title" id="bed_info_header"> At a Glance </h4>	
								</div>
								<div class="col-sm-1">
									<button type="button" onclick="return ref_bed_typ()" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>							
						</div>			
						
					</div>					
					<div class="modal-body" id="total_bed_information">							
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<!--<div>
							<button type="button" id="select_bed" class="btn btn-warning"><i class="fas fa-save"></i> Select</button>
						</div>-->
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End bed at a glance model-->


<!----vaiw model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title" style="font-size:23px;">Booking information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style=""></div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->

<!----autharized model-->
	<div class="modal fade" id="Authorized_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Authorized Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="Authorized_model_result" style="max-height:780px;min-height:510px;overflow-y:scroll;">	
					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End autharized model-->



<!----vaiw model-->
	<div class="modal fade" id="member_prifile_model_details">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Member Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result_details" style="max-height:780px;overflow-y:scroll;">	

						
					</div>
					<div class="modal-footer justify-content-between">

					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->

<!----Camera model-->
	<div class="modal fade" id="camera_model">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Take Member photo</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<select class="form-control" id="videoSource" onchange="return open_camera()"></select>
								</div>
							</div>
						</div>						
							
						<div id="DesiredResult" style="background-color:grey;width: 100%;">
							<video id="video" playsinline autoplay style="width:766px;"></video>
						</div>						
						<div id="output"></div>
					</div>
					<div class="modal-footer justify-content-between">
						<button onclick="return snap()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
						<button onclick="return retake_image()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
						<input type="file" id="other_file" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
						<button onclick="return capture_image_done()" type="button" class="btn btn-sm btn-success">Done</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End Camera model-->

<!----Document 1 Camera model-->
	<div class="modal fade" id="camera_model_one">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Document</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<select class="form-control" id="videoSource_one" onchange="return open_camera_one()"></select>
								</div>
							</div>
						</div>						
							
						<div id="DesiredResult_one" style="background-color:grey;width: 100%;">
							<video id="video_one" playsinline autoplay style="width:766px;"></video>
						</div>						
					</div>
					<div class="modal-footer justify-content-between">
						<button onclick="return snap_one()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
						<button onclick="return retake_image_one()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
						<input type="file" id="other_file_one" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
						<button onclick="return capture_image_done_one()" type="button" class="btn btn-sm btn-success">Done</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End Document 1 Camera model-->

<!----Document 2 Camera model-->
	<div class="modal fade" id="camera_model_two">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Document</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<select class="form-control" id="videoSource_two" onchange="return open_camera_two()"></select>
								</div>
							</div>
						</div>						
							
						<div id="DesiredResult_two" style="background-color:grey;width: 100%;">
							<video id="video_two" playsinline autoplay style="width:766px;"></video>
						</div>						
					</div>
					<div class="modal-footer justify-content-between">
						<button onclick="return snap_two()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
						<button onclick="return retake_image_two()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
						<input type="file" id="other_file_two" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
						<button onclick="return capture_image_done_two()" type="button" class="btn btn-sm btn-success">Done</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End Document 2 Camera model-->

<!----Document 3 Camera model-->
	<div class="modal fade" id="camera_model_three">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Document</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<select class="form-control" id="videoSource_three" onchange="return open_camera_three()"></select>
								</div>
							</div>
						</div>						
							
						<div id="DesiredResult_three" style="background-color:grey;width: 100%;">
							<video id="video_three" playsinline autoplay style="width:766px;"></video>
						</div>						
					</div>
					<div class="modal-footer justify-content-between">
						<button onclick="return snap_three()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
						<button onclick="return retake_image_three()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
						<input type="file" id="other_file_three" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
						<button onclick="return capture_image_done_three()" type="button" class="btn btn-sm btn-success">Done</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End Document 3 Camera model-->
<!----autharized model-->
	<div class="modal fade" id="discount_overview">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning" style="background-color:#333;color:#fff;">
						<h4 class="modal-title">Today's Discount Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="discount_overview_result" style="max-height:780px;min-height:510px;overflow-y:scroll;">	
					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End autharized model-->
<?php
date_default_timezone_set('asia/dhaka');
$number_of_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
$days_reminder = $number_of_month - date("d");
?>
<script type="text/javascript" src="<?=base_url('assets/'); ?>js/webcamjs/webcam.js"></script>
<!---------------------------------------- Desired Result ---------------------------------------->
<script>
<?php if(!empty($_SESSION['re_book_member__money'])){ ?>
	var b_amount = parseFloat(<?php echo $_SESSION['re_book_member__money']; ?>);
<?php }else{ ?>
	var b_amount = parseFloat(0);
<?php } ?>
var uploader = "<?php echo base64_encode($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']); ?>";
var ndate = '<?php echo date("Y-m-d"); ?>';
var tdate = '<?php echo $number_of_month; ?>';
var edate = '<?php echo $days_reminder + 1; ?>';
var pdate = '<?php echo "15"; ?>';
var rdays = '<?php echo sprintf("%02d", date("d")); ?>';
var bed_sel_type = '<option value="">select</option>';
var payment_pattern_values = '<option value="1">Full Payment</option><option value="0">Half Payment</option><option value="2">Due Rent</option>';
var payment_methos = '';
var w = 766, h = 575;
var shutter = new Audio();
shutter.autoplay = false;
shutter.src = navigator.userAgent.match(/Firefox/) ? '<?=base_url("assets/"); ?>js/shutter.ogg' : '<?=base_url("assets/"); ?>js/shutter.mp3';
//---avater //due_sudm

if(b_amount){
	$("#due_sudm").html('(-BDT '+b_amount+') <abbr title="Member Before Security Deposit!">MBSD</abbr>');
}else{
	$("#due_sudm").html('');
}

function capture_image_done(){	
	if(document.getElementById('camera_canvas')){
		var canvas = document.getElementById('camera_canvas');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/camera_session.php"); ?>', function(code, text) {
			$("#avater_image").html('<img src="<?=base_url();?>'+text+'" style="width:50px;" id="view_image"/>');
			$("#photo_avater_value").val(text);
			$("#photo_avater").css({"width":"180px","float":"right"});
			$('#image_test_avater').val('success');
			$('#camera_model').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file").on("change",function(){
	var fileUpload = document.getElementById('other_file');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult").textContent = "";
				document.getElementById("DesiredResult").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_camera(){	
	$('#camera_model').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video');
	const videoSelect = document.querySelector('select#videoSource');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start;
//-------------
	return camera_start();
}
function snap() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult").textContent = "";
    document.getElementById("DesiredResult").appendChild(cv);	
}
function retake_image(){
	var cm = document.createElement("video");
    cm.width = w;
    cm.id = "video" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult").html('<video id="video" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video');
	const videoSelect = document.querySelector('select#videoSource');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start;
//-------------
	return camera_start();
}
$(document).ready(function(){
	$('#camera_model').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------


//-----------------document one--------------------------
function capture_image_done_one(){	
	if(document.getElementById('camera_canvas_one')){
		var canvas = document.getElementById('camera_canvas_one');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/document_one_session.php"); ?>', function(code, text) {
			$("#avater_image_1").html('<img src="<?=base_url(); ?>'+text+'" style="width:50px;" id="view_image_one"/>');
			$("#document_1_avater_val").val(text);
			$("#photo_avater_1").css({"width":"250px","float":"right"});
			$('#camera_model_one').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file_one").on("change",function(){
	var fileUpload = document.getElementById('other_file_one');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas_one";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR = new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult_one").textContent = "";
				document.getElementById("DesiredResult_one").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
$("#photo_avater_1").on("click",function(){
	$('#camera_model_one').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video#video_one');
	const videoSelect = document.querySelector('select#videoSource_one');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_one() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start_one;
//-------------
	return camera_start_one();
})

function snap_one() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas_one";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video_one'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult_one").textContent = "";
    document.getElementById("DesiredResult_one").appendChild(cv);	
}
function retake_image_one(){
	var cm = document.createElement("video_one");
    cm.width = w;
    cm.id = "video_one" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult_one").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult_one").html('<video id="video_one" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video#video_one');
	const videoSelect = document.querySelector('select#videoSource_one');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_one() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start_one;
//-------------
	return camera_start_one();
}
$(document).ready(function(){
	$('#camera_model_one').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------


//-----------------document two--------------------------
function capture_image_done_two(){	
	if(document.getElementById('camera_canvas_two')){
		var canvas = document.getElementById('camera_canvas_two');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/document_two_session.php"); ?>', function(code, text) {
			$("#avater_image_2").html('<img src="<?=base_url(); ?>'+text+'" style="width:50px;" id="view_image_two"/>');
			$("#document_2_avater_val").val(text);
			$("#photo_avater_2").css({"width":"250px","float":"right"});
			$('#camera_model_two').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file_two").on("change",function(){
	var fileUpload = document.getElementById('other_file_two');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas_two";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR = new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult_two").textContent = "";
				document.getElementById("DesiredResult_two").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_doc_camera_2(){
	$('#camera_model_two').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video#video_two');
	const videoSelect = document.querySelector('select#videoSource_two');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_two() {		
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;		
	}
	videoSelect.onchange = camera_start_two;
//-------------
	return camera_start_two();
}


function snap_two() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas_two";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video_two'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult_two").textContent = "";
    document.getElementById("DesiredResult_two").appendChild(cv);	
}
function retake_image_two(){
	var cm = document.createElement("video_two");
    cm.width = w;
    cm.id = "video_two" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult_two").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult_two").html('<video id="video_two" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video#video_two');
	const videoSelect = document.querySelector('select#videoSource_two');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_two() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start_two;
//-------------
	return camera_start_two();
}
$(document).ready(function(){
	$('#camera_model_two').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------


//-----------------document three--------------------------
function capture_image_done_three(){	
	if(document.getElementById('camera_canvas_three')){
		var canvas = document.getElementById('camera_canvas_three');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/document_three_session.php"); ?>', function(code, text) {
			$("#avater_image_3").html('<img src="<?=base_url(); ?>'+text+'" style="width:50px;" id="view_image_three"/>');
			$("#document_3_avater_val").val(text);
			$("#photo_avater_3").css({"width":"250px","float":"right"});
			$('#camera_model_three').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file_three").on("change",function(){
	var fileUpload = document.getElementById('other_file_three');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas_three";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR = new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult_three").textContent = "";
				document.getElementById("DesiredResult_three").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_doc_camera_3(){
	$('#camera_model_three').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video#video_three');
	const videoSelect = document.querySelector('select#videoSource_three');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_three() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		
		return false;
	}
	videoSelect.onchange = camera_start_three;
//-------------
	return camera_start_three();
}


function snap_three() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas_three";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video_three'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult_three").textContent = "";
    document.getElementById("DesiredResult_three").appendChild(cv);	
}
function retake_image_three(){
	var cm = document.createElement("video_three");
    cm.width = w;
    cm.id = "video_three" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult_three").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult_three").html('<video id="video_three" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video#video_three');
	const videoSelect = document.querySelector('select#videoSource_three');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_three() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start_three;
//-------------
	return camera_start_three();
}
$(document).ready(function(){
	$('#camera_model_three').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------



//-----------------rental work java script-------------------------
function discount_overview(){ //discount_overview_result
	var today = <?php echo '1'; ?>;
	if(today != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/todays_discount_information.php');?>",  
			method:"POST",  
			data:{today:today},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#discount_overview_result').html(data); 
				$('#discount_overview').modal('show');   
			}  
		});  
	}
}

function view_member_profile(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/member_profile_information.php');?>",  
			method:"POST",  
			data:{profile_id:profile_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result_details').html(data); 
				$('#total_bed_information').html(''); 
				$('#bed_at_a_glance_model').modal('hide');  
				$('#bed_selecting_model_clender').modal('hide');
				$('#member_prifile_model_details').modal('show');   
			}  
		});  
	}
}


$(document).ready(function(){
	$('#uploader_info').val(uploader);
	return money_manage_ment();
	//return on_change_branches();
})
function booking_form_reset(){	
	$("#booking_form").trigger("reset");	
	$('#bet_type').html(bed_sel_type); 
	$("#bed_id_script").val('');
	$("#selected_bed").val('');
	$('#total_amount_large').html('0.00');	
	$('#rent_amount').val('');
	$('#security_deposit').val('');	
	$("#error_message_booking").html('');
	$('#total_amount').val(''); 
	//$("#payment_method").reset();
	//alert('Form Reset Success!');
	$("#parking_amount").val('');
	$('#rent_amount_show').val('');
	$('#ac_rent_amount_1').val('');	
	$("#payment_pattern").html(payment_pattern_values);
	$("#package").html('');
	$("#UnitBoxDiv12").remove();
	$("#UnitBoxDiv13").remove();	
	var branch_id = $("#branch_id").val();
	if(branch_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/select_spackage_category_options.php');?>",  
			method:"POST",  
			data:{view_id:branch_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#package_category').html(data); 
				var re_book_ioi = 1;
				if(re_book_ioi != ''){
					$.ajax({  
						url:"<?=base_url('assets/ajax/option_select/re_book_member_information.php');?>",  
						method:"POST",  
						data:{re_book_diss:re_book_ioi},
						beforeSend:function(){					
							$('#data-loading').html(data_loading);
						},
						success:function(data){
							$('#data-loading').html('');
							$('#due_sudm').html('');
							alert('Please Print the Recept. Page will be refresh after 10 second');
							setTimeout(function() {
								window.open('<?php echo current_url(); ?>','_self');
							}, 10000);							
						}
					});
				}
			}
		}); 
	}	
}

$('document').ready(function(){
	$("#booking_form").on("submit",function(){
		if($("#full_name").val() == ''){
			$("#member_error_message").html('Full Name Required!');
			$("#full_name").focus();
			return false;
		}else if($("#email").val() == ''){			
			$("#member_error_message").html('Email Required!');
			$("#email").focus();
			return false;
		}else if( IsEmail( $("#email").val() )){			
			$("#member_error_message").html('Enter Valid Email!');
			$("#email").focus();
			return false;
		}else if($("#phone_number").val() == ''){
			$("#member_error_message").html('Phone Number Required!');
			$("#phone_number").focus();
			return false;
		}else if($("#occupation").val() == ''){
			$("#member_error_message").html('Occupation Required!');
			$("#occupation").focus();
			return false;
		}else if($("#religion").val() == ''){
			$("#member_error_message").html('Religion Required!');
			$("#religion").focus();
			return false;
		}else if($("#h_t_f_u").val() == ''){
			$("#member_error_message").html('How to find us Required!');
			$("#h_t_f_u").focus();
			return false;
		}else if($("#photo_avater_value").val() == ''){
			$("#member_error_message").html('Capture / Choose Image File');
			$("#photo_avater").focus();
			return false;
		}else if($("#father_name").val() == ''){
			$("#member_error_message").html('Father Name Required!');
			$("#father_name").focus();
			return false;
		}else if($("#mother_name").val() == ''){
			$("#member_error_message").html('Mother Name Required!');
			$("#mother_name").focus();
			return false;
		}else if($("#emergency_number_1").val() == ''){
			$("#member_error_message").html('Emergency Contact Name Required!');
			$("#emergency_number_1").focus();
			return false;
		}else if($("#emergency_number_2").val() == ''){
			$("#member_error_message").html('Emergency Number Required!');
			$("#emergency_number_2").focus();
			return false;
		}else if($("#address").val() == ''){
			$("#member_error_message").html('Address Required!');
			$("#address").focus();
			return false;
		}else if($("#branch_id").val() == ''){
			$("#error_message_booking").html('Please Select Branch!');
			$(".branch_id").focus();
			return false;
		}else if($("#package_category").val() == ''){
			$("#error_message_booking").html('Please Select Package Category!');
			$(".package_category").focus();
			return false;
		}else if($("#package").val() == ''){
			$("#error_message_booking").html('Please Select Membership!');
			$(".package").focus();
			return false;
		}else if($("#checkin_date").val() == ''){
			$("#error_message_booking").html('Please Select CheckIn Date!');
			$(".checkin_date").focus();
			return false;
		}else if($("#bet_type").val() == ''){
			$("#error_message_booking").html('Please Select Bed Type!');
			$(".checkin_date").focus();
			return false;
		}else if($(".card_number").val() == '' && $('#force_rent').prop('checked', false)){
			$("#error_message_booking").html('Please Input Card Number');
			$(".card_number").focus();
			return false;
		}else if($("#payment_method1").val() == ''){
			$("#error_message_booking").html('Please Select At least one payment Method!');
			$(".payment_method1").focus();
			return false;
		}else{
			event.preventDefault();
			var form = $('#booking_form')[0];
			var data = new FormData(form);			
			var photo_avater = $("#photo_avater").val();
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url:"<?=base_url('assets/ajax/finally_finish_booking.php');?>",  
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				beforeSend:function(){
					$("#finish_booking").prop("disabled", true);
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					var value = data.split('____');
					if(value[1] == '1'){
						$('#member_error_message').html(value[0]);
						$("#finish_booking").prop("disabled", false);
						$('#booking_data_table').DataTable().ajax.reload( null , false);
					}else{
						$('#data_send_success_message').html(value[0]);						
						$('#add-booking').modal('hide');
						$("#finish_booking").prop("disabled", false);
						$('#booking_data_table').DataTable().ajax.reload( null , false);
						return view_profile_from_booking_1(value[2]);						
					}					
				}
			});
			return false;
		}		
			
	})
})
//$(function() {
//    setTimeout(function() {
//        $("#data_send_success_message").hide('blind', {}, 500)
//    }, 5000);
//});


function view_profile_from_booking_1(id){
	var book_id = id;
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/booking_details_information.php');?>",  
			method:"POST",  
			data:{book_id:book_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result').html(data); 
				$('#member_prifile_model').modal('show'); 
				return booking_form_reset();
			}  
		});  
	}
}

function view_profile_from_booking(id){
	var book_id = id;
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/booking_details_information.php');?>",  
			method:"POST",  
			data:{book_id:book_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result').html(data); 
				$('#member_prifile_model').modal('show'); 
			}  
		});  
	}
}

function authorized_finction(id){
	var book_id = id;
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/unathorized_to_athorize_convertion.php');?>",  
			method:"POST",  
			data:{
				book_id:book_id,
				uploader_info:uploader
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#Authorized_model_result').html(data); 
				$('#Authorized_model').modal('show');   
			}
		});
	}
}

function card_payment_calculator(){
	if( $("#payment_method1").val() == 'Credit / Debit Card' && $("#payment_method12").val() == 'Credit / Debit Card' && $("#payment_method13").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date1").val() > 0){
			var atot = parseFloat($("#Expiry_Date1").val());
		}else{
			var atot = 0;
		}		
		var rmatch_t = atot / 100 * 2;
		$("#card_amount1").val(rmatch_t);
		
		if($("#Expiry_Date12").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date12").val());
		}else{
			var atot2 = 0;
		}		
		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_amount12").val(rmatch_t2);
		
		if($("#Expiry_Date13").val() > 0){
			var atot3 = parseFloat($("#Expiry_Date13").val());
		}else{
			var atot3 = 0;
		}	

		var rmatch_t3 = atot3 / 100 * 2;
		$("#card_amount13").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		
		var grnd_total_amt = rmatch_t + rmatch_t2 + rmatch_t3 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 6%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
		
	}else if( $("#payment_method1").val() == 'Credit / Debit Card' && $("#payment_method12").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date1").val() > 0){
			var atot = parseFloat($("#Expiry_Date1").val());
		}else{
			var atot = 0;
		}

		var rmatch_t = atot / 100 * 2;
		$("#card_amount1").val(rmatch_t);
		
		if($("#Expiry_Date12").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date12").val());
		}else{
			var atot2 = 0;
		}
		
		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_amount12").val(rmatch_t2);
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + rmatch_t2 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method12").val() == 'Credit / Debit Card' && $("#payment_method13").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date12").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date12").val());
		}else{
			var atot2 = 0;
		}

		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_amount12").val(rmatch_t2);
		
		if($("#Expiry_Date13").val() > 0){
			var atot3 = parseFloat($("#Expiry_Date13").val());
		}else{
			var atot3 = 0;
		}
		var rmatch_t3 = atot3 / 100 * 2;
		$("#card_amount13").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t2 + rmatch_t3 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method1").val() == 'Credit / Debit Card' && $("#payment_method13").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date1").val() > 0){
			var atot = parseFloat($("#Expiry_Date1").val());
		}else{
			var atot = 0;
		}

		var rmatch_t = atot / 100 * 2;
		$("#card_amount1").val(rmatch_t);
		
		if($("#Expiry_Date13").val() > 0){
			var atot3 = parseFloat($("#Expiry_Date13").val());
		}else{
			var atot3 = 0;
		}

		var rmatch_t3 = atot3 / 100 * 2;
		$("#card_amount13").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + rmatch_t3;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
		
	}else if( $("#payment_method1").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date1").val() > 0){
			var atot = parseFloat($("#Expiry_Date1").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_amount1").val(rmatch_t);	
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 2%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt));		
	}else if( $("#payment_method12").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date12").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date12").val());
		}else{
			var atot2 = 0;
		}
		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_amount12").val(rmatch_t2);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t2 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 2%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method13").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date13").val() > 0){
			var atot = parseFloat($("#Expiry_Date13").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_amount13").val(rmatch_t);				
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
	}else{
		var atot = parseFloat($("#booking_total_amount_c").val());
		$("#booking_total_amount").val(atot);
		$("#crd_add_sudm").html('');
		$('#total_amount_large').html(formatCurrency(atot)); 
	}
}


function money_manage_ment(){
	if($("#try_us_condition_check").val() == '1' ){
		if(ndate == $("#checkin_date").val()){			
			$("#check_in_purpose").css({"display":"block"});
			$("#force_rent_container").css({"display":"none"});
			$('#force_rent').prop('checked', false);
			$('#card_number').attr('readonly', false);
			//----------
			if($("#vicle_parking").val() == '1' ){
				$("#parking_purpose").css({"display":"block"});
				var parki_val = parseFloat($('#parking_value').val());
				var park_m = parki_val;	
				var d_p_a = parki_val;	
			}else{
				$("#parking_purpose").css({"display":"none"});
				var park_m = parseFloat(0);
				var d_p_a = parseFloat(0);
			}

			if($("#locker_value").val() != ''){
				var locker_m = parseFloat($("#locker_value").val());
			}else{
				var locker_m = parseFloat(0);
			}
			
			if($("#disccount_money").val() != ''){
				if($('#payment_pattern').val() == '1'){
					var discount = parseInt($("#disccount_money").val());
				}else if($('#payment_pattern').val() == '0'){
					var discount = parseInt($("#disccount_money").val()) / 2;
				}else{
					var discount = parseInt($("#disccount_money").val());
				}
			}else{
				var discount = parseInt(0);				
			}
			var m_ry = parseFloat($('#rent_amount').val());
			if($('#payment_pattern').val() == '1'){
				var rent_date = m_ry;
				$("#rental_fiels_container").css({"display":"block"});
			}else if($('#payment_pattern').val() == '0'){
				var rent_paymnt_p = m_ry;			
				var rent_date = rent_paymnt_p / 2 + 200;
				$("#rental_fiels_container").css({"display":"block"});
			}else{
				var rent_date = parseFloat(0);
				var park_m = parseFloat(0);
				var due_g_m = 1;
				var r_d_a = m_ry;
				$("#rental_fiels_container").css({"display":"none"});
			}		
			
			if(rent_date > discount){
				var f_rent_v = rent_date - discount;
				$("#discount_text").val(formatCurrency(discount));
				$("#disccount_money").val(discount);
			}else{
				var f_rent_v = rent_date;
				$("#discount_text").val(formatCurrency(discount));
				$("#disccount_money").val(discount); //discount
			}
			var security_money = parseFloat($('#security_money').val());
			var all_total = security_money + park_m + f_rent_v + locker_m - b_amount;
				
			if(security_money > 0){
				$("#booking_security_amount").val(security_money);
				$("#parking_amount").val(formatCurrency(park_m));				
				$('#rent_amount_show').val(formatCurrency(f_rent_v));
				$('#ac_rent_amount_1').val(f_rent_v);	
				$('#total_amount_large').html(formatCurrency(all_total)); 
				$("#booking_total_amount").val(parseFloat(all_total));
				$("#booking_total_amount_c").val(parseFloat(all_total));
				if(due_g_m == 1){
					$("#booking_rent_amount").val(r_d_a);
					$("#booking_parking_amount").val(d_p_a);
				}else{
					$("#booking_rent_amount").val(rent_date);
					$("#booking_parking_amount").val(park_m);
				}
			}else{
				$("#booking_security_amount").val('');
				$('#total_amount_large').html('0.00');
				$("#booking_total_amount").val(parseFloat(0));
				$("#booking_total_amount_c").val(parseFloat(0));
				$('#rent_amount_show').val(0);
				$('#ac_rent_amount_1').val(0);	
				$("#parking_amount").val(0);
				$("#booking_rent_amount").val('');
				$("#booking_parking_amount").val('');
			}
			//----------
			$("#card_number_check").val('1');
		}else{
			$("#card_number_check").val('0');
			$("#force_rent_container").css({"display":"flex"});
			if($("#force_rent").is(':checked')){
				$("#check_in_purpose").css({"display":"block"});
				$('#card_number').attr('readonly', true);
				//----------
				
				if($("#vicle_parking").val() == '1' ){
					$("#parking_purpose").css({"display":"block"});
					var parki_val = parseFloat($('#parking_value').val());
					var park_m = parki_val;
					var d_p_a = parki_val;
				}else{
					//$("#payment_pattern").html(payment_pattern_values);
					var park_m = parseFloat(0);
					var d_p_a = parseFloat(0);
				}	
				
				if($("#locker_value").val() != ''){
					var locker_m = parseFloat($("#locker_value").val());
				}else{
					var locker_m = parseFloat(0);
				}
				
				if($("#disccount_money").val() != ''){
					if($('#payment_pattern').val() == '1'){
						var discount = parseInt($("#disccount_money").val());
					}else if($('#payment_pattern').val() == '0'){
						var discount = parseInt($("#disccount_money").val()) / 2;
					}else{
						var discount = parseInt($("#disccount_money").val());
					}
				}else{
					var discount = parseInt(0);				
				}
				var m_ry = parseFloat($('#rent_amount').val());

				if($('#payment_pattern').val() == '1'){
					var rent_date = m_ry;
					$("#rental_fiels_container").css({"display":"block"});
				}else if($('#payment_pattern').val() == '0'){
					var rent_paymnt_p = m_ry;			
					var rent_date = rent_paymnt_p / 2 + 200;
					$("#rental_fiels_container").css({"display":"block"});
				}else{
					var rent_date = parseFloat(0);
					var park_m = parseFloat(0);
					var due_g_m = 1;
					var r_d_a = m_ry;
					$("#rental_fiels_container").css({"display":"none"});
				}
				if(rent_date > discount){
					var f_rent_v = rent_date - discount;
					$("#discount_text").val(formatCurrency(discount));
					$("#disccount_money").val(discount);
				}else{
					var f_rent_v = rent_date;
					$("#discount_text").val(formatCurrency(discount));
					$("#disccount_money").val(discount);//discount
				}
				var security_money = parseFloat($('#security_money').val());
				var all_total = security_money + park_m + f_rent_v + locker_m - b_amount;
					
				if(security_money > 0){
					$("#booking_security_amount").val(security_money);
					$("#parking_amount").val(formatCurrency(park_m));
					$('#rent_amount_show').val(formatCurrency(f_rent_v));
					$('#ac_rent_amount_1').val(f_rent_v);	
					$('#total_amount_large').html(formatCurrency(all_total)); 
					$("#booking_total_amount").val(parseFloat(all_total));
					$("#booking_total_amount_c").val(parseFloat(all_total));
					if(due_g_m == 1){
						$("#booking_rent_amount").val(r_d_a);
						$("#booking_parking_amount").val(d_p_a);
					}else{
						$("#booking_rent_amount").val(rent_date);
						$("#booking_parking_amount").val(park_m);
					}
				}else{
					$("#booking_security_amount").val('');
					$('#total_amount_large').html('0.00');
					$("#booking_total_amount").val(parseFloat(0));
					$("#booking_total_amount_c").val(parseFloat(0));
					$("#booking_rent_amount").val('');
					$("#booking_parking_amount").val('');
					$("#parking_amount").val(0);
					$('#rent_amount_show').val(0);
					$('#ac_rent_amount_1').val(0);	
				}
				//----------
			}else{			
				$("#check_in_purpose").css({"display":"none"});
				var tt_aa = parseFloat($('#security_money').val());   
				$('#total_amount_large').html(formatCurrency(tt_aa));
				$("#booking_total_amount").val(tt_aa);
				$("#booking_total_amount_c").val(tt_aa);
				$("#booking_security_amount").val(tt_aa);
				$("#booking_rent_amount").val('');
				$("#booking_parking_amount").val('');
				$("#parking_amount").val('');
				$('#rent_amount_show').val('');
				$('#ac_rent_amount_1').val('');	
				$('#card_number').attr('readonly', false);
			}
			$("#card_number_check").val('0');
		}
	}else{
		if(ndate == $("#checkin_date").val()){
			$("#check_in_purpose").css({"display":"block"});			
			$("#force_rent_container").css({"display":"none"});
			$('#force_rent').prop('checked', false);
			$('#card_number').attr('readonly', false);
			//---------
			if($("#vicle_parking").val() == '1' ){
				$("#parking_purpose").css({"display":"block"});
				var parki_val = parseFloat($('#parking_value').val());
				var park_m = ( parki_val / tdate ) * edate;
				var d_p_a = ( parki_val / tdate ) * edate;
			}else{
				$("#parking_purpose").css({"display":"none"});
				var park_m = parseFloat(0);
				var d_p_a = parseFloat(0);
			}

			if($("#locker_value").val() != ''){
				var locker_m = parseFloat($("#locker_value").val());
			}else{
				var locker_m = parseFloat(0);
			}
			
			if($("#disccount_money").val() != ''){
				if($('#payment_pattern').val() == '1'){
					var discount = parseInt($("#disccount_money").val());
				}else if($('#payment_pattern').val() == '0'){
					var discount = parseInt($("#disccount_money").val()) / 2;
				}else{
					var discount = parseInt($("#disccount_money").val());
				}
			}else{
				var discount = parseInt(0);				
			}
			var m_ry = parseFloat($('#rent_amount').val());

			if($('#payment_pattern').val() == '1'){
				var rent_date = ( m_ry / tdate ) * edate;
				$("#rental_fiels_container").css({"display":"block"});
			}else if($('#payment_pattern').val() == '0'){
				var rent_paymnt_p = ( m_ry / tdate ) * edate;			
				var rent_date = rent_paymnt_p / 2 + 200;
				$("#rental_fiels_container").css({"display":"block"});
			}else{
				var rent_date = parseFloat(0);
				var park_m = parseFloat(0);
				var due_g_m = 1;
				var r_d_a = ( m_ry / tdate ) * edate;
				$("#rental_fiels_container").css({"display":"none"});
			}
			if(rent_date > discount){
				var f_rent_v = rent_date - discount;
				$("#discount_text").val(formatCurrency(discount));
				$("#disccount_money").val(discount);
			}else{
				var f_rent_v = rent_date;
				$("#discount_text").val(formatCurrency(discount));
				$("#disccount_money").val(discount);  //discount
			}
			var security_money = parseFloat($('#security_money').val());
			var all_total = security_money + park_m + f_rent_v + locker_m - b_amount;
				
			if(security_money > 0){
				$("#booking_security_amount").val(security_money);
				$("#parking_amount").val(formatCurrency(park_m));
				$('#rent_amount_show').val(formatCurrency(f_rent_v));
				$('#ac_rent_amount_1').val(f_rent_v);	
				$('#total_amount_large').html(formatCurrency(all_total)); 
				$("#booking_total_amount").val(parseFloat(all_total));
				$("#booking_total_amount_c").val(parseFloat(all_total));
				if(due_g_m == 1){
					$("#booking_rent_amount").val(r_d_a);
					$("#booking_parking_amount").val(d_p_a);
				}else{
					$("#booking_rent_amount").val(rent_date);
					$("#booking_parking_amount").val(park_m);
				}
			}else{
				$("#booking_security_amount").val('');
				$('#total_amount_large').html('0.00');
				$("#booking_rent_amount").val('');
				$("#booking_parking_amount").val('');
				$("#booking_total_amount").val(parseFloat(0));
				$("#booking_total_amount_c").val(parseFloat(0));
				$('#rent_amount_show').val(0);
				$('#ac_rent_amount_1').val(0);	
				$("#parking_amount").val(0);
			}
			//---------
			$("#card_number_check").val('1');
		}else{
			$("#force_rent_container").css({"display":"flex"});
			if($("#force_rent").is(':checked')){
				$("#check_in_purpose").css({"display":"block"});	
				$('#card_number').attr('readonly', true);
				//---------------------------------------------
				var n_chk_in = $("#checkin_date").val().split('-');
				var n_days_ed = getDaysInMonth(n_chk_in[1],n_chk_in[0]);
				var n_days_m = getDaysInMonth(n_chk_in[1],n_chk_in[0]);
				if( parseInt(n_chk_in[2]) > n_chk_in[2]){
					var ac_days = n_days_m - parseInt(n_chk_in[2]) + 1;
				}else if( parseInt(n_chk_in[1]) == n_chk_in[1]){
					var ac_days = n_days_m - parseInt(n_chk_in[2]) + 1;
				}else if( parseInt(n_chk_in[1]) > n_chk_in[1]){
					var number_after_d = n_chk_in[2];
					var date_month = n_chk_in[1] + 1;
					var number_after_n = getDaysInMonth(date_month, n_chk_in[0]);
					var ac_days = number_after_n - number_after_d + 1;
				}else if(parseInt(n_chk_in[0]) == n_chk_in[0]){
					var number_after_d = n_chk_in[2];
					var date_month = n_chk_in[1] + 1;
					var number_after_n = getDaysInMonth(date_month , n_chk_in[0]);
					var ac_days = number_after_n - number_after_d + 1;
				}else if(parseInt(n_chk_in[0]) > n_chk_in[0]){
					var number_after_d = n_chk_in[2];
					var number_after_m = n_chk_in[1];
					var number_after_y = n_chk_in[0];
					var date_year = number_after_y + 1;
					var number_after_n = getDaysInMonth(number_after_m, date_year);
					var ac_days = number_after_n - number_after_d + 1;
				}else{
					var ac_days = parseFloat(n_days_m) - n_chk_in[2] + 1;
					//var ac_days = 'test not working!';
				}
				
				//------------
				//---------
				if($("#vicle_parking").val() == '1' ){
					$("#parking_purpose").css({"display":"block"});					
					var parki_val = parseFloat($('#parking_value').val());					
					var park_m = ( parki_val / n_days_ed ) * ac_days;
					var d_p_a = ( parki_val / n_days_ed ) * ac_days ;
				}else{
					$("#parking_purpose").css({"display":"none"});
					var park_m = parseFloat(0);
					var d_p_a = parseFloat(0);
				}	
				
				if($("#locker_value").val() != ''){
					var locker_m = parseFloat($("#locker_value").val());
				}else{
					var locker_m = parseFloat(0);
				}
				
				if($("#disccount_money").val() != ''){
					if($('#payment_pattern').val() == '1'){
						var discount = parseInt($("#disccount_money").val());
					}else if($('#payment_pattern').val() == '0'){
						var discount = parseInt($("#disccount_money").val()) / 2;
					}else{
						var discount = parseInt($("#disccount_money").val());
					}
				}else{
					var discount = parseInt(0);				
				}
				var m_ry = parseFloat($('#rent_amount').val());

				if($('#payment_pattern').val() == '1'){
					var rent_date = ( m_ry / n_days_ed ) * ac_days;
					$("#rental_fiels_container").css({"display":"block"});
				}else if($('#payment_pattern').val() == '0'){
					var rent_paymnt_p = ( m_ry / n_days_ed ) * ac_days ;			
					var rent_date = rent_paymnt_p / 2 + 200;
					$("#rental_fiels_container").css({"display":"block"});
				}else{
					var rent_date = parseFloat(0);
					var park_m = parseFloat(0);
					var due_g_m = 1;
					var r_d_a = ( m_ry / n_days_ed ) * ac_days;
					$("#rental_fiels_container").css({"display":"none"});
				}
				//alert(n_days_ed + ' ------ ' + ac_days);
				if(rent_date > discount){
					var f_rent_v = rent_date - discount;
					$("#discount_text").val(formatCurrency(discount));
					$("#disccount_money").val(discount);
				}else{
					var f_rent_v = rent_date;
					$("#discount_text").val(formatCurrency(discount));
					$("#disccount_money").val(discount); //discount
				}
				var security_money = parseFloat($('#security_money').val());
				var all_total = security_money + park_m + f_rent_v + locker_m - b_amount;
					
				if(security_money > 0){
					$("#booking_security_amount").val(security_money);
					$("#parking_amount").val(formatCurrency(park_m));
					$('#rent_amount_show').val(formatCurrency(f_rent_v));
					$('#ac_rent_amount_1').val(f_rent_v);	
					$('#total_amount_large').html(formatCurrency(all_total)); 
					$("#booking_total_amount").val(parseFloat(all_total));
					$("#booking_total_amount_c").val(parseFloat(all_total));
					if(due_g_m == 1){
						$("#booking_rent_amount").val(r_d_a);
						$("#booking_parking_amount").val(d_p_a);
					}else{
						$("#booking_rent_amount").val(rent_date);
						$("#booking_parking_amount").val(park_m);
					}
				}else{
					$("#booking_security_amount").val('');
					$('#total_amount_large').html('0.00');
					$("#booking_rent_amount").val('');
					$("#booking_parking_amount").val('');
					$("#booking_total_amount").val(parseFloat(0));
					$("#booking_total_amount_c").val(parseFloat(0));
					$('#rent_amount_show').val(0);
					$('#ac_rent_amount_1').val(0);	
				}
				//---------
			}else{
				$("#check_in_purpose").css({"display":"none"});
				var tt_aa = parseFloat($('#security_money').val());   
				$('#total_amount_large').html(formatCurrency(tt_aa));
				$("#booking_total_amount").val(tt_aa);
				$("#booking_total_amount_c").val(tt_aa);
				$("#booking_security_amount").val(tt_aa);
				$("#booking_rent_amount").val('');
				$("#booking_parking_amount").val('');
				$("#parking_amount").val('');
				$('#rent_amount_show').val('');
				$('#ac_rent_amount_1').val('');	
				$('#card_number').attr('readonly', false);
			}
			$("#card_number_check").val('0');
		}
	}
	
	if($("#try_us_condition_check").val() == 1 ){
		if($("#try_us_days").val() > 29 ){
			//$('#payment_pattern').attr('disabled', false);
			$("#payment_pattern option[value='0']").show();
			$("#payment_pattern option[value='2']").show();  // temporary Open for try us 30 day which was desiable
		}else{
			//$('#payment_pattern').attr('disabled', true);
			$("#payment_pattern option[value='0']").hide();
			$("#payment_pattern option[value='2']").show();   // temporary Open for try us 30 day which was desiable
		}
		
		if($('#payment_pattern').val() == '1'){
			$('#card_number').attr('disabled', false);
		}else if($('#payment_pattern').val() == '0'){
			$('#card_number').attr('disabled', false);
		}else{
			$('#card_number').attr('disabled', true);
		}
	}else{
		var n_chk_inq = $("#checkin_date").val().split('-');
		if($("#force_rent").is(':checked')){
			if(n_chk_inq[2] < 16 ){
				//$('#payment_pattern').attr('disabled', false);
				$("#payment_pattern option[value='0']").show();
				$("#payment_pattern option[value='2']").hide();
			}else{
				//$('#payment_pattern').attr('disabled', true);
				$("#payment_pattern option[value='0']").hide();
				$("#payment_pattern option[value='2']").hide();
			}
		}else if(pdate > rdays){
			//$('#payment_pattern').attr('disabled', false);
			$("#payment_pattern option[value='0']").show();
			$("#payment_pattern option[value='2']").show();
		}else{
			//$('#payment_pattern').attr('disabled', true);
			$("#payment_pattern option[value='0']").hide();
			$("#payment_pattern option[value='2']").show(); //hide
		}
	}
	$("#check_out_date").attr("min",$("#checkin_date").val());
}
var getDaysInMonth = function(month,year){
	return new Date(year, month, 0).getDate();
};
$("#force_rent").on("change",function(){
	return money_manage_ment();
})

function get_bet_info_at(id){
	var bed_id = id;				
	if(bed_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/select_beds_information_from_at_a_glance.php');?>",  
			method:"POST",  
			data:{bed_id:bed_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('_');
				$("#bed_id_script").val(value[0]);
				$("#selected_bed").val(value[1]);
				
				$("#bet_type").html(value[2]);
				$('#bed_at_a_glance_model').modal('hide'); 
				$('#bed_selecting_model_clender').modal('hide'); 
				$('#bed_selecting_model').modal('hide');
				$('#add-booking').modal('show');  
			}
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}		
}

function branches_onLoad_windows(branch_iid,room_type){
	if( branch_iid != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/hole_branch_bed_information.php');?>",  
			method:"POST",
			data:{
				branch_id:branch_iid,
				bed_type:room_type
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#total_bed_information').html(data);  
				$('#bed_at_a_glance_model').modal('show');  
			}  
		});  
	}
}

function on_change_branches(){
	var branch_ppoiuty = $("#branch_iid").val();
	$.ajax({  
		url:"<?=base_url('assets/ajax/select_spackage_category_options.php');?>",  
		method:"POST",  
		data:{view_id:branch_ppoiuty},
		success:function(data){						
			$('#package_category_at_aglance').html(data);
			return branches_onLoad_windows($("#branch_iid").val(),$("#room_type_at_glnc").val());				
		}  
	});	
}

$(document).ready(function(){
	$("#package_category_at_aglance").on("change",function(){
		var id = $( this ).val(); 
		if(id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/option_select/select_room_type_options.php');?>",  
				method:"POST",  
				data:{view_id:id},
				success:function(data){	
					$('#room_type_at_glnc').html(data);    
				}  
			});  
		}
	})
})

$("#checkin_date").on("change keyup keyown",function(){ //focus focusout 
	var id = $("#package_category").val();
	if(id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/select_package_options.php');?>",  
			method:"POST",  
			data:{view_id:id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){
				$.ajax({  
					url:"<?=base_url('assets/ajax/option_select/select_room_type_options.php');?>",  
					method:"POST",  
					data:{view_id:id},
					beforeSend:function(){					
						$('#data-loading').html(data_loading);					 
					},
					success:function(data){	
						$('#data-loading').html('');
						$('#bet_type').html(data); 
						$('#rent_amount_show').val('');
						$('#rent_amount').val('');
						$("#parking_amount").val('');
						$("#check_out_date").val('');
						$('#total_amount_large').html('0.00');
						$('#security_money').val('');
						$('#security_deposit').val('');
						$("#discount_text").val('');
						$("#disccount_money").val('');
						return money_manage_ment();	
					}  
				});					
				$('#package').html(data); 
				if($(".my_check_value").val() == ''){
					$("#error_message_booking").html('Please Select CheckIn Date!');
					$(".my_check_value").focus();
				}				
			}  
		});
	}
	
})
function IsEmail(email) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(!regex.test(email)) {
		return true;
	}else{
		return false;
	}
}
function formatCurrency(total) {
	var neg = false;
	if(total < 0) {
		neg = true;
		total = Math.abs(total);
	}
	return (neg ? "-BDT " : 'BDT ') + parseFloat(total, 10).toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}



function get_bet_info(id){
	var bed_id = id;				
	if(bed_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/select_beds_information.php');?>",  
			method:"POST",  
			data:{bed_id:bed_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('_');
				$("#bed_id_script").val(value[0]);
				$("#selected_bed").val(value[1]);
				$('#bed_selecting_model').modal('hide');  
			}
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}		
}

function ref_bed_typ(){
	$('#bet_type').html(bed_sel_type); 
	$('#selected_bed').val(''); 
}
function bet_change_after_select(){
	var branch_id = $("#branch_id").val();
	if($("#bet_type").val() == ''){
		$("#error_message_booking").html('Please Select Bed Type!');
		$(".bet_type").focus();
	} else {
		var bed_type = $("#bet_type").val();
		if($("#checkin_date").val() != ''){
			var checkin_date = $("#checkin_date").val();
		}else{
			var checkin_date = '';
		}
		
		if(bed_type != ''){
			$.ajax({
				url:"<?=base_url('assets/ajax/select_beds_options.php');?>",  
				method:"POST",  
				data:{bed_type:bed_type,branch_id:branch_id,checkin_date:checkin_date},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$('#bed_result').html(data); 
					$('#bed_info_header').html('<i class="fas fa-check"></i> Selected Bed Information. Bed Type: '+bed_type);
					$('#bed_selecting_model').modal('show');   
				}  
			});  
		}
	}
}


$(document).ready(function(){
	$("#package").on("change",function(){
		if($("#email").val() != ''){
			var email = $("#email").val();
		}else{
			var email = '';
		}
		if($("#phone_number").val() != ''){
			var phone = $("#phone_number").val();
		}else{
			var phone = '';
		}
		var pkg_id = $( this ).val();
		var checkin_modify = $("#checkin_date").val().split('-');
		var checkInDate = checkin_modify[2] + '/' + checkin_modify[1] + '/' + checkin_modify[0];
		if(pkg_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/select_pkg_price_options.php');?>",  
				method:"POST",  
				data:{
					pkg_id:pkg_id,
					checkInDate:checkInDate,
					email:email,
					phone:phone
				},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);
				},
				success:function(data){	
					$('#data-loading').html('');
					var value = data.split('_');					
					var s_m = parseFloat(value[0]);					
					var m_r = parseFloat(value[1]);				
					var p_d = value[2];						
					var p_d_continue = value[3];
					var p_d_days = value[4];
					var parking_value = value[5];
					var try_us_v = value[6];
					//alert(p_d_days + '-' + try_us_v);
					$("#try_us_days").val(p_d_days);
					$("#try_us_condition_check").val(try_us_v);
					$("#check_out_date_number").val(p_d);
					$("#check_out_date").val(p_d_continue);					
					if(value[6] == '1' ){
						$("#check_out_date").attr("readonly",true);						
					//}else{
						//$("#check_out_date").attr("type","date");
						//$("#check_out_date").attr("min",$("#checkin_date").val());
						//$("#check_out_date").attr("readonly",false);
					}
					if(value[7] != '' ){
						$("#check_out_info").val(value[7]);
					}else{
						$("#check_out_info").val('');
					}
					$("#discount_text").val(formatCurrency(value[8]));
					$("#disccount_money").val(value[8]);
					
					
					$('#security_deposit').val(formatCurrency(s_m));					
					$('#rent_amount').val(m_r);					
					var total = parseFloat( s_m );					
					$('#security_money').val(total);  
					$('#parking_value').val(parking_value);  
					$("#payment_pattern").html(payment_pattern_values);
					return money_manage_ment();									
				}  
			});  
		}
		$('#rent_amount_show').val('');
		$('#rent_amount').val('');
		$("#parking_amount").val('');
		$("#check_out_date").val('');
		$('#total_amount_large').html('0.00');
		$('#security_money').val('');
		$('#security_deposit').val('');
		$("#check_out_date").attr("type","text");
		$("#discount_text").val('');
		$("#disccount_money").val('');
		//$("#check_out_date").attr("readonly",false);
	})
	$("#package_category").on("change",function(){
		var id = $( this ).val();
		if(id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/select_package_options.php');?>",  
				method:"POST",  
				data:{view_id:id},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){
					$.ajax({  
						url:"<?=base_url('assets/ajax/option_select/select_room_type_options.php');?>",  
						method:"POST",  
						data:{view_id:id},
						beforeSend:function(){					
							$('#data-loading').html(data_loading);					 
						},
						success:function(data){	
							$('#data-loading').html('');
							$('#bet_type').html(data);    
						}  
					});					
					$('#package').html(data); 
					if($(".my_check_value").val() == ''){
						$("#error_message_booking").html('Please Select CheckIn Date!');
						$(".my_check_value").focus();
					}				
				}  
			});
		}
		$('#rent_amount_show').val('');
		$('#rent_amount').val('');
		$("#parking_amount").val('');
		$("#check_out_date").val('');
		$('#total_amount_large').html('0.00');
		$('#security_money').val('');
		$('#security_deposit').val('');
		$("#discount_text").val('');
		$("#disccount_money").val('');
		$("#checkin_date").val('<?php echo date("Y-m-d"); ?>');
		return money_manage_ment();
		//$("#check_out_date").attr("readonly",false);
	})
	
	$("#branch_id").on("change",function(){
		var branch_id = $("#branch_id").val(); 
		if(branch_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/select_spackage_category_options.php');?>",  
				method:"POST",  
				data:{view_id:branch_id},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);
				},
				success:function(data){	
					$('#data-loading').html('');
					$.ajax({  
						url:"<?=base_url('assets/ajax/option_select/select_locker_options.php');?>",  
						method:"POST",  
						data:{view_id:branch_id},
						success:function(data){						
							$('#locker').html(data);
							$("#locker_purpose").css({"display":"none"});
							$("#locker_amount").val('');
							$("#locker_value").val('');
							$("#locker_ids").val('');
							$("#locker_names").val('');
							$("#selected_locker").val('');
						}
					}); 
					$('#package_category').html(data);    
					$('#bet_type').html(bed_sel_type);    
					$('#security_deposit').val('');   
					$('#rent_amount').val('');
					$('#total_amount').val('');
					$('#package').html('<option value="">select</option>');
					$('#rent_amount_show').html('');
				}
			});
		}
		$('#rent_amount_show').val('');
		$('#rent_amount').val('');
		$("#parking_amount").val('');
		$("#check_out_date").val('');
		$('#total_amount_large').html('0.00');
		$('#security_money').val('');
		$('#security_deposit').val('');
		$("#discount_text").val('');
		$("#disccount_money").val('');
	})
	var branch_id = $("#branch_id").val();
	if(branch_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/select_spackage_category_options.php');?>",  
			method:"POST",  
			data:{view_id:branch_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');
				$.ajax({  
					url:"<?=base_url('assets/ajax/option_select/select_locker_options.php');?>",  
					method:"POST",  
					data:{view_id:branch_id},
					success:function(data){						
						$('#locker').html(data); 
						$("#locker_purpose").css({"display":"none"});
						$("#locker_amount").val('');
						$("#locker_value").val('');
						$("#locker_ids").val('');
						$("#locker_names").val('');
						$("#selected_locker").val('');
					}
				}); 
				$('#package_category').html(data);  
			}
		}); 
	}

	//$('#bed_selecting_model').on('hidden.bs.modal', function () {
		//$('#bet_type').html(bed_sel_type);
	//})

	
	
	
	$("#bet_type").on("change",function(){			
		if($(".my_check_value").val() == ''){
			$("#error_message_booking").html('Please Select CheckIn Date!');
			$(".my_check_value").focus();
		}else if($("#package_category").val() == ''){
			$("#error_message_booking").html('Please Select Package Category!');
			$("#package_category").focus();
		} else if ($("#package").val() == ''){
			$("#error_message_booking").html('Please Select Package!');
			$("#package").focus();
		}else{ 
			var branch_id = $("#branch_id").val(); 
			if($("#checkin_date").val() != ''){
				var checkin_date = $("#checkin_date").val();
			}else{
				var checkin_date = '';
			}
			var bed_type = $( this ).val();
			if(bed_type != ''){
				$.ajax({  
					url:"<?=base_url('assets/ajax/select_beds_options.php');?>",  
					method:"POST",  
					data:{bed_type:bed_type,branch_id:branch_id,checkin_date:checkin_date},
					beforeSend:function(){					
						$('#data-loading').html(data_loading);
					},
					success:function(data){
						$('#data-loading').html('');
						$('#bed_result').html(data); 
						$('#bed_info_header').html('<i class="fas fa-check"></i> Selected Bed Information. Bed Type: '+bed_type);
						$('#bed_selecting_model').modal('show');   
					}  
				});  
			}
			$("#error_message_booking").html('');
		 } 
	})
	
	
	
	
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
			dataq += '<div class="col-sm-6">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="credit_card_number1'+counter_payment+'" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;"><input type="hidden" name="card_secret[]" value="0"/>';
			dataq += '<input type="text" id="Expiry_Date1'+counter_payment+'" onkeyup="return card_payment_calculator()" name="Expiry_Date[]" id="card_amount'+counter_payment+'" placeholder="Amount" autocomplete="off"  class="form-control" />';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="card_amount1'+counter_payment+'" name="card_amount[]" id="card_result'+counter_payment+'" placeholder="Amount" autocomplete="off" class="form-control" readonly/>';
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
			dataq += '<input type="text" id="cash_amount1'+counter_payment+'" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
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
		
    var counter = 2;
    $("#addButton").click(function () {
		if( counter == 4 ){
			alert("Sorry! Maximum number of field reached");
			return false;			
		}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv1' + counter ,
			class: 'row',
			style: 'width:100%'
		});		
		var data = '<div class="col-sm-6">';
			data += '<div class="form-group">';
			data += '<select name="document_type[]" class="form-control" required>';
			data += '<option value="">select Document Type</option>';
			data += '<?php if(!empty($doc_type)){ foreach($doc_type as $row){ echo '<option value="'.$row->document_type.'">'.$row->document_type.'</option>'; } } ?>';
			data += '</select>';
			data += '</div>';
			data += '</div>';
			data += '<input type="hidden" name="document_number[]" value="" placeholder="Document serial number" class="form-control" required />';			
			data += '<div class="col-sm-6">';
			data += '<div class="form-group">';
			data += '<div class="custom-file">';
			data += '<span id="avater_image_'+counter+'"></span>';
			data += '<button id="photo_avater_'+counter+'" onclick="open_doc_camera_'+counter+'()"  type="button" class="btn btn-info form-control" style="height:38px;"><i class="fas fa-camera"></i> Document upload <i class="fas fa-upload"></i></button>';
			data += '<input type="hidden" name="document_upload[]" id="document_'+counter+'_avater_val" class="form-control" style="padding-top:3px;" required>';
			//data += '<label class="custom-file-label" for="customFile">Upload Document</label>';
			data += '</div>';
			data += '</div>';
			data += '</div>';
		newTextBoxDiv.after().html(data);
		newTextBoxDiv.appendTo("#UnitBoxesGroup");
		counter++;
    });
    $("#removeButton").click(function () {
		if( counter == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter--;
        $("#UnitBoxDiv1" + counter).remove();
    });
})

function booking_report_table(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
	var ajax_data = "<?=base_url(); ?>assets/ajax/data_table/booking_information_datatable.php"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();
}

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>