<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SubCategory extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('subcategory_model');
    }

    /* List all articles */
    public function index()
    {
        // if (!has_permission('subCategory', '', 'view')) {
        //     access_denied('subCategory');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('sub_category');
        }
       
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'subCategory');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $data['category_result'] = $this->db->get_where(db_prefix().'category', array('status' => 1, 'parent_id' => 0))->result();
        $this->load->view('admin/category/subCategory', $data);
    }

    /* sub_category */
    public function subCategory()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('sub_category');
        }
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        // if (!has_permission('subCategory', '', 'view')) {
        //     access_denied('subCategory');
        // }
        if (!checkPermissions('sub-category')) {
            access_denied('sub-category');
        } 
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                // if (!has_permission('subCategory', '', 'create')) {
                //     access_denied('subCategory');
                // }
                $id = $this->subcategory_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_file_upload($id,'category', 'category');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'category', [$file]);
                        }
                    }                    
                    set_alert('success', _l('added_successfully', _l('Sub Category')));
                    redirect(admin_url('subCategory'));
                }
            } else {
                // if (!has_permission('category', '', 'edit')) {
                //     access_denied('category');
                // }
                $success = $this->subcategory_model->update_article($data, $id);
                
                if($_FILES['category']['name'] != '')
                {
                    $this->subcategory_model->delete_image($id);
                    $uploadedFiles = handle_file_upload($id,'category', 'category');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'category', [$file]);
                        }
                    }
                }                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Sub Category')));
                }
                redirect(admin_url('subCategory'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Sub Category'));
        } else {
            $article         = $this->subcategory_model->get($id);
            $data['article'] = $article;
        }
        $data['category_result'] = $this->db->get_where(db_prefix().'category', array('status' => 1, 'parent_id' => 0))->result();
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'subCategory');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/category/subCategory', $data);
    }
    
    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            if (!checkPermissions('sub-category')) {
                access_denied('sub-category');
            }         
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'category', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_category($id)
    {
        // if (!has_permission('category', '', 'delete')) {
        //     access_denied('category');
        // }
        if (!checkPermissions('sub-category')) {
            access_denied('sub-category');
        } 
        if (!$id) {
            redirect(admin_url('subCategory'));
        }
        $response = $this->subcategory_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Sub Category')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Sub Category')));
        }
        redirect(admin_url('subCategory'));
    }
}
