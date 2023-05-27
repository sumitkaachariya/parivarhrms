<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {
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

        $data = array('');
        $data['user_id'] = $this->session->userdata('id');
        $current_user = $this->session->userdata('id'); 
        $data = $this->return_data();

        if($data['user']->role_id == 1 || $data['user']->role_id == 2){
            $where = array('hrms_user_id' => $data['parivar']->id);
        }else{
            $where = array('hrms_staff_id' => $current_user, 'hrms_user_id' => $data['parivar']->id);
        }
        
        $Common =  new Commn();
        $data['subscriptions'] = $Common->where_all_records('user_membership_plan',$where,'*');

       
        $this->load->view('dashboard/header',$data);
        $this->load->view('user/subscription',$data);
        $this->load->view('dashboard/footer',$data);
    }

    public function new(){
        $data = array('');
        $data = $this->return_data();
        $Common =  new Commn();
        $mobileno = $this->input->get('mobileno');
        $member_user =  $Common->select_get_row_data('user_membership_plan',array('mobileno' => $mobileno),'*');
        $data['type_pay_list'] =  $Common->all_records('hrms_type_pay_list','*');
        $data['gams'] = get_all_field('gam',array('hrms_user_id'=>$data['parivar']->id),'*');
        if($member_user){
            $user_id = $member_user->id;
            $data['member_user'] = $member_user;
            $data['subscriptions'] = $Common->where_all_records('hrms_user_plan', array('member_user_id' => $user_id),'*');
        }


        // echo "<pre>";print_r($data);
        // die;
        $this->load->view('dashboard/header',$data);
        $this->load->view('user/newsubscription',$data);
        $this->load->view('dashboard/footer',$data);
    }

    public function printview(){
        $data = $this->return_data();

        $Common =  new Commn();

        $mobile_no = $this->input->get('mobileno');

        $data['member_user']=  get_field('user_membership_plan',array('mobileno' => $mobile_no ,'hrms_user_id' => $data['parivar']->id),'*');

        $data['list_membership'] = $Common->where_all_records('hrms_user_plan', array('member_user_id' => $data['member_user']->id),'*');
       
        $data['staff_user']=  get_field('staff_user',array('id' =>  $data['member_user']->hrms_staff_id),'*');

        // echo "<pre>";print_r($data);
        // die;

        $amount = array(
            'varshik_lavajam' => 0,
            'danbhet' => 0,
            'notebook' => 0,
            'other' => 0,
        );
        if(isset($data['list_membership'])){
            foreach ($data['list_membership'] as $key => $list_membership) {
                if($list_membership->type_pay == 1){
                    $amount['varshik_lavajam'] = ($amount['varshik_lavajam'] + $list_membership->total_amount);
                }
                if($list_membership->type_pay == 2){
                    $amount['danbhet'] = ($amount['danbhet'] + $list_membership->total_amount);
                }
                if($list_membership->type_pay == 3){
                    $amount['notebook'] = ($amount['notebook'] + $list_membership->total_amount);
                }
                if($list_membership->type_pay == 4){
                    $amount['other'] = ($amount['other'] + $list_membership->total_amount);
                }
            }
        }
        $data['amount'] = $amount;
        $this->load->view('user/printview',$data);
        // Get output html
        $html = $this->output->get_output();

        // Load pdf library
        $this->load->library('pdf');
        
        $dompdf = new Pdf('UTF-8');

        $this->dompdf->set_option('isHtml5ParserEnabled', true);
        $this->dompdf->set_option('isRemoteEnabled', true);   

        // Load HTML content
        $this->dompdf->loadHtml($html, 'UTF-8');
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');
        
        // Render the HTML as PDF
        $this->dompdf->render();
        
        $file_name = $data['member_user']->name.'.pdf';
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream($file_name, array("Attachment"=>0));
    }

    public function submit_subscription(){
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
        $member_user=  get_field('user_membership_plan',array('mobileno' => $this->input->post('mobileno')),'*');

        
        if(empty($member_user)){
            $membership_plan = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'mobileno' => $this->input->post('mobile_no'),
                'gam_id' => $this->input->post('gam'),
                'edu_no_of_child' => $this->input->post('no_of_child_std'),
                'no_of_result' => $this->input->post('submit_result'),
                'pay_of_notebook' => $this->input->post('notebook'),
                'no_of_home_person' => $this->input->post('total_member'),
                'year' => date('Y'),
                'hrms_staff_id' => $current_user,
                'hrms_user_id' => $data['parivar']->id,
            );

            $user_membership_plan_data = $Common->insert_data('user_membership_plan', $membership_plan);
            $last_member_user_id =  $this->db->insert_id();
            $pay_list = $this->input->post('pay_list[]');
            $sabhylist = $this->input->post('sabhy[]');

            $status = 1;
            if(isset($pay_list)){
                foreach ($pay_list as $key => $list) {
                    if($list != ''){

                        $pay_id = get_field('hrms_type_pay_list',array('name' => $key,'hrms_user_id' => $data['parivar']->id),'id');
                        $table = 'hrms_user_plan';
                        $datas = array(
                            'type_pay' => $pay_id->id,
                            'total_amount' => $list,
                            'member_user_id' => $last_member_user_id,
                            'staff_id ' => $current_user,
                            'hrms_user_id ' =>$data['parivar']->id,
                            'no_of_entry' => 1,
                            'year' => date('Y'),
                        );
                        $plan_member = $Common->insert_data('hrms_user_plan', $datas);
                        $status = 1;
                    }
                }
            }else{
                $status = 1;
            }
            if(isset($sabhylist)){
                foreach ($sabhylist as $key => $sabhy) {
                    if($sabhy != ''){
                       
                        $datass = array(
                            'member_name' => $sabhy['name'],
                            'member_edu' => $sabhy['edu'],
                            'member_user_id' => $last_member_user_id,
                            'staff_id ' => $current_user,
                            'hrms_user_id ' =>$data['parivar']->id,
                        );
                        $plan_member = $Common->insert_data('hrms_member_of_user_home', $datass);
                        $status = 1;
                    }
                }
            }else{
                $status = 1;
            }
            if($status == 1){
                echo json_encode(array('status' => 200,'response'=>'SuccessFully Add Memebrship'));
            }
        }else{
            echo json_encode(array('status' => 400,'response'=>'Already added member'));
        }
    }

    public function remark(){
        $Common =  new Commn();
        $data = array('remark'=>$this->input->post('remark_text'));
        $result = $Common->update_data('user_membership_plan',$data,array('mobileno' => $this->input->post('mobileno')));
        if($result){
            $response = array('message'=> 'Successfully Addded Remark','code'=> 200);
            echo json_encode($response);
        }
    }

    public function update_subscription(){
        $Common =  new Commn();
        $current_user = $this->session->userdata('id'); 
        $member_user=  get_field('user_membership_plan',array('mobileno' => $this->input->post('mobileno')),'*');
        $pay_list = $this->input->post('pay_list[]');
        $data = $this->return_data();
        $status = 0;
            if(isset($pay_list)){
                foreach ($pay_list as $key => $list) {
                    if($list != ''){
                        $pay_id = get_field('hrms_type_pay_list',array('name' => $key),'id');
                        $table = 'hrms_user_plan';
                        $res = array(
                            'type_pay' => $pay_id->id,
                            'total_amount' => $list,
                            'member_user_id' => $member_user->id,
                            'staff_id ' => $member_user->hrms_staff_id,
                            'hrms_user_id ' => $data['parivar']->id,
                            'no_of_entry' => 2,
                            'year' => date('Y'),
                        );
                        $plan_member = $Common->insert_data('hrms_user_plan', $res);
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