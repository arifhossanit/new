<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = '(
            SELECT 
                a.service_product_id,
                a.id,
                a.created_at,
                a.month,
                a.year,
                a.amount,
                a.status,
                a.document,
                creator.full_name as creator_name,
                updator.full_name as updator_name
            from scm_service_product_billing a
            INNER JOIN employee creator on creator.id = a.created_by
            LEFT JOIN employee updator on updator.employee_id = a.update_by
        ) temp';
$primaryKey = 'id';
// $where = 'status = 1 AND assigned_to = '.$_SESSION['super_admin']['employee_id'];
// Test
$where = 'status = 1 AND service_product_id = '.$_GET['history_of'];
$columns = array(
    array( 'db' => 'created_at', 'dt' => 0 ),
    array( 'db' => 'month', 'dt' => 1 ),
    array( 
        'db' => 'year', 
        'dt' => 2,
        'formatter' => function( $d, $row ) {
            $monthNum  = $row[1];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March
            return $monthName.', '.$d;
        }
    ),
    array( 'db' => 'amount', 'dt' => 3 ),
    array( 
        'db' => 'document', 
        'dt' => 4,
        'formatter' => function( $d, $row ) {global $home;
            return '<a href="'.$home.$d.'" target="_blank"><button type="button" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button></a>';
        }
    ),
    array( 
        'db' => 'status', 
        'dt' => 5,
        'formatter' => function( $d, $row ) {
            return $d;
        }
    ),
    array( 
        'db' => 'created_at', 
        'dt' => 6,
        'formatter' => function( $d, $row ) {
            return '';
        }
    ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>