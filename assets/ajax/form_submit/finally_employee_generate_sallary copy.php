<?php 
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
// print_r($_SESSION['generated_salary'][0]);
// exit();
if(isset($_POST['sallary_token'])){
	$unique_id = date("d_m_Y").'_'.md5( rand() * time() );
	$year = $_POST['year_id'];
	$year_attendance = substr($_POST['year_id'],2);
	$month = sprintf("%02d", $_POST['month_id']);
	$month_attendance = $_POST['month_id'];
	$total_number_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
	
	$check_year_month = mysqli_fetch_assoc($mysqli->query("select count(*) as total_salaray_generate from employee_sallary_generate_logs where month = '".$month."' and year = '".$year."'"));
	
	
	if(!empty($check_year_month['total_salaray_generate']) AND $check_year_month['total_salaray_generate'] == 2 ){
		$info = array(
			'message' => 'Sallary Allready Generate for ('.$year.' - '.$month.') 2 Times'
		);
		echo json_encode($info);
	}else{
		// print_r($_POST['view_salary']);
		// if(isset($_POST['view_salary'])){
		if(isset($_POST['final_generation'])){
			if(isset($_SESSION['generated_salary'])){
				foreach($_SESSION['generated_salary'] as $salary_info){
					$mysqli->query("INSERT INTO employee_monthly_sallary values(
						'',
						'".$salary_info[1]."',
						'".$salary_info[2]."',
						'".$salary_info[3]."',
						'".$salary_info[4]."',
						'".$salary_info[5]."',
						'".$salary_info[6]."',
						'".$salary_info[7]."',
						'".$salary_info[8]."',
						'".$salary_info[9]."',
						'".$salary_info[10]."',
						'".$salary_info[11]."',
						'".$salary_info[12]."',
						'".$salary_info[13]."',
						'".$salary_info[14]."',
						'".$salary_info[15]."',
						'".$salary_info[16]."',
						'".$salary_info[17]."',
						'".$salary_info[18]."',
						'".$salary_info[19]."',
						'".$salary_info[20]."',
						'".$salary_info[21]."',
						'".$salary_info[22]."',
						'',
						'1',
						'".uploader_info()."',
						'".date('d/m/Y')."'
					)");
				}
				if($mysqli->query("insert into employee_sallary_generate_logs values(
					'',
					'".$_SESSION['generated_salary'][0][1]."',
					'',
					'".$month."',
					'".$year."',
					'".date('h')."',
					'".date('i')."',
					'".date('s')."',
					'".date('h:i:sa')."',
					'".date('d/m/Y')."',
					'1',
					'".$_SESSION['generated_salary'][0][27]."',
					'".uploader_info()."',
					'".date('d/m/Y')."'
				)")){
					unset($_SESSION['generated_salary']);
					$info = array(
						'message' => 'Sallary Generated Successfully'
					);
					echo json_encode($info);
				}else{
					$info = array(
						'message' => 'Something wrong! Please try again.'
					);
					echo json_encode($info);
				}
			}else{
				$info = array(
					'message' => 'Something wrong! Please try again.'
				);
				echo json_encode($info);
			}
		}else{
			$_SESSION['generated_salary'] = array();
			$html = '
					<div class="row justify-content-center"><div class="col-md-4"><p style="font-size:20px;font-weight:bold;"><span class="text-secondary">Total amount: </span><span id="total_salary_amount"></span></p></div></div>
					<div class="table-responsive">
					<table id="salary_preview" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
						<thead>
							<tr>
								<th>#</th>
								<th>Employee</th>
								<th><abbr title="Department-Designation">Dept-Deg</abbr></th>
								<th>Joining Date</th>
								<th>Month-Year</th>
								<th>Total Days</th>
								<th style="color: #f00;"><abbr title="Full Day Leave">FDL</abbr></th>
								<th style="color: #f00;"><abbr title="Half Day Leave">HDL</abbr></th>
								<th style="color: green;">Total Att:</th>
								<th style="color: #f00;">Total Abs:</th>
								<th><abbr title="Total Attendance Amount">T:Att: Amount</abbr></th>
								<th><abbr title="Over Deauty Bonus">OD:Bonus</abbr></th>
								<th><abbr title="Attendance Bonus">Att: Bonus</abbr></th>
								<th><abbr title="Performance Bonus">Prf:Bon<small>%</small></abbr></th>
								<th>Perday</th>
								<th><abbr title="Salary Deduction">SD</abbr></th>
								<th><abbr title="Attendance Missing Deduction">AMD</abbr></th>
								<th><abbr title="Extra Salary">ES</abbr></th>
								<th><abbr title="Advance Loan Salary">ALS</abbr></th>
								<th>Total Sallary</th>
								<th><abbr title="Payment Type">PT</abbr></th>
							</tr>
						</thead>
						<tbody>';
			$total_salary = 0;
			if(!empty($_POST['employee_ids'])){
				$get_ids = '';
				$exp = explode(',',rahat_decode($_POST['employee_ids']));
				foreach($exp as $xp){
					$get_ids .= "'".$xp."',";
				}
				$get_ids = rtrim($get_ids,',');
				//echo $get_ids;
				//exit;
				
				$get_employee = $mysqli->query("select * from employee where employee_id in (".$get_ids.") AND status not in ('2')");
			}else{
				$get_employee = $mysqli->query("select * from employee where status not in ('2')");
			}	
			$i = 1;	
			while($row = mysqli_fetch_assoc($get_employee)){
				$check_leave = $mysqli->query("select * from employee_leave_logs WHERE employee_id = '".$row['employee_id']."' and aproval = '1'");
				$get_leave_date = "";
				$get_leave_date_number = 0;
				$get_half_leave_date = 0;
				while($leav = mysqli_fetch_assoc($check_leave)){
					$get_daily_data = $mysqli->query("select * from employee_everyday_leave_logs where unique_id = '".$leav['unique_id']."' and month = '".$month."' and year = '".$year."' and status = '1'");
					while($daily_leave = mysqli_fetch_assoc($get_daily_data)){
						if($daily_leave['h_days'] == 1 ){
							$get_leave_date .= "'".$daily_leave['days']."',";
							$get_leave_date_number = $get_leave_date_number + 1;
						}					
					}				
				}
				if($get_leave_date_number > 0){
					$get_leave_date_number = $get_leave_date_number;
				}else{
					$get_leave_date_number = 0;
				}
				$half_check_leave = $mysqli->query("select * from employee_leave_logs WHERE employee_id = '".$row['employee_id']."' and how_many_days = '0.5' and month = '".$month."' and year = '".$year."' and aproval = '1'");
				$total_half_day_leave_days = 0;
				while($half_leav = mysqli_fetch_assoc($half_check_leave)){
					$check_att = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where days = '".$half_leav['days']."' and month = '".$half_leav['month']."' and years = '".substr($half_leav['year'],2)."'"));
					if(!empty($check_att['id'])){
						$get_half_leave_date = $get_half_leave_date + (float)$half_leav['how_many_days'];
						$total_half_day_leave_days++;
					}					
				}
				
				if($get_half_leave_date > 0){
					$get_half_leave_date = $get_half_leave_date;
				}else{
					$get_half_leave_date = 0;
				}
				
				if(!empty($get_leave_date)){
					$get_leave_date = rtrim($get_leave_date,',');
					$leave_query = "AND days NOT IN (".$get_leave_date.")";
				}else{
					$leave_query = "";
				}
				
				
				//-- check increament logs
				$check_increament = mysqli_fetch_assoc($mysqli->query("select * from employee_increament_logs where employee_id = '".$row['employee_id']."' and aproval = '1'"));
				$increament_amount = 0;
				if(!empty($check_increament['id'])){
					$att_ddat_fest = $mysqli->query("SELECT * FROM employee_attendence WHERE employee_id = '".$row['employee_id']."' AND attendance = '1' AND month = '".$month_attendance."' AND years = '".$year_attendance."' ".$leave_query." GROUP BY days");
					$increament_amount = 0;
					while($att_row = mysqli_fetch_assoc($att_ddat_fest)){
						$increament_logs = $mysqli->query("select * from employee_increament_logs where employee_id = '".$row['employee_id']."' and aproval = '1'");
						// $increament_amount = 0;
						while($inc_row = mysqli_fetch_assoc($increament_logs)){
							$get_date_ready_increament = $year.''.$month.''.sprintf("%02d",$att_row['days']);
							if($inc_row['start_date_modify'] <= $get_date_ready_increament){
								$increament_amount = $increament_amount + $inc_row['amount'];
							}
						}
					}
				}
				
				if($increament_amount > 0){
					$increament_amount = $increament_amount;
				}else{
					$increament_amount = 0;
				}
				//-- check decreament logs
				$decreament_amount = 0;
				$check_decreament = mysqli_fetch_assoc($mysqli->query("select * from employee_decreament_logs  where employee_id = '".$row['employee_id']."' and aproval = '1'"));
				if(!empty($check_decreament['id'])){
					$att_ddat_fest = $mysqli->query("SELECT * FROM employee_attendence WHERE employee_id = '".$row['employee_id']."' AND attendance = '1' AND month = '".$month_attendance."' AND years = '".$year_attendance."' ".$leave_query." GROUP BY days");
					$decreament_amount = 0;
					while($att_row = mysqli_fetch_assoc($att_ddat_fest)){
						$decreament_logs = $mysqli->query("select * from employee_decreament_logs where employee_id = '".$row['employee_id']."' and aproval = '1'");
						while($dec_row = mysqli_fetch_assoc($decreament_logs)){
							$get_date_ready_decreament = $year.''.$month.''.sprintf("%02d",$att_row['days']);
							if($dec_row['start_date_modify'] <= $get_date_ready_decreament){
								$decreament_amount = $decreament_amount + $dec_row['amount'];
							}
						}
					}
				}				
				if($decreament_amount > 0){
					$decreament_amount = $decreament_amount;
				}else{
					$decreament_amount = 0;
				}

				//--check sallary deduction 
				$_check_salary_deduction = mysqli_fetch_assoc($mysqli->query("select sum(amount) as dicuction_total, id, employee_id from employee_sallary_deduction where employee_id = '".$row['employee_id']."' and month = '".$month."' and year = '".$year."' and aproval = '1'"));
				$deduction_amount = (float)$_check_salary_deduction['dicuction_total'];
				if($deduction_amount > 0){
					$deduction_amount = $deduction_amount;
				}else{
					$deduction_amount = 0;
				}
				
				
				//--check sallary deduction missing_attendance 
				$_check_salary_deduction_missing_attendance = mysqli_fetch_assoc($mysqli->query("select sum(deduction_amount) as miss_att_dicuction_total, id, employee_id from employee_missing_attendance_request_date where employee_id = '".$row['employee_id']."' and month = '".$month."' and years = '".$year."' and aproval = '1'"));
				$d_m_att_amount = (float)$_check_salary_deduction_missing_attendance['miss_att_dicuction_total'];
				if($d_m_att_amount > 0){
					$d_m_att_amount = $d_m_att_amount;
				}else{
					$d_m_att_amount = 0;
				}
				
				
				//--check Extra sallary 
				$_check_salary_extra = mysqli_fetch_assoc($mysqli->query("select sum(amount) as dicuction_total, id, employee_id from employee_extra_sallary where employee_id = '".$row['employee_id']."' and month = '".$month."' and year = '".$year."' and aproval = '1'"));
				//print_r("select sum(amount) as dicuction_total, id, employee_id from employee_extra_sallary where employee_id = '".$row['employee_id']."' and month = '".$month."' and year = '".$year."' and aproval = '1'");
				$extra_amount = (float)$_check_salary_extra['dicuction_total'];
				
				if($extra_amount > 0){
					$extra_amount = $extra_amount;
				}else{
					$extra_amount = 0;
				}
				
				//--check Advance sallary 
				$pao = $year.'-'.$month.'-01';
				$p_mY = date('m/Y', strtotime($pao. ' + 1 month'));
				$_check_advance_salary = mysqli_fetch_assoc($mysqli->query("select sum(amount) as advance_total, id, employee_id from employee_grant_loan where employee_id = '".$row['employee_id']."' and data like '%".$p_mY."' and aproval = '1' and aproval_account = '1'"));
				$advance_salary_amount = (float)$_check_advance_salary['advance_total'];
				if($advance_salary_amount > 0){
					$advance_salary_amount = $advance_salary_amount;
				}else{
					$advance_salary_amount = 0;
				}
				
				// $basic_salary = (float)$row['basic_salary'] + (float)$increament_amount - $decreament_amount;
				$basic_salary = (float)$row['basic_salary'];
				
				$check_festiavle = mysqli_fetch_assoc($mysqli->query("select * from employee_festiavle_awards where year = '".$year."' and month = '".$month."'"));
				$f_bonus_amount = 0;
				if(!empty($check_festiavle['id'])){
					$att_ddat_fest = $mysqli->query("SELECT * FROM employee_attendence WHERE employee_id = '".$row['employee_id']."' AND attendance = '1' AND month = '".$month_attendance."' AND years = '".$year_attendance."' ".$leave_query." GROUP BY days");
					$f_bonus_amount = 0;
					while($fastiavle = mysqli_fetch_assoc($att_ddat_fest)){
						$check_festavle_date = mysqli_fetch_assoc($mysqli->query("select * from employee_festiavle_awards where year = '".$year."' and month = '".$month."' and days = '".$fastiavle['days']."'"));
						if(!empty($check_festavle_date['id']) AND $check_festavle_date['days'] == $fastiavle['days']){
							$percentage = (float)$check_festavle_date['percentage'];
							$root_basic = $basic_salary / 100;
							$f_bonus = $root_basic * $percentage;
							$f_bonus_amount = $f_bonus_amount + $f_bonus;
						}
					}
				}	
				
				$get_employee_attendance_data = mysqli_fetch_assoc($mysqli->query("SELECT count(DISTINCT days) as total_present FROM employee_attendence WHERE employee_id = '".$row['employee_id']."' AND attendance = '1' AND month = '".$month_attendance."' AND years = '".$year_attendance."' ".$leave_query.""));					
				if(!empty($get_employee_attendance_data['total_present']) AND $get_employee_attendance_data['total_present'] > 0 ){
					$number0f_attendance = $get_employee_attendance_data['total_present'] - (float)$get_half_leave_date;
				}else{
					$number0f_attendance = 0;
				}			
				
				if($f_bonus_amount > 0){
					$f_bonus_amount = $f_bonus_amount;
				}else{
					$f_bonus_amount = 0;
				}
				
				if($number0f_attendance > 0){			
					if($total_number_month == $number0f_attendance){
						$get_attendance_bonus = mysqli_fetch_assoc($mysqli->query("select * from set_attendance_bonus_logs where designation_id = '".$row['designation']."' order by id desc"));
						if(!empty($get_attendance_bonus['amount'])){
							$attandance_bonus = (int)$get_attendance_bonus['amount'];
						}else{
							$attandance_bonus = 0;
						}
					}else{
						$attandance_bonus = 0;
					}
					
					$sallary_per_day = $basic_salary;
					$sallary_total = $basic_salary * $number0f_attendance;
					$festival_deauty_bonus = (float)$f_bonus_amount;
					
					
					$get_performance_data = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_performance_logs WHERE employee_id = '".$row['employee_id']."' AND month = '".$month."' AND year = '".$year."' AND aproval = '1'"));
					if(!empty($get_performance_data['id'])){
						$performance_bonus = ( $sallary_total + $increament_amount - $decreament_amount ) * ( $get_performance_data['percentage'] / 100 );
						$performance_percentage = $get_performance_data['percentage'];
						if($get_performance_data['pay_cut']){
							$performance_bonus *= -1; // Making it negative for when pay cut.
						}
					}else{
						$performance_bonus = 0;
						$performance_percentage = 0;
					}
					
					$sallary_total_with_bonus = $sallary_total + $attandance_bonus + $festival_deauty_bonus + $performance_bonus - $deduction_amount - $d_m_att_amount + $extra_amount - $advance_salary_amount;
					$sallary_pay_method = $row['salary_pay_method'];
					//echo $row['employee_id'].' - '.$sallary_total_with_bonus.' | '.$f_bonus_amount.' * '.$performance_bonus.'<br />';
					if($d_m_att_amount > 0){
						$table_missing_du_data = '<span style="color:#f00;">'.money($d_m_att_amount).'</span>';
					}else{
						$table_missing_du_data = 0;
					}
					
					if($deduction_amount > 0){
						$table_du_data = '<span style="color:#f00;">'.money($deduction_amount).'</span>';
					}else{
						$table_du_data = 0;
					}
					
					if($extra_amount > 0){
						$table_es_data = '<span style="color:green;">'.money($extra_amount).'</span>';
					}else{
						$table_es_data = 0;
					}
					
					if($advance_salary_amount > 0){
						$table_as_data = '<span style="color:red;">'.money($advance_salary_amount).'</span>';
					}else{
						$table_as_data = 0;
					}
					
					if(!empty($_POST['employee_type_get'])){
						$employee_type_get = $_POST['employee_type_get'];
					}else{
						$employee_type_get = 'Not Find!';
					}
					$total_absent = (float)$total_number_month - (float)$number0f_attendance;
					if($row['status'] == '0'){
						$html .= '<tr class="table-danger">';
					}else{
						$html .= '<tr>';
					}
					$html .=	   '<td>'.$i++.'</td>
									<td>'.$row['full_name'].' - '.$row['employee_id'].'</td>
									<td>'.$row['designation_name'].' - '.$row['department_name'].'</td>
									<td>'.$row['date_of_joining'].'</td>
									<td>'.month_name($month).' - '.$year.'</td>
									<td>'.$total_number_month.' days'.'</td>
									<td>'.$get_leave_date_number.'</td>
									<td> '.$total_half_day_leave_days.'</td>
									<td>'.$number0f_attendance.' days'.'</td>
									<td>'.$total_absent.' days'.'</td>
									<td>'.money($sallary_total + $increament_amount - $decreament_amount).'</td>
									<td>'.money($festival_deauty_bonus).'</td>
									<td>'.money($attandance_bonus).'</td>';
					if($performance_bonus < 0){
						$html .= '<td><span style="color:red;">'.money(abs($performance_bonus)).' <small>('.$performance_percentage.'%)</small></span></td>';
					}else{
						$html .= '<td><span style="color:green;">'.money($performance_bonus).' <small>('.$performance_percentage.'%)</small></span></td>';
					}
					$html .=		'<td>'.money($sallary_per_day).'</td>
									<td>'.$table_du_data.'</td>
									<td>'.$table_missing_du_data.'</td>
									<td>'.$table_es_data.'</td>
									<td>'.$table_as_data.'</td>
									<td>'.money($sallary_total_with_bonus + $increament_amount - $decreament_amount).'</td>
									<td>'.$sallary_pay_method.'</td>
								</tr>';
					$temp = array(
						'',
						$unique_id,
						$row['employee_id'],
						$month,
						$year,
						$month."/".$year,
						$total_number_month,
						$get_leave_date_number,
						$get_half_leave_date,
						$number0f_attendance,
						$total_absent,
						$festival_deauty_bonus,
						$attandance_bonus,
						$performance_bonus,
						$performance_percentage,
						$sallary_per_day,
						$sallary_total + $increament_amount - $decreament_amount,
						$deduction_amount,
						$d_m_att_amount,
						$extra_amount,
						$advance_salary_amount,
						$sallary_total_with_bonus + $increament_amount - $decreament_amount,
						$sallary_pay_method,
						'',
						'1',
						uploader_info(),
						date('d/m/Y'),
						$employee_type_get
					);
					array_push($_SESSION['generated_salary'], $temp);
					$total_salary += intval($sallary_total_with_bonus + $increament_amount - $decreament_amount);
				}
			}
			$html .=   '</tbody>
					</table>
					</div>';
			$info = array(
				'html' => $html,
				'total' => $total_salary,
				'button' => '<button style="float:right;" type="button" class="btn btn-primary" onclick="send_otp()">OTP</button>'
			);
			echo json_encode($info);
		}					
	}
}
?>