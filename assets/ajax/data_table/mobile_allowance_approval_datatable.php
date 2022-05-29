<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$department = '';
if($_SESSION['super_admin']['user_type'] != "Super Admin"){
    $department = "department = '".$_SESSION['user_info']['department']."'";
}

$table = '(
            SELECT 
                a.id,
                a.employee_id,
                a.requested_amount,
                a.approved_amount,
                a.creation_date,
                a.status,
                a.note,
                b.full_name,
                b.department,
                b.photo
            from increase_mobile_allowance a
            INNER JOIN employee b USING(employee_id)
        ) temp';
$primaryKey = 'id';
// $where = 'status = 1 AND assigned_to = '.$_SESSION['super_admin']['employee_id'];
// Test
$where = '' . $department;
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 
        'db' => 'photo', 
        'dt' => 1,
        'formatter' => function( $d, $row ) {global $home;
            return '<img src="'.$home . $d.'" width="60px" height="60px" style="border-radius: 5px">';
        }
    ),
    array( 'db' => 'full_name', 'dt' => 2 ),
    array( 
        'db' => 'requested_amount', 
        'dt' => 3,
        'formatter' => function( $d, $row ) {
            return money($d);
        }
    ),
    array( 
        'db' => 'approved_amount', 
        'dt' => 4,
        'formatter' => function( $d, $row ) {
            return money($d);
        }
    ),
    array( 
        'db' => 'creation_date', 
        'dt' => 5,
        'formatter' => function( $d, $row ) {global $home;
            return $d;
        }
    ),
    array( 
        'db' => 'status', 
        'dt' => 6,
        'formatter' => function( $d, $row ) {
            switch($d){
                case 0:
                    return '<badge class="badge badge-warning">Pendign DH</badge>';
                case 1:
                    return '<badge class="badge badge-info">Pendign Boss</badge>';
                case 2:
                    return '<badge class="badge badge-danger">Rejected DH</badge>';
                case 3:
                    return '<badge class="badge badge-success">Approved</badge>';
                case 4:
                    return '<badge class="badge badge-danger">Rejected Boss</badge>';
            }
        }
    ),
    array( 
        'db' => 'note', 
        'dt' => 7,
        'formatter' => function( $d, $row ) {
            return $d;
        }
    ),
    array( 
        'db' => 'department', 
        'dt' => 8,
        'formatter' => function( $d, $row ) {global $mysqli;
            if($row[6] == 0){
                if($_SESSION['user_info']['department'] == $d AND $_SESSION['user_info']['d_head']){
                    return '<button onclick="approval_modal('.$row[0].', \'head\', \'accept\', '.$row[4].')" class="btn btn-info btn-xs"><i class="fas fa-check-circle"></i> Approve</button>                    
                            <button onclick="approval_modal('.$row[0].', \'head\', \'reject\', '.$row[4].')" class="btn btn-danger btn-xs"><i class="far fa-times-circle"></i> Reject</button>';
                }
            }

            if($row[6] == 1){
                $approval_log = mysqli_fetch_assoc($mysqli->query("SELECT employee.d_head_reporting FROM `increase_mobile_allowance_approval_logs` INNER JOIN employee using(employee_id) where mobile_allowence_id = ".$row[0]));
                if($approval_log['d_head_reporting'] == $_SESSION['super_admin']['employee_id']){
                    return '<button onclick="approval_modal('.$row[0].', \'boss\', \'accept\', '.$row[4].')" class="btn btn-info btn-xs"><i class="fas fa-check-circle"></i> Approve</button>                    
                            <button onclick="approval_modal('.$row[0].', \'boss\', \'reject\', '.$row[4].')" class="btn btn-danger btn-xs"><i class="far fa-times-circle"></i> Reject</button>';
                }
            }
        }
    ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>