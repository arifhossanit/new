<?php
$idx = explode('_',$_POST['last_idx']);
$last_idx = intval($idx[1]) + 1;
$html = '<tr id="family_'.$last_idx.'">
            <input type="hidden" name="relation_id[]" value="new">
            <td><button type="button" class="btn btn-xs btn-danger" value="'.$last_idx.'" onclick="removeFamily(this.value)"><i class="fas fa-times"></i></button></td>
            <td>
                <select name="relation[]" class="form-control select2">
                    <option value="">Select</option>
                    <option value="Father">Father</option>
                    <option value="Mother">Mother</option>
                    <option value="Brother">Brother</option>
                    <option value="Sister">Sister</option>
                    <option value="Cousin">Cousin</option>
                    <option value="Friends">Friends</option>
                    <option value="Husband">Husband</option>
                    <option value="Wife">Wife</option>
                    <option value="Uncle">Uncle</option>
                    <option value="Aunti">Aunti</option>
                    <option value="Daughter">Daughter</option>
                    <option value="Son">Son</option>
                    <option value="Other">Other</option>
                </select>
            </td>
            <td>
                <input name="name[]" placeholder="Name" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <input name="occupation[]" placeholder="Occupation" type="text" class="form-control" />										
            </td>
            <td>
                <input name="contact_number[]" placeholder="Contact Number" type="text" class="form-control datepicker date-only-year" autocomplete="off">
            </td>
            <td>
                <input name="contact_address[]" placeholder="Contact Address" type="text" class="form-control" autocomplete="off">
            </td>
        </tr>';
echo $html;