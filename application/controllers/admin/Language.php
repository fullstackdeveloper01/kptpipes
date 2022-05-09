<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Language extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('language_model');
        $this->load->library('form_validation');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('language', '', 'view')) {
            access_denied('language');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('language');
        }
       
        $sheader_text = title_text('aside_menu_active', 'language');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/language/language', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('language', '', 'view')) {
            access_denied('language');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('language', '', 'create')) {
                    access_denied('language');
                }
                $this->form_validation->set_rules('name', 'Name', 'required|is_unique[language.name]');
                if ($this->form_validation->run() == FALSE)
                {
                    set_alert('warning', _l(validation_errors()));
                    redirect(admin_url('language'));
                }
                else
                {
                    $id = $this->language_model->add_article($data);
                    if ($id) {
                        
                        $uploadedFiles = handle_task_attachments_array($id,'languageflag');
                        if ($uploadedFiles && is_array($uploadedFiles)) {
                            foreach ($uploadedFiles as $file) {
                                $this->misc_model->add_attachment_to_database($id, 'languageflag', [$file]);
                            }
                        }
                        
                        set_alert('success', _l('added_successfully', _l('Language')));
                        redirect(admin_url('language'));
                    }
                }
            } else {
                if (!has_permission('language', '', 'edit')) {
                    access_denied('language');
                }
                $success = $this->language_model->update_article($data, $id);
                if($_FILES)
                {
                    $this->db->where('rel_id', $id);
                    $this->db->where('rel_type', 'languageflag');
                    $attachment = $this->db->get(db_prefix() . 'files')->row();
            
                    if ($attachment) {
                        if (empty($attachment->external)) {
                            $relPath  = get_upload_path_by_type('languageflag') . $attachment->rel_id . '/';
                            $fullPath = $relPath . $attachment->file_name;
                            unlink($fullPath);
                        }
            
                        $this->db->where('id', $attachment->id);
                        $this->db->delete(db_prefix() . 'files');
                        if ($this->db->affected_rows() > 0) {
                            $deleted = true;
                            //log_activity('audio_book Attachment Deleted [audio_bookID: ' . $attachment->rel_id . ']');
                        }
                    }
                    $uploadedFiles = handle_task_attachments_array($id,'languageflag');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'languageflag', [$file]);
                        }
                    }
                }
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Language')));
                }
                redirect(admin_url('language'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Language'));
        } else {
            $article         = $this->language_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'language');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/language/language', $data);
    }

    /* Delete article from database */
    public function delete_language($id)
    {
        if (!has_permission('language', '', 'delete')) {
            access_denied('language');
        }
        if (!$id) {
            redirect(admin_url('language'));
        }
        $response = $this->language_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Language')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Language')));
        }
        redirect(admin_url('language'));
    }
}
