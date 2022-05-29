<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');		
	}
	
	
	//---------Start employee_approved_widthdraw_list-------------
	public function employee_approved_widthdraw_list(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			
			$data['title_info'] = 'Employee Approved Widthdraw List (Accounting)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/employee_approved_widthdraw_list',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End employee_approved_widthdraw_list
	
	//---------Start employee_widthdraw_list-------------
	public function employee_widthdraw_list(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			
			$data['title_info'] = 'Employee Widthdraw List (Accounting)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/employee_widthdraw_list',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End employee_widthdraw_list
	
	
	//---------Start ipo_member_list-------------
	public function ipo_member_list(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			
			$data['title_info'] = 'IPO Member List (Accounting)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/ipo_member_list',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End ipo_member_list	
	
	//---------Start Check out member list-------------
	public function checkout_member_list(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			
			$data['title_info'] = 'CheckOut Member List (Accounting)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/checkout_member_list',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End Check out member list
	
	//---------Start Check out member list Member-------------
	public function checkout_member_list_member(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
		
			$data['refund_sms_check'] = 'true';
			
			$data['title_info'] = 'CheckOut Member List (CRM REPORT)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/checkout_member_list_member',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End Check out member list  Member
	
	//---------Start Check out member list Member-------------
	public function checkout_old_member_list_member(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{			
			
			$data['title_info'] = 'CheckOut Old Member List (CRM REPORT)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/checkout_old_member_list_member',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End Check out member list  Member
	
	//---------Start Check out member list Member-------------
	public function checkout_old_member_list_member_insert(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$newfile = null;
			if($_FILES['file']['name'] != '' ){
				$filename 		= $_FILES['file']["name"];
				$file_tmp 		= $_FILES['file']["tmp_name"];
				$file_ext 		= substr($filename, strripos($filename, '.'));
				$newfilename 	= md5($filename).'_FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
				$newfile 		= 'assets/uploads/member/old_member_document/' . $newfilename;	
				move_uploaded_file($file_tmp,$newfile);
			}

			$data = array(
				'branch' => $_POST['branch'],
				'card_no' => $_POST['card_no'],
				'name' => $_POST['name'],
				'phone' => $_POST['phone'],
				'bed' => $_POST['bed'],
				'check_in' => $_POST['check_in'],
				'check_out' => $_POST['check_out'],
				'package' => $_POST['package'],
				'security_deposit' => '0',
				'file' => $newfile
			);
			

			$this->Dashboard_model->insert('old_member_directory', $data);

			redirect(base_url('admin/accounting/transaction/checkout-old-member-list'));
		}
	}
	//---------End Check out member list  Member


	public function checkout_old_member_list_member_payment_insert()
	{
		
		$utime = sprintf('%.4f', microtime(TRUE)); 
		$today = DateTime::createFromFormat('U.u', $utime);  
		$today->setTimezone(new DateTimeZone('Asia/Dhaka')); 

		$old_member = $this->Dashboard_model->mysqlij("SELECT * from old_member_directory where id = " . $_POST['old_member_id']);
		// var_dump($old_member->card_no);
		// exit();

		$branch_info = $this->Dashboard_model->mysqlij("SELECT branch_code FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'");
		$transaction_id = $branch_info->branch_code.'-'.$today->format('dmy-his-u');
		$payment_method = '';
		$data_one = '';
		$data_two = '';
		$data_three = '';
		$payment_details = '';
		$p_uploader_info = uploader_info();
		$p_table = 'old_member_directory';
		$total_amount = 0;

		foreach($_POST['payment_method'] as $row => $value){		
			if($_POST['payment_method'][$row] == 'Mobile Banking'){ 
				$payment_details = 'Agent Name: '.$_POST['agent'][$row].', Mobile Banking Number: '.$_POST['mobile_banking_number'][$row].' Transaction Id: '.$_POST['transaction_id'][$row].'';			
				$data_one .= $_POST['payment_method'][$row].' | Agent Name | '.$_POST['agent'][$row].',';
				$data_two .= $_POST['payment_method'][$row].' | Mobile Banking Number | '.$_POST['mobile_banking_number'][$row].',';
				$data_three .= $_POST['payment_method'][$row].' | Transaction Id | '.$_POST['transaction_id'][$row].' | Amount | '.$_POST['mobile_amount'][$row].',';
				$payment_method .= $_POST['payment_method'][$row].',';
				if($_POST['mobile_amount'][$row] > 0){
					$total_amount += $_POST['mobile_amount'][$row];
					$this->payment_varient($transaction_id,'',$_POST['old_member_id'],$_POST['payment_method'][$row],$payment_details,'','',$_POST['mobile_amount'][$row],'',$p_uploader_info,$p_table);
				}
			}else if($_POST['payment_method'][$row] == 'Check'){			
				$payment_details = 'Bank Name: '.$_POST['bank_name'][$row].' Check Number: '.$_POST['check_number'][$row].' Withdraw Date: '.$_POST['withdraw_date'][$row].'';
				$data_one .= $_POST['payment_method'][$row].' | Bank Name | '.$_POST['bank_name'][$row].',';
				$data_two .= $_POST['payment_method'][$row].' | Check Number | '.$_POST['check_number'][$row].',';
				$data_three .= $_POST['payment_method'][$row].' | Withdraw Date | '.$_POST['withdraw_date'][$row].' | Amount | '.$_POST['check_amount'][$row].',';
				$payment_method .= $_POST['payment_method'][$row].',';
				if($_POST['check_amount'][$row] > 0){
					$total_amount += $_POST['check_amount'][$row];
					$this->payment_varient($transaction_id,'',$_POST['old_member_id'],$_POST['payment_method'][$row],$payment_details,'','','',$_POST['check_amount'][$row],$p_uploader_info,$p_table);
				}
			}else{			
				if(!empty($_POST['cash_other_information_remarks'][$row])){
					$cash_other_information_remarks = $_POST['cash_other_information_remarks'][$row];
				}else{
					$cash_other_information_remarks = 'N / A';
				}
				$data_one .= $_POST['payment_method'][$row].' | More Information | '.$_POST['cash_other_information_remarks'][$row].' | Amount | '.$_POST['cash_amount'][$row].',';
				$data_two .= '';
				$data_three .= '';	
				$payment_details = 'More Information: '.$cash_other_information_remarks.'';
				$payment_method .= $_POST['payment_method'][$row].',';
				if($_POST['cash_amount'][$row] > 0){
					$total_amount += $_POST['cash_amount'][$row];
					$this->payment_varient($transaction_id,'',$_POST['old_member_id'],$_POST['payment_method'][$row],$payment_details,'',$_POST['cash_amount'][$row],'','',$p_uploader_info,$p_table);
				}
			}
		}

		$db = get_instance()->db->conn_id;
		$transaction_information = $this->Dashboard_model->mysqliq("insert into transaction values(
			'',
			'".$transaction_id."',
			'',
			'".$_POST['old_member_id']."',
			'".mysqli_real_escape_string($db, $_POST['old_member_name'])."',
			'Defult',
			'Defult',
			'".mysqli_real_escape_string($db, (float)$total_amount)."',
			'".mysqli_real_escape_string($db, date('l, d/m/Y h:i:sa'))."',
			'Debit',
			'Old Member Deposit Return Account',
			'".mysqli_real_escape_string($db, $payment_method)."',
			'".mysqli_real_escape_string($db, $data_one)."',
			'".mysqli_real_escape_string($db, $data_two)."',
			'".mysqli_real_escape_string($db, $data_three)."',
			'Booking Money Collection',
			'1',
			'".mysqli_real_escape_string($db, uploader_info())."',
			'".mysqli_real_escape_string($db, date('d/m/Y'))."'
		)");

		$update = array(
			'security_deposit' => $total_amount,
			'status' => $_POST['status']
		);
		$this->Dashboard_model->update('old_member_directory', $update, $_POST['old_member_id']);

		if($_POST['payment_method'][0] == 'Check'){
			$dat = explode('-',date('Y-m-d'));
			$date = $dat[2].'/'.$dat[1].'/'.$dat[0];
			$this->Dashboard_model->mysqliq("insert into check_print_data values(
				'',
				'".mysqli_real_escape_string($db, 'BAR_011220_210463187872898170_1606780607')."',
				'".mysqli_real_escape_string($db, $date)."',
				'".mysqli_real_escape_string($db, $old_member->name)."',
				'".mysqli_real_escape_string($db, $total_amount)."',
				'".mysqli_real_escape_string($db, $this->convertNumberToWord($total_amount))."',
				'".mysqli_real_escape_string($db, $old_member->card_no)."',
				'".mysqli_real_escape_string($db, $_POST['check_number'][0])."',
				'".mysqli_real_escape_string($db, $_POST['note'])."',
				'1',
				'".mysqli_real_escape_string($db, uploader_info())."',
				'".mysqli_real_escape_string($db, date('d/m/Y'))."'
			)");
		}

		redirect(base_url('admin/accounting/transaction/checkout-old-member-list'));
	}

	function convertNumberToWord($num = false){
		$num = str_replace(array(',', ' '), '' , trim($num));
		if(! $num) {
			return false;
		}
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven',
			'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
		);
		$list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred');
		$list3 = array('', 'Thousand', 'Million', 'Billion', 'Trillion', 'Quadrillion', 'Quintillion', 'Sextillion', 'Septillion',
			'Octillion', 'Nonillion', 'Decillion', 'Undecillion', 'Duodecillion', 'Tredecillion', 'Quattuordecillion',
			'Quindecillion', 'Sexdecillion', 'Septendecillion', 'Octodecillion', 'Novemdecillion', 'Vigintillion'
		);
		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ( $tens < 20 ) {
				$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
			} else {
				$tens = (int)($tens / 10);
				$tens = ' ' . $list2[$tens] . ' ';
				$singles = (int) ($num_levels[$i] % 10);
				$singles = ' ' . $list1[$singles] . ' ';
			}
			$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		} //end for loop
		$commas = count($words);
		if ($commas > 1) {
			$commas = $commas - 1;
		}
		return implode(' ', $words). 'Taka Only';
	}

	

	//--------payment method------
	function payment_varient($tnsid,$branch_id,$booking_id,$payment_method,$payment_details,$card_amount,$cash_amount,$mobile_amount,$check_amount,$uploader_info,$table){
		$invoice_id = $this->Dashboard_model->mysqlij("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'super_hostel' AND TABLE_NAME = '".$table."'");
		$inv_id = date('dmY').$invoice_id->AUTO_INCREMENT;
		$db = get_instance()->db->conn_id;
		if($this->Dashboard_model->mysqliq("insert into payment_received_method values(
			'',
			'".mysqli_real_escape_string($db, $tnsid)."',
			'".mysqli_real_escape_string($db, $branch_id)."',
			'".mysqli_real_escape_string($db, $booking_id)."',
			'".mysqli_real_escape_string($db, $payment_method)."',
			'".mysqli_real_escape_string($db, $payment_details)."',
			'".mysqli_real_escape_string($db, $card_amount)."',
			'".mysqli_real_escape_string($db, $cash_amount)."',
			'".mysqli_real_escape_string($db, $mobile_amount)."',
			'".mysqli_real_escape_string($db, $check_amount)."',
			'".mysqli_real_escape_string($db, $inv_id)."',
			'',
			'1',
			'".mysqli_real_escape_string($db, $uploader_info)."',
			'".mysqli_real_escape_string($db, date('d/m/Y'))."'
		)")){
			return true;
		}else{
			return false;
		}		
	}

	
	
	//---------Start refunded_member_list-------------
	public function refunded_member_list(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			
			$data['title_info'] = 'Refunded Member List (Accounting)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/refunded_member_list',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End refunded_member_list
	
	
	//---------Start expence_ta_da_bill-------------
	public function expence_ta_da_bill(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			
			$data['title_info'] = 'TD/DA Bill (Accounting)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/expence_ta_da_bill',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End expence_ta_da_bill
	
	//---------Start ipo_member_widdraw_list-------------
	public function ipo_member_widdraw_list(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{		
			
			$data['title_info'] = 'Refunded Member List (Accounting)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/ipo_member_widdraw_list',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End ipo_member_widdraw_list
	
	//---------Start Check Print-------------
	public function check_print(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			
			$data['title_info'] = 'Print Check Information';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/check_print',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End Check Print
	
	//---------Start envelope_print-------------
	public function envelope_print(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			
			$data['title_info'] = 'Print Check';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/envelope_print',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End envelope_print
	
	//---------Start Employee List-------------
	public function employee_salary_list(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			
			$data['title_info'] = 'Print Check';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/salary_print',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End envelope_print
	
	//---------Start petty_cash-------------
	public function petty_cash(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			if(isset($_POST['add_amount'])){
				$check_data = $this->Dashboard_model->select('branch_petty_cash',array('branch_id' => $this->input->post('branch_id')),'id','desc','row');
				$_RWQUESTED_BRANCH = $this->Dashboard_model->mysqlii("SELECT * FROM petty_cash_request_logs WHERE status = '1' AND branch_id = '" . $this->input->post('branch_id') . "' ORDER BY id DESC");
				
				if(!empty($check_data->branch_id) AND $check_data->branch_id == $this->input->post('branch_id')){
					$new_amount = (float)$check_data->amount + (int)$this->input->post('amount');
					$update_data = array(
						'transaction_id' => $this->input->post('transaction_id'),
						'amount' => $new_amount,
						'given_date' => $this->input->post('date_given'),
						'note' => $this->input->post('note'),
						'uploader_info' => uploader_info()
					);
					$insert_data = array(
						'id' => '',
						'transaction_id' => $this->input->post('transaction_id'),
						'branch_id' => $this->input->post('branch_id'),
						'amount' => $this->input->post('amount'),
						'given_date' => $this->input->post('date_given'),
						'note' => $this->input->post('note'),
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					$update_request_logs = array(
						'status' => '2'
					);														
					$transaction_data = array(
						'id' => '',
						'transaction_id' => $this->input->post('transaction_id'),
						'branch_id' => $this->input->post('branch_id'),
						'note' => 'Petty Cash Recharge',
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y'),
						'balance' => $new_amount,
						'recharge_amount' => $this->input->post('amount')
					);
					if(
						$this->Dashboard_model->update('branch_petty_cash',$update_data,$check_data->id) AND
						$this->Dashboard_model->update('petty_cash_request_logs',$update_request_logs,$_RWQUESTED_BRANCH[0]->id) AND
						$this->Dashboard_model->insert('instant_transaction_logs',$transaction_data) AND
						$this->Dashboard_model->insert('branch_petty_cash_logs',$insert_data)
					){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}else{
					$insert_data = array(
						'id' => '',
						'transaction_id' => $this->input->post('transaction_id'),
						'branch_id' => $this->input->post('branch_id'),
						'amount' => $this->input->post('amount'),
						'given_date' => $this->input->post('date_given'),
						'note' => $this->input->post('note'),
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);	
					$update_request_logs = array(
						'status' => '2'
					);
					if(
						$this->Dashboard_model->insert('branch_petty_cash',$insert_data) AND
						$this->Dashboard_model->update('petty_cash_request_logs',$update_request_logs,$_RWQUESTED_BRANCH[0]->id) AND
						$this->Dashboard_model->insert('branch_petty_cash_logs',$insert_data)
					){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
				
				
			}
			
			
			
			$data['petty_cash'] = $this->Dashboard_model->mysqlii("SELECT * FROM branch_petty_cash ORDER BY id ASC");
			
			$data['branch'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches ORDER BY id ASC");
			$data['title_info'] = 'Petty Cash';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/petty_cash',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End petty_cash
	
	//---------Start advance_petty_cash-------------
	public function advance_petty_cash(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			if(isset($_POST['add_amount'])){
				if(isset($_POST['add_amount_accept'])){
					$insert_data = array(
						'id' => '',
						'transaction_id' => $this->input->post('transaction_id'),
						'employee_id' => $this->input->post('employee_id'),
						'amount' => $this->input->post('amount'),
						'given_date' => $this->input->post('date_given'),
						'note' => $this->input->post('note').' | '.$this->input->post('approver_note'),
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					$update_acceptence = array(
						'status' => '4'
					);						
					if(							
						$this->Dashboard_model->update('advance_money_request',$update_acceptence,$this->input->post('request_id')) AND
						$this->Dashboard_model->insert('advance_petty_cash_logs',$insert_data)
					){
						$employee_data = $this->Dashboard_model->select('employee',array('id' => $this->input->post('employee_id')),'id','desc','row');
						$number = $employee_data->personal_Phone;
						if($employee_data->gender == 'Male'){
							$gender = 'him';
						}else{
							$gender = 'her';
						}
						if(!empty($number)){
							$_SESSION['advance_pratty_warning_modal'] = "Please Check ".$employee_data->full_name."'s Status before give ".$gender." money!";
							alert('success',"Successfully Accepted!");
							redirect(current_url());
						}else{
							unset($_SESSION['advance_pratty_warning_modal']);
							alert('warning','Successfully Accepted! But Employee Phone Number is empty');
							redirect(current_url());
						}							
					}else{
						unset($_SESSION['advance_pratty_warning_modal']);
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}					
				}else if(isset($_POST['add_amount_reject'])){
					$update_acceptence = array(
						'status' => '3'
					);						
					if(
						$this->Dashboard_model->update('advance_money_request',$update_acceptence,$this->input->post('request_id'))
					){
						unset($_SESSION['advance_pratty_warning_modal']);
						alert('warning','Successfully Rejected!');
						redirect(current_url());
					}else{
						unset($_SESSION['advance_pratty_warning_modal']);
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}			
			}
			if(isset($_POST['distry_advance_pratty_warning'])){
				unset($_SESSION['advance_pratty_warning_modal']);
			}
			$data['petty_cash'] = $this->Dashboard_model->mysqlii("SELECT * FROM advance_petty_cash ORDER BY id ASC");
			$data['employee'] = $this->Dashboard_model->mysqlii("SELECT * FROM employee where status = '1' ORDER BY id ASC");
			$data['title_info'] = 'Advance Petty Cash';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/advance_petty_cash',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End advance_petty_cash
	
	//---------Start sms_employee_accept_money-------------
	public function sms_employee_accept_money($employee_id = '', $parameter_2 = ''){
		$data = array();
		if(!empty($employee_id)){			
			$get_emp_id = rahat_decode(rahat_decode($employee_id));
			$emp_info = $this->Dashboard_model->select('employee',array('employee_id' => $get_emp_id),'id','desc','row');
			$check_data = $this->Dashboard_model->select('advance_petty_cash',array('employee_id' => $emp_info->id),'id','desc','row');
			$transaction_id = rahat_decode($parameter_2);		
			
			$advance_money_info = $this->Dashboard_model->select('advance_petty_cash_logs',array('employee_id' => $emp_info->id , 'transaction_id' => $transaction_id),'id','desc','row');
			
			if(!empty($advance_money_info->transaction_id) AND !empty($check_data->transaction_id) AND $check_data->transaction_id == $advance_money_info->transaction_id){
				$messageee = '1';
			}else{
				if(isset($_POST['accept_money'])){
					if(!empty($advance_money_info->transaction_id)){
						if(!empty($check_data->employee_id) AND $check_data->employee_id == $emp_info->id){
							$new_amount = (float)$check_data->amount + (int)$advance_money_info->amount;
							$update_data = array(
								'transaction_id' => $advance_money_info->transaction_id,
								'amount' => $new_amount,
								'given_date' => $advance_money_info->given_date,
								'note' => $advance_money_info->note,
								'uploader_info' => $advance_money_info->uploader_info
							);
							$update_acceptence = array(
								'status' => '2'
							);
							$update_resend = array(
								'status' => '2'
							);
							$get_request_data = $this->Dashboard_model->select('advance_money_request',array('employee_id' => $emp_info->employee_id),'id','desc','row');
							if(
								$this->Dashboard_model->update('advance_petty_cash',$update_data,$check_data->id) AND
								$this->Dashboard_model->update('advance_money_request',$update_acceptence,$get_request_data->id) AND
								$this->Dashboard_model->update('advance_petty_cash_logs',$update_resend,$advance_money_info->id)
							){

								$get_previous_balance = $this->Dashboard_model->select('employee_petty_cash_overview', array('employee_id' => $emp_info->employee_id),'id','desc','row');
								$new_balance_generate = doubleval($get_previous_balance->balance) + doubleval($advance_money_info->amount);
								$array_for_employee_petty_cash_overview = array(
									'transection_id' => $advance_money_info->transaction_id,
									'employee_id' => $emp_info->employee_id,
									'withdraw' => $advance_money_info->amount,
									'balance' => $new_balance_generate
								);
								$this->Dashboard_model->insert('employee_petty_cash_overview',$array_for_employee_petty_cash_overview);

								$messageee = '3';
							}else{
								$messageee = '2';
							}
						}else{
							$insert_data = array(
								'id' => '',
								'transaction_id' => $advance_money_info->transaction_id,
								'employee_id' => $emp_info->id,
								'amount' => $advance_money_info->amount,
								'given_date' => $advance_money_info->given_date,
								'note' => $advance_money_info->note,
								'status' => '1',
								'uploader_info' => $advance_money_info->uploader_info,
								'data' => $advance_money_info->data
							);
							$update_acceptence = array(
								'status' => '2'
							);
							$update_resend = array(
								'status' => '2'
							);
							$get_request_data = $this->Dashboard_model->select('advance_money_request',array('employee_id' => $emp_info->employee_id),'id','desc','row');
							if(
								$this->Dashboard_model->insert('advance_petty_cash',$insert_data) AND
								$this->Dashboard_model->update('advance_money_request',$update_acceptence,$get_request_data->id) AND
								$this->Dashboard_model->update('advance_petty_cash_logs',$update_resend,$advance_money_info->id)
							){

								$get_previous_balance = $this->Dashboard_model->select('employee_petty_cash_overview', array('employee_id' => $emp_info->employee_id),'id','desc','row');
								$new_balance_generate = doubleval($get_previous_balance->balance) + doubleval($advance_money_info->amount);
								$array_for_employee_petty_cash_overview = array(
									'transection_id' => $advance_money_info->transaction_id,
									'employee_id' => $emp_info->employee_id,
									'withdraw' => $advance_money_info->amount,
									'balance' => $new_balance_generate
								);
								$this->Dashboard_model->insert('employee_petty_cash_overview',$array_for_employee_petty_cash_overview);
								
								$messageee = '3';
							}else{
								$messageee = '2';
							}
						}				
					}else{
						$messageee = '5';
					}			
				}else{
					$messageee = '4';
				}			
			}
			$data['message'] = $messageee;
			$data['title_info'] = 'Advance Cash Approval';
			$data['article'] = $this->load->view('template/accounting/transaction/sms_employee_accept_money',$data,TRUE); 
			$this->load->view('dashboard',$data);
		
		}else{	
			redirect(base_url());					
		}
	}
	//---------End sms_employee_accept_money
	
	//---------Start advance_petty_cash_approval-------------
	public function advance_petty_cash_approval(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			
			$data['employee'] = $this->Dashboard_model->mysqlii("SELECT * FROM employee ORDER BY id ASC");

			$data['title_info'] = 'Purses Item From Advance Money With Approval Logs'; //Advance Purses Item, Money & Aproval Logs
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/advance_petty_cash_approval',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End advance_petty_cash_approval

	//---------Start advance_petty_cash_approval-------------
	public function advance_money_overview_log(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			
			$data['employee'] = $this->Dashboard_model->mysqlii("SELECT * FROM employee where status = '1' ORDER BY id ASC");

			$data['title_info'] = 'Advance Money Overview Log';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/advance_money_overview_log',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End advance_petty_cash_approval
	
	//---------Start advance_petty_cash_return_approval-------------
	public function advance_petty_cash_return_approval(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			
			$data['employee'] = $this->Dashboard_model->mysqlii("SELECT * FROM employee where status = '1' ORDER BY id ASC");

			$data['title_info'] = 'Purses Item From Advance Money Return With Approval Logs';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/advance_petty_cash_return_approval',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End advance_petty_cash_return_approval
	
	//---------Start urgent_advance_petty_cash_employee_logs-------------
	public function urgent_advance_petty_cash_employee_logs(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			$data['title_info'] = 'My Urgent Expense List';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/urgent_advance_petty_cash_employee_logs',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End urgent_advance_petty_cash_employee_logs
	
	//---------Start urgent_advance_petty_cash_return_employee_logs-------------
	public function urgent_advance_petty_cash_return_employee_logs(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['removed_return_id'])){
				$removed_id = $_POST['removed_return_id'];
				$check_status = $this->Dashboard_model->select('advance_petty_cash_return_logs',array('id' => $removed_id, 'aproval' => '0'),'id','desc','row');
				if(!empty($check_status->id)){
					if($this->Dashboard_model->delete('advance_petty_cash_return_logs',$removed_id)){
						echo 'Request Removed Successfully';
					}else{
						echo 'Something Wrong! Please Try Again';
					}
				}else{
					echo 'Your Request is monitarized! Sorry You Can not remove it';
				}				
			}else{
				$data['title_info'] = 'My Urgent Return Logs';
				$data['header'] = $this->load->view('include/header','',TRUE); 
				$data['nav'] = $this->load->view('include/nav','',TRUE); 
				$data['article'] = $this->load->view('template/accounting/transaction/urgent_advance_petty_cash_return_employee_logs',$data,TRUE); 
				$data['footer'] = $this->load->view('include/footer','',TRUE); 
				$this->load->view('dashboard',$data);
			}					
		}
	}
	//---------End urgent_advance_petty_cash_return_employee_logs
	
	public function instant_transaction_slip()
	{
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['user_info']['department'] == '2270968637477766714'){ // Accounts department
				$data['branch'] = $this->Dashboard_model->mysqlii("SELECT * from branches");
			}else{
				$data['branch'] = $this->Dashboard_model->mysqlii("SELECT * from branches where branch_id = '".$_SESSION['super_admin']['branch']."'");
			}
			$data['title_info'] = 'Instant Transaction Slip';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/instant_transaction_slip_list',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}

	//---------Start view_instant_transaction_buy_something-------------
	public function view_instant_transaction_buy_something(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			if(isset($_POST['add_amount'])){
				$check_data = $this->Dashboard_model->select('branch_petty_cash',array('branch_id' => $this->input->post('branch_id')),'id','desc','row');
				if(!empty($check_data->branch_id) AND $check_data->branch_id == $this->input->post('branch_id')){
					$new_amount = (float)$check_data->amount + (int)$this->input->post('amount');
					$update_data = array(
						'transaction_id' => $this->input->post('transaction_id'),
						'amount' => $new_amount,
						'given_date' => $this->input->post('date_given'),
						'note' => $this->input->post('note'),
						'uploader_info' => uploader_info()
					);
					$insert_data = array(
						'id' => '',
						'transaction_id' => $this->input->post('transaction_id'),
						'branch_id' => $this->input->post('branch_id'),
						'amount' => $this->input->post('amount'),
						'given_date' => $this->input->post('date_given'),
						'note' => $this->input->post('note'),
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);
					if(
						$this->Dashboard_model->update('branch_petty_cash',$update_data,$check_data->id) AND
						$this->Dashboard_model->insert('branch_petty_cash_logs',$insert_data)
					){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}else{
					$insert_data = array(
						'id' => '',
						'transaction_id' => $this->input->post('transaction_id'),
						'branch_id' => $this->input->post('branch_id'),
						'amount' => $this->input->post('amount'),
						'given_date' => $this->input->post('date_given'),
						'note' => $this->input->post('note'),
						'status' => '1',
						'uploader_info' => uploader_info(),
						'data' => date('d/m/Y')
					);					
					if(
						$this->Dashboard_model->insert('branch_petty_cash',$insert_data) AND
						$this->Dashboard_model->insert('branch_petty_cash_logs',$insert_data)
					){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			$data['petty_cash'] = $this->Dashboard_model->mysqlii("SELECT * FROM branch_petty_cash ORDER BY id ASC");
			if($_SESSION['user_info']['department'] == '1806965207554226682'){ // Branch Operation
				$data['branch'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches where branch_id = '".$_SESSION['super_admin']['branch']."' ORDER BY id ASC");
			}else{
				$data['branch'] = $this->Dashboard_model->mysqlii("SELECT * FROM branches ORDER BY id ASC");
			}
			$data['title_info'] = 'View Instant Transaction (Buy Something)';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/transaction/view_instant_transaction_buy_something',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End view_instant_transaction_buy_something
	
	//---------Start accounts_loan_aproval-------------
	public function accounts_loan_aproval(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$data['title_info'] = 'Payroll - Increament Approval';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/aproval/accounts_loan_aproval',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}	
	//end exit accounts_loan_aproval

	//---------Start accounts_manage_accounts-------------
	public function accounts_manage_accounts(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			if(isset($_POST['save_account_type'])){
				$check_account_type = $this->Dashboard_model->select('account_type',array('branch_id' => $this->input->post('branch_id'), 'name' => $this->input->post('account_type') ),'id','desc','row');
				if(!empty($check_account_type->id)){
					alert('warning','Account type Allready Exixt! Please Try Again');
					redirect(current_url());
				}else{
					$serial = $this->Dashboard_model->mysqlii("select count(*) as total from account_type");
					if($serial[0]->total > 0){
						$get_serial = $this->Dashboard_model->mysqlii("select serial from account_type order by id desc");
						$number = $get_serial[0]->serial + 1;
						$serial = sprintf("%02d", $number);
					}else{
						$number = 0;
						$serial = sprintf("%02d", $number);
					}
					
					$get_branch_code = $this->Dashboard_model->mysqlii("select * from branches where branch_id = '".$this->input->post('branch_id')."'");
					if(!empty($this->input->post('parents_id'))){
						$get_parent_serial = $this->Dashboard_model->mysqlii("select * from account_type where id = '".$this->input->post('parents_id')."' order by id desc");
						$p_serial = $get_parent_serial[0]->code . '-' . $serial;
					}else{
						$p_serial = $get_branch_code[0]->branch_code . '-' . $serial;
					}
					$code_maker = $p_serial;
					if($this->input->post('opening_balance') > 0 ){
						$opening_balance = $this->input->post('opening_balance');
						$balance = $this->input->post('opening_balance');
					}else{
						$opening_balance = 0;
						$balance = 0;
					}
					
					$data = array(
						'id' 						=> '',
						'branch_id'			 		=> $this->input->post('branch_id'),
						'parents_id'			 	=> $this->input->post('parents_id'),
						'code' 						=> $code_maker,
						'serial' 					=> $serial,
						'name' 						=> $this->input->post('account_type'),
						'oppning_balance' 			=> $opening_balance,
						'closing_amount' 			=> '0',
						'last_transaction_type' 	=> '',
						'balance' 					=> $balance,
						'note' 						=> $this->input->post('note'),
						'status' 					=> $this->input->post('status'),
						'uploader_info' 			=> uploader_info(),
						'data' 						=> date('d/m/Y')
					);
					if( $this->Dashboard_model->insert('account_type',$data) ){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			if(isset($_POST['edit_data'])){
				$data['edit'] = $this->Dashboard_model->select('account_type',array('id' => $this->input->post('hidden_id')),'id','desc','row');
			}
			if(isset($_POST['update'])){
				$check_dublicate = $this->Dashboard_model->mysqlii("select * from account_type where branch_id = '".$this->input->post('branch_id')."' and name = '".$this->input->post('account_type')."' and id not in ('".$this->input->post('update_id')."')");
				if(!empty($check_dublicate[0]->id)){
					alert('warning','Account type Allready Exixt! Please Try Again');
					redirect(current_url());
				}else{
					$data = array(
						'name' 						=> $this->input->post('account_type'),
						'note' 						=> $this->input->post('note'),
						'status' 					=> $this->input->post('status'),
						'uploader_info' 			=> uploader_info(),
						'data' 						=> date('d/m/Y')
					);
					if( $this->Dashboard_model->update('account_type',$data,$this->input->post('update_id')) ){
						alert('success','Successfully Saved!');
						redirect(current_url());
					}else{
						alert('danger','Something Wrong! Please Try Again');
						redirect(current_url());
					}
				}
			}
			if(isset($_POST['delete_data'])){
				if($this->Dashboard_model->delete('account_type',$this->input->post('hidden_id'))){
					alert('success','Delete Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			}
			
			$data['title_info'] = 'Account Head Management';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/account/accounts_manage_accounts',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End accounts_manage_accounts	
	
	//---------Start accounts_chart_of_accounts-------------
	public function accounts_chart_of_accounts(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{	
			
			
			$data['title_info'] = 'Chart of Accounts';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/account/accounts_chart_of_accounts',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}
	//---------End accounts_chart_of_accounts
	
	
	public function expense_category()
	{
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			if(isset($_POST['save'])){
				$expense_types = explode(',', $_POST['expense_type']);
				foreach($expense_types as $expense_type){
					$insert_data = array(
						'head_name' => $expense_type,
						'updated_at' => date('Y-m-d H:i:s'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_by' => $_SESSION['super_admin']['employee_ids'],
					);
					$this->Dashboard_model->insert('expense_type', $insert_data);
					if(!empty($_POST['expense_sub_type'])){
						$sub_categories = explode(',', $_POST['expense_sub_type']);
						foreach($sub_categories as $sub_category){
							$insert_sub = array(
								'head_name' => $sub_category,
								'expense_type_id' => $this->db->insert_id(),
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s'),
								'updated_by' => $_SESSION['super_admin']['employee_ids'],
							);
							$this->Dashboard_model->insert('expense_sub_type', $insert_sub);
						}
					}
				}								
				alert('success','Successfully Saved!');
				redirect(current_url());
			}
			if(isset($_POST['update_sub_type_button'])){
				if(!empty($_POST['update_sub_type'])){
					$sub_categories = explode(',', $_POST['update_sub_type']);
					foreach($sub_categories as $sub_category){
						$insert_sub = array(
							'head_name' => $sub_category,
							'expense_type_id' => $_POST['expense_type_modal'],
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
							'updated_by' => $_SESSION['super_admin']['employee_ids'],
						);
						$this->Dashboard_model->insert('expense_sub_type', $insert_sub);
					}
				}				
				alert('success','Successfully Updated!');
				redirect(current_url());
			}
			$data['title_info'] = 'Expense Category';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/accounting/account/expense_category',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);		
		}
	}

	public function confirm_salary()
	{   
		$employee_id = $_POST['employee_id'];
		$month = $_POST['month'];
		$otp = $_POST['otp'];
		$get_day_month = explode('-',$month);
		$get_month = $get_day_month[1];
		$get_year = $get_day_month[0];
		$month_name = date('F', mktime(0, 0, 0, $get_month, 10));
		$date = date('d/m/Y');
		$time = date('h:i:s');
		$days = date('l', strtotime($date));
		$ampm = date('a');
		$employee = $this->Dashboard_model->mysqlij("SELECT * FROM employee WHERE employee_id='$employee_id'");
		$recent_otp = $this->Dashboard_model->mysqlij("SELECT * FROM sms_logs WHERE  `number`='$employee->personal_Phone' AND otp='$otp' ORDER BY id DESC LIMIT 1");
		if($recent_otp)
		{
			$this->Dashboard_model->mysqliq("UPDATE employee_monthly_sallary SET withdraw_status=1 WHERE employee_id='$employee_id' AND month='$get_month' AND year='$get_year'");

			$number = $employee->personal_Phone;
                    
			$random = rand(100000,999999);
			$message_body = "{$employee->full_name} your {$month_name} {$get_year}'s salary is successfully received. NICL.";

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
			$data['days'] = $days;
			$data['time'] = $time;
			$data['data'] = date('d/m/Y');
			$data['ampm'] = $ampm;
			$this->Dashboard_model->insert('sms_logs', $data);
		}
		else
		{
			echo "invalid_otp";
		}
	}

	public function send_noty_emp()
	{  
		date_default_timezone_set("Asia/Dhaka");
		$month = $_POST['month'];
		$get_day_month = explode('-',$month);
		$get_month = $get_day_month[1];
		$get_year = $get_day_month[0];
		$date = date('d/m/Y');
		$time = date('h:i:s');
		$days = date('l', strtotime($date));
		$month_name = date('F', mktime(0, 0, 0, $get_month, 10));
		
		$ampm = date('a'); 
		
		// $employees = $this->Dashboard_model->mysqlii("SELECT employee.id, employee.employee_id, employee.full_name, employee.personal_Phone, employee_monthly_sallary.total_sallary, employee_monthly_sallary.month, employee_monthly_sallary.year  FROM employee INNER JOIN employee_monthly_sallary ON employee.employee_id=employee_monthly_sallary.employee_id  WHERE employee.employee_id IN(71905,71758,71919, 71944) AND employee_monthly_sallary.month='$get_month' AND employee_monthly_sallary.year='$get_year'");
		if($_POST['old_new'] == 'old')
		{
			$employees = $this->Dashboard_model->mysqlii("SELECT employee.id, employee.employee_id, employee.full_name, employee.personal_Phone, employee_monthly_sallary.total_sallary, employee_monthly_sallary.month, employee_monthly_sallary.year, employee_sallary_generate_logs.employee_type
			FROM ((employee
			INNER JOIN employee_monthly_sallary ON employee.employee_id = employee_monthly_sallary.employee_id)
			INNER JOIN employee_sallary_generate_logs ON employee_monthly_sallary.unique_id = employee_sallary_generate_logs.unique_id) WHERE employee.employee_id IN(SELECT employee_id FROM employee_monthly_sallary) AND employee_monthly_sallary.month='$get_month' AND employee_monthly_sallary.year='$get_year' AND employee_sallary_generate_logs.employee_type='Rest Of Employee'");
		}
		else
		{
			$employees = $this->Dashboard_model->mysqlii("SELECT employee.id, employee.employee_id, employee.full_name, employee.personal_Phone, employee_monthly_sallary.total_sallary, employee_monthly_sallary.month, employee_monthly_sallary.year, employee_sallary_generate_logs.employee_type
			FROM ((employee
			INNER JOIN employee_monthly_sallary ON employee.employee_id = employee_monthly_sallary.employee_id)
			INNER JOIN employee_sallary_generate_logs ON employee_monthly_sallary.unique_id = employee_sallary_generate_logs.unique_id) WHERE employee.employee_id IN(SELECT employee_id FROM employee_monthly_sallary) AND employee_monthly_sallary.month='$get_month' AND employee_monthly_sallary.year='$get_year' AND employee_sallary_generate_logs.employee_type='New Joining'");
		}
		
		$numbers = array();
		foreach($employees as $employee)
		{   
			   
			$number = $employee->personal_Phone;
                    
			$random = rand(100000,999999);
			$message_body = "Dear, {$employee->full_name} your salary confirmation otp is {$random} and your {$month_name} {$get_year}'s salary is: {$employee->total_sallary} BDT. NICL.";

			$phnP_n = strlen($number);		
			if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
			
			$apikey = '1bncPj2IVFre8sK6hY//i4lt9y2sDLlSs67TnGz5lMY='; 
			$device = '22|0';//'19|0';
			$ClientId = "aa34ccfa-5327-4aa8-aeb7-27d54ca2956c";
			$SenderId = '8809638666333';
			$api_params = '?ApiKey='.$apikey.'&ClientId='.$ClientId.'&SenderId='.$SenderId.'&Message='.urlencode($message_body).'&MobileNumbers=880'.$number.'&Is_Unicode='.true; 
			
			$smsGatewayUrl = "https://sms.novocom-bd.com/api/v2/SendSMS"; 
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
			
		}
		     $form = array();
			$form['month'] = $get_month;
			$form['year'] = $get_year;
			$this->Dashboard_model->insert('generate_forms', $form);
	    alert('success','Successfully Notification has been sent to all employee');
	    redirect(base_url('admin/accounting/transaction/employee-salary'));
	}
}

	
	
	
	




























































	