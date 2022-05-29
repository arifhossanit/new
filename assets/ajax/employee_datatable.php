<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../application/config/ajax_config.php");

$table = 'employee';
$primaryKey = 'id';
$columns = array(
    array( 
		'db' => 'photo', 
		'dt' => 0,
		'formatter' => function($d,$row){
				global $home;
				return '<center><img src="'.$home.$d.'" style="height:50px;" /></center>';
			}
		),
    array( 'db' => 'employee_id', 'dt' => 1 ),
    array( 'db' => 'full_name', 'dt' => 2 ),
    array( 'db' => 'designation_name',  'dt' => 3 ),
    array( 'db' => 'department_name',  'dt' => 4 ),
    array( 'db' => 'role_name',   'dt' => 5 ),
    array( 'db' => 'date_of_joining',     'dt' => 6 ),
    array( 
		'db' => 'date_of_joining',     
		'dt' => 7,
		'formatter' => function($d,$row){
			$a = explode('/',$d);			
			$date1 = $a[2].'-'.$a[1].'-'.$a[0];
			$date2 = date('Y-m-d'); 
			$diff = abs(strtotime($date2) - strtotime($date1));
			$years   = floor($diff / (365*60*60*24)); 
			$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
			$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			return $years.' Years '.$months.' Months '.$days.' Days';
		}
	),
    array( 
		'db' => 'id',     
		'dt' => 8 ,
		'formatter' => function($d,$row){
			global $mysqli;
			$row = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			if($row['status'] == '1'){
				return '
					<form action="" method="post">
						<input type="hidden" name="hidden_id" value="'.$row['id'].'"/>
						<button class="btn btn-xs btn-success" name="status_off" type="submit" style="width:150px;font-weight:bolder;">Active</button>
					</form>
					<script>
					$(function () {
						$("input[data-bootstrap-switch]").each(function(){
						  $(this).bootstrapSwitch("state", $(this).prop("checked"));
						});
					})
					</script>
				';
			}else{
				return '
					<form action="" method="post">
						<input type="hidden" name="hidden_id" value="'.$row['id'].'"/>
						<button class="btn btn-xs btn-danger" name="status_on" type="submit" style="width:150px;font-weight:bolder;">Deactive</button>
					</form>
					<script>
					$(function () {
						$("input[data-bootstrap-switch]").each(function(){
						  $(this).bootstrapSwitch("state", $(this).prop("checked"));
						});
					})
					</script>
				';
			}
		}
	),
    array(
        'db'        => 'id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
			global $home;
            return '
				<form action="'.$home.'admin/edit-employee" method="post">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button onclick="return view_profile('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
					<button type="submit" name="edit" class="btn btn-xs btn-success"><i class="fas fa-edit"></i></button>
					<button type="submit" name="delete" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
				</form>
			';
        }
    )
);
 

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>