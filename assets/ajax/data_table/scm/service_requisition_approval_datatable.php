<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = '(
            SELECT 
                c.id,
                a.description,
                b.name as product_name,
                c.status,
                c.start_date,
                c.end_date,
                c.destination_from,
                c.destination_to,
                c.note,
                c.creation_date,                
                requestor.full_name as requestor_name,
                requestor.photo
            FROM scm_service_product_details a
            INNER JOIN scm_product_category b on b.id = a.product_type_id
            INNER JOIN scm_service_requisition c on c.service_product_id = a.id
            INNER JOIN employee requestor on requestor.employee_id = c.requisition_by
            INNER JOIN employee uploader on uploader.employee_id = c.uploader_info
        ) temp';
$primaryKey = 'id';
$where = '';
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 
        'db' => 'photo', 
        'dt' => 1,
        'formatter' => function( $d, $row ) {global $home;
            return "<img src='".$home.$d."' width='50px'>";
        }
    ),
    array( 
        'db' => 'product_name', 
        'dt' => 2,
        'formatter' => function( $d, $row ) {
            return $d.' - '.$row[12];
        }
    ),
    array( 
        'db' => 'start_date', 
        'dt' => 3,
        'formatter' => function( $d, $row ) {
            $start_date = new DateTime($d);
            return $start_date->format('h:i A');
        }
    ),
    array( 
        'db' => 'end_date', 
        'dt' => 4,
        'formatter' => function( $d, $row ) {
            $end_date =  new DateTime($d);
            return $end_date->format('h:i A');
        } 
    ),
    array( 
        'db' => 'end_date', 
        'dt' => 5,
        'formatter' => function( $d, $row ) {
            $start_date =  new DateTime($row[3]);
            $end_date =  new DateTime($row[4]);
            $date_diff = $start_date->diff($end_date);
            $hours = '';
            if($date_diff->h != '0'){
                $hours .= $date_diff->h." Hour, ";
            }
            if($date_diff->i != '0'){
                $hours .= $date_diff->i." Minute, ";
            }
            $hours = rtrim($hours, ', ');
            return $hours;
        } 
    ),
    array( 'db' => 'destination_from', 'dt' => 6 ),
    array( 'db' => 'destination_to', 'dt' => 7 ),
    array( 'db' => 'note', 'dt' => 8 ),
    array( 'db' => 'requestor_name', 'dt' => 9 ),
    array( 
        'db' => 'creation_date', 
        'dt' => 10,
        'formatter' => function( $d, $row ) {
            $creation_date =  new DateTime($d);
            return $creation_date->format('d-m-Y h:i:s A');
        }
    ),    
    array( 
        'db' => 'status', 
        'dt' => 11,
        'formatter' => function( $d, $row ) {
            $button = '<div class="btn-group">';
            if($d == 1){
                $button .= '<button data-target="#service_approval" data-toggle="modal" title="Approve" class="btn btn-xs btn-info" onclick="service_product_approval(\'approve\', '.$row[0].')"><i class="fas fa-check-circle mr-1"></i>Approve</button>';
                $button .= '<button data-target="#service_approval" data-toggle="modal" title="Reject" class="btn btn-xs btn-danger" onclick="service_product_approval(\'reject\', '.$row[0].')"><i class="fas fa-times-circle mr-1"></i>Reject</button>';
            }
            $button .= '</div>';
            return $button;
        }
    ),
    array( 'db' => 'description', 'dt' => 12 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>