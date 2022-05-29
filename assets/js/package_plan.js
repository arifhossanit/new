var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();
var pdate = '35';
var rdays = dd;
ndate = yyyy + '/' + mm + '/' + dd;
$('button.branch').click(function(){
    $(this).parent().find('.selected').removeClass('selected');
    $(this).addClass('selected');
    $('hr.branch').remove();
    $('hr.pkg').remove();
    $( this ).parent().parent().after( "<hr class='solid branch'>" );
    $('hr.divide').addClass('solid');
    $('#packageName').empty();
    $('#packageDetails').empty();
    let branch_id = $(this).attr('value') ;
	if(screen.width < 768){
		$('#selected_dropdown').html( '<div class="button branch selected">' + $(this).html() + '</div>');
		$('#selected_dropdown').show();
		$('#hide_dropdown').addClass('hide_dropdown_menu');
		$('#selected_dropdown_toggle').show();
	}
	$.ajax(
        {
            url: 'assets/ajax/package_plan/fetch_branch_package.php',
            type: 'post',
            data: {branch_id: branch_id},
            success: function (response){
                $('#package').html(response);
                money_manage_ment_pkn_pln();
            }
        }
    );
});

$('#selected_dropdown_toggle').click(function(){
	$('#selected_dropdown').hide();
	$('#selected_dropdown_toggle').hide();
	$('#hide_dropdown').removeClass('hide_dropdown_menu');
});

$('body').on('click', 'button.package', function() {
    $(this).parent().find('.selected').removeClass('selected');
    $(this).addClass('selected');
    $('hr.pkg').remove();
    $( this ).parent().parent().after( "<hr class='solid pkg'>" );
    $('#packageDetails').empty();
    let branch_id = $('#selectedBranchId').attr('value');
    let package_category_id = $(this).attr('value') ;
    let package_name = $(this).html() ;
	if(screen.width < 768){
		$('#pkg_ctg_dropdown').html( '<div class="button branch selected">' + $(this).html() + '</div>');
		$('#pkg_ctg_dropdown').show();
		$('#hide_pkg_ctg_dropdown').addClass('hide_dropdown_menu');
		$('#pkg_ctg_dropdown_toggle').show();
	}
    $.ajax(
        {
            url: 'assets/ajax/package_plan/fetch_package_details.php',
            type: 'post',
            data: {
                package_category_id: package_category_id,
                branch_id: branch_id
            },
            success: function (response){
                $('#packageName').html(response);
				show_modal(package_name);
                money_manage_ment_pkn_pln();
            }
        }
    );
});

function pkg_dropdown_hide(){
	$('#pkg_ctg_dropdown').hide();
	$('#pkg_ctg_dropdown_toggle').hide();
	$('#hide_pkg_ctg_dropdown').removeClass('hide_dropdown_menu');
};

$('body').on('click', 'button.packageName', function() {
    $(this).parent().find('.selected').removeClass('selected');
    $(this).addClass('selected');
    let branch_id = $('#selectedBranchId').attr('value');
    let package_category_id = $('#selectedPackageId').attr('value');
    let package_name = $(this).attr('value') ;
	if(screen.width < 768){
		$('#pkg_name_dropdown').html( '<div class="button branch selected">' + $(this).html() + '</div>');
		$('#pkg_name_dropdown').show();
		$('#hide_pkg_name_dropdown').addClass('hide_dropdown_menu');
		$('#pkg_name_dropdown_toggle').show();
	}
    $.ajax(
        {
            url: 'assets/ajax/package_plan/fetch_package_expenses.php',
            type: 'post',
            data: {
                package_category_id: package_category_id,
                branch_id: branch_id,
                package_name: package_name
            },
            success: function (response){
                $('#packageDetails').html(response);
                money_manage_ment_pkn_pln();
            }
        }
    );
});

function pkg_name_dropdown_hide(){
	$('#pkg_name_dropdown').hide();
	$('#pkg_name_dropdown_toggle').hide();
	$('#hide_pkg_name_dropdown').removeClass('hide_dropdown_menu');
};

function date_append(date){
    let date_set = document.getElementById('date_set').getAttribute('value');
    if(date_set === 'not set'){
        let _href = document.getElementById('check_date').getAttribute('href');
        document.getElementById('check_date').setAttribute('href',_href+'/'+date);
        document.getElementById('date_set').setAttribute('value', 'set');
    }else{
        let _href = document.getElementById('check_date').getAttribute('href');
        _href = _href.slice(0,_href.length - 11);
        document.getElementById('check_date').setAttribute('href',_href+'/'+date);
    }
	money_manage_ment_pkn_pln();
}

