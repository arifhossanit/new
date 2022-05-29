<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = '
		(SELECT 
                a.id,
				a.head_pay_cut,
                a.e_db_id,
                a.month_year,
                a.percentage,
                a.pay_cut,
                a.aproval,
                a.uploader_info,
                a.data,
                a.note,
                a.status,
                a.department,
                a.given_percentage,
                b.branch,
                b.photo,
				b.full_name,
				b.employee_id,
				b.designation_name,
				b.department_name
            FROM employee_performance_logs a
            INNER JOIN employee b ON a.e_db_id = b.id
        ) temp';
$primaryKey = 'id';
$filter = "";

/**
 * Branch filter!
 */
if($_SESSION['user_info']['department'] == '1806965207554226682'){
	$filter .= " AND branch = '".$_SESSION['super_admin']['branch']."'";
}
// else if($_SESSION['user_info']['department'] == '2392358440567352112'){
// 	$filter .= " AND branch = '".$_SESSION['super_admin']['branch']."'";
// }
if($_SESSION['super_admin']['user_type'] != 'Super Admin'){
	if($_SESSION['user_info']['department'] == '1383007286312996344' and $_SESSION['user_info']['d_head'] == '1'){
		
	}else{
		$filter .= " AND department = '".$_SESSION['user_info']['department']."'";
	}
}

$selected_month = new DateTime($_GET['month']);

$where = "status = 1 AND month_year = '".$selected_month->format('m/Y')."'".$filter;
$columns = array(
	array( 
		'db' => 'id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'photo', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			return "<img class='image-zoom' src='http://erp.superhostelbd.com/super_home/$d'>";
		}
	),
	array( 
		'db' => 'department_name', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli; global $home;
			return "<div class='row'>
						<div class='col-md-12'>
							<p class='mb-0'>".$row[11]." - ".$row[12]."</p>
						</div>
						<div class='col-md-12'>
							<p class='mb-0 text-secondary'>".$row[13]."</p>
						</div>
						<div class='col-md-12'>
							<p class='mb-0 text-secondary'>".$d."</p>
						</div>
					</div>";
		}
	),
	array( 'db' => 'month_year',   'dt' => 3 ),
	array( 
		'db' => 'pay_cut', 
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			if($d){
				return '<span class="badge badge-danger"> Penalty </span>';
			}else{
				return '<span class="badge badge-primary"> Bonus </span>';
			}
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
		'db' => 'uploader_info', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			$u = explode('___',$d);
			$em = mysqli_fetch_assoc($mysqli->query("select photo from employee where email = '".$u[1]."'"));
			return "<img class='image-zoom' src='http://erp.superhostelbd.com/super_home/".$em['photo']."'>";
		}
	),
	array( 'db' => 'data',   'dt' => 7 ),	
	array( 
		'db' => 'percentage', 
		'dt' => 8,
		'formatter' => function( $d, $row ) {global $mysqli;
			$get_approval_status = mysqli_fetch_assoc($mysqli->query("SELECT * from employee_performance_aproval_logs where performance_id = ".$row[0]));
			if(is_null($get_approval_status)){
				if($_SESSION['user_info']['department'] == '749568347163692080'){ // Approval will show only for Top-Management department.
					if($row[4] == 1){
						$d *= -1;	// Making the value negative for penalty
					}
					return '<input id="final_percentage_'.$row[0].'" class="form-control" type="number" value="'.$d.'">';
				}else{
					return '<span class="badge badge-info"> Pending </span>';
				}
			}
			if(strtolower($get_approval_status['aproval_type']) == 'rejected'){
				return '<b>0</b><small>%</small>';
			}
			if($row[4] == 1){ // Penalty
				return '<b class="text-danger"> -'.$d.'<small>%</small></b>';
			}else{
				return '<b class="text-success">'.$d.'<small>%</small></b>';
			}
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 9,
		'formatter' => function( $d, $row ) {global $mysqli;
			$get_approval_status = mysqli_fetch_assoc($mysqli->query("SELECT * from employee_performance_aproval_logs where performance_id = ".$d));
			if(is_null($get_approval_status)){
				if($_SESSION['user_info']['department'] == '749568347163692080'){ // Approval will show only for Top-Management department.
					return '<textarea id="approval_note_'.$d.'" class="form-control" type="text" placeholder=" Note! "></textarea>';
				}else{
					return '<span class="badge badge-info"> Pending </span>';
				}
			}
			if(strlen($get_approval_status['note']) > 200){
				return "<span id='note_field_".$row[0]."'>" . substr($get_approval_status['note'], 0, 200) ."<button type='button' class='btn btn-link p-0' onclick='show_more_note(".$row[0].")'>...Show More!</button></span>
					<span id='full_text_".$row[0]."' style='display: none'>" .$get_approval_status['note']. "</span>";
			}else{
				return $get_approval_status['note'];
			}
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 10,
		'formatter' => function( $d, $row ) {global $mysqli;
			$get_approval_status = mysqli_fetch_assoc($mysqli->query("SELECT * from employee_performance_aproval_logs where performance_id = ".$d));
			if(!is_null($get_approval_status)){
				$uploader_info = explode('___', $get_approval_status['uploader_info']);
				$get_uploader_image = mysqli_fetch_assoc($mysqli->query("SELECT photo from employee where email = '".$uploader_info[1]."'"));
				return "<img class='image-zoom' src='http://erp.superhostelbd.com/super_home/".$get_uploader_image['photo']."'>";
			}
			return ' - ';
		}
	),
	array( 'db' => 'full_name',   'dt' => 11 ),	
	array( 'db' => 'employee_id',   'dt' => 12 ),
	array( 'db' => 'designation_name',   'dt' => 13 ),
	array( 'db' => 'head_pay_cut',   'dt' => 14 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>