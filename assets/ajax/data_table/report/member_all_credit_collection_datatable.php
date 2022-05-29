<?php
$file = $_SERVER['DOCUMENT_ROOT'] . '/datatables/pdo.php';
if (is_file($file)) {
	include($file);
}
include("../../../../application/config/ajax_config.php");
$table = 'payment_received_method';
$primaryKey = 'id';

$where = "booking_id = '" . rahat_decode($_GET['member_id']) . "' GROUP BY transaction_id";
$columns = array(
	array('db' => 'id',   'dt' => 0),
    array('db' => 'transaction_id',   'dt' => 1),
	array('db' => 'card_amount',   'dt' => 2),
    array('db' => 'cash_amount',   'dt' => 3),
    array('db' => 'mobile_amount',   'dt' => 4),
    array('db' => 'check_amount',   'dt' => 5),
	array(
		'db' => 'transaction_id',
		'dt' => 6,
		'formatter' => function ($d, $row) {
			if (!empty($d)) {
				global $mysqli;
				$total_paid_amount = mysqli_fetch_assoc($mysqli->query("select (SUM(card_amount)+SUM(cash_amount)+SUM(mobile_amount)+SUM(check_amount)) AS Total from payment_received_method where transaction_id = '" .$d. "'"));
				return '<span style="color:#a50000;font-weight:bolder;">' . money($total_paid_amount['Total']) . '</span>';
			}
		}
	),
	array('db' => 'payment_method',   'dt' => 7),
	array('db' => 'booking_id',
	 'dt' => 8,
	 'formatter' => function ($d, $row){
		if (!empty($d)) {
			global $mysqli;
			$CollectionPurpose = mysqli_fetch_assoc($mysqli->query("select (transaction_category) AS CollectionPurpose from  transaction where booking_id = '" . $d . "'"));
			return '<span style="color:#a50000;font-weight:bolder;">' .$CollectionPurpose['CollectionPurpose'] . '</span>';
		}
	 }
	),
	array('db' => 'data', 'dt' => 9)
);

$sql_details = array('user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host);
echo json_encode(
	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
