<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include("../../../application/config/ajax_config.php");
$sql = $mysqli->query("select * from employee where role in ('1179783255713532148') and status = 1");
while($row = mysqli_fetch_assoc($sql)){
    $role = mysqli_fetch_assoc($mysqli->query("select * from roles where role_id = '".$row['role']."'"));
    $branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch']."'"));
    $uploader_info = $role['role_name'].'___'.$row['email'].'___'.$branch['branch_id'];
    $total_value = 0;
    if(!empty($_POST['selected_date'])){
        $sql_2 = $mysqli->query("select * from booking_receipt_logs where uploader_info LIKE '%".$row['email']."%' AND count_reword = '' AND STR_TO_DATE(data, '%d/%m/%Y') <= '".$_POST['selected_date']."'");
    }else{
        $yesterday = new DateTime('yesterday');
        $sql_2 = $mysqli->query("select * from booking_receipt_logs where uploader_info LIKE '%".$row['email']."%' AND count_reword = '' AND STR_TO_DATE(data, '%d/%m/%Y') <= '".$yesterday->format('Y-m-d')."'");
        // $sql_2 = $mysqli->query("select * from booking_info where uploader_info LIKE '%".$row['email']."%' AND count_reword = ''");
    }
    while($booking = mysqli_fetch_assoc($sql_2)){
        $package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
		if(!empty($package['sub_category_id'])){
			$get_value = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package['sub_category_id']."'"));
			$total_value = $total_value + $get_value['booking_value'];
		}
        
    }
    if($total_value > 0){
        $get_aray[] = array('value' => $total_value, 'label' => $row['full_name'], 'gender' => $row['gender'], 'photo' => $row['photo']);
    }
}
arsort($get_aray);
// var_dump($get_aray);

$html = '';
foreach($get_aray as $row){
    $get_medel = mysqli_fetch_assoc($mysqli->query("SELECT * from badge_awards where point_from <= ".$row['value']." AND point_up_to >= ".$row['value']));
    if(is_null($get_medel)){
        continue;
    }
    $html .= "<tr>";
    $html .= "<td>".$get_medel['level']."</td>";
    $html .= '<td> <img style="border-radius: 5px" src="'.$home . $row['photo'].'" alt="" width="85px"></td>';
    $html .= '<td>'.$row['label'].'</td>';
    $html .= "<td>".$row['value']."</td>";
    if($row['gender'] == 'Male'){
        $html .= '<td><img style="border-radius: 5px" src="'.$home . ($get_medel['male_badge_image_path']).'" alt="" width="100px"></td>';
    }else{
        $html .= '<td><img style="border-radius: 5px" src="'.$home . ($get_medel['female_badge_image_path']).'" alt="" width="100px"></td>';
    }
    $html .= "</tr>";
}
echo $html;
?>