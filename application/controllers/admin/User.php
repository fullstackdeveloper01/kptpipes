<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $staff = ($this->session->staff_role_id);
        if ($staff!=0) {
            redirect(admin_url());
        }
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('users', '', 'view')) {
            access_denied('users');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('users');
        }
       
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'users');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']   = _l($sheader_text);
        $this->load->view('admin/user/users', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        $id=base64_decode($id);
        if (!has_permission('users', '', 'view')) {
            access_denied('users');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            $data['password'] =app_hash_password($data['password']);

            if ($id == '') {
                $id = $this->User_model->Insert(db_prefix().'staff',$data);
                if ($id) {
                    // $uploadedFiles = handle_file_upload($id,'brand', 'brand');
                    // if ($uploadedFiles && is_array($uploadedFiles)) {
                    //     foreach ($uploadedFiles as $file) {
                    //         $this->misc_model->add_attachment_to_database($id, 'brand', [$file]);
                    //     }
                    // }
                    set_alert('success', _l('added_successfully', _l('User')));
                    redirect(site_url('users'));
                }
            } else {
                $success = $this->User_model->update_article($data, $id);
                
                // if($_FILES['brand']['name'] != '')
                // {
                //     $this->brand_model->delete_image($id);
                //     $uploadedFiles = handle_file_upload($id,'brand', 'brand');
                //     if ($uploadedFiles && is_array($uploadedFiles)) {
                //         foreach ($uploadedFiles as $file) {
                //             $this->misc_model->add_attachment_to_database($id, 'brand', [$file]);
                //         }
                //     }
                // }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('User')));
                }
                redirect(site_url('users'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->User_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = setupTitle_text('aside_menu_active', 'User', 'brand');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l('User');
        $this->load->view('admin/user/user', $data);
    }

    /**
    * @funciton: Check Email of distributor
    */
    public function checkemail()
    {
        if ($this->input->is_ajax_request()) {   
            $resc = checkEmail($this->input->post('email'));
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
            $resc = checkMobile($this->input->post('mobile')) ;
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
            $postdata['active'] = $status;
            $this->db->where('staffid', $id);
            $this->db->update(db_prefix().'staff', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_user($id)
    {
        $id=base64_decode($id);
        // if (!has_permission('brand', '', 'delete')) {
        //     access_denied('brand');
        // }
        if (!$id) {
            redirect(site_url('users'));
        }
        $this->User_model->delete_article($id);
        set_alert('success', _l('deleted', _l('User')));
        redirect(site_url('users'));
    }
}
