$(document).on('keyup', 'input[placeholder="Amount"]', function (event, data) {
	var written_amount = 0;
	$('input[placeholder="Amount"]').each(function(){
		if($(this).val() != ''){
			written_amount += parseInt($(this).val());
		}		
	})
	var due_result_amount_booking = written_amount - parseInt($('input[name="total_subtotal"]').val());
	$("#due_result_amount_booking").html('Calculation: ' + due_result_amount_booking);	
	if(parseInt($('input[name="total_subtotal"]').val()) <= written_amount){
		$("#amount_verify_get").val(1);
	}else{
		$("#amount_verify_get").val(0);
	}	
	if($("#amount_verify_get").val() == 1 && $("#otp_verify_get").val() == 1){
		$("#finish_booking").prop("disabled", false);
	}else{
		$("#finish_booking").prop("disabled", true);
	}
});

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
        dataq += '<option value="Check">Cheque</option>';
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

//card payment calculator
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

// format currency
function formatCurrency(total) {
	var neg = false;
	if(total < 0) {
		neg = true;
		total = Math.abs(total);
	}
	return (neg ? "-BDT " : 'BDT ') + parseFloat(total, 10).toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}