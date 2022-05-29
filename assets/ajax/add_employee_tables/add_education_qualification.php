<?php
$idx = explode('_', $_POST['last_idx']);
$last_idx = intval($idx[1]) + 1;
$html = '<tr id="edu_'.$last_idx.'">
            <input type="hidden" name="education_id[]" value="new">
            <td><button type="button" class="btn btn-xs btn-danger" value="'.$last_idx.'" onclick="removeEducationColumn(this.value)"><i class="fas fa-times"></i></button></td>
            <td>
                <select name="qualification[]"  class="select2 form-control" style="width: 100%;">
                    <option value="">Level</option>';
                    if(!empty($adse->qualification)){
                        $QD = explode(',',$adse->qualification);
                        foreach($QD as $row){
                            $html .= '<option value="'.$row.'" selected>'.$row.'</option>';
                        }
                    }
$html .=           '<option value="PSC">PSC</option>
                    <option value="JSC">JSC</option>
                    <option value="SSC">SSC</option>
                    <option value="HSC">HSC</option>
                    <option value="Diploma">Diploma</option>
                    <option value="B.Sc">B.Sc</option>
                    <option value="M.Sc">M.Sc</option>
                    <option value="BBA">BBA</option>
                    <option value="MBA">MBA</option>
                    <option value="BA">BA</option>
                    <option value="BSS">BSS</option>
                    <option value="BBS">BBS</option>
                    <option value="Honours">Honours</option>
                    <option value="Masters">Masters</option>
                    <option value="PHD">PHD</option>
                    <option value="LLB">LLB</option>
                    <option value="LLM">LLM</option>
                    <option value="Other">Other</option>
                </select>
            </td>
            <td>
                <input class="form-control datepicker date-only-year" type="text" name="passing_year[]" placeholder="Passing Year" autocomplete="off"/>										
            </td>
            <td>
                <input name="institution[]" placeholder="Institution" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <select name="board[]" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Barishal">Barishal</option>
                    <option value="Mymensingh">Mymensingh</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Rangpur">Rangpur</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Cumilla">Cumilla</option>
                    <option value="Jessore">Jessore</option>
                </select>
            </td>
            <td>
                <input name="group[]" placeholder="Group" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <select name="class[]" class="select2 select2-hidden-accessible form-control" data-placeholder="Select Class/GPA" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
                    <option value="GPA out of 4">GPA out of 4</option>
                    <option value="GPA out of 5">GPA out of 5</option>
                    <option value="1st Division">1st Division</option>
                    <option value="2nd Division">2nd Division</option>
                    <option value="3rd Division">3rd Division</option>
                    <option value="First Class">First Class</option>
                    <option value="Second Class">Second Class</option>
                    <option value="Third Class">Third Class</option>
                </select>
            </td>
            <td>
                <input name="gpa[]" placeholder="CGPA" type="text" class="form-control" autocomplete="off">
            </td>
        </tr>';
echo $html;