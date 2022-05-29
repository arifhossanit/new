<link rel="stylesheet" href="<?=base_url('assets/css/jquery-ui.css');?>">
<script src="<?=base_url('assets/js/jquery-ui.js');?>"></script>
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Designation</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Manage Designation</li>
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
		<div class="container-flud">
			<div class="row">
				<div class="col-sm-4">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Input Designation information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="form-group">
									<label>Designation Title</label>
									<input name="designation_name" value="<?php if(!empty($edit)){ echo $edit->designation_name; } ?>" type="text" class="form-control" placeholder="Role Title" required>
								</div>
								<div class="form-group">
									<label>Service Enable/Disable</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control" placeholder="Note"><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
								</div>

							</div>
							<div class="card-footer">
								<?php echo $button; ?>
							</div>
						</form>
					</div>
				</div>				
				
				<div class="col-sm-8">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Branch List</h3>
						</div>
						<div class="card-body">
							<table class="table table-sm" id="cexample2">
								<thead>
									<tr>
										<th></th>
										<th>Move</th>
										<th>Serial</th>
										<th>ID</th>
										<th>Designation</th>
										<th>Entry Date</th>
										<th>Status</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody id="page_list">
<?php 
if(!empty($table)){
	foreach($table as $row){
?>								
									<tr id="<?=$row->id;?>">
										<td><input type="checkbox" value="<?=$row->id;?>" /></td>
										<td style="cursor:move;background-color:#eee;"><i class="fa fa-sort"></i></td>
										<td><?=$row->serial;?></td>
										<td><?=$row->id;?></td>
										<td><?=$row->designation_name;?></td>
										<td><?=$row->data;?></td>
										<td>
											<?php if($row->status == '1'){ ?>
												<button class="btn btn-sm btn-success">Active</button>
											<?php }else{ ?>
												<button class="btn btn-sm btn-danger">Deactive</button>
											<?php } ?>
										</td>
										<td>
											<form action="<?=current_url(); ?>" method="post">
												<input type="hidden" value="<?=$row->id;?>" name="hidden_id"/>
												<button name="edit" type="submit" class="btn btn-sm btn-success">Edit</button>
												<?php /* ?><button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-sm btn-danger">Delete</button><?php */ ?>
											</form>
										</td>
									</tr>
<?php } } ?>									
								</tbody>
							</table>
							<input type="hidden" name="page_order_list" id="page_order_list" />
							<div align="left" style="margin-bottom:10px;">
								<button type="button" id="select" class="btn btn-xs btn-warning" style="margin-left:15px;"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
								<button type="button" id="unselect" class="btn btn-xs btn-success"><i class="fa fa-bars" aria-hidden="true"></i></button>
								<button type="button" id="btn_delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
							</div>
						</div>					
					</div>
				</div>
	

			</div>
		</div>
	</div>
</div>
<style>
	#page_list tr {
		background-color:#f9f9f9;
	}
	#page_list tr.ui-state-highlight {
		background-color:#ffffcc;
	}
  </style>
<script>
$(document).ready(function(){ 
	$( "#page_list" ).sortable({
		placeholder	: "ui-state-highlight",
		update		: function(event, ui)
		{
			var page_id_array = new Array();
			$('#page_list tr').each(function(){
				page_id_array.push($(this).attr("id"));
			});
			$.ajax({
				url:"<?php echo base_url(); ?>/assets/ajax/option_select/short_designation_order_list_option_select.php",
				method:"POST",
				data:{page_id_array:page_id_array},
				success:function(data){
					alert(data);
					window.open('<?php echo current_url(); ?>','_self');
				}
			});
		}
	});
	$("#select").click(function(){
			$('input:checkbox').prop('checked',true);     
	});
	$("#unselect").click(function(){
			$('input:checkbox').prop('checked',false);     
	});
	$('#btn_delete').click(function(){  
		if(confirm("Are you sure you want to delete selected Iteam?")){
			var id = [];   
			$(':checkbox:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					 url:'<?= current_url(); ?>',
					 method:'POST',
					 data:{delete_id:id},
					 success:function() {
						window.open('<?= current_url(); ?>','_self');
					}     
				});
			}   
		} else {
			return false;
		}
	});
 
});
</script>