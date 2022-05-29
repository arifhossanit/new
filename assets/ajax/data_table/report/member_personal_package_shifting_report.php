<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'package_change_info';
$primaryKey = 'id';
$where = "booking_id = '".rahat_decode($_GET['member_id'])."'";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array(
		'db' => 'old_category',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$d."'"));
			return '<button type="button" class="btn btn-sm btn-danger">'.$bed['package_category_name'].'</button>';		
		}
	),
	array(
		'db' => 'old_package',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$d."'"));
			return '<button type="button" class="btn btn-sm btn-danger">'.$bed['package_name'].'</button>';	
		}
	),
	array(
		'db' => 'new_category',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$d."'"));
			return '<button type="button" class="btn btn-sm btn-success">'.$bed['package_category_name'].'</button>';		
		}
	),
	array(
		'db' => 'new_package',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$d."'"));
			return '<button type="button" class="btn btn-sm btn-success">'.$bed['package_name'].'</button>';		
		}
	),
	array( 'db' => 'changed_date',   'dt' => 5 ),
	array( 'db' => 'data',   'dt' => 6 ),
    array(
		'db' => 'uploader_info',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			if(!empty($d)){
				$info = explode('___',$d);
				if(!empty($info[1])){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$info[1]."'"));
					return $emp['full_name'].'-'.$emp['employee_id'];
				}else{
					return '';
				}				
			}else{
				return '';
			}	
		}
	),
	array( 
		'db' => 'shifting_transaction_id',
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			// if($d != ''){
				return '<button type="button" class="btn btn-info btn-xs" onclick="get_shifting_receipt('.$row[0].')"> <i class="fas fa-eye"></i> Receipt</button>';
			// }
		}
	),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>