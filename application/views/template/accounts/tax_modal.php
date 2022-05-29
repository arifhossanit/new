<form class="modal-content" id="myform" action="" method="POST">
    <div class="card-body">
        <div class="form-group">
            <input type="hidden" name="tax">
            <input type="hidden" name="current_uri" value="<?=current_url()?>">
            <label for="exampleInputEmail1">Tax Name<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="tax_name" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Tax rate<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="tax_rate" required>
            <small id="emailHelp" class="form-text text-muted">Insert rate without percetage sing.</small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="tax" class="btn btn-primary">Save</button>
    </div>
</form>

<script>
    //  for submit form with ajax
	$("#myform").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "<?= base_url('admin/tax-discount');?>",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result)
		    {
                // alert(result)
				$("#myform")[0].reset();
                $("select.tax_class").each(function (){
                    $(this).append(result);
                });
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