<?php
include("../../application/config/ajax_config.php");
$today = new DateTime(date('Y-m-d H:i:s'));

$selected_package_info = explode('___', $_POST['selected_package']);

/**
 * Gettting the last month from rent info.
 * Getting month name and then getting rent as there can be one or two rent record for a month.
 */
$get_last_rent_month = mysqli_fetch_assoc($mysqli->query("SELECT data, month_name, package_category_name from rent_info where booking_id = '".$_POST['booking_id']."' AND recharge_days > 0 ORDER BY id DESC LIMIT 1"));

/**
 * Old code for calculating for current month.
 */

// if($today->format('F') == 'October'){
//     /**
//      * For October some of the month in database entered as Octaber.
//      * Creating static logic for that.
//      */
//     $rent_info = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as id_count, recharge_days, rent_amount, discount_pattern, discount_money, payment_pattern from rent_info where booking_id = '".$_POST['booking_id']."' AND ( month_name = '".$get_last_rent_month['month_name']."' OR month_name = 'Octaber') GROUP BY month_name ORDER BY id DESC"));
// }else{
// }

/**
 * End Old code.
 */

$payment_pattent = 'full';
if(!is_null($get_last_rent_month)){
    if(strpos($get_last_rent_month['package_category_name'], 'Try US') !== false){
        $rent_info = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as id_count, recharge_days, rent_amount, discount_pattern, discount_money, payment_pattern from rent_info where booking_id = '".$_POST['booking_id']."' ORDER BY id DESC"));
        $rent_info_previous = mysqli_fetch_assoc($mysqli->query("SELECT payment_pattern from rent_info where booking_id = '".$_POST['booking_id']."' ORDER BY id DESC limit 1,1"));
        if(!is_null($rent_info_previous)){
            if($rent_info_previous['payment_pattern'] == '0'){
                $payment_pattent = 'half';
            }
        }
    }else{
        $month_sub_str = substr($get_last_rent_month['data'], 3);
        $rent_info = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as id_count, recharge_days, rent_amount, discount_pattern, discount_money, payment_pattern from rent_info where booking_id = '".$_POST['booking_id']."' AND month_name = '".$get_last_rent_month['month_name']."' AND data LIKE '%". $month_sub_str ."%' GROUP BY month_name ORDER BY id DESC"));
        if($rent_info['id_count'] != '1'){
            $payment_pattent = 'half';
        }
    }
    $get_available_days = mysqli_fetch_assoc($mysqli->query("SELECT available_days from booking_info where booking_id = '".$_POST['booking_id']."' ORDER BY id DESC LIMIT 1"));
    $selected_package = mysqli_fetch_assoc($mysqli->query("SELECT monthly_rent, package_days, try_us from packages where id = ".$selected_package_info[0]));
    $old_package = mysqli_fetch_assoc($mysqli->query("SELECT monthly_rent, package_days from packages where id = ".$_POST['old_package']));

    if((double)$get_available_days['available_days'] <= 0){
        echo json_encode(array('given' => 0, 'new' => 0, 'net_payable' => 0, 'net_payable_final' => 0, 'recharge_days' => 0, 'days_stayed' => 0, 'available_days' => 0, 'old_rent' => 0, 'new_rent' => 0, 'dicount_amount' => 0));
        return;
    }
    
    $days_stayed = (double)$rent_info['recharge_days'] - (double)$get_available_days['available_days'];
    
    $discount_amount = 0;
    $new_rent = (double)$selected_package['monthly_rent'];
    $old_rent = (double)$old_package['monthly_rent'];
    
    /**
     * To identify full paymenmt, payment_pattern will be 1 and also number of row in rent_info table should be 1.
     * If the number of row is 2 then it is second installment and will be counted as half payment.
     */
    
    if($rent_info['payment_pattern'] == '1' AND $payment_pattent == 'full'){
        /**
         * Rent count of full payment.
         */
    
        if(strtolower($rent_info['discount_pattern']) == 'a' OR strtolower($rent_info['discount_pattern']) == 'b' OR strtolower($rent_info['discount_pattern']) == 'aa'){
            /**
             * If the member had discount, discount amount will be deducted from both the old and new rent.
             * As for old rent, discounted amount is already calculated in rent_info table.
             */
            $get_discount_amount = mysqli_fetch_assoc($mysqli->query("SELECT amount from discount_member where booking_id = '".$_POST['booking_id']."'"));
    
            $discount_amount = (is_null($get_discount_amount)) ? 0 : (double)$get_discount_amount['amount'];
        }
        if($selected_package['try_us']){
            $new_package_days = (double)$selected_package['package_days'];
        }else{
            $new_package_days = $today->format('t');
        }
        
    }else if($rent_info['payment_pattern'] == '1' OR $rent_info['payment_pattern'] == '0'){
    
        /**
         * Rent count of half payment first or second installment.
         */
        if(strtolower($rent_info['discount_pattern']) == 'a' OR strtolower($rent_info['discount_pattern']) == 'b' OR strtolower($rent_info['discount_pattern']) == 'aa'){
            /**
             * If the member had discount, discount amount will be deducted from both the old and new rent.
             * As for old rent, discounted amount is already calculated in rent_info table.
             */
            $get_discount_amount = mysqli_fetch_assoc($mysqli->query("SELECT amount from discount_member where booking_id = '".$_POST['booking_id']."'"));
        
            $discount_amount = (is_null($get_discount_amount)) ? 0 : (double)$get_discount_amount['amount'] / 2;
            
        }
    
        $new_rent = (double)$selected_package['monthly_rent'] / 2;
        $new_rent += 200; // 200 is added as this is half payment.

        $old_rent = (double)$old_package['monthly_rent'] / 2;
        $old_rent += 200; // 200 is added as this is half payment.
    
        if($selected_package['try_us']){
            $new_package_days = (double)$selected_package['package_days'] / 2;
        }else{
            $new_package_days = $today->format('t') / 2;
        }
    }
    
    $total_rent_consumed = ( ( $old_rent - $discount_amount ) / (double)$rent_info['recharge_days'] ) * $days_stayed; // Here rent is already calculated with discount!
    // $new_rent = ( ( $new_rent / $new_package_days ) * (double)$get_available_days['available_days'] ) - $discount_amount;
    $new_rent = ( ( ( $new_rent - $discount_amount ) / $new_package_days ) * (double)$get_available_days['available_days'] );
    
    
    /**
     * $rent_info['rent_amount'] => the rent already paid.
     * $total_rent_consumed => Consumed rent which is respected to total days stayed.
     * 
     * Subtracting new rent from rent that is not yet consumed to get the net payable rent!
     */
    $net_payable = ( $new_rent + $total_rent_consumed ) - $rent_info['rent_amount'] ; 
    
    /**
     * If new payable is less then zero then we will not refund that amount.
     */
    if($net_payable < 0){
        $net_payable_final = 0;
    }else{
        $net_payable_final = $net_payable;
    }
    echo json_encode(array('given' => $total_rent_consumed, 'new' => $new_rent, 'net_payable' => $net_payable, 'net_payable_final' => $net_payable_final, 'recharge_days' => $rent_info['recharge_days'], 'days_stayed' => $days_stayed, 'available_days' => $get_available_days['available_days'], 'old_rent' => $rent_info['rent_amount'], 'new_rent' => $new_rent, 'dicount_amount' => $discount_amount));
}else{
    echo json_encode(array('given' => 0, 'new' => 0, 'net_payable' => 0, 'net_payable_final' => 0, 'recharge_days' => 0, 'days_stayed' => 0, 'available_days' => 0, 'old_rent' => 0, 'new_rent' => 0, 'dicount_amount' => 0));
}
