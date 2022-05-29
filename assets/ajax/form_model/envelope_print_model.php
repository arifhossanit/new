<?php 
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
if(isset($_POST['check_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from employee_monthly_sallary where id = '".$_POST['check_id']."'"));
$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$row['employee_id']."'"));
?>
<div class="row">
	<div class="col-sm-12" style="margin-bottom:30px;">
		<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
	</div>
	<div class="col-sm-12" style="padding:50px;padding-top:20px;">
		<div id="print_area" style="width:950px; height:450px;float:left;background-color:#eee;margin-top:500px;margin-left: -183px;transform: rotate(-270deg);"> <!---->
			<div style="height:28.8px;width:100%;margin-top: 40px;">
				<div style="width:417.04px;height:28.8px;float:left;margin-left:503px;"> 
					<span id="date_preview" style="margin-left:-13px;margin-top:7px;font-size: 22px; line-height: 35px; letter-spacing: 6px;">
						Month of Salary: <b><?php echo month_name($row['month']); ?> - <?php echo $row['year']; ?></b>
					</span>
				</div>
			</div>
			<div style="height:28.8px;width:100%;margin-top: 50px;">
				<div style="width:417.04px;height:28.8px;float:left;margin-left:503px;"> 
					<span id="date_preview" style="margin-left:-1px;margin-top:7px;font-size: 22px; line-height: 35px; letter-spacing: 2px;">
						Name: <b><?php echo $emp['full_name']; ?></b><br />						
						Designation: <b><?php echo $emp['designation_name']; ?></b><br />
						Department: <b><?php echo $emp['department_name']; ?></b><br />
						Employee ID: <b><?php echo $emp['employee_id']; ?></b><br />
						Location: <b><?php 
						$get_branch = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$emp['branch']."'"));
						echo $get_branch['branch_name'];
						?></b><br />
					</span>
				</div>
			</div>
			
		</div>
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
<?php
if(isset($_POST['month'])){
$d = explode("-",$_POST['month']);
$date = $d[1].'/'.$d[0];
$joining_date = DateTime::createFromFormat('d/m/Y', '01/' . $date);
$sql = $mysqli->query("select * from employee_monthly_sallary where salary_pay_method = 'cash' and date_full = '".$date."'");


?>
<div class="row">
	<div class="col-sm-12" style="margin-bottom:30px;">
		<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
	</div>
	<div class="col-sm-12" style="padding:50px;padding-top:20px;" id="print_area">
<?php
$i = 1;
while($row = mysqli_fetch_assoc($sql)){
	if($_POST['employee_type'] == 'New'){
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$row['employee_id']."' AND STR_TO_DATE(date_of_joining, '%d/%m/%Y') between '".$joining_date->format('Y-m-01')."' AND '".$joining_date->format('Y-m-t')."'"));
	}else{
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$row['employee_id']."' AND STR_TO_DATE(date_of_joining, '%d/%m/%Y') not between '".$joining_date->format('Y-m-01')."' AND '".$joining_date->format('Y-m-t')."'"));
	}
	if(is_null($emp)){
		continue;
	}
?>
		<div style="width:950px; height:450px;float:left;background-color:#eee;margin-top:500px;margin-bottom:470px;margin-left: -183px;transform: rotate(-270deg);"> <!---->
			<div style="height:28.8px;width:100%;margin-top: 120px;">
				<div style="width:500px;height:28.8px;float:left;margin-left:340px;"> 
					<span id="date_preview" style="margin-left:-13px;margin-top:7px;font-size: 22px; line-height: 35px; letter-spacing: 6px;">
						Month of Salary: <b><?php echo month_name($row['month']); ?> - <?php echo $row['year']; ?></b>
					</span>
				</div>
			</div>
			<div style="height:28.8px;width:100%;margin-top: 50px;">
				<div style="width:500px;height:28.8px;float:left;margin-left:332px;"> 
					<span id="date_preview" style="margin-left:-1px;margin-top:7px;font-size: 22px; line-height: 35px; letter-spacing: 2px;">
						Name: <b><?php echo $emp['full_name']; ?></b><br />						
						Designation: <b><?php echo $emp['designation_name']; ?></b><br />
						Department: <b><?php echo $emp['department_name']; ?></b><br />
						Employee ID: <b><?php echo $emp['employee_id']; ?></b><br />
						Location: <b><?php 
						$get_branch = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$emp['branch']."'"));
						echo $get_branch['branch_name'];
						?></b><br />
					</span>
				</div>
			</div>			
		</div>
<?php } ?>		
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