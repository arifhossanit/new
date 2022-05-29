<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['role_id'])){ 
$role = mysqli_fetch_assoc($mysqli->query("select * from roles where id = '".$_POST['role_id']."'"));
$check_permission_table = mysqli_fetch_assoc($mysqli->query("select * from role_peermission where role_id = '".$role['role_id']."'"));

if(!empty($check_permission_table['role_id'])){
	
}else{
	
	$sql_role_insert_with_comma = '';
	$sql_role_insert = "insert into role_peermission values(
		'',
		'".$role['role_id']."',
	";
	$j = 1;
	$sql_field = $mysqli->query("SELECT COLUMN_NAME as feild FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'role_peermission' ORDER BY ORDINAL_POSITION");
	while($row_field = mysqli_fetch_assoc($sql_field)){
		if($row_field['feild'] != 'id' AND $row_field['feild'] != 'role_id'){
			$sql_role_insert_with_comma .= "'0',";
			echo $j++.' - '.$row_field['feild'].'<br />';
		}
		
	}	
	$sql_role_insert .= rtrim($sql_role_insert_with_comma,',');
	$sql_role_insert .= ")";
	$mysqli->query($sql_role_insert);

}


$check_branch_permission = mysqli_fetch_assoc($mysqli->query("select * from branch_permission where role_id = '".$role['role_id']."'"));
if(!empty($check_branch_permission['role_id'])){
	
}else{
	$insert_field_variable = '';
	$insert_branch_query_data = '';
	$insert_branch_query = "insert into branch_permission values(
		'',
		'".$role['role_id']."',
	";
	$bql = $mysqli->query("select * from branches");
	while($rowq = mysqli_fetch_assoc($bql)){
		$insert_field_variable .= "0,";
	}
	$insert_branch_query_data = rtrim($insert_field_variable,",");
	$insert_branch_query .= "
		'".$insert_branch_query_data."',
		'".date('d/m/Y')."'
	)";
	$mysqli->query($insert_branch_query);
}


?>
<input type="hidden" name="role_id_update" value="<?php echo $role['role_id']; ?>"/>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
<?php 
$sql = $mysqli->query("SELECT COLUMN_NAME as feild FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'role_peermission' ORDER BY ORDINAL_POSITION");
while($row = mysqli_fetch_assoc($sql)){
	if($row['feild'] != 'id' AND $row['feild'] != 'role_id'){
	$fild_name = mysqli_fetch_assoc($mysqli->query("select * from role_fields where field_code = '".$row['feild']."'"));
	$check_permission = mysqli_fetch_assoc($mysqli->query("select * from role_peermission where role_id = '".$role['role_id']."'"));
	if($check_permission[$row['feild']] == '1'){
		$data_checked = 'checked';
	}else{
		$data_checked = '';
	}
?>			
			<div class="col-sm-4">
				<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
					<input name="<?php echo $row['feild']; ?>" type="checkbox" class="custom-control-input" id="customSwitch_<?php echo $row['feild']; ?>" <?php echo $data_checked; ?>>
					<label class="custom-control-label" for="customSwitch_<?php echo $row['feild']; ?>"><?php echo $fild_name['field_name']; ?></label>
				</div>
			</div>
<?php } } ?>
		</div>
	</div>
	<div class="col-sm-12">
		<h4 style="text-decoration:underline;margin-top:30px;">
			Branch Permission
		</h4>
		<div class="row">
<?php
$i = 1;
$j = 0;
$brn = $mysqli->query("select * from branches");
while($br_row = mysqli_fetch_assoc($brn)){
	$bp_sql = mysqli_fetch_assoc($mysqli->query("select * from branch_permission where role_id = '".$role['role_id']."'"));
	if(!empty($bp_sql['permission'])){
		$permission = explode(',',$bp_sql['permission']);
		foreach(array_slice($permission,$j++,$i) as $rain){
		if($rain == $br_row['branch_id']){
			$b_per = 'checked';
		}else{
			$b_per = '';
		}
?>
			<div class="col-sm-4">
				<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
					<input name="<?php echo $br_row['branch_id']; ?>" type="checkbox" class="custom-control-input" id="customSwitch_<?php echo $br_row['branch_id']; ?>" <?php echo $b_per; ?>>
					<label class="custom-control-label" for="customSwitch_<?php echo $br_row['branch_id']; ?>"><?php echo $br_row['branch_name']; ?></label>
				</div>
			</div>
<?php } } } ?>		
		</div>
	</div>
</div>	
<?php }
if(isset($_POST['value_set_permission'])){
	$sql_role_update_with_comma = '';
	$sql_role_update = "update role_peermission set";
	$sql_field = $mysqli->query("SELECT COLUMN_NAME as feild FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'role_peermission' ORDER BY ORDINAL_POSITION");
	while($row_field = mysqli_fetch_assoc($sql_field)){
		if($row_field['feild'] != 'id' AND $row_field['feild'] != 'role_id'){
			if(isset($_POST[$row_field['feild']])){
				$sql_role_update_with_comma .= " ".$row_field['feild']." = '1',";
			}else{
				$sql_role_update_with_comma .= " ".$row_field['feild']." = '0',";
			}			
		}
	}
	$sql_role_update .= rtrim($sql_role_update_with_comma,',');
	$sql_role_update .= " where role_id = '".$_POST['role_id_update']."'";
	
	$brnc_id_val = '';
	$brnc_id_val_com = '';
	$sql_brnc = $mysqli->query("select * from branches");
	while($uffw = mysqli_fetch_assoc($sql_brnc)){
		$b_id = $uffw['branch_id'];
		if(isset($_POST[$b_id])){
			$brnc_id_val_com .= $uffw['branch_id'].",";
		}else{
			$brnc_id_val_com .= "0,";
		}
	}
	$brnc_id_val .= rtrim($brnc_id_val_com,',');	
	$update_b_p = 'update branch_permission set
		permission = "'.$brnc_id_val.'",
		data = "'.date('d/m/Y').'"
		where role_id = "'.$_POST['role_id_update'].'"
	';
	
	if(
		$mysqli->query($sql_role_update)
		AND
		$mysqli->query($update_b_p)
	){
		echo '<span style="color:green;font-weight:bolder;">Permision Update Successfully!</span>';
	}else{
		echo '<span style="color:red;font-weight:bolder;">Something Wrong! Please try again</span>';
	}
}
?>