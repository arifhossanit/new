<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
    }
	
	function login($username,$password) {
		$condition = array('email' => $username,'password' => md5($password));
		$this->db->select('*');
		$this->db->from('super_admin');
		$this->db->where($condition);
		$row = $this->db->get();
		if(!empty($row->row()->id)){
			return $row->row()->email;
		}else{
			return false;
		}
	}
	
	function chaeck_data($table,$field_name,$field_data,$branch_id){
		$condition = array('branch_id' => $branch_id,$field_name => $field_data);
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($condition);
		$row = $this->db->get();
		if(!empty($row->row()->id)){
			return true;
		}else{
			return false;
		}
	}
	
	function chaeck_data_b($table,$field_name,$field_data){
		$condition = array($field_name => $field_data);
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($condition);
		$row = $this->db->get();
		if(!empty($row->row()->id)){
			return true;
		}else{
			return false;
		}
	}
	
	function insert($table, $data){
		if($this->db->insert($table,$data)){
			return true;
		}else{
			return false;
		}
	}
	
	function json_query($data){
		if($this->db->query($data)){
			return true;
		}else{
			return false;
		}
	}
	
	function insert_batch($table, $data){
		if($this->db->insert_batch($table,$data)){
			return true;
		}else{
			return false;
		}
	}
	
	function select($table, $condition, $short_by, $sort, $type,$limit = ''){
		$this->db->select("*");
		$this->db->from($table);
		if(!empty($condition)){
			$this->db->where($condition);
		}
		if(!empty($short_by) AND !empty($sort)){
			$this->db->order_by($short_by,$sort);
		}
		if(!empty($limit)){
			$this->db->limit($limit);
		}
		$row = $this->db->get();
		if($type == 'row'){
			return $row->row();
		}else{
			return $row->result();
		}
	}
	
	function select_field($table,$field, $condition, $short_by, $sort, $type,$limit = ''){
		$this->db->select($field);
		$this->db->from($table);
		if(!empty($condition)){
			$this->db->where($condition);
		}
		if(!empty($short_by) AND !empty($sort)){
			$this->db->order_by($short_by,$sort);
		}
		if(!empty($limit)){
			$this->db->limit($limit);
		}
		$row = $this->db->get();
		if($type == 'row'){
			return $row->row();
		}else{
			return $row->result();
		}
	}
	function table_list(){
		return $this->db->list_tables();
	}
	function update($table, $data,$id){
		if($this->db->update($table, $data, array('id' => $id))){
			return true;
		}else{
			return false;
		}
	}
	function update_json($table, $data, $id, $value){
		if($this->db->update($table, $data, array($id => $value))){
			return true;
		}else{
			return false;
		}
	}
	function delete($table,$id){
		if($this->db->delete($table, array('id' => $id))){
			return true;
		}else{
			return false;
		}
	}
	
	function delete_batch($table,$id){
		$this->db->where_in('id', $id);
		if($this->db->delete($table)){
			return true;
		}else{
			return false;
		}
	}	

    public function get_count($table) {
        return $this->db->count_all($table);
    }
	
	public function con_count($table,$where) {
		$query = $this->db->query('SELECT id FROM '.$table.' where '.$where.' order by id desc');
        return $query->num_rows();
    }
	
	public function mysqlii($query){
		$query = $this->db->query($query);
        return $query->result();
	}
	public function mysqlij($query){
		$query = $this->db->query($query);
        return $query->row();
	}
	public function mysqliq($query){
		if($this->db->query($query)){
			return true;
		}else{
			return true;
		}
	}

    public function get_limit($table,$limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($table);
        return $query->result();
    }
	
	public function permission($role,$field) {
		if($role == '2805597208697462328'){
			return '1';
		}else{
			$condition = array(
				'role_id' => $role,
				$field => 1
			);
			$this->db->select("*");
			$this->db->from('role_peermission');
			$this->db->where($condition);
			$row = $this->db->get();
			if(!empty($row->row()->$field) AND $row->row()->$field == '1'){
				return '1';
			}else{
				return '0';
			}
		}		
    }
	
	public function mysqli(){
		$host = 'localhost';
		$user = 'root';
		$pass = '';
		$db = 'super_hostel';
		return new mysqli($host,$user,$pass,$db);
	}
	public function select_join($select, $table, $join_table, $join_on, $join_type = '', $condition = '', $column = '', $sort = '') {
        $this->db->select($select);
		$this->db->from($table);
		$this->db->join($join_table, $join_on, $join_type);
		if(!empty($condition)){
			$this->db->where($condition);
		}
		$this->db->order_by($column ,$sort);
		$query = $this->db->get();
        return $query->result();
    }

	public function notificaiton_insert($table, $data)
	{
		$notification_database = $this->load->database('notification', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		if($notification_database->insert($table,$data)){
			return true;
		}else{
			return false;
		}
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
		return $response;
	}

	/**
	 * @param String $file_name Requet File Object
	 * @param String $dir Path of the file from uploads directory
	 * 
	 * @return String FilePath to be Saved
	 */
	public function store($file_name, $dir) {
        $filename 		= $_FILES[$file_name]["name"];
		$file_tmp 		= $_FILES[$file_name]["tmp_name"];
		$file_ext 		= substr($filename, strripos($filename, '.'));
		$newfilename 	= md5($filename).'_FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
		$newfile 		= 'assets/uploads/'.$dir.'/' . $newfilename;	
		move_uploaded_file($file_tmp,$newfile);
        return $newfile;
    }
}