$('body').on('click', '#parking_yes', function (){
    // console.log($('#vicle_parking').val());
    $('#vicle_parking').val(1);
    $('#parking_amount').show();
});


$('body').on('click', '#parking_no', function (){
    $('#vicle_parking').val(0);
    $('#parking_amount').hide();
});

$('body').on('click', '#locker_yes', function (){
    $('#locker_type_show').show();
});

$('body').on('click', '#locker_no', function (){
    $('#locker_type_show').hide();
});

$('body').on('click', '#payment_full', function (){
    $('#payment_pattern').val(1);
});

$('body').on('click', '#payment_half', function (){
    $('#payment_pattern').val(0);
});
$('body').on('click', "input[type='radio']", function(){
    var locker_type = $("input[name='locker_type']:checked").val();
    $.ajax({
        url: 'assets/ajax/package_plan/fetch_locker_expenses.php',
        type: 'post',
        data: {
            locker_type: locker_type,
        },
        success: function (response){
            $('#locker_price').html(response);
            money_manage_ment_pkn_pln();
        }
    });
});


// Money Management
var getDaysInMonth = function(month,year){
	return new Date(year, month, 0).getDate();
};

function select_date(selected_date){
	$('#totalAmountBeforeDate').hide();
	$('#totalAmount').show();
	$('#total_amount_disclaimer').show();
	money_manage_ment_pkn_pln();
	selected_date = selected_date.split('-');
	if(selected_date[2] >= 1 && selected_date[2] <= 15){
		$('.half-pay').show();
	}
}


