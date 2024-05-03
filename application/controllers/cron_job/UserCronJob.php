<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserCronJob extends CI_Controller {
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
        $Common =  new Commn();
        $user_id = $this->session->userdata('id');
        $current_user = $this->session->userdata('id'); 
        $data = $this->return_data();
        $data['user_home'] = $Common->where_all_records('hrms_member_of_user_home', array('hrms_user_id' => $user_id),'*');
        if($data['user_home']){
            foreach ($data['user_home'] as $key => $user_home) {
                if($user_home->member_age){
                    $update_age = ($user_home->member_age + 1);
                }else{
                    $update_age = $user_home->member_age;
                }
                
                $get_home_rec_ = $Common->get_row_data('hrms_member_of_user_home',array('year' => date('Y'),'id'=>$user_home->id));


                if(!$get_home_rec_){
                    $user_old_std = $user_home->member_edu;

                    if($user_home->present_member == 1){
                        if($user_old_std < 12){
                          $user_old_std = ($user_old_std +1);
                        }
                        if($user_old_std < 19 && $user_old_std > 12){

                            if($user_old_std == 13){
                                $user_old_std = ($user_old_std + 1);
                            }
                            if($user_old_std == 15){
                                $user_old_std = ($user_old_std + 1);
                            }
                            if($user_old_std == 17){
                                $user_old_std = ($user_old_std + 1);
                            }
                            if($user_old_std == 14 || $user_old_std == 16 || $user_old_std == 18){
                                $user_old_std = 19;
                            }
                        }
                    }
                    $update_user_home_data = array('member_edu' => $user_old_std,'year' => date('Y'),'present_member' => '', 'member_age' => $update_age);
                    $Common->update_data('hrms_member_of_user_home',$update_user_home_data, array('id'=>$user_home->id));

                    $user_membership_plan_settings = $Common->get_row_data('user_membership_plan_settings',array('year' => date('Y'),'member_user_id'=>$user_home->id));


                    if(!$user_membership_plan_settings){
                        $old_user_membership_plan_settings = $Common->get_row_data('user_membership_plan_settings',array('year' =>date("Y",strtotime("-1 year")),'member_user_id'=>$user_home->id));

                        if($old_user_membership_plan_settings){
                            $total_member = $Common->where_all_records('hrms_member_of_user_home', array('member_user_id'=> $old_user_membership_plan_settings->member_user_id,'hrms_user_id' => $user_id),'*');
                            // echo $this->db->last_query() .'</br>';
                            $add_setting_record = array(
                                'edu_no_of_child' => 0,
                                'no_of_result' => 0,
                                'pay_of_notebook' => 0,
                                'no_of_home_person' => count($total_member),
                                'year' => date('Y'),
                                'member_user_id' => $old_user_membership_plan_settings->member_user_id,
                                'hrms_staff_id' => $old_user_membership_plan_settings->hrms_staff_id,
                                'hrms_user_id' => $old_user_membership_plan_settings->hrms_user_id
                            );
                        }
            
                        $Common->insert_data('user_membership_plan_settings', $add_setting_record);
                    }

                    if($user_home->id){
                        $user_eduction_list =  $Common->select_get_row_data('hrms_member_eduction_list',array('home_member_id' => $user_home->id),'*');
                        if($user_eduction_list){
                            $home_member_id = $user_eduction_list->home_member_id;
                            $member_user_id = $user_eduction_list->member_user_id;
                            $staff_id = $user_eduction_list->staff_id;
                            $hrms_user_id = $user_eduction_list->hrms_user_id;
                            if($user_eduction_list->year == date('Y')){

                            }else{
                                $old_std = $user_eduction_list->std;
                                if($old_std < 12){
                                   $old_std = ($old_std + 1); 
                                }
                                if($old_std < 19 && $old_std > 12){
                                    if($old_std == 13){
                                        $old_std = ($old_std + 1);
                                    }
                                    if($old_std == 15){
                                        $old_std = ($old_std + 1);
                                    }
                                    if($old_std == 17){
                                        $old_std = ($old_std + 1);
                                    }
                                    if($old_std == 14 || $old_std == 16 || $old_std == 18){
                                        $old_std = 19;
                                    }
                                }
                                $new_std_rec = array(
                                    'std' => $old_std,
                                    'percentage' => '',
                                    'year' => date('Y'),
                                    'home_member_id' => $home_member_id,
                                    'member_user_id' => $member_user_id,
                                    'staff_id' => $staff_id,
                                    'hrms_user_id' => $hrms_user_id,
                                ); 
                                $Common->insert_data('hrms_member_eduction_list', $new_std_rec);
                            }
                        }
                    }
                }
            }
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