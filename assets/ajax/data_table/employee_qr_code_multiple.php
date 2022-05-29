<?php
include("../../../application/config/ajax_config.php");
// include('../../../application/helpers/qrcode_helper.php');
// $daaata = $home.'employee-rating/qr-code/'.rahat_encode($row['id']);
// $file = '../../uploads/qrcode/employee_q_code_id_'.$row['id'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2); ?>
<style>
    .col-print-1 {width:8%;  float:left;}
    .col-print-2 {width:16%; float:left;}
    .col-print-3 {width:25%; float:left;}
    .col-print-4 {width:33%; float:left;}
    .col-print-5 {width:42%; float:left;}
    .col-print-6 {width:50%; float:left;}
    .col-print-7 {width:58%; float:left;}
    .col-print-8 {width:66%; float:left;}
    .col-print-9 {width:75%; float:left;}
    .col-print-10{width:83%; float:left;}
    .col-print-11{width:92%; float:left;}
    .col-print-12{width:100%; float:left;}
    .qr-box{
        border: 1px solid #e0e0e0;
        padding: 7px;
        margin: 7px;
    }
</style>
<div class="row justify-content-center">
    <table>
        <?php
            $i = 0;
            foreach($_POST['employee_ids'] as $employee_id){ 
                $employee = mysqli_fetch_assoc($mysqli->query("SELECT id, f_name, l_name from employee where employee_id = '$employee_id'"));
        ?>
            <?php //echo ($i % 2 == 0) ? '<tr>' : '' ?>
            <tr>
                <td style="width: 165px;">
                    <div class="col-print-12">
                        <div class="qr-box">
                            <div class="row text-center">
                                <div class="col-sm">
                                    <p style="font-size: 18px;font-weight: 600;"><?php echo $employee['f_name'].' '.$employee['l_name']; ?></p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm">
                                    <img style="width: 147px;" src="<?php echo $home.'assets/uploads/qrcode/employee_q_code_id_'.$employee['id'].'.png'; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php //echo ($i % 2 != 0) ? '</tr>' : '' ?>
        <?php $i++; } ?>
    </table>
</div>