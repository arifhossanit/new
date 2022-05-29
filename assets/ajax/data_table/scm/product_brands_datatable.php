<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'scm_brands';
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
		'db' => 'status', 
		'dt' => 2,
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
		'dt' => 3,
		'formatter' => function( $d, $row ) {global $mysqli; global $home;
            $brand = mysqli_fetch_assoc($mysqli->query("SELECT scm_brands.id,scm_brands.status,scm_brands.name from scm_brands where scm_brands.id = ".$d));
            $html = '<div class="row justify-content-center" >
                        <div class="col-sm">
                            <button data-target="#edit_brand" data-toggle="modal" class="btn btn-info btn-xs" onclick="edit_brand(this.value)" value="'.$brand['id'].'~'.$brand['name'].'~'.$brand['status'].'"><i class="far fa-edit"></i></button>
                        </div>
                        <div class="col-sm">
                            <form action="'.$home.'admin/scm/product-brands/brand-delete" method="post">
                                <input type="hidden" name="brand_id" value="'.$brand['id'].'">
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