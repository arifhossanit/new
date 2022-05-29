<?php 
include("../../../application/config/ajax_config.php");
function field_data(){
	global $mysqli;
	$fields = $mysqli->query("SELECT COLUMN_NAME as feild FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'role_peermission' ORDER BY ORDINAL_POSITION");
	$i = 1;
	$data = '';
	while($row = mysqli_fetch_assoc($fields)){
		if($row['feild'] != 'id' AND $row['feild'] != 'role_id'){
			$name = mysqli_fetch_assoc($mysqli->query("select * from role_fields where field_code = '".$row['feild']."'"));
			$id = "'".$row['feild']."'";
			$data .= '
				<tr>
					<td>'.$i++.'</td>
					<td>'.$name['field_name'].'</td>
					<td>'.$row['feild'].'</td>
					<td>'.$name['data'].'</td>
					<td>
						<button onclick="return delete_items_field('.$id.')" type="button" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
					</td>
				</tr>
			';
		}
	}
	return $data;
}
if(isset($_POST['form_submit'])){
	if($_POST['form_submit'] == '1'){
		foreach($_POST['field_name'] as $row){			
			$n_check = mysqli_fetch_assoc($mysqli->query("select * from role_fields where field_name = '".$row."'"));
			if(!empty($n_check['id'])){
				$table = '2';
			}else{
				$check = mysqli_fetch_array($mysqli->query(" SELECT * FROM information_schema.columns WHERE table_schema = '".$db."' AND column_name IN ( '".$row."' );  "));
				if(empty($check)){
					$code = 'role_'.time().'_'.rand(11,99);
					if($mysqli->query("ALTER TABLE role_peermission ADD ".$code." TINYINT(1) NOT NULL")){
						if($mysqli->query("insert into role_fields values(
							'',
							'".$row."',
							'".$code."',
							'".date('d/m/Y')."'
						)")){
							$table = '1';
						}else{
							$table = '3';
						}					
					}else{
						$table = '3';
					}
				}else{
					$table = '2';
				}
			}			
		}
		if($table == '1'){
			echo field_data();
		}else if($table == '2'){
			echo 'Field All ready exixt!';
		}else if($table == '3'){
			echo 'Something wrong! Please try again';
		}
	}else{
		echo field_data();
	}	
}
if(isset($_POST['field_name_delete'])){
	if($mysqli->query("ALTER TABLE role_peermission DROP ".$_POST['field_name_delete']."")){
		if($mysqli->query("delete from role_fields where field_code = '".$_POST['field_name_delete']."'")){
			echo field_data();
		}		
	}	
}


?>
































