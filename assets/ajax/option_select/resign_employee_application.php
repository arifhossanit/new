<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['application_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from employee_resign_request where id = '".$_POST['application_id']."'"));
?>
<div class="row">
	<div class="col-sm-12" style="margin-bottom:30px;">
		<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
	</div>
	<div class="col-sm-12" id="print_area">
		<?php if(!empty($row['application'])){
			echo $row['application'];
		} ?>
	</div>
</div>
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>
<script>
    $('#print_button').on("click", function () {
      $('#print_area').printThis({
      });
    });
</script>
<?php } ?>