<table class="table text-center display table-sm table-bordered table-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Full Name</th>
			<th>Branch</th>
			<th>Floor</th>
			<th>Room</th>
			<th>Bed</th>
			<th>Phone</th>
			<th>Award Type</th>
			<th>Anniversary</th>
		   <th>Action</th>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($results as $key=>$single){ ?>
			<tr >
				 <td><?php echo $key+1; ?></td>
				 <td><?php echo $single->FULL_NAME; ?></td>
				 <td><?php echo $single->BRANCH_NAME; ?></td>
				 <td><?php echo $single->FLOOR_NAME; ?></td>
				 <td><?php echo $single->ROOM_NAME; ?></td>
				 <td><?php echo $single->BED_NAME; ?></td>
				 <td><?php echo $single->PHONE_NUMBER; ?></td>
				 <td><?php echo $single->ANYVERSARY_TYPE." Months"; ?></td>
				 <td><?php echo $single->ANYVERSARY_DATE; ?></td>
				 
				<td>
					<a href="#" data-member_id="<?php echo $single->ID; ?>" data-anniversary_date="<?php echo $single->ANYVERSARY_DATE; ?>" class="btn btn-sm btn-warning member_profile" data-toggle="modal" data-target="#member_prifile_model"><i class="fa fa-eye"></i></a>
					
				</td>
				
			</tr>
		<?php  } ?>
	</tbody>
	
</table>