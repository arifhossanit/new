<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'booking_info';
$primaryKey = 'id';
if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin')){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND ";
	}
}else{
	$branch_user = "";
}

$where = "data = '".date('d/m/Y')."'";
$columns = array(
    array( 'db' => 'm_name',   'dt' => 0 ),
	array( 'db' => 'checkin_date',    'dt' => 1 ),
	array( 'db' => 'package_category_name',     'dt' => 2 ),
    array( 'db' => 'package_name',     'dt' => 3 ),
	array( 'db' => 'branch_name',   'dt' => 4 ),
	array( 
		'db' => 'booking_id',
		'dt' => 5,
		'formatter' => function($d, $row){
			global $mysqli;
            $mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			if(!empty($mem['h_t_f_u'])){
				return $mem['h_t_f_u'];
			}else{
				return '';
			}
			
		} 
	),
	array( 
		'db' => 'booking_id',
		'dt' => 6,
		'formatter' => function($d, $row){
			global $mysqli;
            $mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			if(!empty($mem['occupation'])){
				return $mem['occupation'];
			}else{
				return '';
			}
			
		} 
	),
	
	array(
        'db'        => 'uploader_info',
        'dt'        => 7,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			if(!empty($d)){
				$em = explode("___",$d);
				$email = $em[1];
				if(!empty($email)){
					$employee_info = mysqli_fetch_assoc($mysqli->query("select *  from employee where email = '".$email."'"));
					if(!empty($employee_info['employee_id'])){
						return $employee_info['f_name'].' ('.$employee_info['employee_id'].')';
					}else{
						return '';
					}					
				}else{
					return '';
				}
			}else{
				return '';
			}			
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 8,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
            $data = '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>';
					$data .= '<button onclick="return view_profile_from_booking('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>';
				$data .= '</form>';
			return $data;
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>