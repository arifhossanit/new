<?php     
 
    $branches = $this->Dashboard_model->mysqlii("SELECT DISTINCT branch_name,branch_id from  branches where branch_name not like '%Corporate Office%' ");
?>
<div>
    <div style="margin-top:30px;">
        <center>
            <span style="font-size:20pt;font-weight:900;width:60vw;background-color:#437ce6;color:white;padding:10px;border-radius:30px;">Daily Renew Monthly Report</span>
		</center>
            <div style="margin-top:20px;display:flex;justify-content:center;">
				<div >
					<form id="DailyOccupiedMonthWiseForm" action="<?php current_url()?>" method="POST">
						<select name="branch_id" id="select_branch_id" class="form-group" onchange="this.form.submit()" style="font-size:14pt;padding:5px;">
							<option value="" >All Branches</option>
							<?php foreach($branches as $row){ ?>
							<option value="<?php print $row->branch_id; ?>" ><?php print $row->branch_name ?></option>
							<?php } ?>
						</select>
				</div>
				<div style="margin-left:10px;">
						<input id="month_id" type="month" name="month" value="<?php print date('Y-m') ?>" onchange="this.form.submit()" style="font-size:14pt;padding:2px;">
					</form>
				</div>
            </div>
    </div>
    <div style="margin-top:5vh;padding:5px;">
        <div id="chartContainer_38" style="height: auto; width: 100%;"></div>
    </div>
