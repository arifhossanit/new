<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Check Print</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
				<li class="breadcrumb-item active">Check Print</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<div class="card card-success">
						<div class="card-header">
							Input Check Information
						</div>
						<div class="card-body">
							<form id="check_print_form" action="<?php echo current_url(); ?>" method="post">
								<input type="hidden" name="save_info" value="1"/>
								<input type="hidden" name="branch_id" value="<?php echo $_SESSION['super_admin']['branch']; ?>"/>
								<input type="hidden" name="uploader_info" value="<?php echo $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']; ?>"/>
								<span id="check_print_message" style="font-weight:bolder;color:#f00;"></span>
								<div class="row">
									<div class="col-sm-12">
										<h3 style="text-decoration:underline;">Check Information</h3>
									</div>
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-6"> 
												<div class="form-group">
													<label>Select Date</label>
													<input type="date" id="date" name="date" class="form-control" autocomplete="off" required />
													
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Input Name</label>
													<input type="text" id="name" name="name" Placeholder="Full Name" class="form-control" autocomplete="off" required />
												</div>
											</div>
										</div>	
										<div class="row">
											<div class="col-sm-6"> 
												<div class="form-group">
													<label>Input amount</label>
													<input type="number" id="amount" name="amount" placeholder="Amount" class="form-control" autocomplete="off" required />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Description</label>
													<textarea id="description" name="description" placeholder="Description" class="form-control" style="background-color:#f4f6f9;" readonly></textarea>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-12">
										<h3 style="text-decoration:underline;">Required Information</h3>
									</div>
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-6"> 
												<div class="form-group">
													<label>Card / Invoice NO:</label>
													<input type="text" id="card_invoice_no" name="card_invoice_no" placeholder="Card / Invoice NO" class="form-control" autocomplete="off" required />
												</div>
												<div class="form-group">
													<label>Check NO:</label>
													<input type="text" name="check_no" placeholder="Check NO" class="form-control" autocomplete="off" required />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Note</label>
													<textarea name="note" placeholder="Note" class="form-control"></textarea>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12" id="card_number_check_note" style="color:#f00;"> </div>
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" id="save" name="save" class="btn btn-info" style="float:right;">Save</button>
										</div>
									</div>
									<div class="col-sm-12" style="padding-top:40px;">
										<div style="width:700px; height:326px;float:left;background:url(<?php echo base_url(); ?>assets/img/chaque.jpg);background-repeat: no-repeat;background-size: cover;border:solid 1px #333;transform: scale(0.9); margin-left: -42px;">
											<div style="height:28.8px;width:100%;margin-top: 50px;">
												<div style="width:215.04px;height:28.8px;float:left;margin-left:490px;">
													<span id="date_preview" style="font-size: 22px; line-height: 29px; letter-spacing: 13px;"></span>
												</div>
											</div>
											
											<div style="height:24.96px;width:100%;margin-top: 30px;">
												<div style="width:555px;height:24.96px;float:left;margin-left:58px;">
													<span align="center" id="name_preview" style="font-size: 17px; margin-left: 30px; color: #000; font-weight: 500;"></span>
												</div>
											</div>
											
											<div style="height:52.8px;width:100%;margin-top: 5px;">
												<div style="width:345.8px;height:52.8px;float:left;margin-left:106px;">
													<span align="center" id="description_preview" style="font-size: 16px; font-weight: 500;line-height: 29px;"></span>
												</div>
												
												<div style="width:182.4px;height:30.72px;float:left;margin-left:40px;margin-top: 7px;">
													<span id="amount_preview" style="font-size: 27px; font-weight: 600; letter-spacing: 3px; margin-left: 0px; line-height: 30px;"></span>
												</div>
											</div>											
										</div>
									</div>
									
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="card card-success">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-3">
									<h3 class="card-title"><i class="far fa-bed"></i> Printed Check Logs</h3>
								</div>
								<div class="col-sm-3">
									<form>
										<div class="form-group">
											<input type="date" id="date_filter" class="form-control"/>
										</div>
									</form>
								</div>
								<div class="col-sm-6">
									<div id="export_buttons" style="float: right;"></div>
								</div>
							</div>						
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;/*white-space: nowrap;*/">
								<thead>
									<tr>
										<th>Id</th>
										<th><abbr title="Withdrawal">W</abbr></th>
										<th>Invoice/Card</th>
										<th>Check Number</th>
										<th>Check Name</th>
										<th>Issue Date</th>
										<th>Print_date</th>												
										<th>Amount</th>
										<th>Note</th>
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
			<div class="row">
				
			</div>
		</div>
	</div>
