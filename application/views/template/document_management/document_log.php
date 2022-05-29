<table id="booking_data_table" class="display table table-sm table-bordered table table-striped">
		<thead>
			<tr>
				<th>Id</th>
				<th>Document</th>
				<th>Renew Date</th>
				<th>Expiration Date</th>
				<th>Image</th>
				<th>Note</th>
			</tr>
		</thead>
		<tbody>
		
		<?php foreach($results as $result) { ?>									
			<tr>
				<td><?php echo $result->id;?></td>
				<td><?php echo $result->document_name; ?></td>
				<td><?php echo $result->renew_date; ?></td>
				<td><?php echo $result->expiration_date; ?></td>
				<td><img 
				class="log_img" data-toggle="modal" data-target="#log_imgModal" data-id="<?php echo $result->id; ?>"
				width="50px" src="<?php echo base_url("assets/uploads/documents/".$result->file_url); ?>" /></td>
				<td><?php echo $result->note; ?></td>
				
			</tr>
		<?php } ?>	

	
		</tbody>
	</table>
