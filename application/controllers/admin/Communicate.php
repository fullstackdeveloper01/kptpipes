<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Communicate extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('communicate_model');
    }

    /* List all knowledgebase carmakes */
    public function index()
    {
        /*
        if (!has_permission('communicate', '', 'view')) {
            access_denied('communicate');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('car_make');
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'communicate', 'car');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        
        $data['title']     = _l($subheader_text);
        $this->load->view('admin/car/cars', $data);
        */
        $this->sendemail();
    }
    
    /* List all sendemail carmakes */
    public function sendemail()
    {
        if (!has_permission('communicate', '', 'view')) {
            access_denied('communicate');
        }
        
        if($this->input->post())
        {
            $data = $this->input->post();
            $emails = $this->input->post('emails');
            if($emails)
            {
                $data['emails'] = implode(',',$this->input->post('emails'));
            }
            else
            {
                $data['emails'] = '';
            }
            //echo '<pre>'; print_r($data['emails']); die;
            $data['type'] = 'email';
            $this->db->insert(db_prefix().'communicate', $data);
            $id = $this->db->insert_id();
            
            if($id)
            {
                send_mail($data['emails'], $data['title'], $data['description']);
            }
            
            $uploadedFiles = handle_task_attachments_array($id);
            if ($uploadedFiles && is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $file) {
                    $attachment = $this->misc_model->add_attachment_to_database($id, 'sendemail', [$file]);
                }
            }
            set_alert('success', _l('Email Send Successful'));
            redirect(admin_url('communicate/sendemail'));
        }
        
        $subheader_text = setupTitle_text('aside_menu_active', 'communicate', 'sendemail');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        
        $data['title']     = _l($subheader_text);
        $data['garage_list'] = $this->db->select('email,firstname,userid')->get_where(db_prefix().'contacts', array('active' => 1))->result();
        $this->app_scripts->add('tinymce-stickytoolbar',site_url('assets/plugins/tinymce-stickytoolbar/stickytoolbar.js'));
        $this->load->view('admin/communicate/sendemail', $data);
    }
    
    /* List all sendsms_ carmakes */
    public function sendsms_()
    {
        if (!has_permission('communicate', '', 'view')) {
            access_denied('communicate');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('emailsmslog');
        }
        
        if($this->input->post())
        {
            $data = $this->input->post();
            $emails = $this->input->post('emails');
            if($emails)
            {
                $data['emails'] = implode(',',$this->input->post('emails'));
            }
            else
            {
                $data['emails'] = '';
            }
            
            $data['type'] = 'sms';
            //echo '<pre>'; print_r($data); die;
            $this->db->insert(db_prefix().'communicate', $data);
            $id = $this->db->insert_id();
            
            if($id)
            {
                $data['moblie_no'] = $data['emails'];
                $data['message']   = $data['description'];
                send_sms($data, false);
            }
            
            set_alert('success', _l('SMS Send Successful'));
            redirect(admin_url('communicate/sendsms_'));
        }
        
        $subheader_text = setupTitle_text('aside_menu_active', 'communicate', 'sendsms_');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        
        $data['garage_list'] = $this->db->select('email,firstname,userid')->get_where(db_prefix().'contacts', array('active' => 1))->result();
        $data['title']     = _l($subheader_text);
        $this->load->view('admin/communicate/sendsms', $data);
    }
    
    /* List all emailsmdlog carmakes */
    public function emailsmslog()
    {
        if (!has_permission('communicate', '', 'view')) {
            access_denied('communicate');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('emailsmslog');
        }
        /*
        if($this->input->post())
        {
            $data = $this->input->post();
            //echo '<pre>'; print_r($data); die;
            set_alert('success', _l('Email Send Successful'));
            redirect(admin_url('communicate/sendemail'));
        }
        */
        
        $subheader_text = setupTitle_text('aside_menu_active', 'communicate', 'emailsmdlog');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        
        $data['title']     = _l($subheader_text);
        $this->app_scripts->add('tinymce-stickytoolbar',site_url('assets/plugins/tinymce-stickytoolbar/stickytoolbar.js'));
        $this->load->view('admin/communicate/emailsmdlog', $data);
    }
}
