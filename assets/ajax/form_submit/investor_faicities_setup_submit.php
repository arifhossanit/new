<?php 
include("../../../application/config/ajax_config.php");
if (isset($_POST['save'])) {

    if (!empty($_POST['card_no']) && !empty($_POST['tea_coffee	']) && !empty($_POST['drinks'])) {

        $id = $_POST[''];
        $card_no = $_POST['card_no'];
        $tea_coffee = $_POST['tea_coffee'];
        $drinks = $_POST['drinks'];
       

        $query = "insert into investor_facilities_setup(id, card_no, tea_coffee, drinks) values('$id' , '$age' , '$tea_coffee' , '$drinks')";

        $run = mysqli_query($conn, $query) or die("connection unsuccessfull.");

        if ($run) {
            echo "From Submitted Successfully";
        } else {
            echo "From Not Submitted";
        }
    }
}

?>