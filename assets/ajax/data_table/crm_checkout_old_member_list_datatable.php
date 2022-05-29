<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'old_member_directory';
$primaryKey = 'id';

$where = ""; 
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'branch', 'dt' => 1 ),
    array( 'db' => 'card_no', 'dt' => 2 ),    
    array( 'db' => 'name',  'dt' => 3 ),
    array( 'db' => 'phone',  'dt' => 4 ),
    array( 'db' => 'bed',     'dt' => 5 ),
    array( 
		'db' => 'check_in',
		'dt' => 6,
		'formatter' => function($d, $row){
			$date = new DateTime($d);
			return $date->format('d F, Y : h:i a');
		} 
	),
    array( 
		'db' => 'check_out',
		'dt' => 7,
		'formatter' => function($d, $row){
			$date = new DateTime($d);
			return $date->format('d F, Y : h:i a');
		} 
	),
    array( 'db' => 'package',     'dt' => 8 ),
    array( 'db' => 'security_deposit',     'dt' => 9 ),	
    array( 
		'db' => 'file',
		'dt' => 10,
		'formatter' => function($d, $row){global $home;
            $html = '';
            if($row[9] == 0){                
                $html .= '<button onclick="old_member_payment_info('.$row[0].', \''.$row[3].'\')" data-target="#old_member_payment" data-toggle="modal" class="btn btn-primary btn-xs mr-2">Give Deposit</button>';
            }else{
                if($row[11] == 1){
                    $html .= '<badge class="badge badge-success mr-2">Rechecked</badge>';
                }else if($row[11] == 2){
                    $html .= '<badge class="badge badge-warning mr-2">Deposit Returned</badge>';
                }
            }

            if(!empty($d)){
                $html .= '<a class="btn btn-info btn-xs" role="button" href="'.$home . $d .'"><i class="far fa-file"></i> File</>';
            }

            return $html;
		} 
	),
    array('db' => 'status', 'dt' => 11)
);
 

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>