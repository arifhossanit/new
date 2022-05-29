<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'expense_type';
$primaryKey = 'id';
$where = "";
$columns = array(
	array( 
		'db' => 'id', 
		'dt' => 0,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'head_name', 
		'dt' => 1,
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$infos = $mysqli->query("SELECT * from expense_sub_type where expense_type_id = '".$d."'");
            $html = '';
            foreach($infos as $info){
                $html .= $info['head_name'] . ', ';
            }
            $html = rtrim($html, ', ');
			return $html;
		}
	),
    array( 
		'db' => 'id', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $home;	
			$conf_message = "'Are you Sure Want To dalete Data?'";
			return '
            <div class="row">
                <div class="col-sm-1"><button onclick="sub_type_modals('.$d.', \''.$row[1].'\')" data-target="#add_sub_type" data-toggle="modal" class="btn btn-info btn-xs"><i class="fas fa-plus"></i></button></div>
				
            </div>
			';	
			$html = '<div class="col-sm-5"><form action="'.$home.'admin/accounting/accounts/manage-accounts" method="POST">
						<input type="hidden" name="hidden_id" value="'.$d.'"/>
						<button name="edit_data" type="submit" class="btn btn-success btn-xs">Edit</button>
						<button name="delete_data" type="submit" class="btn btn-danger btn-xs" onclick="return confirm('.$conf_message.')">Delete</button>
					</form></div>';
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>