<?php
include("../../../application/config/ajax_config.php");
$package_name = $_POST['package_name'];
$result_pkg_pic = $mysqli->query("SELECT category_name, image_one, image_two, image_three FROM ipo_category GROUP BY category_name");
while($pkg_pic = mysqli_fetch_assoc($result_pkg_pic)){
    if(strtolower($package_name) == strtolower($pkg_pic['category_name']) || strpos(strtolower($package_name), strtolower($pkg_pic['category_name'])) !== false){
        echo "  <div class='carousel-item active'>
                    <img class='img-size' src='".$pkg_pic['image_one']."' alt='First slide' />
                </div>
                <div class='carousel-item'>
                    <img class='img-size' src='".$pkg_pic['image_two']."' alt='Second slide' />
                </div>
                <div class='carousel-item'>
                    <img class='img-size' src='".$pkg_pic['image_three']."' alt='Second slide' />
                </div>";
        break;
    }else{
        // echo strtolower($package_name) . strtolower($pkg_pic['category_name']);
    }
}