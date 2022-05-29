<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'employee_grant_loan';
$primaryKey = 'id';
$month_filter = new DateTime(date($_GET['month_filter'] . '-01'));
$where = "STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '".$month_filter->format('Y-m-d')."' AND '".$month_filter->format('Y-m-t')."'";
$columns = array(
	array( 
		'db' => 'e_db_id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return '<img src="'.$home.$emp['photo'].'" style="width:50px;"/>';
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $emp['full_name'].' - '.$emp['employee_id'];
		}
	),
	array( 
		'db' => 'e_db_id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $emp['department_name'];
		}
	),
	array( 
		'db' => 'amount', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			return '<b style="color:green;">'.money($d).'</b>';
		}
	),
	array( 
		'db' => 'uploader_info', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else if($d == 2){
				return '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
			}			
		}
	),
	array( 
		'db' => 'aproval_account', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($row[5] == '2'){
				return '';
			}
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else if($d == 2){
				return '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
			}			
		}
	),
	array( 
		'db' => 'data', 
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			return DateTime::createFromFormat('d/m/Y', $d)->format('d F, Y');
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($d == '0'){
				return '';
			}

			$approval = mysqli_fetch_assoc($mysqli->query("SELECT `data` from employee_loan_aproval where grant_loan_id = ".$row[10]." ORDER BY id asc limit 1"));
			return (is_null($approval)) ? '-' : DateTime::createFromFormat('d/m/Y', $approval['data'])->format('d F, Y');
			// return DateTime::createFromFormat('d/m/Y', $approval['data'])->format('d F, Y');
		}
	),
	array( 
		'db' => 'aproval_account', 
		'dt' => 9,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($d == '0'){
				return '';
			}

			$approval = mysqli_fetch_assoc($mysqli->query("SELECT `data`, id from employee_loan_aproval where grant_loan_id = ".$row[10]." ORDER BY id desc limit 1"));
			return DateTime::createFromFormat('d/m/Y', $approval['data'])->format('d F, Y');			
		}
	),
    array( 
		'db' => 'id', 
		'dt' => 10,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_grant_loan where id = '".$d."'"));
			
			if($info['aproval_account'] == 1 OR $info['aproval_account'] == 2){
				$buttons = '';
			}else{
				$buttons = '
					<form action="#" method="POST">
						<button onclick="return loan_accept_function('.$d.')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button>
						<button onclick="return loan_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>
					</form>
				';
			}
			if($info['aproval'] == 1){
				return $buttons;
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