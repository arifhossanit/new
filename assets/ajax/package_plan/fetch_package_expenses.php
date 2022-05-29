<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['package_category_id'])){
    $package_category_id = $_POST['package_category_id'];
    $branch_id = $_POST['branch_id'];
    $package_name = $_POST['package_name'];
    $result = $mysqli->query("select package_price, monthly_rent, discount_amount, package_days, package_category_name, try_us, parking_amount, id from packages where branch_id = '$branch_id' and package_category_id = '$package_category_id' and package_name = '$package_name'");
    $expense = mysqli_fetch_assoc($result);
    $lockerCount = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as lockerCount from manage_locker WHERE branch_id = '$branch_id' AND uses = 0"));
    $day = date('d');
    $month = date('Y-m');
    $newDay = $month.'-'.$day;
    $html = '<input type="hidden" id="package_name" name="package_name" value="'.$package_name.'">
             <input type="hidden" id="disccount_money" name="disccount_money" value="0">
             <input type="hidden" value="'.$branch_id.'" name="branch_id" id="branch_id">
             <input type="hidden" value="'.$expense['id'].'" name="package_id">
             <input type="hidden" value="'.$expense['package_price'].'" name="security_money" id="security_money">
             <input type="hidden" value="'.$expense['monthly_rent'].'" name="monthly_rent" id="rent_amount">
             <input type="hidden" value="'.$expense['parking_amount'].'" name="parking_amount" id="parking_value">
             <div class="card">
             <div class="card-body">    
                <div class="row">
                    <div class="col-md-6">
                        <h5>Check-in Date: </h5>
                        <span style="color: red" class="error-page danger"></span>
                    </div>
                    <div class="col-md-6">
                        <input id="date_set" type="hidden" value="not set">
                        <input id="checkin_date" name="checkin_date" class="button date" type="date" min="'.$newDay.'" onchange="select_date(this.value)" required>                        
                    </div> 
                </div>';
    if($expense['parking_amount'] != '0'){
        $html .=     '<hr class="solid">
                      <div class="row">
                            <div class="col-md-6">
                                <h5>Parking: </h5>
                                <span style="color: red" class="error-page danger"></span>
                            </div>
                            <div class="col-md-6 parking_container">
                                <label class="parking_label col-md-6">Yes
                                  <input type="radio" name="parking" id="parking_yes" value="yes" onchange="money_manage_ment_pkn_pln()">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="parking_label col-md-6">No
                                  <input type="radio" name="parking" checked="checked" id="parking_no" value="no">
                                  <span class="checkmark"></span>
                                </label>                     
                            </div>
                      </div>
                        ';
    }
    if($lockerCount['lockerCount'] > 0){
        $lockerResult = $mysqli->query("SELECT id, locker_type_name from manage_locker WHERE branch_id = 'BAR_100920_294562129482664344_1599721915' AND uses = 0 group by locker_type_name");
        $html .=     '<hr class="solid">
                      <div class="row">
                            <div class="col-md-6">
                                <h5>Locker: </h5>
                                <span style="color: red" class="error-page danger"></span>
                            </div>
                            <div class="col-md-6 parking_container">
                                <label class="parking_label col-md-6">Yes
                                  <input type="radio" name="locker" id="locker_yes" value="yes">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="parking_label col-md-6">No
                                  <input type="radio" name="locker" checked="checked" id="locker_no" value="no">
                                  <span class="checkmark"></span>
                                </label>                     
                            </div>
                      </div>
                      <div id="locker_type_show" style="display: none">
                        <hr class="solid">
                        <div class="row">
                                <div class="col-md-6">
                                    <h5>Locker Type: </h5>
                                    <span style="color: red" class="error-page danger"></span>
                                </div>
                                <div class="col-md-6 parking_container">';
                                while($locker = mysqli_fetch_assoc($lockerResult)){
                                    $html .= '<label class="parking_label col-md-6">'.$locker['locker_type_name'];
                                    $html .= '<input data-target="#locker_select" data-toggle="modal" type="radio" name="locker_type" value="'.$locker['id'].'" onclick="money_manage_ment()">';
                                    $html .= '<span class="checkmark"></span>
                                              </label>';
                                }                    
        $html .=                '</div>
                        </div>
                      </div>';
    }
    if($expense['try_us'] == 0){
        if(date('d') <= 15){
            $html .= '  <hr class="solid half-pay">
                        <div class="row half-pay">
                            <div class="col-md-6">
                                <h5>Payment: </h5>
                                <span style="color: red" class="error-page danger"></span>
                            </div>
                            <div class="col-md-6 parking_container">
                                <label class="parking_label col-md-6">Full
                                <input type="radio" name="payment" id="payment_full" value="full" onchange="money_manage_ment()" checked>
                                <span class="checkmark"></span>
                                </label> 
                                <label class="parking_label col-md-6">Half
                                <input type="radio" name="payment" id="payment_half" value="half">
                                <span class="checkmark"></span>
                                </label>                     
                            </div>
                        </div>';
        }else{
            $html .= '  <hr class="solid half-pay" style="display: none">
                        <div class="row half-pay" style="display: none">
                            <div class="col-md-6">
                                <h5>Payment: </h5>
                                <span style="color: red" class="error-page danger"></span>
                            </div>
                            <div class="col-md-6 parking_container">
                                <label class="parking_label col-md-6">Full
                                <input type="radio" name="payment" id="payment_full" value="full" onchange="money_manage_ment()" checked>
                                <span class="checkmark"></span>
                                </label> 
                                <label class="parking_label col-md-6">Half
                                <input type="radio" name="payment" id="payment_half" value="half">
                                <span class="checkmark"></span>
                                </label>                     
                            </div>
                        </div>';
        }      
    }else if($expense['package_days'] == 30){
        if(date('d') <= 15){
            $html .= '  <hr class="solid half-pay">
                        <div class="row half-pay">
                            <div class="col-md-6">
                                <h5>Payment: </h5>
                                <span style="color: red" class="error-page danger"></span>
                            </div>
                            <div class="col-md-6 parking_container">
                                <label class="parking_label col-md-6">Full
                                <input type="radio" name="payment" id="payment_full" value="full" onchange="money_manage_ment()" checked>
                                <span class="checkmark"></span>
                                </label> 
                                <label class="parking_label col-md-6">Half
                                <input type="radio" name="payment" id="payment_half" value="half">
                                <span class="checkmark"></span>
                                </label>                     
                            </div>
                        </div>';
        }else{
            $html .= '  <hr class="solid half-pay" style="display: none">
                        <div class="row half-pay" style="display: none">
                            <div class="col-md-6">
                                <h5>Payment: </h5>
                                <span style="color: red" class="error-page danger"></span>
                            </div>
                            <div class="col-md-6 parking_container">
                                <label class="parking_label col-md-6">Full
                                <input type="radio" name="payment" id="payment_full" value="full" onchange="money_manage_ment()" checked>
                                <span class="checkmark"></span>
                                </label> 
                                <label class="parking_label col-md-6">Half
                                <input type="radio" name="payment" id="payment_half" value="half">
                                <span class="checkmark"></span>
                                </label>                     
                            </div>
                        </div>';
        }
    }else{
        $html .= '  <hr class="solid" style="display: none">
                    <div class="row" style="display: none">
                        <div class="col-md-6">
                            <h5>Payment: </h5>
                            <span style="color: red" class="error-page danger"></span>
                        </div>
                        <div class="col-md-6 parking_container">
                            <label class="parking_label col-md-6">Full
                            <input type="radio" name="payment" id="payment_full" value="full" onchange="money_manage_ment()" checked>
                            <span class="checkmark"></span>
                            </label> 
                            <label class="parking_label col-md-6">Half
                            <input type="radio" name="payment" id="payment_half" value="half">
                            <span class="checkmark"></span>
                            </label>                     
                        </div>
                    </div>';
    }
    $html .=    '<hr class="solid">       
                <div class="row">
                    <div class="col-md-6">
                        <h5>Security Deposit: </h5>
                    </div>
                    <div class="col-md-6">
                        <p> TK
                            <span id="amount">'.number_format($expense['package_price']).'</span>
                        </p>   
                    </div>        
                </div>
                <hr class="solid">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Discount: </h5>
                    </div>
                    <div class="col-md-6">
                        <p id="discountFoot">TK <span id="discount_text">'.number_format($expense['discount_amount']).'</span></p><small class="danger">(Applicable if you are lucky.)</small>
                    </div>                
                </div>                
                <hr class="solid">
                <div class="row">                
                    <div class="col-md-6">';
    if($expense['try_us'] == 1){
        $html .= '<h5>Package Amount: </h5>';
    }else{
        $html .= '<h5>Monthly Rent: </h5>';
    }
    $html .= '</div>
                    <div class="col-md-6">
                    <p id="monthlyRent">TK <span>'.number_format($expense['monthly_rent']).'</span></p>
                    </div>
                </div>  
                
                <div id="parking_amount" style="display: none">
                    <hr class="solid">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Parking Rent: </h5>
                            <span style="color: red" class="error-page danger"></span>
                        </div>
                        <div class="col-md-6">
                            <p id="parking">TK <span>'.number_format($expense['parking_amount']).'</span></p>              
                        </div> 
                    </div>  
                </div> 

                <div id="locker_price">
                </div>

                <div id="full_amount">
                    <hr class="solid">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Amount to Pay: </h5>';
                            if($expense['try_us'] != 1){
                                $html .= '<small id="total_amount_disclaimer" style="display: none" class="text-info">(Monthly Rent Calculated for the remaining days of the month!)</small>';
                            }                            
    $html .=                '<span style="color: red" class="error-page danger"></span>
                        </div>
                        <div class="col-md-6">
                            <p id="totalAmountBeforeDate"><small class="text-danger">Enter Check In Date</small></p>
                            <p id="totalAmount" style="display: none">TK <span id="total_amount_large"></span></p>              
                        </div> 
                    </div>  
                </div>
                
                <div class="row">
                    <input type="submit" class="button book" value="Book">
                </div> 
            </div>
            </div>';
    echo $html;

//    <button class="button book">Book</button>
}
