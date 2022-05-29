<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['branch_id'])){
    $branch_id = $_POST['branch_id'];
    $result = $mysqli->query("SELECT id, package_category_name from packages_category where branch_id = '$branch_id' group by package_category_name");
    echo '<div class="col-md-3">
            <label style="float: left;" for="exampleInputPassword1"><h4>Package Category</h4></label>
            <div id="pkg_ctg_dropdown_toggle" style="float: right; display: none;" onclick="pkg_dropdown_hide()"><i class="fa fa-bars" aria-hidden="true"></i></div>                                      
        </div>';
    echo '<input id="selectedBranchId" type="hidden" name="selectedBranchId" value="'.$branch_id.'">';
    echo '  <div id="pkg_ctg_dropdown" style="display: none;" class="col-md-9">
            </div>
            <div class="col-md-9" id="hide_pkg_ctg_dropdown">';
    while($branch = mysqli_fetch_assoc($result)){
        $name = str_replace("try us", "Day Package",strtolower($branch['package_category_name']));
        echo '<button type="button" id="package"  class="button package" value="'.$branch['id'].'">'.ucfirst($name).'</button>';
    }
    echo '</div>';
}