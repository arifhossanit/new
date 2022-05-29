<?php
//error_reporting(0);
include("../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
if(isset($_POST['rent_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['rent_id']."'"));
$booking_info = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$row['booking_id']."'"));

if(strpos($booking_info['package_category_name'], 'Contract') !== false){
	$rent_count = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as rent_count from rent_info where payment_pattern = '1' AND booking_id = '".$booking_info['booking_id']."'"));
	switch($booking_info['package_name']){
		case 'Half Year':
			if($rent_count['rent_count'] == 6){
				echo '<div class="col-md-12 text-center font-weight-bold text-danger">Half Year Contract Package Expired!</div>';
				return;
			}
			break;
		case 'Quarter Year':
			if($rent_count['rent_count'] == 3){
				echo '<div class="col-md-12 text-center font-weight-bold text-danger">Quarter Year Contract Package Expired!</div>';
				return;
			}
			break;
		case 'One Year':
			if($rent_count['rent_count'] == 12){
				echo '<div class="col-md-12 text-center font-weight-bold text-danger">One Year Contract Package Expired!</div>';
				return;
			}
			break;
	}
}
$rent_info = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' and rent_status = 'Paid' order by id desc"));
$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where	 id = '".$row['package']."'"));

?>
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


$(document).ready(function(){
	$("#save_rent_information").prop("disabled", true);
})	
$(document).on('keyup', 'input[placeholder="Amount"]', function (event, data) {
	$("#save_rent_information").prop("disabled", true);
	var written_amount = 0;
	$('input[placeholder="Amount"]').each(function(){
		if($(this).val() != ''){
			written_amount += parseInt($(this).val());
		}		
	})
	var due_result_amount_booking = written_amount - parseInt($('input[name="total_result"]').val());
	$("#due_result_amount_booking").html('Calculation: ' + due_result_amount_booking);	
	if(parseInt($('input[name="total_result"]').val()) <= written_amount){
		$("#save_rent_information").prop("disabled", false);
	}else{
		$("#save_rent_information").prop("disabled", true);
	}	
});
</script>
<?php	
	if($package_info['try_us'] == 0){
		if(date('d') < 17 ){
			//$hlf = 1;
			//if(!empty($rent_info['id']) AND $rent_info['payment_pattern'] == 1){
				$hlf = 1;
			//}else{
			//	$hlf = 0;
			//}
		}else{
			$hlf = 0;
		}
	}else{
		if($package_info['package_days'] > 28){
			$hlf = 1;
		}else{
			$hlf = 0;
		}			
	}	
?>
<?php 
$rent_info_2 = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' order by id desc"));
$rent_count = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as count_rent from rent_info where booking_id = '".$row['booking_id']."'"));
if($package_info['try_us'] == 1){
	if($package_info['package_days'] == 30){
		if(!empty($rent_info_2['id'])){
			if($rent_info_2['rent_status'] == 'Due' AND $rent_info_2['payment_pattern'] == '0'){
				$rent_clc_amount = $package_info['monthly_rent'];
				$park_clc_amount = $package_info['parking_amount'];
			}else if($rent_info_2['rent_status'] == 'Paid' AND $rent_info_2['payment_pattern'] == '0'){
				$rent_clc_amount = $package_info['monthly_rent'] / 2 + 200;
				$park_clc_amount = $package_info['parking_amount'];
			}else if($rent_info_2['rent_status'] == 'Due' AND $rent_info_2['payment_pattern'] == '1'){
				$rent_clc_amount = $package_info['monthly_rent'];
				$park_clc_amount = $package_info['parking_amount'];
			}else if($rent_info_2['rent_status'] == 'Paid' AND $rent_info_2['payment_pattern'] == '1'){
				$rent_clc_amount = $package_info['monthly_rent'];
				$park_clc_amount = $package_info['parking_amount'];
			}
		}else{
			$rent_clc_amount = $package_info['monthly_rent'];
			$park_clc_amount = $package_info['parking_amount'];
		}
	}else{
		$rent_clc_amount = $package_info['monthly_rent'];
		$park_clc_amount = $package_info['parking_amount'];
	}
}else{
	if(!empty($rent_info_2['id'])){
		if($rent_info_2['rent_status'] == 'Due' AND $rent_info_2['payment_pattern'] == '2'){
			$rent_count = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM rent_info WHERE booking_id = '".$row['booking_id']."'"));
			if($rent_count[0] > 2){
				if($rent_info_2['data_two'] == 'Recheck'){ 
 					$rent_clc_amount = $rent_info_2['rent_amount']; //change date 05/06/2021
					$park_clc_amount = $rent_info_2['parking'];
				}else{
					$rent_clc_amount = $package_info['monthly_rent'];
					$park_clc_amount = $package_info['parking_amount'];
				}				
			}else if($rent_count[0] < 2){
				$rent_clc_amount = $booking_info['rent_amount'];
				$park_clc_amount = $booking_info['parking_amount'];
			}else{
				$rent_clc_amount = $package_info['monthly_rent'];
				$park_clc_amount = $package_info['parking_amount'];
			}						
		}else if($rent_info_2['rent_status'] == 'Due' AND $rent_info_2['payment_pattern'] == '0'){
			$rent_clc_amount = $package_info['monthly_rent'];
			$park_clc_amount = $package_info['parking_amount'];
		}else if($rent_info_2['rent_status'] == 'Due' AND $rent_info_2['payment_pattern'] == '2'){
			$rent_clc_amount = $package_info['monthly_rent'];
			$park_clc_amount = $package_info['parking_amount'];
		}else if($rent_info_2['rent_status'] == 'Paid' AND $rent_info_2['payment_pattern'] == '0'){
			$rent_count = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM rent_info where booking_id = '".$row['booking_id']."'"));
			if($rent_count[0] < 2){
				$rent_clc_amount = $booking_info['rent_amount'];
				$park_clc_amount = $booking_info['parking_amount'];
			}else{
				$rent_clc_amount = $package_info['monthly_rent'] / 2 + 200;
				$park_clc_amount = $package_info['parking_amount'];
			}							
		}else if($rent_info_2['rent_status'] == 'Due' AND $rent_info_2['payment_pattern'] == '1'){
			$rent_clc_amount = $package_info['monthly_rent'];
			$park_clc_amount = $package_info['parking_amount'];
		}else if($rent_info_2['rent_status'] == 'Paid' AND $rent_info_2['payment_pattern'] == '1'){
			$rent_clc_amount = $package_info['monthly_rent'];
			$park_clc_amount = $package_info['parking_amount'];
		} 
		$electricity_bill_auto = $rent_info_2['electricity'];
	}else{
		$rent_clc_amount = $booking_info['rent_amount'];
		$park_clc_amount = $booking_info['parking_amount'];
		$electricity_bill_auto = 0;
	}
}

/* if(empty($rent_info['id'])){
	$rent_clc_amount = $row['rent_amount'];
}else if(!empty($rent_info['id']) AND $rent_info['payment_pattern'] == 0 ){
	$rent_clc_amount = $row['rent_amount'] / 2 + 200;
}else if(!empty($rent_info['id']) AND $rent_info['payment_pattern'] == 2 ){
	$rent_clc_amount = $rent_info['rent_amount'];
}else if(!empty($rent_info['id']) AND $rent_info['payment_pattern'] == 3 ){
	$rent_clc_amount = $row['rent_amount'] / 2;
}else if(!empty($rent_info['id']) AND $rent_info['rent_status'] == 'Due'){
	$rent_clc_amount = $rent_info['rent_amount'];
}else{
	$rent_clc_amount = $row['rent_amount'];
} */

$rent_past = mysqli_fetch_assoc($mysqli->query("select sum(rent_amount) as total_past_due, count(*) as past_due_number from rent_info where booking_id = '".$row['booking_id']."' and rent_status = 'Due' and month_name not in ('".month_name(date('m'))."')"));
if($rent_past['total_past_due'] > 0){
	$total_past_due = (int)$rent_past['total_past_due'];
	//$rent_clc_amount = $rent_clc_amount + $total_past_due;
}else{
	$total_past_due = 0;
	//$rent_clc_amount = $rent_clc_amount;
}
if($rent_past['past_due_number'] > 0){
	$past_due_number = $rent_past['past_due_number'];
}else{
	$past_due_number = 0;
}
if($total_past_due > 0 ){
	$due_rent_information_sql = $mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' and rent_status = 'Due' and month_name not in ('".month_name(date('m'))."')");
	$month_duesi = '';
	while($due_wile_info = mysqli_fetch_assoc($due_rent_information_sql)){
		$month_duesi .= $due_wile_info['month_name'].',';
	}
	$actual_due_month = rtrim($month_duesi,',');
	$due_remarks_information = 'Previous Due Months: '.$month_duesi.' & Due Amount: '.money($total_past_due).' Added to this Month.';
}
if(!empty($package_info['id']) AND $package_info['aggreement'] == '1'){
	$aggreement_info = 1;
}else{
	$aggreement_info = 0;
}
?>
<input type="hidden" name="past_due_amounts" id="past_due_amounts" value="<?php echo $total_past_due; ?>"/>
<div class="row" style="width:100%;">
	<div class="col-sm-12">
		<h4 style="text-decoration:underline;">Rental Information</h4>
	</div>							
</div>
<div class="row" style="width:100%;">	
	<div class="col-sm-6">
		<div class="form-group">
			<label>
				Rent Amount 
				<?php if($past_due_number > 0){ echo ' - <span style="color:#ff6161;">Past Due Months: '.$past_due_number.', </span>'; } ?>
				<?php if($total_past_due > 0){ echo '<span style="color:#ff6161;">Past Due Amount: '.money($total_past_due).'</span>'; } ?>
				<?php if($aggreement_info == 1){ echo '<span style="color:#ff6161;">Agreement Member!</span>'; } ?>
			</label>			
			<input type="text" id="rent_amount_show" value="<?php if(!empty($rent_clc_amount)){ echo money($rent_clc_amount); } ?>" class="form-control" readonly/>
			<input type="hidden" name="rent_amount" id="rent_amount" value="<?php if(!empty($rent_clc_amount)){ echo $rent_clc_amount; } ?>" class="form-control" readonly/>
			<input type="hidden" name="rent_amount_final" id="rent_amount_final" value=""/>
		</div> 
	</div>	
	<div class="col-sm-2"></div>
	<div class="col-sm-4" style="background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);">
		<div class="form-group" style="margin:0px;">
			<label style="margin-bottom:0px;">
				<i class="fas fa-calculator"></i>
				Total Amount
				<span id="crd_add_sudm" style="color:#f00;"></span>
			</label>
			<style>@font-face { font-family: OPTICalculator; src: url(<?php echo $home.'assets/font/OPTICalculator.otf'; ?>); } </style>
			<div id="total_amount" style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">
			</div>
		</div>
	</div>
	
</div>
<div class="row" style="width:100%;">
	<div class="col-sm-3">
		<div class="form-group">
			<label>Payment Pattern</label>
			<select name="payment_pattern" id="payment_pattern" onchange="return rent_calculator()" class="form-control select2" required>
				<option value="1"><?php if(!empty($rent_info['id']) AND $rent_info['payment_pattern'] == 0 ){ echo 'Rest Of Amount'; $package_entnd = 0; } else{ echo 'Full Payment';  $package_entnd = 1; } ?></option>				
				<?php
					if($hlf == 1){
						echo '<option value="0">Half Payment</option>';
					}
					echo '<option value="3">Pandemic</option>';
				?>
			</select>
		</div>
	</div>
	<?php
       $get_check_in =  mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$row['booking_id']."'"));
       $get_check_rent_meta = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' order by id desc LIMIT 1"));
	   if($get_check_rent_meta)
	   {
		$meta_data = explode("/",$get_check_rent_meta['data']);
		$date = strtotime($get_check_rent_meta['month_name']);
		$mnum = date("m", $date);
		if($get_check_rent_meta['payment_pattern'] == 1)
		{
		  $plus = $mnum+1;
		  if($plus >= 10)
		  {
		   $date_meta = $meta_data[2]."-".$plus;
		  }
		  else
		  {
		   $date_meta = $meta_data[2]."-"."0".$plus;
		  }
		  
		}
		else
		{
		  if($mnum >= 10)
		  {
		   $date_meta = $meta_data[2]."-".$mnum;
		  }
		  else
		  {
		   $date_meta = $meta_data[2]."-".$mnum;
		  }
		  
		 
		}
	   }
	   else
	   {
		   $date_meta = date('Y-m');
	   }
       
      //  echo $date_meta;
      //  exit();
      ?>
	<div class="col-sm-3">
		<div class="form-group">
			<label>Rental Month</label>
			<input type="month" onchange="return month_check()" name="rental_mpnth" id="rental_mpnth" value="<?php echo  $date_meta; ?>" min="<?php echo date('Y-m'); ?>" max="" class="form-control select2" required/>			
		</div>
	</div>
