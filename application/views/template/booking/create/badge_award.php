
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Badge Award</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Create</a></li>
              <li class="breadcrumb-item"><a href="#">Award</a></li>
              <li class="breadcrumb-item active">Employee IPO Commission</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>	
	<div class="content">
		<div class="container-flud">
			<div class="row" style="display:flex;width:100%;justify-content:space-around;min-height:70vh;">
				<div>
					<div class="card card-primary" style="display:flex;justify-content:space-around;width:100%;">
						<div class="card-header">
							<h3 class="card-title">Badge Award</h3>
						</div>
                        <div class="card-body" style="max-width: 1400px !important;margin-left:auto;margin-right:auto;">
                            <p style="width:50px;float:right;margin:0px;margin-right:20px;">
                                <button 
                                    style="background-color: red;color:white;border:3px solid white;border-radius:10px;font-weight:800;"
                                    data-toggle="modal" 
                                    data-target="#exampleModalCenter"
                                >
                                    CREATE
                                </button>
                            </p>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
                            <input 
                                name="how_many" 
                                value="<?php foreach($how_many as $row){ print $row->how_many;} ?>" 
                                type="hidden"
                            >
                                <?php foreach($badge_award as $row){ ?>
                                    <input 
                                        name="previous_male_badge_image_link_edited[]" 
                                        value="<?php echo $row->male_badge_image_path; ?>" 
                                        type="hidden" 
                                        class="form-control" 
                                        required placeholder="Badge Level"
                                        style="text-align: center;"
                                    >
                                    <input 
                                        name="previous_female_badge_image_link_edited[]" 
                                        value="<?php echo $row->female_badge_image_path; ?>" 
                                        type="hidden" 
                                        class="form-control" 
                                        required placeholder="Badge Level"
                                        style="text-align: center;"
                                    >
                                    <input 
                                        name="update_id[]" 
                                        value="<?php echo $row->id; ?>" 
                                        type="hidden"
                                    >
								<div class="row" style="background-color:#bcc6cf;margin-bottom:20px;padding-top:15px;border-radius:10px;display:flex;justify-content:space-evenly;width:1250px;margin-right:auto;margin-left:auto;">
									<div class="col-sm-1">
										<div class="form-group">
											<label>Level</label>
											<input 
                                                name="badge_level_edited[]" 
                                                value="<?php echo $row->level; ?>" 
                                                type="number" 
                                                class="form-control" 
                                                required placeholder="Badge Level"
                                                style="text-align: center;"
                                                readonly
                                            >
										</div>
									</div>
                                    <div class="col-sm-2">
										<div class="form-group">
											<label>Minimum</label>
											<input 
                                                name="badge_min_point_edited[]" 
                                                value="<?php echo $row->point_from; ?>" 
                                                type="number" 
                                                class="form-control" 
                                                required placeholder="Badge Level"
                                                style="text-align: center;"
                                            >
										</div>
									</div>
                                    <div class="col-sm-2">
										<div class="form-group">
											<label>Maximum</label>
											<input 
                                                name="badge_max_point_edited[]" 
                                                value="<?php echo $row->point_up_to; ?>" 
                                                type="number" 
                                                class="form-control" 
                                                required placeholder="Badge Level"
                                                style="text-align: center;"
                                                max="1000000000"
                                            >
										</div>
									</div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Update Male Badge</label>     
                                            <input 
                                                name="male_badge_edited_emage[]" 
                                                type="file" 
                                                class="form-control" 
                                                placeholder="Badge Level"
                                                style="text-align: center;padding-bottom:20px;"   
                                            />                 
                                        </div>
									</div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <img 
                                                class="form-control" 
                                                src="<?php print base_url().$row->male_badge_image_path ?>" 
                                                alt="Hello" 
                                                style="width:100px;height:80px;"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Update Female Badge</label>     
                                            <input 
                                                name="female_badge_edited_emage[]" 
                                                type="file" 
                                                class="form-control" 
                                                placeholder="Badge Level"
                                                style="text-align: center;padding-bottom:20px;"   
                                            />                 
                                        </div>
									</div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <img 
                                                class="form-control" 
                                                src="<?php print base_url().$row->female_badge_image_path ?>" 
                                                alt="Hello" 
                                                style="width:100px;height:80px;"
                                            />
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-1" style="display:flex;align-items:center;justify-content:space-around;">
                                        Hello
                                    </div> -->
								</div>
                                <?php } ?>
							</div>
							<div class="card-footer" style="text-align: center;">
								<button 
                                    style="background-color: green;color:white;border:3px solid white;border-radius:10px;padding:10px;font-weight:800;"
                                >
                                    UPDATE
                                </button>
							</div>
						</form>
					</div>
				</div>				
				
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Create New Badge</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo current_url() ?>" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Badge Level
                                        </label>
                                        <input 
                                            type="number" 
                                            readonly 
                                            class="form-control" 
                                            id="badge_level" 
                                            name="badge_level" 
                                            aria-describedby="emailHelp" 
                                            value="<?php foreach($max_award_level as $row){ print $row->last_level+1;} ?>" 
                                            placeholder="Enter email"
                                            required
                                        >
                                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">
                                            Minimum Point
                                        </label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            id="badge_minimum_point"
                                            name="badge_minimum_point"
                                            placeholder="Minimum Point"
                                            required
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">
                                            Maximum Point
                                        </label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            id="badge_maximum_point" 
                                            name="badge_maximum_point"
                                            placeholder="Maximum Point"
                                            required
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">
                                            Male Badge Image
                                        </label>
                                        <input 
                                            type="file" 
                                            class="form-control" 
                                            id="male_badge_image" 
                                            name="male_badge_image"
                                            required
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">
                                            Female Badge Image
                                        </label>
                                        <input 
                                            type="file" 
                                            class="form-control" 
                                            id="female_badge_image" 
                                            name="female_badge_image"
                                            required
                                        >
                                    </div>
                                    <div class="form-group" style="text-align: center;">
                                        <button 
                                            type="submit" 
                                            class="btn btn-primary">
                                                CREATE
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
				
	

			</div>
		</div>
	</div>
</div>
