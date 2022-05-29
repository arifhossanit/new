<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'missing_attendance_logs';
$primaryKey = 'id';
$where = "";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 
		'db' => 'employee_id', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { 			
			global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			if(!empty($emp['employee_id'])){
				return $emp['full_name'].' - '.$emp['employee_id'];
			}else{
				return '';
			}			
		}
	),
    array( 'db' => 'attendance_date', 'dt' => 2 ),
	array( 
		'db' => 'uploader_info', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { 			
			global $mysqli;
			$email = explode("___",$d);
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$email[1]."'"));
			if(!empty($emp['employee_id'])){
				return $emp['full_name'];
			}else{
				return '';
			}			
		}
	),
    array( 'db' => 'data',  'dt' => 4 ),
	array( 
		'db' => 'note', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { 			
			if(!empty($d)){
				return '<marquee style="width:100px;">'.$d.'</marquee>';
			}else{
				return '';
			}			
		}
	)   
);
 

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>