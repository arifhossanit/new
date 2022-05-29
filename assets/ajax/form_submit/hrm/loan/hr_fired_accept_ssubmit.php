<?php
include("../../../../../application/config/ajax_config.php");
if (isset($_POST['accept_id'])) {
	$id = $_POST['accept_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from exit_employee_chain_hr where id = '" . $id . "'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '" . $info['e_db_id'] . "'"));
	if (
		$mysqli->query("update exit_employee_chain_hr set
		aproval = '1'
		where id = '" . $id . "'
	") and
		$mysqli->query("update employee_resign_request_to_hr set
		aproval = '1'
		where e_db_id = '" . $emp['id'] . "'
	")
	) {
		if ($mysqli->query("insert into employee_fired_aproval values(
			'',
			'" . $emp['id'] . "',
			'" . $emp['employee_id'] . "',
			'" . $info['id'] . "',
			'Approved FROM HR',
			'Approved By " . $_SESSION['super_admin']['email'] . "',
			'1',
			'" . uploader_info() . "',
			'" . date('d/m/Y') . "'
		)")) {
			$check_resign_table = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as validate from employee_resign_request where employee_id = '" . $emp['employee_id'] . "'"));

			//geting employee requested resign date
			$get_resign_date = mysqli_fetch_assoc($mysqli->query("SELECT resign_date as requested_resign_date from employee_resign_request where employee_id = '" . $emp['employee_id'] . "'"));
			$set_status = 0;

			//defining wheather resign date is past+present / future date and set employee status 0/1
			//here today is also past date
			if (!empty($get_resign_date)) {
				$resign_date = new DateTime($get_resign_date['requested_resign_date'] . ' 00:00:00');
				$today = new DateTime(date('Y-m-d') . ' 00:00:00');
				if ($resign_date <= $today) {
					$set_status = 0;
				} else {
					$set_status = 1;
				}
			}


			if ($check_resign_table['validate'] != 0) {
				$release_type = 'Self Resign';
			} else {
				$release_type = 'Fired';
			}
			/**
			 * Will not go to fired list if self resign.
			 * If self resign data is already updated.
			 */
			$get_date = mysqli_fetch_assoc($mysqli->query("SELECT * from employee_fired_list where employee_id = '" . $emp['employee_id'] . "'"));
			if (is_null($get_date)) {
				$updated = $mysqli->query("UPDATE employee set last_working_date = '".$_POST['last_working_date']."' ,status = '" . $set_status . "', extra_note = 'Approved FROM HR', release_type = '$release_type' where id = '" . $emp['id'] . "'");
			} else {
				$updated = $mysqli->query("UPDATE employee set last_working_date = '".$_POST['last_working_date']."' ,status = '" . $set_status . "', data = '" . $get_date['data'] . "', extra_note = 'Approved FROM HR' and release_type = '$release_type' where id = '" . $emp['id'] . "'");
			}
			if ($updated) {
				echo 'Approved Successfully';
			} else {
				echo 'Something Wrong! Please Try again';
			}
		} else {
			echo 'Something Wrong! Please Try again';
		}
	} else {
		echo 'Something Wrong! Please Try again';
	}
}
if (isset($_POST['rejected_id'])) {
	$id = $_POST['rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from exit_employee_chain_hr where id = '" . $id . "'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '" . $info['e_db_id'] . "'"));
	if (
		$mysqli->query("update exit_employee_chain_hr set
		aproval = '2'
		where id = '" . $id . "'
	") and
		$mysqli->query("update employee_resign_request_to_hr set
		aproval = '2'
		where e_db_id = '" . $emp['id'] . "'
	")
	) {
		if ($mysqli->query("insert into employee_fired_aproval values(
			'',
			'" . $emp['id'] . "',
			'" . $emp['employee_id'] . "',
			'" . $info['id'] . "',
			'Rejected FROM HR',
			'Rejected By " . $_SESSION['super_admin']['email'] . "',
			'1',
			'" . uploader_info() . "',
			'" . date('d/m/Y') . "'
		)")) {
			echo 'Rejected Successfully';
		} else {
			echo 'Something Wrong! Please Try again';
		}
	} else {
		echo 'Something Wrong! Please Try again';
	}
}
