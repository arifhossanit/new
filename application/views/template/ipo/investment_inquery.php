<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Investment Inquery</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Investment Inquery</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">					
					<div class="row">
						<div class="col-sm-12" style="margin-bottom:20px;">							
							<button type="button" onclick="window.open('<?php echo base_url(); ?>admin/ipo','_self')" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="fas fa-fast-backward"></i> &nbsp;&nbsp;Back</button>
						</div>
						<div class="col-sm-12">
							<div class="card card-dark">
								<div class="card-header">
									<h3 class="card-title">Investment Inquery</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
										<thead>
											<tr>
												<th class="text-center">ID</th>
												<th class="text-center">Full Name</th>
												<th class="text-center">Phone Number</th>
												<th class="text-center">E-mail Address</th>
												<th class="text-center">Note</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>	
											<?php foreach($inqueries as $inquery) { ?> 
											<tr>
												<td class="text-center"><?php echo $inquery->id; ?></td>
												<td class="text-center"><?php echo $inquery->full_name; ?></td>
												<td class="text-center"><?php echo $inquery->phone; ?></td>
												<td class="text-center"><?php echo $inquery->email; ?></td>
												<td class="text-center"><?php echo $inquery->note; ?></td>
												<td class="text-center">
													<a href="#"  class="btn btn-sm btn-primary add_note" data-toggle="modal" data-target="#exampleModal" data-inquery_id="<?php echo $inquery->id; ?>">Add Note</a>
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
	</div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Please add a note</h5><br/>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?=base_url("admin/ipo/investment_inquery_note"); ?>">
			<input type="hidden" name="inquery_id" id="inquery_id" value="">
			<div class="form-group">
				<label for="message-text" class="col-form-label">Note:</label>
				<textarea class="form-control" id="message-text" name="note" required></textarea>
			</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<script>
 $(document).ready(function(){ 
	$('#booking_data_table').DataTable();
	
	$(document).on('click', '.add_note', function(e){
          e.preventDefault();
          var id = $(this).data('inquery_id');
		  $("#inquery_id").val(id);
		  
    });
	
	$(document).on('click', '.delete_category', function(e){
          //alert("tets");
          e.preventDefault();
          var id = $(this).data('id');
		   $.ajax({
				url: "<?=base_url('admin/create/complain/complain-category'); ?>",
				type:"post",
				data:{'delete_id':id},
				dataType:"html",
				success:function(data) {
				  window.location.reload();
				},
					
		}); 
      });
 
 });
</script>


