<!-- Vertically centered discount modal -->
    <form class="modal-content" id="myform" method="POST">
      <div class="modal-body">
            <input type="hidden" name="discount">
        <div class="form-group">
            <label for="exampleInputEmail1">Discount Name<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="discount_name" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Discount Type<small class="text-danger">*</small></label>
            <select name="discount_type" class="form-control" required>
                <option value="fixed">Fixed</option>
                <option value="rate">Rate</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Discount Rate/Amount<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="discount_rate" required>
            <small id="emailHelp" class="form-text text-muted">Insert rate without percetage sing.</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="discount" class="btn btn-primary">Save</button>
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
				$("#myform")[0].reset();
                $("select.dis_class").each(function (){
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