<form class="modal-content" id="myform" action="" method="POST">
    <div class="card-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Unit Type Name<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="unit_type_name" required>
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
        	url: "<?= current_url();?>",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result)
		    {
                // alert(result)
				$("#myform")[0].reset();
                $("select.unit_type_class").each(function (){
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