<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = '(
            SELECT 
                g.note,
                g.id,
                a.warrenty_expiry,
                b.product_name,
                d.product_types_id as type_id,
                d.name as type_name,
                c.received_date,
                c.vendor_id,
                b.scale_id,
                f.received_date as food_received_date,
                g.amount as damaged_amount,
                g.status,
                a.purchase_order_id,
                a.id as order_details_id
            FROM scm_damaged_goods g
            INNER JOIN scm_product_order_details a  on g.purchase_pk = a.id
            INNER JOIN scm_products b ON a.product_id = b.id
            LEFT JOIN scm_purchase_order c ON c.purchase_order_id = a.purchase_order_id
            INNER JOIN scm_product_category d ON b.product_category_id = d.id
            INNER JOIN scm_pre_purchase_order f ON f.purchase_order_id = a.pre_purchase_order_id
        ) temp';
$primaryKey = 'id';

// if(!empty($_GET['user_type'])){
// 	if($_GET['user_type'] == rahat_encode('Super Admin') OR $_GET['user_type'] == rahat_encode('Accounts')){
// 		$branch_user = "";
// 	}else{
// 		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND ";
// 	}
// }else{
// 	$branch_user = "";
// }


// $where = "".$branch_user." status = '3' AND note = ''";\
// if($_SESSION['super_admin'] != '2805597208697462328'){
//     $where = " department_requested_for = '".$_SESSION['user_info']['department']."'";
// }else{
    // $where = 'product_status = 3 AND stock_amount > 0 AND department_requested_for = \''.$_SESSION['user_info']['department'].'\'';
    $where = 'status = 1';
// }
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'type_name', 'dt' => 1 ),
    array( 
        'db' => 'product_name', 
        'dt' => 2,
        'formatter' => function( $d, $row ) {
            return $row[1].' - '.$d;
        }
    ),    
    array( 
        'db' => 'damaged_amount',
        'dt' => 3,
        'formatter' => function( $d, $row ) {global $mysqli;
            $scale = mysqli_fetch_assoc($mysqli->query("SELECT `name` from scm_scales where id = '".$row[6]."'"));
            return $d.' '.$scale['name'];
        }
    ),
    array( 
        'db' => 'vendor_id',
        'dt' => 4,
        'formatter' => function( $d, $row ) {global $mysqli;
            if(!is_null($d)){
                $vendor = mysqli_fetch_assoc($mysqli->query("SELECT `company_name` from scm_vendor where id = '".$d."'"));
                if($vendor){
                    return $vendor['company_name'];
                }else{
                    return ' - ';
                }
            }            
        }
    ),
    array( 
        'db' => 'warrenty_expiry', 
        'dt' => 5,
        'formatter' => function( $d, $row ) {global $mysqli;
            $warrenty = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `scm_product_warremty` where id = '".$d."'"));
            $html = 'No Warrenty Available';
            if($row[7] == 3){
                if(!is_null($warrenty)){
                    $recive_date = new DateTime($row[8]);     
                    $warrenty_end_date = new DateTime($row[8]);
                    $date_string = 'P'.$warrenty['service_warrenty_years'].'Y'.$warrenty['service_warrenty_months'].'M'.$warrenty['service_warrenty_months'].'D';
                    $warrenty_end_date->add(new DateInterval($date_string));
                    // return $date_string.' | '.$warrenty_end_date->format('Y-m-d');
                    // $interval = $warrenty_end_date->diff($recive_date);
                    // return $interval->m;
                    if($warrenty_end_date > $recive_date){
                        $interval = $warrenty_end_date->diff($recive_date);
                        $html = ($interval->y != '0') ? $interval->y.' year, ' : '';
                        $html .= ($interval->m != '0') ? $interval->m.' month, ' : '';
                        $html .= ($interval->d != '0') ? $interval->d.' day, ' : '';
                        $html = rtrim($html, ', ');
                    }
                }                
            }
            return $html.'.';
        }
    ),
    array( 'db' => 'scale_id', 'dt' => 6 ),
    array( 'db' => 'type_id', 'dt' => 7 ),
    array( 
        'db' => 'food_received_date',
        'dt' => 8,
        'formatter' => function( $d, $row ) {
            if($row[7] == '5'){
                return $d;
            }else{
                return $row[12];
            }
        }
    ),
    array( 
        'db' => 'purchase_order_id',
        'dt' => 9,
        'formatter' => function( $d, $row ) {
            if($row[7] == '5'){
                return ' - ';
            }else{
                return $d;
            }
        }
    ),
    array( 'db' => 'note', 'dt' => 10 ),
    array( 
        'db' => 'order_details_id', 
        'dt' => 11,
        'formatter' => function( $d, $row ) {global $mysqli;
            $html = '<div class="row">
                        <div class="col-sm-8 pl-0 pr-0">
                            <div class="dropdown">
                                <button class="btn btn-warning btn-xs dropdown-toggle" id="actionDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;">Action</button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropDown">
                                    <a data-toggle="modal" data-target="#damaged_goods" class="dropdown-item" href="#" onclick="damaged_product_modal(\'claim_warrenty\', '.$d.', '.$row[3].', '.$row[0].', '.$row[7].')">Claim Warrenty</a>
                                    <a data-toggle="modal" data-target="#damaged_goods" class="dropdown-item" href="#" onclick="damaged_product_modal(\'repair_in_house\', '.$d.', '.$row[3].', '.$row[0].', '.$row[7].')">Repair In-house</a>
                                    <a data-toggle="modal" data-target="#damaged_goods" class="dropdown-item" href="#" onclick="damaged_product_modal(\'repair_outside\', '.$d.', '.$row[3].', '.$row[0].', '.$row[7].')">Repair From Vendor</a>
                                    <a class="dropdown-item" href="#" onclick="out_of_order('.$row[0].')">Out of order</a>
                                </div>
                            </div>
                        </div>';
            if($row[7] == '3'){
                $html .= '<div class="col-sm-4 pl-0 pr-0">
                              <abbr title="Show Barcodes"><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#product_details" onclick="show_product_details(\''.$row[2].'\', \''.rahat_encode($row[0]).'\')"><i class="fas fa-eye"></i></button></abbr>
                          </div>';
                        //   <abbr title="Show Barcodes"><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#product_details" onclick="show_product_details(\''.rahat_encode('scm_damaged_goods').'\', \''.rahat_encode($row[0]).'\')"><i class="fas fa-eye"></i></button></abbr>
            }            
            $html .= '</div>';
            return $html;
        }
    ),
    array( 'db' => 'received_date', 'dt' => 12 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>