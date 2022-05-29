<?php include("../../../application/config/ajax_config.php");
$purses_code = $_POST['purchaseCode'];
$item = $_POST['item'];
$aggrement_information = $mysqli->query("SELECT * from ipo_agreement_information where purses_code = '$purses_code'");
$html = '';
$count = 1;
while($aggrement = mysqli_fetch_assoc($aggrement_information)){
    $html .= '  <a href="#item-'.$item.'-'.$count++.'" class="list-group-item" data-toggle="collapse">
                    <i></i>
                </a>';
}
echo $html;
