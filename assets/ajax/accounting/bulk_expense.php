<?php
include("../../../application/config/ajax_config.php");
$expense_types = $mysqli->query("SELECT * from expense_type");
// <input type="text" data-type="productCode" name="item_name[]" id="itemNo_'.$_POST['i'].'" class="form-control autocomplete_txt" autocomplete="off" required />

$html = '<tr>';
$html .= '<td><input class="case" type="checkbox" style="transform: scale(1.3); margin-left: 8px; margin-top: 13px;"/></td>';
$html .= '<td><input type="date" class="form-control" name="" id=""></td>';

$html .= '<td>
        <select class="form-control select2" name="vendor[]" data-select2-id="3">
        <option>Select Expense</option>';
$scm_vendors = $mysqli->query("SELECT * from scm_vendor");
if($scm_vendors->num_rows != 0){
    while($scm_vendor = mysqli_fetch_assoc($scm_vendors)){
        $html .= '<option value="'.$scm_vendor['id'].'">'.$scm_vendor['company_name'].'</option>';
    }
}
$html .=    '</select>
    </td>';

$html .= '<td>
            <select class="form-control select2" name="expense_tpye[]" data-select2-id="3">
            <option>Select Expense</option>';
foreach($expense_types as $expense_type){
    $expense_sub_types = $mysqli->query("SELECT * from expense_sub_type where expense_type_id = ".$expense_type['id']);
    if($expense_sub_types->num_rows != 0){
        while($expense_sub_type = mysqli_fetch_assoc($expense_sub_types)){
            $html .= '<option value="'.$expense_type['id'].'|'.$expense_sub_type['id'].'">'.$expense_type['head_name'] . ' - '. $expense_sub_type['head_name'] .'</option>';
        }
    }else{
        $html .= '<option value="'.$expense_type['id'].'">'.$expense_type['head_name'].'</option>';
    }
}
$html .=    '</select>
         </td>';
         
$html .= '<td><input type="text" name="item_price[]" id="price_'.$_POST['i'].'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>';
$html .= '<td><input type="text" name="ite_qty[]" id="quantity_'.$_POST['i'].'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required /></td>';
$html .= '<td><input type="text" name="total_item_amount[]" id="total_'.$_POST['i'].'" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" style="color:green;font-weight:bolder;font-size: 18px;" readonly /></td>';
$html .= '<td><input type="text" name="total_item_amount[]" id="total_'.$_POST['i'].'" class="form-control totalLinePrice" autocomplete="off" style="color:green;font-weight:bolder;font-size: 18px;" /></td>';
$html .= '<td><input type="file" name="attachment[]" class="form-control" style="padding-top:3px;" required/></td>';
$html .= '<td>
        <select class="form-control select2" name="vendor[]" data-select2-id="3">
        <option>Select Expense</option>';
$branches = $mysqli->query("SELECT * from branches");
if($branches->num_rows != 0){
    while($branche = mysqli_fetch_assoc($branches)){
        $html .= '<option value="'.$branche['id'].'">'.$branche['branch_name'].'</option>';
    }
}
$html .=    '</select>
    </td>';
$html .= '</tr>';
echo $html;