</div>
<script>

</script>
<div class="row" style="width:100%;">
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Parking Amount</label>
					<?php
						if($row['parking'] == 0){
							$park_clc_amount = '0';
							$have_parking = 0;
						}else{
							$have_parking = 1;
						}
					?>
					<input type="text" id="parking_amount_show" value="<?php if(!empty($park_clc_amount)){ echo money($park_clc_amount); } ?>" class="form-control" readonly/>
					<input type="text" onkeyup="return rent_calculator()" name="parking_amount" id="parking_amount" value="<?php if(!empty($park_clc_amount)){ echo $park_clc_amount; } ?>" class="form-control"/>
					<input type="hidden" name="have_parking" id="have_parking" value="<?php echo $have_parking; ?>" class="form-control"/> 
				</div> 
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Penalty</label>
					<?php 
					
					if($package_info['try_us'] == 1){
						if(strpos($booking_info['available_days'], '-') !== false){
							$days = str_replace("-","",$booking_info['available_days']);
							$result_panalty = 100 * $days;
							if($result_panalty > 0){
								$penalty = $result_panalty;
							}
							else{
								$penalty = 0;
							}
						}else{
							$penalty = 0;
						}
					}else{
						// rent_info table a booking_id missing hobar kono posibility nai so, next query never count to zero.
						$rent_count = mysqli_fetch_assoc($mysqli->query("select count(id) as rent_count from rent_info where booking_id = '".$row['booking_id']."'"));
						
						$member_rent_info = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' ORDER by id DESC limit 1"));
						
						if($rent_count['rent_count'] > 0){
							if($rent_count['rent_count'] == 1 && $member_rent_info['payment_pattern'] == 2){
								// Member is going to make First payment.
								$checkin_date = $booking_info['checkin_date'];
								$date_array = explode('/', $checkin_date);
								$date = $date_array[2]."-".$date_array[1]."-".$date_array[0];
								$panaltry = strtotime("+4 day", strtotime($date));
								$panaltry_from = date("Y-m-d", $panaltry); 
								$current_date = date("Y-m-d");

								$diff = date_diff(date_create($current_date),date_create($panaltry_from));

								$date_differece = (int)$diff->format("%R%a");
								if($date_differece >= 0){
									$penalty = 0;
								}else{
									$penalty = abs($date_differece) * 100;
								}
								
							}else{
								// Regular payment 
								if($rent_count['rent_count'] > 1 && $member_rent_info['payment_pattern'] == 2){
									//full payment 
									$days = date('d') - 10;
									$result_panalty = 100 * $days;
									if($result_panalty > 0){
										$penalty = 100 * $days;
									}
									else{
										$penalty = 0;
									}
								}elseif($rent_count['rent_count'] > 1 && $member_rent_info['payment_pattern'] == 0){
									// Half payment
									$days = date('d') - 25;
									$result_panalty = 100 * $days;
									if($result_panalty > 0){
										$penalty = 100 * $days;
									}
									else{
										$penalty = 0;
									}
								}
							}
						}else{
							echo "Booking_id not in rent_info. Needs to investigate"; exit();
						}
					}
					
					?>
					
					<input type="hidden" name="recharge_days" value=""/>
					<input type="text" id="panalty_amount_show" value="<?php echo money($penalty);  ?>" class="form-control" readonly=""/>
					<input type="hidden" name="panalty_amount" onkeyup="return rent_calculator()" id="panalty_amount" value="<?php echo $penalty; ?>" class="form-control"/>
				</div> 
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Tea / Coffee Bill</label>
					<?php
						$tea_coff = mysqli_fetch_assoc($mysqli->query("select sum(total_amount) as bill from refreshment_item_sell where buyer_id = '".$row['card_number']."' and payment_status = 'Due'")); //$booking_info
						if($tea_coff['bill'] > 0 ){
							$bill = $tea_coff['bill'];
						}else{
							$bill = '0';
						}
					?>
					<input type="text" onkeyup="return rent_calculator()" value="<?php echo $bill; ?>" name="tea_coffee_bill" id="tea_coffee_bill" class="form-control" readonly />
				</div> 
			</div> 
			
			<div class="col-sm-6">
				<div class="form-group">
					<label>Locker Bill</label>
					<?php
						if($row['locker_amount'] > 0 ){
							$billq = $booking_info['locker_amount'];
						}else{
							$billq = '0';
						}
					?>
					<input type="text" onkeyup="return rent_calculator()" value="<?php echo $billq; ?>" name="locker_bill" id="locker_bill" class="form-control" readonly />
				</div> 
			</div> 
		</div>
		
	</div>
	<div class="col-sm-6">
		<div class="col-sm-12">
			<p style="padding:5px;">
				Name: <b><?php echo $row['full_name']; ?></b> <br/>
				Days Avaible: <b><?php if(!empty($booking_info['available_days'])){ echo $booking_info['available_days']; }else{ echo '0'; } ?> Days</b><br />
				Package: <b><?php echo $booking_info['package_category_name']; ?> - <?php echo $row['package_name']; ?></b><br />
				Card NO: <b><?php echo $row['card_number']; ?></b><br />
				CheckIn Date: <b><?php echo $row['check_in_date']; ?></b><br />
				CheckOut Date: <b><?php echo $row['check_out_date']; ?></b><br />
				Last Payed Date: <b><?php if(!empty($rent_info['data'])){ echo $rent_info['data']; }else{ echo 'Not Pay Yet!'; } ?> </b> <br />
				Last Payment Pattern: <b><?php if(!empty($rent_info['id'])){ if($rent_info['payment_pattern'] == 1){ echo 'Full Payment'; }else{ echo 'Half Payment'; } }else{ echo 'Not Pay Yet!'; } ?> </b><br />
				Last Payed Amount: <b><?php if(!empty($rent_info['rent_amount'])){ echo money($rent_info['rent_amount']); }else{ echo 'Not Pay Yet!'; } ?> </b><br />
				<?php 
					$discount_test = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'"));
				?>
				Got Discount: <b><?php if(!empty($rent_info['dis_aamt'])){ if($rent_info['dis_aamt'] == 1){ /* if(!empty($discount_test['p_p'])){ */ if($discount_test['p_p'] == 0){ echo 'YES - '.money($discount_test['amount'] / 2); }else{ 'YES - '.money($discount_test['amount']); } /*}else{ echo 'NOT'; }*/ }else{ echo 'NOT'; } }else{ echo 'NOT'; } ?> </b><br />
				Last Panalty: <b><?php if(!empty($rent_info['penalty'])){ echo money((int)$rent_info['penalty']); }else{ echo money(0); } ?> </b><br />
				Last Receiver: <b><?php if(!empty($rent_info['uploader_info'])){ $lr = explode('___',$rent_info['uploader_info']); echo $lr[1]; } ?></b> <br/>
			</p>
		</div>
	</div>
