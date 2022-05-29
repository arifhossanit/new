<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'scm_product_category';
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
    array( 'db' => 'name', 'dt' => 1 ),
	array( 
		'db' => 'product_types_id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) {global $mysqli;
            $product_type = mysqli_fetch_assoc($mysqli->query("SELECT `name` FROM `scm_product_types` where id = '".$d."'"));
            return $product_type['name'];
        }
	),
    array( 
		'db' => 'id', 
		'dt' => 3,
		'formatter' => function( $d, $row ) {global $mysqli;global $home;
            $html = '';
            $products_info = $mysqli->query("SELECT scm_product_extra_specification.name from scm_has_product_specification INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_has_product_specification.product_extra_specification_id where scm_has_product_specification.product_category_id = ".$d);
            while($product_info = mysqli_fetch_assoc($products_info)){
                $html .= $product_info['name'].', ';
            }
            $html = rtrim($html,', ');
            return $html;
        }
	), 
    array( 
		'db' => 'status', 
		'dt' => 4,
		'formatter' => function( $d, $row ) {
            if($d == '1'){
                return '<span class="badge badge-primary">Active</span>';
            }else{
                return '<span class="badge badge-danger">Inactive</span>';
            }
        }
	),
    array( 
		'db' => 'id', 
		'dt' => 5,
		'formatter' => function( $d, $row ) {global $mysqli;global $home;
            $product_info = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_category.id, scm_product_category.name, scm_product_category.status, scm_product_types.name as type_name, scm_product_types.id as type_id from scm_product_category INNER JOIN scm_product_types on scm_product_category.product_types_id = scm_product_types.id where scm_product_category.id = ".$d));
            $html = '<div class="row justify-content-center" >
                        <div class="col-sm-4">
                            <abbr title="Add Product Configuration"><button data-toggle="modal" data-target="#add_configuration" class="btn btn-info btn-xs" onclick="add_configuration_ajax(this.value)" value="'.$d.'"><i class="fas fa-plus-circle"></i></button></abbr>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-info btn-xs" onclick="edit_product(this.value)" value="'.$product_info['id'].'~'.$product_info['name'].'~'.$product_info['status'].'~'.$product_info['type_id'].'"><i class="far fa-edit"></i></button>
                        </div>
                        <div class="col-sm-4">
                            <form action="'.$home.'admin/scm/product-category/delete" method="post">
                                <input type="hidden" name="product_id" value="'.$product_info['id'].'">
                                <button class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                    </div>';
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