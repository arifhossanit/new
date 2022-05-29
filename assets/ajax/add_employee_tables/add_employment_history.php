<?php
$idx = explode('_',$_POST['last_idx']);
$last_idx = intval($idx[1]) + 1;
$html = '<tr id="empHst_'.$last_idx.'">
            <input type="hidden" name="history_id[]" value="new">
            <td><button type="button" class="btn btn-xs btn-danger" value="'.$last_idx.'" onclick="removeEmploymentHistory(this.value)"><i class="fas fa-times"></i></button></td>
            <td>
                <input name="company_name[]" placeholder="Company Name" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <input name="designation_emp[]" placeholder="Designation" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <input name="department_emp[]" type="text" placeholder="Department" class="form-control" />										
            </td>
            <td>
                <input name="from[]" placeholder="From" type="text" class="form-control datepicker" autocomplete="off">
            </td>
            <td>
                <input name="to[]" placeholder="To" type="text" class="form-control datepicker" autocomplete="off">
            </td>
            <td>
                <input name="responsibility[]" placeholder="Core Responsibility" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <input name="leaving_reason[]" placeholder="Leave Reason" type="text" class="form-control" autocomplete="off">
            </td>
        </tr>';
echo $html;