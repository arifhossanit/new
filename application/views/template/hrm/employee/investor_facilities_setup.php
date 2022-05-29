
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Investor Facilities Setup</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Create</a></li>
              <li class="breadcrumb-item"><a href="#">Award</a></li>
              <li class="breadcrumb-item active">Sales Award</li>
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
							<h3 class="card-title">Investor Facilities Setup</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Card Number</label>
											<input name="card_no" value="<?php if(!empty($edit)){ echo $edit->card_no; } ?>" type="number" min="0" class="number_int form-control" required>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Tea/Coffee</label>
											<input name="tea_coffee" value="<?php if(!empty($edit)){ echo $edit->tea_coffee; } ?>" type="number" min="0" class="number_int form-control" required>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Drinks</label>
											<input name="drinks" value="<?php if(!empty($edit)){ echo $edit->drinks; } ?>" type="number" min="0" class="number_int form-control" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label>Service Enable/Disable</label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
									</div>
								</div>								
							</div>
							<div class="card-footer">
								<?php echo $button; ?>
							</div>
						</form>
					</div>
				</div>	
				<div class="col-sm-8">
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Investor Facilities</h3>
						</div>
						<div class="card-body">
							<table class="table text-center">
								<thead>
									<tr>
										<th>Investor Name</th>
										<th>Card No</th>
										<th>Tea/Coffee</th>
										<th>Drinks</th>
										<th>Status</th>
										<th>Uploader</th>
										<th>Options</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($investor_infos as $investor_info){ ?>
										<tr>
											<td><?php echo $investor_info->personal_full_name; ?></td>
											<td><?php echo $investor_info->card_no; ?></td>
											<td><?php echo $investor_info->tea_coffee; ?></td>
											<td><?php echo $investor_info->drinks; ?></td>
											<td><?php echo $investor_info->uploader_name; ?></td>
											<td><?php echo ( $investor_info->status == '1') ? '<p class="badge badge-primary mb-0">Active</p>' : '<p class="badge badge-danger mb-0">Inactive</p>'; ?></td>
											<form action="<?=base_url()?>admin/create/award/investor_facilities_setup" method="post">
												<input type="hidden" name="card_number_edit" value="<?php echo $investor_info->card_no; ?>">	
												<td><button name="edit" value="edit" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button></td>
											</form>
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