<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
if(isset($_GET['employee_id'])){
	if($_GET['employee_id'] == 'x'){
		$employee_id = "";
	}else{
		$employee_id = " AND employee_id = '".$_GET['employee_id']."'";
	}	
}else{
	$employee_id = "";
}
if(isset($_GET['date_range'])){
	if(!empty($_GET['date_range'])){
		$one = explode(' - ',$_GET['date_range']);	
		$date_from = $one[0];
		$date_to = $one[1];	
		$date_filter = " AND data >= '$date_from' AND data <= '$date_to'";
	}else{
		$date_filter = "";
	}
}else{
	$date_filter = "";
}
$table = 'advance_transaction_logs';
$primaryKey = 'id';

$where = "status = '1' $employee_id $date_filter";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array(
        'db'        => 'transaction_id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;">'.$d.'</span>';
        }
    ),
	array(
        'db'        => 'employee_id',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {			
			global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			$branch = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$emp['branch']."'"));
			return '<b>'.$emp['full_name'].'</b> - ('.$branch['branch_name'].')';
        }
    ),
	array(
        'db'        => 'amount',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>';
        }
    ),
	array(
        'db'        => 'note',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {		
			return '<p>'.$d.'</p>';
        }
    ),
    array(
		'db' => 'uploader_info',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			global $mysqli;			
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE email = '".$u[1]."'"));
					return ''.$emp['full_name'].'';
				}
			}	
		}
	),
    array( 'db' => 'data',   'dt' => 6 ),	
    array(
        'db'        => 'id',
        'dt'        => 7,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$data = '';			
			$logs = mysqli_fetch_assoc($mysqli->query("select * from advance_transaction_logs where id = '".$d."'"));
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$logs['employee_id']."'"));
			$transaction_id = "'".$logs['transaction_id']."'";
			$money = "'".$logs['amount']."'";
			$name = "'".$emp['full_name']."'";
			$data .= '<button onclick="return view_buied_iteams('.$transaction_id .')" type="button" class="btn btn-xs btn-info">View Iteams</button>';
			/* if($logs['approval'] == 0){
				if(check_permission('role_1613903537_70')){
					$data .= '<button onclick="return purses_item_approved('.$transaction_id .','.$money.','.$name.')" type="button" class="btn btn-xs btn-warning" style="margin-left:5px;">Approved It!</button>';
				}
			}else */ 
			if($logs['approval'] == 3){
				$data .= '<button type="button" class="btn btn-xs btn-danger" style="margin-left:5px;">Rejected!</button>';
			}else{
				if ($logs['approval'] == 0){
					$data .= '<button type="button" class="btn btn-xs btn-success" style="margin-left:5px;"><i class="fas fa-check-square"></i></button>';
					if(check_permission('role_1613903537_29')){
						$data .= '<button  onclick="return purses_item_checkit('.$transaction_id .','.$money.','.$name.')" type="button" class="btn btn-xs btn-success" style="margin-left:5px;">Approved It!</button>';
						$data .= '<button  onclick="return purses_item_checkit_reject('.$transaction_id .','.$money.','.$name.')" type="button" class="btn btn-xs btn-danger" style="margin-left:5px;">Reject It!</button>';
					}
				}else if ($logs['approval'] == 2){
					$data .= '<button type="button" class="btn btn-xs btn-success" style="margin-left:5px;" title="Auto Boss Aproval Checked!"><i class="fas fa-check-square"></i></button>';
					$data .= '<button type="button" class="btn btn-xs btn-primary" style="margin-left:5px;" title="Account Aproval Checked!"><i class="fas fa-check-square"></i></button>';
				}
			}
			
			
			return $data;
        }
    )	
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>