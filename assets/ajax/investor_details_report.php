<?php
include("../../application/config/ajax_config.php");
$html = '<table class="table table-bordered" id="refreshment_table">
                <thead>
                    <tr>
                        <td>Tea/Coffee</td>
                        <td>Drinks</td>
                        <td>Date</td>
                        <td>Issued By</td>
                    </tr>
                </thead>
                <tbody>';
$refreshment_records = $mysqli->query("SELECT * from investor_facilities_setup_records where investor_facilities_setup_id = ".$_POST['id']);
$no_body = true;
while($refreshment_record = mysqli_fetch_assoc($refreshment_records)){
    $no_body = false;
    $html .=    '<tr>
                    <td>'.$refreshment_record['tea_coffee'].'</td>
                    <td>'.$refreshment_record['drinks'].'</td>
                    <td>'.$refreshment_record['date'].'</td>';
    $temp = explode('___',$refreshment_record['uploader_info']);
    $uploader_name = mysqli_fetch_assoc($mysqli->query("SELECT full_name from employee where email = '".$temp[1]."'"));
    $html .=        '<td>'.$uploader_name['full_name'].'</td>
                </tr>';
}
if($no_body){
    $html .= '<tr><td colspan="4" class="text-center">No Data</td></tr>';
}
$html .=        '</tbody>
        </table>';
echo $html;