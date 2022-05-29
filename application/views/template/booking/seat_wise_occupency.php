<div class="card">													
    <div class="card-body">
        <div class="form-group mb-5">
            <select  name="dashboard_bbranch_id" class="form-control w-5" onchange="get_seat_occudied_by_branch(this.value)" id="seat_occupancy_select" required>
                <?php
                    if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['user_info']['branch_name'] == 'Corporate Office'){
                        echo '<option value="">All Branch</option>';
                    }
                    if(!empty($branches)){
                        foreach($branches as $row){
                            if(!empty($branch) AND $branch == $row->branch_id){
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
        <div id="seat_wise_booking_by_branch_iframe" style="width: 100%;"></div>
		<?php
		error_reporting(0); 
			if(!empty($branch)){ 
				$branchewos = " AND beds.branch_id = '".$branch."'";
			}else{ 
				$branchewos = "";
			}		
			$room_types = $this->Dashboard_model->mysqlii("SELECT DISTINCT(name) as room_type FROM `packages_info` WHERE 1;");
			$uses = array(0,2,3,4,5,6);
			
			$graph_arr = array();
			// foreach($room_types as $item){
			// 	$graph_arr[$item] = array();
			// }

			foreach($uses as $use){
				foreach($room_types as $item){
					$count = $this->Dashboard_model->mysqlij("SELECT COUNT(*) as use_count FROM `beds` INNER JOIN rooms on rooms.id = beds.room_id WHERE rooms.room_type LIKE '%{$item->room_type}%' AND beds.uses = '" . $use. "'");
					if(!isset($graph_arr[$item->room_type])){
						$graph_arr[$use][] = array("y" => $count->use_count, "label" => $item->room_type);
					}else{
						array_push($graph_arr[$use], array("y" => $count->use_count, "label" => $item->room_type));
					}
				}
			}

			$dataPoints4 = $graph_arr[0];
			$dataPoints2 = $graph_arr[2];
			$dataPoints1 = $graph_arr[3];
			$dataPoints3 = $graph_arr[4];
			$dataPoints5 = $graph_arr[5];
			$dataPoints6 = $graph_arr[6];
							
		?>
    </div>
</div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
let get_seat_occudied_by_branch = (branch) => {
    let graph_number = 40;
    $.ajax({  
    	url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
    	method:"POST",
    	data:{ graph_number, branch_id:branch  },
    	beforeSend:function(){  },
    	success:function(data){ $('#seat_wise_booking_by_branch_iframe').html(data); }
    });
}

$('document').ready(function(){
    // let get_seat_occudied_by_branch = () => {
    //     let graph_number = 40;
    //     $.ajax({  
    //         url:"<?=base_url('assets/ajax/dashboard/graph/graph_view_by_number.php');?>",  
    //         method:"POST",
    //         data:{ graph_number, branch_id:''  },
    //         beforeSend:function(){  },
    //         success:function(data){ $('#seat_wise_booking_by_branch').html(data); }
    //     });
    // }
    var seat_wise_booking_by_branch = new CanvasJS.Chart("seat_wise_booking_by_branch_iframe", {
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
                type: "stackedBar", toolTipContent: "<b style = '\"'color:#007bff;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Booked", color: "#007bff",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            },{
                type: "stackedBar", toolTipContent: "<b style = '\"'color:#28a745;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Available", color: "#28a745",
                dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            },{
                type: "stackedBar", toolTipContent: "<b style = '\"'color:#b5b5b5;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Out of Service", color: "#b5b5b5",
                dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
            },{
                type: "stackedBar", toolTipContent: "<b style = '\"'color:#17cae7;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Employee", color: "#17cae7",
                dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
            },
                                                    
        ]
    });
    seat_wise_booking_by_branch.render();
})
</script>