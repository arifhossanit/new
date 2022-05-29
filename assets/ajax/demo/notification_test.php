<!--===NOTIFICATION Panel===--->
<?php 
	include("../../../application/config/ajax_config.php");
	$emp_id = $_SESSION['user_info']['employee_id'];						
	$emp_info = $this->Dashboard_model->mysqlii("select * from employee where id = '".$_SESSION['user_info']['employee_id']."' and department = '".$_SESSION['user_info']['department']."' and d_head = '1' order by id desc limit 01");
	// $emp_info = $this->Dashboard_model->mysqlii("select * from employee where id = '119' and department = '1383007286312996344' and d_head = '1' order by id desc limit 01");
	if(!empty($emp_info[0]->id)){
		$hr_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_resign_aprv from employee_resign_request_to_hr where department_head_id = '".$emp_info[0]->id."' and aproval = '0'");
		$hr_resign_aprv = (int)$hr_resign_emp_apov[0]->hr_resign_aprv;			
	}else{
		$hr_resign_aprv = 0;
	}
	
	$lw_request = $this->Dashboard_model->mysqlii("select count(*) as lw_request from employee_everyday_withdraw_logs where d_head_id = '".$emp_id."' and status = '1' and approval = '0'");
	$lw_request = (int)$lw_request[0]->lw_request;
	if($lw_request > 0){
		$lw_request = $lw_request;
	}else{
		$lw_request = 0;
	}
	
	$lwt_request = $this->Dashboard_model->mysqlii("select count(*) as lwt_request from employee_leave_logs where h_id = '".$emp_id."' and status = '1' and ( h_aproval = '0' OR  h_aproval = '3') and aproval = '0'");
	// $lwt_request = $this->Dashboard_model->mysqlii("select count(*) as lwt_request from employee_leave_logs where h_id = '".$emp_id."' and status = '1' and h_aproval = '0' and aproval = '0'");
	$lwt_request = (int)$lwt_request[0]->lwt_request;
	if($lwt_request > 0){
		$lwt_request = $lwt_request;
	}else{
		$lwt_request = 0;
	}
	
	$tt_received = $this->Dashboard_model->mysqlii("select count(*) as tt_received from employee_wallet_money_transfer_logs where receiver_id = '".$_SESSION['super_admin']['employee_ids']."' and status = '1'");
	$tt_received = (int)$tt_received[0]->tt_received;
	if($tt_received > 0){
		$tt_received = $tt_received;
	}else{
		$tt_received = 0;
	}
	
	
	
	
	
	$head_requirement_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as head_requirement_emp_apov from employee_recruitment_request where department_head_notify = '1' and department = '".$_SESSION['user_info']['department']."'");
	$head_requirement_emp_apov = (int)$head_requirement_emp_apov[0]->head_requirement_emp_apov;
	if(!empty($head_requirement_emp_apov > 0)){
		$head_requirement_emp_apov = $head_requirement_emp_apov;
	}else{
		$head_requirement_emp_apov = 0;
	}
	
	
	if($_SESSION['super_admin']['role_id'] == '390647376434090456'){
		$hr_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_chain_aprv from exit_employee_chain_hr where aproval = '1'");
		$hr_chain_aprv = (int)$hr_resign_emp_apov[0]->hr_chain_aprv;
		if(!empty($hr_chain_aprv > 0)){
			$hr_chain_aprv = (int)$hr_resign_emp_apov[0]->hr_chain_aprv;
		}else{
			$hr_chain_aprv = 0;
		}
		
		$hr_requirement_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_requirement_emp_apov from employee_recruitment_request where hr_notify = '1'");
		$hr_requirement_emp_apov = (int)$hr_requirement_emp_apov[0]->hr_requirement_emp_apov;
		if(!empty($hr_requirement_emp_apov > 0)){
			$hr_requirement_emp_apov = $hr_requirement_emp_apov;
		}else{
			$hr_requirement_emp_apov = 0;
		}
		
		
	}else{
		$hr_requirement_emp_apov = 0;
		$hr_chain_aprv = 0;
	}

		
	
	$c_exit_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as t_exit_aprv from exit_employee_chain_aproval where e_db_id = '".$emp_id."' and aproval = '0'");
	$c_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as t_resign_aprv from employee_resign_request where department_head_id = '".$emp_id."' and aproval = '0'");
	
	if($_SESSION['user_info']['d_head'] == 1 ){
		$d_head_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_dh from employee_ta_da_bill_logs where department_head_id = '".$emp_id."' and department_head_aproval = '0'");
		if($d_head_td_da_aprv[0]->t_tada_apr_dh > 0){
			$td_da_request_c = $d_head_td_da_aprv[0]->t_tada_apr_dh;
		}else{
			$td_da_request_c = 0;
		}	
	}else{
		$td_da_request_c = 0;
	}
	
	if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ // super admin
		$c_deduction_apov_acunt = $this->Dashboard_model->mysqlii("select count(*) as t_deduction_aprv_ac from employee_sallary_deduction where aproval = '0'");
		if($c_deduction_apov_acunt[0]->t_deduction_aprv_ac > 0){
			$deduction_request = $c_deduction_apov_acunt[0]->t_deduction_aprv_ac;
		}else{
			$deduction_request = 0;
		}
		
		$c_fired_aprov = $this->Dashboard_model->mysqlii("select count(*) as t_fired_aprv from employee_fired_list where aproval = '0'");
		if($c_fired_aprov[0]->t_fired_aprv > 0){
			$c_fired_aprov = $c_fired_aprov[0]->t_fired_aprv;
		}else{
			$c_fired_aprov = 0;
		}
		
		$d_boss_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_bos from employee_ta_da_bill_logs where department_head_aproval = '1' and boss_aproval = '0'");
		if($d_boss_td_da_aprv[0]->t_tada_apr_bos > 0){
			$td_da_request_bos = $d_boss_td_da_aprv[0]->t_tada_apr_bos;
		}else{
			$td_da_request_bos = 0;
		}
		
		$t_requ_emp = $this->Dashboard_model->mysqlii("select count(*) as t_requ_emp from employee_recruitment_request where boss_aproval = '0'");
		if($t_requ_emp[0]->t_requ_emp > 0){
			$t_requ_emp = $t_requ_emp[0]->t_requ_emp;
		}else{
			$t_requ_emp = 0;
		}
		
	}else{
		$deduction_request = 0;
		$c_fired_aprov = 0;
		$td_da_request_bos = 0;
		$t_requ_emp = 0;
	}
	
	if($_SESSION['super_admin']['role_id'] == '1622657840330042228'){ //accounts
		$c_loan_emp_apov_acunt = $this->Dashboard_model->mysqlii("select count(*) as t_loan_aprv_ac from employee_grant_loan where e_db_id = '".$emp_id."' and aproval_account = '0'");
		if($c_loan_emp_apov_acunt[0]->t_loan_aprv_ac > 0){
			$account_loan_request = $c_loan_emp_apov_acunt[0]->t_loan_aprv_ac;
		}else{
			$account_loan_request = 0;
		}

		$d_acc_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_acc from employee_ta_da_bill_logs where boss_aproval = '1' and accounts_aproval = '0' order by id desc");
		if($d_acc_td_da_aprv[0]->t_tada_apr_acc > 0){
			$td_da_request_acc = $d_acc_td_da_aprv[0]->t_tada_apr_acc;
		}else{
			$td_da_request_acc = 0;
		}	
	}else{
		$account_loan_request = 0;
		$td_da_request_acc = 0;
	}	

	$increament_counter = $this->Dashboard_model->mysqlii("select count(*) as total_approval from employee_increament_logs where aproval = '0'");
	$decreament_counter = $this->Dashboard_model->mysqlii("select count(*) as total_approval from employee_decreament_logs where aproval = '0'");
	$increament_total = $increament_counter[0]->total_approval + $decreament_counter[0]->total_approval;

	
	
	
	
	$total_notif = 
		$td_da_request_acc + 
		$td_da_request_bos + 
		(int)$c_exit_emp_apov[0]->t_exit_aprv + 
		(int)$c_resign_emp_apov[0]->t_resign_aprv + 
		$hr_resign_aprv + $account_loan_request + 
		$deduction_request + $c_fired_aprov + 
		$td_da_request_c +
		$t_requ_emp +
		$hr_requirement_emp_apov +
		$head_requirement_emp_apov +
		$hr_chain_aprv +
		$tt_received +
		$lw_request +
		$lwt_request +
		$increament_total
	;
	if($total_notif > 0){
		$total_notif = $total_notif; 
	}else{
		$total_notif = 0;
	}
	$info = array(
		'total_notification' => $total_notif,
		'leave' => $lwt_request,
	);
	echo json_encode($info);
?>
<!--===Exit NOTIFICATION Panel===--->