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
           $today_type_count = $Common->total_assume_type_count($data,date('y-m-d'));
           $all_type_count = $Common->total_assume_type_count($data,'');
        }else{
            $allResult = $Common->admin_total_assume($data,'');
            $todayResult = $Common->admin_total_assume($data,date('y-m-d'));
            $type_count = $Common->admin_total_assume_type_count($data,'');
            $today_type_count = $Common->admin_total_assume_type_count($data,date('y-m-d'));
            $all_type_count = $Common->admin_total_assume_type_count($data,'');
            // $total_villege_by_count =  $Common->total_villege_by_count($data,'');
            // echo $this->db->last_query();
        }   
        $data['total_assume'] = $allResult;
        $data['todayResult'] = $todayResult;
        $data['today_type_count'] = $today_type_count;
        $data['all_type_count'] = $all_type_count;
        
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/dashboard',$data);
        $this->load->view('dashboard/footer',$data);
    }
    public function view_more(){
        $Common =  new Commn();
        $data['user_id'] = $this->session->userdata('id');  
        $data['user'] = $this->common_data($data['user_id']);
        if($data['user']->role_id != 1){
            $data['parivar'] = $this->get_parivar_details($data['user']->hrms_user_id);
        }else{
            $data['parivar'] = $this->common_data($data['user_id']);
        }
        $id = $this->input->get('id');
       
        $data['get_all'] = array();
        if($data['user']->role_id == 3){
            $data['getData'] = $Common->where_all_records('hrms_user_plan',array('type_pay' => $id,'staff_id' =>  $data['user']->id),'*');
            if(isset($data['getData'])){
                foreach ($data['getData'] as $key => $type_val) {
                    $staff_name = get_field('staff_user',array('id' => $type_val->staff_id),'name')->name;
                    $total_amount = $type_val->total_amount;
                    $member_name = get_field('user_membership_plan',array('id' => $type_val->member_user_id),'name')->name;
                    $member_gam_id = $data['user']->gam_id;
                    $gam_name = get_field('gam',array('id' => $member_gam_id),'name')->name;
                    $arr = array(
                        'gam_id' => $member_gam_id,
                        'member_name' => $member_name,
                        'gam_name' => $gam_name,
                        'total_amount' => $total_amount,
                        'staff_name' => $staff_name,
                    );
                    array_push($data['get_all'], $arr);
                }
            }

        }else{
            $data['getData'] = $Common->where_all_records('hrms_user_plan',array('type_pay' => $id),'*');
            $data['gams'] = $Common->order_where_all_records('gam',array('hrms_user_id' => $data['parivar']->id),'*','name','asc');
            if(isset($data['getData'])){
                foreach ($data['getData'] as $key => $type_val) {
                    $staff_name = get_field('staff_user',array('id' => $type_val->staff_id),'name')->name;
                    $total_amount = $type_val->total_amount;
                    $member_name = get_field('user_membership_plan',array('id' => $type_val->member_user_id),'name')->name;
                    $member_gam_id = $Common->select_get_row_data('user_membership_plan', array('id'=> $type_val->member_user_id),'gam_id');
                    $gam_name = get_field('gam',array('id' => $member_gam_id->gam_id),'name')->name;              
                    $arr = array(
                        'gam_id' => $member_gam_id->gam_id,
                        'member_name' => $member_name,
                        'gam_name' => $gam_name,
                        'total_amount' => $total_amount,
                        'staff_name' => $staff_name,
                    );
                    array_push($data['get_all'], $arr);
                }
    
            }
        }
        
        
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/view-more',$data);
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