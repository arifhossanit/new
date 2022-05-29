<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$table = 'electicity_bill';
$primaryKey = 'id';
if(!empty($_GET['room_id'])){	
	$room_id = $_GET['room_id'];
}else{
	$room_id = "";
}
$where = "room_id = '".$room_id."' AND status = 1";
$columns = array(
    array( 'db' => 'id',    'dt' => 0 ),
	array(
        'db'        => 'id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$details = mysqli_fetch_assoc($mysqli->query("select * from electicity_bill where id = '".$d."'"));
			return month_name($details['month']).' '.$details['year'];
		}
    ),
	array(
        'db'        => 'amount',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {			
			return money($d);
		}
    ),
	array(
        'db'        => 'uploader_info',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$u[1]."'"));
					return ''.$emp['full_name'].' | '.$emp['employee_id'].'';
				}
			}
		}
    ),
    array( 'db' => 'data',    'dt' => 4 ),
	array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
			return '<button type="button" onclick="return delete_electricity_bill('.$d.')" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>';
        }
    )
);
$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>