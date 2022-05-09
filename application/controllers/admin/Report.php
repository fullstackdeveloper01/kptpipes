<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('order_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('report', '', 'view')) {
            access_denied('report');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('report');
        }
       
        $sheader_text = title_text('aside_menu_active', 'report');
        $data['sheading_text'] = $sheader_text;
        $data['heading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/report/reports', $data);
    }
    
    public function selectFilter($para1 = '')
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('report_filter', [
                'report_type'   => $para1
            ]);
        }
    }
}
