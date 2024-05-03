<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capitation extends CI_Controller {
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
        $data = $this->return_data();
        $Common =  new Commn();
    
        $data['total_users'] = $Common->where_all_records('hrms_member_of_user_home', array('hrms_user_id' => $data['parivar']->id),'*');
        $data['group_by_capitation'] = $Common->group_by_capitation_();
        $data['total_capitation'] = count($data['total_users']);
 
        $this->load->view('dashboard/header',$data);
        $this->load->view('capitation/capitation',$data);
        $this->load->view('dashboard/footer',$data);
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
                $role =  get_field('role',array('id' =>$result->role_id),'*');
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