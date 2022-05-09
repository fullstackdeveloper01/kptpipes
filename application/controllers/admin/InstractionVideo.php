<?php

defined('BASEPATH') or exit('No direct script access allowed');

class InstractionVideo extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('instractionvideo_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('instractionVideo', '', 'view')) {
            access_denied('instractionVideo');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('instractionVideos');
        }
       
        $sheader_text = title_text('aside_menu_active', 'instractionVideo');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/instractionVideo/instractionVideos', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('instractionVideo', '', 'view')) {
            access_denied('instractionVideo');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('instractionVideo', '', 'create')) {
                    access_denied('instractionVideo');
                }
                $id = $this->instractionvideo_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles_ = handle_task_attachments_array($id,'instractionVideofile');
                    if ($uploadedFiles_ && is_array($uploadedFiles_)) {
                        foreach ($uploadedFiles_ as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'instractionVideofile', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Instraction video')));
                    redirect(admin_url('instractionVideo'));
                }
            } else {
                if (!has_permission('instractionVideo', '', 'edit')) {
                    access_denied('instractionVideo');
                }
                $success = $this->instractionvideo_model->update_article($data, $id);
                
                $uploadedFiles_ = handle_task_attachments_array($id,'instractionVideofile');
                if ($uploadedFiles_ && is_array($uploadedFiles_)) {
                    foreach ($uploadedFiles_ as $file) {
                        $this->misc_model->add_attachment_to_database($id, 'instractionVideofile', [$file]);
                    }
                }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Instraction video')));
                }
                redirect(admin_url('instractionVideo'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Instraction video'));
        } else {
            $article         = $this->instractionvideo_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'instractionVideo');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($subheader_text);
        $this->load->view('admin/instractionVideo/instractionVideo', $data);
    }

    /* Delete article from database */
    public function delete_instractionVideo($id)
    {
        if (!has_permission('instractionVideo', '', 'delete')) {
            access_denied('instractionVideo');
        }
        if (!$id) {
            redirect(admin_url('instractionVideo'));
        }
        $response = $this->instractionvideo_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Instraction video')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Instraction video')));
        }
        redirect(admin_url('instractionVideo'));
    }
}
