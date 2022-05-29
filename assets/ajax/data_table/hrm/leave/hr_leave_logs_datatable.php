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
		a.start_days,
		a.how_many_days,
		a.note,
		a.end_date,
		a.h_id,
		a.h_aproval,
		a.aproval,
		a.uploader_info,
		a.data,
		b.photo,
		a.employee_id,
		b.department_name,
		b.full_name,
		b.designation_name,
		c.branch_name,
		d.days,
		d.month,
		d.status
	from employee_leave_logs a
	INNER JOIN employee b on b.id = a.e_db_id
	INNER JOIN branches c on c.branch_id = b.branch
	INNER JOIN employee_everyday_leave_logs d on d.unique_id = a.unique_id
) temp';

$primaryKey = 'id';


// if(!empty($_GET['end_date'])){
// $selected_date = new DateTime($_GET['month'].'-'.$_GET['end_date']); 
// $where = "h_aproval != 2 AND '".$selected_date->format('Y-m-d')."' BETWEEN STR_TO_DATE(start_days,'%d/%m/%Y') AND STR_TO_DATE(end_date,'%d/%m/%Y')";
// }else{
// 	$first_date = new DateTime($_GET['month'].'-01'); 
//     $last_date = new DateTime($first_date->format('Y-m-t'));
//    $where = "h_aproval != 2 AND STR_TO_DATE(start_days,'%d/%m/%Y') = '".$first_date->format('Y-m-d')."' AND '".$last_date->format('Y-m-d')."'";
// } 
$val = 1;
if(!empty($_GET['end_date']))
{   
	$first_date = new DateTime($_GET['month'].'-01');
	//$where = "h_aproval != 2 AND days = '".$_GET['end_date']."'";
	$where = "h_aproval != 2 AND days = '".$_GET['end_date']."' AND month = '".$first_date->format('m')."' AND status ='".$val."'";
}
else
{
	$first_date = new DateTime($_GET['month'].'-01'); 
    //$last_date = new DateTime($first_date->format('Y-m-t'));
   //$where = "h_aproval != 2 AND STR_TO_DATE(start_days,'%d/%m/%Y') = '".$first_date->format('Y-m-d')."' AND '".$last_date->format('Y-m-d')."'";
	$where = "h_aproval != 2 AND month = '".$first_date->format('m')."' AND status ='".$val."'";
}

$columns = array(
	array( 
		'db' => 'id', 
		'dt' => 0,
	),
	array( 
		'db' => 'photo',
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			return '<a href="'.$home.$d.'" target="_blank"><img src="'.$home.$d.'" style="width:50px;"/></a>';
		}
	),
	array( 
		'db' => 'full_name',
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $d.' - '.$row[17];
		}
	),
	array( 
		'db' => 'branch_name',
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
		}
	),
	array( 
		'db' => 'department_name',
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
		}
	),
	array( 
		'db' => 'designation_name',
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;
		}
	),

	array( 
		'db' => 'start_days', 
		'dt' => 6
		
	),

	array(
		'db' => 'days',
		'dt' => 7,
		// 'formatter' => function( $d, $row ) {
		// 	$time = explode('/', $d);
		// 	return $time[2].'/'.$time[1].'/'.$time[0];	
		// } 
	),
	array( 
		'db' => 'how_many_days', 
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			return $d.' Days';
		}
	),
	array( 'db' => 'note',   'dt' => 9 ),
	array( 'db' => 'end_date',   'dt' => 10 ),
	array( 
		'db' => 'h_id',
		'dt' => 11,
		'formatter' => function( $d, $row ) { global $mysqli;global $home;
			if(!empty($d)){
				$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
				return '<a href="'.$home.$emp['photo'].'" target="_blank"><img src="'.$home.$emp['photo'].'" style="width:50px;"/></a>';
			}else{
				return '';
			}
			
		}
	),
	array( 
		'db' => 'h_aproval', 
		'dt' => 12,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else if($d == 2){
				return '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
			}else if($d == 3){
				return '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
			}			
		}
	),
	array( 
		'db' => 'aproval', 
		'dt' => 13,
		'formatter' => function( $d, $row ) { global $mysqli;
			if($row[11] == '2'){

			}else if($d == 1){
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
		'dt' => 14,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."'"));
			return $em['full_name'].' - '.$em['employee_id']; 
		}
	),
	array( 'db' => 'data',   'dt' => 15 ),
	array( 
		'db' => 'id', 
		'dt' => 16,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select `note` from employee_leave_aproval_logs where leave_id = '".$d."'"));		
			return (is_null($info)) ? ' - ' : $info['note'];
		}
	),
    array( 
		'db' => 'id', 
		'dt' => 17,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$d."'"));
			$leave_employee_information = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where id = '".$row[1]."'"));
			$top_management = mysqli_fetch_assoc($mysqli->query("SELECT d_head_reporting, department from employee where id = '".$row[10]."'"));
			if(is_null($top_management)){
				$top_management_id = '114';
			}else if($top_management['d_head_reporting'] == '0'){
				$top_management_id = '114';
			}else{
				$top_management_id = $top_management['d_head_reporting'];
			}
			if($info['h_aproval'] == '0' AND $_SESSION['user_info']['d_head'] == '1' AND $info['h_id'] == $_SESSION['user_info']['employee_id']){
				if($_SESSION['user_info']['department'] == '2392358440567352112'){
					$buttons = '';
				}else{
					$buttons = '';
				}
				
			}else if($info['h_aproval'] == '2' OR $info['aproval'] == 1 OR $info['aproval'] == 2){
				$buttons = '';	
			}else if($info['h_aproval'] == '1' AND $info['aproval'] == 0 AND $top_management_id == $_SESSION['user_info']['employee_id']){
				$buttons = '';		
			}else if($info['h_aproval'] == '3' AND $info['aproval'] == 0 AND $info['h_id'] == $_SESSION['user_info']['employee_id']){
				$buttons = '';		
			}else if($info['h_aproval'] == '1' AND $info['aproval'] == 0 AND $top_management_id == $_SESSION['user_info']['employee_id']){
				$buttons = '';		
			}else{
				if($info['h_aproval'] == '0'){
					if(!is_null($top_management) AND $top_management['department'] == '2392358440567352112'){
						$buttons = '<badge class="badge badge-warning">Pending HI approval</badge>';
					}else{
						$buttons = '<badge class="badge badge-warning">Pending DH approval</badge>';
					}
				}else if($info['h_aproval'] == '3'){
					$buttons = '<badge class="badge badge-info">Pending DH approval</badge>';
				}else{
					$buttons = '<badge class="badge badge-info">Pending Boss approval</badge>';
				}
			}
			return $buttons;
		}
	),
	array('db' => 'employee_id', 'dt' => 18)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>