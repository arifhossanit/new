<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'prebook_employee';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array( 
		'db' => 'photo', 
		'dt' => 1,
		'formatter' => function($d,$row){ global $home;		
			return '<a href="'.$home.$d.'" target="_blank" title="Click To View"><img src="'.$home.$d.'" style="width:50px;" class="image-responsive"/></a>';
		}
	),
    array( 'db' => 'employee_id',   'dt' => 2 ),
    array( 'db' => 'full_name',   'dt' => 3 ),
	array( 
		'db' => 'personal_Phone', 
		'dt' => 4,
		'formatter' => function($d,$row){			
			return '<a href="tel:'.$d.'">'.$d.'</a>';
		}
	),
    array( 'db' => 'email',   'dt' => 5 ),
    array( 'db' => 'nid_number',   'dt' => 6 ),	
	array( 
		'db' => 'id', 
		'dt' => 7,
		'formatter' => function($d,$row){ global $home; global $mysqli;			
			$files = mysqli_fetch_assoc($mysqli->query("select * from prebook_employee where id = '".$d."'"));
			$file = '';
			if(!empty($files['emergency_attachment_1'])){
				$file .= '<li><a href="'.$home.$files['emergency_attachment_1'].'" target="_blank">File One</a></li>';
			}
			
			if(!empty($files['emergency_attachment_2'])){
				$file .= '<li><a href="'.$home.$files['emergency_attachment_2'].'" target="_blank">File Two</a></li>';
			}
			
			return $file;
		}
	),
    array( 'db' => 'data',   'dt' => 8 ),	
    array( 
		'db' => 'id', 
		'dt' => 9,
		'formatter' => function($d,$row){ global $mysqli; global $home;		
			$files = mysqli_fetch_assoc($mysqli->query("select * from prebook_employee where id = '".$d."'"));
			$employee = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$files['email']."' or personal_Phone = '".$files['personal_Phone']."'"));
			$onclick_message = "'Are you sure want to add ".$files['full_name']." as Employee?'";
			$onclick_message_delete = "'Are you sure want to Delete ".$files['full_name']." From Employee Request?'";
			
			if(!empty($employee['email']) OR !empty($employee['personal_Phone'])){
				$button = '';
			}else{
				$button = '<button name="add_as_employee" onclick="return confirm('.$onclick_message.')" class="btn btn-xs btn-info" type="submit">Add as Employee</button>';
			}
			
			
			return '
				<form action="'.$home.'admin/employ-directory" method="post">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button class="btn btn-xs btn-warning" type="button">view</button>
					<button name="delete_prebook_request" onclick="return confirm('.$onclick_message_delete.')" class="btn btn-xs btn-danger" type="submit">Delete</button>
					'.$button.'
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