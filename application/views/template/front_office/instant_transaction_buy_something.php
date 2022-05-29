<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Instant Transaction (Buy Something)</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Instant Transaction (Buy Something)</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
<?php
$utime = sprintf('%.4f', microtime(TRUE)); 
$raw_time = DateTime::createFromFormat('U.u', $utime);  
$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
$today = $raw_time->format('dmy-his-u');
if(!empty($branch_code)){
	$bc = $branch_code->branch_code;
}else{
	$bc = '';
	echo "<script>window.open('".$home."admin/booking','_top')</script>";
}
$transaction_id = $bc.'-'.$today;
?>	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Instant Transaction (Buy Something)</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="branch_id" value="<?php echo $_SESSION['super_admin']['branch'];?>"/>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Transaction ID:</label>	
										<input type="text" id="transaction_id" name="transaction_id" class="form-control" value="<?php echo $transaction_id; ?>" placeholder="Id Number" readonly/>
									</div>
								</div>
								<div class="col-sm-9">
									<span id="error_message" style="color:#f00;font-weight:bolder;float: right;"></span>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<!--------------------------------------->								
									<div class='row'>
										<div class='col-sm-12'>
											<style>.item_table td{padding:4px;}</style>
											<table class="table table-bordered table-hover item_table">
												<thead>
													<tr>
														<th width="2%"><input id="check_all" class="formcontrol" type="checkbox" style="transform: scale(1.3);"/></th>
														<th width="15%">Item Name</th>
														<th width="23%">Buying Pupose</th>
														<th width="15%">Price</th>
														<th width="15%">Quantity</th>
														<th width="15%">Sub total</th>
														<th width="15%">Attachment</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><input class="case" type="checkbox" style="transform: scale(1.3); margin-left: 8px; margin-top: 13px;"/></td>
														<td><input type="text" data-type="productCode" name="item_name[]" id="ipro_1" class="form-control autocomplete_txt" autocomplete="off" required /></td>
														<td><input type="text" data-type="productName" name="purpose[]" id="ides_1" class="form-control autocomplete_txt" autocomplete="off" required /></td>
														<td><input type="text" name="item_price[]" id="price_1" class="number_int form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>
														<td><input type="text" name="ite_qty[]" id="quantity_1" class="number_int form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>
														<td><input type="text" name="total_item_amount[]" id="total_1" class="number_int form-control totalLinePrice" style="color:green;font-weight:bolder;font-size: 18px;" readonly /></td>
														<td><input type="file" name="attachment[]" class="form-control" style="padding-top:3px;" required /></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class='row'>
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-3">
													<button class="btn btn-danger delete" type="button">- Delete</button>
													<button class="btn btn-success addmore" type="button">+ Add More</button>
												</div>
												<?php
													if(!empty($petty_balance)){
														$balance = (float)$petty_balance->amount;
													}else{
														$balance = 0;
													}
												?>
												<div class="col-sm-6">
													<center>
														<b style="font-size: 24px;">
															Balance: <span style="color:#f00;"> <?php echo money($balance); ?></span>
														</b>
													</center>
													<input id="total_amount" type="hidden" name="total_amount" value="<?php echo $balance; ?>"/>
												</div>
												<div class="col-sm-3">
													<div class="form-group">														
														<input name="total_subtotal" type="number" class="form-control" id="subTotal" placeholder="Total" style="color:#f00;font-weight:bolder;font-size: 25px;" readonly>
													</div>
												</div>
											</div>												
										</div>												
									</div>													
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<textarea name="extra_note" class="form-control" placeholder="Extra Note" style="height:120px;"></textarea>
											</div>
										</div>
									</div>
									<!--------------------------------------->
								</div>												
							</div>													
							<div class="form-group" style="margin-top:20px;">
								<button type="submit" name="save" class="btn btn-lg btn-success" style="width:100% !important;">
									<i class="far fa-save"></i>
									Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var i=$('table tr').length;
$(".addmore").on('click',function(){
    html = '<tr>';
    html += '<td><input class="case" type="checkbox" style="transform: scale(1.3); margin-left: 8px; margin-top: 13px;"/></td>';
    html += '<td><input type="text" data-type="productCode" name="item_name[]" id="itemNo_'+i+'" class="form-control autocomplete_txt" autocomplete="off" required /></td>';
    html += '<td><input type="text" data-type="productName" name="purpose[]" id="itemName_'+i+'" class="form-control autocomplete_txt" autocomplete="off" required /></td>';
    html += '<td><input type="text" name="item_price[]" id="price_'+i+'" class="number_int form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>';
    html += '<td><input type="text" name="ite_qty[]" id="quantity_'+i+'" class="number_int form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>';
    html += '<td><input type="text" name="total_item_amount[]" id="total_'+i+'" class="number_int form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" style="color:green;font-weight:bolder;font-size: 18px;" readonly /></td>';
    html += '<td><input type="file" name="attachment[]" class="form-control" style="padding-top:3px;" required/></td>';
    html += '</tr>';
    $('table').append(html);
    i++;
});
$(document).on('change','#check_all',function(){
    $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});
$(".delete").on('click', function() {
    $('.case:checkbox:checked').parents("tr").remove();
    $('#check_all').prop("checked", false); 
    calculateTotal();
});
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