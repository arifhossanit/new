<?php 
//This company never generate salary in last running month - by (Ibrahim Khalil - Deputy manager & IT Incharge) (22-08-2021)
include("../../../application/config/ajax_config.php");
if(isset($_POST['year'])){
	$all_employee_activation = 0;
	echo '<option value="">--select--</option>';
	$f_year = $_POST['year'];
	$h_month = $_POST['month'];
	
	$h_year = substr($_POST['year'],2);;
	$f_month = sprintf("%02d", $_POST['month']);
	
	$pao = $f_year.'-'.$f_month.'-01';
	$p_mY = date('m/Y', strtotime($pao. ' - 1 month'));
	
	$r_mY = $f_month.'/'.$f_year;
	$select_employee_by_joining_date = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE date_of_joining LIKE '%".$r_mY."' ORDER BY id DESC"));
	if(!empty($select_employee_by_joining_date['id'])){
		$check_exixting = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(*) as row_count FROM employee_monthly_sallary WHERE date_full = '".$r_mY."' and employee_id in (SELECT employee_id from employee where date_of_joining LIKE '%".$r_mY."%') ORDER BY id DESC"));
		if($check_exixting['row_count'] > 0){
			echo '<option value="" disabled>New Joining</option>';
			$all_employee_activation = 0;
		}else{
			$n_emp_ids = '';
			$n_ret_emp = $mysqli->query("SELECT * FROM employee WHERE date_of_joining LIKE '%".$r_mY."' ORDER BY id DESC");
			$d_count = 0;
			while($n_ids = mysqli_fetch_assoc($n_ret_emp)){
				$n_emp_ids .= $n_ids['employee_id'].',';
				$d_count = $d_count + 1;
			}
			$n_emp_ids = rtrim($n_emp_ids,',');
			echo '<option value="New Joining_____'.rahat_encode($n_emp_ids).'">New Joining ('.$d_count.')</option>';
			$all_employee_activation = 1;
		}	
		$ret_emp = $mysqli->query("select employee_id from employee where employee_id not in(select employee_id from employee where date_of_joining LIKE '%".$r_mY."')");
	}else{
		echo '<option value="" disabled>New Joining</option>';
		$ret_emp = $mysqli->query("select employee_id from employee where status not in ('2')");
	}
	
	$emp_ids = '';	
	$c_count = 0;
	while($ids = mysqli_fetch_assoc($ret_emp)){
		$check_exixting = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_monthly_sallary WHERE date_full = '".$r_mY."' and employee_id = '".$ids['employee_id']."'"));	
		if(!empty($check_exixting['id'])){
			
		}else{
			$emp_ids .= $ids['employee_id'].',';
			$c_count = $c_count + 1;
		}
	}
	$emp_ids = rtrim($emp_ids,',');
	if(!empty($emp_ids)){
		echo '<option value="Rest Of Employee_____'.rahat_encode($emp_ids).'">Rest Of Employee ('.$c_count.')</option>';
	}else{
		echo '<option value="" disabled>Rest Of Employee</option>';
	}
	if($all_employee_activation == 1){
		$ret_empx = $mysqli->query("select employee_id from employee where status not in ('2')");
		$emp_idsx = '';	
		$c_countx = 0;
		while($idsx = mysqli_fetch_assoc($ret_empx)){
			$emp_idsx .= $idsx['employee_id'].',';
			$c_countx = $c_countx + 1;			
		}
		$emp_idsx = rtrim($emp_idsx,',');
		if(!empty($emp_idsx)){
			echo '<option value="All Employee_____'.rahat_encode($emp_idsx).'">All Employee ('.$c_countx.')</option>';
		}else{
			echo '<option value="" disabled>All Employee</option>';
		}
	}else{
		echo '<option value="" disabled>All Employee</option>';
	}	
}
?>