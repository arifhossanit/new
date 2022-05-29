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


</script>
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Rental Information</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Rental Information</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
<style>
.card-primary.card-outline-tabs>.card-header .paid a.active {
    border-top: 3px solid #28a745 !important;
}
.card-primary.card-outline-tabs>.card-header .due a.active {
    border-top: 3px solid #dc3545 !important;
}
</style>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div id="success_message" style="color:green;text-align:center;"></div>
						<div class="col-sm-12" style="margin-bottom:20px;">
						<?php if(check_permission('role_1606371304_22')){ ?>
							<button class="btn btn-info" id="add-rent" style="float:right;"><i class="fas fa-plus-square"></i> &nbsp;&nbsp;Add Rent / Renew Package</button>
						<?php } ?>
						<button class="btn btn-warning" id="add-payment" style="float:right;margin-right:15px;"><i class="fas fa-plus-square"></i> &nbsp;&nbsp;Add Payment</button>
						</div>
					</div>
				
					<div class="row">
						<div class="col-sm-2" style="margin-bottom:15px;">
							<div class="form-group" style="margin:0px;">
								<select onchange="return booking_report_table();" class="form-control select2" id="branch_id_hrad">
									<?php
									if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
										echo '<option value="1">All Branches</option>';
									}									
									if(!empty($banches)){
										foreach($banches as $row){
											echo '<option value="'.rahat_encode($row->branch_id).'">'.$row->branch_name.'</option>';
										}
									}													
									?>
								</select>
							</div>
						</div>
						<div class="col-sm-2" style="margin-bottom:15px;">
							<div class="form-group" style="margin:0px;">
								<input id="month_filter" value="<?php echo date('Y-m'); ?>" type="month" class="form-control"/>
							</div>
						</div>
						<div class="col-sm-12">
							<span id="data_send_success_message" style="color:green;fonr-weight:bolder;"></span>
							<div class="card card-primary card-outline card-outline-tabs">
								<div class="card-header p-0 border-bottom-0">
									<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
										<li class="nav-item due">
											<a class="nav-link active " id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true" >Rental Information (DUE)</a> 
										</li>
										<li class="nav-item paid">
											<a class="nav-link " id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Rental Information (PAID)</a>
										</li>
										<li class="nav-item">
											<a class="nav-link " id="custom-tabs-four-installment_due-tab" data-toggle="pill" href="#custom-tabs-four-installment_due" role="tab" aria-controls="custom-tabs-four-installment_due" aria-selected="false">Installment List</a>
										</li>
										<li class="nav-item">
											<a class="nav-link " id="custom-tabs-four-pandamic-tab" data-toggle="pill" href="#custom-tabs-four-pandamic" role="tab" aria-controls="custom-tabs-four-pandamic" aria-selected="false">Pandamic List</a>
										</li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-four-tabContent">
										<!----->
										<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
											<div class="card card-danger">
												<div class="card-header">
													<h3 class="card-title">Rental Information (DUE)</h3>
													<div id="export_buttons_due" style="float: right;"></div>
												</div>
												<div class="card-body" style="max-width:100%;overflow-x:scroll;">
													<style>#due_data_table td{text-align:center;vertical-align: middle;}#due_data_table th{text-align:center;vertical-align: middle;}</style>
													<table id="due_data_table" class="display table table-sm table-bordered table table-striped display nowrap" style="width:100%;font-size:16px;">
														<thead>
															<tr>
																<th>ID</th>
																<th>Branch</th>
																<th>Category</th>
																<th>Package</th>												
																<th>Card</th>
																<th>Name</th>
																<th>Phone Number</th>
																<th>Bed</th>
																<th>Rent Amount</th>
																<th>Parking Amount</th>
																<th>Electicity</th>
																<th>Panalty</th>
																<th>Tea & Coffee</th>
																<th>Payment Pattern</th>
																<th>Recharge</th>
																<th>Rental Month</th>
																<th>Rent Status</th>
																<th>Option</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!----->
										
										
										
										<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
											<div class="card card-success">
												<div class="card-header">
													<h3 class="card-title">Rental Information (PAID)</h3>
													<div id="export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">
													<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
													<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
														<thead>
															<tr>
																<th>ID</th>
																<th>Branch</th>
																<th>Category</th>
																<th>Package</th>												
																<th>Card</th>
																<th>Name</th>
																<th>Phone Number</th>
																<th>Rent Amount</th>
																<th>Parking Amount</th>
																<th>Electicity</th>
																<th>Panalty</th>
																<th>Tea & Coffee</th>
																<th>Payment Pattern</th>
																<th>Recharge</th>
																<th>Rental Month</th>
																<th>Rent Status</th>
																<th>Option</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!----->
										
										<div class="tab-pane fade" id="custom-tabs-four-installment_due" role="tabpanel" aria-labelledby="custom-tabs-four-installment_due-tab">
											<div class="card card-primary">
												<div class="card-header">
													<h3 class="card-title">Installment list</h3>
													<div id="export_buttons_installment" style="float: right;"></div>
												</div>
												<div class="card-body">
													<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
													<table id="booking_data_table_installment" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
														<thead>
															<tr>
																<th>ID</th>
																<th>Branch</th>
																<th>Category</th>
																<th>Package</th>												
																<th>Card</th>
																<th>Name</th>
																<th>Rent Amount</th>
																<th>Parking Amount</th>
																<th>Electicity</th>
																<th>Panalty</th>
																<th>Tea & Coffee</th>
																<th>Payment Pattern</th>
																<th>Recharge</th>
																<th>Rental Month</th>
																<th>Rent Status</th>
																<th>Option</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
													</table>
												</div>
											</div>
										</div>
										
										<div class="tab-pane fade" id="custom-tabs-four-pandamic" role="tabpanel" aria-labelledby="custom-tabs-four-pandamic-tab">
											<div class="card card-warning">
												<div class="card-header">
													<h3 class="card-title">pandamic list</h3>
													<div id="export_buttons_pandamic" style="float: right;"></div>
												</div>
												<div class="card-body">
													<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
													<table id="booking_data_table_pandamic" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
														<thead>
															<tr>
																<th>ID</th>
																<th>Branch</th>
																<th>Category</th>
																<th>Package</th>												
																<th>Card</th>
																<th>Name</th>
																<th>Rent Amount</th>
																<th>Parking Amount</th>
																<th>Electicity</th>
																<th>Panalty</th>
																<th>Tea & Coffee</th>
																<th>Payment Pattern</th>
																<th>Recharge</th>
																<th>Rental Month</th>
																<th>Rent Status</th>
																<th>Option</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
													</table>
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
	</div>
