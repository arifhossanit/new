<?php

defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
error_reporting(E_ERROR | E_COMPILE_ERROR | E_WARNING);
error_reporting(0);
ini_set('display_errors', 0);

class Json extends CI_Controller
{
	private $header;
	private $authenticated;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
	}

	public function data_info($type = '', $field = '', $table = '', $where = '', $id = '', $desc = '', $row = '', $limit = '')
	{

		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		
		header('Content-Type: application/json');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		$data = array();

		if ($id == 'null') {
			$id = 'id';
		}
		if ($desc == 'null') {
			$desc = 'asc';
			$desc_new = 'null';
		}
		if ($row == 'null') {
			$row = 'row';
			$row_new = 'null';
		} else if ($row == 'one') {
			$row = 'row';
			$row_new = 'null';
		} else if ($row == 'all') {
			$row = 'result';
			$row_new = 'null';
		}
		if ($limit == 'null') {
			$limit = '';
			$limit_new = 'null';
		}

		if ($type == 'select') {
			if ($where == 'null') {
				$where = '';
			} else {
				$div = explode("_____", $where);
				$div_f = '';
				foreach ($div as $div_d) {
					$div_r = explode("-----", $div_d);
					$div_f .= "" . $div_r[0] . " = '" . urldecode($div_r[1]) . "' AND ";
				}
				$where = rtrim($div_f, 'AND ');
			}
			if ($field == 'null') {
				$jesn_data = $this->Dashboard_model->select($table, $where, $id, $desc, $row, $limit);
			} else {
				$field_f = '';
				$field_r = explode("-----", $field);
				foreach ($field_r as $field_d) {
					$field_f .= "" . $field_d . ",";
				}
				$field_f = rtrim($field_f, ',');
				$jesn_data = $this->Dashboard_model->select_field($table, $field_f, $where, $id, $desc, $row, $limit);
			}
			if (!empty($jesn_data)) {
				header('HTTP/1.0 200 OK');
				$data['message'] = true;
				$data['data'] = $jesn_data;
				echo json_encode($jesn_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			} else {
				header('HTTP/1.0 404 No Data Found!');
				$data['message'] = false;
				$data['data'] = 'No matching records found!';
				echo json_encode(array(0 => $data), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			}
		}

		if ($type == 'login') {
			if ($where == 'null') {
				$where = '';
			} else {
				$div = explode("_____", $where);
				$div_f = '';
				foreach ($div as $div_d) {
					$div_r = explode("-----", $div_d);
					$div_f .= "" . $div_r[0] . " = '" . urldecode($div_r[1]) . "' AND ";
				}
				$where = rtrim($div_f, 'AND ');
			}
			if ($field == 'null') {
				$jesn_data = $this->Dashboard_model->select($table, $where, $id, $desc, $row, $limit);
			} else {
				$field_f = '';
				$field_r = explode("-----", $field);
				foreach ($field_r as $field_d) {
					$field_f .= "" . $field_d . ",";
				}
				$field_f = rtrim($field_f, ',');
				$jesn_data = $this->Dashboard_model->select_field($table, $field_f, $where, $id, $desc, $row, $limit);
			}
			if (!empty($jesn_data)) {
				echo '1';
			} else {
				echo '0';
			}
		}


		if ($type == 'insert') {
			if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
				header('HTTP/1.0 400 Bad Request');
			}
			if ($this->db->insert($table, $_POST)) {
				header('HTTP/1.0 201 Created');
			} else {
				header('HTTP/1.0 500 Internal Server Error!' . $this->db->error());
				echo $this->db->error();
			}


			// if($where == 'null'){
			// 	$where = '';
			// }else{
			// 	$div = explode("_____",$where);
			// 	$div_f = '';
			// 	$div_g = '';
			// 	foreach($div as $div_d){
			// 		$div_r = explode("-----",$div_d);
			// 		$div_f .= "`".$div_r[0]."`,";
			// 		$div_g .= "'".urldecode($div_r[1])."',";
			// 	}
			// 	$name = rtrim($div_f,',');
			// 	$values = rtrim($div_g,',');
			// }

			// if($this->Dashboard_model->json_query("INSERT INTO $table ($name) VALUES ($values)")){				
			// 	$data['message'] = 'true';
			// 	$data['data'] = 'Data Insert SuccessFully';
			// 	echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
			// }else{
			// 	$data['message'] = 'false';
			// 	$data['data'] = 'Something Wrong! Please Try Again';
			// 	echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
			// }
		}

		if ($type == 'update') {
			if (empty($_POST)) {
				header('HTTP/1.0 400 Bad Request');
				echo json_encode($_POST);
			} else {
				if ($this->Dashboard_model->update_json($table, $_POST, $id, $desc)) {
					header('HTTP/1.0 200 OK');
				} else {
					header('HTTP/1.0 500 Internal Server Error!');
				}
			}
			// if($where == 'null'){
			// 	$where = '';
			// }else{
			// 	$div = explode("_____",$where);
			// 	$div_f = '';
			// 	foreach($div as $div_d){
			// 		$div_r = explode("-----",$div_d);
			// 		$div_f .= "`".$div_r[0]."` = '".urldecode($div_r[1])."',";
			// 	}
			// 	$values = rtrim($div_f,',');
			// }
			// if($this->Dashboard_model->json_query("UPDATE $table SET $values WHERE $id = '$desc'")){				
			// 	$data['message'] = 'true';
			// 	$data['data'] = 'Data Update SuccessFully';
			// 	echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
			// }else{
			// 	$data['message'] = 'false';
			// 	$data['data'] = 'Something Wrong! Please Try Again';
			// 	echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
			// }
		}

		if ($type == 'delete') {
			if ($this->Dashboard_model->json_query("DELETE FROM $table WHERE $id = '$desc'")) {
				header('HTTP/1.0 200 OK');
				$data['message'] = 'true';
				$data['data'] = 'Data Delete SuccessFully';
				echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			} else {
				header('HTTP/1.0 500 Internal Server Error!');
				$data['message'] = 'false';
				$data['data'] = 'Something Wrong! Please Try Again';
				echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			}
		}

		if ($type == 'join') {
			if (empty($_GET['join_table']) || empty($_GET['on_left']) || empty($_GET['on_right'])) {
				header('HTTP/1.0 502 Bad Gateway!');
				return;
			}
			if ($field == 'null') {
				$this->db->select('*');
			} else {
				$field_string = '';
				$field_arrays = explode("-----", $field);
				foreach ($field_arrays as $field_row) {
					$field_string .= "" . urldecode($field_row) . ",";
				}
				$field_string = rtrim($field_string, ',');
				$this->db->select($field_string);
			}
			$this->db->from($table);

			$join_table = $_GET['join_table'];
			$join_condition = $table . '.' . $_GET['on_left'] . " = " . $join_table . '.' . $_GET['on_right'];
			$this->db->join($join_table, $join_condition);
			if ($where != 'null') {
				$where_split = explode("_____", $where);
				$where_string = '';
				foreach ($where_split as $where_row) {
					$where_condition = explode("-----", $where_row);
					$where_string .= "" . $where_condition[0] . " = '" . urldecode($where_condition[1]) . "' AND ";
				}
				$where_string = rtrim($where_string, 'AND ');
				$this->db->where($where_string);
			}
			header('HTTP/1.0 200 OK!');
			$query = $this->db->get();
			$result = $query->result();
			echo json_encode($result);
		}
		if ($type == 'select_new') {
			if ($field == 'null') {
				$this->db->select('*');
			} else {
				$field_string = '';
				$field_arrays = explode("-----", $field);
				foreach ($field_arrays as $field_row) {
					$field_string .= "" . urldecode($field_row) . ",";
				}
				$field_string = rtrim($field_string, ',');
				$this->db->select($field_string);
			}

			$this->db->from($table);

			if ($where != 'null') {
				$where_clauses = explode('_____', $where);
				foreach ($where_clauses as $idx => $where_clause) {
					$expression_split = explode(':', $where_clause);
					if (count($expression_split) < 3) {
						header('HTTP/1.0  400 Bad Request');
						return;
					}
					/*
						$expression_split[0] => Column Name
						$expression_split[1] => Comparison symbols
						$expression_split[2] => Value
						$expression_split[3] => Optional: specify AND OR operation
						$expression_split[4] => Optional: Bracket
					*/
					if(isset($expression_split[3]) AND isset($expression_split[4]) AND $expression_split[4] == '('){
						$this->db->group_start();
					}else if($expression_split[3] == '('){
						$this->db->group_start();
					}
					switch ($expression_split[1]) {
						case 'in':
							$values = explode(',', $expression_split[2]);
							$this->db->where_in($expression_split[0], $values);
							break;
						case 'between':
							$date_between = explode(',', $expression_split[2]);
							if (strtolower($expression_split[3]) == 'or') {
								$this->db->or_where($expression_split[0] . ' ' . urldecode($expression_split[1]), $expression_split[2]);
							} else {
								$this->db->where('(' . urldecode($expression_split[0]) . ' between ' . urldecode($date_between[0]) . ' AND ' . urldecode($date_between[1]) . ')');
							}
							break;
						default:
							if (isset($expression_split[3])) {
								if (strtolower($expression_split[3]) == 'or') {
									$this->db->or_where($expression_split[0] . ' ' . urldecode($expression_split[1]), $expression_split[2]);
								} else {
									$this->db->where($expression_split[0] . ' ' . urldecode($expression_split[1]), $expression_split[2]);
								}
							} else {
								$this->db->where($expression_split[0] . ' ' . urldecode($expression_split[1]), $expression_split[2]);
							}
					}
					if(isset($expression_split[3]) AND isset($expression_split[4]) AND $expression_split[4] == ')'){
						$this->db->group_end();
					}else if($expression_split[3] == ')'){
						$this->db->group_end();
					}
				}
			}

			if ($desc_new != 'null') {
				$group_by = explode(',', $desc);
				$this->db->group_by($group_by);
			}

			if ($row_new != 'null') {
				$this->db->order_by(urldecode($row));
			}

			if ($limit_new != 'null') {
				$this->db->limit($limit);
			}

			// echo $this->db->get_compiled_select();
			header('HTTP/1.0 200 OK!');
			$query = $this->db->get();
			$result = $query->result();
			echo json_encode($result);
		}
		if ($type == 'join_new') {
			if (empty($_GET['join_table']) || empty($_GET['on_left']) || empty($_GET['on_right'])) {
				header('HTTP/1.0 400 Bad Request!');
				return;
			}
			if (count($_GET['join_table']) != count($_GET['on_left']) or count($_GET['on_left']) != count($_GET['on_right'])) {
				header('HTTP/1.0 400 Bad Request!');
				return;
			}
			if ($field == 'null') {
				$this->db->select('*');
			} else {
				$field_string = '';
				$field_arrays = explode("-----", $field);
				foreach ($field_arrays as $field_row) {
					$field_string .= "" . urldecode($field_row) . ",";
				}
				$field_string = rtrim($field_string, ',');
				$this->db->select($field_string);
			}
			$this->db->from($table);
			foreach ($_GET['join_table'] as $idx => $join_table) {
				$join_condition = $table . '.' . $_GET['on_left'][$idx] . " = " . $_GET['on_right'][$idx];
				$this->db->join($join_table, $join_condition);
			}
			if ($where != 'null') {
				$where_clauses = explode('_____', $where);
				foreach ($where_clauses as $idx => $where_clause) {
					$expression_split = explode(':', $where_clause);
					if (count($expression_split) < 3) {
						header('HTTP/1.0  400 Bad Request');
						return;
					}
					/*
						$expression_split[0] => Column Name
						$expression_split[1] => Comparison symbols
						$expression_split[2] => Value
						$expression_split[3] => Optional: specify AND OR operation
						$expression_split[4] => Optional: Bracket
					*/
					if(isset($expression_split[3]) AND isset($expression_split[4]) AND $expression_split[4] == '('){
						$this->db->group_start();
					}else if($expression_split[3] == '('){
						$this->db->group_start();
					}
					switch ($expression_split[1]) {
						case 'in':
							$values = explode(',', $expression_split[2]);
							$this->db->where_in($expression_split[0], $values);
							break;
						case 'between':
							$date_between = explode(',', $expression_split[2]);
							if (strtolower($expression_split[3]) == 'or') {
								$this->db->or_where($expression_split[0] . ' ' . urldecode($expression_split[1]), $expression_split[2]);
							} else {
								$this->db->where('(' . urldecode($expression_split[0]) . ' between ' . urldecode($date_between[0]) . ' AND ' . urldecode($date_between[1]) . ')');
							}
							break;
						default:
							if (isset($expression_split[3])) {
								if (strtolower($expression_split[3]) == 'or') {
									$this->db->or_where($expression_split[0] . ' ' . urldecode($expression_split[1]), $expression_split[2]);
								} else {
									$this->db->where($expression_split[0] . ' ' . urldecode($expression_split[1]), $expression_split[2]);
								}
							} else {
								$this->db->where($expression_split[0] . ' ' . urldecode($expression_split[1]), $expression_split[2]);
							}
					}
					if(isset($expression_split[3]) AND isset($expression_split[4]) AND $expression_split[4] == ')'){
						$this->db->group_end();
					}else if($expression_split[3] == ')'){
						$this->db->group_end();
					}
				}
			}
			// echo $this->db->get_compiled_select();
			// return;
			header('HTTP/1.0 200 OK!');
			$query = $this->db->get();
			$result = $query->result();
			echo json_encode($result);
		}
	}

	/**
	 * Authorize
	 */
	private function authorized($token, $device)
	{
		if (strpos($token, 'Bearer') === false) {
			header('HTTP/1.0 406 Not Acceptable');
			return false;
		}

		$token = substr($token, 7); // Getting substring without the 'Brearer' phrase.

		$this->db->select('*');
		$this->db->from('app_login_token');
		$this->db->where('token', $token);
		$this->db->where('device_id', $device);
		$this->db->where('valid_till >', date('Y-m-d H:i:s'));
		$validate = $this->db->get()->result_array();

		// echo $this->db->last_query();

		if (empty($validate)) {
			header('HTTP/1.0 401 Unauthorized');
			return false;
		}

		switch ($validate[0]['member_type']) {
			case 'employee':
				$this->authenticated = $this->Dashboard_model->mysqlij("SELECT * from employee where employee_id = '" . $validate[0]['member_id'] . "'");
		}
		return true;
	}

	/**
	 * Inserting contact information
	 */
	public function contact_information()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		header('Content-Type: application/json');
		header('Access-Control-Allow-Methods: POST');
		$contacts = json_decode(file_get_contents('php://input'), true);
		foreach ($contacts as $contact) {
			$existing = $this->Dashboard_model->mysqlij("SELECT * from member_contact_information where phone = '" . $contact['phone'] . "'");
			if (is_null($existing)) {
				$this->db->insert('member_contact_information', $contact);
			}
		}
	}

	/**
	 * File uplaod
	 */
	public function file_upload()
	{
		if (isset($_FILES['ta_da_file'])) {
			echo $this->store('ta_da_file', 'ta_da_attachment');
			return;
		}

		if (isset($_FILES['profile_picture'])) {
			echo $this->store('profile_picture', 'employee/employee_photo');
			return;
		}
		if (isset($_FILES['bill_attachment'])) {
			echo $this->store('bill_attachment', 'other_document/petty_cash');
			return;
		}
	}

	public function store($file_name, $dir)
	{
		$filename 		= $_FILES[$file_name]["name"];
		$file_tmp 		= $_FILES[$file_name]["tmp_name"];
		$file_ext 		= substr($filename, strripos($filename, '.'));
		if ($file_ext == '.jpg' || $file_ext == '.jpeg' || $file_ext == '.png' || $file_ext == '.gif') {
			$newfilename 	= md5($filename) . '_FILES_' . date('d_m_Y') . '_' . rand() * time() . '_' . time() * rand() . $file_ext;
			$newfile 		= 'assets/uploads/' . $dir . '/' . $newfilename;
			move_uploaded_file($file_tmp, $newfile);
			return $newfile;
		}else{
			header('HTTP/1.0 400 Bad Request');
			return 'Wrong file type!';
		}
	}

	public function petty_cash()
	{

		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
			$petty_cash = json_decode(file_get_contents('php://input'), true);
			$this->Dashboard_model->mysqliq("UPDATE branch_petty_cash set amount = amount - " . $petty_cash['amount'] . " where branch_id = '" . $petty_cash['branch_id'] . "'");
			header('HTTP/1.0 200 OK');
			return;
		}
	}

	public function login()
	{
		$condition = array(
			'employee_id' => $_POST['employee_id'],
			'status' => 1
		);
		$get_employee = $this->Dashboard_model->select('employee', $condition, 'id', 'row', 'DESC');

		if (empty($get_employee)) {
			header('HTTP/1.0 404 Not Found!');
			echo json_encode(array('message' => 'User not found!'));
			return;
		}

		if (md5($_POST['password']) !== $get_employee[0]->password) {
			header('HTTP/1.0 406 Not Acceptable!');
			echo json_encode(array('message' => 'Wrong password!'));
			return;
		}

		$now = new DateTime(date('Y-m-d H:i:s'));
		$validity = new DateTime(date('Y-m-d H:i:s'));
		$validity->add(new DateInterval('P1Y'));

		$log_information = array(
			'member_type' => 'employee',
			'member_id' => $_POST['employee_id'],
			'requested_at' => $now->format('Y-m-d H:i:s u'),
			'device_id' => $_POST['device_id'],
		);
		$this->Dashboard_model->insert('app_login_log', $log_information);

		/**
		 * Deleting previous token.
		 */
		$this->Dashboard_model->mysqliq("DELETE from app_login_token where member_id = '" . $_POST['employee_id'] . "'");

		$bytes = random_bytes(20);
		$token = bin2hex($bytes);

		$app_login = array(
			'member_type' => 'employee',
			'member_id' => $_POST['employee_id'],
			'token' => $token,
			'valid_till' => $validity->format('Y-m-d H:i:s u'),
			'device_id' => $_POST['device_id'],
		);
		$this->Dashboard_model->insert('app_login_token', $app_login);

		header('HTTP/1.0 201 Created');
		echo json_encode(array('token' => $token));
		return;
	}

	public function transaction()
	{

		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$today = new DateTime("now");

		$branch_information = $this->Dashboard_model->mysqlij("SELECT * FROM branches WHERE branch_id = '" . $this->authenticated->branch . "'");

		$transaction_id = $branch_information->branch_code . '-' . $today->format('dmy-his-u');

		$informations = json_decode(file_get_contents('php://input'), true);

		if (is_null($informations)) {
			header('HTTP/1.0 400 Bad Request');
			return;
		}

		if (!$informations) {
			header('HTTP/1.0 408 Request Timeout');
			return;
		}

		$care_of = $this->Dashboard_model->select('employee', array('employee_id' => $informations['care_of']), 'id', 'desc', 'row');

		$payment_methods_string = '';

		foreach ($informations['payment_method'] as $method => $amount) {
			$card_amount = '';
			$cash_amount = '';
			$mobile_amount = '';
			$check_amount = '';
			switch ($method) {
				case 'cash':
					$cash_amount = $amount;
					break;
				case 'mobile_banking':
					$mobile_amount = $amount;
					break;
				case 'card':
					$card_amount = $amount;
					break;
				case 'cheque':
					$check_amount = $amount;
					break;
			}
			$payment_received = array(
				'transaction_id' 		=> $transaction_id,
				'branch_id' 			=> $branch_information->branch_id,
				'booking_id' 			=> '',
				'payment_method' 		=> ucfirst($method),
				'details' 				=> $informations['account'],
				'card_amount' 			=> $card_amount,
				'cash_amount' 			=> $cash_amount,
				'mobile_amount' 		=> $mobile_amount,
				'check_amount' 			=> $check_amount,
				'invoice_number' 		=> '',
				'note' 					=> 'Received By Self (' . $care_of->full_name . ') TD/DA Bill',
				'status' 				=> '1',
				'uploader_info' 		=> $this->uploader_info(),
				'data' 					=> date('d/m/Y')
			);
			$this->Dashboard_model->insert('payment_received_method', $payment_received);
			$payment_methods_string .= ucfirst($method) . ',';
		}
		$payment_methods_string = rtrim($payment_methods_string, ',');

		$transaction = array(
			'transaction_id' 		=> $transaction_id,
			'branch_id' 			=> $branch_information->branch_id,
			'booking_id' 			=> '',
			'careof' 				=> $care_of->full_name,
			'account_type' 			=> 'Defult',
			'account' 				=> 'Defult',
			'amount' 				=> $informations['transaction'],
			'date' 					=> date('l, d/m/Y h:i:sa'),
			'transaction_type' 		=> 'Debit',
			'transaction_category' 	=> $informations['transaction'],
			'transaction_method' 	=> $payment_methods_string,
			'data_one' 				=> '',
			'data_two' 				=> '',
			'data_three' 			=> '',
			'note' 					=> $care_of->employee_id,
			'status' 				=> '1',
			'uploader_info' 		=> $this->uploader_info(),
			'data' 					=> date('d/m/Y')
		);
		$this->Dashboard_model->insert('transaction', $transaction);
	}

	public function advance_salary()
	{

		header('HTTP/1.0 406 Not Acceptable');
		echo (json_encode(array('message' => 'Advance salary not available through app!', 'limit' => '')));
		return;

		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$current_date = new DateTime(date('Y-m-d'));
		$advance_salary_date = new DateTime('first day of last month');

		$already_taken_advance_info = $this->Dashboard_model->mysqlij("SELECT * from employee_grant_loan where employee_id = '" . $this->authenticated->employee_id . "' AND applied_for = '" . $advance_salary_date->format('Y-m-d') . "' AND aproval != 2 AND aproval_account != 2");
		if (!is_null($already_taken_advance_info)) {
			header('HTTP/1.0 406 Not Acceptable');
			echo (json_encode(array('message' => 'Advance salary already applied for this month!')));
			return;
		}

		$joining_date = new DateTime(date('d/m/Y', strtotime($this->authenticated->date_of_joining)));
		$joining_date_diff_till_today = $current_date->diff($joining_date);
		if ($joining_date_diff_till_today->m <= 3 AND $joining_date_diff_till_today->y == 0) {
			header('HTTP/1.0 406 Not Acceptable');
			echo (json_encode(array('message' => 'You are not yet eligible!')));
			return;
		}
		$year_substr = substr($advance_salary_date->format('Y'), 2, 2);
		$total_attendence = $this->Dashboard_model->mysqlij("SELECT COUNT(DISTINCT(days)) as total_days from employee_attendence WHERE month = '" . $advance_salary_date->format('m') . "' AND years = '$year_substr' AND employee_id = '" . $this->authenticated->employee_id . "'");
		$total_abscent = $this->Dashboard_model->mysqlij("SELECT COUNT(DISTINCT(employee_leave_logs.days)) as total_days from employee_leave_logs INNER JOIN employee_everyday_leave_logs USING (unique_id) WHERE employee_leave_logs.month = '" . $advance_salary_date->format('m') . "' AND employee_leave_logs.year = '" . $advance_salary_date->format('Y') . "' AND employee_id = '" . $this->authenticated->employee_id . "' AND employee_leave_logs.aproval = '1' AND employee_everyday_leave_logs.status = '1'");
		$total_working_days = (int)$total_attendence->total_days - (int)$total_abscent->total_days;

		$basic_salary = $total_working_days * $this->authenticated->basic_salary;

		$total_increment = 0;
		$increments = $this->Dashboard_model->mysqlii("SELECT * from employee_increament_logs where employee_id = '" . $this->authenticated->employee_id . "' AND status = 1 AND aproval = 1");
		foreach ($increments as $increment) {
			$increment_starting_date = new DateTime(date('d/m/Y', strtotime($increment->start_date)));

			if ($increment_starting_date < $advance_salary_date) {
				$total_increment += $increment->amount * $total_working_days;
				continue;
			}

			$increment_total_days = (int)$increment_starting_date->format('t') - (int)$increment_starting_date->format('d');
			$total_increment += $increment->amount * $increment_total_days;
		}

		$total_decrement = 0;
		$decrements = $this->Dashboard_model->mysqlii("SELECT * from employee_decreament_logs where employee_id = '" . $this->authenticated->employee_id . "' AND status = 1 AND aproval = 1");
		if (!is_null($decrements)) {
			foreach ($decrements as $decrement) {
				$decrement_starting_date = new DateTime(date('d/m/Y', strtotime($decrement->start_date)));

				if ($decrement_starting_date < $advance_salary_date) {
					$total_decrement += $decrement->amount * $total_working_days;
					continue;
				}

				$decrement_total_days = (int)$decrement_starting_date->format('t') - (int)$decrement_starting_date->format('d');
				$total_decrement += $decrement->amount * $decrement_total_days;
			}
		}

		$tota_salary = $basic_salary + $total_increment + $total_decrement;
		$advance_limit = $tota_salary / 2;

		if ($advance_limit < 0) {
			$advance_limit = 0;
		}

		if ($advance_limit < $_POST['amount']) {
			header('HTTP/1.0 406 Not Acceptable');
			echo (json_encode(array('message' => 'Limit exceeded!', 'limit' => $advance_limit)));
			return;
		}

		$insert_arr = array(
			'e_db_id' => $this->authenticated->id,
			'employee_id' => $this->authenticated->employee_id,
			'amount' => $_POST['amount'],
			'note' => $_POST['note'],
			'aproval' => 0,
			'aproval_account' => 0,
			'status' => 1,
			'uploader_info' => $this->uploader_info(),
			'data' => date('d/m/Y'),
			'applied_for' => $advance_salary_date->format('Y-m-d'),
		);
		$this->Dashboard_model->insert('employee_grant_loan', $insert_arr);
	}

	function uploader_info()
	{
		return $this->authenticated->role_name . '___' . $this->authenticated->email . '___' . $this->authenticated->branch;
	}

	public function app_login()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$token = $_GET['key'];
		$current_time = date('Y-m-d H:i:s');
		$validate = $this->Dashboard_model->mysqlij("SELECT * from app_desktop_login_token where token = '$token' AND expired_in > '$current_time'");

		if (is_null($validate)) {
			header('HTTP/1.0 401 Unauthorized');
			echo (json_encode(array('message' => 'QR Code session expired!')));
			return;
		}
		$this->Dashboard_model->update('app_desktop_login_token', array('status' => 1, 'employee_id' => $this->authenticated->employee_id), $validate->id);
	}

	/**
	 * Notification!
	 * 
	 */

	public function notification_stream()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		header("Cache-Control: no-cache");
		header("Content-Type: text/event-stream");

		while (true) {
			$notificaiton_count =  0;
			$this->db->select('COUNT(*) as amount');
			$this->db->from('notification');
			$this->db->where('user_id', $this->authenticated->employee_id);
			$this->db->where('is_pushed', 0);
			$query = $this->db->get();
			if ($query->result()[0]->amount > 0) {
				$notificaiton_count +=  $query->result()[0]->amount;
			}

			echo 'data: {"count": "' . $notificaiton_count . '"}';
			echo "\n\n";

			if (ob_get_contents()) ob_end_flush();
			flush();

			if (connection_aborted()) break;

			sleep(30);
		}
	}

	public function notification_show()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$this->db->select('*');
		$this->db->from('notification');
		$this->db->where('user_id', $this->authenticated->employee_id);
		$result = $this->db->get();
		echo json_encode($result->result());
	}

	public function notification_read()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$this->Dashboard_model->update('notification', array('is_read' => '1'), $_POST['id']);
	}

	public function notification_push()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$this->Dashboard_model->mysqliq("UPDATE notification set is_pushed = 1 where user_id = '" . $this->authenticated->employee_id . "' AND creation_date < '" . $_POST['time'] . "'");
	}

	public function set_user()
	{
		$this->header = $this->input->request_headers();
		if(!$this->authorized($this->header['authorization'], $this->header['device'])){
			exit();
		}
		
		if(!isset($_POST['player_id'])){
			header('HTTP/1.0 400 Bad Request');
			return;
		}

		$this->Dashboard_model->mysqliq("UPDATE employee set player_id = '".$_POST['player_id']."' where id = ".$this->authenticated->id);
	}

	public function notification_create()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$notification_type = 0;
		if (strpos(strtolower($_POST['header']), 'leave') !== false) {
			$notification_type = 1;
		}
		if (strpos(strtolower($_POST['header']), 'ta/da') !== false) {
			$notification_type = 2;
		}
		if (strpos(strtolower($_POST['header']), 'advance salary') !== false) {
			$notification_type = 3;
		}
		if (strpos(strtolower($_POST['header']), 'purchase money') !== false) {
			$notification_type = 4;
		}
		if($_POST['type'] == 'personal'){

			$player_id = $this->Dashboard_model->mysqlij("SELECT player_id from employee where employee_id = '".$_POST['user_id']."'");

			$data = array(
				'user_id' => $_POST['user_id'],
				'user_type' => '1',
				'n_header' => $_POST['header'],
				'n_message' => $_POST['message'],
				'n_links' => '',
				'is_read' => '0',
				'uploader_info' => $this->uploader_info(),
				'creation_date' => date('Y-m-d H:i:s'),
				'is_pushed' => '0',
				'notification_type' => $notification_type
			);

			$this->Dashboard_model->insert('notification', $data);
            
			$this->onesignal($_POST['message'], $_POST['header'], array(0 => $player_id->player_id));

			header('HTTP/1.0 201 Created');
			return;
		}

		if($_POST['broadcast_scope'] == 'company'){
			$players = array();
			$data = array();
			$employees = $this->Dashboard_model->mysqlii("SELECT employee.employee_id, employee.player_id from employee LEFT JOIN unsubscribed_broadcast_notification on unsubscribed_broadcast_notification.employee_id = employee.employee_id where employee.status = 1 AND unsubscribed_broadcast_notification.employee_id is null");
			foreach($employees as $employee){
				if($_POST['user_id'] != $employee->employee_id){
					if(!is_null($employee->player_id)){
						array_push($players, $employee->player_id);
					}
					$data[] = array(
						'user_id' => $employee->employee_id,
						'user_type' => '1',
						'n_header' => $_POST['header'],
						'n_message' => $_POST['message'],
						'n_links' => '',
						'is_read' => '0',
						'uploader_info' => $this->uploader_info(),
						'creation_date' => date('Y-m-d H:i:s'),
						'is_pushed' => '0',
						'notification_type' => $notification_type
					);
				}
			}
			$this->db->insert_batch('notification', $data);
			$this->onesignal($_POST['message'], $_POST['header'], $players);
			header('HTTP/1.0 201 Created');
			return;
		}

		if($_POST['broadcast_scope'] == 'department'){
			$players = array();
			$employees = $this->Dashboard_model->mysqlii("SELECT employee_id, player_id from employee where department = '".$_POST['department']."' AND status = 1");
			$user_id = (!empty($_POST['user_id'])) ? $_POST['user_id'] : '';
			foreach($employees as $employee){
				if($user_id != $employee->employee_id){
					if(!is_null($employee->player_id)){
						array_push($players, $employee->player_id);
					}
					$data = array(
						'user_id' => $employee->employee_id,
						'user_type' => '1',
						'n_header' => $_POST['header'],
						'n_message' => $_POST['message'],
						'n_links' => '',
						'is_read' => '0',
						'uploader_info' => $this->uploader_info(),
						'creation_date' => date('Y-m-d H:i:s'),
						'is_pushed' => '0',
						'notification_type' => $notification_type
					);
					$this->Dashboard_model->insert('notification', $data);
				}
			}
			$this->db->insert_batch('notification', $data);
			$this->onesignal($_POST['message'], $_POST['header'], $players);
			header('HTTP/1.0 201 Created');
			return;
		}
		header('HTTP/1.0 400 Error');
	}

	public function onesignal($body, $title, $player_id)
	{
		$key = 'NGY1ZGQ5YTItNjRjOC00MTcyLTg4MzUtZWE4MTk1ZDhjMDdk';
		$content      = array(

			"en" => $body,

		);

		$headings = array(

			'en' => $title

		);

		$ios_img = array(
			"id1" => '',
		);
		$fields = array(
			'app_id' => '47e73b79-77ca-4983-a4ce-81af34df9018',
			'headings' => $headings,
			'include_player_ids' => $player_id,
			'data' => array( 'foo' => 'bar' ),
			'big_picture' => '',
			'large_icon' => '',
			'content_available' => true,
			'contents' => $content,
			'ios_attachments' => $ios_img,
		);

		$fields = json_encode($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 
			'Authorization: Basic ' . $key));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

		$response = curl_exec($ch);
		curl_close($ch);
		// print $response;
	}

	// =============== ! END

	public function location_stream()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$query = $this->db->query("SELECT location_data.date, employee.employee_id, employee.full_name, employee.photo, location_data.longitude, location_data.latitude FROM `location_data` INNER JOIN employee on employee.employee_id = location_data.user_id WHERE location_data.id in ( SELECT MAX(id) from location_data GROUP BY user_id) AND employee.status = 1");
		echo json_encode($query->result());
	}

	public function version()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$this->db->select('major, minor, patch, link, state');
		$result = $this->db->get('app_version');
		echo json_encode($result->result());
	}

	public function missing_attendance()
	{
		
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		
		$missing_attendances = json_decode(file_get_contents('php://input'), true);
		$unique_id = time() * rand();
		$note = $missing_attendances['note'];
		$number_of_days = count($missing_attendances['requests']);
		
		foreach ($missing_attendances['requests'] as $missing_attendance) {
			
			$date = explode('-', $missing_attendance['date']);
			$days = $date[2];
			$month = $date[1];
			$years = $date[0];
			$adj_date = $days . '/' . $month . '/' . $years;
			$insert_data[] = array(
				'id' => '',
				'unique_id' => $unique_id,
				'employee_id' => $this->authenticated->employee_id,
				'adj_date' => $adj_date,
				'days' => $days,
				'month' => $month,
				'years' => $years,
				'adj_reason' => $missing_attendance['reason'],
				'status' => '1',
				'is_hr_checked' => '0',
				'hr_note' => '',
				'aproval' => '0',
				'deduction_amount' => '0',
				'uploader_info' => $this->uploader_info(),
				'data' => date('d/m/Y')
			);
		}
		//forgot
		$request_manage = array(
			'id' => '',
			'employee_id' => $this->authenticated->employee_id,
			'unique_id' => $unique_id,
			'number_of_days' => $number_of_days,
			'status' => '1',
			'is_hr_checked' => '1',
			'hr_note' => '',
			'boss_note' => '',
			'aproval' => '1',
			'note' => $note,
			'uploader_info' => $this->uploader_info(),
			'data' => date('d/m/Y')
		);
		$this->Dashboard_model->insert_batch('employee_missing_attendance_request_date', $insert_data);
		$this->Dashboard_model->insert('employee_missing_attendance_request', $request_manage);

		header('HTTP/1.0 201 Created');
	}

	/**
	 * Employee Resign
	 * 
	 */

	public function employee_own_resign_request()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$department  = $this->authenticated->department;
		$get_d_head = $this->Dashboard_model->select('employee', array('department' => $department, 'd_head' => '1', 'branch' => $this->authenticated->branch), 'id', 'desc', 'row');
		if (!empty($get_d_head->employee_id)) {
			if ($get_d_head->id == $this->authenticated->id) {
				$get_head_reporting = $this->Dashboard_model->select('employee', array('id' => $this->authenticated->d_head_reporting), 'id', 'desc', 'row');
				$d_head_id = $get_head_reporting->id;
				$d_head_e_id = $get_head_reporting->employee_id;
			} else {
				$d_head_id = $get_d_head->id;
				$d_head_e_id = $get_d_head->employee_id;
			}
			$aproval = 0;
		} else {
			$get_d_head = $this->Dashboard_model->select('employee', array('department' => '1383007286312996344', 'd_head' => '1'), 'id', 'desc', 'row');
			$d_head_id = $get_d_head->id;
			$d_head_e_id = $get_d_head->employee_id;
			$aproval = 1;
			$insert_data_hr = array(
				'id' 					=> '',
				'e_db_id' 				=> $this->authenticated->id,
				'employee_id' 			=> $this->authenticated->employee_id,
				'department_head_id' 	=> $d_head_id,
				'department_head_e_id' 	=> $d_head_e_id,
				'application' 			=> $this->input->post('application'),
				'aproval' 				=> $aproval,
				'note' 					=> '',
				'status' 				=> '1',
				'uploader_info' 		=> uploader_info(),
				'data' 					=> date('d/m/Y')
			);
			$this->Dashboard_model->insert('employee_resign_request_to_hr', $insert_data_hr);
		}

		$insert_data = array(
			'id' 					=> '',
			'e_db_id' 				=> $this->authenticated->id,
			'employee_id' 			=> $this->authenticated->employee_id,
			'department_head_id' 	=> $d_head_id,
			'department_head_e_id' 	=> $d_head_e_id,
			'application' 			=> $this->input->post('application'),
			'aproval' 				=> $aproval,
			'note' 					=> '',
			'status' 				=> '1',
			'uploader_info' 		=> $this->uploader_info(),
			'data' 					=> date('d/m/Y')
		);

		$update_date_logs = array(
			'id' => '',
			'employee_id' => $this->authenticated->employee_id,
			'old_date' => $this->authenticated->data,
			'new_date' => date('d/m/Y'),
			'note' => 'employee_own_resign_request',
			'uploader_info' => $this->uploader_info(),
			'data' => date('d/m/Y')
		);
		$update_date = array(
			'data' => date('d/m/Y')
		);
		$this->Dashboard_model->insert('employee_resign_request', $insert_data);
		$this->Dashboard_model->insert('emp_release_date_update_logs', $update_date_logs);
		$this->Dashboard_model->update('employee', $update_date, $this->authenticated->id);

		header('HTTP/1.0 201 Created!');
	}

	public function resign_accept($id)
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$note = $this->input->post('note');
		$get_data = $this->Dashboard_model->select('employee_resign_request', array('id' => $id), 'id', 'desc', 'row');

		if ($get_data->department_head_id != $this->authenticated->id) {
			header('HTTP/1.0 406 Unacceptable!');
			return;
		}

		$get_hr_data = $this->Dashboard_model->select('employee', array('department' => '1383007286312996344', 'd_head' => '1'), 'id', 'desc', 'row');
		$insert_data_hr = array(
			'id' 					=> '',
			'e_db_id' 				=> $get_data->e_db_id,
			'employee_id' 			=> $get_data->employee_id,
			'department_head_id' 	=> $get_hr_data->id,
			'department_head_e_id' 	=> $get_hr_data->employee_id,
			'application' 			=> $get_data->application,
			'aproval' 				=> '0',
			'note' 					=> $note,
			'status' 				=> '1',
			'uploader_info' 		=> $this->uploader_info(),
			'data' 					=> date('d/m/Y')
		);

		$this->Dashboard_model->insert('employee_resign_request_to_hr', $insert_data_hr);
		$this->Dashboard_model->mysqliq("UPDATE employee_resign_request set aproval = 1, note = '$note' where id = $id");

		echo json_encode(array('message', 'Accepted!'));
	}

	public function resign_reject($id)
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$get_data = $this->Dashboard_model->select('employee_resign_request', array('id' => $id), 'id', 'desc', 'row');

		if ($get_data->department_head_id != $this->authenticated->id) {
			header('HTTP/1.0 406 Unacceptable!');
			return;
		}

		$note = $this->input->post('note');
		$update_data = array(
			'aproval' => '2',
			'note' => $note
		);
		$this->Dashboard_model->update('employee_resign_request', $update_data, $id);
		echo json_encode(array('message', 'Rejected!'));
	}

	public function resign_show()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		echo (json_encode($this->Dashboard_model->mysqlii("SELECT employee.full_name, employee.photo, employee_resign_request.* from employee_resign_request INNER JOIN employee on employee.id = employee_resign_request.e_db_id where department_head_id  = '" . $this->authenticated->id . "' and aproval = '0' order by id desc limit 200")));
	}

	// ========== ! END

	/**
	 * Service Requisition
	 * 
	 */

	public function check_availability()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$start_date = new DateTime($_POST['requisition_date'] . ' ' . $_POST['from_time']);

		$end_date_in_minute = (int)$_POST['requisition_duration'] * 60;
		$end_date = new DateTime($_POST['requisition_date'] . ' ' . $_POST['from_time']);
		$end_date = $end_date->add(new DateInterval('PT' . $end_date_in_minute . 'M'));

		$validate = $this->Dashboard_model->mysqlij("SELECT scm_service_requisition.id,scm_service_requisition.start_date,scm_service_requisition.end_date, employee.full_name from scm_service_requisition INNER JOIN employee on employee.employee_id = scm_service_requisition.requisition_by where ( ( '" . $end_date->format('Y-m-d H:i:s') . "' between start_date AND end_date ) OR ( '" . $start_date->format('Y-m-d H:i:s') . "' between start_date AND end_date ) ) AND scm_service_requisition.service_product_id = " . $_POST['car_id']);
		if (!is_null($validate)) {
			header('HTTP/1.0 406 Not Acceptable');
			return;
		}
		header('HTTP/1.0 200 OK');
	}

	public function test()
	{
		$end_date_in_minute = floatval($_POST['requisition_duration']) * 60;
		$end_date = new DateTime($_POST['requisition_date'] . ' ' . $_POST['from_time']);
		$end_date = $end_date->add(new DateInterval('PT' . $end_date_in_minute . 'M'));
		echo $end_date->format('Y-m-d H:i:s');
	}

	public function service_request()
	{
		// Test
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$error = false;
		$message = "Successfully done!";

		$start_date = new DateTime($_POST['requisition_date'] . ' ' . $_POST['from_time']);

		$end_date_in_minute = floatval($_POST['requisition_duration']) * 60;
		$end_date = new DateTime($_POST['requisition_date'] . ' ' . $_POST['from_time']);
		$end_date = $end_date->add(new DateInterval('PT' . $end_date_in_minute . 'M'));

		$validate = $this->Dashboard_model->mysqlij("SELECT scm_service_requisition.id,scm_service_requisition.start_date,scm_service_requisition.end_date, employee.full_name from scm_service_requisition INNER JOIN employee on employee.employee_id = scm_service_requisition.requisition_by where ( ( '" . $end_date->format('Y-m-d H:i:s') . "' between driver_start_date AND driver_end_date ) OR ( '" . $start_date->format('Y-m-d H:i:s') . "' between driver_start_date AND driver_end_date ) ) AND scm_service_requisition.status != 0 AND scm_service_requisition.service_product_id = " . $_POST['car_id']);
		if (is_null($validate)) {
			if (strtolower($_POST['destination_from']) == 'other') {
				$destination_from = $_POST['from_other'];
			} else {
				$destination_from = $_POST['destination_from'];
			}
			if (strtolower($_POST['destination_to']) == 'other') {
				$destination_to = $_POST['to_other'];
			} else {
				$destination_to = $_POST['destination_to'];
			}
			$insert_data = array(
				'service_product_id' => $_POST['car_id'],
				'start_date' => $start_date->format('Y-m-d H:i:s'),
				'end_date' => $end_date->format('Y-m-d H:i:s'),
				'destination_from' => $destination_from,
				'destination_to' => $destination_to,
				'requisition_by' => $this->authenticated->employee_id,
				'creation_date' => date('Y-m-d H:i:s'),
				'uploader_info' => $this->authenticated->employee_id,
				'status' => '1',
				'note' => $_POST['note'],
				'driver_start_date' => $start_date->format('Y-m-d H:i:s'),
				'driver_end_date' => $end_date->format('Y-m-d H:i:s'),
				'confirmation_code' => rand(10000, 99999),
			);
			if (!$this->Dashboard_model->insert('scm_service_requisition', $insert_data)) {
				$message = $this->db->error();
				header('HTTP/1.0 406 Not Acceptable');
			} else {
				header('HTTP/1.0 201 Created');
			}
			$info = array(
				'message' => $message,
			);
			echo json_encode($info);
			return;
		}

		$error = true;
		$validate_start_date = new DateTime($validate->start_date);
		$validate_end_date = new DateTime($validate->end_date);
		if ($validate_start_date->format('Y-m-d') < $validate_end_date->format('Y-m-d')) {
			$time_string = "from: " . $validate_start_date->format('d-m-Y h:i A') . " to: " . $validate_end_date->format('h:i A') . "";
		} else if ($validate_start_date->format('Y-m-d') < $validate_end_date->format('Y-m-d')) {
			$time_string = "from: " . $validate_start_date->format('h:i A') . " to: " . $validate_end_date->format('d-m-Y h:i A') . "";
		} else {
			$time_string = "from: " . $validate_start_date->format('h:i A') . " to: " . $validate_end_date->format('h:i A') . "";
		}
		$message = "Requisiton conflicts with " . $validate->full_name . "s requition " . $time_string;
		header('HTTP/1.0 406 Not Acceptable');
		$info = array(
			'message' => $message,
		);
		echo json_encode($info);
		return;
	}

	public function services_show()
	{
		$get_requisition_types = $this->Dashboard_model->mysqlii("SELECT scm_service_product_details.description as name, scm_service_product_details.requisition_type, scm_service_product_details.id from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id where scm_service_product_details.product_type_id = 122");
		$this->db->select('branch_id, branch_name');
		$result = $this->db->get('branches');
		echo json_encode(array(
			'cars' => $get_requisition_types,
			'branches' => $result->result(),
		));
	}

	public function scheduled_rides()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$result = $this->Dashboard_model->mysqlii("SELECT employee.full_name,employee.photo, scm_service_requisition.id as service_id, scm_service_requisition.* from scm_vehicle_driver_log INNER JOIN scm_service_product_details on scm_service_product_details.id = scm_vehicle_driver_log.service_product_details_id INNER JOIN scm_service_requisition on scm_service_requisition.service_product_id = scm_service_product_details.id INNER JOIN employee on employee.employee_id = scm_service_requisition.requisition_by WHERE scm_vehicle_driver_log.driver_id = " . $this->authenticated->employee_id . " AND ( scm_service_requisition.start_date LIKE '" . $_POST['date'] . "%' OR scm_service_requisition.end_date LIKE '" . $_POST['date'] . "%' ) AND scm_service_requisition.status = 2 ORDER BY start_date, end_date");
		echo json_encode($result);
	}

	public function upcoming_ride()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$result = $this->Dashboard_model->mysqlij("SELECT scm_service_requisition.id as service_id, requestee.full_name, requestee.photo,  scm_service_requisition.*
		from scm_service_requisition
		INNER JOIN employee requestee on requestee.employee_id = scm_service_requisition.requisition_by
		INNER JOIN scm_vehicle_driver_log on scm_vehicle_driver_log.service_product_details_id = scm_service_requisition.service_product_id
		INNER JOIN employee driver on driver.employee_id = scm_vehicle_driver_log.driver_id
		where scm_service_requisition.start_date LIKE '" . date('Y-m-d') . "%'
		AND scm_service_requisition.status IN (2, 3)
		AND driver.employee_id = '" . $this->authenticated->employee_id . "'
		ORDER BY scm_service_requisition.start_date ASC LIMIT 1");

		echo empty($result) ? json_encode(array('message' => 'No Upcoming Ride!')) : json_encode($result);
	}

	public function start_ride($id)
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$validate = $this->Dashboard_model->mysqlij("SELECT id from scm_service_requisition where id = " . $id . " AND confirmation_code = '" . $_POST['confirmation_code'] . "'");

		if (empty($validate)) {
			header('HTTP/1.0 406 Unacceptable');
			json_encode(array('message', 'Confirmation code did not match!'));
			return;
		}

		$update_data = array(
			'status' => 3,
			'driver_start_date' => date('Y-m-d H:i:s'),
			'mileage_start' => $_POST['mileage'],
		);

		$this->Dashboard_model->update('scm_service_requisition', $update_data, $id);

		$insert_log = array(
			'service_requisition_id' => $id,
			'note' => $_POST['note'],
			'uploader' => $this->authenticated->employee_id,
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->Dashboard_model->insert('scm_service_driver_travel_logs', $insert_log);

		header('HTTP/1.0 200 OK');
		json_encode(array('message', 'Successfully Started!'));
		return;
	}

	public function end_ride($id)
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$update_data = array(
			'status' => 4,
			'driver_end_date' => date('Y-m-d H:i:s'),
			'mileage_end' => $_POST['mileage'],
		);

		$this->Dashboard_model->update('scm_service_requisition', $update_data, $id);

		$insert_log = array(
			'service_requisition_id' => $id,
			'note' => $_POST['note'],
			'uploader' => $this->authenticated->employee_id,
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->Dashboard_model->insert('scm_service_driver_travel_logs', $insert_log);

		header('HTTP/1.0 200 OK');
		json_encode(array('message', 'Successfully Ended!'));
		return;
	}

	public function service_requests_show()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		echo json_encode($this->Dashboard_model->mysqlii("SELECT scm_service_requisition_approval_logs.note as approval_note, employee.full_name, employee.photo,scm_service_requisition.id as service_id, scm_service_requisition.*, scm_service_product_details.description, scm_service_product_details.requisition_type, scm_product_category.name, scm_service_product_details.id from scm_service_product_details
			INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id
			INNER JOIN scm_service_requisition on scm_service_requisition.service_product_id = scm_service_product_details.id
			INNER JOIN employee on employee.employee_id = scm_service_requisition.requisition_by
			LEFT JOIN scm_service_requisition_approval_logs on scm_service_requisition_approval_logs.service_requisition_id = scm_service_requisition.id
			where scm_service_product_details.product_type_id = 122
			-- AND ( scm_service_requisition.end_date LIKE '" . $_POST['date'] . "%' OR scm_service_requisition.start_date LIKE '" . $_POST['date'] . "%' )
			AND ( scm_service_requisition_approval_logs.id = ( SELECT max(id) from scm_service_requisition_approval_logs WHERE service_requisition_id = scm_service_requisition.id ) OR scm_service_requisition_approval_logs.id is null)"));
	}

	public function requisition_approval()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		echo json_encode($this->Dashboard_model->mysqlii("SELECT 
                c.id,
                a.description,
                b.name as product_name,
                c.status,
                c.start_date,
                c.end_date,
                c.destination_from,
                c.destination_to,
                c.note,
                c.creation_date,                
                requestor.full_name as requestor_name,
                requestor.photo
            FROM scm_service_product_details a
            INNER JOIN scm_product_category b on b.id = a.product_type_id
            INNER JOIN scm_service_requisition c on c.service_product_id = a.id
            INNER JOIN employee requestor on requestor.employee_id = c.requisition_by
            INNER JOIN employee uploader on uploader.employee_id = c.uploader_info"));
	}

	public function service_requisition_update($id)
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$data = array(
			'status' => $_POST['status']
		);
		$this->Dashboard_model->update('scm_service_requisition', $data, $id);

		$data = array(
			'service_requisition_id' => $id,
			'note' => $_POST['note'],
			'uploader' => $this->authenticated->employee_id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->Dashboard_model->insert('scm_service_requisition_approval_logs', $data);

		$driver = $this->Dashboard_model->mysqlij("SELECT scm_vehicle_driver_log.driver_id from scm_vehicle_driver_log INNER JOIN scm_service_requisition on scm_service_requisition.service_product_id = scm_vehicle_driver_log.service_product_details_id where scm_vehicle_driver_log.status = 1 AND scm_service_requisition.id = " . $id);
		echo json_encode(array('dirver_id' => $driver->driver_id));

		header('HTTP/1.0 201 Created');
	}

	// ========= ! END

	/**
	 * TA / DA
	 * 
	 */

	public function ta_da()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		// Not D:Head & Not Accounts
		if ($this->authenticated->d_head != 1 and $this->authenticated->department != '2270968637477766714') {
			header('HTTP/1.0 404 Not Found!');
			return json_encode(array('message' => 'Nothing found!'));
		}

		// Jimmy Boss
		if ($this->authenticated->id == '114') {
			$result = $this->Dashboard_model->mysqlii("SELECT employee_ta_da_bill_logs.*, employee.full_name, employee.photo, employee.d_head, employee.role, employee.designation_name, employee.email, employee.branch, employee.id as employee_table_pk, employee.department from employee_ta_da_bill_logs INNER JOIN employee on employee.id = employee_ta_da_bill_logs.e_db_id where department_head_aproval = 1 AND boss_aproval = 0 AND accounts_aproval = 0 AND self_aproval = 0");
			echo json_encode($result);
			return;
		}

		// Not accounts
		if ($this->authenticated->department != '2270968637477766714') {
			$result = $this->Dashboard_model->mysqlii("SELECT employee_ta_da_bill_logs.*, employee.full_name, employee.photo, employee.d_head, employee.role, employee.designation_name, employee.email, employee.branch, employee.id as employee_table_pk, employee.department from employee_ta_da_bill_logs INNER JOIN employee on employee.id = employee_ta_da_bill_logs.e_db_id where employee.department = '" . $this->authenticated->department . "' AND department_head_aproval = 0 AND boss_aproval = 0 AND accounts_aproval = 0 AND self_aproval = 0");
			echo json_encode($result);
			return;
		}

		// ( Accounts but not D:Head )
		if ($this->authenticated->d_head != 1) {
			$result = $this->Dashboard_model->mysqlii("SELECT employee_ta_da_bill_logs.*, employee.full_name, employee.photo, employee.d_head, employee.role, employee.designation_name, employee.email, employee.branch, employee.id as employee_table_pk, employee.department from employee_ta_da_bill_logs INNER JOIN employee on employee.id = employee_ta_da_bill_logs.e_db_id where department_head_aproval = 1 AND boss_aproval = 1 AND accounts_aproval = 0 AND self_aproval = 0");
			echo json_encode($result);
			return;
		}

		// Account & D:Head
		$result = $this->Dashboard_model->mysqlii("SELECT employee_ta_da_bill_logs.*, employee.full_name, employee.photo, employee.d_head, employee.role, employee.designation_name, employee.email, employee.branch, employee.id as employee_table_pk, employee.department from employee_ta_da_bill_logs INNER JOIN employee on employee.id = employee_ta_da_bill_logs.e_db_id where ( department_head_aproval = 0 AND boss_aproval = 0 AND accounts_aproval = 0 AND self_aproval = 0 AND employee.department = '" . $this->authenticated->department . "') OR ( department_head_aproval = 1 AND boss_aproval = 1 AND accounts_aproval = 0 AND self_aproval = 0 )");
		echo json_encode($result);
		return;
	}

	public function employee_self_ta_da_aproval($info_page = '')
	{
		$data = array();
		if (!empty($info_page)) {
			$main_data = explode('___', rahat_decode($info_page));
			$aproval_id = $main_data[0];
			$employee_id = $main_data[1];
			$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $aproval_id), 'id', 'DESC', 'row');
			$r_emp = $this->Dashboard_model->select('employee', array('id' => $employee_id), 'id', 'ASC', 'row');
			if ($info->self_aproval != 1) {
				if (!empty($info->food_amount) and $info->food_amount > 0) {
					$da_amount = $info->food_amount;
				} else {
					$da_amount = '0';
				}
				// if(isset($_POST['received'])){
				$update_data = array(
					'self_aproval' => '1'
				);
				$insert_data = array(
					'id' 				=> '',
					'e_db_id' 			=> $r_emp->id,
					'employee_id' 		=> $r_emp->employee_id,
					'ta_request_id' 	=> $info->id,
					'aproval_type'		=> 'Received',
					'note' 				=> 'Received By Self (' . $r_emp->full_name . ')',
					'status' 			=> '1',
					'uploader_info' 	=> $r_emp->full_name,
					'data' 				=> date('d/m/Y')
				);
				if (
					$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id) and
					$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data)
				) {
					header('HTTP/1.0 200 OK');
				} else {
					header('HTTP/1.0 500 Server Error');
				}
			} else {
				header('HTTP/1.0 400 Error');
			}
		} else {
			header('HTTP/1.0 400 Error');
		}
	}

	// ========== ! END

	/**
	 * Advance Money Request
	 * 
	 */

	public function money_request_boss_accept()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$transaction_id = date('dmY') . '-' . rand();
		$id_sent = $this->input->post('request_id');
		$emplouyee_id_get = $this->Dashboard_model->mysqlij("SELECT employee.id as emp_id from advance_money_request INNER JOIN employee using(employee_id) where advance_money_request.id =  '" . $id_sent . "' ");

		$insert_data = array(
			'id' => '',
			'transaction_id' => $transaction_id,
			'employee_id' => $emplouyee_id_get->emp_id,
			'amount' => $this->input->post('amount'),
			'given_date' => date('Y-m-d'),
			'note' => $this->input->post('note') . ' | ' . $this->input->post('boss_note'),
			'status' => '1',
			'uploader_info' => $this->uploader_info(),
			'data' => date('d/m/Y')
		);
		$update_acceptence = array(
			'status' => '4'
		);
		$this->Dashboard_model->update('advance_money_request', $update_acceptence, $this->input->post('request_id'));
		$this->Dashboard_model->insert('advance_petty_cash_logs', $insert_data);

		header('HTTP/1.0 201 Created');
	}

	public function money_request_boss_reject()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$update_acceptence = array(
			'status' => '3'
		);
		$this->Dashboard_model->update('advance_money_request', $update_acceptence, $this->input->post('request_id'));
	}

	public function meney_request_self_pending()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		echo json_encode($this->Dashboard_model->mysqlii("SELECT advance_petty_cash_logs.*, employee.full_name, employee.photo, employee.id as employee_table_pk, employee.designation_name, employee.department_name from advance_petty_cash_logs INNER JOIN employee on employee.id = advance_petty_cash_logs.employee_id where advance_petty_cash_logs.employee_id = '" . $this->authenticated->id . "' AND advance_petty_cash_logs.status = 1"));
		return;
	}

	public function money_request_self_accept()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		// Requested amount
		$advance_money_info = $this->Dashboard_model->select('advance_petty_cash_logs', array('employee_id' => $this->authenticated->id, 'transaction_id' => $_POST['transaction_id']), 'id', 'desc', 'row');
		if (is_null($advance_money_info)) {
			header('HTTP/1.0 406 Invalid request!');
			return;
		}

		// Previous balance
		$check_data = $this->Dashboard_model->select('advance_petty_cash', array('employee_id' => $this->authenticated->id), 'id', 'desc', 'row');
		if (!is_null($check_data) and $check_data->transaction_id == $advance_money_info->transaction_id) {
			header('HTTP/1.0 200 OK');
			echo json_encode(array('message', 'Request already accepted!'));
			return;
		}

		$update_acceptence = array(
			'status' => '2'
		);
		$update_resend = array(
			'status' => '2'
		);
		$get_request_data = $this->Dashboard_model->select('advance_money_request', array('employee_id' => $this->authenticated->employee_id), 'id', 'desc', 'row');

		if (!is_null($check_data)) {
			$new_amount = (float)$check_data->amount + (float)$advance_money_info->amount;
			$update_data = array(
				'transaction_id' => $advance_money_info->transaction_id,
				'amount' => $new_amount,
				'given_date' => $advance_money_info->given_date,
				'note' => $advance_money_info->note,
				'uploader_info' => $advance_money_info->uploader_info
			);
			$this->Dashboard_model->update('advance_petty_cash', $update_data, $check_data->id);
		} else {
			$insert_data = array(
				'id' => '',
				'transaction_id' => $advance_money_info->transaction_id,
				'employee_id' => $this->authenticated->id,
				'amount' => $advance_money_info->amount,
				'given_date' => $advance_money_info->given_date,
				'note' => $advance_money_info->note,
				'status' => '1',
				'uploader_info' => $advance_money_info->uploader_info,
				'data' => $advance_money_info->data
			);
			$this->Dashboard_model->insert('advance_petty_cash', $insert_data);
		}

		$is_employee_exist_in_employee_petty_cash_overview = $this->Dashboard_model->mysqlij("SELECT balance  from employee_petty_cash_overview where employee_id = '".$this->authenticated->employee_id."' order by id desc");
		$balance = doubleval($is_employee_exist_in_employee_petty_cash_overview->balance) + doubleval($advance_money_info->amount);

			$insert_data = array(
				'transection_id' => $advance_money_info->transaction_id,
				'employee_id' => $this->authenticated->employee_id,
				'withdraw' => $advance_money_info->amount,
				'balance' => $balance
			);
			$this->Dashboard_model->insert('employee_petty_cash_overview', $insert_data);

		$this->Dashboard_model->update('advance_money_request', $update_acceptence, $get_request_data->id);
		$this->Dashboard_model->update('advance_petty_cash_logs', $update_resend, $advance_money_info->id);

		header('HTTP/1.0 200 OK');
		echo json_encode(array('message', 'Request successfully accepted!'));
		return;
	}

	// Reset Password


	public function app_password_reset_otp($id) 
	{
		// $this->header = $this->input->request_headers();
		// if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
		// 	exit();
		// }

		//$number = $this->authenticated->personal_Phone;

		$get_employee_id = $this->Dashboard_model->mysqlij("select personal_Phone as phoneNumber from employee where employee_id = '$id' ");
		$mobile_number = $get_employee_id->phoneNumber;
	
		$number = $mobile_number;

		$random = rand(1000,9999);
    	$message_body = 'Your password reset OTP is '.$random;

        $phnP_n = strlen($number);		
        if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
		$apikey = '1bncPj2IVFre8sK6hY//i4lt9y2sDLlSs67TnGz5lMY='; 
		//$apikey = 'e61022bacbd3b3213716f2295b70de8e44992fb9'; 
		$device = '22|0';//'19|0';
		$ClientId = "aa34ccfa-5327-4aa8-aeb7-27d54ca2956c";
		$SenderId = '8809638666333';
		$api_params = '?ApiKey='.$apikey.'&ClientId='.$ClientId.'&SenderId='.$SenderId.'&Message='.urlencode($message_body).'&MobileNumbers=880'.$number.'&Is_Unicode='.true;  
		
		$smsGatewayUrl = "https://sms.novocom-bd.com/api/v2/SendSMS"; 
        $smsgatewaydata = $smsGatewayUrl.$api_params;
        $url = $smsgatewaydata;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);   

		$days = date("l"); 
		$time = date("h:i:s");
		$ampm = date("a");
		$data = date("d/m/Y"); 

        if($this->Dashboard_model->mysqliq("INSERT into sms_logs (`number`, `message`, `days`, `time`, `ampm`, `data`) values ('$number', '$message_body', '$days', '$time', '$ampm', '$data')")){
			print true;
		}else{
			print false;
		}
	}

	function app_password_reset(){
		$em_id = $_POST['employee_id'];
		$password = $_POST['password'];
		$otp = $_POST['otp'];

		$get_employee_phone_and_other_from_sms_log = $this->Dashboard_model->mysqlij("select id, personal_Phone as Personal_Phone_number from employee where employee_id = '".$em_id."' ");
		$mobile_number = substr($get_employee_phone_and_other_from_sms_log->Personal_Phone_number,1,10);
		
		$get_otp_message = $this->Dashboard_model->mysqlij("select message as otpMessage,time,ampm,data from sms_logs where number = '".$mobile_number."' order by id DESC");

		$time = $get_otp_message->time ;
		$ampm = $get_otp_message->ampm ;
		$date = $get_otp_message->data ;
		$otp_sent_time = DateTime::createFromFormat('d/m/Y h:i:s a', $date.' '.$time.' '.$ampm);
		$otp_sent_time->add(new DateInterval('PT5M'));

		$current = DateTime::createFromFormat('d/m/Y H:i:s', date('d/m/Y H:i:s'));
		$formated_otp_sent_date = $otp_sent_time->format('d/m/Y H:i:s');
		$get_otp_from_database = substr($get_otp_message->otpMessage,27,4);
		$make_password_hashed = md5($password);


		if($get_otp_from_database != $otp){
			print 'Wrong OTP!';
		}else if($current < $formated_otp_sent_date){
			print 'OTP Expired!';
		}else{
			if($this->Dashboard_model->mysqliq("UPDATE employee set password  = '".$make_password_hashed."' where id = ".$get_employee_phone_and_other_from_sms_log->id)){
				print "Password reset successful!";
			}else{
				print 'Please try again!';
			}
		}	
	}

	// ========= ! END
	

	public function get_qr_code($branch_id)
	{
		$this->db->from('employee');
		$this->db->select('department, department_name, branch');
		$this->db->where('branch', $branch_id);
		$this->db->where('status', '1');
		// $this->db->where('branch', $branch_id);
		// $this->db->where('branch', $branch_id);
		$this->db->group_by("department");
		$department_group = $this->db->get();
		$departments = $department_group->result();

		$data = array();
		foreach($departments as $department){
			$this->db->from('employee');
			$this->db->select("photo, full_name, CONCAT('assets/uploads/qrcode/employee_q_code_id_', id, '.png') as qr_code, designation_name");
			$this->db->where('department', $department->department);
			$this->db->where('branch', $branch_id);
			$this->db->where('status', '1');
			// $this->db->where('branch', $branch_id);
			// $this->db->where('branch', $branch_id);
			$result = $this->db->get();
			$employees = $result->result();
			array_push($data, ['department_name' => $department->department_name, 'employees' => $employees]);
		}
		echo json_encode($data);
	}

	public function qr_branches()
	{
		$this->db->from('branches');
		$this->db->select('branch_name, branch_id');
		$branches = $this->db->get();
		echo json_encode($branches->result());
	}

	public function salary_earned()
	{
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}

		$get_total_attendance = $this->Dashboard_model->mysqlij("SELECT count(distinct(days)) as total_days from employee_attendence where month = '".(int)date('m')."' AND years = '".(int)date('y')."' AND employee_id = '".$this->authenticated->employee_id."' AND days not in (SELECT employee_everyday_leave_logs.days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.employee_id = '".$this->authenticated->employee_id."' AND employee_leave_logs.aproval = 1 AND employee_everyday_leave_logs.status = 1 AND employee_everyday_leave_logs.month = '".(int)date('m')."' AND employee_everyday_leave_logs.year = '".(int)date('Y')."') ");
		$get_total_leave = $this->Dashboard_model->mysqlij("SELECT count(distinct(employee_everyday_leave_logs.days)) as total_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.employee_id = '".$this->authenticated->employee_id."' AND employee_leave_logs.aproval = 1 AND employee_everyday_leave_logs.status = 1 AND employee_everyday_leave_logs.month = '".(int)date('m')."'");
		$total_increament = $this->Dashboard_model->mysqlij("SELECT sum(amount) as total from employee_increament_logs where STR_TO_DATE(start_date, '%d/%m/%Y') <= '" . date('Y-m-01') . "' AND status = 1 AND employee_id = '" . $this->authenticated->employee_id . "'");
		$earned_salary = (int)$get_total_attendance->total_days * ( $this->authenticated->basic_salary + $total_increament->total );
		echo json_encode(array('earned_salary' => $earned_salary, 'total_attendance' => $get_total_attendance->total_days, 'total_leave' => $get_total_leave->total_days));
	}



	/**
	 * ============================================ For Website ==================================================================
	 */

	public function server_status()
	{
		echo '1';
	}

	public function pre_book()
	{
		$contacts = json_decode(file_get_contents('php://input'), true);
		if ($contacts['authorization'] == 'super_home_pre_book') {
			$candidate = $contacts['data'];

			$this->db->where('phone', $candidate['phone']);
			$this->db->or_where('email', $candidate['email']);
			$this->db->or_where('nid', $candidate['nid']);
			$result = $this->db->get('pre_booking_directory');
			if (count($result->result()) != 0) {
				echo '0';
				return;
			}

			$data = array();
			$data['generate_id'] = $candidate['generate_id'];
			$data['full_name'] = $candidate['full_name'];
			$data['father_name'] = $candidate['father_name'];
			$data['date_of_birth'] = $candidate['date_of_birth'];
			$data['marital_status'] = $candidate['marital_status'];
			$data['blood_group'] = $candidate['blood_group'];
			$data['religion'] = $candidate['religion'];
			$data['occupation'] = $candidate['occupation'];
			$data['qualification'] = $candidate['qualification'];
			$data['phone'] = $candidate['phone'];
			$data['email'] = $candidate['email'];
			$data['nid'] = $candidate['nid'];
			$data['passport_no'] = $candidate['passport_no'];
			$data['h_t_f_u'] = $candidate['h_t_f_u'];
			$data['branch_id'] = $candidate['branch_id'];
			$data['permament_address'] = $candidate['permament_address'];
			$data['present_addrress'] = $candidate['present_addrress'];
			$data['workplace_address'] = '';
			$data['note'] = '';
			$data['emergency_contact_name'] = $candidate['emergency_contact_name'];
			$data['emergency_contact_number'] = $candidate['emergency_contact_number'];
			$data['emergency_contact_address'] = $candidate['emergency_contact_address'];
			$data['old_home_owner_name'] = $candidate['old_home_owner_name'];
			$data['emergency_relation'] = $candidate['emergency_relation'];
			$data['status'] = 1;
			$data['uploader_info'] = '';
			$data['data'] = date('d/m/Y');
			$data['selected_pkg'] = $candidate['selected_pkg'];
			$data['check_in_date'] = $candidate['check_in_date'];
			$data['parking'] = $candidate['parking'];
			$data['payment'] = $candidate['payment'];
			$data['locker'] = $candidate['locker'];
			$data['member_type'] = '';
			$data['otp'] = $candidate['otp'];
			$url = 'https://www.superhomebd.com/public/photo/' . $candidate['photo_avater'];
			$file_name = 'assets/uploads/member/member_image/' . $candidate['photo_avater'];
			$img = 'E:/xampp/htdocs/super_home/' . $file_name;
			$data['photo_avater'] = $file_name;
			file_put_contents($img, file_get_contents($url));
			$this->Dashboard_model->insert('pre_booking_directory', $data);
			echo '1';
			return;
		}
		header('HTTP/1.0 404 Page not found');
	}

	public function sms_log()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if ($data['authorization'] == 'super_home_pre_book') {
			$candidate = $data['data'];
			$data = array();
			$data['number'] = $candidate['number'];
			$data['message'] = $candidate['message'];
			$data['days'] = $candidate['days'];
			$data['time'] = $candidate['time'];
			$data['ampm'] = $candidate['ampm'];
			$data['data'] = $candidate['data'];
			$this->Dashboard_model->insert('sms_logs', $data);
			header('HTTP/1.0 201 Created');
			return;
		}
		header('HTTP/1.0 404 Page not found');
	}

	public function get_otp($number)
	{
		$this->db->where('number', $number);
		$this->db->like('message', 'OTP for booking');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get('sms_logs');
		$row = $result->result();
		if (empty($row)) {
			echo '0';
			return;
		}
		echo substr($row[0]->message, 40, 4);
		return;
	}

	public function branches()
	{
		$result = $this->db->get('branches');
		echo json_encode($result->result());
	}

	public function branches_where($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('branches');
		echo json_encode($result->result());
	}

	public function packages_where($id)
	{
		$this->db->select('DISTINCT(name), image');
		$this->db->where('status', '1');
		$this->db->where('id', $id);
		$result = $this->db->get('packages_info');
		echo json_encode($result->result());
	}

	public function packages()
	{
		$this->db->select('DISTINCT(name), image');
		$this->db->where('status', '1');
		$result = $this->db->get('packages_info');
		echo json_encode($result->result());
	}

	public function pre_book_validation()
	{
		$this->db->where('phone', $_POST['validate']);
		$this->db->or_where('email', $_POST['validate']);
		$this->db->or_where('nid', $_POST['validate']);
		$result = $this->db->get('pre_booking_directory');
		if (count($result->result()) == 0) {
			echo '0';
		} else {
			echo '1';
		}
	}

	public function facilities_icons()
	{
		$this->db->select('id, icon_image');
		$result = $this->db->get('facilities_icons');
		echo json_encode(array('data' => $result->result()));
	}

	public function device_id()
	{
		$result = $this->db->get('otp_device');
		$device = $result->result();
		echo $device[0]->device_id;
	}	

	public function branch_images($id)
	{
		$this->db->select('image_link');
		$this->db->where('branch_id', $id); 
		$result = $this->db->get('branch_images');
		echo json_encode($result->result());
	}

	

	public function store_candidate()
	{   
		$header = $this->input->request_headers();
		$token = $header['authorization'];

		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$circular_id = $_POST['circular_id'];
	    $check = $this->Dashboard_model->mysqlii("SELECT * FROM apply_jobs WHERE phone='$phone' AND circular_id='$circular_id'");
	
		if($check)
		{   
			header('HTTP/1.0 302 Found');
			echo json_encode('You already applied for this position!');
		}
		else
		{    

			$url = $_POST['file_cv'];
			$ext = explode('.', $url);
			$cv_name = 'images/' . $_POST['name'] . time() . time() .'.'. $ext[2];
			$file = 'E:/xampp/htdocs/super_home/' . $cv_name;
			file_put_contents($file, file_get_contents($url));

			$video_cv = NULL;
			if(!empty($_POST['video_cv'])){
				$url = $_POST['video_cv'];
				$ext = explode('.', $url);
				$video_cv = 'images/' . $_POST['name'] . '_video_' . time() . time() .'.'. $ext[2];
				$file = 'E:/xampp/htdocs/super_home/' . $video_cv;
				file_put_contents($file, file_get_contents($url));
			}

			$full_data = array();
			$full_data['circular_id'] = $_POST['circular_id'];
			$full_data['name'] = $_POST['name'];
			$full_data['phone'] = $_POST['phone'];
			$full_data['email'] = $_POST['email'];
			$full_data['apply_date'] = date('Y-m-d');
			$full_data['last_education_level'] = $_POST['last_education_level'];
			$full_data['experience'] = $_POST['experience'];
			$full_data['portfolio_link'] = $_POST['portfolio_link'];
			$full_data['document_cv'] = $cv_name;
			$full_data['video_cv'] = $video_cv;

			$this->Dashboard_model->insert('apply_jobs', $full_data);				
			
		}
		
	}

	public function apply_data()
	{
		$apply_data = $this->Dashboard_model->mysqlii("SELECT * FROM apply_jobs ORDER BY id DESC");
		echo json_encode($apply_data);
	}

	public function circular_data()
	{   
		    
		$data = $this->Dashboard_model->mysqlii("SELECT ciculars.id, ciculars.job_title, ciculars.job_nature, ciculars.salary, ciculars.job_deadline , department.department_name, designation.designation_name
		FROM ((ciculars
		INNER JOIN department ON ciculars.department_id = department.id)
		INNER JOIN designation ON ciculars.designation_id = designation.id) WHERE (curdate() < ciculars.job_deadline) ORDER BY ciculars.id DESC");

		echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
	}



	/**
	 * ============================================ For Raspberry =================================================================
	 */


	public function data_info_pi($type = '')
	{
		//1. select all: root/select/field_name & null/table_name/where_condition & null/order_by_field_name & null/all & one & null
		//2. where is ""field_name-----field_value_____field_name_field_value   "";
		//--------------
		//2 inseert exmple : http://10.100.93.149/super_hostel/json/data-information/insert/null/activity_log/id-----_____branch_id-----10_____branch_name-----test%20branch%20name_____details-----325_____user_info-----9879_____data-----1234567890/null/null/all/null
		//--------------
		//3 update exmple: http://10.100.93.149/super_hostel/json/data-information/update/null/table_name/field_name-----values_____field_name-----values/where_field_name/where_values/null/null
		//--------------
		//4. delete exmple: http://10.100.93.149/super_hostel/json/data-information/delete/null/table_name/null/where_field_name/where_field_value/null/null
		$header = $this->input->request_headers();
		if (isset($header['authorization'])) {
			$token = $header['authorization'];
		} else {
			$token = 'unauthorized';
		}

		if ($token != 'api_pi_12345678!@#$%^&*') {
			header('HTTP/1.0 403 Forbidden');
			echo 'Access denied!';
		} else {
			header('Content-Type: application/json');
			header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
			$data = array();

			if ($type == 'select') {
				// echo $_POST['card_number'];
				// return;
				if (isset($_POST['card_number'])) {

					$device_id = '';
					if (isset($_POST['ip_address'])) {
						$device_id = $_POST['ip_address'];
					}

					$log_information = array(
						'card_number' => $_POST['card_number'],
						'time' => date('Y-m-d H:i:s'),
						'device_id' => $device_id
					);
					$this->Dashboard_model->insert('member_card_log', $log_information);

					/**
					 * Member information
					 * 
					 * @return JSON
					 * 
					 */
					$get_card_information = $this->Dashboard_model->select('member_directory', array('card_number' => $_POST['card_number']), 'id', 'ASC', 'row');
					$auto_cancel_report = $this->Dashboard_model->select('cencel_request', array('note' => 'Request For Cancel for rental payment issue (auto cancel from software)', 'booking_id' => $get_card_information->booking_id), 'id', 'ASC', 'row');

					if (!is_null($get_card_information)) {
						header('HTTP/1.0 200 OK');
						if ($get_card_information->status == '1') {
							$data['name'] = $get_card_information->full_name;
							$data['image'] = 'http://erp.superhostelbd.com/super_home/' . $get_card_information->photo_avater;
							if (!is_null($auto_cancel_report)) {
								$data['message'] = "Auto canceled!";
								$data['note'] = 'Please pay your rent!';
							} else {
								$data['message'] = 'Active Member!';
								$data['note'] = 'Welcome to Super Home!';
							}
							$data['branch_name'] = $get_card_information->branch_name;
							$data['branch_id'] = $get_card_information->branch_id;
							$data['room'] = $get_card_information->unit_name . $get_card_information->room_name;
							$data['status'] = true;
						} else {
							$data['name'] = $get_card_information->full_name;
							$data['image'] = 'http://erp.superhostelbd.com/super_home/' . $get_card_information->photo_avater;
							$data['message'] = 'Inctive Member!';
							$data['branch_name'] = $get_card_information->branch_name;
							$data['branch_id'] = $get_card_information->branch_id;
							$data['room'] = $get_card_information->unit_name . $get_card_information->room_name;
							$data['status'] = false;
							$data['note'] = 'Please book again!';
						}
						echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
						return;
					}

					/**
					 * Employee information
					 * 
					 * @return JSON
					 * 
					 */
					$get_card_information = $this->Dashboard_model->select('employee', array('card_number' => $_POST['card_number'], 'status' => '1'), 'id', 'ASC', 'row');

					if (!is_null($get_card_information)) {
						header('HTTP/1.0 200 OK');
						if ($get_card_information->status == '1') {
							$data['name'] = $get_card_information->full_name;
							$data['image'] = 'http://erp.superhostelbd.com/super_home/' . $get_card_information->photo;
							$data['message'] = 'Active Member!';
							$data['note'] = 'Welcome to Neways International!';
							$data['branch_name'] = '';
							$data['branch_id'] = '';
							$data['room'] = '';
							$data['status'] = true;
						} else {
							$data['name'] = $get_card_information->full_name;
							$data['image'] = 'http://erp.superhostelbd.com/super_home/' . $get_card_information->photo_avater;
							$data['message'] = 'Inctive Member!';
							$data['branch_name'] = '';
							$data['branch_id'] = '';
							$data['room'] = '';
							$data['status'] = false;
							$data['note'] = 'Welcome!';
						}
						echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
						return;
					}


					header('HTTP/1.0 404 No Data Found!');
					$data['message'] = 'No matching records found!';
					$data['note'] = 'No matching records found!';
					$data['status'] = false;
					echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
					return;
				} else {
					header('HTTP/1.0 400 BAD REQUEST');
					echo 'Bad request! Provide proper information!';
					return;
				}
			}
		}
	}

	public function get_device_information()
	{
		$header = $this->input->request_headers();
		if (isset($header['authorization'])) {
			$token = $header['authorization'];
		} else {
			$token = 'unauthorized';
		}
		if ($token != 'api_pi_12345678!@#$%^&*') {
			header('HTTP/1.0 403 Forbidden');
			echo 'Access denied!';
		} else {
			header('Content-Type: application/json');
			header('Access-Control-Allow-Methods: POST');
			$data = array();

			if (isset($_POST['device_id'])) {
				$get_device_information = $this->Dashboard_model->select('lock_device_informations', array('device_id' => $_POST['device_id']), 'id', 'ASC', 'row');

				if (!is_null($get_device_information)) {
					header('HTTP/1.0 200 OK!');
					$data['ssid'] = $get_device_information->ssid;
					$data['password'] = $get_device_information->password;
					$data['api_link'] = $get_device_information->api_link;
					echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
				} else {
					header('HTTP/1.0 404 No information found!');
					$data['message'] = 'No matching records found!';
					echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
				}
				return;
			} else {
				header('HTTP/1.0 400 BAD REQUEST');
				echo 'Bad request! Provide proper information!';
				return;
			}
		}
	}

	public function card_number_per_branch()
	{
		$header = $this->input->request_headers();
    if (isset($header['authorization'])) {
      $token = $header['authorization'];
    } else {
      $token = 'unauthorized';
    }
    if ($token != 'api_pi_12345678!@#$%^&*') {
      header('HTTP/1.0 403 Forbidden');
      echo 'Access denied!';
    } else {
      // $this->db->select('card_number, photo_avater, full_name');
      // $this->db->where('branch_id', $_POST['branch_id']);
      // $this->db->where('status', '1');
      // $query = $this->db->get('member_directory');
      // echo json_encode($query->result());  
      $checking = 'BAR_090920_92154076852295696_1599655159';
       $branch_id = $_POST['branch_id'];
       if($checking == $branch_id)
       {
       $employees = $this->Dashboard_model->mysqlii("SELECT card_number, photo as photo_avater, full_name FROM employee WHERE branch='BAR_011220_210463187872898170_1606780607' AND status=1");
       }
       else
       {
      $employees = $this->Dashboard_model->mysqlii("SELECT card_number, photo as photo_avater, full_name FROM employee WHERE branch='$branch_id' AND status=1");
       }
      
      $members = $this->Dashboard_model->mysqlii("SELECT card_number, photo_avater, full_name FROM member_directory WHERE branch_id='$branch_id' AND status=1");
      $data = ['employees'=>$employees, 'members'=>$members];
      $push = array_merge($employees,$members);
      echo json_encode($push);
    }
	}

	public function employee_phone_search(){
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$today = new DateTime(date('Y-m-d'));
		$jesn_data = $this->Dashboard_model->mysqlii("SELECT employee.employee_id,employee.full_name,employee.department_name,employee.designation_name,employee.personal_Phone,employee.Company_phone as company_phone,employee.photo, MAX(employee_everyday_leave_logs.id) as leave_log, employee_leave_logs.hold_unhold from employee LEFT JOIN employee_leave_logs on employee_leave_logs.employee_id = employee.employee_id LEFT JOIN employee_everyday_leave_logs on ( employee_everyday_leave_logs.unique_id = employee_leave_logs.unique_id AND employee_everyday_leave_logs.date_full = '".$today->format('d/m/Y')."' AND employee_everyday_leave_logs.status = 1 ) where employee.status = 1 GROUP BY employee.employee_id");
		echo json_encode($jesn_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	}


	public function exit_employee_search(){
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			exit();
		}
		$jesn_data = $this->Dashboard_model->mysqlii("SELECT employee.employee_id,employee.full_name,employee.department_name,employee.designation_name,employee.personal_Phone,'' as company_phone,employee.photo from employee where employee.status = 0 GROUP BY employee.employee_id");
		header('Content-Type: application/json');
		echo json_encode($jesn_data);
	}

	public function employee_coffee_machine()
	{
		if(empty($_POST['card_number'])){
			echo json_encode(['status' => 0]);
			return;
		}
		$employee_data = $this->Dashboard_model->mysqlij("SELECT employee.full_name as name, employee.employee_id, employee.status, department.department_name from employee INNER JOIN department on employee.department = department.department_id where employee.status = 1 AND employee.card_number = '".$_POST['card_number']."'");
		if(!empty($employee_data)){
			echo json_encode($employee_data);
		}else{
			echo json_encode(['status' => 0]);
		}
	}

	public function accept_salary()
	{
		$month = $_POST['month'];
		$year = $_POST['year'];
		$employee_id = $_POST['employee_id'];
		$otp = $_POST['otp'];
		if(empty($month) || empty($year) || empty($employee_id) || empty($otp))
		{    
	        header('HTTP/1.0 422 Unprocessable Entity');
			echo json_encode('Please Fill all required fields'); 
		}
		else
		{   
			
			$data = $this->Dashboard_model->mysqlij("SELECT employee.full_name, employee.personal_Phone, employee.employee_id, employee_monthly_sallary.total_sallary,employee_monthly_sallary.withdraw_status FROM employee_monthly_sallary INNER JOIN employee ON employee_monthly_sallary.employee_id=employee.employee_id  WHERE employee_monthly_sallary.month='$month' AND employee_monthly_sallary.year='$year' AND employee_monthly_sallary.employee_id='$employee_id'");
			// $data = $this->Dashboard_model->mysqlij("SELECT employee.full_name, employee.personal_Phone, employee.employee_id, employee_monthly_sallary.total_sallary
			// FROM ((employee_monthly_sallary
			// INNER JOIN employee ON employee_monthly_sallary.employee_id = employee.employee_id)
			// INNER JOIN Shippers ON Orders.ShipperID = Shippers.ShipperID)");
			if($data)
			{   
				$get_otp = $this->Dashboard_model->mysqlij("SELECT * FROM sms_logs WHERE `number`='$data->personal_Phone' ORDER BY id DESC LIMIT 1");
				if($get_otp->otp == $otp)
				{
					if($data->withdraw_status == 1)
					{    
						echo json_encode(['message'=>"Already salary {$month}, {$year} has been accepted for {$data->full_name}", 'status'=>2]);
					}
					else
					{   
							$this->Dashboard_model->mysqliq("UPDATE employee_monthly_sallary SET withdraw_status='1'  WHERE employee_monthly_sallary.month='$month' AND employee_monthly_sallary.year='$year' AND employee_monthly_sallary.employee_id='$employee_id'");
						echo json_encode(['message'=>"Successfully accepted {$data->total_sallary} of {$data->full_name} for the month {$month}, {$year}.", 'status'=>1]);
						
					}
				}
				else
				{
					//header('HTTP/1.0 404 not found');
					echo json_encode(['message'=>'Otp is not matched', 'status'=>2]);
				}
				
				//echo json_encode($data);
			}
			else
			{   
				header('HTTP/1.0 404 not found');
				echo json_encode(['message'=>"No entry found for {$employee_id}, {$month} {$year}", 'status'=>3]);
			}
		}
	}

	public function get_salary_data()
	{
		$month = $_GET['month'];
		$year = $_GET['year'];
		if(empty($month) || empty($year))
		{
			header('HTTP/1.0 422 Unprocessable Entity');
			echo json_encode('Please Fill all required fields'); 
		}
		else
		{
			$data = $this->Dashboard_model->mysqlii("SELECT employee.employee_id, employee.full_name, employee.photo, employee_monthly_sallary.withdraw_status, employee_monthly_sallary.total_sallary, department.department_name
			FROM ((employee
			INNER JOIN employee_monthly_sallary ON employee.employee_id = employee_monthly_sallary.employee_id)
			INNER JOIN department ON employee.department = department.department_id) WHERE employee_monthly_sallary.month='$month' AND year='$year'");
			if(count($data) > 0)
			{
				echo json_encode($data);
			}
			else
			{   
				header('HTTP/1.0 404 not found');
				echo json_encode('No data found');
			}
		}
	}

	public function salary_confirm_emp()
	{
		$employee_id = $_POST['employee_id'];
		$month = $_POST['month'];
		$nmonth = date("m", strtotime($month));
		$year = $_POST['year'];
		$otp = $_POST['otp'];
		$get_employee = $this->Dashboard_model->mysqlij("SELECT * FROM employee WHERE employee_id='$employee_id'");
		$check_otp = $this->Dashboard_model->mysqlij("SELECT * FROM sms_logs WHERE `number`='$get_employee->personal_Phone' ORDER BY id DESC LIMIT 1");
		if($check_otp->otp == $otp)
		{
            $this->Dashboard_model->mysqliq("UPDATE employee_monthly_sallary SET withdraw_status='1' WHERE month='$nmonth' AND year='$year' AND employee_id='$employee_id'");
			alert('success','Successfully your salary has been confirmed by you');
			redirect(base_url('api/salary_confirm_emp_view'));
		}
		else
		{
			alert('error','Sorry otp is not matched');
	        redirect(base_url('api/salary_confirm_emp_view'));
		}
		
	   
	}

	public function salary_confirm_emp_view()
	{
		$data['title_info'] = 'Salary Confirm Form';
		
		$data['article'] = $this->load->view('template/salary_confirm_form',$data,TRUE); 

		$this->load->view('dashboard',$data);
	}

	public function get_emp_image()
	{   
		$employee_id = $_GET['employee_id'];
		$employee = $this->Dashboard_model->mysqlij("SELECT * FROM employee WHERE employee_id='$employee_id'");
		if($employee)
		{
			$data =  base_url('/'.$employee->photo);
			echo $data;
		}
		else
		{
			echo "wrong";
		}
	}

	public function resend_otp_salary()
	{
		$employee_id = $_GET['employee_id'];
		$month = $_GET['month'];
		$year = $_GET['year'];
		if(empty($employee_id) || empty($month) || empty($year))
		{
			echo json_encode("Please fill all required fields");
		}
		else
		{
			$month_name = date('F', mktime(0, 0, 0, $month, 10));
			$date = date('d/m/Y');
			$time = date('h:i:s');
			$days = date('l', strtotime($date));
			$ampm = date('a');
			$employee =  $this->Dashboard_model->mysqlij("SELECT employee.full_name, employee.employee_id, employee.personal_Phone, employee_monthly_sallary.total_sallary FROM employee INNER JOIN employee_monthly_sallary ON employee.employee_id=employee_monthly_sallary.employee_id WHERE employee.employee_id='$employee_id' AND month='$month' AND year='$year'");
		    if($employee)
			{
				$number = $employee->personal_Phone;
						
			$random = rand(100000,999999);
				$message_body = "Dear, {$employee->full_name} your salary confirmation otp is {$random} and your {$month_name} {$year}'s salary is: {$employee->total_sallary} BDT. NICL.";

				$phnP_n = strlen($number);		
				if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
				$apikey = '1bncPj2IVFre8sK6hY//i4lt9y2sDLlSs67TnGz5lMY='; 
				$device = '22|0';//'19|0';
				$ClientId = "aa34ccfa-5327-4aa8-aeb7-27d54ca2956c";
				$SenderId = '8809638666333';
				$api_params = '?ApiKey='.$apikey.'&ClientId='.$ClientId.'&SenderId='.$SenderId.'&Message='.urlencode($message_body).'&MobileNumbers=880'.$number.'&Is_Unicode='.true;  
				
				$smsGatewayUrl = "https://sms.novocom-bd.com/api/v2/SendSMS"; 
				
				$smsgatewaydata = $smsGatewayUrl.$api_params;
				$url = $smsgatewaydata;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_POST, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec($ch);
				curl_close($ch); 
				//redirect(current_url());   
				$data = array(); 
				$data['number'] = $employee->personal_Phone;
				$data['message'] = $message_body;
				$data['otp'] = $random;
				$data['days'] = $days;
				$data['time'] = $time;
				$data['data'] = date('d/m/Y');
				$data['ampm'] = $ampm;
				$this->Dashboard_model->insert('sms_logs', $data);
				echo json_encode(['message'=>"Successfully salary confirmation's otp has been sent to {$employee->personal_Phone}"]);
			}
			else
			{   header('HTTP/1.0 404 not found');
				echo json_encode(['message'=>'No records found', 'status'=>3]);
			}
		}
		
	}

	public function resend_otp_again()
	{
		$employee_id = $_GET['employee_id'];
		$month = date('m');
		$year = date('Y');
		$month_name = date('F', mktime(0, 0, 0, $month, 10));
			$date = date('d/m/Y');
			$time = date('h:i:s');
			$days = date('l', strtotime($date));
			$ampm = date('a');
			$employee =  $this->Dashboard_model->mysqlij("SELECT * FROM employee WHERE employee_id='$employee_id'");
		    if($employee)
			{
				$number = $employee->personal_Phone;
						
			   $random = rand(100000,999999);
				$message_body = "Dear, {$employee->full_name} your salary confirmation otp is {$random} and your {$month_name} {$year}'s salary is: {$employee->total_sallary} BDT. NICL.";

				$phnP_n = strlen($number);		
				if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
				$apikey = 'e61022bacbd3b3213716f2295b70de8e44992fb9';  
				//$apikey = 'baee927bf84af59e7e4dacdf4a9ece0112b7b66c';  //SariIT
				//$device = '18|0';
				$device = '19|1'; 
				$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device;  
				//$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device.'&type=sms&prioritize=1';  //SariIT
				$smsGatewayUrl = "https://sms.superhostelbd.com/services/send.php";  //Bapbeta
				// $smsGatewayUrl = "https://sms.bapbeta.com/services/send.php";  
				//$smsGatewayUrl = "https://sms.sariit.com/services/send.php";  //SariIT
				$smsgatewaydata = $smsGatewayUrl.$api_params;
				$url = $smsgatewaydata;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_POST, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec($ch);
				curl_close($ch); 
				//redirect(current_url());   
				$data = array(); 
				$data['number'] = $employee->personal_Phone;
				$data['message'] = $message_body;
				$data['otp'] = $random;
				$data['days'] = $days;
				$data['time'] = $time;
				$data['data'] = date('d/m/Y');
				$data['ampm'] = $ampm;
				$this->Dashboard_model->insert('sms_logs', $data);
				echo "success";
			}
	}

	


	public function complain_category() 
	{
		$data = $this->Dashboard_model->mysqlii("SELECT * FROM complain_category ORDER BY id DESC");
		echo json_encode($data, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

	}
	

	public function store_complain_db()
	{   
		$get_data = $this->input->post();
		$target_dir = './assets/uploads/complain/';
		foreach($get_data as $data){
			$insert = $this->db->insert('complain', $data);
			
			$links_array = explode(",", $data['complain_images']);
			foreach($links_array as $link){
				$img_url = "https://superhomebd.com/public/complain/".$link;
				if(file_exists($img_url)){
					file_put_contents($target_dir.$link, file_get_contents($img_url));
					
				}
			}
			
		}
		echo json_encode($get_data);
	}
	
	public function member_number()
	{   
		$card_or_phone = $this->input->post("card_or_phone");
		$data = $this->db->query("select id from member_directory where phone_number='$card_or_phone' or card_number='$card_or_phone'");
		$member_number = $data->row();
		echo json_encode($member_number->id);
	}
	
	public function inquery_submit()
	{   
		$full_name = $this->input->post("full_name");
		$email = $this->input->post("email");
		$phone = $this->input->post("phone");
		$data = array(
			'full_name'=>$full_name,
			'email'=>$email,
			'phone'=>$phone,
		);
		
		$this->db->insert('investment_query',$data);
		$insert_id = $this->db->insert_id();
		echo json_encode($insert_id);
	}
	
	public function get_department_ids()
	{   
		$player_id = array();
		//$category_ids = [1,2,3];
		$category_ids = $this->input->post("category_ids");
		$ids_comma = implode(',', $category_ids);
		$sql = $this->db->query("SELECT employee.player_id 
		FROM complain_category 
		inner join employee on employee.department = complain_category.department_id
		WHERE complain_category.id IN ($ids_comma) and employee.d_head='1'");
		$result = $sql->result();
		foreach($result as $res){
			$player_id[] = $res->player_id;
		}
		echo json_encode($player_id);
	}
	
	public function onesignal_api()
	{
		$body = $this->input->post("body");
		$title = $this->input->post("title");
		$player_id = $this->input->post("player_id");
		
		$key = 'NGY1ZGQ5YTItNjRjOC00MTcyLTg4MzUtZWE4MTk1ZDhjMDdk';
		$content      = array(

			"en" => $body,

		);

		$headings = array(

			'en' => $title

		);

		$ios_img = array(
			"id1" => '',
		);
		$fields = array(
			'app_id' => '47e73b79-77ca-4983-a4ce-81af34df9018',
			'headings' => $headings,
			'include_player_ids' => $player_id,
			'data' => array( 'foo' => 'bar' ),
			'big_picture' => '',
			'large_icon' => '',
			'content_available' => true,
			'contents' => $content,
			'ios_attachments' => $ios_img,
		);

		$fields = json_encode($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 
			'Authorization: Basic ' . $key));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

		$response = curl_exec($ch);
		curl_close($ch);
		return json_encode($response);
	}
	
	public function document_expiry_notification(){
		// department id HR_admin. 1383007286312996344
		// super admin role. 2805597208697462328
		
		$sql1 = $this->db->query("select * from document_managment where (DATEDIFF(CURDATE(), expiration_date)) < 10");
		$doc_number = $sql1->num_rows();
		
		if($doc_number > 0){
			$sql = $this->db->query("select player_id from employee where department='1383007286312996344' or role='2805597208697462328' ");
			$results = $sql->result();
			
			$player_id = array();
			foreach($results as $result){
				$player_id[] = $result->player_id;
			}
			
			$body = "Your $doc_number documents are about to expire. Please login to software to see details and renew your documents.";
			$title = "$doc_number Documents About to expire";
			
			$key = 'NGY1ZGQ5YTItNjRjOC00MTcyLTg4MzUtZWE4MTk1ZDhjMDdk';
			$content      = array(

				"en" => $body,

			);

			$headings = array(

				'en' => $title

			);

			$ios_img = array(
				"id1" => '',
			);
			$fields = array(
				'app_id' => '47e73b79-77ca-4983-a4ce-81af34df9018',
				'headings' => $headings,
				'include_player_ids' => $player_id,
				'data' => array( 'foo' => 'bar' ),
				'big_picture' => '',
				'large_icon' => '',
				'content_available' => true,
				'contents' => $content,
				'ios_attachments' => $ios_img,
			);

			$fields = json_encode($fields);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 
				'Authorization: Basic ' . $key));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

			$response = curl_exec($ch);
			curl_close($ch);
			return json_encode($response); 
			//echo json_encode($doc_number); 
			 
		}
		
		
	}
	
	
	
	public function expense_type(){
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			echo json_encode(header('HTTP/1.0 401 Not Authorized!'));
			exit();
		}else{
			$sql = $this->db->query("SELECT IF( sub_exp.id is not null,  CONCAT( exp.id, '|', sub_exp.id), exp.id)  AS expense_tpye,  IF( sub_exp.head_name is not null,  CONCAT( exp.head_name, ' - ', sub_exp.head_name ), exp.head_name)  AS head_name 
			from expense_type as exp
			left join expense_sub_type as sub_exp on sub_exp.expense_type_id=exp.id
			order by expense_tpye asc;"); 
			$result  = $sql->result();
			if (!empty($result)) {
				header('HTTP/1.0 200 OK');
				echo json_encode($result);
			}else{
				header('HTTP/1.0 406 Not Acceptable');
				return null;
			}
		}
	}
	
	
	
	public function advance_transaction_buy_something(){
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			header('HTTP/1.0 401 Not Authorized!');
			exit();
		}else{ 
			$item_data = array();
			$employee_id = $this->authenticated->id;
			//if(isset($_POST['save'])){
				$check_pending_status = $this->Dashboard_model->select('advance_petty_cash_return_logs',array('aproval' => '0', 'employee_id' => $employee_id),'id','DESC','row');
				
				if(!empty($check_pending_status->id)){
					$msg = array('danger' => 'Sorry! You can not Purses! You Have return request still Pending!');
					echo json_encode($msg); exit();
				}else{
					$data = date('d/m/Y');
					$transactionss_id = $this->input->post('transaction_id');
					$emp_sql = $this->db->query("select * from employee where id='$employee_id'");
					$emp_info = $emp_sql->row();
					$total_amount = $this->input->post('total_subtotal');
					$balance_amount = $this->input->post('total_amount');
					$extra_note = $this->input->post('extra_note');
					// need data from emplouyee_id as php session.role_name
					$branch_info = $this->Dashboard_model->mysqlij("SELECT * from branches where branch_id = '".$emp_info->branch."'");
					$uploader_info = $emp_info->role_name.'___'.$emp_info->email.'___'.$branch_info->branch_name;
					$empl_info = $this->Dashboard_model->select('employee',array('id' => $employee_id),'id','DESC','row');
					//if($balance_amount >= $total_amount){
						if(!empty($this->input->post('item_name'))){
							foreach($this->input->post('attachment') as $row => $value){
								$expense_type_split = explode('|', $_POST['expense_tpye'][$row]);
								if(count($expense_type_split) == 2){
									$expense_type = $expense_type_split[0];
									$expense_sub_type = $expense_type_split[1];
								}else{
									$expense_type = $expense_type_split[0];
									$expense_sub_type = -1;
								}
								$item_data[] = array(
									'id' => '',
									'transaction_id' => $transactionss_id,
									'item_name' => $this->input->post('item_name')[$row],
									'purpose' => $expense_type,
									'sub_purpose' => $expense_sub_type,
									'item_price' => $this->input->post('item_price')[$row],
									'ite_qty' => $this->input->post('ite_qty')[$row],
									'total' => $this->input->post('total_item_amount')[$row],
									//'attachment' => file_upload_m($_FILES['attachment']['name'][$row],$_FILES['attachment']['tmp_name'][$row]),
									'attachment' => $this->input->post('attachment')[$row],
									'data' => $data
								);
							}
						}					
						$transaction_data = array(
							'id' => '',
							'transaction_id' => $transactionss_id,
							'branch_id' => $emp_info->branch,
							'employee_id' => $employee_id,
							'amount' => $total_amount,
							'note' => $extra_note,
							'approval' => '0',
							'status' => '1',
							'uploader_info' => $uploader_info,
							'data' => $data
						);					
						$invoice_id = $this->Dashboard_model->select('advance_transaction_logs','','id','DESC','row');
						if(!empty($invoice_id->id)){
							$invv_id = $invoice_id->id;
						}else{
							$invv_id = 1;
						}
						$inv_id = date('dmY').$invv_id;
						$data_varient = array(
							'id' => '',
							'transaction_id' => $transactionss_id,
							'branch_id' => $emp_info->branch,
							'booking_id' => '',
							'payment_method' => 'Cash',
							'details' => 'Urgent Transaction(Buy Something)',
							'card_amount' => '',
							'cash_amount' => $total_amount,
							'mobile_amount' => '',
							'check_amount' => '',
							'invoice_number' => $inv_id,
							'note' => '',
							'status' => '1',
							'uploader_info' => $uploader_info,
							'data' => $data
						); 
						$transaction = array(
							'id' => '',
							'transaction_id' => $transactionss_id,
							'branch_id' => $emp_info->branch,
							'booking_id' => '',
							'careof' => $emp_info->full_name,
							'account_type' => 'Defult',
							'account' => 'Defult',
							'amount' => $total_amount,
							'date' => date('l, d/m/Y h:i:sa'),
							'transaction_type' => 'Debit',
							'transaction_category' => 'Urgent Transaction(Buy Something)',
							'transaction_method' => 'Petty Cash',
							'data_one' => '',
							'data_two' => '',
							'data_three' => '',
							'note' => 'Urgent Transaction(Buy Something)',
							'status' => '1',
							'uploader_info' => $uploader_info,
							'data' => $data
						);
						
						$petty_chash_check = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $employee_id),'id','ASC','row');
						$get_money = $petty_chash_check->amount - (int)$total_amount;
						$petty_chash = array(
							'amount' =>  $get_money
						);	
						//echo json_encode($this->input->post('attachment')); exit();
						$insert_transaction = $this->Dashboard_model->insert('transaction',$transaction);
						$insert_advance_transaction_logs = $this->Dashboard_model->insert('advance_transaction_logs',$transaction_data);
						$insert_payment_received_method = $this->Dashboard_model->insert('payment_received_method',$data_varient);
						$insert_advance_transaction_iteams = $this->Dashboard_model->insert_batch('advance_transaction_iteams',$item_data);
						
						if($insert_transaction && $insert_advance_transaction_logs && $insert_payment_received_method && $insert_advance_transaction_iteams){
							
							$success = array('success' => 'Successfully Saved!');
							header('HTTP/1.0 200 OK');
							echo json_encode($success);
						}else{
							
							$failure = array('failure' => 'Something Went Wrong Please Try Again!');
							header('HTTP/1.0 404 Data Error!');
							echo json_encode($failure);
						}	
						
				}
			/*  }else{
				header('HTTP/1.0 406 Not Acceptable');
				echo json_encode(array('msg' => "Did not save"));
			}  */
		}
		
	}
	
	public function check_parking(){
		if($this->input->method() == "get" && $this->input->get('authorization') == "raspberry"){
			$card_number = $this->input->get('card_number');
			$emp_sql = $this->db->query("select card_number from employee 
			where card_number='$card_number' and status='1'");
			$member_sql = $this->db->query("select card_number, parking from member_directory 
			where card_number='$card_number' and status='1'");
			$member_card = $member_sql->row();
			
			if(!empty($emp_sql->num_rows())){
				$emp = $this->db->query("select employee_id from employee where card_number='$card_number' and status='1'")->row();
				$card_holders_id = $emp->employee_id;
				
				$in_out = $this->db->query("select * from parking_logs where card_holders_id='$card_holders_id' order by id desc limit 1")->row();
				
				if(!empty($in_out)){
					if(!empty($in_out->vehicle_in) && !empty($in_out->vehicle_out)){
						// holders is currently out.
						$data = array(
							"card_holders_id" => $card_holders_id,
							"vehicle_in" => date("Y-m-d H:i:s"),
							"vehicle_out" => NULL,
							"holder_type" => "Employee"
						);
						$this->db->insert("parking_logs", $data);
					}elseif(!empty($in_out->vehicle_in) && empty($in_out->vehicle_out)){
						// holders is currently in.
						$data = array(
							"vehicle_out" => date("Y-m-d H:i:s")
						);
						$this->db->where('id', $in_out->id);
						$this->db->update('parking_logs', $data);
					}
				}else{
					// holders is currently out and first time in.
					$data = array(
						"card_holders_id" => $card_holders_id,
						"vehicle_in" => date("Y-m-d H:i:s"),
						"vehicle_out" => NULL,
						"holder_type" => "Employee"
					);
					$this->db->insert("parking_logs", $data);
				}
				echo json_encode(true);
			}else{
				if($member_card->parking == 1){
					$member = $this->db->query("select id from member_directory where card_number='$card_number' and status='1'")->row();
					$card_holders_id = $member->id;
					
					$in_out = $this->db->query("select * from parking_logs where card_holders_id='$card_holders_id' order by id desc limit 1")->row();
					
					if(!empty($in_out)){
						if(!empty($in_out->vehicle_in) && !empty($in_out->vehicle_out)){
							// holders is currently out.
							$data = array(
								"card_holders_id" => $card_holders_id,
								"vehicle_in" => date("Y-m-d H:i:s"),
								"vehicle_out" => NULL,
								"holder_type" => "Member"
							);
							$this->db->insert("parking_logs", $data);
						}elseif(!empty($in_out->vehicle_in) && empty($in_out->vehicle_out)){
							// holders is currently in.
							$data = array(
								"vehicle_out" => date("Y-m-d H:i:s")
							);
							$this->db->where('id', $in_out->id);
							$this->db->update('parking_logs', $data);
						}
					}else{
						// holders is currently out and first time in.
						$data = array(
							"card_holders_id" => $card_holders_id,
							"vehicle_in" => date("Y-m-d H:i:s"),
							"vehicle_out" => NULL,
							"holder_type" => "Member"
						);
						$this->db->insert("parking_logs", $data);
					}
					echo json_encode(true);
				}else{
					
					echo json_encode(false);
				}
			}
		}else{
			header('HTTP/1.0 400 Method Not Acceptable');
		}
	}
	
	public function parking_in_out(){
		//10.100.92.184/super_home/json/api/parking-in-out?card_number=0013111855&authorization=raspberry&status=OUT
		if($this->input->method() == "get" && $this->input->get('authorization') == "raspberry"){
			
			$status = $this->input->get('status');
			if(isset($status) && !empty($status)){
				if($status == "IN"){
					echo json_encode($status);
				}elseif($status == "OUT"){
					echo json_encode($status);
				}else{
					header('HTTP/1.0 400 Status Not Acceptable');
				}
			}else{
				header('HTTP/1.0 400 Status Not Acceptable');
			}
			
		}else{
			header('HTTP/1.0 400 Method Not Acceptable');
		}
	}

	//*********** */ hrm change password *********
	public function app_password_change()
	{
		$data = array();
		$this->header = $this->input->request_headers();
		if (!$this->authorized($this->header['authorization'], $this->header['device'])) {
			$array = array(
				'error'    => true,
				'authorization' => "Authorization fail"
			);
			echo json_encode($array, true);
			exit();
		}else
		{
			if (isset($_POST['old_password']) && isset($_POST['new_password'])) {
				$old_password = md5($this->input->post('old_password'));
				$new_password = md5($this->input->post('new_password'));
				$condition = array(
					'email' => $this->authenticated->email,
					'branch' => $this->authenticated->branch,
					'password' => $old_password,
					'status' => '1'
				);
				$challenge = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'row');
				if (!empty($challenge->password)) {
					if (!empty($new_password)) {
						if ($challenge->password == $new_password) {
							$array = array(
								'error'    => true,
								'old_password' => form_error('old_password'),
								'new_password' => form_error('new_password')
							);
						} else {
							$data = array(
								'password' => $new_password
							);
							if ($this->Dashboard_model->update('employee', $data, $challenge->id)) {
								$array = array(
									'success'    => true
								);
							} else {
								$array = array(
									'error'    => true
								);
							}
						}
					} else {
						$array = array(
							'success'    => true
						);
					}
				} else {
					$array = array(
						'error'    => true,
						'old_password' => form_error('old_password')
					);
				}
			}
		}
		echo json_encode($array, true);
	}
	//end exit change Password


}
