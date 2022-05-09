<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Donation extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('donation_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('donation', '', 'view')) {
            access_denied('donation');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('donation');
        }
       
        $sheader_text = title_text('aside_menu_active', 'donation');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/donation/donations', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('donation', '', 'view')) {
            access_denied('donation');
        }        
        if ($this->input->post()) {
            $data                = $this->input->post();
            if ($id == '') {
                if (!has_permission('donation', '', 'create')) {
                    access_denied('donation');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $data['donation_price'] = implode(',', $data['donation_price']);
                $id = $this->donation_model->add_article($data);
                if ($id) {              
                    $uploadedFiles = handle_file_upload($id,'donation', 'donation');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'donation', [$file]);
                        }
                    }

                    set_alert('success', _l('added_successfully', _l('Donation')));
                    redirect(admin_url('donation'));
                }
            } else {
                if (!has_permission('donation', '', 'edit')) {
                    access_denied('donation');
                }
                $data['donation_price'] = implode(',', $data['donation_price']);
                $success = $this->donation_model->update_article($data, $id);  

                if($_FILES['donation']['name'] != '')
                {
                    $this->donation_model->delete_image($id);
                    $uploadedFiles = handle_file_upload($id,'donation', 'donation');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'donation', [$file]);
                        }
                    }
                }

                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Donation')));
                }
                redirect(admin_url('donation'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->donation_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = title_text('aside_menu_active', 'donation');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/donation/donations', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
        
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'donation', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_slider($id)
    {
        if (!has_permission('donation', '', 'delete')) {
            access_denied('donation');
        }
        if (!$id) {
            redirect(admin_url('donation'));
        }
        $this->donation_model->delete_article($id);        
        set_alert('success', _l('deleted', _l('Donation')));
        redirect(admin_url('donation'));
    }
}
