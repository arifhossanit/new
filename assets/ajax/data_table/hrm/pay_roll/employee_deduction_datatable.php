<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
include("../../../../../application/config/ajax_config.php");

$table = '(
			SELECT 
				a.e_db_id,
				a.amount,
				a.id,
				a.reason,
				a.aproval,
				a.uploader_info,
				a.data,
				b.full_name,
				b.employee_id
			FROM employee_sallary_deduction a
			INNER JOIN employee b ON a.e_db_id = b.id
		) temp';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 
		'db' => 'full_name', 
		'dt' => 0,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d . ' - '.$row[8];
		}
	),
	array( 
		'db' => 'amount', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			return '<b style="color:red;">'.money($d).'</b>';
		}
	),
    array( 
		'db' => 'id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_sallary_deduction where id = '".$d."'"));
			return month_name($info['month']).' - '.$info['year'];
		}
	),
	array( 'db' => 'reason',   'dt' => 3 ),
	array( 
		'db' => 'aproval', 
		'dt' => 4,
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
		'db' => 'uploader_info', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 'db' => 'data',   'dt' => 6 ),
    array( 
		'db' => 'id', 
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_sallary_deduction where id = '".$d."'"));
			$confirm = "'Are you sure?'";
			if($info['aproval'] == 1 OR $info['aproval'] == 2){
				$buttons = '';
			}else{
				$buttons = '
					<form action="'.$home.'admin/hrm/payroll/employee-salary-deduction" method="POST">
						<input type="hidden" name="hidden_id" value="'.$d.'"/>
						<button onclick="confirm('.$confirm.')" name="remove_deduction" type="submit" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Remove</button>
					</form>
				';
			}			
			return $buttons;
		}
	),
	array( 'db' => 'employee_id',   'dt' => 8 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>