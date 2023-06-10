<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {
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
        $data['gams'] = get_all_field('gam',array('hrms_user_id'=>$data['parivar']->id),'*','name','asc');
        $data['educations'] = $Common->where_all_records('hrms_eduction_list', array('hrms_user_id' => $data['parivar']->id),'*');
        if($member_user){
            $user_id = $member_user->id;
            $data['member_user'] = $member_user;
            $data['subscriptions'] = $Common->where_all_records('hrms_user_plan', array('member_user_id' => $user_id),'*');
            $data['eduction_list'] = $Common->where_all_records('hrms_member_eduction_list', array('member_user_id' => $user_id,'year' => date('Y')),'*');
        }
       
        $this->load->view('dashboard/header',$data);
        $this->load->view('user/newsubscription',$data);
        $this->load->view('dashboard/footer',$data);
    }
    public function edit(){
        $data = array('');
        $data = $this->return_data();
        $Common =  new Commn();
        $mobileno = $this->input->get('mobileno');
        $member_user =  $Common->select_get_row_data('user_membership_plan',array('mobileno' => $mobileno),'*');
        $data['type_pay_list'] =  $Common->all_records('hrms_type_pay_list','*');
        $data['gams'] = get_all_field('gam',array('hrms_user_id'=>$data['parivar']->id),'*','name','asc');
        $data['educations'] = $Common->where_all_records('hrms_eduction_list', array('hrms_user_id' => $data['parivar']->id),'*');
        if($member_user){
            $user_id = $member_user->id;
            $data['member_user'] = $member_user;
            $data['subscriptions'] = $Common->where_all_records('hrms_user_plan', array('member_user_id' => $user_id),'*');
            $data['user_membership_plan_settings'] = $Common->select_get_row_data('user_membership_plan_settings', array('member_user_id' => $user_id),'*');
            $data['member_list'] = $Common->where_all_records('hrms_member_of_user_home', array('member_user_id' => $user_id),'*');
        }
        $this->load->view('dashboard/header',$data);
        $this->load->view('user/edit',$data);
        $this->load->view('dashboard/footer',$data);
    }

    public function printview(){
        $data = $this->return_data();

        $Common =  new Commn();

        $mobile_no = $this->input->get('mobileno');

        $data['member_user']=  get_field('user_membership_plan',array('mobileno' => $mobile_no ,'hrms_user_id' => $data['parivar']->id),'*');

        $data['member_user_setting']=  get_field('user_membership_plan_settings',array('member_user_id' =>$data['member_user']->id ,'hrms_user_id' => $data['parivar']->id),'*');

        $data['list_membership'] = $Common->where_all_records('hrms_user_plan', array('member_user_id' => $data['member_user']->id),'*');
       
        $data['staff_user']=  get_field('staff_user',array('id' =>  $data['member_user']->hrms_staff_id),'*');

       

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
        $this->dompdf->stream($file_name, array("Attachment"=>1));
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

        if($data['user']->role_id == 1){
            $current_user = null;
        }
        if(empty($member_user)){
            $membership_plan = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'mobileno' => $this->input->post('mobile_no'),
                'gam_id' => $this->input->post('gam'),
                'year' => date('Y'),
                'hrms_staff_id' => $current_user,
                'hrms_user_id' => $data['parivar']->id,
            );

            $user_membership_plan_data = $Common->insert_data('user_membership_plan', $membership_plan);
            $last_member_user_id =  $this->db->insert_id();
            $membership_plan_settings = array(
                'edu_no_of_child' => $this->input->post('no_of_child_std'),
                'no_of_result' => $this->input->post('submit_result'),
                'pay_of_notebook' => $this->input->post('notebook'),
                'no_of_home_person' => $this->input->post('total_member'),
                'year' => date('Y'),
                'member_user_id' =>$last_member_user_id,
                'hrms_staff_id' => $current_user,
                'hrms_user_id' => $data['parivar']->id,
            );
            $membership_plan_settings_data = $Common->insert_data('user_membership_plan_settings', $membership_plan_settings);
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
                            'member_age' => $sabhy['age'],
                            'member_edu' => isset($sabhy['std']) ? $sabhy['std'] : null,
                            'present_member' => isset($sabhy['present']) ? $sabhy['present'] : '',
                            'member_user_id' => $last_member_user_id,
                            'staff_id ' => $current_user,
                            'hrms_user_id ' =>$data['parivar']->id,
                        );
                        $user_home = $Common->insert_data('hrms_member_of_user_home', $datass);
                        $last_user_home_id =  $this->db->insert_id();   

                        if(isset($sabhy['present']) && $sabhy['present'] == 1){
                            $present_member = array(
                                'std' => isset($sabhy['std']) ? $sabhy['std'] : null,
                                'year' => date('Y'),
                                'home_member_id' => $last_user_home_id,
                                'member_user_id' => $last_member_user_id,
                                'staff_id ' => $current_user,
                                'hrms_user_id ' =>$data['parivar']->id
                            );
                            $present_member_list = $Common->insert_data('hrms_member_eduction_list', $present_member);
                        }

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

    public function update_details_subscription(){
    
        $Common =  new Commn();
        $current_user = $this->session->userdata('id'); 
        $member_user=  get_field('user_membership_plan',array('mobileno' => $this->input->post('mobileno')),'*');
        $pay_list = $this->input->post('pay_list[]');
        $data = $this->return_data();

     $details = array(
        'name' => $this->input->post('name'),
        'address' => $this->input->post('address'),
        'gam_id' => $this->input->post('gam'),
     );
     $Common->update_data('user_membership_plan', $details, array('mobileno'=>$this->input->post('mobileno')));
    
     $membership_plan_settings = array(
        'edu_no_of_child' => $this->input->post('no_of_child_std'),
        'no_of_result' => $this->input->post('submit_result'),
        'pay_of_notebook' => $this->input->post('notebook'),
        'no_of_home_person' => $this->input->post('total_member'),
        'year' => date('Y')
    );
    $Common->update_data('user_membership_plan_settings', $membership_plan_settings, array('member_user_id'=> $member_user->id));

     $sabhylist = $this->input->post('sabhy[]');

     if(isset($sabhylist)){
        foreach ($sabhylist as $key => $sabhy) {
            
            if (str_contains($key, 'null')) {
                $datass = array(
                    'member_name' => $sabhy['name'],
                    'member_age' => $sabhy['age'],
                    'year' => date('Y'),
                    'member_edu' => empty($sabhy['std']) ? null : $sabhy['std'],
                    'present_member' => isset($sabhy['present']) ? $sabhy['present'] : '',
                    'member_user_id' => $member_user->id,
                    'staff_id ' => $member_user->hrms_staff_id,
                    'hrms_user_id ' =>$data['parivar']->id,
                );
                $Common->insert_data('hrms_member_of_user_home', $datass);
                $last_user_home_id =  $this->db->insert_id();   
                    if(isset($sabhy['present']) && $sabhy['present'] == 1){
                        $present_member = array(
                            'std' => empty($sabhy['std']) ? null : $sabhy['std'],
                            'year' => date('Y'),
                            'home_member_id' => $last_user_home_id,
                            'member_user_id' => $member_user->id,
                            'staff_id ' => $member_user->hrms_staff_id,
                            'hrms_user_id ' =>$data['parivar']->id,
                        );
                        $present_member_list = $Common->insert_data('hrms_member_eduction_list', $present_member);
                    }
                $status = 1;
            }else{
                $datass = array(
                    'member_name' => $sabhy['name'],
                    'member_age' => $sabhy['age'],
                    'year' => date('Y'),
                    'member_edu' => empty($sabhy['std']) ? null : $sabhy['std'],
                    'present_member' => isset($sabhy['present']) ? $sabhy['present'] : '',
                    'member_user_id' => $member_user->id,
                    'staff_id ' => $member_user->hrms_staff_id,
                    'hrms_user_id ' =>$data['parivar']->id,
                );
                $Common->update_data('hrms_member_of_user_home', $datass, array('id'=>$key)); 
                    if(isset($sabhy['present']) && $sabhy['present'] == 1){
                        $get_record = get_field('hrms_member_eduction_list',array('home_member_id' => $key,'year' => date('Y')),'*');
                        if(!$get_record){
                            $present_member = array(
                                'std' => empty($sabhy['std']) ? null : $sabhy['std'],
                                'year' => date('Y'),
                                'home_member_id' => $key,
                                'member_user_id' => $member_user->id,
                                'staff_id ' => $member_user->hrms_staff_id,
                                'hrms_user_id ' =>$data['parivar']->id,
                            );
                            $present_member_list = $Common->insert_data('hrms_member_eduction_list', $present_member);
                        }
                    }else{
                        $get_record = get_field('hrms_member_eduction_list',array('home_member_id' => $key,'year' => date('Y')),'*');
                        if($get_record){
                            $where = array('id' => $get_record->id);
                            $Common->delete_data('hrms_member_eduction_list', $where);
                        }
                    }
                $status = 1;
            }
        }
        }else{
            $status = 1;
        }
        if($status == 1){
            echo json_encode(array('status' => 200,'response'=>'SuccessFully Update Details'));
        }
    }

    public function update_edu(){
        $Common =  new Commn();
        $current_user = $this->session->userdata('id');
        $data = $this->return_data();

        $home_member_id = $this->input->post('home_member_id');
        $member_user_id = $this->input->post('member_user_id');
        $std = $this->input->post('std');
        $percentage = $this->input->post('percentage');
        $year = $this->input->post('year');
        $get_record = get_field('hrms_member_eduction_list',array('home_member_id' => $home_member_id,'year' => $year),'*');
        $status = 0;
        if($get_record){
            $update_data = array('std' => $std,'percentage' => $percentage);
            $where = array('id' => $get_record->id);
            $Common->update_data('hrms_member_eduction_list', $update_data, $where);
            $status = 1;
        }else{
            if($data['user']->role_id == 1){
                $current_user = null;
            }
            $update_data = array(
                'std' => $std,
                'percentage' => $percentage,
                'year' => $year,
                'home_member_id' => $home_member_id,
                'member_user_id' => $member_user_id,
                'staff_id ' => $current_user,
                'hrms_user_id ' =>$data['parivar']->id
            );
            $member_eduction_list = $Common->insert_data('hrms_member_eduction_list', $update_data);
            $status = 1;
        }
        if($status == 1){
            echo json_encode(array('code' => 200,'message'=>'SuccessFully Update Details'));
        }
    }

    public function delete_subscrption_rec(){
        $Common =  new Commn();
        $id = $this->input->post('id');
        $Common->delete_data('hrms_user_plan',array('id' => $id));
        echo json_encode(array('code' => 200,'message'=>'SuccessFully Delete Record'));
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