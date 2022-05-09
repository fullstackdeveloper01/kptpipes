<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WebsiteHeading extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!has_permission('websiteHeading', '', 'view')) {
            access_denied('websiteHeading');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('websiteHeading');
        }
       
        $sheader_text = title_text('aside_menu_active', 'websiteHeading');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/websiteHeading/websiteHeadings', $data);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('websiteHeading', '', 'view')) {
            access_denied('websiteHeading');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            $postdata[] = 
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'website_heading', $data);
            if ($this->db->affected_rows() > 0) {
                set_alert('success', _l('updated_successfully', _l('Website Heading')));
            }
            redirect(admin_url('websiteHeading'));
        }
                
        $sheader_text = title_text('aside_menu_active', 'websiteHeading');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['article'] = $this->db->get_where('tblwebsite_heading')->row();
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/websiteHeading/websiteHeading', $data);
    }
}
