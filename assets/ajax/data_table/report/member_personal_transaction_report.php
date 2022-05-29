<?php
$file = $_SERVER['DOCUMENT_ROOT'] . '/datatables/pdo.php';
if (is_file($file)) {
	include($file);
}
include("../../../../application/config/ajax_config.php");
$table = 'transaction';
$primaryKey = 'id';

$where = "booking_id = '" . rahat_decode($_GET['member_id']) . "'";
$columns = array(
	array('db' => 'id',   'dt' => 0),
	array('db' => 'transaction_id',   'dt' => 1),
	array(
		'db' => 'amount',
		'dt' => 2,
		'formatter' => function ($d, $row) {
			if (!empty($d)) {
				return '<span style="color:#a50000;font-weight:bolder;">' . money($d) . '</span>';
			}
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 3,
		'formatter' => function ($d, $row) {
			if (!empty($d)) {
				global $mysqli;
				$total_paid_amount = mysqli_fetch_assoc($mysqli->query("select (SUM(card_amount)+SUM(cash_amount)+SUM(mobile_amount)+SUM(check_amount)) AS Total from payment_received_method where booking_id = '" . $d . "'"));
				return '<span style="color:#a50000;font-weight:bolder;">' . money($total_paid_amount['Total']) . '</span>';
			}
		}
	),
	array(
		'db' => 'transaction_type',
		'dt' => 4,
		'formatter' => function ($d, $row) {
			if ($d == 'Credit') {
				return '<button type="butoon" class="btn btn-xs btn-success">' . $d . '</button>';
			} else {
				return '<button type="butoon" class="btn btn-xs btn-danger">' . $d . '</button>';
			}
		}
	),
	array('db' => 'date',    'dt' => 5),
	array('db' => 'transaction_category',    'dt' => 6),
	array(
		'db' => 'uploader_info',
		'dt' => 7,
		'formatter' => function ($d, $row) {
			global $mysqli;
			if (!empty($d)) {
				$u = explode("___", $d);
				if (!empty($u[1])) {
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '" . $u[1] . "'"));
					return (is_null($emp)) ? '' : $emp['full_name'] . '-' . $emp['employee_id'];
					// return $emp['full_name'].'-'.$emp['employee_id'];
				}
			}
		}
	),
	array('db' => 'data',    'dt' => 8)
);

$sql_details = array('user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host);
echo json_encode(
	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
