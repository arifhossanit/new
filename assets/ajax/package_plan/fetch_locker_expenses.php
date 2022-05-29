<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['locker_type'])){
    $html = '';
    $locker_type_id = $_POST['locker_type'];
    $locker_expense = mysqli_fetch_assoc($mysqli->query("SELECT price from manage_locker where id = $locker_type_id"));
    $html .=    '<hr class="solid">
                <input type="hidden" name="selected_locker" value="'.$locker_type_id.'">
                <input type="hidden" name="locker_value" id="locker_value" value="'.$locker_expense['price'].'">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Locker Rent: </h5>
                        <span style="color: red" class="error-page danger"></span>
                    </div>
                    <div class="col-md-6">
                        <p id="locker">TK <span>'.number_format($locker_expense['price']).'</span></p>              
                    </div>
                </div>';
    echo $html;
}