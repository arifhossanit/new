<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Building Overview</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Building Overview</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<select name="" id="branch_id" onchange="return overview_buildings();" class="form-control select2">
									<?php
										if(!empty($banches)){
											foreach($banches as $row){
												if(!empty($edit) AND $edit->branch_id == $row->branch_id){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
											}
										}
									?>	
								</select>
							</div>
						</div>
					</div>					
				</div>			
			</div>
			
			<div class="row">
				<div class="col-sm-12" id="branch_result">
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	return overview_buildings();
})
function overview_buildings(){
	branch_id = $("#branch_id").val();
	if(branch_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/building_overview.php');?>",  
			method:"POST",  
			data:{branch_id:branch_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$('#branch_result').html(data);
			}
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}
}
</script>



