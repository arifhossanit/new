<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Investor Referal Member</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('ipo-member'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Investor Referal Member</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container-fluid">
			<div class="card card-info">
				<div class="card-header">
					<h3>Investor Referal Member</h3>
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
								<th>Comission</th>
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

<script>


$(document).ready(function(){
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
		"ajax": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_referal_member_datatable.php"
	});
	$('#ipo_referal_member').addClass('active');
});
</script>