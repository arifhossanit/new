<?php
include("../../../application/config/ajax_config.php");
function duration($d){
	$a = explode('/',$d);			
	$date1 = $a[2].'-'.$a[1].'-'.$a[0];
	$date2 = date('Y-m-d'); 
	$diff = abs(strtotime($date2) - strtotime($date1));
	$years   = floor($diff / (365*60*60*24)); 
	$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
	$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	return $years.' Years '.$months.' Months '.$days.' Days';
}
if(isset($_POST['post_id'])){ 
$colspan = '14';
?>
<style>
#employee_overview_table_header{
	display: none;
    position: fixed;
    background-color: #fff;
    margin-top: -69px;
	    margin-left: -1px;
}
.dipart_name{
	background-color:#b2dfff;
	padding:3px;
	text-align:center;
	font-size:23px;
	border:solid 2px #333; 
}
.branch_name{
	background-color:#7992f0;
	padding:3px;
	text-align:center;
	font-size:23px;
	border:solid 3px #333; 
	font-weight:bolder;
	color:#fff;
}
.table_header{
	background-color:#0070c0;
	padding:10px;
	text-align:center;
	font-size:30px;
	color:#fff;
}
.custom_table{
	text-align:center;
}
.custom_table.table-bordered td{
    border: 1px solid #000000 !important;
}
.custom_table.table-bordered th {
    border: 1px solid #000000 !important;
}
.image_hover:hover{
	transform:scale(5.5);
	transition:0.3s;
}
</style>
<script>
function search_employee_overview(){
	var value = $('#myInput').val().toLowerCase();
	$("#employee_overview_table_search tr").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
}
</script>
<div class="row" style="font-family: cambria !important;">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-4" style="margin-bottom:15px;">
				<button type="button" class="btn btn-success" id="print_employee_data"><i class="fas fa-file-excel"></i> &nbsp;Excel Export</button>
				<button type="button" class="btn btn-success" id="print2_employee_data"><i class="fas fa-print"></i> &nbsp;Print</button>
			</div>
			<div class="col-sm-4" style="margin-bottom:15px;">
			</div>
			<div class="col-sm-4" style="margin-bottom:15px;">
				
			</div>
		</div>
		<table id="employee_overview_table_header" class="custom_table table table-sm table-bordered">
			<thead>
				<tr>
					<th class="table_header" colspan="<?php echo $colspan; ?>">
						Employee Information
					</th>
				</tr>
				<tr>
					<th class="th_11">Photo</th>
					<th class="th_22">SL</th>
					<th class="th_33">Dept. Sl No</th>
					<th class="th_44">Name</th>
					<th class="th_55">Designation</th>
					<th class="th_66">ID No</th>
					<th class="th_77">Official Number</th>
					<th class="th_88">Personal Number</th>
					<th class="th_99">Location</th>
					<th class="th_aa">Joining Date</th>
					<th class="th_bb">Employment Duration</th>
					<th class="th_cc">Facilities</th>
					<th class="th_cc1">Joining Salary</th>
					<th class="th_dd">Salary</th>
				</tr>
			</thead>
		</table>
		<table id="employee_overview_table" class="custom_table table table-sm table-bordered">
			<thead>
				<tr>
					<th class="table_header" colspan="<?php echo $colspan; ?>">
						Employee Information
					</th>
				</tr>
				<tr>
					<th class="th_1">Photo</th>
					<th class="th_2">SL</th>
					<th class="th_3">Dept. Sl No</th>
					<th class="th_4">Name</th>
					<th class="th_5">Designation</th>
					<th class="th_6">ID No</th>
					<th class="th_7">Official Number</th>
					<th class="th_8">Personal Number</th>
					<th class="th_9">Location</th>
					<th class="th_a">Joining Date</th>
					<th class="th_b">Employment Duration</th>
					<th class="th_c">Facilities</th>
					<th class="th_ccs">Joining Salary</th>
					<th class="th_d">Salary</th>
				</tr>
			</thead>
			<tbody id="employee_overview_table_search">
