<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Old Member Directory</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Front Office</a></li>
              <li class="breadcrumb-item active">Old Member Directory</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<form id="old_member_insert" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
					<div class="col-sm-12" style="border:solid 1px #e3e3e3;margin-bottom:25px;background-color:#fff;border-radius:5px;padding-top:15px;padding-bottom:15px;">
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">
									<label>Full Name</label>
									<input type="text" name="full_name" autocomplete="off" class="form-control" required/>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>phone number</label>
									<input type="text" name="phone_number" placeholder="Ex: 01XXXXXXXXX" autocomplete="off" pattern=".{11,11}" title="Minimum 11 to Maximum 11 Numaric Character Required" minlength="11" maxlength="11" class="number_int form-control" required/>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Status</label>
									<select name="status" class="form-control select2" required>
										<option value="">--select--</option>
										<option value="1">Active</option>
										<option value="0">Deactive</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Card Number</label>
									<input type="text" name="card_number" autocomplete="off" class="number_int form-control" required/>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>CheckIn Date</label>
									<input type="date" name="checkin_date" autocomplete="off" class="form-control" required/>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<button id="insert_old_member" name="insert_old_member" type="submit" class="btn btn-success" style="width:100%;margin-top:32px;">Insert</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-12">
				<div class="card card-success">
					<div class="card-header">
						Old Member Directory
						<div id="export_buttons" style="float: right;"></div>
					</div>
					<div class="card-body">
						<table class="table table-sm" id="booking_data_table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Phone Number</th>
									<th>Status</th>
									<th>Card Number</th>
									<th>CheckIn</th>
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
<script>
$(document).ready(function() {
	$("#old_member_insert").on("submit",function(){
		event.preventDefault();
		var form = $('#old_member_insert')[0];
		var data = new FormData(form);			
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/insert_old_member_to_database.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#insert_old_member").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$("#insert_old_member").prop("disabled", false);
				$('#old_member_insertold_member_insert')[0].reset();
				alert(data);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
			}
		});
		return false;
	})
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500, 1000],
			[10, 25, 50, 100, 500, 1000]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/old_member_information_datatable.php",
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>