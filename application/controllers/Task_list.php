<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task_list extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		
	}

    public function Task_list_control(){
        $data = array();
		$department = $_SESSION['user_info']['department'];
		date_default_timezone_set('Asia/Dhaka');
        $date_time = date('Y-m-d h:i:s a', time());
		$id_emp = $_SESSION['super_admin']['employee_ids'];

		$player=$this->db->query("SELECT player_id FROM employee WHERE department ='$department'");
		$player=$player->result();
		$player_ids=[];
		foreach ($player as $value) {
			$player_ids[]=$value->player_id;
		}

		if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else
		{
			 if(isset($_POST['save'])){
				$this->form_validation->set_rules('title','title','trim|required');
				$this->form_validation->set_rules('description','description','trim|required');
                $config = array();
				$config['upload_path'] = './assets/uploads/task_list';
		        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['remove_spaces'] = TRUE;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $title = addslashes($this->input->post('title'));
                $description = addslashes($this->input->post('description'));
                $assigned_to = $this->input->post('employee_id') ? $this->input->post('employee_id') : '';
                $assigned_by = $_SESSION['super_admin']['employee_ids'];
				$rate = $this->input->post('rate');
				$deadline =  $this->input->post('deadline');
                $status = 0;
                $file_status =$this->upload->do_upload('image');
                $task_image = $this->upload->data('file_name');

				// assign person department id change whene data insert by top management
                if ($department==749568347163692080) {
					$data=$this->db->query("SELECT department FROM employee WHERE employee_id='$assigned_to'")->row();
					$department = $data->department;
				}

				if($this->form_validation->run() == FALSE){
                    alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}else{
                    if ($file_status) {
                        $insert = $this->db->query("INSERT into task_list (title,description,priority_rate,task_image,department_id,assigned_to,assigned_by,status,deadline_at,created_at) values ('$title','$description','$rate','$task_image','$department','$assigned_to','$assigned_by','$status','$deadline','$date_time')");
                        if($insert){
							// sending notification to mobile via api call
							if ($assigned_to !== '') {
								$xy=$this->Dashboard_model->onesignal('New Task Created in Your Department!', 'Task Notification', array("$assigned_to"));
							}else {
								$query=$this->Dashboard_model->mysqlij("SELECT player_id FROM employee WHERE department ='$department'");
								$xy=$this->Dashboard_model->onesignal('New Task Created in Your Department!', 'Task Notification', $player_ids);
							}
                            alert('success','Save Successfully!');
                            redirect(current_url());
                        }else{
                            alert('danger','Something Wrong! Please try Again');
                            redirect(current_url());
                        }
                    }elseif(!$file_status && !empty($task_image)) {
                        alert('danger','Something Wrong! Please try Again');
					    redirect(current_url());
                    }else {
                        $insert = $this->db->query("INSERT INTO task_list (title,description,priority_rate,department_id,assigned_to,assigned_by,status,deadline_at,created_at) VALUES ('$title','$description','$rate','$department','$assigned_to','$assigned_by','$status','$deadline','$date_time')");
                        if($insert){
							// sending notification to mobile via api call
							if ($assigned_to !== '') {
								$xy=$this->Dashboard_model->onesignal('New Task Created in Your Department!', 'Task Notification', array("$assigned_to"));
							}else {
								$query=$this->Dashboard_model->mysqlij("SELECT player_id FROM employee WHERE department ='$department'");
								$xy=$this->Dashboard_model->onesignal('New Task Created in Your Department!', 'Task Notification', $player_ids);
							}
						alert('success','Save Successfully!');
						redirect(current_url());
                        }else{
                            alert('danger','Something Wrong! Please try Again');
                            redirect(current_url());
                        }
                    }
					
				}
				
			} 

			if(isset($_POST['task_edit'])){
				$id = $this->input->post('task_edit');
				$sql = $this->db->query("SELECT employee_id,full_name FROM employee WHERE d_head=1 AND status=1");
				$data['result'] = $sql->result();

				$query = $this->db->query("SELECT employee_id,full_name,d_head FROM employee WHERE department=$department AND status=1");
				$data['emp_list'] = $query->result();

				$data['dep_head'] = $this->db->query("SELECT d_head FROM employee WHERE  employee_id='$id_emp'")->row();
			
			 	$data['edit'] = $this->db->query("SELECT * FROM task_list WHERE id='$id'")->row();
				$html = $this->load->view('template/tasks/edit_task',$data,TRUE);
				echo $html;
				exit;
			 }

			if(isset($_POST['update'])){
				$this->form_validation->set_rules('title','title','trim|required');
				$this->form_validation->set_rules('description','description','trim|required');
                $config = array();
				$config['upload_path'] = './assets/uploads/task_list';
		        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['remove_spaces'] = TRUE;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
				$update_id = $this->input->post('update_id');
                $title = addslashes($this->input->post('title'));
                $description = addslashes($this->input->post('description'));
                $assigned_to = $this->input->post('employee_id') ? $this->input->post('employee_id') : '';
                $assigned_by = $_SESSION['super_admin']['employee_ids'];
                $status = 0;
                $file_status =$this->upload->do_upload('image');
                $task_image = $this->upload->data('file_name');
                
				if($this->form_validation->run() == FALSE){
                    alert('danger','Something Wrong! Please try Again');
					redirect(current_url());
				}else{
                    if ($file_status) {
                        $update = $this->db->query("UPDATE task_list SET title='$title', description='$description',task_image='$task_image',assigned_to='$assigned_to' WHERE id='$update_id'");
                        if($update){
                            alert('success','Save Successfully!');
                            redirect(current_url());
                        }else{
                            alert('danger','Something Wrong! Please try Again');
                            redirect(current_url());
                        }
                    }elseif(!$file_status && !empty($task_image)) {
                        alert('danger','Something Wrong! Please try Again');
					    redirect(current_url());
                    }else {
                        $update = $this->db->query("UPDATE task_list SET title='$title', description='$description',assigned_to='$assigned_to' WHERE id='$update_id'");
                        if($update){
							alert('success','Update Successfully!');
							redirect(current_url());
                        }else{
							echo "edit5";
                            alert('danger','Something Wrong! Please try Again');
                            redirect(current_url());
                        }
                    }
					
				}
			 }
			
			 if (isset($_POST['task_accept_id'])) {
				$emp_id = $_SESSION['super_admin']['employee_ids'];
				$task_id=$_POST['task_accept_id'];
				$url =base_url('admin/s_it/tasks');
				$date=date('Y-m-d');
				 echo "<div class='text-center'>
				 		<form role='form' action='$url' method='POST'>
						 <input type='hidden' name='emp_id' value='$emp_id'/>
						 <input type='hidden' name='task_id' value='$task_id'/>
							<label for='start'>Select Task End date:</label>
							<br>
							<input type='date' id='start' name='task_end' min='$date' required>
							<input type='time' id='time' name='time' required>
							<br>
							<button type='submit' id='accept' name='accept_task' class='btn btn-warning mt-3'>Accept</button>
						</form>
					</div>";
				exit;
			 }

			if(isset($_POST['accept_task'])){
				$emp_id = $this->input->post('emp_id');
				$task_id = $this->input->post('task_id');
				$task_end = $this->input->post('task_end');
				$time = $this->input->post('time');
				$d=$time . $task_end;
				$d=strtotime($d);
				$target_at= date("Y-m-d h:i:sa", $d);
				$accept = $this->db->query("UPDATE task_list SET processing_by='$emp_id',accepted_at='$date_time', target_at='$target_at', status='1' WHERE id=$task_id");
				if($accept){
					alert('success','Acceptd Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }
			
			 if(isset($_POST['task_complete_id'])){
				$task_id = $this->input->post('task_complete_id');
				
				$task_info = $this->db->query("SELECT id,title,description,task_image,processing_by,created_at FROM task_list WHERE id=$task_id");
				$data['task_info'] = $task_info->row();

				$html = $this->load->view('template/tasks/task_complete',$data,TRUE);
				echo $html;
				exit;
			 }

			 if(isset($_POST['complete_task'])){
				$emp_id = $this->input->post('emp_id');
				$task_id = $this->input->post('task_id');
				$accept = $this->db->query("UPDATE task_list SET complete_by='$emp_id', status='2', completed_at='$date_time' WHERE id=$task_id");
				if($accept){
					alert('success','Acceptd Successfully!');
			 		redirect(current_url());
			 	}else{
			 		alert('danger','Something Wrong! Please try Again');
			 		redirect(current_url());
			 	}
			 }


			if ($department==749568347163692080) {
				// query for showing all task for top management
				$task_queue = $this->db->query("SELECT task_list.id,task_list.title,priority_rate,task_list.assigned_by,task_list.assigned_to,(SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_by ) AS emp_name_by, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_to ) AS emp_name_to, task_list.deadline_at FROM task_list WHERE task_list.status=0");
			 	$data['task_queue'] = $task_queue->result();

				 // query for showing department processing task for top management
				 $task_processing = $this->db->query("SELECT task_list.id,task_list.title,task_list.processing_by, task_list.target_at, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_by ) AS emp_name_by, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.processing_by ) AS emp_name_pro, task_list.deadline_at FROM task_list WHERE task_list.status=1");
			 	$data['task_processing'] = $task_processing->result();

				 
				 // query for showing department complete task for top management
				 $task_complete = $this->db->query("SELECT task_list.id,task_list.title, task_list.completed_at, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_by ) AS emp_name_by, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.complete_by ) AS emp_name_com, task_list.deadline_at FROM task_list WHERE task_list.status=2");
				 $data['task_complete'] = $task_complete->result();
			}else {
				// query for showing department wise queue task for top management
				 $task_queue = $this->db->query("SELECT task_list.id,task_list.title,priority_rate,task_list.assigned_by,task_list.assigned_to,(SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_by ) AS emp_name_by, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_to ) AS emp_name_to, task_list.deadline_at FROM task_list WHERE task_list.status=0 AND (task_list.department_id='$department' OR task_list.department_id='749568347163692080')");
			 	$data['task_queue'] = $task_queue->result();

				 // query for showing department processing task for top management
				 $task_processing = $this->db->query("SELECT task_list.id,task_list.title,task_list.processing_by, task_list.target_at, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_by ) AS emp_name_by, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.processing_by ) AS emp_name_pro, task_list.deadline_at FROM task_list WHERE task_list.status=1 AND (task_list.department_id='$department' OR task_list.department_id='749568347163692080') ORDER BY target_at ASC");
			 	$data['task_processing'] = $task_processing->result();

				 
				 // query for showing department complete task for top management
				 $task_complete = $this->db->query("SELECT task_list.id,task_list.title, task_list.completed_at, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_by ) AS emp_name_by, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.complete_by ) AS emp_name_com, task_list.deadline_at FROM task_list WHERE task_list.status=2 AND (task_list.department_id='$department' OR task_list.department_id='749568347163692080') ORDER BY completed_at DESC");
			 	$data['task_complete'] = $task_complete->result();
			}
				
			$sql = $this->db->query("SELECT employee_id,full_name FROM employee WHERE d_head=1 AND status=1");
			$data['result'] = $sql->result();

			$query = $this->db->query("SELECT employee_id,full_name,d_head FROM employee WHERE department=$department AND status=1");
			$data['emp_list'] = $query->result();

			$data['dep_head'] = $this->db->query("SELECT d_head FROM employee WHERE  employee_id='$id_emp'")->row();

			$data['title_info'] = 'TODO List'; 
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('template/tasks/task_list_page',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
    }

	public function Task_detail_control()
	{
		$task_id = $this->input->post("task_info");
		$task_info = $this->db->query("SELECT task_list.id,task_list.title,task_list.description,task_list.task_image,task_list.assigned_to,task_list.processing_by, task_list.status, task_list.created_at, task_list.accepted_at, task_list.completed_at,(SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_by ) AS emp_name_by, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.assigned_to ) AS emp_name_to, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.processing_by ) AS emp_name_pro, (SELECT employee.full_name FROM employee WHERE employee.employee_id=task_list.complete_by ) AS emp_name_com FROM task_list WHERE task_list.id=$task_id");
		$data['task_info'] = $task_info->row();

		$result=$this->db->query("SELECT task_comment.id, task_id, comment, created_at, full_name FROM task_comment, employee WHERE task_id='$task_id' AND task_comment.employee_id = employee.employee_id ORDER BY task_comment.id DESC LIMIT 3");
		$data['comment']= $result->result();

		$html = $this->load->view('template/tasks/task_detail_page',$data,TRUE);
		echo $html;
	}

	public function comment()
	{
		if(isset($_POST['comment']))
		{
			$task_id= $this->input->post('task_id');
			$emp_id= $_SESSION['super_admin']['employee_ids'];
			$comment= $this->input->post('comment');
			$insert= $this->db->query("INSERT INTO task_comment (task_id,employee_id,comment) VALUES ('$task_id','$emp_id','$comment')");

			if ($insert) {
				$result=$this->db->query("SELECT task_comment.id, task_id, comment, created_at, full_name FROM task_comment, employee WHERE task_id='$task_id' AND task_comment.employee_id = employee.employee_id ORDER BY task_comment.id DESC LIMIT 3");
				$comment= $result->row();
				$phpdate = strtotime( $comment->created_at );
				$mysqldate = date( 'd M Y, h:i A', $phpdate );
				echo "<div class='d-flex flex-row mt-3'>
						<h2 class='col-2 text-right'>
							<i class='far fa-user-circle pt-1 pr-2 text-info'></i>
						</h2>
						<div class=''>
							<h5>$comment->full_name <small class='text-muted' style='font-size:11px'>$mysqldate</small></h5>
							<p>$comment->comment</p>
						</div>
					</div>";
			}
		}

		if (!empty($_POST['count']) && !empty($_POST['task_id'])) {
			$count=$_POST['count'];
			$task_id=$_POST['task_id'];
			$row=$this->db->query("SELECT task_comment.id, task_id, comment, created_at, full_name FROM task_comment, employee WHERE task_id='$task_id' AND task_comment.employee_id = employee.employee_id ORDER BY task_comment.id DESC LIMIT 3,$count");
			$comment= $row->result();
			foreach ($comment as $data) {
			  $phpdate = strtotime( $data->created_at );
			  $mysqldate = date( 'd M Y, h:i A', $phpdate );
			echo "<div class='d-flex flex-row mt-3'>
					<h2 class='col-2 text-right'>
						<i class='far fa-user-circle pt-1 pr-2 text-info'></i>
					</h2>
					<div class=''>
						<h5>$data->full_name <small class='text-muted' style='font-size:11px'>$mysqldate</small></h5>
						<p>$data->comment</p>
					</div>
				</div>";
			}
		}
	}
}