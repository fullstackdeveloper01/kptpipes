<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Medicines extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('medicines_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('medicines', '', 'view')) {
            access_denied('medicines');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('medicines');
        }
       
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'medicines');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/medicines/mediciness', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('medicines', '', 'view')) {
            access_denied('medicines');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('medicines', '', 'create')) {
                    access_denied('medicines');
                }
                $recorddadta = $this->db->get_where(db_prefix().'medicines', array('name' => $data['name']))->row('name');
                if($recorddadta)
                {
                    set_alert('warning', _l($data['name'].' name is already added'));
                    redirect(admin_url('medicines'));
                }
                else
                {
                    $data['created_date'] = date('Y-m-d h:i:s');
                    $id = $this->medicines_model->add_article($data);
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('Medicines')));
                        redirect(admin_url('medicines'));
                    }
                }
                    
            } else {
                if (!has_permission('medicines', '', 'edit')) {
                    access_denied('medicines');
                }
                $success = $this->medicines_model->update_article($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Medicines')));
                }
                redirect(admin_url('medicines'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Medicines'));
        } else {
            $article         = $this->medicines_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'medicines');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/medicines/medicines', $data);
    }

    /* Delete article from database */
    public function delete_medicines($id)
    {
        if (!has_permission('medicines', '', 'delete')) {
            access_denied('medicines');
        }
        if (!$id) {
            redirect(admin_url('medicines'));
        }
        $response = $this->medicines_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Medicines')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Medicines')));
        }
        redirect(admin_url('medicines'));
    }
}
