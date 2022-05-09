<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MedicineType extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('medicinetype_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('medicineType', '', 'view')) {
            access_denied('medicineType');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('medicineType');
        }
       
        $sheader_text = title_text('aside_menu_active', 'medicineType');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/medicineType/medicineTypes', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('medicineType', '', 'view')) {
            access_denied('medicineType');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('medicineType', '', 'create')) {
                    access_denied('medicineType');
                }
                $data['created_date'] = date('Y-m-d');
                $id = $this->medicinetype_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_file_upload($id,'medicine_icon','medicine_icon');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'medicineType', [$file]);
                        }
                    }
                    set_alert('success', _l('added_successfully', _l('Medicine type')));
                    redirect(admin_url('medicineType'));
                }
            } else {
                if (!has_permission('medicineType', '', 'edit')) {
                    access_denied('medicineType');
                }
                $success = $this->medicinetype_model->update_article($data, $id);
                $uploadedFiles = handle_file_upload($id,'medicine_icon','medicine_icon');
                if ($uploadedFiles && is_array($uploadedFiles)) {
                    foreach ($uploadedFiles as $file) {
                        $this->misc_model->add_attachment_to_database($id, 'medicineType', [$file]);
                    }
                }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Medicine type')));
                }
                redirect(admin_url('medicineType'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Medicine type'));
        } else {
            $article         = $this->medicinetype_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'medicineType');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($subheader_text);
        $this->load->view('admin/medicineType/medicineTypes', $data);
    }

    /* Delete article from database */
    public function delete_medicineType($id)
    {
        if (!has_permission('medicineType', '', 'delete')) {
            access_denied('medicineType');
        }
        if (!$id) {
            redirect(admin_url('medicineType'));
        }
        $response = $this->medicinetype_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Medicine type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Medicine type')));
        }
        redirect(admin_url('medicineType'));
    }
}