</div>
<!----vaiw model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Rental information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result"></div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->

<!----Add Rent Model-->
	<div class="modal fade" id="add-rent-model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="rental_form" method="post" enctype="multipart/form-data">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Input Rental / Recharge / Renew information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<style>.label_cust label(font-weight:300 !important;)</style>
					<div class="modal-body label_cust" id="" style="max-height:780px;min-height:400px;overflow-y:scroll;">	
						
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12">
									<h4 style="text-decoration:underline;">Member Information</h4>
									<span style="color:red;font-weight:bolder;" id="member_error_message"></span>
								</div>							
							</div>
							<div class="row" style="min-height:131px;">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Input Card Number <div id="loading_data_callection"></div></label>
										<input type="number" name="card_number" id="card_number" placeholder="Input Card number" class="form-control" autofocus required />
										<div id="member_rental_result" class="member_rental_result"></div>
									</div>
								</div>
								<div class="col-sm-2"></div>
								<div class="col-sm-4">
									<div class="row">										
										<div class="col-sm-6">
											<img src="<?php echo base_url('assets/img/photo_avatar.png'); ?>" id="avater_image" style="width:100%;" class="image-responsive"/>
										</div>
									</div>									
								</div>
							</div>							
							<div class="row" id="rental_other_information">
								
							</div>						
							
						</div>
						
					</div>
					<input type="hidden" name="uploader_info" value="<?php echo rahat_encode($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']); ?>" />
					<input type="hidden" name="total_result" id="total_result" value="" />
					<input type="hidden" name="total_result_c" id="total_result_c" value="" />
					<div class="box-footer">
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button id="save_rent_information" type="submit" class="btn btn-success">Get Rent</button>
						</div>														
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End Add Rent Model-->
	<div class="modal fade" id="add-payment-model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="payment_form" method="post" enctype="multipart/form-data">
					<input type="hidden" name="uploader_info" value="<?php echo $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']; ?>"/>
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Payment information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body add_payment_method" id="" style="max-height:780px;min-height:400px;overflow-y:scroll;">					
						<div class="row">
							<div class="col-sm-12">
								<span id="payment_error_message" style="color:#f00;font-weight:bolder;"></span>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Select Payment Type</label>
											<select name="payment_type" id="" class="form-control select3" required>
												<option value="">--select--</option>
												<?php if(!empty($payment_type)){
													foreach($payment_type as $row){
														echo '<option value="'.$row->payment_type.'">'.$row->payment_type.'</option>';
													}
													
												}?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Write Card Number</label>
											<input type="number" name="card_number" id="" class="form-control" required />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Amount</label>
											<input type="text" name="amount" id="" class="number_int form-control add_payment_amount" required autocomplete="off"/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Remarks</label>
											<textarea name="remarks" class="form-control" required></textarea>
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
									<div id="due_result_amount_add_payment" class="row d-flex" style="float:right;padding-right: 26px; color: #f00; margin-top: -4px;font-size: 20px;"> </div>
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
					<div class="box-footer">
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button id="save_payment_information" name="save_payment_information" type="submit" class="btn btn-success">Save</button>
						</div>														
					</div>

				</form>
			</div>
		</div>
	</div>

