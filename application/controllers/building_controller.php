<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class building_controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');		
	}

    public function add_building_info()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
		else
		{
            $data = array();
            if(!isset($_SESSION['super_admin']['email'])){
                redirect(base_url('admin/login'));
            }else{			
                $data['title_info'] = 'Add Building';
                $data['header'] = $this->load->view('include/header','',TRUE); 
                $data['nav'] = $this->load->view('include/nav','',TRUE); 
                $data['article'] = $this->load->view('/template/building/add_building',$data,TRUE); 
                $data['footer'] = $this->load->view('include/footer','',TRUE); 
                $this->load->view('dashboard',$data);		
            }
		}
    }

    public function insert_building_info()
    {    
        
        if(!isset($_SESSION['super_admin']['email'])){ 
			redirect(base_url('admin/login'));
		}
        else
        {
                $count = count($_FILES['files']['name']);
                
                for($i=0;$i<$count;$i++){
                    $data = [];
                            if(!empty($_FILES['files']['name'][$i])){
                        
                            $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                    
                            $config['upload_path'] = 'building_images/'; 
                            $config['allowed_types'] = '*';
                            $config['max_size'] = '5000';
                            $config['file_name'] = $_FILES['files']['name'][$i];
                
                            $this->load->library('upload',$config); 
                
                            if($this->upload->do_upload('file')){
                                $uploadData = $this->upload->data();
                                $filename = $uploadData['file_name'];
                                $data['random_id'] = $_POST['rand'];
                                $data['image'] = $filename;
                            }
                    }
                    $this->Dashboard_model->insert('building_images', $data);
                
                }
             $front_array = array();
             $fornt_errors = "";
             $config_two['upload_path'] = 'building_images/'; 
             $config_two['allowed_types'] = '*';
             $config_two['max_size'] = '5000';
             $this->load->library('upload', $config_two);
             if(!$this->upload->do_upload('front_image')){
               $fornt_errors = $this->upload->display_errors();
             }
             else
             {
                 $front_array = $this->upload->data();
                 $file_name = $front_array['file_name'];
                 $full_data['front_image'] = $config_two['upload_path'].$file_name;
                 
             }


             $map = array();
             $map_errors = "";
             $config_three['upload_path'] = 'building_images/'; 
             $config_three['allowed_types'] = '*';
             $config_three['max_size'] = '5000';
             $this->load->library('upload', $config_three);
             if(!$this->upload->do_upload('map_image')){
               $map_errors = $this->upload->display_errors();
             }
             else
             {
                 $front_array = $this->upload->data();
                 $file_name = $front_array['file_name'];
                 $full_data['map_image'] = $config_three['upload_path'].$file_name;
                 
             }

            $employee_id = $_SESSION['super_admin']['employee_ids'];
            //$full_data = array();
            $full_data['building_age'] = $_POST['building_age'];
            $full_data['building_rand_id'] = $_POST['rand'];
            $full_data['owner_name'] = $_POST['owner_name'];
            $full_data['owner_phone'] = $_POST['owner_phone'];
            $full_data['area'] = $_POST['area'];
            $full_data['address'] = $_POST['address'];
            $full_data['building_type'] = $_POST['building_type'];
            $full_data['bulding_floor'] = $_POST['bulding_floor'];
            $full_data['rent_per_sqft'] = $_POST['rent_per_sqft'];
            $full_data['full_unit_size'] = $_POST['full_unit_size'];
            $full_data['rent'] = $_POST['rent'];
            $full_data['bed'] = $_POST['bed'];
            $full_data['toilet'] = $_POST['toilet'];
            $full_data['living_room'] = $_POST['living_room'];
            $full_data['dining'] = $_POST['dining'];
            $full_data['belcony'] = $_POST['belcony'];
            $full_data['basement_parking'] = $_POST['basement_parking'];
            $full_data['generator'] = $_POST['generator'];
            $full_data['elevator'] = $_POST['elevator'];
            $full_data['electric_bill'] = $_POST['electric_bill'];
            $full_data['water_bill'] = $_POST['water_bill'];
            $full_data['gas_bill'] = $_POST['gas_bill'];
            $full_data['service_charge'] = $_POST['service_charge'];
            $full_data['have_furniture'] = $_POST['have_furniture'];
            $full_data['google_map'] = $_POST['google_map'];
            $full_data['uploader_info'] = $employee_id;
            $full_data['substation'] = $_POST['substation'];
            $full_data['servant_washroom'] = $_POST['servant_washroom'];
            $full_data['room_per_unit'] = $_POST['room_per_unit'];;
            $full_data['total_room'] = $_POST['total_room'];
            $full_data['location_code'] = $_POST['location_code'];
            $full_data['contact_no'] = $_POST['contact_no'];
            $full_data['contact_person'] = $_POST['contact_person'];
            $full_data['found_by'] = $_POST['found_by'];
            $full_data['height'] = $_POST['height'];
            // $full_data['front_image'] = $front_image;
            // $full_data['map_image'] = $map_image;
            $this->Dashboard_model->insert('buildings', $full_data);
            alert('success', 'Successfully Saved!');
            redirect(base_url('admin/add_building_info'));
        }
        
       
    }

    public function all_building_info()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
		else
		{
			$data['buildings'] =  $this->Dashboard_model->mysqlii("SELECT * FROM buildings ORDER BY id DESC");
			// $this->load->view('hrm_add_department',$department);
			$data['title_info'] = 'All Building';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('/template/building/all_building',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
		}
    }

    public function edit_building($id)
    {
            $data['building'] =  $this->Dashboard_model->mysqlij("SELECT * FROM buildings WHERE id=$id");
			$data['departments'] =  $this->Dashboard_model->mysqlii("SELECT * FROM department");
			$data['designations'] = $this->Dashboard_model->mysqlii("SELECT * FROM designation ORDER BY ID DESC");
			$data['title_info'] = 'Edit Building';
			$data['header'] = $this->load->view('include/header','',TRUE); 
			$data['nav'] = $this->load->view('include/nav','',TRUE); 
			$data['article'] = $this->load->view('/template/building/edit_building',$data,TRUE); 
			$data['footer'] = $this->load->view('include/footer','',TRUE); 
			$this->load->view('dashboard',$data);
    }

    public function delete_building_image($id)
    {
        $this->Dashboard_model->mysqliq("DELETE FROM building_images WHERE id=$id");
		echo "Successfully Deleted";
    }

    public function update_building_info()
    {
        $id = $_POST['id'];
        $get_data = $this->Dashboard_model->mysqlij("SELECT * FROM buildings WHERE id=$id");
        
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}
        else
        {
            $count = count($_FILES['files']['name']);
            if($count > 0)
            {
                for($i=0;$i<$count;$i++){
                    $data = [];
                    if(!empty($_FILES['files']['name'][$i])){
                        
                        $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                
                        $config['upload_path'] = 'building_images/'; 
                        $config['allowed_types'] = '*';
                        $config['max_size'] = '5000';
                        $config['file_name'] = $_FILES['files']['name'][$i];
                
                        $this->load->library('upload',$config); 
            
                        if($this->upload->do_upload('file')){
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];
                            $data['random_id'] = $_POST['rand'];
                            $data['image'] = $filename;
                        }
                    }
                    
                    if(!empty($data)){
                        $this->Dashboard_model->insert('building_images', $data);
                    }
                    
                
                }

            }
            
           if(!empty($_FILES['front_image']) && !empty($_FILES['map_image']))
           {
                $front_array = array();
                $fornt_errors = "";
                $config_two['upload_path'] = 'building_images/'; 
                $config_two['allowed_types'] = '*';
                $config_two['max_size'] = '5000';
                $this->load->library('upload', $config_two);
                if(!$this->upload->do_upload('front_image')){
                $fornt_errors = $this->upload->display_errors();
                }
                else
                {
                    $front_array = $this->upload->data();
                    $file_name = $front_array['file_name'];
                    $full_data['front_image'] = $config_two['upload_path'].$file_name;
                    
                }


                $map = array();
                $map_errors = "";
                $config_three['upload_path'] = 'building_images/'; 
                $config_three['allowed_types'] = '*';
                $config_three['max_size'] = '5000';
                $this->load->library('upload', $config_three);
                if(!$this->upload->do_upload('map_image')){
                $map_errors = $this->upload->display_errors();
                }
                else
                {
                    $front_array = $this->upload->data();
                    $file_name = $front_array['file_name'];
                    $full_data['map_image'] = $config_three['upload_path'].$file_name;
                    
                }
           } 
           elseif(!empty($_FILES['front_image']) && empty($_FILES['map_image']))
           {
                $front_array = array();
                $fornt_errors = "";
                $config_two['upload_path'] = 'building_images/'; 
                $config_two['allowed_types'] = '*';
                $config_two['max_size'] = '5000';
                $this->load->library('upload', $config_two);
                if(!$this->upload->do_upload('front_image')){
                $fornt_errors = $this->upload->display_errors();
                }
                else
                {
                    $front_array = $this->upload->data();
                    $file_name = $front_array['file_name'];
                    $full_data['front_image'] = $config_two['upload_path'].$file_name;
                    
                }

                $full_data['map_image'] = $get_data->map_image;
           }
           elseif(empty($_FILES['front_image']) && !empty($_FILES['map_image']))
           {
                $map = array();
                $map_errors = "";
                $config_three['upload_path'] = 'building_images/'; 
                $config_three['allowed_types'] = '*';
                $config_three['max_size'] = '5000';
                $this->load->library('upload', $config_three);
                if(!$this->upload->do_upload('map_image')){
                $map_errors = $this->upload->display_errors();
                }
                else
                {
                    $front_array = $this->upload->data();
                    $file_name = $front_array['file_name'];
                    $full_data['map_image'] = $config_three['upload_path'].$file_name;
                    
                }
                $full_data['front_image'] = $get_data->front_image;
           }
           else
           {
               $full_data['front_image'] = $get_data->front_image;
               $full_data['map_image'] = $get_data->map_image;
           }

            //$employee_id = $_SESSION['super_admin']['employee_ids'];
            //$full_data = array();
            $full_data['building_age'] = $_POST['building_age'];
            $full_data['building_rand_id'] = $_POST['rand'];
            $full_data['owner_name'] = $_POST['owner_name'];
            $full_data['owner_phone'] = $_POST['owner_phone'];
            $full_data['area'] = $_POST['area'];
            $full_data['address'] = $_POST['address'];
            $full_data['building_type'] = $_POST['building_type'];
            $full_data['bulding_floor'] = $_POST['bulding_floor'];
            $full_data['rent_per_sqft'] = $_POST['rent_per_sqft'];
            $full_data['full_unit_size'] = $_POST['full_unit_size'];
            $full_data['rent'] = $_POST['rent'];
            $full_data['bed'] = $_POST['bed'];
            $full_data['toilet'] = $_POST['toilet'];
            $full_data['living_room'] = $_POST['living_room'];
            $full_data['dining'] = $_POST['dining'];
            $full_data['belcony'] = $_POST['belcony'];
            $full_data['basement_parking'] = $_POST['basement_parking'];
            $full_data['generator'] = $_POST['generator'];
            $full_data['elevator'] = $_POST['elevator'];
            $full_data['electric_bill'] = $_POST['electric_bill'];
            $full_data['water_bill'] = $_POST['water_bill'];
            $full_data['gas_bill'] = $_POST['gas_bill'];
            $full_data['service_charge'] = $_POST['service_charge'];
            $full_data['have_furniture'] = $_POST['have_furniture'];
            $full_data['google_map'] = $_POST['google_map'];
            $full_data['uploader_info'] = $_POST['employee_id'];
            $full_data['substation'] = $_POST['substation'];
            $full_data['servant_washroom'] = $_POST['servant_washroom'];
            $full_data['room_per_unit'] = $_POST['room_per_unit'];;
            $full_data['total_room'] = $_POST['total_room'];
            $full_data['location_code'] = $_POST['location_code'];
            $full_data['contact_no'] = $_POST['contact_no'];
            $full_data['contact_person'] = $_POST['contact_person'];
            $full_data['found_by'] = $_POST['found_by'];
            $full_data['height'] = $_POST['height'];
            $this->Dashboard_model->update('buildings', $full_data, $id);
            alert('success', 'Successfully Updated!');
            redirect(base_url('admin/all_building_info'));
        }
        
    }

    public function view_building($id)
    {
        $building = $this->Dashboard_model->mysqlij("SELECT * FROM buildings WHERE id=$id");
        $building_images = $this->Dashboard_model->mysqlii("SELECT * FROM building_images WHERE random_id=$building->building_rand_id");
        ?>
            <div class="col-md-8">
                  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      <?php foreach($building_images as $idx=>$image): ?>
                      <div class="carousel-item <?= ($idx == 0) ? 'active' : '' ?>">
                        <img style="height: 800px;" class="d-block w-100" src="<?=base_url('/'."building_images/".$image->image); ?>" alt="First slide">
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  
                  </div>
                  <div class="row" style="margin-top: 50px;">
                
                <div class="col-sm-6"><img style="width: 93%; height: 400px;" src="<?=base_url('/'.$building->front_image); ?>"></div>
                <div class="col-sm-6"><img  style="width: 93%; height: 400px;" src="<?=base_url('/'.$building->map_image); ?>"></div>
                  
              </div>
              </div>

                 <div class="col-md-4">
                    <div class="row">
                    <div class="col-md-6">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <tr>
                                            <td style="text-align: center;font-weight:600;font-size:14pt;" colspan="2">
                                                Details
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:30px;">Owner Name</td>
                                            <td><?php echo $building->owner_name; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:30px;">Owner Phone</td>
                                            <td><?php echo $building->owner_phone; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Building Type</td>
                                            <td><?php echo $building->building_type; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Floor</td>
                                            <td><?php echo $building->bulding_floor; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Unit</td>
                                            <td><?php echo $building->full_unit_size; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;"">Bed</td>
                                            <td><?php echo $building->bed; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Toilet</td>
                                            <td><?php echo $building->toilet; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Living Room</td>
                                            <td><?php echo $building->living_room; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Dining</td>
                                            <td><?php echo $building->dining; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Belcony</td>
                                            <td><?php echo $building->belcony; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Parking</td>
                                            <td><?php echo $building->basement_parking; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Generator</td>
                                            <td><?php echo $building->generator; ?></td>
                                        </tr>
                                    </table>
                                  </div>

                                  <div class="col-md-6">
                                  <table class="table table-bordered" style="width: 100%;">
                                        <tr>
                                            <td style="text-align: center;font-weight:600;font-size:14pt;" colspan="2">
                                                Details
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:30px;">Elevator</td>
                                            <td><?php echo $building->elevator; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:30px;">Electric Bill</td>
                                            <td><?php echo $building->electric_bill; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Water Bill</td>
                                            <td><?php echo $building->water_bill; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Gas Bill</td>
                                            <td><?php echo $building->gas_bill; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Service Charge</td>
                                            <td><?php echo $building->service_charge; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;"">Height</td>
                                            <td><?php echo $building->height; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Room Per Unit</td>
                                            <td><?php echo $building->room_per_unit; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Found By</td>
                                            <td><?php echo $building->found_by; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Contact Person</td>
                                            <td><?php echo $building->contact_person; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Contact No</td>
                                            <td><?php echo $building->contact_no; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Substation</td>
                                            <td><?php echo $building->substation; ?></td>
                                        </tr>


                                    </table>
                                  </div>
                    </div>
                   
                 </div>
        <?php
    }

    public function print_building($id)
    {
            $data['building'] =  $this->Dashboard_model->mysqlij("SELECT * FROM buildings WHERE id=$id");
            $data['title_info'] = 'Print Building';
			
			$data['article'] = $this->load->view('/template/building/print_building',$data,TRUE); 
			
			$this->load->view('dashboard',$data); 
    }
}