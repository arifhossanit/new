<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$ipo_id = $_SESSION['ipo_member_panel']['ipo_id'];
$table = 'ipo_member_widthdraw_request';
$primaryKey = 'id';
$where = "ipo_id = '".$ipo_id."'";
$columns = array(
    array('db' => 'id','dt' => 0 ),
	array(
        'db'        => 'amount',
        'dt'        => 1,
        'formatter' => function( $d, $row ) { global $mysqli;
			return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>'; 
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 2,
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
	array('db' => 'data','dt' => 3 ),
	array(
        'db'        => 'id',
        'dt'        => 4,
        'formatter' => function( $d, $row ) { global $mysqli;
            $get_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_widthdraw_request where id = '".$d."'"));
			if($get_info['status'] == '1'){
				return '
					<button type="button" class="btn btn-xs btn-info">						
						<marquee style="line-height: 9px;">
							<i class="fa fa-spinner fa-spin"></i> Pending...!
						</marquee>
					</button>
					<button onclick="return ipo_member_widthdraw_remove('.$d.')" type="button" class="btn btn-xs btn-danger">Remove</button>
				';
			}else{
				return '<button type="button" class="btn btn-xs btn-success">paid & Approved</button>';
			}			
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>