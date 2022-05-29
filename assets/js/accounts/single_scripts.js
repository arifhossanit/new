$(document).on('keyup', 'input[placeholder="Amount2"]', pay_cal);


function pay_cal() {
	var written_amount2 = 0;
	$('input[placeholder="Amount2"]').each(function(){
		if($(this).val() != ''){
			written_amount2 += parseInt($(this).val());
		}		
	})
	var due_result_amount_booking2 = written_amount2 - parseInt($('#grandtotal').val());
	var due_amount = parseInt($('#grandtotal').val()) - written_amount2;
	$("#due_result_amount_booking2").html('Calculation: ' + due_result_amount_booking2);
	$('#dueamount').val(due_amount);
	if(parseInt($('#grandtotal').val()) <= written_amount2){
		$("#amount_verify_get2").val(2);
	}else{
		$("#amount_verify_get2").val(0);
	}	
	if($("#amount_verify_get2").val() == 2 && $("#otp_verify_get").val() == 2){
		$("#finish_booking2").prop("disabled", false);
	}else{
		$("#finish_booking2").prop("disabled", true);
	}
	// if ($("#due_result_amount_booking2").html() == 'Calculation: ' +'0') {
	// 	$("button.single_exp").prop("disabled", false);
	// }else{
	// 	$("button.single_exp").prop("disabled", true);
	// }
}