<?php
$b = 1;
$branch_sql = $mysqli->query("SELECT * FROM branches ORDER BY id ASC");
while($branch_row = mysqli_fetch_assoc($branch_sql)){
	$branch_employee = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM employee WHERE branch = '".$branch_row['branch_id']."' AND status != '0'"));
	
	// Starting silly code 
	$branch_salary = array();
	
	$emp_sql = $mysqli->query("SELECT * FROM employee WHERE branch = '".$branch_row['branch_id']."' AND status != '0'");
	while($emp_row = mysqli_fetch_assoc($emp_sql)){
		$inc = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_increament_logs where e_db_id = '".$emp_row['id']."' and aproval = '1'"));
		$dec = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_decreament_logs where e_db_id = '".$emp_row['id']."' and aproval = '1'"));
		$slry = $emp_row['basic_salary'] + $inc['total'] - $dec['total'];
		//$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$emp_row['branch']."'"));
		$branch_salary[] = $slry; 

	}
	// Ending silly code.
?>
				<tr class="branch_name">
					<td colspan="<?php echo $colspan; ?>"><?php echo $branch_row['branch_name']; ?> (<?php echo "Employee $branch_employee[0] Person"." Salary/Day: ".money(array_sum($branch_salary)); ?>)</td>
				</tr>
<?php 

$department_sql = $mysqli->query("SELECT * FROM department ORDER BY serial ASC");
while($department = mysqli_fetch_assoc($department_sql)){
	$check_employee = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM employee WHERE department = '".$department['department_id']."' AND branch = '".$branch_row['branch_id']."' AND status != '0'"));
	if($check_employee[0] > 0){
	
	// Starting silly code 
	$dpart_emp_salary = array();
	$dpart_emp_sql = $mysqli->query("SELECT * FROM employee WHERE department = '".$department['department_id']."' AND  branch = '".$branch_row['branch_id']."' AND status != '0'");
	while($dpart_emp_row = mysqli_fetch_assoc($dpart_emp_sql)){
		$dpart_inc = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_increament_logs where e_db_id = '".$dpart_emp_row['id']."' and aproval = '1'"));
		$dpart_dec = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_decreament_logs where e_db_id = '".$dpart_emp_row['id']."' and aproval = '1'"));
		$dpart_slry = $dpart_emp_row['basic_salary'] + $dpart_inc['total'] - $dpart_dec['total'];
		//$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$dpart_emp_row['branch']."'"));
		$dpart_emp_salary[] = $dpart_slry; 
	}
	// Ending silly code.
		
?>			
				<tr class="dipart_name">
					<td colspan="<?php echo $colspan; ?>"><?php echo $department['department_name']; ?> (<?php echo "Employee $check_employee[0] Person".", Salary/Day: ".money(array_sum($dpart_emp_salary)); ?>)</td>
				</tr>
<?php
$i = 1;

$desig_ql = $mysqli->query("SELECT * FROM designation ORDER BY serial ASC");
while($desig_row = mysqli_fetch_assoc($desig_ql)){
$employee_sql = $mysqli->query("SELECT * FROM employee WHERE department = '".$department['department_id']."' AND designation = '".$desig_row['designation_id']."' AND status != '0' ORDER BY id ASC");
while($employee = mysqli_fetch_assoc($employee_sql)){
	$increament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_increament_logs where e_db_id = '".$employee['id']."' and aproval = '1'"));
	$decreament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_decreament_logs where e_db_id = '".$employee['id']."' and aproval = '1'"));
	$emp_salary = $employee['basic_salary'] + $increament['total'] - $decreament['total'];
	$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$employee['branch']."'"));
	if($branch_row['branch_id'] == $employee['branch']){
?>				
				<tr>
					<td>
						<?php
							if(!empty($employee['photo'])){
								echo '<a href="'.$home.$employee['photo'].'" target="_blank"><img src="'.$home.$employee['photo'].'" style="height:15px;" class="image_hover image-responsive"/></a>';
							}
						?>
					</td>
					<td><?php echo $b++; ?></td>
					<td><?php echo $i++; ?></td>
					<td><?php echo $employee['full_name']; ?></td>
					<td><?php echo $desig_row['designation_name']; ?></td>
					<td><span style="font-weight:bolder;"><?php echo $employee['employee_id']; ?></span></td>
					<td><?php if(!empty($employee['Company_phone'])){ ?><a href="tel:<?php echo $employee['Company_phone']; ?>" target="_blank"><?php echo $employee['Company_phone']; ?></a><?php }else{ echo '<span style="color:#f00;">Empty!</span>'; } ?></td>
					<td><a href="tel:<?php echo $employee['personal_Phone']; ?>" target="_blank"><?php echo $employee['personal_Phone']; ?></a></td>
					<td><?php echo $branch['branch_name']; ?></td>					
					<td><?php echo $employee['date_of_joining']; ?></td>
					<td><?php echo duration($employee['date_of_joining']); ?></td>					
					<td><?php if(!empty($employee['assign_bed'])){ ?><?php echo $employee['assign_bed']; ?><?php }else{ echo '<span style="color:#f00;">Empty!</span>'; } ?></td>
					<td>৳ <?php echo $employee['basic_salary']; ?></td>
					<td>৳ <?php echo $emp_salary; ?></td>
				</tr>
<?php 
					}					
				}		
			}
		}
	}
}
?>				
			</tbody>
		</table>
		<div class="row">
