<style type="stylesheet">
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Performance</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Award</a></li>
						<li class="breadcrumb-item active">Employee Performance</li>
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
								
						<div class="col-sm-12">
							<div class="card card-success">
								<div class="card-header">
									Performance Logs
								</div>
								<?php 
									$current_year_month = date('Y-m'); 
									$minus_one_month = date('Y-m', strtotime(date('Y-m').(' -1 month')));
								?>
								<div class="row">
									<div class="col-md-2 mb-3" style="float: left;margin-top:20px;padding-left:20px;">
										<form id="YearMonthForm" name="MONTH_YEAR" action="<?php print current_url()?>" method="POST" enctype="multipart/form-data">
											<input id="CurrentMonth" name="CurrentMonth" class="form-control" type="month" value="<?php print $last_year.'-'.$last_month; ?>" max="<?php print $current_year_month; ?>" onchange="change_month()" required>
										</form>
									</div>
									<div class="col-md-6 mb-3" style="float: left;margin-top:20px;">
										<?php if(empty($last_year)){ ?>
											<h4 style="margin-top: 10px;font-size:16pt;font-weight:900;margin-left:22vw;color:brown;">Please Select a month!</h4>  
										<?php }?>
									</div>
									<div class="col-md-4 mb-3" style="float: left;margin-top:20px;">
										<button class="btn btn-danger btn-sm all-delete-button" style="display: none;float:right;margin-right:5px;" data-toggle="modal" data-target="#RemoveAllPendingRequestModal">
											Remove selected pending request
										</button>
											<!-- Remove All Pending Request Modal Modal start -->
											<div class="modal fade" id="RemoveAllPendingRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
													<div>
														<center style="color:red;font-weight:900;font-size:18pt;padding:10px;border:2px solid red;margin:10px;background-color:red;color:white;">Be Aware!</center>
													</div>
													<div class="modal-body">
														<p style="color:red;font-size:15pt;text-align:justify;font-weight:900;">You are going to remove all pending performance request!</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
														<button type="button" class="btn btn-warning" onclick="SubmitRemovePerformanceForm()">Okay</button>
													</div>
													</div>
												</div>
											</div>
											<script>
												function SubmitRemovePerformanceForm(){
													event.preventDefault();
													var countHowManyForms = document.querySelectorAll('input[type="checkbox"]:checked').length;
													for (let i = 0; i < countHowManyForms; i++) {
															let GetRemoveFormID = document.getElementsByClassName('performanceRemoveFormClass')[i].getAttribute("id");
															var form = $('#'+GetRemoveFormID);
															event.preventDefault();
															$.post('<?=current_url();?>', $(form).serialize())
													}
													location.href="<?php print base_url('admin/profile/employee-performance-request') ?>";
												}
											</script>
											<!-- Remove All Pending Request Modal Modal end -->
										<button class="btn btn-success btn-sm all-submit-button" style="display: none;float:right;margin-right:5px;" data-toggle="modal" data-target="#SubmitAllPendingRequestModal">
											Submit selected performance
										</button>
												<!-- Submit All Selected Performance Request Modal Modal start -->
												<div class="modal fade" id="SubmitAllPendingRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
														<div>
															<center style="color:red;font-weight:900;font-size:18pt;padding:10px;border:2px solid green;margin:10px;background-color:red;color:white;">Be Aware!</center>
														</div>
														<div class="modal-body">
															<p style="color:red;font-size:15pt;text-align:justify;font-weight:900;">You are going to submit all selected performance request!</p>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
															<button type="button" class="btn btn-warning" onclick="SubmitAllPerformanceForm()">Okay</button>
														</div>
														</div>
													</div>
												</div>
												<script>
													function SubmitAllPerformanceForm(){
														event.preventDefault();
														var countHowManySubmitForms = document.querySelectorAll('input[type="checkbox"]:checked').length;
														for (let j = 0; j < countHowManySubmitForms; j++) {
																let GetSubmitFormID = document.getElementsByClassName('performanceAddFormClass')[j].getAttribute("id");
																var form = $('#'+GetSubmitFormID);
																event.preventDefault();
																$.post('<?=current_url();?>', $(form).serialize())
																}
														location.href="<?php print base_url('admin/profile/employee-performance-request') ?>";
													}
												</script>
											<!-- Submit All Selected Performance Request Modal Modal start -->
										</div>
								</div>
								<div class="card-body" style="height:80vh;overflow-x:scroll;">
									<table class="table table-sm table-bordered" id="example5">
										<thead>
											<tr>
												<th>#</th>
												<th style="width:15vw;" class="sticky-header">Name</th>
												<th style="width:15vw;" class="sticky-header">Employee ID</th>
												<th>Branch</th>
												<th style="width:60px;" class="sticky-header">Percentage</th>
												<th style="width:100px;" class="sticky-header">Year/Month</th>
												<th style="width:80px" class="sticky-header">Aproval</th>
												<th style="width:20vw;" class="sticky-header">Note</th>
												<th style="width:40px;" class="sticky-header">Type</th>
												<th style="width:80px" class="sticky-header">Option</th>
											</tr>
										</thead>
										<tbody style="height:300px !important;overflow-x:scroll;">
										<?php
										 if(!empty($last_year)){ if(!empty($a)){ foreach($a as $key=>$LoopRow){?>
										 <?php 
										 	$attendance = $this->Dashboard_model->mysqlij("SELECT count(*) as total from employee_attendence where employee_id = '".$LoopRow->employee_id."' AND month = '".(int)$last_month."' AND years = '".substr($last_year, 2, 2)."'"); 
											 if($attendance->total == 0){
												 continue;
											 }
										 ?>
											<tr>
												<td style="width:50px;">
												<?php if($LoopRow->aproval !== '1' && empty($LoopRow->salary_already_given)){ ?>
													<input onchange="checkBoxChangeFunction(this)" id="<?php print 'checkBox_'.$key ?>" value="<?php print $key ?>" class="selectCheckboxClass" style="width:50px;margin-left:auto;margin-right:auto;height:20px;margin-top:4vh;" type="checkbox"/>
												<?php }else if(!empty($LoopRow->salary_already_given)){
													print "<span style='text-align:center;font-size:11pt;font-weight:600;color:red;'>Salary Already Given!</span>";
												} ?>
												</td>
												<td style="width:15vw;">
													<img src="<?php print base_url().$LoopRow->photo ?>" style="width:100px;height:100px;">
													<span style="padding-left: 5px;">
														<?php print $LoopRow->full_name ?>
													</span>
												</td>
												<td>
													<?php print $LoopRow->employee_id; ?>
												</td>
												<td>
												<?php print $LoopRow->BranchName; ?>
												</td>
												<form id="<?php print "submit_form_id_".$key; ?>" action="<?php print current_url(); ?>" method="POST" enctype="multipart/form-data">
												<input type="hidden" name="submit_method" value="submit">
												<td style="width:60px;">
													<input name="employee_id" id="employee_id" value="<?php print $LoopRow->employee_id; ?>" type="hidden" >
													<input value="0" type="hidden" name="bonus_type" id="<?php print $LoopRow->employee_id.'_pay_cut'; ?>">
													<input type="number" 
																		id="<?php print $LoopRow->employee_id.'_percentage';?>" 
																		name="percentage" 
																		max='30' 
																		min="-30" 
																		value="<?php print ($LoopRow->pay_cut == '1') ? ( -1 * $LoopRow->percentage ) : $LoopRow->percentage; ?>" 
																		style="border:none;outline:none;width:100%;height:110px;padding-left:30%;padding-right:10px;font-weight:600;font-size:12pt;
																		<?php echo ($LoopRow->pay_cut == '1') ? 'color:red;' : 'color:green;'; ?>"  
																		<?php if(!empty($LoopRow->salary_already_given)){print 'readonly';} ?> 
																		required 
																		onchange="setBonusType(this,'<?php print $LoopRow->employee_id?>');" 
																		onkeyup="setBonusType(this,<?php print $LoopRow->employee_id?>);" 
																		<?php if($LoopRow->aproval === '0' || $LoopRow->aproval === '1'){print 'readonly';} ?>
													>
												</td>
												<td style="width:100px;">
													<input type="text" name="selected_month" value="<?php if(is_null($LoopRow->year)){ print $last_year.'-'.$last_month;}else{
														print $LoopRow->year.'-'.$LoopRow->month;
													} ?>" style="border:none;outline:none;width:100px;" readonly required>	
												</td>
												<td style="width:80px">
													<?php if($LoopRow->aproval === '1'){ ?>
														<span class="badge badge-success" style="width:100%;margin-left:auto;margin-right:auto;padding:7px;margin-top:20px;">Approved</span>
													<?php } ?>
													<?php if($LoopRow->aproval === '0'){ ?>
														<span class="badge badge-warning" style="width:100%;margin-left:auto;margin-right:auto;padding:7px;margin-top:20px;">Pending</span>
													<?php }?>
													<?php if(is_null($LoopRow->aproval)){?>
														<span class="badge badge-warning" style="width:100%;margin-left:auto;margin-right:auto;padding:7px;margin-top:20px;">Not Requested</span>
													<?php } ?>
												</td>
												<td style="width:20vw;">
													<textarea name="note" style="border:none;outline:none;width:100%;height:100px;" required ><?php print $LoopRow->note ?></textarea>
												</td>
												<td style="width:40px;">
													<?php if($LoopRow->pay_cut === '1'){?> 
														<span class="badge badge-danger" style="width:100%;margin-left:auto;margin-right:auto;padding:7px;margin-top:20px;">Penalty</span> <?php }elseif($LoopRow->pay_cut === '0'){ ?>  
														<span class="badge badge-primary" style="width:100%;margin-left:auto;margin-right:auto;padding:7px;margin-top:20px;">Bonus</span> <?php }else{ ?> 
														<span class="badge badge-warning" style="width:100%;margin-left:auto;margin-right:auto;padding:7px;margin-top:20px;">Not Given</span>
														<?php } ?>
												</td>
												<td style="width:80px">
												<?php
												$deduction = (strtotime($minus_one_month))-(strtotime($LoopRow->year.'-'.$LoopRow->month));

												if((is_null($LoopRow->delete_id)) && 
												($LoopRow->aproval !== 2) && 
												($_SESSION['user_info']['d_head'] === '1') &&
												(empty($LoopRow->salary_already_given)) &&
												($deduction == 1633024800 || $deduction == 0) &&
												$LoopRow->pay_cut !== '1' &&
												(empty($LoopRow->pay_cut) || (($LoopRow->pay_cut === '0') && ($LoopRow->aproval === '0')))
												)
													{ ?>

													<button type="submit" name="save" class="btn btn-xs btn-success" style="width:100%;margin-bottom:15px;margin-top:15px;" >Submit</button>

												<?php }?>

													</form>
													<form id="<?php print "remove_form_id_".$key ?>" action="<?php print current_url(); ?>" method="post">
														<input type="hidden" name="delete_id" value="<?php print $LoopRow->delete_id; ?>"/>
														<input type="hidden" name="delete_data" value="<?php print $LoopRow->delete_id; ?>"/>

														<?php 
														if(empty($LoopRow->salary_already_given) && 
														$_SESSION['user_info']['d_head'] === '1' && 
														$LoopRow->aproval !== '1' &&
														(!empty($LoopRow->percentage) || $LoopRow->percentage === '0')
														)
														{?>

															<button type="submit" name="delete_data"  class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to Remove <?php print $LoopRow->full_name.' - '.$LoopRow->employee_id; ?>?')" style="width:100%;margin-left:auto;margin-right:auto;font-weight:600;" >Remove</button>

														<?php }?>
													</form>
												</td>
											</tr>
											<?php }
										}} ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<script>
	$('#example5').DataTable();
	let verify_bonus_for_d_head = () => {
		let employee_id = $('#employee_id').val();
		let selected_month = $('#selected_month').val();
		$.ajax({
			url: "<?=base_url('assets/ajax/form_submit/hrm/leave/verify_d_head_bonus.php'); ?>",
			method:'POST',
			data:{employee_id, selected_month},
			success:function(response) {
				let info = JSON.parse(response);
				if(info.status){
					$('.bonus').show();
					$('#pay_cut').prop('required', true);
				}else{
					$('.bonus').hide();
					$('#pay_cut').prop('required', false);
				}
			}     
		});
	}
