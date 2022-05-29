<div class="content-wrapper">	
		    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
				Net Graph Configuration
			</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Create</a></li>
              <li class="breadcrumb-item"><a href="#">Netwark</a></li>
              <li class="breadcrumb-item active">Net Graph Configuration</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-4"></div>
						<div class="col-sm-4">
							<div class="card card-info">
								<div class="card-header">
									Information
								</div>
								<div class="card-body">
									<form action="<?php echo current_url(); ?>" method="POST">
										<div class="form-group">
											<label>IP Address</label>
											<input type="ip" name="ip_address" value="<?php if(!empty($info)){ echo $info->ip_address; } ?>" class="form-control" autocomplete="off" placeholder="Ip Address" required="required"/>
										</div>
										<div class="form-group">
											<label>Username</label>
											<input type="text" name="username" value="<?php if(!empty($info)){ echo $info->username; } ?>" class="form-control" autocomplete="off" placeholder="Username" required="required"/>
										</div>
										<div class="form-group">
											<label>Password</label>
											<input type="Password" name="password" value="<?php if(!empty($info)){ echo $info->password; } ?>" class="form-control" autocomplete="off" placeholder="Password" required="required"/>
										</div>
										<div class="form-group">
											<label>Max-Speed<small>(Mbps)</small></label>
											<input type="text" name="max_speed" value="<?php if(!empty($info)){ echo $info->max_speed; } ?>" class="number_int form-control" autocomplete="off" placeholder="Max- Speed" required="required"/>
										</div>
										<div class="form-group">
											<label>Interface</label>
											<input type="text" name="interface" value="<?php if(!empty($info)){ echo $info->interface; } ?>" class="form-control" autocomplete="off" placeholder="Interface" required="required"/>
										</div>
										<div class="form-group">
											<button type="submit" name="save" class="btn btn-success">Save</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-sm-4"></div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>