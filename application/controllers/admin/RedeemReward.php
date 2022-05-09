<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RedeemReward extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {

        // if (!has_permission('products', '', 'view')) {
        //     access_denied('products');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('claim_reward');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Claim Request');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $data['category_list'] = $this->db->get_where(db_prefix().'category', array('parent_id' => 0, 'status' => 1))->result();
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        
        $this->load->view('admin/redeemReward/rewards', $data);
    }

    /* List all histry list */
    public function history()
    {

        // if (!has_permission('products', '', 'view')) {
        //     access_denied('products');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('redeemRewards');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Redeem Reward');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $data['category_list'] = $this->db->get_where(db_prefix().'category', array('parent_id' => 0, 'status' => 1))->result();
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        
        $this->load->view('admin/redeemReward/history', $data);
    }

    public function change_status()
    {
        $postdata = $this->input->post();
        $this->db->where('id', $postdata['id']);
        unset($postdata['id']);
        $this->db->update(db_prefix().'claim_reward', $postdata);

        $claim = $this->db->select('user_reward_id,user_id,type')->get_where(db_prefix().'claim_reward',['id'=>$this->input->post('id')])->row();
        if ($postdata['status'] == 2) {
            $this->db->where('id',$id)->delete(db_prefix().'user_reward');
            $subject="claim request is rejected";
        }else{
            $subject="claim request is accepted";
        }
        // if ($userdata['token']!="") {
        //     // echo $userdata['token'];
        //     sendNotifications($userdata['token'],$insertdata['message'],$subject);
        // }
        set_alert('success',_l('Claim Request updated successfully'));
        redirect(site_url('redeem-reward'));  
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        // if (!has_permission('products', '', 'view')) {
        //     access_denied('products');
        // }
        if (!checkPermissions('reward')) {
            access_denied('reward');
        } 
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($id == '') {
                $id = $this->Reward_model->add_article($data);
                if ($id) {
                    // $uploadedFiles = handle_file_upload($id,'product', 'product');
                    // if ($uploadedFiles && is_array($uploadedFiles)) {
                    //     foreach ($uploadedFiles as $file) {
                    //         $this->misc_model->add_attachment_to_database($id, 'product', [$file]);
                    //     }
                    // }                    
                    set_alert('success', _l('added_successfully', _l('Reward')));
                    redirect(site_url('reward-list'));
                }
            } else {
                // if (!has_permission('rewards', '', 'edit')) {
                //     access_denied('rewards');
                // }
                $res =$this->db->get_where(db_prefix().'reward',['id'=>$id])->row_array();
                $data['user_type']=$res['user_type'];
                $data['brand_id']=$res['brand_id'];
                $data['product_id']=$res['product_id'];
                $data['user_type']=$res['user_type'];
                $success = $this->Reward_model->update_article($data, $id);
                if ($id) {
                    // $uploadedFiles = handle_file_upload($id,'product', 'product');
                    // if ($uploadedFiles && is_array($uploadedFiles)) {
                    //     foreach ($uploadedFiles as $file) {
                    //         $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $id, 'rel_type' => 'product'))->row('file_name');
                    //         $fullPath  = 'uploads/product/' . $id . '/'.$filename;
                    //         unlink($fullPath);
                    //         $this->db->delete(db_prefix().'files', array('rel_id' => $id, 'rel_type' => 'product'));
                    //         $this->misc_model->add_attachment_to_database($id, 'product', [$file]);
                    //     }
                    // }                    
                    set_alert('success', _l('updated_successfully', _l('Reward')));
                }
                redirect(site_url('reward-list'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Reward'));
            $data['product_list'] = $this->db->get_where(db_prefix().'products', array('status' => 1,'isDeleted'=>0))->result();
        } else {
            $article         = $this->Reward_model->get($id);
            $data['article'] = $article;
            $data['product_list'] = $this->db->get_where(db_prefix().'products', array('brand_id'=>$article->brand_id,'status' => 1,'isDeleted'=>0))->result();
        }
        $sheader_text = title_text('aside_menu_active', 'Reward');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/reward/reward', $data);
    }

    /* Function: product List */
    public function product()
    {
        $profileResult = [];
        $product = $_POST['product'];
        $profileResult = $this->db->select('id,title,product_variant')->get_where(db_prefix().'products', array('brand_id' => $product,'isDeleted'=>0))->result_array();
        $data=[];
        foreach ($profileResult as $key => $value) {
            $res = $this->db->get_where(db_prefix().'reward',['product_id'=>$value['id'],'isDeleted'=>0,'user_type'=>$_POST['dealer']])->row('percent');
            if ($res=="") {
                $data[]=$value;
            }
        }
        echo json_encode($data);
    }

    // /* Function: Category List */
    // public function getSubCategorylist()
    // {
    //     $profileResult = [];
    //     $state = $_POST['state'];
    //     $profileResult = $this->db->get_where(db_prefix().'category', array('parent_id' => $state))->result();
    //     echo json_encode($profileResult);
    // }

    /* Delete article from database */
    public function delete_reward($id)
    {
        // if (!has_permission('rewards', '', 'delete')) {
        //     access_denied('rewards');
        // }
        if (!checkPermissions('reward')) {
            access_denied('reward');
        } 
        if (!$id) {
            redirect(site_url('reward-list'));
        }
        $response = $this->Reward_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Reward')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Reward')));
        }
        redirect(site_url('reward-list'));
    }
    /* Set reward point value in database */
    public function value(){
        $response =$this->Reward_model->getrewardValue();
        // print_r($response);die;
        if ($this->input->post()) {
            $data = $this->input->post();
            // if ($response->id == '') {
            //     $id = $this->Reward_model->add_rewardValue($data);
            //     if ($id) {
            //         set_alert('success', _l('added_successfully', _l('Reward')));
            //         redirect(site_url('reward-value'));
            //     }
            // } else {
                if (!checkPermissions('reward')) {
                    access_denied('reward');
                } 
                $success = $this->Reward_model->update_rewardValue($data, $this->uri->segment(2));
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Reward')));
                    redirect(site_url('reward-value'));
                }
            // }
        }
        // if ($response->id == '') {
        //     $title = _l('add_new', _l('Reward'));
        // } else {
        //     $article = $response;
            $data['article'] = $response;
        // }
        $sheader_text = title_text('aside_menu_active', 'Reward');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/reward/reward_value', $data);
    }
}
