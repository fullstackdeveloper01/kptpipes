<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Plumbers extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plumbers_model');
    }

    /* Index function of this controller */
    public function index()
    {
        // if (!has_permission('plumbers', '', 'view')) {
        //     access_denied('plumbers');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('plumbers');
        }
       
        $sheader_text = title_text('aside_menu_active', 'plumbers');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/plumbers/plumbers', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        // if (!has_permission('plumbers', '', 'view')) {
        //     access_denied('plumbers');
        // }
        if (!checkPermissions('plumber')) {
            access_denied('plumber');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                // if (!has_permission('plumbers', '', 'create')) {
                //     access_denied('plumbers');
                // }
                $data['plumber_dob'] = date('Y-m-d', strtotime(str_replace('/','-',$data['plumber_dob'])));
                $data['plumber_doj'] = date('Y-m-d', strtotime($data['plumber_doj']));
                $plumber_password = rand(10000,99999);
                $data['plumber_password'] = md5($plumber_password);
                $data['plumber_pass'] = $plumber_password;
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->plumbers_model->add_article($data);
                if ($id) {
                    $uploadedFiles = handle_file_upload($id,'plumbers', 'plumber');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'plumber', [$file]);
                        }
                    } 
                    set_alert('success', _l('added_successfully', _l('Plumber')));
                    redirect(admin_url('plumbers'));
                }
            } else {
                // if (!has_permission('plumbers', '', 'edit')) {
                //     access_denied('plumbers');
                // }
                $data['plumber_dob'] = date('Y-m-d', strtotime(str_replace('/','-',$data['plumber_dob'])));
                $data['plumber_doj'] = date('Y-m-d', strtotime($data['plumber_doj']));
                $success = $this->plumbers_model->update_article($data, $id);  
                if($_FILES['plumber']['name'] != '')
                {
                    $this->plumbers_model->delete_image($id,'plumber');
                    $uploadedFiles = handle_file_upload($id,'plumbers', 'plumber');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'plumber', [$file]);
                        }
                    }
                }           
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Plumber')));
                }
                redirect(admin_url('plumbers'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->plumbers_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'plumbers');
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();   
        $data['dealer_list'] = $this->db->get_where('tbldealer', array('status' => 1))->result(); 
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/plumbers/plumber', $data);
    }

    /* View plumber details*/
    public function view($id)
    {
        $article         = $this->plumbers_model->get($id);
        $data['article'] = $article;
        
        $sheader_text = title_text('aside_menu_active', 'plumbers');
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();   
        $data['dealer_list'] = $this->db->get_where('tbldealer', array('status' => 1))->result(); 
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);

        $where['user_id']=$id;
        $where['type']='plumber';
        $data['totalpoints'] = $this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->get()->row('points');
        $data['redeempoints'] = $this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->where(['status_type'=>'less'])->get()->row('points');
        $data['availablepoints'] =$this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->where(['status_type'=>'add'])->get()->row('points');

        $this->load->view('admin/plumbers/view', $data);
    }

    /* Function: State List */
    public function getStatelist()
    {
        $profileResult = [];
        $country = $_POST['country'];
        $profileResult = $this->db->get_where(db_prefix().'state', array('country_id' => $country))->result();
        echo json_encode($profileResult);
    }
    
    /* Function: City List */
    public function getCitylist()
    {
        $profileResult = [];
        $state = $_POST['state'];
        $profileResult = $this->db->get_where(db_prefix().'city', array('state_id' => $state))->result();
        echo json_encode($profileResult);
    }
    /**
    * @funciton: inactive Count
    */
    public function counts($status)
    {
        if ($this->input->is_ajax_request()) {        
            $where['status'] = $status;
            $count =  $this->db->get_where(db_prefix().'plumber', $where)->num_rows();
            echo json_encode($count);
            die;
        }
    }

    /**
    * @funciton: Check Pan number
    */
    public function checkPanNumber()
    {
        if ($this->input->is_ajax_request()) {   
            $pan=$this->input->post('panno');
            $id=$this->input->post('id');
            
            $where['dealer_pan_number'] = $pan;
            $where['status'] = 1; 
            $count =  $this->db->get_where(db_prefix().'dealer', $where)->num_rows();
            
            $where1['distributor_pan_number'] = $pan;
            $where1['status'] = 1; 
            $count1 =  $this->db->get_where(db_prefix().'distributors', $where1)->num_rows();
            
            if ($id!="") {
                $where2['plumber_pan_number'] = $pan;
                $where2['status'] = 1;                
                $count2 = $this->db->from(db_prefix().'plumber')->where($where2)->where('id !=', $id)->get()->num_rows();
            }else{   
                $where2['plumber_pan_number'] = $pan;
                $where2['status'] = 1; 
                $count2 = $this->db->get_where(db_prefix().'plumber', $where2)->num_rows();
            }
            if ($count == 0 && $count1 == 0 && $count2 == 0) {
                $resc=0;
            }else{
                $resc=1;
            }
            echo json_encode($resc);
            die;
        }
    }
    /**
    * @funciton: Check Aadhar number
    */
    public function checkAadharNumber()
    {
        if ($this->input->is_ajax_request()) {   
            $aadhar=$this->input->post('aadhaar_no');
            $id=$this->input->post('id');

            
            $where['dealer_aadhar_number'] = $aadhar;
            $where['status'] = 1;                
            $count =  $this->db->get_where(db_prefix().'dealer', $where)->num_rows();
            
            $where1['distributor_aadhar_number'] = $aadhar;
            $where1['status'] = 1; 
            $count1 =  $this->db->get_where(db_prefix().'distributors', $where1)->num_rows();
            
            if ($id!="") {
                $where2['plumber_aadhar_number'] = $aadhar;
                $where2['status'] = 1;                
                $count2 = $this->db->from(db_prefix().'plumber')->where($where2)->where('id !=', $id)->get()->num_rows();
            }else{
                $where2['plumber_aadhar_number'] = $aadhar;
                $where2['status'] = 1; 
                $count2 = $this->db->get_where(db_prefix().'plumber', $where2)->num_rows();
            }
            if ($count == 0 && $count1 == 0 && $count2 == 0) {
                $resc=0;
            }else{
                $resc=1;
            }

            echo json_encode($resc);
            die;
        }
    }

    /**
    * @funciton: Check GST number
    */
    public function checkGST()
    {
        if ($this->input->is_ajax_request()) {   
            $where['distributor_GST'] = $this->input->post('gst');
            $count =  $this->db->get_where(db_prefix().'distributors', $where)->num_rows();
            
            $where1['dealer_GST'] = $this->input->post('gst');
            $count1 = $this->db->get_where(db_prefix().'dealer', $where1)->num_rows();

            if ($count == 0 && $count1 == 0 ) {
                $resc=0;
            }else{
                $resc=1;
            }

            echo json_encode($resc);
            die;
        }
    }
    /**
    * @funciton: Check Email of distributor
    */
    public function checkemail()
    {
        if ($this->input->is_ajax_request()) {   
            // $resc = checkEmail($this->input->post('email'));
            // echo json_encode($resc);
            // die;
            $email=$this->input->post('email');
            $id=$this->input->post('id');
            
            $where['dealer_email'] = $email;
            $where['status'] = 1;
            $count =  $this->db->get_where(db_prefix().'dealer', $where)->num_rows();
            
            $where1['distributor_email'] = $email;
            $where1['status'] = 1;
            $count1 =  $this->db->get_where(db_prefix().'distributors', $where1)->num_rows();

            if ($id!="") {
                $where2['plumber_email'] = $email;
                $where2['status'] = 1;                
                $count2 = $this->db->from(db_prefix().'plumber')->where($where2)->where('id !=', $id)->get()->num_rows();
            }else{
                $where2['plumber_email'] = $email;
                $where2['status'] = 1;
                $count2 = $this->db->get_where(db_prefix().'plumber', $where2)->num_rows();
            }
            $where3['email'] = $email;
            $where3['active'] = 1;
            $count3 = $this->db->get_where(db_prefix().'staff', $where3)->num_rows();

            if ($count == 0 && $count1 == 0 && $count2 == 0 && $count3==0) {
                $resc=0;
            }else{
                $resc=1;
            }
            echo json_encode($resc);
            die;
        }
    }

    /**
    * @funciton: Check mobile of distributor
    */
    public function checkmobile()
    {
        if ($this->input->is_ajax_request()) {   
            // $resc = checkMobile($this->input->post('mobile')) ;
            // echo json_encode($resc);
            // die;
            $mobile=$this->input->post('mobile');
            $id=$this->input->post('id');
            
            $where['distributor_mobile'] =$mobile;
            $where['status'] = 1;
            $count = $this->db->get_where(db_prefix().'distributors', $where)->num_rows();

            
            $where1['dealer_mobile'] =$mobile;
            $where1['status'] = 1;
            $count1 = $this->db->get_where(db_prefix().'dealer', $where1)->num_rows();
            if ($id!="") {
                $where2['plumber_mobile'] =$mobile;
                $where2['status'] = 1;
                $count2 = $this->db->from(db_prefix().'plumber')->where($where2)->where('id !=', $id)->get()->num_rows();
            }else{
                $where2['plumber_mobile'] =$mobile;
                $where2['status'] = 1;
                $count2 = $this->db->get_where(db_prefix().'plumber', $where2)->num_rows();
            }
            $where3['phonenumber'] =$mobile;
            $where3['active'] = 1;
            $count3 = $this->db->get_where(db_prefix().'staff', $where3)->num_rows();


            if ($count == 0 && $count1 == 0 && $count2 == 0 && $count3==0) {
                $resc=0;
            }else{
                $resc=1;
            }

            echo json_encode($resc);
            die;
        }
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {  
            if (!checkPermissions('plumber')) {
                access_denied('plumber');
            }
            // $postdata['status'] = $status;
            // $this->db->where('id', $id);
            // $this->db->update(db_prefix().'plumber', $postdata);

            $res = $this->Common_model->get(db_prefix().'plumber',['id'=>$id]);
            // echo $res->distributor_mobile;
            $response = $this->Common_model->get(db_prefix().'user_master',['status'=>1,'mobile'=>$res->plumber_mobile]);
            // $response = $this->Common_model->get(db_prefix().'user_master',['status'=>1,'mobile'=>$res->distributor_mobile,'user_id!='=>$id,'type!='=>'distributor']);

            if ($status == 1 && count($response) == 0) {
                $postdata['status'] = $status;
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'plumber', $postdata);

                $this->db->where(['user_id'=>$id,'type'=>'plumber']);
                $this->db->update(db_prefix().'user_master', $postdata);
            }elseif ($status == 0) {
                $postdata['status'] = $status;
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'plumber', $postdata);
                
                $this->db->where(['user_id'=>$id,'type'=>'plumber']);
                $this->db->update(db_prefix().'user_master', $postdata);
            }
            set_alert('success', _l('updated_successfully', _l('Plumber')));
        }
    }
    
    /* Delete article from database */
    public function delete_plumbers($id)
    {
        if (!checkPermissions('plumber')) {
            access_denied('plumber');
        }
        if (!$id) {
            redirect(admin_url('plumbers'));
        }
        $this->plumbers_model->delete_article($id);        
        set_alert('success', _l('deleted', _l('Plumber')));
        redirect(admin_url('plumbers'));
    }

    /* Distributor List all knowledgebase articles */
    public function list()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('plumbers_list');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Plumbers');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        // $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();  
        // $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();         
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/plumbers/plumber_list', $data);
    }

    /* Reward report */
    public function reward_report()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('plumber_reward');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Plumbers Reward');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/plumbers/rewards', $data);
    }

    //this function is for claim rewards points
    public function claimReward()
    {
        $postData = $this->input->post();
        if(!empty($postData['userid']) && !empty($postData['claim_type']) && !empty($postData['points']) && !empty($postData['comment'])){
            $pointscountadd =  $this->Common_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>'plumber','status_type'=>'add'],'points');
            $pointscountless =  $this->Common_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>'plumber','status_type'=>'less'],'points');
            $pointscount=$pointscountadd-$pointscountless;
            if ($pointscount >= $postData['points'] ) {
                $user_reward['user_id']=$postData['userid'];
                $user_reward['type']='plumber';
                $user_reward['points']=$postData['points'];
                $user_reward['message']=$postData['claim_type'];
                $user_reward['status_type']='less';
                $this->Common_model->Insert(db_prefix().'user_reward',$user_reward);
                $id = $this->db->insert_id();
                if (!empty($id)) {
                    $insertdata['type']='plumber';
                    $insertdata['user_id']=$postData['userid'];
                    $insertdata['claim_type']=$postData['claim_type'];
                    $insertdata['points']=$postData['points'];
                    $insertdata['comment']=$postData['comment'];                    
                    $insertdata['user_reward_id']=$id;
                    $insertdata['status']=1;
                    $response= $this->Common_model->Insert(db_prefix().'claim_reward',$insertdata);
                    if ($response) {
                        set_alert('success', _l('Request claimed Successfully'));
                    }else{
                        set_alert('danger', _l('Request Not Submitted'));
                    }
                }else{
                    set_alert('danger', _l('Some Error Found Please Try Again later.'));
                }
            }else{
                set_alert('danger', _l('Redeem Points Request Is Greater than Available points '));
            }
        }else{
            set_alert('danger', _l('Need To Fill full Form Required'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}
