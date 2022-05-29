<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = '(
            SELECT 
                a.id,
                a.agreement_type,
                a.status,
                a.description,
                a.start_date,
                a.created_at,
                a.uploader_info,
                d.company_name,
                b.name as product_name,
                c.full_name as employee_name,
                c.employee_id,
                e.full_name as uploader_name
            FROM scm_service_product_details a
            INNER JOIN scm_product_category b on b.id = a.product_type_id
            INNER JOIN employee c on c.id = a.assigned_to
            INNER JOIN scm_vendor d on d.id = a.vendor_id
            INNER JOIN employee e on e.employee_id = a.uploader_info
        ) temp';
$primaryKey = 'id';
$where = 'status = 1';
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'product_name', 'dt' => 1 ),
    array( 'db' => 'company_name', 'dt' => 2 ),
    array( 'db' => 'employee_name', 'dt' => 3 ),
    array( 'db' => 'start_date', 'dt' => 4 ),
    array( 'db' => 'agreement_type', 'dt' => 5 ),
    array( 'db' => 'description', 'dt' => 6 ),
    array( 'db' => 'uploader_name', 'dt' => 7 ),
    array( 
        'db' => 'created_at', 
        'dt' => 8,
        'formatter' => function( $d, $row ) {
            return '<p class="m-0 p-0">'.$row[7].'</p><p class="m-0 p-0">'.$d.'</p>';
        }
    ),    
    array( 'db' => 'uploader_name', 'dt' => 9 ),    
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>