<style>


</style>
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Anniversary Award</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">List</a></li>
              <li class="breadcrumb-item"><a href="#">Anniversary</a></li>
              <li class="breadcrumb-item active">Anniversary Award</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container-flud">
			<div class="row">
				<div class="col-sm-10 offset-sm-1">
					<div class="card card-info">
						<div class="card-header">
						<!--
						<div class="col-sm-2">
							<div class="form-group" style="margin:0px;">
								<select onchange="return booking_report_table();" class="form-control select2" id="branch_id_hrad">
									<?php
									if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
										echo '<option value="1">All Branches</option>';
									}
									if(!empty($banches)){
										foreach($banches as $row){
											echo '<option value="'.rahat_encode($row->branch_id).'">'.$row->branch_name.'</option>';
										}
									}													
									?>
								</select>
							</div>
						</div>
						-->
						
						<!--
							<h3 class="card-title">Anniversary Award </h3>
						-->
						</div>
						<div class="card-body">
							<div class="col-md-2">
								<div class="form-group">
									<label>Select Date</label>
									<div class="input-group">
										<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="far fa-calendar-alt"></i>
										</span>
										</div>
										<input  id="date_range" type="text" class="form-control float-right date_range">
									</div>
								</div>
							</div>
							<div id='counting'></div>
							
							<div class="tab-content" id="complain_tabContent">
							<table class="table text-center display table-sm table-bordered table-striped" id="anniversary">
								<thead>
									<tr>
										<th>Id</th>
										<th>Anniversary Date</th>
									    <th>Action</th>
									</tr>
								</thead>
								
								<tbody>
								
									<?php foreach($results as $key=>$single){ ?>
										<tr >
											 <td><?php echo $key+1; ?></td>
											 
											 <td><?php echo $single->ANYVERSARY_DATE; ?></td>
											<td>
												<a href="#" data-anniversary_date="<?php echo $single->ANYVERSARY_DATE; ?>" class="btn btn-sm btn-warning anniversary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye"></i></a>
												
											</td>
										</tr>
									<?php } ?>
									
								
								</tbody>	
							</table>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Anniversary details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body " id="anniversary_item">
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>


<!----vaiw member profile model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Member Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">	
						
						
						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="button" id="select_bed" class="btn btn-warning"><i class="fas fa-save"></i> Select</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw member profile model-->


<script>

	
  $(document).ready(function(){
	  
	  
	/* $(document).on('change', ".date_range", function(e){
		e.preventDefault();
		
		var date_range = $("#date_range").val();
		$.ajax({
			url: "<?php echo base_url("admin/anniversary_date_range"); ?>",
			method: "POST",
			dataType: "JSON",
			data: {"date_range": date_range},
			success: function(data){
				
			}
			
		})
	 }); */
	 
	//datatable first load.
	
	  
 	$('#anniversary').DataTable({
		
		/* "processing": true,
        "serverSide": true,
        "ajax": "<?= base_url(); ?>assets/ajax/data_table/anniversary/anniversary_datatable.php" */
		
	});
	
	$(document).on('click', ".anniversary", function(e){
		e.preventDefault();
		var anniversary_date = $(this).data("anniversary_date");
		$.ajax({
			url: "<?php echo base_url("admin/anyversary_date"); ?>",
			method: "POST",
			dataType: "HTML",
			data: {"anniversary_date": anniversary_date},
			success: function(data){
				$("#anniversary_item").html(data);
			}
			
		})
	});
	
	
	
	
	$(document).on('click', ".member_profile", function(e){
		e.preventDefault();
		var member_id = $(this).data("member_id");
		
		$.ajax({  
			url:"<?=base_url('assets/ajax/member_profile_information.php');?>",  
			method:"POST",  
			data:{profile_id:member_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result').html(data); 
				$('#member_prifile_model').modal('show');   
			}  
		});
	});
	
	
	
	
	
	
} );
</script>
