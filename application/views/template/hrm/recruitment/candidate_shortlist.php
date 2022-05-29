<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Candidate ShortList</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Recruitment</a></li>
						<li class="breadcrumb-item active">Candidate ShortList</li>
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
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Candidate ShortList visitor book</h3>
							<div id="export_buttons_due" style="float: right;"></div>
						</div>
						<div class="card-body">
							<span id="message_from_server"></span>
							<style>#due_data_table td{text-align:center;vertical-align: middle;}#due_data_table th{text-align:center;vertical-align: middle;}</style>
							<table id="candidate_list" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Phone</th>
										<th>Department</th>
										<th>Designation</th>
										<th>Mark</th>
										<th>Selection Date</th>
										<th style="min-width:280px;max-width:280px;width:280px;s">Option</th>
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
<style>
.star_list{
	margin:0px;
	padding:0px;
	list-style:none;
}
.star_list li{
	float:left;
	margin-right:4px;
	background-color:#fd7e14;
	color:#fff;
	padding-left:2px;
	padding-right:2px;
	border-radius:5px;
}
</style>
<script>
function accept_function(accept_ids){
	var accept_id = accept_ids;
	event.preventDefault();
	var form = $('form[name="candiadate_form_'+accept_id+'"]')[0];
	var data = new FormData(form);
	if($('form[name="candiadate_form_'+accept_id+'"] input:radio[name=star_mark]').is(':checked')){		
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/today_candidate_accept_submit_list.php');?>",  
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
				$('#candidate_list').DataTable().ajax.reload( null , false);
				$('#message_from_server').fadeIn();
				$("#message_from_server").html(data);
				$('#message_from_server').delay(1500).fadeOut();
			}
		});
	}else{ 
		$("#message_from_server").html('<p style="color:#f00;margin: 0px; position: absolute;">Please select at list one option!</p>');
	}	
}
$('document').ready(function(){
	var table = $('#candidate_list').DataTable({
		"paging": false,
		"lengthChange": false,
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/recruitment/candidate_shortlist_datatable_data.php",
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