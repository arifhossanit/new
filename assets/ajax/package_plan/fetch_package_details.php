<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['package_category_id'])){
  $package_category_id = $_POST['package_category_id'];
  $branch_id = $_POST['branch_id'];
  $try_us = mysqli_fetch_assoc($mysqli->query("SELECT try_us from packages where branch_id = '$branch_id' and package_category_id = $package_category_id"));
  $result = $mysqli->query("SELECT package_name, try_us from packages where branch_id = '$branch_id' and package_category_id = $package_category_id");
  if(is_null($try_us)){
    echo '
        <div class="col-md-3">
          <label style="float: left;" for="exampleInputPassword1"><h4>Package Name</h4></label>            
          <div id="pkg_name_dropdown_toggle" style="float: right; display: none;" onclick="pkg_name_dropdown_hide()"><i class="fa fa-bars" aria-hidden="true"></i></div>                                      
        </div>
        <div class="col-md-9"><p class="text-info text-bold">Comming Soon</p></div>';
  }else{
    echo '<input type="hidden" id="try_us_condition_check" name="try_us_condition" value="'.$try_us['try_us'].'">
        <hr class="solid">
        <div class="col-md-3">
          <label style="float: left;" for="exampleInputPassword1"><h4>Package Name</h4></label>            
          <div id="pkg_name_dropdown_toggle" style="float: right; display: none;" onclick="pkg_name_dropdown_hide()"><i class="fa fa-bars" aria-hidden="true"></i></div>                                      
        </div>';
    echo '<input id="selectedPackageId" type="hidden" name="package_category_id" value="'.$package_category_id.'">';
    echo '<div id="pkg_name_dropdown" style="display: none;" class="col-md-9">
        </div>
        <div class="col-md-9" id="hide_pkg_name_dropdown">';
    while($branch = mysqli_fetch_assoc($result)){
      echo '<button type="button" id="package" type="button" class="button packageName" value="'.$branch['package_name'].'" onclick="money_manage_ment_pkn_pln()">'.$branch['package_name'].'</button>';
    }
    echo '</div>';
  }
}