function payment_function_on_change2(){
	if($("#payment_method2").val() == 'Mobile Banking'){
		$("#mobile_banking2").css({"display":"flex"});
		$("#check_number2").css({"display":"none"});
		$("#credit_card2").css({"display":"none"});
		$("#cash2").css({"display":"none"});		
		
		//-----mobile banking---
		$('select[id="agent2"]').prop('required',true);
		$('input[id="mobile_banking_number2"]').prop('required',true);
		$('input[id="transaction_id2"]').prop('required',true);
		$('input[id="mobile_amount2"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name2"]').prop('required',false);
		$('input[id="check_number2"]').prop('required',false);
		$('input[id="withdraw_date2"]').prop('required',false);
		$('input[id="check_amount2"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number2"]').prop('required',false);
		$('input[id="Expiry_Date2"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount2"]').prop('required',false);
		//-----cash---		
		
	}else if($("#payment_method2").val() == 'Check'){
		$("#mobile_banking2").css({"display":"none"});
		$("#credit_card2").css({"display":"none"});
		$("#check_number2").css({"display":"flex"});
		$("#cash2").css({"display":"none"});		
		
		//-----mobile banking---
		$('select[id="agent2"]').prop('required',false);
		$('input[id="mobile_banking_number2"]').prop('required',false);
		$('input[id="transaction_id2"]').prop('required',false);
		$('input[id="mobile_amount2"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name2"]').prop('required',true);
		$('input[id="check_number2"]').prop('required',true);
		$('input[id="withdraw_date2"]').prop('required',true);
		$('input[id="check_amount2"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number2"]').prop('required',false);
		$('input[id="Expiry_Date2"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount2"]').prop('required',false);
		//-----cash---		
		
	}else if($("#payment_method2").val() == 'Credit / Debit Card'){
		$("#mobile_banking2").css({"display":"none"});
		$("#check_number2").css({"display":"none"});
		$("#credit_card2").css({"display":"flex"});
		$("#cash2").css({"display":"none"});		
		
		//-----mobile banking---
		$('select[id="agent2"]').prop('required',false);
		$('input[id="mobile_banking_number2"]').prop('required',false);
		$('input[id="transaction_id2"]').prop('required',false);
		$('input[id="mobile_amount2"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name2"]').prop('required',false);
		$('input[id="check_number2"]').prop('required',false);
		$('input[id="withdraw_date2"]').prop('required',false);
		$('input[id="check_amount2"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number2[]"]').prop('required',true);
		$('input[id="Expiry_Date2"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount2"]').prop('required',false);
		//-----cash---		
		
	}else if($("#payment_method2").val() == 'Cash'){
		$("#mobile_banking2").css({"display":"none"});
		$("#check_number2").css({"display":"none"});
		$("#credit_card2").css({"display":"none"});
		$("#cash2").css({"display":"flex"});		
		
		//-----mobile banking---
		$('select[id="agent2"]').prop('required',false);
		$('input[id="mobile_banking_number2"]').prop('required',false);
		$('input[id="transaction_id2"]').prop('required',false);
		$('input[id="mobile_amount2"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name2"]').prop('required',false);
		$('input[id="check_number2"]').prop('required',false);
		$('input[id="withdraw_date2"]').prop('required',false);
		$('input[id="check_amount2"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number2"]').prop('required',false);
		$('input[id="Expiry_Date2"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount2"]').prop('required',true);
		//-----cash---
		
	}else{
		$("#mobile_banking2").css({"display":"none"});
		$("#check_number2").css({"display":"none"});
		$("#credit_card2").css({"display":"none"});
		$("#cash2").css({"display":"none"});		
		
		//-----mobile banking---
		$('select[id="agent2"]').prop('required',false);
		$('input[id="mobile_banking_number2"]').prop('required',false);
		$('input[id="transaction_id2"]').prop('required',false);
		$('input[id="mobile_amount2"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name2"]').prop('required',false);
		$('input[id="check_number2"]').prop('required',false);
		$('input[id="withdraw_date2"]').prop('required',false);
		$('input[id="check_amount2"]').prop('required',false);
	 //-----check---
		
		//-----card---
		$('input[id="credit_card_number2"]').prop('required',false);
		$('input[id="Expiry_Date2"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount2"]').prop('required',false);
		//-----cash---
	}	
	
	if($("#payment_method22").val() == 'Mobile Banking'){
		$("#mobile_banking22").css({"display":"flex"});
		$("#check_number22").css({"display":"none"});
		$("#credit_card22").css({"display":"none"});
		$("#cash22").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent22"]').prop('required',true);
		$('input[id="mobile_banking_number22"]').prop('required',true);
		$('input[id="transaction_id22"]').prop('required',true);
		$('input[id="mobile_amount22"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name22"]').prop('required',false);
		$('input[id="check_number22"]').prop('required',false);
		$('input[id="withdraw_date22"]').prop('required',false);
		$('input[id="check_amount22"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number22"]').prop('required',false);
		$('input[id="Expiry_Date22"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount22"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method22").val() == 'Check'){
		$("#mobile_banking22").css({"display":"none"});
		$("#credit_card22").css({"display":"none"});
		$("#check_number22").css({"display":"flex"});
		$("#cash22").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent22"]').prop('required',false);
		$('input[id="mobile_banking_number22"]').prop('required',false);
		$('input[id="transaction_id22"]').prop('required',false);
		$('input[id="mobile_amount22"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name22"]').prop('required',true);
		$('input[id="check_number22"]').prop('required',true);
		$('input[id="withdraw_date22"]').prop('required',true);
		$('input[id="check_amount22"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number22"]').prop('required',false);
		$('input[id="Expiry_Date22"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount22"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method22").val() == 'Credit / Debit Card'){
		$("#mobile_banking22").css({"display":"none"});
		$("#check_number22").css({"display":"none"});
		$("#credit_card22").css({"display":"flex"});
		$("#cash22").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent22"]').prop('required',false);
		$('input[id="mobile_banking_number22"]').prop('required',false);
		$('input[id="transaction_id22"]').prop('required',false);
		$('input[id="mobile_amount22"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name22"]').prop('required',false);
		$('input[id="check_number22"]').prop('required',false);
		$('input[id="withdraw_date22"]').prop('required',false);
		$('input[id="check_amount22"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number22"]').prop('required',true);
		$('input[id="Expiry_Date22"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount22"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method22").val() == 'Cash'){
		$("#mobile_banking22").css({"display":"none"});
		$("#check_number22").css({"display":"none"});
		$("#credit_card22").css({"display":"none"});
		$("#cash22").css({"display":"flex"});
		//-----mobile banking---
		$('select[id="agent22"]').prop('required',false);
		$('input[id="mobile_banking_number22"]').prop('required',false);
		$('input[id="transaction_id22"]').prop('required',false);
		$('input[id="mobile_amount22"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name22"]').prop('required',false);
		$('input[id="check_number22"]').prop('required',false);
		$('input[id="withdraw_date22"]').prop('required',false);
		$('input[id="check_amount22"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number22"]').prop('required',false);
		$('input[id="Expiry_Date22"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount22"]').prop('required',true);
		//-----cash---
	}else{
		$("#mobile_banking22").css({"display":"none"});
		$("#check_number22").css({"display":"none"});
		$("#credit_card22").css({"display":"none"});
		$("#cash22").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent22"]').prop('required',false);
		$('input[id="mobile_banking_number22"]').prop('required',false);
		$('input[id="transaction_id22"]').prop('required',false);
		$('input[id="mobile_amount22"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name22"]').prop('required',false);
		$('input[id="check_number22"]').prop('required',false);
		$('input[id="withdraw_date22"]').prop('required',false);
		$('input[id="check_amount22"]').prop('required',false);
		$('input[id="check_amount22"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number22"]').prop('required',false);
		$('input[id="Expiry_Date22"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount22"]').prop('required',false);
		//-----cash---
	}	
	
	if($("#payment_method23").val() == 'Mobile Banking'){
		$("#mobile_banking23").css({"display":"flex"});
		$("#check_number23").css({"display":"none"});
		$("#credit_card23").css({"display":"none"});
		$("#cash23").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent23"]').prop('required',true);
		$('input[id="mobile_banking_number23"]').prop('required',true);
		$('input[id="transaction_id23"]').prop('required',true);
		$('input[id="mobile_amount23"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name23"]').prop('required',false);
		$('input[id="check_number23"]').prop('required',false);
		$('input[id="withdraw_date23"]').prop('required',false);
		$('input[id="check_amount23"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number23"]').prop('required',false);
		$('input[id="Expiry_Date23"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount23"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method23").val() == 'Check'){
		$("#mobile_banking23").css({"display":"none"});
		$("#credit_card23").css({"display":"none"});
		$("#check_number23").css({"display":"flex"});
		$("#cash23").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent23"]').prop('required',false);
		$('input[id="mobile_banking_number23"]').prop('required',false);
		$('input[id="transaction_id23"]').prop('required',false);
		$('input[id="mobile_amount23"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name23"]').prop('required',true);
		$('input[id="check_number23"]').prop('required',true);
		$('input[id="withdraw_date23"]').prop('required',true);
		$('input[id="check_amount23"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number23"]').prop('required',false);
		$('input[id="Expiry_Date23"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount23"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method23").val() == 'Credit / Debit Card'){
		$("#mobile_banking23").css({"display":"none"});
		$("#check_number23").css({"display":"none"});
		$("#credit_card23").css({"display":"flex"});
		$("#cash23").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent23"]').prop('required',false);
		$('input[id="mobile_banking_number23"]').prop('required',false);
		$('input[id="transaction_id23"]').prop('required',false);
		$('input[id="mobile_amount23"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name23"]').prop('required',false);
		$('input[id="check_number23"]').prop('required',false);
		$('input[id="withdraw_date23"]').prop('required',false);
		$('input[id="check_amount23"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number23"]').prop('required',true);
		$('input[id="Expiry_Date23"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount23"]').prop('required',false);
		//-----cash---
	}else if($("#payment_method23").val() == 'Cash'){
		$("#mobile_banking23").css({"display":"none"});
		$("#check_number23").css({"display":"none"});
		$("#credit_card23").css({"display":"none"});
		$("#cash23").css({"display":"flex"});
		//-----mobile banking---
		$('select[id="agent23"]').prop('required',false);
		$('input[id="mobile_banking_number23"]').prop('required',false);
		$('input[id="transaction_id23"]').prop('required',false);
		$('input[id="mobile_amount23"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name23"]').prop('required',false);
		$('input[id="check_number23"]').prop('required',false);
		$('input[id="withdraw_date23"]').prop('required',false);
		$('input[id="check_amount23"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number23"]').prop('required',false);
		$('input[id="Expiry_Date23"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount23"]').prop('required',true);
		//-----cash---
	}else{
		$("#mobile_banking23").css({"display":"none"});
		$("#check_number23").css({"display":"none"});
		$("#credit_card23").css({"display":"none"});
		$("#cash23").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent23"]').prop('required',false);
		$('input[id="mobile_banking_number23"]').prop('required',false);
		$('input[id="transaction_id23"]').prop('required',false);
		$('input[id="mobile_amount23"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name23"]').prop('required',false);
		$('input[id="check_number23"]').prop('required',false);
		$('input[id="withdraw_date23"]').prop('required',false);
		$('input[id="check_amount23"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number23"]').prop('required',false);
		$('input[id="Expiry_Date23"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount23"]').prop('required',false);
		//-----cash---
	}
	return card_payment_calculator();
}

var counter_payment2 = 2;
$("#addButton_payment2").click(function () {	
    if( counter_payment2 == 4 ){
        alert("Sorry! Maximum number of field reached");
        return false;			
    }
    var newTextBoxDiv2 = $(document.createElement('div')).attr({
        id:'UnitBoxDiv_payment2' + counter_payment2 ,
        class: 'row',
        style: 'width:100%margin-top: 20px;'
    });
    
    var dataq = '<div class="col-sm-3">';
        dataq += '<div class="form-group">';
        dataq += '<select onchange="return payment_function_on_change2()" id="payment_method2'+counter_payment2+'" name="payment_method[]" class="form-control">';
        dataq += '<option value="">select payment method</option>';
        dataq += '<option value="Cash">Cash</option>';
        dataq += '<option value="Mobile Banking">Mobile Banking</option>';
        dataq += '<option value="Credit / Debit Card">Credit / Debit Card</option>';
        dataq += '<option value="Check">Cheque</option>';
        dataq += '</select>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="col-sm-9">	';							
        dataq += '<div class="row" id="mobile_banking2'+counter_payment2+'" style="display:none;">';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<select id="agent2'+counter_payment2+'" name="agent[]" class="form-control">';
        dataq += '<option value="">select agent</option>';
        dataq += '<option value="Bikash">bKash</option>';
        dataq += '<option value="Rocket">Rocket</option>';
        dataq += '<option value="Nogod">Nogod</option>';
        dataq += '</select>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="mobile_banking_number2'+counter_payment2+'" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';			
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="transaction_id2'+counter_payment2+'" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="mobile_amount2'+counter_payment2+'" name="mobile_amount[]" placeholder="Amount2" autocomplete="off" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="row" id="check_number2'+counter_payment2+'" style="display:none;">';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="bank_name2'+counter_payment2+'" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';	 		
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="check_number2'+counter_payment2+'" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
		var todayDate = new Date().toISOString().slice(0, 10);
        dataq += '<input type="date" id="withdraw_date2'+counter_payment2+'" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="'+todayDate+'" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="check_amount2'+counter_payment2+'" name="check_amount[]" placeholder="Amount2" autocomplete="off" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="row" id="credit_card2'+counter_payment2+'" style="display:none;">';
        dataq += '<div class="col-sm-6">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="credit_card_number2'+counter_payment2+'" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;"><input type="hidden" name="card_secret[]" value="0"/>';
        dataq += '<input type="text" id="Expiry_Date2'+counter_payment2+'" onkeyup="return card_payment_calculator()" name="Expiry_Date[]" id="card_amount'+counter_payment2+'" placeholder="Amount2" autocomplete="off"  class="form-control" />';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="card_amount2'+counter_payment2+'" name="card_amount[]" id="card_result'+counter_payment2+'" placeholder="Amount2" autocomplete="off" class="form-control" readonly/>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="row" id="cash2'+counter_payment2+'" style="display:none;">';
        dataq += '<div class="col-sm-9">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<textarea id="cash_other_information_remarks2'+counter_payment2+'" name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>';											
        dataq += '</div>';
        dataq += '</div>';
        dataq += '<div class="col-sm-3">';
        dataq += '<div class="form-group" style="width:100%;">';
        dataq += '<input type="text" id="cash_amount2'+counter_payment2+'" name="cash_amount[]" placeholder="Amount2" autocomplete="off" class="form-control"/>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '</div>';
        dataq += '</div>';

    newTextBoxDiv2.after().html(dataq);
    newTextBoxDiv2.appendTo("#UnitBoxesGroup_payment2");
    counter_payment2++;
});

$("#removeButton_payment2").click(function () {
    if( counter_payment2 == 2 ){
        alert("Sorry! The System Can Not Remove This field");
        return false;
    }
    counter_payment2--;
    $("#UnitBoxDiv_payment2" + counter_payment2).remove();
});

//card payment calculator
function card_payment_calculator(){
	if( $("#payment_method2").val() == 'Credit / Debit Card' && $("#payment_method22").val() == 'Credit / Debit Card' && $("#payment_method23").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date2").val() > 0){
			var atot = parseFloat($("#Expiry_Date2").val());
		}else{
			var atot = 0;
		}		
		var rmatch_t = atot / 200 * 2;
		$("#card_amount2").val(rmatch_t);
		
		if($("#Expiry_Date22").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date22").val());
		}else{
			var atot2 = 0;
		}		
		var rmatch_t2 = atot2 / 200 * 2;
		$("#card_amount22").val(rmatch_t2);
		
		if($("#Expiry_Date23").val() > 0){
			var atot3 = parseFloat($("#Expiry_Date23").val());
		}else{
			var atot3 = 0;
		}	

		var rmatch_t3 = atot3 / 200 * 2;
		$("#card_amount23").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		
		var grnd_total_amt = rmatch_t + rmatch_t2 + rmatch_t3 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 6%)');
		$('#total_amount_large').html(formatCurrency2(grnd_total_amt)); 
		
	}else if( $("#payment_method2").val() == 'Credit / Debit Card' && $("#payment_method22").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date2").val() > 0){
			var atot = parseFloat($("#Expiry_Date2").val());
		}else{
			var atot = 0;
		}

		var rmatch_t = atot / 200 * 2;
		$("#card_amount2").val(rmatch_t);
		
		if($("#Expiry_Date22").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date22").val());
		}else{
			var atot2 = 0;
		}
		
		var rmatch_t2 = atot2 / 200 * 2;
		$("#card_amount22").val(rmatch_t2);
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + rmatch_t2 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency2(grnd_total_amt)); 
	}else if( $("#payment_method22").val() == 'Credit / Debit Card' && $("#payment_method23").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date22").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date22").val());
		}else{
			var atot2 = 0;
		}

		var rmatch_t2 = atot2 / 200 * 2;
		$("#card_amount22").val(rmatch_t2);
		
		if($("#Expiry_Date23").val() > 0){
			var atot3 = parseFloat($("#Expiry_Date23").val());
		}else{
			var atot3 = 0;
		}
		var rmatch_t3 = atot3 / 200 * 2;
		$("#card_amount23").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t2 + rmatch_t3 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency2(grnd_total_amt)); 
	}else if( $("#payment_method2").val() == 'Credit / Debit Card' && $("#payment_method23").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date2").val() > 0){
			var atot = parseFloat($("#Expiry_Date2").val());
		}else{
			var atot = 0;
		}

		var rmatch_t = atot / 200 * 2;
		$("#card_amount2").val(rmatch_t);
		
		if($("#Expiry_Date23").val() > 0){
			var atot3 = parseFloat($("#Expiry_Date23").val());
		}else{
			var atot3 = 0;
		}

		var rmatch_t3 = atot3 / 200 * 2;
		$("#card_amount23").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + rmatch_t3;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency2(grnd_total_amt)); 
		
	}else if( $("#payment_method2").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date2").val() > 0){
			var atot = parseFloat($("#Expiry_Date2").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 200 * 2;
		$("#card_amount2").val(rmatch_t);	
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 2%)');
		$('#total_amount_large').html(formatCurrency2(grnd_total_amt));		
	}else if( $("#payment_method22").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date22").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date22").val());
		}else{
			var atot2 = 0;
		}
		var rmatch_t2 = atot2 / 200 * 2;
		$("#card_amount22").val(rmatch_t2);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t2 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 2%)');
		$('#total_amount_large').html(formatCurrency2(grnd_total_amt)); 
	}else if( $("#payment_method23").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date23").val() > 0){
			var atot = parseFloat($("#Expiry_Date23").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 200 * 2;
		$("#card_amount23").val(rmatch_t);				
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency2(grnd_total_amt)); 
	}else{
		var atot = parseFloat($("#booking_total_amount_c").val());
		$("#booking_total_amount").val(atot);
		$("#crd_add_sudm").html('');
		$('#total_amount_large').html(formatCurrency2(atot)); 
	}
}
// format currency
function formatCurrency2(total) {
	var neg = false;
	if(total < 0) {
		neg = true;
		total = Math.abs(total);
	}
	return (neg ? "-BDT " : 'BDT ') + parseFloat(total, 10).toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}