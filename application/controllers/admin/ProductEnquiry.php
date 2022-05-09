<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProductEnquiry extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('productenquiry_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('productEnquiry', '', 'view')) {
            access_denied('productEnquiry');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('productEnquiry');
        }
       
        $sheader_text = title_text('aside_menu_active', 'productEnquiry');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/productEnquiry/productEnquiry', $data);
    }

    /* details and update */
    public function details($id = '')
    {
        if (!has_permission('productEnquiry', '', 'view')) {
            access_denied('productEnquiry');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            if ($id == '') {
                set_alert('warning', _l('added_successfully', _l('Product Enquiry')));
                redirect(admin_url('productEnquiry'));
            } else {
                if (!has_permission('productEnquiry', '', 'edit')) {
                    access_denied('productEnquiry');
                }
                if($data['update'] == 'Update')
                //$success = $this->productenquiry_model->update_article($data, $id);
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Product Enquiry')));
                }
                redirect(admin_url('productEnquiry'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Happinesh'));
        } else {
            $article         = $this->productenquiry_model->get($id);
            //echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'productEnquiry');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/productEnquiry/enquiryDetails', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'product_enquiry', $postdata);
        }
    }    

    /* Delete article from database */
    public function delete_productEnquiry($id)
    {
        if (!has_permission('productEnquiry', '', 'delete')) {
            access_denied('productEnquiry');
        }
        if (!$id) {
            redirect(admin_url('productEnquiry'));
        }
        $response = $this->productenquiry_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Product enquiry')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Product enquiry')));
        }
        redirect(admin_url('productEnquiry'));
    }
}