<?php
$total_sallary = mysqli_fetch_assoc($mysqli->query("select sum(basic_salary) as total_sallary, count(id) as total_employee from employee where status = '1'"));
$increament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_increament_logs where aproval = '1' and e_db_id in(select id from employee where status = '1')"));
$decreament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_decreament_logs where aproval = '1' and e_db_id in(select id from employee where status = '1')"));
?>		
			<div class="col-sm-3"></div>
			<div class="col-sm-3"></div>
			<div class="col-sm-3">
				<span>Total Active Employee: <b style="color:#f00;"><?php echo $total_sallary['total_employee']; ?></b></span>
			</div>
			<div class="col-sm-3">			
				<span style="float:right;">Total Salary/Day: <b style="color:#f00;"><?php echo money($total_sallary['total_sallary'] + $increament['total'] - $decreament['total']); ?></b></span>
			</div>
		</div>
	</div>
</div>
<script>
$('#employee_over_view_body').on("scroll",function(){
	var get_s_height = $(this).scrollTop();	
	if(get_s_height > 65){
		$("#employee_overview_table_header").css({"display":"block"});
	}else{
		$("#employee_overview_table_header").css({"display":"none"});
	}
	$(".th_11").width($(".th_1").width());
	$(".th_22").width($(".th_2").width());
	$(".th_33").width($(".th_3").width());
	$(".th_44").width($(".th_4").width());
	$(".th_55").width($(".th_5").width());
	$(".th_66").width($(".th_6").width());
	$(".th_77").width($(".th_7").width());
	$(".th_88").width($(".th_8").width());
	$(".th_99").width($(".th_9").width());
	$(".th_aa").width($(".th_a").width());
	$(".th_bb").width($(".th_b").width());
	$(".th_cc").width($(".th_c").width());
	$(".th_cc1").width($(".th_ccs").width());
	$(".th_dd").width($(".th_d").width());
	$("#employee_overview_table_header").width($("#employee_overview_table").width() + 5);
})

