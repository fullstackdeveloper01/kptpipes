<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subscription extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('subscription_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('subscription', '', 'view')) {
            access_denied('subscription');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('subscription');
        }
       
        $sheader_text = title_text('aside_menu_active', 'subscription');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/subscription/subscriptions', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('subscription', '', 'view')) {
            access_denied('subscription');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('subscription', '', 'create')) {
                    access_denied('subscription');
                }
                $id = $this->subscription_model->add_article($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Subscription')));
                    redirect(admin_url('subscription'));
                }
            } else {
                if (!has_permission('subscription', '', 'edit')) {
                    access_denied('subscription');
                }
                $success = $this->subscription_model->update_article($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Subscription')));
                }
                redirect(admin_url('subscription'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Subscription'));
        } else {
            $article         = $this->subscription_model->get($id);
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'subscription');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($subheader_text);
        $this->load->view('admin/subscription/subscription', $data);
    }

    /* Delete article from database */
    public function delete_subscription($id)
    {
        if (!has_permission('subscription', '', 'delete')) {
            access_denied('subscription');
        }
        if (!$id) {
            redirect(admin_url('subscription'));
        }
        $response = $this->subscription_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Subscription')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Subscription')));
        }
        redirect(admin_url('subscription'));
    }
}
