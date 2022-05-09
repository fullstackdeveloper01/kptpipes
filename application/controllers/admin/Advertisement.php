<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Advertisement extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('advertisement_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        // if (!has_permission('advertisement', '', 'view')) {
        //     access_denied('advertisement');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('advertisement');
        }
       
        $sheader_text = title_text('aside_menu_active', 'advertisement');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/advertisement/advertisement', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        // if (!has_permission('advertisement', '', 'view')) {
        //     access_denied('advertisement');
        // }
        if (!checkPermissions('advertisement')) {
            access_denied('advertisement');
        } 
        if ($this->input->post()) {
            $data                = $this->input->post();
            if ($id == '') {
                if (!checkPermissions('advertisement')) {
                    access_denied('advertisement');
                } 
                $data['start_date'] = strtotime($data['start_date']);
                $data['end_date'] = strtotime($data['end_date']);
                $data['created_date'] = date('Y-m-d H:i:s');
                $id = $this->advertisement_model->add_article($data);
                if ($id) {
                    $uploadedFiles = handle_file_upload($id,'advertisement', 'advertisement');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'advertisement', [$file]);
                        }
                    }                    
                    set_alert('success', _l('added_successfully', _l('Advertisement')));
                    redirect(admin_url('advertisement'));
                }
            } else {
                if (!checkPermissions('advertisement')) {
                    access_denied('advertisement');
                } 
                $data['start_date'] = strtotime($data['start_date']);
                $data['end_date'] = strtotime($data['end_date']);
                
                $success = $this->advertisement_model->update_article($data, $id);
                if($_FILES['advertisement']['name'] != '')
                {
                    $this->advertisement_model->delete_image($id, 'advertisement');
                    $uploadedFiles = handle_file_upload($id,'advertisement', 'advertisement');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'advertisement', [$file]);
                        }
                    }
                    $success = true;
                }
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Advertisement')));
                }
                redirect(admin_url('advertisement'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Advertisement'));
        } else {
            $article         = $this->advertisement_model->get($id);
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'advertisement');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($subheader_text);
        $this->load->view('admin/advertisement/advertisement', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            if (!checkPermissions('advertisement')) {
                access_denied('advertisement');
            } 
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'advertisement', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_advertisement($id)
    {
        // if (!has_permission('advertisement', '', 'delete')) {
        //     access_denied('advertisement');
        // }
        if (!checkPermissions('advertisement')) {
            access_denied('advertisement');
        } 
        if (!$id) {
            redirect(admin_url('advertisement'));
        }
        $response = $this->advertisement_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Advertisement')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Advertisement')));
        }
        redirect(admin_url('advertisement'));
    }
}
