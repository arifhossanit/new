<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Service_review extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		
		
	}
	// and new function.
    public function complain_category(){
        $data = array();
		
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			 if(isset($_POST['save'])){
				$this->form_validation->set_rules('department_id','department','required');
				$this->form_validation->set_rules('category_name','category','trim|required');
				if($this->form_validation->run() == FALSE){
					
				}else{
					if(isset($_POST['status'])){
						$status = 1;
					}else{
						$status = 0;
					}
					$data = array(
						'department_id' => $this->input->post('department_id'),
						'name' => $this->input->post('category_name'),
						'status' => $status
					);
					
					$insert = $this->db->insert('complain_category', $data);
					if($insert){
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
				if(isset($_POST['status'])){
					$status = 1;
				}else{
					$status = 0;
				}
				$data = array(
					'department_id' => $this->input->post('department_id'),
					'name' => $this->input->post('category_name'),
					'status' => $status
				);
				$update = $this->db->where('id', $update_id)->update('complain_category', $data);
				if($update){
					alert('success','Save Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }
			
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
			 }
			
			if(isset($_POST['edit'])){
				$id = $this->input->post('id');
			 	$data['edit'] = $this->db->query("SELECT * from complain_category where id='$id'")->row();
			 }
			
			 $complain_category_list = $this->db->query("SELECT complain_category.id, complain_category.department_id, complain_category.name, complain_category.status, department.department_name
			 from complain_category
			 left join department on complain_category.department_id=department.department_id
			 ");
			 $data['complain_category_list'] = $complain_category_list->result();
			 
			
			$sql = $this->db->query("select * from department");
			$data['result'] = $sql->result();
		
			$data['title_info'] = 'investor_facilities_setup'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/service_review/complain_category',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
    }
	
	public function complain_list_without_action(){
		$data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			$sql = $this->db->query("select * from complain_category");
			$data['result'] = $sql->result();
			
			$data['title_info'] = 'Complain List'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/service_review/complain_list_without_action',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
	}
	
	public function complain_list(){
        $data = array();
		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
			 if(isset($_POST['save'])){
				$target_dir = './assets/uploads/complain/';
				$file_name_to_store = '';
				$cpt = count($_FILES['complain_images']['name']);
				for($i=0; $i<$cpt; $i++)
				{   
					
					$target_file = basename($_FILES["complain_images"]["name"][$i]);
					$file_name_to_store .= basename($_FILES["complain_images"]["name"][$i]).',';
					$rtrim_name = rtrim($file_name_to_store, ',');
					move_uploaded_file($_FILES["complain_images"]["tmp_name"][$i], $target_file);
					
				}
				
				$data = array(
					'category_id' => $this->input->post('category_id'),
					'complain_images' => $rtrim_name,
					'note' => $this->input->post('note'),
					'status' => 1, 
					'created_at' => time()
				);
				
				
				$insert = $this->db->insert('complain', $data);
				if($insert){
					alert('success','Save Successfully!');
					redirect(current_url());
				}else{
					alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}
			} 
			if(isset($_POST['update'])){
				$update_id = $this->input->post('update_id');
				
				$data = array(
					'category_id' => $this->input->post('category_id'),
					'note' => $this->input->post('note')
					//'status' => $status
				);
				
				$update = $this->db->where('id', $update_id)->update('complain', $data);
				if($update){
					alert('success','Save Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }
			
			if(isset($_POST['delete_id'])){
				$delete_id = $this->input->post('delete_id');
				
				$delete = $this->db->where('id', $delete_id)->delete('complain');
				if($delete){
					alert('success','Deleted Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			}
			
			if(isset($_POST['ongoing_id'])){
				$ongoing_id = $this->input->post('ongoing_id');
				$data = array(
					'status' => 2,
					'ongoing_from' => time()
				);
				$ongoing = $this->db->where('id', $ongoing_id)->update('complain', $data);
				if($ongoing){
					alert('success','Updated Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }
			 
			if(isset($_POST['fixed_id'])){
				$fixed_id = $this->input->post('fixed_id');
				$data = array(
					'status' => 0,
					'finished_at' => time()
				);
				$ongoing = $this->db->where('id', $fixed_id)->update('complain', $data);
				if($ongoing){
					alert('success','Updated Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }
			 
			 if(isset($_POST['return_fixed_id'])){
				$return_fixed_id = $this->input->post('return_fixed_id');
				$data = array(
					'status' => 2
				);
				$ongoing = $this->db->where('id', $return_fixed_id)->update('complain', $data);
				if($ongoing){
					alert('success','Updated Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }
			 
			 if(isset($_POST['return_pending_id'])){
				$return_pending_id = $this->input->post('return_pending_id');
				$data = array(
					'status' => 1
				);
				$ongoing = $this->db->where('id', $return_pending_id)->update('complain', $data);
				if($ongoing){
					alert('success','Updated Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }
			
			if(isset($_POST['edit'])){
				$id = $this->input->post('id');
				
			 	$data['edit'] = $this->db->query("SELECT complain.id, complain.category_id, complain.note, complain.status   from complain 
				left join complain_category on complain_category.id=complain.category_id
				where complain.id='$id'")->row();
			 }
			
			
			
			$sql = $this->db->query("select * from complain_category");
			$data['result'] = $sql->result();
			
			$data['title_info'] = 'Complain List'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/service_review/complain_list',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
    }
	
	public function check_member($card_phone=null){
		
		if($_POST){
			$card_or_phone = $this->input->post('card_phone');
			$sql = $this->db->query("select * from member_directory where phone_number='$card_or_phone' or card_number='$card_or_phone' and status='1'");
			$num_rows = $sql->num_rows();
			if($num_rows > 0){
				return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array(
					'result' => true
					))); 
				
			}else{
				return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array(
					'result' => false
					)));  
			}
			
		}
		
		
	}
	
	public function complain_submit(){
		$sql = $this->db->query("select * from complain_category");
		$data['result'] = $sql->result();
		$this->session->unset_userdata('error');
		if(isset($_POST['submit'])){
			 $this->form_validation->set_rules('card_phone','Card Or Phone Number Is Required.','numeric|required');
			 $this->form_validation->set_rules('category[]','category','trim|required');
			 $this->form_validation->set_rules('note[]','note','trim|required');
			$complain_number = count($this->input->post('category'));
			
			if($this->form_validation->run() === false){
				// codeigniter handles error.
				//$data['error'] = validation_errors();
			}else{
				$card_or_phone = $this->input->post('card_phone');
				$sql = $this->db->query("select * from member_directory where phone_number='$card_or_phone' or card_number='$card_or_phone' and status='1'");
				$num_rows = $sql->num_rows();
				
				if($num_rows < 1){
					
					$data["error"] ="Invalid Card or Phone number.";
					
				}else{
					for($j=0; $j < $complain_number; $j++){
						$target_dir = './assets/uploads/complain/';
						$file_name_to_store = '';
						$cpt = count($_FILES["complain_images_$j"]['name']);
						
						for($i=0; $i<$cpt; $i++)
						{   
							
							$target_file = $target_dir.basename($_FILES["complain_images_$j"]["name"][$i]);
							$file_name_to_store .= basename($_FILES["complain_images_$j"]["name"][$i]).',';
							$rtrim_name = rtrim($file_name_to_store, ',');
							move_uploaded_file($_FILES["complain_images_$j"]["tmp_name"][$i], $target_file);
							
						}
						
						$data = array(
							'category_id' => $this->input->post('category')[$j],
							'complain_images' => $rtrim_name,
							'note' => $this->input->post('note')[$j],
							'status' => 1, 
							'card_phone' => $this->input->post('card_phone'), 
							'created_at' => time()
						);
						
						
						$insert = $this->db->insert('complain', $data);
					}
					if($insert){
						$data["success"] ="Successfully submited !";
					}else{
						$data["error"] ="Something went wrong !";
						//$this->load->view('template/service_review/complain_submit',$data);
					}
				}
				
			}
		}
		$this->load->view('template/service_review/complain_submit',$data);
	}
	
	public function get_start_time()
	{
		if($_POST){
			$row_id = $this->input->post('row_id');
			$sql = $this->db->query("select * from complain where id='$row_id'");
			$start_time = $sql->row();
			
			return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode(array(
                    'created_at' => $start_time->created_at,
                    'ongoing_from' => $start_time->ongoing_from,
                    'row_id' => $row_id
            )));
		}
		
	}
	
	public function complain_details()
	{
		if($_POST){
			$row_id = $this->input->post('row_id');
			$sql = $this->db->query("select * from complain where id='$row_id'");
			$start_time = $sql->row();
			$data['file_names'] = explode(",", $start_time->complain_images);
			$images = $this->load->view('template/service_review/complain_images', $data, true);
			//echo $images;
			
			return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output($images);
		}
		
	}
	
	public function contacts_download(){
		//echo 'Downloading all contacts'; exit();
		$sql = $this->db->query("select * from member_contact_information");
		$results = $sql->result();
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Serial');
		$sheet->setCellValue('B1', 'Employee ID');
		$sheet->setCellValue('C1', 'Contact Name');
		$sheet->setCellValue('D1', 'Email');
		$sheet->setCellValue('E1', 'PHONE NUMBER');
		
		$row = 2;
		foreach($results as $result){
			$sheet->setCellValue("A$row", $row-1);
			$sheet->setCellValue("B$row", $result->member_id);
			$sheet->setCellValue("C$row", $result->name);
			$sheet->setCellValue("D$row", $result->email);
			$sheet->setCellValueExplicit("E$row", $result->phone, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
			$sheet->setCellValue("F$row", $result->email);
			
			$row++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Contacts';
 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		 
		$writer->save('php://output');
	}
	

}