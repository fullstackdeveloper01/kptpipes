<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Promocode extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('promocode_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('promocode', '', 'view')) {
            access_denied('promocode');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('promocode');
        }
       
        $sheader_text = title_text('aside_menu_active', 'promocode');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/promocode/promocodes', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('promocode', '', 'view')) {
            access_denied('promocode');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('promocode', '', 'create')) {
                    access_denied('promocode');
                }
                $data['start_date'] = strtotime($data['start_date']);
                $data['end_date'] = strtotime($data['end_date']);
                $data['created_at'] = date('Y-m-d h:i:s');
                $id = $this->promocode_model->add_article($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Promocode')));
                    redirect(admin_url('promocode'));
                }
            } else {
                if (!has_permission('promocode', '', 'edit')) {
                    access_denied('promocode');
                }
                $data['start_date'] = strtotime($data['start_date']);
                $data['end_date'] = strtotime($data['end_date']);
                
                $success = $this->promocode_model->update_article($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Promocode')));
                }
                redirect(admin_url('promocode'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Promocode'));
        } else {
            $article         = $this->promocode_model->get($id);
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'promocode');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($subheader_text);
        $this->load->view('admin/promocode/promocode', $data);
    }

    /* Delete article from database */
    public function delete_promocode($id)
    {
        if (!has_permission('promocode', '', 'delete')) {
            access_denied('promocode');
        }
        if (!$id) {
            redirect(admin_url('promocode'));
        }
        $response = $this->promocode_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Promocode')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Promocode')));
        }
        redirect(admin_url('promocode'));
    }
}
