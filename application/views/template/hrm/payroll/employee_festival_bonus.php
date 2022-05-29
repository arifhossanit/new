<?php

function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
?>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Festival Bonus</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Bonus</a></li>
						<li class="breadcrumb-item active">Employee Festival Bonus</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<div class="row">
						<div class="col-sm-3">
							<div class="card card-info">
								<div class="card-header">
									Employee Festival Bonus Info
								</div>
								<div class="card-body">
									<form id="employee_festival_bonus_form" action="<?php echo current_url(); ?>" method="POST">
										<input type="hidden" name="Bonus_submit_token" value="<?php echo md5(time());?>"/>
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label>Festival Name</label>
													<select name="festival_name" id="festival_name" class="form-control" required >
														<option value="">--select--</option>
														<?php 
															$sql = $this->db->query("select * from festival ");
															$festivals = $sql->result();
															foreach($festivals as $fest){
														?>
														<option value="<?php echo $fest->id ; ?>"><?php echo $fest->festival_name ; ?></option>
															<?php } ?>
													</select>
												</div>
												<div class="form-group">
													<label>Select Year</label>
													<select name="festival_year" id="year" class="form-control select2" required >
														<option value="">--select--</option>
														<?php
															$year = date('Y');
															$year1 = date('Y') + 10;
															for($year; $year <= $year1; $year++){
																echo '<option value="'.$year.'">'.$year.'</option>';
															}
														?>
													</select>
												</div>
												
												<div class="form-group">
													<label>Festival Date</label>
													<input placeholder="YYYY-MM-DD" id="festival_date" class="form-control datepicker" name="festival_date" required />
												</div>
												
												<div class="form-group">
													<label>Festival Maturity Date</label>
													<input placeholder="YYYY-MM-DD" id="adjustment_date" class="form-control datepicker" name="adjustment_date" required />
												</div>
												
												<div class="form-group">
													<label>Percentage<small>(6-12 months)</small></label>
													<input type="number" name="percentage_six_months" value="" placeholder="Percentage" autocomplete="off" class="form-control" required />
												</div>	
										
												<div class="form-group">
													<label>Percentage<small>(12+ months)</small></label>
													<input type="number" name="percentage_tweelve_months" value="" placeholder="Percentage" autocomplete="off" class="form-control" required />
												</div>
												
												<div class="form-group">
													<button type="submit" name="save" class="btn btn-success" style="float:right;">Generate</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-sm-9">
							<div class="card card-success">
								<div class="card-header">
									Employee Festival Bonus Logs
									<span id="export_buttons" style="float:right;"></span>
								</div>
								<div class="card-body">
									<table class="table table-bordered table-sm table-striped" id="festival_table">
										<thead>
											<tr>
												<th>Serial</th>
												<th>Festival Date</th>
												<th>Festival name</th>
												<th>Festival Year</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$serial = 1;
										foreach($bonus as $bns) { ?>
											<tr>
												<td><?php echo $serial; ?></td>
												<td><?php echo $bns->festival_date; ?></td>
												<td><?php echo $bns->festival_id == 1 ? "Eid al-Fitr":"Eid al-Adha"; ?></td>
												<td><?php echo $bns->festival_year; ?></td>
												<td class="d-flex">
													<button id="festival_bonus_list" data-toggle='modal' data-target='#festival_bonus' data-festival_date="<?php echo $bns->festival_date; ?>" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button>&nbsp;
													<button name="download" id="download" data-festival_date="<?php echo $bns->festival_date; ?>" class="btn btn-sm btn-success"><i class="fas fa-solid fa-download"></i></button>&nbsp;
													<?php if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
													<form action="<?php echo current_url(); ?>" method="post">
														<input type="hidden" name="festival_date" value="<?php echo $bns->festival_date; ?>"></input>
														<button name="festival_delete" id="festival_delete" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
													</form>
													<?php } ?>
												</td>
											</tr>
										<?php $serial++; } ?>
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


<div class="modal" id="festival_bonus" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Festival bonus.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="festival_bonus_data">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>

$(document).on("load", function(){
	$( "#adjustment_date" ).datepicker({
		dateFormat: "yy/mm/dd",
		
	});
	$( "#festival_date" ).datepicker({
		dateFormat: "yy/mm/dd",
		
	});
})

$(document).on("click", "#download", function(){
	var festival_date = $(this).data("festival_date");
	var url = "<?php echo base_url();?>"+"admin/hrm/award/download-employee-festival-bonus?festival_date="+festival_date;   
    window.open(url);  
});

$(document).on("click", "#festival_bonus_list", function(){
	var festival_date = $(this).data("festival_date");
	console.log(festival_date);
	$.ajax({
		url: "<?php echo base_url();?>"+"admin/hrm/award/employee-festival-bonus-show?festival_date="+festival_date,
		method: "GET",
		dataType: "HTML",
		success: function(data){
			$("#festival_bonus_data").html(data);
		}
	})
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>