<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'rent_info';
$primaryKey = 'id';
$one = explode(' - ',$_GET['date_range']);
if($_GET['package_type'] == 'try_us'){
    $package_type = " AND package in (SELECT id from packages where try_us = 1)";
}else if($_GET['package_type'] == 'monthly'){
    $package_type = " AND package in (SELECT id from packages where try_us != 1)";
}else{
    $package_type = "";
}
if($one[0] != ''){
    $one_ymd = explode('/',$one[0]);
    $two_ymd = explode('/',$one[1]);
    $date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
    $date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
    $date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
}else{
    $date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$today' AND '$today'";
}

if(isset($_GET['branch_id'])){
    if($_GET['branch_id'] != '1'){
        $branch_id = " AND branch_id = '".rahat_decode($_GET['branch_id'])."'";
    }else{
	    $branch_id = "";
    }
}else{
	$branch_id = "";
}

if(isset($_GET['payment_pattern'])){
    if($_GET['payment_pattern'] != 'all'){
        $payment_pattern = " AND payment_pattern = '".$_GET['payment_pattern']."'";
    }else{
	    $payment_pattern = " AND payment_pattern != '2'";
    }
}else{
	$payment_pattern = " AND payment_pattern != '2'";
}
$where = "status = 1".$date_filter.$branch_id.$payment_pattern.$package_type;
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'branch_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) {global $mysqli;
            $branch = mysqli_fetch_assoc($mysqli->query("SELECT `branch_name` from branches where branch_id LIKE '".$d."'"));
            return (is_null($branch['branch_name'])) ? '-' : $branch['branch_name'];
		}
	),
    array( 'db' => 'm_name',   'dt' => 2 ),
    array( 'db' => 'package_name',   'dt' => 3 ),
    array( 'db' => 'card_no',   'dt' => 4 ),
    array(
        	'db' => 'payment_pattern',
        	'dt' => 5,
        	'formatter' => function( $d, $row ) {
                if($d == '0'){
                    return 'Half';
                }else if($d == '1'){
                    return 'Full';
                }else if($d == '2'){
                    return 'Due';
                }else if($d == '3'){
                    return 'Pandemic Rent';
                }
            }
        ),
    array(
        'db' => 'rent_amount',
        'dt' => 6,
        'formatter' => function( $d, $row ) {
            return round($d);
        }
    ),
    array( 'db' => 'electricity',   'dt' => 7 ),
    array( 'db' => 'parking',   'dt' => 8 ),
    array( 'db' => 'penalty',   'dt' => 9 ),
    array( 'db' => 'card_p_amount',   'dt' => 10 ),
    array(
        'db' => 'tea_coffee',
        'dt' => 11,
        'formatter' => function( $d, $row ) {
            return (empty($d)) ? 0 : $d;
        }
    ),
    array( 'db' => 'locker',   'dt' => 12 ),
    array(
		'db' => 'booking_id',
		'dt' => 13,
		'formatter' => function( $d, $row ) {global $mysqli;
            $member_info = mysqli_fetch_assoc($mysqli->query("SELECT sum(card_amount) as card_amount, sum(cash_amount) as cash_amount, sum(mobile_amount) as mobile_amount, sum(check_amount) as check_amount FROM `payment_received_method` where booking_id LIKE '".$d."' AND data LIKE '".$row[16]."' GROUP BY booking_id, transaction_id ORDER BY `payment_received_method`.`id` ASC"));
            return intval($member_info['card_amount']) + intval($member_info['cash_amount']) + intval($member_info['mobile_amount']) + intval($member_info['check_amount']);
            // return $member_info['card_amount'] . $member_info['cash_amount'] . $member_info['mobile_amount'] . $member_info['check_amount'];
            // return $d;
		}
	),
    array(
		'db' => 'booking_id',
		'dt' => 14,
		'formatter' => function( $d, $row ) {global $mysqli;
            $member_info = mysqli_fetch_assoc($mysqli->query("SELECT sum(card_amount) as card_amount, sum(cash_amount) as cash_amount, sum(mobile_amount) as mobile_amount, sum(check_amount) as check_amount FROM `payment_received_method` where booking_id LIKE '".$d."' AND data LIKE '".$row[16]."' GROUP BY booking_id, transaction_id ORDER BY `payment_received_method`.`id` ASC"));
            $total = intval($row[6]) + intval($row[7]) + intval($row[8]) + intval($row[9]) + intval($row[10]) + intval($row[11]) + intval($row[12]);
            $total_received = intval($member_info['card_amount']) + intval($member_info['cash_amount']) + intval($member_info['mobile_amount']) + intval($member_info['check_amount']);
            if($row[17] == 'booking'){
                $package_price = mysqli_fetch_assoc($mysqli->query("SELECT package_price from packages where id = ".$row[18]));
                return $total_received - $total - intval($package_price['package_price']);  
            }else{
                return $total_received - $total;
            }
		}
	),
    array(
		'db' => 'uploader_info',
		'dt' => 15,
		'formatter' => function( $d, $row ) {global $mysqli;
            // return $d;
            $employee_email = explode('___',$d);
            // return $employee_email[0];
            if(isset($employee_email[1])){
                $member_info = mysqli_fetch_assoc($mysqli->query("SELECT `full_name` from employee where email LIKE '".$employee_email[1]."'"));
                return $member_info['full_name'];
            }else{
                return '-';
            }
		}
	),
    array( 'db' => 'data',   'dt' => 16 ),
    array( 'db' => 'note',   'dt' => 17 ),
    array( 'db' => 'package',   'dt' => 18 ),
    // array(
	// 	'db' => 'booking_id',
	// 	'dt' => 5,
	// 	'formatter' => function( $d, $row ) {global $mysqli;
    //         $check_out = mysqli_fetch_assoc($mysqli->query("SELECT `checkoutdate` from withdraw_checkout where booking_id LIKE '".$d."'"));
    //         return (is_null($check_out) ? 'Not confirmed yet' : $check_out['checkoutdate']);
	// 	}
	// ),
    // array(
	// 	'db' => 'booking_id',
	// 	'dt' => 6,
	// 	'formatter' => function( $d, $row ) {global $mysqli;
    //         $check_out = mysqli_fetch_assoc($mysqli->query("SELECT `checkoutdate` from withdraw_checkout where booking_id LIKE '".$d."'"));
    //         if(is_null($check_out)){
    //             return 'Not Yet Confirm';
    //         }else{
    //             $sum_recharge_days = mysqli_fetch_assoc($mysqli->query("SELECT SUM(recharge_days) as recharge_sum FROM `rent_info` where booking_id LIKE '".$d."'"));
    //             $check_out_info = explode(', ', $check_out['checkoutdate']);
    //             $check_out_date = substr($check_out_info[1],0,10);
    //             $date_split = explode('/', $check_out_date);
    //             $formatted_check_out_date = $date_split[2].'/'.$date_split[1].'/'.$date_split[0];
    //             $date_split = explode('/', $row[4]);
    //             $formatted_check_in_date = $date_split[2].'/'.$date_split[1].'/'.$date_split[0];
    //             $check_in = new Datetime($formatted_check_in_date);
    //             $check_out = new Datetime($formatted_check_out_date);
    //             $date_diff = $check_out->diff($check_in);
    //             if(intval($date_diff->d) > intval($sum_recharge_days['recharge_sum'])){
    //                 $extra = intval($date_diff->d) - intval($sum_recharge_days['recharge_sum']);
    //                 if($extra == 0){
    //                     return '<p class="mb-0">Stayed: '.$date_diff->d.' days </p>';
    //                 }else{
    //                     return '<p class="mb-0">Stayed: '.$date_diff->d.' days </p>'.'<p class="mb-0 text-danger">Extra: '.$extra.' days </p>';
    //                 }
    //             }else{
    //                 $less = intval($sum_recharge_days['recharge_sum']) - intval($date_diff->d);
    //                 if($less == 0){
    //                     return '<p class="mb-0">Stayed: '.$date_diff->d.' days </p>';
    //                 }else{
    //                     return '<p class="mb-0">Stayed: '.$date_diff->d.' days </p>'.'<p class="mb-0 text-info">Less: '.$less.' days </p>';
    //                 }
    //             }
    //         }
            
	// 	}
	// ),
    // array( 'db' => 'package_name',   'dt' => 7 ),
	// array(
	// 	'db' => 'booking_id',
	// 	'dt' => 8,
	// 	'formatter' => function( $d, $row ) {global $mysqli;
    //         $pattern = mysqli_fetch_assoc($mysqli->query("SELECT `payment_pattern` from rent_info where booking_id LIKE '".$d."'"));
    //         if(!is_null($pattern)){
    //             if($pattern['payment_pattern'] == '0'){
    //                 return 'Half';
    //             }else{
    //                 return 'Full';
    //             }
    //         }			
	// 	}
	// ),
    // array(
	// 	'db' => 'booking_id',
	// 	'dt' => 9,
	// 	'formatter' => function( $d, $row ) {global $mysqli;
    //         // return $d;
    //         $cancel = mysqli_fetch_assoc($mysqli->query("SELECT `note` from cencel_request where booking_id LIKE '".$d."'"));
    //         if(!is_null($cancel)){
    //             // return $cancel['note'];
    //             if($cancel['note'] == 'Request For Cancel for rental payment issue (auto cancel from software)'){
    //                 return 'Auto Cancel';
    //             }else{
    //                 return 'Cancel';
    //             }
    //         }else{
    //             // return $cancel['note'];
    //             return 'Occupied';
    //         }
	// 	}
	// ),
    // array(
	// 	'db' => 'booking_id',
	// 	'dt' => 10,
	// 	'formatter' => function( $d, $row ) {global $mysqli;
    //         // return $d;
    //         $uploader = mysqli_fetch_assoc($mysqli->query("SELECT `uploader_info` from booking_info where booking_id LIKE '".$d."'"));
    //         $employee_email = explode('___',$uploader['uploader_info']);
    //         $member_info = mysqli_fetch_assoc($mysqli->query("SELECT `full_name` from employee where email LIKE '".$employee_email[1]."'"));
    //         return $member_info['full_name'];
	// 	}
	// ),
    // array(
	// 	'db' => 'booking_id',
	// 	'dt' => 11,
	// 	'formatter' => function( $d, $row ) {global $mysqli;
    //         // return $d;
    //         $check_out_by = mysqli_fetch_assoc($mysqli->query("SELECT `uploader_info` from withdraw_checkout where booking_id LIKE '".$d."'"));
    //         if(!is_null($check_out_by)){
    //             $employee_email = explode('___',$check_out_by['uploader_info']);
    //             $member_info = mysqli_fetch_assoc($mysqli->query("SELECT `full_name` from employee where email LIKE '".$employee_email[1]."'"));
    //             return $member_info['full_name'];
    //         }else{
    //             return 'Not Checked Out Yet';
    //         }
            
	// 	}
	// ),
    // array(
	// 	'db' => 'booking_id',
	// 	'dt' => 12,
	// 	'formatter' => function( $d, $row ) {global $mysqli;
    //         $member = mysqli_fetch_assoc($mysqli->query("SELECT `id` from member_directory where booking_id = '".$d."'"));
    //         if(check_permission('role_1606371205_51')){ 
    //             $data = '<button onclick="return view_member_profile('.$member['id'].')" type="button" class="btn btn-xs btn-warning" title="View member profile"><i class="fa fa-eye"></i></button>';		
    //         }
    //         return $data;
	// 	}
	// ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>