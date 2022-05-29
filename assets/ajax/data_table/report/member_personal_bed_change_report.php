<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'bed_change_info';
$primaryKey = 'id';
$where = "booking_id = '".rahat_decode($_GET['member_id'])."'";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array(
		'db' => 'before_bed',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$d."'"));
			if(!empty($bed['bed_name'])){
				return '<button type="button" class="btn btn-sm btn-danger">'.$bed['bed_name'].'</button>';		
			}else{
				return 'NULL';
			}
			
		}
	),
	array(
		'db' => 'current_bed',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$d."'"));
			return '<button type="button" class="btn btn-sm btn-success">'.$bed['bed_name'].'</button>';	
		}
	),
	array( 'db' => 'change_date',   'dt' => 3 ),
	array( 'db' => 'data',   'dt' => 4 ),
    array(
		'db' => 'uploader_info',
		'dt' => 5,
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
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>