
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Sales Award</h1>
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
<style>
.seals_award_form label{
	font-size:14px;
}
.seals_award_form .bootstrap-switch-label{
	background:#fff;
}
</style>
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Sales Award</h3>
						</div>
						<form role="form" class="seals_award_form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-1"  style="background: #e4d1f6;">
										<div class="row">
											<div class="col-sm-12">
												<center><h4 style="text-decoration:underline;">Option</h4></center>
											</div>											
										</div>
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label style="margin-bottom: 12px;">ON/Off</label>
													<input type="checkbox" name="_1st_price" <?php if(!empty($edit)){ if($edit->_1st_price == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label style="margin-bottom: 12px;margin-top: 7px;">ON/Off</label>
													<input type="checkbox" name="_2nd_price" <?php if(!empty($edit)){ if($edit->_2nd_price == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label style="margin-bottom: 12px;margin-top: 7px;">ON/Off</label>
													<input type="checkbox" name="_3rd_price" <?php if(!empty($edit)){ if($edit->_3rd_price == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label style="margin-bottom: 12px;margin-top: 7px;">ON/Off</label>
													<input type="checkbox" name="_4th_price" <?php if(!empty($edit)){ if($edit->_4th_price == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label style="margin-bottom: 12px;margin-top: 7px;">ON/Off</label>
													<input type="checkbox" name="_5th_price" <?php if(!empty($edit)){ if($edit->_5th_price == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-11">
										<div class="row">
											<div class="col-sm-4" style="background: #d1f6d1;">
												<div class="row">
													<div class="col-sm-12">
														<center><h4 style="text-decoration:underline;">Days Configuration</h4></center>
													</div>											
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>1st Day Amount</label>
															<input name="last_day_price" value="<?php if(!empty($edit)){ echo $edit->last_day_price; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>1st Day Point Limit</label>
															<input name="last_day_point_limit" value="<?php if(!empty($edit)){ echo $edit->last_day_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>2nd Day Amount</label>
															<input name="second_last_day" value="<?php if(!empty($edit)){ echo $edit->second_last_day; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>2nd Day Point Limit</label>
															<input name="second_last_day_point_limit" value="<?php if(!empty($edit)){ echo $edit->second_last_day_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>3rd Day Amount</label>
															<input name="thired_last_day" value="<?php if(!empty($edit)){ echo $edit->thired_last_day; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>3rd Day Point Limit</label>
															<input name="thired_last_day_point_limit" value="<?php if(!empty($edit)){ echo $edit->thired_last_day_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>4th Day Amount</label>
															<input name="forth_last_day" value="<?php if(!empty($edit)){ echo $edit->forth_last_day; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>4th Day Point Limit</label>
															<input name="forth_last_day_point_limit" value="<?php if(!empty($edit)){ echo $edit->forth_last_day_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>5th Day Amount</label>
															<input name="fifth_last_day" value="<?php if(!empty($edit)){ echo $edit->fifth_last_day; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>5th Day Point Limit</label>
															<input name="fifth_last_day_point_limit" value="<?php if(!empty($edit)){ echo $edit->fifth_last_day_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
											</div>
											<div class="col-sm-4" style="background: #f6ecd1;">
												<div class="row">
													<div class="col-sm-12">
														<center><h4 style="text-decoration:underline;">Week Configuration</h4></center>
													</div>											
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>1st Week Amount</label>
															<input name="last_week_price" value="<?php if(!empty($edit)){ echo $edit->last_week_price; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>1st Week Point Limit</label>
															<input name="last_week_point_limit" value="<?php if(!empty($edit)){ echo $edit->last_week_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>2nd Week Amount</label>
															<input name="second_last_week" value="<?php if(!empty($edit)){ echo $edit->second_last_week; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>2nd Week Point Limit</label>
															<input name="second_last_week_point_limit" value="<?php if(!empty($edit)){ echo $edit->second_last_week_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>3rd Week Amount</label>
															<input name="thired_last_week" value="<?php if(!empty($edit)){ echo $edit->thired_last_week; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>3rd Week Point Limit</label>
															<input name="thired_last_week_point_limit" value="<?php if(!empty($edit)){ echo $edit->thired_last_week_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>4th Week Amount</label>
															<input name="forth_last_week" value="<?php if(!empty($edit)){ echo $edit->forth_last_week; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>4th Week Point Limit</label>
															<input name="forth_last_week_point_limit" value="<?php if(!empty($edit)){ echo $edit->forth_last_week_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>5th Week Amount</label>
															<input name="fifth_last_week" value="<?php if(!empty($edit)){ echo $edit->fifth_last_week; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>5th Week Point Limit</label>
															<input name="fifth_last_week_point_limit" value="<?php if(!empty($edit)){ echo $edit->fifth_last_week_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
											</div>
											
											<div class="col-sm-4" style="background:#d1f6f6;">
												<div class="row">
													<div class="col-sm-12">
														<center><h4 style="text-decoration:underline;">Month Configuration</h4></center>
													</div>											
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>1st Month Amount</label>
															<input name="last_month_price" value="<?php if(!empty($edit)){ echo $edit->last_month_price; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>1st Month Point Limit</label>
															<input name="last_month_point_limit" value="<?php if(!empty($edit)){ echo $edit->last_month_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>2nd Month Amount</label>
															<input name="second_last_month" value="<?php if(!empty($edit)){ echo $edit->second_last_month; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>2nd Month Point Limit</label>
															<input name="second_last_month_point_limit" value="<?php if(!empty($edit)){ echo $edit->second_last_month_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>3rd Month Amount</label>
															<input name="thired_last_month" value="<?php if(!empty($edit)){ echo $edit->thired_last_month; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>3rd Month Point Limit</label>
															<input name="thired_last_month_point_limit" value="<?php if(!empty($edit)){ echo $edit->thired_last_month_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>4th Month Amount</label>
															<input name="forth_last_month" value="<?php if(!empty($edit)){ echo $edit->forth_last_month; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>4th Month Point Limit</label>
															<input name="forth_last_month_point_limit" value="<?php if(!empty($edit)){ echo $edit->forth_last_month_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>5th Month Amount</label>
															<input name="fifth_last_month" value="<?php if(!empty($edit)){ echo $edit->fifth_last_month; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>5th Month Point Limit</label>
															<input name="fifth_last_month_point_limit" value="<?php if(!empty($edit)){ echo $edit->fifth_last_month_point_limit; } ?>" type="text" class="number_int form-control" required>
														</div>
													</div>
												</div>
												
											</div>	
										</div>
									</div>												
									
								</div>
															
								<div class="form-group" style="margin-top:15px;">
									<label>Sales Looser Enable/Disable</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="sales_looser" <?php if(!empty($edit)){ if($edit->sales_looser == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
								</div>
								<div class="form-group" style="margin-top:15px;">
									<label>Service Enable/Disable</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control" placeholder="Note" required><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
								</div>

							</div>
							<div class="card-footer">
								<?php echo $button; ?>
							</div>
						</form>
					</div>
				</div>				
				
				
	

			</div>
		</div>
	</div>
</div>