</div>

<div class="row" style="width:100%;">
<?php 
if($package_info['try_us'] == 0){ 
	$member_room_id = $row['room_id'];
	$member_sql = $mysqli->query("select * from member_directory where room_id = '".$member_room_id."' AND status = '1'");
	$member_number = 0;
	$member_counter = 1;
	while($member_row_bill = mysqli_fetch_assoc($member_sql)){
		$package_info_bill = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member_row_bill['package']."'"));
		if($package_info_bill['try_us'] != 1){
			$member_number = $member_counter++;
		}
	}
	$member_bill = mysqli_fetch_assoc($mysqli->query("select * from electicity_bill where room_id = '".$member_room_id."' and month_year = '".date('m/Y')."' order by id desc"));
	if(!empty($member_bill['amount'])){
		if($member_number > 0){
			$electrict_bill_amount = (int)$member_bill['amount'] / (int)$member_number;
		}else{
			$electrict_bill_amount = (int)$member_bill['amount'];
		}
	}else{
		$electrict_bill_amount = 0;
	}
	
?>	
	<div class="col-sm-3">
		<div class="form-group">
			<label>Electricity Bill</label>
			<input type="text" value="<?php echo round($electrict_bill_amount + $electricity_bill_auto,0); ?>" onkeyup="return rent_calculator()" name="electricity_bill" id="electricity_bill" class="form-control" required />
		</div> 
	</div>
	<input type="hidden" onkeyup="return rent_calculator()" value="" name="package_extender" id="package_extender"/>
