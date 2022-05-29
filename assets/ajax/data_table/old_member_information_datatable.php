<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'old_members';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'name',   'dt' => 1 ),
    array( 'db' => 'phone_number',   'dt' => 2 ),
    array( 'db' => 'status',   'dt' => 3 ),
    array( 'db' => 'card_no',   'dt' => 4 ),	
    array( 'db' => 'checkIn',   'dt' => 5 )	
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>