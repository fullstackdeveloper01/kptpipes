<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Portfolio extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('portfolio_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('portfolio', '', 'view')) {
            access_denied('portfolio');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('portfolio');
        }
       
        $sheader_text = title_text('aside_menu_active', 'portfolio');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/portfolio/portfolios', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('portfolio', '', 'view')) {
            access_denied('portfolio');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            if ($id == '') {
                if (!has_permission('portfolio', '', 'create')) {
                    access_denied('portfolio');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $id = $this->portfolio_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_file_upload($id,'portfolio', 'portfolio');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'portfolio', [$file]);
                        }
                    }                    
                    $uploadedFiles = handle_file_upload($id,'portfolio_thumbnail', 'portfolio_thumbnail');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'portfolio_thumbnail', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Portfolio')));
                    redirect(admin_url('portfolio'));
                }
            } else {
                if (!has_permission('portfolio', '', 'edit')) {
                    access_denied('portfolio');
                }
                $success = $this->portfolio_model->update_article($data, $id);                
                if($_FILES['portfolio']['name'] != '')
                {
                    $this->portfolio_model->delete_image($id,'portfolio');
                    $uploadedFiles = handle_file_upload($id,'portfolio', 'portfolio');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'portfolio', [$file]);
                        }
                    }
                }                            
                if($_FILES['portfolio_thumbnail']['name'] != '')
                {
                    $this->portfolio_model->delete_image($id, 'portfolio_thumbnail');
                    $uploadedFiles = handle_file_upload($id,'portfolio_thumbnail', 'portfolio_thumbnail');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'portfolio_thumbnail', [$file]);
                        }
                    }
                }                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Portfolio')));
                }
                redirect(admin_url('portfolio'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->portfolio_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'portfolio');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['technology_list'] = $this->db->get_where('tbltechnology')->result();

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/portfolio/portfolio', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'portfolio', $postdata);
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
            $this->db->update(db_prefix().'portfolio', $postdata);
        echo 1; 
        exit();
    }

    /* Delete article from database */
    public function delete_portfolio($id)
    {
        if (!has_permission('portfolio', '', 'delete')) {
            access_denied('portfolio');
        }
        if (!$id) {
            redirect(admin_url('portfolio'));
        }
        $this->portfolio_model->delete_article($id);        
        set_alert('success', _l('deleted', _l('Portfolio')));
        redirect(admin_url('portfolio'));
    }
}
