<?php 
// $file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
// if ( is_file( $file ) ) {
// 	include( $file );
// }
include("../../../../application/config/ajax_config.php");
$table = 'investor_facilities_setup';
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
        $date_filter = " AND data BETWEEN '$date_from' AND '$date_to'";
    }else{
        $date_filter = " AND data BETWEEN '$today' AND '$today'";
    }
}else{
	$date_filter = "";
}

$where = "status = 1".$date_filter;
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'card_no',
		'dt' => 1,
		'formatter' => function( $d, $row ) {global $mysqli;
            $ipo = mysqli_fetch_assoc($mysqli->query("SELECT `personal_full_name` from ipo_member_directory where card_number = '".$d."'"));
            return $ipo['personal_full_name'];		
		}
	),
    array( 'db' => 'card_no',   'dt' => 2 ),
    array( 'db' => 'tea_coffee',   'dt' => 3 ),
    array( 'db' => 'drinks',   'dt' => 4 ),
    array(
		'db' => 'id',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
            return '<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#investor_modal" onclick="get_investor_details(\''.$d.'\')"><i class="fas fa-eye"></i></button>';
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>