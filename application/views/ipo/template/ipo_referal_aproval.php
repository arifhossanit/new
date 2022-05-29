<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Investor Referal Aproval</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('ipo-member'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Investor Referal Aproval</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container-fluid">
			<div class="card card-info">
				<div class="card-header">
					<h3>Investor Referal Aproval</h3>
				</div>
				<div class="card-body">
					<style>#ipo_referal_aproval_table td{text-align:center;vertical-align: middle;}#ipo_referal_aproval_table th{text-align:center;vertical-align: middle;}</style>
					<table id="ipo_referal_aproval_table" class="table table-sm table-bordered table table-striped" style="width:100%;">
						<thead>
							<tr>
								<th>id</th>
								<th>Referad Name</th>
								<th>Referad Image</th>
								<th>Referad Contact</th>
								<th>Note</th>
								<th>Option</th>
							</tr>
						</thead>
						<tbody>	
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!----treams & condition model-->
	<div class="modal fade" id="treams_condition_modal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form id="create_booking_group" action="<?=current_url(); ?>" method="post">
					<input type="hidden" id="aproval_id" value=""/>
					<div class="modal-header btn-dark" style="background-color:#333;color:#fff;">
						<h4 class="modal-title">Read & Accept</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12" style="max-height:300px;overflow-y:scroll;margin-bottom:25px;">
								<?php
									if(!empty($trems_content)){
										echo $trems_content->content; 
									}
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<label>
									<input type="checkbox" name="aproval_accept_box" id="aproval_accept_box" required />&nbsp;&nbsp;
									I have read & Accept the terms & condition
								</label>
							</div>
						</div>
						
						<div class="row" id="aproval_button_container" style="display:none;">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-success" style="float:right;">Approve!</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End treams & condition-->
<script>
$('document').ready(function(){
	$("#create_booking_group").on('submit',function(){
		var aproval_id = $("#aproval_id").val();
		if(aproval_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/ipo/referal_id_approve.php');?>",  
				method:"POST",  
				data:{aproval_id:aproval_id},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					$('#data-loading').html('');
					$('#ipo_referal_aproval_table').DataTable().ajax.reload( null , false);
					alert(data);
					$('#treams_condition_modal').modal('hide'); 
				}  
			});  
		}else{
			alert('Field Selection missing!');
		}
		return false;
	});
})
function ipo_referal_approvaal_member(id){
	$("#aproval_id").val(id);
	$("#treams_condition_modal").modal('show');
}
$(document).ready(function(){
	
	$("#aproval_accept_box").on("change",function(){
		if(this.checked){
			$("#aproval_button_container").css({"display":"flex"});
		}else{
			$("#aproval_button_container").css({"display":"none"});
		}
	});
	$('#ipo_referal_aproval_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
		"serverSide": true,
		"ajax": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_referal_aproval_datatable.php"
	});
	$('#ipo_referal_aproval').addClass('active');
});
</script>