<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clients extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('client_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('client', '', 'view')) {
            access_denied('client');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('client');
        }
       
        $sheader_text = title_text('aside_menu_active', 'clients');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/client/clients', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('client', '', 'view')) {
            access_denied('client');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                if (!has_permission('client', '', 'create')) {
                    access_denied('client');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->client_model->add_article($data);
                if ($id) {
                    $uploadedFiles = handle_file_upload($id,'client_logo', 'client_logo');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'client_logo', [$file]);
                        }
                    }                    
                    /*
                    $uploadedFiles = handle_file_upload($id,'client_thumbnail', 'client_thumbnail');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'client_thumbnail', [$file]);
                        }
                    }
                    */
                    set_alert('success', _l('added_successfully', _l('client')));
                    redirect(admin_url('clients'));
                }
            } else {
                if (!has_permission('client', '', 'edit')) {
                    access_denied('client');
                }
                $success = $this->client_model->update_article($data, $id);  
                if($_FILES['client_logo']['name'] != '')
                {
                    $this->client_model->delete_image($id,'client_logo');
                    $uploadedFiles = handle_file_upload($id,'client_logo', 'client_logo');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'client', [$file]);
                        }
                    }
                }                            
                /*              
                if($_FILES['client_thumbnail']['name'] != '')
                {
                    $this->client_model->delete_image($id, 'client_thumbnail');
                    $uploadedFiles = handle_file_upload($id,'client_thumbnail', 'client_thumbnail');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'client_thumbnail', [$file]);
                        }
                    }
                }    
                */            
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Clients')));
                }
                redirect(admin_url('clients'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->client_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'clients');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['technology_list'] = $this->db->get_where('tbltechnology')->result();

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/client/client', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'client', $postdata);
        }
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
            $this->db->update(db_prefix().'client', $postdata);
        echo 1; 
        exit();
    }
    
    /* Delete article from database */
    public function delete_client($id)
    {
        if (!$id) {
            redirect(admin_url('client'));
        }
        $this->client_model->delete_article($id);        
        set_alert('success', _l('deleted', _l('client')));
        redirect(admin_url('clients'));
    }
}