<script>
$(document).on('keyup', '.add_payment_method input[placeholder="Amount"]', function (event, data) {
	var written_amount = 0;
	$('input[placeholder="Amount"]').each(function(){
		if($(this).val() != ''){
			written_amount += parseInt($(this).val());
		}		
	})
	var due_result_amount_booking = written_amount - parseInt($('.add_payment_amount').val());
	$("#due_result_amount_add_payment").html('Calculation: ' + due_result_amount_booking);	
	if(parseInt($('.add_payment_amount').val()) <= written_amount){
		$("#save_payment_information").prop("disabled", false);
	}else{
		$("#save_payment_information").prop("disabled", true);
	}	
});
$("#payment_form").on("submit",function(){
	event.preventDefault();
	var form = $('#payment_form')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?=base_url('assets/ajax/form_submit/input_payment_data_to_database.php'); ?>",  
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$("#save_payment_information").prop("disabled", true);
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$("#save_payment_information").prop("disabled", false);
			var value = data.split('____');
			if(value[1] == '1'){
				$('#payment_error_message').html(value[0]);				
			}else{
				$('#data_send_success_message').html(value[0]);										
				$('#add-payment-model').modal('hide');
			}					
		}
	});
	return false;
})
function due_rent_collection(card_number){
	if(card_number == 'Unauthorized'){
		alert(card_number);
	}else{
		$("#card_number").val(card_number);	
		$('#add-rent-model').modal('show');
		setTimeout(function() { $('input[name="card_number"]').focus() }, 500);
	}	
}


