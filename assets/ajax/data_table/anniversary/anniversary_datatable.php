<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");


//$conn = new mysqli($host,$user,$pass,$db);
$table = '(select 
		member_directory.id,
		member_anyversary.anyversary_date, member_anyversary.anyversary_type,
		member_directory.branch_name, member_directory.phone_number, member_directory.full_name,
		member_directory.check_in_date
		from member_anyversary
		inner join member_directory on member_directory.id = member_anyversary.member_id
		group by member_anyversary.anyversary_date
		order by member_anyversary.anyversary_date desc              
        ) temp';
//$table = "member_anyversary";
$primaryKey = 'id';
/* if(!empty($_GET['branch_id'])){	
	if($_GET['branch_id'] == '1'){
		$branch_user = "";
	}else{
		$row_b = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".rahat_decode($_GET['branch_id'])."'"));
		if(!empty($row_b['branch_id'])){
			$branch_user = "branch_id = '".$row_b['branch_id']."' AND ";
		}else{
			$branch_user = "";
		}
	}
}else{
	$branch_user = "";
}
if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);
	if(!empty($one[0]) AND !empty($one[1])){			
		$one_ymd = explode('/',$one[0]);
		$two_ymd = explode('/',$one[1]);
		$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
		$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
		$date_filter = " AND STR_TO_DATE(member_anyversary.check_out_date,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
	}else{
		$date_filter = "";
	}	
}else{
	$date_filter = "";
}
$where = "".$branch_user." status = '1' ".$date_filter;

 */
$where = "  ";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'anyversary_date', 'dt' => 1 ),
   
    array( 
		'db' => 'member_id', 
		'dt' => 2
	)   
        
    
);
 

$db_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $db_details, $table, $primaryKey, $columns)
	
);

?>