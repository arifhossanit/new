<?php
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");
function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$table = 'employee_monthly_sallary';
$primaryKey = 'id';
if(!empty($_GET['payment_type'])){
	$payment_type = "AND salary_pay_method = '".$_GET['payment_type']."'";
}else{
	$payment_type = "";
}
$where = "unique_id = '".$_GET['unique_id']."' ".$payment_type."";
$columns = array(
	array('db' => 'id', 'dt' => 0),
	array( 
		'db' => 'employee_id', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $emp['full_name'].' - <b>'.$emp['employee_id'].'</b>';
		}
	),
	array( 
		'db' => 'employee_id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));			
			return $emp['department_name'].' - <b>'.$emp['designation_name'].'</b>';
		}
	),
	array( 
		'db' => 'employee_id', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
			$first_day = $row[22] . "-" . $row[21] . "-01"; 
			$last_day = date($row[22] . "-" . $row[21] . "-t"); 
			$joining_salary = mysqli_fetch_assoc($mysqli->query("SELECT basic_salary FROM employee WHERE employee_id = '$d'"));
			$increament_till_now = mysqli_fetch_assoc($mysqli->query("SELECT SUM(employee_increament_logs.amount) as total FROM employee_increament_logs WHERE STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y') < '$first_day' AND employee_increament_logs.employee_id = '$d'"));
			$decreament_till_now = mysqli_fetch_assoc($mysqli->query("SELECT SUM(employee_decreament_logs.amount) as total FROM employee_decreament_logs WHERE STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y') < '$first_day' AND employee_decreament_logs.employee_id = '$d'"));
			$running_salary = $joining_salary['basic_salary'] + $increament_till_now['total'] + $decreament_till_now['total'];

			$increament_decreament_this_month = mysqli_fetch_assoc($mysqli->query("SELECT
            LEAST(ifnull(min(STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y')), '9999-99-99'), ifnull(min(STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y')), '9999-99-99')) as least_date,
			COUNT(*) as validate
			FROM employee_increament_logs
			LEFT JOIN employee_decreament_logs on employee_decreament_logs.employee_id = employee_increament_logs.employee_id AND STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y') between '$first_day' AND '$last_day'
			WHERE STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y') between '$first_day' AND '$last_day'
            AND ( employee_increament_logs.employee_id = '$d' OR employee_increament_logs.employee_id = '$d' );"));

			$days = $row[8];
			$html = "";

			if($increament_decreament_this_month['validate'] > 0){
				$salary_date = new DateTime($row[22].'-'.$row[21].'-01');
				$least_date = new DateTime($increament_decreament_this_month['least_date']);

				$get_total_attendance = mysqli_fetch_assoc($mysqli->query("SELECT count(distinct(days)) as total_days from employee_attendence where month = '".(int)$salary_date->format('m')."' AND years = '".(int)$salary_date->format('y')."' AND employee_id = '$d' AND days not in (SELECT employee_everyday_leave_logs.days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.employee_id = '$d' AND employee_leave_logs.aproval = 1 AND employee_everyday_leave_logs.status = 1 AND employee_everyday_leave_logs.month = '".$salary_date->format('m')."' AND employee_everyday_leave_logs.year = '".(int)$salary_date->format('Y')."') AND employee_attendence.days <= ".(int)$least_date->format('d')));
				$total_half_days = mysqli_fetch_assoc($mysqli->query("SELECT SUM(h_days) as total_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.employee_id = '$d' AND employee_leave_logs.aproval = 1 AND employee_everyday_leave_logs.status = 1 AND employee_everyday_leave_logs.month = '".$salary_date->format('m')."' AND employee_everyday_leave_logs.year = '".(int)$salary_date->format('Y')."' AND CAST(employee_everyday_leave_logs.days as UNSIGNED) <= ".(int)$least_date->format('d')));

				$days_w_last_month_salary = $get_total_attendance['total_days'] + $total_half_days['total_days'];

				$increaments = $mysqli->query("SELECT * from employee_increament_logs LEFT JOIN employee_decreament_logs using(employee_id) where ( STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y') between '$first_day' AND '$last_day' OR STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y') between '$first_day' AND '$last_day' ) ORDER BY STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y') ASC, STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y') ASC");

				$last_date = new DateTime(date($row[22].'-'.$row[21].'-t'));
				foreach($increaments as $idx => $increament){
					$temp_date = DateTime::createFromFormat('d/m/Y', $increament['start_date']);
					if(isset($increaments[$idx+1])){
						$last_date = new DateTime($increaments[$idx+1]['start_date']);
					}else{
						$last_date = new DateTime(date($row[22].'-'.$row[21].'-t'));
					}

					$attendance = mysqli_fetch_assoc($mysqli->query("SELECT count(distinct(days)) as total_days from employee_attendence where month = '".(int)$salary_date->format('m')."' AND years = '".(int)$salary_date->format('y')."' AND employee_id = '$d' AND days not in (SELECT employee_everyday_leave_logs.days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.employee_id = '$d' AND employee_leave_logs.aproval = 1 AND employee_everyday_leave_logs.status = 1 AND employee_everyday_leave_logs.month = '".$salary_date->format('m')."' AND employee_everyday_leave_logs.year = '".(int)$salary_date->format('Y')."') AND employee_attendence.days >= ". (int)$temp_date->format('d') . " AND employee_attendence.days <= ".(int)$last_date->format('d')));

					$half_days = mysqli_fetch_assoc($mysqli->query("SELECT SUM(h_days) as total_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.employee_id = '$d' AND employee_leave_logs.aproval = 1 AND employee_everyday_leave_logs.status = 1 AND employee_everyday_leave_logs.month = '".$salary_date->format('m')."' AND employee_everyday_leave_logs.year = '".(int)$salary_date->format('Y')."' AND CAST(employee_everyday_leave_logs.days as UNSIGNED) > ".(int)$least_date->format('d')));

					$increamented_days = $attendance['total_days'] + $half_days['total_days'];
					$temp_diff = $temp_date->diff($last_date);


				}

			}
			$total = $running_salary * $days_w_last_month_salary;
			return "($running_salary * $days_w_last_month_salary) $total";
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_monthly_sallary where id = '".$d."'"));
		return '<b>'.month_name($info['month']).' - '.$info['year'].'</b>';
		}
	),
	array( 
		'db' => 'total_number_of_days', 
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			return '<b style="color:#9e0000;">'.$d.'</b> Days';
		}
	),
	array( 
		'db' => 'full_day_leave', 
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			if($d > 0){
				return '<span style="color:red;">'.$d.' Days</span>';
			}else{
				return $d;
			}
		}
	),
	array( 
		'db' => 'half_day_leave', 
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			if($d > 0){
				return '<span style="color:red;">'.$d.' Days</span>';
			}else{
				return $d;
			}
		}
	),
	array( 
		'db' => 'total_attendance', 
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			if($d > 0){
				return $d.' Days';
			}else{
				return '<span style="color:red;">'.$d.'</span>';
			}
		}
	),
	array( 
		'db' => 'total_absent', 
		'dt' => 9,
		'formatter' => function( $d, $row ) {
			if($d > 0){
				return '<span style="color:red;">'.$d.' Days</span>';
			}else{
				return $d;
			}			
		}
	),
	array( 
		'db' => 'attendence_wise_sallary', 
		'dt' => 10,
		'formatter' => function( $d, $row ) {
			if($d > 0){
				return money($d);
			}else{
				return $d;
			}			
		}
	),
	array( 
		'db' => 'festival_deauty_bonus', 
		'dt' => 11,
		'formatter' => function( $d, $row ) {
			if($d > 0){
				return '<span style="color:green;">'.money($d).'</span>';
			}else{
				return $d;
			}			
		}
	),
	array( 
		'db' => 'attendance_bonus', 
		'dt' => 12,
		'formatter' => function( $d, $row ) {
			if($d > 0){
				return '<span style="color:green;">'.money($d).'</span>';
			}else{
				return $d;
			}			
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 13,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_monthly_sallary where id = '".$d."'"));
			if($info['performance_bonus'] > 0){
				return '<span style="color:green;">'.money($info['performance_bonus']).' <small>('.$info['performance_bonus_percentage'].'%)</small></span>';
			}else{
				return $info['performance_bonus'];
			}
		}
	),
	array( 
		'db' => 'employee_id', 
		'dt' => 14,
		'formatter' => function( $d, $row ) {global $mysqli;
			$first_day = $row[22] . "-" . $row[21] . "-01";
			$last_day = date($row[22] . "-" . $row[21] . "-t"); 
			$joining_salary = mysqli_fetch_assoc($mysqli->query("SELECT basic_salary FROM employee WHERE employee_id = '$d'"));
			$increament_till_now = mysqli_fetch_assoc($mysqli->query("SELECT SUM(employee_increament_logs.amount) as total FROM employee_increament_logs WHERE STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y') < '$first_day' AND employee_increament_logs.employee_id = '$d'"));
			$decreament_till_now = mysqli_fetch_assoc($mysqli->query("SELECT SUM(employee_decreament_logs.amount) as total FROM employee_decreament_logs WHERE STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y') < '$first_day' AND employee_decreament_logs.employee_id = '$d'"));
			$running_salary = $joining_salary['basic_salary'] + $increament_till_now['total'] - $decreament_till_now['total'];

			$increament_decreament_this_month = mysqli_fetch_assoc($mysqli->query("SELECT
            LEAST(ifnull(min(STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y')), '9999-99-99'), ifnull(min(STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y')), '9999-99-99')) as least_date,
			COUNT(*) as validate
			FROM employee_increament_logs
			LEFT JOIN employee_decreament_logs on employee_decreament_logs.employee_id = employee_increament_logs.employee_id AND STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y') between '$first_day' AND '$last_day'
			WHERE STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y') between '$first_day' AND '$last_day'
            AND ( employee_increament_logs.employee_id = '$d' OR employee_increament_logs.employee_id = '$d' );"));
			$total = 0;
			if($increament_decreament_this_month['validate'] > 0){
				$increaments = $mysqli->query("SELECT * from employee_increament_logs where STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y') between '$first_day' AND '$last_day' AND employee_increament_logs.employee_id = '$d' ORDER BY STR_TO_DATE(employee_increament_logs.start_date, '%d/%m/%Y') ASC");
				while($increament = mysqli_fetch_assoc($increaments)){
					$total += $increament['amount'];
				}
				$decreaments = $mysqli->query("SELECT * from employee_decreament_logs where STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y') between '$first_day' AND '$last_day' AND employee_decreament_logs.employee_id = '$d' ORDER BY STR_TO_DATE(employee_decreament_logs.start_date, '%d/%m/%Y') ASC");
				while($decreament = mysqli_fetch_assoc($decreaments)){
					$total -= $decreament['amount'];
				}
			}
			$html = "<p class='m-0'>".$running_salary."</p>";
			if($total != 0){
				$tmp = $running_salary + $total;
				$html .= "<p class='m-0'><u>$tmp</u></p>";
			}
			return $html;			
		}
	),
	
	array( 
		'db' => 'slary_deduction', 
		'dt' => 15,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d > 0){
					return '<span style="color:#f00;">'.money($d).'</span>';
				}else{
					return $d;
				}
			}else{
				return '--';
			}						
		}
	),
	array( 
		'db' => 'miss_att_deduction', 
		'dt' => 16,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d > 0){
					return '<span style="color:#f00;">'.money($d).'</span>';
				}else{
					return $d;
				}
			}else{
				return '--';
			}						
		}
	),
	array( 
		'db' => 'extra_salary', 
		'dt' => 17,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d > 0){
					return '<span style="color:#f00;">'.money($d).'</span>';
				}else{
					return $d;
				}
			}else{
				return '--';
			}						
		}
	),
	array( 
		'db' => 'advance_salary', 
		'dt' => 18,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d > 0){
					return '<span style="color:#f00;">'.money($d).'</span>';
				}else{
					return $d;
				}
			}else{
				return '--';
			}						
		}
	),
	array( 
		'db' => 'total_sallary', 
		'dt' => 19,
		'formatter' => function( $d, $row ) {
			if($d > 0){
				return '<b style="color:#003c00;">'.money($d).'</b>';
			}else{
				return '<span style="color:red;">'.$d.'</span>';
			}			
		}
	),
	array( 
		'db' => 'salary_pay_method', 
		'dt' => 20,
		'formatter' => function( $d, $row ) {
			if($d == 'cash'){
				return '<b style="color:red;">'.$d.'</b>';
			}else{
				return '<b style="color:green;">'.$d.'</b>';
			}			
		}
	),
	array('db' => 'month', 'dt' => 21),
	array('db' => 'year', 'dt' => 22),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>