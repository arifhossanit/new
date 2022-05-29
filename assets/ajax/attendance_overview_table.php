<?php 
include("../../application/config/ajax_config.php");
if(isset($_POST['view_attendance'])){
	$year = $_POST['year_id'];
	$year_2 = substr($_POST['year_id'],2);
	$month = $_POST['month_id'];
?>						
							<table id="attendance_data_table" class="table table-sm table-striped table-bordered table-hover attendance_cus">
								<thead>
									<tr role="row">
										<th rowspan="1" colspan="1" style="width: 0px;">E:ID</th>
										<th rowspan="1" colspan="1" style="width: 0px;"> Employee | Days <span style="color:red;font-weight:bolder;">(<?php echo $year; ?> - <?php echo $month; ?>)</span></th>					
<?php 
$number_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
for($b = '01'; $b <= $number_of_month; $b++){
									echo '<th rowspan="1" colspan="1" style="width: 0px;">'.sprintf("%02d", $b).'</th>';
}
?>					
										<th style="color:green;">Present</th>
										<th style="color:red;">Absent</th>
									</tr>
								</thead>
								<tbody>
<?php
if(!empty($_POST['emp_type'])){
	if($_POST['emp_type'] == 1){
		$status = "where status = '1'";
	}else if($_POST['emp_type'] == 2){
		$status = "where status = '0'";
	}else if($_POST['emp_type'] == 3){
		if(!empty($_POST['custom_employee_id'])){
			$c_emp_id = '';
			foreach($_POST['custom_employee_id'] as $emp){
				$c_emp_id .= "'".$emp."',";
			}
			$cus_emp_id = rtrim($c_emp_id,',');
			$status = "where employee_id in (".$cus_emp_id.")";
		}else{
			$status = "";
		}
	}else{
		$status = "";
	}
}else{
	$status = "";
}					
$get_employee = $mysqli->query("select id, employee_id, full_name, status from employee ".$status." order by id asc");
foreach($get_employee as $row){
?>
    <tr>
        <td style="text-align:left;"> <?php echo $row['employee_id']; ?> <?php if($row['status'] == 1 ){}else{ ?><span style="background-color:#f00;border-radius:10px;color: #fff;">.</span><?php } ?></td>
        <td style="text-align:left;"> <?php echo $row['full_name']; ?> </td>					
<?php 
$present = '0';
$number_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
for($m = 1; $m <= $number_of_month; $m++){
	if($year >= 2021){
		$get_leave = mysqli_fetch_assoc($mysqli->query("SELECT employee_everyday_leave_logs.days, employee_everyday_leave_logs.id, employee_everyday_leave_logs.h_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.e_db_id = '".$row['id']."' AND employee_everyday_leave_logs.days = '".sprintf("%02d", $m)."' AND employee_everyday_leave_logs.month = '".sprintf("%02d", $month)."' AND employee_everyday_leave_logs.year = '20".$year_2."' AND employee_everyday_leave_logs.status = 1 AND employee_leave_logs.aproval = 1 AND employee_leave_logs.h_aproval in (1,3) LIMIT 1"));
	}else if($month >= 9){
		$get_leave = mysqli_fetch_assoc($mysqli->query("SELECT employee_everyday_leave_logs.id, employee_everyday_leave_logs.h_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.e_db_id = '".$row['id']."' AND employee_everyday_leave_logs.days = '".sprintf("%02d", $m)."' AND employee_everyday_leave_logs.month = '".sprintf("%02d", $month)."' AND employee_everyday_leave_logs.year = '20".$year_2."' AND employee_everyday_leave_logs.status = 1 AND employee_leave_logs.aproval = 1 AND employee_leave_logs.h_aproval in (1,3) LIMIT 1"));
	}else{
		$get_leave = null;
	}
	$att = mysqli_fetch_assoc($mysqli->query("select id, attendance, note from employee_attendence where e_db_id = '".$row['id']."' and days = '".sprintf("%02d", $m)."' and month = '".sprintf("%02d", $month)."' and years = '".$year_2."'"));
?>
										<td>
<?php
	if(!is_null($get_leave)){
		if($get_leave['h_days'] == '0.5'){
			echo '<span style="font-weight:bolder;color:#8500ff;">H</span>';
			$present = $present + 0.5;
		}else{
			echo '<span style="font-weight:bolder;color:red;">L</span>';
		}
	}else{								
		if(!empty($att['id'])){
			if($att['attendance'] == '1'){
				if($att['note'] == 'half'){
					echo '<span style="font-weight:bolder;color:#8500ff;">H</span>';
					$present = $present + 0.5;
				}else if($att['note'] == 'home'){
					echo '<span style="font-weight:bolder;color:blue;">W</span>';
					$present = $present + 1;
				}else{
					echo '<span style="font-weight:bolder;color:green;">P</span>';
					$present = $present + 1;
				}
			}else{
				echo '<span style="font-weight:bolder;color:red;">A</span>';
			}															
		}else{
			echo '<span style="color:#f00;">--</span>';
		}
		
	}
	// if(!empty($att['id'])){
	// 	if($att['attendance'] == '1'){
	// 		if($att['note'] == 'home'){
	// 			echo '<span style="font-weight:bolder;color:blue;">W</span>';
	// 			$present = $present + 1;
	// 		}else if($att['note'] == 'half'){
	// 			echo '<span style="font-weight:bolder;color:#8500ff;">H</span>';
	// 			$present = $present + 0.5;
	// 		}else{
	// 			echo '<span style="font-weight:400;color:green;">P</span>';
	// 			$present = $present + 1;
	// 		}
	// 	}else{
	// 		echo '<span style="font-weight:400;color:red;">A</span>';
	// 	}															
	// }else{
	// 	echo '<span style="color:red;">--</span>';
	// }
?>
										</td>
<?php } ?>
										<td style="font-weight:bolder;color:green;"><?php echo $present; ?></td>
										<td style="font-weight:bolder;color:red;">
											<?php 
												$absent = $number_of_month - $present;
												if($absent > 0){
													echo $absent;
												}else{
													echo '0';
												}
												
											?>
										</td>
									</tr>
<?php } ?>				
								</tbody>
							</table>
<?php } ?>						