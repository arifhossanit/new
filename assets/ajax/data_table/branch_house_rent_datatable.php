<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$table = 'branch_house_rent';
$primaryKey = 'id';
$where = "status = '1'";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'month_year',
		'dt' => 1,
		'formatter' => function( $d, $row ) {			
			$date = new DateTime(date('Y-m-d', strtotime('01-' . str_replace('/','-',$d))));
			return $date->format('F Y');
		}
	),
	array( 'db' => 'branch_name',   'dt' => 2 ),
    array(
		'db' => 'amount',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			return money($d);				
		}
	),
	array( 'db' => 'data',   'dt' => 4 ),
	array(
		'db' => 'status',
		'dt' => 5,
		'formatter' => function( $d, $row ) {
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Active</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-danger">Deactive</button>';
			}
		}
	),
	array(
        'db'        => 'uploader_info',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$u[1]."'"));
					return ''.$emp['full_name'].' | '.$emp['employee_id'].'';
				}
			}
		}
    ),
	
    array(
        'db'        => 'id',
        'dt'        => 7,
        'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$date = new DateTime(date('Y-m-d', strtotime('01-' . str_replace('/','-',$row[1]))));
			$validate = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as id_count from branches_revenue_rank where month = '".$date->format('Y-m')."'"));
			if($validate['id_count'] > 0){
				return;
			}
			// <button name="delete" type="submit" onclick="return confirm('.$question.');" class="btn btn-sm btn-danger">Delete</button>
			return '
				<form action="'.$home.'admin/create/front-office/add-house-rent" method="post">
					<input type="hidden" value="'.$d.'" name="hidden_id"/>
					<button name="edit" type="submit" class="btn btn-sm btn-success">Edit</button>
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