$(document).ready(function() {	
	$("#print_employee_data").on("click",function(){  
	   var page = "<?php echo $home; ?>assets/ajax/option_select/employee_overview.php?excel_data=<?php echo '1234';?>&file_type=excel";  
	   window.open(page,'_blank');
	})
	$("#print2_employee_data").on("click",function(){  
	   var page = "<?php echo $home; ?>assets/ajax/option_select/employee_overview.php?excel_data=<?php echo '1234';?>&file_type=print";  
	   window.open(page,'_blank');
	})
});
</script>
<?php }else if(isset($_GET['excel_data'])){
	 if(!empty($_GET['file_type'] == 'excel')){
		 header('Content-Type: application/vnd.ms-excel');  
		 header('Content-disposition: attachment; filename='.rand().'_'.time().'_'.date('d_m_Y').'.xls');  
	 }else{
		 echo '<script>window.print();</script>';
		 echo '<script>setTimeout(function(){ window.close(); }, 500);</script>';
	 }
	 $data = '
	<style>
		.dipart_name{ background-color:#fce4d6; padding:3px; text-align:center; font-size:23px; border:solid 2px #333; }
		.branch_name{ background-color:#ddedf7; padding:3px; text-align:center; font-size:23px; border:solid 2px #333; font-weight:bolder; }
		.table_header{ background-color:#0070c0; padding:10px; text-align:center; font-size:30px; color:#fff; }
		.custom_table{ text-align:center; width:100%; font-family:arial; border-spacing:0px; }
		.custom_table.table-bordered td{ border: 1px solid #000000 !important; }
		.custom_table.table-bordered th { border: 1px solid #000000 !important; }
		.image_hover:hover{ transform:scale(5.5); }
	</style>
		<table id="employee_overview_table" class="custom_table table table-sm table-bordered">
			<thead>
				<tr>
					<th class="table_header" colspan="12">
						Employee Information
					</th>
				</tr>
				<tr>
					<th>SL</th>
					<th>Dept. Sl No</th>
					<th>Name</th>
					<th>Designation</th>
					<th>ID No</th>
					<th>Official Number</th>
					<th>Personal Number</th>
					<th>Location</th>
					<th>Joining Date</th>
					<th>Age</th>
					<th>Facilities</th>
					<th>Sallary</th>
				</tr>
			</thead>
			<tbody>';
$b = 1;
$branch_sql = $mysqli->query("SELECT * FROM branches ORDER BY id ASC");
while($branch_row = mysqli_fetch_assoc($branch_sql)){
	$branch_employee = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM employee WHERE branch = '".$branch_row['branch_id']."' AND status != '0'"));
				$data .='<tr class="branch_name">
					<td colspan="12">'.$branch_row['branch_name'].' ('.$branch_employee[0].')</td>
				</tr>';			
$department_sql = $mysqli->query("SELECT * FROM department ORDER BY serial ASC");
while($department = mysqli_fetch_assoc($department_sql)){ 
	$check_employee = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM employee WHERE department = '".$department['department_id']."' AND branch = '".$branch_row['branch_id']."' AND status != '0'"));
	if($check_employee[0] > 0){		
				$data .= '<tr class="dipart_name">
					<td colspan="12">'.$department['department_name'].' ('.$check_employee[0].')</td>
				</tr>';
$a = 1;
$employee_sql = $mysqli->query("SELECT * FROM employee WHERE department = '".$department['department_id']."' AND status != '0' ORDER BY id ASC");
while($employee = mysqli_fetch_assoc($employee_sql)){
	$increament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_increament_logs where e_db_id = '".$employee['id']."' and aproval = '1'"));
	$decreament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_decreament_logs where e_db_id = '".$employee['id']."' and aproval = '1'"));
	$emp_salary = $employee['basic_salary'] + $increament['total'] - $decreament['total'];
	$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$employee['branch']."'"));
	if($branch_row['branch_id'] == $employee['branch']){		
				$data .= '<tr>						
					<td>'.$b++.'</td>
					<td>'.$a++.'</td>
					<td>'.$employee['full_name'].'</td>
					<td>'.$employee['designation_name'].'</td>
					<td>'.$employee['employee_id'].'</td>
					<td>'.$employee['Company_phone'].'</td>
					<td>'.$employee['personal_Phone'].'</td>
					<td>'.$branch['branch_name'].'</td>					
					<td>'.$employee['date_of_joining'].'</td>
					<td>'.duration($employee['date_of_joining']).'</td>					
					<td>'.$employee['assign_bed'].'</td>
					<td>৳ '.$emp_salary.'</td>
				</tr>';
				}
			}
		}
	}
}			
		$data .= '</tbody>
		</table>
	 ';
	echo $data;
}
?>