<?php }else{ 
		if($aggreement_info == 1){ $electrict_bill_amount = 0; $electricity_bill_auto = 0;
?>
	<div class="col-sm-3">
		<div class="form-group">
			<label>Electricity Bill</label>
			<input type="text" value="<?php echo round($electrict_bill_amount + $electricity_bill_auto,0); ?>" onkeyup="return rent_calculator()" name="electricity_bill" id="electricity_bill" class="form-control" required />
		</div> 
	</div>
	<input type="hidden" onkeyup="return rent_calculator()" value="" name="package_extender" id="package_extender"/>
<?php } else {
	
	if(!empty($rent_info['id']) AND $rent_info['payment_pattern'] == 0 ){ ?>
		<input type="hidden" onkeyup="return rent_calculator()" value="0" name="electricity_bill" id="electricity_bill"/>
		<input type="hidden" onkeyup="return rent_calculator()" value="" name="package_extender" id="package_extender"/>
<?php }else{ ?>

	<input type="hidden" onkeyup="return rent_calculator()" value="0" name="electricity_bill" id="electricity_bill"/>
	<div class="col-sm-3">
		<div class="form-group">
			<?php
				if(!empty($row['package_category'])){
					$p_ctc = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$row['package_category']."'"));
				}
			?>
			<label style="color:#f00;">Extend <?php if(!empty($p_ctc['package_category_name'])){ echo '('.$p_ctc['package_category_name'].')'; } ?></label>
			<select onchange="return rent_calculator()" id="package_extender" class="form-control select2" name="package_extender" <?php if($package_entnd == 1){ echo 'required'; } ?> style="color:#f00;font-weight:bolder;">
				<option value="" style="color:#f00;">--select--</option>
				<?php
					if($aggreement_info == 1){
						$p_row = $mysqli->query("select * from packages where try_us = '1' and aggreement = '1' and status = '1' and id = '".$row['package']."'");
						while($pql = mysqli_fetch_assoc($p_row)){
							echo '<option value="'.$pql['id'].'____'.$pql['monthly_rent'].'____'.$pql['package_days'].'____'.$pql['parking_amount'].'">'.$pql['package_name'].'</option>';
						}
					}else{
						$p_row = $mysqli->query("select * from packages where try_us = '1' and status = '1' and package_category_id = '".$row['package_category']."'");
						while($pql = mysqli_fetch_assoc($p_row)){
							echo '<option value="'.$pql['id'].'____'.$pql['monthly_rent'].'____'.$pql['package_days'].'____'.$pql['parking_amount'].'">'.$pql['package_name'].'</option>';
						}
					}
				?>
			</select>
		</div>
	</div>	
<?php }
	} 
} ?>
	<div class="col-sm-3">
		<div class="form-group">
			<label>Discount</label>
			<?php
				$rent_infoj = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' AND rent_status = 'Due'"));
				$rent_infojc = mysqli_fetch_array($mysqli->query("select count(*) from rent_info where booking_id = '".$row['booking_id']."' AND rent_status = 'Due' "));
				$rent_infoi = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' AND rent_status = 'Paid'"));
				$dis_check = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'"));
				if(!empty($rent_infoi['id'])){
					$brento_n_c = mysqli_fetch_array($mysqli->query("select count(*) from rent_info where booking_id = '".$row['booking_id']."' AND rent_status = 'Paid'"));
					if($brento_n_c[0] == 1){
						if($rent_infoi['payment_pattern'] == 0){
							if(!empty($dis_check['amount'])){
								$discount_money = $dis_check['amount'] / 2;
							}else{
								$discount_money = 0;
							}
						}else{
							//if(!empty($rent_infoj['payment_pattern']) AND $rent_infoj['payment_pattern'] == 0){
							//	$discount_money = $dis_check['amount'] / 2;
							//}else if(!empty($rent_infoj['payment_pattern']) AND $rent_infoj['payment_pattern'] == 2){
							//	if($rent_infojc[0] == 1){
							//		if(!empty($dis_check['amount'])){
							//			$discount_money = $dis_check['amount'];	
							//		}else{
							//			$discount_money = 0;	
							//		}
							//	}else{
							//		$discount_money = 0;	
							//	}								
							//}else{
								$discount_money = 0;
							//}																		
						}
					}else{
						$discount_money = 0;
					}
				}else{
					if(!empty($dis_check['amount'])){
						$discount_money = $dis_check['amount'];
					}else{
						$discount_money = 0;
					}					
				}
				
				if($discount_money > $rent_clc_amount){
					$discount_money = 0;
				}else{
					$discount_money = $discount_money;
				}
				
				$_GetDiscountInfo = mysqli_fetch_assoc($mysqli->query("SELECT * FROM discount_member WHERE booking_id = '".$row['booking_id']."'"));
				if(!empty($_GetDiscountInfo['id'])){
					if($rent_clc_amount > $_GetDiscountInfo['amount']){
						if($_GetDiscountInfo['discount_pattern'] == 'YES'){
							$discount_money = $_GetDiscountInfo['amount'];
							$_DISCOUNT_PATTERN = 'YES';
						} else if ($_GetDiscountInfo['discount_pattern'] == 'A'){
							$discount_money = $_GetDiscountInfo['amount'] / 2;
							$_DISCOUNT_PATTERN = 'A';
						}else if ($_GetDiscountInfo['discount_pattern'] == 'AA'){
							$discount_money = 0;
							$_DISCOUNT_PATTERN = 'B';
						} else if ($_GetDiscountInfo['discount_pattern'] == 'B'){						
							$discount_money = 0;
							$_DISCOUNT_PATTERN = 'B';
						}else{
							$discount_money = 0;
							$_DISCOUNT_PATTERN = 'B';
						}
					}else{
						$discount_money = 0;
						$_DISCOUNT_PATTERN = 'YES';
					}				
				}else{
					$discount_money = 0;
				}
				
				
			?>
			<input type="text" value="<?php if($discount_money > 0){ echo money($discount_money); }else{ echo money(0); } ?>" name="dis" class="form-control" readonly />
			<input type="hidden" id="discount_amount" value="<?php if($discount_money > 0){ echo $discount_money; }else{ echo 0; } ?>" name="disccount_money" class="form-control" />
			<input type="hidden" id="discount_pattern" value="<?php if(!empty($_DISCOUNT_PATTERN)){ echo $_DISCOUNT_PATTERN; } ?>" name="discount_pattern" class="form-control" />
		</div>
	</div>	
	
