<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'check_print_data';
$primaryKey = 'id';
if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin')){
		$branch_user = "";
	}else{
		$email = $_SESSION['super_admin']['email'];
		$branch_user = ""; //uploader_info LIKE '%".$email."%' AND   //branch_id = '".rahat_decode($_GET['branch_id'])."' AND
	}
}else{
	$branch_user = "";
}
if(!empty($_GET['card_invoice_no'])){
	$card_number = "card_invoice_no LIKE '".$_GET['card_invoice_no']."%' AND ";
}else{
	$card_number = "";
}

if(!empty($_GET['date_filter'])){
	$dt = explode('-',$_GET['date_filter']);
	$date_filter = $dt[2].'/'.$dt[1].'/'.$dt[0];
	$data_filter = "check_date LIKE '".$date_filter."%' AND ";
}else{
	$data_filter = "";
}


$where = "".$card_number."".$data_filter."".$branch_user." status IN ('1','2','3')";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array(
        'db'        => 'id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) { global $mysqli;
			$wid_chk = mysqli_fetch_assoc($mysqli->query("select * from check_print_data where id = '".$d."'"));
			if($wid_chk['status'] == '3'){
				$get_message = mysqli_fetch_assoc($mysqli->query("select * from check_print_disabled_data where check_id = '".$wid_chk['id']."'"));
				$message = $get_message['note'];
				$date = $get_message['data'];
				$u = explode('___',$get_message['uploader_info']);				
				$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$u[1]."'"));
				return '<button title="It is Disabled! ('.$message.' - '.$emp['full_name'].' - '.$emp['employee_id'].' - '.$date.')" class="btn btn-xs btn-danger" type="button"><i class="fa fa-times"></i> Disabled!</button>';
			}else{
				if($wid_chk['status'] == '2'){
					return '<button title="Withdrawal" class="btn btn-xs btn-success" type="button"><i class="fa fa-check"></i></button>';
				}else{
					return '<button title="Not Withdrawal" class="btn btn-xs btn-danger" type="button"><i class="fa fa-times"></i></button>';
				}
			}
        }
    ),
    array( 'db' => 'card_invoice_no',   'dt' => 2 ),
    array( 'db' => 'check_no',   'dt' => 3 ),
    array( 'db' => 'check_name',    'dt' => 4 ),
	array(
        'db'        => 'check_date',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {			
			return '<span class="badge badge-primary">'.$d.'</span>';
        }
    ),
    array( 'db' => 'data',   'dt' => 6 ),
	array(
        'db'        => 'check_amount',
        'dt'        => 7,
        'formatter' => function( $d, $row ) {			
			return money($d);
        }
    ),
	array( 'db' => 'note',   'dt' => 8 ),
	array(
        'db'        => 'id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) { global $mysqli;
			$check_data = mysqli_fetch_assoc($mysqli->query("select * from check_print_data where id = '".$d."'"));
            $data = '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>';
					$data .= '<button onclick="return check_print_modal('.$d.')" type="button" class="btn btn-xs btn-warning" style="margin-right:5px;"><i class="fa fa-eye"></i></button>';
					if(check_permission('role_1612251450_19')){
						if($check_data['status'] == '1'){
							$data .= '<button onclick="return check_withdrawal_modal('.$d.')" type="button" class="btn btn-xs btn-info"><i class="fa fa-check"></i> &nbsp;Withdrawal</button>';
						}					
					}
					if(check_permission('role_1614780577_84')){
						if($check_data['status'] == '1'){
							$informatio = $check_data['check_no'];
							$data .= '<button onclick="return check_edit_modal('.$d.','.$informatio.')" type="button" class="btn btn-xs btn-warning"><i class="far fa-edit"></i> &nbsp;Edit</button>';
						}					
					}
					if(check_permission('role_1631174163_52')){
						if($check_data['status'] == '1'){
							$informatio = $check_data['check_no'];
							$data .= '<button onclick="return check_disabled_modal('.$d.','.$informatio.')" type="button" class="btn btn-xs btn-danger"><i class="fas fa-minus-circle"></i> &nbsp;Disable it</button>';
						}					
					}
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