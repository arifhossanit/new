<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Widthdraw</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('ipo-member'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Withdraw</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<div class="card card-info">
						<div class="card-header">
							<h3>Withdraw</h3>
						</div>
						<div class="card-body">
							<form id="ipo_member_widthdrawral_form" action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="ipo_id" value="<?php echo $_SESSION['ipo_member_panel']['ipo_id']; ?>" />
								<div class="row">
									<div class="col-sm-12" id="widthdraw_message"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Amount</label>
											<input onkeyup="return width_function_management()" type="text" name="amount" class="number_int form-control" placeholder="Amount" required="required" autocomplete="off"/>
										</div>
									</div>
									
									<div class="col-sm-12">
										<div class="form-group">
											<label>Received By</label>
											<select onchange="return width_function_management()" name="payment_received_by" class="form-control" required="required">
												<option value="">--select--</option>
												<option value="Own">Own</option>
												<option value="Other">Other</option>
											</select>
										</div>
									</div>
									
									<div class="col-sm-12">
										<div class="form-group">
											<label>Withdraw Method</label>
											<select onchange="return width_function_management()" name="widthdraw_method" class="form-control" required="required">
												<option value="">--select--</option>
												<option value="Cash">Cash</option>
												<option value="Mobile Banking">Mobile Banking</option>
												<option value="Bank">Bank</option>
												<option value="Chequee">Chequee</option>
											</select>
										</div>
									</div>
									
									<div class="col-sm-12" id="mobile_banking" style="display:none;">
										<div class="form-group">
											<label>Choose Media</label>
											<select name="mobile_media" class="form-control">
												<option value="">--select--</option>
												<option value="Bikash">Bikash</option>
												<option value="Nogod">Nogod</option>
												<option value="Rocket">Rocket</option>
											</select>
										</div>
										<div class="form-group">
											<label>Receiver Number</label>
											<input type="text" name="receiver_number" class="number_int form-control" placeholder="Receiver Number" autocomplete="off"/>
										</div>										
									</div>
									
									<div class="col-sm-12" id="bank_payment" style="display:none;">
										<div class="form-group">
											<label>Bank Name</label>
											<input type="text" name="bank_name" class="form-control" placeholder="Bank Name" autocomplete="off">
										</div>
										<div class="form-group">
											<label>Account holder Name</label>
											<input type="text" name="account_holder_name" class="form-control" placeholder="Account Holder Name" autocomplete="off">
										</div>
										<div class="form-group">
											<label>Account Number</label>
											<input type="text" name="account_number" class="form-control" placeholder="Account Number" autocomplete="off">
										</div>
									</div>
									
									<div class="col-sm-12" id="chequee_payment" style="display:none;">
										<div class="form-group">
											<label>Receiver Name</label>
											<input type="text" name="receiver_name" class="form-control" placeholder="Receiver Name" autocomplete="off"/>
										</div>	
									</div>
									
									<div class="col-sm-12">
										<div class="form-group">
											<label>Password</label>
											<input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required="required" />
										</div>
										<div class="form-group">
											<label>Note</label>
											<textarea name="note" class="form-control" placeholder="Note"></textarea>
										</div>
									</div>
									
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="send_request" class="btn btn-success" style="float:right;">Send Request</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-9">
					<div class="card card-info">
						<div class="card-header">
							<h3>Widthdraw List</h3>
						</div>
						<div class="card-body">
							<style>#ipo_referal_aproval_table td{text-align:center;vertical-align: middle;}#ipo_referal_aproval_table th{text-align:center;vertical-align: middle;}</style>
							<table id="ipo_referal_aproval_table" class="table table-sm table-bordered table table-striped" style="width:100%;">
								<thead>
									<tr>
										<th>id</th>
										<th>Amount</th>
										<th>Receiver Info</th>
										<th>Request Date</th>
										<th>Status</th>
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

<script>
$('document').ready(function(){
	$("#ipo_member_widthdrawral_form").on("submit",function(){
		event.preventDefault();
		var form = $('#ipo_member_widthdrawral_form')[0];
		var data = new FormData(form);			
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/ipo/ipo_member_widthdrawral_form_submit.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$('#data-loading').html(data_loading);
				$('button[name="send_request"]').prop("disabled", true);				
			},
			success:function(data){
				$('#data-loading').html('');
				$('button[name="send_request"]').prop("disabled", false);
				$('#ipo_referal_aproval_table').DataTable().ajax.reload( null , false);
				alert(data);
			}
		});
		return false;
	})
})
function ipo_member_widthdraw_remove(id){
	if(confirm('Are you sure want to remove widthdraw request?')){
		$.ajax({  
			url:"<?=base_url('assets/ajax/ipo/remove_ipo_widthdraw_requset.php');?>",  
			method:"POST",  
			data:{ipo_request_id:id},
			beforeSend:function(){
				$('#data-loading').html(data_loading);			
			},
			success:function(data){
				$('#data-loading').html('');
				$('#ipo_referal_aproval_table').DataTable().ajax.reload( null , false);
				alert(data);
			}  
		})
	}
}
function width_function_management(){
	var m_type = $('select[name="widthdraw_method"]').val();
	if(m_type == 'Mobile Banking'){
		mobile_banking();
	}else if(m_type == 'Bank'){
		bank_payment();
	}else if(m_type == 'Chequee'){
		chequee_payment();
	}else{
		else_method();
	}
}
function chequee_payment(){
	$("#mobile_banking").css({"display":"none"});
	$("#bank_payment").css({"display":"none"});
	$("#chequee_payment").css({"display":"block"});	
	$('select[name="mobile_media"]').prop('required', false);
	$('input[name="receiver_number"]').prop('required', false);	
	$('input[name="bank_name"]').prop('required', false);
	$('input[name="account_holder_name"]').prop('required', false);
	$('input[name="account_number"]').prop('required', false);	
	$('input[name="receiver_name"]').prop('required', true);
	if($('select[name="payment_received_by"]').val() == 'Own'){
		var ipo_id = '<?php echo $_SESSION['ipo_member_panel']['ipo_id']; ?>';
		if(ipo_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/ipo/get_widthraw_options_options.php');?>",  
				method:"POST",  
				data:{ipo_id:ipo_id},
				success:function(data){
					var row = jQuery.parseJSON(data);
					$('select[name="mobile_media"]').val('');
					$('input[name="receiver_number"]').val('');
					$('input[name="bank_name"]').val('');
					$('input[name="account_holder_name"]').val('');
					$('input[name="account_number"]').val('');
					$('input[name="receiver_name"]').val(row['personal_full_name']);
					$('input[name="receiver_name"]').prop('readonly', true);
				}  
			})
		}else{
			alert('your session is expired! Please login again');
		}
	}else{
		$('select[name="mobile_media"]').val('');
		$('input[name="receiver_number"]').val('');
		$('input[name="bank_name"]').val('');
		$('input[name="account_holder_name"]').val('');
		$('input[name="account_number"]').val('');
		$('input[name="receiver_name"]').val('');
		$('input[name="receiver_name"]').prop('readonly', false);
		$('input[name="receiver_name"]').prop('required', true);
	}
}
function bank_payment(){
	$("#mobile_banking").css({"display":"none"});
	$("#bank_payment").css({"display":"block"});
	$("#chequee_payment").css({"display":"none"});	
	$('select[name="mobile_media"]').prop('required', false);
	$('input[name="receiver_number"]').prop('required', false);	
	$('input[name="bank_name"]').prop('required', true);
	$('input[name="account_holder_name"]').prop('required', true);
	$('input[name="account_number"]').prop('required', true);	
	$('input[name="receiver_name"]').prop('required', false);	
	if($('select[name="payment_received_by"]').val() == 'Own'){
		var ipo_id = '<?php echo $_SESSION['ipo_member_panel']['ipo_id']; ?>';
		if(ipo_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/ipo/get_widthraw_options_options.php');?>",  
				method:"POST",  
				data:{ipo_id:ipo_id},
				success:function(data){
					var row = jQuery.parseJSON(data);
					$('select[name="mobile_media"]').val('');
					$('input[name="receiver_number"]').val('');
					$('input[name="bank_name"]').val(row['bank_name']);
					$('input[name="account_holder_name"]').val(row['account_holder_name']);
					$('input[name="account_number"]').val(row['account_number']);
					$('input[name="receiver_name"]').val('');
					$('input[name="bank_name"]').prop('readonly', true);
					$('input[name="account_holder_name"]').prop('readonly', true);
					$('input[name="account_number"]').prop('readonly', true);
				}  
			})
		}else{
			alert('your session is expired! Please login again');
		}
	}else{
		$('select[name="mobile_media"]').val('');
		$('input[name="receiver_number"]').val('');
		$('input[name="bank_name"]').val('');
		$('input[name="account_holder_name"]').val('');
		$('input[name="account_number"]').val('');
		$('input[name="receiver_name"]').val('');
		$('input[name="bank_name"]').prop('readonly', false);
		$('input[name="account_holder_name"]').prop('readonly', false);
		$('input[name="account_number"]').prop('readonly', false);
		$('input[name="bank_name"]').prop('required', true);
		$('input[name="account_holder_name"]').prop('required', true);
		$('input[name="account_number"]').prop('required', true);
	}
}
function mobile_banking(){
	$("#mobile_banking").css({"display":"block"});
	$("#bank_payment").css({"display":"none"});
	$("#chequee_payment").css({"display":"none"});	
	$('select[name="mobile_media"]').prop('required', true);
	$('input[name="receiver_number"]').prop('required', true);	
	$('input[name="bank_name"]').prop('required', false);
	$('input[name="account_holder_name"]').prop('required', false);
	$('input[name="account_number"]').prop('required', false);	
	$('input[name="receiver_name"]').prop('required', false);	
	if($('select[name="payment_received_by"]').val() == 'Own'){
		var ipo_id = '<?php echo $_SESSION['ipo_member_panel']['ipo_id']; ?>';
		if(ipo_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/ipo/get_widthraw_options_options.php');?>",  
				method:"POST",  
				data:{ipo_id:ipo_id},
				success:function(data){
					var row = jQuery.parseJSON(data);
					$('select[name="mobile_media"]').val('');
					$('input[name="receiver_number"]').val(row['personal_phone_number']);
					$('input[name="bank_name"]').val('');
					$('input[name="account_holder_name"]').val('');
					$('input[name="account_number"]').val('');
					$('input[name="receiver_name"]').val('');
					$('input[name="receiver_number"]').prop('readonly', true);
				}  
			})
		}else{
			alert('your session is expired! Please login again');
		}
	}else{
		$('select[name="mobile_media"]').val('');
		$('input[name="receiver_number"]').val('');
		$('input[name="bank_name"]').val('');
		$('input[name="account_holder_name"]').val('');
		$('input[name="account_number"]').val('');
		$('input[name="receiver_name"]').val('');
		$('input[name="receiver_number"]').prop('readonly', false);
		$('input[name="receiver_number"]').prop('required', true);
	}
}
function else_method(){
	$("#mobile_banking").css({"display":"none"});
	$("#bank_payment").css({"display":"none"});
	$("#chequee_payment").css({"display":"none"});	
	$('select[name="mobile_media"]').prop('required', false);
	$('input[name="receiver_number"]').prop('required', false);	
	$('input[name="bank_name"]').prop('required', false);
	$('input[name="account_holder_name"]').prop('required', false);
	$('input[name="account_number"]').prop('required', false);	
	$('input[name="receiver_name"]').prop('required', false);
	
	$('select[name="mobile_media"]').prop('readonly', false);
	$('input[name="receiver_number"]').prop('readonly', false);	
	$('input[name="bank_name"]').prop('readonly', false);
	$('input[name="account_holder_name"]').prop('readonly', false);
	$('input[name="account_number"]').prop('readonly', false);	
	$('input[name="receiver_name"]').prop('readonly', false);
	
	$('select[name="mobile_media"]').val('');
	$('input[name="receiver_number"]').val('');
	$('input[name="bank_name"]').val('');
	$('input[name="account_holder_name"]').val('');
	$('input[name="account_number"]').val('');
	$('input[name="receiver_name"]').val('');
	$('input[name="receiver_name"]').val('');
}
$(document).ready(function(){
	$('#ipo_referal_aproval_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
		"serverSide": true,
		"ajax": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_widthdraw_request_datatable.php"
	});
	$('#ipo_widthdraw_member').addClass('active');
});
</script>