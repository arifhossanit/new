<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'ipo_member_widthdraw_request';
$primaryKey = 'id';
$where = "status = '1'";
$columns = array(
    array('db' => 'id','dt' => 0 ),
	array(
        'db'        => 'ipo_id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$get_data = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$d."'"));
			if(!empty($get_data['id'])){
				return '<a href="'.$home.$get_data['personal_images'].'" target="_blank"><img src="'.$home.$get_data['personal_images'].'" style="height:120px;"></a>'; 
			}else{
				return '';
			}		
        }
    ),
	array(
        'db'        => 'amount',
        'dt'        => 2,
        'formatter' => function( $d, $row ) { global $mysqli;
			return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>'; 
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$get_data = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_widthdraw_request where id = '".$d."'"));
			if($get_data['widthdraw_method'] == 'Mobile Banking'){
				return '
					<b>Received By: </b>'.$get_data['payment_received_by'].'<br />
					<b>Widthdraw Method: </b>'.$get_data['widthdraw_method'].'<br />
					<b>Media: </b>'.$get_data['mobile_banking'].'<br />
					<b>Receiver Number: </b>'.$get_data['receiver_number'].'
				';
			}else if($get_data['widthdraw_method'] == 'Bank'){
				return '
					<b>Received By: </b>'.$get_data['payment_received_by'].'<br />
					<b>Widthdraw Method: </b>'.$get_data['widthdraw_method'].'<br />
					<b>Bank Name: </b>'.$get_data['bank_name'].'<br />
					<b>Account holder Name: </b>'.$get_data['account_holder_name'].'<br />
					<b>Account Number: </b>'.$get_data['account_number'].'
				';
			}else if($get_data['widthdraw_method'] == 'Chequee'){
				return '
					<b>Received By: </b>'.$get_data['payment_received_by'].'<br />
					<b>Widthdraw Method: </b>'.$get_data['widthdraw_method'].'<br />
					<b>Receiver Name: </b>'.$get_data['receiver_name'].'
				';
			}else{
				return '
					<b>Received By: </b>'.$get_data['payment_received_by'].'<br />
					<b>Widthdraw Method: </b>'.$get_data['widthdraw_method'].'
				';
			}
        }
    ),	
	array('db' => 'data','dt' => 4 ),
	array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) { global $mysqli;
			return '<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-dark" title=""><i class="fas fa-money-check-alt"></i>&nbsp;&nbsp;&nbsp;Approved Request</button>';
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>