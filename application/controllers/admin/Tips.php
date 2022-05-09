<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tips extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tips_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('tips', '', 'view')) {
            access_denied('tips');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('tips');
        }
       
        $sheader_text = title_text('aside_menu_active', 'tips');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/tips/tipses', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('tips', '', 'view')) {
            access_denied('tips');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('tips');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('tips', '', 'create')) {
                    access_denied('tips');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->tips_model->add_article($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Tips')));
                    redirect(admin_url('tips'));
                }
            } else {
                if (!has_permission('tips', '', 'edit')) {
                    access_denied('tips');
                }
                $success = $this->tips_model->update_article($data, $id);
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Tips')));
                }
                redirect(admin_url('tips'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Tips'));
        } else {
            $article         = $this->tips_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'tips');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/tips/tips', $data);
    }

    /* Delete article from database */
    public function delete_tips($id)
    {
        if (!has_permission('tips', '', 'delete')) {
            access_denied('tips');
        }
        if (!$id) {
            redirect(admin_url('tips'));
        }
        $response = $this->tips_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Tips')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Tips')));
        }
        redirect(admin_url('tips'));
    }
}
