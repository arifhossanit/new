<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Urgent Transaction (Buy Something)</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Urgent Transaction (Buy Something)</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	<div class="container">
		<div class="row">
			<?php
				if(!empty($petty_balance)){
					$balance = (float)$petty_balance->amount;
				}else{
					$balance = 0;
				}
			?>
			<div class="col-md-3">
				<b style="font-size: 25px;"> Balance: <span style="color:#f00;"> <?php echo money($balance); ?></span> </b>
			</div>
			<div class="col-md-3">
				<button onclick="return return_money('<?php echo $balance; ?>','<?php echo $_SESSION['super_admin']['employee_id']; ?>');" type="button" class="btn btn-success button-sm" style="float:right;"><i class="far fa-money-bill-alt"></i> &nbsp;Return Money</button>
			</div>
			<div class="col-md-3">
				<button class="btn btn-primary" onclick="request_money()"><i class="fas fa-receipt"></i> &nbsp;Bill Submit</button>
			</div>
			<div class="col-md-12 mt-5" id="form_body"></div>
		</div>
	</div>
</div>

<div class="modal fade" id="return_advance_money_modal">
	<div class="modal-dialog modal-sm" >
		<div class="modal-content">	
			
		</div>
	</div>
</div>

<script>
$('document').ready(function(){
	$('#return_advance_money_form').on("submit",function(){
		event.preventDefault();
		var form = $('#return_advance_money_form')[0];
		var data = new FormData(form);			
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo current_url(); ?>",  
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
				$("#finish_booking").prop("disabled", false);
				alert(data);
				window.open('<?php echo current_url(); ?>','_self');
			}
		});
		return false;
	})
})

function request_money(){
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?php echo base_url('assets/ajax/accounting/get_transaction_forms.php'); ?>",  
		data: {type: 'request_money', branch_code: '<?php echo $branch_code->branch_code; ?>'},
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$("#form_body").html(data);
		}
	});
}

function return_money(balance, employee_id){
	if(balance != '' && employee_id != ''){
		//if(balance > 0){
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url:"<?php echo base_url('assets/ajax/accounting/get_transaction_forms.php'); ?>",  
				data: {employee_id, balance, type: 'return_money'},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$("#form_body").html(data);
				}
			});
		//}else{
		//	alert('You have not enough money to return! Please Try Another time');
		//}
	}else{
		alert('Something wrong!! Please Try again.');
	}
}



var i= Number(('table tr').length) + 1;
function add_row(){
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?php echo base_url('assets/ajax/accounting/get_expense_more_option.php'); ?>",  
		data: { i },
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
    		$('table').append(data);
		}
	});
    // html = '<tr>';
    // html += '<td><input class="case" type="checkbox" style="transform: scale(1.3); margin-left: 8px; margin-top: 13px;"/></td>';
    // html += '<td><input type="text" data-type="productCode" name="item_name[]" id="itemNo_'+i+'" class="form-control autocomplete_txt" autocomplete="off" required /></td>';
    // html += '<td><input type="text" data-type="productName" name="purpose[]" id="itemName_'+i+'" class="form-control autocomplete_txt" autocomplete="off" required /></td>';
    // html += '<td><input type="text" name="item_price[]" id="price_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>';
    // html += '<td><input type="text" name="ite_qty[]" id="quantity_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>';
    // html += '<td><input type="text" name="total_item_amount[]" id="total_'+i+'" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" style="color:green;font-weight:bolder;font-size: 18px;" readonly /></td>';
    // html += '<td><input type="file" name="attachment[]" class="form-control" style="padding-top:3px;" required/></td>';
    // html += '</tr>';
	// console.log(html);
    // $('table').append(html);
    i++;
};
$(document).on('change','#check_all',function(){
    $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});
function remove_row() {
    $('.case:checkbox:checked').parents("tr").remove();
    $('#check_all').prop("checked", false); 
    calculateTotal();
};
var prices = ["S24_4620|1961 Chevrolet Impala|32.33"];
$(document).on('focus','.autocomplete_txt',function(){
    type = $(this).data('type');

    if(type =='productCode' )autoTypeNo=0;
    if(type =='productName' )autoTypeNo=1;  

    $(this).autocomplete({
        source: function( request, response ) {  
             var array = $.map(prices, function (item) {
                 var code = item.split("|");
                 return {
                     label: code[autoTypeNo],
                     value: code[autoTypeNo],
                     data : item
                 }
             });
             response($.ui.autocomplete.filter(array, request.term));
        },
        autoFocus: true,            
        minLength: 2,
        select: function( event, ui ) {
            var names = ui.item.data.split("|");                        
            id_arr = $(this).attr('id');
            id = id_arr.split("_");
            $('#itemNo_'+id[1]).val(names[0]);
            $('#itemName_'+id[1]).val(names[1]);
            $('#quantity_'+id[1]).val(1);
            $('#price_'+id[1]).val(names[2]);
            $('#total_'+id[1]).val( 1*names[2] );
            calculateTotal();
        }               
    });
});

$(document).on('change keyup blur','.changesNo',function(){
    id_arr = $(this).attr('id');
    id = id_arr.split("_");
    qty = $('#quantity_'+id[1]).val();
    price = $('#price_'+id[1]).val();
    if( qty!='' && price !='' ) $('#total_'+id[1]).val( (parseFloat(price)*parseFloat(qty)).toFixed(2) );   
    calculateTotal();
});
function calculateTotal(){
    subTotal = 0 ; sub_total = 0; 
    $('.totalLinePrice').each(function(){
        if($(this).val() != '' )subTotal += parseFloat( $(this).val() );
    });
	if(subTotal.toFixed(2) > parseFloat($("#total_amount").val())){
		$("#error_message").html('You Have Not Enough Balance In Petty Cash!');
	}else{
		$("#error_message").html('');
	}
	$('#subTotal').val( subTotal.toFixed(2) );
}

var specialKeys = new Array();
specialKeys.push(8,46);
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    console.log( keyCode );
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}

</script>