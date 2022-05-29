<?php
include("../../../application/config/ajax_config.php");

$html = '<div class="card-header">
            <p style="font-weight: bold;font-size: 25px;">Ordering For:</p>
        </div>
        <div class="card-body">';
$html .=  '<div class="row justify-content-left mt-3 mb-2" style="margin-left: 0px;margin-right: 0px;">';
$html .=    '<div class="col-md-12">
                <p class="mb-2"> Requisition for Branch:</p>
            </div>
            <div class="col-md-6">
                <select class="form-control select2" name="branch" id="branch" required>
                    <option value="">Select Branch</option>';
$branches = $mysqli->query("SELECT branch_name , branch_id from branches where `status` = 1");
while($branch = mysqli_fetch_assoc($branches)){
    $html .=        '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
}
$html .=        '</select>
            </div>';
$html .=    '<div class="col-md-12">
                <p class="mb-2"> Send Requisition to:</p>
            </div>
            <div class="col-md-6">
                <select class="form-control select2" name="department" id="department" required>
                    <option value="">Select Department</option>';
$departments = $mysqli->query("SELECT department_name , id, department_id from department where `status` = 1");
while($department = mysqli_fetch_assoc($departments)){
    if($department['department_id'] == $_SESSION['user_info']['department']){
        continue;
    }
    $html .=        '<option value="'.$department['department_id'].'">'.$department['department_name'].'</option>';
}
$html .=        '</select>
            </div>
            </div>';
$button =   '<button type="button" class="btn btn-success" style="float: left;margin-left: 15px;" onclick="goToPreviousStep()"><span class="mr-1"><i class="fas fa-arrow-left"></i></span>Go to Previous Step</button>
            <button class="btn btn-success" style="float: right;margin-right: 15px;"><span class="mr-1"><i class="fas fa-check"></i></span>Confirm Requisition</button>';
$data = array(
    'html' => $html,
    'button' => $button,
    'action' => $home.'admin/scm/confirm-product-requisition'
);
echo json_encode($data);

// ----------------------------------------- OLD CODE

// $first_div = false;
// $search = array_search($_SESSION['user_info']['department'], array_column($_SESSION['scm_cart'], 'product_department'));
// if($search !== false){
//     $html .=    '<div class="col-md-12">
//                     <p class="mb-2"> Information for SCM to send product:</p>
//                 </div>
//                 <div class="col-md-6">
//                     <select class="form-control select2" name="branch" id="branch" required>
//                         <option value="">Select Branch</option>';
//     $branches = $mysqli->query("SELECT branch_name , branch_id from branches where `status` = 1");
//     while($branch = mysqli_fetch_assoc($branches)){
//         $html .=        '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
//     }
//     $html .=        '</select>
//                 </div>';
//     // $html .=  '<div class="col-md-6">
//     //                 <select class="form-control select2" name="department" id="department" required>
//     //                     <option value="">Select Department</option>';
//     // $departments = $mysqli->query("SELECT department_name , department_id from department where `status` = 1");
//     // while($department = mysqli_fetch_assoc($departments)){
//     //     $html .=        '<option value="'.$department['department_id'].'">'.$department['department_name'].'</option>';
//     // }
//     // $html .=        '</select>
//     //             </div>';
//     $first_div = true;
// }

// if(count(array_unique(array_column($_SESSION['scm_cart'], 'product_department'))) > 1){
//     if($first_div){
//         $html .= '<div class="col-md-12"><hr></div>';
//     }
//     $html .=    '<div class="col-md-12">
//                     <p class="mb-2"> Information for Department to send product:</p>
//                 </div>
//                 <div class="col-md-6">
//                     <select class="form-control select2" name="branch_for_department" id="branch_for_department" required>
//                         <option value="">Select Branch</option>';
//     $branches = $mysqli->query("SELECT branch_name , branch_id from branches where `status` = 1");
//     while($branch = mysqli_fetch_assoc($branches)){
//         $html .=        '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
//     }
//     $html .=        '</select>
//                 </div>
//                 <div class="col-md-6"></div>';
//     $html .=  '<div class="col-md-3 mt-3">
//                     <select class="form-control select2" name="recipient_type" id="recipient_type" onchange="get_recipient_type(this.value)" required>
//                         <option value="">Recipent Type</option>
//                         <option value="own">Own Department</option>
//                         <option value="room">Room</option>
//                         <option value="employee">Employee</option>';
//     // $departments = $mysqli->query("SELECT department_name , department_id from department where `status` = 1");
//     // while($department = mysqli_fetch_assoc($departments)){
//     //     $html .=        '<option value="'.$department['department_id'].'">'.$department['department_name'].'</option>';
//     // }
//     $html .=        '</select>
//                 </div>
//                 <div class="col-md-5 mt-3" id="recipient_type_div">
//                 </div>
//                 <div class="col-md-4 mt-3" id="recipient_type_error" style="display: none;">
//                     <p class="text-danger"><span><i class="fa fa-exclamation-circle"></i></span><span class="ml-2" id="error_message"></span><p>
//                 </div>';
// }else{
//     if($search === false){
//         if($first_div){
//             $html .= '<div class="col-md-12"><hr></div>';
//         }
//         $html .=    '<div class="col-md-12">
//                         <p class="mb-2"> Information for Department to send product:</p>
//                     </div>
//                     <div class="col-md-6">
//                         <select class="form-control select2" name="branch_for_department" id="branch_for_department" required>
//                             <option value="">Select Branch</option>';
//         $branches = $mysqli->query("SELECT branch_name , branch_id from branches where `status` = 1");
//         while($branch = mysqli_fetch_assoc($branches)){
//             $html .=        '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
//         }
//         $html .=        '</select>
//                     </div>
//                     <div class="col-md-6"></div>';
//         $html .=  '<div class="col-md-3 mt-3">
//                         <select class="form-control select2" name="recipient_type" id="recipient_type" onchange="get_recipient_type(this.value)" required>
//                             <option value="">Recipent Type</option>
//                             <option value="own">Own Department</option>
//                             <option value="room">Room</option>
//                             <option value="employee">Employee</option>';
//         $html .=        '</select>
//                     </div>
//                     <div class="col-md-5 mt-3" id="recipient_type_div">
//                     </div>
//                     <div class="col-md-4 mt-3" id="recipient_type_error" style="display: none;">
//                         <p><span><i class="fa fa-exclamation-circle text-danger"></i></span><span class="ml-2" id="error_message"></span><p>
//                     </div>';
//     }
// }
// $html .=        '</div>
//             </div>
//         </div>';
// $button =   '<button type="button" class="btn btn-success" style="float: left;margin-left: 15px;" onclick="goToPreviousStep()"><span class="mr-1"><i class="fas fa-arrow-left"></i></span>Go to Previous Step</button>
//             <button class="btn btn-success" style="float: right;margin-right: 15px;"><span class="mr-1"><i class="fas fa-check"></i></span>Confirm Requisition</button>';
// $data = array(
//     'html' => $html,
//     'button' => $button,
//     'action' => $home.'admin/scm/confirm-product-requisition'
// );
// echo json_encode($data);