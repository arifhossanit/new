<style>
	.dataTables_info{
		display: none;
	}
</style>
<!-- Aggrement -->
<div class="modal fade" tabindex="-1" role="dialog" id="show_aggrements">
	<div class="modal-dialog modal-dialog-report modal-xl" role="document">
		<form action="template/visaSubmit.php" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Investment aggrement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="showAgentReportDiv">
					<style>#ipo_aggrement_table td{text-align:center;vertical-align: middle;}#ipo_aggrement_table th{text-align:center;vertical-align: middle;}</style>
					<table id="ipo_aggrement_table" class="table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
						<thead>
							<tr>
								<th>id</th>
								<th>Branch Name</th>
								<th>Investment Type</th>
								<th>Aggrement Type</th>
								<th>Comission</th>
								<th>Investment rate</th>
								<th>Validity</th>
								<th>Options</th>
							</tr>
						</thead>
						<tbody id="aggrement_table_body">	
						</tbody>
						<tfoot>
							<tr hidden>
								<th>id</th>
								<th>Branch Name</th>
								<th>Investment Type</th>
								<th>Aggrement Type</th>
								<th>Comission</th>
								<th>Investment rate</th>
								<th>Validity</th>
								<th>Options</th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- Exhange -->
<div class="modal fade exchange inner_modal" tabindex="-1" role="dialog" id="exchange_ipo">
	<div class="modal-dialog modal-dialog-report modal-lg" role="document">
		<form action="ipo-member/exchange-ipo" method="post" enctype="multipart/form-data" id="exchange_form">
			<input type="hidden" name="member_type" id="member_type">
			<input type="hidden" name="exchange_aggrement_id" id="exchange_aggrement_id">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Exchange Investment</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="exchange_close()">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="showAgentReportDiv">
					<div class="row"> <div class="col-sm text-danger"><p id="exchange_massage"></p></div></div>
					<div class="row justify-content-between">
						<div class="col-md-6">
							<p>From</p>
							<label for="name">Name</label>
							<input class="form-control" id="name" type="text" value="<?php echo $ipo_member_information->personal_full_name?>" readonly>
							<label for="card_number_from">Card Number</label>
							<input class="form-control" name="card_number_from" id="card_number_from" type="text" value="<?php echo $ipo_member_information->card_number?>" readonly>
						</div>
						<div class="col-md-6">
							<p>To</p>
							<label for="to_card_number">Card Number to Transfer</label>
							<input class="form-control" type="text" name="to_card_number" id="to_card_number" onchange="get_to_member_name(this.value)">
							<label for="to_name">Name of Member to Transfer</label>
							<input class="form-control" type="text" id="to_name" readonly>
						</div>
					</div>
					<div class="row justify-content-between">
						<div class="col-md-12">
							<label for="">Reason, Remarks</label>
							<textarea class="form-control" name="exchange_reason" id="exchange_reason" cols="30" rows="2" placeholder="Enter reason for exchange or leave any remarks"></textarea>
						</div>						
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-info"><span>Exchange </span><i class="fas fa-random"></i></button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="exchange_close()">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- Cancel -->
<div class="modal fade exchange inner_modal" tabindex="-1" role="dialog" id="cancel_ipo">
	<div class="modal-dialog modal-dialog-report modal-lg" role="document">
		<form action="ipo-member/cancel-ipo" method="post" enctype="multipart/form-data" id="cancel_form">
			<input type="hidden" name="cancel_aggrement_id" id="cancel_aggrement_id">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Cancel Investment</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="exchange_close()">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="showAgentReportDiv">
					<div class="row"> <div class="col-sm text-danger"><p id="exchange_massage"></p></div></div>
					<div class="row justify-content-between">
						<div class="col-md-6">
							<label for="name">Withdraw Date</label>
							<input class="form-control" name="withdraw_date" id="withdraw_date" type="date" required>
						</div>
					</div>
					<div class="row justify-content-between">
						<div class="col-md-12">
							<label for="">Reason, Remarks</label>
							<textarea class="form-control" name="cancel_reason" id="cancel_reason" cols="30" rows="2" placeholder="Enter reason for exchange or leave any remarks" required></textarea>
						</div>						
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-warning"><span>Confirm Cancel</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="exchange_close()">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="content-wrapper">		   
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="card mt-2">
						<div class="card-header">
							<h3 class="card-title">Investment Informations</h3>
						</div>
						<div class="card-body">
							<style>#ipo_member_table td{text-align:center;vertical-align: middle;}#ipo_member_table th{text-align:center;vertical-align: middle;}</style>
							<table id="ipo_member_table" class="table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
								<thead>
									<tr>
										<th>id</th>
										<th>Total Amount</th>
										<th>Paid Amount</th>
										<th>Payment Method</th>
										<th>Purchase Date</th>
										<th style="width:170px;">Option</th>
									</tr>
								</thead>
								<tbody>	
								</tbody>
								<tfoot>
									<tr hidden>
										<th>id</th>
										<th>Total Amount</th>
										<th>Paid Amount</th>
										<th>Payment Method</th>
										<th>Purchase Date</th>
										<th style="width:170px;">Option</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>	
	function exchange_id(exchange_id){
		$('#show_aggrements').hide();
		$('#exchange_aggrement_id').val(exchange_id);
	}
	function cancel_id(cancel_id){
		$('#show_aggrements').hide();
		$('#cancel_aggrement_id').val(cancel_id);
	}
	$('.inner_modal').on('hide.bs.modal', function () {
		$('#show_aggrements').show();
	})
	$('#exchange_form').on('submit', function(){
		if($('#to_card_number').val() === ''){
			$('#exchange_massage').html('Enter A Card');
			return false;
		}else if($('#to_name').val() === 'No Member Found'){
			$('#exchange_massage').html('Enter a valid card number');
			return false;
		}else if($('#to_card_number').val() === $('#card_number_from').val()){
			$('#exchange_massage').html('Cannot Exchange to Same Member');
			return false;
		}
	});
	function get_to_member_name(card_number){
		$.ajax({
			type: 'post',
			url: '<?=base_url('assets/ajax/ipo/get_ipo_to_member_name.php');?>',
			data: {card_number: card_number},
			success: function(response){
				let name = JSON.parse(response);
				$('#to_name').val(name.name);
			}
		});
	}

	function get_aggrement(purchaseCode){
		let ipo_id = '<?php echo $_SESSION['ipo_member_panel']['ipo_id']; ?>';
		if ( ! $.fn.DataTable.isDataTable( '#ipo_aggrement_table' ) ) {
			var table = $('#ipo_aggrement_table').DataTable({
				"paging": true,
				"lengthChange": true,
				"lengthMenu": [
					[10, 25, 50, 100, 500],
					[10, 25, 50, 100, 500]
				],
				"searching": true,
				"ordering": true,
				"order": [[ 1, "asc" ]],
				"info": true,
				"autoWidth": false,
				"responsive": true,
				"ScrollX": true,
				"processing": true,
				"serverSide": true,
				"ajax": { 
					"url": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_aggrement_datatable.php",
					"data": {purchaseCode: purchaseCode, ipo_id: ipo_id},
				}
			});
		}else{
			$('#ipo_aggrement_table').DataTable().clear().destroy();
			var table = $('#ipo_aggrement_table').DataTable({
				"paging": true,
				"lengthChange": true,
				"lengthMenu": [
					[10, 25, 50, 100, 500],
					[10, 25, 50, 100, 500]
				],
				"searching": true,
				"ordering": true,
				"order": [[ 1, "asc" ]],
				"info": true,
				"autoWidth": false,
				"responsive": true,
				"ScrollX": true,
				"processing": true,
				"serverSide": true,
				"ajax": { 
					"url": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_aggrement_datatable.php",
					"data": {purchaseCode: purchaseCode, ipo_id: ipo_id},
				}
			});
		}
	}	

	$(document).ready(function(){		
		$('#dashboard_nav').addClass('active');
		if(screen.width < 700){
			$('table').addClass('table-responsive');
		}
		var conditions = '?ipo_id=<?php echo $_SESSION['ipo_member_panel']['ipo_id'];?>';
		console.log(conditions);
		var table = $('#ipo_member_table').DataTable({
			"paging": true,
			"lengthChange": true,
			"lengthMenu": [
				[10, 25, 50, 100, 500],
				[10, 25, 50, 100, 500]
			],
			"searching": true,
			"ordering": true,
			"order": [[ 1, "asc" ]],
			"info": true,
			"autoWidth": false,
			"responsive": false,
			"ScrollX": true,
			"processing": true,
			"serverSide": true,
			"ajax": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_purchase_datatable.php"+conditions,
			// dom: 'lBfrtip',
			// buttons: [			
			// 	{
			// 		extend: 'copy',
			// 		text: '<i class="fas fa-copy"></i> Copy',
			// 		titleAttr: 'Copy',
			// 		exportOptions: {
			// 			columns: ':visible'
			// 		}
			// 	},
			// 	{
			// 		extend: 'excel',
			// 		text: '<i class="fas fa-file-excel"></i> Excel',
			// 		titleAttr: 'Excel',
			// 		exportOptions: {
			// 			columns: ':visible'
			// 		}
			// 	},
			// 	{
			// 		extend: 'csv',
			// 		text: '<i class="fas fa-file-csv"></i> CSV',
			// 		titleAttr: 'CSV',
			// 		exportOptions: {
			// 			columns: ':visible'
			// 		}
			// 	},
			// 	{
			// 		extend: 'pdf',
			// 		exportOptions: {
			// 			columns: ':visible'
			// 		},
			// 		orientation: 'landscape',
			// 		pageSize: "LEGAL",
			// 		text: '<i class="fas fa-file-pdf"></i> PDF',
			// 		titleAttr: 'PDF'
			// 	},
			// 	{
			// 		extend: 'print',
			// 		text: '<i class="fas fa-print"></i> Print',
			// 		titleAttr: 'Print',
			// 		exportOptions: {
			// 			columns: ':visible'
			// 		}
			// 	},
			// 	{
			// 		extend: 'colvis',
			// 		text: '<i class="fas fa-list"></i> Column Visibility',
			// 		titleAttr: 'Column Visibility'
			// 	}
			// ]
		});
		// table.buttons().container().appendTo($('#export_buttons'));
	});
</script>