<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
?>
<div class="card">													
    <div class="card-body">
        <div class="form-group mb-5">
            <select  name="dashboard_bbranch_id" class="form-control select2 w-5" onchange="get_seat_occudied_by_branch()" id="seat_occupancy_select" required>
                <?php
                    if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['user_info']['branch_name'] == 'Corporate Office'){
                        echo '<option value="">All Branch</option>';
                    }
                    if(!empty($banches)){
                        foreach($banches as $row){
                            if(!empty($drop_down_v_id) AND $drop_down_v_id == $row->branch_id){
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
        <div id="seat_wise_booking_by_branch" style="height: 370px; width: 100%;"></div>
		<?php
		error_reporting(0); 
			if(!empty($_POST['branch_id'])){ 
				$branchewos = " AND beds.branch_id = '".$_POST['branch_id']."'";
			}else{ 
				$branchewos = "";
			}		
			$room_types = mysqli_fetch_all($mysqli->query("SELECT DISTINCT(name) as room_type FROM `packages_info` WHERE 1;"));
			$uses = array(0,3);
			
			$graph_arr = array();
			// foreach($room_types as $item){
			// 	$graph_arr[$item] = array();
			// }

			foreach($uses as $use){
				foreach($room_types as $item){
					$count = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(*) as use_count FROM `beds` INNER JOIN rooms on rooms.id = beds.room_id WHERE rooms.room_type LIKE '%{$item[0]}%' AND beds.uses = '" . $use. "' $branchewos"));
					if(!isset($graph_arr[$item[0]])){
						$graph_arr[$use][] = array("y" => $count['use_count'], "label" => $item[0]);
					}else{
						array_push($graph_arr[$use], array("y" => $count['use_count'], "label" => $item[0]));
					}
				}
			}

			$dataPoints4 = $graph_arr[0];
			$dataPoints1 = $graph_arr[3];
							
		?>
    </div>
</div>

<script>
// $('document').ready(function(){
    var seat_wise_booking_by_branch = new CanvasJS.Chart("seat_wise_booking_by_branch", {
        theme: "light1", //"light1", "dark1", "dark2"
        exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true, zoomEnabled: true, zoomType: "xy",
        axisY:{ 
            suffix: "", 
            minimum: 0
        },
        toolTip:{ shared: true, },
        data:[				
            {										
                type: "stackedBar", toolTipContent: "<b style = '\"'color:#ffc107;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true, name: "Occupied", color: "#ffc107",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },{
                type: "stackedBar", toolTipContent: "<b style = '\"'color:#007bff;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Available", color: "#007bff",
                dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            },
                                                    
        ]
    });
    seat_wise_booking_by_branch.render();
// })
</script>