<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Commn');
        $id = $this->session->userdata('id');
        if(empty($id)){
            redirect('/');
        }
    }

    public function index(){

        $data = $this->return_data();
        $Common =  new Commn();
        $data['users'] = $Common->where_all_records('staff_user',array('hrms_user_id'=>$data['parivar']->id),'*');
        $this->load->view('dashboard/header',$data);
        $this->load->view('users/users',$data);
        $this->load->view('dashboard/footer',$data);
    }

    public function add_user(){
        $data = $this->return_data();
        $Common =  new Commn();
        $data['gams'] = get_all_field('gam',array('hrms_user_id'=>$data['parivar']->id),'*','name','asc');
        $data['roles'] = $Common->all_records('role','*');
        $this->load->view('dashboard/header',$data);
        $this->load->view('users/add_user',$data);
        $this->load->view('dashboard/footer',$data);
    }

    public function save_user(){
        $data = $this->return_data();
        $data['mobileno'] = get_field('staff_user',array('mobileno'=> $this->input->post('mobile_no')),'mobileno');
        $data['email'] = get_field('staff_user',array('email'=> $this->input->post('email')),'email');
        $data['other_mobileno'] = get_field('hrms_user',array('mobileno'=> $this->input->post('mobile_no')),'mobileno');

        $data['other_email'] = get_field('hrms_user',array('email'=> $this->input->post('email')),'email');
        if(isset($data['mobileno'])){
            $response = array('message'=> 'Mobile No already Exist','code'=> 404);
            echo json_encode($response);
            return false;
        }
        if(isset($data['email'])){
            $response = array('message'=> 'Email Address already Exist','code'=> 404);
            echo json_encode($response);
            return false;
        }
        if(isset($data['other_mobileno'])){
            $response = array('message'=> 'Mobile No already Exist','code'=> 404);
            echo json_encode($response);
            return false;
        }
        if(isset($data['other_email'])){
            $response = array('message'=> 'Email Address already Exist','code'=> 404);
            echo json_encode($response);
            return false;
        }

        $data_user = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'mobileno' => $this->input->post('mobile_no'),
            'hrms_user_id' => $data['parivar']->id,
            'gam_id' => $this->input->post('gam'),
            'role_id' => $this->input->post('role'),
            'status' => 1,
        );
        $Common =  new Commn();
        $user = $Common->insert_data('staff_user', $data_user);
        if($user){
            $response = array('message'=> 'SuccessFully Add User','code'=> 200);
            echo json_encode($response);
            return false;
        }

    }

    public function update_subscription(){
        $Common =  new Commn();
        $current_user = $this->session->userdata('id'); 
        $member_user=  get_field('user_membership_plan',array('mobileno' => $this->input->post('mobileno')),'*');
        $pay_list = $this->input->post('pay_list[]');
        $status = 0;
            if(isset($pay_list)){
                foreach ($pay_list as $key => $list) {
                    if($list != ''){
                        $pay_id = get_field('type_pay_list',array('name' => $key),'id');
                        $table = 'plan_member';
                        $data = array(
                            'type_pay' => $pay_id->id,
                            'total_amount' => $list,
                            'member_user' => $member_user->id,
                            'user_id ' => $current_user,
                            'no_of_entry' => 2,
                            'year' => date('Y'),
                        );
                        $plan_member = $Common->insert_data('plan_member', $data);
                        $status = 1;
                    }
                }
            }
            if($status == 1){
                echo json_encode(array('status' => 200,'response'=>'SuccessFully Add Memebrship'));
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