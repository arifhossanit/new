<?php
$idx = explode('_',$_POST['last_idx']);
$last_idx = intval($idx[1]) + 1;
$html = '<tr id="training_'.$last_idx.'">
            <input type="hidden" name="training_id[]" value="new">
            <td><button type="button" class="btn btn-xs btn-danger" value="'.$last_idx.'" onclick="removeTraining(this.value)"><i class="fas fa-times"></i></button></td>
            <td>
                <input name="training_name[]" placeholder="Name of the Training" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <input name="training_institution[]" placeholder="Institution" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <input name="place[]" placeholder="Place" type="text" class="form-control" />										
            </td>
            <td>
                <input name="completion_year[]" placeholder="Completion Year" type="text" class="form-control datepicker date-only-year" autocomplete="off">
            </td>
            <td>
                <input name="duration[]" placeholder="Duration" type="text" class="form-control" autocomplete="off">
            </td>
        </tr>';
echo $html;