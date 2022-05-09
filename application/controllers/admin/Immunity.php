<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Immunity extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('immunity_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('immunity', '', 'view')) {
            access_denied('immunity');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('immunity');
        }
       
        $sheader_text = title_text('aside_menu_active', 'immunity');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/immunity/immunitys', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('immunity', '', 'view')) {
            access_denied('immunity');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {// echo $id; die;
                if (!has_permission('immunity', '', 'create')) {
                    access_denied('immunity');
                }
                $id = $this->immunity_model->add_article($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Immunity')));
                    redirect(admin_url('immunity'));
                }
            } else {
                if (!has_permission('immunity', '', 'edit')) {
                    access_denied('immunity');
                } //echo '<pre>'; print_r($data); die;
                if($data['update'] == 'Update')
                $success = $this->immunity_model->update_article($data, $id);
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Immunity')));
                }
                redirect(admin_url('immunity'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Immunity'));
        } else {
            $article         = $this->immunity_model->get($id);
            //echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'immunity');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['category_result'] = $this->db->get_where(db_prefix().'category', array('status' => 1, 'parent_id' => 0))->result();
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/immunity/immunity', $data);
    }

    /* Delete article from database */
    public function delete_immunity($id)
    {
        if (!has_permission('immunity', '', 'delete')) {
            access_denied('immunity');
        }
        if (!$id) {
            redirect(admin_url('immunity'));
        }
        $response = $this->immunity_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Immunity')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Immunity')));
        }
        redirect(admin_url('immunity'));
    }
}