</div>
<?php 
			$this_month = date('m');
			$this_year = date('Y');
			$d = array();
			$how_many_days = cal_days_in_month(CAL_GREGORIAN,$this_month,$this_year)+1;
			$yesterday = new DateTime('yesterday');
			
			for($i = 1; $i < $how_many_days; $i++){
			    $d[] = ($i.'/'.$this_month.'/'.$this_year);
				if( intval($yesterday->format('d')) == intval(substr($i,0,2))){
					break;
				}
			}

			$avg = 0;
			$sum = 0;
			$days = 0;

			if(empty($_POST['branch_id']) && empty($_POST['month'])){
				foreach($d as $i ){			
					if(strlen($i) == 9){
						$i = '0'.$i;
					}else{
						$i = $i;
					}	
					$current_date =  DateTime::createFromFormat('d/m/Y', $i);
					//$current_date->sub(new DateInterval('P1D'));
					$paid = $this->Dashboard_model->mysqlij("SELECT count(id) as nmbr FROM rent_info where data = '".$current_date->format('d/m/Y')."' and data_three like '%renew%' ");
					if(!empty($paid->nmbr) AND $paid->nmbr > 0){ $count_p = $paid->nmbr; }else{ $count_p = '0'; }

					$paid_graph_1[] =array( "label" => substr($i,0,6).substr($i,8,2), "y" => $count_p );
					$sum += (int)$count_p;
					$days++;
				}


			}else if(!empty($_POST['branch_id']) && empty($_POST['month'])){
	?>
            <script>
                document.getElementById('select_branch_id').value = "<?php print $_POST['branch_id']; ?>";
				document.getElementById('month_id').value = "<?php print $_POST['month']; ?>";
            </script>
    <?php
				foreach($d as $i ){		

					if(strlen($i) == 9){
						$i = '0'.$i;
					}else{
                        $i = $i;
                    }

					$current_date =  DateTime::createFromFormat('d/m/Y', $i);
					//$current_date->sub(new DateInterval('P1D'));
					$paid = $this->Dashboard_model->mysqlij("SELECT count(id) as nmbr FROM rent_info where data = '".$current_date->format('d/m/Y')."' and branch_id like '%".$_POST['branch_id']."%' and data_three like '%renew%' ");
					if(!empty($paid->nmbr) AND $paid->nmbr > 0){ $count_p = $paid->nmbr; }else{ $count_p = '0'; }
					$paid_graph_1[] =array( "label" => substr($i,0,6).substr($i,8,2), "y" => $count_p );
					$sum += (int)$count_p;
					$days++;
				}
			 }else if(empty($_POST['branch_id']) && !empty($_POST['month'])){
				?>

				<script>
					document.getElementById('select_branch_id').value = "<?php print $_POST['branch_id']; ?>";
					document.getElementById('month_id').value = "<?php print $_POST['month']; ?>";
				</script>

				<?php
				$this_month = substr($_POST['month'],5,2);
				$this_year = substr($_POST['month'],0,4);
				$how_many_days = cal_days_in_month(CAL_GREGORIAN,$this_month,$this_year)+1;
				
				$d = array();
				if((strtotime(date('Y-m')) == strtotime($_POST['month']))){
					for($i = 1; $i < $how_many_days; $i++){
						$d[] = ($i.'/'.$this_month.'/'.$this_year);
					if( intval($yesterday->format('d')) == intval(substr($i,0,2))){
						break;
						}
					}
				}else{
					for($i = 1; $i < $how_many_days; $i++){
						$d[] = ($i.'/'.$this_month.'/'.$this_year);
					}
				}

				foreach($d as $i ){	

					if(strlen($i) == 9){
						$i = '0'.$i;
					}else{
                        $i = $i;
                    }

					$current_date =  DateTime::createFromFormat('d/m/Y', $i);
					//$current_date->sub(new DateInterval('P1D'));
					$paid = $this->Dashboard_model->mysqlij("SELECT count(id) as nmbr FROM rent_info where data = '".$current_date->format('d/m/Y')."' and data_three like '%renew%' ");

					if(!empty($paid->nmbr) AND $paid->nmbr > 0){ $count_p = $paid->nmbr; }else{ $count_p = '0'; }
					$paid_graph_1[] =array( "label" => substr($i,0,6).substr($i,8,2), "y" => $count_p );
					$sum += (int)$count_p;
					$days++;
				}
			}else if(!empty($_POST['branch_id']) && !empty($_POST['month'])){
				?>

				<script>
					document.getElementById('select_branch_id').value = "<?php print $_POST['branch_id']; ?>";
					document.getElementById('month_id').value = "<?php print $_POST['month']; ?>";
				</script>

				<?php
				$this_month = substr($_POST['month'],5,2);
				$this_year = substr($_POST['month'],0,4);
				$how_many_days = cal_days_in_month(CAL_GREGORIAN,$this_month,$this_year)+1;
				
				$d = array();
				if((strtotime(date('Y-m')) == strtotime($_POST['month']))){
					for($i = 1; $i < $how_many_days; $i++){
						$d[] = ($i.'/'.$this_month.'/'.$this_year);
					if( intval($yesterday->format('d')) == intval(substr($i,0,2))){
						break;
						}
					}
				}else{
					for($i = 1; $i < $how_many_days; $i++){
						$d[] = ($i.'/'.$this_month.'/'.$this_year);
					}
				}
				foreach($d as $i ){	

					if(strlen($i) == 9){
						$i = '0'.$i;
					}else{
                        $i = $i;
                    }

					$current_date =  DateTime::createFromFormat('d/m/Y', $i);
					//$current_date->sub(new DateInterval('P1D'));
					$paid = $this->Dashboard_model->mysqlij("SELECT count(id) as nmbr FROM rent_info where data = '".$current_date->format('d/m/Y')."' and branch_id = '".$_POST['branch_id']."' and data_three like '%renew%' ");

					if(!empty($paid->nmbr) AND $paid->nmbr > 0){ $count_p = $paid->nmbr; }else{ $count_p = '0'; }
					$paid_graph_1[] =array( "label" => substr($i,0,6).substr($i,8,2), "y" => $count_p );
					$sum += (int)$count_p;
					$days++;
				}
			}


			if($days > 0){
				$avg = $sum/$days;
			}
		?>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>
			$('document').ready(function(){
				var chart_2 = new CanvasJS.Chart("chartContainer_38", {
				animationEnabled: true, exportFileName: "Paid & Due Member Graph", exportEnabled: true, theme: "light2",
				axisY:{ 
					includeZero: false,
					minimum: 0,
					labelFontSize: 12,
				},
				axisX:[{ 
					includeZero: true,
					labelFontSize: 15,
					interval:1,

				},
				{
					title : "Avarage: <?= round($avg, 2); ?>",
					titleFontColor: "green"
				}],
				legend:{ cursor: "pointer", verticalAlign: "center", horizontalAlign: "right", itemclick: toggleDataSeries },
				height:600,
				data: [{
					indexLabelFontSize: 15,
					type: "column", name: "Booking", color: "#437ce6", indexLabel: "{y}", yValueFormatString: "#0.##", showInLegend: true,
					dataPoints: <?php echo json_encode($paid_graph_1, JSON_NUMERIC_CHECK); ?>
				}],
				legend:{
				fontSize: 15,
				},
			}); chart_2.render();		 
			function toggleDataSeries(e){ if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) { e.dataSeries.visible = false; } else{ e.dataSeries.visible = true; } chart_2.render(); } })
		</script>
        