<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Generate QR Code</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
					<li class="breadcrumb-item active">Generate QR Code</li>
					</ol>
				</div> 
			</div> 
		</div> 
	</div>
    <div class="content">
		<div class="container-flud">
			<div class="row">
				<div class="col-sm-4">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Select Members</h3>
						</div>
						<form role="form" id="generate_qr" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<div class="card-body">
								<div class="form-group">
									<label>Select Employee</label>
                                    <select name="employee_name[]" id="employee_name" multiple="multiple" class="form-control select2">
                                        <option value="">Select Employee</option>
                                        <?php foreach($member_lists as $member_list){ ?>
                                            <option value="<?php echo $member_list->employee_id?>"><?php echo $member_list->employee_id.' - '.$member_list->f_name.' '.$member_list->l_name?></option>
                                        <?php } ?>
                                    </select>
								</div>
							</div>
							<div class="card-footer">
                                <button type="submit" name="save" class="btn btn-primary">Generate QR Code</button>
							</div>
						</form>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">QR Code</h3>
						</div>
						<div class="col-sm-12" style="margin-top:20px;display: none;" id="print_button">
							<button id="print_button_visiting_card" class="btn btn-sm btn-success"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;PRINT</button> <!-- onclick="return downloadSVG()"-->
						</div>
						<div class="card-body" id="cards_show">
                            <div class="row text-center">
								<div class="col-md-12">
									<p style="font-size: 25px;">SELECT EMPLOYEE!!</p>
								</div>
							</div>
						</div>			
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?=base_url().'assets/js/printThis.js'; ?>"></script>
<script>
$('#generate_qr').on('submit', function(){
    event.preventDefault();
    employee_ids = $("#employee_name").val();
	$.ajax({
		type: 'post',
		url:"<?=base_url('assets/ajax/data_table/employee_qr_code_multiple.php');?>",
		data: {employee_ids: employee_ids},
		success: function(response){
			$('#cards_show').html(response);
			$('#print_button').show()
		} 
	})
})
$('#print_button_visiting_card').on("click", function () {
	$('#cards_show').printThis({
	});
});
</script>