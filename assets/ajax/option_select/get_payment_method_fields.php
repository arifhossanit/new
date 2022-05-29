<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(!empty($_GET['payment_method_id'])){
	$payment_method_id = $_GET['payment_method_id'];	
	$get_extra_charge = mysqli_fetch_object($mysqli->query("select t_c from payment_method where id = '".$payment_method_id."'"));
	$extra_charge_field = ($get_extra_charge->t_c > 0 ? $get_extra_charge->t_c : 0 );
	echo '<input type="hidden" name="payment_extra_charge[]" class="payment_extra_charge" value="'.$extra_charge_field.'"/>';	
	$sql = $mysqli->query("select * from payment_custom_fields where payment_method_id = '".$payment_method_id."'");
	while( $row = mysqli_fetch_object($sql) ){
		$field = mysqli_fetch_object($mysqli->query("select * from payment_method_fields where id = '".$row->field_id."'"));
		$required = ($field->is_required == 1 ? 'required' : '');
		$readonly = ($field->is_readonly == 1 ? 'readonly' : '');		
		$html = '			
			<div class="col-sm-'.$field->row_width.'">
				<div class="form-group m-0">
					<label class="m-0">'.$field->field_name.'</label>
		';
		if($field->field_type == 'text' OR $field->field_type == 'number' OR $field->field_type == 'date'){
			$field_type = ( $field->field_type == 'number' ? 'text' : $field->field_type);
			$field_type_class = ( $field->field_type == 'number' ? 'number_int' : $field->field_type . '_int');
			$html .= '<input type="'.$field_type.'" name="field_' . $field->id . '" class="'.$field_type_class.' form-control" placeholder="'.$field->field_name.'" '.$required.' '.$readonly.'/>';
		} else if($field->field_type == 'textarea'){
			$html .= '<textarea name="field_' . $field->id . '" class="form-control" placeholder="'.$field->field_name.'" '.$required.' '.$readonly.'></textarea>';
		} else if($field->field_type == 'dropdown'){
			$option_sql = $mysqli->query("select * from payment_field_option where field_id = '".$field->id."'");
			$option_data = '<option value="">select</option>';
			while($oow = mysqli_fetch_object($option_sql)){
				$option_data .= '<option value="'.$oow->id.'">'.$oow->option_name.'</option>';
			}
			$html .= '
				<select name="field_' . $field->id . '" class="form-control">
					'.$option_data.'
				</select>
			';
		} else if($field->field_type == 'dropdown_multi'){
			$option_sql = $mysqli->query("select * from payment_field_option where field_id = '".$field->id."'");
			$option_data = '<option value="">select</option>';
			while($oow = mysqli_fetch_object($option_sql)){
				$option_data .= '<option value="'.$oow->id.'">'.$oow->option_name.'</option>';
			}
			$html .= '
				<select name="field_' . $field->id . '" class="form-control" multiple>
					'.$option_data.'
				</select>
			';
		}
		$html .= '
				</div>
			</div>
		';
		echo $html;
	}
}
?>