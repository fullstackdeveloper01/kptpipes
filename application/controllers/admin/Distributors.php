<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Distributors extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('distributor_model');
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    /* List all knowledgebase articles */
    public function index()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('distributors');
        }
       
        $sheader_text = title_text('aside_menu_active', 'distributors');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();  
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();         
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/distributors/distributors', $data);
    }

    /* List all knowledgebase articles */
    public function stock()
    {
        // if (!has_permission('distributors-stock', '', 'view')) {
        //     access_denied('distributors-stock');
        // }
        if (!checkPermissions('distributor-stock')) {
            access_denied('distributors-stock');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('distributors-stock');
        }
       
        $sheader_text = title_text('aside_menu_active', 'distributors-stock');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        // $data['response'] = $this->db->from('tbluser_stock')->where(array('status' => 1,'type'=>'distributor'))->group_by('product_id')->get()->result_array();
        $this->load->view('admin/distributors/stock', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if (!checkPermissions('distributor')) {
            access_denied('distributor');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            // echo '<pre>'; print_r($data); die;
            if ($id == '') {
                // if (!has_permission('distributors', '', 'create')) {
                //     access_denied('distributors');
                // }
                $pan = checkPanNumber($data['distributor_pan_number']);
                $aadhar = checkAadharNumber($data['distributor_aadhar_number']);
                $gst = checkGST($data['distributor_GST']);
                $mobile = checkMobile($data['distributor_mobile']);
                $email = checkEmail($data['distributor_email']);
                if ($pan == 0 && $aadhar == 0 && $gst == 0 && $mobile == 0 && $email == 0) {
                    $data['distributor_dob'] = date('Y-m-d', strtotime($data['distributor_dob']));
                    $data['distributor_doj'] = date('Y-m-d', strtotime($data['distributor_doj']));
                    $distributor_password = rand(10000,99999);
                    $data['distributor_password'] = md5($distributor_password);
                    $data['distributor_pass'] = $distributor_password;
                    $data['created_date'] = date('Y-m-d h:i:s');
                    $id = $this->distributor_model->add_article($data);
                    if ($id) {
                        $insert['user_id']=$id;
                        $insert['type']='distributor';
                        $insert['mobile']=$data['distributor_mobile'];
                        $this->Common_model->add_article(db_prefix().'user_master',$insert);
                        $uploadedFiles = handle_file_upload($id,'distributors', 'distributor');
                        if ($uploadedFiles && is_array($uploadedFiles)) {
                            foreach ($uploadedFiles as $file) {
                                $this->misc_model->add_attachment_to_database($id, 'distributor', [$file]);
                            }
                        } 
                        set_alert('success', _l('added_successfully', _l('Distributor')));
                        redirect(admin_url('distributors'));
                    }
                }else{
                    set_alert('danger', _l('Some Error Founf Try Again', _l('Distributor')));
                    redirect(admin_url('distributors'));
                }
            } else {
                // if (!has_permission('distributors', '', 'edit')) {
                //     access_denied('distributors');
                // }
                $data['distributor_dob'] = date('Y-m-d', strtotime($data['distributor_dob']));
                $data['distributor_doj'] = date('Y-m-d', strtotime($data['distributor_doj']));
                $success = $this->distributor_model->update_article($data, $id);  
                if($_FILES['distributor']['name'] != '')
                {
                    $this->distributor_model->delete_image($id,'distributor');
                    $uploadedFiles = handle_file_upload($id,'distributors', 'distributor');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'distributor', [$file]);
                        }
                    }
                }           
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Distributor')));
                }
                redirect(admin_url('distributors'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->distributor_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'distributors');
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();   
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        if($id)
        {
            $data['pagename']     = 'profile';
            $this->load->view('admin/distributors/distributors_html', $data);
        }
        else
        {
            $this->load->view('admin/distributors/distributor', $data);
        }
    }

    /* view distributor details*/
    public function view($id)
    {
        
        $article         = $this->distributor_model->get($id);
        $data['article'] = $article;
        
        $sheader_text = title_text('aside_menu_active', 'distributors');
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();   
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $data['pagename']     = 'profile';
        $where['user_id']=$id;
        $where['type']='distributor';
        $data['totalpoints'] = $this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->get()->row('points');
        $data['redeempoints'] = $this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->where(['status_type'=>'less'])->get()->row('points');
        $data['availablepoints'] =$this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->where(['status_type'=>'add'])->get()->row('points');
        $this->load->view('admin/distributors/view', $data);
        
    }

    /* all reward  List of distributor */
    public function reward()
    {
        // if (!checkPermissions('distributor-stock')) {
        //     access_denied('distributors-stock');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('distributors-stock');
        }
       
        $sheader_text = title_text('aside_menu_active', 'distributors-stock');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        // $data['response'] = $this->db->from('tbluser_stock')->where(array('status' => 1,'type'=>'distributor'))->group_by('product_id')->get()->result_array();
        $this->load->view('admin/distributors/stock', $data);
    }
    /**
    * @funciton: Status change
    */
    public function loginDetails($id)
    {
        $sheader_text = title_text('aside_menu_active', 'distributors');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $article         = $this->distributor_model->get($id);
        $data['article'] = $article;
        $data['title']     = _l($sheader_text);
        $data['pagename']     = 'loginDetails';
        $this->load->view('admin/distributors/distributors_html', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {    
            if (!checkPermissions('distributor')) {
                access_denied('distributor');
            }
            $res = $this->Common_model->get(db_prefix().'distributors',['id'=>$id]);
            // echo $res->distributor_mobile;
            $response = $this->Common_model->get(db_prefix().'user_master',['status'=>1,'mobile'=>$res->distributor_mobile]);
            // $response = $this->Common_model->get(db_prefix().'user_master',['status'=>1,'mobile'=>$res->distributor_mobile,'user_id!='=>$id,'type!='=>'distributor']);

            if ($status == 1 && count($response) == 0) {
                $postdata['status'] = $status;
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'distributors', $postdata);
                $this->db->where(['user_id'=>$id,'type'=>'distributor']);
                $this->db->update(db_prefix().'user_master', $postdata);
            }elseif ($status == 0) {
                $postdata['status'] = $status;
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'distributors', $postdata);
                $this->db->where(['user_id'=>$id,'type'=>'distributor']);
                $this->db->update(db_prefix().'user_master', $postdata);
            }
        }
    }
    /**
    * @funciton: inactive Count
    */
    public function counts($status)
    {
        if ($this->input->is_ajax_request()) {        
            $where['status'] = $status;
            $count =  $this->db->get_where(db_prefix().'distributors', $where)->num_rows();
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
            // $resc = checkPanNumber($this->input->post('panno'));
            // echo json_encode($resc);
            // die;
            $pan=$this->input->post('panno');
            $id=$this->input->post('id');
            if ($id!="") {
                $where['distributor_pan_number'] = $pan;
                $where['status'] = 1;                
                $count = $this->db->from(db_prefix().'distributors')->where($where)->where('id !=', $id)->get()->num_rows();
            }else{
                $where['distributor_pan_number'] = $pan;
                $where['status'] = 1;
                $count =  $this->db->get_where(db_prefix().'distributors', $where)->num_rows();
            }
            $where1['dealer_pan_number'] = $pan;
            $where1['status'] = 1;
            $count1 = $this->db->get_where(db_prefix().'dealer', $where1)->num_rows();

            $where2['plumber_pan_number'] = $pan;
            $where2['status'] = 1;
            $count2 = $this->db->get_where(db_prefix().'plumber', $where2)->num_rows();
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
            // $resc = checkAadharNumber($this->input->post('aadhaar_no'));
            // echo json_encode($resc);
            // die;
            $aadhar=$this->input->post('aadhaar_no');
            $id=$this->input->post('id');

            if ($id!="") {
                $where['distributor_aadhar_number'] = $aadhar;
                $where['status'] = 1;                
                $count = $this->db->from(db_prefix().'distributors')->where($where)->where('id !=', $id)->get()->num_rows();
            }else{
                $where['distributor_aadhar_number'] = $aadhar;
                $where['status'] = 1;
                $count =  $this->db->get_where(db_prefix().'distributors', $where)->num_rows();
            }
            $where1['dealer_aadhar_number'] = $aadhar;
            $where1['status'] = 1;
            $count1 = $this->db->get_where(db_prefix().'dealer', $where1)->num_rows();

            $where2['plumber_aadhar_number'] = $aadhar;
            $where2['status'] = 1;
            $count2 = $this->db->get_where(db_prefix().'plumber', $where2)->num_rows();
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
            // $resc = checkGST($this->input->post('gst')) ;
            // echo json_encode($resc);
            // die;
            $gst =$this->input->post('gst');
            $id=$this->input->post('id');
            if ($id!="") {
                $where['distributor_GST'] = $gst;
                $where['status'] = 1;                
                $count = $this->db->from(db_prefix().'distributors')->where($where)->where('id !=', $id)->get()->num_rows();
            }else{
                $where['distributor_GST'] = $gst;
                $where['status'] = 1;
                $count =  $this->db->get_where(db_prefix().'distributors', $where)->num_rows();
            }
            $where1['dealer_GST'] = $gst;
            $where1['status'] = 1;
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
            if ($id!="") {
                $where1['distributor_email'] = $email;
                $where1['status'] = 1;                
                $count1 = $this->db->from(db_prefix().'distributors')->where($where1)->where('id !=', $id)->get()->num_rows();
            }else{
                $where1['distributor_email'] = $email;
                $where1['status'] = 1;
                $count1 =  $this->db->get_where(db_prefix().'distributors', $where1)->num_rows();
            }
            $where2['plumber_email'] = $email;
            $where2['status'] = 1;
            $count2 = $this->db->get_where(db_prefix().'plumber', $where2)->num_rows();

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
            // echo $this->input->post('id');die;
            // $resc = checkMobile($this->input->post('mobile'),$this->input->post('id')) ;
            // echo json_encode($resc);
            // die;
            $mobile=$this->input->post('mobile');
            $id=$this->input->post('id');
            if ($id!="") {
                $where['distributor_mobile'] =$mobile;
                $where['status'] = 1;
                $count = $this->db->from(db_prefix().'distributors')->where($where)->where('id !=', $this->input->post('id'))->get()->num_rows();
            }else{
                $where['distributor_mobile'] =$mobile;
                $where['status'] = 1;
                $count = $this->db->get_where(db_prefix().'distributors', $where)->num_rows();
            }

            $where1['dealer_mobile'] =$mobile;
            $where1['status'] = 1;
            $count1 = $this->db->get_where(db_prefix().'dealer', $where1)->num_rows();

            $where2['plumber_mobile'] =$mobile;
            $where2['status'] = 1;
            $count2 = $this->db->get_where(db_prefix().'plumber', $where2)->num_rows();

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
    * @funciton: Status change
    */
    public function change_featured()
    {
        $menuid = $_POST['mid'];
        $status = $_POST['status'];
        $postdata['featured_option'] = $status;
            $this->db->where('id', $menuid);
            $this->db->update(db_prefix().'distributors', $postdata);
        echo 1; 
        exit();
    }
    
    /* Delete article from database */
    public function delete_distributors($id)
    {
        if (!$id) {
            redirect(admin_url('distributors'));
        }
        $this->distributor_model->delete_article($id);        
        set_alert('success', _l('deleted', _l('Distributor')));
        redirect(admin_url('distributors'));
    }
    /* test get and post api code */
    public function apiData(){
        //--------------------------------- get api data code--------------------------------------
        $cSession = curl_init(); 
        // Step 2
        curl_setopt($cSession,CURLOPT_URL,"http://kptpipes.manageprojects.in/kptpipes/api/users/state_list");
        curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($cSession,CURLOPT_HEADER, false); 
        // Step 3
        $result=curl_exec($cSession);
        // Step 4
        curl_close($cSession);
        // Step 5
        $response = json_decode($result,true);
        print_r($response);
        die;
        //--------------------------------- post api data code--------------------------------------
        // $fields='{"dealer_id":"7"}';
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "http://kptpipes.manageprojects.in/kptpipes/api/users/deleteDealer");
        // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        // $result = curl_exec($ch);
        // echo $result;
        // die;
    }

    /* Distributor List all knowledgebase articles */
    public function list()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('distributors_list');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Distributors');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();  
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();         
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/distributors/distributor_list', $data);
    }

    /* order report */
    public function order_report()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('distributor_order');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Distributors Order');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/distributors/order', $data);
    }

    /* Reward report */
    public function reward_report()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('distributor_reward');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Distributors Reward');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/distributors/rewards', $data);
    }

    //this function is for claim rewards points
    public function claimReward()
    {
        $postData = $this->input->post();
        if(!empty($postData['userid']) && !empty($postData['claim_type']) && !empty($postData['points']) && !empty($postData['comment'])){
            $pointscountadd =  $this->Common_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>'distributor','status_type'=>'add'],'points');
            $pointscountless =  $this->Common_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>'distributor','status_type'=>'less'],'points');
            $pointscount=$pointscountadd-$pointscountless;
            if ($pointscount >= $postData['points'] ) {
                $user_reward['user_id']=$postData['userid'];
                $user_reward['type']='distributor';
                $user_reward['points']=$postData['points'];
                $user_reward['message']=$postData['claim_type'];
                $user_reward['status_type']='less';
                $this->Common_model->Insert(db_prefix().'user_reward',$user_reward);
                $id = $this->db->insert_id();
                if (!empty($id)) {
                    $insertdata['type']='distributor';
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
