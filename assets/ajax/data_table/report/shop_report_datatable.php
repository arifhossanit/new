<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'refreshment_item_sell';
$primaryKey = 'id';
if(isset($_GET['branch_id'])){
	if($_GET['branch_id'] == 1){
		$branch_id = "";
	}else{
		$branch_id = " AND branch_id = '".$_GET['branch_id']."'";
	}	
}else{
	$branch_id = "";
}
if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);	
	$one_ymd = explode('/',$one[0]);
	$two_ymd = explode('/',$one[1]);
	$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
	$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
	$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
}else{
	$date_filter = "";
}

$where = "status = '1' $branch_id $date_filter"; //
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'branch_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$d."'"));
				if(!empty($branch['branch_name'])){
					return $branch['branch_name'];	
				}					
			}
		}
	),
	array(
		'db' => 'buyer_id',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$d."'"));
				$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
				$beq = mysqli_fetch_assoc($mysqli->query("select * from booking_enquery where generate_id = '".$d."'"));
				if(!empty($mem['full_name'])){
					return $mem['full_name'];	
				}else if(!empty($emp['full_name'])){
					return $emp['full_name'];	
				}else if(!empty($beq['name'])){
					return $beq['name'];	
				}else{
					return 'Null!';
				}				
			}
		}
	),
	array(
		'db' => 'total_qty',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				return '<span style="color:#a50000;font-weight:bolder;">'.$d.'</span>';
			}
		}
	),
	array(
		'db' => 'total_amount',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				return '<span style="color:#a50000;font-weight:bolder;">'.money($d).'</span>';
			}
		}
	),
	array(
		'db' => 'payment_status',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				if($d == 'Paid'){
					return '<button class="btn btn-xs btn-success" type="button">PAID</button>';
				}else{
					return '<button class="btn btn-xs btn-danger" type="button">DUE</button>';
				}
			}
		}
	),
	
	array(
		'db' => 'uploader_info',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					return $u[1];
				}
			}	
		}
	),
	array( 'db' => 'data',    'dt' => 7 ),	
	array(
        'db'        => 'id',
        'dt'        => 8,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
            return '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button onclick="return view________('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
				</form>
			';
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>