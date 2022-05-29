<?php 
//foreach($file_names as $key => $file_name){
	
for ($x = 0; $x < count($file_names); $x++) {
  ///echo "The number is: $x <br>";

?>

<img src="<?php echo base_url('assets/uploads/complain/').$file_names[$x]; ?>" width="100%;">

<?php  } ?>