<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('brand_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        // if (!has_permission('brand', '', 'view')) {
        //     access_denied('brand');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('brand');
        }
       
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'brand');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/brand/brands', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        // if (!has_permission('brand', '', 'view')) {
        //     access_denied('brand');
        // }
        if (!checkPermissions('brand')) {
            access_denied('brand');
        } 
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                // if (!has_permission('brand', '', 'create')) {
                //     access_denied('brand');
                // }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->brand_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_file_upload($id,'brand', 'brand');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'brand', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Brand')));
                    redirect(admin_url('brand'));
                }
            } else {
                // if (!has_permission('brand', '', 'edit')) {
                //     access_denied('brand');
                // }
                $success = $this->brand_model->update_article($data, $id);
                
                if($_FILES['brand']['name'] != '')
                {
                    $this->brand_model->delete_image($id);
                    $uploadedFiles = handle_file_upload($id,'brand', 'brand');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'brand', [$file]);
                        }
                    }
                }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Brand')));
                }
                redirect(admin_url('brand'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->brand_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'brand');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/brand/brands', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            if (!checkPermissions('brand')) {
                access_denied('brand');
            } 
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'brand', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_brand($id)
    {
        // if (!has_permission('brand', '', 'delete')) {
        //     access_denied('brand');
        // }
        if (!checkPermissions('brand')) {
            access_denied('brand');
        } 
        if (!$id) {
            redirect(admin_url('brand'));
        }
        $this->brand_model->delete_article($id);
        /*
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'brand');
        $attachment = $this->db->get(db_prefix() . 'files')->row();

        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = 'uploads/brand/' . $attachment->rel_id . '/';
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
        set_alert('success', _l('deleted', _l('Brand')));
        redirect(admin_url('brand'));
    }
}
