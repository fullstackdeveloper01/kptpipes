<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Slider extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('slider_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('slider', '', 'view')) {
            access_denied('slider');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('slider');
        }
       
        $sheader_text = title_text('aside_menu_active', 'slider');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/slider/sliders', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('slider', '', 'view')) {
            access_denied('slider');
        }
        /*
        if ($_FILES['slider']['name']) {
            $uploadedFiles = handle_file_upload(3, 'slider', 'slider');
            if ($uploadedFiles && is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $file) {
                    $this->misc_model->add_attachment_to_database(3, 'slider', [$file]);
                }
            }
            set_alert('success', _l('added_successfully', _l('Slider')));
            redirect(admin_url('slider'));
        }
        */
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                if (!has_permission('slider', '', 'create')) {
                    access_denied('slider');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->slider_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_file_upload($id,'slider', 'slider');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'slider', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Slider')));
                    redirect(admin_url('slider'));
                }
            } else {
                if (!has_permission('slider', '', 'edit')) {
                    access_denied('slider');
                }
                $success = $this->slider_model->update_article($data, $id);
                
                if($_FILES['slider']['name'] != '')
                {
                    $this->slider_model->delete_image($id);
                    $uploadedFiles = handle_file_upload($id,'slider', 'slider');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'slider', [$file]);
                        }
                    }
                }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Slider')));
                }
                redirect(admin_url('slider'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->slider_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'slider');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/slider/sliders', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'slider', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_slider($id)
    {
        if (!has_permission('slider', '', 'delete')) {
            access_denied('slider');
        }
        if (!$id) {
            redirect(admin_url('slider'));
        }
        $this->slider_model->delete_article($id);
        /*
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'slider');
        $attachment = $this->db->get(db_prefix() . 'files')->row();

        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = 'uploads/slider/' . $attachment->rel_id . '/';
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
        set_alert('success', _l('deleted', _l('Slider')));
        redirect(admin_url('slider'));
    }
}
