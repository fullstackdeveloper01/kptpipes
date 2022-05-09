<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PrivacyPolicy extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /* List all privacyPolicy */
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
                set_alert('success', _l('updated_successfully', _l('Privacy Policy')));
            }else{
                $data =$this->input->post();
                $this->db->insert(db_prefix().'content',$data);
                set_alert('success', _l('added_successfully', _l('Privacy Policy')));
            }
            redirect(admin_url('privacyPolicy'));
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'content', 'privacyPolicy');
        $data['response'] = $this->db->get_where(db_prefix().'content', array('page_name' => 'privacypolicy'))->row('description');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = $subheader_text;
        $data['pagename']='privacypolicy';
        $this->load->view('admin/content/content', $data);
    }
}
