<?php $department=$_SESSION['user_info']['department']; ?>
<!--===NOTIFICATION Panel===--->
<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Notification">
	<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-primary btn_sdo">
		<?php


		$emp_id = $_SESSION['user_info']['employee_id'];
		$emp_info = $this->Dashboard_model->mysqlii("select * from employee where id = '" . $_SESSION['user_info']['employee_id'] . "' and department = '" . $_SESSION['user_info']['department'] . "' and d_head = '1' order by id desc limit 01");
		// $emp_info = $this->Dashboard_model->mysqlii("select * from employee where id = '119' and department = '1383007286312996344' and d_head = '1' order by id desc limit 01");
		if (!empty($emp_info[0]->id)) {
			$hr_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_resign_aprv from employee_resign_request_to_hr where department_head_id = '" . $emp_info[0]->id . "' and aproval = '0'");
			$hr_resign_aprv = (int)$hr_resign_emp_apov[0]->hr_resign_aprv;
		} else {
			$hr_resign_aprv = 0;
		}

		$lw_request = $this->Dashboard_model->mysqlii("select count(*) as lw_request from employee_everyday_withdraw_logs where d_head_id = '" . $emp_id . "' and status = '1' and approval = '0'");
		$lw_request = (int)$lw_request[0]->lw_request;
		if ($lw_request > 0) {
			$lw_request = $lw_request;
		} else {
			$lw_request = 0;
		}

		$lwt_request = $this->Dashboard_model->mysqlii("select count(*) as lwt_request from employee_leave_logs where h_id = '" . $emp_id . "' and status = '1' and ( h_aproval = '0' OR  h_aproval = '3') and aproval = '0'");
		// $lwt_request = $this->Dashboard_model->mysqlii("select count(*) as lwt_request from employee_leave_logs where h_id = '".$emp_id."' and status = '1' and h_aproval = '0' and aproval = '0'");
		$lwt_request = (int)$lwt_request[0]->lwt_request;
		if ($lwt_request > 0) {
			$lwt_request = $lwt_request;
		} else {
			$lwt_request = 0;
		}

		$tt_received = $this->Dashboard_model->mysqlii("select count(*) as tt_received from employee_wallet_money_transfer_logs where receiver_id = '" . $_SESSION['super_admin']['employee_ids'] . "' and status = '1'");
		$tt_received = (int)$tt_received[0]->tt_received;
		if ($tt_received > 0) {
			$tt_received = $tt_received;
		} else {
			$tt_received = 0;
		}





		$head_requirement_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as head_requirement_emp_apov from employee_recruitment_request where department_head_notify = '1' and department = '" . $_SESSION['user_info']['department'] . "'");
		$head_requirement_emp_apov = (int)$head_requirement_emp_apov[0]->head_requirement_emp_apov;
		if (!empty($head_requirement_emp_apov > 0)) {
			$head_requirement_emp_apov = $head_requirement_emp_apov;
		} else {
			$head_requirement_emp_apov = 0;
		}

		$attendance_adjustment_count = 0;
		$performance_approved_count = 0;
		if ($_SESSION['super_admin']['role_id'] == '390647376434090456') {
			$attendance_adjustment = $this->Dashboard_model->mysqlii("SELECT count(*) as total from employee_missing_attendance_request_date where aproval = '0'");
			$attendance_adjustment_count = $attendance_adjustment[0]->total;
			$performance_approved = $this->Dashboard_model->mysqlii("SELECT count(*) as total from employee_increament_approval where notification_status = '1'");
			$performance_approved_count = $performance_approved[0]->total;
			$hr_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_chain_aprv from exit_employee_chain_hr where aproval = '0'");
			$hr_chain_aprv = (int)$hr_resign_emp_apov[0]->hr_chain_aprv;
			if (!empty($hr_chain_aprv > 0)) {
				$hr_chain_aprv = (int)$hr_resign_emp_apov[0]->hr_chain_aprv;
			} else {
				$hr_chain_aprv = 0;
			}

			$hr_requirement_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_requirement_emp_apov from employee_recruitment_request where hr_notify = '1'");
			$hr_requirement_emp_apov = (int)$hr_requirement_emp_apov[0]->hr_requirement_emp_apov;
			if (!empty($hr_requirement_emp_apov > 0)) {
				$hr_requirement_emp_apov = $hr_requirement_emp_apov;
			} else {
				$hr_requirement_emp_apov = 0;
			}
		} else {
			$hr_requirement_emp_apov = 0;
			$hr_chain_aprv = 0;
		}



		$c_exit_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as t_exit_aprv from exit_employee_chain_aproval where e_db_id = '" . $emp_id . "' and aproval = '0'");
		$c_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as t_resign_aprv from employee_resign_request where department_head_id = '" . $emp_id . "' and aproval = '0'");

		if ($_SESSION['user_info']['d_head'] == 1) {
			$d_head_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_dh from employee_ta_da_bill_logs where department_head_id = '" . $emp_id . "' and department_head_aproval = '0'");
			if ($d_head_td_da_aprv[0]->t_tada_apr_dh > 0) {
				$td_da_request_c = $d_head_td_da_aprv[0]->t_tada_apr_dh;
			} else {
				$td_da_request_c = 0;
			}
		} else {
			$td_da_request_c = 0;
		}

		$mobile_allowence_notification = 0;
		if ($_SESSION['user_info']['d_head']) {
			if ($_SESSION['user_info']['department'] == '2392358440567352112' or $_SESSION['user_info']['department'] == '2721298155724163568') { // Housekeeping OR Sales Department
				$mobile_allowence = $this->Dashboard_model->mysqlij("SELECT count(*) as total from increase_mobile_allowance INNER JOIN employee using(employee_id) where employee.department = '" . $_SESSION['user_info']['department'] . "' AND employee.branch = '" . $_SESSION['super_admin']['branch'] . "' AND increase_mobile_allowance.status = 0");
			} else {
				$mobile_allowence = $this->Dashboard_model->mysqlij("SELECT count(*) as total from increase_mobile_allowance INNER JOIN employee using(employee_id) where employee.department = '" . $_SESSION['user_info']['department'] . "' AND increase_mobile_allowance.status = 0");
			}
			$mobile_allowence_notification = $mobile_allowence->total;
		}

		if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') { // super admin
			$c_deduction_apov_acunt = $this->Dashboard_model->mysqlii("select count(*) as t_deduction_aprv_ac from employee_sallary_deduction where aproval = '0'");
			if ($c_deduction_apov_acunt[0]->t_deduction_aprv_ac > 0) {
				$deduction_request = $c_deduction_apov_acunt[0]->t_deduction_aprv_ac;
			} else {
				$deduction_request = 0;
			}

			$c_fired_aprov = $this->Dashboard_model->mysqlii("select count(*) as t_fired_aprv from employee_fired_list where aproval = '0'");
			if ($c_fired_aprov[0]->t_fired_aprv > 0) {
				$c_fired_aprov = $c_fired_aprov[0]->t_fired_aprv;
			} else {
				$c_fired_aprov = 0;
			}

			$d_boss_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_bos from employee_ta_da_bill_logs where department_head_aproval = '1' and boss_aproval = '0'");
			if ($d_boss_td_da_aprv[0]->t_tada_apr_bos > 0) {
				$td_da_request_bos = $d_boss_td_da_aprv[0]->t_tada_apr_bos;
			} else {
				$td_da_request_bos = 0;
			}

			$t_requ_emp = $this->Dashboard_model->mysqlii("select count(*) as t_requ_emp from employee_recruitment_request where boss_aproval = '0'");
			if ($t_requ_emp[0]->t_requ_emp > 0) {
				$t_requ_emp = $t_requ_emp[0]->t_requ_emp;
			} else {
				$t_requ_emp = 0;
			}
		} else {
			$deduction_request = 0;
			$c_fired_aprov = 0;
			$td_da_request_bos = 0;
			$t_requ_emp = 0;
		}

		if ($_SESSION['super_admin']['role_id'] == '1622657840330042228') { //accounts
			$c_loan_emp_apov_acunt = $this->Dashboard_model->mysqlii("select count(*) as t_loan_aprv_ac from employee_grant_loan where e_db_id = '" . $emp_id . "' and aproval_account = '0' AND aproval = '1'");
			if ($c_loan_emp_apov_acunt[0]->t_loan_aprv_ac > 0) {
				$account_loan_request = $c_loan_emp_apov_acunt[0]->t_loan_aprv_ac;
			} else {
				$account_loan_request = 0;
			}

			$d_acc_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_acc from employee_ta_da_bill_logs where boss_aproval = '1' and accounts_aproval = '0' order by id desc");
			if ($d_acc_td_da_aprv[0]->t_tada_apr_acc > 0) {
				$td_da_request_acc = $d_acc_td_da_aprv[0]->t_tada_apr_acc;
			} else {
				$td_da_request_acc = 0;
			}
		} else {
			$account_loan_request = 0;
			$td_da_request_acc = 0;
		}
		$advance_salary_approval = 0;
		if($_SESSION['user_info']['d_head']){
			$grant_loan = $this->Dashboard_model->mysqlij("SELECT COUNT(*) as validate from employee_grant_loan INNER JOIN employee using(employee_id) where employee_grant_loan.aproval = 3 AND employee.department = '".$_SESSION['user_info']['department']."'");
			if($grant_loan->validate > 0){
				$advance_salary_approval = $grant_loan->validate;
			}
		}

		$increament_counter = $this->Dashboard_model->mysqlii("select count(*) as total_approval from employee_increament_logs where aproval = '0'");
		$decreament_counter = $this->Dashboard_model->mysqlii("select count(*) as total_approval from employee_decreament_logs where aproval = '0'");
		$increament_total = $increament_counter[0]->total_approval + $decreament_counter[0]->total_approval;
		
		// This block is add to ensure HR gets notification after boss approved.
		if ($_SESSION['user_info']['department'] == '1383007286312996344') { // HR & Admin 
			$increament_counter = $this->Dashboard_model->mysqlii("select count(*) as total_approval from employee_increament_logs where aproval = '1' and hr_check='0'");
			$decreament_counter = $this->Dashboard_model->mysqlii("select count(*) as total_approval from employee_decreament_logs where aproval = '1' and hr_check='0'");
			$increament_total = $increament_counter[0]->total_approval + $decreament_counter[0]->total_approval;
		}
		
		$requisition_for_warehouse = 0;
		if($_SESSION['user_info']['department'] == '1818976187744468155'){
			$get_warehouse_requisition = $this->Dashboard_model->mysqlij("SELECT count(*) as total from scm_product_requisition where `status` = 1 AND requisition_for = 0");
			$requisition_for_warehouse = $get_warehouse_requisition->total;
		}

		$sent_requisition_for_department = $this->Dashboard_model->mysqlij("SELECT count(*) as total from scm_product_requisition where department_requested_by = '{$_SESSION['user_info']['department']}' AND status = 2");

		$total_task = $this->db->query("SELECT count(status) AS total_status FROM task_list WHERE task_list.department_id='749568347163692080' OR task_list.department_id='$department' AND task_list.status=0")->row();
		$total_tasks=$total_task->total_status;
		
		// d-head product requisition notification B10L
		//'department_requested_by' => $_SESSION['user_info']['department']
		$d_requisition = 0;
		$d_sql = $this->Dashboard_model->mysqlij("select count(id) as num_notification, department_requested_by from scm_product_requisition where ( status='4' or status='10' ) and department_requested_by='{$_SESSION['user_info']['department']}' group by department_requested_by");
		if($_SESSION['user_info']['d_head']){
			if(!empty($d_sql)){
				// and department_requested_by='{$_SESSION['user_info']['department']}'
				if($d_sql->num_notification > 0){
					$d_requisition = $d_sql->num_notification;
				}
			}
			
		}

		$total_notif =
			$d_requisition+
			$total_tasks+
			$td_da_request_acc +
			$td_da_request_bos +
			(int)$c_exit_emp_apov[0]->t_exit_aprv +
			(int)$c_resign_emp_apov[0]->t_resign_aprv +
			$hr_resign_aprv + $account_loan_request + $advance_salary_approval +
			$deduction_request + $c_fired_aprov +
			$td_da_request_c +
			$t_requ_emp +
			$hr_requirement_emp_apov +
			$head_requirement_emp_apov +
			$hr_chain_aprv +
			$tt_received +
			$lw_request +
			$lwt_request +
			$increament_total +
			$mobile_allowence_notification +
			$attendance_adjustment_count +
			$performance_approved_count + 
			$requisition_for_warehouse + 
			$sent_requisition_for_department->total;
		if ($total_notif > 0) {
			$total_notif = $total_notif;
		} else {
			$total_notif = 0;
		}


		?>
		<span class="badge badge-danger right" id="total_notification"><?php echo $total_notif; ?></span>&nbsp;&nbsp;
		<i class="nav-icon far fa-comments" style="font-size: 18px;"></i>
	</a>

	<ul aria-labelledby="dropdownSubMenu1" class="dropleft dropdown-menu border-0 shadow dropdown-menu-righ">
		<?php if ($attendance_adjustment_count > 0) {  ?>
			<li><a href="<?= base_url('admin/hrm/payroll/missing-attendence-request-logs-hr'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $attendance_adjustment[0]->total; ?></span> Attendance Adjustment</a></li>
		<?php }
		if ($performance_approved_count > 0) {  ?>
			<li><a href="<?= base_url('admin/hrm/report/increament-report/green'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $performance_approved[0]->total; ?></span> Salary Increament</a></li>
		<?php } ?>
		<?php if ($requisition_for_warehouse > 0 AND $_SESSION['user_info']['department'] == '1818976187744468155') {  ?>
			<li><a href="<?= base_url('admin/scm/requisitions'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $get_warehouse_requisition->total; ?></span> Warehouse Requisition</a></li>
		<?php } ?>
		
		<?php if ($d_requisition > 0 AND $_SESSION['user_info']['department'] == $d_sql->department_requested_by) {  ?>
			<li><a href="<?= base_url('admin/scm/requisitions'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $d_requisition; ?></span> Product Requisition</a></li>
		<?php } ?>
		
		<?php if ($sent_requisition_for_department->total > 0) {  ?>
			<li><a href="<?= base_url('admin/scm/department-requisitions'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $sent_requisition_for_department->total; ?></span> Sent Requisition </a></li>
		<?php } ?>
		
		<?php if ($lwt_request > 0) {  ?>
			<li><a href="<?= base_url('admin/hrm/payroll/leave-approval-department-head'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $lwt_request; ?></span> Leave Request</a></li>
		<?php } ?>
		<?php if ($lw_request > 0) {  ?>
			<li><a href="<?= base_url('admin/hrm/profile/employee-leave-witdraw-request'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $lw_request; ?></span> Leave Widthraw Request</a></li>
		<?php } ?>
		<?php if ($tt_received > 0) {  ?>
			<li><a href="<?= base_url('admin/profile/employee-award-money-transfer'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $tt_received; ?></span> Received Money</a></li>
		<?php } ?>
		<?php if ($hr_resign_aprv > 0) {  ?>
			<li><a href="<?= base_url('admin/notification/payroll/resign-employee-approval-hr'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $hr_resign_aprv; ?></span> Resign Employee(HR)</a></li>
		<?php } ?>
		<?php if ($c_resign_emp_apov[0]->t_resign_aprv > 0) { ?>
			<li><a href="<?= base_url('admin/notification/payroll/resign-employee-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $c_resign_emp_apov[0]->t_resign_aprv; ?></span> Resign Employee Aproval</a></li>
		<?php }
		if ($c_exit_emp_apov[0]->t_exit_aprv > 0) { ?>
			<li><a href="<?= base_url('admin/notification/payroll/exit-employee-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $c_exit_emp_apov[0]->t_exit_aprv; ?></span> Employee Exit/fire/regin Aproval</a></li>
		<?php } ?>
		<?php
		if ($_SESSION['super_admin']['role_id'] == '390647376434090456') { //HRM admin  
		?>
			<?php if ($hr_chain_aprv > 0) { ?>
				<li><a href="<?= base_url('admin/notification/payroll/fired-employee-chain-approval-hr'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $hr_chain_aprv; ?></span> Employee Fired Aproval</a></li>
			<?php } ?>
			<?php if ($hr_requirement_emp_apov > 0) { ?>
				<li><a href="<?= base_url('admin/hrm/recruitment/recruitment_approved_logs'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $hr_requirement_emp_apov; ?></span> Recruitment Approved Logs</a></li>
			<?php } ?>
			<?php if ($increament_total > 0) { ?>
				<li><a href="<?= base_url('admin/hrm/payroll/increament-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $increament_total; ?></span> Increament / Decrement</a></li>
			<?php } ?>

		<?php  } ?>

		<?php
		if ($account_loan_request > 0) { ?>
			<li><a href="<?= base_url('admin/notification/payroll/accounts-loan-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $account_loan_request; ?></span> Loan Aproval</a></li>
		<?php }
		if ($advance_salary_approval > 0) { ?>
			<li><a href="<?= base_url('admin/hrm/loan/loan-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $advance_salary_approval; ?></span> Advance Salary Aproval</a></li>
		<?php }
		if ($td_da_request_c > 0) { ?>
			<li><a href="<?= base_url('admin/notification/payroll/employee-ta-da-approval/department_head'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $td_da_request_c; ?></span> TA/DA Aproval(D:Head)</a></li>
		<?php }
		if ($td_da_request_bos > 0) { ?>
			<li><a href="<?= base_url('admin/notification/payroll/employee-ta-da-approval/boss'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $td_da_request_bos; ?></span> TA/DA Aproval(Boss)</a></li>
		<?php }
		if ($td_da_request_acc > 0) { ?>
			<li><a href="<?= base_url('admin/notification/payroll/employee-ta-da-approval/account'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $td_da_request_acc; ?></span> TA/DA Aproval(ACC)</a></li>
		<?php }
		if ($head_requirement_emp_apov > 0) { ?>
			<li><a href="<?= base_url('admin/profile/employee-recruitment-request'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $head_requirement_emp_apov; ?></span> Recruitment Request</a></li>
		<?php } ?>
		<?php if ($mobile_allowence_notification > 0) { ?>
			<li><a href="<?= base_url('admin/profile/increase-mobile-allowence-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $mobile_allowence_notification; ?></span> Mobile Allowance Request</a></li>
		<?php } ?>

		<?php if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') { //super admin 
		?>
			<?php if ($increament_total > 0) { ?>
				<li><a href="<?= base_url('admin/hrm/payroll/increament-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $increament_total; ?></span> Increament / Decrement</a></li>
			<?php } ?>

			<?php if ($deduction_request > 0) { ?>
				<li><a href="<?= base_url('admin/notification/payroll/employee-deduction-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $deduction_request; ?></span> Employee Deduction Aproval</a></li>
			<?php } ?>

			<?php if ($c_fired_aprov > 0) { ?>
				<li><a href="<?= base_url('admin/profile/employee-fired-request-aproval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $c_fired_aprov; ?></span> Employee Fired Aproval</a></li>
			<?php } ?>

			<?php if ($t_requ_emp > 0) { ?>
				<li><a href="<?= base_url('admin/notification/payroll/employee-recruitment-approval'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $t_requ_emp; ?></span> Employee Recruitment Aproval</a></li>
			<?php } ?>

		<?php } ?>

		<?php if ($total_tasks > 0) { ?>
			<li><a href="<?= base_url('admin/s_it/tasks'); ?>" class="dropdown-item"><span class="badge badge-danger right"><?php echo $total_tasks; ?></span> Pandding Tasks on Queue</a></li>
		<?php } ?>

		<li><a href="#" class="dropdown-item">-- -- -- --</a></li>
	</ul>
</li>
<!--===Exit NOTIFICATION Panel===--->