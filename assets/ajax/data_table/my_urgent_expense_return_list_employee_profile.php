<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
$employee_id = " AND employee_id = '".$_SESSION['super_admin']['employee_id']."'";
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
$table = 'advance_petty_cash_return_logs';
$primaryKey = 'id';
$where = "id != '' $employee_id $date_filter";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array(
        'db'        => 'employee_id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {			
			global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			$branch = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$emp['branch']."'"));
			return '<b>'.$emp['full_name'].'</b> - ('.$branch['branch_name'].')';
        }
    ),
	array(
        'db'        => 'amount',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>';
        }
    ),
	array(
        'db'        => 'note',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {		
			return '<p>'.$d.'</p>';
        }
    ),
    array(
		'db' => 'uploader_info',
		'dt' => 4,
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
    array( 'db' => 'data',   'dt' => 5 ),	
    array(
        'db'        => 'id',
        'dt'        => 6,
        'formatter' => function( $d, $row ) { global $mysqli; $data = '';			
			$logs = mysqli_fetch_assoc($mysqli->query("select * from advance_petty_cash_return_logs where id = '".$d."'"));
			if($logs['aproval'] == 2){
				$data .= '<button type="button" class="btn btn-xs btn-danger" style="margin-left:5px;">Rejected!</button>';
			}else{
				if ($logs['aproval'] == 0){
					$data .= '<button type="button" class="btn btn-xs btn-info" style="margin-left:5px;">Pending...!</button>';
					$data .= '<button onclick="return remove_return_request('.$logs['id'].')" type="button" class="btn btn-xs btn-danger" style="margin-left:5px;">Removed</button>';
				}else if ($logs['aproval'] == 1){
					$data .= '<button type="button" class="btn btn-xs btn-success" style="margin-left:5px;"><i class="fas fa-check-square"></i> Approved</button>';
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