</div>
<!----vaiw model-->
	<div class="modal fade" id="check_print_model">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Check Print information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="check_print_result" style="height:1080px;overflow-y:scroll;">	
					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<!----vaiw model-->
	<div class="modal fade" id="edit_modal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Check Edit information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="edit_modal_result">	
						<div class="row">
							<div class="col-sm-12">
								<input type="hidden" id="check_id" value=""/>
								<div class="form-group">
									<label>Old Number</label>
									<input type="text" id="old_check_number" readonly class="form-control"/>
								</div>
								<div class="form-group">
									<label>New Number</label>
									<input type="text" id="new_check_number" class="number_int form-control"/>
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea id="check_update_note" class="form-control"></textarea>
								</div>
								<div class="form-group">
									<button type="button" onclick="return submit_card_number()" class="btn btn-success">Change</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<script>
const picker = document.getElementById('date');
picker.addEventListener('input', function(e){
  var day = new Date(this.value).getUTCDay();
  if([5,6].includes(day)){
    e.preventDefault();
    this.value = '';
    alert('Weekends not allowed');
  }
});
function check_edit_modal(id, Check){	
	$("#check_id").val(id); 
	$("#old_check_number").val(Check); 
	$("#edit_modal").modal('show');	
}
function submit_card_number(){
	var check_id = $("#check_id").val(); 
	var new_number = $("#new_check_number").val(); 
	var old_number = $("#old_check_number").val(); 
	var change_note = $("#check_update_note").val(); 
	if(new_number != ''){
		if(confirm('Are you sure want to change the check number?')){
			$.ajax({  
				url:"<?=base_url('assets/ajax/form_submit/update_check_number_data.php');?>",  
				method:"POST",  
				data:{
					check_id:check_id,
					new_number:new_number,
					old_number:old_number,
					change_note:change_note
				},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					$('#data-loading').html('');
					alert(data); 
					$("#edit_modal").modal('hide'); 
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}  
			});
		}else{
			$("#edit_modal").modal('hide');
		}
	}else{
		alert('New Check Number Required!');
		$("#new_check_number").focus(); 
	}
}
function check_print_modal(id){
	var check_id = id;
	if(check_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/check_print_model.php');?>",  
			method:"POST",  
			data:{check_id:check_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#check_print_result').html(data); 
				$("#check_print_model").modal('show');   
			}  
		});  
	}	
}
function check_disabled_modal(id, information){
	var retVal = prompt( 'DANGER! Are your sure want to Disabled ('+information+') this Cheque??Please remember..! If you disabled it then never further enabled & Please Write some reason in note field for disable' );	
	if(retVal != null){
		if(retVal == ''){
			alert('Sorry! System can not disable it. Note: Field was required!');
		}else{
			var check_id = id;
			if(check_id != ''){
				$.ajax({  
					url:"<?=base_url('assets/ajax/form_model/check_withdrawal_modal.php'); ?>",  
					method:"POST",  
					data:{disabled_check_id:check_id, disabled_check_note: retVal},
					beforeSend:function(){					
						$('#data-loading').html(data_loading);					 
					},
					success:function(data){	
						$('#data-loading').html('');
						alert(data);
						$('#booking_data_table').DataTable().ajax.reload( null , false);
					}  
				});  
			}else{
				alert('Something Wrong! Please Try again');
			}
		}
		
	}
}
function check_withdrawal_modal(id){
	if(confirm('Are you sure?')){
		var check_id = id;
		if(check_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/form_model/check_withdrawal_modal.php'); ?>",  
				method:"POST",  
				data:{check_id:check_id},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					$('#data-loading').html('');
					alert(data);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}  
			});  
		}else{
			alert('Something Wrong! Please Try again');
		}
	}
}





