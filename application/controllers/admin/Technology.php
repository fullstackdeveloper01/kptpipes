<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Technology extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('technology_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('technology', '', 'view')) {
            access_denied('technology');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('technology');
        }
       
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'technology');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/technology/technologys', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('technology', '', 'view')) {
            access_denied('technology');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                if (!has_permission('technology', '', 'create')) {
                    access_denied('technology');
                }
                $postdata['created_date'] = date('Y-m-d h:i:s');
                $postdata['technology'] = $data['technology_name'];
                $id = $this->technology_model->add_article($postdata);
                if ($id) {
                    
                    $uploadedFiles = handle_file_upload($id,'technology', 'technology');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'technology', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Technology')));
                    redirect(admin_url('technology'));
                }
            } else {
                if (!has_permission('technology', '', 'edit')) {
                    access_denied('technology');
                }
                $postdata['technology'] = $data['technology_name'];
                $success = $this->technology_model->update_article($postdata, $id);
                
                if($_FILES['technology']['name'] != '')
                {
                    $this->technology_model->delete_image($id);
                    $uploadedFiles = handle_file_upload($id,'technology', 'technology');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'technology', [$file]);
                        }
                    }
                }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Technology')));
                }
                redirect(admin_url('technology'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->technology_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'technology');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/technology/technologys', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'technology', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_technology($id)
    {
        if (!has_permission('technology', '', 'delete')) {
            access_denied('technology');
        }
        if (!$id) {
            redirect(admin_url('technology'));
        }
        $this->technology_model->delete_article($id);
        /*
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'technology');
        $attachment = $this->db->get(db_prefix() . 'files')->row();

        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = 'uploads/technology/' . $attachment->rel_id . '/';
                $fullPath = $relPath . $attachment->file_name;
                unlink($fullPath);
            }

            $this->db->where('id', $attachment->id);
            $this->db->delete(db_prefix() . 'files');
            if ($this->db->affected_rows() > 0) {
                $deleted = true;
            }
        }
        */
        set_alert('success', _l('deleted', _l('Technology')));
        redirect(admin_url('technology'));
    }
}
