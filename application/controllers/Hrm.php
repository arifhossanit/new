<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Hrm extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->library('csvimport');
		$this->load->library('form_validation');
	}

	//==========================================EMPLOY SECTION======================================
	//---------Start adding Employ-------------
	public function add_employ()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['add_as_employee'])) {
				$condition = array('id' => $_POST['hidden_id']);
				$data['adse'] = $this->Dashboard_model->select('prebook_employee', $condition, 'id', 'DESC', 'row');
			}
			if (isset($_POST['add_employ'])) { //photo_avater
				if (!empty($_POST['photo_avater'])) {
					$photo = $_POST['photo_avater']; //image_upload('avater_photo','240','320','100');
				} else {
					$photo = '';
				}
				if (!empty($_POST['photo_avater_one'])) { //photo_avater_one
					$emergency_attachment_1 = $_POST['photo_avater_one'];
				} else {
					$emergency_attachment_1 = '';
				}
				if (!empty($_POST['photo_avater_two'])) { //photo_avater_two
					$emergency_attachment_2 = $_POST['photo_avater_two'];
				} else {
					$emergency_attachment_2 = '';
				}
				if (!empty($_FILES['first_doc']['name'])) {
					$first_doc = file_upload('first_doc');
				} else {
					$first_doc = '';
				}
				if (!empty($_FILES['second_doc']['name'])) {
					$second_doc = file_upload('second_doc');
				} else {
					$second_doc = '';
				}
				if (!empty($_FILES['forth_doc']['name'])) {
					$forth_doc = file_upload('forth_doc');
				} else {
					$forth_doc = '';
				}
				$total = count($_FILES['thired_doc']['name']);
				if ($total > 0 and !empty($_FILES['thired_doc']['name'][0])) {
					$newFilePathw = '';
					$variable = rand() * rand();
					for ($i = 0; $i < $total; $i++) {
						$tmpFilePath = $_FILES['thired_doc']['tmp_name'][$i];
						if ($tmpFilePath != "") {
							$newFilePath = "assets/uploads/" . $variable . '_' . $_FILES['thired_doc']['name'][$i];
							$newFilePathw .= "assets/uploads/" . $variable . '_' . $_FILES['thired_doc']['name'][$i] . ',';
							move_uploaded_file($tmpFilePath, $newFilePath);
						}
					}
					$thired_doc = $newFilePathw;
				} else {
					$thired_doc = '';
				}
				$rc = array('role_id' => $this->input->post('role'));
				$role_name = $this->Dashboard_model->select('roles', $rc, 'id', 'desc', 'row');

				$dc = array('designation_id' => $this->input->post('designation'));
				$designation_name = $this->Dashboard_model->select('designation', $dc, 'id', 'desc', 'row');

				$dcd = array('department_id' => $this->input->post('department'));
				$department_name = $this->Dashboard_model->select('department', $dcd, 'id', 'desc', 'row');

				$dgrd = array('grade_id' => $this->input->post('grade'));
				$grade_name = $this->Dashboard_model->select('manage_grade', $dgrd, 'id', 'desc', 'row');

				$generated_password = spc_chr(8);
				// if(!empty($this->input->post('qualification'))){
				// 	$qualification = implode(",",$this->input->post('qualification'));
				// }else{
				// 	$qualification = '';
				// }
				//$qualification = implode(",",$this->input->post('qualification'));

				$data = array(
					'id' => '',
					'employee_id' 					=> $this->input->post('employee_id'),
					'role' 							=> $this->input->post('role'),
					'role_name' 					=> $role_name->role_name,
					'designation' 					=> $this->input->post('designation'),
					'designation_name' 				=> $designation_name->designation_name,
					'department' 					=> $this->input->post('department'),
					'department_name' 				=> $department_name->department_name,
					'grade_id' 						=> $this->input->post('grade'),
					'grade_name' 					=> $grade_name->grade_name,
					'f_name' 						=> $this->input->post('f_name'),
					'l_name' 						=> $this->input->post('l_name'),
					'full_name' 					=> $this->input->post('f_name') . ' ' . $this->input->post('l_name'),
					'father_name' 					=> '',
					'mother_name' 					=> '',
					'gender' 						=> $this->input->post('gender'),
					'marital_status' 				=> $this->input->post('marital_status'),
					'date_of_birth' 				=> $this->input->post('date_of_birth'),
					'date_of_joining' 				=> $this->input->post('date_of_joining'),
					'blood_group' 					=> $this->input->post('blood_group'),
					'personal_Phone' 				=> $this->input->post('personal_Phone'),
					'email' 						=> $this->input->post('email'),
					'password' 						=> md5($generated_password),
					'photo' 						=> $photo,
					'Company_phone' 				=> $this->input->post('Company_phone'),
					'company_email' 				=> $this->input->post('company_email'),
					'nid_number' 					=> $this->input->post('nid_number'),
					'branch' 						=> $this->input->post('branch'),
					'emergency_contact_name' 		=> $this->input->post('emergency_name1'),
					'emergency_contact_relation' 	=> $this->input->post('emergency_relation1'),
					'emergency_no1' 				=> $this->input->post('emergency_no1'),
					'emergency_contact_name2'		=> $this->input->post('emergency_name2'),
					'emergency_contact_relation2'	=> $this->input->post('emergency_relation2'),
					'emergency_no2' 				=> $this->input->post('emergency_no2'),
					'emergency_attachment_1' 		=> $emergency_attachment_1,
					'emergency_attachment_2' 		=> $emergency_attachment_2,
					'current_address' 				=> $this->input->post('current_address'),
					'permanent_address' 			=> $this->input->post('permanent_address'),
					'qualification' 				=> '',
					'work_exp' 						=> '',
					'job_responsibilities' 			=> '',
					'note' 							=> $this->input->post('note'),
					'previus_company' 				=> '',
					'previus_designation' 			=> '',
					'reason_leave' 					=> '',
					'basic_salary' 					=> $this->input->post('basic_salary'),
					'mobile_allowance' 				=> $this->input->post('mobile_allowance'),
					'salary_pay_method' 			=> $this->input->post('salary_pay_method'),
					'contruct_type' 				=> $this->input->post('contruct_type'),
					'work_shift' 					=> $this->input->post('work_shift'),
					'assign_bed' 					=> $this->input->post('assign_bed'),
					'bank_account_title' 			=> $this->input->post('bank_account_title'),
					'bank_account_number' 			=> $this->input->post('bank_account_number'),
					'bank_name' 					=> $this->input->post('bank_name'),
					'bfsc_code' 					=> $this->input->post('bfsc_code'),
					'bank_branch_name' 				=> $this->input->post('bank_branch_name'),
					'account_type' 					=> $this->input->post('account_type'),
					'facebook' 						=> $this->input->post('facebook'),
					'twitter' 						=> $this->input->post('twitter'),
					'linkedin' 						=> $this->input->post('linkedin'),
					'instagram' 					=> $this->input->post('instagram'),
					'first_doc' 					=> $first_doc,
					'second_doc' 					=> $second_doc,
					'thired_doc' 					=> $thired_doc,
					'forth_doc' 					=> $forth_doc,
					'status' 						=> '1',
					'uploader_info' 				=> uploader_info(),
					'data' 							=> date('d/m/Y'),
					'extra_note'					=> '',
					'd_head'					    => '0',
					'religion'						=> $this->input->post('religion'),
					'card_number'					=> $this->input->post('card_number')
				);

				$wallet_data = array(
					'id' => '',
					'employee_id' => $this->input->post('employee_id'),
					'balance' => '0',
					'data' => date('d/m/Y')
				);

				$condition = array('employee_id' => $this->input->post('employee_id'));
				$check = $this->Dashboard_model->select('employee', $condition, 'id', 'ASC', 'row');
				if (empty($check->employee_id)) {
					$condition2 = array('email' => $this->input->post('email'));
					$check2 = $this->Dashboard_model->select('employee', $condition2, 'id', 'ASC', 'result');
					if (empty($check2->email)) {
						if (
							$this->Dashboard_model->insert('employee', $data) and
							$this->Dashboard_model->insert('employee_award_wallet', $wallet_data)
						) {
							$max_id = $this->Dashboard_model->mysqlij('SELECT max(id) as max_id from employee');
							
							if(!empty($_POST['probation_perido'])){
								if(!empty($_POST['probation_perido'])){
									$probationArr = explode(',',$_POST['probation_perido']);
									foreach($probationArr as $row){
										$date = new DateTime($row);
										$attendence = array(
											'e_db_id' => $max_id->max_id,
											'employee_id' => $this->input->post('employee_id'),
											'attendance' => 1,
											'checkin' => '08:00',
											'checkout' => '19:00',
											'note' => 'Observation Attendance',
											'days' => $date->format('j'),
											'month' => $date->format('n'),
											'years' => $date->format('y'),
											'data' => date('d/m/Y'),
											'date' => null,
											'sn' => ''
										);
										$this->Dashboard_model->insert('employee_attendence', $attendence);
									}
								}
							}
							foreach ($this->input->post('qualification') as $idx => $qualification) {
								if ($qualification != "") {
									$data = array(
										'id' => '',
										'level_of_education' 	=> $qualification,
										'passing_year' 			=> $this->input->post('passing_year')[$idx],
										'institution' 			=> $this->input->post('institution')[$idx],
										'board' 				=> $this->input->post('board')[$idx],
										'edu_group' 			=> $this->input->post('group')[$idx],
										'class' 				=> $this->input->post('class')[$idx],
										'gpa' 					=> $this->input->post('gpa')[$idx],
										'employee_id' 			=> $max_id->max_id
									);
									$this->Dashboard_model->insert('employee_education_qualification', $data);
								}
							}
							foreach ($this->input->post('company_name') as $idx => $company_name) {
								if ($company_name != "") {
									$data = array(
										'id' => '',
										'company_name' 		=> $company_name,
										'designation' 		=> $this->input->post('designation_emp')[$idx],
										'department' 		=> $this->input->post('department_emp')[$idx],
										'from_date' 		=> $this->input->post('from')[$idx],
										'to_date' 			=> $this->input->post('to')[$idx],
										'responsibility' 	=> $this->input->post('responsibility')[$idx],
										'leaving_reason' 	=> $this->input->post('leaving_reason')[$idx],
										'employee_id' 		=> $max_id->max_id
									);
									$this->Dashboard_model->insert('employment_history', $data);
								}
							}
							foreach ($this->input->post('training_name') as $idx => $training_name) {
								if ($training_name != "") {
									$data = array(
										'id' => '',
										'training_name' 	=> $training_name,
										'institution' 		=> $this->input->post('training_institution')[$idx],
										'place' 			=> $this->input->post('place')[$idx],
										'completion_year' 	=> $this->input->post('completion_year')[$idx],
										'duration' 			=> $this->input->post('duration')[$idx],
										'employee_id' 		=> $max_id->max_id
									);
									$this->Dashboard_model->insert('employee_professional_training', $data);
								}
							}
							foreach ($this->input->post('relation') as $idx => $relation) {
								if ($relation != "") {
									$data = array(
										'id' => '',
										'relation' 			=> $relation,
										'name' 				=> $this->input->post('name')[$idx],
										'occupation' 		=> $this->input->post('occupation')[$idx],
										'contact_number' 	=> $this->input->post('contact_number')[$idx],
										'contact_address' 	=> $this->input->post('contact_address')[$idx],
										'employee_id' 		=> $max_id->max_id
									);
									$this->Dashboard_model->insert('employee_family', $data);
								}
							}
							$message = emp_login($this->input->post('employee_id'), $generated_password, base_url());
							$full____name = $this->input->post('f_name') . ' ' . $this->input->post('l_name');
							$sms_body = 'NEWAYS EMPLOYEE LOGIN INFORMATION. Name: ' . $full____name . ' | Employee ID: ' . $this->input->post('employee_id') . ' | Password: ' . $generated_password . ' | Login URL: ' . base_url("admin") . '';
							if (sendsms($this->input->post('personal_Phone'), $sms_body)) {
								alert('success', 'Successfully Saved! Also sended SMS');
								redirect(current_url());
							} else {
								alert('danger', 'Something Wrong in SMS API SECTION! Please Try Again');
								redirect(current_url());
							}
							if (!empty($this->input->post('email'))) {
								if (main_email('NEWAYS EMPLOYEE LOGIN INFORMATION', $message, '', '', $this->input->post('email'), $full____name)) {
								} else {
									alert('danger', 'Something Wrong In Email Section! Please Try Again');
									redirect(current_url());
								}
							}
						} else {
							alert('danger', 'Something Wrong! Please Try Again');
							redirect(current_url());
						}
					} else {
						alert('warning', 'Employee Email All Ready Exixt! Please Try Again');
						redirect(current_url());
					}
				} else {
					alert('warning', 'EmployeeID All Ready Exixt! Please Try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['status_off'])) {
				$dac_date = explode('-', $this->input->post('deactive_Date'));
				$actual_date = $dac_date[2] . '/' . $dac_date[1] . '/' . $dac_date[0];
				$deactive_note = $this->input->post('extra_note');
				$d_emp = $this->Dashboard_model->select('employee', array('id' => $this->input->post('hidden_id')), 'id', 'ASC', 'row');

				foreach ($this->input->post('aproval_employee') as $row) {
					$a_emp = $this->Dashboard_model->select('employee', array('employee_id' => $row), 'id', 'ASC', 'row');
					$exit_insert_data[] = array(
						'id' 					=> '',
						'e_db_id' 				=> $a_emp->id,
						'employee_id' 			=> $a_emp->employee_id,
						'exit_emp_id' 			=> $d_emp->id,
						'exit_emp_employee_id' 	=> $d_emp->employee_id,
						'aproval' 				=> '0',
						'deactive_note' 		=> $deactive_note,
						'note' 					=> $actual_date,
						'status' 				=> '1',
						'uploader_info' 		=> uploader_info(),
						'data'					=> date('d/m/Y')
					);
				}
				$insert_data_hr = array(
					'id' 					=> '',
					'e_db_id' 				=> $d_emp->id,
					'employee_id' 			=> $d_emp->employee_id,
					'aproval' 				=> '0',
					'note' 					=> '',
					'status' 				=> '1',
					'uploader_info' 		=> uploader_info(),
					'data'					=> date('d/m/Y')
				);
				if (
					$this->Dashboard_model->insert_batch('exit_employee_chain_aproval', $exit_insert_data) and
					$this->Dashboard_model->insert('exit_employee_chain_hr', $insert_data_hr)
				) {
					alert('success', 'Save Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}


				/*
				$data = array(
					'status' 		=> '0',
					'data' 			=> $actual_date,
					'uploader_info' => uploader_info(),
					'extra_note'	=> $this->input->post('extra_note')
				);				
				
				if( $this->Dashboard_model->update('employee',$data,$this->input->post('hidden_id')) ){
					alert('success','Save Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				} 
				*/
			}

			if (isset($_POST['status_on'])) {
				$data = array(
					//'date_of_joining' 	=> date('d/m/Y'),
					'status' 			=> '1',
					'data' 				=> date('d/m/Y'),
					'extra_note'		=> ''
				);
				if ($this->Dashboard_model->update('employee', $data, $this->input->post('hidden_id'))) {
					alert('success', 'Update Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			//----------add roles-----
			if (isset($_POST['add_role'])) {
				$data = array(
					'id' 			=> '',
					'role_id' 		=> time() * rand(),
					'role_name' 	=> $this->input->post('role_name'),
					'note' 			=> '',
					'status' 		=> '1',
					'uploader_info' => uploader_info(),
					'data' 			=> date('d/m/Y')
				);
				if ($this->Dashboard_model->insert('roles', $data)) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			//----------end add roles----


			//----------add Designation-----
			if (isset($_POST['add_designation'])) {
				$data = array(
					'id' 					=> '',
					'designation_id' 		=> time() * rand(),
					'designation_name' 		=> $this->input->post('designation_name'),
					'note' 					=> '',
					'status' 				=> '1',
					'uploader_info' 		=> uploader_info(),
					'data' 					=> date('d/m/Y'),
					'a_bonus' 				=> '0'
				);
				if ($this->Dashboard_model->insert('designation', $data)) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			//----------end add Designation----

			//----------add department-----
			if (isset($_POST['add_department'])) {
				$data = array(
					'id' 				=> '',
					'department_id' 	=> time() * rand(),
					'department_name' 	=> $this->input->post('department_name'),
					'note' 				=> '',
					'status' 			=> '1',
					'uploader_info' 	=> uploader_info(),
					'data' 				=> date('d/m/Y')
				);
				if ($this->Dashboard_model->insert('department', $data)) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			//----------end add department----
			if (isset($_POST['delete_prebook_request'])) {
				$condition = array('id' => $this->input->post('hidden_id'));
				$check = $this->Dashboard_model->select('prebook_employee', $condition, 'id', 'DESC', 'row');
				if (!empty($check->personal_Phone)) {
					$message = 'Dear, ' . $check->full_name . ', Your Employee Pre Registration is rejected! Please Contact With HR Department. Thank You';
					if (sendsms('$check->personal_Phone', '')) {
						if ($this->Dashboard_model->delete('prebook_employee', $this->input->post('hidden_id'))) {
							alert('success', 'Delete Successfully!');
							redirect('admin/hrm/employee-prebook-request');
						} else {
							alert('danger', 'Something Wrong! Please try Again');
							redirect('admin/hrm/employee-prebook-request');
						}
					} else {
						alert('warning', 'Something Wrong in SMS section! Delete From Database');
						redirect('admin/hrm/employee-prebook-request');
					}
				} else {
					alert('warning', 'Phone Number Not Found. Delete From Database');
					redirect('admin/hrm/employee-prebook-request');
				}
			}


			$condition = array('status' => '1');
			$data['role'] = $this->Dashboard_model->select('roles', $condition, 'id', 'ASC', 'result');
			$data['designation'] = $this->Dashboard_model->select('designation', $condition, 'id', 'ASC', 'result');
			$data['department'] = $this->Dashboard_model->select('department', $condition, 'id', 'ASC', 'result');
			$data['grade'] = $this->Dashboard_model->select('manage_grade', $condition, 'id', 'ASC', 'result');
			$data['banches'] = $this->Dashboard_model->select('branches', $condition, 'id', 'ASC', 'result');
			$data['table'] = $this->Dashboard_model->select('employee', $condition, 'id', 'ASC', 'result');
			$data['auto_employee_id'] = $this->Dashboard_model->select('employee', $condition, 'employee_id', 'DESC', 'row');

			$data['title_info'] = 'Employee, Roles, Designation & Dipartment Management';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/add_employ', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function delete_employee_informations()
	{
	}

	public function edit_employee()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			if (isset($_POST['update_employee'])) {
				$where = array('id' => $this->input->post('update_id'));
				$attasted_data = $this->Dashboard_model->select('employee', $where, 'id', 'desc', 'row');

				if (!empty($_FILES['avater_photo']['name'])) {
					$photo = image_upload('avater_photo', '240', '320', '100');
				} else {
					$photo = $attasted_data->photo;
				}
				if (!empty($_FILES['emergency_attachment_1']['name'])) {
					$emergency_attachment_1 = file_upload('emergency_attachment_1');
				} else {
					$emergency_attachment_1 = $attasted_data->emergency_attachment_1;
				}
				if (!empty($_FILES['emergency_attachment_2']['name'])) {
					$emergency_attachment_2 = file_upload('emergency_attachment_2');
				} else {
					$emergency_attachment_2 = $attasted_data->emergency_attachment_2;
				}
				if (!empty($_FILES['first_doc']['name'])) {
					$first_doc = file_upload('first_doc');
				} else {
					$first_doc = $attasted_data->first_doc;
				}
				if (!empty($_FILES['second_doc']['name'])) {
					$second_doc = file_upload('second_doc');
				} else {
					$second_doc = $attasted_data->second_doc;
				}
				if (!empty($_FILES['forth_doc']['name'])) {
					$forth_doc = file_upload('forth_doc');
				} else {
					$forth_doc = $attasted_data->forth_doc;
				}
				$total = count($_FILES['thired_doc']['name']);
				if ($total > 0 and !empty($_FILES['thired_doc']['name'][0])) {
					$newFilePathw = '';
					$variable = rand() * rand();
					for ($i = 0; $i < $total; $i++) {
						$tmpFilePath = $_FILES['thired_doc']['tmp_name'][$i];
						if ($tmpFilePath != "") {
							$newFilePath = "assets/uploads/" . $variable . '_' . $_FILES['thired_doc']['name'][$i];
							$newFilePathw .= "assets/uploads/" . $variable . '_' . $_FILES['thired_doc']['name'][$i] . ',';
							move_uploaded_file($tmpFilePath, $newFilePath);
						}
					}
					$thired_doc = $newFilePathw;
				} else {
					$thired_doc = $attasted_data->thired_doc;
				}
				$rc = array('role_id' => $this->input->post('role'));
				$role_name = $this->Dashboard_model->select('roles', $rc, 'id', 'desc', 'row');

				$dc = array('designation_id' => $this->input->post('designation'));
				$designation_name = $this->Dashboard_model->select('designation', $dc, 'id', 'desc', 'row');

				$dcd = array('department_id' => $this->input->post('department'));
				$department_name = $this->Dashboard_model->select('department', $dcd, 'id', 'desc', 'row');

				$dgrd = array('grade_id' => $this->input->post('grade'));
				$grade_name = $this->Dashboard_model->select('manage_grade', $dgrd, 'id', 'desc', 'row');

				// if(!empty($this->input->post('qualification'))){
				// 	$qualification = implode(",",$this->input->post('qualification'));
				// }else{
				// 	$qualification = '';
				// }				

				$data = array(
					'id' 							=> $this->input->post('update_id'),
					'employee_id' 					=> $this->input->post('employee_id'),
					'role' 							=> $this->input->post('role'),
					'role_name' 					=> $role_name->role_name,
					'designation' 					=> $this->input->post('designation'),
					'designation_name' 				=> $designation_name->designation_name,
					'department' 					=> $this->input->post('department'),
					'department_name' 				=> $department_name->department_name,
					'grade_id' 						=> $this->input->post('grade'),
					'grade_name' 					=> $grade_name->grade_name,
					'f_name' 						=> $this->input->post('f_name'),
					'l_name' 						=> $this->input->post('l_name'),
					'full_name' 					=> $this->input->post('f_name') . ' ' . $this->input->post('l_name'),
					'father_name' 					=> $this->input->post('father_name'),
					'mother_name' 					=> $this->input->post('mother_name'),
					'gender' 						=> $this->input->post('gender'),
					'marital_status' 				=> $this->input->post('marital_status'),
					'date_of_birth' 				=> $this->input->post('date_of_birth'),
					'date_of_joining' 				=> $this->input->post('date_of_joining'),
					'blood_group' 					=> $this->input->post('blood_group'),
					'personal_Phone' 				=> $this->input->post('personal_Phone'),
					'email' 						=> $this->input->post('email'),
					'photo' 						=> $photo,
					'Company_phone' 				=> $this->input->post('Company_phone'),
					'company_email' 				=> $this->input->post('company_email'),
					'nid_number' 					=> $this->input->post('nid_number'),
					'branch' 						=> $this->input->post('branch'),
					'emergency_contact_name' 		=> $this->input->post('emergency_name1'),
					'emergency_contact_relation' 	=> $this->input->post('emergency_relation1'),
					'emergency_no1' 				=> $this->input->post('emergency_no1'),
					'emergency_contact_name2'		=> $this->input->post('emergency_name2'),
					'emergency_contact_relation2'	=> $this->input->post('emergency_relation2'),
					'emergency_no2' 				=> $this->input->post('emergency_no2'),
					'emergency_attachment_1' 		=> $emergency_attachment_1,
					'emergency_attachment_2' 		=> $emergency_attachment_2,
					'current_address' 				=> $this->input->post('current_address'),
					'permanent_address' 			=> $this->input->post('permanent_address'),
					// 'qualification' 				=> $qualification,
					'work_exp' 						=> $this->input->post('work_exp'),
					'job_responsibilities' 			=> $this->input->post('job_responsibilities'),
					'note' 							=> $this->input->post('note'),
					'previus_company' 				=> $this->input->post('previus_company'),
					'previus_designation' 			=> $this->input->post('previus_designation'),
					'reason_leave' 					=> $this->input->post('reason_leave'),
					'basic_salary' 					=> $this->input->post('basic_salary'),
					'mobile_allowance' 				=> $this->input->post('mobile_allowance'),
					'salary_pay_method' 			=> $this->input->post('salary_pay_method'),
					'contruct_type' 				=> $this->input->post('contruct_type'),
					'work_shift' 					=> $this->input->post('work_shift'),
					'assign_bed' 					=> $this->input->post('assign_bed'),
					'bank_account_title' 			=> $this->input->post('bank_account_title'),
					'bank_account_number' 			=> $this->input->post('bank_account_number'),
					'bank_name' 					=> $this->input->post('bank_name'),
					'bfsc_code' 					=> $this->input->post('bfsc_code'),
					'bank_branch_name' 				=> $this->input->post('bank_branch_name'),
					'account_type' 					=> $this->input->post('account_type'),
					'facebook' 						=> $this->input->post('facebook'),
					'twitter' 						=> $this->input->post('twitter'),
					'linkedin' 						=> $this->input->post('linkedin'),
					'instagram' 					=> $this->input->post('instagram'),
					'first_doc' 					=> $first_doc,
					'second_doc' 					=> $second_doc,
					'thired_doc' 					=> $thired_doc,
					'forth_doc' 					=> $forth_doc,
					'status' 						=> $attasted_data->status,
					'uploader_info' 				=> uploader_info(),
					'religion'						=> $this->input->post('religion')
				);

				$check_wallet_data = $this->Dashboard_model->select('employee_award_wallet', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				if (!empty($check_wallet_data->employee_id)) {
				} else {
					$wallet_data = array(
						'id' => '',
						'employee_id' => $this->input->post('employee_id'),
						'balance' => '0',
						'data' => date('d/m/Y')
					);
					$this->Dashboard_model->insert('employee_award_wallet', $wallet_data);
				}
				// var_dump($this->input->post('qualification'));
				// print_r($_POST);
				// exit();
				if ($this->Dashboard_model->update('employee', $data, $this->input->post('update_id'))) {
					foreach ($this->input->post('qualification') as $idx => $qualification) {
						if ($qualification != "") {
							if ($this->input->post('education_id')[$idx] == 'new') {
								$data = array(
									'id' => '',
									'level_of_education' 	=> $qualification,
									'passing_year' 			=> $this->input->post('passing_year')[$idx],
									'institution' 			=> $this->input->post('institution')[$idx],
									'board' 				=> $this->input->post('board')[$idx],
									'edu_group' 			=> $this->input->post('group')[$idx],
									'class' 				=> $this->input->post('class')[$idx],
									'gpa' 					=> $this->input->post('gpa')[$idx],
									'employee_id' 			=> $this->input->post('update_id')
								);
								$this->Dashboard_model->insert('employee_education_qualification', $data);
							} else {
								$data = array(
									'level_of_education' 	=> $qualification,
									'passing_year' 			=> $this->input->post('passing_year')[$idx],
									'institution' 			=> $this->input->post('institution')[$idx],
									'board' 				=> $this->input->post('board')[$idx],
									'edu_group' 			=> $this->input->post('group')[$idx],
									'class' 				=> $this->input->post('class')[$idx],
									'gpa' 					=> $this->input->post('gpa')[$idx]
								);
								$this->Dashboard_model->update('employee_education_qualification', $data, $this->input->post('education_id')[$idx]);
							}
						}
					}
					foreach ($this->input->post('company_name') as $idx => $company_name) {
						if ($company_name != "") {
							if ($this->input->post('history_id')[$idx] == 'new') {
								$data = array(
									'id' => '',
									'company_name' 		=> $company_name,
									'designation' 		=> $this->input->post('designation_emp')[$idx],
									'department' 		=> $this->input->post('department_emp')[$idx],
									'from_date' 		=> $this->input->post('from')[$idx],
									'to_date' 			=> $this->input->post('to')[$idx],
									'responsibility' 	=> $this->input->post('responsibility')[$idx],
									'leaving_reason' 	=> $this->input->post('leaving_reason')[$idx],
									'employee_id' 		=> $this->input->post('update_id')
								);
								$this->Dashboard_model->insert('employment_history', $data);
							} else {
								$data = array(
									'company_name' 		=> $company_name,
									'designation' 		=> $this->input->post('designation_emp')[$idx],
									'department' 		=> $this->input->post('department_emp')[$idx],
									'from_date' 		=> $this->input->post('from')[$idx],
									'to_date' 			=> $this->input->post('to')[$idx],
									'responsibility' 	=> $this->input->post('responsibility')[$idx],
									'leaving_reason' 	=> $this->input->post('leaving_reason')[$idx],
								);
								$this->Dashboard_model->update('employment_history', $data, $this->input->post('history_id')[$idx]);
							}
						}
					}
					foreach ($this->input->post('training_name') as $idx => $training_name) {
						if ($training_name != "") {
							if ($this->input->post('training_id')[$idx] == 'new') {
								$data = array(
									'id' => '',
									'training_name' 	=> $training_name,
									'institution' 		=> $this->input->post('training_institution')[$idx],
									'place' 			=> $this->input->post('place')[$idx],
									'completion_year' 	=> $this->input->post('completion_year')[$idx],
									'duration' 			=> $this->input->post('duration')[$idx],
									'employee_id' 		=> $this->input->post('update_id')
								);
								$this->Dashboard_model->insert('employee_professional_training', $data);
							} else {
								$data = array(
									'training_name' 	=> $training_name,
									'institution' 		=> $this->input->post('training_institution')[$idx],
									'place' 			=> $this->input->post('place')[$idx],
									'completion_year' 	=> $this->input->post('completion_year')[$idx],
									'duration' 			=> $this->input->post('duration')[$idx],
								);
								$this->Dashboard_model->update('employee_professional_training', $data, $this->input->post('training_id')[$idx]);
							}
						}
					}
					foreach ($this->input->post('relation') as $idx => $relation) {
						if ($relation != "") {
							if ($this->input->post('relation_id')[$idx] == 'new') {
								$data = array(
									'id' => '',
									'relation' 			=> $relation,
									'name' 				=> $this->input->post('name')[$idx],
									'occupation' 		=> $this->input->post('occupation')[$idx],
									'contact_number' 	=> $this->input->post('contact_number')[$idx],
									'contact_address' 	=> $this->input->post('contact_address')[$idx],
									'employee_id' 		=> $this->input->post('update_id')
								);
								$this->Dashboard_model->insert('employee_family', $data);
							} else {
								$data = array(
									'relation' 			=> $relation,
									'name' 				=> $this->input->post('name')[$idx],
									'occupation' 		=> $this->input->post('occupation')[$idx],
									'contact_number' 	=> $this->input->post('contact_number')[$idx],
									'contact_address' 	=> $this->input->post('contact_address')[$idx],
								);
								$this->Dashboard_model->update('employee_family', $data, $this->input->post('relation_id')[$idx]);
							}
						}
					}
					alert('success', 'Successfully Saved!');
					redirect('admin/employ-directory');
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect('admin/employ-directory');
				}
			}

			if (isset($_POST['delete_employee'])) {
				// print_r('insert edit');
				// exit();
				if (isset($_POST['delete_information_table'])) {
					$this->Dashboard_model->delete($_POST['delete_information_table'], $this->input->post('information_table_id'));
				}
				// $where = array('id' => $this->input->post('hidden_id'));
				// $data['edit'] = $this->Dashboard_model->select('employee',$where,'id','desc','row');
				// $data['education_qualification'] = $this->Dashboard_model->mysqlii("SELECT * from employee_education_qualification where employee_id = '".$this->input->post('hidden_id')."'");
				// $data['employment_history'] = $this->Dashboard_model->mysqlii("SELECT * from employment_history where employee_id = '".$this->input->post('hidden_id')."'");
				// $data['professional_training'] = $this->Dashboard_model->mysqlii("SELECT * from employee_professional_training where employee_id = '".$this->input->post('hidden_id')."'");
				// $data['employee_family'] = $this->Dashboard_model->mysqlii("SELECT * from employee_family where employee_id = '".$this->input->post('hidden_id')."'");
			}

			if (isset($_POST['delete'])) {
				if ($this->Dashboard_model->delete('employee', $this->input->post('hidden_id'))) {
					alert('success', 'Delete Successfully!');
					redirect('admin/employ-directory');
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect('admin/employ-directory');
				}
			}
			$where = array('id' => $this->input->post('hidden_id'));
			$data['edit'] = $this->Dashboard_model->select('employee', $where, 'id', 'desc', 'row');
			$data['education_qualification'] = $this->Dashboard_model->mysqlii("SELECT * from employee_education_qualification where employee_id = '" . $this->input->post('hidden_id') . "'");
			$data['employment_history'] = $this->Dashboard_model->mysqlii("SELECT * from employment_history where employee_id = '" . $this->input->post('hidden_id') . "'");
			$data['professional_training'] = $this->Dashboard_model->mysqlii("SELECT * from employee_professional_training where employee_id = '" . $this->input->post('hidden_id') . "'");
			$data['employee_family'] = $this->Dashboard_model->mysqlii("SELECT * from employee_family where employee_id = '" . $this->input->post('hidden_id') . "'");

			$condition = array('status' => '1');
			$data['role'] = $this->Dashboard_model->select('roles', $condition, 'id', 'ASC', 'result');
			$data['designation'] = $this->Dashboard_model->select('designation', $condition, 'id', 'ASC', 'result');
			$data['department'] = $this->Dashboard_model->select('department', $condition, 'id', 'ASC', 'result');
			$data['grade'] = $this->Dashboard_model->select('manage_grade', $condition, 'id', 'ASC', 'result');
			$data['banches'] = $this->Dashboard_model->select('branches', $condition, 'id', 'ASC', 'result');

			$data['title_info'] = 'Employee Management';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/edit_employee', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//---------End adding Employ-------------

	//---------Start exit Employ directory-------------
	public function exit_employee()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			if (isset($_POST['status_off'])) {
				$data = array(
					'id' 		=> $this->input->post('hidden_id'),
					'status' 	=> '0',
					'data' 		=> date('d/m/Y')
				);
				if ($this->Dashboard_model->update('employee', $data, $this->input->post('hidden_id'))) {
					alert('success', 'Update Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}


			if (isset($_POST['status_on'])) {
				$data = array(
					'id' 		=> $this->input->post('hidden_id'),
					'status' 	=> '1',
					'data' 		=> date('d/m/Y')
				);
				if ($this->Dashboard_model->update('employee', $data, $this->input->post('hidden_id'))) {
					alert('success', 'Update Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			$condition = array('status' => '0');
			$data['table'] = $this->Dashboard_model->mysqlii("SELECT * FROM employee WHERE status = '0' ORDER BY STR_TO_DATE(data,'%d/%m/%Y') DESC");

			$data['title_info'] = 'Exit Employee Directory';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/exit_employee', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	//end exit employ-directory

	//---------Start Manage Roles-------------
	public function manage_roles()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => '',
					'role_id' => time() * rand(),
					'role_name' => $this->input->post('role_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('role_name');
				if ($this->Dashboard_model->chaeck_data_b('roles', 'role_name', $check)) {
					alert('warning', '' . $check . ' is already exixt! Please try again');
					redirect(current_url());
				} else {
					if ($this->Dashboard_model->insert('roles', $data)) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}

			if (isset($_POST['update'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'role_name' => $this->input->post('role_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if ($this->Dashboard_model->update('roles', $data, $this->input->post('update_id'))) {
					alert('success', 'Update Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['edit'])) {
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('roles', $where, 'id', 'desc', 'row');
			}

			if (isset($_POST['delete'])) {
				if ($this->Dashboard_model->delete('roles', $this->input->post('hidden_id'))) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST["delete_id"])) {
				$id = implode(',', $_POST["delete_id"]);
				if ($this->Dashboard_model->delete_batch('roles', $id)) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			$condition = array('status' => '1');

			$data['table'] = $this->Dashboard_model->select('roles', '', 'id', 'asc', 'result');

			$data['title_info'] = 'Roles & Permission Management';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/manage_roles', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	//---------End Manage Roles-------------

	//---------Start Manage department-------------
	public function manage_department()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => '',
					'department_id' => time() * rand(),
					'department_name' => $this->input->post('department_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('department_name');
				if ($this->Dashboard_model->chaeck_data_b('department', 'department_name', $check)) {
					alert('warning', '' . $check . ' is already exixt! Please try again');
					redirect(current_url());
				} else {
					if ($this->Dashboard_model->insert('department', $data)) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}

			if (isset($_POST['update'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'department_name' => $this->input->post('department_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if ($this->Dashboard_model->update('department', $data, $this->input->post('update_id'))) {
					alert('success', 'Update Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['edit'])) {
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('department', $where, 'id', 'desc', 'row');
			}

			if (isset($_POST['delete'])) {
				if ($this->Dashboard_model->delete('department', $this->input->post('hidden_id'))) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST["delete_id"])) {
				$id = implode(',', $_POST["delete_id"]);
				if ($this->Dashboard_model->delete_batch('department', $id)) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			$condition = array('status' => '1');
			$data['table'] = $this->Dashboard_model->select('department', '', 'serial', 'asc', 'result');

			$data['title_info'] = 'Department Management';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/manage_department', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	//---------End Manage department-------------

	//---------Start Manage designation-------------
	public function manage_designation()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => '',
					'designation_id' 		=> time() * rand(),
					'designation_name' 		=> $this->input->post('designation_name'),
					'note' 					=> $this->input->post('note'),
					'status' 				=> $status,
					'uploader_info' 		=> uploader_info(),
					'data' 					=> date('d/m/Y'),
					'a_bonus' 				=> '0'
				);
				$check = $this->input->post('designation_name');
				if ($this->Dashboard_model->chaeck_data_b('designation', 'designation_name', $check)) {
					alert('warning', '' . $check . ' is already exixt! Please try again');
					redirect(current_url());
				} else {
					if ($this->Dashboard_model->insert('designation', $data)) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}

			if (isset($_POST['update'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				if (isset($_POST['d_head'])) {
					$d_head = 1;
				} else {
					$d_head = 0;
				}
				$data = array(
					'id' 					=> $this->input->post('update_id'),
					'designation_name' 		=> $this->input->post('designation_name'),
					'note' 					=> $this->input->post('note'),
					'status' 				=> $status,
					'uploader_info' 		=> uploader_info(),
					'data' 					=> date('d/m/Y')
				);
				if ($this->Dashboard_model->update('designation', $data, $this->input->post('update_id'))) {
					alert('success', 'Update Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['edit'])) {
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('designation', $where, 'id', 'desc', 'row');
			}

			if (isset($_POST['delete'])) {
				if ($this->Dashboard_model->delete('designation', $this->input->post('hidden_id'))) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST["delete_id"])) {
				$id = implode(',', $_POST["delete_id"]);
				if ($this->Dashboard_model->delete_batch('designation', $id)) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			$condition = array('status' => '1');
			$data['table'] = $this->Dashboard_model->select('designation', '', 'serial', 'asc', 'result');

			$data['title_info'] = 'Designation Management';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/manage_designation', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	//---------End Manage designation-------------

	//---------Start Manage manage_grade_intro-------------
	public function manage_grade_intro()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => '',
					'grade_id' => time() * rand(),
					'grade_name' => $this->input->post('grade_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('grade_name');
				if ($this->Dashboard_model->chaeck_data_b('manage_grade', 'grade_name', $check)) {
					alert('warning', '' . $check . ' is already exixt! Please try again');
					redirect(current_url());
				} else {
					if ($this->Dashboard_model->insert('manage_grade', $data)) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}

			if (isset($_POST['update'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'grade_id' => time() * rand(),
					'grade_name' => $this->input->post('grade_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if ($this->Dashboard_model->update('manage_grade', $data, $this->input->post('update_id'))) {
					alert('success', 'Update Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['edit'])) {
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('manage_grade', $where, 'id', 'desc', 'row');
			}

			if (isset($_POST['delete'])) {
				if ($this->Dashboard_model->delete('manage_grade', $this->input->post('hidden_id'))) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST["delete_id"])) {
				$id = implode(',', $_POST["delete_id"]);
				if ($this->Dashboard_model->delete_batch('manage_grade', $id)) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			$condition = array('status' => '1');
			$data['table'] = $this->Dashboard_model->select('manage_grade', '', 'serial', 'asc', 'result');

			$data['title_info'] = 'Grade Management';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/manage_grade_intro', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	//---------End Manage manage_grade_intro-------------

	//---------Start Manage fingure_missing_reason-------------
	public function fingure_missing_reason()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => '',
					'reason_id' => time() * rand(),
					'reason_name' => $this->input->post('reason_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				$check = $this->input->post('reason_name');
				if ($this->Dashboard_model->chaeck_data_b('fingure_missing_reason', 'reason_name', $check)) {
					alert('warning', '' . $check . ' is already exixt! Please try again');
					redirect(current_url());
				} else {
					if ($this->Dashboard_model->insert('fingure_missing_reason', $data)) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}

			if (isset($_POST['update'])) {
				if (isset($_POST['status'])) {
					$status = 1;
				} else {
					$status = 0;
				}
				$data = array(
					'id' => $this->input->post('update_id'),
					'reason_id' => time() * rand(),
					'reason_name' => $this->input->post('reason_name'),
					'note' => $this->input->post('note'),
					'status' => $status,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if ($this->Dashboard_model->update('fingure_missing_reason', $data, $this->input->post('update_id'))) {
					alert('success', 'Update Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['edit'])) {
				$where = array('id' => $this->input->post('hidden_id'));
				$data['edit'] = $this->Dashboard_model->select('fingure_missing_reason', $where, 'id', 'desc', 'row');
			}

			if (isset($_POST['delete'])) {
				if ($this->Dashboard_model->delete('fingure_missing_reason', $this->input->post('hidden_id'))) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST["delete_id"])) {
				$id = implode(',', $_POST["delete_id"]);
				if ($this->Dashboard_model->delete_batch('fingure_missing_reason', $id)) {
					alert('success', 'Delete Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			$condition = array('status' => '1');
			$data['table'] = $this->Dashboard_model->select('fingure_missing_reason', '', 'serial', 'asc', 'result');

			$data['title_info'] = 'Fingure Missing Reason';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/fingure_missing_reason', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	//---------End Manage fingure_missing_reason-------------





	//---------Start hrm attendance form-------------
	public function attendance_form()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['search'])) {
				if (!empty($this->input->post('branch_id')) and !empty($this->input->post('department_id'))) {
					$filter = array(
						'branch' => $this->input->post('branch_id'),
						'department' => $this->input->post('department_id'),
						'status' => '1'
					);
				} else if (!empty($this->input->post('branch_id'))) {
					$filter = array(
						'branch' => $this->input->post('branch_id'),
						'status' => '1'
					);
				} else if (!empty($this->input->post('department_id'))) {
					$filter = array(
						'department' => $this->input->post('department_id'),
						'status' => '1'
					);
				} else {
					$filter = array(
						'status' => '1'
					);
				}
				$data['table'] = $this->Dashboard_model->select('employee', $filter, 'id', 'ASC', 'result');
			}
			if (isset($_POST['save'])) {
				foreach ($this->input->post('db_id') as $row => $value) {
					if (!empty($this->input->post('attendence')[$row])) {
						$data[] = array(
							'id' => '',
							'e_db_id' => $this->input->post('db_id')[$row],
							'employee_id' => $this->input->post('employee_id')[$row],
							'attendance' => $this->input->post('attendence')[$row],
							'checkin' => $this->input->post('checkin')[$row],
							'checkout' => $this->input->post('checkout')[$row],
							'note' => $this->input->post('note')[$row],
							'days' => date('d'),
							'month' => date('m'),
							'years' => date('y'),
							'uploader_info' => uploader_info(),
							'data' => date('m/d/Y')
						);
					}
				}
				if ($this->Dashboard_model->insert_batch('employee_attendence', $data)) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['import'])) {
				$error = 0;
				$allowedFileType = ['application/vnd.ms-excel', 'text/csv', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
				if (in_array($_FILES["xlsx_sheet"]["type"], $allowedFileType)) {
					$filename 		= $_FILES["xlsx_sheet"]["name"];
					$file_tmp 		= $_FILES["xlsx_sheet"]["tmp_name"];
					$file_ext 		= substr($filename, strripos($filename, '.'));
					$newfilename 	= $filename . '_IMPORTED_FILES_' . date('d_m_Y') . '_' . rand() * time() . '_' . time() * rand() . $file_ext;
					$file_path 		= 'assets/uploads/imported_document/' . $newfilename;
					move_uploaded_file($file_tmp, $file_path);
					if ($this->csvimport->get_array($file_path)) {
						$csv_array = $this->csvimport->get_array($file_path);
						foreach ($csv_array as $row) {
							if (!empty($row['employee'])) {
								$check_employee_id = $this->Dashboard_model->select('employee', array('employee_id' => $row['employee'], 'status' => 1), 'id', 'desc', 'row');
								//if(!empty($check_employee_id->employee_id) AND $check_employee_id->employee_id == $row['employee']){
								$dt_data = explode(" ", $row['hour']);
								$date = $dt_data[0];
								$time = $dt_data[1];
								$ds = explode("/", $date);
								$years = substr($ds[2], 2);
								$check_date = $this->Dashboard_model->mysqlii("SELECT * FROM employee_attendence WHERE employee_id = '" . $row['employee'] . "' and days = '" . $ds[1] . "' AND month = '" . $ds[0] . "' AND years = '" . $years . "'");
								if (empty($check_date)) {
									$data[] = array(
										'id' => '',
										'e_db_id' => $check_employee_id->id,
										'employee_id' => $row['employee'],
										'attendance' => '1',
										'checkin' => $time,
										'checkout' => '',
										'note' => '',
										'days' => $ds[1],
										'month' => $ds[0],
										'years' => $years,
										'uploader_info' => uploader_info(),
										'data' => date('m/d/Y')
									);
								}
								$error = 0;
								//}else{
								//	$error = 9;
								//}							
							} else {
								$error = 35;
							}
						}
					}
					if ($error == 35) {
						alert('danger', 'Document Header Names Are not perfect');
						redirect(current_url());
					} else {
						if ($error == 9) {
							alert('danger', 'Employee ID Not Found');
							redirect(current_url());
						} else {
							if ($this->Dashboard_model->insert_batch('employee_attendence', $data)) {
								alert('success', 'Successfully Saved!');
								redirect(current_url());
							} else {
								alert('danger', 'Something Wrong! Please Try Again');
								redirect(current_url());
							}
						}
					}
				} else {
					alert('warning', 'File Formate Not Supported! Please try again');
					redirect(current_url());
				}
			}

			$condition = array('status' => '1');
			$data['department'] = $this->Dashboard_model->select('department', $condition, 'id', 'ASC', 'result');
			$data['banches'] = $this->Dashboard_model->select('branches', $condition, 'id', 'ASC', 'result');
			$data['title_info'] = 'Employee Attendance Form';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/attendance/attendance_form', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	//end hrm attendance form

	//---------Start hrm missing_attencance_form-------------
	public function missing_attencance_form()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['get_attendance'])) {
				$attendance = $this->input->post('attendance');
				$employee_id = $this->input->post('employee_id');
				$error = false;
				if ($attendance == 'absent') {
					$get_employees = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
					$e_d = explode('/', $this->input->post('attendate_date'));
					$how_many_days = $this->input->post('how_many_days');
					$start_date_obj = new DateTime($this->input->post('attendate_date'));
					for ($i = 1; $i <= $how_many_days; $i++) {
						$missing_logs = array(
							'id' => '',
							'employee_id' => $employee_id,
							'attendance_date' => $start_date_obj->format('Y/m/d'),
							'note' => 'Marking Absent',
							'status' => '1',
							'uploader_info' => uploader_info(),
							'data' => date('d/m/Y')
						);
						$e_d = explode('/', $start_date_obj->format('Y/m/d'));
						if (
							$this->Dashboard_model->mysqliq("DELETE from employee_attendence where e_db_id = '" . $get_employees->id . "' AND days = '" . intval($e_d[2]) . "' AND month = '" . intval($e_d[1]) . "' AND years = '" . substr($e_d[0], 2, 2) . "'") and
							$this->Dashboard_model->insert('missing_attendance_logs', $missing_logs)
						) {
						} else {
							$error = true;
							break;
						}
						$start_date_obj->add(new DateInterval('P1D'));
					}
					if (!$error) {
						alert('success', 'Successfully Absent!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				} else if (strpos($attendance, '0.5') !== false) {
					$note = 'half';
					$get_employees = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
					$s_d = explode('-', $this->input->post('attendate_date')); // This is start date
					$start_date_obj = new DateTime($this->input->post('attendate_date'));
					$start_date = $s_d[2] . '/' . $s_d[1] . '/' . $s_d[0];
					$how_many_days = $this->input->post('how_many_days');
					$unique_id = rand() * time();
					$has_data = false;
					for ($i = 1; $i <= $how_many_days; $i++) {
						$e_d = explode('/', $start_date_obj->format('Y/m/d'));
						$existing_leave_log = $this->Dashboard_model->mysqlij("SELECT unique_id from employee_leave_logs where e_db_id = '" . $get_employees->id . "' AND days = '" . $e_d[2] . "' AND month = '" . $e_d[1] . "' AND year = '" . $e_d[0] . "'");
						if (is_null($existing_leave_log)) {
							$has_data = true;
							$insert_leave_logs[] = array(
								'id' 				=> '',
								'unique_id' 		=> $unique_id,
								'e_db_id' 			=> $get_employees->id,
								'employee_id' 		=> $get_employees->employee_id,
								'start_days' 		=> $start_date,
								'how_many_days' 	=> '0.5',
								'end_date' 			=> $this->input->post('end_date'),
								'hold_unhold' 		=> '0',
								'days' 				=> $e_d[2],
								'month' 			=> $e_d[1],
								'year' 				=> $e_d[0],
								'note' 				=> $note,
								'status' 			=> '1',
								'aproval' 			=> '1',
								'uploader_info' 	=> uploader_info(),
								'data' 				=> date('d/m/Y')
							);
							$insert_data = array(
								'e_db_id' => $get_employees->id,
								'employee_id' => $get_employees->employee_id,
								'attendance' => '1',
								'checkin' => '',
								'checkout' => '',
								'note' => $note,
								'days' => $e_d[2],
								'month' => $e_d[1],
								'years' => substr($e_d[0], 2, 2),
								'uploader_info' => uploader_info(),
								'data' => date('d/m/Y')
							);
							$existing_attendance = $this->Dashboard_model->mysqlij("SELECT id from employee_attendence where e_db_id = '" . $get_employees->id . "' AND days = '" . $e_d[2] . "' AND month = '" . $e_d[1] . "' AND years = '" . substr($e_d[0], 2, 2) . "'");
							if (is_null($existing_attendance)) {
								$this->Dashboard_model->insert('employee_attendence', $insert_data);
							} else {
								$this->Dashboard_model->update('employee_attendence', $insert_data, $existing_attendance->id);
							}
							$missing_logs[] = array(
								'id' => '',
								'employee_id' => $employee_id,
								'attendance_date' => $start_date_obj->format('Y/m/d'),
								'note' => $note,
								'status' => '1',
								'uploader_info' => uploader_info(),
								'data' => date('d/m/Y')
							);
							$leave_every_day_logs[] = array(
								'id' => '',
								'unique_id' => $unique_id,
								'h_days' => '0.5',
								'days' => $e_d[2],
								'month' => $e_d[1],
								'year' => $e_d[0],
								'date_full' => $start_date_obj->format('Y/m/d'),
								'status' => '1',
								'uploader_info' => uploader_info(),
								'data' => date('d/m/Y')
							);
							$start_date_obj->add(new DateInterval('P1D'));
						}
					}
					if ($has_data) {
						if (
							$this->Dashboard_model->insert_batch('employee_everyday_leave_logs', $leave_every_day_logs) and
							$this->Dashboard_model->insert_batch('employee_leave_logs', $insert_leave_logs) and
							$this->Dashboard_model->insert_batch('missing_attendance_logs', $missing_logs)
						) {
							alert('success', 'Successfully Saved!');
							redirect(current_url());
						} else {
							alert('danger', 'Something Wrong! Please Try Again');
							redirect(current_url());
						}
					} else {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					}
				} else {
					$note = $this->input->post('note');
					$get_employees = $this->Dashboard_model->select('employee', array('employee_id' => $employee_id), 'id', 'desc', 'row');
					if (strpos($attendance, 'home') !== false) {
						$note = 'home';
					} else {
						if (!empty($note)) {
							$note = $note;
						} else {
							$note = '';
						}
					}
					$how_many_days = $this->input->post('how_many_days');
					$start_date_obj = new DateTime($this->input->post('attendate_date'));
					for ($i = 1; $i <= $how_many_days; $i++) {
						$e_d = explode('/', $start_date_obj->format('Y/m/d'));
						$insert_data = array(
							'e_db_id' => $get_employees->id,
							'employee_id' => $get_employees->employee_id,
							'attendance' => '1',
							'checkin' => '',
							'checkout' => '',
							'note' => $note,
							'days' => $e_d[2],
							'month' => $e_d[1],
							'years' => substr($e_d[0], 2, 2),
							'uploader_info' => uploader_info(),
							'data' => date('d/m/Y')
						);
						$existing_attendance = $this->Dashboard_model->mysqlij("SELECT id from employee_attendence where e_db_id = '" . $get_employees->id . "' AND days = '" . $e_d[2] . "' AND month = '" . $e_d[1] . "' AND years = '" . substr($e_d[0], 2, 2) . "'");
						if (is_null($existing_attendance)) {
							$this->Dashboard_model->insert('employee_attendence', $insert_data);
						} else {
							$this->Dashboard_model->update('employee_attendence', $insert_data, $existing_attendance->id);
							$existing_leave_log = $this->Dashboard_model->mysqlij("SELECT unique_id from employee_leave_logs where e_db_id = '" . $get_employees->id . "' AND days = '" . $e_d[2] . "' AND month = '" . $e_d[1] . "' AND year = '" . $e_d[0] . "'");
							$this->Dashboard_model->mysqliq("DELETE from employee_everyday_leave_logs where unique_id = '" . $existing_leave_log->unique_id . "'");
							$this->Dashboard_model->mysqliq("DELETE from employee_leave_logs where unique_id = '" . $existing_leave_log->unique_id . "'");
						}
						$missing_logs[] = array(
							'id' => '',
							'employee_id' => $employee_id,
							'attendance_date' => $start_date_obj->format('Y/m/d'),
							'note' => $note,
							'status' => '1',
							'uploader_info' => uploader_info(),
							'data' => date('d/m/Y')
						);
						$start_date_obj->add(new DateInterval('P1D'));
					}
					if (
						$this->Dashboard_model->insert_batch('missing_attendance_logs', $missing_logs)
					) {
						alert('success', 'Successfully Submitted!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			$condition = array('status' => '1');
			$data['employee'] = $this->Dashboard_model->select('employee', '', 'id', 'ASC', 'result');
			$data['title_info'] = 'Employee Missing Attendance Form';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/attendance/missing_attencance_form', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end hrm missing_attencance_form	

	//---------Start hrm yearly_attendance-------------
	public function yearly_attendance()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array('status' => '1');
			$data['employee'] = $this->Dashboard_model->select('employee', $condition, 'id', 'ASC', 'result');
			$data['title_info'] = 'Employee Yearly Attendance Overview';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/attendance/yearly_attendance', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end hrm yearly_attendance


	//---------Start attendance overview-------------
	public function attendance_overview()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			$data['logout_timer'] = 'yes_false';
			$data['title_info'] = 'Employee Attendance Overview';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/attendance/attendance_overview', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit attendance overview

	//---------Start attendance log-------------
	public function attendance_log()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			$data['title_info'] = 'Employee Attendance Log';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/attendance/attendance_log', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit attendance log

	//---------Start today_candidate_attendance-------------
	public function today_candidate_attendance()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Today Candidate Attendance';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/recruitment/today_candidate_attendance', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit today_candidate_attendance


	//---------Start candidate_shortlist-------------
	public function candidate_shortlist()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Candidate Shortlist';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/recruitment/candidate_shortlist', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit candidate_shortlist

	//---------Start employee_prebook_request-------------
	public function employee_prebook_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			$data['title_info'] = 'Employee Prebook Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/recruitment/employee_prebook_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit employee_prebook_request


	//===================PAYROLL SECTION======================


	//---------Start payroll_add_increament-------------
	public function payroll_add_increament()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (
				$_SESSION['super_admin']['employee_id'] == '113' or
				$_SESSION['super_admin']['employee_id'] == '114'
			) {
				$_SUPER_ADMIN = 1;
			} else {
				$_SUPER_ADMIN = 0;
			}
			if (isset($_POST['save'])) {
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				$d = explode('-', $this->input->post('selected_date'));
				$selected_date = $d[2] . '/' . $d[1] . '/' . $d[0];
				$selected_date_modify = $d[0] . '' . $d[1] . '' . $d[1];
				$designation = $this->input->post('designation_id');
				if ($_SUPER_ADMIN == 1) {
					$approval = 1;
					$get_id = $this->Dashboard_model->select('employee_increament_logs', '', 'id', 'desc', 'row');
					$info = $this->Dashboard_model->select('designation', array('designation_id' => $designation), 'id', 'desc', 'row');
					$increament_id = (int)$get_id->id + 1;
					$super_admin_data = array(
						'id' 				=> '',
						'e_db_id' 			=> $emp->id,
						'employee_id' 		=> $emp->employee_id,
						'increament_id' 	=> $increament_id,
						'aproval_type' 		=> 'Approved',
						'note' 				=> 'Approved',
						'status' 			=> '1',
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					$this->Dashboard_model->insert('employee_increament_approval', $super_admin_data);
					$super_admin_update_designation = array(
						'designation' 		=> $info->designation_id,
						'designation_name' 	=> $info->designation_name
					);
					$this->Dashboard_model->update('employee', $super_admin_update_designation, $emp->id);
				} else {
					$approval = 0;
				}
				$insert_data = array(
					'id' => '',
					'old_designation' 	=> $emp->designation,
					'department' 		=> $emp->department,
					'designation' 		=> $designation,
					'e_db_id' 			=> $emp->id,
					'employee_id' 		=> $emp->employee_id,
					'amount' 			=> $this->input->post('amount'),
					'start_date' 		=> $selected_date,
					'start_date_modify' => $selected_date_modify,
					'note' 				=> $this->input->post('note'),
					'status' 			=> '1',
					'aproval' 			=> $approval,
					'uploader_info' 	=> uploader_info(),
					'data' 				=> date('d/m/Y'),
					'hr_check' => 0
				);
				if ($this->Dashboard_model->insert('employee_increament_logs', $insert_data)) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('employee_increament_logs', $this->input->post('delete_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$sin_emp = $this->Dashboard_model->select('employee', array('id' => $_SESSION['user_info']['employee_id'], 'd_head' => '1'), 'id', 'desc', 'row');
			if (!empty($sin_emp->department)) {
				if ($_SUPER_ADMIN == 1) {
					$data['emp_list'] 			= $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
					$data['deg_list'] 			= $this->Dashboard_model->mysqlii("select * from designation order by serial asc");
					$data['emp_list_table'] 	= $this->Dashboard_model->mysqlii("select * from employee_increament_logs order by id DESC");
				} else {
					if ($_SESSION['user_info']['department'] == '1383007286312996344' and $_SESSION['user_info']['d_head'] == 1) {
						$data['emp_list'] 			= $this->Dashboard_model->mysqlii("select * from employee where status = '1' and ( department = '" . $sin_emp->department . "' OR ( d_head = 1 AND department != '749568347163692080') ) order by employee_id asc");
						$data['deg_list'] 			= $this->Dashboard_model->mysqlii("select * from designation order by serial asc");
						$data['emp_list_table'] 	= $this->Dashboard_model->mysqlii("select employee_increament_logs.* from employee_increament_logs INNER JOIN employee on employee.id = employee_increament_logs.e_db_id where ( employee.department = '" . $sin_emp->department . "' OR ( employee.d_head = 1 AND employee.department != '749568347163692080') ) order by employee_increament_logs.id DESC");
					} else {
						$data['emp_list'] 			= $this->Dashboard_model->mysqlii("select * from employee where status = '1' and department = '" . $sin_emp->department . "' order by employee_id asc");
						$data['deg_list'] 			= $this->Dashboard_model->mysqlii("select * from designation order by serial asc");
						$data['emp_list_table'] 	= $this->Dashboard_model->mysqlii("select * from employee_increament_logs where department = '" . $sin_emp->department . "' order by id DESC");
					}
				}
			}
			$data['title_info'] = 'Payroll - Add Increament';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_add_increament', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_add_increament

	//---------Start payroll_add_decreament-------------
	public function payroll_add_decreament()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (
				$_SESSION['super_admin']['employee_id'] == '113' or
				$_SESSION['super_admin']['employee_id'] == '114'
			) {
				$_SUPER_ADMIN = 1;
			} else {
				$_SUPER_ADMIN = 0;
			}
			if (isset($_POST['save'])) {
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				$d = explode('-', $this->input->post('selected_date'));
				$selected_date = $d[2] . '/' . $d[1] . '/' . $d[0];
				$selected_date_modify = $d[0] . '' . $d[1] . '' . $d[1];
				$designation = $this->input->post('designation_id');
				if ($_SUPER_ADMIN == 1) {
					$approval = 1;
					$get_id = $this->Dashboard_model->select('employee_decreament_logs', '', 'id', 'desc', 'row');
					$info = $this->Dashboard_model->select('designation', array('designation_id' => $designation), 'id', 'desc', 'row');
					$decreament_id = (int)$get_id->id + 1;
					$super_admin_data = array(
						'id' 				=> '',
						'e_db_id' 			=> $emp->id,
						'employee_id' 		=> $emp->employee_id,
						'decreament_id' 	=> $decreament_id,
						'aproval_type' 		=> 'Approved',
						'note' 				=> 'Approved',
						'status' 			=> '1',
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					$this->Dashboard_model->insert('employee_decreament_approval', $super_admin_data);
					$super_admin_update_designation = array(
						'designation' 		=> $info->designation_id,
						'designation_name' 	=> $info->designation_name
					);
					$this->Dashboard_model->update('employee', $super_admin_update_designation, $emp->id);
				} else {
					$approval = 0;
				}
				$insert_data = array(
					'id' => '',
					'old_designation' => $emp->designation,
					'department' => $emp->department,
					'designation' => $designation,
					'e_db_id' => $emp->id,
					'employee_id' => $emp->employee_id,
					'amount' => $this->input->post('amount'),
					'start_date' => $selected_date,
					'start_date_modify' => $selected_date_modify,
					'note' => $this->input->post('note'),
					'status' => '1',
					'aproval' => $approval,
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y'),
					'hr_check' => 0
				);
				if ($this->Dashboard_model->insert('employee_decreament_logs', $insert_data)) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('employee_decreament_logs', $this->input->post('delete_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$sin_emp = $this->Dashboard_model->select('employee', array('id' => $_SESSION['user_info']['employee_id'], 'd_head' => '1'), 'id', 'desc', 'row');
			if (!empty($sin_emp->department)) {
				if ($sin_emp->d_head == 1 and $sin_emp->department == '1383007286312996344') {
					$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' and d_head = '1' order by employee_id asc");
					$data['deg_list'] = $this->Dashboard_model->mysqlii("select * from designation order by serial desc");
					$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_decreament_logs order by id DESC");
				} else {
					if ($_SUPER_ADMIN == 1) {
						$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
						$data['deg_list'] = $this->Dashboard_model->mysqlii("select * from designation order by serial desc");
						$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_decreament_logs order by id DESC");
					} else {
						if ($_SESSION['user_info']['department'] == '1383007286312996344' and $_SESSION['user_info']['d_head'] == 1) {
							$data['emp_list'] 			= $this->Dashboard_model->mysqlii("select * from employee where status = '1' and ( department = '" . $sin_emp->department . "' OR ( d_head = 1 AND department != '749568347163692080') ) order by employee_id asc");
							$data['deg_list'] 			= $this->Dashboard_model->mysqlii("select * from designation order by serial asc");
							$data['emp_list_table'] 	= $this->Dashboard_model->mysqlii("select * from employee_increament_logs INNER JOIN employee on employee.id = employee_increament_logs.e_db_id where ( employee.department = '" . $sin_emp->department . "' OR ( employee.d_head = 1 AND employee.department != '749568347163692080') ) order by employee_increament_logs.id DESC");
						} else {
							$data['emp_list'] 			= $this->Dashboard_model->mysqlii("select * from employee where status = '1' and department = '" . $sin_emp->department . "' order by employee_id asc");
							$data['deg_list'] 			= $this->Dashboard_model->mysqlii("select * from designation order by serial asc");
							$data['emp_list_table'] 	= $this->Dashboard_model->mysqlii("select * from employee_increament_logs where department = '" . $sin_emp->department . "' order by id DESC");
						}
					}
				}
			}
			$data['title_info'] = 'Payroll - Add Increament';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_add_decreament', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_add_decreament

	//---------Start payroll_set_department_head-------------
	public function payroll_set_department_head()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				$d = explode('-', $this->input->post('selected_date'));
				$selected_date = $d[2] . '/' . $d[1] . '/' . $d[0];
				$update_data = array(
					'd_head' => '1',
					'd_head_reporting' => $this->input->post('d_head_reporting'),
				);
				$insert_data = array(
					'id' => '',
					'branch_id' => $emp->branch,
					'employee_id' => $emp->employee_id,
					'department_id' => $emp->department,
					'department_name' => $emp->department_name,
					'start_date' => $selected_date,
					'note' => $this->input->post('note'),
					'status' => '1',
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if (
					$this->Dashboard_model->update('employee', $update_data, $emp->id) and
					$this->Dashboard_model->insert('set_department_head_logs', $insert_data)
				) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['update'])) {
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('update_employee_id')), 'id', 'desc', 'row');
				$update_data = array(
					'd_head_reporting' => $this->input->post('d_head_reporting'),
				);
				if (
					$this->Dashboard_model->update('employee', $update_data, $emp->id)
				) {
					alert('success', 'Successfully Updated!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['delete_data'])) {
				$d_logs = $this->Dashboard_model->select('set_department_head_logs', array('id' => $this->input->post('delete_id')), 'id', 'desc', 'row');
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $d_logs->employee_id), 'id', 'desc', 'row');
				$update_data = array(
					'd_head' => '0',
					'd_head_reporting' => '',
				);
				if (
					$this->Dashboard_model->update('employee', $update_data, $emp->id) and
					$this->Dashboard_model->delete('set_department_head_logs', $d_logs->id)
				) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$data['employeies'] = $this->Dashboard_model->select('employee', array('status' => '1', 'd_head' => '0'), 'id', 'ASC', 'result');
			$data['top_management'] = $this->Dashboard_model->select('employee', array('status' => '1', 'department' => '749568347163692080'), 'id', 'ASC', 'result');
			$data['head_emp'] = $this->Dashboard_model->select('set_department_head_logs', array('status' => '1'), 'id', 'ASC', 'result');

			
			
			$data['title_info'] = 'Payroll - Set Department Head';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_set_department_head', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_set_department_head

	//---------Start payroll_set_attendance_bonus-------------
	public function payroll_set_attendance_bonus()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				$desig = $this->Dashboard_model->select('designation', array('designation_id' => $this->input->post('designation_id')), 'id', 'desc', 'row');
				$update_data = array(
					'a_bonus' => '1'
				);
				$insert_data = array(
					'id' => '',
					'designation_id' => $desig->designation_id,
					'designation_name' => $desig->designation_name,
					'amount' => $this->input->post('amount'),
					'note' => $this->input->post('note'),
					'status' => '1',
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if (
					$this->Dashboard_model->update('designation', $update_data, $desig->id) and
					$this->Dashboard_model->insert('set_attendance_bonus_logs', $insert_data)
				) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['delete_data'])) {
				$d_logs = $this->Dashboard_model->select('set_attendance_bonus_logs', array('id' => $this->input->post('delete_id')), 'id', 'desc', 'row');
				$dig = $this->Dashboard_model->select('designation', array('designation_id' => $d_logs->designation_id), 'id', 'desc', 'row');
				$update_data = array(
					'a_bonus' => '0'
				);
				if (
					$this->Dashboard_model->update('designation', $update_data, $dig->id) and
					$this->Dashboard_model->delete('set_attendance_bonus_logs', $d_logs->id)
				) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$data['designations'] = $this->Dashboard_model->select('designation', array('status' => '1', 'a_bonus' => '0'), 'id', 'ASC', 'result');
			$data['att_bonus_log'] = $this->Dashboard_model->select('set_attendance_bonus_logs', array('status' => '1'), 'id', 'ASC', 'result');
			$data['title_info'] = 'Payroll - Set Department Head';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_set_attendance_bonus', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_set_attendance_bonus

	//---------Start payroll_increament_approval-------------
	public function payroll_increament_approval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$pending_increment_count = 0;
			$pending_decrement_count = 0;
			if ($_SESSION['user_info']['department'] == '749568347163692080') {
				$increments = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from employee_increament_logs where aproval = 0");
				$pending_increment_count = $increments->id_count;
				$decrements = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from employee_decreament_logs where aproval = 0");
				$pending_decrement_count = $decrements->id_count;
			}
			
			// This block is add to ensure HR gets notification after boss approved.
			// So, there is a extra column in database called hr_check.
			if ($_SESSION['user_info']['department'] == '1383007286312996344') { // HR & Admin 
				$increments = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from employee_increament_logs where aproval = 1 and hr_check='0' ");
				$pending_increment_count = $increments->id_count;
				$decrements = $this->Dashboard_model->mysqlij("SELECT count(*) as id_count from employee_decreament_logs where aproval = 1 and hr_check='0' ");
				$pending_decrement_count = $decrements->id_count;
			}
			
			$data['pending_increment_count'] = $pending_increment_count;
			$data['pending_decrement_count'] = $pending_decrement_count;
			$data['title_info'] = 'Payroll - Increament Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_increament_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_increament_approval

	//---------Start payroll_employee_salary_deduction-------------
	public function payroll_employee_salary_deduction()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				$mon = explode('-', $this->input->post('month'));
				$month = $mon[1];
				$year = $mon[0];
				foreach ($this->input->post('employee_id') as $row) {
					$emp = $this->Dashboard_model->select('employee', array('employee_id' => $row), 'id', 'desc', 'row');
					$insert_deduction_data[] = array(
						'id' => '',
						'e_db_id' => $emp->id,
						'employee_id' => $emp->employee_id,
						'amount' => $this->input->post('amount'),
						'month' => $month,
						'year' => $year,
						'reason' => $this->input->post('deduction_reason'),
						'note' => $this->input->post('note'),
						'aproval' => '0',
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
				}

				if (!empty($insert_deduction_data) and count($insert_deduction_data) > 0) {
					if ($this->Dashboard_model->insert_batch('employee_sallary_deduction', $insert_deduction_data)) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				} else {
					alert('warning', 'Something Wrong! or Employee all ready deducted this month! Please Try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['remove_deduction'])) {
				if ($this->Dashboard_model->delete('employee_sallary_deduction', $this->input->post('hidden_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee order by employee_id asc");
			$data['title_info'] = 'Payroll - Employee Salary Deduction';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_employee_salary_deduction', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_employee_salary_deduction	


	//---------Start payroll_employee_extra_salary-------------
	public function payroll_employee_extra_salary()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				$mon = explode('-', $this->input->post('month'));
				$month = $mon[1];
				$year = $mon[0];
				foreach ($this->input->post('employee_id') as $row) {
					$check = $this->Dashboard_model->select('employee_extra_sallary', array('employee_id' => $row, 'month' => $month, 'year' => $year), 'id', 'desc', 'row');
					if (!empty($check->id)) {
					} else {
						$emp = $this->Dashboard_model->select('employee', array('employee_id' => $row), 'id', 'desc', 'row');
						$insert_deduction_data[] = array(
							'id' => '',
							'e_db_id' => $emp->id,
							'employee_id' => $emp->employee_id,
							'amount' => $this->input->post('amount'),
							'month' => $month,
							'year' => $year,
							'reason' => $this->input->post('deduction_reason'),
							'note' => $this->input->post('note'),
							'aproval' => '1',
							'status' => '1',
							'uploader_info' => uploader_info(),
							'data' => date('d/m/Y')
						);
					}
				}

				if (!empty($insert_deduction_data) and count($insert_deduction_data) > 0) {
					if ($this->Dashboard_model->insert_batch('employee_extra_sallary', $insert_deduction_data)) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				} else {
					alert('warning', 'Something Wrong! or Employee all ready deducted this month! Please Try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['remove_deduction'])) {
				if ($this->Dashboard_model->delete('employee_extra_sallary', $this->input->post('hidden_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee order by employee_id asc");
			$data['title_info'] = 'Payroll - Employee Extra Salary';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_employee_extra_salary', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_employee_extra_salary



	//---------Start payroll_employee_salary_generate-------------
	public function payroll_employee_salary_generate()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
			$data['title_info'] = 'Payroll - Employee Salary Generate';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_employee_salary_generate', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_employee_salary_generate



	//---------Start payroll_accounts_employee_salary_generate-------------
	public function payroll_accounts_employee_salary_generate()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
			$data['title_info'] = 'Accounts - Employee Salary';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_accounts_employee_salary_generate', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_accounts_employee_salary_generate


	//---------Start loan_grant_loan-------------
	public function loan_grant_loan()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				$insert_data = array(
					'id' => '',
					'e_db_id' => $emp->id,
					'employee_id' => $emp->employee_id,
					'amount' => $this->input->post('amount'),
					'note' => $this->input->post('note'),
					'aproval' => '3',
					'aproval_account' => '0',
					'status' => '1',
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if ($this->Dashboard_model->insert('employee_grant_loan', $insert_data)) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by full_name asc");
			$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_grant_loan order by id DESC limit 100");

			$data['title_info'] = 'Loan - Grant Loan';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/loan/loan_grant_loan', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit loan_grant_loan

	//---------Start loan_loan_approval-------------
	public function loan_loan_approval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Payroll - Loan Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/loan/loan_loan_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit loan_loan_approval 

	//---------Start employee_fired_from_head-------------
	public function employee_fired_from_head()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				$check_data = $this->Dashboard_model->select('employee_fired_list', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				if (!empty($check_data)) {
					alert('danger', 'Employee all ready added to fired list');
					redirect(current_url());
				} else {
					$insert_data = array(
						'id' => '',
						'e_db_id' => $emp->id,
						'employee_id' => $emp->employee_id,
						'department' => $emp->department,
						'reason' => $this->input->post('reason'),
						'note' => $this->input->post('note'),
						'aproval' => '0',
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					$update_date_logs = array(
						'id' => '',
						'employee_id' => $emp->employee_id,
						'old_date' => $emp->data,
						'new_date' => date('d/m/Y'),
						'note' => 'employee_fired_from_head',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					$update_date = array(
						'last_working_date' => $_POST['last_working_date'],
						'data' => date('d/m/Y')
					);
					if (
						$this->Dashboard_model->insert('employee_fired_list', $insert_data) and
						$this->Dashboard_model->insert('emp_release_date_update_logs', $update_date_logs) and
						$this->Dashboard_model->update('employee', $update_date, $emp->id)
					) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('employee_fired_list', $this->input->post('delete_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$department = $_SESSION['user_info']['department'];
			if ($_SESSION['user_info']['department'] == '1383007286312996344') {
				$data['emp_list_table'] = $this->Dashboard_model->mysqlii("SELECT * from employee_fired_list where uploader_info like '%" . $_SESSION['super_admin']['email'] . "%' OR department = '" . $department . "' order by id DESC limit 200");
			} else {
				$data['emp_list_table'] = $this->Dashboard_model->mysqlii("SELECT * from employee_fired_list where department = '" . $department . "' order by id DESC limit 200");
			}
			if ($_SESSION['user_info']['department'] == '1383007286312996344') {
				$data['emp_list'] = $this->Dashboard_model->mysqlii("SELECT * from employee where status = '1' and ( department = '" . $department . "' OR d_head = 1 ) order by employee_id asc");
				$employee_wo_d_head = $this->Dashboard_model->mysqlii("SELECT department.department_name, subordinates.full_name, subordinates.employee_id FROM `department` LEFT JOIN `employee` heads on heads.department = department.department_id AND heads.d_head = 1 INNER JOIN employee subordinates on subordinates.department = department.department_id WHERE heads.d_head is null AND subordinates.status = 1 ORDER BY `department`.`department_name` DESC");
				$data['emp_list'] = array_merge($data['emp_list'], $employee_wo_d_head);
			} else {
				$data['emp_list'] = $this->Dashboard_model->mysqlii("SELECT * from employee where status = '1' and department = '" . $department . "' order by employee_id asc");
			}

			$data['title_info'] = 'Payroll - Employee Fired Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/employee_fired_from_head', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit employee_fired_from_head

	public function fire_eligibility()
	{
		$employee = $this->Dashboard_model->select('employee',array('employee_id' => $_POST['employee_id']),'id','DESC','row');

		$petty_balance = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $employee->id),'id','DESC','row');
		if(!is_null($petty_balance) AND $petty_balance->amount > 0){
			echo json_encode(array('eligible' => false, $_POST['employee_id']));
		}else{
			echo json_encode(array('eligible' => true, $_POST['employee_id']));
		}
	}


	//---------Start employee_fired_request_aproval-------------
	public function employee_fired_request_aproval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['status_off'])) {
				$dac_date = explode('-', $this->input->post('deactive_Date'));
				$actual_date = $dac_date[2] . '/' . $dac_date[1] . '/' . $dac_date[0];
				$deactive_note = $this->input->post('extra_note');
				$d_emp = $this->Dashboard_model->select('employee', array('id' => $this->input->post('aprove_id')), 'id', 'ASC', 'row');

				foreach ($this->input->post('aproval_employee') as $row) {
					$a_emp = $this->Dashboard_model->select('employee', array('employee_id' => $row), 'id', 'ASC', 'row');
					$exit_insert_data[] = array(
						'id' 					=> '',
						'e_db_id' 				=> $a_emp->id,
						'employee_id' 			=> $a_emp->employee_id,
						'exit_emp_id' 			=> $d_emp->id,
						'exit_emp_employee_id' 	=> $d_emp->employee_id,
						'aproval' 				=> '0',
						'deactive_note' 		=> $deactive_note,
						'note' 					=> $actual_date,
						'status' 				=> '1',
						'uploader_info' 		=> uploader_info(),
						'data'					=> date('d/m/Y')
					);
				}
				$insert_data_hr = array(
					'id' 					=> '',
					'e_db_id' 				=> $d_emp->id,
					'employee_id' 			=> $d_emp->employee_id,
					'aproval' 				=> '0',
					'note' 					=> $deactive_note,
					'status' 				=> '1',
					'uploader_info' 		=> uploader_info(),
					'data'					=> date('d/m/Y')
				);
				$check_data = $this->Dashboard_model->select('exit_employee_chain_hr', array('e_db_id' => $d_emp->id), 'id', 'ASC', 'row');
				if ($this->Dashboard_model->insert_batch('exit_employee_chain_aproval', $exit_insert_data)) {
					alert('success', 'Save Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			$data['title_info'] = 'Payroll - Fired Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/loan/employee_fired_request_aproval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit employee_fired_request_aproval 


	//---------Start fired_employee_chain_approval_hr-------------
	public function fired_employee_chain_approval_hr()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['status_off'])) {
				$dac_date = explode('-', $this->input->post('deactive_Date'));
				$actual_date = $dac_date[2] . '/' . $dac_date[1] . '/' . $dac_date[0];
				$deactive_note = $this->input->post('extra_note');
				$d_emp = $this->Dashboard_model->select('employee', array('id' => $this->input->post('aprove_id')), 'id', 'ASC', 'row');

				if (!empty($this->input->post('aproval_employee'))) {
					foreach ($this->input->post('aproval_employee') as $row) {
						$a_emp = $this->Dashboard_model->select('employee', array('employee_id' => $row), 'id', 'ASC', 'row');
						$exit_insert_data[] = array(
							'id' 					=> '',
							'e_db_id' 				=> $a_emp->id,
							'employee_id' 			=> $a_emp->employee_id,
							'exit_emp_id' 			=> $d_emp->id,
							'exit_emp_employee_id' 	=> $d_emp->employee_id,
							'aproval' 				=> '0',
							'deactive_note' 		=> $deactive_note,
							'note' 					=> '',
							'status' 				=> '1',
							'uploader_info' 		=> uploader_info(),
							'data'					=> date('d/m/Y')
						);
					}
					if ($this->Dashboard_model->insert_batch('exit_employee_chain_aproval', $exit_insert_data)) {
						alert('success', 'Save Successfully!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please try Again');
						redirect(current_url());
					}
				} else {
					$update_employee_data = array(
						'status' => 0,
						'data' => $actual_date,
						'extra_note' => $deactive_note
					);
					if ($this->Dashboard_model->update('employee', $update_employee_data)) {
						alert('success', 'Save Successfully!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please try Again');
						redirect(current_url());
					}
				}
			}



			$data['title_info'] = 'Payroll - Fired Employee (HRM) Request Chain Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/loan/fired_employee_chain_approval_hr', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit fired_employee_chain_approval_hr 

	//---------Start exit_employee_approval-------------
	public function exit_employee_approval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['aprove_data'])) {
				$id = $this->input->post('aprove_id');
				$note = $this->input->post('note');
				$update_data = array(
					'aproval' => '1',
					'note' => $note
				);
				if ($this->Dashboard_model->update('exit_employee_chain_aproval', $update_data, $id)) {
					$exit_emp = $this->db->query("select exit_emp_employee_id from exit_employee_chain_aproval where id='$id'")->row();
					$delete_id = $exit_emp->exit_emp_employee_id;
					$this->db->query("delete from set_department_head_logs where employee_id='$delete_id'");
					
					alert('success', 'Successfully Approved BY USER!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}				
			}
			if (isset($_POST['reject_data'])) {
				$id = $this->input->post('reject_id');
				$note = $this->input->post('note');


				$update_data = array(
					'aproval' => '2',
					'note' => $note
				);
				if ($this->Dashboard_model->update('exit_employee_chain_aproval', $update_data, $id)) {
					alert('success', 'Successfully Approved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$emp_id = $_SESSION['user_info']['employee_id'];
			$data['emp_list_table'] = $this->Dashboard_model->mysqlii("SELECT * from exit_employee_chain_aproval where e_db_id = '" . $emp_id . "' and aproval = '0' and aproval not in('1') order by id desc limit 200");
			
			$data['title_info'] = 'Payroll - Exit Employee Request Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/exit_employee_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit exit_employee_approval

	//---------Start loan_loan_approval_accounts-------------
	public function loan_loan_approval_accounts()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Payroll - Loan Approval Accounts';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/loan/loan_loan_approval_accounts', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit loan_loan_approval_accounts 

	//---------Start employee_deduction_approval-------------
	public function employee_deduction_approval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Payroll - Loan Approval Accounts';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/loan/employee_deduction_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit employee_deduction_approval 

	//---------Start loan_loan_report-------------
	public function loan_loan_report()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Payroll - Loan Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/loan/loan_loan_report', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit loan_loan_report 

	//---------Start payroll_employee_leave_request-------------
	public function payroll_employee_leave_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['apply'])) {
				if (isset($_POST['hold_employee'])) {
					$_HOLD_EMPLOYEE = 1;
					$aproval_hold = 1;
				} else {
					$_HOLD_EMPLOYEE = 0;
					$aproval_hold = 1;
				}
				foreach ($this->input->post('employee_id') as $row) {
					$get_employees = $this->Dashboard_model->select('employee', array('employee_id' => $row), 'id', 'desc', 'row');
					$s_d = explode('-', $this->input->post('start_date'));
					$start_date = $s_d[2] . '/' . $s_d[1] . '/' . $s_d[0];
					$how_many_days = $this->input->post('how_many_days');
					$e_d = explode('-', $this->input->post('end_date'));
					$end_date = $e_d[2] . '/' . $e_d[1] . '/' . $e_d[0];
					$note = $this->input->post('note');
					$unique_id = rand() * time();
					if ($_HOLD_EMPLOYEE == 1) {
						$insert_hold_employee = array(
							'id' 			=> '',
							'e_db_id' 		=> $get_employees->id,
							'employee_id' 	=> $get_employees->employee_id,
							'hold' 			=> $_HOLD_EMPLOYEE,
							'note' 			=> $note,
							'status' 		=> '1',
							'aproval' 		=> '0',
							'uploader_info' => uploader_info(),
							'data' 			=> date('d/m/Y')
						);
						if ($this->Dashboard_model->insert('hold_employe_logs', $insert_hold_employee)) {
							$_UPLOADING = 1;
						} else {
							$_UPLOADING = 0;
						}
					}
					$insert_leave_logs = array(
						'id' 				=> '',
						'unique_id' 		=> $unique_id,
						'e_db_id' 			=> $get_employees->id,
						'employee_id' 		=> $get_employees->employee_id,
						'start_days' 		=> $start_date,
						'how_many_days' 	=> $how_many_days,
						'end_date' 			=> $end_date,
						'hold_unhold' 		=> $_HOLD_EMPLOYEE,
						'days' 				=> $e_d[2],
						'month' 			=> $e_d[1],
						'year' 				=> $e_d[0],
						'note' 				=> $note,
						'status' 			=> '1',
						'aproval' 			=> $aproval_hold,
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					for ($i = 0; $i < $how_many_days; $i++) {
						$sd = explode('/', $start_date);
						$std = $sd[2] . '/' . $sd[1] . '/' . $sd[0];
						$every_day = date('d/m/Y', strtotime($std . ' + ' . $i . ' days'));
						$ed = explode('/', $every_day);
						$leave_every_day_logs[] = array(
							'id' => '',
							'unique_id' => $unique_id,
							'h_days' => '1',
							'days' => $ed[0],
							'month' => $ed[1],
							'year' => $ed[2],
							'date_full' => $every_day,
							'status' => '1',
							'uploader_info' => uploader_info(),
							'data' => date('d/m/Y')
						);
					}
					if (
						$this->Dashboard_model->insert_batch('employee_everyday_leave_logs', $leave_every_day_logs) and
						$this->Dashboard_model->insert('employee_leave_logs', $insert_leave_logs)
					) {
						$_UPLOADING = 1;
					} else {
						$_UPLOADING = 0;
					}
				}
				if ($_UPLOADING == 1) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
			$data['title_info'] = 'Leave - Employee Leave Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_employee_leave_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_employee_leave_request

	//---------- Locked Leave ----------
	public function payroll_employee_locked_leave()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {			
			$data['title_info'] = 'Payroll - Loan Report';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_employee_locked_leave', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	} 
	//END

	//---------Start employee_subordinate_leave_request-------------
	public function employee_subordinate_leave_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['apply'])) {
				if (isset($_POST['hold_employee'])) {
					$_HOLD_EMPLOYEE = 1;
					$aproval_hold = 0;
				} else {
					$_HOLD_EMPLOYEE = 0;
					$aproval_hold = 0;
				}
				foreach ($this->input->post('employee_id') as $row) {
					$get_employees = $this->Dashboard_model->select('employee', array('employee_id' => $row), 'id', 'desc', 'row');
					if (!empty($_POST['h_aproval'])) {
						$d_head_aproval = 3;
						$d_head_id = $_POST['h_aproval'];
					} else {
						if ($get_employees->department == '1810685559802248792' or $get_employees->department == '2335318469842157306' or $get_employees->department == '528388997158023095') { // Branch filter not allicable for `Food and Beverage` & `Housekeeping` & `Security`
							$get_department_head = $this->Dashboard_model->select('employee', array('department' => $get_employees->department, 'd_head' => '1'), 'id', 'desc', 'row');
						} else {
							$get_department_head = $this->Dashboard_model->select('employee', array('department' => $get_employees->department, 'd_head' => '1', 'branch' => $get_employees->branch), 'id', 'desc', 'row');
						}
						if (!empty($get_department_head->id) and $get_department_head->id == $_SESSION['super_admin']['employee_id']) {
							if ($get_employees->department == '2392358440567352112') {
								$get_branch_incharge = $this->Dashboard_model->select('employee', array('department' => '1806965207554226682', 'd_head' => '1', 'branch' => $get_employees->branch), 'id', 'desc', 'row');
								$d_head_aproval = 3;
								$d_head_id = $get_branch_incharge->id;
							} else if ($get_employees->department == '1810685559802248792' or $get_employees->department == '2335318469842157306' or $get_employees->department == '528388997158023095') {
								$d_head_aproval = 1;
								$d_head_id = $get_department_head->id;
								$aproval_hold = '1';
							} else {
								$d_head_aproval = 1;
								$d_head_id = $get_department_head->id;
							}
						} else {
							if (!empty($get_department_head->id)) {
								$d_head_aproval = 0;
								$d_head_id = $get_department_head->id;
							} else {
								$get_hr_head = $this->Dashboard_model->select('employee', array('department' => '1383007286312996344', 'd_head' => '1'), 'id', 'desc', 'row');
								$d_head_aproval = 0;
								$d_head_id = $get_hr_head->id;
							}
						}
					}



					$s_d = explode('-', $this->input->post('start_date'));
					$start_date = $s_d[2] . '/' . $s_d[1] . '/' . $s_d[0];
					$how_many_days = $this->input->post('how_many_days');
					$e_d = explode('-', $this->input->post('end_date'));
					$end_date = $e_d[2] . '/' . $e_d[1] . '/' . $e_d[0];
					$note = $this->input->post('note');
					$unique_id = rand() * time();
					if ($_HOLD_EMPLOYEE == 1) {
						$insert_hold_employee = array(
							'id' 			=> '',
							'e_db_id' 		=> $get_employees->id,
							'employee_id' 	=> $get_employees->employee_id,
							'hold' 			=> $_HOLD_EMPLOYEE,
							'note' 			=> $note,
							'status' 		=> '1',
							'aproval' 		=> '0',
							'uploader_info' => uploader_info(),
							'data' 			=> date('d/m/Y')
						);
						if ($this->Dashboard_model->insert('hold_employe_logs', $insert_hold_employee)) {
							$_UPLOADING = 1;
						} else {
							$_UPLOADING = 0;
						}
					}
					if ($_POST['leave_type'] == 'full_day') {
						$s_d = explode('-', $this->input->post('start_date'));
						$start_date = $s_d[2] . '/' . $s_d[1] . '/' . $s_d[0];
						$how_many_days = $this->input->post('how_many_days');
						$end_date = new DateTime(date($this->input->post('start_date')));
						$end_date->add(new DateInterval('P' . ($how_many_days - 1) . 'D'));
						$insert_leave_logs = array(
							'id' 				=> '',
							'unique_id' 		=> $unique_id,
							'e_db_id' 			=> $get_employees->id,
							'employee_id' 		=> $get_employees->employee_id,
							'start_days' 		=> $start_date,
							'how_many_days' 	=> $how_many_days,
							'end_date' 			=> $end_date->format('d/m/Y'),
							'hold_unhold' 		=> $_HOLD_EMPLOYEE,
							'days' 				=> $e_d[2],
							'month' 			=> $e_d[1],
							'year' 				=> $e_d[0],
							'note' 				=> $note,
							'status' 			=> '1',
							'h_aproval' 		=> $d_head_aproval,
							'h_id' 				=> $d_head_id,
							'aproval' 			=> $aproval_hold,
							'uploader_info' 	=> uploader_info(),
							'data' 				=> date('d/m/Y')
						);
						for ($i = 0; $i < $how_many_days; $i++) {
							$sd = explode('/', $start_date);
							$std = $sd[2] . '/' . $sd[1] . '/' . $sd[0];
							$every_day = date('d/m/Y', strtotime($std . ' + ' . $i . ' days'));
							$ed = explode('/', $every_day);
							$leave_every_day_logs[] = array(
								'id' => '',
								'unique_id' => $unique_id,
								'h_days' => '1',
								'days' => $ed[0],
								'month' => $ed[1],
								'year' => $ed[2],
								'date_full' => $every_day,
								'status' => '1',
								'uploader_info' => uploader_info(),
								'data' => date('d/m/Y')
							);
						}
						if (
							$this->Dashboard_model->insert_batch('employee_everyday_leave_logs', $leave_every_day_logs) and
							$this->Dashboard_model->insert('employee_leave_logs', $insert_leave_logs)
						) {
							$_UPLOADING = 1;
						} else {
							$_UPLOADING = 0;
						}
					} else if ($_POST['leave_type'] == 'half_day') {
						$s_d = explode('-', $this->input->post('leave_date'));
						$start_date = $s_d[2] . '/' . $s_d[1] . '/' . $s_d[0];
						$how_many_days = $this->input->post('how_many_days');
						$end_date = $start_date;
						$insert_leave_logs = array(
							'id' 				=> '',
							'unique_id' 		=> $unique_id,
							'e_db_id' 			=> $get_employees->id,
							'employee_id' 		=> $get_employees->employee_id,
							'start_days' 		=> $start_date,
							'how_many_days' 	=> '0.5',
							'end_date' 			=> $end_date,
							'hold_unhold' 		=> $_HOLD_EMPLOYEE,
							'days' 				=> $s_d[2],
							'month' 			=> $s_d[1],
							'year' 				=> $s_d[0],
							'note' 				=> '(' . $_POST['leave_in_type'] . ') Half Day Leave. ' . $note,
							'status' 			=> '1',
							'h_aproval' 		=> $d_head_aproval,
							'h_id' 				=> $d_head_id,
							'aproval' 			=> $aproval_hold,
							'uploader_info' 	=> uploader_info(),
							'data' 				=> date('d/m/Y')
						);
						$sd = explode('/', $start_date);
						$std = $sd[2] . '/' . $sd[1] . '/' . $sd[0];
						$every_day = date('d/m/Y', strtotime($std . ' + 0 days'));
						$ed = explode('/', $every_day);
						$leave_every_day_logs[] = array(
							'id' => '',
							'unique_id' => $unique_id,
							'h_days' => '0.5',
							'days' => $ed[0],
							'month' => $ed[1],
							'year' => $ed[2],
							'date_full' => $every_day,
							'status' => '1',
							'uploader_info' => uploader_info(),
							'data' => date('d/m/Y')
						);
						if (
							$this->Dashboard_model->insert_batch('employee_everyday_leave_logs', $leave_every_day_logs) and
							$this->Dashboard_model->insert('employee_leave_logs', $insert_leave_logs)
						) {
							$_UPLOADING = 1;
						} else {
							$_UPLOADING = 0;
						}
					}
				}
				if ($_UPLOADING == 1) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$emp_id = $_SESSION['user_info']['employee_id'];
			$get_department = $this->Dashboard_model->mysqlii("select * from employee where status = '1' and id = '" . $emp_id . "' and d_head = '1'");
			// $get_department_test = $this->Dashboard_model->mysqlii("select * from employee where status = '1' and id = ".$emp_id);
			$department = $get_department[0]->department;
			$branch = $get_department[0]->branch;

			$depart_employe = $this->Dashboard_model->mysqlii("select * from employee where department = '" . $department . "' and status = '1' order by employee_id asc");

			if (!empty($depart_employe[0]->id)) {
				$leave_ids = '';
				foreach ($depart_employe as $eow) {
					$leave_ids .= "'" . $eow->id . "',";
				}
				$final_ids = rtrim($leave_ids, ',');
				$data['leave_request_list'] = $this->Dashboard_model->mysqlii("select * from employee_leave_logs where e_db_id in (" . $final_ids . ") order by id desc limit 200");
			}

			if ($department == '1810685559802248792' or $department == '2392358440567352112' or $department == '528388997158023095') { // Branch filter not allicable for `Food and Beverage` & `Housekeeping` & `Security`
				$branch = "";
			} else {
				$branch = "and branch = '" . $branch . "'";
			}

			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where department = '" . $department . "' $branch and status = '1' order by employee_id asc");

			$data['department'] = $department;
			$data['title_info'] = 'Leave - Employee Leave Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_employee_leave_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit employee_subordinate_leave_request

	//---------Start payroll_employee_own_leave_request-------------
	public function payroll_employee_own_leave_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['apply'])) {
				$get_employees = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				if (!empty($_POST['h_aproval'])) {
					$d_head_aproval = 0;
					$d_head_id = $_POST['h_aproval'];
				} else {
					if ($get_employees->department == '1810685559802248792' or $get_employees->department == '2335318469842157306') {
						$get_department_head = $this->Dashboard_model->select('employee', array('department' => $get_employees->department, 'd_head' => '1', 'status' => '1'), 'id', 'desc', 'row');
					} else {
						$get_department_head = $this->Dashboard_model->select('employee', array('department' => $get_employees->department, 'd_head' => '1', 'branch' => $get_employees->branch, 'status' => '1'), 'id', 'desc', 'row');
					}
					$get_hr_head = $this->Dashboard_model->select('employee', array('department' => '1383007286312996344', 'd_head' => '1'), 'id', 'desc', 'row');
					if (!empty($get_department_head->id) and $get_department_head->id == $_SESSION['super_admin']['employee_id']) {
						if ($get_department_head->d_head_reporting != '0') {
							$d_head_aproval = 1;
							$d_head_id = $get_department_head->d_head_reporting;
						} else {
							$d_head_aproval = 0;
							$d_head_id = $get_hr_head->id;
						}
					} else {
						if (!empty($get_department_head->id)) {
							$d_head_aproval = 0;
							$d_head_id = $get_department_head->id;
						} else {
							$d_head_aproval = 0;
							$d_head_id = $get_hr_head->id;
						}
					}
				}


				$s_d = explode('-', $this->input->post('start_date'));
				$start_date = $s_d[2] . '/' . $s_d[1] . '/' . $s_d[0];
				$how_many_days = $this->input->post('how_many_days');
				$e_d = explode('-', $this->input->post('end_date'));
				$end_date = $e_d[2] . '/' . $e_d[1] . '/' . $e_d[0];
				$note = $this->input->post('note');
				$unique_id = rand() * time();
				$insert_leave_logs = array(
					'id' 				=> '',
					'unique_id' 		=> $unique_id,
					'e_db_id' 			=> $get_employees->id,
					'employee_id' 		=> $get_employees->employee_id,
					'start_days' 		=> $start_date,
					'how_many_days' 	=> $how_many_days,
					'end_date' 			=> $end_date,
					'hold_unhold' 		=> '0',
					'days' 				=> $e_d[2],
					'month' 			=> $e_d[1],
					'year' 				=> $e_d[0],
					'note' 				=> $note,
					'status' 			=> '1',
					'h_aproval' 		=> $d_head_aproval,
					'h_id' 				=> $d_head_id,
					'aproval' 			=> '0',
					'uploader_info' 	=> uploader_info(),
					'created_at' 		=> date('Y-m-d H:i:s'),
					'data' 				=> date('d/m/Y')
				);
				if($d_head_aproval = 0 OR $d_head_aproval = 3){
					$get_player_id = $this->Dashboard_model->mysqlij("SELECT player_id from employee where id = " . $d_head_id);
					$this->Dashboard_model->onesignal('Leave Approval of ' . $get_employees->full_name, 'Leave Approval', array($get_player_id->player_id));
				}

				for ($i = 0; $i < $how_many_days; $i++) {
					$sd = explode('/', $start_date);
					$std = $sd[2] . '/' . $sd[1] . '/' . $sd[0];
					$every_day = date('d/m/Y', strtotime($std . ' + ' . $i . ' days'));
					$ed = explode('/', $every_day);
					$leave_every_day_logs[] = array(
						'id' => '',
						'unique_id' => $unique_id,
						'h_days' => '1',
						'days' => $ed[0],
						'month' => $ed[1],
						'year' => $ed[2],
						'date_full' => $every_day,
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
				}
				$now = new DateTime(date('Y-m-d H:i:s'));
				$get_d_head = $this->Dashboard_model->select('employee', array('id' => $d_head_id), 'id', 'desc', 'row');

				// if(
				// 	$this->Dashboard_model->insert_batch('employee_everyday_leave_logs',$leave_every_day_logs) AND
				// 	$this->Dashboard_model->insert('employee_leave_logs',$insert_leave_logs) AND
				// 	$this->Dashboard_model->notificaiton_insert('notification', $notification_data)
				// ){
				// 	alert('success','Successfully Saved!');
				// 	redirect(current_url());
				// }else{
				// 	alert('danger','Something Wrong! Please Try Again');
				// 	redirect(current_url());
				// }
				if (
					$this->Dashboard_model->insert_batch('employee_everyday_leave_logs', $leave_every_day_logs) and
					$this->Dashboard_model->insert('employee_leave_logs', $insert_leave_logs)
				) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('employee_leave_logs', $this->input->post('delete_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['get_leave_today'])) {
				$get_employees = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				if (!empty($_POST['h_aproval'])) {
					$d_head_aproval = 0;
					$d_head_id = $_POST['h_aproval'];
				} else {
					if ($get_employees->department == '1810685559802248792' or $get_employees->department == '2335318469842157306') {
						$get_department_head = $this->Dashboard_model->select('employee', array('department' => $get_employees->department, 'd_head' => '1', 'status' => 1), 'id', 'desc', 'row');
					} else {
						$get_department_head = $this->Dashboard_model->select('employee', array('department' => $get_employees->department, 'd_head' => '1', 'branch' => $get_employees->branch, 'status' => 1), 'id', 'desc', 'row');
					}
					$get_hr_head = $this->Dashboard_model->select('employee', array('department' => '1383007286312996344', 'd_head' => '1'), 'id', 'desc', 'row');
					if (!empty($get_department_head->id) and $get_department_head->id == $_SESSION['super_admin']['employee_id']) {
						if ($get_department_head->d_head_reporting != '0') {
							$d_head_aproval = 1;
							$d_head_id = $get_department_head->d_head_reporting;
						} else {
							$d_head_aproval = 0;
							$d_head_id = $get_hr_head->id;
						}
					} else {
						if (!empty($get_department_head->id)) {
							$d_head_aproval = 0;
							$d_head_id = $get_department_head->id;
						} else {
							$d_head_aproval = 0;
							$d_head_id = $get_hr_head->id;
						}
					}
				}
				$gd = explode('-', $this->input->post('leave_date'));
				$get_date = $gd[2] . '/' . $gd[1] . '/' . $gd[0];
				$start_date = $get_date;
				$how_many_days = '0.5';
				$end_date = $get_date;
				$leave_in_type = $this->input->post('leave_in_type');
				$note = '(' . $leave_in_type . ') Half Day Leave. ' . $this->input->post('note');
				$unique_id = rand() * time();
				$insert_leave_logs = array(
					'id' 				=> '',
					'unique_id' 		=> $unique_id,
					'e_db_id' 			=> $get_employees->id,
					'employee_id' 		=> $get_employees->employee_id,
					'start_days' 		=> $start_date,
					'how_many_days' 	=> $how_many_days,
					'end_date' 			=> $end_date,
					'hold_unhold' 		=> '0',
					'days' 				=> $gd[2],
					'month' 			=> $gd[1],
					'year' 				=> $gd[0],
					'note' 				=> $note,
					'status' 			=> '1',
					'h_aproval' 		=> $d_head_aproval,
					'h_id' 				=> $d_head_id,
					'aproval' 			=> '0',
					'uploader_info' 	=> uploader_info(),
					'data' 				=> date('d/m/Y')
				);
				if($d_head_aproval = 0 OR $d_head_aproval = 3){
					$get_player_id = $this->Dashboard_model->mysqlij("SELECT player_id from employee where id = " . $d_head_id);
					$this->Dashboard_model->onesignal('Leave Approval of ' . $get_employees->full_name, 'Leave Approval', array($get_player_id->player_id));
				}
				$leave_every_day_logs = array(
					'id' => '',
					'unique_id' => $unique_id,
					'h_days' => '0.5',
					'days' => $gd[2],
					'month' => $gd[1],
					'year' => $gd[0],
					'date_full' => date('d/m/Y'),
					'status' => '1',
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if (
					$this->Dashboard_model->insert('employee_everyday_leave_logs', $leave_every_day_logs) and
					$this->Dashboard_model->insert('employee_leave_logs', $insert_leave_logs)
				) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$employee_id = $_SESSION['user_info']['employee_id'];
			$data['leave_request_list'] = $this->Dashboard_model->mysqlii("select * from employee_leave_logs where e_db_id = '" . $employee_id . "' order by id desc");
			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
			$data['title_info'] = 'Leave - Employee Own Leave Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_employee_own_leave_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_employee_own_leave_request


	//---------Start payroll_employee_own_withdraw_leave_request-------------
	public function payroll_employee_own_withdraw_leave_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {


			$employee_id = $_SESSION['user_info']['employee_id'];
			$data['leave_request_list'] = $this->Dashboard_model->mysqlii("select * from employee_leave_logs where e_db_id = '" . $employee_id . "' order by id desc");
			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");

			$data['title_info'] = 'Withdraw Leave - Employee Own Leave Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_employee_own_withdraw_leave_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_employee_own_withdraw_leave_request

	//---------Start leave_application_logs-------------
	public function leave_application_logs()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('employee_leave_logs', $this->input->post('delete_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['leave_request_list'] = $this->Dashboard_model->mysqlii("select * from employee_leave_logs order by id desc");
			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
			$data['title_info'] = 'Leave - Employee Leave Application Logs';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/leave_application_logs', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit leave_application_logs

	//---------Start hold_employee_logs --- --- --- --- ---
	public function hold_employee_logs()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			if (isset($_POST['unhold_employe'])) {
				$hold_employees = $this->Dashboard_model->select('hold_employe_logs', array('id' => $this->input->post('unhold_id')), 'id', 'desc', 'row');
				$get_employees = $this->Dashboard_model->select('employee', array('id' => $hold_employees->e_db_id), 'id', 'desc', 'row');
				$update_data = array(
					'status' => '1'
				);
				if (
					$this->Dashboard_model->update('employee', $update_data, $get_employees->id) and
					$this->Dashboard_model->delete('hold_employe_logs', $hold_employees->id)
				) {
					alert('success', 'Successfully Unholded!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('hold_employe_logs', $this->input->post('delete_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['hold_employee_list'] = $this->Dashboard_model->mysqlii("select * from hold_employe_logs order by id desc");
			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
			$data['title_info'] = 'Leave - Hold Employee Logs';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/hold_employee_logs', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit hold_employee_logs

	//---------Start payroll_leave_approval-------------
	public function payroll_leave_approval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Payroll - Leave Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_leave_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_leave_approval

	//---------Start payroll_leave_approval_department_head-------------
	public function payroll_leave_approval_department_head()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Payroll - Leave Approval Department Head';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_leave_approval_department_head', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_leave_approval_department_head


	//---------Start award_employee_performance-------------
	public function award_employee_performance()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				$mn = explode("-", $this->input->post('selected_month'));
				$month = $mn[1];
				$year = $mn[0];
				$month_year = $month . '/' . $year;
				$check_data = $this->Dashboard_model->select('employee_performance_logs', array('employee_id' => $this->input->post('employee_id'), 'month_year' => $month_year), 'id', 'desc', 'row');
				if (!empty($check_data)) {
					alert('danger', 'Performance bonus already added for this month');
					redirect(current_url());
				} else {
					$insert_data = array(
						'id' => '',
						'e_db_id' => $emp->id,
						'employee_id' => $emp->employee_id,
						'department' => $emp->department,
						'percentage' => abs($this->input->post('percentage')),
						'given_percentage' => abs($this->input->post('percentage')),
						'month' => $month,
						'year' => $year,
						'month_year' => $month_year,
						'note' => $this->input->post('note'),
						'aproval' => '0',
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					if ($this->Dashboard_model->insert('employee_performance_logs', $insert_data)) {
						alert('success', 'Successfully Saved!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('employee_performance_logs', $this->input->post('delete_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_performance_logs order by id DESC limit 200");
			$data['emp_list'] = $this->Dashboard_model->mysqlii("select * from employee where status = '1' order by employee_id asc");
			$data['title_info'] = 'Award - Employee Perfromance';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/award_employee_performance', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit award_employee_performance

	//---------Start employee_festival_award-------------
	public function employee_festival_award()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			$data['title_info'] = 'Award - Employee Festival Award';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/employee_festival_award', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit employee_festival_award

	//---------Start award_employee_performance_from_head-------------
	public function award_employee_performance_from_head()
	{

		$data = array();

		if (isset($_POST['CurrentMonth'])) {

			$filterYearMonth = $_POST['CurrentMonth'];
			$mnYr = explode("-", $filterYearMonth);
			$data['last_month'] = $mnYr[1];
			$data['last_year'] = $mnYr[0];
			$month = $mnYr[1];
			$year = $mnYr[0];
		} else {
			$data['last_month'] = '';
			$data['last_year'] = '';

			$month = '';
			$year = '';
		}

		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			// var_dump($_POST['submit_method']);
			// exit();
			if (isset($_POST['submit_method'])) {
				if ($_SESSION['user_info']['department'] == '749568347163692080') { // Auto approval for top management department.
					$_APROVAL = 1;
				} else {
					$_APROVAL = 0;
				}
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				$mn = explode("-", $this->input->post('selected_month'));
				$month = $mn[1];
				$year = $mn[0];
				$month_year = $month . '/' . $year;
				$check_data = $this->Dashboard_model->select('employee_performance_logs', array('employee_id' => $this->input->post('employee_id'), 'month_year' => $month_year), 'id', 'desc', 'row');
				var_dump($check_data);
				// exit();
				if (!empty($check_data)) {
					// alert('danger', 'Performance bonus all ready added in this month');
					// redirect(current_url());
				} else {
					$insert_data = array(
						'id' => '',
						'e_db_id' => $emp->id,
						'employee_id' => $emp->employee_id,
						'department' => $emp->department,
						'percentage' => abs($this->input->post('percentage')),
						'given_percentage' => abs($this->input->post('percentage')),
						'month' => $month,
						'year' => $year,
						'month_year' => $month_year,
						'note' => $this->input->post('note'),
						'aproval' => $_APROVAL,
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y'),
						'head_pay_cut' => $_POST['bonus_type'],
						'pay_cut' => $_POST['bonus_type']
					);

					if ($this->Dashboard_model->insert('employee_performance_logs', $insert_data)) {
						$insert_id = $this->db->insert_id();
						if ($_APROVAL == 1) {
							$insert_aproval_logs = array(
								'id' => '',
								'e_db_id' => $emp->id,
								'employee_id' => $emp->employee_id,
								'performance_id' => $insert_id,
								'aproval_type' => 'Approved',
								'note' => $this->input->post('note'),
								'status' => '1',
								'uploader_info' => uploader_info(),
								'data' => date('d/m/Y')
							);
							$this->Dashboard_model->insert('employee_performance_aproval_logs', $insert_aproval_logs);
						}
						// alert('success', 'Successfully Saved!');
						// redirect(current_url());
					} else {
						// alert('danger', 'Something Wrong! Please Try Again');
						// redirect(current_url());
					}
				}
				return;
			}
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('employee_performance_logs', $this->input->post('delete_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$department = $_SESSION['user_info']['department'];

			if ($department == '1806965207554226682') { // Branch operation
				$data['a'] = $this->Dashboard_model->mysqlii(
					"SELECT employee_performance_logs.id as delete_id, 
																		employee.photo, 
																		employee.employee_id,
																		employee.id, 
																		employee.full_name, 
																		employee_performance_logs.percentage, 
																		employee_performance_logs.month, 
																		employee_performance_logs.year,
																		employee_performance_logs.pay_cut, 
																		employee_performance_logs.note,employee_performance_logs.aproval, 
																		employee.uploader_info,
																		employee_performance_logs.e_db_id,
																		branches.branch_name as BranchName,
																		employee_monthly_sallary.employee_id as salary_already_given
																	FROM employee
																	LEFT JOIN employee_performance_logs 
																			ON employee.employee_id = employee_performance_logs.employee_id 
																			AND employee_performance_logs.month = '" . $month . "' 
																			AND employee_performance_logs.year = '" . $year . "' 
																		LEFT JOIN employee_monthly_sallary 
																			ON employee.employee_id = employee_monthly_sallary.employee_id 
																			AND employee_monthly_sallary.month = '" . $month . "' 
																			AND employee_monthly_sallary.year = '" . $year . "'
																		LEFT JOIN branches
																			ON employee.branch = branches.branch_id
																	WHERE  employee.branch = '" . $_SESSION['super_admin']['branch'] . "' 
																		AND employee.department = '" . $_SESSION['user_info']['department'] . "'
																		AND employee.employee_id != '" . $_SESSION['super_admin']['employee_ids'] . "' 
																		AND employee.status = '1'
																		order by employee_performance_logs.month desc"
				);
			} else if ($department == '2392358440567352112') { // Housekeeping
				if ($_SESSION['user_info']['designation'] == '3279772007133682635') { // Housekeeping incharge
					$data['a'] = $this->Dashboard_model->mysqlii(
						"SELECT employee_performance_logs.id as delete_id, 
																			employee.photo, 
																			employee.employee_id, 
																			employee.id, 
																			employee.full_name, 
																			employee_performance_logs.percentage, 
																			employee_performance_logs.month, 
																			employee_performance_logs.year,
																			employee_performance_logs.pay_cut, 
																			employee_performance_logs.note,
																			employee_performance_logs.aproval, 
																			employee.uploader_info,
																			employee_performance_logs.e_db_id,
																			branches.branch_name as BranchName,
																			employee_monthly_sallary.employee_id as salary_already_given
																			FROM employee
																			LEFT JOIN employee_performance_logs 
																				ON employee.employee_id = employee_performance_logs.employee_id 
																				AND employee_performance_logs.month = '" . $month . "'
																				AND employee_performance_logs.year = '" . $year . "'
																			LEFT JOIN employee_monthly_sallary 
																				ON employee.employee_id = employee_monthly_sallary.employee_id 
																				AND employee_monthly_sallary.month = '" . $month . "' 
																				AND employee_monthly_sallary.year = '" . $year . "'
																			LEFT JOIN branches
																				ON employee.branch = branches.branch_id
																			WHERE
																			employee.department = '" . $_SESSION['user_info']['department'] . "'
																			AND employee.employee_id != '" . $_SESSION['super_admin']['employee_ids'] . "'
																			AND employee.status = '1'
																			order by employee_performance_logs.month desc"
					);
				}
			} else if ($department == '749568347163692080') { // Top Management
				$data['a'] = $this->Dashboard_model->mysqlii(
					"SELECT employee_performance_logs.id as delete_id, 
																		employee.photo, 
																		employee.employee_id, 
																		employee.id, employee.full_name, 
																		employee_performance_logs.percentage, 
																		employee_performance_logs.month,
																		employee_performance_logs.year, 
																		employee_performance_logs.pay_cut, 
																		employee_performance_logs.note, 
																		employee_performance_logs.aproval, 
																		employee.uploader_info,
																		employee_performance_logs.e_db_id,
																		branches.branch_name as BranchName,
																		employee_monthly_sallary.employee_id as salary_already_given
																		FROM employee
																		LEFT JOIN employee_performance_logs 
																			ON employee.employee_id = employee_performance_logs.employee_id 
																			AND employee_performance_logs.month = '" . $month . "' 
																			AND employee_performance_logs.year = '" . $year . "'
																		LEFT JOIN employee_monthly_sallary 
																			ON employee.employee_id = employee_monthly_sallary.employee_id
																			AND employee_monthly_sallary.month = '" . $month . "' 
																			AND employee_monthly_sallary.year = '" . $year . "'
																		LEFT JOIN branches
																			ON employee.branch = branches.branch_id
																		WHERE ( employee.d_head = '1' OR employee.department != '" . $_SESSION['user_info']['department'] . "' )
																		AND employee.employee_id != '" . $_SESSION['super_admin']['employee_ids'] . "'
																		AND employee.status = '1'
																		order by employee_performance_logs.month desc"
				);
			} else {
				$data['a'] = $this->Dashboard_model->mysqlii(
					"SELECT employee_performance_logs.id as delete_id, 
																		employee.photo, 
																		employee.employee_id, 
																		employee.id, 
																		employee.full_name, 
																		employee_performance_logs.percentage, 
																		employee_performance_logs.month, 
																		employee_performance_logs.year,
																		employee_performance_logs.pay_cut, 
																		employee_performance_logs.note , 
																		employee_performance_logs.aproval, 
																		employee.uploader_info,
																		employee_performance_logs.e_db_id,
																		branches.branch_name as BranchName,
																		employee_monthly_sallary.employee_id as salary_already_given 
																		FROM employee
																		LEFT JOIN employee_performance_logs 
																		ON employee.employee_id = employee_performance_logs.employee_id 
																			AND employee_performance_logs.month = '" . $month . "'
																			AND employee_performance_logs.year = '" . $year . "' 
																			LEFT JOIN employee_monthly_sallary 
																			ON employee.employee_id = employee_monthly_sallary.employee_id
																			AND employee_monthly_sallary.month = '" . $month . "' 
																			AND employee_monthly_sallary.year = '" . $year . "'
																		LEFT JOIN branches
																			ON employee.branch = branches.branch_id
																				WHERE employee.department = '" . $_SESSION['user_info']['department'] . "'
																					AND employee.employee_id != '" . $_SESSION['super_admin']['employee_ids'] . "' 
																					AND employee.status = '1'
																					order by employee_performance_logs.month desc"
				);
			}

			if ($_SESSION['super_admin']['user_type'] == 'Super Admin') {
				$data['a'] = $this->Dashboard_model->mysqlii("SELECT employee_performance_logs.id as delete_id, 
																		employee.photo, 
																		employee.employee_id, 
																		employee.id, 
																		employee.full_name, 
																		employee_performance_logs.percentage, 
																		employee_performance_logs.month, 
																		employee_performance_logs.year,
																		employee_performance_logs.pay_cut, 
																		employee_performance_logs.note , 
																		employee_performance_logs.aproval, 
																		employee.uploader_info,
																		employee_performance_logs.e_db_id,
																		branches.branch_name as BranchName,
																		employee_monthly_sallary.employee_id as salary_already_given
																		FROM employee 
																		LEFT JOIN employee_performance_logs 
																		ON employee.employee_id = employee_performance_logs.employee_id 
																			AND employee_performance_logs.month = '" . $month . "' 
																			AND employee_performance_logs.year = '" . $year . "'
																		 LEFT JOIN employee_monthly_sallary 
																		 	ON employee.employee_id = employee_monthly_sallary.employee_id
																			AND employee_monthly_sallary.month = '" . $month . "' 
																			AND employee_monthly_sallary.year = '" . $year . "'
																		LEFT JOIN branches
																			ON employee.branch = branches.branch_id
																		WHERE ( employee.d_head = '1' 
																			OR employee.department = '" . $_SESSION['user_info']['department'] . "' ) 
																			AND employee.employee_id != '" . $_SESSION['super_admin']['employee_ids'] . "'
																			AND employee.status = '1'
																			AND employee.designation_name not like '%Housekeeping Supervisor%'
																		order by employee_performance_logs.month desc");
			}


			$data['title_info'] = 'Award - Employee Perfromance Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/award_employee_performance', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit award_employee_performance_from_head




	//---------Start award_performance_approval-------------
	public function award_performance_approval($month_year = null)
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['month_year'] = $month_year;
			$data['title_info'] = 'Award - Employee Performance Request Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/award_performance_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit award_performance_approval

	//---------Start award_performance_approval-------------
	public function award_performance_approval_hr()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Award - Employee Performance Request Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/award_performance_approval_hr', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit award_performance_approval




	//---------Start employee_own_resign_request-------------
	public function employee_own_resign_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['apply'])) {
				$emp_id = $this->input->post('employee_id');
				$resign_date = $this->input->post('resign_date');
				$get_data = $this->Dashboard_model->select('employee', array('id' => $emp_id), 'id', 'desc', 'row');
				$department  = $get_data->department;

				$has_active_resign_request = $this->Dashboard_model->mysqlii("select id from employee_resign_request where e_db_id = '".$emp_id."' AND aproval = '0' order by id desc");
				if(!empty($has_active_resign_request[0]->id)){
					alert('danger', 'You have already applied!');
					redirect(current_url());
				}

				if($get_data->department == '1806965207554226682' OR $get_data->department == '2392358440567352112' ){ // Housekeeping OR Branch Operation
					$get_d_head = $this->Dashboard_model->select('employee', array('department' => $department, 'd_head' => '1', 'branch' => $get_data->branch), 'id', 'desc', 'row');
				}else{
					$get_d_head = $this->Dashboard_model->select('employee', array('department' => $department, 'd_head' => '1'), 'id', 'desc', 'row');
				}
				if (!empty($get_d_head->employee_id)) {
					if ($get_d_head->id == $get_data->id) {
						$get_head_reporting = $this->Dashboard_model->select('employee', array('id' => $get_data->d_head_reporting), 'id', 'desc', 'row');
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
					$application = $this->input->post('application');
					$insert_data_hr = array(
						'id' 					=> '',
						'e_db_id' 				=> $get_data->id,
						'employee_id' 			=> $get_data->employee_id,
						'department_head_id' 	=> $d_head_id,
						'department_head_e_id' 	=> $d_head_e_id,
						'application' 			=> $application,
						'aproval' 				=> $aproval,
						'note' 					=> '',
						'status' 				=> '1',
						'uploader_info' 		=> uploader_info(),
						'data' 					=> date('d/m/Y')
					);
					$this->Dashboard_model->insert('employee_resign_request_to_hr', $insert_data_hr);
				}

				$application = $this->input->post('application');
				$insert_data = array(
					'id' 					=> '',
					'e_db_id' 				=> $get_data->id,
					'employee_id' 			=> $get_data->employee_id,
					'department_head_id' 	=> $d_head_id,
					'department_head_e_id' 	=> $d_head_e_id,
					'application' 			=> $application,
					'aproval' 				=> $aproval,
					'note' 					=> '',
					'status' 				=> '1',
					'uploader_info' 		=> uploader_info(),
					'data' 					=> date('d/m/Y'),
					'resign_date'			=> $resign_date,
				);

				$update_date_logs = array(
					'id' => '',
					'employee_id' => $get_data->employee_id,
					'old_date' => $get_data->data,
					'new_date' => date('d/m/Y'),
					'note' => 'employee_own_resign_request',
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				$update_date = array(
					'data' => date('d/m/Y')
				);

				if (
					$this->Dashboard_model->insert('employee_resign_request', $insert_data) and
					$this->Dashboard_model->insert('emp_release_date_update_logs', $update_date_logs) and
					$this->Dashboard_model->update('employee', $update_date, $get_data->id)
				) {
					alert('success', 'Successfully Submited!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['petty_balance'] = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $_SESSION['user_info']['employee_id']),'id','DESC','row');

			$data['title_info'] = 'Payroll - Employee Resign Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/employee_own_resign_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//---------end exit employee_own_resign_request----------

	//---------Start employee_recruitment_request-------------
	public function employee_recruitment_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			$head_requirement_emp_apov = $this->Dashboard_model->mysqlii("select * from employee_recruitment_request where department_head_notify = '1' and department = '" . $_SESSION['user_info']['department'] . "'");
			if (!empty($head_requirement_emp_apov)) {
				foreach ($head_requirement_emp_apov as $row) {
					$data_auto = array(
						'department_head_notify' => '0'
					);
					$this->Dashboard_model->update('employee_recruitment_request', $data_auto, $row->id);
				}
			}

			if (isset($_POST['send_request'])) {
				$data = array(
					'id' 						=> '',
					'department' 				=> $_SESSION['user_info']['department'],
					'designation' 				=> $this->input->post('designation_id'),
					'number_of_people' 			=> $this->input->post('number_of_people'),
					'exixting_people' 			=> $this->input->post('exixting_people'),
					'job_title' 			    => $this->input->post('job_title'),
					'salary' 			        => $this->input->post('salary'),
					'job_responsibility' 		=> $this->input->post('job_responsibility'),
					'required_date' 			=> date_converter($this->input->post('required_date')),
					'note' 						=> $this->input->post('note'),
					'boss_aproval'			 	=> '0',
					'department_head_notify' 	=> '0',
					'hr_notify' 				=> '0',
					'status' 					=> '1',
					'uploader_info' 			=> uploader_info(),
					'data' 						=> date('d/m/Y')
				);
				if ($this->Dashboard_model->insert('employee_recruitment_request', $data)) {
					alert('success', 'Successfully Request Sended!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['delete_data'])) {
				if ($this->Dashboard_model->delete('employee_recruitment_request', $this->input->post('hidden_id'))) {
					alert('success', 'Successfully Removed!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['table'] = $this->Dashboard_model->mysqlii("select * from employee_recruitment_request where department = '" . $_SESSION['user_info']['department'] . "' order by id desc limit 200");
			$data['designation'] = $this->Dashboard_model->mysqlii("select * from designation");
			$data['title_info'] = 'Payroll - Employee Recruitment Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/employee_recruitment_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//---------end exit employee_recruitment_request----------

	//---------Start employee_recruitment_approval-------------
	public function employee_recruitment_approval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['accept_data'])) {
				$get_data = $this->Dashboard_model->mysqlii("select * from employee_recruitment_request where id = '" . $this->input->post('hidden_id') . "'");
				$data = array(
					'number_of_people' 			=> $this->input->post('number_of_people'),
					'boss_aproval'			 	=> '1',
					'department_head_notify' 	=> '1',
					'hr_notify' 				=> '1'
				);
				$data_logs = array(
					'id' 						=> '',
					'aproval_id' 				=> $get_data[0]->id,
					'number_of_people' 			=> $this->input->post('number_of_people'),
					'note' 						=> $this->input->post('note'),
					'status' 					=> '1',
					'uploader_info'		 		=> uploader_info(),
					'data' 						=> date('d/m/Y')
				);
				
				$data_circular = array(
					'job_title' 				=> $get_data[0]->job_title,
					'salary' 					=> $get_data[0]->salary,
					'department_id' 			=> $get_data[0]->department,
					'designation_id' 			=> $get_data[0]->designation,
					'job_description' 			=> $get_data[0]->job_responsibility,
					'job_deadline' 			=> $get_data[0]->required_date,
					'created_at' 			=> date('d/m/Y'),
				);
				
				
				if (
					$this->Dashboard_model->update('employee_recruitment_request', $data, $get_data[0]->id) and
					$this->Dashboard_model->insert('employee_recruitment_approval_logs', $data_logs) and 
					$this->Dashboard_model->insert('ciculars', $data_circular)
				) {
					alert('success', 'Successfully Request Approved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['reject_data'])) {
				$data = array(
					'boss_aproval'			 	=> '2'
				);
				if ($this->Dashboard_model->update('employee_recruitment_request', $data, $this->input->post('hidden_id'))) {
					alert('success', 'Successfully Request Rejected!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['table'] = $this->Dashboard_model->mysqlii("select * from employee_recruitment_request where boss_aproval in ('0','1') order by id desc limit 200");
			$data['designation'] = $this->Dashboard_model->mysqlii("select * from designation");
			$data['title_info'] = 'Payroll - Employee Recruitment Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/employee_recruitment_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//---------end exit employee_recruitment_approval----------

	//---------Start recruitment_approved_logs-------------HR
	public function recruitment_approved_logs()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {


			$data['table'] = $this->Dashboard_model->mysqlii("select * from employee_recruitment_request where boss_aproval = '1' order by id desc limit 200");
			$data['designation'] = $this->Dashboard_model->mysqlii("select * from designation");
			$data['title_info'] = 'Payroll - Employee Recruitment Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/employee_recruitment_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//---------end exit recruitment_approved_logs----------

	//---------Start employee_leave_widthdraw_request-------------HR
	public function employee_leave_widthdraw_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['accept_data_btn'])) {
				$get_data = $this->Dashboard_model->mysqlii("select * from employee_everyday_withdraw_logs where id = '" . $this->input->post('hidden_id') . "'");
				$get_leave_data = $this->Dashboard_model->mysqlii("select * from employee_leave_logs where unique_id = '" . $get_data[0]->unique_id . "'");
				$approval_logs_data = array(
					'id' => '',
					'e_db_id' => $get_leave_data[0]->e_db_id,
					'employee_id' => $get_leave_data[0]->employee_id,
					'leave_id' => $get_leave_data[0]->id,
					'aproval_type' => 'Approved',
					'note' => '',
					'status' => '1',
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				$approved_date = explode(',', $get_data[0]->withdraw_ids);
				foreach ($approved_date as $row) {
					$update_leave_data = array(
						'status' => '0'
					);
					$this->Dashboard_model->update('employee_everyday_leave_logs', $update_leave_data, $row);
				}
				$update_request_data = array(
					'approval' => '1'
				);

				if (
					$this->Dashboard_model->update('employee_everyday_withdraw_logs', $update_request_data, $get_data[0]->id) and
					$this->Dashboard_model->insert('leave_widthdraw_approval_logs', $approval_logs_data)
				) {
					alert('success', 'Successfully Request Approved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['reject_data'])) {
				$data = array(
					'approval' => '2'
				);
				$get_data = $this->Dashboard_model->mysqlii("select * from employee_everyday_withdraw_logs where id = '" . $this->input->post('hidden_id') . "'");
				$get_leave_data = $this->Dashboard_model->mysqlii("select * from employee_leave_logs where unique_id = '" . $get_data[0]->unique_id . "'");
				$approval_logs_data = array(
					'id' => '',
					'e_db_id' => $get_leave_data[0]->e_db_id,
					'employee_id' => $get_leave_data[0]->employee_id,
					'leave_id' => $get_leave_data[0]->id,
					'aproval_type' => 'Rejected',
					'note' => '',
					'status' => '1',
					'uploader_info' => uploader_info(),
					'data' => date('d/m/Y')
				);
				if (
					$this->Dashboard_model->update('employee_everyday_withdraw_logs', $data, $this->input->post('hidden_id')) and
					$this->Dashboard_model->insert('leave_widthdraw_approval_logs', $approval_logs_data)
				) {
					alert('success', 'Successfully Request Rejected!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}


			$emp_id = $_SESSION['user_info']['employee_id'];
			$data['table'] = $this->Dashboard_model->mysqlii("select * from employee_everyday_withdraw_logs where d_head_id = '" . $emp_id . "' order by id desc limit 200");
			$data['designation'] = $this->Dashboard_model->mysqlii("select * from designation");
			$data['title_info'] = 'Payroll - Employee Recruitment Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/employee_leave_widthdraw_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//---------end exit employee_leave_widthdraw_request----------

	//---------Start payroll_resign_employee_approval-------------
	public function payroll_resign_employee_approval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			if (isset($_POST['aprove_data'])) {
				$id = $this->input->post('aprove_id');
				$note = $this->input->post('extra_note');
				$get_data = $this->Dashboard_model->select('employee_resign_request', array('e_db_id' => $id), 'id', 'desc', 'row');

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
					'uploader_info' 		=> uploader_info(),
					'data' 					=> date('d/m/Y')
				);

				// $update_data = array(
				// 	'aproval' => '1',
				// 	'note' => $note
				// );				

				if (
					$this->Dashboard_model->insert('employee_resign_request_to_hr', $insert_data_hr) and
					$this->Dashboard_model->mysqliq("UPDATE employee_resign_request set aproval = 1, note = '$note' where e_db_id = $id")
				) {
					alert('success', 'Successfully Approved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['reject_data'])) {
				$id = $this->input->post('reject_id');
				$get_id = $this->Dashboard_model->mysqlii("select id from employee_resign_request where e_db_id = '".$id."' and aproval = 0 order by id desc ");
				
				$note = $this->input->post('note');
				if ($this->Dashboard_model->mysqliq("UPDATE employee_resign_request set aproval = 2, note = '$note' where id = '".$get_id[0]->id."'")) {
					alert('success', 'Successfully Rejected!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$emp_id = $_SESSION['user_info']['employee_id'];
			$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_resign_request where department_head_id  = '" . $emp_id . "' and aproval = '0' order by id desc limit 200");
			$data['title_info'] = 'Payroll - Resign Employee Request Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_resign_employee_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_resign_employee_approval

	//---------Start payroll_resign_employee_approval_hr-------------
	public function payroll_resign_employee_approval_hr()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {

			if (isset($_POST['aprove_data'])) {
				// $dac_date = explode('-',$this->input->post('deactive_Date'));
				// $actual_date = $dac_date[2].'/'.$dac_date[1].'/'.$dac_date[0];
				$deactive_note = $this->input->post('extra_note');
				$d_emp = $this->Dashboard_model->select('employee', array('id' => $this->input->post('aprove_id')), 'id', 'ASC', 'row');

				foreach ($this->input->post('aproval_employee') as $row) {
					$a_emp = $this->Dashboard_model->select('employee', array('employee_id' => $row), 'id', 'ASC', 'row');
					$exit_insert_data[] = array(
						'id' 					=> '',
						'e_db_id' 				=> $a_emp->id,
						'employee_id' 			=> $a_emp->employee_id,
						'exit_emp_id' 			=> $d_emp->id,
						'exit_emp_employee_id' 	=> $d_emp->employee_id,
						'aproval' 				=> '0',
						'deactive_note' 		=> $deactive_note,
						'note' 					=> '',
						'status' 				=> '1',
						'uploader_info' 		=> uploader_info(),
						'data'					=> date('d/m/Y')
					);
				}
				$insert_data_hr = array(
					'id' 					=> '',
					'e_db_id' 				=> $d_emp->id,
					'employee_id' 			=> $d_emp->employee_id,
					'aproval' 				=> '0',
					'note' 					=> '',
					'status' 				=> '1',
					'uploader_info' 		=> uploader_info(),
					'data'					=> date('d/m/Y')
				);
				if (
					$this->Dashboard_model->insert_batch('exit_employee_chain_aproval', $exit_insert_data) and
					$this->Dashboard_model->insert('exit_employee_chain_hr', $insert_data_hr)
				) {
					alert('success', 'Save Successfully!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please try Again');
					redirect(current_url());
				}
			}

			if (isset($_POST['reject_data'])) {
				$id = $this->input->post('reject_id');
				$note = $this->input->post('note');
				$update_data = array(
					'aproval' => '2',
					'note' => $note
				);
				if ($this->Dashboard_model->update('employee_resign_request_to_hr', $update_data, $id)) {
					alert('success', 'Successfully Rejected!');
					redirect(base_url('admin/notification/payroll/fired-employee-chain-approval-hr'));
					// redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			$data['for_hr_flag'] = '1';
			$get_hr_head = $this->Dashboard_model->select('employee', array('department' => '1383007286312996344', 'd_head' => '1'), 'id', 'desc', 'row');
			$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_resign_request_to_hr where department_head_id = '" . $get_hr_head->id . "' and aproval = '0' order by id desc limit 200");
			$data['title_info'] = 'Payroll - Resign Employee Request Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_resign_employee_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_resign_employee_approval_hr

	//---------Start profile_my_profile-------------
	public function profile_my_profile()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'My Profile';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/profile_my_profile', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit profile_my_profile

	//---------Start emp_info_from_card-------------
	public function emp_info_from_card($employee_db_id = '')
	{
		$data = array();
		if (!empty($employee_db_id)) {
			$id = rahat_decode($employee_db_id);
			$emp = $this->Dashboard_model->select('employee', array('id' => $id), 'id', 'desc', 'row');
			$data['emp'] = $emp;
			$data['title_info'] = $emp->full_name . ' -  Neways International';
			$data['article'] = $this->load->view('template/hrm/emp_info_from_card', $data, TRUE);
			$this->load->view('dashboard', $data);
		} else {
			redirect(current_url());
		}
	}
	//end exit emp_info_from_card

	//---------Start payroll_ta_da_request-------------
	public function payroll_ta_da_request()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['save'])) {
				$emp = $this->Dashboard_model->select('employee', array('employee_id' => $this->input->post('employee_id')), 'id', 'desc', 'row');
				$d = explode('-', $this->input->post('transport_date'));
				$transport_date = $d[2] . '/' . $d[1] . '/' . $d[0];
				if ($emp->department == '1806965207554226682' OR $emp->department == '2392358440567352112') { // Branch filter applicable only for branch operation department AND housekeeping!
					$department_head = $this->Dashboard_model->select('employee', array('department' => $emp->department, 'd_head' => '1', 'branch' => $emp->branch), 'id', 'desc', 'row');
				} else {
					$department_head = $this->Dashboard_model->select('employee', array('department' => $emp->department, 'd_head' => '1'), 'id', 'desc', 'row');
				}
				if (!empty($department_head->id)) {
					if ($department_head->id == $emp->id) {
						$department_head_aproval = '1';
					} else {
						$department_head_aproval = '0';
					}
					$department_head_id = $department_head->id;
				} else {
					/**
					 * Old Code
					 */

					// $department_head_aproval = '1';
					// $department_head_id = '';

					/**
					 * HR HEAD
					 */
					$hr_head = $this->Dashboard_model->select('employee', array('department' => '1383007286312996344', 'd_head' => '1'), 'id', 'desc', 'row');
					$department_head_aproval = '0';
					$department_head_id = $hr_head->id;
				}
				$vicle_type = implode(",", $this->input->post('vehicle_type'));
				if ($_FILES['bill_attachment']['name'] != '') {
					$bill_attachment = file_upload_ta_da('bill_attachment');
				} else {
					$bill_attachment = '';
				}
				if ($this->input->post('destination_from') == 1) {
					$destination_from = 'Other: ' . $this->input->post('from_other');
				} else {
					$destination_from = $this->input->post('destination_from');
				}
				if ($this->input->post('destination_to') == 1) {
					$destination_to = 'Other: ' . $this->input->post('to_other');
				} else {
					$destination_to = $this->input->post('destination_to');
				}
				$insert_data = array(
					'id' 						=> '',
					'e_db_id' 					=> $emp->id,
					'employee_id' 				=> $emp->employee_id,
					'department_head_id'		=> $department_head_id,
					'destination_from' 			=> $destination_from,
					'destination_to' 			=> $destination_to,
					'transport_date' 			=> $transport_date,
					'transport_type' 			=> $this->input->post('transport_type'),
					'transport_details' 		=> $this->input->post('transport_details'),
					'transport_amount' 			=> $this->input->post('transport_amount'),
					'food_amount' 				=> $this->input->post('food_amount'),
					'vehicle_type' 				=> $vicle_type,
					'vehicle_type_reason' 		=> $this->input->post('vehicle_type_reason'),
					'bill_attachment' 			=> $bill_attachment,
					'note' 						=> $this->input->post('note'),
					'status' 					=> '1',
					'department_head_aproval' 	=> $department_head_aproval,
					'boss_aproval' 				=> '0',
					'accounts_aproval' 			=> '0',
					'self_aproval' 				=> '0',
					'uploader_info' 			=> uploader_info(),
					'data'						=> date('d/m/Y')
				);
				if ($this->Dashboard_model->insert('employee_ta_da_bill_logs', $insert_data)) {
					alert('success', 'Successfully Saved!');
					redirect(current_url());
				} else {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				}
			}
			if (isset($_POST['delete_data'])) {
				$row = $this->Dashboard_model->mysqlii("select * from employee_ta_da_bill_logs where id = '" . $this->input->post('delete_id') . "' order by id DESC");
				if ($row->self_aproval == 1 or $row->accounts_aproval == 1 or $row->accounts_aproval == 1 or $row->department_head_aproval == 1) {
					alert('danger', 'Something Wrong! Please Try Again');
					redirect(current_url());
				} else {
					if ($this->Dashboard_model->delete('employee_ta_da_bill_logs', $this->input->post('delete_id'))) {
						alert('success', 'Successfully Removed!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			$sin_emp = $this->Dashboard_model->select('employee', array('id' => $_SESSION['user_info']['employee_id']), 'id', 'desc', 'row');
			if (!empty($sin_emp->id)) {
				$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_ta_da_bill_logs where e_db_id = '" . $sin_emp->id . "' order by id DESC");
			}
			$data['title_info'] = 'Payroll - TA / DA Request';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/payroll_ta_da_request', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit payroll_ta_da_request

	//---------Start employee_ta_da_aproval-------------
	public function employee_ta_da_aproval($aproval_page = '')
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if ($aproval_page == 'department_head') {
				if (isset($_POST['approve_selected_button'])) {
					foreach ($_POST['selected_ids'] as $selected_id) {
						$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $selected_id), 'id', 'DESC', 'row');
						$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
						$update_data = array(
							'department_head_aproval' => '1'
						);
						$insert_data = array(
							'id' 				=> '',
							'e_db_id' 			=> $a_emp->id,
							'employee_id' 		=> $a_emp->employee_id,
							'ta_request_id' 	=> $info->id,
							'aproval_type'		=> 'Approved',
							'note' 				=> 'Approved By Hepartment Head (' . $a_emp->full_name . ')',
							'status' 			=> '1',
							'uploader_info' 	=> uploader_info(),
							'data' 				=> date('d/m/Y')
						);
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id);
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data);
					}
					alert('success', 'Aprove Successfully!');
					redirect(current_url());
				}

				if (isset($_POST['reject_selected_button'])) {
					foreach ($_POST['selected_ids'] as $selected_id) {
						$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $selected_id), 'id', 'DESC', 'row');
						$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
						$update_data = array(
							'department_head_aproval' => '2'
						);
						$insert_data = array(
							'id' 				=> '',
							'e_db_id' 			=> $a_emp->id,
							'employee_id' 		=> $a_emp->employee_id,
							'ta_request_id' 	=> $info->id,
							'aproval_type'		=> 'Rejected',
							'note' 				=> 'Rejected By Hepartment Head (' . $a_emp->full_name . ')',
							'status' 			=> '1',
							'uploader_info' 	=> uploader_info(),
							'data' 				=> date('d/m/Y')
						);
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id);
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data);
					}
					alert('success', 'Rejected Successfully!');
					redirect(current_url());
				}
				if (isset($_POST['aprove_data'])) {
					$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $this->input->post('hidden_id')), 'id', 'DESC', 'row');
					$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
					$update_data = array(
						'department_head_aproval' => '1'
					);
					$insert_data = array(
						'id' 				=> '',
						'e_db_id' 			=> $a_emp->id,
						'employee_id' 		=> $a_emp->employee_id,
						'ta_request_id' 	=> $info->id,
						'aproval_type'		=> 'Approved',
						'note' 				=> 'Approved By Hepartment Head (' . $a_emp->full_name . ')',
						'status' 			=> '1',
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					if (
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id) and
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data)
					) {
						alert('success', 'Aprove Successfully!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please try Again');
						redirect(current_url());
					}
				}
				if (isset($_POST['reject_data'])) {
					$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $this->input->post('hidden_id')), 'id', 'DESC', 'row');
					$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
					$update_data = array(
						'department_head_aproval' => '2'
					);
					$insert_data = array(
						'id' 				=> '',
						'e_db_id' 			=> $a_emp->id,
						'employee_id' 		=> $a_emp->employee_id,
						'ta_request_id' 	=> $info->id,
						'aproval_type'		=> 'Rejected',
						'note' 				=> 'Rejected By Hepartment Head (' . $a_emp->full_name . ')',
						'status' 			=> '1',
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					if (
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id) and
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data)
					) {
						alert('success', 'Rejected Successfully!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please try Again');
						redirect(current_url());
					}
				}
				$sin_emp = $this->Dashboard_model->select('employee', array('id' => $_SESSION['user_info']['employee_id']), 'id', 'desc', 'row');
				if (!empty($sin_emp->id)) {
					$data['emp_list_table'] = $this->Dashboard_model->mysqlii("SELECT * from employee_ta_da_bill_logs where department_head_id = '" . $sin_emp->id . "' order by id DESC");
				}
				$data['title_info'] = 'Payroll - Employee TA / DA Request Approval';
				$data['header'] = $this->load->view('include/header', '', TRUE);
				$data['nav'] = $this->load->view('include/nav', '', TRUE);
				$data['article'] = $this->load->view('template/hrm/payroll/employee_td_da_approval', $data, TRUE);
				$data['footer'] = $this->load->view('include/footer', '', TRUE);
				$this->load->view('dashboard', $data);
			} else if ($aproval_page == 'boss') { //===========BOSS
				if (isset($_POST['approve_selected_button'])) {
					foreach ($_POST['selected_ids'] as $selected_id) {
						$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $selected_id), 'id', 'DESC', 'row');
						$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
						$update_data = array(
							'boss_aproval' => '1'
						);
						$insert_data = array(
							'id' 				=> '',
							'e_db_id' 			=> $a_emp->id,
							'employee_id' 		=> $a_emp->employee_id,
							'ta_request_id' 	=> $info->id,
							'aproval_type'		=> 'Approved',
							'note' 				=> 'Approved By Boss (' . $a_emp->full_name . ')',
							'status' 			=> '1',
							'uploader_info' 	=> uploader_info(),
							'data' 				=> date('d/m/Y')
						);
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id);
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data);
					}
					alert('success', 'Aprove Successfully!');
					redirect(current_url());
				}

				if (isset($_POST['reject_selected_button'])) {
					foreach ($_POST['selected_ids'] as $selected_id) {
						$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $selected_id), 'id', 'DESC', 'row');
						$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
						$update_data = array(
							'boss_aproval' => '2'
						);
						$insert_data = array(
							'id' 				=> '',
							'e_db_id' 			=> $a_emp->id,
							'employee_id' 		=> $a_emp->employee_id,
							'ta_request_id' 	=> $info->id,
							'aproval_type'		=> 'Rejected',
							'note' 				=> 'Rejected By Boss (' . $a_emp->full_name . ')',
							'status' 			=> '1',
							'uploader_info' 	=> uploader_info(),
							'data' 				=> date('d/m/Y')
						);
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id);
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data);
					}
					alert('success', 'Rejected Successfully!');
					redirect(current_url());
				}
				if (isset($_POST['aprove_data'])) {
					$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $this->input->post('hidden_id')), 'id', 'DESC', 'row');
					$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
					$update_data = array(
						'boss_aproval' => '1'
					);
					$insert_data = array(
						'id' 				=> '',
						'e_db_id' 			=> $a_emp->id,
						'employee_id' 		=> $a_emp->employee_id,
						'ta_request_id' 	=> $info->id,
						'aproval_type'		=> 'Approved',
						'note' 				=> 'Approved By Boss (' . $a_emp->full_name . ')',
						'status' 			=> '1',
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					if (
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id) and
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data)
					) {
						alert('success', 'Aprove Successfully!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please try Again');
						redirect(current_url());
					}
				}
				if (isset($_POST['reject_data'])) {
					$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $this->input->post('hidden_id')), 'id', 'DESC', 'row');
					$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
					$update_data = array(
						'boss_aproval' => '2'
					);
					$insert_data = array(
						'id' 				=> '',
						'e_db_id' 			=> $a_emp->id,
						'employee_id' 		=> $a_emp->employee_id,
						'ta_request_id' 	=> $info->id,
						'aproval_type'		=> 'Rejected',
						'note' 				=> 'Rejected By Boss (' . $a_emp->full_name . ')',
						'status' 			=> '1',
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					if (
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id) and
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data)
					) {
						alert('success', 'Rejected Successfully!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please try Again');
						redirect(current_url());
					}
				}
				if ($_SESSION['user_info']['department'] == '749568347163692080') {
					$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_ta_da_bill_logs where department_head_aproval = '1' order by id DESC");
				}
				$data['title_info'] = 'Payroll - Employee TA / DA Request Approval';
				$data['header'] = $this->load->view('include/header', '', TRUE);
				$data['nav'] = $this->load->view('include/nav', '', TRUE);
				$data['article'] = $this->load->view('template/hrm/payroll/employee_td_da_approval_boss', $data, TRUE);
				$data['footer'] = $this->load->view('include/footer', '', TRUE);
				$this->load->view('dashboard', $data);
			} else if ($aproval_page == 'account') { //===========Accounts
				if (isset($_POST['aprove_data'])) {
					$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $this->input->post('hidden_id')), 'id', 'DESC', 'row');
					$r_emp = $this->Dashboard_model->select('employee', array('id' => $info->e_db_id), 'id', 'ASC', 'row');
					$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
					$update_data = array(
						'accounts_aproval' => '1'
					);
					$insert_data = array(
						'id' 				=> '',
						'e_db_id' 			=> $a_emp->id,
						'employee_id' 		=> $a_emp->employee_id,
						'ta_request_id' 	=> $info->id,
						'aproval_type'		=> 'Approved',
						'note' 				=> 'Approved By Accounts (' . $a_emp->full_name . ')',
						'status' 			=> '1',
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					if (!empty($info->food_amount) and $info->food_amount > 0) {
						$da_amount = $info->food_amount;
					} else {
						$da_amount = '0';
					}
					$total_amount = $info->transport_amount + $da_amount;
					$patty_cash = $this->Dashboard_model->select('branch_petty_cash', array('branch_id' => 'BAR_011220_210463187872898170_1606780607'), 'id', 'DESC', 'row');
					$balance = $patty_cash->amount;
					if ($balance >= $total_amount) {
						$utime = sprintf('%.4f', microtime(TRUE));
						$raw_time = DateTime::createFromFormat('U.u', $utime);
						$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka'));
						$today = $raw_time->format('dmy-his-u');
						$bc_code = $this->Dashboard_model->mysqlii("SELECT * FROM branches WHERE branch_id = '" . $_SESSION['super_admin']['branch'] . "'");
						$transaction_id = $bc_code[0]->branch_code . '-' . $today;


						$result = $balance - $total_amount;
						$transaction = array(
							'id' 					=> '',
							'transaction_id' 		=> $transaction_id,
							'branch_id' 			=> $bc_code[0]->branch_id,
							'booking_id' 			=> '',
							'careof' 				=> $r_emp->full_name,
							'account_type' 			=> 'Defult',
							'account' 				=> 'Defult',
							'amount' 				=> $total_amount,
							'date' 					=> date('l, d/m/Y h:i:sa'),
							'transaction_type' 		=> 'Debit',
							'transaction_category' 	=> 'TD/DA Return Account',
							'transaction_method' 	=> 'Cash,',
							'data_one' 				=> '',
							'data_two' 				=> '',
							'data_three' 			=> '',
							'note' 					=> $r_emp->employee_id,
							'status' 				=> '1',
							'uploader_info' 		=> uploader_info(),
							'data' 					=> date('d/m/Y')
						);

						$payment_received = array(
							'id' 					=> '',
							'transaction_id' 		=> $transaction_id,
							'branch_id' 			=> $bc_code[0]->branch_id,
							'booking_id' 			=> '',
							'payment_method' 		=> 'Cash',
							'details' 				=> 'TD/DA Return Account',
							'card_amount' 			=> '',
							'cash_amount' 			=> $total_amount,
							'mobile_amount' 		=> '',
							'check_amount' 			=> '',
							'invoice_number' 		=> '',
							'note' 					=> 'Received By Self (' . $r_emp->full_name . ') TD/DA Bill',
							'status' 				=> '1',
							'uploader_info' 		=> uploader_info(),
							'data' 					=> date('d/m/Y')
						);

						$update_balance = array(
							'amount' => $result
						);

						$iiddss = $info->id . '___' . $r_emp->id;
						$number = $r_emp->personal_Phone;
						$link = 'employee_ta_da_received/' . rahat_encode($iiddss) . '';
						$sms_body = 'Dear, ' . $r_emp->full_name . ' Please click the link below for received TD/DA Amount. ' . base_url($link) . '';
						// if(sendsms($number,$sms_body)){
						$notification_data = array(
							'user_id' => $r_emp->employee_id,
							'user_type' => 1,
							'n_header' => 'TA/DA Approved',
							'n_message' => "Your TA/DA of $total_amount has been approved!",
							'n_links' => '',
							'is_read' => 0,
							'uploader_info' => uploader_info(),
							'creation_date' => date('Y-m-d H:i:s'),
							'is_pushed' => 0,
							'notification_type' => 2,
						);
						$transaction_data = array(
							'id' => '',
							'transaction_id' => $transaction_id,
							'branch_id' => $bc_code[0]->branch_id,
							'note' => 'TA Bill',
							'status' => '1',
							'uploader_info' => uploader_info(),
							'data' => date('d/m/Y'),
							'balance' => $result,
							'amount' => $total_amount
						);
						if (
							$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id) and
							$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data) and
							$this->Dashboard_model->insert('notification', $notification_data) and
							$this->Dashboard_model->insert('transaction', $transaction) and
							$this->Dashboard_model->insert('instant_transaction_logs', $transaction_data) and
							$this->Dashboard_model->insert('payment_received_method', $payment_received) and
							$this->Dashboard_model->update('branch_petty_cash', $update_balance, $patty_cash->id)
						) {
							alert('success', 'Aprove Successfully!');
							redirect(current_url());
						} else {
							alert('danger', 'Something Wrong! Please try Again');
							redirect(current_url());
						}
						// }else{
						// 	alert('danger','Something Wrong in SMS Section! Please try Again');
						// 	redirect(current_url());
						// }
					} else {
						alert('danger', 'Not Enough Balance In Petty Cash! Please try Again');
						redirect(current_url());
					}
				}
				if (isset($_POST['reject_data'])) {
					$info = $this->Dashboard_model->select('employee_ta_da_bill_logs', array('id' => $this->input->post('hidden_id')), 'id', 'DESC', 'row');
					$a_emp = $this->Dashboard_model->select('employee', array('id' => $info->department_head_id), 'id', 'ASC', 'row');
					$update_data = array(
						'accounts_aproval' => '2'
					);
					$insert_data = array(
						'id' 				=> '',
						'e_db_id' 			=> $a_emp->id,
						'employee_id' 		=> $a_emp->employee_id,
						'ta_request_id' 	=> $info->id,
						'aproval_type'		=> 'Rejected',
						'note' 				=> 'Rejected By Accounts (' . $a_emp->full_name . ')',
						'status' 			=> '1',
						'uploader_info' 	=> uploader_info(),
						'data' 				=> date('d/m/Y')
					);
					if (
						$this->Dashboard_model->update('employee_ta_da_bill_logs', $update_data, $info->id) and
						$this->Dashboard_model->insert('employee_ta_da_aproval_logs', $insert_data)
					) {
						alert('success', 'Rejected Successfully!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please try Again');
						redirect(current_url());
					}
				}
				$data['emp_list_table'] = $this->Dashboard_model->mysqlii("select * from employee_ta_da_bill_logs where boss_aproval = '1' order by id DESC");
				$data['title_info'] = 'Payroll - Employee TA / DA Request Approval';
				$data['header'] = $this->load->view('include/header', '', TRUE);
				$data['nav'] = $this->load->view('include/nav', '', TRUE);
				$data['article'] = $this->load->view('template/hrm/payroll/employee_td_da_approval_accounts', $data, TRUE);
				$data['footer'] = $this->load->view('include/footer', '', TRUE);
				$this->load->view('dashboard', $data);
			}
		}
	}
	//end exit employee_ta_da_aproval

	//---------Start employee_self_ta_da_aproval-------------
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
				if (isset($_POST['received'])) {
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
						alert('success', 'Received Successfully!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please try Again');
						redirect(current_url());
					}
				}
				$data['amount'] = $info->transport_amount + $da_amount;
				$data['title_info'] = 'Employee TA / DA Request Approval';
				$data['article'] = $this->load->view('template/hrm/payroll/employee_td_da_approval_self', $data, TRUE);
				$data['footer'] = $this->load->view('include/footer', '', TRUE);
				$this->load->view('dashboard', $data);
			} else {
				alert('warning', 'Aproval Already Accepted! Please try again.');
				redirect(base_url());
			}
		} else {
			alert('success', 'Something Wrong! Please try again.');
			redirect(base_url());
		}
	}
	//end exit employee_self_ta_da_aproval
































































	//---------Start employee_award_money_transfer-------------
	public function employee_award_money_transfer()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$tt_received = $this->Dashboard_model->mysqlii("select * from employee_wallet_money_transfer_logs where receiver_id = '" . $_SESSION['super_admin']['employee_ids'] . "' and status = '1'");

			if (!empty($tt_received)) {
				foreach ($tt_received as $row) {
					$updatae_data = array(
						'status' => '0'
					);
					$this->Dashboard_model->update('employee_wallet_money_transfer_logs', $updatae_data, $row->id);
				}
			}

			if (isset($_POST['send_request'])) {
				$employee_id = $this->input->post('employee_id');
				if (!empty($employee_id)) {
					$password = md5($this->input->post('password'));
					$condition = array(
						'employee_id' => $employee_id,
						'password' => $password,
						'status' => '1'
					);
					$challenge = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'row');
					if (!empty($challenge->id)) {
						$transfer_emp_id = $this->input->post('transfer_emp_id');
						$transfer_condition = array(
							'employee_id' => $transfer_emp_id,
							'status' => '1'
						);
						$transfer_challenge = $this->Dashboard_model->select('employee', $transfer_condition, 'id', 'DESC', 'row');
						if (!empty($transfer_challenge->id)) {
							if ($challenge->id == $transfer_challenge->id) {
								alert('danger', 'Never Transfer process work in same account');
								redirect(current_url());
							} else {
								$check_balance = $this->Dashboard_model->select('employee_award_wallet', array('employee_id' => $challenge->employee_id), 'id', 'DESC', 'row');
								if ($check_balance->balance == 0) {
									alert('danger', 'Your Wallet Is Empty! Please try again.');
									redirect(current_url());
								} else {
									if ($check_balance->balance >= $this->input->post('amount')) {
										if ($this->input->post('amount') < 10) {
											alert('danger', 'Sorry! You can not Transfer less then ' . money(10) . '! Please try again.');
											redirect(current_url());
										} else {
											$send_logs = array(
												'id' 				=> '',
												'transaction_id' 	=> time(),
												'sender_id' 		=> $challenge->employee_id,
												'receiver_id'		=> $transfer_challenge->employee_id,
												'amount' 			=> $this->input->post('amount'),
												'note' 				=> $this->input->post('note'),
												'status' 			=> '1',
												'uploader_info' 	=> uploader_info(),
												'data' 				=> date('d/m/Y')
											);
											$get_balance_info = $this->Dashboard_model->select('employee_award_wallet', array('employee_id' => $challenge->employee_id), 'id', 'DESC', 'row');
											$new_balance = $get_balance_info->balance - $this->input->post('amount');
											$update_balance = array(
												'balance' => $new_balance
											);

											$get_balance_info_receiver = $this->Dashboard_model->select('employee_award_wallet', array('employee_id' => $transfer_challenge->employee_id), 'id', 'DESC', 'row');
											$new_balance_receiver = $get_balance_info_receiver->balance + $this->input->post('amount');
											$update_balance_receiver = array(
												'balance' => $new_balance_receiver
											);

											if (
												$this->Dashboard_model->insert('employee_wallet_money_transfer_logs', $send_logs) and
												$this->Dashboard_model->update('employee_award_wallet', $update_balance, $get_balance_info->id) and
												$this->Dashboard_model->update('employee_award_wallet', $update_balance_receiver, $get_balance_info_receiver->id)
											) {
												alert('success', 'Balance Transfered Successfully.');
												redirect(current_url());
											} else {
												alert('danger', 'Something Wrong! Please try Again');
												redirect(current_url());
											}
										}
									} else {
										alert('danger', 'You have not enough balance to Transfer! Please try again.');
										redirect(current_url());
									}
								}
							}
						} else {
							alert('danger', 'Transfer EmployeeID not found OR Employee status not Pure! Please try again');
							redirect(current_url());
						}
					} else {
						alert('danger', 'Password Wrong! Please try again.');
						redirect(current_url());
					}
				} else {
					alert('danger', 'Your Session is Expired! Please login again.');
					redirect(current_url());
				}
			}

			$data['title_info'] = 'Wallet Money Transfer';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/employee_award_money_transfer', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit employee_award_money_transfer



	//---------Start award_money_widthdraw-------------
	public function award_money_widthdraw()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['send_request'])) {
				$employee_id = $this->input->post('employee_id');
				if (!empty($employee_id)) {
					$password = md5($this->input->post('password'));
					$condition = array(
						'employee_id' => $employee_id,
						'password' => $password,
						'status' => '1'
					);

					$challenge = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'row');
					if (!empty($challenge->id)) {
						$check_balance = $this->Dashboard_model->select('employee_award_wallet', array('employee_id' => $challenge->employee_id), 'id', 'DESC', 'row');
						if ($check_balance->balance == 0) {
							alert('danger', 'Your Wallet Is Empty! Please try again.');
							redirect(current_url());
						} else {
							if ($check_balance->balance >= $this->input->post('amount')) {
								if ($this->input->post('amount') < 100) {
									alert('danger', 'Sorry! You can not widthdraw less then ' . money(100) . '! Please try again.');
									redirect(current_url());
								} else {
									$check_pending_status = $this->Dashboard_model->select('employee_wallet_money_widthdraw_request', array('employee_id' => $challenge->employee_id, 'aproval' => '0'), 'id', 'DESC', 'row');
									if (!empty($check_pending_status->id)) {
										alert('danger', 'Sorry! You already have a pending Request! Please try again.');
										redirect(current_url());
									} else {
										$data = array(
											'id' 				=> '',
											'employee_id'		=> $challenge->employee_id,
											'amount' 			=> $this->input->post('amount'),
											'aproval'			=> '0',
											'note' 				=> $this->input->post('note'),
											'status' 			=> '1',
											'uploader_info' 	=> uploader_info(),
											'data' 				=> date('d/m/Y')
										);
										if ($this->Dashboard_model->insert('employee_wallet_money_widthdraw_request', $data)) {
											alert('success', 'Your Request sended Successfully.');
											redirect(current_url());
										} else {
											alert('danger', 'Something Wrong! Please try Again');
											redirect(current_url());
										}
									}
								}
							} else {
								alert('danger', 'You have not enough balance to widthdraw! Please try again.');
								redirect(current_url());
							}
						}
					} else {
						alert('danger', 'Password Wrong! Please try again.');
						redirect(current_url());
					}
				} else {
					alert('danger', 'Your Session is Expired! Please login again.');
					redirect(current_url());
				}
			}
			if (isset($_POST['remove_request'])) {
				$check_pending_status = $this->Dashboard_model->select('employee_wallet_money_widthdraw_request', array('id' => $this->input->post('hidden_id')), 'id', 'DESC', 'row');
				if ($check_pending_status->aproval == 0) {
					if ($this->Dashboard_model->delete('employee_wallet_money_widthdraw_request', $this->input->post('hidden_id'))) {
						alert('success', 'Successfully Removed!');
						redirect(current_url());
					} else {
						alert('danger', 'Something Wrong! Please Try Again');
						redirect(current_url());
					}
				} else {
					alert('warning', 'Sorry! You Can not removed the request because your request all-ready Approved!');
					redirect(current_url());
				}
			}

			$data['title_info'] = 'Wallet Money Widthdraw';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/award_money_widthdraw', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit award_money_widthdraw

	//---------Start change Password-------------
	public function change_password()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if (isset($_POST['change_password'])) {
				$old_password = md5($this->input->post('old_password'));
				$new_password = md5($this->input->post('new_password'));
				$confirm_password = md5($this->input->post('confirm_password'));
				$condition = array(
					'email' => $_SESSION['super_admin']['email'],
					'branch' => $_SESSION['super_admin']['branch'],
					'password' => $old_password,
					'status' => '1'
				);
				$challenge = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'row');
				if (!empty($challenge->password)) {
					if ($new_password == $confirm_password) {
						if ($challenge->password == $new_password) {
							alert('warning', 'New & Old Password Could not be same! Please Try Again');
							redirect(current_url());
						} else {
							$data = array(
								'password' => $new_password
							);
							if ($this->Dashboard_model->update('employee', $data, $challenge->id)) {
								unset($_SESSION['super_admin']);
								alert('success', 'Password Change Successfully! Please Login Again');
								redirect(current_url());
							} else {
								alert('danger', 'Something wrong! Please Try Again');
								redirect(current_url());
							}
						}
					} else {
						alert('warning', 'New & Confirm Password dose not match! Please Try Again');
						redirect(current_url());
					}
				} else {
					alert('danger', 'Old Password Wrong! Please Try Again');
					redirect(current_url());
				}
			}

			$data['title_info'] = 'Employee Change Password';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/change_password', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit change Password

	//---------Start my attendance-------------
	public function my_attendents()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Employee Attendance Table';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/my_attendents', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit  my attendance

	//---------Start my attendance-------------
	public function subordinate_attendents()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			// if($_SESSION['user_info']['d_head'] == '1'){
			if ($_SESSION['super_admin']['role_id'] == '1806965207554226682') {
				$condition = array(
					'department' => $_SESSION['user_info']['department'],
					'branch' => $_SESSION['super_admin']['branch'],
					'status' => '1'
				);
			} else {
				$condition = array(
					'department' => $_SESSION['user_info']['department'],
					'status' => '1'
				);
			}
			$data['subordinates'] = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'result');
			$data['title_info'] = 'Subordiante Attendance Table';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/subordinate_attendents', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
			// }else{
			// 	redirect(base_url('admin/login'));
			// }					
		}
	}
	//end exit  my attendance

	//---------Start my visiting_card-------------
	public function visiting_card()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Employee visiting card';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/visiting_card', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit  my visiting_card

	//---------Start my id_card-------------
	public function id_card()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Employee ID CARD card';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/id_card', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end exit  my id_card

	//---------Start my change_profile_picture-------------
	public function change_profile_picture()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$condition = array(
				'email' => $_SESSION['super_admin']['email'],
				'branch' => $_SESSION['super_admin']['branch'],
				'status' => '1'
			);
			$details = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'row');
			$data['profile_picture'] = $details->photo;

			$data['title_info'] = 'Change Employee Profile Picture';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/employee/change_profile_picture', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	//end change_profile_picture

	// visiting card
	function employee_visiting_card()
	{
		$condition = array(
			'status' => '1'
		);
		$data['member_lists'] = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'result');
		$data['title_info'] = 'Generate Visiting Card';
		$data['header'] = $this->load->view('include/header', '', TRUE);
		$data['nav'] = $this->load->view('include/nav', '', TRUE);
		$data['article'] = $this->load->view('template/hrm/employee/employee_visiting_card', $data, TRUE);
		$data['footer'] = $this->load->view('include/footer', '', TRUE);
		$this->load->view('dashboard', $data);
	}
	// end visiting card
	// qr code
	function employee_qr_code()
	{
		$condition = array(
			'status' => '1'
		);
		$data['member_lists'] = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'result');
		$data['title_info'] = 'Generate Visiting Card';
		$data['header'] = $this->load->view('include/header', '', TRUE);
		$data['nav'] = $this->load->view('include/nav', '', TRUE);
		$data['article'] = $this->load->view('template/hrm/employee/employee_qr_code', $data, TRUE);
		$data['footer'] = $this->load->view('include/footer', '', TRUE);
		$this->load->view('dashboard', $data);
	}
	// end qr code
	// employee_id_card
	function employee_id_card()
	{
		$condition = array(
			'status' => '1'
		);
		$data['member_lists'] = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'result');
		$data['title_info'] = 'Generate ID Card';
		$data['header'] = $this->load->view('include/header', '', TRUE);
		$data['nav'] = $this->load->view('include/nav', '', TRUE);
		$data['article'] = $this->load->view('template/hrm/employee/employee_id_card', $data, TRUE);
		$data['footer'] = $this->load->view('include/footer', '', TRUE);
		$this->load->view('dashboard', $data);
	}
	// end employee_id_card
	
	// ovserbation_id_card
	function ovserbation_id_card()
	{
		$condition = array(
			'status' => '1'
		);
		$data['member_lists'] = $this->Dashboard_model->select('employee', $condition, 'id', 'DESC', 'result');
		$data['title_info'] = 'Generate ID Card';
		$data['header'] = $this->load->view('include/header', '', TRUE);
		$data['nav'] = $this->load->view('include/nav', '', TRUE);
		$data['article'] = $this->load->view('template/hrm/employee/ovserbation_id_card', $data, TRUE);
		$data['footer'] = $this->load->view('include/footer', '', TRUE);
		$this->load->view('dashboard', $data);
	}
	// end ovserbation_id_card

	public function demo_notificaiton()
	{
		if (isset($_SESSION['user_info'])) {
			$emp_id = $_SESSION['user_info']['employee_ids'];
			$emp_db_id = $_SESSION['user_info']['employee_id'];
			$department = $_SESSION['user_info']['department'];
			$role_id = $_SESSION['super_admin']['role_id'];
			$d_head = $_SESSION['user_info']['d_head'];
		} else {
			$emp_id = $_POST['employee_id'];
			$emp_db_id = $_POST['user_id'];
			$department = $_POST['department'];
			$role_id = $_POST['role_id'];
			$d_head = $_POST['d_head'];
		}

		$emp_info = $this->Dashboard_model->mysqlii("select * from employee where id = '" . $emp_db_id . "' and department = '" . $department . "' and d_head = '1' order by id desc limit 01");
		// $emp_info = $this->Dashboard_model->mysqlii("select * from employee where id = '119' and department = '1383007286312996344' and d_head = '1' order by id desc limit 01");
		if (!empty($emp_info[0]->id)) {
			$hr_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_resign_aprv from employee_resign_request_to_hr where department_head_id = '" . $emp_info[0]->id . "' and aproval = '0'");
			$hr_resign_aprv = (int)$hr_resign_emp_apov[0]->hr_resign_aprv;
		} else {
			$hr_resign_aprv = 0;
		}

		$lw_request = $this->Dashboard_model->mysqlii("select count(*) as lw_request from employee_everyday_withdraw_logs where d_head_id = '" . $emp_db_id . "' and status = '1' and approval = '0'");
		$lw_request = (int)$lw_request[0]->lw_request;
		if ($lw_request > 0) {
			$lw_request = $lw_request;
		} else {
			$lw_request = 0;
		}

		$lwt_request = $this->Dashboard_model->mysqlii("select count(*) as lwt_request from employee_leave_logs where h_id = '" . $emp_db_id . "' and status = '1' and ( h_aproval = '0' OR  h_aproval = '3') and aproval = '0'");
		// $lwt_request = $this->Dashboard_model->mysqlii("select count(*) as lwt_request from employee_leave_logs where h_id = '".$emp_id."' and status = '1' and h_aproval = '0' and aproval = '0'");
		$lwt_request = (int)$lwt_request[0]->lwt_request;
		if ($lwt_request > 0) {
			$lwt_request = $lwt_request;
		} else {
			$lwt_request = 0;
		}

		$tt_received = $this->Dashboard_model->mysqlii("select count(*) as tt_received from employee_wallet_money_transfer_logs where receiver_id = '" . $emp_id . "' and status = '1'");
		$tt_received = (int)$tt_received[0]->tt_received;
		if ($tt_received > 0) {
			$tt_received = $tt_received;
		} else {
			$tt_received = 0;
		}





		$head_requirement_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as head_requirement_emp_apov from employee_recruitment_request where department_head_notify = '1' and department = '" . $department . "'");
		$head_requirement_emp_apov = (int)$head_requirement_emp_apov[0]->head_requirement_emp_apov;
		if (!empty($head_requirement_emp_apov > 0)) {
			$head_requirement_emp_apov = $head_requirement_emp_apov;
		} else {
			$head_requirement_emp_apov = 0;
		}


		if ($role_id == '390647376434090456') {
			$hr_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_chain_aprv from exit_employee_chain_hr where aproval = '1'");
			$hr_chain_aprv = (int)$hr_resign_emp_apov[0]->hr_chain_aprv;
			if (!empty($hr_chain_aprv > 0)) {
				$hr_chain_aprv = (int)$hr_resign_emp_apov[0]->hr_chain_aprv;
			} else {
				$hr_chain_aprv = 0;
			}

			$hr_requirement_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as hr_requirement_emp_apov from employee_recruitment_request where hr_notify = '1'");
			$hr_requirement_emp_apov = (int)$hr_requirement_emp_apov[0]->hr_requirement_emp_apov;
			if (!empty($hr_requirement_emp_apov > 0)) {
				$hr_requirement_emp_apov = $hr_requirement_emp_apov;
			} else {
				$hr_requirement_emp_apov = 0;
			}
		} else {
			$hr_requirement_emp_apov = 0;
			$hr_chain_aprv = 0;
		}



		$c_exit_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as t_exit_aprv from exit_employee_chain_aproval where e_db_id = '" . $emp_db_id . "' and aproval = '0'");
		$c_resign_emp_apov = $this->Dashboard_model->mysqlii("select count(*) as t_resign_aprv from employee_resign_request where department_head_id = '" . $emp_db_id . "' and aproval = '0'");

		if ($d_head == 1) {
			$d_head_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_dh from employee_ta_da_bill_logs where department_head_id = '" . $emp_db_id . "' and department_head_aproval = '0'");
			if ($d_head_td_da_aprv[0]->t_tada_apr_dh > 0) {
				$td_da_request_c = $d_head_td_da_aprv[0]->t_tada_apr_dh;
			} else {
				$td_da_request_c = 0;
			}
		} else {
			$td_da_request_c = 0;
		}

		if ($role_id == '2805597208697462328') { // super admin
			$c_deduction_apov_acunt = $this->Dashboard_model->mysqlii("select count(*) as t_deduction_aprv_ac from employee_sallary_deduction where aproval = '0'");
			if ($c_deduction_apov_acunt[0]->t_deduction_aprv_ac > 0) {
				$deduction_request = $c_deduction_apov_acunt[0]->t_deduction_aprv_ac;
			} else {
				$deduction_request = 0;
			}

			$c_fired_aprov = $this->Dashboard_model->mysqlii("select count(*) as t_fired_aprv from employee_fired_list where aproval = '0'");
			if ($c_fired_aprov[0]->t_fired_aprv > 0) {
				$c_fired_aprov = $c_fired_aprov[0]->t_fired_aprv;
			} else {
				$c_fired_aprov = 0;
			}

			$d_boss_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_bos from employee_ta_da_bill_logs where department_head_aproval = '1' and boss_aproval = '0'");
			if ($d_boss_td_da_aprv[0]->t_tada_apr_bos > 0) {
				$td_da_request_bos = $d_boss_td_da_aprv[0]->t_tada_apr_bos;
			} else {
				$td_da_request_bos = 0;
			}

			$t_requ_emp = $this->Dashboard_model->mysqlii("select count(*) as t_requ_emp from employee_recruitment_request where boss_aproval = '0'");
			if ($t_requ_emp[0]->t_requ_emp > 0) {
				$t_requ_emp = $t_requ_emp[0]->t_requ_emp;
			} else {
				$t_requ_emp = 0;
			}
		} else {
			$deduction_request = 0;
			$c_fired_aprov = 0;
			$td_da_request_bos = 0;
			$t_requ_emp = 0;
		}

		if ($role_id == '1622657840330042228') { //accounts
			$c_loan_emp_apov_acunt = $this->Dashboard_model->mysqlii("select count(*) as t_loan_aprv_ac from employee_grant_loan where e_db_id = '" . $emp_id . "' and aproval_account = '0'");
			if ($c_loan_emp_apov_acunt[0]->t_loan_aprv_ac > 0) {
				$account_loan_request = $c_loan_emp_apov_acunt[0]->t_loan_aprv_ac;
			} else {
				$account_loan_request = 0;
			}

			$d_acc_td_da_aprv = $this->Dashboard_model->mysqlii("select count(*) as t_tada_apr_acc from employee_ta_da_bill_logs where boss_aproval = '1' and accounts_aproval = '0' order by id desc");
			if ($d_acc_td_da_aprv[0]->t_tada_apr_acc > 0) {
				$td_da_request_acc = $d_acc_td_da_aprv[0]->t_tada_apr_acc;
			} else {
				$td_da_request_acc = 0;
			}
		} else {
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
			$increament_total;
		if ($total_notif > 0) {
			$total_notif = $total_notif;
		} else {
			$total_notif = 0;
		}

		$info = array(
			'total_notification' => $total_notif,
			'leave' => $lwt_request,
			'ta_head_approval' => $td_da_request_c,
			'ta_account_approval' => $td_da_request_acc,
			'ta_boss_approval' => $td_da_request_bos,
		);
		echo json_encode($info);
	}

	public function increase_mobile_allowence()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			/**
			 * Insert Data
			 * 
			 * @return view
			 */
			if (isset($_POST['submit'])) {
				$status = 0;
				if ($_SESSION['user_info']['d_head']) {
					$status = 1;
				}

				$data = array(
					'employee_id' => $_SESSION['super_admin']['employee_ids'],
					'requested_amount' => $_POST['request_amount'],
					'approved_amount' => $_POST['request_amount'],
					'creation_date' => date('Y-m-d h:i:s'),
					'status' => $status,
					'note' => $_POST['note'],
				);
				$this->Dashboard_model->insert('increase_mobile_allowance', $data);

				if ($_SESSION['user_info']['d_head']) {
					$approval_data = array(
						'mobile_allowence_id' => $this->db->insert_id(),
						'note' => '',
						'type' => 'head',
						'employee_id' => $_SESSION['super_admin']['employee_ids'],
					);
					$this->Dashboard_model->insert('increase_mobile_allowance_approval_logs', $approval_data);
				}

				alert('success', 'Successfully Saved!');
				redirect(current_url());
			}

			/**
			 * Remove Request
			 * 
			 * @return view
			 */
			if (isset($_POST['remove_request'])) {
				$this->Dashboard_model->delete('increase_mobile_allowance', $_POST['remove_id']);
			}

			$data['current_amount'] = $this->Dashboard_model->mysqlij("SELECT mobile_allowance from employee where employee_id = '" . $_SESSION['super_admin']['employee_ids'] . "'");
			$data['mobile_allowances'] = $this->Dashboard_model->mysqlii("SELECT increase_mobile_allowance.*, employee.full_name from increase_mobile_allowance INNER JOIN employee USING(employee_id) where increase_mobile_allowance.employee_id = '" . $_SESSION['super_admin']['employee_ids'] . "' ORDER BY id DESC");

			$data['title_info'] = 'Increase Mobile Allowance';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('/template/hrm/employee/increase_mobile_allowance', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function increase_mobile_allowence_approval()
	{
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			$data['title_info'] = 'Mobile Allowance Approval';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('/template/hrm/employee/increase_mobile_allowance_approval', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}

	public function increase_mobile_allowence_submit()
	{
		$data = array(
			'mobile_allowence_id' => $_POST['approval_id'],
			'note' => $_POST['note'],
			'type' => $_POST['approving_by'],
			'employee_id' => $_SESSION['super_admin']['employee_ids'],
		);
		$this->Dashboard_model->insert('increase_mobile_allowance_approval_logs', $data);

		if ($_POST['approval_type'] == 'accept') {
			if ($_POST['approving_by'] == 'head') {
				$status = 1;
			} else {
				$status = 3;
			}

			$approved_amount = $_POST['approved_amount'];
		}

		if ($_POST['approval_type'] == 'reject') {
			if ($_POST['approving_by'] == 'head') {
				$status = 2;
			} else {
				$status = 4;
			}

			$approved_amount = 0;
		}

		$this->Dashboard_model->update('increase_mobile_allowance', array('status' => $status, 'approved_amount' => $approved_amount), $_POST['approval_id']);

		if ($status == 3) {
			$increase_amount = $this->Dashboard_model->select('increase_mobile_allowance', array('id' => $_POST['approval_id']), 'id', 'desc', 'row');
			$this->Dashboard_model->mysqliq("UPDATE employee set mobile_allowance = mobile_allowance + '" . $increase_amount->approved_amount . "' where employee_id = '" . $increase_amount->employee_id . "'");
		}
	}

	public function add_department() 
	{
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
		else
		{
			$data['department'] =  $this->Dashboard_model->mysqlii("SELECT * FROM department");
			// $this->load->view('hrm_add_department',$department);
			$data['title_info'] = 'Add Department';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('/template/hrm/hrm_add_department',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
		}
	}

	public function insert_department()
	{
		// $data = array(
		// 	'employee_id' => $_SESSION['super_admin']['employee_ids'],
		// 	'requested_amount' => $_POST['request_amount'],
		// 	'approved_amount' => $_POST['request_amount'],
		// 	'creation_date' => date('Y-m-d h:i:s'),
		// 	'status' => $status,
		// 	'note' => $_POST['note'],
		// );
		// $this->Dashboard_model->insert('increase_mobile_allowance', $data);
        
		

		if(empty($_POST['department']))
		{
			alert('error','Please select at least one department');
			redirect(base_url('admin/hrm/recruitment/add_department'));
		}
		else
		{   
			foreach($_POST['department'] as $row)
			{
				$recruitment = array('recruitment' => 1);    
				$this->Dashboard_model->update('department', $recruitment, $row);
			}
			alert('success','Successfully Saved');
			redirect(base_url('admin/hrm/recruitment/add_department'));
		}
	}

	public function add_circular()
	{     
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
		else
		{
			$data['departments'] =  $this->Dashboard_model->mysqlii("SELECT * FROM department");
			$data['designations'] = $this->Dashboard_model->mysqlii("SELECT * FROM designation ORDER BY ID DESC");
			// $this->load->view('hrm_add_department',$department);
			$data['title_info'] = 'Add Circular';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('/template/hrm/add_circular',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
		    	
	}

	public function insert_circular()
	{   
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
		else
		{   
			
			$data = array();
			$data['job_title'] = $_POST['job_title'];
			$data['job_nature'] = $_POST['job_nature'];
			$data['salary'] = $_POST['salary'];
			$data['department_id'] = $_POST['department_id'];
			$data['designation_id'] = $_POST['designation_id'];
			$data['job_description'] = strip_tags($_POST['job_description']);
			$data['job_deadline'] = $_POST['job_deadline'];
            $this->Dashboard_model->insert('ciculars', $data);
			alert('success','Successfully Saved');
			redirect(base_url('admin/hrm/add_circular'));
		}
		
		
	}

	public function all_circular()
	{
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
		else
		{
			$data['ciculars'] =  $this->Dashboard_model->mysqlii("SELECT ciculars.id, ciculars.job_title, ciculars.job_nature, ciculars.salary, ciculars.job_deadline , department.department_name, designation.designation_name
			FROM ((ciculars
			INNER JOIN department ON ciculars.department_id = department.id)
			INNER JOIN designation ON ciculars.designation_id = designation.id) ORDER BY ciculars.id DESC");
			$data['title_info'] = 'All Circular';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('/template/hrm/all_circular',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
			
		}
	}

	public function edit_circular($id)
	{
		    $data['circular'] =  $this->Dashboard_model->mysqlij("SELECT * FROM ciculars WHERE id=$id");
			$data['departments'] =  $this->Dashboard_model->mysqlii("SELECT * FROM department");
			$data['designations'] = $this->Dashboard_model->mysqlii("SELECT * FROM designation ORDER BY ID DESC");
			$data['title_info'] = 'Edit Circular';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('/template/hrm/edit_circular',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
			
	}

	public function update_circular()
	{
		    $id = $_POST['id'];
		//$data = array('recruitment' => 1);    
		    $data = array();
			$data['job_title'] = $_POST['job_title'];
			$data['job_nature'] = $_POST['job_nature'];
			$data['salary'] = $_POST['salary'];
			$data['department_id'] = $_POST['department_id'];
			$data['designation_id'] = $_POST['designation_id'];
			$data['job_description'] = strip_tags($_POST['job_description']);
			$data['job_deadline'] = $_POST['job_deadline'];
		    $this->Dashboard_model->update('ciculars', $data, $id);
			alert('success','Successfully Updated');
			redirect(base_url('admin/hrm/all_circular'));
	}

	public function delete_circular($id)
	{
		
		$this->Dashboard_model->mysqliq("DELETE FROM ciculars WHERE id=$id");
		echo "Successfully Deleted";
	}

	public function candidate_details($id)
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
		else
		{
			$data['job_applications'] =  $this->Dashboard_model->mysqlii("SELECT * FROM apply_jobs WHERE NOT id IN(SELECT apply_id FROM short_lists) AND circular_id='$id' ORDER BY id DESC");
			$data['cicular'] = $this->Dashboard_model->mysqlij("SELECT * FROM ciculars WHERE id='$id'");

			
			
			$data['short_lists'] = $this->Dashboard_model->mysqlii("SELECT short_lists.apply_id, short_lists.circular_id, short_lists.remarks, apply_jobs.id, apply_jobs.name, apply_jobs.phone, apply_jobs.email, apply_jobs.remarks as apply_remarks
			FROM short_lists 
			INNER JOIN apply_jobs ON short_lists.apply_id = apply_jobs.id WHERE NOT apply_jobs.id IN(SELECT call_interview_id FROM interview_calls) AND short_lists.circular_id='$id'  ORDER BY short_lists.id DESC");

			// $data['interviews'] = $this->Dashboard_model->mysqlii("SELECT interview_calls.call_interview_id, interview_calls.circular_id, interview_calls.marks, interview_calls.expected_salary, interview_calls.first_interview_remarks, interview_calls.second_interview_remarks, interview_calls.observation_interview_remarks , apply_jobs.id, apply_jobs.name, apply_jobs.phone, apply_jobs.email 
			// FROM interview_calls 
			// INNER JOIN apply_jobs ON interview_calls.call_interview_id = apply_jobs.id WHERE interview_calls.circular_id='$id' AND interview_calls.final_interview_status != 1 ORDER BY interview_calls.id DESC");
            
			$data['interviews'] = $this->Dashboard_model->mysqlii("SELECT interview_calls.call_interview_id, interview_calls.circular_id, interview_calls.marks, interview_calls.expected_salary, interview_calls.first_interview_remarks, interview_calls.second_interview_remarks, interview_calls.observation_interview_remarks, apply_jobs.id, apply_jobs.name, apply_jobs.phone, apply_jobs.email, short_lists.remarks as short_remarks
			FROM ((interview_calls
			INNER JOIN apply_jobs ON interview_calls.call_interview_id = apply_jobs.id)
			INNER JOIN short_lists ON interview_calls.call_interview_id = short_lists.apply_id) WHERE interview_calls.circular_id='$id' AND interview_calls.final_interview_status != 1 ORDER BY interview_calls.id DESC");

			$data['primary_interviews'] = $this->Dashboard_model->mysqlii("SELECT interview_calls.call_interview_id, interview_calls.circular_id, interview_calls.marks, interview_calls.expected_salary, interview_calls.second_interview_remarks,  interview_calls.first_interview_remarks, apply_jobs.id, apply_jobs.name, apply_jobs.phone, apply_jobs.email 
			FROM interview_calls 
			INNER JOIN apply_jobs ON interview_calls.call_interview_id = apply_jobs.id WHERE interview_calls.circular_id='$id' AND interview_calls.final_interview_status=1 AND interview_calls.observation_status!=1 ORDER BY interview_calls.id DESC");
            
			$data['observations'] = $this->Dashboard_model->mysqlii("SELECT interview_calls.call_interview_id, interview_calls.circular_id, interview_calls.marks, interview_calls.select_status, interview_calls.observation_interview_remarks, interview_calls.expected_salary, apply_jobs.id, apply_jobs.name, apply_jobs.phone, apply_jobs.email 
			FROM interview_calls 
			INNER JOIN apply_jobs ON interview_calls.call_interview_id = apply_jobs.id WHERE interview_calls.circular_id='$id' AND interview_calls.observation_status=1 ORDER BY interview_calls.marks DESC");
			
            // foreach($data['interviews']  as $ints)
			// {
			// 	foreach($data['observations'] as $obs)
			// 	{
			// 		if($ints->call_interview_id == $obs->call_observation_id)
			// 		{
			// 			echo "true";
			// 		}
			// 		else{
			// 			echo "false";
			// 		}
			// 	}
			// }
			//$people = array("Peter", "Joe", "Glenn", "Cleveland");
			
			//exit();
			$data['title_info'] = 'All Candidate';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('/template/hrm/candidate_details',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);	
			
		}
    }

	public function save_remark($id)
	{
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
		else
		{
			if(!$this->Dashboard_model->mysqliq("UPDATE apply_jobs set remarks = '" . $_POST['remark'] . "' where id = " . $_POST['id'])){
				return json_encode(array('error', true));
			}else{
				return json_encode(array('error', false));
			}
		}
	}

	public function make_short()
	{
		$shorts = $_POST['select_short'];
		$circular_id = $_POST['apply_id'];
		if(count($shorts) > 0)
		{
			
			for($count=0; $count < count($shorts); $count++)
			{
				$data = array(
					'apply_id' =>$shorts[$count], 
					'circular_id'=> $circular_id,
					//'remarks'   => $_POST['remarks'][$count]
				);
				$this->Dashboard_model->insert('short_lists', $data); 
			} 
			foreach($shorts as $short)
			{
				$this->Dashboard_model->mysqliq("UPDATE apply_jobs SET remarks='".$_POST['remarks'][$short]."' WHERE id = '$short'");
				//$this->Dashboard_model->mysqliq("UPDATE short_lists SET remarks='".$_POST['remarks'][$short]."' WHERE apply_id = '$short'");
			}   
			alert('success','Successfully Saved');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
		else
		{
			alert('error','Please Select At least One');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}

		
	}

	public function make_interview()
	{
		$circular_id = $_POST['circular_id'];
		$call_interview_id = $_POST['call_interview_id'];
		
		if(count($call_interview_id) > 0)
		{
			for($count=0; $count < count($call_interview_id); $count++)
			{
				$data = array(
					'circular_id' =>$circular_id, 
					'call_interview_id'=> $call_interview_id[$count],
				);
				$this->Dashboard_model->insert('interview_calls', $data); 
			}
			foreach($call_interview_id as $obs)
			{
				$this->Dashboard_model->mysqliq("UPDATE short_lists SET remarks='".$_POST['remarks'][$obs]."' WHERE apply_id = '$obs'");
			}    
			alert('success','Successfully Saved');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
		else
		{
			alert('error','Please At Least One Candidate');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
	}

	public function make_observation()
	{
		$circular_id = $_POST['circular_id'];
		$call_observation_id = $_POST['call_observation_id'];
		
		if(count($call_observation_id) > 0)
		{
			foreach($call_observation_id as $obs)
			{
				$this->Dashboard_model->mysqliq("UPDATE interview_calls SET observation_status='1', second_interview_remarks='".$_POST['second_interview_remarks'][$obs]."' WHERE call_interview_id = '$obs'");
			}
			alert('success','Successfully Saved');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
		else
		{
			alert('error','Please at least select a candidate');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
	}

	public function make_final()
	{
		$circular_id = $_POST['circular_id'];
		$selected_id = $_POST['selected_id'];
		$observation_interview_remarks = $_POST['observation_interview_remarks'];
	    $expected_salary = $_POST['expected_salary'];
		
		if(count($selected_id) > 0)
		{
			for($count=0; $count < count($selected_id); $count++)
			{
				$data = array(
					'circular_id' =>$circular_id, 
					'candidate_id'=> $selected_id[$count],
				);
				$this->Dashboard_model->insert('final_selections', $data); 
				
			} 
			foreach($selected_id as $selected)
			{    
				//$this->Dashboard_model->mysqliq("UPDATE interview_calls SET expected_salary='".$_POST['expected_salary'][$selected]."',observation_status=1 WHERE call_interview_id = '$selected'");
				
				$get_data = $this->Dashboard_model->mysqlii("SELECT * FROM apply_jobs WHERE id='$selected'");
				foreach($get_data as $row)
				{
					$number = $row->phone;

					//$random = rand(1000,9999);
					$message_body = "Congrats You are Selected, Please Fill the form. The link is: https://erp.superhomebd.com/employee-information-form/new-employee-details-form";

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
				}
				$this->Dashboard_model->mysqliq("UPDATE interview_calls SET select_status='1',observation_interview_remarks='".$_POST['observation_interview_remarks'][$selected]."', expected_salary='".$_POST['expected_salary'][$selected]."' WHERE call_interview_id = '$selected'");
			}
			
			alert('success','Successfully Saved');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
		else
		{
			alert('error','Please select at least one candidate');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
	}
	
	public function make_final_interview()
	{
		$circular_id = $_POST['circular_id'];
		$call_final_interview_id = $_POST['call_final_interview_id'];
		$expected_salary = $_POST['expected_salary'];
		if(count($call_final_interview_id) > 0)
		{
			foreach($call_final_interview_id as $obs)
			{
				$this->Dashboard_model->mysqliq("UPDATE interview_calls SET marks='".$_POST['mark'][$obs]."', first_interview_remarks='".$_POST['first_interview_remarks'][$obs]."' , expected_salary='".$_POST['expected_salary'][$obs]."', final_interview_status=1 WHERE call_interview_id = '$obs'");
			}
			alert('success','Successfully Saved');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
		else
		{
			alert('error','Please select at least one candidate');
			redirect(base_url('admin/hrm/candidate_details/'.$circular_id));
		}
		
		//$this->Dashboard_model->mysqliq("UPDATE interview_calls SET select_status='1' WHERE call_interview_id = '$selected'");
	}

	public function back_primary($id)
	{   
		$get_circular_id = $this->Dashboard_model->mysqlij("SELECT * FROM interview_calls WHERE call_interview_id='$id'");
		
		$this->Dashboard_model->mysqliq("UPDATE interview_calls SET final_interview_status=0 WHERE id='$get_circular_id->id'");

		$data = $this->Dashboard_model->mysqlii("SELECT interview_calls.call_interview_id, interview_calls.circular_id, interview_calls.marks, interview_calls.expected_salary, apply_jobs.id, interview_calls.first_interview_remarks, apply_jobs.name, apply_jobs.phone, apply_jobs.email 
		FROM interview_calls 
		INNER JOIN apply_jobs ON interview_calls.call_interview_id = apply_jobs.id WHERE interview_calls.circular_id='$get_circular_id->circular_id'   ORDER BY interview_calls.id DESC");
		
		?>
		<?php foreach($data as $key=>$interview): ?>
			<tr>
                           
                           <td width="10%"><input type="checkbox" id="source_cart_<?php echo $interview->id; ?>" class="ovs_id" name="call_final_interview_id[]" value="<?php echo $interview->id; ?>"></td>
                           
                           <td width="12%"><?php echo $interview->name; ?></td>
                           <td width="12%"><?php echo $interview->phone; ?></td>
                           <td width="12%"><?php echo $interview->email; ?></td>
                           <td width="14%"><input type="radio" name="mark[<?php echo $interview->id; ?>]" value="1" <?php if($interview->marks == 1){echo "checked";} ?>><label style="cursor: pointer; margin-left: 2px;">1</label> <input  type="radio" name="mark[<?php echo $interview->id; ?>]" value="2" <?php if($interview->marks == 2){echo "checked";} ?>><label  style="cursor: pointer; margin-left: 2px;">2</label> <input  type="radio" name="mark[<?php echo $interview->id; ?>]" value="3" <?php if($interview->marks == 3){echo "checked";} ?>><label  style="cursor: pointer; margin-left: 2px;">3</label> <input  type="radio" name="mark[<?php echo $interview->id; ?>]" value="4" <?php if($interview->marks == 4){echo "checked";} ?>><label  style="cursor: pointer; margin-left: 2px;">4</label> <input  type="radio" name="mark[<?php echo $interview->id; ?>]" value="5" <?php if($interview->marks == 5){echo "checked";} ?>><label  style="cursor: pointer; margin-left: 2px;">5</label></td>
                           

                           <td width="15"><input type="number" class="form-control" id="expected_<?php echo $interview->id; ?>" name="expected_salary[<?php echo $interview->id ?>]" readonly value="<?php echo $interview->expected_salary; ?>"></td>

                           <?php if($interview->first_interview_remarks == NULL): ?>
                             <td width="25%;"><textarea class="form-control" name="first_interview_remarks[<?php echo $interview->id; ?>]"></textarea></td>
                           <?php else: ?>
                            <td width="25%"><textarea class="form-control" name="first_interview_remarks[<?php echo $interview->id; ?>]"><?php echo $interview->first_interview_remarks; ?></textarea></td>
                            <?php endif; ?>
                          </tr>
			<?php endforeach; ?>
		<?php
	}

	public function candidate_images($id)
	{  
		$image = $this->Dashboard_model->mysqlij("SELECT * FROM apply_jobs WHERE id=$id");
        $images = $this->Dashboard_model->mysqlii("SELECT * FROM apply_images WHERE apply_random_id=$image->random_id");
		?>
        <div class="col-md-12">
                  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      <?php foreach($images as $idx=>$image): ?>
                      <div class="carousel-item <?= ($idx == 0) ? 'active' : '' ?>">
                        <img style="height: 800px;" class="d-block w-100" src="<?=base_url('/'.$image->image); ?>" alt="First slide">
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  
                  </div>
                  
              </div>
		<?php
	}

	public function source_video($id)
	{   
        $get_id = $this->Dashboard_model->mysqlij("SELECT * FROM apply_videos WHERE id='$id'");
		$get_data =  $this->Dashboard_model->mysqlij("SELECT * FROM apply_jobs WHERE random_id='$get_id->video_random_id'");
       
		$job_applications =  $this->Dashboard_model->mysqlii("SELECT * FROM apply_jobs WHERE NOT id IN(SELECT apply_id FROM short_lists) AND circular_id='$get_data->circular_id' ORDER BY id DESC");
		?>
		<?php foreach($job_applications as $row): ?>
			<?php 
				$videos = $this->Dashboard_model->mysqlii("SELECT * FROM apply_videos WHERE video_random_id='$row->random_id'");
				$one = $this->Dashboard_model->mysqlij("SELECT * FROM apply_videos WHERE video_random_id='$row->random_id' ORDER BY id ASC LIMIT 1");
			 ?>
		   <div class="col-md-3" id="source_data_<?php echo $row->id; ?>">
			 
			<div class="card card_content" style="width: 26.5rem; margin: 5px auto;">
			  <?php if($get_id->video_random_id == $row->random_id): ?>
				<video style="height: 250px;" class="video_src" src="<?=base_url('/'.$get_id->video); ?>" controls></video>
			  <?php else: ?>
				<video style="height: 250px;" class="video_src" src="<?=base_url('/'.$row->video_cv); ?>" controls></video>
			  <?php endif; ?> 
				  <div class="card-body">
				  <?php foreach($videos as $key=>$video_data): ?>
					<a  style="cursor: pointer; color: white;" class="btn btn-primary btn-sm source_video" data-id="<?php echo $video_data->id; ?>"><?php echo $key+1; ?></a>
					<?php endforeach; ?><br><br>
					 <h5 class="card-title">Phone: <?php echo $row->phone; ?></h5><br>
					 <button type="button" class="btn btn-success view_image" data-id="<?php echo $row->id; ?>">View</button><br><br>
					 <a href="<?php echo $row->portfolio_link; ?>" class="btn btn-primary" target="__blank">See Portfolio</a><br><br>
					 <textarea onfocusout=save_remarks(<?= $row->id; ?>) class="form-control" name="remarks[<?php echo $row->id; ?>]"><?php echo $row->remarks; ?></textarea><br>
					 <input style="cursor: pointer;" type="checkbox" class="selected_short" name="select_short[]" id="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" data-id="<?php echo $row->id; ?>">
					 <label for="<?php echo $row->id; ?>">Select to short list</label>
				  </div>
			 </div>

			 
		   </div>
		   
		  <?php endforeach; ?> 
		  <?php
	}

	public function view_video_display($id)
	{    
		//1239
		$short_data = $this->Dashboard_model->mysqlij("SELECT * FROM short_lists WHERE apply_id='$id'");

		$s_interview_data = $this->Dashboard_model->mysqlij("SELECT * FROM interview_calls WHERE call_interview_id='$id'");
        if($short_data)
		{
			$get_data = $short_data;
		}
		else
		{
			$get_data = $s_interview_data;
		}
		
		$get_candidate = $this->Dashboard_model->mysqlij("SELECT * FROM apply_jobs WHERE id='$get_data->apply_id'");
		$videos = $this->Dashboard_model->mysqlii("SELECT * FROM apply_videos WHERE video_random_id='$get_candidate->random_id'");
		if(count($videos) > 0)
		{
			?>
			<?php foreach($videos as $row): ?>
			<div class="col-md-3">
				
				<div class="card card_content" style="width: 26.5rem; margin: 5px auto;">
				
					<video style="height: 250px;" class="video_src" src="<?=base_url('/'.$row->video); ?>" controls></video>
				
				</div>
			</div>
				
			<?php endforeach; ?>
			<?php
		}
		else
		{
			echo "no_data";
		}
		
	}
	
	
	public function document_managment(){
		$data = array();
		
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			 if(isset($_POST['save'])){
				
				$this->form_validation->set_rules('document_name','document_name','required');
				$this->form_validation->set_rules('renew_date','renew_date','required');
				$this->form_validation->set_rules('expiration_date','expiration_date','required');
				//$this->form_validation->set_rules('image_docs','image_docs','required');
				$this->form_validation->set_rules('note','note','required'); 
				
				if($this->form_validation->run() == FALSE){
					/* print("Failed."); exit();
					redirect(current_url()); */
				}else{
					
					$target_dir = './assets/uploads/documents/';
					$target_file = basename($_FILES["image_docs"]["name"]);
					$file_name = time().$target_file;
					move_uploaded_file($_FILES["image_docs"]["tmp_name"], $target_dir.$file_name);
					
					$data = array(
						'document_name' => $this->input->post('document_name'),
						'renew_date' => $this->input->post('renew_date'),
						'expiration_date' => $this->input->post('expiration_date'),
						'file_url' => $file_name,
						'note' => $this->input->post('note')
					);
					
					$insert = $this->db->insert('document_managment', $data);
					if($insert){
						$insert_id = $this->db->insert_id();
						$last_data = $this->db->query("SELECT * from document_managment where id='$insert_id'")->row();
						$last_data_log = array(
							'document_id' => $last_data->id,
							'document_name' => $last_data->document_name,
							'renew_date' => $last_data->renew_date,
							'expiration_date' => $last_data->expiration_date, 
							'file_url' => $last_data->file_url,
							'note' => $last_data->note
						);
						$this->db->insert('document_managment_log', $last_data_log);
						
						alert('success','Save Successfully!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please try Again');
						redirect(current_url());
					}
				}
				
			} 
			
			if(isset($_POST['update'])){
				$update_id = $this->input->post('update_id');
				
				if(!empty($_FILES["image_docs"]["name"])){
					$target_dir = './assets/uploads/documents/';
					$target_file = basename($_FILES["image_docs"]["name"]);
					$file_name = time().$target_file;
					move_uploaded_file($_FILES["image_docs"]["tmp_name"], $target_dir.$file_name);
					
					$data = array(
						'document_name' => $this->input->post('document_name'),
						'renew_date' => $this->input->post('renew_date'),
						'expiration_date' => $this->input->post('expiration_date'),
						'file_url' => $file_name,
						'note' => $this->input->post('note')
					);
				}else{
					$data = array(
						'document_name' => $this->input->post('document_name'),
						'renew_date' => $this->input->post('renew_date'),
						'expiration_date' => $this->input->post('expiration_date'),
						'note' => $this->input->post('note')
					);
				}
				
				$update = $this->db->where('id', $update_id)->update('document_managment', $data);
				
				if($update){
					$edit = $this->db->query("SELECT * from document_managment where id='$update_id'")->row();
					$data_log = array(
						'document_id' => $edit->id,
						'document_name' => $edit->document_name,
						'renew_date' => $edit->renew_date,
						'expiration_date' => $edit->expiration_date, 
						'file_url' => $edit->file_url,
						'note' => $edit->note
					);
					$this->db->insert('document_managment_log', $data_log);
					
					alert('success','Save Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }
			/* 
			if(isset($_POST['delete_id'])){
				$delete_id = $this->input->post('delete_id');
				
				$delete = $this->db->where('id', $delete_id)->delete('complain_category');
				if($delete){
					alert('success','Deleted Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 } */
			
			if(isset($_POST['edit'])){
				$id = $this->input->post('id');
			 	$data['edit'] = $this->db->query("SELECT * from document_managment where id='$id'")->row();
			}
			
			 /* $complain_category_list = $this->db->query("SELECT complain_category.id, complain_category.department_id, complain_category.name, complain_category.status, department.department_name
			 from complain_category
			 left join department on complain_category.department_id=department.department_id
			 ");
			 $data['complain_category_list'] = $complain_category_list->result();
			  */
			
			$sql = $this->db->query("select * from document_managment");
			$data['results'] = $sql->result(); 
		
			$data['title_info'] = 'Document Management'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/document_management/document_management',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	public function document_log(){
		if(isset($_POST)){
			$doc_id = $this->input->post('doc_id');
			$sql = $this->db->query("SELECT * from document_managment_log where document_id='$doc_id'");
			$data["results"] = $sql->result();
			$logs  = $this->load->view("template/document_management/document_log",$data,TRUE);
			echo $logs;
		}
	}
	
	public function document_image(){
		if(isset($_POST)){
			$docs_img = $this->input->post('docs_img');
			$sql = $this->db->query("SELECT * from document_managment where id='$docs_img'");
			$data["results"] = $sql->row();
			$logs  = $this->load->view("template/document_management/document_image",$data,TRUE);
			echo $logs;
		}
	}
	
	public function log_img(){
		if(isset($_POST)){
			$log_img = $this->input->post('log_img');
			$sql = $this->db->query("SELECT * from document_managment_log where id='$log_img'");
			$data["results"] = $sql->row();
			$logs  = $this->load->view("template/document_management/document_image",$data,TRUE);
			echo $logs;
		}
	}
	
	public function employee_festival_bonus(){
		$data = array();
		if (!isset($_SESSION['super_admin']['email'])) {
			redirect(base_url('admin/login'));
		} else {
			if(isset($_POST['save'])){
				$festival_name = $this->input->post("festival_name");
				$festival_year = $this->input->post("festival_year");
				$festival_date = $this->input->post("festival_date");
				$adjustment_date = $this->input->post("adjustment_date");
				$percentage_six_months = $this->input->post("percentage_six_months");
				$percentage_tweelve_months = $this->input->post("percentage_tweelve_months");
				
				$festival_date = date("Y-m-d", strtotime($festival_date));
				$adjustment_date = date("Y-m-d", strtotime($adjustment_date));
				
				// check if festival bonus already generated.
				$sql_check = $this->db->query("select id from festival_bonus where festival_date='$festival_date'");
				$query_execute = $sql_check->num_rows();
				if($query_execute > 0){
					echo "Festival bonus report already generated for this festival please download!";
					exit();
				}
				
				$sql = "call festival_bonus('".$adjustment_date."')";
				$sql_query = $this->db->query($sql);
				$emp_bonus = $sql_query->result();
				// bellow two line is for procedural call handling.
				$sql_query->next_result(); 
				$sql_query->free_result(); 
				
				$bonus_data = array();
				foreach($emp_bonus as $bonus){
					
					if(empty($bonus->increament) && empty($bonus->decreament)){
						$current_salary = $bonus->basic_salary;
					}else{
						if(empty($bonus->increament) && !empty($bonus->decreament)){
							$current_salary = $bonus->basic_salary - $bonus->decreament;
						}elseif(!empty($bonus->increament) && empty($bonus->decreament)){
							$current_salary = $bonus->basic_salary + $bonus->increament;
						}else{
							$current_salary = $bonus->basic_salary + $bonus->increament - $bonus->decreament;
						}
					}
					
					if($bonus->working_days < 365){
						$festival_bonus = (30 * $current_salary * $percentage_six_months) / 100;
						$stability = "6+ Months (Bonus: $percentage_six_months %)";
					}else{
						$festival_bonus = (30 * $current_salary * $percentage_tweelve_months) / 100;
						$stability = "1+ Years (Bonus: $percentage_tweelve_months %)";
					}
					
					$data = array(
						"festival_id" => $festival_name,
						"festival_year" => $festival_year,
						"festival_date" => $festival_date,
						"employee_id" => $bonus->employee_id,
						"employee_name" => $bonus->full_name,
						"employee_department" => $bonus->department_name,
						"employee_designation" => $bonus->designation_name,
						"current_salary" => $current_salary,
						"monthly_salary" => $current_salary * 30,
						"festival_bonus" => $festival_bonus,
						"adjustment_date" => $adjustment_date,
						"stability" => $stability,
					);
					
					$bonus_data[] = $data;
				}
				$this->Dashboard_model->insert_batch('festival_bonus', $bonus_data);
				alert('success','Festival bonus generated successfully!');
			 	redirect(current_url());
				
			}
			if(isset($_POST['festival_delete'])){
				$festival_date = $this->input->post("festival_date");
				$this->db->query("delete from festival_bonus where festival_date='$festival_date'"); 
				alert('danger','Festival bonus deleted!');
			 	redirect(current_url());
			}
			$show = $this->db->query("select * from festival_bonus group by festival_date order by festival_date desc");
			$data['bonus'] = $show->result();
			
			$data['title_info'] = 'Bonus - Employee Festival Bonus';
			$data['header'] = $this->load->view('include/header', '', TRUE);
			$data['nav'] = $this->load->view('include/nav', '', TRUE);
			$data['article'] = $this->load->view('template/hrm/payroll/employee_festival_bonus', $data, TRUE);
			$data['footer'] = $this->load->view('include/footer', '', TRUE);
			$this->load->view('dashboard', $data);
		}
	}
	
	public function download_employee_festival_bonus()
	{
		
		$festival_date = $_GET['festival_date'];
		$sql = $this->db->query("select * from festival_bonus where festival_date='$festival_date'");
		$results = $sql->result();
		//echo $this->db->last_query(); exit();
		//print_r($result); exit();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'SERIAL');
		$sheet->setCellValue('B1', 'FESTIVAL NAME');
		$sheet->setCellValue('C1', 'EMPLOYEE ID');
		$sheet->setCellValue('D1', 'EMPLOYEE NAME');
		$sheet->setCellValue('E1', 'DEPARTMENT');
		$sheet->setCellValue('F1', 'DESIGNATION');
		$sheet->setCellValue('G1', 'DAILY SALARY');
		$sheet->setCellValue('H1', 'MONTHLY SALARY');
		$sheet->setCellValue('I1', 'FESTIVAL BONUS');
		$sheet->setCellValue('J1', 'EMPLOYMENT DURATION');
		
		$row = 2;
		$serial = 1;
		foreach($results as $result){
			$sheet->setCellValue("A$row", $serial);
			$sheet->setCellValue("B$row", $result->festival_id == 1 ? "Eid al-Fitr":"Eid al-Adha");
			$sheet->setCellValue("C$row", $result->employee_id);
			$sheet->setCellValue("D$row", $result->employee_name);
			$sheet->setCellValue("E$row", $result->employee_department);
			$sheet->setCellValue("F$row", $result->employee_designation);
			$sheet->setCellValue("G$row", $result->current_salary);
			$sheet->setCellValue("H$row", $result->monthly_salary);
			$sheet->setCellValue("I$row", $result->festival_bonus);
			$sheet->setCellValue("J$row", $result->stability);
			
			$row++;
			$serial++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Employee-festival-bonus';
 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		 
		$writer->save('php://output');
		
	}
	
	public function employee_festival_bonus_show(){
		$festival_date = $_GET['festival_date'];
		$sql = $this->db->query("select * from festival_bonus where festival_date='$festival_date'");
		$data['results'] = $sql->result();
		$sql2 = $this->db->query("select sum(festival_bonus) as total_bonus, 
		count(id) as total_employee
		from festival_bonus where festival_date='$festival_date'");
		$sql_result = $sql2->row();
		$data['total_bonus'] = $sql_result->total_bonus;
		$data['total_employee'] = $sql_result->total_employee;
		
		$html = $this->load->view('template/hrm/payroll/employee_festival_bonus_show', $data, true);
		echo $html;
	}



}