$('document').ready(function(){
	$("#check_print_form").on("submit",function(){
		event.preventDefault();
		var form = $('#check_print_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/insert_print_check_data.php'); ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#save").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$("#save").prop("disabled", false);
				var value = data.split('_____');
				if(value[1] == '1'){
					document.getElementById("check_print_form").reset();
					$("#name_preview").html('');
					$("#amount_preview").html('');
					$("#description_preview").html('');
					$("#date_preview").html('');
					return check_print_modal(value[2]);
				}else{
					$("#check_print_message").html(value[0])
				}
			}
		});
		return false;
	})
	$("#name").on("keyup",function(){
		var name = $(this).val();
		$("#name_preview").html(name);
	})
	$("#amount").on("keyup",function(){
		var amount = $(this).val();
		$("#description").val(numberToWords(amount));
		$("#description_preview").html(numberToWords(amount));
		$("#amount_preview").html(amount + '/=');
	})
	$("#date").on("keyup Keydown focusout change",function(){
		var date = $(this).val();
		var formet_date = date.split('-');
		var priview = formet_date[2] + formet_date[1] + formet_date[0];
		$("#date_preview").html(priview);
	})
})
function numberToWords(number){  
	var digit = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];  
	var elevenSeries = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];  
	var countingByTens = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];  
	var shortScale = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];  
	number = number.toString();
	number = number.replace(/[\, ]/g, '');
	if (number != parseFloat(number)){
		return 'Not A Number!';
	} 
	var x = number.indexOf('.'); 
	if (x == -1){
		x = number.length;
	} 
	if (x > 15){
		return 'Too Big!'; 
	}
	var n = number.split(''); 
	var str = ''; 
	var sk = 0; 
	for (var i = 0; i < x; i++) { 
		if ((x - i) % 3 == 2) { 
			if (n[i] == '1') { 
				str += elevenSeries[Number(n[i + 1])] + ' '; 
				i++; sk = 1; 
			} else if (n[i] != 0) { 
				str += countingByTens[n[i] - 2] + ' '; 
				sk = 1; 
			}
		} else if (n[i] != 0) { 
			str += digit[n[i]] + ' '; 
			if ((x - i) % 3 == 0) str += 'Hundred '; sk = 1; 
		} 
		if ((x - i) % 3 == 1) { 
			if (sk) str += shortScale[(x - i - 1) / 3] + ' '; sk = 0; 
		} 
	} 
	if (x != number.length) { 
		var y = number.length; 
		str += 'point '; 
		for (var i = x + 1; i < y; i++){ 
			str += digit[n[i]] + ' '; 
		}
	} 
	str = str.replace(/\number+/g, ' '); 
	return str.trim() + " Taka Only.";  
}

$("#date_filter").on("change",function(){
	return booking_report_table();
})
$("#card_invoice_no").on("keyup keyown focusout",function(){
	var check_card = $("#card_invoice_no").val();
	if(check_card != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_submit/check_old_member_card.php'); ?>",  
			method:"POST",  
			data:{check_card:check_card},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				if(data == 1){
					$('button[name="save"]').prop('disabled', true);
					$("#card_number_check_note").html('NOTE: Card Number Not Allow Here! If you want to print Chequee for refund deposit, <a href="<?php echo base_url("admin/accounting/transaction/checkout-member-list"); ?>">click here</a>');
				}else{
					$('button[name="save"]').prop('disabled', false);
					$("#card_number_check_note").html('');
				}
			}  
		});  
	}
	booking_report_table();
})
function booking_report_table(){
	var report_info = '&card_invoice_no='+$("#card_invoice_no").val()+'&date_filter='+$("#date_filter").val();
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/print_check_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}


$(document).ready(function() {
	var report_info = '&card_invoice_no='+$("#card_invoice_no").val()+'&date_filter='+$("#date_filter").val();
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/print_check_datatable.php'+condition;
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		scrollY: false,
		scrollX: true,
		
		/* columnDefs: [
		  { visible: false, targets: 1 }
		], */

		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/print_check_datatable.php"+condition,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            }
        ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>