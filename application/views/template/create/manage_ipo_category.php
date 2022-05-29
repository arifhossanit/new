
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage IPO Category</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Manage IPO Category</li>
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
} else {
	$button = '<button type="submit" name="save" class="btn btn-primary">Save</button>';
}
?>	
	<div class="content">
		<div class="container-flud">
			<div class="row">
				<div class="col-sm-4">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Input IPO Category information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<?php if(!empty($edit)){ ?>								
								<div class="form-group">
									<label>Select Branch</label>
									<select name="branch_id" id="branch_id" class="form-control select2" required>
										<option value="">--choose one--</option>
										<?php
											if(!empty($banches)){
												foreach($banches as $row){
													if(!empty($edit) AND $edit->branch_id == $row->branch_id){
														$selected = 'selected';
													}else{
														$selected = '';
													}
													echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
												}
											}
										?>				
									</select>
								</div>
								<?php } else{ ?>
								<div class="form-group">
									<label>Select Branch</label>
									<select name="branch_id[]" multiple="multiple" id="branch_id" class="form-control select2" required>
										<option value="">--choose one--</option>
										<?php
											if(!empty($banches)){
												foreach($banches as $row){
													if(!empty($edit) AND $edit->branch_id == $row->branch_id){
														$selected = 'selected';
													}else{
														$selected = '';
													}
													echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
												}
											}
										?>				
									</select>
								</div>
								<?php } ?>
								
								<div class="form-group">
									<label>IPO Category Name</label>
									<input name="category_name" value="<?php if(!empty($edit)){ echo $edit->category_name; } ?>" type="text" class="form-control" placeholder="IPO Category Name" required>
								</div>
								<div class="form-group">
									<label>IPO Rate</label>
									<input name="ipo_rate" value="<?php if(!empty($edit)){ echo $edit->price; } ?>" type="text" class="form-control" placeholder="IPO Rate" required>
								</div>
								
								<div class="form-group">
									<label>IPO Profit <small style="color:#f00;">(In %)</small></label>
									<input name="ipo_profit" value="<?php if(!empty($edit)){ echo $edit->ipo_profit; } ?>" type="text" class="form-control" placeholder="IPO Profit" required>
								</div>
								<hr />
								<div class="row">
									<div class="col-sm-6">
										<h4>Referal Discount</h4>
										<div class="form-group">
											<label>First Month</label>
											<input name="ipo_discount_first_month" value="<?php if(!empty($edit)){ echo $edit->referal_first_month; } ?>" type="text" class="form-control" placeholder="IPO Discount First Month" required>
										</div>
										<div class="form-group">
											<label>Second Month</label>
											<input name="ipo_discount_secont_month" value="<?php if(!empty($edit)){ echo $edit->referal_second_month; } ?>" type="text" class="form-control" placeholder="IPO Discount Second Month" required>
										</div>
										<div class="form-group">
											<label>Third Month</label>
											<input name="ipo_discount_third_month" value="<?php if(!empty($edit)){ echo $edit->referal_third_month; } ?>" type="text" class="form-control" placeholder="IPO Commission Third Month" required>
										</div>
									</div>
									<div class="col-sm-6">
										<h4>Referal Profit</h4>
										<div class="form-group">
											<label>First Month</label>
											<input name="referal_profit_first_month" value="<?php if(!empty($edit)){ echo $edit->profit_first_month; } ?>" type="text" class="form-control" placeholder="IPO Profit First Month" required>
										</div>
										<div class="form-group">
											<label>Second Month</label>
											<input name="referal_profit_second_month" value="<?php if(!empty($edit)){ echo $edit->profit_second_month; } ?>" type="text" class="form-control" placeholder="IPO Profit Second Month" required>
										</div>
										<div class="form-group">
											<label>Third Month</label>
											<input name="referal_profit_third_month" value="<?php if(!empty($edit)){ echo $edit->profit_third_month; } ?>" type="text" class="form-control" placeholder="IPO Profit Third Month" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<?php if(!empty($edit)){ ?>
											<img src="<?php echo base_url($edit->image_one); ?>" style="width:100%;"/>
										<?php 
											$required_image_one = '';
										}else{
											$required_image_one = 'required';
										} 
										?>
										<div class="form-group">
											<label>Image 1</label>
											<input type="file" name="image_one" class="form-control" style="padding-top:3px;padding-left:3px;" <?php echo $required_image_one; ?> />
										</div>
									</div>
									<div class="col-sm-4">
										<?php if(!empty($edit)){ ?>
											<img src="<?php echo base_url($edit->image_two); ?>" style="width:100%;"/>
										<?php 
											$required_image_two = '';
										}else{
											$required_image_two = 'required';
										} 
										?>
										<div class="form-group">
											<label>Image 2</label>
											<input type="file" name="image_two" class="form-control" style="padding-top:3px;padding-left:3px;" <?php echo $required_image_two; ?> />
										</div>
									</div>
									<div class="col-sm-4">
										<?php if(!empty($edit)){ ?>
											<img src="<?php echo base_url($edit->image_three); ?>" style="width:100%;"/>
										<?php 
											$required_image_three = '';
										}else{
											$required_image_three = 'required';
										} 
										?>
										<div class="form-group">
											<label>Image 3</label>
											<input type="file" name="image_three" class="form-control" style="padding-top:3px;padding-left:3px;" <?php echo $required_image_three; ?> />
										</div>
									</div>
								</div>
								
								
								<div class="form-group">
									<label>package Enable/Disable</label>
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
							<h3 class="card-title">Category List</h3>
						</div>
						<div class="card-body">
							<table class="table table-sm" id="example2">
								<thead>
									<tr>
										<th>ID</th>
										<th>Branch</th>
										<th>Category</th>
										<th>Rate</th>
										<th>Profit</th>
										<th>Entry Date</th>
										<th>Status</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody>
<?php 
if(!empty($table)){
	foreach($table as $row){
?>								
									<tr>
										<td><?=$row->id;?></td>
										<td><?=$row->branch_name;?></td>
										<td><?=$row->category_name;?></td>
										<td><?=money($row->price);?></td>
										<td><?=$row->ipo_profit;?>%</td>
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
												<button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-sm btn-danger">Delete</button>
											</form>
										</td>
									</tr>
<?php } } ?>									
								</tbody>
							</table>
						</div>					
					</div>
				</div>
	

			</div>
		</div>
	</div>
</div>