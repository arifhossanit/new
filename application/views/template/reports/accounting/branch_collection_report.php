
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Branch Revenue Report</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Report</a></li>
						<li class="breadcrumb-item"><a href="#">Collection Report</a></li>
						<li class="breadcrumb-item active">Branch Revenue Report</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	<div class="content">
		<div class="container-fluid">
			<div class="row">			
				<div class="col-sm-12">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Branch Revenue Report</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<p id="error-message" class="text-danger" style="display: none;"></p>
							<div class="row justify-content-between">
								<div class="col-sm-2 col-4">
									<div class="form-group">
										<label>Select Month</label>
										<input onchange="get_month_data(this.value)" type="month" id="month_filter" value="<?php if(!empty($_GET['month'])){ echo base64_decode($_GET['month']); } else{ echo date('Y-m'); } ?>" min="<?php echo date('2021-05'); ?>" class="form-control" required />
									</div>
								</div>
								<div class="col-sm-1 col-4 align-self-end">
									<div class="form-group">
										<?php if($generated){ ?>
											<button class="btn btn-success" disabled>Generated</button>
										<?php }else{ ?>
											<button onclick="generate_rank()" class="btn btn-info">Generate Rank</button>
										<?php } ?>
									</div>
								</div>
							</div>
						
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>Branch Name</th>
										<th>Total Rent</th>
										<th>Branch Salary</th>
										<th>House Rent</th>
										<th>Electricity</th>
										<th>Water</th>
										<th>Food Cost</th>
										<th>Internet</th>
										<th>Revenue</th>
										<th>Revenue - Filter</th>
									</tr>
								</thead>
								<tbody>
									<?php unset($_SESSION['profit_rank']);?>
									<?php //var_dump($electric_bills)?>
									<?php foreach($rents as $idx=>$rent) {
										if(empty($rent->branch_id)){
											continue;
										}
									?>
										<tr>
											<td><?= $rent->branch_name ?></td>
											<td><?= money($rent->rent_amount) ?></td>
											<?php $total_salary = ($salaries == NULL) ? 0 : $salaries[$rent->branch_id] ?></td>
											<td><?= money($total_salary) ?></td>
											<td><?= money($house_rents[$rent->branch_id]) ?></td>
											<td><?= money($electric_bills[$rent->branch_id]) ?></td>
											<td><?= money($water_bills[$rent->branch_id]) ?></td>
											<td><?= money($food_costs[$rent->branch_id]) ?></td>
											<td><?= money($internet_bills[$rent->branch_id]) ?></td>
											<?php $revenue = (double)$rent->rent_amount - ( $total_salary + $electric_bills[$rent->branch_id] + $house_rents[$rent->branch_id] + $water_bills[$rent->branch_id] + $food_costs[$rent->branch_id] + $internet_bills[$rent->branch_id] ) ?>
											<td><?= money($revenue) ?></td>
											<td><?= $revenue ?></td>
										</tr>
									<?php 
										$_SESSION['profit_rank'][$idx] = array(
											'branch_id' => $rent->branch_id,
											'branch_name' => $rent->branch_name,
											'month_revenue' => $revenue,
										);
									} ?>
								</tbody>
							</table>  
						</div>					
					</div>
				</div>
	

			</div>
		</div>
	</div>
</div>

<script>
function generate_rank(){
	let month = $('#month_filter').val();
	$.ajax({ 
		method:"POST", 
		url:"<?=base_url('admin/accounts/generate_rank');?>",
		data: {month},
		beforeSend:function(){ 
			$('#data-loading').html(data_loading); 
		}, 
		success:function(data){
			$('#data-loading').html(''); 

			let info = JSON.parse(data);

			if(info.error){
				$('#error-message').html(info.message);
				$('#error-message').show();
				return;
			}

			window.location.href = "<?=base_url()?>" + "admin/report/branch-revenue";
		} 
	});
}

function get_month_data(date){
	window.location.href = "<?=base_url()?>" + "admin/report/branch-revenue?month=" + btoa(date);
}	

function view_deduction_logs(dates){ 
	var profile_id = dates; 
	$.ajax({ 
		url:"<?=base_url('assets/ajax/dashboard/view_amount_dectector_data.php');?>", 
		method:"POST", 
		data:{profile_id:profile_id}, 
		beforeSend:function(){ 
			$('#data-loading').html(data_loading); 
		}, 
		success:function(data){ 
			$('#data-loading').html(''); 
			$('#view_amount_dectector_result').html(data); 
			$('#view_amount_dectector_modal').modal('show'); 
		} 
	}); 
}
$('document').ready(function(){ 
	$('#amount_dectector_form').on("submit",function(){ 
		event.preventDefault(); 
		var form = $('#amount_dectector_form')[0]; 
		var data = new FormData(form); 
		$.ajax({ 
			type: "POST", 
			enctype: 'multipart/form-data', 
			url:"<?=base_url('assets/ajax/form_submit/report/insert_deduction_data_to_database.php');?>", 
			data: data, 
			processData: false, 
			contentType: false, 
			cache: false, 
			timeout: 600000, 
			beforeSend:function(){ 
				$('buttton[name="add_adj"]').prop("disabled", true); 
				$('#data-loading').html(data_loading); 
			}, 
			success:function(data){ 
				$('#data-loading').html(''); 
				$('buttton[name="add_adj"]').prop("disabled", false); alert(data); 
				$('input[name="get_date"]').val(''); 
				$("#amount_dectector_modal").modal('hide'); 
				$("#details_collection_form").submit(); 
			} 
		}); 
		return false; 
	}) 
})
function open_adjustment_form(date){ 
	$('input[name="get_date"]').val(date); 
	$("#amount_dectector_modal").modal('show'); 
}
$(document).ready(function() {
    $('#booking_data_table').DataTable( {
		"ordering": true,
		"order": ["9", "desc"],
        "columnDefs": [
            {
                "targets": [ 9 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 0,1,2,3,4,5,6,7,8 ],
                "orderable": false,
            },
        ]
    } );
} );
</script>