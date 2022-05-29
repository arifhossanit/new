<?php if (!empty($_SESSION['super_admin']['user_type']) and $_SESSION['super_admin']['user_type'] == 'Super Admin') { ?>
	<?php
	$increament_counter = $this->Dashboard_model->mysqlii("select count(*) as total_approval from employee_increament_logs where aproval = '0'");
	$decreament_counter = $this->Dashboard_model->mysqlii("select count(*) as total_approval from employee_decreament_logs where aproval = '0'");
	$increament_total = $increament_counter[0]->total_approval + $decreament_counter[0]->total_approval;

	$e_requesti = $this->Dashboard_model->mysqlii("SELECT count(*) as total_adavance FROM advance_money_request where status = '1'");
	$e_requesti1 = $this->Dashboard_model->mysqlii("SELECT count(*) as total_loan FROM employee_grant_loan where aproval = '0'");
	if($_SESSION['super_admin']['employee_id'] == 113){
		$e_requesti2 = $this->Dashboard_model->mysqlii("SELECT count(*) as total_loan FROM employee_leave_logs INNER JOIN employee using(employee_id) where employee_leave_logs.aproval = '0' AND ( employee_leave_logs.h_aproval = '1' OR employee_leave_logs.h_aproval = '3' ) AND employee.department = '687558693128511379'");
	}else{
		$e_requesti2 = $this->Dashboard_model->mysqlii("SELECT count(*) as total_loan FROM employee_leave_logs where aproval = '0' AND ( h_aproval = '1' OR h_aproval = '3' )");
	}
	// $e_requesti2 = $this->Dashboard_model->mysqlii("SELECT count(*) as total_loan FROM employee_leave_logs where aproval = '0'");
	$e_requesti3 = $this->Dashboard_model->mysqlii("SELECT count(*) as total FROM employee_recruitment_request where boss_aproval = '0'");
	$e_requesti4 = $this->Dashboard_model->mysqlii("SELECT count(*) as total FROM employee_ta_da_bill_logs where department_head_aproval = '1' and boss_aproval = '0'");
	$e_requesti5 = $this->Dashboard_model->mysqlii("SELECT count(*) as total FROM employee_resign_request where aproval = '0' AND department_head_id = " . $_SESSION['super_admin']['employee_id']);
	$e_requesti6 = $this->Dashboard_model->mysqlii("SELECT count(*) as total FROM advance_petty_cash_return_logs where aproval = '0'");
	$e_requesti7 = $this->Dashboard_model->mysqlii("SELECT count(*) as total FROM employee_missing_attendance_request_date where aproval = '0' and is_hr_checked = '1'");
	$e_requesti8 = $this->Dashboard_model->mysqlii("SELECT count(*) as total,month_year FROM employee_performance_logs where aproval = '0' group by month_year ");	
	$e_requesti9 = $this->Dashboard_model->mysqlii("SELECT COUNT(*) as total from `increase_mobile_allowance` INNER JOIN `increase_mobile_allowance_approval_logs` on increase_mobile_allowance.id = increase_mobile_allowance_approval_logs.mobile_allowence_id INNER JOIN employee on employee.employee_id = increase_mobile_allowance_approval_logs.employee_id where increase_mobile_allowance.status = 1 AND employee.d_head_reporting = " . $_SESSION['super_admin']['employee_id']);


	$today = new DateTime(date('Y-m-d'));
	$first_day_of_month = new DateTime($today->format('Y-m-') . '01');
	$fifth_day_of_month = new DateTime($today->format('Y-m-') . '05');
	$pending_d_head_performance = 0;
	if ($today >= $first_day_of_month && $today <= $fifth_day_of_month) {
		$e_requesti10 = $this->Dashboard_model->mysqlij("SELECT COUNT(*) as id_count from `employee` LEFT JOIN `employee_performance_logs` on employee_performance_logs.employee_id = employee.employee_id AND employee_performance_logs.month_year = '" . $today->format('m/Y') . "' where employee.d_head = 1 AND employee.status = 1 AND employee.d_head_reporting = '" . $_SESSION['super_admin']['employee_id'] . "' AND employee_performance_logs.id is null");
		$pending_d_head_performance = $e_requesti10->id_count;
	}

	$e_requesti11 = $this->Dashboard_model->mysqlii("SELECT COUNT(*) as total from `scm_product_requisition` where `status` = 0");
	$e_requesti12 = $this->Dashboard_model->mysqlii("SELECT COUNT(*) as total from `scm_pre_purchase_order` where `status` = 0");
	$e_requesti13 = $this->Dashboard_model->mysqlii("select count(*) as total from employee_everyday_withdraw_logs where d_head_id = '" . $_SESSION['super_admin']['employee_id'] . "' and status = '1' and approval = '0'");

	// $e_requesti14 = $this->Dashboard_model->mysqlii("SELECT count(*) as total from scm_product_requisition where `status` = 0");


	$total_value =
		$increament_total +
		$e_requesti[0]->total_adavance +
		$e_requesti1[0]->total_loan +
		$e_requesti2[0]->total_loan +
		$e_requesti3[0]->total +
		$e_requesti4[0]->total +
		$e_requesti5[0]->total +
		$e_requesti6[0]->total +
		$e_requesti7[0]->total +
		$e_requesti9[0]->total +
		$pending_d_head_performance +
		$e_requesti11[0]->total +
		$e_requesti12[0]->total +
		$e_requesti13[0]->total;
	if(!empty($e_requesti8)){
		$total_value += $e_requesti8[0]->total;
	}









	if ($total_value > 0) {
	?>

		<div class="modal fade" id="home_notice_board_modal">
			<div class="modal-dialog modal-xl" style="background:none !important;width:1138px !important;">
				<div class="modal-content" style="background:none !important;width:1138px !important;">
					<div class="modal-body" style=" padding:0px; background:url(<?php echo base_url('assets/img/Notic-board.png'); ?>) !important; background-size: contain !important; min-height: 709px; width:1138px !important; border-radius: 7px; ">
						<div class="col-sm-12" style="margin-top:60px;">
							<center>
								<link rel="preconnect" href="https://fonts.gstatic.com">
								<link href="https://fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">
								<h1 style="font-weight: bolder;font-family: 'Handlee', cursive;color:#000;text-decoration:underline;">Aproval Notice Board!</h1>
							</center>
						</div>
						<div id="frame" class="col-sm-12" style="margin:30px 106px;height: 510px;width: 925px; overflow-y: scroll;font-family: 'The Girl Next Door', cursive;">
							<?php if ($e_requesti4[0]->total > 0) { ?>
								<a href="<?php echo base_url('admin/notification/payroll/employee-ta-da-approval/boss'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										TA/DA Aproval
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti4[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>							

							<?php if ($e_requesti13[0]->total > 0) { ?>
								<a href="<?php echo base_url('admin/hrm/profile/employee-leave-witdraw-request'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Leave Withdraw Aproval
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti13[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($e_requesti11[0]->total > 0) { ?>
								<a href="<?php echo base_url('admin/scm/requisitions'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Product Requisition Approval
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti11[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if (false) { ?>
								<a href="<?php echo base_url('admin/scm/manage-product-purchase'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Pre-Purchase Order
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti12[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($e_requesti3[0]->total > 0) { ?>
								<a href="<?php echo base_url('admin/notification/payroll/employee-recruitment-approval'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Recruitment Aproval
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti3[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($pending_d_head_performance > 0) { ?>
								<a href="<?php echo base_url('admin/profile/employee-performance-request'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										D.Head Performance Pending
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $pending_d_head_performance; ?>
										</span>
									</div>
								</a>
							<?php } ?>


							<?php if ($increament_total > 0) { ?>
								<a href="<?php echo base_url('admin/hrm/payroll/increament-approval'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Increament / Decrement
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $increament_total; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($e_requesti[0]->total_adavance > 0) { ?>
								<a href="<?php echo base_url('admin/accounting/transaction/advance-petty-cash'); ?>" target="_blank" class="note sticky2">
									<div class='pin'></div>
									<div class='text'>
										Advance Money Request
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti[0]->total_adavance; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($e_requesti1[0]->total_loan > 0) { ?>
								<a href="<?php echo base_url('admin/hrm/loan/loan-approval'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Advance Salary Aproval
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti1[0]->total_loan; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($e_requesti2[0]->total_loan > 0) { ?>
								<a href="<?php echo base_url('admin/hrm/payroll/leave-approval'); ?>" target="_blank" class="note sticky2">
									<div class='pin'></div>
									<div class='text'>
										Leave Approval
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti2[0]->total_loan; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($e_requesti5[0]->total > 0) { ?>
								<a href="<?php echo base_url('admin/notification/payroll/resign-employee-approval'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Resign Aproval
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti5[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($e_requesti6[0]->total > 0) { ?>
								<a href="<?php echo base_url('admin/accounting/transaction/advance-petty-cash-return-approval'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Rest of Amount Return
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti6[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>

							<?php if ($e_requesti7[0]->total > 0) { ?>
								<a href="<?php echo base_url('admin/profile/attendance-adsjustment-boss-aproval'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Missing Attendance
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti7[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>
							<?php
							if (count($e_requesti8) > 0) { ?>
								<div target="_blank">
									<div class='pin'></div>
									<div class='text'>
										<?php
										foreach ($e_requesti8 as $row) { ?>
											<a href="<?php echo base_url('admin/hrm/award/performance-approval/' . str_replace('/', '-', $row->month_year)); ?>" class="note sticky1">
												<span style="font-size: 10pt;">Performance Approval</span>
												<hr style="margin:0px;" />
												<span style="font-size:11pt;padding:0;margin:0;"><?php print date("F", mktime(0, 0, 0, substr($row->month_year, 0, 2), 10)) . '-' . substr($row->month_year, 3, 4); ?></span>
												<br>
												<p style="font-size:14pt;padding:0;margin:0;text-align:center;border:violet solid 3px;padding:5px;width:60px;margin-left:auto;margin-right:auto;margin-top:10px;"><?= $row->total ?></p>
											</a>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<?php if ($e_requesti9[0]->total > 0) { ?>
								<a href="<?php echo base_url('admin/profile/increase-mobile-allowence-approval'); ?>" target="_blank" class="note sticky1">
									<div class='pin'></div>
									<div class='text'>
										Mobile Allowance Approval
										<hr style="margin:0px;" />
										<span style="font-size: 35px;">
											<?php echo $e_requesti9[0]->total; ?>
										</span>
									</div>
								</a>
							<?php } ?>

						</div>
						<style>
							.note {
								width: 160px;
								height: 160px;
								padding: 10px;
								box-shadow: 0 3px 6px rgba(0, 0, 0, .25);
								-webkit-box-shadow: 0 3px 6px rgba(0, 0, 0, .25);
								-moz-box-shadow: 0 3px 6px rgba(0, 0, 0, .25);
								float: left;
								margin: 8px;
								border: 1px solid rgba(0, 0, 0, .25);
								background-color: #faffb2;
							}

							.pin {
								height: 10px;
								width: 10px;
								border-radius: 10px;
								background-color: #333;
							}

							.sticky1 {
								transform: rotate(-3.5deg);
								-webkit-transform: rotate(-3.5deg);
								-moz-transform: rotate(-3.5deg);
								background-color: #CBFAFA;
							}

							div#frame a:nth-child(3n) .pin {
								background-image: -moz-radial-gradient(45px 45px 45deg, circle cover, yellow 50%, black 100%);
								background-image: -webkit-radial-gradient(45px 45px, circle cover, yellow, black);
								background-image: radial-gradient(yellow 50%, black 100%);
							}

							.text {
								margin: 10px;
								font-family: 'The Girl Next Door', cursive;
							}

							div#frame a:hover.note {
								border: 1px solid rgba(0, 0, 0, .75);
								-webkit-transform: scale(1.1);
								-moz-transform: scale(1.1);
								transform: scale(1.1);
							}
						</style>
					</div>
				</div>
			</div>
		</div>
<?php }
} ?>
<?php include("employee_birthday_alert.php"); ?>
<?php include("employee_aniversary_alert.php"); ?>
<?php include("member_birthday_and_year_completation_alert.php"); ?>
<div class="modal fade" id="video_tutorials_modal">
	<div class="modal-dialog modal-xl" style="background:none !important;">
		<div class="modal-content" style="background:none !important;">
			<div class="modal-body" style="padding:0px;background:none !important;">
				<iframe style="width:100%;" height="720" id="video_frame" src="#" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="life_history_modal">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header btn-info">
				<h4 class="modal-title">My History</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="life_history_modal_result">

			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="occupency_target_modal">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header btn-warning">
				<h4 class="modal-title">Warning</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h3 style="color:#f00;text-align:center;">
					Please Add Occupency Target Of this Month!<br />
					<a href="<?php echo base_url('admin/booking/booking-target-setup'); ?>">Go to Target Setup Page</a>
					<h3>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="view_calculator_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header btn-dark">
				<h4 class="modal-title">Calculator</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body" id="view_calculator_modal_result">

			</div>
		</div>
	</div>
</div>
<!----vaiw booking model-->
<div class="modal fade" id="member_prifile_model_global">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?= current_url(); ?>" method="post">
				<div class="modal-header btn-success">
					<h4 class="modal-title">Booking information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="members_result_global"></div>
			</form>
		</div>
	</div>
</div>
<!----End vaiw booking model-->

<div class="modal fade" id="view_branch_wise_up_down_modal">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header btn-info">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-6">
							<h4 class="modal-title">Branch Wise Up & Down</h4>
						</div>
						<div class="col-sm-3">
							<select id="month_value" onchange="return view_branch_wise_up_down()" class="form-control select2">
								<option value="1">1 Month</option>
								<option value="2">2 Month</option>
								<option value="3">3 Month</option>
								<option value="4">4 Month</option>
								<option value="5">5 Month</option>
								<option value="6">6 Month</option>
								<option value="7">7 Month</option>
								<option value="8">8 Month</option>
								<option value="9">9 Month</option>
								<option value="10">10 Month</option>
								<option value="11">11 Month</option>
								<option value="12">12 Month</option>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body" id="view_branch_wise_up_down_modal_result">

			</div>
		</div>
	</div>
</div>