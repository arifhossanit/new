<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../application/config/ajax_config.php");

$employee_id = "";
$date_filter = "";

if(isset($_GET['employee_id'])){
	if($_GET['employee_id'] == 'x'){
		$employee_id = "";
	}else{
		$employee_id = " AND employee_id = '".$_GET['employee_id']."'";
	}	
}else{
	$employee_id = "";
}
if(isset($_GET['date_range'])){
	if(!empty($_GET['date_range'])){
		$one = explode(' - ',$_GET['date_range']);	
		$date_from = DateTime::createFromFormat('d/m/Y', $one[0]); 
		$date_to = DateTime::createFromFormat('d/m/Y', $one[1]);
		$date_filter = " AND `updated_at` BETWEEN '".$date_from->format('Y-m-d H:i:s 00:00:01')."' AND '".$date_to->format('Y-m-d 23:59:59')."'";	
	}else{
		$date_filter = "";
	}
}else{
	$date_filter = "";
}
$table = 'employee_petty_cash_overview';
$primaryKey = 'id';
$where = "id IS NOT NULL ".$employee_id.$date_filter;
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array(
        'db'        => 'transection_id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;">'.$d.'</span>';
        }
    ),
	array(
        'db' => 'employee_id','dt' => 2),
	array(
        'db'        => 'withdraw',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>';
        }
    ),
	array(
        'db'        => 'expense',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {		
			return '<p>'.$d.'</p>';
        }
    ),
    array(
        'db'        => 'balance',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>';    
        }
    ),
    array(
		'db' => 'updated_at',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
            $tmp = new DateTime($d);
			return date_format($tmp,"d/m/Y h:i a");	
		}
	)	
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,$where, null)
);
?>