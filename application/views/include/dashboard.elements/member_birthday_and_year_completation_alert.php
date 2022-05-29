<?php
	if(!empty($_SESSION['super_admin'])){
	if(!isset($_SESSION['birthday_notification_alert_member'])){
	$_SESSION['birthday_notification_alert_member'] = 'true';
	$check_employee = $this->Dashboard_model->mysqlii("select * from employee where role in ('2805597208697462328','1179783255713532148','1892907820998244323') and employee_id = '".$_SESSION['super_admin']['employee_ids']."'");
	if(!empty($check_employee->id)){
	$check_member = $this->Dashboard_model->mysqlii("select data from member_directory where check_in_date like '".date('d/m')."/%' and status = '1'");
	$year = explode('/',$check_member[0]->data);
	$check_birthday = $this->Dashboard_model->mysqlii("select * from member_directory where check_in_date like '".date('d/m')."/%' and status = '1' and data not like '%".$year[2]."%'");
	$count_birthday = $this->Dashboard_model->mysqlii("select count(*) as total from member_directory where check_in_date like '".date('d/m')."/%' and status = '1' and data not like '%".$year[2]."%'");
	
	if(!empty($check_birthday)){
		$counter = $count_birthday[0]->total; //
		if($counter > 0 AND $counter < 2){
			$col_class = 'col-sm-12';
			$b_class = 'col-sm-4';
			$sb_class = 'col-sm-4';			
		}else if($counter > 1 AND $counter < 3){
			$col_class = 'col-sm-6';
			$b_class = 'col-sm-6';
			$sb_class = 'col-sm-3';	
		}else if($counter > 2 AND $counter < 4){
			$col_class = 'col-sm-4';
			$b_class = 'col-sm-6';
			$sb_class = 'col-sm-3';	
		}else if($counter > 3){
			$col_class = 'col-sm-3';
			$b_class = 'col-sm-6';
			$sb_class = 'col-sm-3';	
		}
?>
<div class="modal fade" id="employee_birthday_popup">
	<div class="modal-dialog modal-xl" style="min-width:100%;margin:0px;">
		<div class="modal-content" style="background:none;">			
			<div class="modal-body close" data-dismiss="modal" id="employee_birthday_popup_body" style="padding:0px;opacity:1.0;">
				<canvas id = 'cd' style="width:100%;height:100%;position: absolute; top: 0%; bottom: 0%; left: 0%; right: 0%;opacity: 0.8;"></canvas>
				<div class="row">
					<div class="<?php if(!empty($sb_class)){ echo $sb_class; } ?>"></div>
					<div class="<?php if(!empty($b_class)){ echo $b_class; } ?>">
						<div class="card" style="margin-top:12%;max-height:755px;overflow-y:scroll;background:rgba(255,255,255,0.5);">
							<div class="card-body">
								<center>
									<h2>Today's Birthday</h2>
								</center>
								<div class="row">
									<?php foreach($check_birthday as $row){ ?>
									<div class="<?php if(!empty($col_class)){ echo $col_class; } ?>" id="width_magerment" style="margin-bottom:100px;">
										<img src="<?php echo base_url($row->photo_avater); ?>" style="width:100%;border-radius:100%;" class="set_image_height" alt=""/>
										<center>
											<span>
												<?php echo $row->full_name; ?><br />
												<span style="font-size:18px;"><?php echo $row->branch_name; ?></span>
											<span>
										</center>
									</div>
									<?php } ?>
								</div>
								
							</div>
						</div>
					</div>
					<div class="<?php if(!empty($sb_class)){ echo $sb_class; } ?>"></div>
				<div>
			</div>
		</div>
	</div>
</div>
<style>

</style>
<script>
$('document').ready(function(){
	setTimeout(function(){
		var width_magerment = $("#width_magerment").width();
		$(".set_image_height").height(width_magerment);
	}, 300 )
	
	
	var dov_height = $(window).height();
	$("#employee_birthday_popup_body").css({"height":dov_height});
	$("#employee_birthday_popup").modal('show');
})
var c = document.getElementById("c");
var ctx = c.getContext("2d");
var cw = c.width = window.innerWidth;
var ch = c.height = window.innerHeight;
var cX = cw / 2,
  cY = ch / 2;
var rad = Math.PI / 180;
var howMany = 100;
// size of the tangent
var t = 1 / 5;

ctx.strokeStyle = "white";
ctx.shadowBlur = 5;
ctx.shadowOffsetX = 2;
ctx.shadowOffsetY = 2;
ctx.shadowColor = "#333";
ctx.globalAlpha = .85;

var colors = ["#930c37", "#ea767a", "#ee6133", "#ecac43", "#fb9983", "#f9bc9f", "#f8ed38", "#a8e3f9", "#d1f2fd", "#ecd5f5", "#fee4fd", "#8520b4", "#FA2E59", "#FF703F", "#FF703F", "#F7BC05", "#ECF6BB", "#76BCAD"];
var flowers = [];
for (var hm = 0; hm < howMany; hm++) {
  flowers[hm] = {}
  flowers[hm].cx = ~~(Math.random() * cw) + 1;
  flowers[hm].cy = ~~(Math.random() * ch) + 1;
  flowers[hm].R = randomIntFromInterval(20, 50);
  flowers[hm].Ri = randomIntFromInterval(5, 7) / 10;
  flowers[hm].k = randomIntFromInterval(5, 10) / 10;
  flowers[hm].ki = randomIntFromInterval(2, 7) / 100;
  flowers[hm].K = randomIntFromInterval(5, 16) / 10;
  flowers[hm].fs = ~~(Math.random() * colors.length) + 1;
  flowers[hm].cs = ~~(Math.random() * colors.length) + 1;
  flowers[hm].nP = randomIntFromInterval(4, 10);
  flowers[hm].spacing = randomIntFromInterval(4, 10);

}

function buildRy(R, k, cx, cy, nP, spacing) {
  var r = R * k;
  var A = 360 / nP; //nP num petals
  var petals = [];
  for (var i = 0; i < nP; i++) {
    var ry = [];

    ry[ry.length] = {
      x: cx,
      y: cy
    }

    var a1 = i * A + spacing;
    var x1 = ~~(cx + R * Math.cos(a1 * rad));
    var y1 = ~~(cy + R * Math.sin(a1 * rad));

    ry[ry.length] = {
      x: x1,
      y: y1,
      a: a1
    }

    var a2 = i * A + A / 2;
    var x2 = ~~(cx + r * Math.cos(a2 * rad));
    var y2 = ~~(cy + r * Math.sin(a2 * rad));

    ry[ry.length] = {
      x: x2,
      y: y2,
      a: a2
    }

    var a3 = i * A + A - spacing
    var x3 = ~~(cx + R * Math.cos(a3 * rad));
    var y3 = ~~(cy + R * Math.sin(a3 * rad));

    ry[ry.length] = {
      x: x3,
      y: y3,
      a: a3
    }

    ry[ry.length] = {
      x: cx,
      y: cy
    }

    petals[i] = ry;

  }
  return petals
}

function update() {
  ctx.clearRect(0, 0, cw, ch);

  for (var f = 0; f < flowers.length; f++) {

    if (flowers[f].k < flowers[f].K) {
      flowers[f].R += flowers[f].Ri;
      flowers[f].k += flowers[f].ki;
    }
    var R = flowers[f].R;
    var Ri = flowers[f].Ri;
    var k = flowers[f].k;
    var ki = flowers[f].ki;
    var K = flowers[f].K;
    var cx = flowers[f].cx;
    var cy = flowers[f].cy;
    var fs = colors[flowers[f].fs];
    var cs = colors[flowers[f].cs];
    var nP = flowers[f].nP;
    var spacing = flowers[f].spacing;

    for (var petal = 0; petal < petals.length; petal++) { //console.log(petals[petal])
      petals = buildRy(R, k, cx, cy, nP, spacing);
      ctx.fillStyle = fs;
      drawCurve(petals[petal]);
    }
    drawCenter(k, cx, cy, cs);
  }

  requestId = window.requestAnimationFrame(update);
}

function drawCenter(k, cx, cy, cs) {
  ctx.beginPath();
  ctx.fillStyle = cs;
  ctx.arc(cx, cy, k * 10, 0, 2 * Math.PI)
  ctx.fill();
}

function drawCurve(p) {

  var pc = controlPoints(p); // the control points array

  ctx.beginPath();
  ctx.moveTo(p[0].x, p[0].y);
  // the first & the last curve are quadratic Bezier
  // because I'm using push(), pc[i][1] comes before pc[i][0]
  ctx.quadraticCurveTo(pc[1][1].x, pc[1][1].y, p[1].x, p[1].y);

  if (p.length > 2) {
    // central curves are cubic Bezier
    for (var i = 1; i < p.length - 2; i++) {
      ctx.bezierCurveTo(pc[i][0].x, pc[i][0].y, pc[i + 1][1].x, pc[i + 1][1].y, p[i + 1].x, p[i + 1].y);
    }
    // the first & the last curve are quadratic Bezier
    var n = p.length - 1;
    ctx.quadraticCurveTo(pc[n - 1][0].x, pc[n - 1][0].y, p[n].x, p[n].y);
  }
  ctx.fill();
}

function controlPoints(p) {
  // given the points array p calculate the control points
  var pc = [];
  for (var i = 1; i < p.length - 1; i++) {
    var dx = p[i - 1].x - p[i + 1].x; // difference x
    var dy = p[i - 1].y - p[i + 1].y; // difference y
    // the first control point
    var x1 = p[i].x - dx * t;
    var y1 = p[i].y - dy * t;
    var o1 = {
      x: x1,
      y: y1
    };

    // the second control point
    var x2 = p[i].x + dx * t;
    var y2 = p[i].y + dy * t;
    var o2 = {
      x: x2,
      y: y2
    };

    // building the control points array
    pc[i] = [];
    pc[i].push(o1);
    pc[i].push(o2);
  }
  return pc;
}

function randomIntFromInterval(mn, mx) {
  return ~~(Math.random() * (mx - mn + 1) + mn);
}

for (var f = 0; f < flowers.length; f++) {
  var R = flowers[f].R;
  var Ri = flowers[f].Ri;
  var k = flowers[f].k;
  var ki = flowers[f].ki;
  var K = flowers[f].K;
  var cx = flowers[f].cx;
  var cy = flowers[f].cy;
  var fs = colors[flowers[f].fs];
  var cs = colors[flowers[f].cs];
  var nP = flowers[f].nP;
  var spacing = flowers[f].spacing;
  var petals = buildRy(R, k, cx, cy, nP, spacing);
  ctx.fillStyle = colors[flowers[f].fs];
  for (var i = 0; i < petals.length; i++) {
    drawCurve(petals[i]);
  }
}
requestId = window.requestAnimationFrame(update);

window.setTimeout(function() {
  if (requestId) {
    window.cancelAnimationFrame(requestId)
  };
  console.log("cancelAnimationFrame")
}, 30000)

</script>
	<?php } } } } ?>