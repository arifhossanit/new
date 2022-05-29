<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'beds';
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
$where = "".$branch_user." status IN (0,1)";
$columns = array(
    array(
		'db' => 'id',
		'dt' => 0,
		'formatter' => function( $d, $row ) {
			return '<input type="checkbox" value="'.$d.'" />';
		}
	),
	array( 'db' => 'id',   'dt' => 1 ),
    array( 'db' => 'branch_name',   'dt' => 2 ),
    array( 'db' => 'floor_name',    'dt' => 3 ),
    array( 'db' => 'unit_name',   'dt' => 4 ),
    array( 'db' => 'room_name',    'dt' => 5 ),
	array(
		'db' => 'coloumn_id',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$colum = mysqli_fetch_assoc($mysqli->query("select * from column_list where id = '".$d."'"));
			if(!empty($colum['id'])){
				return $colum['column_name'];
			}else{
				return '';
			}			
		}
	),
	array(
		'db' => 'id',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$d."'"));
			$member_number = mysqli_fetch_array($mysqli->query("select count(*) from booking_info where bed_id = '".$bed_info['id']."' and status = '1'"));
			if($member_number[0] > 1){
				$style = 'style="background-color:#f00;color:#fff;"';
			}elseif($member_number[0] == 1){
				$style = 'style="background-color:green;color:#fff;"';
			}else{
				$style = '';
			}
			return '<span '.$style.'>'.$bed_info['bed_name'].' ('.$member_number[0].')</span>';
		}
	),	
    array( 'db' => 'data',    'dt' => 8 ),
	array(
        'db'        => 'id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
            global $mysqli;
            global $home;
			$status = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$d."'"));
			$message = "'are you sure?'";
			$data = '
				<form action="'.$home.'admin/manage-beds" method="post">
				<input type="hidden" value="'.$d.'" name="hidden_id"/>
			';
			if($status['status'] == '1'){
				$data .= '<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>';
			}else{
				$data .= '<button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>';	
			}
			$data .= '<button name="edit" type="submit" class="btn btn-xs btn-success"><i class="fas fa-edit"></i></button>';
			$data .= '<button name="delete" type="submit" onclick="return confirm('.$message.');" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>';
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