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
$where = "status in ('1','2')";
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
    array( 
		'db' => 'card_number',
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $home;
			if(!empty($d)){
				return $d;
			}else{
				return ' - ';
			} 				
		}
	),
    array(
        'db'        => 'branch',
        'dt'        => 3,
        'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$d."'"));
			return $info['branch_name'];
        }
    ),	
    array( 'db' => 'full_name',   'dt' => 4 ),
    array( 'db' => 'blood_group',   'dt' => 5 ),
    array( 'db' => 'designation_name',   'dt' => 6 ),
    array( 'db' => 'department_name',   'dt' => 7 ),
    array( 'db' => 'role_name',   'dt' => 8 ),
    array( 'db' => 'email',   'dt' => 9 ),
    array( 'db' => 'personal_Phone',   'dt' => 10 ),
    array( 'db' => 'date_of_joining',   'dt' => 11 ),
	array(
        'db'        => 'date_of_joining',
        'dt'        => 12,
        'formatter' => function( $d, $row ) {
			return duration($d);
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select id,status from employee where id = '".$d."'"));
			if($info['status'] == '1'){
				/* return '
					<form action="'.$home.'admin/employ-directory" method="post">
						<input type="hidden" name="hidden_id" value="'.$info['id'].'"/>
						<button onclick="return deactive_model('.$info['id'].')" class="btn btn-xs btn-danger" type="button" style="width:60px;font-weight:bolder;">Deactive</button>
					</form>
				'; */ /* (26-08-2021) disabled By - Md. Ibrahim Khalil */
				return '--';
			}else if($info['status'] == '2'){
				return '
						<button class="btn btn-xs btn-warning" type="button" style="width:60px;font-weight:bolder;color:#333;">Hold</button>
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
	array(
        'db'        => 'id',
        'dt'        => 14,
        'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select status from employee where id = '".$d."'"));
			if($info['status'] == 2){
				$hold_button = '<button onclick="return un_hold_an_employee('.$d.')" type="button" class="btn btn-xs btn-dark">Unhold</button>';
			}else{
				$check_hold_logs = mysqli_fetch_assoc($mysqli->query("select * from hold_employe_logs where e_db_id = '".$d."' and aproval = '0' order by id desc"));
				if(!empty($check_hold_logs['id'])){
					$hold_button = '';
				}else{
					$hold_button = '<button type="button" onclick="hold_am_employee_click('.$d.')" class="btn btn-xs btn-warning" title="Hold This Employee!"><i class="fas fa-hospital-symbol"></i></button>';
				}				
			}
			$data = '
				<form action="'.$home.'admin/edit-employee" method="post">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<div class="btn-group">
						<div class="dropdown dropleft">
							<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" style="line-height: 23px;">
								<i class="fas fa-list"></i>
							</button>
							<div class="dropdown-menu">
								<a href="javascript:void(0)" data-target="#employee_card_modal" data-toggle="modal" onclick="return employee_card_information(\''.$row[2].'\', \''.$d.'\')" class="dropdown-item"><i class="far fa-id-card"></i> Employee Card</a>
								<a onclick="return print_applicant_account_Details('.$d.')" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-arrow-right"></i> Applicant Account</a>
								<a onclick="return print_payroll_card('.$d.')" class="dropdown-item" href="javascript:void(0)"  title="View Employee Payroll Report"><i class="fas fa-arrow-right"></i> Payroll Card</a>
							</div>
						</div>	
						'.$hold_button.'
						<button onclick="return view_profile('.$d.')" type="button" class="btn btn-xs btn-info" title="View Employee Information!"><i class="fa fa-eye"></i></button>
						<button type="submit" name="edit" class="btn btn-xs btn-success" title="Update Employee Information"><i class="fas fa-edit"></i></button>';
						if(check_permission('role_1604920260_56')){
							$data .= '<button type="submit" name="delete" class="btn btn-xs btn-danger" title="Remove Employee From System"><i class="fas fa-trash-alt"></i></button>';
						}											
			$data .= '</div>
			</form> ';						
			return $data;
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>