$("#save_rent_information").on("click",function(){
	let given_penalty = $('#panalty_amount').val();
	let min_penalty = $('#minimum_penalty').val();
	if($("#card_number").val() == ''){
		$("#member_error_message").html('Card Number Is Empty!');
		$("#card_number").focus();
		return false;
	} else if ($("#card_number").val().length < 8) {
		$("#member_error_message").html('Card Number Must 8 Character');
		$("#card_number").focus();
		return false;
	} else if ($("#rent_amount").length == 0) {
		$("#member_error_message").html('No Match Found Please write card number again!');
		$("#card_number").focus();
		return false;
	} else if ($("#rent_amount").val() == '') {		
		$("#member_error_message").html('Rent Amount Is Empty');
		return false;
	} else if ($("#payment_method_aut1").val() == '') {
		$("#member_error_message").html('Payment Method is not selected!');
		return false;
	}else{
		$("#member_error_message").html('');
		event.preventDefault();
		var form = $('#rental_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/input_rental_data_to_database.php'); ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#save_rent_information").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('____');
				if(value[1] == '1'){
					$('#member_error_message').html(value[0]);
					$("#save_rent_information").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}else{
					$('#data_send_success_message').html(value[0]);										
					$('#add-rent-model').modal('hide');
					$("#save_rent_information").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
					return view_rental_recipt(value[2]);	
				}					
			}
		});
		return false;
	}
})
function formatCurrency(total) {
	var neg = false;
	if(total < 0) {
		neg = true;
		total = Math.abs(total);
	}
	return (neg ? "-BDT " : 'BDT ') + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}
