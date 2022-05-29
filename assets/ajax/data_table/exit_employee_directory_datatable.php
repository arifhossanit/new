<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
function duration($d){
	$a = explode('/',$d);			
	$date1 = $a[2].'-'.$a[1].'-'.$a[0];
	$date2 = date('Y-m-d'); 
	$diff = abs(strtotime($date2) - strtotime($date1));
	$years   = floor($diff / (365*60*60*24)); 
	$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
	$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	return $years.' Years '.$months.' Months '.$days.' Days';
}
$table = 'employee';
$primaryKey = 'id';
$where = "status = '0' order by STR_TO_DATE(data,'%d/%m/%Y') desc";
$columns = array(
	array(
		'db' => 'photo',
		'dt' => 0,
		'formatter' => function( $d, $row ) { global $home;
				if(!empty($d)){
					return '<center><a href="'.$home.$d.'" target="_blank" title="Click to view!"><img class="image_employee" src="'.$home.$d.'" style="height:50px;" /></a></center>';
				}else{
					return '';
				} 				
			}
	),
    array( 'db' => 'employee_id',   'dt' => 1 ),	
    array( 'db' => 'full_name',   'dt' => 2 ),
    array( 'db' => 'designation_name',   'dt' => 3 ),
    array( 'db' => 'department_name',   'dt' => 4 ),
    array( 'db' => 'role_name',   'dt' => 5 ),
    array( 'db' => 'email',   'dt' => 6 ),
    array( 'db' => 'personal_Phone',   'dt' => 7 ),
    array( 'db' => 'date_of_joining',   'dt' => 8 ),
	array(
        'db'        => 'date_of_joining',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
			return duration($d);
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 10,
        'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select id,status from employee where id = '".$d."'"));
			if($info['status'] == '1'){
				return '
					<form action="'.$home.'admin/employ-directory" method="post">
						<input type="hidden" name="hidden_id" value="'.$info['id'].'"/>
						<button onclick="return deactive_model('.$info['id'].')" class="btn btn-xs btn-danger" type="button" style="width:60px;font-weight:bolder;">Deactive</button>
					</form>
				';
			}else{
				return '
					<form action="'.$home.'admin/employ-directory" method="post">
						<input type="hidden" name="hidden_id" value="'.$info['id'].'"/>
						<button class="btn btn-xs btn-success" name="status_on" type="submit" style="width:60px;font-weight:bolder;">Active</button>
					</form>
				';
			}
        }
    ),
	array( 'db' => 'data',   'dt' => 11 ),
    array( 'db' => 'extra_note',   'dt' => 12 ),
    array( 'db' => 'release_type',   'dt' => 13 ),
    array( 'db' => 'last_working_date',   'dt' => 14,
		'formatter' => function($d, $row){
			return substr($d, 0, 10);
		}
	),
	array( 'db' => 'card_number',   'dt' => 15 ),
	array(
        'db'        => 'id',
        'dt'        => 16,
        'formatter' => function( $d, $row ) { global $home; global $mysqli;
			
			$data = '
				<form action="'.$home.'admin/edit-employee" method="post">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button onclick="return view_profile('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>';
			/*if($_SESSION['super_admin']['user_type'] == 'Super Admin')*/{
				$data .=	'<button type="submit" name="edit" class="btn btn-xs btn-success"><i class="fas fa-edit"></i></button>';
			}
			if(check_permission('role_1604921365_99')){	
				$data .= '<button type="submit" name="delete" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>';
			}
			$data .= '</form> ';						
			return $data;
        }
    )
);
$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>