</script>
<script>
	function setBonusType(field,employee_id){
		var currentPercentage = field.value;
		var mathSign = Math.sign(currentPercentage);
		var id_of_pay_cut = employee_id+'_pay_cut';
		var id_of_percentage_input_field = field.id;
		setTimeout(function(){ 
			if(mathSign === -1){
				document.getElementById(id_of_pay_cut).value = 1;
				document.getElementById(id_of_percentage_input_field).style.color = 'red';
				}else{
					document.getElementById(id_of_pay_cut).value = 0;
					document.getElementById(id_of_percentage_input_field).style.color = 'green';
			}
		}, 1000);
		
	}
</script>
<script>
	function change_month(){
			document.getElementById("YearMonthForm").submit();
			return false;
	}
</script>
<script>
function checkBoxChangeFunction(field) {

	var countChekedCheckbox = document.querySelectorAll('input[type="checkbox"]:checked').length;
	if(countChekedCheckbox < 1){
		$("#submit_form_id_1").removeClass('performanceAddFormClass');
		$("#remove_form_id_1").removeClass('performanceRemoveFormClass');
	}

	var lastVal = field.value;
	var checkBoxId = 'checkBox_'+lastVal;
	
	var submit_form_id = 'submit_form_id_'+lastVal;
	var remove_form_id = 'remove_form_id_'+lastVal;

    if(countChekedCheckbox > 0) {
		
			$(".all-submit-button").hide();
			$(".all-delete-button").hide();
			$(".all-submit-button").show();
			$(".all-delete-button").show();

			
			if($("#"+checkBoxId).is(':checked')){
				$("#"+submit_form_id).addClass('performanceAddFormClass');
				$("#"+remove_form_id).addClass('performanceRemoveFormClass');
			}else{
				$("#"+submit_form_id).removeClass('performanceAddFormClass');
				$("#"+remove_form_id).removeClass('performanceRemoveFormClass');
				}
						

    		}else{
				$(".all-submit-button").show();
				$(".all-delete-button").show();
				$(".all-submit-button").hide();
				$(".all-delete-button").hide();
			}
}
</script>