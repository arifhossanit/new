<?php
include("../../../application/config/ajax_config.php");
$investor_info = mysqli_fetch_assoc($mysqli->query("SELECT ipo_member_directory.personal_full_name, investor_facilities_setup.tea_coffee, investor_facilities_setup.drinks, investor_facilities_setup.id from investor_facilities_setup INNER JOIN ipo_member_directory on ipo_member_directory.card_number = investor_facilities_setup.card_no where investor_facilities_setup.card_no = '".$_POST['card_number']."' AND investor_facilities_setup.status = 1"));
$otp_flag = false;
if(isset($_SESSION['investor_refreshment_otp'])){
    if($_POST['confirm_otp'] == $_SESSION['investor_refreshment_otp']){
        $otp_flag = true;
    }
}
if($otp_flag){
    $html = '<div class="row mt-2">
                <div class="col-md-6 p-3" style="border: 1px solid #bdbdbd; border-radius: 15px">
                    <div class="row">
                        <div class="col-md-8">
                            <p style="font-size: 25px;"><span class="text-secondary">Tea/Coffee Remaining: </span> '.$investor_info['tea_coffee'].'</p>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="number" name="tea_amount" placeholder="Enter Amount" max="'.$investor_info['tea_coffee'].'">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <p style="font-size: 25px;"><span class="text-secondary">Drinks Remaining: </span> '.$investor_info['drinks'].'</p>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="number" name="drinks_amount" placeholder="Enter Amount" max="'.$investor_info['drinks'].'">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered" id="refreshment_table">
                    <thead>
                        <tr>
                            <td>Tea/Coffee</td>
                            <td>Drinks</td>
                            <td>Date</td>
                            <td>Issued By</td>
                        </tr>
                    </thead>
                    <tbody>';
    $refreshment_records = $mysqli->query("SELECT * from investor_facilities_setup_records where investor_facilities_setup_id = ".$investor_info['id']);
    while($refreshment_record = mysqli_fetch_assoc($refreshment_records)){
        $html .=    '<tr>
                        <td>'.$refreshment_record['tea_coffee'].'</td>
                        <td>'.$refreshment_record['drinks'].'</td>
                        <td>'.$refreshment_record['date'].'</td>';
        $temp = explode('___',$refreshment_record['uploader_info']);
        $uploader_name = mysqli_fetch_assoc($mysqli->query("SELECT full_name from employee where email = '".$temp[1]."'"));
        $html .=        '<td>'.$uploader_name['full_name'].'</td>
                    </tr>';
    }
    $html .=        '</tbody>
                </div>
            </div>';
    $info = array(
        'html'      => $html,
        'button'    => '<button type="submit" name="investor_refreshment" style="float:right;" class="btn btn-success">Save</button>'
    );
}else{
    $info = array(
        'html' => 'OTP did not match!',
        'button' => ''
    );
}
echo json_encode($info);