function money_manage_ment_pkn_pln(){
    console.log('working');
    console.log(ndate);
	if($("#try_us_condition_check").val() == '1' ){
		if(ndate == $("#checkin_date").val()){			
            console.log('on first if');
			$("#check_in_purpose").css({"display":"block"});
			$("#force_rent_container").css({"display":"none"});
			$('#force_rent').prop('checked', false);
			$('#card_number').attr('readonly', false);
			//----------
			if($("#vicle_parking").val() == '1' ){
				$("#parking_purpose").css({"display":"block"});
				var parki_val = ($('#parking_value').val());
				var park_m = parki_val;	
				var d_p_a = parki_val;	
			}else{
				$("#parking_purpose").css({"display":"none"});
				var park_m = (0);
				var d_p_a = (0);
			}

			if($("#locker_value").val() != ''){
				var locker_m = ($("#locker_value").val());
			}else{
				var locker_m = (0);
			}
			
			if($("#disccount_money").val() != ''){
				if($('#payment_pattern').val() == '1'){
					var discount = ($("#disccount_money").val());
				}else if($('#payment_pattern').val() == '0'){
					var discount = ($("#disccount_money").val()) / 2;
				}else{
					var discount = ($("#disccount_money").val());
				}
			}else{
				var discount = (0);				
			}
			var m_ry = ($('#rent_amount').val());
			if($('#payment_pattern').val() == '1'){
				var rent_date = m_ry;
				$("#rental_fiels_container").css({"display":"block"});
			}else if($('#payment_pattern').val() == '0'){
				var rent_paymnt_p = m_ry;			
				var rent_date = rent_paymnt_p / 2 + 200;
				$("#rental_fiels_container").css({"display":"block"});
			}else{
				var rent_date = (0);
				var park_m = (0);
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
			var security_money = ($('#security_money').val());
			var all_total = security_money + park_m + f_rent_v + locker_m;
				
			if(security_money > 0){
				$("#booking_security_amount").val(security_money);
				$("#parking_amount").val(formatCurrency(park_m));				
				$('#rent_amount_show').val(formatCurrency(f_rent_v));
				$('#ac_rent_amount_1').val(f_rent_v);	
				$('#total_amount_large').html(Math.round(formatCurrency(all_total))); 
				$("#booking_total_amount").val((all_total));
				$("#booking_total_amount_c").val((all_total));
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
				$("#booking_total_amount").val((0));
				$("#booking_total_amount_c").val((0));
				$('#rent_amount_show').val(0);
				$('#ac_rent_amount_1').val(0);	
				$("#parking_amount").val(0);
				$("#booking_rent_amount").val('');
				$("#booking_parking_amount").val('');
			}
			//----------
			$("#card_number_check").val('1');
		}else{
            console.log('on first else');
			$("#card_number_check").val('0');
			$("#force_rent_container").css({"display":"flex"});
			// if($("#force_rent").is(':checked')){
				$("#check_in_purpose").css({"display":"block"});
				if($("#late_night_checkin").is(':checked')){
					$('#card_number').attr('readonly', false);
				}else{
					$('#card_number').attr('readonly', true);
				}
				//----------
				
				if($("input[name='parking']:checked").val() == 'yes'){
					$("#parking_purpose").css({"display":"block"});
					var parki_val = ($('#parking_value').val());
					var park_m = parki_val;
					var d_p_a = parki_val;
				}else{
					//$("#payment_pattern").html(payment_pattern_values);
					var park_m = (0);
					var d_p_a = (0);
				}	
				
				if($("input[name='locker']:checked").val() == 'yes'){
					if(typeof $("#locker_value").val() != 'undefined'){
						var locker_m = ($("#locker_value").val());						
					}else{
						var locker_m = (0);
					}
				}else{
					var locker_m = (0);
				}
				
				if($("#disccount_money").val() != ''){
					if($('#payment_pattern').val() == '1'){
						var discount = ($("#disccount_money").val());
					}else if($('#payment_pattern').val() == '0'){
						var discount = ($("#disccount_money").val()) / 2;
					}else{
						var discount = ($("#disccount_money").val());
					}
				}else{
					var discount = (0);			
				}
				var m_ry = ($('#rent_amount').val());

				if($("input[name='payment']:checked").val() == 'full'){
					var rent_date = m_ry;
					$("#rental_fiels_container").css({"display":"block"});
				}else if($("input[name='payment']:checked").val() == 'half'){
					var rent_paymnt_p = m_ry;			
					var rent_date = rent_paymnt_p / 2 + 200;
					$("#rental_fiels_container").css({"display":"block"});
				}else{
					var rent_date = (0);
					var park_m = (0);
					var due_g_m = 1;
					var r_d_a = m_ry;
					$("#rental_fiels_container").css({"display":"none"});
				}
				if(rent_date > discount){
					var f_rent_v = rent_date - discount;
					$("#discount_text").val((discount));
					$("#disccount_money").val(discount);
				}else{
					var f_rent_v = rent_date;
					$("#discount_text").val((discount));
					$("#disccount_money").val(discount);//discount
				}
				var security_money = ($('#security_money').val());
				var all_total = Number(security_money) + Number(park_m) + Number(f_rent_v) + Number(locker_m);
                console.log('full ' + all_total);
                console.log('security ' + security_money);
                console.log('park ' + park_m);
                console.log('rent ' + f_rent_v);
                console.log('locker ' + locker_m);
				if(security_money > 0){
					$("#booking_security_amount").val(security_money);
					$("#parking_amount").val((park_m));
					$('#rent_amount_show').val((f_rent_v));
					$('#ac_rent_amount_1').val(f_rent_v);	
					$('#total_amount_large').html(Math.round(all_total)); 
					$("#booking_total_amount").val((all_total));
					$("#booking_total_amount_c").val((all_total));
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
					$("#booking_total_amount").val((0));
					$("#booking_total_amount_c").val((0));
					$("#booking_rent_amount").val('');
					$("#booking_parking_amount").val('');
					$("#parking_amount").val(0);
					$('#rent_amount_show').val(0);
					$('#ac_rent_amount_1').val(0);	
				}
				//----------
			// }else{			
			// 	$("#check_in_purpose").css({"display":"none"});
			// 	var tt_aa = ($('#security_money').val());   
			// 	$('#total_amount_large').html((tt_aa));
			// 	$("#booking_total_amount").val(tt_aa);
			// 	$("#booking_total_amount_c").val(tt_aa);
			// 	$("#booking_security_amount").val(tt_aa);
			// 	$("#booking_rent_amount").val('');
			// 	$("#booking_parking_amount").val('');
			// 	$("#parking_amount").val('');
			// 	$('#rent_amount_show').val('');
			// 	$('#ac_rent_amount_1').val('');	
			// 	$('#card_number').attr('readonly', false);
			// }
			$("#card_number_check").val('0');
		}
	}else{
		if(ndate == $("#checkin_date").val()){
            console.log('on second if');
			$("#check_in_purpose").css({"display":"block"});			
			$("#force_rent_container").css({"display":"none"});
			$('#force_rent').prop('checked', false);
			$('#card_number').attr('readonly', false);
			//---------
			if($("#vicle_parking").val() == '1' ){
				$("#parking_purpose").css({"display":"block"});
				var parki_val = ($('#parking_value').val());
				var park_m = ( parki_val / tdate ) * edate;
				var d_p_a = ( parki_val / tdate ) * edate;
			}else{
				$("#parking_purpose").css({"display":"none"});
				var park_m = (0);
				var d_p_a = (0);
			}

			if($("#locker_value").val() != ''){
				var locker_m = ($("#locker_value").val());
			}else{
				var locker_m = (0);
			}
			
			if($("#disccount_money").val() != ''){
				if($('#payment_pattern').val() == '1'){
					var discount = ($("#disccount_money").val());
				}else if($('#payment_pattern').val() == '0'){
					var discount = ($("#disccount_money").val()) / 2;
				}else{
					var discount = ($("#disccount_money").val());
				}
			}else{
				var discount = (0);				
			}
			var m_ry = ($('#rent_amount').val());

			if($('#payment_pattern').val() == '1'){
				var rent_date = ( m_ry / tdate ) * edate;
				$("#rental_fiels_container").css({"display":"block"});
			}else if($('#payment_pattern').val() == '0'){
				var rent_paymnt_p = ( m_ry / tdate ) * edate;			
				var rent_date = rent_paymnt_p / 2 + 200;
				$("#rental_fiels_container").css({"display":"block"});
			}else{
				var rent_date = (0);
				var park_m = (0);
				var due_g_m = 1;
				var r_d_a = ( m_ry / tdate ) * edate;
				$("#rental_fiels_container").css({"display":"none"});
			}
			if(rent_date > discount){
				var f_rent_v = rent_date - discount;
				$("#discount_text").val((discount));
				$("#disccount_money").val(discount);
			}else{
				var f_rent_v = rent_date;
				$("#discount_text").val((discount));
				$("#disccount_money").val(discount);  //discount
			}
			var security_money = ($('#security_money').val());
			var all_total = security_money + park_m + f_rent_v + locker_m;
				
			if(security_money > 0){
				$("#booking_security_amount").val(security_money);
				$("#parking_amount").val((park_m));
				$('#rent_amount_show').val((f_rent_v));
				$('#ac_rent_amount_1').val(f_rent_v);	
				$('#total_amount_large').html(Math.round(all_total)); 
				$("#booking_total_amount").val((all_total));
				$("#booking_total_amount_c").val((all_total));
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
				$("#booking_total_amount").val((0));
				$("#booking_total_amount_c").val((0));
				$('#rent_amount_show').val(0);
				$('#ac_rent_amount_1').val(0);	
				$("#parking_amount").val(0);
			}
			//---------
			$("#card_number_check").val('1');
		}else{
            console.log('on second else');
			// if($("#force_rent").is(':checked')){
				
				
				//---------------------------------------------
				var n_chk_in = $("#checkin_date").val().split('-');
				var n_days_ed = getDaysInMonth(n_chk_in[1],n_chk_in[0]);
				var n_days_m = getDaysInMonth(n_chk_in[1],n_chk_in[0]);
				console.log('ok');
				console.log($("#checkin_date").val() + 'check in date');
				console.log(parseInt(n_chk_in[2]) + n_chk_in[2] + 'check in');
				if( parseInt(n_chk_in[2]) > n_chk_in[2]){
					var ac_days = n_days_m - (n_chk_in[2]) + 1;
					console.log(ac_days + ' AC days 1');
				}else if( parseInt(n_chk_in[1]) == n_chk_in[1]){
					var ac_days = n_days_m - (n_chk_in[2]) + 1;
					console.log(ac_days + ' AC days 2');
				}else if( parseInt(n_chk_in[1]) > n_chk_in[1]){
					var number_after_d = n_chk_in[2];
					var date_month = n_chk_in[1] + 1;
					var number_after_n = getDaysInMonth(date_month, n_chk_in[0]);
					var ac_days = number_after_n - number_after_d + 1;
					console.log(ac_days + ' AC days 3');
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
					console.log(ac_days + ' AC days 4');
				}else{
					var ac_days = (n_days_m) - n_chk_in[2] + 1;
					console.log(ac_days + ' AC days 5');
					//var ac_days = 'test not working!';
				}
				
				//------------
				//---------
				if($("input[name='parking']:checked").val() == 'yes'){
					var parki_val = ($('#parking_value').val());					
					var park_m = ( parki_val / n_days_ed ) * ac_days;
					var d_p_a = ( parki_val / n_days_ed ) * ac_days ;
				}else{
					var park_m = (0);
					var d_p_a = (0);
				}	
				
				if($("input[name='locker']:checked").val() == 'yes'){
					if(typeof $("#locker_value").val() != 'undefined'){
						var locker_m = ($("#locker_value").val());						
					}else{
						var locker_m = (0);
					}
				}else{
					var locker_m = (0);
				}
				
				if($("#disccount_money").val() != ''){
					if($('#payment_pattern').val() == '1'){
						var discount = ($("#disccount_money").val());
					}else if($('#payment_pattern').val() == '0'){
						var discount = ($("#disccount_money").val()) / 2;
					}else{
						var discount = ($("#disccount_money").val());
					}
				}else{
					var discount = (0);				
				}

				var m_ry = ($('#rent_amount').val());

				if($("input[name='payment']:checked").val() == 'full'){
					var rent_date = ( m_ry / n_days_ed ) * ac_days;
				}else if($("input[name='payment']:checked").val() == 'half'){
					var rent_paymnt_p = ( m_ry / n_days_ed ) * ac_days ;			
					var rent_date = rent_paymnt_p / 2 + 200;
				}else{
					var rent_date = (0);
					var park_m = (0);
					var due_g_m = 1;
					var r_d_a = ( m_ry / n_days_ed ) * ac_days;
				}
				//alert(n_days_ed + ' ------ ' + ac_days);
				if(rent_date > discount){
					var f_rent_v = rent_date - discount;
					$("#discount_text").val((discount));
					$("#disccount_money").val(discount);
				}else{
					var f_rent_v = rent_date;
					$("#discount_text").val((discount));
					$("#disccount_money").val(discount); //discount
				}
				var security_money = $('#security_money').val();
				var all_total = Number(security_money) + Number(park_m) + Number(f_rent_v) + Number(locker_m);
                console.log('full ' + all_total);
                console.log('park ' + park_m);
                console.log('rent ' + f_rent_v);
                console.log('locker ' + locker_m);
                // console.log('discount' + b_amount);
				
				if(security_money > 0){
					$("#booking_security_amount").val(security_money);
					$("#parking_amount").val((park_m));
					$('#rent_amount_show').val((f_rent_v));
					$('#ac_rent_amount_1').val(f_rent_v);	
					$('#total_amount_large').html(Math.round(all_total)); 
					$("#booking_total_amount").val((all_total));
					$("#booking_total_amount_c").val((all_total));
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
					$("#booking_total_amount").val((0));
					$("#booking_total_amount_c").val((0));
					$('#rent_amount_show').val(0);
					$('#ac_rent_amount_1').val(0);	
				}
				//---------
			// }else{
			// 	$("#check_in_purpose").css({"display":"none"});
			// 	var tt_aa = ($('#security_money').val());   
			// 	$('#total_amount_large').html((tt_aa));
			// 	$("#booking_total_amount").val(tt_aa);
			// 	$("#booking_total_amount_c").val(tt_aa);
			// 	$("#booking_security_amount").val(tt_aa);
			// 	$("#booking_rent_amount").val('');
			// 	$("#booking_parking_amount").val('');
			// 	$("#parking_amount").val('');
			// 	$('#rent_amount_show').val('');
			// 	$('#ac_rent_amount_1').val('');	
			// 	$('#card_number').attr('readonly', false);
			// }
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



// -----------------------------------
// ------------- Bkash ---------------
$('body').on('click','button.demo', function (){
    const options = {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            username: 'asdf',
            password: 'asdf',
            'Content-Type': 'application/json'
        },
        body: '{"app_key":"asdf","app_secret":"asdf"}'
    };

    fetch('https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/token/grant', options)
        .then(response => console.log(response))
        .catch(err => console.error(err));
});

function show_modal(package_name){
	$.ajax({
		type: 'post',
		url: 'assets/ajax/package_plan/fetch_modal_img.php',
		data: {package_name: package_name},
		success: function(response){
			if(response != ''){
				$('#carousel-inner').html(response);
				$('#pkg_bed_pic').modal();
			}
		}
	});
}