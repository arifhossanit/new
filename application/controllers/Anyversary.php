<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Anyversary extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url');
	}
	
	public function anyversary_report(){
		/* This code originally written to generate pdf file. 
		$sql = $this->db->query("select check_in_date 
		from member_directory 
		WHERE status='1' ");
		$data['result'] = $sql->result();
		
		$html = $this->load->view("template/anyversary/member_anyversary", $data, TRUE);
		$dompdf = new Pdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$output = $dompdf->stream(); */
		
		$sql = $this->db->query("select 
		MEMBER_DIRECTORY.ID,
		MEMBER_ANYVERSARY.ANYVERSARY_DATE, MEMBER_ANYVERSARY.ANYVERSARY_TYPE, MEMBER_DIRECTORY.ID,
		MEMBER_DIRECTORY.BRANCH_NAME, MEMBER_DIRECTORY.PHONE_NUMBER, MEMBER_DIRECTORY.FULL_NAME,
		MEMBER_DIRECTORY.CHECK_IN_DATE
		from MEMBER_ANYVERSARY
		INNER JOIN MEMBER_DIRECTORY ON MEMBER_DIRECTORY.ID = MEMBER_ANYVERSARY.MEMBER_ID
		group by MEMBER_ANYVERSARY.ANYVERSARY_DATE
		order by MEMBER_ANYVERSARY.ANYVERSARY_DATE desc
		");
		
		$data['results'] = $sql->result();
		$data['title_info'] = "Member Anniversaries!";
		$data['header'] = $this->load->view('include/header', '', TRUE);
		$data['nav'] = $this->load->view('include/nav', '', TRUE);
		$data['article'] = $this->load->view("template/anyversary/member_anyversary", $data, TRUE);
		$data['footer'] = $this->load->view('include/footer', '', TRUE);
		$this->load->view('dashboard', $data);
		
		
	}
	
	
	public function anyversary_date_wise_report(){
		if($_POST){
			$anniversary_date = $this->input->post("anniversary_date");
			$sql = $this->db->query("select 
				MEMBER_ANYVERSARY.ANYVERSARY_DATE, MEMBER_ANYVERSARY.ANYVERSARY_TYPE, MEMBER_DIRECTORY.ID,
				MEMBER_DIRECTORY.BRANCH_NAME, MEMBER_DIRECTORY.PHONE_NUMBER, MEMBER_DIRECTORY.FULL_NAME,
				MEMBER_DIRECTORY.CHECK_IN_DATE, MEMBER_DIRECTORY.FLOOR_NAME, MEMBER_DIRECTORY.ROOM_NAME, 
				MEMBER_DIRECTORY.BED_NAME
				from MEMBER_ANYVERSARY
				INNER JOIN MEMBER_DIRECTORY ON MEMBER_DIRECTORY.ID = MEMBER_ANYVERSARY.MEMBER_ID
				where MEMBER_ANYVERSARY.ANYVERSARY_DATE = '$anniversary_date'
			");
			
			$data['results'] = $sql->result();
			$html = $this->load->view("template/anyversary/anyversary_date_wise_report", $data, true);
			
			echo $html;
		}
		
	}
	
	public function anniversary_member_profile(){
		if($_POST){
			$member_id = $this->input->post("member_id");
			$data['member_id'] = $member_id;
			$html = $this->load->view("template/anyversary/anniversary_member_profile", $data, true);
			
			echo $html;
		}
		
	}
	
	public function anniversary_date_range(){
		if($_POST){
			$date_range = $this->input->post("date_range");
			$dates = explode("-", $date_range);
			$date1 = trim($dates[0]);
			$date2 = trim($dates[1]);
			$date1_array = explode("/", $date1);
			$date2_array = explode("/", $date2);
			$formated_date1 = $date1_array[2]."-".$date1_array[1]."-".$date1_array[0];
			$formated_date2 = $date2_array[2]."-".$date2_array[1]."-".$date2_array[0];
			if(strtotime($formated_date1) < strtotime($formated_date2)){
				$later_date = $formated_date2;
				$earlier_date = $formated_date1;
			}else{
				$later_date = $formated_date1;
				$earlier_date = $formated_date2;
			}
			
			$sql = $this->db->query("select 
			member_directory.id,
			member_anyversary.anyversary_date, member_anyversary.anyversary_type,
			member_directory.branch_name, member_directory.phone_number, member_directory.full_name,
			member_directory.check_in_date
			from member_anyversary
			inner join member_directory on member_directory.id = member_anyversary.member_id
			
			where member_directory.status='1' and  
			date_format(STR_TO_DATE(member_anyversary.anyversary_date, '%d/%m/%Y'), '%Y-%m-%d') BETWEEN 
			'$earlier_date'
			 AND 
			 '$later_date'
			group by member_anyversary.anyversary_date
			order by member_anyversary.anyversary_date desc 
			
			");
			
			$results = $sql->result();
			echo json_encode($results);
		}
		
	}
	
	
}