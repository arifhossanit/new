<div class="tab-pane" id="attendance">						
	<div class="row">
		<div class="col-sm-3">
			<div class="staffprofile">
				<h5>Total Present</h5>
				<?php 
					$year = date('y');
					$to_att = '0';
					$gett = $mysqli->query("SELECT * FROM employee_attendence where e_db_id = '".$row['id']."' and attendance = '1' AND years = '".$year."'");
					while($ewo = mysqli_fetch_assoc($gett)){
						if($ewo['e_db_id'] == $row['id']){
							$to_att = $to_att + $ewo['attendance'];
						}else{
							$to_att = '0';
						}
						
					}
				?>
				<h4><?php echo $to_att; ?></h4>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="halfday pull-right">                                                 
				<b> Present: <b class="text text-success">P</b></b>&nbsp;|&nbsp;
				<b> Absent: <b class="text text-danger">A</b> </b>&nbsp;|&nbsp;
				<b> Uncount: <b class="text text-danger">--</b> </b>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="download_label">Attendance Report <b><?php echo $row['full_name']; ?></b></div>
		<style> .table-sm td, .table-sm th { padding: 0px; text-align: center; } </style>
		<table class="table table-sm table-striped table-bordered table-hover dataTable no-footer" id="attendancetable" role="grid">
			<thead>
				<tr role="row">
					<th rowspan="1" colspan="1" style="width: 0px;"> Date | Month (<?php echo date('Y'); ?>)</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Jan</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Feb</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Mar</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Apr</th>
					<th rowspan="1" colspan="1" style="width: 0px;">May</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Jun</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Jul</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Aug</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Sep</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Oct</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Nov</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Dec</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = '1';										
				for($i ; $i < 32; $i++ ){
				?>
				<tr role="row" class="odd">                                                
					<td><b><?php echo $i; ?></b></td>
					<?php for($j = 1; $j < 13; $j++ ){ ?>
					<td>
						<?php 
							$get = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where e_db_id = '".$row['id']."' AND days = '".sprintf("%02d", $i)."' AND month = '".sprintf("%02d", $j)."' AND years = '".$year."' order by id asc"));
							if(!empty($get['id'])){
								if($get['attendance'] == '1'){
									echo '<span style="font-weight:bolder;color:green;">P</span>';
								}else{
									echo '<span style="font-weight:bolder;color:red;">A</span>';
								}															
							}else{
								echo '<span style="color:#f00;">--</span>';
							}												
						?>
					</td>
					<?php } ?>												
				</tr>
				<?php
				}
				?>	
						
			</tbody>
		</table>

	</div>
</div>