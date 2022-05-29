<style>
    .checked {
        color: orange;
    }
    .product-rating {
        font-size: 25px
    }
</style>




<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
		    
				<h1 class="m-0 text-dark">Employee Rating</h1>
			
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">Employee Rating</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>



	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">					
					<div class="row justify-content-center">
						<div class="col-sm-10">
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">Employee Rating</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									
									<div class="tab-content" id="pills-tabContent">
									  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
											<div class="row">
												<div class="col-md-2">
													<label for="month">Select Month</label>
													<input onchange="get_new_review()" class="form-control" type="month" name="month" id="month" value="<?= date('Y-m') ?>">
												</div>
												<div class="col-md-2">
													<label for="month">Select Branch</label>
													<select onchange="get_new_review()" id="branch" class="form-control select2">
														<option value="all">All</option>
														<?php foreach($branches as $branch){ ?>
															<option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-md-12 mt-2">
													<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
													<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>Image</th>
																<th>Department</th>
																<th>Designation</th>
																<th>Employee Information</th>
																<th>Location</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody id="review_table_body">	
															<?php foreach($employee_ratings as $employee_rating){ ?>
																<tr>
																	<td><img src="<?= base_url($employee_rating->photo) ?>" alt="" width="90px" style="border-radius: 5px;"></td>
																	<td><?= $employee_rating->department_name ?></td>
																	<td><?= $employee_rating->designation_name ?></td>
																	<td><?= $employee_rating->full_name . " (".$employee_rating->employee_id.")" ?></td>
																	<td><?= $employee_rating->branch_name ?></td>
																	<td>
																		<div class="row justify-content-center text-center">
																			<div class="col-md-12">
																				<button onclick="get_review_details(<?= $employee_rating->id ?>)" data-target="#indevidual_review_modal" data-toggle="modal" class="btn btn-link"><span class="product-rating"><?= round($employee_rating->avarage, 2) ?></span><span>/5  </span></button>
																			</div>
																			<div class="col-md-12">
																				<span class="fa fa-star <?= ($employee_rating->avarage >= 1) ? 'checked' : '' ?>"></span>
																				<span class="fa fa-star <?= ($employee_rating->avarage >= 2) ? 'checked' : '' ?>""></span>
																				<span class="fa fa-star <?= ($employee_rating->avarage >= 3) ? 'checked' : '' ?>""></span>
																				<span class="fa fa-star <?= ($employee_rating->avarage >= 4) ? 'checked' : '' ?>""></span>
																				<span class="fa fa-star <?= ($employee_rating->avarage >= 5) ? 'checked' : '' ?>""></span>
																				<span class="text-secondary" style="font-size: 00.9166em;">(<?= $employee_rating->number_of_review ?>)</span>
																			</div>
																		</div>
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
			</div>
		</div>
	</div>
</div>


<!----Careate Group-->
<div class="modal fade" id="indevidual_review_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header btn-dark" style="background-color:#333;color:#fff;">
                <h4 class="modal-title">All Reviews</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:#fff;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="individual_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Review By</th>
                            <th>Image</th>
                            <th>Reviewer Details</th>
                            <th>Remark</th>
                            <th>Score</th>
                            <th>Review Date</th>
                        </tr>
                    </thead>
                    <tbody id="all_review">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!----End Careate Group-->

<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script>


//-----------------rental work java script-------------------------

$("#short_from").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#short_to").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})


function booking_reset(){
	$("#short_from").val('');
	$("#short_to").val('');
	$("#meal_type_filter").html('<option value="0">All</option> <option value="1">Breakfast</option> <option value="2">Lunch</option> <option value="3">Dinner</option>');
	return booking_report_table();
}

function get_review_details(e_db_id){
    let month = $('#month').val();
    $.ajax({  
		url:"<?=base_url('admin/scm/detailed-review/');?>" + month,  
		method:"GET",
        data: {e_db_id},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#all_review').html(data);
		}
	});
}


$('document').ready(function(){	
	//return booking_report_table();
})
function get_new_review(){
    let month = $('#month').val();
    let branch = $('#branch').val();
    $.ajax({  
		url:"<?=base_url('admin/scm/employee-review-show/');?>" + month + '/' + branch,  
		method:"GET",
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#review_table_body').html(data);
		}
	});
}
$('document').ready(function(){
    
    $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"scrollX": false,
		// "columnDefs": [
		// 	{ "visible": false, "targets": 0 },
		// 	{ "width": "2%", "targets": 9 }
		// ]
	});
    $('#individual_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"scrollX": false,
		// "columnDefs": [
		// 	{ "visible": false, "targets": 0 },
		// 	{ "width": "2%", "targets": 9 }
		// ]
	});

})


</script>


