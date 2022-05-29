
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Aproved Widthlist List</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
              <li class="breadcrumb-item active">Aproved Widthlist List</li>
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
									<a href="<?php echo base_url('admin/accounting/transaction/ipo-member-list'); ?>" class="btn btn-dark" style="margin-bottom:15px;float:right;">Back</a>
								</div>
							</div>
							
							<span id="data_send_success_message"></span>
							<div class="card card-dark">
								<div class="card-header">
									<h3 class="card-title">Aproved Widthlist Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>id</th>
												<th>Image</th>
												<th>Name</th>											
												<th>Phone Number</th>
												<th>Email</th>
												<th>Amount</th>
												<th>Receive Information</th>
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
	</div>
</div>
<!----vaiw member profile model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="sicuriey_deposit_submit" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="form_submit" value="form submit"/>
					<div class="modal-header btn-info">
						<h4 class="modal-title">Widthdraw Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">	
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<!--<div>
							<button type="submit" id="form_submit" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
						</div>-->
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw member profile model-->

<script>
function re_book_this_member(id){
	var member_id = id;
	if(member_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_submit/re_book_member_id_open_in_add_book.php'); ?>",  
			method:"POST",  
			data:{member_id:member_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				window.open(data,'_self');
			}
		});  
	}
}
var branch_id = "<?php echo base64_encode($_SESSION['super_admin']['branch']); ?>";
function view_member_profile(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/ipo/ipo_widthdraw_details_money_form.php');?>",  
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
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_aproved_widthdraw_list_datatable.php",
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
	table.buttons().container().appendTo($('#export_buttons'));
})
</script>