<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CaseStudy extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('casestudy_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('caseStudy', '', 'view')) {
            access_denied('caseStudy');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('caseStudy');
        }
       
        $sheader_text = title_text('aside_menu_active', 'caseStudy');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/caseStudy/caseStudys', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('caseStudy', '', 'view')) {
            access_denied('caseStudy');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                if (!has_permission('caseStudy', '', 'create')) {
                    access_denied('caseStudy');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->casestudy_model->add_article($data);
                if ($id) {
                    $uploadedFiles = handle_file_upload($id,'caseStudy', 'caseStudy');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'caseStudy', [$file]);
                        }
                    }                    
                    $uploadedFiles = handle_file_upload($id,'caseStudy', 'client_image');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'client_image', [$file]);
                        }
                    }
                    set_alert('success', _l('added_successfully', _l('Case Studys')));
                    redirect(admin_url('caseStudy'));
                }
            } else {
                if (!has_permission('caseStudy', '', 'edit')) {
                    access_denied('caseStudy');
                }
                $success = $this->casestudy_model->update_article($data, $id);  
                if($_FILES['caseStudy']['name'] != '')
                {
                    $this->casestudy_model->delete_image($id,'caseStudy');
                    $uploadedFiles = handle_file_upload($id,'caseStudy', 'caseStudy');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'caseStudy', [$file]);
                        }
                    }
                }                            
                if($_FILES['client_image']['name'] != '')
                {
                    $this->casestudy_model->delete_image($id, 'client_image');
                    $uploadedFiles = handle_file_upload($id,'caseStudy', 'client_image');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'client_image', [$file]);
                        }
                    }
                }           
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Case Studys')));
                }
                redirect(admin_url('caseStudy'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->casestudy_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'caseStudy');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['technology_list'] = $this->db->get_where('tbltechnology')->result();

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/caseStudy/caseStudy', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'case_study', $postdata);
        }
    }

    /**
    * @funciton: Status change
    */
    public function change_featured()
    {
        $menuid = $_POST['mid'];
        $status = $_POST['status'];
        $postdata['featured_option'] = $status;
            $this->db->where('id', $menuid);
            $this->db->update(db_prefix().'case_study', $postdata);
        echo 1; 
        exit();
    }
    
    /* Delete article from database */
    public function delete_caseStudy($id)
    {
        if (!$id) {
            redirect(admin_url('caseStudy'));
        }
        $this->casestudy_model->delete_article($id);        
        set_alert('success', _l('deleted', _l('Case Studys')));
        redirect(admin_url('caseStudy'));
    }
}
