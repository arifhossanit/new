<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'member_directory';
$primaryKey = 'id';

// for rent_info
if(isset($_GET['date_range'])){
    $today = date('Y-m-d');
    $one = explode(' - ',$_GET['date_range']);
    if($one[0] != ''){
        $one_ymd = explode('/',$one[0]);
        $two_ymd = explode('/',$one[1]);
        $date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
        $date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
        $date_filter = " AND STR_TO_DATE(check_in_date,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
    }else{
        $date_filter = " AND STR_TO_DATE(check_in_date,'%d/%m/%Y') BETWEEN '$today' AND '$today'";
    }
}else{
	$date_filter = "";
}

if(!empty($_GET['cancel_type'])){
    $cancel_query = $mysqli->query("select booking_id from cencel_request where note = 'Request For Cancel for rental payment issue (auto cancel from software)'");
    $cencel = '';
    while($row = mysqli_fetch_assoc($cancel_query)){
        $cencel .= "'".$row['booking_id']."',";
    }
    $cancel_data = rtrim($cencel,',');
    $cancel_id = " AND booking_id IN (".$cancel_data.")";
}else{
    $cancel_id = '';
}

if(isset($_GET['payment_pattern'])){
    if($_GET['payment_pattern'] != 'all'){
        $rent_query = $mysqli->query("SELECT booking_id from rent_info where payment_pattern = '".$_GET['payment_pattern']."' GROUP BY booking_id");
        $rent_id = '';
        while($row = mysqli_fetch_assoc($rent_query)){
            $rent_id .= "'".$row['booking_id']."',";
        }
        $rent_data = rtrim($rent_id,',');
        $payment_pattern = " AND booking_id IN (".$rent_data.")";
    }else{
	    $payment_pattern = "";
    }
}else{
	$payment_pattern = "";
}
if(isset($_GET['package_name'])){
    if($_GET['package_name'] != '1'){
        $package_name = " AND package_name LIKE '%".$_GET['package_name']."%'";
        // $package_name = " AND package_name = '".$_GET['package_name']."'";
    }else{
	    $package_name = "";
    }
}else{
	$package_name = "";
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
$where = "status in ('0','1','2','3') ".$cancel_id." ".$date_filter." ".$payment_pattern." ".$package_name." ".$branch_id;
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'booking_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) {global $mysqli;
            $pattern = mysqli_fetch_assoc($mysqli->query("SELECT `card_no` from booking_info where booking_id LIKE '".$d."'"));
            return $pattern['card_no'];		
		}
	),
    array( 'db' => 'branch_name',   'dt' => 2 ),
    array( 'db' => 'full_name',   'dt' => 3 ),
    array( 'db' => 'check_in_date',   'dt' => 4 ),
    array(
		'db' => 'booking_id',
		'dt' => 5,
		'formatter' => function( $d, $row ) {global $mysqli;
            $check_out = mysqli_fetch_assoc($mysqli->query("SELECT `checkoutdate` from withdraw_checkout where booking_id LIKE '".$d."'"));
            return (is_null($check_out) ? 'Not confirmed yet' : $check_out['checkoutdate']);
		}
	),
    array(
		'db' => 'booking_id',
		'dt' => 6,
		'formatter' => function( $d, $row ) {global $mysqli;
            $check_out = mysqli_fetch_assoc($mysqli->query("SELECT `checkoutdate` from withdraw_checkout where booking_id LIKE '".$d."'"));
            if(is_null($check_out)){
                return 'Not Yet Confirm';
            }else{
                $sum_recharge_days = mysqli_fetch_assoc($mysqli->query("SELECT SUM(recharge_days) as recharge_sum FROM `rent_info` where booking_id LIKE '".$d."'"));
                $check_out_info = explode(', ', $check_out['checkoutdate']);
                $check_out_date = substr($check_out_info[1],0,10);
                $date_split = explode('/', $check_out_date);
                $formatted_check_out_date = $date_split[2].'/'.$date_split[1].'/'.$date_split[0];
                $date_split = explode('/', $row[4]);
                $formatted_check_in_date = $date_split[2].'/'.$date_split[1].'/'.$date_split[0];
                $check_in = new Datetime($formatted_check_in_date);
                $check_out = new Datetime($formatted_check_out_date);
                $date_diff = $check_out->diff($check_in);
                if(intval($date_diff->d) > intval($sum_recharge_days['recharge_sum'])){
                    $extra = intval($date_diff->d) - intval($sum_recharge_days['recharge_sum']);
                    if($extra == 0){
                        return '<p class="mb-0">Stayed: '.$date_diff->d.' days </p>';
                    }else{
                        return '<p class="mb-0">Stayed: '.$date_diff->d.' days </p>'.'<p class="mb-0 text-danger">Extra: '.$extra.' days </p>';
                    }
                }else{
                    $less = intval($sum_recharge_days['recharge_sum']) - intval($date_diff->d);
                    if($less == 0){
                        return '<p class="mb-0">Stayed: '.$date_diff->d.' days </p>';
                    }else{
                        return '<p class="mb-0">Stayed: '.$date_diff->d.' days </p>'.'<p class="mb-0 text-info">Less: '.$less.' days </p>';
                    }
                }
            }
            
		}
	),
    array( 'db' => 'package_name',   'dt' => 7 ),
	array(
		'db' => 'booking_id',
		'dt' => 8,
		'formatter' => function( $d, $row ) {global $mysqli;
            $pattern = mysqli_fetch_assoc($mysqli->query("SELECT `payment_pattern` from rent_info where booking_id LIKE '".$d."'"));
            if(!is_null($pattern)){
                if($pattern['payment_pattern'] == '0'){
                    return 'Half';
                }else{
                    return 'Full';
                }
            }			
		}
	),
    array(
		'db' => 'booking_id',
		'dt' => 9,
		'formatter' => function( $d, $row ) {global $mysqli;
            // return $d;
            $cancel = mysqli_fetch_assoc($mysqli->query("SELECT `note` from cencel_request where booking_id LIKE '".$d."'"));
            if(!is_null($cancel)){
                // return $cancel['note'];
                if($cancel['note'] == 'Request For Cancel for rental payment issue (auto cancel from software)'){
                    return 'Auto Cancel';
                }else{
                    return 'Cancel';
                }
            }else{
                // return $cancel['note'];
                return 'Occupied';
            }
		}
	),
    array(
		'db' => 'booking_id',
		'dt' => 10,
		'formatter' => function( $d, $row ) {global $mysqli;
            // return $d;
            $uploader = mysqli_fetch_assoc($mysqli->query("SELECT `uploader_info` from booking_info where booking_id LIKE '".$d."'"));
            $employee_email = explode('___',$uploader['uploader_info']);
            $member_info = mysqli_fetch_assoc($mysqli->query("SELECT `full_name` from employee where email LIKE '".$employee_email[1]."'"));
            return $member_info['full_name'];
		}
	),
    array(
		'db' => 'booking_id',
		'dt' => 11,
		'formatter' => function( $d, $row ) {global $mysqli;
            // return $d;
            $check_out_by = mysqli_fetch_assoc($mysqli->query("SELECT `uploader_info` from withdraw_checkout where booking_id LIKE '".$d."'"));
            if(!is_null($check_out_by)){
                $employee_email = explode('___',$check_out_by['uploader_info']);
                $member_info = mysqli_fetch_assoc($mysqli->query("SELECT `full_name` from employee where email LIKE '".$employee_email[1]."'"));
                return $member_info['full_name'];
            }else{
                return 'Not Checked Out Yet';
            }
            
		}
	),
    array(
		'db' => 'booking_id',
		'dt' => 12,
		'formatter' => function( $d, $row ) {global $mysqli;
            $member = mysqli_fetch_assoc($mysqli->query("SELECT `id` from member_directory where booking_id = '".$d."'"));
            if(check_permission('role_1606371205_51')){ 
                $data = '<button onclick="return view_member_profile('.$member['id'].')" type="button" class="btn btn-xs btn-warning" title="View member profile"><i class="fa fa-eye"></i></button>';		
            }
            return $data;
		}
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>