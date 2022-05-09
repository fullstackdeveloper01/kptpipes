<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dealers extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dealer_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        // if (!has_permission('dealers', '', 'view')) {
        //     access_denied('dealers');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('dealers');
        }
       
        $sheader_text = title_text('aside_menu_active', 'dealers');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        /*
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();        
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();        
        $data['distributor_list'] = $this->db->get_where('tbldistributors', array('status' => 1))->result();   
        */     
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/dealers/dealers', $data);
    }

    /* List all knowledgebase articles */
    public function stock()
    {
        // if (!has_permission('dealers-stock', '', 'view')) {
        //     access_denied('dealers-stock');
        // }
        if (!checkPermissions('dealer-stock')) {
            access_denied('dealer-stock');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('dealers-stock');
        }
       
        $sheader_text = title_text('aside_menu_active', 'dealers-stock');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        // $data['response'] = $this->db->from('tbluser_stock')->where(array('status' => 1,'type'=>'distributor'))->group_by('product_id')->get()->result_array();
        $this->load->view('admin/dealers/stock', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {

        if (!checkPermissions('dealer')) {
            access_denied('dealer');
        }
        // if (!has_permission('dealers', '', 'view')) {
        //     access_denied('dealers');
        // }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                if (!has_permission('dealers', '', 'create')) {
                    access_denied('dealers');
                }
                $data['dealer_dob'] = date('Y-m-d', strtotime($data['dealer_dob']));
                $data['dealer_doj'] = date('Y-m-d', strtotime($data['dealer_doj']));
                $dealer_password = rand(10000,99999);
                $data['dealer_password'] = md5($dealer_password);
                $data['dealer_pass'] = $dealer_password;
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->dealer_model->add_article($data);
                if ($id) {
                    $insert['user_id']=$id;
                    $insert['type']='dealer';
                    $insert['mobile']=$data['dealer_mobile'];
                    $this->Common_model->add_article(db_prefix().'user_master',$insert);
                    $uploadedFiles = handle_file_upload($id,'dealers', 'dealer');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'dealer', [$file]);
                        }
                    } 
                    set_alert('success', _l('added_successfully', _l('Dealer')));
                    redirect(admin_url('dealers'));
                }
            } else {
                if (!has_permission('dealers', '', 'edit')) {
                    access_denied('dealers');
                }
                $data['dealer_dob'] = date('Y-m-d', strtotime($data['dealer_dob']));
                $data['dealer_doj'] = date('Y-m-d', strtotime($data['dealer_doj']));
                $success = $this->dealer_model->update_article($data, $id);  
                if($_FILES['dealer']['name'] != '')
                {
                    $this->dealer_model->delete_image($id,'dealer');
                    $uploadedFiles = handle_file_upload($id,'dealers', 'dealer');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'dealer', [$file]);
                        }
                    }
                }           
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Dealer')));
                }
                redirect(admin_url('dealers'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->dealer_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'dealers');
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();   
        $data['distributor_list'] = $this->db->get_where('tbldistributors', array('status' => 1))->result(); 
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        if($id)
        {
            $data['pagename']     = 'profile';
            $this->load->view('admin/dealers/dealers_html', $data);
        }
        else{
            $this->load->view('admin/dealers/dealer', $data);
        }
    }

    /* view dealer details*/
    public function view($id = '')
    {
        
        $article         = $this->dealer_model->get($id);
        $data['article'] = $article;
        
        $sheader_text = title_text('aside_menu_active', 'dealers');
        $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();
        $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();   
        $data['distributor_list'] = $this->db->get_where('tbldistributors', array('status' => 1))->result(); 
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $data['pagename']     = 'profile';
        
        $where['user_id']=$id;
        $where['type']='dealer';
        $data['totalpoints'] = $this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->get()->row('points');
        $data['redeempoints'] = $this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->where(['status_type'=>'less'])->get()->row('points');
        $data['availablepoints'] =$this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->where(['status_type'=>'add'])->get()->row('points');

        $this->load->view('admin/dealers/view', $data);
        
    }
    
    /**
    * @funciton: Status change
    */
    public function loginDetails($id)
    {
        $sheader_text = title_text('aside_menu_active', 'dealers');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $article         = $this->dealer_model->get($id);
        $data['article'] = $article;
        $data['title']     = _l($sheader_text);
        $data['pagename']     = 'loginDetails';
        $this->load->view('admin/dealers/dealers_html', $data);
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
            $count =  $this->db->get_where(db_prefix().'dealer', $where)->num_rows();
            echo json_encode($count);
            die;
        }
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {  
            if (!checkPermissions('dealer')) {
                access_denied('dealer');
            }
            $res = $this->Common_model->get(db_prefix().'dealer',['id'=>$id]);
            // echo $res->dealer_mobile;
            $response = $this->Common_model->get(db_prefix().'user_master',['status'=>1,'mobile'=>$res->dealer_mobile]);
            // $response = $this->Common_model->get(db_prefix().'user_master',['status'=>1,'mobile'=>$res->dealer_mobile,'user_id!='=>$id,'type!='=>'dealer']);
            if ($status == 1 && count($response) == 0 ) {

                $postdata['status'] = $status;
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'dealer', $postdata);

                $this->db->where(['user_id'=>$id,'type'=>'dealer']);
                $this->db->update(db_prefix().'user_master', $postdata);
            }elseif ($status == 0) {
                $postdata['status'] = $status;
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'dealer', $postdata);

                $this->db->where(['user_id'=>$id,'type'=>'dealer']);
                $this->db->update(db_prefix().'user_master', $postdata);
            }

            
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
            if ($id!="") {
                $where['dealer_pan_number'] = $pan;
                $where['status'] = 1;                
                $count = $this->db->from(db_prefix().'dealer')->where($where)->where('id !=', $id)->get()->num_rows();
            }else{   
                $where['dealer_pan_number'] = $pan;
                $where['status'] = 1; 
                $count =  $this->db->get_where(db_prefix().'dealer', $where)->num_rows();
            }
            $where1['distributor_pan_number'] = $pan;
            $where1['status'] = 1; 
            $count1 =  $this->db->get_where(db_prefix().'distributors', $where1)->num_rows();
            
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

            $aadhar=$this->input->post('aadhaar_no');
            $id=$this->input->post('id');

            if ($id!="") {
                $where['dealer_aadhar_number'] = $aadhar;
                $where['status'] = 1;                
                $count = $this->db->from(db_prefix().'dealer')->where($where)->where('id !=', $id)->get()->num_rows();
            }else{
                $where['dealer_aadhar_number'] = $aadhar;
                $where['status'] = 1;                
                $count =  $this->db->get_where(db_prefix().'dealer', $where)->num_rows();
            }
            $where1['distributor_aadhar_number'] = $aadhar;
            $where1['status'] = 1; 
            $count1 =  $this->db->get_where(db_prefix().'distributors', $where1)->num_rows();
            
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
            $gst =$this->input->post('gst');
            $id=$this->input->post('id');
            if ($id!="") {
                $where['dealer_GST'] = $gst;
                $where['status'] = 1;                
                $count = $this->db->from(db_prefix().'dealer')->where($where)->where('id !=', $id)->get()->num_rows();
            }else{ 
                $where['dealer_GST'] = $gst;
                $where['status'] = 1;                
                $count =  $this->db->get_where(db_prefix().'dealer', $where)->num_rows();
            }
            $where1['distributor_GST'] = $gst;
            $where1['status'] = 1;                
            $count1 =  $this->db->get_where(db_prefix().'distributors', $where1)->num_rows();

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
            if ($id!="") {
                $where['dealer_email'] = $email;
                $where['status'] = 1;                
                $count = $this->db->from(db_prefix().'dealer')->where($where)->where('id !=', $id)->get()->num_rows();
            }else{
                $where['dealer_email'] = $email;
                $where['status'] = 1;
                $count =  $this->db->get_where(db_prefix().'dealer', $where)->num_rows();
            }
            $where1['distributor_email'] = $email;
            $where1['status'] = 1;
            $count1 =  $this->db->get_where(db_prefix().'distributors', $where1)->num_rows();
            
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
            // $resc = checkMobile($this->input->post('mobile')) ;
            // echo json_encode($resc);
            // die;
            $mobile=$this->input->post('mobile');
            $id=$this->input->post('id');
            
            $where['distributor_mobile'] =$mobile;
            $where['status'] = 1;
            $count = $this->db->get_where(db_prefix().'distributors', $where)->num_rows();

            if ($id!="") {
                $where1['dealer_mobile'] =$mobile;
                $where1['status'] = 1;
                $count1 = $this->db->from(db_prefix().'dealer')->where($where1)->where('id !=', $this->input->post('id'))->get()->num_rows();
            }else{
                $where1['dealer_mobile'] =$mobile;
                $where1['status'] = 1;
                $count1 = $this->db->get_where(db_prefix().'dealer', $where1)->num_rows();
            }
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
    
    /* Delete article from database */
    public function delete_dealers($id)
    {
        if (!checkPermissions('dealer')) {
            access_denied('dealer');
        }
        if (!$id) {
            redirect(admin_url('dealers'));
        }
        $this->dealer_model->delete_article($id);        
        set_alert('success', _l('deleted', _l('Dealer')));
        redirect(admin_url('dealers'));
    }

    /* Distributor List all knowledgebase articles */
    public function list()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('dealer_list');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Dealers');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        // $data['brandList'] = $this->db->get_where('tblbrand', array('status' => 1))->result();  
        // $data['state_list'] = $this->db->get_where('tblstate', array('status' => 1))->result();         
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/dealers/dealer_list', $data);
    }

    /* order report */
    public function order_report()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('dealer_order');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Dealers Order');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/dealers/order', $data);
    }

    /* Reward report */
    public function reward_report()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('dealer_reward');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Dealers Reward');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/dealers/rewards', $data);
    }

    //this function is for claim rewards points
    public function claimReward()
    {
        $postData = $this->input->post();
        // print_r($postData);die;
        if(!empty($postData['userid']) && !empty($postData['claim_type']) && !empty($postData['points']) && !empty($postData['comment'])){
            $pointscountadd =  $this->Common_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>'dealer','status_type'=>'add'],'points');
            $pointscountless =  $this->Common_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>'dealer','status_type'=>'less'],'points');
            $pointscount=$pointscountadd-$pointscountless;
            if ($pointscount >= $postData['points'] ) {
                $user_reward['user_id']=$postData['userid'];
                $user_reward['type']='dealer';
                $user_reward['points']=$postData['points'];
                $user_reward['message']=$postData['claim_type'];
                $user_reward['status_type']='less';
                $this->Common_model->Insert(db_prefix().'user_reward',$user_reward);
                $id = $this->db->insert_id();
                if (!empty($id)) {
                    $insertdata['type']='dealer';
                    $insertdata['user_id']=$postData['userid'];
                    $insertdata['claim_type']=$postData['claim_type'];
                    $insertdata['points']=$postData['points'];
                    $insertdata['user_reward_id']=$id;
                    $insertdata['comment']=$postData['comment'];
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
