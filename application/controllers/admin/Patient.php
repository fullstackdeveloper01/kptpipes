<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Patient extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('patient_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('patient', '', 'view')) {
            access_denied('patient');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('patient');
        }
       
        $sheader_text = title_text('aside_menu_active', 'patient');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/patient/patients', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('patient', '', 'view')) {
            access_denied('patient');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('patient', '', 'create')) {
                    access_denied('patient');
                }
                $recorddadta = $this->db->get_where(db_prefix().'_patient', array('mobile' => $data['mobile']))->row('mobile');
                if($recorddadta)
                {
                    set_alert('warning', _l($data['mobile'].' mobile is already registered'));
                    redirect(admin_url('patient/add'));
                }
                else
                {
                    $data['created_date'] = date('Y-m-d h:i:s');
                    $data['role'] = 'Admin';
                    $id = $this->patient_model->add_article($data);
                    $folderid = $data['folderid'];
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('Patient')));
                        redirect(admin_url('patient'));
                    }
                }
            } else {
                if (!has_permission('patient', '', 'edit')) {
                    access_denied('patient');
                }
                $success = $this->patient_model->update_article($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Patient')));
                }
                redirect(admin_url('patient'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Patient'));
        } else {
            $article         = $this->patient_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'patient');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        //$data['patient_typeRes'] = $this->db->get_where(db_prefix().'patient_type')->result();
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/patient/patient', $data);
    }

    /* getFolderList */
    public function getTypeList()
    {
        $profileResult = [];
        $profileResult = $this->db->get_where(db_prefix().'patient_type')->result();
        echo json_encode($profileResult);
    }
    
    /* createNewFolder */
    public function createNewType()
    {
        $name = $_POST['name'];
        if($name)
        {
            $exitrecord = $this->db->get_where(db_prefix().'patient_type', array('name' => $name))->row('name');
            if($exitrecord)
            {
                echo 2; exit();
            }
            else
            {
                $data['name'] = $name;
                $this->db->insert(db_prefix().'patient_type', $data);
                echo 1; exit();
            }
        }
        else
        {
            echo ''; exit();
        }
    }

    /* Delete article from database */
    public function delete_patient($id)
    {
        if (!has_permission('patient', '', 'delete')) {
            access_denied('patient');
        }
        if (!$id) {
            redirect(admin_url('patient'));
        }
        $response = $this->patient_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Patient')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Patient')));
        }
        redirect(admin_url('patient'));
    }
}
