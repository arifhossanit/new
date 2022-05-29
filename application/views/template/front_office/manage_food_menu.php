<!---- edit modal-->
<div class="modal fade" id="edit_type">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=base_url()?>admin/front-office/manage-food-menu/menu-update" method="post">
                <input type="hidden" name="type_id" id="type_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Edit Foods</h4>
				</div>
				<div class="modal-body" id="print_applicant_account_Details_result">
                    <div class="form-group">
						<span>Meal Title</span>
                        <input class="form-control" type="text" name="food_title" id="food_title">
                    </div>
					<div class="form-group">
						<label>Select Meal Type</label>
						<select name="meal_type" id="meal_type" class="form-control select2">
							<option value="">--select--</option>
							<option value="Breakfast">Breakfast</option>
							<option value="Lunch">Lunch</option>
							<option value="Dinner">Dinner</option>
							<option value="Iftar">Iftar</option>
							<option value="Sehri">Sehri</option>
						</select>
                    </div>
					<div class="form-group">
						<label>Week</label>
						<select name="week" id="week" class="form-control select2">
							<option value="">--select--</option>
							<option value="First">First Week</option>
							<option value="Second">Second Week</option>
							<option value="Third">Third Week</option>
							<option value="Fourth">Fourth Week</option>
						</select>
                    </div>
					<div class="form-group">
						<label>Day (Multiple Select)</label>
						<select name="day" id="day" class="form-control select2">
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
					
                    <!-- <div class="form-group">
                        <label>package Enable/Disable</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="type_status" name="type_status" data-bootstrap-switch data-off-color="danger" data-on-color="success" >
                    </div> -->
				</div>                
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<!----End edit -->
<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Food Menu</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Manage Food Menu</li>
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
						<h3 class="card-title">Manage Food Menu</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<table id="food_menu_data_table" class="table table-bordered">
									<thead>
										<tr>
											<th>Id</th>
											<th>Branch</th>
											<th>Meal_type</th>
											<th>Meal_Title</th>
											<th>Week</th>
											<th>Day</th>
											<th>Date</th>
											<th>Option</th>
										</tr>
									</thead>
									<tbody>
									<?php 
if(!empty($foodmenu)){
	foreach($foodmenu as $row){
		
?>								
									<tr>
										<!-- <td><input type="checkbox" value="<!?=$row->id;?>" /></td> -->
										<!-- <td><!?=$row->id; ?></td> -->
										<td><?=$row->id; ?></td>
										<td><?=$row->branch_id; ?></td>
										<td><?=$row->meal_type; ?></td>
										<td><?=$row->food_title; ?></td>
										<td><?=$row->week; ?></td>
										<td><?=$row->day; ?></td>
										<td><?=$row->data; ?></td>

										<!-- <td>
											<!?php if($row->status == '1'){ ?>
												<button class="btn btn-xs btn-success">Active</button>
											<!?php }else{ ?>
												<button class="btn btn-xs btn-danger">Deactive</button>
											<!?php } ?>
										</td> -->
										<td>
                                            <div class="row justify-content-center" >
                                                <div class="col-6">
                                                    <button data-target="#edit_type" data-toggle="modal" class="btn btn-info btn-xs" onclick="edit_type(this.value)" value="<?php echo $row->id.'~'.$row->meal_type.'~'.$row->food_title; ?>"><i class="far fa-edit"></i></button>
                                                </div>
                                                <div class="col-6">
                                                    <form action="<?=base_url()?>admin/front-office/manage-food-menu/menu-delete" method="post">
                                                        <input type="hidden" name="menu_id" value="<?php echo $row->id; ?>">
                                                        <button class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
									</tr>
<?php } }  ?>
										
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
</script>
<script>
function edit_type(info) {
    info = info.split('~');
    $('#type_id').val(info[0]);
    $('#product_type').val(info[1]);
    if(info[2] === '1'){
        $('#type_status').attr('checked', 'checked');
    }else{
        $('#type_status').attr('unchecked', 'unchecked');
    }
}
</script>