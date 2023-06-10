<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $maintenance = maintenance();
        if($maintenance == 0){
            $id = $this->session->userdata('id');
            if(empty($id)){
                redirect('/');
            }
        }else{
            redirect('maintenance');
        }
        $this->load->model('Commn');
    }

    public function index(){
        $Common =  new Commn();
        $data['user_id'] = $this->session->userdata('id');  
        $data['user'] = $this->common_data($data['user_id']);
        if($data['user']->role_id != 1){
            $data['parivar'] = $this->get_parivar_details($data['user']->hrms_user_id);
        }else{
            $data['parivar'] = $this->common_data($data['user_id']);
        }   

        if($data['user']->role_id == 3 || $data['user']->role_id == 2){
           $allResult = $Common->total_assume($data,'');
           $todayResult = $Common->total_assume($data,date('y-m-d'));
        }else{
            $allResult = $Common->admin_total_assume($data,'');
            $todayResult = $Common->admin_total_assume($data,'');
        }
        $data['total_assume'] = $allResult;
        $data['todayResult'] = $todayResult;
        
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/dashboard',$data);
        $this->load->view('dashboard/footer',$data);
    }
    public function logout(){
        $this->session->unset_userdata('id');
        redirect('/');
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