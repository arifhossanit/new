
<?php echo "Total Bonus Amount: ".$total_bonus; ?><br>
<?php echo "Total Employee: ".$total_employee; ?>
<table class="table table-bordered table-xs table-striped">
	<thead>
		<tr>
			<th style="width: 10px;">Serial</th>
			<th style="width: 90px;">Emp Id.</th>
			<th style="width: 180px;">Full Name</th>
			<th>Department</th>
			<th>Designation</th>
			<th>Daily. Salary</th>
			<th>Monthly. Salary</th>
			<th>Festival. Bonus</th>
			<th>Duration(%) </th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_amount = 0;
		$serial = 1;
		foreach($results as $result) { ?>
		<tr>
			<td><?php echo $serial; ?></td>
			<td><?php echo $result->employee_id; ?></td>
			<td><?php echo $result->employee_name; ?></td>
			<td><?php echo $result->employee_department; ?></td>
			<td><?php echo $result->employee_designation; ?></td>
			<td><?php echo $result->current_salary; ?></td>
			<td><?php echo $result->monthly_salary; ?></td>
			<td><?php echo $result->festival_bonus; ?></td>
			<td><?php echo $result->stability; ?></td>
		</tr>
		<?php 
		$total_amount += $result->festival_bonus;
		$serial++; } ?>
	</tbody>
</table>