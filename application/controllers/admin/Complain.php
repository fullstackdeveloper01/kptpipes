<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Complain extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Complain_model','model');
    }

    /* List all announcements */
    public function index()
    {
        // if (!has_permission('content', '', 'view')) {
        //     access_denied('content');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('compalin');
        }

      
        $subheader_text = setupTitle_text('aside_menu_active', 'Complain', 'Complain');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = $subheader_text;
        $data['pagename']='Complain';
        $this->load->view('admin/complain/complain', $data);
    }
    /* Add new article or edit existing*/
    public function add($id)
    {
        // if (!checkPermissions('complain')) {
        //     access_denied('complain');
        // } 
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('compalin');
        }
        if ($this->input->post()) {
            $data['reply']                = $this->input->post('reply');
            $data['message_status']=0;
            $data['status']=0;
            if ($id != '') {
                $success = $this->model->update_article($data, $id);
                // if($_FILES['advertisement']['name'] != '')
                // {
                //     $this->advertisement_model->delete_image($id, 'advertisement');
                //     $uploadedFiles = handle_file_upload($id,'advertisement', 'advertisement');
                //     if ($uploadedFiles && is_array($uploadedFiles)) {
                //         foreach ($uploadedFiles as $file) {
                //             $this->misc_model->add_attachment_to_database($id, 'advertisement', [$file]);
                //         }
                //     }
                //     $success = true;
                // }
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('help-center')));
                }
                redirect(site_url('help-center'));
            }
        }
        if ($id != ''){
            $article         = $this->model->get($id);
            $data['article'] = $article;
        }
        // print_r($article);die;
        $subheader_text = setupTitle_text('aside_menu_active', 'Complain', 'Complain');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = $subheader_text;
        $data['pagename']='Complain';
        $this->load->view('admin/complain/complain', $data);
    }
}
