<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Business extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Commn');
        $maintenance = maintenance();
        if($maintenance == 0){
            $id = $this->session->userdata('id');
            if(empty($id)){
                redirect('/');
            }
        }else{
            redirect('maintenance');
        }
    }

    public function index(){
        $data = array('');
        $data['user_id'] = $this->session->userdata('id');
        $current_user = $this->session->userdata('id'); 
        $data = $this->return_data();

        if($data['user']->role_id == 1 || $data['user']->role_id == 2){
            $where = array('hrms_user_id' => $data['parivar']->id);
        }else{
            $where = array('bussiness_staff_id' => $current_user, 'hrms_user_id' => $data['parivar']->id);
        }
        $Common =  new Commn();
        $data['bussiness_s'] = $Common->where_all_records('hrms_bussiness_list',$where,'*');
        if(!empty($data['bussiness_s'])){
            foreach ($data['bussiness_s'] as $key => $bussiness) {
                $bussiness->gam_name = $Common->select_get_row_data('gam',array('id'=>$bussiness->gam_id),'name')->name;
            }
        }
        $this->load->view('dashboard/header',$data);
        $this->load->view('bussiness/bussiness',$data);
        $this->load->view('dashboard/footer',$data);
    }
    public function new(){
        $data = array('');
        $data = $this->return_data();
        $data['gams'] = get_all_field('gam',array('hrms_user_id'=>$data['parivar']->id),'*','name','asc');
        $this->load->view('dashboard/header',$data);
        $this->load->view('bussiness/new',$data);
        $this->load->view('dashboard/footer',$data);
    }
    public function save(){
        $data = array('');
        $data['user_id'] = $this->session->userdata('id');
        $data['user'] = $this->common_data($data['user_id']);
        if($data['user']->role_id != 1){
            $data['parivar'] = $this->get_parivar_details($data['user']->hrms_user_id);
        }else{
            $data['parivar'] = $this->common_data($data['user_id']);
        }
        $Common =  new Commn();
        $current_user = $this->session->userdata('id'); 
        $business_status = true;
        $business_post_data =  array(
            'name' => $this->input->post('name'),
            'mobile_no' => $this->input->post('mobileno'),
            'gam_id' => $this->input->post('gam_id'),
            'bussiness_name' => $this->input->post('businessname'),
            'bussiness_type' => $this->input->post('businesstype'),
            'bussiness_address' => $this->input->post('businessaddress'),
            'bussiness_mobile' => $this->input->post('businessmobileno'),
            'bussiness_staff_id' => $current_user,
            'hrms_user_id' => $data['parivar']->id,
        );

        if(isset($_FILES["businessvisitingcard"]["type"]))
        {
            $validextensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["businessvisitingcard"]["name"]);
            $file_extension = end($temporary);
            if ((($_FILES["businessvisitingcard"]["type"] == "image/png") ||($_FILES["businessvisitingcard"]["type"] == "image/jpg") || 
                 ($_FILES["businessvisitingcard"]["type"] == "image/jpeg") ) && 
                 ($_FILES["businessvisitingcard"]["size"] < 10000000) && 
                  in_array($file_extension, $validextensions)){
                if ($_FILES["businessvisitingcard"]["error"] > 0)
                  {
                    $business_status = false;
                    echo json_encode(array('status' => 201,'response'=>$_FILES["businessvisitingcard"]["error"]));
                  } else {
                    $sourcePath = $_FILES['businessvisitingcard']['tmp_name'];// Store source path in a variable
                    $targetPath = "assets/upload/business/" . $_FILES['businessvisitingcard']['name']; // The Target path where file is to be stored
                    move_uploaded_file($sourcePath,$targetPath); // Moving Uploaded file
                     // The Image Data
                     $business_post_data['bussiness_visiting_card'] = $_FILES["businessvisitingcard"]["name"];
                     $business_status = true;
                    } 
                  }
        }
        if($business_status == true){
            $Common->insert_data('hrms_bussiness_list', $business_post_data);
            echo json_encode(array('status' => 200,'response'=>'SuccessFully Add Business'));
        }
    }
    private function return_data(){
        $data['user_id'] = $this->session->userdata('id');
        $data['user'] = $this->common_data($data['user_id']);
        if($data['user']->role_id != 1){
            $data['parivar'] = $this->get_parivar_details($data['user']->hrms_user_id);
        }else{
            $data['parivar'] = $this->common_data($data['user_id']);
        }
        return $data;
    }
    private function common_data($user_id){
        $Common =  new Commn();
        $result = get_field('hrms_user',array('id' =>$user_id),'*');
        $other_result = get_field('staff_user',array('id' =>$user_id),'*');

        if(isset($result) && !empty($result)){
            if($result->status == 0){
                $response = array('message'=> 'you are blocked','code'=> 404);
                echo json_encode($response);
                return false;
            }else{
                $response = array('data'=> $result,'code'=> 200);
                $role =  get_field('role',array('id' =>$result->role_id),'*');
                $result->role_name = $role->name;
                return ($result);
            }
        }
        if(isset($other_result) && !empty($other_result)){
            if($other_result->status == 0){
                $response = array('message'=> 'you are blocked','code'=> 404);
                echo json_encode($response);
                return false;
            }else{
                $response = array('data'=> $other_result,'code'=> 200);
                $role =  get_field('role',array('id' =>$other_result->role_id),'*');
                $other_result->role_name = $role->name;
                return ($other_result);
            }
        }
        // return true;
    }
    private function get_parivar_details($hrms_user_id){
        $result = get_field('hrms_user',array('id' =>$hrms_user_id),'*');
         return ($result);
    } 
}
?>