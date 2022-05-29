<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = '(
            SELECT 
                a.id,
                a.driver,
                a.vehicle,
                a.assigned_to,
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
// $where = 'status = 1 AND assigned_to = '.$_SESSION['super_admin']['employee_id'];
// Test
$where = 'status = 1';
$columns = array(
    array(  'db' => 'product_name',
            'dt' => 0,
            'formatter' => function($d, $row){
                return $d . ": " . $row[9];
            }
    ),
    array( 'db' => 'company_name', 'dt' => 1 ),
    array( 'db' => 'agreement_type', 'dt' => 2 ),
    array( 'db' => 'start_date', 'dt' => 3 ),
    array( 
        'db' => 'start_date', 
        'dt' => 4,
        'formatter' => function( $d, $row ) {global $mysqli;
            $start_date = new DateTime($d);
            $today = new DateTime(date("Y-m-d"));
            $date_diff = $start_date->diff($today);
            $today->modify( 'first day of previous month' );
            $get_prev_month_data = mysqli_fetch_assoc($mysqli->query("SELECT `id`, `status` from scm_service_product_billing where `month` = " . (int)$today->format('m')." AND `year` = " . (int)$today->format('Y')));
            if($date_diff->m == 0 AND $date_diff->y == 0){
                $html = 'No Bill';
            }else{
                if(!is_null($get_prev_month_data)){
                    if($get_prev_month_data['status'] == '1'){
                        $html = 'Last month: Waiting Accounts';
                    }else{
                        $html = 'Last month: Paid';
                    }
                }else{
                    $html = 'Last month: Due';
                }
            }
            return $html;
        }
    ),
    array( 
        'db' => 'agreement_type', 
        'dt' => 5,
        'formatter' => function( $d, $row ) {global $mysqli;
            if(strtolower($d) == 'monthly'){
                $html = '<button data-toggle="modal" data-target="#add_bill" class="btn btn-info btn-sm" onclick="add_bill_service(\'monthly\', \''.$row[6].'\')"><i class="fas fa-money-bill"></i></button>';
            }else{
                $html = '<button class="btn btn-info btn-sm" onclick="add_bill_service(\'yearly\', \''.$row[6].'\')"><i class="fas fa-money-bill"></i></button>';
            }
            if($row[8] == 1){
                if($row[7] == 0){
                    $html .= '<button data-toggle="modal" data-target="#driver_history" class="btn btn-secondary btn-sm ml-2" onclick="get_driver_history('.$row[6].')"><i class="fas fa-car"></i></button>';
                }else{
                    $html .= '<button data-toggle="modal" data-target="#driver_history" class="btn btn-info btn-sm ml-2" onclick="get_driver_history('.$row[6].')"><i class="fas fa-car"></i></button>';
                }
            }            
            $html .= '<button data-toggle="modal" data-target="#add_bill" class="btn btn-info btn-xs ml-2" onclick="get_history(\''.$row[0].'\', \''.$row[1].'\', '.$row[6].')"><i class="fas fa-eye"></i></button>';
            return $html;
        }
    ),
    array( 'db' => 'id', 'dt' => 6),
    array( 'db' => 'driver', 'dt' => 7),
    array( 'db' => 'vehicle', 'dt' => 8),
    array( 'db' => 'description', 'dt' => 9),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>