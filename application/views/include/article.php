<?php

	if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
		$admin = TRUE;
	}else{
		$admin = FALSE;
	}
?>
<style>
th,td{
	padding: 0px !important;
}
.nmbr_cls_dash{
	position: relative;max-width: 100%; padding-right: 7.5px; padding-left: 7.5px;
	overflow-x:hidden;
	margin-bottom:10px;
}
.custom_design_grph_body{
	min-height:410px;
}
.custom_design_grph_body i{
	margin-top: 62px;
	font-size: 228px;
	opacity: 1.0;
}
.tableFixHead {
	overflow: auto;
	height: 100px;
}
.tableFixHead thead th {
	position: sticky;
	top: 0;
	z-index: 1;
}

/* Just common table stuff. Really. */
table  {
	border-collapse: collapse;
	width: 100%;
}
th, td {
	padding: 8px 16px;
	border: 1px solid #e0e0e0;
}
th {
	background:#eee;
}
</style>
<script>	
	function graph_load(graph_number){
		$.ajax({  
			url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
			method:"POST",
			data:{ graph_number:graph_number },
			beforeSend:function(){ $('#data-loading').html(data_loading); },
			success:function(data){	 $('#data-loading').html(''); $('#graph_load_'+graph_number+'').css({"background":"none"}); $('#graph_load_'+graph_number+'').html(data); }
		});  
	}
	function graph_load_branch(graph_number){
		var branch_id = $('select[name="dashboard_bbranch_id"]').val();
		$.ajax({  
			url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
			method:"POST",
			data:{ graph_number:graph_number, branch_id:branch_id },
			beforeSend:function(){ $('#data-loading').html(data_loading); },
			success:function(data){	 $('#data-loading').html(''); $('#graph_load_'+graph_number+'').css({"background":"none"}); $('#graph_load_'+graph_number+'').html(data); }
		});  
	}
</script>
<div class="modal fade" id="view_live_list_percentage_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">	
			<div class="modal-header btn-info">
				<h4 class="modal-title">Live Booked Percentage</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<div style="width:100%;margin-top:30px;" id="view_live_list_percentage_result"></div>
			</div>
		</div>
	</div>
