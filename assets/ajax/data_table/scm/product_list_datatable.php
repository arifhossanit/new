<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'scm_products';
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
	array( 
		'db' => 'product_image', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $home;			
            return '<img src="'.$home.$d.'" style="width:100px;"/>';
        }
	),
	array( 'db' => 'product_name', 'dt' => 2 ),
    array( 
        'db' => 'brand_id', 
        'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
            $brand_name = mysqli_fetch_assoc($mysqli->query('SELECT `name` from scm_brands where id = '.$d));
            if($brand_name){
                return $brand_name['name'];
            }else{
                return ' - ';
            }
        } 
    ),
    array( 
        'db' => 'product_category_id', 
        'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
            $category_name = mysqli_fetch_assoc($mysqli->query('SELECT `name` from scm_product_category where id = '.$d));
            return $category_name['name'];
        } 
    ),
    array( 
        'db' => 'product_category_id',
        'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
            $type = mysqli_fetch_assoc($mysqli->query('SELECT scm_product_types.name from scm_product_category INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id where scm_product_category.id = '.$d));
            return $type['name'];
        } 
    ),
    array( 
        'db' => 'id',
        'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
            $departments = $mysqli->query('SELECT department.department_name from department INNER JOIN scm_product_has_department using (department_id) where scm_product_has_department.product_id = '.$d);
            $html = '';
            while($department = mysqli_fetch_assoc($departments)){
                $html .= '<p class="badge badge-primary ml-1 mr-1">'.$department['department_name'].'</p>';
            }
            return $html;
        } 
    ),
    array( 
        'db' => 'scale_id',
        'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
            $scale = mysqli_fetch_assoc($mysqli->query('SELECT `name` from scm_scales where id = '.$d));
            return (is_null($scale)) ? '' : $scale['name'];
        }
    ),
    array( 
        'db' => 'id',
        'dt' => 8,
		'formatter' => function( $d, $row ) {global $home;
            $html = '<div class="row" >
                        <div class="col-sm-2">
                            <abbr title="Add Product Configuration"><button data-toggle="modal" data-target="#add_configuration" class="btn btn-info btn-xs" onclick="add_configuration_ajax(this.value)" value="'.$d.'"><i class="fas fa-plus-circle"></i></button></abbr>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-info btn-xs" onclick="edit_product('.$d.', \''.$row[2].'\')" value=""><i class="far fa-edit"></i></button>
                        </div>
                        <div class="col-sm-2">
                            <form action="'.$home.'admin/scm/add-product/delete" method="post">
                                <input type="hidden" name="product_id" value="'.rahat_encode($d).'">
                                <button class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                    </div>';
            return $html;
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>