<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Member Login Activity</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Report</a></li>
						<li class="breadcrumb-item"><a href="#">Tracing Report</a></li>
						<li class="breadcrumb-item active">Member Login Activity</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	<div class="content">
		<div class="container-fluid">
			<div class="row">			
				<div class="col-sm-12">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Member Login Activity</h3>
							<div id="export_buttons_due" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#due_data_table td{text-align:center;vertical-align: middle;}#due_data_table th{text-align:center;vertical-align: middle;}</style>
							<table id="candidate_list" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
								<thead>
									<tr>
										<th>ID</th>
										<th>Member Name</th>
										<th>Type</th>										
										<th>Time</th>
										<th>IP_Address</th>
										<th>Date</th>
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
		</div>
	</div>
</div>
<!----vaiw model-->
	<div class="modal fade" id="sms_model_details">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">View Info</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="sms_result_details">					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<script>
function view_data(view_id){				
	if(view_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/view_member_login_information.php');?>",  
			method:"POST",  
			data:{view_id:view_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');				
				$('#sms_result_details').html(data);  
				$('#sms_model_details').modal('show');  
			}
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}	
}
$('document').ready(function(){
	var table = $('#candidate_list').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[25, 50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/tracing_report/tracing_report_all_member_login.php",
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
	table.buttons().container().appendTo($('#export_buttons_due'));
})
</script>