<?php
//$package_info['aggreement'] == '1'

$booking_id = $row['booking_id'];
if($package_info['aggreement'] == 1){
	$check_ipo_discount = mysqli_fetch_assoc($mysqli->query("select * from ipo_referal_approval where booking_id = '".$booking_id."'"));
	if(!empty($check_ipo_discount['booking_id'])){
		if($check_ipo_discount['aproval'] == '1'){
			$ipo_discount_status = $row['ipo_discount'];			
			$room_info = mysqli_fetch_assoc($mysqli->query("select * from rooms where id = '".$row['room_id']."'"));			
			$get_ipo_discount_money = mysqli_fetch_assoc($mysqli->query("select * from ipo_category where category_name = '".$room_info['note']."'"));
			
			/* if(!empty($get_ipo_discount_money['id'])){ */		
				if($ipo_discount_status == 'A'){
					$ipo_id = $check_ipo_discount['ipo_id'];
					$discount_lavel = 'A';
					$ipo_discount_condition = '1st Month';
					$ipo_discount_money = 100;
					$ipo_commission_money = 100;
					$ipo_discount_money_for_view = money(100);
				}else if($ipo_discount_status == 'AA'){
					$ipo_id = $check_ipo_discount['ipo_id'];
					$discount_lavel = 'AA';
					$ipo_discount_condition = '1st Month / 2';
					$ipo_discount_money = 100 / 2;
					$ipo_commission_money = 100 / 2;
					$ipo_discount_money_for_view = money(100 / 2);
				}else if($ipo_discount_status == 'B'){
					$ipo_id = $check_ipo_discount['ipo_id'];
					$discount_lavel = 'B';
					$ipo_discount_condition = '2nd Month';
					$ipo_discount_money = 250;
					$ipo_commission_money = 250;
					$ipo_discount_money_for_view = money(250);
				}else if($ipo_discount_status == 'BB'){
					$ipo_id = $check_ipo_discount['ipo_id'];
					$discount_lavel = 'BB';
					$ipo_discount_condition = '2nd Month / 2';
					$ipo_discount_money = 250 / 2;
					$ipo_commission_money = 250 / 2;
					$ipo_discount_money_for_view = money(250 / 2);
				}else if($ipo_discount_status == 'C'){
					$ipo_id = $check_ipo_discount['ipo_id'];
					$discount_lavel = 'C';
					$ipo_discount_condition = '3rd Month';
					$ipo_discount_money = 500;
					$ipo_commission_money = 500;
					$ipo_discount_money_for_view = money(500);
				}else if($ipo_discount_status == 'CC'){
					$ipo_id = $check_ipo_discount['ipo_id'];
					$discount_lavel = 'CC';
					$ipo_discount_condition = '3rd Month / 2';
					$ipo_discount_money = 500 / 2;
					$ipo_commission_money = 500 / 2;
					$ipo_discount_money_for_view = money(500 / 2);
				}else if($ipo_discount_status == 'D'){
					$ipo_id = '';
					$discount_lavel = 'NO';
					$ipo_discount_condition = 'All Ready Gotten!';
					$ipo_discount_money = '0';
					$ipo_commission_money = '0';
					$ipo_discount_money_for_view = money(0);
				} 
			/*}else{
				$ipo_id = '';
				$discount_lavel = 'NO';
				$ipo_discount_condition = 'NOT Applicable!';
				$ipo_discount_money = '0';
				$ipo_commission_money = '0';
				$ipo_discount_money_for_view = money(0);
			}	*/		
		}else{
			$ipo_id = '';
			$discount_lavel = 'NO';
			$ipo_discount_condition = 'NOT Aprove Yet!';
			$ipo_discount_money = '0';
			$ipo_commission_money = '0';
			$ipo_discount_money_for_view = money(0);
		}
	}else{
		$ipo_id = '';
		$discount_lavel = 'NO';
		$ipo_discount_condition = 'NOT Applicable!';
		$ipo_discount_money = '0';
		$ipo_commission_money = '0';
		$ipo_discount_money_for_view = money(0);
	}
}else{
	if($package_info['try_us'] == 1){
		$ipo_id = '';
		$discount_lavel = 'NO';
		$ipo_discount_condition = 'TRY US NOT Applicable!';
		$ipo_discount_money = '0';
		$ipo_commission_money = '0';
		$ipo_discount_money_for_view = money(0);
	}else{
		$ipo_id = '';
		$discount_lavel = 'NO';
		$ipo_discount_condition = 'NOT Applicable!';
		$ipo_discount_money = '0';
		$ipo_commission_money = '0';
		$ipo_discount_money_for_view = money(0);	
	}
}



	

