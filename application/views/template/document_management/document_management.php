<style>
.btn-xs {
  padding: 6px;
  
}

</style>

<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Document management</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item"><a href="#">Request</a></li>
						<li class="breadcrumb-item active">Document management</li>
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
				<div class="col-sm-3">
					<div class="card card-info">
						<div class="card-header">
							<h4>Documents Add </h4>
						</div>
						<div class="card-body">
							<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Document Name</label>
										<input type="text" name="document_name" class="form-control" placeholder="Document Name" value="<?php if(!empty($edit)){ echo $edit->document_name; } ?>" autocomplete="off"  required />
										<span class="text-danger"><?php echo form_error('document_name');?> </span>
									</div>
									
									<div class="form-group">
										<label>Renew Date</label>
										<input type="date" name="renew_date" value="<?php if(!empty($edit)){ echo $edit->renew_date; } ?>"  placeholder="renew_date" class="form-control"  autocomplete="off" required />
										<span class="text-danger"><?php echo form_error('renew_date');?> </span>
									</div>
									
									<div class="form-group">
										<label>Expiration Date</label>
										<input type="date" name="expiration_date"  placeholder="expiration_date" class="form-control" value="<?php if(!empty($edit)){ echo $edit->expiration_date; } ?>" autocomplete="off" required />
										<span class="text-danger"><?php echo form_error('expiration_date');?> </span>
									</div>
									<?php if(!empty($edit)){  ?>								
									<div class="form-group">
										<label>Upload File</label>
										<input type="file" name="image_docs" class="form-control" />
										<span class="text-danger"><?php echo form_error('image_docs');?> </span>
									</div>
									<?php } else{  ?>	
									<div class="form-group">
										<label>Upload File</label>
										<input type="file" name="image_docs" class="form-control" required />
										<span class="text-danger"><?php echo form_error('image_docs');?> </span>
									</div>
									
									<?php }  ?>	
									<div class="form-group">
										<label>Note</label>
										<textarea name="note" class="form-control" placeholder="Note" id="note" required ><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
										<span class="text-danger"><?php echo form_error('note');?> </span>
									</div>
									
									<div class="form-group">
										<?php echo $button; ?>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-9">
					<div class="card card-info">
						<div class="card-header">
							<h4 style="width: 200px; float: left;">Documents</h4>
							<div id="export_buttons" style="float:right;"></div>
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Document</th>
										<th>Renew Date</th>
										<th>Expiration Date</th>
										<th>Image</th>
										<th>Note</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								
								<?php foreach($results as $result) { ?>									
									<tr>
										<td><?php echo $result->id;?></td>
										<td><?php echo $result->document_name; ?></td>
										<td><?php echo $result->renew_date; ?></td>
										<td><?php echo $result->expiration_date; ?></td>
										<td><img class="docs_img" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $result->id; ?>" width="50px"  src="<?php echo base_url("assets/uploads/documents/".$result->file_url); ?>" /></td>
										<td><?php echo $result->note; ?></td>
										<td class="d-flex">
											<form action="<?=current_url(); ?>" method="post">
												<input type="hidden" name="id" value="<?php echo $result->id; ?>">	
												<button  name="edit" value="edit" title="Renew" class="btn btn-xs btn-info"><i class="fas fa-upload"></i></button>
											</form>&nbsp;
											
											<a  data-toggle="modal" data-target="#exampleModal" class="btn btn-xs btn-success document_log"  data-id="<?php echo $result->id; ?>"><i class="fa fa-eye"></i></a>
											
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Document Logs.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="document_log">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="log_imgModal" tabindex="-1" aria-labelledby="log_imgModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="log_imgModalLabel">Document Logs Image.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="document_log_img">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable();	
});

$(document).on("click", ".document_log", function(){
	var doc_id = $(this).data("id");
	console.log(doc_id);
	$.ajax({  
		url:"<?=base_url('admin/hrm/document_log');?>",  
		method:"POST",  
		data:{doc_id:doc_id},
		dataType: "HTML",
		success:function(data){	
			console.log(data);
			$('#document_log').html(data);
		}
	});
});


$(document).on("click", ".docs_img", function(){
	var docs_img = $(this).data("id");
	console.log(docs_img);
	$.ajax({  
		url:"<?=base_url('admin/hrm/document_image');?>",  
		method:"POST",  
		data:{docs_img:docs_img},
		dataType: "HTML",
		success:function(data){	
			$('#document_log').html(data);
		}
	}); 
});

$(document).on("click", ".log_img", function(){
	var log_img = $(this).data("id");
	console.log(log_img);
	$.ajax({  
		url:"<?=base_url('admin/hrm/log_img');?>",  
		method:"POST",  
		data:{log_img:log_img},
		dataType: "HTML",
		success:function(data){	
			$('#document_log_img').html(data);
		}
	}); 
});


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>