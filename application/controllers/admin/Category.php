<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
    }

    /* List all articles */
    public function index()
    {
        // if (!has_permission('category', '', 'view')) {
        //     access_denied('category');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('category');
        }
       
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'category');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        $this->load->view('admin/category/category', $data);
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
        // if (!has_permission('category', '', 'view')) {
        //     access_denied('category');
        // }
        if (!checkPermissions('category')) {
            access_denied('category');
        } 
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                // if (!has_permission('category', '', 'create')) {
                //     access_denied('category');
                // }
                $id = $this->category_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_file_upload($id,'category', 'category');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'category', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Category')));
                    redirect(admin_url('category'));
                }
            } else {
                // if (!has_permission('category', '', 'edit')) {
                //     access_denied('category');
                // }
                $success = $this->category_model->update_article($data, $id);
                
                if($_FILES['category']['name'] != '')
                {
                    $this->category_model->delete_image($id);
                    $uploadedFiles = handle_file_upload($id,'category', 'category');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'category', [$file]);
                        }
                    }
                }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Category')));
                }
                redirect(admin_url('category'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Category'));
        } else {
            $article         = $this->category_model->get($id);
            //echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'category');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/category/category', $data);
    }
    
    /* Edit sub category */
    // public function edit($id = '')
    // {
    //     // if (!has_permission('category', '', 'view')) {
    //     //     access_denied('category');
    //     // }
    //     if (!checkPermissions('category')) {
    //         access_denied('category');
    //     } 
    //     if ($this->input->post()) {
    //         $data                = $this->input->post();
    //         //echo '<pre>'; print_r($data); die;
    //         if ($id == '') {
    //             // if (!has_permission('category', '', 'create')) {
    //             //     access_denied('category');
    //             // }
    //             $id = $this->category_model->add_article($data);
    //             if ($id) {
                    
    //                 $uploadedFiles = handle_file_upload($id,'category', 'category');
    //                 if ($uploadedFiles && is_array($uploadedFiles)) {
    //                     foreach ($uploadedFiles as $file) {
    //                         $this->misc_model->add_attachment_to_database($id, 'category', [$file]);
    //                     }
    //                 }
                    
    //                 set_alert('success', _l('added_successfully', _l('Category')));
    //                 redirect(admin_url('category'));
    //             }
    //         } else {
    //             // if (!has_permission('category', '', 'edit')) {
    //             //     access_denied('category');
    //             // }
    //             $success = $this->category_model->update_article($data, $id);
                
    //             if($_FILES['category']['name'] != '')
    //             {
    //                 $this->category_model->delete_image($id);
    //                 $uploadedFiles = handle_file_upload($id,'category', 'category');
    //                 if ($uploadedFiles && is_array($uploadedFiles)) {
    //                     foreach ($uploadedFiles as $file) {
    //                         $this->misc_model->add_attachment_to_database($id, 'category', [$file]);
    //                     }
    //                 }
    //             }
                
    //             if ($success) {
    //                 set_alert('success', _l('updated_successfully', _l('Sub Category')));
    //             }
    //             redirect(admin_url('category'));
    //         }
    //     }
    //     if ($id == '') {
    //         $title = _l('add_new', _l('Category'));
    //         $data['category_result'] = $this->db->get_where(db_prefix().'category', array('parent_id' => 0))->result();
    //     } else {
    //         $article         = $this->category_model->get($id);
    //         //echo '<pre>'; print_r($article); die;
    //         $data['article'] = $article;
    //         $data['category_result'] = $this->db->get_where(db_prefix().'category', array('parent_id' => 0, 'id != '=> $id))->result();
    //     }
    //     $sheader_text = setupTitle_text('aside_menu_active', 'master', 'category');
    //     $data['sheading_text'] = $sheader_text;
    //     $data['sh_text'] = $sheader_text;
        
    //     $data['title']     = _l($sheader_text);
    //     $this->load->view('admin/category/sub_category', $data);
    // }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {  
            if (!checkPermissions('category')) {
                access_denied('category');
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
        if (!checkPermissions('category')) {
            access_denied('category');
        } 
        if (!$id) {
            redirect(admin_url('category'));
        }
        $response = $this->category_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Category')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Category')));
        }
        redirect(admin_url('category'));
    }
}
