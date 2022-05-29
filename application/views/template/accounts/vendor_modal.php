<?php $product= $this->db->query("select * from expense_sub_type")->result(); ?>
<form method="post" class="modal-content" id="myform">
    <div class="card-body">
        <div class="form-group">
            <input type="hidden" name="current_uri" value="<?=current_url()?>">
            <input class="form-control mb-1" type="text" name="company_name" placeholder="Enter Company Name">
            <input class="form-control mb-1" type="text" name="contact_number" placeholder="Enter Contact Number">
            <input class="form-control mb-1" type="email" name="email" placeholder="Enter Email">
            <input class="form-control mb-1" type="text" name="address" placeholder="Enter Address">
        </div>
        <div class="form-group">
            <input class="form-control mb-1" type="text" name="account_number" placeholder="Enter Bank Account Number">
            <input class="form-control mb-1" type="text" name="bank_address" placeholder="Enter Bank Address">
        </div>
        <div class="form-group">
            <input class="form-control" type="text" name="note" placeholder="Note">
        </div>
        <select class="form-control" id="select-multiple" name="products[]" multiple>
            <?php 
                foreach ($product as $key => $value) {
                    echo "<option value='$value->id'>$value->head_name</option>";
                }
            ?>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>

<script>
    //  for submit form with ajax
	$("#myform").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "<?= base_url('admin/scm/manage-supplier/insert');?>",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result)
		    {
				$("#myform")[0].reset();
                $("#vendorId").append(result);
                $('.toast').toast('show');
                $('#myModal').modal('hide');
				// window.location.reload();
		    },
		  	error: function() 
	    	{
				window.location.reload();
	    	} 	        
	   	});
	}));
</script>