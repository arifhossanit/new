<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">View Instant Transaction (Buy Something)</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
				<li class="breadcrumb-item active">View Instant Transaction (Buy Something)</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	<div class="content">
		<div class="container-flud">
			<div class="row justify-content-center">				
				<div class="col-md-10">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title"><i class="far fa-bed"></i> View Instant Transaction (Buy Something)</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Short branch</label><small class="req"> *</small>
										<select id="branch_id" class="form-control select2" onchange="return filter_data_table()">
											<?php if($_SESSION['user_info']['department'] != '1806965207554226682'){ ?>
												<option value="1">All</option>
											<?php } ?>
											<?php
												if(!empty($branch)){
													foreach($branch as $row){
														echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
													}
												}
											?>	
										</select>
										
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date range:</label>
										<div class="input-group">
											<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="far fa-calendar-alt"></i>
											</span>
											</div>
											<input onchange="return filter_data_table()" id="date_range" type="text" class="form-control float-right date_range">
										</div>
									</div>
								</div>
								<div class="col-sm-6 align-self-center text-right create-slip-div" style="display: none;">
									<button type="button" onclick="submit_create_slip()" class="btn btn-success btn-sm"><i class="fas fa-check mr-1"></i>Create Slip</button>
								</div>
								<div class="col-md-12">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>Id</th>
												<th>Transaction ID</th>
												<th>Member</th>
												<th>Branch</th>
												<th>Recharge</th>
												<th>Amount</th>
												<th>Balance</th>
												<th>Note</th>
												<th>Added By</th>												
												<th>Date</th>
												<th>Option</th>
												<th>slip_id</th>
												<th>phone</th>
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
<!----vaiw model-->
	<div class="modal fade" id="view_buied_iteams">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title" style="font-size:23px;">Transaction Item</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="view_buied_iteams_result" style=""></div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<!----vaiw model-->
	<div class="modal fade" id="slip_modal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title" style="font-size:23px;">Expense Invoice</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="slip_details_div" style=""></div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<script>
let show_receipt = (slip_id) => {
	$.ajax({  
		url:"<?=base_url('assets/ajax/receipt/instant_transaction_details_information.php'); ?>",  
		method:"POST",  
		data: {slip_id},
		beforeSend:function(){					
			// $('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#slip_modal').modal('toggle');
			$('#slip_details_div').html(data);
		}
	});
}

let submit_create_slip = () => {
	var boxes = $('input[name="slip_id[]"]:checked');
	let serialize = boxes.serialize();
	console.log(serialize)
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_submit/report/instant_transaction_slip.php'); ?>",  
		method:"POST",  
		data:serialize,
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');
			let info = JSON.parse(data);
			if(info.error == '1'){
				alert(info.message);
			}else{
				$('#booking_data_table').DataTable().ajax.reload( null , false);
				show_receipt(info.message);
			}
		}
	});
}

let create_slip = () => {
	var boxes = $('input[name="slip_id[]"]:checked');
	if(boxes.length){
		$('.create-slip-div').show();
		return;
	}
	$('.create-slip-div').hide();
}

function filter_data_table(){
	var branch_id = $("#branch_id").val();
	var date_range = $("#date_range").val();	
    var condition = '?branch_id='+branch_id+'&date_range='+date_range+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/view_instant_transaction_buy_something_datatable.php"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
}
function view_buied_iteams(transaction_id){
	if(transaction_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/view_buied_iteams_options.php'); ?>",  
			method:"POST",  
			data:{ transaction_id:transaction_id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#view_buied_iteams_result').html(data);
				$('#view_buied_iteams').modal('show');
			}
		});  
	}
}
$(document).ready(function() {
	var branch_id = $("#branch_id").val();
    var condition = '?branch_id='+branch_id;
    var table_booking = $('#booking_data_table').DataTable({
		"paging": false,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		columnDefs: [
			{ targets: [11, 12], visible: false},
		],
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/view_instant_transaction_buy_something_datatable.php" + condition,
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