?>	
	<div class="col-sm-3">		
		<input type="hidden" name="ipo_id" value="<?php if(!empty($ipo_id)){ echo $ipo_id; } ?>"/>		
		<input type="hidden" name="discount_lavel" value="<?php if(!empty($discount_lavel)){ echo $discount_lavel; } ?>"/>
		<input type="hidden" name="ipo_commission_money_cal" value=""/>
		<input type="hidden" name="ipo_commission_money" value="<?php if(!empty($ipo_commission_money)){ echo $ipo_commission_money; } ?>"/>
		<label>IPO Discount condition</label>
		<input type="text" name="ipo_discount_condition" value="<?php if(!empty($ipo_discount_condition)){ echo $ipo_discount_condition; } ?>" class="form-control" readonly />
	</div>
	<div class="col-sm-3">
		<label>IPO Discount Money</label>
		<input type="hidden" name="ipo_discount_money" value="<?php if(!empty($ipo_discount_money)){ echo $ipo_discount_money; } ?>" />
		<input type="hidden" name="ipo_discount_money_cal" value="" />
		<input type="text" name="ipo_discount_money_for_view" value="<?php if(!empty($ipo_discount_money_for_view)){ echo $ipo_discount_money_for_view; } ?>" class="form-control" readonly />
	</div>	
	<div class="col-sm-6">
		<div class="form-group">
			<label>Remarks</label>
			<textarea name="remarks" class="form-control"><?php if(!empty($due_remarks_information)){ echo $due_remarks_information; } ?></textarea>
		</div>
	</div>
	
	<div class="col-sm-6"></div>
	<div class="col-sm-6">
		<div class="form-group" style="margin-top:40px;">
			<label><input type="checkbox" value="Soap" name="soap"/> &nbsp;&nbsp; Soap</label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" value="Shampoo" name="shampoo"/> &nbsp;&nbsp; Shampoo</label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" value="Tishue" name="tishue"/> &nbsp;&nbsp; Tishue</label>
		</div>
	</div>
	
