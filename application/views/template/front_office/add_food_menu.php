<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Food Menu</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Add Food Menu</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Add Food Menu</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Food Code</label>
										<input type="text" name="food_code" id="food_code" value="<?php echo date('dmY').'-'.time() * rand(); ?>" class="form-control" readonly="readonly"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Select Branch (Multiple Select)</label>
										<select name="branch_id[]" id="branch_id" multiple="multiple" class="form-control select2" required="required">
											<option value="">--select--</option>
											<?php
												if(!empty($banches)){
													foreach($banches as $row){ ?>
														<option value="<?php echo $row->branch_id?>"><?php echo $row->branch_name?></option>;
												<?php	}
												}
											?>
										</select>
										<!-- <select name="meal_type[]" id="meal_type" multiple="multiple" class="form-control select2">
                                        <option value="">--Select--</option>
                                        <!?php foreach($member_lists as $member_list){ ?>
                                            <option value="<!?php echo $member_list->employee_id?>"><!?php echo $member_list->employee_id.' - '.$member_list->f_name.' '.$member_list->l_name?></option>
                                        <!?php } ?>
                                    	</select> -->
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Select Meal Type</label>
										<select name="meal_type" id="meal_type" class="form-control select2" required="required">
											<option value="">--select--</option>
											<option value="Breakfast">Breakfast</option>
											<option value="Lunch">Lunch</option>
											<option value="Dinner">Dinner</option>
											<option value="Iftar">Iftar</option>
											<option value="Sehri">Sehri</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Week (Multiple Select)</label>
										<select name="week[]" id="week" multiple="multiple" class="form-control select2" required="required">
											<option value="">--select--</option>
											<option value="First">First Week</option>
											<option value="Second">Second Week</option>
											<option value="Third">Third Week</option>
											<option value="Fourth">Fourth Week</option>
										</select>
										<!-- <select name="meal_type[]" id="meal_type" multiple="multiple" class="form-control select2">
                                        <option value="">--Select--</option>
                                        <!?php foreach($member_lists as $member_list){ ?>
                                            <option value="<!?php echo $member_list->employee_id?>"><!?php echo $member_list->employee_id.' - '.$member_list->f_name.' '.$member_list->l_name?></option>
                                        <!?php } ?>
                                    	</select> -->
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Food Title</label>
										<input type="text" name="food_title" id="food_title" class="form-control" required="required"/>
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Day (Multiple Select)</label>
										<select name="day[]" id="day" multiple="multiple" class="form-control select2" required="required">
											<option value="">--select--</option>
											<option value="Saturday">Saturday</option>
											<option value="Sunday">Sunday</option>
											<option value="Monday">Monday</option>
											<option value="Tuesday">Tuesday</option>
											<option value="Wednesday">Wednesday</option>
											<option value="Thursday">Thursday</option>
											<option value="Friday">Friday</option>
											
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Food Image</label>
										<input type="file" name="food_image" id="food_image" class="form-control" style="padding-top:3px;" required="required"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Note</label>
										<textarea name="note" class="form-control" style="height:120px;" required></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" onclick="return confirm('Are you sure want to save this data?')" name="save" class="btn btn-success">Save</button>
									</div>
								</div>								
							</div>						
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

</script>