function rent_calculator(){	
	if($("#package_extender").val() != ''){
		var data = $("#package_extender").val();
		var pid = data.split("____");
		var package_id = pid[0];
		var ext_rent = pid[1];
		var ext_days = pid[2]; //parking_amount_show
		var parking_amount = pid[3]; //parking_amount_show 
		if($("#parking_amount").val() != '' ){
			var parking = parseInt($("#parking_amount").val());
		}else{
			var parking = parseInt(0);
		}
		if($("#panalty_amount").val() != '' ){
			var panalty = parseInt($("#panalty_amount").val());
			
		}else{
			var panalty = parseInt(0);
		}
		if($("#rent_amount").val() != '' ){
			var rent = parseInt(ext_rent);
		}else{
			var rent = parseInt('<?php if(!empty($rent_clc_amount)){ echo $rent_clc_amount; } ?>');
		}			
		if($("#tea_coffee_bill").val() != '' ){
			var tea = parseInt($("#tea_coffee_bill").val());
		}else{
			var tea = parseInt(0);
		}		
		if($("#locker_bill").val() != '' ){
			var locker_bill = parseInt($("#locker_bill").val());
		}else{
			var locker_bill = parseInt(0);  //locker_bill
		}		
		if($("#payment_pattern").val() == '1'){
			if(ext_days > 29){
				var option_select = '<option value="1">Full Payment</option><option value="0">Half Payment</option>';
				$("#payment_pattern").html(option_select);
			}else if(ext_days > 0){
				var option_select = '<option value="1">Full Payment</option>';
				$("#payment_pattern").html(option_select);
			}else if(data == ''){
				var option_select = '<option value="1">Full Payment</option><option value="3">Pandemic</option>	';
				$("#payment_pattern").html(option_select);
			}
			var total = rent;
			var amount = total + parking + tea + locker_bill + panalty;			
		}else if($("#payment_pattern").val() == '0'){
			if(ext_days > 29){
				var option_select = '<option value="0">Half Payment</option><option value="1">Full Payment</option>';
				$("#payment_pattern").html(option_select);
			}else if(ext_days > 0){
				var option_select = '<option value="1">Full Payment</option>';
				$("#payment_pattern").html(option_select);
			}else if(data == ''){
				var option_select = '<option value="1">Full Payment</option><option value="3">Pandemic</option>	';
				$("#payment_pattern").html(option_select);
			}
			var total = rent / 2 + 200;
			var addition = parking + tea + total + locker_bill + panalty;
			var amount = addition;			
		}else if($("#payment_pattern").val() == '3'){
			if(ext_days > 29){
				var option_select = '<option value="0">Half Payment</option><option value="1">Full Payment</option><option value="3">Pandemic</option>';
				$("#payment_pattern").html(option_select);
			}else if(ext_days > 0){
				var option_select = '<option value="1">Full Payment</option><option value="3">Pandemic</option>';
				$("#payment_pattern").html(option_select);
			}else if(data == ''){
				var option_select = '<option value="1">Full Payment</option><option value="3">Pandemic</option>	';
				$("#payment_pattern").html(option_select);
			}
			var total = rent / 2;
			var addition = parking + tea + total + locker_bill + panalty;
			var amount = addition;			
		}	
		
		$("#rent_amount_show").val(formatCurrency(total));		
		$("#rent_amount_final").val(total);
		$("#total_amount").html(formatCurrency(amount));
		$("#total_result").val(amount);
		$("#total_result_c").val(amount);		
	}else{
		if($("#discount_amount").val() != '' ){
			var discount = parseInt($("#discount_amount").val());
		}else{
			var discount = parseInt(0);
		}
		
		if($("#rent_amount").val() != '' ){
			var rent = parseInt($("#rent_amount").val()) - discount;
		}else{
			var rent = parseInt(0) - discount;
		}
	
		if($("#parking_amount").val() != '' ){
			var parking = parseInt($("#parking_amount").val());
		}else{
			var parking = parseInt(0);
		}

		if($("#panalty_amount").val() != '' ){
			var panalty = parseInt($("#panalty_amount").val());
		}else{
			var panalty = parseInt(0);
		}
		
		if($("#electricity_bill").val() != '' ){
			var electrict = parseInt($("#electricity_bill").val());
		}else{
			var electrict = parseInt(0);  //
		}
		
		if($("#locker_bill").val() != '' ){
			var locker_bill = parseInt($("#locker_bill").val());
		}else{
			var locker_bill = parseInt(0);  //locker_bill
		}
		
		if($("#tea_coffee_bill").val() != '' ){
			var tea = parseInt($("#tea_coffee_bill").val());
		}else{
			var tea = parseInt(0);
		}
		var total = rent;
		
		if($('input[name="ipo_commission_money"]').val() != ''){
			var ipo_commission_money = parseInt($('input[name="ipo_commission_money"]').val());
		}else{
			var ipo_commission_money = parseInt(0);
		}
		
		if($('input[name="ipo_discount_money"]').val() != ''){
			var ipo_discount_money = parseInt($('input[name="ipo_discount_money"]').val());
		}else{
			var ipo_discount_money = parseInt(0);
		}
		
		if($('input[name="past_due_amounts"]').val() != ''){
			var past_due_amounts = parseInt($('input[name="past_due_amounts"]').val());
		}else{
			var past_due_amounts = parseInt(0);
		}
		
		
		
		if($("#payment_pattern").val() == '1'){
			var ipo_discount = ipo_discount_money;
			var ipo_comission = ipo_commission_money;
			var amount = total + parking + panalty + electrict + tea + locker_bill + past_due_amounts - ipo_discount;
			var rentt = rent;
		}else if($("#payment_pattern").val() == '3'){
			var ipo_discount = 0;
			var ipo_comission = 0;
			var prcentage = '50';
			var total_tt = parking + rent;	//electrict	
			var hun_con = total_tt / 100;
			var prc_rul = hun_con * prcentage;
			var amount = prc_rul + electrict + locker_bill + past_due_amounts - ipo_discount;
			var rentt = rent / 2;			
		}else{
			var ipo_discount = ipo_discount_money / 2;
			var ipo_comission = ipo_commission_money / 2;
			var total2 = rent / 2 + 200;
			var rentt = total2;
			var addition = rentt + parking + panalty + electrict + tea + locker_bill + past_due_amounts - ipo_discount;
			var amount = addition;	
			
		}	
		
		$('input[name="ipo_discount_money_cal"]').val(ipo_discount);
		$('input[name="ipo_discount_money_for_view"]').val(formatCurrency(ipo_discount));
		$('input[name="ipo_commission_money_cal"]').val(ipo_comission);
		
		$("#rent_amount_final").val(rentt);
		$("#total_amount").html(formatCurrency(amount));
		$("#total_result").val(amount);
		$("#total_result_c").val(amount);
	}
}

function set_member_profile(id,card){
	var rent_id = id;
	if(rent_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/set_member_input_fields_imformation.php');?>",  
			method:"POST",
			data:{rent_id:rent_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#rental_other_information').html(data);
				//$("#card_number").val(card);
				return rent_calculator();
				
			}  
		});
	}
}
	