</div>
<div class="container-flud">
	<div class="content-wrapper">
	
	
		<div class="content-header">
		  <div class="container-fluid">
			<div class="row">
			
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-2">
							<form action="<?php echo current_url(); ?>" method="post">
								<div class="form-group">
									<select name="dashboard_bbranch_id" class="form-control select2" onchange="this.form.submit()" id="branch_id_select" required>
									<?php
										if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['user_info']['branch_name'] == 'Corporate Office'){
											echo '<option value="">All Branch</option>';
										}
										if(!empty($banches)){
											foreach($banches as $row){
												if(!empty($drop_down_v_id) AND $drop_down_v_id == $row->branch_id){
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
							</form>
						</div>

						
						<?php if(check_permission('role_1606369762_84')){ ?>
						<div class="col-sm-2" id="graph_load_36">
							<button type="button" onclick="graph_load_branch(36)" class="btn btn-outline-dark" style="width:100%;">
								Local Investment: &nbsp;&nbsp;<i class="fas fa-sync-alt"></i>
							</button>
						</div>
						<?php } ?>						
						
						<?php if(check_permission('role_1606369766_39')){ ?>
						<div class="col-sm-2" id="graph_load_35">
							<button type="button" onclick="graph_load_branch(35)" class="btn btn-outline-dark" style="width:100%;">
								Petty Cash: &nbsp;&nbsp;<i class="fas fa-sync-alt"></i>
							</button>
						</div>
						<?php } ?>
						
						<?php if(check_permission('role_1606369770_98')){ ?>
						<div class="col-sm-2" id="graph_load_34">
							<button type="button" onclick="graph_load_branch(34)" class="btn btn-outline-dark" style="width:100%;">
								In DropBox: &nbsp;&nbsp;<i class="fas fa-sync-alt"></i>
							</button>
						</div>
						<?php } ?>						
						
						<?php if(check_permission('role_1606369775_92')){ ?>
						<div class="col-sm-2">
							<button type="button" onclick="graph_load(33)" id="graph_load_33" class="btn btn-outline-dark" style="width:100%;">
								<?=date('F'); ?> Collected: &nbsp;&nbsp;<i class="fas fa-sync-alt"></i>
							</button>
						</div>
						<?php } ?>
						
						<?php if(check_permission('role_1606369825_81')){ ?>
						<div class="col-sm-2">
							<button type="button" onclick="graph_load(32)" id="graph_load_32" class="btn btn-outline-dark" style="width:100%;">
								Collected: &nbsp;&nbsp;<i class="fas fa-sync-alt"></i>
							</button>							
						</div>
						<?php } ?>

					</div>
				</div>
			<!----------------------------->
			
			
			<?php if(check_permission('role_1606369825_96')){ ?>
				<div class="col-sm-12" style="max-height:71px;overflow-y:scroll;" id="graph_load_37">
					<button type="button" onclick="graph_load_branch(37)" class="btn btn-outline-dark" style="width:100%;">
						Package Info: &nbsp;&nbsp;<i class="fas fa-sync-alt"></i>
					</button>	
				</div>
			<?php } ?>		  
			</div>
		  </div>
		</div>
		
		
<!------------------------------------->
<script>
function view_live_booked_member_percentage(){
	var graph_number = 28;
	$.ajax({  
		url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
		method:"POST",
		data:{ graph_number:graph_number },
		beforeSend:function(){ $('#data-loading').html(data_loading); },
		success:function(data){	 $('#data-loading').html(''); 
			$('#view_live_list_percentage_result').html(data); 
			$('#view_live_list_percentage_modal').modal('show'); 
			return false;
		}
	});
	return false;
}
</script>
<!------------------------------------->
		
		
		<section class="content">	
			<div class="container-fluid">
				<?php if(check_permission('role_1606369825_92')){ ?>
				<div class="row">
					<div class="col-lg-2 col-6">
						<a href="<?=base_url('admin/report/crm-report/live-booked-member-list'); ?>">
							<div class="small-box bg-info" style=" box-shadow: 0 0 10px -1px black !important;padding: 1px !important;border-radius:30px;border:white 3px solid;">
								<div class="inner">				
									<h3> 
										<?php if(!empty($booked_number)){ echo sprintf("%02d", $booked_number); } else{ echo '00';} ?> 
										<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
										<button onclick="return view_live_booked_member_percentage();" type="button" class="btn btn-warning btn-xs font-weight-bold" style="position: absolute; right: 11px;">Live Booked Percentage</button>
										<?php } ?>
									</h3>
									<p style="margin-bottom: 0px;">Booked | Total Booked Member: <b><?php if(!empty($booked_member_dsh)){ echo sprintf("%02d", $booked_member_dsh); } else{ echo '00';} ?></b></p>
								</div>
								<div class="icon">
									<i class="ion ion-bag"></i>
								</div>								
							</div>
						</a>
					</div>
					<style>
						.abl_btn_cus{border: solid 1px #333; padding: 0px 10px; border-radius: 7px;}
					</style>
					<div class="col-lg-6 col-6">
						<a href="<?=base_url('admin/booking'); ?>">
							<div class="small-box bg-defult" style=" box-shadow: 0 0 10px -1px black !important;padding: 1px !important;border-radius:30px;border:red 3px solid;">
								<div class="inner">
									<h3 style="color:#000;">
										<span class="abl_btn_cus text-info"><?php if(!empty($abail_number)){ echo sprintf("%02d", $abail_number); } else{ echo '00';} ?></span> +
										<span class="abl_btn_cus text-secondary"><?php if(!empty($out_of_service)){ echo sprintf("%02d", $out_of_service); } else{ echo '00';} ?></span> +
										<span class="abl_btn_cus text-darktext-dark"><?php if(!empty($number_of_disabled)){ echo sprintf("%02d", $number_of_disabled); } else{ echo '00';} ?></span> +
										<span class="abl_btn_cus text-primary"><?php if(!empty($number_of_employee)){ echo sprintf("%02d", $number_of_employee); } else{ echo '00';} ?></span>
									</h3>
									<p style="margin-bottom: 0px;font-weight:bolder;">
										<span class="text-info">Available</span> +
										<span class="text-secondary">Out of service</span> +
										<span class="text-dark">Disabled</span> +
										<span class="text-primary">Employee</span>
										Beds | <span style="color:#fd7e14;">Total Capacity of Branch: <b><?php if(!empty($total_number_of_bed)){ echo sprintf("%02d", $total_number_of_bed); } else{ echo '00';} ?></b></span></p>
								</div>
								<div class="icon">
									<i class="ion ion-stats-bars"></i>
								</div>								
							</div>
						</a>
					</div>

					<div class="col-lg-2 col-6">
						<a href="<?=base_url('admin/report/crm-report/live-request-for-cancel-member-list'); ?>">
							<div class="small-box bg-danger" style=" box-shadow: 0 0 10px -1px black !important;padding: 1px !important;border-radius:30px;border:white 3px solid;">
								<div class="inner">
									<h3><?php if(!empty($rfc_number)){ echo sprintf("%02d", $rfc_number); } else{ echo '00';} ?></h3>
									<p style="margin-bottom: 0px;">Request For Cancel</p>
								</div>
								<div class="icon">
									<i class="ion ion-person-add"></i>
								</div>								
							</div>
						</a>
					</div>
					<div class="col-lg-2 col-6">
						<a href="<?=base_url('admin/report/crm-report/occupide-member-list'); ?>">
							<div class="small-box bg-warning" style=" box-shadow: 0 0 10px -1px black !important;padding: 1px !important;border-radius:30px;border:white 3px solid;">
								<div class="inner">
									<h3>
										<?php if(!empty($ocp_number)){ $ocup = $ocp_number; echo sprintf("%02d", $ocp_number); } else{$ocup = 0; echo '00';} ?>
										+
										<span style="background-color:#f00;padding:2px;border-radius:5px;color:#fff;font-weight:bolder;">
											<?php if(!empty($rfc_number)){ $recu = $rfc_number; echo sprintf("%02d", $rfc_number); } else{$recu = 0; echo '00';} ?></span>
										=
										<?php 
											echo sprintf("%02d", $ocup + $recu);
										?>									
									</h3>
									<p style="margin-bottom: 0px;">Occupied + <span style="background-color:#f00;padding:2px;border-radius:5px;color:#fff;font-weight:bolder;">Request For Cancel</span> = Total</p>
								</div>
								<div class="icon">
									<i class="ion ion-pie-graph"></i>
								</div>								
							</div>
						</a>
					</div>
				</div>
				<?php } ?>

				<div class="row">
					<div class="col-sm-12">
						<div class="row">
						<!-------start from here ----->	
						
							<?php if(check_permission('role_1606369825_34')){ ?>
							<div class="col-sm-4">
								<div class="card card-warning">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Occupied Map (Monthly) </b><span class="text-dark">Total: <?php if($monthly_total_booking[0]->total_booking > 0){ echo $monthly_total_booking[0]->total_booking; }else{ echo 0; } ?></span></h3> <button onclick="return branch_booking_map_monthly_date_wise_view()" type="button" class="btn btn-primary btn-xs font-weight-bold" style="float:right;"><i class="fas fa-calendar-day"></i>  Month Wise View</button>
										<button onclick="return monthly_booking_date_wise_view_percentage()" type="button" class="btn btn-info btn-xs font-weight-bold" style="float:right;margin-right:5px;"><i class="fas fa-chart-pie"></i>  Date Booking Percentage</button>
										<a onclick="graph_load_branch(10)" href="javascript:void(0)" style="float:right;margin-right:15px;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_10"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_9.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(10)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
							</div>	
							<div class="modal fade" id="view_monthly_booking_percentage_modal">
								<div class="modal-dialog modal-md">
									<div class="modal-content">	
										<div class="modal-header btn-info">
											<h4 class="modal-title">Monthly Booking Percentage</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<input type="month" id="branch_booking_map_monthly_input_percentage" value="<?php echo date('Y-m'); ?>" max="<?php echo date('Y-m'); ?>" class="form-control"/>												
											</div>
											<div style="width:100%;margin-top:30px;" id="view_monthly_booking_percentage_result"></div>
										</div>
									</div>
								</div>
							</div>
							<script>
								$('document').ready(function(){
									$("#branch_booking_map_monthly_input").on("change",function(){ 
										branch_booking_map_monthly_date_wise_view(); 
									})
									
									$("#branch_booking_map_monthly_input_percentage").on("change",function(){ 
										monthly_booking_date_wise_view_percentage(); 
									})
								})	
								function monthly_booking_date_wise_view_percentage(){
									var graph_number = 27;
									var date_range = $("#branch_booking_map_monthly_input_percentage").val();
									$.ajax({  
										url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
										method:"POST",
										data:{ graph_number:graph_number,date_range:date_range },
										beforeSend:function(){ $('#data-loading').html(data_loading); },
										success:function(data){	 $('#data-loading').html(''); 
											$('#view_monthly_booking_percentage_result').html(data); 
											$('#view_monthly_booking_percentage_modal').modal('show'); 
										}
									});
								}
								function branch_booking_map_monthly_date_wise_view(){
									var book_id_date = $("#branch_booking_map_monthly_input").val();
									if(book_id_date != ''){
										$.ajax({  
											url:"<?=base_url('assets/ajax/graph_modal/branch_booking_map_monthly_date_wise_view.php');?>",  
											method:"POST",  
											data:{book_id_date:book_id_date},
											beforeSend:function(){					
												$('#data-loading').html(data_loading);					 
											},
											success:function(data){	
												$('#data-loading').html('');
												$('#branch_booking_map_monthly_result').html(data); 
												$('#branch_booking_map_monthly_modal').modal('show'); 
											}  
										});
									}
								}
							</script>
							<div class="modal fade" id="branch_booking_map_monthly_modal">
								<div class="modal-dialog modal-xl" style="min-width: 80%;">
									<div class="modal-content">	
										<div class="modal-header btn-info">
											<h4 class="modal-title">Branch Booking Map (Monthly)</h4> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-sm-12">
													<div class="row">
														<div class="col-sm-3"></div> <div class="col-sm-3"></div> <div class="col-sm-3"></div>
														<div class="col-sm-3">
															<input type="month" id="branch_booking_map_monthly_input" value="<?php echo date('Y-m'); ?>" max="<?php echo date('Y-m'); ?>" class="form-control"/>
														</div>
													</div>
												</div>
												<div class="col-sm-12" id="branch_booking_map_monthly_result"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>	






							
							<?php if(check_permission('role_1606369825_52')){ ?>
							<!----daily booking---->
							<div class="col-sm-4">
								<div class="card card-success">
									<div class="card-header">
										<h3 class="card-title"><b><i class="fas fa-chart-pie mr-1"></i> Daily Booking</b> <span>Total: <?php if($daily_total_booking[0]->total_booking > 0){ echo $daily_total_booking[0]->total_booking; }else{ echo 0; } ?></span></h3> 
										<button class="btn btn-dark btn-xs font-weight-bold" style="float:right;margin-left:5px;" data-toggle="modal" data-target="#dailyBookingDayWiseModal"> 
											Monthly
										</button>
										<button onclick="return view_daily_booking_list()" class="btn btn-primary btn-xs font-weight-bold" type="button" style="float:right;"><i class="fas fa-eye"></i> View List</button> <button onclick="return daily_booking_date_wise_view()" type="button" class="btn btn-warning btn-xs font-weight-bold text-dark" style="float:right;margin-right:5px;"><i class="far fa-calendar-alt"></i>  Date Wise View</button>
										<button onclick="return daily_booking_date_wise_view_percentage()" type="button" class="btn btn-info btn-xs font-weight-bold" style="float:right;margin-right:5px;"><i class="fas fa-chart-pie"></i>  Date Booking Percentage</button>
										<a onclick="graph_load(11)" href="javascript:void(0)" style="float:right;margin-right:15px;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_11"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_10.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(11)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
								<!-- Modal -->
								<div class="modal fade" id="dailyBookingDayWiseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document" style="margin-left:1vw;">
										<div class="modal-content" style="height: auto;min-height: 55vh;border-radius: 0;min-width:96vw;margin:20px;border-radius:30px;">
											<div class="modal-body">
												<iframe src="<?php print base_url('every_branch_at_a_time_occupied_report') ?>" title="W3Schools Free Online Web Tutorials" style="width:100%;min-height:80vh;"></iframe>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="view_daily_booking_percentage_modal">
								<div class="modal-dialog modal-md">
									<div class="modal-content">	
										<div class="modal-header btn-info">
											<h4 class="modal-title">Daily Booking Percentage</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-prepend"> <span class="input-group-text"> <i class="far fa-calendar-alt"></i> </span> </div>
													<input id="date_wise_input2" type="text" class="form-control float-right date_range">
												</div>												
											</div>
											<div style="width:100%;margin-top:30px;" id="view_daily_booking_percentage_result"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="view_daily_booking_list_modal">
								<div class="modal-dialog modal-xl" style="min-width: 80%;">
									<div class="modal-content">	
										<div class="modal-header btn-info">
											<h4 class="modal-title">Daily booking List</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body" id="view_daily_booking_list_result"> </div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="daily_booking_date_wise_view_modal">
								<div class="modal-dialog modal-xl" style="min-width: 80%;">
									<div class="modal-content">	
										<div class="modal-header btn-info">
											<h4 class="modal-title">Daily Booking</h4> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-sm-12">
													<div class="row">
														<div class="col-sm-3"></div> <div class="col-sm-3"></div>
														<div class="col-sm-3">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="far fa-calendar-alt"></i>
																	</span>
																	</div>
																	<input id="daily_booking_date_wise_view_input" type="text" class="form-control float-right date_range">
																</div>
															</div>
														</div>
														<div class="col-sm-3"> </div>
													</div>
												</div>
												<div class="col-sm-12" id="daily_booking_date_wise_view_result"></div>
											</div>
										</div>
									</div>
								</div>
							</div>							
							<script>
								function daily_booking_date_wise_view_percentage(){
									var graph_number = 26;
									var date_range = $("#date_wise_input2").val();
									$.ajax({  
										url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
										method:"POST",
										data:{ graph_number:graph_number,date_range:date_range },
										beforeSend:function(){ $('#data-loading').html(data_loading); },
										success:function(data){	 $('#data-loading').html(''); 
											$('#view_daily_booking_percentage_result').html(data); 
											$('#view_daily_booking_percentage_modal').modal('show'); 
										}
									});
								}
								function daily_booking_date_wise_view(){
									var book_id_date = $("#daily_booking_date_wise_view_input").val();
									if(book_id_date != ''){
										$.ajax({  
											url:"<?=base_url('assets/ajax/graph_modal/daily_booking_date_wise_view.php');?>",  
											method:"POST",  
											data:{book_id_date:book_id_date},
											beforeSend:function(){					
												$('#data-loading').html(data_loading);					 
											},
											success:function(data){	
												$('#data-loading').html('');
												$('#daily_booking_date_wise_view_result').html(data); 
												$('#daily_booking_date_wise_view_modal').modal('show'); 
											}
										});  
									}
								}
								function view_daily_booking_list(){
									var view_id = '1';
									$.ajax({  
										url:"<?=base_url('assets/ajax/option_select/view_daily_booking_list.php');?>",  
										method:"POST",
										data:{ view_id:view_id },
										beforeSend:function(){ $('#data-loading').html(data_loading); },
										success:function(data){	
											$('#data-loading').html('');	
											$('#view_daily_booking_list_modal').modal('show');
											$('#view_daily_booking_list_result').html(data);
										}
									});
								}
								$('document').ready(function(){	
									$("#date_wise_input2").on("change",function(){
										var g_val = "<?php echo date('d/m/Y').' - '.date('d/m/Y'); ?>";
										if(g_val != $(this).val()){
											daily_booking_date_wise_view_percentage();
										}
									})
									$("#daily_booking_date_wise_view_input").on("change",function(){
										var g_val = "<?php echo date('d/m/Y').' - '.date('d/m/Y'); ?>";
										if(g_val != $(this).val()){
											daily_booking_date_wise_view();
										}									
									})
								})						
							</script>
							<!----end daily booking---->				
							<?php } ?>
							
							
							
							
							<?php if(check_permission('role_1606369825_33')){ ?>
							<!---daily renew---->
							<div class="col-sm-4">
								<div class="card card-warning">
									<div class="card-header">
										<?php 
											$count_daily_renew = $this->Dashboard_model->mysqlii("select count(*) as total_booking from rent_info where booking_id IN (select booking_id from member_directory where status = '1') and rent_status = 'Paid' AND data = '".date('d/m/Y')."' AND data_three = 'renew' AND status = '1'");
										?>
										<button class="btn btn-dark btn-xs font-weight-bold" style="float:right;margin-left:5px;" data-toggle="modal" data-target="#daily_renew_monthly_report"> 
											Monthly
										</button>
										<b><i class="fas fa-chart-pie mr-1"></i> Daily Renew <span style="color:#333;">Total: <?php if($count_daily_renew[0]->total_booking > 0){ echo $count_daily_renew[0]->total_booking; }else{ echo 0; } ?></span></b> <button onclick="return view_daily_renew_list()" class="btn btn-primary btn-xs font-weight-bold" type="button" style="float:right;"><i class="fas fa-eye"></i> View List</button> <button onclick="return daily_renew_date_wise_view()" type="button" class="btn btn-success btn-xs font-weight-bold" style="float:right;margin-right:5px;"><i class="far fa-calendar-alt"></i>  Date Wise View</button>
										<button onclick="return daily_renew_date_wise_view_percentage()" type="button" class="btn btn-info btn-xs font-weight-bold" style="float:right;margin-right:5px;"><i class="fas fa-chart-pie"></i>  Date Wise Percentage</button>
										<a onclick="graph_load(12)" href="javascript:void(0)" style="float:right;margin-right:15px;"><i class="fas fa-sync-alt"></i></a>
									</div>									
									<div class="card-body custom_design_grph_body" id="graph_load_12"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_11.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(12)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
								<div class="modal fade" id="daily_renew_monthly_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document" style="margin-left:1vw;">
										<div class="modal-content" style="height: auto;min-height: 55vh;border-radius: 0;min-width:96vw;margin:20px;border-radius:30px;">
											<div class="modal-body">
												<iframe src="<?php print base_url('daily_renew_monthly_report') ?>" title="W3Schools Free Online Web Tutorials" style="width:100%;min-height:80vh;"></iframe>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="view_daily_renew_list_percentage_modal">
								<div class="modal-dialog modal-md">
									<div class="modal-content">	
										<div class="modal-header btn-info">
											<h4 class="modal-title">Daily Renew Percentage</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-prepend"> <span class="input-group-text"> <i class="far fa-calendar-alt"></i> </span> </div>
													<input id="date_wise_input1" type="text" class="form-control float-right date_range">
												</div>												
											</div>
											<div style="width:100%;margin-top:30px;" id="view_daily_renew_list_percentage_result"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="view_daily_renew_list_modal">
								<div class="modal-dialog modal-xl" style="min-width: 80%;">
									<div class="modal-content">	
										<div class="modal-header btn-info">
											<h4 class="modal-title">Daily Renew List</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body" id="view_daily_renew_list_result"> </div>
									</div>
								</div>
							</div>
							<!----vaiw rental model-->
							<div class="modal fade" id="rental_receipt_model">
								<div class="modal-dialog modal-xl">
									<div class="modal-content">
										<form action="<?=current_url(); ?>" method="post">
											<div class="modal-header btn-warning">
												<h4 class="modal-title">Rental information</h4> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
											</div>
											<div class="modal-body" id="rental_result"></div>
										</form>
									</div>
								</div>
							</div>
							<!----End vaiw rental model-->
							<div class="modal fade" id="daily_renew_date_wise_view_modal">
								<div class="modal-dialog modal-xl" style="min-width: 80%;">
									<div class="modal-content">	
										<div class="modal-header btn-info">
											<h4 class="modal-title">Daily Renew</h4> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-sm-12">
													<div class="row">
														<div class="col-sm-3"></div> <div class="col-sm-3"></div>
														<div class="col-sm-3">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="far fa-calendar-alt"></i>
																	</span>
																	</div>
																	<input id="daily_renew_date_wise_input" type="text" class="form-control float-right date_range">
																</div>
															</div>
														</div>
														<div class="col-sm-3"></div>
													</div>
												</div>
												<div class="col-sm-12" id="daily_renew_date_wise_view_result"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<script>
								function daily_renew_date_wise_view_percentage(){
									var graph_number = 25;
									var date_range = $("#date_wise_input1").val();
									$.ajax({  
										url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
										method:"POST",
										data:{ graph_number:graph_number,date_range:date_range },
										beforeSend:function(){ $('#data-loading').html(data_loading); },
										success:function(data){	 $('#data-loading').html(''); 
											$('#view_daily_renew_list_percentage_result').html(data); 
											$('#view_daily_renew_list_percentage_modal').modal('show'); 
										}
									});
								}
								function daily_renew_date_wise_view(){
									var book_id_date = $("#daily_renew_date_wise_input").val();
									if(book_id_date != ''){
										$.ajax({  
											url:"<?=base_url('assets/ajax/graph_modal/daily_renew_date_wise_view.php');?>",  
											method:"POST",  
											data:{book_id_date:book_id_date},
											beforeSend:function(){ $('#data-loading').html(data_loading); },
											success:function(data){	
												$('#data-loading').html('');
												$('#daily_renew_date_wise_view_result').html(data); 
												$('#daily_renew_date_wise_view_modal').modal('show'); 
											}
										});  
									}
								}
								function view_rental_recipt(id){
									var rent_id = id;
									if(rent_id != ''){
										$.ajax({  
											url:"<?=base_url('assets/ajax/rental_details_information.php');?>",  
											method:"POST",  
											data:{rent_id:rent_id},
											beforeSend:function(){ $('#data-loading').html(data_loading); },
											success:function(data){	
												$('#data-loading').html('');
												$('#rental_result').html(data); 
												$('#rental_receipt_model').modal('show');   
											}  
										});  
									}
								}
								function view_daily_renew_list(){
									var view_id = '1';
									$.ajax({  
										url:"<?=base_url('assets/ajax/option_select/view_daily_renew_list.php');?>",  
										method:"POST",
										data:{ view_id:view_id },
										beforeSend:function(){ $('#data-loading').html(data_loading); },
										success:function(data){	
											$('#data-loading').html('');	
											$('#view_daily_renew_list_modal').modal('show');
											$('#view_daily_renew_list_result').html(data);
										}  
									});
								}
								$('document').ready(function(){	
									$("#date_wise_input1").on("change",function(){
										var g_val = "<?php echo date('d/m/Y').' - '.date('d/m/Y'); ?>";
										if(g_val != $(this).val()){
											daily_renew_date_wise_view_percentage();
										}									
									})
									$("#daily_renew_date_wise_input").on("change",function(){
										var g_val = "<?php echo date('d/m/Y').' - '.date('d/m/Y'); ?>";
										if(g_val != $(this).val()){
											daily_renew_date_wise_view();
										}									
									})
								})							
							</script>							
							<!---End daily renew---->
							<?php } ?>
							
							
							
							<?php if(check_permission('role_1606369825_59')){ ?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"> <b> <i class="fas fa-chart-pie mr-1"></i> Tomorrow you will get reward accoroding this point </b> </h3>
										<a onclick="graph_load(1)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_1" style="background:url(<?php echo base_url('assets/img/graph/Screenshot_27.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(1)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>
							<?php } ?>
							
							
							<?php if(check_permission('role_1606369825_93')){ ?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Next Week you will get reward accoroding this point</b></h3>
										<a onclick="graph_load(2)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_2"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_1.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(2)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>
							<?php } ?>
							
							<?php if(check_permission('role_1606369825_15')){ ?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Next Month you will get reword accoroding this point</b></h3>
										<a onclick="graph_load(3)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_3"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_2.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(3)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>
							<?php } ?>						
							
							<?php if(check_permission('role_1606369858_82')){ ?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b>Branch Booking Map (Life Histoy)</b></h3>
										<a onclick="graph_load_branch(4)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_4"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_3.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(4)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
							</div>						
							<?php } ?>
							
							<?php if(check_permission('role_1606369858_58')){ ?>						
							<div class="col-sm-4">
								<div class="card card-primary">
									<div class="card-header">
										<h3 class="card-title"><b>Occupation wise Booking</b></h3>
										<a onclick="graph_load_branch(5)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_5"  style="background: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url(<?php echo base_url('assets/img/graph/Screenshot_4.png'); ?>) no-repeat 0 50%;background-size:cover;" >
										<center ><a onclick="graph_load_branch(5)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>							
							<?php } ?>
							
							<?php if(check_permission('role_1606369858_34')){ ?>
							<div class="col-sm-4">
								<div class="card card-success">
									<div class="card-header">
										<h3 class="card-title"><b>Cancel & Booking</b></h3>
										<a onclick="graph_load_branch(6)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_6"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_5.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(6)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
							</div>							
							<?php } ?>
							
							<?php if(check_permission('role_1606369858_77')){ ?>
							<div class="col-sm-4">
								<div class="card card-warning">
									<div class="card-header">
										<h3 class="card-title"><b>Checkin & CheckOut</b></h3>
										<a onclick="graph_load_branch(7)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt text-white"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_7"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_6.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(7)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
							</div>							
							<?php } ?>							
							
							
							<?php if(check_permission('role_1606369858_13')){ ?>
							<div class="col-sm-4">
								<div class="card card-success">
									<div class="card-header">
										<h3 class="card-title"><b>Paid & Due Members</b></h3>
										<a onclick="graph_load_branch(8)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_8"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_7.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(8)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
							</div>							
							<?php } ?>							
							
							
							<?php if(check_permission('role_1606369858_85')){?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Monthly Branch Discount Graph </b>
											<?php if(!empty($thisMonthTotalDiscount)){ ?> <button style="margin-left: 2vw;" class="btn btn-sm btn-primary"><b>Total Amount</b> : <?php print $thisMonthTotalDiscount; ?> BDT </button> <?php } ?>
										</h3>
										<a onclick="graph_load_branch(9)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_9"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_8.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(9)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
							</div>							
							<?php } ?>					
							
							
							<?php if(check_permission('role_1606369858_87')){ ?>
							<!---Branch Seat Data---->
							<div class="col-sm-4">
								<div class="card card-dark">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Branch Seat Data </b></h3>
										<a onclick="graph_load_branch(13)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_13"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_12.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(13)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
							</div>						
							<?php } ?>							
				
							<?php if(check_permission('role_1606369858_28')){ ?>
							<div class="col-sm-4">
								<div class="card card-warning">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Branch wise occupide in(%) </b></h3>
										<button class="btn btn-success btn-sm font-weight-bold" style="float: right;margin-left:20px;" data-toggle="modal" data-target="#dailyBranchwiseOccupiedModal"> 
											Day Wise
										</button>
										<a onclick="graph_load_branch(14)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_14"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_13.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(14)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
								<!-- Modal -->
								<div class="modal fade" id="dailyBranchwiseOccupiedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document" style="margin-left:1vw;">
										<div class="modal-content" style="height: auto;min-height: 55vh;border-radius: 0;min-width:96vw;margin:20px;border-radius:30px;">
											<div class="modal-body">
												<iframe src="<?php print base_url('daily_occupied_report') ?>" title="W3Schools Free Online Web Tutorials" style="width:100%;min-height:80vh;"></iframe>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>						
				
							<?php if(check_permission('role_1606369858_28')){ ?>
							<div class="col-sm-4">
								<div class="card card-danger">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Seat wise occupide in(%) </b></h3>
										<button onclick="get_seat_occudied_by_branch()" class="btn btn-success btn-sm font-weight-bold" style="float: right;margin-left:20px;" data-toggle="modal" data-target="#seat_wise_occupency_modal"> 
											Branch Wise
										</button>
										<a onclick="graph_load_branch(39)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_39"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_13.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(39)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
								<!-- Modal -->
								<div class="modal fade" id="seat_wise_occupency_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Seat By Branch</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">
												<iframe id="seat_iframe" src="<?php print base_url('seat_wise_occupency') ?>" title="W3Schools Free Online Web Tutorials" style="width:100%;min-height:50vh;"></iframe>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<script>
								let get_seat_occudied_by_branch = () => {
									// let branch_id = $('#seat_occupancy_select').val();
									// let graph_number = 40;
									// $.ajax({  
									// 	url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
									// 	method:"POST",
									// 	data:{ graph_number, branch_id },
									// 	beforeSend:function(){ $('#data-loading').html(data_loading); },
									// 	success:function(data){	 $('#data-loading').html(''); $('#seat_wise_occupency_modal_body').css({"background":"none"}); $('#seat_wise_occupency_modal_body').html(data); }
									// });  
								}
							</script>
							<?php } ?>
							
							
							<?php if(check_permission('role_1606369858_90')){ ?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Monthly Package Wise Booking </b></h3> <button onclick="return package_wise_booking_history('true')" type="button" class="btn btn-xs btn-warning font-weight-bold" style="float:right;">View History</button>
										<button onclick="return monthly_date_wise_package_percentage()" type="button" class="btn btn-primary btn-xs font-weight-bold" style="float:right;margin-right:5px;"><i class="fas fa-chart-pie"></i> Percentage</button>
										<a onclick="graph_load_branch(15)" href="javascript:void(0)" style="float:right;margin-right:15px;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_15"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_14.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(15)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
								
								<div class="modal fade" id="monthly_date_wise_package_percentage">
									<div class="modal-dialog modal-xl">
										<div class="modal-content">	
											<div class="modal-header btn-info">
												<h4 class="modal-title">Package Wise Booking</h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
											</div>
											<div class="modal-body">
												<?php /* ?>
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend"> <span class="input-group-text"> <i class="far fa-calendar-alt"></i> </span> </div>
														<input id="date_wise_input_m_1" type="text" class="form-control float-right date_range">
													</div>												
												</div>
												<?php */ ?>
												<div style="width:100%;" id="monthly_date_wise_package_percentage_result"></div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="modal fade" id="package_wise_booking_history_modal">
									<div class="modal-dialog modal-xl" style="min-width:85%;">
										<div class="modal-content">
											<form action="<?=current_url(); ?>" method="post">
												<div class="modal-header btn-primary">
													<h4 class="modal-title">Package Wise Booking History</h4> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" style="color:#fff;">&times;</span> </button>
												</div>
												<div class="modal-body" id="package_wise_booking_history_result"> </div>
											</form>
										</div>
									</div>
								</div>
								<script>
									function monthly_date_wise_package_percentage(){
										var graph_number = 29;
										//var date_range = $("#date_wise_input_m_1").val();
										$.ajax({  
											url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
											method:"POST",
											data:{ graph_number:graph_number },
											beforeSend:function(){ $('#data-loading').html(data_loading); },
											success:function(data){	 $('#data-loading').html(''); 
												$('#monthly_date_wise_package_percentage_result').html(data); 
												$('#monthly_date_wise_package_percentage').modal('show'); 
											}
										});
									}
									function package_wise_booking_history(id){
										$.ajax({  
											url:"<?=base_url('assets/ajax/option_select/package_wise_booking_history_ajax.php');?>",  
											method:"POST",  
											data:{post:id},
											beforeSend:function(){					
												$('#data-loading').html(data_loading);
											},
											success:function(data){						
												$('#data-loading').html('');										
												$("#package_wise_booking_history_result").html(data);
												$("#package_wise_booking_history_modal").modal('show');
												setTimeout(function(){ 
													return package_wise_booking_history_function();
												},300);
											}
										});
									}
									/*
									$('document').ready(function(){	
										$("#date_wise_input_m_1").on("change",function(){
											var g_val = "<?php echo date('d/m/Y').' - '.date('d/m/Y'); ?>";
											if(g_val != $(this).val()){
												monthly_date_wise_package_percentage();
											}									
										})
									})	*/
								</script>
							</div>
							<?php } ?>					
							
							<?php if(check_permission('role_1606369858_53')){ ?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Package Wise Exixting Member </b></h3>
										<button onclick="return package_wise_exixting_member2()" type="button" class="btn btn-primary btn-xs font-weight-bold" style="float:right;margin-right:5px;"><i class="fas fa-chart-pie"></i> Percentage</button>
										<a onclick="graph_load_branch(16)" href="javascript:void(0)" style="float:right;margin-right:15px;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_16"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_15.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load_branch(16)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
								<div class="modal fade" id="package_wise_exixting_member2">
									<div class="modal-dialog modal-xl">
										<div class="modal-content">	
											<div class="modal-header btn-info">
												<h4 class="modal-title">Package Wise Exixting Member</h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
											</div>
											<div class="modal-body">
												<?php /* ?>
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend"> <span class="input-group-text"> <i class="far fa-calendar-alt"></i> </span> </div>
														<input id="date_wise_input_m_2" type="text" class="form-control float-right date_range">
													</div>												
												</div>
												<?php */ ?>
												<div style="width:100%;" id="package_wise_exixting_member_result2"></div>
											</div>
										</div>
									</div>
								</div>
								<script>
									function package_wise_exixting_member2(){
										var graph_number = 30;
										//var date_range = $("#date_wise_input_m_2").val();
										$.ajax({  
											url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
											method:"POST",
											data:{ graph_number:graph_number},
											beforeSend:function(){ $('#data-loading').html(data_loading); },
											success:function(data){	 $('#data-loading').html(''); 
												$('#package_wise_exixting_member_result2').html(data); 
												$('#package_wise_exixting_member2').modal('show'); 
											}
										});
									}
									/*
									$('document').ready(function(){	
										$("#date_wise_input_m_2").on("change",function(){
											var g_val = "<?php echo date('d/m/Y').' - '.date('d/m/Y'); ?>";
											if(g_val != $(this).val()){
												package_wise_exixting_member2();
											}									
										})
									})
									*/
								</script>
							</div>	
							<?php } ?>

							
							<?php if(check_permission('role_1606369870_90')){ ?>
							<div class="col-sm-4">
								<div class="card card-primary">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Branch NET uses graph </b></h3>
										<a onclick="graph_load(17)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_17"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_16.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(17)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
							</div>
							<?php } ?>
							
							
							
							<?php if(check_permission('role_1631683180_49')){ ?>						
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Employees Live Booking Value (Begin To Till now) </b></h3>
										
										<button 
											class="btn btn-primary btn-xs font-weight-bold"
											style = "background-color:green;font-size:small;margin-left:10px;"
											data-toggle="modal" data-target=".bd-example-modal-lg"
											onclick="get_live_booking_employee_table()"
										>
											Badge
										</button>
										<button onclick="return employee_live_booking_value()" type="button" class="btn btn-primary btn-xs font-weight-bold" style="float:right;margin-right:5px;"><i class="fas fa-chart-pie"></i> Percentage</button>
										<a onclick="graph_load(18)" href="javascript:void(0)" style="float:left;margin-right:15px;"> <i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_18"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_17.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(18)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>
								<!-- Modal -->
								<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-xl">
										<div class="modal-content">
											<div class="row" >
												<div class="col-md-6">
													<img 
														src="<?php print base_url().'assets/img/branch-grade-mark-badge.jpg'?>"
														width="100%"
													/>
												</div>
												<div class="col-md-6">
													<div class="row justify-content-between">
														<div class="col-md-4 mb-2 mt-2">
															<input id="employee_medel_date" onchange="get_live_booking_employee_table()" type="date" class="form-control" max="<?php $yesterday = new DateTime('yesterday'); echo $yesterday->format('Y-m-d'); ?>" value="<?php $yesterday = new DateTime('yesterday'); echo $yesterday->format('Y-m-d'); ?>">
														</div>
														<div class="col-md-2" style="display: fixed;">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
														</div>

														<div class="col-md-12" style="max-height: 750px; overflow-y: scroll;">
															<table class="tableFixHead">
																<thead>
																	<tr>
																		<th>Level</th>
																		<th>Image</th>
																		<th>Name</th>
																		<th>Point</th>
																		<th>Badge</th>
																	</tr>
																</thead>
																<tbody id="live_employee_table_date">
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal fade" id="employee_live_booking_value">
									<div class="modal-dialog modal-xl">
										<div class="modal-content">	
											<div class="modal-header btn-info">
												<h4 class="modal-title">Employee Live Booking</h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
											</div>
											<div class="modal-body">
												<?php /* ?>
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend"> <span class="input-group-text"> <i class="far fa-calendar-alt"></i> </span> </div>
														<input id="date_wise_input_m_3" type="text" class="form-control float-right date_range">
													</div>												
												</div>
												<?php */ ?>
												<div style="width:100%;" id="employee_live_booking_value_result"></div>
											</div>
										</div>
									</div>
								</div>
								
								<script>
									function employee_live_booking_value(){
										var graph_number = 31;
										//var date_range = $("#date_wise_input_m_3").val();
										$.ajax({  
											url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
											method:"POST",
											data:{ graph_number:graph_number},
											beforeSend:function(){ $('#data-loading').html(data_loading); },
											success:function(data){	 $('#data-loading').html(''); 
												$('#employee_live_booking_value_result').html(data); 
												$('#employee_live_booking_value').modal('show'); 
											}
										});
									}
									/*
									$('document').ready(function(){	
										$("#date_wise_input_m_3").on("change",function(){
											var g_val = "<?php echo date('d/m/Y').' - '.date('d/m/Y'); ?>";
											if(g_val != $(this).val()){
												employee_live_booking_value();
											}									
										})
									})*/
								</script>
							</div>							
							<?php } ?>	
						</div>
					</div>
				</div>			
				
				<div class="row">
					<div class="col-sm-12">						
						<div class="row">							
							<?php if(check_permission('role_1631683233_16')){ ?>					
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Booking Religion Percentage </b></h3>.
										<a onclick="graph_load(19)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_19"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_18.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(19)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>
							<?php } ?>
							
							<?php if(check_permission('role_1631683275_56')){ ?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Booking Occupation Percentage </b></h3>
										<a onclick="graph_load(20)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_20"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_19.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(20)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>
							<?php } ?>
							
							<?php if(check_permission('role_1631683319_87')){ ?>
							<div class="col-sm-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Booking How to find us Percentage </b></h3>
										<a onclick="graph_load(21)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_21"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_20.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(21)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>						
							<?php } ?>
							
						</div>
					</div>
				</div>
				
				
				
				<div class="row">
					<div class="col-sm-12">						
						<div class="row">							
							<?php if(check_permission('role_1631683368_82')){ ?>
							<div class="col-sm-4">
								<div class="card card-warning">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Booking Religion Percentage (History)</b></h3>
										<a onclick="graph_load(22)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_22"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_21.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(22)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>
							<?php } ?>				
							
							
							<?php if(check_permission('role_1631683423_33')){ ?>
							<div class="col-sm-4">
								<div class="card card-warning">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Booking Occupation Percentage (History) </b></h3>
										<a onclick="graph_load(23)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_23"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_22.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(23)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>
							<?php } ?>							
							
							<?php if(check_permission('role_1631683462_90')){ ?>
							<div class="col-sm-4">
								<div class="card card-warning">
									<div class="card-header">
										<h3 class="card-title"><b> <i class="fas fa-chart-pie mr-1"></i> Booking How to find us Percentage (History) </b></h3>
										<a onclick="graph_load(24)" href="javascript:void(0)" style="float:right;"><i class="fas fa-sync-alt"></i></a>
									</div>
									<div class="card-body custom_design_grph_body" id="graph_load_24"  style="background:url(<?php echo base_url('assets/img/graph/Screenshot_23.png'); ?>);background-size:cover;">
										<center><a onclick="graph_load(24)" href="javascript:void(0);"><i class="fas fa-sync-alt"></i></a></center>
									</div>
								</div>								
							</div>						
							<?php } ?>
						</div>
					</div>
				</div>
				
				<?php if(check_permission('role_1631683584_39')){ ?>
				<div class="row">
					<div class="col-sm-12">						
						<div class="row">
							<div class="col-sm-12" id="dashboard_building_overview">
								<div class="card">
									<div class="card-header" style="padding:15px;">
										<h3 class="card-title">Branch Wise Building Overview</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-card-widget="collapse">
												<i class="fas fa-plus"></i>
											</button>
										</div>
									</div>

									<div class="card-body p-0" style="display:none;">										
										<div class="col-sm-12">
											<button onclick="function_get_booking_overview();" class="btn btn-success" type="button" >View / Refresh</button>
										</div>
										<div class="col-sm-12" id="building_overview_result_dashboard" ></div>
									</div>
								</div>
							</div>						
						</div>						
					</div>
				</div>
				<?php } ?>
				

				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							
							
							<div class="col-sm-8">
								
							</div>
							
						</div>
					</div>
				</div>
				

				
			</div>
		</section>
	</div>
</div>

<script>
function iframeLoaded() {
	var iFrameID = document.getElementById('seat_iframe');
	if(iFrameID) {
		// here you can make the height, I delete it first, then I make it again
		iFrameID.height = "";
		iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
	}   
}


let get_live_booking_employee_table = () => {
	let selected_date = $('#employee_medel_date').val();
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/booking_employee_medel.php');?>",  
		method:"POST",
		data:{ selected_date },
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			console.log(data);	
			$('#live_employee_table_date').html(data);
		}
	});
}

function function_get_booking_overview(){
	var branch_id = $('select[name="dashboard_bbranch_id"]').val();
	if( branch_id != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/dashboard_building_overview.php');?>",  
			method:"POST",
			data:{ branch_id:branch_id },
			beforeSend:function(){ $('#data-loading').html(data_loading); },
			success:function(data){ $('#data-loading').html('');	
				$('#building_overview_result_dashboard').html(data);
			}  
		});  
	}else{
		alert('Please Select a branch!');
	}
}
</script>
<script src="<?php echo base_url('assets/js/cart/canvasjs.min.js'); ?>"></script>
<!--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->