<thead>
	<tr>
		<th>id</th>
		<th>Image</th>
		<th>Branch_Name</th>
		<th>Name</th>												
		<th>Phone Number</th>
		<th>Email</th>
		<th>NID</th>
		<th>Occupation</th>
		<th>Aaddress</th>
		<th>Submited_Date</th>
		<th><abbr title="How To Find Us">HTFU</abbr></th>
		<th>Action</th>
	</tr>
</thead>
	<tbody>	
		
		<tr>
			<td><?php echo $result->id; ?></td>
			<td><img style="width:30px;" id="photo_avater" src="<?php echo base_url($result->photo_avater); ?>" /></td>
			<td>
				<select name="branch" id="branch" data-update_id="<?php echo $result->id; ?>">
					<?php foreach($branches as $branch){ ?>
						<option <?php echo $result->branch_id == $branch->branch_id ? "selected":""; ?> value="<?php echo $branch->branch_id; ?>"><?php echo $branch->branch_name; ?></option>
					<?php } ?>
				</select>
			
			</td>
			<td><?php echo $result->full_name; ?></td>												
			<td><?php echo $result->phone; ?></td>
			<td><?php echo $result->email; ?></td>
			<td><?php echo $result->nid; ?></td>
			<td><?php echo $result->occupation; ?></td>
			<td><?php echo $result->permament_address; ?></td>
			<td><?php echo $result->data; ?></td>
			<th><?php echo $result->h_t_f_u; ?></th>
			<td>
			
			<script>
				var upload_id = "<?php echo $result->id; ?>";
				var name = "<?php echo $result->full_name; ?>";
			</script>
				
			<form action="<?php echo base_url('admin/booking'); ?>" method="post" class="duallistbox">
				<input type="hidden" name="hidden_id" value="<?php echo $result->id; ?>"/> 
				<input type="hidden" name="hidden_id_pre_book" value="<?php echo $result->id; ?>"/>
				<button onclick="return reupload_member_image(upload_id, name)" type="button" class="btn btn-xs btn-dark" title="Reupload Image"><i class="fas fa-image"></i></button> 
				
				<button onclick="return view_pre_book_infformation(<?php echo $result->id; ?>)" type="button" class="btn btn-xs btn-info" title="View PreBook member profile"><i class="fa fa-eye"></i></button> 
				<button onclick="return print_police_verification_form(<?php echo $result->id; ?>)" type="button" class="btn btn-xs btn-success" title="View Police Verification Print File"><i class="fa fa-print"></i></button>
			<?php if($result->status == '1') { ?>
				<button name="go_to_booking" onclick="return confirm('Are you sure want perform this action')" type="submit" class="btn btn-xs btn-info" title="Got To Booking"><i class="fa fa-pencil">Go to Booking</i></button>
			<?php } ?>
			</form>
			
			</td>
		</tr>
	
	</tbody>
	