function view_rental_recipt(id){
	var rent_id = id;
	if(rent_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/rental_details_information.php');?>",  
			method:"POST",  
			data:{rent_id:rent_id},
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

$('#month_filter').on("change",function(){
	return booking_report_table();
})
function booking_report_table(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	
	var month_filter = $("#month_filter").val();
	
	var table_info = '?branch_id='+branch_sele_id+'&month_filter='+month_filter+'';
    var condition = table_info;	

	var ajax_data3 = "<?=base_url('assets/ajax/data_table/due_rental_information_datatable_data.php'); ?>"+condition;
	$('#due_data_table').DataTable().ajax.url(ajax_data3).load();
	
	var ajax_data4 = "<?=base_url('assets/ajax/data_table/rental_information_datatable_data.php'); ?>"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
	
	var ajax_data5 = "<?=base_url('assets/ajax/data_table/installment_rental_information_datatable_data.php'); ?>"+condition;
	$('#booking_data_table_installment').DataTable().ajax.url(ajax_data5).load();
	
	var ajax_data6 = "<?=base_url('assets/ajax/data_table/pandamic_rental_information_datatable_data.php'); ?>"+condition;
	$('#booking_data_table_pandamic').DataTable().ajax.url(ajax_data6).load();
}
$(document).ready(function() {
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
})	
	
$(document).ready(function() {
	
	
	
	$("#add-payment").on('click',function(){
		$('#add-payment-model').modal('show');
	})
	
	$("#add-rent").on("click",function(){		 
		$("#card_number").val('');
		if($("#card_number").val() == ''){
			setTimeout(function() { $('input[name="card_number"]').focus() }, 300);
		}		
		$('#add-rent-model').modal('show');
		$('#rental_other_information').html('');
		$('#members_result').html(''); 
		$('#member_rental_result').html('');
		$("#avater_image").attr("src", "<?php echo base_url('assets/img/photo_avatar.png'); ?>");
		
	})
	
	
	$("#card_number").on("keyup focus",function(){
		var get_value = $(this).val();
		if(get_value != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/member_rental_result.php');?>",  
				method:"POST",  
				data:{get_value:get_value},
				beforeSend:function(){					
					$('#loading_data_callection').html('<i class="fas fa-spinner fa-pulse"></i>');					 
				},
				success:function(data){	
					$('#loading_data_callection').html('');
					var value = data.split('***');					
					$('#member_rental_result').html(value[0]);					
					if(value[2] != '0'){
						$('#avater_image').attr('src', value[2]);
					}else{
						$("#avater_image").attr("src", "<?php echo base_url('assets/img/photo_avatar.png'); ?>");
					}					
					if(value[1] != '0'){
						return set_member_profile(value[1],value[3]);
					}else{
						$('#rental_other_information').html('');
					}
				}  
			});  
		}
	})
	
	

	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id+'&month_filter='+month_filter+'';
    var condition = table_info;	
	
	var table = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[10, 25, 50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/rental_information_datatable_data.php"+condition,
		<?php if(check_permission('role_1606371206_64')){ ?>
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
		<?php } ?>
    });
	table.buttons().container().appendTo($('#export_buttons'));	
	//due rent table
	var table = $('#due_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[10, 25, 50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		//"scrollX": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		//"info": true,
		//"autoWidth": true,
		//"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/due_rental_information_datatable_data.php"+condition,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table.buttons().container().appendTo($('#export_buttons_due'));
	
	//due rent table
	var table1 = $('#booking_data_table_installment').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[10, 25, 50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/installment_rental_information_datatable_data.php"+condition,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table1.buttons().container().appendTo($('#export_buttons_installment'));
	
	//due rent table
	var table1 = $('#booking_data_table_pandamic').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[10, 25, 50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/pandamic_rental_information_datatable_data.php"+condition,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table1.buttons().container().appendTo($('#export_buttons_pandamic'));
})
</script>