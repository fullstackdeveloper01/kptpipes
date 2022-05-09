<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RecommandedApps extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('recommandedapps_model');
    }

    /* List all articles */
    public function index()
    {
        if (!has_permission('recommandedApps', '', 'view')) {
            access_denied('recommandedApps');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('recommandedApps');
        }
       
        $sheader_text = title_text('aside_menu_active', 'recommandedApps');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/recommandedApps/recommandedApps', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('recommandedApps', '', 'view')) {
            access_denied('recommandedApps');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('recommandedApps', '', 'create')) {
                    access_denied('recommandedApps');
                }
                $id = $this->recommandedapps_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_task_attachments_array($id,'recommendedimg');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'recommendedimg', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Recommanded Apps')));
                    redirect(admin_url('recommandedApps'));
                }
            } else {
                if (!has_permission('recommandedApps', '', 'edit')) {
                    access_denied('recommandedApps');
                }
                $success = $this->recommandedapps_model->update_article($data, $id);
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Recommanded Apps')));
                }
                redirect(admin_url('recommandedApps'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Recommanded Apps'));
        } else {
            $article         = $this->recommandedapps_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'recommandedApps');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($subheader_text);
        $this->load->view('admin/recommandedApps/recommandedApp', $data);
    }

    /* Delete article from database */
    public function delete_recommandedApps($id)
    {
        if (!has_permission('recommandedApps', '', 'delete')) {
            access_denied('recommandedApps');
        }
        if (!$id) {
            redirect(admin_url('recommandedApps'));
        }
        $response = $this->recommandedapps_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Recommanded Apps')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Recommanded Apps')));
        }
        redirect(admin_url('recommandedApps'));
    }
}
