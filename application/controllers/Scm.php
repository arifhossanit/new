<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scm extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');	
		$this->load->library('form_validation');		
	}

    public function product_category_view(){
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $data['scales'] = $this->Dashboard_model->select('scm_scales',$condition,'id','ASC','result');
            // $join_condition = array(
            //     ''
            // );
            $data['products'] = $this->Dashboard_model->select_join('scm_product_category.*, scm_product_types.name as type_name, scm_product_types.id as type_id', 'scm_product_category','scm_product_types', 'scm_product_category.product_types_id = scm_product_types.id','','','scm_product_category.id','ASC');
            $data['types'] = $this->Dashboard_model->select('scm_product_types',$condition,'id','ASC','result');
            $data['title_info'] = 'Add Product Category';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/product_category',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function product_brand_view(){
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Add Product Brands';
            $data['header'] = $this->load->view('include/header','',TRUE);
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/product_brand_view',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }   
    public function extra_specification_view()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $data['extra_specifications'] = $this->Dashboard_model->select('scm_product_extra_specification',$condition,'id','ASC','result');
            $data['title_info'] = 'Add Product Configuration';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/product_extra_specification',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    } 
    public function product_type_view(){
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $data['scales'] = $this->Dashboard_model->select('scm_scales',$condition,'id','ASC','result');
            $data['product_units'] = $this->Dashboard_model->select('scm_unit',$condition,'id','ASC','result');
            $data['title_info'] = 'Add Product Scales';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/product_type',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function add_configuration()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $error = false;
            $date_time = date("Y:m:d H:i:s");
            $_POST['product_category_id_modal'];
            foreach ($_POST['product_specification'] as $product_specification){
                $data = array(
                    'product_extra_specification_id' => $product_specification,
                    'product_category_id' => $_POST['product_category_id_modal'],
                    'created_at' => $date_time,
                    'updated_at' => $date_time,
                    'updated_by' => $_SESSION['super_admin']['employee_ids'],
                    'created_by' => $_SESSION['super_admin']['employee_ids']
                );
                if(!$this->Dashboard_model->insert('scm_has_product_specification',$data)){
                    $error = true;
                    break;
                }
            }
            if(!$error){
                alert('success','Added Product Configuration!');
                redirect(base_url('admin/scm/product-category'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    // category
    public function insert()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $error = false;
            $date_time = date("Y:m:d H:i:s");
            $categories = explode(',',$_POST['product_category']);
            foreach($categories as $category){
                $product_category = array(
                    'name' => $category,
                    'product_types_id' => $_POST['product_type'],
                    'created_at' => $date_time,
                    'updated_at' => $date_time,
                    'updated_by' => $_SESSION['super_admin']['employee_ids'],
                    'status' => '1',
                    'created_by' => $_SESSION['super_admin']['employee_ids']
                );
                if(!$this->Dashboard_model->insert('scm_product_category',$product_category)){
                    $error = true;
                    break;
                }
            }            
            if(!$error){
                alert('success','Inserted product category!');
                redirect(base_url('admin/scm/product-category'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    
    public function update()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if(isset($_POST['product_status'])){
                $status = '1';
            }else{
                $status = '0';
            }
            $date_time = date("Y:m:d H:i:s");
            $product_category = array(
                'name' => $_POST['product_category'],
                'updated_at' => $date_time,
                'updated_by' => $_SESSION['super_admin']['employee_ids'],
                'status' => $status,
                'product_types_id' => $_POST['product_type']
            );
            if($this->Dashboard_model->update('scm_product_category',$product_category,$_POST['product_id'])){
                alert('success','Updated product category!');
                redirect(base_url('admin/scm/product-category'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function delete()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if($this->Dashboard_model->delete('scm_product_category',$this->input->post('product_id'))){
                alert('danger','Deleted product category!');
                redirect(base_url('admin/scm/product-category'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    // scales

    // extra specification
    public function extra_specification_insert()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $error = false;
            $today = date('Y-m-d H:i:s');
            $names = explode(',', $_POST['product_extra_measurement_name']);
            foreach($names as $name){
                $data = array(
                    'name' => $name,
                    'created_at' => $today,
                    'created_by' => $_SESSION['super_admin']['employee_ids'],
                    'updated_at' => $today,
                    'updated_by' => $_SESSION['super_admin']['employee_ids'],
                    'status' => '1'
                );
                if(!$this->Dashboard_model->insert('scm_product_extra_specification',$data)){
                    $error = true;
                    break;
                }
            }
            if(!$error){
                alert('success','Inserted Extra Measurement!');
                redirect(base_url('admin/scm/product-type'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }

    // product units
    public function product_unit_insert()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $error = false;
            $today = date('Y-m-d H:i:s');
            $names = explode(',', $_POST['product_units']);
            foreach($names as $name){
                $data = array(
                    'name' => $name,
                    'created_at' => $today,
                    'created_by' => $_SESSION['super_admin']['employee_ids'],
                    'updated_at' => $today,
                    'updated_by' => $_SESSION['super_admin']['employee_ids'],
                    'status' => '1'
                );
                if(!$this->Dashboard_model->insert('scm_unit',$data)){
                    $error = true;
                    break;
                }
            }
            if(!$error){
                alert('success','Inserted Product Unit!');
                redirect(base_url('admin/scm/product-type'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }

    // brands
    public function brand_insert()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $error = false;
            $date_time = date("Y:m:d H:i:s");
            $brands = explode(',' , $_POST['product_brand']);
            foreach($brands as $brand){
                $data = array(
                    'name' => $brand,
                    'product_category_id' => '',
                    'created_at' => $date_time,
                    'updated_at' => $date_time,
                    'updated_by' => $_SESSION['super_admin']['employee_ids'],
                    'status' => '1',
                    'created_by' => $_SESSION['super_admin']['employee_ids']
                );
                if(!$this->Dashboard_model->insert('scm_brands',$data)){
                    $error = true;
                }
            }
            if(!$error){
                alert('success','Inserted product brand!');
                redirect(base_url('admin/scm/product-brands'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function brand_update()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $date_time = date("Y:m:d H:i:s");
            $product_brand = array(
                'name' => $_POST['product_brand_name'],
                'product_category_id' => $_POST['product_category_id'],
                'updated_at' => $date_time,
                'updated_by' => $_SESSION['super_admin']['employee_ids']
            );
            if($this->Dashboard_model->update('scm_brands',$product_brand,$_POST['brand_id'])){
                alert('success','Updated product brand!');
                redirect(base_url('admin/scm/product-brands'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function brand_delete()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if($this->Dashboard_model->delete('scm_brands',$this->input->post('brand_id'))){
                alert('danger','Deleted product category!');
                redirect(base_url('admin/scm/product-brands'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    // types
    public function type_insert()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $date_time = date("Y:m:d H:i:s");
            $type = array(
                'name' => $_POST['product_type'],
                'created_at' => $date_time,
                'updated_at' => $date_time,
                'updated_by' => $_SESSION['super_admin']['employee_ids'],
                'status' => '1',
                'created_by' => $_SESSION['super_admin']['employee_ids']
            );
            if($this->Dashboard_model->insert('scm_product_types',$type)){
                alert('success','Inserted product type!');
                redirect(base_url('admin/scm/product-type'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function type_update()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $date_time = date("Y:m:d H:i:s");
            $product_type = array(
                'name' => $_POST['product_type'],
                'updated_at' => $date_time,
                'updated_by' => $_SESSION['super_admin']['employee_ids']
            );
            if($this->Dashboard_model->update('scm_product_types',$product_type,$_POST['type_id'])){
                alert('success','Updated product type!');
                redirect(base_url('admin/scm/product-type'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function type_delete()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if($this->Dashboard_model->delete('scm_product_types',$this->input->post('type_id'))){
                alert('danger','Deleted product type!');
                redirect(base_url('admin/scm/product-type'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    // scale
    public function scale_insert()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $date_time = date("Y:m:d H:i:s");
            $scales = array(
                'name' => $_POST['product_scales'],
                'created_at' => $date_time,
                'updated_at' => $date_time,
                'updated_by' => $_SESSION['super_admin']['employee_ids'],
                'status' => '1',
                'created_by' => $_SESSION['super_admin']['employee_ids']
            );
            if($this->Dashboard_model->insert('scm_scales',$scales)){
                alert('success','Inserted product scale!');
                redirect(base_url('admin/scm/product-type'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function scale_update()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $date_time = date("Y:m:d H:i:s");
            $product_scale = array(
                'name' => $_POST['product_scale'],
                'updated_at' => $date_time,
                'updated_by' => $_SESSION['super_admin']['employee_ids']
            );
            if($this->Dashboard_model->update('scm_scales',$product_scale,$_POST['scale_id'])){
                alert('success','Updated product scale!');
                redirect(base_url('admin/scm/product-type'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function scale_delete()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if($this->Dashboard_model->delete('scm_scales',$this->input->post('scale_id'))){
                alert('danger','Deleted product scale!');
                redirect(base_url('admin/scm/product-type'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    // products
    public function add_product_view()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $data['departments'] = $this->Dashboard_model->mysqlii('SELECT department_id, department_name from department');
            $data['scales'] = $this->Dashboard_model->select('scm_scales',$condition,'id','ASC','result');
            $data['product_categories'] = $this->Dashboard_model->select('scm_product_category',$condition,'id','ASC','result');
            $data['brands'] = $this->Dashboard_model->select('scm_brands',$condition,'id','ASC','result');
            $data['types'] = $this->Dashboard_model->select('scm_product_types',$condition,'id','ASC','result');        
            $data['extra_specifications'] = $this->Dashboard_model->select('scm_product_extra_specification',$condition,'id','ASC','result');
            $data['product_units'] = $this->Dashboard_model->select('scm_unit',$condition,'id','ASC','result');
            $data['title_info'] = 'Add Product';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/add_product',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function add_product_insert()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            // var_dump($_POST);
            // exit();
            $error = false;
            $current_time = date('Y-m-d H:i:s');
            if(isset($_POST['product_brand'])){
                $product_brand = $_POST['product_brand'];
            }else{
                $product_brand = '';
            }
            $product_category_info = explode('~',$_POST['product_category']);
            /**
             * If no product name (model name) is mentioned product name will be set to product category name
             */
            if(empty($_POST['product_name'])){
                $product_names = array($product_category_info[1]);
            }else{
                // This was done to add multiple product at a time but only one product will be added. This function is now redundened.
                $product_names = explode(',', $_POST['product_name']);
            }
            // Value initialization
            $message = 'Inserted Product Successfully!';
            $message_type = 'success';
            foreach($product_names as $product_name){
                if($this->Dashboard_model->select('scm_products', array('product_name' => $product_name, 'brand_id' => $product_brand),'id','ASC','row')){
                    $message = 'One of the product already exists!';
                    $message_type = 'warning';                    
                    continue;
                }else{
                    $image_path = $this->store('product_image', 'product_images');
                    // exit();
                    $product = array(
                        'product_category_id' => $product_category_info[0],
                        'brand_id' => $product_brand,
                        'scale_id' => $_POST['product_scale'],
                        'product_name' => $product_name,
                        'product_image' => $image_path,
                        'updated_by' => $_SESSION['super_admin']['employee_ids'],
                        'created_at' => $current_time,
                        'updated_at' => $current_time,
                        'created_by' => $_SESSION['super_admin']['employee_ids'],
                        'status' => '1',
                        'product_description' => $_POST['product_description']
                    );
                    if($this->Dashboard_model->insert('scm_products',$product)){
                        $previous_info = $this->Dashboard_model->mysqlij('SELECT max(id) as max_id from scm_products');
                        if($previous_info->max_id == NULL){
                            $id = 0;
                        }else{
                            $id = $previous_info->max_id;
                        }
                        foreach($_POST['departments_id'] as $department){
                            $department_product = array(
                                'product_id' => $id,
                                'department_id' => $department
                            );
                            $this->Dashboard_model->insert('scm_product_has_department',$department_product);
                        }
                        if(isset($_POST['product_color'])){
                            foreach($_POST['product_color'] as $product_color){
                                $product_color = array(
                                    'product_id' => $id,
                                    'color' => $product_color
                                );
                                $this->Dashboard_model->insert('scm_product_color',$product_color);
                            }
                        }
                        if($_POST['product_specification'] != 'none'){
                            foreach($_POST['specification_one'] as $idx=>$width){
                                if(isset($_POST['specification_two'])){
                                    $height = $_POST['specification_two'][$idx];
                                }else{
                                    $height = '0';
                                }
                                $measurements = array(
                                    'product_id' => $id,
                                    'width' => $width,
                                    'height' => $height,
                                    'unit' => $_POST['specification_unit'][$idx]
                                );
                                $this->Dashboard_model->insert('scm_product_measurement',$measurements);
                            }
                        }
                        $product_specification_extras = $this->Dashboard_model->mysqlii('SELECT product_extra_specification_id from scm_has_product_specification where product_category_id = '.$product_category_info[0]);
                        foreach($product_specification_extras as $product_specification_extra){
                            var_dump($_POST[$product_specification_extra->product_extra_specification_id]);
                            if(!empty($_POST[$product_specification_extra->product_extra_specification_id])){
                                $specifications = explode(',', $_POST[$product_specification_extra->product_extra_specification_id]);
                                foreach($specifications as $specification_measurement){
                                    $data = array(
                                        'product_extra_specification_id' => $product_specification_extra->product_extra_specification_id,
                                        'product_id' => $id,
                                        'name' => $specification_measurement
                                    );
                                    $this->Dashboard_model->insert('scm_product_specification',$data);
                                }
                            }                            
                        }
                        // if($_POST['extra_product_specification'] != 'none'){
                        //     foreach($_POST['extra_specification_one'] as $idx=>$width){
                        //         if(isset($_POST['extra_specification_two'])){
                        //             $height = $_POST['extra_specification_two'][$idx];
                        //         }else{
                        //             $height = '';
                        //         }
                        //         $measurements = array(
                        //             'product_id' => $id,
                        //             'width' => $width,
                        //             'height' => $height,
                        //             'unit' => $_POST['extra_specification_unit'][$idx],
                        //             'name' => $_POST['extra_product_specification']
                        //         );
                        //         $this->Dashboard_model->insert('scm_extra_product_measurement',$measurements);
                        //     }
                        // }
                        // redirect(current_url());
                    }else{
                        $error = true;
                        break;
                        // redirect(current_url());
                    }
                }
            }
            if(!$error){

                alert($message_type,$message);
                redirect(base_url('admin/scm/add-product'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
            }
        }
    }
    public function add_product_delete()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if($this->Dashboard_model->delete('scm_products',rahat_decode($this->input->post('product_id')))){
                alert('success','Product removed successfully!');
                redirect(base_url('admin/scm/products-list'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
            }
        }
    }

    public function edit_product_view($product_id)
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $product = $this->Dashboard_model->mysqlij(
            "SELECT scm_products.brand_id, scm_product_types.id as product_type_id, scm_product_category.id as product_category_id from scm_products
                INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id
                INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id
                where scm_products.id = ".$product_id
            );
            $data['product'] = $product;
            $data['product_categories'] = $this->Dashboard_model->select('scm_product_category',array('status' => '1', 'product_types_id' => $product->product_type_id),'id','ASC','result');
            $data['types'] = $this->Dashboard_model->select('scm_product_types',$condition,'id','ASC','result');
            $data['departments'] = $this->Dashboard_model->mysqlii('SELECT department_id, department_name from department');
            $data['scales'] = $this->Dashboard_model->select('scm_scales',$condition,'id','ASC','result');
            $data['brands'] = $this->Dashboard_model->select('scm_brands',$condition,'id','ASC','result');

            $data['extra_specifications'] = $this->Dashboard_model->select('scm_product_extra_specification',$condition,'id','ASC','result');
            $data['product_units'] = $this->Dashboard_model->select('scm_unit',$condition,'id','ASC','result');
            $data['title_info'] = 'Edit Product';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/edit_product',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function products_list()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $data['products'] = $this->Dashboard_model->mysqlii('SELECT scm_product_types.name, scm_scales.name, scm_product_category.name, scm_product_category.product_types_id, scm_products.* FROM `scm_products` INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id');
            $data['brands'] = $this->Dashboard_model->select('scm_brands',$condition,'id','ASC','result');
            $data['title_info'] = 'Product Lists';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/products_list',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }

    public function update_product_name_image()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data = array();
            if(!empty($_FILES['update_product_image']['name'])){
                $image_path = $this->store('update_product_image', 'product_images');
                $data['product_image'] = $image_path;
            }
            $data['product_name'] = $_POST['edit_product_name'];
            if($this->Dashboard_model->update('scm_products',$data,$_POST['edit_update_id'])) {
                echo json_encode(array('error' => false, $data));
            }else{
                echo json_encode(array('error' => true, $_POST['edit_update_id']));
            }
            return;
        }
    }

    public function item_stock_management()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );

            if(isset($_POST['refreshment_product_name'])){
                $getting_branch_name = $this->Dashboard_model->mysqlii("SELECT `branch_name` from branches where `branch_id` = '".$_POST['branch_name']."' ");
                
                $gotBranchNameFronBranchTable = $getting_branch_name[0]->branch_name;
                $data = array(
                    'product_name' => $_POST['refreshment_product_name'],
                    'branch_name' => $gotBranchNameFronBranchTable,
                    'initial_quantity' => $_POST['quantity'],
                    'remaining_quantity' => $_POST['quantity'],
                );
                if($this->Dashboard_model->insert('item_stocks', $data)){
                    alert('success','Added!');
                    return redirect(base_url('admin/scm/item-stock-managemet'));
                }else{
                    alert('danger','Something Wrong! Please Try Again');
                    return redirect(base_url('admin/scm/item-stock-managemet'));
                }
            }
            if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['user_info']['department'] == '1596237883895240682'){ // Supply Chain Department
                $data['branches'] = $this->Dashboard_model->mysqlii('SELECT * from refreshment_item group by branch_name');
                $data['products'] = $this->Dashboard_model->mysqlii('SELECT * from refreshment_item');
            }else{
                $data['branches'] = $this->Dashboard_model->mysqlii('SELECT * from branches where branch_name = "'.$_SESSION['user_info']['branch_name'].'"');
                $data['products'] = $this->Dashboard_model->mysqlii('SELECT * from refreshment_item where branch_id = "'.$_SESSION['super_admin']['branch'].'"');
            }
            $data['title_info'] = 'Stock Lists';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/item_stock_managemet',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function store($file_name, $dir) {
        $filename 		= $_FILES[$file_name]["name"];
		$file_tmp 		= $_FILES[$file_name]["tmp_name"];
		$file_ext 		= substr($filename, strripos($filename, '.'));
		$newfilename 	= md5($filename).'_FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
		$newfile 		= 'assets/uploads/scm/'.$dir.'/' . $newfilename;	
		move_uploaded_file($file_tmp,$newfile);
        return $newfile;
    }
    public function product_requisition_type($purchase_order = '')
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['purchase_order'] = $purchase_order;
            $data['title_info'] = 'Product Lists';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/product_requisition_type',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function product_requisition($type, $purchase_order = '')
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            // var_dump($_GET['department_id']);
            // exit();
            if(!empty($purchase_order)){
                $data['purchase_order'] = 'yes';
            }
            $condition = array(
                'status' => '1'
            );
            if($type == 'food'){
                $where = " scm_product_types.name = 'Food' ";
            }else{
                $where = " scm_product_types.name != 'Food' ";
            }
            $query = 'SELECT department.department_name, scm_product_has_department.department_id, scm_product_types.name as types_name, scm_scales.name as scale_name, scm_product_category.name as category_name, scm_product_category.product_types_id, scm_products.*, scm_brands.name as brand_name FROM `scm_products` INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id LEFT JOIN scm_scales on scm_scales.id = scm_products.scale_id INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id INNER JOIN scm_product_has_department on scm_product_has_department.product_id = scm_products.id INNER JOIN department on department.department_id = scm_product_has_department.department_id ';
            if(!isset($_GET['clear_department'])){
                if(isset($_GET['department_id'])){
                    if(!empty($_GET['department_id'])){
                        $where .= " AND scm_product_has_department.department_id in (";
                        foreach($_GET['department_id'] as $idx=>$department_id){
                            if($idx == 0){
                                $where .= "'$department_id'";
                            }else{
                                $where .= ",'$department_id'";
                            }
                        }
                        $where .= ") ";
                        $data['department_filter'] = $_GET['department_id'];
                    }
                }
            }            
            // if(isset($_GET['product_search'])){
            if(!empty($_GET['product_name_search'])){
                $where .= ' AND ( scm_products.product_name LIKE \'%'.$_GET['product_name_search'].'%\' OR scm_brands.name LIKE \'%'.$_GET['product_name_search'].'%\' OR scm_product_category.name LIKE \'%'.$_GET['product_name_search'].'%\' )';
                $data['search_text'] = $_GET['product_name_search'];
            }
            // }
            // if($where == ''){
            //     $final_query = $query.' GROUP BY scm_products.id';
            // }else{
                $final_query = $query.' where '.$where.' GROUP BY scm_products.id LIMIT 18';
            // }
            // print_r($final_query);
            // exit();
            $data['type'] = $type;
            $data['products'] = $this->Dashboard_model->mysqlii($final_query);
            $data['departments'] = $this->Dashboard_model->mysqlii('SELECT id, department_id, department_name from department');
            $data['brands'] = $this->Dashboard_model->select('scm_brands',$condition,'id','ASC','result');
            $data['title_info'] = 'Product Lists';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/product_requisition',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function warehouses()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $data['warehouses'] = $this->Dashboard_model->select('scm_warehouses',$condition,'id','DESC','result');
            $data['title_info'] = 'Warehouses List';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/warehouses',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function insert_warehouses()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $current_time = date("Y-m-d H:i:s");
            $data = array(
                'name' => $_POST['warehouse_name'],
                'address' => $_POST['warehouse_address'],
                'status' => 1,
                'updated_by' => $_SESSION['super_admin']['employee_ids'],
                'created_at' => $current_time,
                'updated_at' => $current_time,
                'created_by' => $_SESSION['super_admin']['employee_ids'],
            );
            if($this->Dashboard_model->insert('scm_warehouses', $data)){
                alert('success','Added!');
                redirect(base_url('admin/scm/warehouses'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function warehouse_stock()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $data['departments'] = $this->Dashboard_model->mysqlii('SELECT * from department');
            $data['branches'] = $this->Dashboard_model->mysqlii('SELECT * FROM `branches`');
            $data['title_info'] = 'Warehouse Stock';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/warehouse_stock',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }    
    public function clear_cart()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            unset($_SESSION['scm_cart']);
            redirect(current_url());
            // $this->product_requisition();
        }
    }
    public function confirm_product_requisition()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            
            $error = false;
            $error_msg = '';
            $today = date('Y-m-d H:i:s');
            $check_requisition_ids = array();
            $requisition_tmp_id = '';

            if($_SESSION['user_info']['d_head']){
                $status = '0';
                $date = date('Y-m-d H:i:s');
            }else{
                $status = '10'; // Product requisition department head approval
            }

            $department_send_details_id = 0;
            if($_POST['department'] == '1818976187744468155'){ // Warehouse
                $department_requested_for = $_SESSION['user_info']['department'];
                $requisition_for = 0;
            }else{
                $employee_id = '';
                $unit_name = '';
                $room_name = '';
                if($_SESSION['user_info']['d_head']){
                    $status = '5';
                    $date = date('Y-m-d H:i:s');
                }else{
                    $status = '4';
                }
                
                /**
                 * Type own. Others types are not needed right now!
                 */
                $type = 'Own';
                $row = array(
                    'type' => $type,
                    'employee_id' => $employee_id,
                    'unit_name' => $unit_name,
                    'room_name' => $room_name,
                );
                $this->Dashboard_model->insert('scm_department_send_product_details',$row);
                $department_send_details_id = $this->db->insert_id();
                $department_requested_for = $_POST['department'];
                $requisition_for = 1;
            }

            $requisition_tmp_id = 'RQST'.$this->unique_id();
			$date = isset($date) ? $date: "";
            $data = array(
                'requisition_id' => $requisition_tmp_id,
                'requested_on' => $today,
                'requested_by' => $_SESSION['super_admin']['employee_ids'],
                'department_requested_for' => $department_requested_for,
                'department_requested_by' => $_SESSION['user_info']['department'],
                'branch_requested_for' => $_POST['branch'],
                'status' => $status,
                'approved_on' => $date,  
                'department_send_details_id' => $department_send_details_id,                                              
                'requisition_for' => $requisition_for,
            );
            $this->Dashboard_model->insert('scm_product_requisition',$data);
            
            foreach($_SESSION['scm_cart'] as $idx=>$product){
                
                
                $data = array(
                    'product_id' => $product['product_id'],
                    'requested_amount' => $product['product_amount'],
                    'approved_amount' => $product['product_amount'],
                    'color' => $product['product_color'],
                    'product_size' => $product['product_size'],
                    'requisition_id' => $requisition_tmp_id
                );
                if($this->Dashboard_model->insert('scm_product_requisition_details',$data)){
                    $condition = array(
                        'product_category_id' => $product['product_category_id']
                    );
                    $requisition_pk = $this->Dashboard_model->mysqlij('SELECT max(id) as max_id from scm_product_requisition_details');
                    $specifications = $this->Dashboard_model->select('scm_has_product_specification',$condition,'id','ASC','result');
                    foreach($specifications as $specification){
                        if(isset($product[$specification->product_extra_specification_id])){
                            $specification_data = array(
                                'requisition_pk' => $requisition_pk->max_id,
                                'scm_product_specification_id' => $product[$specification->product_extra_specification_id],
                            );
                            if(!$this->Dashboard_model->insert('scm_product_requisition_specification',$specification_data)){
                                $error = true;
                                print_r('1');
                                break;
                            }
                        }
                    }
                }else{
                    $error = true;
                    print_r('3');
                    break;
                }
            }
            
            unset($_SESSION['type']);
            unset($_SESSION['scm_cart']);
            // exit();
            if(!$error){
                alert('success','Successful!');
                redirect(base_url('admin/scm/department-requisitions'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                // redirect(current_url());
            }
            // exit();
        }
    }
    public function confirm_product_pre_purchase()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            // var_dump($_SESSION['scm_cart']);
            // exit();
            $error = false;
            $today = date('Y-m-d');
            $purchase_order_id = 'PRE'.$this->unique_id();
            $order_data = array(
                'order_date' => $today,
                'created_by' => $_SESSION['super_admin']['employee_ids'],
                'purchase_order_id' => $purchase_order_id,
                'type' => $_SESSION['type'],
            );
            if($this->Dashboard_model->insert('scm_pre_purchase_order',$order_data)){
                foreach($_SESSION['scm_cart'] as $product){
                    if(isset($_POST['bypass_warehouse'])){
                        print_r($_POST['branch']);
                        print_r($_POST['department']);
                        exit();
                    }
                    $details_data = array(
                        'product_id' => $product['product_id'],
                        'pre_purchase_order_id' => $purchase_order_id,
                        'requested_amount' => $product['product_amount'],
                        'color' => $product['product_color'],
                        'product_size' => $product['product_size'],
                        'warehouse_id' => $_POST['warehouse'],
                    );
                    if($this->Dashboard_model->insert('scm_product_order_details',$details_data)){
                        $condition = array(
                            'product_category_id' => $product['product_category_id']
                        );
                        $order_pk = $this->Dashboard_model->mysqlij('SELECT max(id) as max_id from scm_product_order_details');
                        $specifications = $this->Dashboard_model->select('scm_has_product_specification',$condition,'id','ASC','result');
                        foreach($specifications as $specification){
                            if(isset($product[$specification->product_extra_specification_id])){
                                $specification_data = array(
                                    'scm_product_order_pk' => $order_pk->max_id,
                                    'scm_product_specification_id' => $product[$specification->product_extra_specification_id],
                                );
                                if(!$this->Dashboard_model->insert('scm_product_order_specification',$specification_data)){
                                    $error = true;
                                }
                            }               
                        }
                    }
                }
            }
            unset($_SESSION['type']);
            unset($_SESSION['scm_cart']);
            if(!$error){
                alert('success','Added!');
                redirect(base_url('admin/scm/manage-product-purchase'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
            // print_r($purchase_order_id);
        }
    }
    public function unique_id()
    {
        $time_start = microtime(true);
        $time_end = explode('.', $time_start);
        $timeStamp = time();
        return $timeStamp.$time_end[1];
    }
    
    public function view_supplier()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $condition = array(
                'status' => '1'
            );
            $data['suppliers'] = $this->Dashboard_model->select_join('scm_vendor.*, scm_vendor_bank_information.account_number,scm_vendor_bank_information.bank_address','scm_vendor', 'scm_vendor_bank_information', 'scm_vendor.id = scm_vendor_bank_information.vendor_id', 'INNER JOIN', '', '', '');
            $data['product']= $this->db->query("select * from expense_sub_type")->result();
            // var_dump($data['suppliers']);
            $data['title_info'] = 'Supplier List';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/supplier',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function insert_supplier()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $error = false;
            $current_uri=$this->input->post('current_uri');
            $products= $this->input->post('products');
            $current_time = date('Y-m-d H:i:s');
            $company_name=$this->input->post('company_name');
            $contact_number=$this->input->post('contact_number');
            $email=$this->input->post('email');
            $address=$this->input->post('address');
            $note=$this->input->post('note');
            $account_number=$this->input->post('account_number');
            $bank_address=$this->input->post('bank_address');
            $data = array(
                "company_name"      => $company_name,
                "contact_number"    => $contact_number,
                "email"             => $email,
                "address"           => $address,
                "note"              => $note,
                'updated_by'        => $_SESSION['super_admin']['employee_ids'],
                'created_at'        => $current_time,
                'updated_at'        => $current_time,
                'created_by'        => $_SESSION['super_admin']['employee_ids'],
                'status'            => '1',
            );
            
            if($this->Dashboard_model->insert('scm_vendor',$data)){
                $id = $this->db->insert_id();
                foreach ($products as $value) {
                    $this->db->query("INSERT into vendor_product(scm_vendor_id,expense_sub_type_id) values('$id','$value')");
                }
                $previous_info = $this->Dashboard_model->mysqlij('SELECT max(id) as max_id from scm_vendor');
                $bank_info = array(
                    "account_number" => $account_number,
                    "bank_address"   => $bank_address,
                    "vendor_id"   => $previous_info->max_id
                );
                if(!$this->Dashboard_model->insert('scm_vendor_bank_information',$bank_info)){
                    $error = true;
                }

               if (!$error && $_POST['current_uri'] != current_url()) {
                    echo "<option value='$id'> $company_name </option>";
                    exit;
                } 
            }

            if(!$error){
                alert('success','Supplier Inserted!');
                redirect(base_url('admin/scm/manage-supplier'));
            }else{
                alert('danger',"Something Wrong! Please Try Again");
                redirect(current_url());
            }
        }
    }
    public function delete_supplier()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if($this->Dashboard_model->delete('scm_vendor',$this->input->post('supplier_id'))){
                alert('danger','Deleted Supplier!');
                redirect(base_url('admin/scm/manage-supplier'));
            }else{
                alert('danger','Something Wrong! Please Try Again');
                redirect(current_url());
            }
        }
    }
    public function manage_product_purchase()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Manage Pre Purchase';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/manage_orders',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function add_vendor()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            // var_dump($_POST['expiry_date']);
            // exit();
            // var_dump($_POST);
            $today = date("Y-m-d");
            $purchase_order_list = array();
            foreach($_POST['product_order_details_id'] as $idx=>$product_order_details_id){     //creating purchase order for each vendor
                if(array_key_exists($_POST['vendor'][$idx], $purchase_order_list)){// adding to already existing vendor
                    $existing_purchase_order_id = $purchase_order_list[$_POST['vendor'][$idx]];
                    $warrenty_expiry = "";
                    if($_POST['warrenty'][$idx] == 'Yes'){
                        $warrenty_data = array(
                            'service_warrenty_days' => $_POST['warrenty_days'][$idx],
                            'service_warrenty_months' => $_POST['warrenty_months'][$idx],
                            'service_warrenty_years' => $_POST['warrenty_years'][$idx],
                        );
                        $this->Dashboard_model->insert('scm_product_warremty',$warrenty_data);
                        $warrenty_expiry = $this->db->insert_id();
                    }else if(!empty($_POST['expiry_date'][$idx])){
                            $warrenty_data = array(
                                'expiry' => $_POST['expiry_date'][$idx],
                            );
                            $this->Dashboard_model->insert('scm_product_warremty',$warrenty_data);
                            $warrenty_expiry = $this->db->insert_id();
                    }
                    $update_data = array(
                        'purchase_order_id' => $existing_purchase_order_id,
                        'unit_price' => $_POST['product_unit_price'][$idx],
                        'warrenty_expiry' => $warrenty_expiry
                    );
                    $this->Dashboard_model->update('scm_product_order_details',$update_data,$product_order_details_id);
                }else{
                    $new_purchase_order = 'PUR'.$this->unique_id();
                    $data = array(
                        'purchase_order_id' => $new_purchase_order,
                        'order_date' => $today,
                        'created_by' => $_SESSION['super_admin']['employee_ids'],
                        'vendor_id' => $_POST['vendor'][$idx]
                    );
                    $warrenty_expiry = "";
                    if($_POST['warrenty'][$idx] == 'Yes'){
                        $warrenty_data = array(
                            'service_warrenty_days' => $_POST['warrenty_days'][$idx],
                            'service_warrenty_months' => $_POST['warrenty_months'][$idx],
                            'service_warrenty_years' => $_POST['warrenty_years'][$idx],
                        );
                        $this->Dashboard_model->insert('scm_product_warremty',$warrenty_data);
                        $warrenty_expiry = $this->db->insert_id();
                    }else if(!empty($_POST['expiry_date'][$idx])){
                            $warrenty_data = array(
                                'expiry' => $_POST['expiry_date'][$idx],
                            );
                            $this->Dashboard_model->insert('scm_product_warremty',$warrenty_data);
                            $warrenty_expiry = $this->db->insert_id();
                    }
                    $update_data = array(
                        'purchase_order_id' => $new_purchase_order,
                        'unit_price' => $_POST['product_unit_price'][$idx],
                        'warrenty_expiry' => $warrenty_expiry
                    );
                    $this->Dashboard_model->insert('scm_purchase_order',$data);
                    $this->Dashboard_model->update('scm_product_order_details',$update_data,$product_order_details_id);
                    $purchase_order_list[$_POST['vendor'][$idx]] = $new_purchase_order;
                }
            }
            $this->Dashboard_model->mysqliq("UPDATE scm_pre_purchase_order set `status` = '2' where purchase_order_id = '".$_POST['purchase_order']."'");
            redirect(base_url('admin/scm/manage-product-order'));
            exit();
            // if($this->Dashboard_model->mysqliq('UPDATE scm_purchase_order set vendor_id = "'.$_POST['vendor_id'].'" where purchase_order_id = "'.$_POST['purchase_order'].'"')){
            //     alert('success','Vendor Assigned!');
            //     redirect(base_url('admin/scm/manage-product-purchase'));
            // }else{
            //     alert('danger','Something Wrong! Please Try Again');
            //     redirect(current_url());
            // }
        }
    }
    public function add_vendor_food()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $today = date("Y-m-d");
            foreach($_POST['product_order_details_id'] as $idx=>$product_order_details_id){
                $warrenty_expiry = "";
                if(!empty($_POST['expiry_date'][$idx])){
                    $warrenty_data = array(
                        'expiry' => $_POST['expiry_date'][$idx],
                    );
                    $this->Dashboard_model->insert('scm_product_warremty',$warrenty_data);
                    $warrenty_expiry = $this->db->insert_id();
                }
                $update_data = array(
                    'unit_price' => $_POST['product_unit_price'][$idx],
                    'warrenty_expiry' => $warrenty_expiry
                );
                $this->Dashboard_model->update('scm_product_order_details',$update_data,$product_order_details_id);
            }
            $this->Dashboard_model->mysqliq("UPDATE scm_pre_purchase_order set `status` = '2' where purchase_order_id = '".$_POST['purchase_order']."'");
            redirect(base_url('admin/scm/manage-food-product-order'));
        }
    }
    public function manage_product_order()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Manage Orders';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/manage_product_orders',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function view_requisitions()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Requisitions';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/requisitions',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function manage_requisitions($requisition_id)
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['products'] = $this->Dashboard_model->mysqlii("SELECT scm_product_category.product_types_id, scm_product_measurement.width, scm_product_measurement.height, scm_product_measurement.unit, scm_products.product_name, scm_product_category.name as category_name, scm_scales.name as scale_name, scm_brands.name as brand_name, scm_product_requisition_details.*
            FROM scm_product_requisition_details
            INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id
            INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id
            INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id
            LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id
            LEFT JOIN scm_product_measurement on scm_product_measurement.id = scm_product_requisition_details.product_size
            where scm_product_requisition_details.requisition_id = '$requisition_id'");

            foreach($data['products'] as $idx=>$requested_product){
                $specification = $this->Dashboard_model->mysqlii("SELECT scm_product_extra_specification.name as specification_type, scm_product_specification.name as specification_name from scm_product_requisition_specification INNER JOIN scm_product_specification on scm_product_specification.id = scm_product_requisition_specification.scm_product_specification_id  INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where requisition_pk = ".$requested_product->id);
                if(!empty($specification)){
                    $data['products'][$idx]->specification = $specification;
                }else{
                    $data['products'][$idx]->specification = '';
                }
            }
            // var_dump($data['products'][0]->specification);
            // exit();
            $data['title_info'] = 'Manage Requisition';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/manage_requisition',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function view_department_requisitions()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Department Requisitions';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/department_requisitions',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function department_product_stock()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Department Product Stock';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/department_product_stock',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function department_product_transfer()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Department Product Stock';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/department_product_transfer',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function manage_food_order()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Manage Food Orders';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/manage_food_orders',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function manual_assign()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            // var_dump($_POST['send_to_department']);
            // exit();
            if(isset($_SESSION['warehouse_transfer_cart'])){
                $update_amount = array();
                foreach($_SESSION['warehouse_transfer_cart'] as $product){
                    $validate = $this->Dashboard_model->mysqlij("SELECT requisition_id from scm_product_requisition_details where id = ".$product['rqst_id']);
                    // var_dump($validate);
                    // exit();
                    if($validate){ 
                        $row = array(
                            'amount' => $product['amount'],
                            'scm_product_requisition_details_id' => $product['rqst_id'],
                            'scm_warehouse_product_stock_id' =>  $product['id'],
                        );
                        $this->Dashboard_model->insert('scm_product_requisition_received', $row);
                        $this->Dashboard_model->mysqliq('UPDATE scm_product_requisition_details set sent_amount = sent_amount + '.$product['amount'].' where id = '.$product['rqst_id']);
                        $this->Dashboard_model->mysqliq('UPDATE scm_warehouse_product_stock set stock_amount = stock_amount - '.$product['amount'].' where id = '.$product['id']);
                        if($product['type'] == '3'){
                            foreach($product['barcodes'] as $barcode){
                                $barcode_update = array(
                                    'product_id' => $product['rqst_id'],
                                    'id_table_name' => 'scm_product_requisition_details',
                                );
                                $this->Dashboard_model->update('scm_product_barcode', $barcode_update, $barcode);
                            }
                        }
                        $transfer_log = array(
                            'transfer_from_table' => 'scm_warehouse_product_stock',
                            'transfer_from_table_id' => $product['id'],
                            'transfer_to_table' => 'scm_product_requisition_details',
                            'transfer_to_table_id' => $product['rqst_id'],
                            'amount' => $product['amount'],
                            'transfer_type' => 'transfer',
                            'note' => 'Assigning Product for Department from Warehouse!',
                            'creation_date' => date('Y-m-d H:i:s'),
                            'created_by' => $_SESSION['super_admin']['employee_ids'],
                            'status' => '1',
                        );
                        $this->Dashboard_model->insert('scm_product_transfer_log', $transfer_log);
                        $this->Dashboard_model->mysqliq("UPDATE scm_product_requisition set `status` = 2, warehouse_exit_date = '".date('Y-m-d H:i:s')."' where requisition_id = '".$validate->requisition_id."'");
                    }else{
                        alert('danger','Something Went Wrong!');
                        redirect(base_url('admin/scm/requisitions'));
                    }
                }
                unset($_SESSION['warehouse_transfer_cart']);
            }else{
                alert('danger','Add product to cart!');
                redirect(base_url('admin/scm/requisitions'));
            }
            alert('success','Products Assign!');
            redirect(base_url('admin/scm/requisitions'));
        }
    }
    public function department_send_product()
    {
        // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        // echo $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if(isset($_SESSION['department_transfer_cart'])){
                $error = false;
                $transfer_type = $_POST['recipient_type'];
                $branch_id = '';
                $unit_name = '';
                $room_name = '';
                $barcode_stock_ids = array();
                if($transfer_type == 'storage_branch'){
                    foreach($_SESSION['department_transfer_cart'] as $idx=>$product){
                        $condition = array(
                            'scm_product_requisition_details_id' => $product['rqst_id'],
                            'scm_product_requisition_received_id' =>  $product['requisition_receive'],
                            'branch_id' => rahat_decode($_POST['branch']),
                        );
                        $existing_id = $this->Dashboard_model->select('scm_department_stock',$condition,'id','ASC','row');
                        if($existing_id){
                            if(!$this->Dashboard_model->mysqliq('UPDATE scm_department_stock set stock_amount = stock_amount + '.$product['amount'].' WHERE id = '.$existing_id->id)){
                                alert('danger','Something went wrong!');
                                redirect(base_url('admin/scm/department-product-stock'));
                            }
                        }else{
                            $row = array(
                                'stock_amount' => $product['amount'],
                                'scm_product_requisition_details_id' => $product['rqst_id'],
                                'scm_product_requisition_received_id' =>  $product['requisition_receive'],
                                'branch_id' => rahat_decode($_POST['branch']),
                            );
                            if($this->Dashboard_model->insert('scm_department_stock', $row)){
                                if($product['type'] == '3'){
                                    $update_barcode = array(
                                        'product_id' => $this->db->insert_id()
                                    );
                                    foreach($product['barcodes'] as $barcode){
                                        $this->Dashboard_model->update('scm_product_barcode', $update_barcode, $barcode);
                                    }
                                }
                            }else{
                                alert('danger','Something went wrong!');
                                redirect(base_url('admin/scm/department-product-stock'));
                            }
                        }
                        
                        $this->Dashboard_model->mysqliq("UPDATE scm_department_stock set stock_amount = stock_amount - ".$product['amount']." where id = ".$product['id']);
                    }
                    unset($_SESSION['department_transfer_cart']);
                    alert('success','Transferred successfull!');
                    redirect(base_url('admin/scm/department-product-stock'));
                }else if($transfer_type == 'Stolen'){
                    foreach($_SESSION['department_transfer_cart'] as $idx=>$product){
                        if($product['type'] != '3'){
                            $order_details_id = $this->Dashboard_model->mysqlii('SELECT scm_product_order_details.id from scm_warehouse_product_stock INNER JOIN scm_product_order_details on scm_product_order_details.id = scm_warehouse_product_stock.scm_product_order_details_id INNER JOIN scm_product_requisition_received on scm_product_requisition_received.scm_warehouse_product_stock_id = scm_warehouse_product_stock.id INNER JOIN scm_department_stock on scm_department_stock.scm_product_requisition_received_id = scm_product_requisition_received.id where scm_department_stock.id= '.$product['id']);
                            $row = array(
                                'amount' => $product['amount'],
                                'purchase_pk' => $order_details_id->id,
                                'created_by' =>  $_SESSION['super_admin']['employee_ids'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'note' => $_POST['note'],
                                'status' => '1',
                            );
                            if($this->Dashboard_model->insert('scm_stolen_goods', $row)){
                                $insert_id = $this->db->insert_id();
                                $transfer_data = array(
                                    'transfer_from_table' => 'scm_department_stock',
                                    'transfer_from_table_id' => $product['id'],
                                    'transfer_to_table' => 'scm_stolen_goods',
                                    'transfer_to_table_id' => $insert_id,
                                    'amount' => $product['amount'],
                                    'transfer_type' => 'Stolen',
                                    'note' => 'Send Stolen Product to Warehouse From Department Stock!',
                                    'creation_date' => date('Y-m-d H:i:s'),
                                    'created_by' => $_SESSION['super_admin']['employee_ids'],
                                );
                                $this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data);
                            }                            
                            $this->Dashboard_model->mysqliq('UPDATE scm_department_stock set stock_amount = stock_amount - '.$product['amount'].' where id = '.$product['id']);
                        }else{
                            $qry = '';
                            foreach($product['barcodes'] as $barcode){
                                $qry .= $barcode.', ';
                            }
                            $qry = rtrim($qry, ', ');
                            $distinct_ids = $this->Dashboard_model->mysqlii('SELECT purchase_table_id, product_id, count(*) as amount from scm_product_barcode where id in ( '.$qry.' ) GROUP BY purchase_table_id');
                            foreach($distinct_ids as $distinct_id){
                                $row = array(
                                    'amount' => $distinct_id->amount,
                                    'purchase_pk' => $distinct_id->purchase_table_id,
                                    'created_by' =>  $_SESSION['super_admin']['employee_ids'],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'note' => $_POST['note'],
                                    'status' => '1',
                                );
                                $this->Dashboard_model->insert('scm_stolen_goods', $row);
                                $insert_id = $this->db->insert_id();
                                $update = array(
                                    'id_table_name' => 'scm_stolen_goods',
                                    'product_id' => $insert_id,
                                );
                                $this->Dashboard_model->mysqliq("UPDATE scm_product_barcode set id_table_name = 'scm_stolen_goods', product_id = $insert_id WHERE id in (SELECT id from scm_product_barcode where id in ( $qry ) AND id_table_name = 'scm_department_stock' AND product_id = ".$distinct_id->product_id.")");
                                $transfer_data = array(
                                    'transfer_from_table' => 'scm_department_stock',
                                    'transfer_from_table_id' => $distinct_id->product_id,
                                    'transfer_to_table' => 'scm_stolen_goods',
                                    'transfer_to_table_id' => $insert_id,
                                    'amount' => $distinct_id->amount,
                                    'transfer_type' => 'Stolen',
                                    'note' => 'Send Stolen Product to Warehouse From Department Stock!',
                                    'creation_date' => date('Y-m-d H:i:s'),
                                    'created_by' => $_SESSION['super_admin']['employee_ids'],
                                );
                                $this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data);
                                $this->Dashboard_model->mysqliq('UPDATE scm_department_stock set stock_amount = stock_amount - '.$distinct_id->amount.' where id = '.$distinct_id->product_id);
                            }
                        }
                    }
                    unset($_SESSION['department_transfer_cart']);
                }else if($transfer_type == 'Damaged'){
                    foreach($_SESSION['department_transfer_cart'] as $idx=>$product){

                        if($product['type'] != '3'){
                            $order_details_id = $this->Dashboard_model->mysqlij('SELECT scm_product_order_details.id from scm_warehouse_product_stock INNER JOIN scm_product_order_details on scm_product_order_details.id = scm_warehouse_product_stock.scm_product_order_details_id INNER JOIN scm_product_requisition_received on scm_product_requisition_received.scm_warehouse_product_stock_id = scm_warehouse_product_stock.id INNER JOIN scm_department_stock on scm_department_stock.scm_product_requisition_received_id = scm_product_requisition_received.id where scm_department_stock.id= '.$product['id']);
                            // var_dump($order_details_id);
                            // print_r('SELECT scm_product_order_details.id from scm_warehouse_product_stock INNER JOIN scm_product_order_details on scm_product_order_details.id = scm_warehouse_product_stock.scm_product_order_details_id INNER JOIN scm_product_requisition_received on scm_product_requisition_received.scm_warehouse_product_stock_id = scm_warehouse_product_stock.id INNER JOIN scm_department_stock on scm_department_stock.scm_product_requisition_received_id = scm_product_requisition_received.id where scm_department_stock.id= '.$product['id']);
                            // $order_details_id = $this->Dashboard_model->mysqlii('SELECT scm_product_order_details.id from warehouse_product_stock INNER JOIN scm_product_order_details where scm_product_order_details.id = warehouse_product_stock.scm_product_order_details_id INNER JOIN scm_product_requisition_received on scm_product_requisition_received.scm_warehouse_product_stock_id = warehouse_product_stock.id where scm_product_requisition_received.id = '.$product['requisition_receive']);
                            $row = array(
                                'amount' => $product['amount'],
                                'purchase_pk' => $order_details_id->id,
                                'created_by' =>  $_SESSION['super_admin']['employee_ids'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'note' => $_POST['note'],
                                'status' => '1',
                            );
                            if($this->Dashboard_model->insert('scm_damaged_goods', $row)){
                                $insert_id = $this->db->insert_id();
                                $transfer_data = array(
                                    'transfer_from_table' => 'scm_department_stock',
                                    'transfer_from_table_id' => $product['id'],
                                    'transfer_to_table' => 'scm_damaged_goods',
                                    'transfer_to_table_id' => $insert_id,
                                    'amount' => $product['amount'],
                                    'transfer_type' => 'Damaged',
                                    'note' => 'Send Damaged Product to Warehouse From Department Stock!',
                                    'creation_date' => date('Y-m-d H:i:s'),
                                    'created_by' => $_SESSION['super_admin']['employee_ids'],
                                );
                                $this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data);
                            }                            
                            $this->Dashboard_model->mysqliq('UPDATE scm_department_stock set stock_amount = stock_amount - '.$product['amount'].' where id = '.$product['id']);
                        }else{
                            $qry = '';
                            foreach($product['barcodes'] as $barcode){
                                $qry .= $barcode.', ';
                            }
                            $qry = rtrim($qry, ', ');
                            $distinct_ids = $this->Dashboard_model->mysqlii('SELECT purchase_table_id, product_id, count(*) as amount from scm_product_barcode where id in ( '.$qry.' ) GROUP BY purchase_table_id');
                            foreach($distinct_ids as $distinct_id){
                                $row = array(
                                    'amount' => $distinct_id->amount,
                                    'purchase_pk' => $distinct_id->purchase_table_id,
                                    'created_by' =>  $_SESSION['super_admin']['employee_ids'],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'note' => $_POST['note'],
                                    'status' => '1',
                                );
                                $this->Dashboard_model->insert('scm_damaged_goods', $row);
                                $insert_id = $this->db->insert_id();
                                $update = array(
                                    'id_table_name' => 'scm_damaged_goods',
                                    'product_id' => $insert_id,
                                );
                                $this->Dashboard_model->mysqliq("UPDATE scm_product_barcode set id_table_name = 'scm_damaged_goods', product_id = $insert_id WHERE id in (SELECT id from scm_product_barcode where id in ( $qry ) AND id_table_name = 'scm_department_stock' AND product_id = ".$distinct_id->product_id.")");
                                $transfer_data = array(
                                    'transfer_from_table' => 'scm_department_stock',
                                    'transfer_from_table_id' => $distinct_id->product_id,
                                    'transfer_to_table' => 'scm_damaged_goods',
                                    'transfer_to_table_id' => $insert_id,
                                    'amount' => $distinct_id->amount,
                                    'transfer_type' => 'Damaged',
                                    'note' => 'Send Damaged Product to Warehouse From Department Stock!',
                                    'creation_date' => date('Y-m-d H:i:s'),
                                    'created_by' => $_SESSION['super_admin']['employee_ids'],
                                );
                                $this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data);
                                $this->Dashboard_model->mysqliq('UPDATE scm_department_stock set stock_amount = stock_amount - '.$distinct_id->amount.' where id = '.$distinct_id->product_id);
                            }
                        }
                    }
                    unset($_SESSION['department_transfer_cart']);
                }else{
                    if($transfer_type == 'Branch'){
                        if(strlen($_POST['type_id']) != 4){
                            alert('warning','Enter Proper Room Number!');
                            redirect(base_url('admin/scm/department-product-stock'));
                        }else{
                            $branch_id = rahat_decode($_POST['branch']);
                            $unit_name = strtoupper(substr($_POST['type_id'],0,2));
                            $room_name = strtoupper(substr($_POST['type_id'],2,3));
                            // var_dump();
                            // print_r("SELECT id from rooms where branch_id = '$branch_id' AND unit_name = '$unit_name' AND room_name = '$room_name'");
                            // exit();
                            if(empty($this->Dashboard_model->mysqlii("SELECT id from rooms where branch_id = '$branch_id' AND unit_name = '$unit_name' AND room_name = '$room_name'"))){
                                alert('warning','Room does not exist!');
                                redirect(base_url('admin/scm/department-product-stock'));
                            }
                        }                    
                    }
                    foreach($_SESSION['department_transfer_cart'] as $product){
                        $row = array(
                            'scm_department_stock_id' => $product['id'],
                            'scm_product_requisition_details_id' => $product['rqst_id'],
                            'type' => $transfer_type,
                            'branch_id' => $branch_id,
                            'unit_name' => $unit_name,
                            'room_name' => $room_name,
                            'employee_id' => (isset($_POST['employee_id'])) ? rahat_decode($_POST['employee_id']) : null,
                            'amount' => $product['amount'],
                            'updated_by' => $_SESSION['super_admin']['employee_ids'],
                            'updated_at' => date('Y-m-d H:i:s'),
                            'creationDate' => date('Y-m-d H:i:s'),
                            'status' => 1,
                            'scm_product_types_id' => $product['type'],
                            'used_id' => '',
                        );
                        if($this->Dashboard_model->insert('scm_product_requisition_uses', $row)){
                            $insert_id = $this->db->insert_id();
                            if($this->Dashboard_model->mysqliq('UPDATE scm_department_stock set stock_amount = stock_amount - '.$product['amount'].' where id = '.$product['id'])){
                                $transfer_data = array(
                                    'transfer_from_table' => 'scm_department_stock',
                                    'transfer_from_table_id' => $product['id'],
                                    'transfer_to_table' => 'scm_product_requisition_uses',
                                    'transfer_to_table_id' => $insert_id,
                                    'amount' => $product['amount'],
                                    'transfer_type' => 'Transfer',
                                    'note' => '',
                                    'creation_date' => date('Y-m-d H:i:s'),
                                    'created_by' => $_SESSION['super_admin']['employee_ids'],
                                );
                                if(!$this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data)){                                
                                    $error = true;
                                }
                            }else{
                                $error = true;
                            }
                        }else{
                            $error = true;
                        }
                        if($product['type'] === '3'){
                            foreach($product['barcodes'] as $barcode){
                                $update = array(
                                    'id_table_name' => 'scm_product_requisition_uses',
                                    'product_id' => $insert_id,
                                    'status' => '2',
                                );
                                if(!$this->Dashboard_model->update('scm_product_barcode', $update, $barcode)){
                                    $error = true;
                                }
                            }
                        }
                    }
                    unset($_SESSION['department_transfer_cart']);                    
                }
            }else{
                alert('warning','Select Atleat One Product!');
                redirect(base_url('admin/scm/department-product-stock'));
            }
            if($error){
                alert('danger','Something Went Wrong!');
                redirect(base_url('admin/scm/department-product-stock'));
            }else{
                redirect(base_url('admin/scm/department-product-stock'));
            }
            // $data['title_info'] = 'Manage Food Orders';
            // $data['header'] = $this->load->view('include/header','',TRUE); 
            // $data['nav'] = $this->load->view('include/nav','',TRUE); 
            // $data['article'] = $this->load->view('template/scm/manage_food_orders',$data,TRUE); 
            // $data['footer'] = $this->load->view('include/footer','',TRUE); 
            // $this->load->view('dashboard',$data);
        }
    }    
    public function department_product_status()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Manage Food Orders';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/department_product_status',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function manage_damaged_product()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Manage Damaged Goods';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/manage_damaged_goods',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }


    public function department_transfer_product() // Transfer from usign state
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if(isset($_POST['amount'])){
                $amount = $_POST['amount'];
            }else{
                $amount = count($_POST['product_to_add']);
            }
            if($_POST['transfer_type'] == 'to_branch'){
                $product = $this->Dashboard_model->mysqlij("SELECT id, amount, scm_department_stock_id , scm_product_types_id, scm_product_requisition_details_id, `type` from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // print_r("SELECT id, amount from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // var_dump($product);
                // exit();
                if(!empty($product)){
                    if(strlen($_POST['type_id']) != 4){
                        alert('warning','Enter Proper Room Number!');
                        redirect(base_url('admin/scm/department-product-status'));
                    }else{
                        $branch_id = rahat_decode($_POST['branch']);
                        $unit_name = strtoupper(substr($_POST['type_id'],0,2));
                        $room_name = strtoupper(substr($_POST['type_id'],2,3));
                        if(empty($this->Dashboard_model->mysqlii("SELECT id from rooms where branch_id = '$branch_id' AND unit_name = '$unit_name' AND room_name = '$room_name'"))){
                            alert('warning','Room does not exist!');
                            redirect(base_url('admin/scm/department-product-status'));
                        }
                    }
                    $row = array(
                        'scm_department_stock_id' => $product->scm_department_stock_id,
                        'scm_product_requisition_details_id' => $product->scm_product_requisition_details_id,
                        'type' => 'Branch',
                        'branch_id' => $branch_id,
                        'unit_name' => $unit_name,
                        'room_name' => $room_name,
                        'amount' => $amount,
                        'updated_by' => $_SESSION['super_admin']['employee_ids'],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'creationDate' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'scm_product_types_id' => $product->scm_product_types_id,
                    );
                    if($this->Dashboard_model->insert('scm_product_requisition_uses', $row)){
                        $insert_id = $this->db->insert_id();
                        if($_POST['type_id'] == '3'){
                            foreach($_POST['product_to_add'] as $barcode_id){
                                $barcode_update = array(
                                    'product_id' => $insert_id
                                );
                                if(!$this->Dashboard_model->update('scm_product_barcode', $barcode_update, $barcode_id)){
                                    alert('danger','Something Went Wrong!! Please try again!');
                                    redirect(base_url('admin/scm/department-product-status'));
                                }
                            }
                        }
                        $update_data = array(
                            'amount' => $product->amount - $amount
                        );
                        if($this->Dashboard_model->update('scm_product_requisition_uses', $update_data, $product->id)){
                            $transfer_data = array(
                                'transfer_from_table' => 'scm_product_requisition_uses',
                                'transfer_from_table_id' => $product->id,
                                'transfer_to_table' => 'scm_product_requisition_uses',
                                'transfer_to_table_id' => $insert_id,
                                'amount' => $amount,
                                'transfer_type' => 'Transfer',
                                'note' => 'From '.$product->type.' To Branch!',
                                'creation_date' => date('Y-m-d H:i:s'),
                                'created_by' => $_SESSION['super_admin']['employee_ids'],
                            );
                            if($this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data)){
                                alert('success','Successfully Transferred!');
                                redirect(base_url('admin/scm/department-product-status'));
                            }                            
                        }
                    }
                }else{
                    alert('warning','Enter Proper Amount!');
                    redirect(base_url('admin/scm/department-product-status'));
                }
            }else if($_POST['transfer_type'] == 'to_employee'){
                $product = $this->Dashboard_model->mysqlij("SELECT id, amount, scm_department_stock_id , scm_product_types_id, scm_product_requisition_details_id, `type` from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // print_r("SELECT id, amount from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // var_dump($product);
                // exit();
                if(!empty($product)){
                    $row = array(
                        'scm_department_stock_id' => $product->scm_department_stock_id,
                        'scm_product_requisition_details_id' => $product->scm_product_requisition_details_id,
                        'type' => 'Employee',
                        'employee_id' => rahat_decode($_POST['employee_id']),
                        'amount' => $amount,
                        'updated_by' => $_SESSION['super_admin']['employee_ids'],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'creationDate' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'scm_product_types_id' => $product->scm_product_types_id,
                        'used_id' => $product->used_id,
                    );
                    if($this->Dashboard_model->insert('scm_product_requisition_uses', $row)){
                        $insert_id = $this->db->insert_id();
                        if($_POST['type_id'] == '3'){
                            foreach($_POST['product_to_add'] as $barcode_id){
                                $barcode_update = array(
                                    'product_id' => $insert_id
                                );
                                if(!$this->Dashboard_model->update('scm_product_barcode', $barcode_update, $barcode_id)){
                                    alert('danger','Something Went Wrong!! Please try again!');
                                    redirect(base_url('admin/scm/department-product-status'));
                                }
                            }
                        }                        
                        $update_data = array(
                            'amount' => $product->amount - $amount
                        );
                        if($this->Dashboard_model->update('scm_product_requisition_uses', $update_data, $product->id)){
                            $transfer_data = array(
                                'transfer_from_table' => 'scm_product_requisition_uses',
                                'transfer_from_table_id' => $product->id,
                                'transfer_to_table' => 'scm_product_requisition_uses',
                                'transfer_to_table_id' => $insert_id,
                                'amount' => $amount,
                                'transfer_type' => 'Transfer',
                                'note' => 'From '.$product->type.' To Employee!',
                                'creation_date' => date('Y-m-d H:i:s'),
                                'created_by' => $_SESSION['super_admin']['employee_ids'],
                            );
                            if($this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data)){
                                alert('success','Successfully Transferred!');
                                redirect(base_url('admin/scm/department-product-status'));
                            }                            
                        }
                    }
                }else{
                    alert('warning','Enter Proper Amount!');
                    redirect(base_url('admin/scm/department-product-status'));
                }
            }else if($_POST['transfer_type'] == 'to_department'){
                $product = $this->Dashboard_model->mysqlij("SELECT id, amount, scm_department_stock_id , scm_product_types_id, scm_product_requisition_details_id from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                $product_stock = $this->Dashboard_model->mysqlij("SELECT id, scm_product_requisition_received_id, branch_id, stock_amount from scm_department_stock where id = ".$product->scm_department_stock_id);
                // print_r("SELECT id, amount from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // var_dump($product);
                // exit();
                if(!empty($product)){
                    if($product_stock->branch_id == rahat_decode($_POST['branch'])){
                        $row = array(
                            'stock_amount' => $product_stock->stock_amount + $amount,
                        );
                        $this->Dashboard_model->update('scm_department_stock', $row, $product_stock->id);
                        if($_POST['type_id'] == '3'){
                            foreach($_POST['product_to_add'] as $barcode_id){                                
                                $barcode_update = array(
                                    'id_table_name' => 'scm_department_stock',
                                    'product_id' => $product_stock->id
                                );
                                if(!$this->Dashboard_model->update('scm_product_barcode', $barcode_update, $barcode_id)){
                                    alert('danger','Something Went Wrong!! Please try again!');
                                    redirect(base_url('admin/scm/department-product-status'));
                                }
                            }
                        }
                        $update_data = array(
                            'amount' => $product->amount - $amount
                        );
                        if($this->Dashboard_model->update('scm_product_requisition_uses', $update_data, $product->id)){
                            $transfer_data = array(
                                'transfer_from_table' => 'scm_product_requisition_uses',
                                'transfer_from_table_id' => $product->id,
                                'transfer_to_table' => 'scm_department_stock',
                                'transfer_to_table_id' => $product_stock->id,
                                'amount' => $amount,
                                'transfer_type' => 'Transfer',
                                'note' => 'From '.$product->type.' To Departement Warehouse!',
                                'creation_date' => date('Y-m-d H:i:s'),
                                'created_by' => $_SESSION['super_admin']['employee_ids'],
                            );
                            if($this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data)){
                                alert('success','Successfully Transferred!');
                                redirect(base_url('admin/scm/department-product-status'));
                            }                            
                        }
                    }else{
                        $row = array(
                            'scm_product_requisition_received_id' => $product_stock->scm_product_requisition_received_id,
                            'scm_product_requisition_details_id' => $product->scm_product_requisition_details_id,
                            'branch_id' => rahat_decode($_POST['branch']),
                            'stock_amount' => $amount,
                        );
                        $this->Dashboard_model->insert('scm_department_stock', $row);
                        // if($this->Dashboard_model->insert('scm_department_stock', $row)){
                        $insert_id = $this->db->insert_id();
                        // var_dump($_POST['type_id']);
                        // exit();
                        if($_POST['type_id'] == '3'){
                            foreach($_POST['product_to_add'] as $barcode_id){                                
                                $barcode_update = array(
                                    'id_table_name' => 'scm_department_stock',
                                    'product_id' => $insert_id
                                );
                                if(!$this->Dashboard_model->update('scm_product_barcode', $barcode_update, $barcode_id)){
                                    alert('danger','Something Went Wrong!! Please try again!');
                                    redirect(base_url('admin/scm/department-product-status'));
                                }
                            }
                        }
                        $update_data = array(
                            'amount' => $product->amount - $amount
                        );
                        if($this->Dashboard_model->update('scm_product_requisition_uses', $update_data, $product->id)){
                            $transfer_data = array(
                                'transfer_from_table' => 'scm_product_requisition_uses',
                                'transfer_from_table_id' => $product->id,
                                'transfer_to_table' => 'scm_department_stock',
                                'transfer_to_table_id' => $insert_id,
                                'amount' => $amount,
                                'transfer_type' => 'Transfer',
                                'note' => 'From '.$product->type.' To Departement Warehouse!',
                                'creation_date' => date('Y-m-d H:i:s'),
                                'created_by' => $_SESSION['super_admin']['employee_ids'],
                            );
                            if($this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data)){
                                alert('success','Successfully Transferred!');
                                redirect(base_url('admin/scm/department-product-status'));
                            }                            
                        }
                    }
                }else{
                    alert('warning','Enter Proper Amount!');
                    redirect(base_url('admin/scm/department-product-status'));
                }
            }else if($_POST['transfer_type'] == 'to_damaged'){
                $product = $this->Dashboard_model->mysqlij("SELECT id, amount, scm_department_stock_id , scm_product_types_id, scm_product_requisition_details_id from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // print_r("SELECT id, amount from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // var_dump($product);
                // exit();
                if(!empty($product)){
                    if($product->scm_product_types_id != '3'){
                        $row = array(
                            'amount' => $amount,
                            'purchase_pk' => $_POST['pur_pk'],
                            'created_by' =>  $_SESSION['super_admin']['employee_ids'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'note' => '',
                            'status' => '1',
                        );
                        if($this->Dashboard_model->insert('scm_damaged_goods', $row)){
                            $insert_id = $this->db->insert_id();
                            if(!$this->Dashboard_model->mysqliq('UPDATE scm_product_requisition_uses set amount = amount - '.$amount.' where id = '.$product->id)){
                                $error = true;                                
                            }
                        }
                    }else{
                        $condition = array(
                            'id' => $_POST['product_to_add'][0]
                        );
                        $purchase_pk = $this->Dashboard_model->select('scm_product_barcode',$condition,'id','ASC','row');
                        $row = array(
                            'amount' => count($_POST['product_to_add']),
                            'purchase_pk' => $purchase_pk->purchase_table_id,
                            'created_by' =>  $_SESSION['super_admin']['employee_ids'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'note' => $_POST['note'],
                            'status' => '1',
                        );
                        if($this->Dashboard_model->insert('scm_damaged_goods', $row)){
                            $insert_id = $this->db->insert_id();
                            if(!$this->Dashboard_model->mysqliq('UPDATE scm_product_requisition_uses set amount = amount - '.$amount.' where id = '.$product->id)){
                                $error = true;                                
                            }
                            $update = array(
                                'id_table_name' => 'scm_damaged_goods',
                                'product_id' => $insert_id,
                            );
                            foreach($_POST['product_to_add'] as $barcode){
                                if(!$this->Dashboard_model->update('scm_product_barcode', $update, $barcode)){
                                    $error = true;
                                }
                            }
                        }else{
                            $error = true;
                        }
                    }
                    $transfer_data = array(
                        'transfer_from_table' => 'scm_product_requisition_uses',
                        'transfer_from_table_id' => $product->id,
                        'transfer_to_table' => 'scm_damaged_goods',
                        'transfer_to_table_id' => $insert_id,
                        'amount' => $amount,
                        'transfer_type' => 'Damaged',
                        'note' => 'Send Damaged Product to Warehouse From Product Use State!',
                        'creation_date' => date('Y-m-d H:i:s'),
                        'created_by' => $_SESSION['super_admin']['employee_ids'],
                    );
                    if($this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data)){                                
                        alert('success','Successfully Transferred!');
                        redirect(base_url('admin/scm/department-product-status'));
                    }
                }else{
                    alert('warning','Enter Proper Amount!');
                    redirect(base_url('admin/scm/department-product-status'));
                }
            }else if($_POST['transfer_type'] == 'to_damaged'){
                $product = $this->Dashboard_model->mysqlij("SELECT id, amount, scm_department_stock_id , scm_product_types_id, scm_product_requisition_details_id from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // print_r("SELECT id, amount from scm_product_requisition_uses where id = ".$_POST['use_id']." AND amount >= ".$amount);
                // var_dump($product);
                // exit();
                if(!empty($product)){
                    if($product->scm_product_types_id != '3'){
                        $row = array(
                            'amount' => $amount,
                            'purchase_pk' => $_POST['pur_pk'],
                            'created_by' =>  $_SESSION['super_admin']['employee_ids'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'note' => '',
                            'status' => '1',
                        );
                        if($this->Dashboard_model->insert('scm_damaged_goods', $row)){
                            $insert_id = $this->db->insert_id();
                            if(!$this->Dashboard_model->mysqliq('UPDATE scm_product_requisition_uses set amount = amount - '.$amount.' where id = '.$product->id)){
                                $error = true;                                
                            }
                        }
                    }else{
                        $condition = array(
                            'id' => $_POST['product_to_add'][0]
                        );
                        $purchase_pk = $this->Dashboard_model->select('scm_product_barcode',$condition,'id','ASC','row');
                        $row = array(
                            'amount' => count($_POST['product_to_add']),
                            'purchase_pk' => $purchase_pk->purchase_table_id,
                            'created_by' =>  $_SESSION['super_admin']['employee_ids'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'note' => $_POST['note'],
                            'status' => '1',
                        );
                        if($this->Dashboard_model->insert('scm_damaged_goods', $row)){
                            $insert_id = $this->db->insert_id();
                            if(!$this->Dashboard_model->mysqliq('UPDATE scm_product_requisition_uses set amount = amount - '.$amount.' where id = '.$product->id)){
                                $error = true;                                
                            }
                            $update = array(
                                'id_table_name' => 'scm_damaged_goods',
                                'product_id' => $insert_id,
                            );
                            foreach($_POST['product_to_add'] as $barcode){
                                if(!$this->Dashboard_model->update('scm_product_barcode', $update, $barcode)){
                                    $error = true;
                                }
                            }
                        }else{
                            $error = true;
                        }
                    }
                    $transfer_data = array(
                        'transfer_from_table' => 'scm_product_requisition_uses',
                        'transfer_from_table_id' => $product->id,
                        'transfer_to_table' => 'scm_damaged_goods',
                        'transfer_to_table_id' => $insert_id,
                        'amount' => $amount,
                        'transfer_type' => 'Damaged',
                        'note' => 'Send Damaged Product to Warehouse From Product Use State!',
                        'creation_date' => date('Y-m-d H:i:s'),
                        'created_by' => $_SESSION['super_admin']['employee_ids'],
                    );
                    if($this->Dashboard_model->insert('scm_product_transfer_log', $transfer_data)){                                
                        alert('success','Successfully Transferred!');
                        redirect(base_url('admin/scm/department-product-status'));
                    }
                }else{
                    alert('warning','Enter Proper Amount!');
                    redirect(base_url('admin/scm/department-product-status'));
                }
            }
            alert('warning','Something went wrong! Please try again!');
            redirect(base_url('admin/scm/department-product-status'));
        }
    }

    public function out_of_order()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Out of order products';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/out_of_order',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }

    public function stolen_product()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Out of order products';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/stolen_product',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    
    public function other_department_requisition()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Out of order products';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/other_department_requisition',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function manage_other_department_requisition()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Department product Requisition';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/department_requisitions_to_department',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }

    public function service_product()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['service_products'] = $this->Dashboard_model->select('scm_product_category',array('product_types_id' => 6),'id','ASC','result');
            $data['vendors'] = $this->Dashboard_model->select('scm_vendor',array('status' => 1),'id','ASC','result');
            $data['employees'] = $this->Dashboard_model->select('employee',array('status' => 1, 'd_head' => 1),'id','ASC','result');
            $data['title_info'] = 'Service Product';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/service_product',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function service_product_insert()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            if(isset($_POST['service_type'])){
                $service_type = 1;
            }else{
                $service_type = 0;
            }
            $service_product_data = array(
                'vendor_id' => $_POST['vendor'],
                'vehicle' => $service_type,
                'product_type_id' => $_POST['product_type'],
                'assigned_to' => $_POST['assigned_to'],
                'agreement_type' => $_POST['agreement_type'],
                'status' => 1,
                'description' => $_POST['description'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'uploader_info' => $_SESSION['super_admin']['employee_ids'],
                'updated_by' => $_SESSION['super_admin']['employee_ids'],
                'start_date' => $_POST['start_date'],
            );
            if($this->Dashboard_model->insert('scm_service_product_details', $service_product_data)){
                alert('success','Successfully Assigned');
                redirect(base_url('admin/scm/service-product'));
            }else{
                alert('warning','Something went wrong! Please try again!');
                redirect(base_url('admin/scm/service-product'));
            }            
        }
    }
    public function manage_service_product()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            $data['title_info'] = 'Manage Service Product';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/manage_service_product',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }

    public function manage_assigned_service_product()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            // $data['assigned_services'] = $this->Dashboard_model->select("SELECT count(*) as number_of_service, scm_product_category.name from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id where scm_service_product_details.assigned_to = ".$_SESSION['super_admin']['employee_id']." AND status = 1 GROUP BY scm_service_product_details.product_type_id");
            // Test
            $data['assigned_services'] = $this->Dashboard_model->mysqlii("SELECT count(*) as number_of_service, scm_product_category.name, scm_product_category.id from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id GROUP BY scm_service_product_details.product_type_id");
            $data['title_info'] = 'Manage Service Product';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/manage_assigned_service_product',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function service_requisition()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            // $data['assigned_services'] = $this->Dashboard_model->select("SELECT count(*) as number_of_service, scm_product_category.name from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id where scm_service_product_details.assigned_to = ".$_SESSION['super_admin']['employee_id']." AND status = 1 GROUP BY scm_service_product_details.product_type_id");
            // Test
            // $data['assigned_services'] = $this->Dashboard_model->mysqlii("SELECT count(*) as number_of_service, scm_product_category.name, scm_product_category.id from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id GROUP BY scm_service_product_details.product_type_id");
            $data['title_info'] = 'Service Requisition';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/service_requisition',$data,TRUE); 
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }
    public function service_requisition_approval()
    {
        if(!isset($_SESSION['super_admin']['email'])){
			redirect(base_url('admin/login'));
		}else{
            // $data['assigned_services'] = $this->Dashboard_model->select("SELECT count(*) as number_of_service, scm_product_category.name from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id where scm_service_product_details.assigned_to = ".$_SESSION['super_admin']['employee_id']." AND status = 1 GROUP BY scm_service_product_details.product_type_id");
            // Test
            // $data['assigned_services'] = $this->Dashboard_model->mysqlii("SELECT count(*) as number_of_service, scm_product_category.name, scm_product_category.id from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id GROUP BY scm_service_product_details.product_type_id");
            $data['title_info'] = 'Service Requisition';
            $data['header'] = $this->load->view('include/header','',TRUE); 
            $data['nav'] = $this->load->view('include/nav','',TRUE); 
            $data['article'] = $this->load->view('template/scm/service_requisition_approval',$data,TRUE);
            $data['footer'] = $this->load->view('include/footer','',TRUE); 
            $this->load->view('dashboard',$data);
        }
    }

    public function service_request()
    {
        // if(!isset($_SESSION['super_admin']['email'])){
		// 	redirect(base_url('admin/login'));
		// }else{
            $error = false;
            $message = "Successfully done!";

            $start_date = new DateTime($_POST['requisition_date'].' '.$_POST['from_time']);

            $end_date_in_minute = (int)$_POST['requisition_duration'] * 60;
            $end_date = new DateTime($_POST['requisition_date'].' '.$_POST['from_time']);
            $end_date = $end_date->add(new DateInterval('PT' .$end_date_in_minute. 'M'));

            $validate = $this->Dashboard_model->mysqlij("SELECT scm_service_requisition.id,scm_service_requisition.start_date,scm_service_requisition.end_date, employee.full_name from scm_service_requisition INNER JOIN employee on employee.employee_id = scm_service_requisition.requisition_by where ( '".$end_date->format('Y-m-d H:i:s')."' between start_date AND end_date ) OR ( '".$start_date->format('Y-m-d H:i:s')."' between start_date AND end_date )");
            if(is_null($validate)){
                if(strtolower($_POST['destination_from']) == 'other'){
                    $destination_from = $_POST['from_other'];
                }else{
                    $destination_from = $_POST['destination_from'];
                }
                if(strtolower($_POST['destination_to']) == 'other'){
                    $destination_to = $_POST['to_other']; 
                }else{
                    $destination_to = $_POST['destination_to'];
                }
                $insert_data = array(
                    'service_product_id' => $_POST['requesting_product'],
                    'start_date' => $start_date->format('Y-m-d H:i:s'),
                    'end_date' => $end_date->format('Y-m-d H:i:s'),
                    'destination_from' => $destination_from,
                    'destination_to' => $destination_to,
                    'requisition_by' => (isset($_SESSION['super_admin'])) ? $_SESSION['super_admin']['employee_ids'] : $_SESSION['employee_info']['user_id'],
                    'creation_date' => date('Y-m-d H:i:s'),
                    'uploader_info' => (isset($_SESSION['super_admin'])) ? $_SESSION['super_admin']['employee_ids'] : $_SESSION['employee_info']['user_id'],
                    'status' => '1',
                    'note' => $_POST['note'],
                    'driver_start_date' => $start_date->format('Y-m-d H:i:s'),
                    'driver_end_date' => $end_date->format('Y-m-d H:i:s'),
                    'confirmation_code' => rand(10000,99999),
                );
                if(!$this->Dashboard_model->insert('scm_service_requisition', $insert_data)){
                    $message = $this->db->error();
                    $error = 'true';
                }
            }else{
                $error = true;
                $validate_start_date = new DateTime($validate->start_date);
                $validate_end_date = new DateTime($validate->end_date);
                if($validate_start_date->format('Y-m-d') < $validate_end_date->format('Y-m-d')){
                    $time_string = "from: <span>".$validate_start_date->format('d-m-Y h:i A')."</span> to: <span>".$validate_end_date->format('h:i A')."</span>";
                }else if($validate_start_date->format('Y-m-d') < $validate_end_date->format('Y-m-d')){
                    $time_string = "from: <span>".$validate_start_date->format('h:i A')."</span> to: <span>".$validate_end_date->format('d-m-Y h:i A')."</span>";
                }else{
                    $time_string = "from: <span>".$validate_start_date->format('h:i A')."</span> to: <span>".$validate_end_date->format('h:i A')."</span>";
                }
                $message = "Requisiton conflicts with <span>".$validate->full_name."s</span> requition ".$time_string;
            }
            // var_dump($_POST);
            // var_dump($start_date);
            // var_dump($end_date);
            // var_dump($validate);
            $info = array(
                'error' => $error,
                'message' => $message,
            );
            echo json_encode($info);
        // }
    }
    public function service_request_remove()
    {
        // if(!isset($_SESSION['super_admin']['email'])){
		// 	redirect(base_url('admin/login'));
		// }else{
            $error = false;
            $message = "Successfull!";
            $validate = $this->Dashboard_model->mysqlij("SELECT `status` from scm_service_requisition where id = ".$_POST['requisition_for']);
            if($validate->status == 1 OR $validate->status == 2){
                if(!$this->Dashboard_model->delete('scm_service_requisition', $_POST['requisition_for'])){
                    $error = true;
                    $message = $this->db->error();                    
                }
            }else{
                $error = true;
                $message = "Cannot remove request!";
            }
            $info = array(
                'error' => $error,
                'message' => $message,
            );
            if($error){
                alert('danger',$message);
            }else{
                alert('success',$message);
            }
            echo json_encode($info);
        // }
    }
}