</div>
<div class="row">
	<?php 
		$mw_balance = mysqli_fetch_assoc( $mysqli->query("select * from balance_shpoint where booking_id = '".$row['booking_id']."'") );
	?>
	<div class="col-sm-12">
		Member Wallet Balance: <b><?php echo $mw_balance['balance']; ?></b>
	</div>	
</div>
<div class="row" style="width:100%;margin-top: 20px;">
	<div class="col-sm-12">
		<h4 style="text-decoration:underline;">
			Payment Information									
			<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
				<button type="button" id='removeButton_payment_aut' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
				<button type="button" id='addButton_payment_aut' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
			</div>
			<div id="due_result_amount_booking" class="row d-flex" style="float:right;padding-right: 26px; color: #f00; margin-top: -4px;font-size: 20px;"> </div>
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
						<option value="Check">Cheque</option>										
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
							<input type="text" id="mobile_banking_number1" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control" required/>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group" style="width:100%;">
							<input type="text" id="transaction_id1" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control" required/>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group" style="width:100%;">
							<input type="number" id="mobile_amount1" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control" required/>
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
							<input type="number" id="check_amount1" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
						</div>
					</div>
				</div>
				
				
				<div class="row" id="credit_card_aut1" style="display:none;">
					<div class="col-sm-6">
						<div class="form-group" style="width:100%;">
							<input type="text" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>
						</div>
					</div>
					<input type="hidden" name="card_secret[]" value="0"/>											
					<div class="col-sm-3">
						<div class="form-group" style="width:100%;">
							<input type="text" onkeyup="return card_payment_calculator()" name="Expiry_Date[]" id="card_amount1" placeholder="Amount" autocomplete="off" class="form-control"/>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group" style="width:100%;">
							<input type="number" name="card_amount[]" id="card_result1" placeholder="Amount" autocomplete="off" class="form-control" readonly/>
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
							<input type="number" id="cash_amount1" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
						</div>
					</div>
				</div>							
				
			</div>
		</div>	
	</div>
