<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Accounts extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('payment');
		$this->load->helper(array('form', 'url'));
		
	}

    public function manage_expense(){
        $data = array();
		$department = $_SESSION['user_info'] ['department'];
		date_default_timezone_set('Asia/Dhaka');
        $date_time = date('Y-m-d h:i:s a', time());
		$id_emp = $_SESSION['super_admin']['employee_ids'];
		$branch_ids=$_SESSION['super_admin']['branch'];
		

		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else
		{
			if (isset($_POST['add_item'])) {
				$item=addslashes($this->input->post('name'));
			}

			if (isset($_POST['vendor_id'])) {
				$vendor_id=$this->input->post('vendor_id');
				$items= $this->db->query("SELECT expense_sub_type.id AS item_id, expense_sub_type.head_name AS item_name from  expense_sub_type,vendor_product where vendor_product.scm_vendor_id='$vendor_id' AND vendor_product.expense_sub_type_id = expense_sub_type.id")->result();
				
				echo "<option selected disabled>-- select one --</option>";
				foreach ($items as $item) {
					echo "<option value='$item->item_id'>$item->item_name</option>";
				}
				exit;
			}

			if (isset($_POST['addvendor'])) {
				echo $html=$this->load->view('template/accounts/vendor_modal',$data,TRUE);
				exit;
			}

			if (isset($_POST['item_id'])) {
				$item_id=$_POST['item_id'];
				$data['exp_type'] = $this->db->query("SELECT expense_sub_type.id AS items_id, expense_sub_type.head_name AS items_name from expense_sub_type where id='$item_id'")->row();
				$data['unit_types'] = $this->db->query("SELECT id, name from scm_unit")->result();
				$data['tax_rate'] = $this->db->query("SELECT * from tax_rates")->result();
				$data['discount_rate'] = $this->db->query("SELECT * from discount_rates")->result();
				echo $html=$this->load->view('template/accounts/product',$data,TRUE);
				exit;
			}
			if (isset($_POST['unit_type_name'])) {
				$unit_type_name=addslashes($this->input->post('unit_type_name'));
				$insert=$this->db->query("INSERT INTO scm_unit (name,created_at,created_by,status) VALUES ('$unit_type_name', '$date_time','$id_emp',1)");
				
				if($insert){
					$id = $this->db->insert_id();
					echo "<option value='$id'>$unit_type_name</option>";
					alert('success','Save Successfully!');
					exit;
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
					exit;
			 	}
			}
			if (isset($_POST['addunit_type'])) {
				echo $html=$this->load->view('template/accounts/unit_type_modal',$data,TRUE);
				exit;
			}
			if (isset($_POST['addtax'])) {
				echo $html=$this->load->view('template/accounts/tax_modal',$data,TRUE);
				exit;
			}
			if (isset($_POST['adddiscount'])) {
				echo $html=$this->load->view('template/accounts/discount_modal',$data,TRUE);
				exit;
			}
			if (isset($_POST['addbranch'])) {
				$data['branche'] = $this->db->query("SELECT * from branches")->result();
				$data['ids']=$_POST['addbranch'];
				$data['bqty']=$_POST['qt'];
				$data['branch_data']=isset($_POST['branch_data']) ? $_POST['branch_data']: '';
				echo $html=$this->load->view('template/accounts/branch_qty_modal',$data,TRUE);
				exit;
			}
			if (isset($_POST['branch_qt'])) {
				$branch=$_POST['branches'];
				$qty=$_POST['qtys'];
				$branches=[];
				foreach ($branch as $key=>$value) {
					$branches[]=array("bid"=>"$value","qt"=>$qty[$key]);
				}
				$brn=json_encode($branches);
				echo "<input type='hidden' name='branches[]' value='$brn'>";
				exit;
				// $branch=addslashes($this->input->post('branch'));
				// $qty=$this->input->post('qty');
				// $insert=$this->db->query("INSERT INTO tax_rates (tax_name, tax_rate) VALUES ('$tax_name', '$tax_rate')");

				// if ($insert && $_POST['current_uri'] != current_url()) {
				// 	$id = $this->db->insert_id();
				// 	echo "<option value='$id' selected>$tax_name (".$tax_rate."%)</option>";
				// 	exit;
				// }
			}
			if (isset($_POST['adjust_br_id'])) {
				$result=$this->db->query("SELECT amount from branch_petty_cash where branch_id='$_POST[adjust_br_id]' ORDER BY id DESC")->row();
				echo $result->amount;
				exit;
			}
			if (isset($_POST['adjust_emp_id'])) {
				$result=$this->db->query("SELECT amount from advance_petty_cash where employee_id='10017' ORDER BY id DESC")->row();
				echo $result->amount;
				exit;
			}
			if (isset($_POST['single_exp'])) {
				// print_r($_POST);
				extract($_POST);
				$result;
				$utime = sprintf('%.4f', microtime(TRUE)); 
				$raw_time = DateTime::createFromFormat('U.u', $utime); 
				$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
				$today = $raw_time->format('dmy-his-u');
				$trx_id = 'TRX-'.$today;
				$uploader_id=$_SESSION['super_admin']['employee_ids'];
				$date=	date('Y-m-d H:i:s');
				
				$config = array();
				$config['upload_path'] = './assets/uploads/accounts';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|txt';
				$config['remove_spaces'] = TRUE;
				$config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $file_status =$this->upload->do_upload('file');
                $file_name = $this->upload->data('file_name');
				$due_amounts=isset($due_amount) ? $due_amount : '';
				$due_dates=isset($due_date) ? $due_date : '';
				$adjust_status=isset($adjust_status) ? $adjust_status : 0;
				
				if (!empty($items_id)) {
					if ($due_amounts<=0) {
						$pay_status="paid";
					}elseif ($due_amounts>0 && $due_amounts<$grandtotal) {
						$pay_status="defer";
					}else {
						$pay_status="due";
					}
					$result=$this->db->query("INSERT INTO expenses VALUES('','$trx_id','$branch_ids','$vendor','$total','$fixed_discount','$fixed_tax','$transit','$grandtotal','$due_amounts','$pay_status','$due_dates','$ref','$note','$file_name','$bill_date','0','$adjust_status','$uploader_id','$date')");
					
					// '$item','$amount','$qty','$dis_rate','$dis_amount','credit','$tax_rate','$tax_amount','debit','$total','debit',

					if ($exp_id = $this->db->insert_id()) {
						foreach ($items_id as $key => $item) {
							$item_names=$items_name[$key];
							$amounts=$amount[$key];
							$unit_types=$unit_type[$key];
							$qts=(int)$qty[$key];
							$sub_totals=(float)$sub_total[$key];
							$dis_rates=$dis_rate[$key];
							$dis_amounts=(float)$dis_amount[$key];
							$tax_rates=$tax_rate[$key];
							$tax_amounts=(float)$tax_amount[$key];
							$item_totals=(float)$item_total[$key];
							// print_r($branches[$key]);
							// echo "<br>";
							$item_branches=json_decode($branches[$key]);
							$result=$this->db->query("INSERT INTO purchese_item VALUES('','$trx_id','$exp_id','$vendor','$item','$item_names','$amounts','$unit_types','$qts','$sub_totals','$dis_rates','$dis_amounts','$tax_rates','$tax_amounts','$item_totals','$date')");
							$item_id = $this->db->insert_id();
							if (isset($item_branches) && !empty($item_branches)) {
								foreach ($item_branches as $i => $item_branch) {
									$branch_id= $item_branch->bid;
									$qti= (int)$item_branch->qt;
									$item_sub_total = $sub_totals/$qts*$qti;
									$dis_money=$dis_amounts/$qts*$qti;
									$tax_money=$tax_amounts/$qts*$qti;
									$br_item_total=$item_totals/$qts*$qti;
									$result=$this->db->query("INSERT INTO distributed_branch VALUES('','$trx_id','$exp_id','$branch_id','$item_id','$item','$amounts','$unit_types','$qti','$item_sub_total','$dis_rates','$dis_money','$tax_rates','$tax_money','$br_item_total','$date')");
										
								}
							}
						}
					}
					// $utime = sprintf('%.4f', microtime(TRUE)); 
					// $raw_time = DateTime::createFromFormat('U.u', $utime); 
					// $raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
					// $today = $raw_time->format('dmy-his-u');
					// $trx_id = 'TRX-'.$today;
					// foreach ( $branches as $key => $branche) {
					// 	$total=$amount*$qtys[$key];
					// 	$result=$this->db->query("INSERT INTO expenses VALUES('','$trx_id','$branch','$branche','','$item','$amount','$qtys[$key]','','','','','','','$total','credit','','$ref','','','','$note','$file_name','$bill_date','$date')");
					// }
				}else {
					alert('danger',"Something Wrong! Please try Again");
					redirect(current_url());
				}
				// if ($result) {
				// 	foreach($_POST['payment_method'] as $row => $value){		
				// 		if($_POST['payment_method'][$row] == 'Mobile Banking'){ 
				// 			$payment_details = 'Agent Name: '.$_POST['agent'][$row].', Mobile Banking Number: '.$_POST['mobile_banking_number'][$row].' Transaction Id: '.$_POST['transaction_id'][$row].'';
				// 			if($_POST['mobile_amount'][$row] > 0){
				// 				payment_varient($trx_id,$branch,'',$_POST['payment_method'][$row],$payment_details,'','',$_POST['mobile_amount'][$row],'',$uploader_id,'booking_info');
				// 			}
				// 		}else if($_POST['payment_method'][$row] == 'Credit / Debit Card'){			
				// 			$payment_details = 'Credit Card Number: '.$_POST['credit_card_number'][$row].' Card Secret: '.$_POST['card_secret'][$row].' Expiry Date: '.$_POST['Expiry_Date'][$row].'';			
				// 			if($_POST['Expiry_Date'][$row] > 0){
				// 				payment_varient($trx_id,$branch,'',$_POST['payment_method'][$row],$payment_details,(float)$_POST['card_amount'][$row] + (float)$_POST['Expiry_Date'][$row],'','','',$uploader_id,'booking_info');
				// 			}
				// 		}else if($_POST['payment_method'][$row] == 'Check'){			
				// 			$payment_details = 'Bank Name: '.$_POST['bank_name'][$row].' Check Number: '.$_POST['check_number'][$row].' Withdraw Date: '.$_POST['withdraw_date'][$row].'';
				// 			if($_POST['check_amount'][$row] > 0){
				// 				payment_varient($trx_id,$branch,'',$_POST['payment_method'][$row],$payment_details,'','','',$_POST['check_amount'][$row],$uploader_id,'booking_info');
				// 			}
				// 		}else{			
				// 			if(!empty($_POST['cash_other_information_remarks'][$row])){
				// 				$cash_other_information_remarks = $_POST['cash_other_information_remarks'][$row];
				// 			}else{
				// 				$cash_other_information_remarks = 'N / A';
				// 			}
				// 			$payment_details = 'More Information: '.$cash_other_information_remarks.'';
				// 			if($_POST['cash_amount'][$row] > 0){
				// 				payment_varient($trx_id,$branch,'',$_POST['payment_method'][$row],$payment_details,'',$_POST['cash_amount'][$row],'','',$uploader_id,'booking_info');
				// 			}
				// 		}
				// 	}
				// 	// alert('success','Acceptd Successfully!');
			 	// 	// redirect(current_url());
				// }
					
				if(!empty($_POST['payment_method_id'][0])){
					foreach($_POST['payment_method_id'] as $row => $value){
					  $payment_method_id = $_POST['payment_method_id'][$row];
					  $payment_method = $this->db->query("SELECT * from payment_method where id = '".$payment_method_id."'")->row();
					  $custom_fields = $this->db->query("SELECT * from  payment_custom_fields where payment_method_id = '".$payment_method_id."'")->result();
					  $payment_details = ''; 
					  $cash_amount = 0;
					  $mobile_amount = 0;
					  $card_amount = 0;
					  $check_amount = 0;
					  //print_r($custom_fields);
					  foreach($custom_fields as $row){
						 // print_r($row);
						//   exit;
						//echo $row->field_id;
						$field = $this->Dashboard_model->mysqlij("SELECT * from payment_method_fields where id = '".$row->field_id."'");
						 // print_r($field);
						  //exit;
						if(!empty($field->id) AND $field->field_type == 'text' OR $field->field_type == 'number' OR $field->field_type == 'date' OR $field->field_type == 'textarea'){
						  $payment_details .= '|' . $field->field_name . ': ' . $_POST['field_' . $field->id] . ',';
						}else if(!empty($field->id) AND $field->field_type == 'dropdown'){
						  $option_id = $this->db->query("select * from payment_field_option where id = '".$_POST['field_' . $field->id]."'")->row();
						  $payment_details .= '|' . $field->field_name . ': ' . $option_id->option_name . ',';
						} else if(!empty($field->id) AND $field->field_type == 'dropdown_multi'){
						  $dropdown_ids = $_POST['field_' . $field->id]; $all_options = '';
						  foreach($dropdown_ids as $row){
							$option_id = $this->db->query("select * from payment_field_option where id = '".$row."'")->row();
							$all_options .= $option_id->option_name . ',';
						  }
						  $payment_details .= '|' . $field->field_name . ': ' . $all_options . ',';
						}
						
						if($payment_method->id == 3){ //Cash							
						  if($field->id == 3){
							$cash_amount = $cash_amount + (float)$_POST['field_' . $field->id];
						  }
						} else if($payment_method->id == 4){ //Mobile Banking
						  if($field->id == 3){
							$mobile_amount = $mobile_amount + (float)$_POST['field_' . $field->id];
						  }
						} else if($payment_method->id == 5){ //Credit Card
						  if($field->id == 3){
							$card_amount = $card_amount + (float)$_POST['field_' . $field->id];
						  }
						} else if($payment_method->id == 6){ //Cheque
						  if($field->id == 3){
							$check_amount = $check_amount + (float)$_POST['field_' . $field->id];
						  }
						}
					  }
							  
					  if($payment_method->id == 3){ //Cash
						//print($cash_amount);
						//exit;
						if($cash_amount > 0){
							// print($cash_amount);
							// exit;
						  payment_varient($trx_id, $branch_ids, '', $payment_method->payment_method, $payment_details, '', $cash_amount, '', '', $uploader_id, 'expense_info');
						} 
					  } else if($payment_method->id == 4){ //Mobile Banking
						if($mobile_amount > 0){
							payment_varient($trx_id, $branch_ids, '', $payment_method->payment_method, $payment_details, '', '', $mobile_amount, '', $uploader_id, 'expense_info');
						}
					  } else if($payment_method->id == 5){ //Credit Card
						if($card_amount > 0){
							payment_varient($trx_id, $branch_ids, '', $payment_method->payment_method, $payment_details, $card_amount, '', '', '', $uploader_id, 'expense_info');
						}
					  } else if($payment_method->id == 6){ //Cheque
						if($check_amount > 0){
						  payment_varient($trx_id, $branch_ids, '', $payment_method->payment_method, $payment_details, '', '', '', $check_amount, $uploader_id, 'expense_info');
						}
					  }
					  
					}
				}
				
				if ($result)
				{
					echo $trx_id;
					exit;
					alert('success','Acceptd Successfully!');
					redirect(current_url());
				}
				else
				{
					alert('danger',"Something Wrong! Please try Again");
					redirect(current_url());
				}
				exit;
			}

			$data['payment_method'] = $this->Dashboard_model->select('payment_method', array('status' => '1'), 'id', 'asc', 'result');
			$data['exp_sub_type'] = $this->db->query("SELECT * from expense_sub_type")->result();
			$data['scm_vendors'] = $this->db->query("SELECT * from scm_vendor")->result();
			$data['branche'] = $this->db->query("SELECT * from branches where branch_id='$branch_ids'")->result();
			$data['adjsut_ability'] = $this->db->query("SELECT created_by FROM expenses WHERE created_by='$id_emp' AND status='0' AND adjust_status!='0'")->num_rows();

			$data['title_info'] = 'Add New | Expenses'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounts/expenses',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
    }

	public function tax_discount(){
        $data = array();

		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else
		{
			if (isset($_POST['tax'])) {
				$tax_name=addslashes($this->input->post('tax_name'));
				$tax_rate=$this->input->post('tax_rate');
				$insert=$this->db->query("INSERT INTO tax_rates (tax_name, tax_rate) VALUES ('$tax_name', '$tax_rate')");

				if ($insert && $_POST['current_uri'] != current_url()) {
					$id = $this->db->insert_id();
					echo "<option value='$id'>$tax_name (".$tax_rate."%)</option>";
					exit;
				}
				
				if($insert){
					alert('success','Save Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			}

			if (isset($_POST['tax_del'])) {
				$tax_del=$this->input->post('tax_del');
				if($this->db->query("DELETE FROM tax_rates WHERE id='$tax_del'")){
					alert('success','Deleted Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			}

			if (isset($_POST['discount'])) {
				$discount_name=addslashes($this->input->post('discount_name'));
				$discount_type=$this->input->post('discount_type');
				$sing="%";
				$sing=$discount_type=="rate" ? $sing : '';
				$discount_rate=$this->input->post('discount_rate');
				$insert=$this->db->query("INSERT INTO discount_rates (discount_name, discount_type,discount_value) VALUES ('$discount_name', '$discount_type','$discount_rate')");
				if ($insert && $_POST['current_uri'] != current_url()) {
					$id = $this->db->insert_id();
					echo "<option value='$id'>$discount_name (".$discount_rate,$sing.")</option>";
					exit;
				}
				if($insert){
					alert('success','Save Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			}

			if (isset($_POST['discount_del'])) {
				$discount_del=$this->input->post('discount_del');
				if($this->db->query("DELETE FROM discount_rates WHERE id='$discount_del'")){
					alert('success','Deleted Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			}

			
			 
			$data['taxes'] = $this->db->query("SELECT * from tax_rates")->result();
			$data['discounts'] = $this->db->query("SELECT * from  discount_rates")->result();

			$data['title_info'] = 'Add Tax & Discount'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounts/tax_discount',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}

	public function view_expenses(){
		$data = array();
		$department = $_SESSION['user_info'] ['department'];
		$id_emp = $_SESSION['super_admin']['employee_ids'];
		$branch_ids=$_SESSION['super_admin']['branch'];

		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else
		{
			if (isset($_POST['exp_id'])) {
				$exp_id=$_POST['exp_id'];
				$data['exp_info'] = $this->db->query("SELECT expenses.*,(SELECT employee.full_name FROM employee WHERE employee.employee_id=expenses.created_by) AS emp_name,(SELECT branch_name FROM branches WHERE branches.branch_id=expenses.branch_id) AS branch_name,(SELECT company_name FROM scm_vendor WHERE scm_vendor.id=expenses.vendor_id) AS company_name from expenses WHERE expenses.trx_id='$exp_id'")->row();

				$data['items_info']= $this->db->query("SELECT purchese_item.id AS item_id,item_name,unit_price, (SELECT name FROM scm_unit WHERE id=purchese_item.unit_type) AS unit_name,qty,sub_total,discount_amount,tax_amount,net_amount FROM expenses,purchese_item WHERE expenses.trx_id='$exp_id' AND purchese_item.trx_id='$exp_id'")->result();

				$data['branch_items']= $this->db->query("SELECT distributed_branch.* ,(SELECT branch_name FROM branches WHERE branches.branch_id=distributed_branch.dis_branch_id) AS br_name, (SELECT name FROM scm_unit WHERE id=distributed_branch.unit_type) AS unit_name FROM distributed_branch WHERE distributed_branch.trx_id ='$exp_id'")->result();
				echo $html=$this->load->view('template/accounts/exp_invoice',$data,TRUE);
				
				exit; 
			}
			// 
			if ($department=='2270968637477766714') {
				$data['expense_info'] = $this->db->query("SELECT expenses.*,(SELECT branch_name FROM branches WHERE expenses.branch_id=branches.branch_id) AS branch_name,(SELECT company_name FROM scm_vendor WHERE scm_vendor.id=expenses.vendor_id) AS company_name FROM expenses ORDER BY expenses.id DESC")->result();
			}else {
				$data['expense_info'] = $this->db->query("SELECT expenses.*,(SELECT branch_name FROM branches WHERE expenses.branch_id=branches.branch_id) AS branch_name,(SELECT company_name FROM scm_vendor WHERE scm_vendor.id=expenses.vendor_id) AS company_name FROM expenses WHERE created_by='$id_emp' ORDER BY expenses.id DESC")->result();
			}
			

			$data['title_info'] = 'Expense Transaction Table'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounts/expense_view',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}

	public function general_exp_approval(){
		$data = array();
		$emp_id = $_SESSION['super_admin']['employee_ids'];
		$branch_ids=$_SESSION['super_admin']['branch'];
		$uploader_info	=$emp_id.'__'.$_SESSION['user_info']['user'].'__'.$branch_ids;

		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else
		{ 
			
			if(isset($_POST["query"]))  
			{  
				$result=$this->db->query("SELECT trx_id FROM `expenses` WHERE `status`=0 AND trx_id LIKE '%".$_POST["query"]."%'")->result();
				// print_r($result);
				foreach ($result as $key => $trx) {
					$data[]= array('id'=>$trx->trx_id,'text'=>$trx->trx_id);
				}
				echo json_encode($data);
				exit; 
				// $output = '';  
				// $result = $this->db->query("SELECT * FROM expenses WHERE trx_id LIKE '%".$_POST["query"]."%'")->result();  
				// $output = '<ul class="list-unstyled">';  
				// if($result)  
				// {  
				// 	foreach($result as $trx)  
				// 	{  
				// 		$output .= '<li>'.$trx->trx_id.'</li>';  
				// 	}  
				// }  
				// else  
				// {  
				// 	$output .= '<li>Not Found</li>';  
				// }  
				// $output .= '</ul>';  
				// echo $output;  
				// exit;
			}

			if (isset($_POST["find_trx"]) && !empty($_POST["find_trx"])) {
				$exp_id=$_POST['find_trx'];
				$data['exp_info'] = $this->db->query("SELECT expenses.*,(SELECT employee.full_name FROM employee WHERE employee.employee_id=expenses.created_by) AS emp_name,(SELECT branch_name FROM branches WHERE branches.branch_id=expenses.branch_id) AS branch_name,(SELECT company_name FROM scm_vendor WHERE scm_vendor.id=expenses.vendor_id) AS company_name from expenses WHERE expenses.trx_id='$exp_id'")->row();

				$data['items_info']= $this->db->query("SELECT purchese_item.id AS item_id,item_name,unit_price,(SELECT name FROM scm_unit WHERE id=purchese_item.unit_type) AS unit_name,qty,sub_total,discount_amount,tax_amount,net_amount FROM expenses,purchese_item WHERE expenses.trx_id='$exp_id' AND purchese_item.trx_id='$exp_id'")->result();

				$data['branch_items']= $this->db->query("SELECT distributed_branch.* ,(SELECT branch_name FROM branches WHERE branches.branch_id=distributed_branch.dis_branch_id) AS br_name, (SELECT name FROM scm_unit WHERE id=distributed_branch.unit_type) AS unit_name FROM distributed_branch WHERE distributed_branch.trx_id ='$exp_id'")->result();
				$data['payment_info']= $this->db->query("SELECT * FROM `payment_received_method` WHERE payment_received_method.transaction_id ='$exp_id'")->result();
				// $data['account_type']=$this->db->query("SELECT * FROM `account_head`")->result();
				echo $html=$this->load->view('template/accounts/exp_approval',$data,TRUE);
				
				exit; 
			}

			if (isset($_GET['select_query'])) {
				$q=$_GET['select_query'];
				$result=$this->db->query("SELECT id,ac_name FROM `account_head` WHERE ac_name LIKE '%".$q."%'")->result();
				// print_r($result);
				foreach ($result as $key => $row) {
					$data[]= array('id'=>$row->id,'text'=>$row->ac_name);
				}
				echo json_encode($data);
				exit; 
			}
			if(isset($_POST['approve'])){
				extract($_POST);
				// print_r($_POST);
				// exit;
				if (!empty($item_s)) {
					foreach ($item_s as $key => $item) {
						$item= $item;
						$ac_head=$acount_head[$key];
						//account_process(account_ID, amount, 'c', 'referance_no', 'Cash', 'care_of', 'cost_center', '');
						foreach ($cost_center[$key] as $i => $costCenter) {
							// echo $costCenter;
							if (!empty($sub_tk[$key][$i])) {
								account_process(4, $sub_tk[$key][$i], 'd', $trx_id, 'Cash', $care_of, $costCenter, '');
							}
							if (!empty($tax_tk[$key][$i])) {
								account_process(14, $tax_tk[$key][$i], 'd', $trx_id, 'Cash', $care_of, $costCenter, '');
							}
							if (!empty($dis_tk[$key][$i])) {
								account_process($ac_head, $dis_tk[$key][$i], 'c', $trx_id, 'Cash', $care_of, $costCenter, '');
							}
						}
					}
				}
				if (!empty($transit_tk)) {
					account_process($transit_ac, $transit_tk, 'd', $trx_id, 'Cash', $care_of, $br_id, '');
				}
				if (!empty($fixed_tax_tk)) {
					account_process($fixed_tax_ac, $fixed_tax_tk, 'd', $trx_id, 'Cash', $care_of, $br_id, '');
				}
				if (!empty($fixed_discount_tk)) {
					account_process($fixed_discount_ac, $fixed_discount_tk, 'c', $trx_id, 'Cash', $care_of, $br_id, '');
				}
				if (!empty($payment_tk)) {
					foreach ($payment_tk as $key => $pay_tk) {
						if (!empty($pay_tk)) {
							account_process($payment_ac[$key], $pay_tk, 'c', $trx_id, $pay_method[$key], $care_of, $br_id, '');
						}
					}
				}
				if (!empty($due_tk)) {
					account_process($due_ac, $due_tk, 'c', $trx_id, 'payable', $care_of, $br_id, '');
				}
				if (!empty($adjust_tk)) {
					account_process($adjust_ac, $adjust_tk, 'c', $trx_id, 'receivable', $care_of, $br_id, '');
				}
				//adjustment with branch petty cash
				if (!empty($adjust_type) && $adjust_type=='2' && !empty($adjust_tk)) {
					$result=$this->db->query("SELECT id FROM `branch_petty_cash` WHERE branch_id='$br_id' ORDER BY id DESC")->row();
					$this->db->query("UPDATE `branch_petty_cash` set amount=amount-$adjust_tk where branch_id='$br_id' AND id='".$result->id."'");
						
					$transaction_data = array(
						'id' => '',
						'transaction_id' => $trx_id,
						'branch_id' => $br_id,
						'amount' => $grand_tk,
						'note' => 'expense from petty cash',
						'status' => '1',
						'uploader_info' => $uploader_info,
						'data' => date('d/m/Y'),
						'balance' => ''
					);	
					$this->Dashboard_model->insert('instant_transaction_logs',$transaction_data);
				}
				//adjustment with  advance_petty_cash 
				if (!empty($adjust_type) && $adjust_type=='1' && !empty($adjust_tk)) {
					$result=$this->db->query("SELECT id FROM `advance_petty_cash` WHERE employee_id='$care_of' ORDER BY id DESC")->row();
					$this->db->query("UPDATE `advance_petty_cash` set amount=amount-$adjust_tk where employee_id='$care_of' AND id='".$result->id."'");
										
					$transaction_data = array(
						'id' => '',
						'transaction_id' => $trx_id,
						'branch_id' => $br_id,
						'employee_id' => $care_of,
						'amount' => $grand_tk,
						'note' => 'expense from advance money',
						'approval' => '0',
						'status' => '1',
						'uploader_info' => $uploader_info,
						'data' => date('d/m/Y')
					);	
					$this->Dashboard_model->insert('advance_transaction_logs',$transaction_data);
				}
				$result=$this->db->query("UPDATE expenses SET status='1' WHERE trx_id='$trx_id'");

				$transaction_information = "insert into transaction values(
					'',
					'".$trx_id."',
					'".$this->db->escape_str($br_id)."',
					'',
					'".$this->db->escape_str($vendor_nam)."',
					'Defult',
					'Defult',
					'".$this->db->escape_str((float)$grand_tk)."',
					'".$this->db->escape_str(date('l, d/m/Y h:i:sa'))."',
					'Debit',
					'Expense Account',
					'',
					'',
					'',
					'',
					'Expenses',
					'1',
					'".$this->db->escape_str($uploader_info)."',
					'".$this->db->escape_str(date('d/m/Y'))."'
				)";	
				$insert_query=$this->db->query($transaction_information);
				if ($result)
				{
					alert('success','Acceptd Successfully!');
					redirect(current_url());
				}
				else
				{
					alert('danger',"Something Wrong! Please try Again");
					redirect(current_url());
				}
			}
			if (isset($_POST['reject'])) {
				$result=$this->db->query("UPDATE expenses SET status='2' WHERE trx_id='$trx_id'");
				if ($result)
				{
					alert('success','Acceptd Successfully!');
					redirect(current_url());
				}
				else
				{
					alert('danger',"Something Wrong! Please try Again");
					redirect(current_url());
				}
			}
			
			$data['title_info'] = 'Expense Transaction Table'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounts/general_exp_approval',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}

}