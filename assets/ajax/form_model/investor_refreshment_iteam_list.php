<?php
include("../../../application/config/ajax_config.php");
$investor_info = mysqli_fetch_assoc($mysqli->query("SELECT ipo_member_directory.personal_full_name, investor_facilities_setup.tea_coffee, investor_facilities_setup.drinks, investor_facilities_setup.id from investor_facilities_setup INNER JOIN ipo_member_directory on ipo_member_directory.card_number = investor_facilities_setup.card_no where investor_facilities_setup.card_no = '".$_POST['card_number']."' AND investor_facilities_setup.status = 1"));
if(is_null($investor_info)){
    $html = '<div class="col-sm-12 text-center" id="investor_refreshment_item"><p class="text-center">No Info Found!!!</p></div>';
    $button = '';
}else{
    $html = '<input type="hidden" name="investor_refreshment_id" value="'.$investor_info['id'].'">
            <div class="col-sm-12" id="investor_refreshment_item">
                <div class="row" id="otp_div">
                    <div class="col-md-3">
                        <p style="font-size: 25px;"><span class="text-secondary">Name:</span> '.$investor_info['personal_full_name'].'</p>
                    </div>
                    <div class="col-md-2">
                        <button id="send_otp_button" type="button" onclick="send_investor_otp(\''.$_POST['card_number'].'\')" class="btn btn-success">Send OTP</button>
                    </div>
                    <div class="col-md-6" id="confirm_otp_div">
                        
                    </div>
                </div>
                <div id="items_div"></div>
            </div>';
}

$info = array(
    'html' => $html,
);
echo json_encode($info);