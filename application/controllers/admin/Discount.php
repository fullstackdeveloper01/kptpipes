<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Discount extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('discount_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('discount', '', 'view')) {
            access_denied('discount');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('discount');
        }
       
        $sheader_text = title_text('aside_menu_active', 'discount');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/discount/discounts', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('discount', '', 'view')) {
            access_denied('discount');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                if (!has_permission('discount', '', 'create')) {
                    access_denied('discount');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->discount_model->add_article($data);
                if ($id) {                    
                    set_alert('success', _l('added_successfully', _l('Discount')));
                    redirect(admin_url('discount'));
                }
            } else {
                if (!has_permission('discount', '', 'edit')) {
                    access_denied('discount');
                }
                $success = $this->discount_model->update_article($data, $id);                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Discount')));
                }
                redirect(admin_url('discount'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->discount_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'discount');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/discount/discounts', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'discount', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_discount($id)
    {
        if (!has_permission('discount', '', 'delete')) {
            access_denied('discount');
        }
        if (!$id) {
            redirect(admin_url('discount'));
        }
        $this->discount_model->delete_article($id);
        /*
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'discount');
        $attachment = $this->db->get(db_prefix() . 'files')->row();

        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = 'uploads/discount/' . $attachment->rel_id . '/';
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
        set_alert('success', _l('deleted', _l('Discount')));
        redirect(admin_url('discount'));
    }
}
