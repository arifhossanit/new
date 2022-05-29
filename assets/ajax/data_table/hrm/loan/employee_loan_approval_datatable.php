<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = '(
		SELECT 
			a.e_db_id,
			a.id,
			a.amount,
			a.note,
			a.aproval,
			a.data,
			b.full_name,
			b.employee_id,
			c.branch_name,
			b.department_name,
			b.department,
			b.designation_name
		from employee_grant_loan a
		INNER JOIN employee b on b.id = a.e_db_id
		INNER JOIN branches c on c.branch_id = b.branch
	) temp';
$primaryKey = 'id';
$department_filter = "";

if($_SESSION['super_admin']['user_type'] != 'Super Admin'){

	$department_filter = " department = '" . $_SESSION['user_info']['department'] . "'";

}

$where = $department_filter;
$columns = array(
	array( 
		'db' => 'e_db_id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return '<img src="'.$home.$emp['photo'].'" style="width:50px;" />';
		}
	),
	array( 
		'db' => 'full_name', 
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			return $d.' - '.$row[9];
		}
	),
	array( 
		'db' => 'branch_name', 
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'department_name', 
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			return '<p class="m-0">' . $d . '</p> - ' . '<p class="m-0">' . $row[14] . '</p>';
		}
	),
	array( 
		'db' => 'amount', 
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			return '<b style="color:green;">'.money($d).'</b>';
		}
	),
	array( 
		'db' => 'note', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$check_loan_approval = mysqli_fetch_assoc($mysqli->query("SELECT note from employee_loan_aproval where grant_loan_id = " . $row[7] ." order by id asc"));
			$d_head_note = '';
			if(!empty($check_loan_approval) AND !empty($check_loan_approval['note'])){
				$d_head_note = '<p class="m-0"> <span class="text-secondary">D.Head: </span>' . $check_loan_approval['note'] . '</p>';
			}
			return '<p class="m-0">' . $d . '</p>' .  $d_head_note ;
			// $u = explode('___',$d);
			// $em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			// return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 6,
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
		'db' => 'id', 
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_grant_loan where id = '".$d."'"));
			$check_loan_approval = mysqli_fetch_assoc($mysqli->query("SELECT note from employee_loan_aproval where grant_loan_id = $d order by id desc"));
			if($info['aproval'] == 0 AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){
				return '<textarea class="form-control" id="note" placeholder="Note!"></textarea>';
			}else if($info['aproval'] == 3 AND $_SESSION['user_info']['department'] == $row[13] AND $_SESSION['user_info']['d_head']){
				return '<textarea class="form-control" id="note" placeholder="Note!"></textarea>';
			}else if(!empty($check_loan_approval)){
				if(!empty($check_loan_approval['note'])){
					return $check_loan_approval['note'];
				}
			}
		}
	),
    array( 
		'db' => 'id', 
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_grant_loan where id = '".$d."'"));
			$buttons = '';
			if($info['aproval'] == 1 OR $info['aproval'] == 2 OR $info['aproval'] == 4){
				$buttons = '';
			}else if($info['aproval'] == 0 AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){
				$buttons = '
					<form action="#" method="POST">
						<button onclick="return loan_accept_function('.$d.')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button>
						<button onclick="return loan_reject_function('.$d.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>
					</form>
				';
			}else if($info['aproval'] == 3 AND $_SESSION['user_info']['department'] == $row[13] AND $_SESSION['user_info']['d_head']){
				$buttons = '
					<form action="#" method="POST">
						<button onclick="return loan_accept_function('.$d.', \'d_head\')" type="button" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i> Accept</button>
						<button onclick="return loan_reject_function('.$d.', \'d_head\')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i> Reject</button>
					</form>
				';
			}
			return $buttons;
		}
	),
	array('db' => 'employee_id', 'dt' => 9),
	array('db' => 'data', 'dt' => 10),
	array( 
		'db' => 'id', 
		'dt' => 11,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = $mysqli->query("SELECT * from employee_loan_aproval where grant_loan_id = '".$d."' ORDER BY id ASC");

			if($info->num_rows < 2){
				return '<badge class="badge badge-warning">Pending</badge>';
			}

			$date = mysqli_fetch_assoc($info);
			return $date['data'];
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 12,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($row[6] == '2'){
				return;
			}

			$info = $mysqli->query("SELECT * from employee_loan_aproval where grant_loan_id = '".$d."' ORDER BY id DESC");
		
			if($info->num_rows < 3){
				return '<badge class="badge badge-warning">Pending</badge>';
			}

			$date = mysqli_fetch_assoc($info);
			return $date['data'];
		}
	),
	array('db' => 'department', 'dt' => 13),
	array('db' => 'designation_name', 'dt' => 14),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>