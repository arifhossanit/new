
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Employee widrawral List</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
              <li class="breadcrumb-item active">Employee widrawral List</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
<?php
if(!empty($edit)){
	$button = '
		<button type="submit" name="update" class="btn btn-warning">Update</button>
		<a href="'.current_url().'" class="btn btn-danger">Close</a>
	';
}else{
	$button = '<button type="submit" name="save" class="btn btn-primary">Save</button>';
}
?>	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12">
									<a href="<?php echo base_url('admin/accounting/transaction/employee-approved-widdraw-list'); ?>" class="btn btn-info" style="margin-bottom:15px;float:right;">Approved Widthdraw List</a>
								</div>
							</div>
							<span id="data_send_success_message"></span>
							<div class="card card-info">
								<div class="card-header">
									<h3 class="card-title">Employee widrawral Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
										<thead>
											<tr>
												<th>Id</th>
												<th>Employee ID</th>
												<th>Request amount</th>
												<th>Note</th>												
												<th>Request Date</th>												
												<th>Status</th>												
												<th style="width: 125.2px;">Option</th>
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
<!----vaiw member profile model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="sicuriey_deposit_submit" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="form_submit" value="form submit"/>
					<div class="modal-header btn-info">
						<h4 class="modal-title">Widthdraw Request Submit Form</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">	
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="submit" id="form_submit" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw member profile model-->
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
<script>
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
$('document').ready(function(){
	$("#sicuriey_deposit_submit").on("submit",function(){
		event.preventDefault();
		var form = $('#sicuriey_deposit_submit')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/accounting/employee_widthdraw_request_submit_form_account.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#form_submit").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$("#form_submit").prop("disabled", false);
				var value = data.split('_____');
				$("#member_prifile_model").modal('hide');
				$("#data_send_success_message").html(value[0]);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
				if(value[2] != '' && value[2] > 0){
					return check_print_modal(value[2]);
				}
				
			}
		});
		return false;
	})
})

var branch_id = "<?php echo base64_encode($_SESSION['super_admin']['branch']); ?>";
function view_member_profile(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/accounting/return_widthdraw_money_form.php');?>",  
			method:"POST",  
			data:{profile_id:profile_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result').html(data); 
				$('#member_prifile_model').modal('show');
			}  
		});  
	}
}
$(document).ready(function() {
	var table = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"ScrollX": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/accounting_employee_widthdraw_member_list_datatable.php",
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table.buttons().container().appendTo($('#export_buttons'));
})
</script>