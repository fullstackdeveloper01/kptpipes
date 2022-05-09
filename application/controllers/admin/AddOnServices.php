<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AddOnServices extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('addonservices_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('addOnServices', '', 'view')) {
            access_denied('addOnServices');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('addOnServices');
        }
       
        $sheader_text = title_text('aside_menu_active', 'addOnServices');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/addOnServices/addOnServicess', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('addOnServices', '', 'view')) {
            access_denied('addOnServices');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('addOnServices', '', 'create')) {
                    access_denied('addOnServices');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->addonservices_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_file_upload($id,'product', 'product');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'product', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Add on services')));
                    redirect(admin_url('addOnServices'));
                }
            } else {
                if (!has_permission('addOnServices', '', 'edit')) {
                    access_denied('addOnServices');
                }
                $success = $this->addonservices_model->update_article($data, $id);
                
                if($id)
                {
                    // $this->addonservices_model->delete_image($id);
                    $uploadedFiles = handle_file_upload($id,'product', 'product');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $id, 'rel_type' => 'product'))->row('file_name');
                            $fullPath  = 'uploads/product/' . $id . '/'.$filename;
                            unlink($fullPath);
                            $this->db->delete(db_prefix().'files', array('rel_id' => $id, 'rel_type' => 'product'));
                            $this->misc_model->add_attachment_to_database($id, 'product', [$file]);
                        }
                    }
                }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Add on services')));
                }
                redirect(admin_url('addOnServices'));
            }
        }
       
        if ($id == '') {
        } else {
            $article         = $this->addonservices_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'addOnServices');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/addOnServices/addOnServicess', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'product', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_addOnServices($id)
    {
        if (!has_permission('addOnServices', '', 'delete')) {
            access_denied('addOnServices');
        }
        if (!$id) {
            redirect(admin_url('addOnServices'));
        }
        $this->addonservices_model->delete_article($id);
        /*
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'addOnServices');
        $attachment = $this->db->get(db_prefix() . 'files')->row();

        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = 'uploads/addOnServices/' . $attachment->rel_id . '/';
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
        set_alert('success', _l('deleted', _l('Add on services')));
        redirect(admin_url('addOnServices'));
    }
}
