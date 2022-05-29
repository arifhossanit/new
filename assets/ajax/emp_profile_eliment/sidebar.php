<div class="card card-default">
	<div class="card-header" style="height: 44px;">
		Profile
	</div>
	<div class="card-body">
		<div class="box box-primary">
			<div class="box-body box-profile">
				<center>
					<?php if(!empty($row['photo'])){ ?>
						<img class="profile-user-img img-responsive" src="<?php echo $home.$row['photo']; ?>" alt="<?php echo $row['full_name']; ?>" style="width:200px;height:210px;">
					<?php }else{ ?>
						<img class="profile-user-img img-responsive" src="<?php echo $home.'assets/img/photo_avatar.png'; ?>" alt="<?php echo $row['full_name']; ?>" style="width:200px;">
					<?php } ?>						
				</center>
				<h3 class="profile-username text-center ratin" style="padding-top:15px;padding-bottom:15px;font-size:25px;font-weight:bolder;">
					<?php echo $row['full_name']; ?> <hr />
					<?php
						if($rt_point == '5'){
							echo ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> ';
						}else if($rt_point < '5' AND '4' < $rt_point){
							echo ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> ';
						}else if($rt_point < '4' AND '3' < $rt_point){
							echo ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> ';
						}else if($rt_point < '3' AND '2' < $rt_point){
							echo ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> '; 
						}else if($rt_point < '2' AND '1' < $rt_point){
							echo ' <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> ';
						}else if($rt_point < '1' AND '0' < $rt_point){
							echo ' <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> '; 
						}
					?>
				</h3>
				<ul class="list-group list-group-unbordered">
					<li class="list-group-item listnoback">
						Staff ID : <b><span style="float:right;"><?php echo $row['employee_id']; ?></span></b>
					</li>
					<li class="list-group-item listnoback">
						Role : <b><span style="float:right;"><?php echo $role['role_name']; ?></span></b>
					</li>
					<li class="list-group-item listnoback">
						Designation : <b><span style="float:right;"><?php echo $designation['designation_name']; ?></span></b>
					</li>

					<li class="list-group-item listnoback">
						Department : <b><span style="float:right;"><?php echo $department['department_name']; ?></span></b>
					</li>
					<li class="list-group-item listnoback">
						Location: <b><span style="float:right;"><?php echo $branchn['branch_name']; ?></span></b>
					</li>
					<li class="list-group-item listnoback">
						Date Of Joining: <b><span style="float:right;"><?php echo $row['date_of_joining']; ?></span></b>
					</li>
					<li class="list-group-item listnoback">
						Phone: <b><span style="float:right;"><?php echo $row['Company_phone']; ?></span></b>
					</li>
					<li class="list-group-item listnoback">
						Email: <b><span style="float:right;"><?php echo $row['company_email']; ?></span></b>
					</li>
					<li class="list-group-item listnoback">
						Blood Group: <b><span style="float:right;"><?php echo $row['blood_group']; ?></span></b>
					</li>
					<li class="list-group-item listnoback">
						NID: <b><span style="float:right;"><?php echo $row['nid_number']; ?></span></b>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>