<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Chart Of Account</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Advance Acounts</a></li>
				<li class="breadcrumb-item active">Chart Of Account</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
<?php
	$_GET_ACCOUNTS = $this->Dashboard_model->mysqlii("SELECT * FROM account_type WHERE status = '1'");
	if(!empty($_GET_ACCOUNTS)){
		$_ACCOUNT_ARRAY = array();
		foreach($_GET_ACCOUNTS as $row){
			$_ACCOUNT_ARRAY[$row->id] = array(
				'parent_id' 				=> $row->parents_id,
				'branch_id' 				=> $row->branch_id,
				'code' 						=> $row->code,
				'serial' 					=> $row->serial,
				'name' 						=> $row->name,
				'oppning_balance' 			=> $row->oppning_balance,
				'closing_amount' 			=> $row->closing_amount,
				'last_transaction_type' 	=> $row->last_transaction_type,
				'balance' 					=> $row->balance,
				'id' 						=> $row->id
			);
		}
	}
	
	function createTree($array, $currentParent, $currLevel = 0, $prevLevel = -1) {
		foreach ($array as $categoryId => $row) {
			if ($currentParent == $row['parent_id']) {                       
				if ($currLevel > $prevLevel){
					echo '<ul>';
				}
				if ($currLevel == $prevLevel){ 
					echo '</li>';
				}
				echo '<li class="closed"><span class="folder">(<b>'.$row['code'].'</b>) '.$row['name'].' - '.money($row['balance']).' <button onclick="return account_open_window('.$row['id'].');" type="button" class="btn btn-dark btn-xs" style="border:none;background:none;color:#333;"><i class="far fa-eye"></i></button></span>';

				if ($currLevel > $prevLevel) { 
					$prevLevel = $currLevel; 
				}
				$currLevel++; 
				createTree ($array, $categoryId, $currLevel, $prevLevel);
				$currLevel--;               
			} 
		}
		if ($currLevel == $prevLevel){ 
			echo ' </li>
				</ul>';
		}
	}
?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">				
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="card card-success">
						<div class="card-header">
							<h4 style="float:left;">Chart Of Account</h4>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/account_tree/jquery.treeview.css" />
							<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/account_tree/red-treeview.css" />
							<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/account_tree/demo/screen.css" />
							<script src="<?php echo base_url(); ?>assets/js/account_tree/demo/jquery.cookie.js"></script>
							<script src="<?php echo base_url(); ?>assets/js/account_tree/jquery.treeview.js" type="text/javascript"></script>
							<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/account_tree/demo/demo.js"></script>

							
							<!--
							<div id="treecontrol">
								<a title="Collapse the entire tree below" href="#"><img src="<?php echo base_url(); ?>assets/js/account_tree/images/minus.gif" /> Collapse All</a>&nbsp;&nbsp;&nbsp;
								<a title="Expand the entire tree below" href="#"><img src="<?php echo base_url(); ?>assets/js/account_tree/images/plus.gif" /> Expand All</a>
							</div>-->
							
													
							
							
							<ul id="browser" class="filetree">
								<li><span class="folder">Chart Of Account</span>
									<?php createTree($_ACCOUNT_ARRAY, 0); ?>
								</li>

							</ul>
							
							
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.filetree span.folder, .filetree span.file {
    padding: 1px 0px 1px 20px;
    display: block;
    line-height: 14px;
}
.filetree li {
    padding: 3px 0 2px 25px;
}
.treeview .hitarea{
	margin-left:-25px;

</style>
<script>
$(document).ready(function(){
	$("#browser").treeview({
		toggle: function() {
			console.log("%s was toggled.", $(this).find(">span").text());
		}
	});
});
</script>