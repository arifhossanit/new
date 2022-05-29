<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'scm_purchase_order';
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
$where = '';
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'purchase_order_id', 'dt' => 1 ),
    array( 'db' => 'order_date', 'dt' => 2 ),
	array( 
		'db' => 'vendor_id', 
		'dt' => 3,
		'formatter' => function( $d, $row ) {global $mysqli;
            $vendor = mysqli_fetch_assoc($mysqli->query("SELECT `company_name` from scm_vendor where id = '".$d."'"));
            return (is_null($vendor) ? '<span class="text-secondary">Vendor Does Not Exists!</span>' : $vendor['company_name']);
        }
	),
    array( 
		'db' => 'purchase_order_id', 
		'dt' => 4,
		'formatter' => function( $d, $row ) {global $mysqli;
            $total_price = mysqli_fetch_assoc($mysqli->query("SELECT sum(unit_price * requested_amount) as total_sum from scm_product_order_details where purchase_order_id = '".$d."'"));
            return money($total_price['total_sum']);
        }
	),
    array(
        'db' => 'status',
        'dt' => 5 ,
        'formatter' => function( $d, $row ) {
            if($d == '0'){
                return '<span class="badge badge-warning">Not Received</span>';
            }else if($d == '1'){
                return '<span class="badge badge-success">Received</span>';
            }
        }
    ),
	array( 
		'db' => 'purchase_order_id', 
		'dt' => 6,
		'formatter' => function( $d, $row ) {global $mysqli;
            // $vendor = mysqli_fetch_assoc($mysqli->query("SELECT `status` from scm_pre_purchase_order where purchase_order_id = '".$d."'"));
            $html = '';
            // if($vendor['status'] == 'boss_approved'){
            //     $html .= '<abbr title="Add Vendor"><button data-target="#add_vendor" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="add_vendor(this.value)" value="'.$d.'"><i class="fas fa-user-plus"></i></button></abbr>';
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="show_approved_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }else if($vendor['status'] == 'vendor_assigned'){
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="show_approved_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }else{
            //     $html .= '<abbr title="Show Products"><button data-target="#show_products" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_products(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button></abbr>';
            // }
            $html .= '<button data-target="#show_receipt" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_receipt(this.value)" value="'.$d.'"><i class="fas fa-eye"></i></button>';
            if($row[5] == '0'){
                $html .= '<button data-target="#product_receive" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="receive_product(this.value, \'not_received\')" value="'.$d.'"><i class="fas fa-cart-arrow-down"></i></button>';
            }else if($row[5] == '1'){
                $html .= '<button data-target="#product_receive" data-toggle="modal" class="btn btn-success btn-xs mr-1" onclick="receive_product(this.value, \'received\')" value="'.$d.'"><i class="fas fa-check"></i></button>';
            }
            return $html;
        }
	), 
    // array( 
    //     'db' => 'brand_id', 
    //     'dt' => 3,
	// 	'formatter' => function( $d, $row ) { global $mysqli;
    //         $brand_name = mysqli_fetch_assoc($mysqli->query('SELECT `name` from scm_brands where id = '.$d));
    //         if($brand_name){
    //             return $brand_name['name'];
    //         }else{
    //             return ' - ';
    //         }
    //     } 
    // ),
    // array( 
    //     'db' => 'product_category_id', 
    //     'dt' => 4,
	// 	'formatter' => function( $d, $row ) { global $mysqli;
    //         $category_name = mysqli_fetch_assoc($mysqli->query('SELECT `name` from scm_product_category where id = '.$d));
    //         return $category_name['name'];
    //     } 
    // ),
    // array( 
    //     'db' => 'product_category_id',
    //     'dt' => 5,
	// 	'formatter' => function( $d, $row ) { global $mysqli;
    //         $type = mysqli_fetch_assoc($mysqli->query('SELECT scm_product_types.name from scm_product_category INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id where scm_product_category.id = '.$d));
    //         return $type['name'];
    //     } 
    // ),
    // array( 
    //     'db' => 'id',
    //     'dt' => 6,
	// 	'formatter' => function( $d, $row ) { global $mysqli;
    //         $departments = $mysqli->query('SELECT department.department_name from department INNER JOIN scm_product_has_department using (department_id) where scm_product_has_department.product_id = '.$d);
    //         $html = '';
    //         while($department = mysqli_fetch_assoc($departments)){
    //             $html .= '<p class="badge badge-primary ml-1 mr-1">'.$department['department_name'].'</p>';
    //         }
    //         return $html;
    //     } 
    // ),
    // array( 
    //     'db' => 'scale_id',
    //     'dt' => 7,
	// 	'formatter' => function( $d, $row ) { global $mysqli;
    //         $scale = mysqli_fetch_assoc($mysqli->query('SELECT `name` from scm_scales where id = '.$d));
    //         return $scale['name'];
    //     } 
    // ),
    // array( 'db' => 'id',  'dt' => 8 )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>