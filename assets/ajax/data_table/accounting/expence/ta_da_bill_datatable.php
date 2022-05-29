<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'transaction';
$primaryKey = 'id';
if(isset($_GET['branch_id'])){
	if($_GET['branch_id'] == 1){
		$branch_id = "";
	}else{
		$branch_id = " AND branch_id = '".$_GET['branch_id']."'";
	}	
}else{
	$branch_id = "";
}
if(isset($_GET['department_id'])){
	if($_GET['department_id'] == 1){
		$department_id = "";
	}else{
		$department_id = " AND note in (select employee_id from employee where department = '".$_GET['department_id']."')";
	}	
}else{
	$department_id = "";
}
if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);	
	$one_ymd = explode('/',$one[0]);
	$two_ymd = explode('/',$one[1]);
	$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
	$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
	$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
}else{
	$date_filter = "";
}
$where = "transaction_category = 'TD/DA Return Account' $branch_id $date_filter $department_id";
$columns = array(
	array( 
		'db' => 'id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'transaction_id', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
		}
	),
	array( 
		'db' => 'branch_id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$d."'"));
			return $info['branch_name'];
		}
	),
	array( 
		'db' => 'note', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $info['department_name'];
		}
	),
	array( 
		'db' => 'note', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $info['designation_name'];
		}
	),
	array( 
		'db' => 'careof', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
		}
	),
	array( 
		'db' => 'amount', 
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			return '<b style="color:#f00;">'.money($d).'</b>';
		}
	),
	array( 
		'db' => 'date', 
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'transaction_type', 
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'uploader_info', 
		'dt' => 9,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>