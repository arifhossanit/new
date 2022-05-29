<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");


$date = (isset($_GET['date'])) ? $_GET['date'] : '';
$branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
$item = (isset($_GET['item'])) ? $_GET['item'] : '';

$get_branch_name = mysqli_fetch_assoc($mysqli->query("select branch_name from branches where branch_id like '%".$branch."%' limit 1 "));
$branch = $get_branch_name['branch_name'];
// var_dump($item);


$table = 'item_stocks';
$primaryKey = 'id';
if(!empty($date)){
	$date_explode = explode(' - ',$date);
	$start_date = DateTime::createFromFormat('d/m/Y H:i:s', $date_explode[0]." 00:00:00");				
	$end_date = DateTime::createFromFormat('d/m/Y H:i:s', $date_explode[1]." 23:59:59");
}else{
	$start_date = new DateTime();				
	$end_date = new DateTime();
}
$condition = "";
if(!empty($item)){
	$condition = " AND product_name like '%".$item."%'";
}
$where = "branch_name like '%".$branch."%' AND updated_at BETWEEN '".$start_date->format('Y-m-d H:i:s')."' AND '".$end_date->format('Y-m-d H:i:s')."'" . $condition;
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	// array( 
	// 	'db' => 'product_image', 
	// 	'dt' => 1,
	// 	'formatter' => function( $d, $row ) { global $home;			
    //         return '<img src="'.$home.$d.'" style="width:100px;"/>';
    //     }
	// ),
    array( 'db' => 'branch_name', 'dt' => 1 ),
	array( 'db' => 'product_name', 'dt' => 2 ),
	array( 'db' => 'initial_quantity', 'dt' => 3 ),
	array( 'db' => 'remaining_quantity', 'dt' => 4 ),
	array( 'db' => 'created_at', 'dt' => 5,
        'formatter' => function($d,$row){
            //global $home;
            return date('d-M-Y',strtotime($d));
        }
 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>