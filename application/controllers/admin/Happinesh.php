<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Happinesh extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('happinesh_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('happinesh', '', 'view')) {
            access_denied('happinesh');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('happinesh');
        }
       
        $sheader_text = title_text('aside_menu_active', 'happinesh');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/happinesh/happineshs', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('happinesh', '', 'view')) {
            access_denied('happinesh');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {// echo $id; die;
                if (!has_permission('happinesh', '', 'create')) {
                    access_denied('happinesh');
                }
                $id = $this->happinesh_model->add_article($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Happinesh')));
                    redirect(admin_url('happinesh'));
                }
            } else {
                if (!has_permission('happinesh', '', 'edit')) {
                    access_denied('happinesh');
                } //echo '<pre>'; print_r($data); die;
                if($data['update'] == 'Update')
                $success = $this->happinesh_model->update_article($data, $id);
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Happinesh')));
                }
                redirect(admin_url('happinesh'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Happinesh'));
        } else {
            $article         = $this->happinesh_model->get($id);
            //echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'happinesh');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['category_result'] = $this->db->get_where(db_prefix().'category', array('status' => 1, 'parent_id' => 0))->result();
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/happinesh/happinesh', $data);
    }

    /* Delete article from database */
    public function delete_happinesh($id)
    {
        if (!has_permission('happinesh', '', 'delete')) {
            access_denied('happinesh');
        }
        if (!$id) {
            redirect(admin_url('happinesh'));
        }
        $response = $this->happinesh_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Happinesh')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Happinesh')));
        }
        redirect(admin_url('happinesh'));
    }
}