</div>

<script>
function card_payment_calculator(){
	if( $("#payment_method_aut1").val() == 'Credit / Debit Card' && $("#payment_method_aut12").val() == 'Credit / Debit Card' && $("#payment_method_aut13").val() == 'Credit / Debit Card'){
		if($("#card_amount1").val() > 0){
			var atot = parseFloat($("#card_amount1").val());
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
		
		$("#total_result").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 6%)');
		$('#total_amount').html(formatCurrency(grnd_total_amt)); 
		
	}else if( $("#payment_method_aut1").val() == 'Credit / Debit Card' && $("#payment_method_aut12").val() == 'Credit / Debit Card'){
		if($("#card_amount1").val() > 0){
			var atot = parseFloat($("#card_amount1").val());
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
		
		$("#total_result").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount').html(formatCurrency(grnd_total_amt)); 
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
		
		$("#total_result").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method_aut1").val() == 'Credit / Debit Card' && $("#payment_method_aut13").val() == 'Credit / Debit Card'){
		if($("#card_amount1").val() > 0){
			var atot = parseFloat($("#card_amount1").val());
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
		
		$("#total_result").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount').html(formatCurrency(grnd_total_amt)); 
		
	}else if( $("#payment_method_aut1").val() == 'Credit / Debit Card'){
		if($("#card_amount1").val() > 0){
			var atot = parseFloat($("#card_amount1").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_result1").val(rmatch_t);	
		
		var total = parseFloat($("#total_result_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#total_result").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 2%)');
		$('#total_amount').html(formatCurrency(grnd_total_amt)); 
		
		
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
		
		$("#total_result").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 2%)');
		$('#total_amount').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method_aut13").val() == 'Credit / Debit Card'){
		if($("#card_amount1").val() > 0){
			var atot = parseFloat($("#card_amount1").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_result1").val(rmatch_t);				
		
		var total = parseFloat($("#total_result_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#total_result").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount').html(formatCurrency(grnd_total_amt)); 
	}else{
		var atot = parseFloat($("#total_result_c").val());
		$("#total_result").val(atot);
		$("#crd_add_sudm").html('');
		$('#total_amount').html(formatCurrency(atot)); 
	}
}

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
			dataq += '<option value="Check">Cheque</option>';
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
			dataq += '<input type="text" id="mobile_banking_number1'+counter_payment_aut+'" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>';
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
			dataq += '<input type="text" id="check_number1'+counter_payment_aut+'" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>';
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
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;"><input type="hidden" name="card_secret[]" value="0"/>';
			dataq += '<input type="text" onkeyup="return card_payment_calculator()" name="Expiry_Date[]" id="card_amount'+counter_payment_aut+'" placeholder="Amount" autocomplete="off"  class="form-control" />';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="card_amount[]" id="card_result'+counter_payment_aut+'" placeholder="Amount" autocomplete="off" class="form-control" readonly/>';
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
<?php } ?>















