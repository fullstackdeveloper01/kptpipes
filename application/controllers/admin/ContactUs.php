<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ContactUs extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /* List all announcements */
    public function index()
    {
        if (!has_permission('content', '', 'view')) {
            access_denied('content');
        }
        if($this->input->post())
        {
            $where['page_name']=$this->input->post('page_name');
            $res = $this->db->get_where(db_prefix().'content',$where)->num_rows();
            // print_r($res);
            // die;
            if ($res>0) {
                $postData['description'] = $this->input->post('description');
                $this->db->where($where);
                $this->db->update(db_prefix().'content',$postData);
                set_alert('success', _l('updated_successfully', _l('Contact Us')));
            }else{
                $data =$this->input->post();
                $this->db->insert(db_prefix().'content',$data);
                set_alert('success', _l('added_successfully', _l('Contact Us')));
            }
            redirect(admin_url('contactUs'));
        }

      
        $subheader_text = setupTitle_text('aside_menu_active', 'content', 'contactUs');
        $data['response'] = $this->db->get_where(db_prefix().'content', array('page_name' => 'contactus'))->row('description');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = $subheader_text;
        $data['pagename']='contactus';
        $this->load->view('admin/content/content', $data);
    }
}
