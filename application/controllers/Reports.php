<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
	}

	public function booking_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$form_branch_id = '';
			if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') {  // SUPER ADMIN=============
				if (!empty($form_branch_id)) {
					$branches = "and branch_id = '" . $form_branch_id . "'";
				} else {
					$branches = "";
				}
				$data['banches'] = $this->Dashboard_model->select('branches', array('status' => '1'), 'id', 'ASC', 'result');
			} else {
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array('role_id' => $role_id);
				$branch_per = $this->Dashboard_model->select('branch_permission', $condition_per, 'id', 'desc', 'row');
				$branchids = explode(",", $branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach ($branchids as $row) {
					if ($row != '0') {
						$branches .= "'" . $row . "',";
						$ides_branch = '1';
					}
				}
				if ($ides_branch == '1') {	// BRNCH ADMIN =======================				
					if (!empty($form_branch_id)) {
						$get_branch = "'" . $form_branch_id . "'";
					} else {
						$get_branch = rtrim($branches, ",");
					}
					$get_branch_branch = rtrim($branches, ",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (" . $get_branch_branch . ")");
				} else {   // INDIVITUAL BRANCH ADMIN ================================
					$branch_id = $_SESSION['super_admin']['branch'];
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '" . $branch_id . "'");
				}
			}

			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Booking Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/booking_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end booking report---

	//--- Start CheckIn Today---
	public function checkin_today()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'CheckIn Taday Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/checkin_today', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end CheckIn Today---

	//--- Start CheckOut Today---
	public function checkout_today()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'CheckOut Today Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/checkout_today', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end CheckOut Today---

	//--- Start rental_report---
	public function rental_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$form_branch_id = '';
			if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') {  // SUPER ADMIN=============
				if (!empty($form_branch_id)) {
					$branches = "and branch_id = '" . $form_branch_id . "'";
				} else {
					$branches = "";
				}
				$data['banches'] = $this->Dashboard_model->select('branches', array('status' => '1'), 'id', 'ASC', 'result');
			} else {
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array('role_id' => $role_id);
				$branch_per = $this->Dashboard_model->select('branch_permission', $condition_per, 'id', 'desc', 'row');
				$branchids = explode(",", $branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach ($branchids as $row) {
					if ($row != '0') {
						$branches .= "'" . $row . "',";
						$ides_branch = '1';
					}
				}
				if ($ides_branch == '1') {	// BRNCH ADMIN =======================				
					if (!empty($form_branch_id)) {
						$get_branch = "'" . $form_branch_id . "'";
					} else {
						$get_branch = rtrim($branches, ",");
					}
					$get_branch_branch = rtrim($branches, ",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (" . $get_branch_branch . ")");
				} else {   // INDIVITUAL BRANCH ADMIN ================================
					$branch_id = $_SESSION['super_admin']['branch'];
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '" . $branch_id . "'");
				}
			}
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Rental Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/rental_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end rental_report---

	//--- Start renew_report---
	public function renew_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$form_branch_id = '';
			if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') {  // SUPER ADMIN=============
				if (!empty($form_branch_id)) {
					$branches = "and branch_id = '" . $form_branch_id . "'";
				} else {
					$branches = "";
				}
				$data['banches'] = $this->Dashboard_model->select('branches', array('status' => '1'), 'id', 'ASC', 'result');
			} else {
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array('role_id' => $role_id);
				$branch_per = $this->Dashboard_model->select('branch_permission', $condition_per, 'id', 'desc', 'row');
				$branchids = explode(",", $branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach ($branchids as $row) {
					if ($row != '0') {
						$branches .= "'" . $row . "',";
						$ides_branch = '1';
					}
				}
				if ($ides_branch == '1') {	// BRNCH ADMIN =======================				
					if (!empty($form_branch_id)) {
						$get_branch = "'" . $form_branch_id . "'";
					} else {
						$get_branch = rtrim($branches, ",");
					}
					$get_branch_branch = rtrim($branches, ",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (" . $get_branch_branch . ")");
				} else {   // INDIVITUAL BRANCH ADMIN ================================
					$branch_id = $_SESSION['super_admin']['branch'];
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '" . $branch_id . "'");
				}
			}
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Renew Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/renew_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end renew_report---

	//--- Start panalty report---
	public function panalty_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Member Panalty Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/panalty_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end  panalty report---

	//--- Start request_cancel_report---
	public function request_cancel_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Request For Cancel Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/request_cancel_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end auto_cancel_report---

	//--- Start auto_cancel_report---
	public function auto_cancel_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Auto Cancel Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/auto_cancel_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end auto_cancel_report---

	//--- Start force_cancel_report---
	public function force_cancel_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Force Cancel Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/force_cancel_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end force_cancel_report---

	//--- Start salf_cancel_report---
	public function salf_cancel_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Self Cancel Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/salf_cancel_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end salf_cancel_report---

	//--- Start package_change_report---
	public function package_change_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Member Package Change Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/package_change_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end package_change_report---

	//--- Start bed_change_report---
	public function bed_change_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Member Bed Change Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/bed_change_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end bed_change_report---

	//--- Start today_collection_report---
	public function today_collection_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			if (isset($_POST['branch_id_hrad'])) {
				$form_branch_id = $_POST['branch_id_hrad'];
				$data['drop_down_v_id'] = $_POST['branch_id_hrad'];
			} else {
				$form_branch_id = '';
				$data['drop_down_v_id'] = '';
			}
			if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') {  // SUPER ADMIN=============
				if (!empty($form_branch_id)) {
					$branches = "and branch_id = '" . $form_branch_id . "'";
					$pck_branches = "where branch_id = '" . $form_branch_id . "'";
				} else {
					$branches = "";
					$pck_branches = "";
				} //Super admin
				$data['banches'] = $this->Dashboard_model->select('branches', array('status' => '1'), 'id', 'ASC', 'result');

				if (isset($_POST['date_filter'])) {
					if (!empty($_POST['from_date'])) {
						$fd = explode('-', $_POST['from_date']);
						$fdate = $fd[2] . '/' . $fd[1] . '/' . $fd[0];
						$from_date  = " data = '" . $fdate . "' AND ";
					} else {
						$from_date  = " data = '" . date('d/m/Y') . "' AND ";
					}
					if (!empty($_POST['branch_id'])) {
						$branch_id = " branch_id = '" . $_POST['branch_id'] . "' AND ";
					} else {
						$branch_id = "";
					}
				} else {
					$from_date  = " data = '" . date('d/m/Y') . "' AND ";
					$branch_id = "";
				}

				$data['transaction']  = $this->Dashboard_model->mysqlii("SELECT * FROM transaction WHERE $from_date $branch_id transaction_type = 'Credit' order by id desc ");
				$data['transaction_debit'] = $this->Dashboard_model->mysqlii("SELECT * FROM transaction WHERE $from_date $branch_id transaction_type = 'Debit' order by id desc ");
				$data['tr_brn']  = $this->Dashboard_model->mysqlii("SELECT * FROM branches order by id desc");
				$data['tr_mem']  = $this->Dashboard_model->mysqlii("SELECT * FROM member_directory order by id desc");
				$data['tr_emp']  = $this->Dashboard_model->mysqlii("SELECT * FROM employee order by id desc");
			} else {
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);
				$branch_per = $this->Dashboard_model->select('branch_permission', $condition_per, 'id', 'desc', 'row');
				$branchids = explode(",", $branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach ($branchids as $row) {
					if ($row != '0') {
						$branches .= "'" . $row . "',";
						$ides_branch = '1';
					}
				}
				if ($ides_branch == '1') {
					if (!empty($form_branch_id)) {
						$get_branch = "'" . $form_branch_id . "'";
					} else {
						$get_branch = rtrim($branches, ",");
					} //Multi branch admin

					$get_branch_branch = rtrim($branches, ",");
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (" . $get_branch_branch . ")");
					if (isset($_POST['date_filter'])) {
						if (!empty($_POST['from_date'])) {
							$fd = explode('-', $_POST['from_date']);
							$fdate = $fd[2] . '/' . $fd[1] . '/' . $fd[0];
							$from_date  = " data = '" . $fdate . "' AND ";
						} else {
							$from_date  = " data = '" . date('d/m/Y') . "' AND ";
						}
						if (!empty($_POST['branch_id'])) {
							$branch_id = " branch_id = '" . $_POST['branch_id'] . "' AND ";
						} else {
							$branch_id = " branch_id IN (" . $get_branch_branch . ") AND ";
						}
					} else {
						$from_date  = " data = '" . date('d/m/Y') . "' AND ";
						$branch_id = " branch_id IN (" . $get_branch_branch . ") AND ";
					}

					$data['transaction']  = $this->Dashboard_model->mysqlii("SELECT * FROM transaction WHERE $from_date $branch_id transaction_type = 'Credit' order by id desc ");
					$data['transaction_debit'] = $this->Dashboard_model->mysqlii("SELECT * FROM transaction WHERE $from_date $branch_id transaction_type = 'Debit' order by id desc ");
					$data['tr_brn']  = $this->Dashboard_model->mysqlii("SELECT * FROM branches order by id desc");
					$data['tr_mem']  = $this->Dashboard_model->mysqlii("SELECT * FROM member_directory order by id desc");
					$data['tr_emp']  = $this->Dashboard_model->mysqlii("SELECT * FROM employee order by id desc");
				} else { //indevitul admin
					$branch_id = $_SESSION['super_admin']['branch'];
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '" . $branch_id . "'");
					if (isset($_POST['date_filter'])) {
						if (!empty($_POST['from_date'])) {
							$fd = explode('-', $_POST['from_date']);
							$fdate = $fd[2] . '/' . $fd[1] . '/' . $fd[0];
							$from_date  = " data = '" . $fdate . "' AND ";
						} else {
							$from_date  = " data = '" . date('d/m/Y') . "' AND ";
						}
						if (!empty($_POST['branch_id'])) {
							$branch_id = " branch_id = '" . $_POST['branch_id'] . "' AND ";
						} else {
							$branch_id = " branch_id = '" . $branch_id . "' AND ";
						}
					} else {
						$from_date  = " data = '" . date('d/m/Y') . "' AND ";
						$branch_id = " branch_id = '" . $branch_id . "' AND ";
					}

					$data['transaction']  = $this->Dashboard_model->mysqlii("SELECT * FROM transaction WHERE $from_date $branch_id transaction_type = 'Credit' order by id desc ");
					$data['transaction_debit'] = $this->Dashboard_model->mysqlii("SELECT * FROM transaction WHERE $from_date $branch_id transaction_type = 'Debit' order by id desc ");
					$data['tr_brn']  = $this->Dashboard_model->mysqlii("SELECT * FROM branches order by id desc");
					$data['tr_mem']  = $this->Dashboard_model->mysqlii("SELECT * FROM member_directory order by id desc");
					$data['tr_emp']  = $this->Dashboard_model->mysqlii("SELECT * FROM employee order by id desc");
				}
			}

			$data['package_category'] = $this->Dashboard_model->select('packages_category', array('branch_id' => $branch_id), 'id', 'asc', 'result');
			$data['title_info'] = 'Collection Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/today_collection_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end today_collection_report---

	//--- Start discount_report---
	public function discount_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Discount Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/discount_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end discount_report---

	//--- Start occupide_member_list---
	public function occupide_member_list()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Occupide Member Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/occupide_member_list', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end occupide_member_list---


	//--- Start cancel_reminder---
	public function cancel_reminder()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Today Cancel Reminder';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/cancel_reminder', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end cancel_reminder---


	//--- Start live_request_for_cancel_member_list---
	public function live_request_for_cancel_member_list()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Request For Cancel Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/live_request_for_cancel_member_list', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end live_request_for_cancel_member_list---

	//--- Start live_booked_member_list---
	public function live_booked_member_list()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Booked Member Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/live_booked_member_list', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end live_booked_member_list---

	//--- end live_booked_member_list---
	public function ipo_payment_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['cash_collect'])) {
				error_reporting(0);
				$success = false;
				$today = date('Y-m-d');
				foreach ($_POST['cash_collect'] as $collected_id) {
					$data = array(
						'note' 			=> 'cash_received',
						'received_date'	=> $today,
						'collected_by'	=> $_SESSION['super_admin']['employee_ids']
					);
					$get_info = $this->Dashboard_model->select('ipo_payment_received_method', array('id' => $collected_id), 'id', 'DESC', 'row');
					$uploader_info = explode('___', $get_info->uploader_info);
					$email = $uploader_info[1];
					$get_emp_info = $this->Dashboard_model->select('employee', array('email' => $email), 'id', 'DESC', 'row');
					$get_balance_info = $this->Dashboard_model->select('employee_award_wallet', array('employee_id' => $get_emp_info->employee_id), 'id', 'DESC', 'row');
					$get_commission = $this->Dashboard_model->select('employee_ipo_commmission', array('id' => '1'), 'id', 'DESC', 'row');

					if (!empty($get_info->card_amount)) {
						$card_amount = $get_info->card_amount;
					} else {
						$card_amount = 0;
					}
					if (!empty($get_info->cash_amount)) {
						$cash_amount = $get_info->cash_amount;
					} else {
						$cash_amount = 0;
					}
					if (!empty($get_info->mobile_amount)) {
						$mobile_amount = $get_info->mobile_amount;
					} else {
						$mobile_amount = 0;
					}
					if (!empty($get_info->check_amount)) {
						$check_amount = $get_info->check_amount;
					} else {
						$check_amount = 0;
					}
					$balance = (float)$get_balance_info->balance;
					$main_amount = (float)$card_amount + (float)$cash_amount + (float)$mobile_amount + (float)$check_amount;
					$commission = $get_commission->commission_percentage;
					$commission_amount = ($main_amount * ($commission / 100));
					$update_result = $balance + (float)$commission_amount;
					$update_wallet_data = array(
						'balance' => $update_result
					);
					$update_insert_logs = array(
						'id' => '',
						'employee_id' => $get_emp_info->employee_id,
						'amount' => $commission_amount,
						'type' => 'Investor registration Commission',
						'date_from' => date('d/m/Y'),
						'date_to' => date('d/m/Y'),
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					if (
						$this->Dashboard_model->update('ipo_payment_received_method', $data, $collected_id) and
						$this->Dashboard_model->update('employee_award_wallet', $update_wallet_data, $get_balance_info->id) and
						$this->Dashboard_model->insert('award_insert_logs', $update_insert_logs)
					) {
						$success = true;
					} else {
						$success = false;
					}
				}
				if ($success) {
					echo 'Data Subbmitted Successfully!________';
					return;
				} else {
					echo 'Something wrong!Please Try again________';
					return;
				}
			}

			if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') {  // SUPER ADMIN=============
				if (isset($_POST['date_sub'])) {
					if (!empty($_POST['date_range'])) {
						$date = explode(' - ', $_POST['date_range']);
						$one_ymd = explode('/', $date[0]);
						$two_ymd = explode('/', $date[1]);
						$date_from = $one_ymd[2] . '-' . $one_ymd[1] . '-' . $one_ymd[0];
						$date_to = $two_ymd[2] . '-' . $two_ymd[1] . '-' . $two_ymd[0];
						$data['date_range'] = $_POST['date_range'];
						$data['b_id'] = $_POST['branch_id'];
						$date_wise = "and STR_TO_DATE(data,'%d/%m/%Y') between '$date_from' and '$date_to'";
					} else {
						$date_wise = "";
					}
					if ($_POST['branch_id'] != '1') {
						$branchwe = "and branch_id = '" . $_POST['branch_id'] . "'";
					} else {
						$branchwe = "";
					}

					$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from ipo_payment_received_method where status = '1' $branchwe $date_wise");

					// $data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' $branchwe"); // $date_wise
				} else {
					$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from ipo_payment_received_method");

					// $data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data"); // where data = '".date('d/m/Y')."'
				}
				$data['banches'] = $this->Dashboard_model->select('branches', array('status' => '1'), 'id', 'ASC', 'result');
			} else {
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);
				$branch_per = $this->Dashboard_model->select('branch_permission', $condition_per, 'id', 'desc', 'row');
				$branchids = explode(",", $branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach ($branchids as $row) {
					if ($row != '0') {
						$branches .= "'" . $row . "',";
						$ides_branch = '1';
					}
				}
				if ($ides_branch == '1') {	// BRNCH ADMIN =======================				
					if (!empty($form_branch_id)) {
						$get_branch = "'" . $form_branch_id . "'";
					} else {
						$get_branch = rtrim($branches, ",");
					}
					if (isset($_POST['date_sub'])) {
						if (!empty($_POST['date_range'])) {
							$date = explode(' - ', $_POST['date_range']);
							$one_ymd = explode('/', $date[0]);
							$two_ymd = explode('/', $date[1]);
							$date_from = $one_ymd[2] . '-' . $one_ymd[1] . '-' . $one_ymd[0];
							$date_to = $two_ymd[2] . '-' . $two_ymd[1] . '-' . $two_ymd[0];
							$data['date_range'] = $_POST['date_range'];
							$data['b_id'] = $_POST['branch_id'];
							$date_wise = "and STR_TO_DATE(data,'%d/%m/%Y') between '$date_from' and '$date_to'";
						} else {
							$date_wise = "";
						}
						if ($_POST['branch_id'] != '1') {
							$branchwe = "and branch_id = '" . $_POST['branch_id'] . "'";
						} else {
							$branchwe = "";
						}

						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from ipo_payment_received_method where status = '1' $branchwe $date_wise");
						// $data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' $branchwe "); //$date_wise
					} else {
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from ipo_payment_received_method where status = '1' and data = '" . date('d/m/Y') . "' and branch_id IN (" . $get_branch . ")");
						// $data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' and branch_id IN (".$get_branch.")"); // and data = '".date('d/m/Y')."'
					}
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (" . $get_branch . ")");
				} else {   // INDIVITUAL BRANCH ADMIN ================================
					$branch_id = $_SESSION['super_admin']['branch'];
					if (isset($_POST['date_sub'])) {
						if (!empty($_POST['date_range'])) {
							$date = explode(' - ', $_POST['date_range']);
							$one_ymd = explode('/', $date[0]);
							$two_ymd = explode('/', $date[1]);
							$date_from = $one_ymd[2] . '-' . $one_ymd[1] . '-' . $one_ymd[0];
							$date_to = $two_ymd[2] . '-' . $two_ymd[1] . '-' . $two_ymd[0];
							$data['date_range'] = $_POST['date_range'];
							$data['b_id'] = $_POST['branch_id'];
							$date_wise = "and STR_TO_DATE(data,'%d/%m/%Y') between '$date_from' and '$date_to'";
						} else {
							$date_wise = "";
						}
						if ($_POST['branch_id'] != '1') {
							$branchwe = "and branch_id = '" . $_POST['branch_id'] . "'";
						} else {
							$branchwe = "";
						}
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from ipo_payment_received_method where status = '1' $branchwe $date_wise");
						// $data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' $branchwe"); // $date_wise
					} else {
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from ipo_payment_received_method where status = '1' and data = '" . date('d/m/Y') . "' and branch_id = '" . $branch_id . "'");
						// $data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' and branch_id = '".$branch_id."'"); // and data = '".date('d/m/Y')."'
					}
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '" . $branch_id . "'");
				}
			}
			// $data['payment_reports'] = $this->Dashboard_model->select('ipo_payment_received_method', $data, 'id', 'DESC', 'row');
			$data_transaction = array(
				'status' 				=> 1,
				'transaction_category'	=> 'IPO Account'
			);
			$data['payment_reports_received'] = $this->Dashboard_model->mysqlii("select * from ipo_payment_received_method where note = 'cash_received'");
			$data['transaction'] = $this->Dashboard_model->select('transaction', $data_transaction, 'id', 'DESC', 'result');
			// var_dump($data['transaction']);
			// exit();			
			$data['title_info'] = 'IPO Payment Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/ipo_payment_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);

			$this->load->view('dashboard', $data);
		}
	}

	//--- Start payment_report---
	public function payment_report()
	{
		
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$uploader_info = $_SESSION['super_admin']['user_type'] . '___' . $_SESSION['super_admin']['email'] . '___' . $_SESSION['super_admin']['branch'];
			if (isset($_POST['copy_id'])) {
				foreach ($_POST['copy_id'] as $row) {
					$get_cond = array('id' => $row);
					$get_data = $this->Dashboard_model->select('payment_received_method', $get_cond, 'id', 'DESC', 'row');
					$get_data_check = $this->Dashboard_model->select('drop_box_data', array('transaction_id' => $get_data->transaction_id), 'id', 'DESC', 'row');
					if ($get_data_check->transaction_id == $get_data->transaction_id) {
						echo 'Operation Break!' . $get_data_check->transaction_id . 'All ready sent to dropbox!________';
						break;
					}
					$drop_box_data[] = array(
						'id' => '',
						'payment_id' => $get_data->id,
						'branch_id' => $get_data->branch_id,
						'transaction_id' => $get_data->transaction_id,
						'invoice_id' => $get_data->invoice_number,
						'payment_method' => $get_data->payment_method,
						'amount' => $get_data->cash_amount,
						'note' => '',
						'status' => '1',
						'uploader_info' => $uploader_info,
						'data' => date('d/m/Y')
					);
					$update_data = array(
						'note' => 'drop_box_checked'
					);
					$this->Dashboard_model->update('payment_received_method', $update_data, $row);
				}
				if ($this->Dashboard_model->insert_batch('drop_box_data', $drop_box_data)) {
					echo 'Data Subbmitted Successfully!________';
				} else {
					echo 'Something wrong!Please Try again________';
				}
			}
			if (isset($_POST['missing_id'])) {
				foreach ($_POST['missing_id'] as $row) {
					$get_cond = array('id' => $row);
					$check_id = $this->Dashboard_model->select('drop_box_data', $get_cond, 'id', 'DESC', 'row');
					$update_data = array(
						'note' => ''
					);
					if ($this->Dashboard_model->update('payment_received_method', $update_data, $check_id->payment_id)) {
						$this->Dashboard_model->delete('drop_box_data', $check_id->id);
					}
				}
				echo 'Data Subbmitted Successfully!________';
				$data['mis_act'] = 'active';
			}
			if (isset($_POST['missing'])) {
				$get_cond = array('id' => $this->input->post('hidden_id'));
				$check_id = $this->Dashboard_model->select('drop_box_data', $get_cond, 'id', 'DESC', 'row');
				$update_data = array(
					'note' => ''
				);
				if ($this->Dashboard_model->update('payment_received_method', $update_data, $check_id->payment_id)) {
					if ($this->Dashboard_model->delete('drop_box_data', $check_id->id)) {
						alert('warning', 'Back Successfully!');
					} else {
						alert('danger', 'Something wrong! Please try again');
					}
				} else {
					alert('danger', 'Something wrong! Please try again');
				}
				$data['mis_act'] = 'active';
			}


			if (isset($_POST['generate_received_money'])) {
				$get_branch = $this->Dashboard_model->select('branches', array('branch_id' => $this->input->post('branch_id')), 'id', 'DESC', 'row');
				$get_money = $this->Dashboard_model->select('accounts', array('id' => '1'), 'id', 'DESC', 'row');
				$update_money = $get_money->balance - $this->input->post('total_money');
				$uniq_generate_key = $this->input->post('transac_uniq_id');
				$transaction_ids = $this->input->post('transaction_ids');
				$send_data = array(
					'id' 				=> '',
					'uniq_id' 			=> $uniq_generate_key,
					'transaction_ids' 	=> $transaction_ids,
					'branch_id' 		=> $get_branch->branch_id,
					'branch_name' 		=> $get_branch->branch_name,
					'note' 				=> $this->input->post('receive_money_note'),
					'status' 			=> '1',
					'uploader_info' 	=> $uploader_info,
					'data' 				=> date('d/m/Y')
				);


				$accounts_data = array(
					'balance' => $update_money
				);

				if (
					$this->Dashboard_model->insert('collection_money_from_dropbox', $send_data)
					and $this->Dashboard_model->update('accounts', $accounts_data, '1')
				) {
					foreach (explode(',', $transaction_ids) as $row) {
						$ind_data = array(
							'note' => 'money_collected'
						);
						$this->Dashboard_model->update('drop_box_data', $ind_data, $row);
					}
					alert('success', 'Successfully Generated Report!');
				} else {
					alert('danger', 'Something wrong! Please try again');
				}
			}


			$data['collection_money_from_dropbox'] =  $this->Dashboard_model->mysqlii("select * from collection_money_from_dropbox order by id desc");

			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);

			if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') {  // SUPER ADMIN=============
				if (isset($_POST['date_sub'])) {
					if (!empty($_POST['date_range'])) {
						$date = explode(' - ', $_POST['date_range']);
						$one_ymd = explode('/', $date[0]);
						$two_ymd = explode('/', $date[1]);
						$date_from = $one_ymd[2] . '-' . $one_ymd[1] . '-' . $one_ymd[0];
						$date_to = $two_ymd[2] . '-' . $two_ymd[1] . '-' . $two_ymd[0];
						$data['date_range'] = $_POST['date_range'];
						$data['b_id'] = $_POST['branch_id'];
						$date_wise = "and STR_TO_DATE(data,'%d/%m/%Y') between '$date_from' and '$date_to'";
					} else {
						$date_wise = "";
					}
					if ($_POST['branch_id'] != '1') {
						$branchwe = "and branch_id = '" . $_POST['branch_id'] . "'";
					} else {
						$branchwe = "";
					}

					$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' $branchwe $date_wise");
					$data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' $branchwe"); // $date_wise
				} else {
					$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where data = '" . date('d/m/Y') . "'");
					$data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data"); // where data = '".date('d/m/Y')."'
				}
				$data['banches'] = $this->Dashboard_model->select('branches', array('status' => '1'), 'id', 'ASC', 'result');
			} else {
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);
				$branch_per = $this->Dashboard_model->select('branch_permission', $condition_per, 'id', 'desc', 'row');
				$branchids = explode(",", $branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach ($branchids as $row) {
					if ($row != '0') {
						$branches .= "'" . $row . "',";
						$ides_branch = '1';
					}
				}
				if ($ides_branch == '1') {	// BRNCH ADMIN =======================				
					if (!empty($form_branch_id)) {
						$get_branch = "'" . $form_branch_id . "'";
					} else {
						$get_branch = rtrim($branches, ",");
					}
					if (isset($_POST['date_sub'])) {
						if (!empty($_POST['date_range'])) {
							$date = explode(' - ', $_POST['date_range']);
							$one_ymd = explode('/', $date[0]);
							$two_ymd = explode('/', $date[1]);
							$date_from = $one_ymd[2] . '-' . $one_ymd[1] . '-' . $one_ymd[0];
							$date_to = $two_ymd[2] . '-' . $two_ymd[1] . '-' . $two_ymd[0];
							$data['date_range'] = $_POST['date_range'];
							$data['b_id'] = $_POST['branch_id'];
							$date_wise = "and STR_TO_DATE(data,'%d/%m/%Y') between '$date_from' and '$date_to'";
						} else {
							$date_wise = "";
						}
						if ($_POST['branch_id'] != '1') {
							$branchwe = "and branch_id = '" . $_POST['branch_id'] . "'";
						} else {
							$branchwe = "";
						}

						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' $branchwe $date_wise");
						$data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' $branchwe "); //$date_wise
					} else {
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' and data = '" . date('d/m/Y') . "' and branch_id IN (" . $get_branch . ")");
						$data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' and branch_id IN (" . $get_branch . ")"); // and data = '".date('d/m/Y')."'
					}
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id in (" . $get_branch . ")");
				} else {   // INDIVITUAL BRANCH ADMIN ================================
					$branch_id = $_SESSION['super_admin']['branch'];
					if (isset($_POST['date_sub'])) {
						if (!empty($_POST['date_range'])) {
							$date = explode(' - ', $_POST['date_range']);
							$one_ymd = explode('/', $date[0]);
							$two_ymd = explode('/', $date[1]);
							$date_from = $one_ymd[2] . '-' . $one_ymd[1] . '-' . $one_ymd[0];
							$date_to = $two_ymd[2] . '-' . $two_ymd[1] . '-' . $two_ymd[0];
							$data['date_range'] = $_POST['date_range'];
							$data['b_id'] = $_POST['branch_id'];
							$date_wise = "and STR_TO_DATE(data,'%d/%m/%Y') between '$date_from' and '$date_to'";
						} else {
							$date_wise = "";
						}
						if ($_POST['branch_id'] != '1') {
							$branchwe = "and branch_id = '" . $_POST['branch_id'] . "'";
						} else {
							$branchwe = "";
						}
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' $branchwe $date_wise");
						$data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' $branchwe"); // $date_wise
					} else {
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' and data = '" . date('d/m/Y') . "' and branch_id = '" . $branch_id . "'");
						$data['drop_box_data'] =  $this->Dashboard_model->mysqlii("select * from drop_box_data where status = '1' and branch_id = '" . $branch_id . "'"); // and data = '".date('d/m/Y')."'
					}
					$data['banches'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '" . $branch_id . "'");
				}
			}
			
			$data['member_info'] =  $this->Dashboard_model->mysqlii("select * from member_directory");
			$data['employee_info'] =  $this->Dashboard_model->mysqlii("select * from employee");
			$data['transaction'] =  $this->Dashboard_model->mysqlii("select * from transaction");

			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Payment Report';
			
			$data['header'] = $this->load->view('include/header', $data, TRUE);
			$data['nav'] = $this->load->view('include/nav', $data, TRUE);
			
			$data['article'] = $this->load->view('template/reports/payment_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', $data, TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end payment_report---

	//--- Start shop_report---
	public function shop_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Shop Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/shop_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end shop_report---

	//--- Start account_employee_award_insert_logs---
	public function account_employee_award_insert_logs()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Employee Award insert logs';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/accounting/account_employee_award_insert_logs', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end account_employee_award_insert_logs---

	//--- Start dining_report---
	public function dining_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Payment Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/dining_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end dining_report---

	//--- Start all_collection_report---
	public function all_collection_reportall_collection_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);

			if ($_SESSION['super_admin']['role_id'] == '2805597208697462328') {  // SUPER ADMIN=============
				if (isset($_POST['date_sub'])) {
					$det = explode('-', $_POST['short_from']);
					$s_date = $det[2] . '/' . $det[1] . '/' . $det[0];
					$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' and data = '" . $s_date . "' GROUP BY (invoice_number)");
				} else {
					$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' and data = '" . date('d/m/Y') . "' GROUP BY (invoice_number)");
				}
			} else {
				$role_id = $_SESSION['super_admin']['role_id'];
				$condition_per = array(
					'role_id' => $role_id
				);
				$branch_per = $this->Dashboard_model->select('branch_permission', $condition_per, 'id', 'desc', 'row');
				$branchids = explode(",", $branch_per->permission);
				$branches = '';
				$get_branch = '';
				$ides_branch = '0';
				foreach ($branchids as $row) {
					if ($row != '0') {
						$branches .= "'" . $row . "',";
						$ides_branch = '1';
					}
				}
				if ($ides_branch == '1') {	// BRNCH ADMIN =======================				
					if (!empty($form_branch_id)) {
						$get_branch = "'" . $form_branch_id . "'";
					} else {
						$get_branch = rtrim($branches, ",");
					}
					if (isset($_POST['date_sub'])) {
						$det = explode('-', $_POST['short_from']);
						$s_date = $det[2] . '/' . $det[1] . '/' . $det[0];
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' and data = '" . $s_date . "' and branch_id IN (" . $get_branch . ") GROUP BY (invoice_number)");
					} else {
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' and data = '" . date('d/m/Y') . "' and branch_id IN (" . $get_branch . ") GROUP BY (invoice_number)");
					}
				} else {   // INDIVITUAL BRANCH ADMIN ================================
					$branch_id = $_SESSION['super_admin']['branch'];
					if (isset($_POST['date_sub'])) {
						$det = explode('-', $_POST['short_from']);
						$s_date = $det[2] . '/' . $det[1] . '/' . $det[0];
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' and data = '" . $s_date . "' and branch_id = '" . $branch_id . "' GROUP BY (invoice_number)");
					} else {
						$data['payment_reports'] = $this->Dashboard_model->mysqlii("select * from payment_received_method where status = '1' and data = '" . date('d/m/Y') . "' and branch_id = '" . $branch_id . "' GROUP BY (invoice_number)");
					}
				}
			}
			$data['member_info'] =  $this->Dashboard_model->mysqlii("select * from member_directory order by id desc");
			$data['employee_info'] =  $this->Dashboard_model->mysqlii("select * from employee order by id desc");
			$data['transaction'] =  $this->Dashboard_model->mysqlii("select * from transaction order by id desc");

			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Payment Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/all_collection_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end all_collection_report---


	//--- Start details_collection_report---
	public function details_collection_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {


			$data['title_info'] = 'Details Collection Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/accounting/details_collection_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end details_collection_report---

	public function branch_revenue_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['generated'] = false;

			$selected_month = new DateTime(date('Y-m') . '-01');
			if (isset($_GET['month'])) {
				$selected_month = new DateTime(base64_decode($_GET['month']) . '-01');
			}
			$validate_generated = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from branches_revenue_rank where month = '" . $selected_month->format('Y-m') . "'");
			if ($validate_generated->id_count > 0) {
				$data['generated'] = true;
			}
			$data['rents'] = $this->Dashboard_model->mysqlii("SELECT SUM(rent_amount) AS rent_amount, branch_name, branch_id FROM rent_info WHERE payment_pattern NOT IN ('2') AND STR_TO_DATE(data, '%d/%m/%Y') between '" . $selected_month->format('Y-m-d') . "' AND '" . $selected_month->format('Y-m-t') . "' GROUP BY branch_id");
			$salaries = $this->Dashboard_model->mysqlii("SELECT SUM(total_sallary) as total_salary, branch_id FROM employee_monthly_sallary WHERE date_full = '" . $selected_month->format('m/Y') . "' GROUP BY branch_id");
			if (!empty($salaries)) {
				foreach ($salaries as $salary) {
					$data['salaries'][$salary->branch_id] = $salary->total_salary;
				}
			} else {
				$data['salaries'] = NULL;
			}
			$branches = $this->Dashboard_model->mysqlii("SELECT branch_id, branch_name from branches WHERE status = 1");
			foreach ($branches as $branch) {
				$electirc_bill = $this->Dashboard_model->mysqlij("SELECT amount from branch_elictric_bill where branch_id = '" . $branch->branch_id . "' AND month_year = '" . $selected_month->format('m/Y') . "'");
				$data['electric_bills'][$branch->branch_id] = 0;
				if (!is_null($electirc_bill)) {
					$data['electric_bills'][$branch->branch_id] = $electirc_bill->amount;
				}

				$electirc_bill = $this->Dashboard_model->mysqlij("SELECT amount from branch_food_cost where branch_id = '" . $branch->branch_id . "' AND month_year = '" . $selected_month->format('m/Y') . "'");
				$data['food_costs'][$branch->branch_id] = 0;
				if (!is_null($electirc_bill)) {
					$data['food_costs'][$branch->branch_id] = $electirc_bill->amount;
				}

				$electirc_bill = $this->Dashboard_model->mysqlij("SELECT amount from branch_house_rent where branch_id = '" . $branch->branch_id . "' AND month_year = '" . $selected_month->format('m/Y') . "'");
				$data['house_rents'][$branch->branch_id] = 0;
				if (!is_null($electirc_bill)) {
					$data['house_rents'][$branch->branch_id] = $electirc_bill->amount;
				}

				$electirc_bill = $this->Dashboard_model->mysqlij("SELECT amount from branch_internet_bill where branch_id = '" . $branch->branch_id . "' AND month_year = '" . $selected_month->format('m/Y') . "'");
				$data['internet_bills'][$branch->branch_id] = 0;
				if (!is_null($electirc_bill)) {
					$data['internet_bills'][$branch->branch_id] = $electirc_bill->amount;
				}

				$electirc_bill = $this->Dashboard_model->mysqlij("SELECT amount from branch_water_bill where branch_id = '" . $branch->branch_id . "' AND month_year = '" . $selected_month->format('m/Y') . "'");
				$data['water_bills'][$branch->branch_id] = 0;
				if (!is_null($electirc_bill)) {
					$data['water_bills'][$branch->branch_id] = $electirc_bill->amount;
				}
			}

			$data['title_info'] = 'Branch Collection Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/accounting/branch_collection_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function generate_rank()
	{
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			foreach ($_SESSION['profit_rank'] as $rank) {
				// Branch Operation Department
				$branch_incharge = $this->Dashboard_model->mysqlij("SELECT employee_id from employee where branch = '" . $rank['branch_id'] . "' AND department = '1806965207554226682' AND d_head = 1 AND status = 1");

				if (is_null($branch_incharge)) {
					echo json_encode(array('error' => true, 'message' => $rank['branch_name'] . " Branch In Charge Not Found!"));
					return;
				}

				$insert_data[] = array(
					'branch_id' => $rank['branch_id'],
					'branch_in_charge' => $branch_incharge->employee_id,
					'month_revenue' => $rank['month_revenue'],
					'month' => $_POST['month']
				);
			}
			$this->Dashboard_model->insert_batch('branches_revenue_rank', $insert_data);
			echo json_encode(array('error' => false, 'message' => "Successfull"));
			alert('success', 'Successfull!');
		}
	}



	//--- Start visitor_book_report---
	public function visitor_book_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Visitor Book Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/visitor_book_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end visitor_book_report---


	//--- Start communication_auto_sms_logs---
	public function communication_auto_sms_logs()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Auto SMS Logs Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/communication/communication_auto_sms_logs', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end communication_auto_sms_logs---


	//--- Start communication_member_corn_jobs---
	public function communication_member_corn_jobs()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Member Corn Job Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/communication/communication_member_corn_jobs', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end communication_member_corn_jobs---

	//--- Start communication_investor_corn_jobs---
	public function communication_investor_corn_jobs()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Investor Corn Job Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/communication/communication_investor_corn_jobs', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end communication_investor_corn_jobs---

	//--- Start communication_demo_investor_corn_jobs---
	public function communication_demo_investor_corn_jobs()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Demo Investor Corn Job Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/communication/communication_demo_investor_corn_jobs', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end communication_demo_investor_corn_jobs---

	//--- Start hrm_employee_wallet_report---
	public function hrm_employee_wallet_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Employee Wallet Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/hrm/hrm_employee_wallet_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end hrm_employee_wallet_report---

	//--- Start tracing_report_all_employee_secreenshot---
	public function tracing_report_all_employee_secreenshot()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'status' => '1',
				'branch_id' => $_SESSION['super_admin']['branch']
			);
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_category'] = $this->Dashboard_model->select('packages_category', $condition, 'id', 'asc', 'result');
			$data['title_info'] = 'Employee Activity Screenshot';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/tracing_report/tracing_report_all_employee_secreenshot', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end tracing_report_all_employee_secreenshot---	

	//--- Start tracing_report_employee_login_info---
	public function tracing_report_employee_login_info()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Employee Login Activity';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/tracing_report/tracing_report_employee_login_info', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end tracing_report_employee_login_info---

	//--- Start tracing_report_member_login_info---
	public function tracing_report_member_login_info()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Member Login Activity';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/tracing_report/tracing_report_member_login_info', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//--- end tracing_report_member_login_info---

	public function custom_report()
	{
		// $get_data_id_pass = $this->Dashboard_model->mysqlii('SELECT id,employee_id,password from employee_test_id_pass');
		// foreach($get_data_id_pass as $row){
		// 	$data_array = array(
		// 		'password' => $row->password
		// 	);
		// 	$this->Dashboard_model->update('employee', $data_array, $row->id);
		// }
		// exit;

		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_name'] = $this->Dashboard_model->mysqlii('SELECT sub_package_name from sub_package_category');
			// $data['package_name'] = $this->Dashboard_model->mysqlii('SELECT package_name from packages group by package_name');
			$data['title_info'] = 'Custom Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/custom_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	public function electricity_bill_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_name'] = $this->Dashboard_model->mysqlii('SELECT sub_package_name from sub_package_category');
			// $data['package_name'] = $this->Dashboard_model->mysqlii('SELECT package_name from packages group by package_name');
			$data['title_info'] = 'Income Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/electricity_bill_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function security_deposit_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_name'] = $this->Dashboard_model->mysqlii('SELECT sub_package_name from sub_package_category');
			// $data['package_name'] = $this->Dashboard_model->mysqlii('SELECT package_name from packages group by package_name');
			$data['title_info'] = 'Security Deposit Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/security_deposit_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	public function security_deposit_report_debit_credit()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition1 = array(
				'status' => '1'
			);
			$data['banches'] = $this->Dashboard_model->select('branches', $condition1, 'id', 'ASC', 'result');
			$data['package_name'] = $this->Dashboard_model->mysqlii('SELECT sub_package_name from sub_package_category');
			// $data['package_name'] = $this->Dashboard_model->mysqlii('SELECT package_name from packages group by package_name');
			$data['title_info'] = 'Security Deposit Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/security_deposit_debit_credit_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function hrm_report_increament_report($increament_color = null)
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['increament_color'] = $increament_color;
			$data['title_info'] = 'Employee Increament Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/hrm_report_increament_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function hrm_report_decreament_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Employee Decreament Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/hrm_report_decreament_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	/**
	 * Bkash Report
	 */
	function bkash_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if ($_SESSION['super_admin']['user_type'] == 'Super Admin' or $_SESSION['user_info']['department'] == '2270968637477766714') {
				$data['banches'] = $this->Dashboard_model->select('branches', array('status' => '1'), 'id', 'ASC', 'result');
			} else {
				$data['banches'] = $this->Dashboard_model->select('branches', array('status' => '1', 'branch_id' => $_SESSION['super_admin']['branch']), 'id', 'ASC', 'result');
			}
			$data['title_info'] = 'Bkash Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/bkash_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function duplicate_beds_report()
	{
		$branch = '';
		if ($_SESSION['super_admin']['user_type'] != 'Super Admin') {
			$branch = "AND branch_id = '" . $_SESSION['super_admin']['branch'] . "'";
		}
		$result = $this->Dashboard_model->mysqlii("SELECT * from member_directory
		where bed_id in (
			SELECT bed_id
			FROM member_directory
			WHERE status = 1
			GROUP BY bed_id
			HAVING COUNT(id) > 1
		) AND status = 1
		$branch
		ORDER BY `member_directory`.`bed_name`, `member_directory`.`branch_id` ASC");
		$html = '';
		if (!empty($result)) {
			$row_span = 0;
			for ($i = (count($result) - 1); $i >= 0; $i--) {
				if ($i == 0) {
					$row_span++;
					$html = '<tr>
								<td rowspan="' . $row_span . '">' . $result[$i]->branch_name . ': ' . $result[$i]->bed_name . '</td>
								<td>' . $result[$i]->full_name . '</td>
								<td>' . $result[$i]->card_number . '</td>
								<td>' . $result[$i]->package_name . '</td>
								<td>' . $result[$i]->phone_number . '</td>
							</tr>' . $html;
					continue;
				}

				if ($result[$i - 1]->branch_name . $result[$i - 1]->bed_id === $result[$i]->branch_name . $result[$i]->bed_id) {
					$html = '<tr>
								<td>' . $result[$i]->full_name . '</td>
								<td>' . $result[$i]->card_number . '</td>
								<td>' . $result[$i]->package_name . '</td>
								<td>' . $result[$i]->phone_number . '</td>
							</tr>' . $html;
					$row_span++;
					continue;
				}

				$row_span++;
				$html = '<tr>
							<td rowspan="' . $row_span . '">' . $result[$i]->branch_name . ': ' . $result[$i]->bed_name . '</td>
							<td>' . $result[$i]->full_name . '</td>
							<td>' . $result[$i]->card_number . '</td>
							<td>' . $result[$i]->package_name . '</td>
							<td>' . $result[$i]->phone_number . '</td>
						</tr>' . $html;
				$row_span = 0;
			}
		}
		echo $html;
	}

	public function seat_wise_occupency()
	{		
		$data['branches'] = $this->Dashboard_model->mysqlii("SELECT * from branches where status = 1");
		$data['branch'] = (isset($_POST['branch_id'])) ? $_POST['branch_id'] : '';
		$data['title_info'] = 'Seat Wise Occupency';
		$data['header'] = $this->load->view('include/header', '', TRUE);
		$data['nav'] = $this->load->view('include/nav', '', TRUE);
		$data['article'] = $this->load->view('template/reports/employee_review', $data, TRUE);
		$data['footer'] = $this->load->view('include/footer', '', TRUE);
		return $this->load->view('template/booking/seat_wise_occupency', $data);
	}

	public function employee_review()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if($_SESSION['super_admin']['user_type'] != 'Super Admin'){
				redirect(base_url('admin/login'));
			}
			$employee_ratings = $this->Dashboard_model->mysqlii("SELECT branches.branch_name, employee.department_name, employee.designation_name, employee.full_name,employee.photo, employee.employee_id, employee.id, avg(value) as avarage, count(*) as number_of_review from employee_rating INNER JOIN employee on employee.id = employee_rating.receiver_id INNER JOIN branches on branches.branch_id = employee.branch where employee_rating.month = '".date('m')."' AND employee_rating.year = '".date('Y')."' group by receiver_id");
			$data['branches'] = $this->Dashboard_model->mysqlii("SELECT * from branches where status = 1");
			$data['employee_ratings'] = $employee_ratings;
			$data['title_info'] = 'Employee Review';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/reports/employee_review', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function employee_review_show($month, $branch)
	{
		if($branch != 'all'){
			$employee_ratings = $this->Dashboard_model->mysqlii("SELECT branches.branch_name, employee.department_name, employee.designation_name, employee.full_name,employee.photo, employee.employee_id, employee.id, avg(value) as avarage, count(*) as number_of_review from employee_rating INNER JOIN employee on employee.id = employee_rating.receiver_id INNER JOIN branches on branches.branch_id = employee.branch where employee_rating.month = '".substr($month, 5, 2)."' AND employee_rating.year = '".substr($month, 0, 4)."' AND branches.id = '$branch' group by receiver_id");
		}else{
			$employee_ratings = $this->Dashboard_model->mysqlii("SELECT branches.branch_name, employee.department_name, employee.designation_name, employee.full_name,employee.photo, employee.employee_id, employee.id, avg(value) as avarage, count(*) as number_of_review from employee_rating INNER JOIN employee on employee.id = employee_rating.receiver_id INNER JOIN branches on branches.branch_id = employee.branch where employee_rating.month = '".substr($month, 5, 2)."' AND employee_rating.year = '".substr($month, 0, 4)."' group by receiver_id");
		}
		$html = "";
		if(empty($employee_ratings)){
			echo '	<tr>
						<td colspan=6 class="text-center" style="font-size: 17px">No Data</td>
					</tr>';
		}
		foreach($employee_ratings as $employee_rating){
			$html .= '<tr>';
			$html .= '<td><img src="'.base_url($employee_rating->photo).'" alt="" width="90px" style="border-radius: 5px;"></td>
			<td>'.$employee_rating->department_name.'</td>
			<td>'.$employee_rating->designation_name.'</td>
			<td>'.$employee_rating->branch_name.'</td>
			<td>'.$employee_rating->full_name . ' ('.$employee_rating->employee_id.')</td>
			<td>
				<div class="row justify-content-center text-center">
					<div class="col-md-12">
					<button onclick="get_review_details('.$employee_rating->id.')" data-target="#indevidual_review_modal" data-toggle="modal" class="btn btn-link"><span class="product-rating">'.round($employee_rating->avarage, 2).'</span><span>/5  </span></button>
					</div>
					<div class="col-md-12">';					
			$html .= '<span class="fa fa-star '.( ($employee_rating->avarage >= 1) ? 'checked' : '' ) .'"></span>';
			$html .= '<span class="fa fa-star '.( ($employee_rating->avarage >= 2) ? 'checked' : '' ).'""></span>';
			$html .= '<span class="fa fa-star '.( ($employee_rating->avarage >= 3) ? 'checked' : '' ).'""></span>';
			$html .= '<span class="fa fa-star '.( ($employee_rating->avarage >= 4) ? 'checked' : '' ).'""></span>';
			$html .= '<span class="fa fa-star '.( ($employee_rating->avarage >= 5) ? 'checked' : '' ).'""></span>';
			$html .=	'<span class="text-secondary" style="font-size: 00.9166em;">('.$employee_rating->number_of_review.')</span>
					</div>
				</div>
			</td>';
			$html .= '</tr>';
		}
		echo $html;
		return;
	}

	public function detailed_review($month)
	{
		$employee_ratings = $this->Dashboard_model->mysqlii(
		"SELECT member_directory.card_number, member_directory.full_name as member_name, member_directory.branch_name, member_directory.photo_avater, employee.department_name, employee.designation_name, employee.full_name as employee_name,employee.photo, employee.employee_id as emp_id, employee_rating.* from employee_rating
			LEFT JOIN employee on employee.id = employee_rating.employee_id AND employee_rating.user = 'Employee'
			LEFT JOIN member_directory on member_directory.id = employee_rating.employee_id AND employee_rating.user = 'Member'
			where employee_rating.month = '".substr($month, 5, 2)."' AND employee_rating.year = '".substr($month, 0, 4)."' AND employee_rating.receiver_id = ".$_GET['e_db_id']);
		$html = "";
		foreach($employee_ratings as $employee_rating){

			$html .= '<tr>';
			if($employee_rating->user == 'Employee'){
				$html .= '<td>Employee</td>';
				$html .= '<td><img src="'.base_url($employee_rating->photo).'" alt="" width="90px" style="border-radius: 5px;"></td>';
				$html .= '<td>';
				$html .= '<p class="m-0">'.$employee_rating->employee_name . ' ('.$employee_rating->emp_id.')</p>';
				$html .= '<p class="m-0">'.$employee_rating->department_name.'</p>';
				$html .= '<p class="m-0">'.$employee_rating->designation_name.'</p>';
				$html .= '</td>';
			}else{
				$html .= '<td>Member</td>';
				$html .= '<td><img src="'.base_url($employee_rating->photo_avater).'" alt="" width="90px" style="border-radius: 5px;"></td>';
				$html .= '<td>';
				$html .= '<p class="m-0">'.$employee_rating->member_name . ' ('.$employee_rating->card_number.')</p>';
				$html .= '<p class="m-0">'.$employee_rating->branch_name.'</p>';
				$html .= '</td>';
			}
			$rating = '';
			if(!empty($employee_rating->attachment)){
				$rating = '<a href="'.base_url($employee_rating->attachment).'" target="_blank">Attachment</a>';
			}
			$html .= '<td><p>'.$employee_rating->note . '</p>' . $rating . '</td>';
			$html .= '<td>
				<div class="row justify-content-center text-center">
					<div class="col-md-12">
						<span class="product-rating">'.round($employee_rating->value, 2).'</span><span>/5  </span>
					</div>
					<div class="col-md-12">';					
			$html .= '<span class="fa fa-star '.( ($employee_rating->value >= 1) ? 'checked' : '' ) .'"></span>';
			$html .= '<span class="fa fa-star '.( ($employee_rating->value >= 2) ? 'checked' : '' ).'""></span>';
			$html .= '<span class="fa fa-star '.( ($employee_rating->value >= 3) ? 'checked' : '' ).'""></span>';
			$html .= '<span class="fa fa-star '.( ($employee_rating->value >= 4) ? 'checked' : '' ).'""></span>';
			$html .= '<span class="fa fa-star '.( ($employee_rating->value >= 5) ? 'checked' : '' ).'""></span>';
			$html .=	'<span class="text-secondary" style="font-size: 00.9166em;"></span>
					</div>
				</div>
			</td>';
			$review_time = new DateTime($employee_rating->created_at);
			$html .= '<td>'.$review_time->format('d F, Y. h:i a').'</td>';
			$html .= '</tr>';
		}
		echo $html;
		return;
	}


	public function charsochar_error()
	{
		$data = array();
		$this->load->view('404', $data);
	}
	
	
	
	
}
