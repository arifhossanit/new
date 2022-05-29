<?php 
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['employee_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".rahat_decode($_POST['employee_id'])."'"));
include('../../../application/helpers/qrcode_helper.php');
$daaata = $home.'employee-rating/qr-code/'.rahat_encode($row['id']);
$file = '../../uploads/qrcode/employee_q_code_id_'.$row['id'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2); 
?>
<div class="row">
	<div class="col-sm-12" id="print_area"> <!--id="download_id_card" -->
		<div style="width:1059px;height:493px;background:url(<?php echo $home; ?>assets/img/id_card.png) no-repeat; background-size: cover;">
			<div style="width: 307px; height: 489px; margin-left: 3px; margin-top:3px; float: left;">
				<?php if(!empty($row['photo'])){ ?>
				<img src="<?php echo $home.$row['photo']; ?>" style="width: 133px; height: 133px; margin-top: 143px; margin-left: 87px; border-radius: 200px;"/>
				<?php } else { ?>
				<img src="<?php echo $home; ?>assets/img/photo_avatar.png" style="width: 133px; height: 133px; margin-top: 143px; margin-left: 87px; border-radius: 200px;"/>
				<?php } ?>
				<br />
				<center style="margin-top:24px;color:#000;"> <!--#2380ae-->
					<span><b><?php echo $row['full_name']; ?></b></span><br />
					<span><?php echo $row['designation_name']; ?> - <?php echo $row['department_name']; ?></span><br />
					<?php /* ?><span><?php echo $row['job_responsibilities']; ?></span><br /><?php */ ?>
					<span>Employee ID Number: <?php echo $row['employee_id']; ?></span>
				</center>
			</div>
			<div style="width: 307px; height: 489px; margin-left: 29px; margin-top: 3px; float: left;">
				<center style="color:#fff;">
					<p style="margin: 0px; margin-top: 10px; font-size: 14px; "><b>Issue Date:</b> 
						<?php 
							$dt = explode("/",$row['date_of_joining']); 
							$date = $dt[2].'-'.$dt[1].'-'.$dt[0];							
							echo date_format(date_create($date),"d M Y");
							if($row['status'] == 1){
								$dta = explode("/",date('d/m/Y', strtotime('+2 years', strtotime($date))));
								$year = date('Y')+ 2;
								if(date('Y') < $dta[2]){
									$date1 = $dt[2].'-'.$dt[1].'-'.$dt[0]; 
								}else{
									$date1 = $year.'-'.$dt[1].'-'.$dt[0]; 
								}
							}else{
								$date1 = $dt[2].'-'.$dt[1].'-'.$dt[0]; 
							}
						?>
					</p>
					<p style="margin: 0px; margin-top: -6px; font-size: 14px;"><b>Expire Date:</b> 
						<?php 
							echo date('d M Y', strtotime('+2 years', strtotime($date1))); 
						?>
					</p>
				</center>
				<img src="<?php echo $home.'assets/uploads/qrcode/employee_q_code_id_'.$row['id'].'.png'; ?>" style="width: 121px; height: 121px; margin-top: 21px; margin-left: 93px;">
				<center style="color:#2380ae;">
					<p style="margin: 0px; margin-top: 21px;  "><b>Blood Group:</b> <?php echo $row['blood_group']; ?></p>
				</center>
			</div>
			<div style="width: 375px; height: 58px; margin-left: 36px; margin-top: 3px; float: left;">
				<div style="width: 45px; height: 58px; margin-left: 36px; margin-top: 3px; float: left;">
					<?php if(!empty($row['photo'])){ ?>
					<img src="<?php echo $home.$row['photo']; ?>" style="width: 39px; height: 39px; margin-top: 7px; margin-left: 1px; border-radius: 200px;"/>
					<?php } else { ?>
					<img src="<?php echo $home; ?>assets/img/photo_avatar.png" style="width: 39px; height: 39px; margin-top: 7px; margin-left: 2px; border-radius: 200px;"/>
					<?php } ?>
				</div>
				<div style="width: 278px; height: 58px; margin-left: 10px; margin-top: 3px; float: left;color: #2380ae;">
					<p style="margin:0px; margin-top: 3px;text-align:center;"><b><?php echo $row['full_name']; ?></b></p>
					<p style="margin:0px;margin-top: -3px; font-size: 13px;text-align:center;"><?php echo $row['designation_name']; ?> - <?php echo $row['department_name']; ?>(<?php echo $row['employee_id']; ?>)</p>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-sm-12" style="margin-top:20px;">
		<button id="print_button" class="btn btn-sm btn-success"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;PRINT</button> <!-- onclick="return downloadSVG()"-->
	</div>
</div>
<script>/*
function downloadSVG() {
  const svg = document.getElementById('download_id_card').innerHTML;
  const blob = new Blob([svg.toString()]);
  const element = document.createElement("a");
  element.download = "w3c.svg";
  element.href = window.URL.createObjectURL(blob);
  element.click();
  element.remove();
}*/
</script>	
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