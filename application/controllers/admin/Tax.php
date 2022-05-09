<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tax extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tax_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('tax');
        }
       
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'tax');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/tax/taxs', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('tax', '', 'view')) {
            access_denied('tax');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                if (!has_permission('tax', '', 'create')) {
                    access_denied('tax');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->tax_model->add_article($data);
                if ($id) {                    
                    set_alert('success', _l('added_successfully', _l('Tax')));
                    redirect(admin_url('tax'));
                }
            } else {
                if (!has_permission('tax', '', 'edit')) {
                    access_denied('tax');
                }
                $success = $this->tax_model->update_article($data, $id);                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Tax')));
                }
                redirect(admin_url('tax'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->tax_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'tax');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/tax/taxs', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'tax', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_tax($id)
    {
        if (!has_permission('tax', '', 'delete')) {
            access_denied('tax');
        }
        if (!$id) {
            redirect(admin_url('tax'));
        }
        $this->tax_model->delete_article($id);
        /*
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'tax');
        $attachment = $this->db->get(db_prefix() . 'files')->row();

        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = 'uploads/tax/' . $attachment->rel_id . '/';
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
        set_alert('success', _l('deleted', _l('Tax')));
        redirect(admin_url('tax'));
    }
}
