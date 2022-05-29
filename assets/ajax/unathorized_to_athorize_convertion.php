<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['book_id'])){ 
$booking_info = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$_POST['book_id']."'"));
$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$booking_info['booking_id']."'"));
$rent_info = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$booking_info['booking_id']."' order by id desc"));
$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking_info['package']."'"));
?>

<div class="row">
	<div class="col-sm-12">
		<form method="post" id="authorize_form" enctype="multipart/form-data">
			<span id="err_msg_aut" style="color:red;font-weight:bolder;"></span>
			<span id="member_error_message" style="color:red;font-weight:bolder;"></span>
			<input type="hidden" name="uploader_infoe" id="uploader_info" value="<?php if(!empty($_POST['uploader_info'])){ echo $_POST['uploader_info']; }?>"/>
			<input type="hidden" name="booking_id" id="booking_id" value="<?php if(!empty($member_info['booking_id'])){ echo $member_info['booking_id']; }?>"/>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-grouop">
						<label>Input Valid Card Number</label>
						<input type="text" name="card_numberss" id="card_numberss" placeholder="Card Number" class="number_int form-control" style=" FONT-SIZE: 30px; font-weight: bolder;"/>
						<p class="m-0 p-0 text-danger" id="error_message"></p>
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
		$('input[id="card_amount1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		
	}else if($("#payment_method_aut1").val() == 'Check'){
		$("#mobile_banking_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"none"});
		$("#check_number_aut1").css({"display":"flex"});
		$("#cash_aut1").css({"display":"none"});
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
		$('input[id="card_amount1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method_aut1").val() == 'Credit / Debit Card'){
		$("#mobile_banking_aut1").css({"display":"none"});
		$("#check_number_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"flex"});
		$("#cash_aut1").css({"display":"none"});
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
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',true);
		$('input[id="card_amount1"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---		
	}else if($("#payment_method_aut1").val() == 'Cash'){
		$("#mobile_banking_aut1").css({"display":"none"});
		$("#check_number_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"none"});
		$("#cash_aut1").css({"display":"flex"});
		
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
		$('input[id="card_amount1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',true);
		//-----cash---
	}else{
		$("#mobile_banking_aut1").css({"display":"none"});
		$("#check_number_aut1").css({"display":"none"});
		$("#credit_card_aut1").css({"display":"none"});
		$("#cash_aut1").css({"display":"none"});
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
		$('input[id="card_amount1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---
		
	}
	
	if($("#payment_method_aut12").val() == 'Mobile Banking'){
		$("#mobile_banking_aut12").css({"display":"flex"});
		$("#check_number_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"none"});		
		$("#cash_aut12").css({"display":"none"});
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
		$('input[id="card_amount2"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method_aut12").val() == 'Check'){
		$("#mobile_banking_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"none"});
		$("#check_number_aut12").css({"display":"flex"});		
		$("#cash_aut12").css({"display":"none"});
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
		$('input[id="card_amount2"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method_aut12").val() == 'Credit / Debit Card'){
		$("#mobile_banking_aut12").css({"display":"none"});
		$("#check_number_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"flex"});
		$("#cash_aut12").css({"display":"none"});
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
		$('input[id="card_amount2"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method_aut12").val() == 'Cash'){
		$("#mobile_banking_aut12").css({"display":"none"});
		$("#check_number_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"none"});
		$("#cash_aut12").css({"display":"flex"});
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
		$('input[id="card_amount2"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',true);
		//-----cash---
	}else{
		$("#mobile_banking_aut12").css({"display":"none"});
		$("#check_number_aut12").css({"display":"none"});
		$("#credit_card_aut12").css({"display":"none"});
		$("#cash_aut12").css({"display":"none"});
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
		$('input[id="card_amount2"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
	}
	
	if($("#payment_method_aut13").val() == 'Mobile Banking'){
		$("#mobile_banking_aut13").css({"display":"flex"});
		$("#check_number_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"none"});
		$("#cash_aut13").css({"display":"none"});
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
		$('input[id="card_amount3"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method_aut13").val() == 'Check'){
		$("#mobile_banking_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"none"});
		$("#check_number_aut13").css({"display":"flex"});
		$("#cash_aut13").css({"display":"none"});
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
		$('input[id="card_amount3"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method_aut13").val() == 'Credit / Debit Card'){
		$("#mobile_banking_aut13").css({"display":"none"});
		$("#check_number_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"flex"});
		$("#cash_aut13").css({"display":"none"});
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
		$('input[id="card_amount3"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method_aut13").val() == 'Cash'){
		$("#mobile_banking_aut13").css({"display":"none"});
		$("#check_number_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"none"});
		$("#cash_aut13").css({"display":"flex"});
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
		$('input[id="card_amount3"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',true);
		//-----cash---
	}else{
		$("#mobile_banking_aut13").css({"display":"none"});
		$("#check_number_aut13").css({"display":"none"});
		$("#credit_card_aut13").css({"display":"none"});
		$("#cash_aut13").css({"display":"none"});
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
		$('input[id="card_amount3"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
	}
	return card_payment_calculator();
}
</script>
<?php if(empty($rent_info['booking_id']) AND $package_info['try_us'] == '1'){  //parking
$ac_rent = $booking_info['rent_amount'];
$check_in = explode('/',$booking_info['checkin_date']);

if($package_info['try_us'] == 1){
	$days_remin = $package_info['package_days'];
	// code change for rent update. 01/04/2022
	/* if($package_info['aggreement'] == 1){
		$rent_amount = $package_info['monthly_rent'];
	}else{
		$rent_amount = $package_info['monthly_rent'];
	} */
	
	if($package_info['aggreement'] == 1){
		$rent_amount = $booking_info['rent_amount'];
	}else{
		$rent_amount = $booking_info['rent_amount'];
	}	
	$park_amount = $package_info['parking_amount'];
	$cin_days = $check_in[0];
	$total_days = $package_info['package_days'];
}else{
	$cin_days = $check_in[0];
	$cin_month = $check_in[1];
	$cin_years = $check_in[2];
	$rent_amount = $package_info['monthly_rent'];
	$park_amount = $package_info['parking_amount'];
	$total_days = cal_days_in_month(CAL_GREGORIAN,$cin_month,$cin_years);
	$days_remin = $total_days - $cin_days;
	$rent_div = $rent_amount / $total_days;
}
$total_rent = $rent_amount; //$ac_rent; //$rent_div * $days_remin;

$dis = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$member_info['booking_id']."'"));
if(!empty($dis['id'])){
	$dis_count_amount = $dis['amount'];
}else{
	$dis_count_amount = '0';
}
$total_rent = $total_rent - $dis_count_amount;
if($member_info['parking'] == '1'){
	$park_div = $park_amount / $total_days;
	$total_parking = $park_div * $days_remin;
}else{
	$total_parking = '0';
}
$total_amount_all = $total_rent + $total_parking;
?>
<style>
select[readonly]
{
    pointer-events: none;
}
</style>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-3"></div>
				<div class="col-sm-3"></div>
				<div class="col-sm-3"></div>
				<div class="col-sm-3" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
					<div class="form-group" style="margin:0px;">
						<label style="margin-bottom:0px;"><i class="fas fa-calculator"></i> 
							Total Amount
							<span id="crd_add_sudm_P" style="color:#f00;"></span>
						</label>
						<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
						<div id="total_amount_aut" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">
							<?php echo round($total_amount_all,2); ?>
						</div>
					</div>
				</div>	
				<input type="hidden" value="<?php echo round($total_amount_all,2); ?>" name="total_result_c" id="total_result_c"/>
				<div class="col-sm-3">
					<div class="form-grouop">
						<label>Discount</label>
						<input type="text" id="discount_amount" value="<?php echo round($dis_count_amount,2); ?>" class="form-control" readonly/>
						<input type="hidden" value="<?php echo round($dis_count_amount,2); ?>" name="get_discount_amount" id="get_discount_amount"/>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-grouop">
						<label>Renntal Amount <?php if($dis_count_amount > 0 ){ echo '- Discount'; } ?></label>
						<input type="text" id="rent_amountaa" value="" class="form-control" readonly/>
						<input type="hidden" value="<?php echo round($total_rent,2); ?>" id="get_rent_amount"/>
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-grouop">
						<label>Payment Pattern</label>
						<select name="payment_pattern_athu" id="payment_pattern_athu" onchange="return money_management_athorization()" class="form-control" <?php echo 'required'; ?>>
							<option value="1">Full Payment</option>
							<?php if($cin_days < 16 OR $package_info['try_us'] == '1'){ ?>
							<option value="0">Half Payment</option>
							<?php } ?>
							
						</select>
					</div>			
				</div>				
				<div class="col-sm-3">
					<?php if($member_info['parking'] = '1'){ ?>
					<div class="form-grouop">
						<label>Parking Amount</label>
						<input type="text" id="parkingaaa" value="" class="form-control" readonly/>
						<input type="hidden" id="get_parking_am_atu" value="<?php echo round($total_parking,2); ?>"/>
					</div>
					<?php } ?>
				</div>				
				
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
											<input type="text" id="mobile_amount1" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="number_int form-control"/>
										</div>
									</div>
									
								</div>
								<div class="row" id="check_number_aut1" style="display:none;">
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
								
								<div class="row" id="credit_card_aut1" style="display:none;">
									<div class="col-sm-6">
										<div class="form-group" style="width:100%;">
											<input type="text" id="credit_card_number1" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>
										</div>
									</div>
									
									<input type="hidden" id="card_secret1" name="card_secret[]" value="0"/><div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="number" id="card_amount1" onkeyup="return card_payment_calculator()" name="Expiry_Date[]" placeholder="Amount" autocomplete="off" class="card_amount1 form-control"/>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" id="card_result1" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control" readonly/>
										</div>
									</div>
								</div>
								
								<div class="row" id="cash_aut1" style="display:none;">
									<div class="col-sm-9">
										<div class="form-group" style="width:100%;">
											<textarea id="cash_other_information_remarks1" name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>											
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group" style="width:100%;">
											<input type="text" id="cash_amount1" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="number_int form-control"/>
										</div>
									</div>
								</div>							
								
							</div>
						</div>	
					</div>
				</div>
				<input type="hidden" name="days_remin" value="<?php echo $days_remin; ?>"/>
				<input type="hidden" name="sent_rent_amount" id="sent_rent_amount" value=""/>
				<input type="hidden" name="sent_parking_amount" id="sent_parking_amount" value=""/>
				<input type="hidden" name="sent_total_amount" id="sent_total_amount" value=""/>				
			</div>
<script>
function card_payment_calculator(){
	if( $("#payment_method_aut1").val() == 'Credit / Debit Card' && $("#payment_method_aut12").val() == 'Credit / Debit Card' && $("#payment_method_aut13").val() == 'Credit / Debit Card'){
		if($(".card_amount1").val() > 0){
			var atot = parseFloat($(".card_amount1").val());
		}else{
			var atot = 0;
		}		
		var rmatch_t = atot / 100 * 2;
		$("#card_result1").val(rmatch_t);
		
		if($("#card_amount2").val() > 0){
			var atot2 = parseFloat($("#card_amount2").val());
		}else{
			var atot2 = 0;
		}		
		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_result2").val(rmatch_t2);
		
		if($("#card_amount3").val() > 0){
			var atot3 = parseFloat($("#card_amount3").val());
		}else{
			var atot3 = 0;
		}

		var rmatch_t3 = atot3 / 100 * 2;
		$("#card_result3").val(rmatch_t3);		
		
		var total = parseFloat($("#total_result_c").val());
		
		var grnd_total_amt = rmatch_t + rmatch_t2 + rmatch_t3 + total;
		
		$("#sent_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm_P").html('(CP: 6%)');
		$('#total_amount_aut').html(formatCurrency(grnd_total_amt)); 
		
	}else if( $("#payment_method_aut1").val() == 'Credit / Debit Card' && $("#payment_method_aut12").val() == 'Credit / Debit Card'){
		if($(".card_amount1").val() > 0){
			var atot = parseFloat($(".card_amount1").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_result1").val(rmatch_t);
		
		if($("#card_amount2").val() > 0){
			var atot2 = parseFloat($("#card_amount2").val());
		}else{
			var atot2 = 0;
		}		
		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_result2").val(rmatch_t2);
		
		var total = parseFloat($("#total_result_c").val());
		var grnd_total_amt = rmatch_t + rmatch_t2 + total;
		
		$("#sent_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm_P").html('(CP: 4%)');
		$('#total_amount_aut').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method_aut12").val() == 'Credit / Debit Card' && $("#payment_method_aut13").val() == 'Credit / Debit Card'){
		if($("#card_amount2").val() > 0){
			var atot2 = parseFloat($("#card_amount2").val());
		}else{
			var atot2 = 0;
		}

		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_result2").val(rmatch_t2);
		
		if($("#card_amount3").val() > 0){
			var atot3 = parseFloat($("#card_amount3").val());
		}else{
			var atot3 = 0;
		}
		var rmatch_t3 = atot3 / 100 * 2;
		$("#card_result3").val(rmatch_t3);		
		
		var total = parseFloat($("#total_result_c").val());
		var grnd_total_amt = rmatch_t2 + rmatch_t3 + total;
		
		$("#sent_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm_P").html('(CP: 4%)');
		$('#total_amount_aut').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method_aut1").val() == 'Credit / Debit Card' && $("#payment_method_aut13").val() == 'Credit / Debit Card'){
		if($(".card_amount1").val() > 0){
			var atot = parseFloat($(".card_amount1").val());
		}else{
			var atot = 0;
		}

		var rmatch_t = atot / 100 * 2;
		$("#card_result1").val(rmatch_t);
		
		if($("#card_amount3").val() > 0){
			var atot3 = parseFloat($("#card_amount3").val());
		}else{
			var atot3 = 0;
		}

		var rmatch_t3 = atot3 / 100 * 2;
		$("#card_result3").val(rmatch_t3);		
		
		var total = parseFloat($("#total_result_c").val());
		var grnd_total_amt = rmatch_t + rmatch_t3;
		
		$("#sent_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm_P").html('(CP: 4%)');
		$('#total_amount_aut').html(formatCurrency(grnd_total_amt)); 
		
	}else if( $("#payment_method_aut1").val() == 'Credit / Debit Card'){
		if($(".card_amount1").val() > 0){
			var atot = parseFloat($(".card_amount1").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_result1").val(rmatch_t);	
		
		var total = parseFloat($("#total_result_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#sent_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm_P").html('(CP: 2%)');
		$('#total_amount_aut').html(formatCurrency(grnd_total_amt)); 
		
		
	}else if( $("#payment_method_aut12").val() == 'Credit / Debit Card'){
		if($("#card_amount2").val() > 0){
			var atot2 = parseFloat($("#card_amount2").val());
		}else{
			var atot2 = 0;
		}
		var atot2 = parseFloat($("#card_amount2").val());
		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_result2").val(rmatch_t2);		
		
		var total = parseFloat($("#total_result_c").val());
		var grnd_total_amt = rmatch_t2 + total;
		
		$("#sent_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm_P").html('(CP: 2%)');
		$('#total_amount_aut').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method_aut13").val() == 'Credit / Debit Card'){
		if($("#card_amount3").val() > 0){
			var atot = parseFloat($("#card_amount3").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_result3").val(rmatch_t);				
		
		var total = parseFloat($("#total_result_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#sent_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm_P").html('(CP: 2%)');
		$('#total_amount_aut').html(formatCurrency(grnd_total_amt)); 
	}else{
		var atot = parseFloat($("#total_result_c").val());
		$("#sent_total_amount").val(atot);
		$("#crd_add_sudm_P").html('');
		$('#total_amount_aut').html(formatCurrency(atot)); 
	}
	//$('select[name="payment_pattern_athu"]').prop('readonly',true);
}


function money_management_athorization(){
	var get_rent_amount = parseFloat($("#get_rent_amount").val());	
	if($("#payment_pattern_athu").val() == 0 ){
		var rent_amounta = get_rent_amount / 2 + 200;
	}else{
		var rent_amounta = get_rent_amount;		
	}	
	if($("#get_parking_am_atu").val() != '' && $("#get_parking_am_atu").val() != '0'){
		var get_parking_amount_at = parseFloat($("#get_parking_am_atu").val());	
	}else{
		var get_parking_amount_at = 0;
	}	
	$("#rent_amountaa").val(formatCurrency_atat(rent_amounta));
	$("#parkingaaa").val(formatCurrency_atat(get_parking_amount_at));	
	var total_aut = rent_amounta + get_parking_amount_at;
	$("#total_amount_aut").html(formatCurrency_atat(total_aut));		
	$("#sent_rent_amount").val(rent_amounta);
	$("#sent_parking_amount").val(get_parking_amount_at);
	$("#sent_total_amount").val(total_aut);	
	$("#total_result_c").val(total_aut);	
}
$( document ).ready(function() {
    return money_management_athorization();
});
$("#authorize_form").on("submit",function(){ //payment_method_aut1
	$('#error_message').html('');
	$('#card_numberss').removeClass('border border-danger');
	if($("#card_numberss").val() == '' ){
		$("#err_msg_aut").html('Card number Required!');
		$("#card_numberss").focus();
		return false;
	}else if($("#payment_method_aut1").val() == '' ){
		$("#err_msg_aut").html('Payment Method Required!');
		$("#payment_method_aut1").focus();
		return false;
	}else{
		event.preventDefault();
		var form = $('#authorize_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo $home.'assets/ajax/form_submit/submit_authorize_form_with_rental.php'; ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#athorized_submit").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('____');
				if(value[1] == 'error'){
					$('#error_message').html('Card Number Already Exists!');
					$('#card_numberss').addClass('border border-danger');
					$("#athorized_submit").prop("disabled", false);
				}else if(value[1] == '1'){
					$('#member_error_message').html(value[0]);
					$("#athorized_submit").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}else{
					$('#data_send_success_message').html(value[0]);										
					$('#Authorized_model').modal('hide');
					$("#athorized_submit").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
					let receipt_type = $('#receipt_type').val();
					if(receipt_type === 'booking'){
						return view_profile_from_booking(value[2]);	
					}else{
						return view_rental_recipt(value[2]);	
					}
				}					
			}
		});
		return false;
	}	
})
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
			dataq += '<select id="agent1'+counter_payment_aut+'" name="agent[]" class="form-control">';
			dataq += '<option value="">select agent</option>';
			dataq += '<option value="Bikash">bKash</option>';
			dataq += '<option value="Rocket">Rocket</option>';
			dataq += '<option value="Nogod">Nogod</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text"id="mobile_banking_number1'+counter_payment_aut+'" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';			
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="transaction_id1'+counter_payment_aut+'" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="mobile_amount1'+counter_payment_aut+'" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="check_number_aut1'+counter_payment_aut+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="bank_name1'+counter_payment_aut+'" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';			
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="bank_name1'+counter_payment_aut+'" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="date" id="withdraw_date1'+counter_payment_aut+'" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="check_amount1'+counter_payment_aut+'" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="credit_card_aut1'+counter_payment_aut+'" style="display:none;">';
			dataq += '<div class="col-sm-6">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';

			dataq += '<input type="hidden" id="credit_card_number1'+counter_payment_aut+'" name="card_secret[]" value="0"/>';

			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="number" id="card_amount'+counter_payment_aut+'" onkeyup="return card_payment_calculator()" name="Expiry_Date[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="card_result'+counter_payment_aut+'" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control" readonly/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="cash_aut1'+counter_payment_aut+'" style="display:none;">';
			dataq += '<div class="col-sm-9">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<textarea id="cash_other_information_remarks1'+counter_payment_aut+'" name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>';											
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" id="cash_amount1'+counter_payment_aut+'" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
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
	
	//-------------------------------------
</script>			
<?php } else { ?>			
<script>
$("#authorize_form").on("submit",function(){ //payment_method_aut1
	$('#error_message').html('');
	$('#card_numberss').removeClass('border border-danger');
	if($("#card_numberss").val() == '' ){
		$("#err_msg_aut").html('Card number Required!');
		$("#card_numberss").focus();
		return false;
	}else{
		event.preventDefault();
		var form = $('#authorize_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo $home.'assets/ajax/form_submit/submit_authorize_form_with_out_rental.php'; ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#athorized_submit").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('____');
				if(value[1] == 'error'){
					$('#error_message').html('Card Number Already Exists!');
					$('#card_numberss').addClass('border border-danger');
					$("#athorized_submit").prop("disabled", false);
				}else if(value[1] == '1'){
					$('#member_error_message').html(value[0]);
					$("#athorized_submit").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}else{
					$('#data_send_success_message').html(value[0]);										
					$('#Authorized_model').modal('hide');
					$("#athorized_submit").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
					let receipt_type = $('#receipt_type').val();
					console.log(receipt_type);
					if(receipt_type === 'booking'){
						return view_profile_from_booking(value[2]);
					}else{
						return view_rental_recipt(value[3]);
					}
				}					
			}
		});
		return false;
	}	
})
</script>
<?php } ?>
			<div class="form-group" style="margin-top:50px;">
				<?php if(empty($rent_info['booking_id']) AND $package_info['try_us'] == '1'){  //parking ?>
					<input type="hidden" id="receipt_type" value="booking">
					<button id="athorized_submit" name="submit_form" type="submit" class="btn btn-warning" style="float:right;" disabled>Authorize</button>
				<?php } else { ?>
					<input type="hidden" id="receipt_type" value="rent">
					<button id="athorized_submit" name="submit_form" type="submit" class="btn btn-warning" style="float:right;">Authorize</button>
				<?php } ?>
			</div>
		</form>
	</div>
</div>

<script>
function formatCurrency_atat(total) {
	var neg = false;
	if(total < 0) {
		neg = true;
		total = Math.abs(total);
	}
	return (neg ? "-BDT " : 'BDT ') + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}
$('document').ready(function(){
	$('.number_int').on("input",function(){
		this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
	})
})

$(document).on('keyup', 'input[placeholder="Amount"]', function (event, data) {
	var written_amount = 0;
	$('input[placeholder="Amount"]').each(function(){
		if($(this).val() != ''){
			written_amount += parseInt($(this).val());
		}		
	})
	total_due = $('#total_result_c').val();
	$("#due_result_amount_package_shift").html('Calculation: ' + ( total_due - written_amount ));	
	if(total_due <= written_amount){
		$('#athorized_submit').prop("disabled", false);
	}else{
		$('#athorized_submit').prop("disabled", true);
	}	
});
</script>
<?php } ?>