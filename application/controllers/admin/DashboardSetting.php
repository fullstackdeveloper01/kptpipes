<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DashboardSetting extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment_modes_model');
        $this->load->model('settings_model');
    }

    /* View all settings */
    public function index()
    {
        if (!has_permission('dashboard_settings', '', 'view')) {
            access_denied('settings');
        }

        $sheader_text = title_text('setup_menu_active', 'dashboard_settings');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        if ($this->input->post()) {
            /*
            if (!has_permission('settings', '', 'edit')) {
                access_denied('settings');
            }
            */
            $post_data = $this->input->post();
            
            $data_one['bg_color']       = $post_data['box_one_bgcolor'];
            $data_one['hover_color']    = $post_data['box_one_hovercolor'];
            $data_one['icon']           = $post_data['box_one_icon'];
            $data_one['heading_one']    = $post_data['box_one_heading_one'];
            $data_one['heading_two']    = $post_data['box_one_heading_two'];
            $data_one['heading_one_color']    = $post_data['box_one_heading_one_color'];
            $data_one['heading_two_color']    = $post_data['box_one_heading_two_color'];
            $data_one['icon_color']     = $post_data['box_one_iconcolor'];
            $data_one['link']           = $post_data['box_one_Link'];
            
            $this->db->where('id', 1);
            $this->db->update('tbldashboard_boxsetting', $data_one);
            
            $data_two['bg_color']       = $post_data['box_two_bgcolor'];
            $data_two['hover_color']    = $post_data['box_two_hovercolor'];
            $data_two['icon']           = $post_data['box_two_icon'];
            $data_two['heading_one']    = $post_data['box_two_heading_one'];
            $data_two['heading_two']    = $post_data['box_two_heading_two'];
            $data_two['icon_color']     = $post_data['box_two_iconcolor'];
            $data_two['link']           = $post_data['box_two_Link'];
            $data_two['heading_one_color']    = $post_data['box_two_heading_one_color'];
            $data_two['heading_two_color']    = $post_data['box_two_heading_two_color'];
            
            $this->db->where('id', 2);
            $this->db->update('tbldashboard_boxsetting', $data_two);
            
            $data_third['bg_color']       = $post_data['box_third_bgcolor'];
            $data_third['hover_color']    = $post_data['box_third_hovercolor'];
            $data_third['icon']           = $post_data['box_third_icon'];
            $data_third['heading_one']    = $post_data['box_third_heading_one'];
            $data_third['heading_two']    = $post_data['box_third_heading_two'];
            $data_third['icon_color']     = $post_data['box_third_iconcolor'];
            $data_third['link']           = $post_data['box_third_Link'];
            $data_third['heading_one_color']    = $post_data['box_third_heading_one_color'];
            $data_third['heading_two_color']    = $post_data['box_third_heading_two_color'];
            
            $this->db->where('id', 3);
            $this->db->update('tbldashboard_boxsetting', $data_third);
            
            $data_fourth['bg_color']       = $post_data['box_fourth_bgcolor'];
            $data_fourth['hover_color']    = $post_data['box_fourth_hovercolor'];
            $data_fourth['icon']           = $post_data['box_fourth_icon'];
            $data_fourth['heading_one']    = $post_data['box_fourth_heading_one'];
            $data_fourth['heading_two']    = $post_data['box_fourth_heading_two'];
            $data_fourth['icon_color']     = $post_data['box_fourth_iconcolor'];
            $data_fourth['link']           = $post_data['box_fourth_Link'];
            $data_fourth['heading_one_color']    = $post_data['box_fourth_heading_one_color'];
            $data_fourth['heading_two_color']    = $post_data['box_fourth_heading_two_color'];
            
            $this->db->where('id', 4);
            $this->db->update('tbldashboard_boxsetting', $data_fourth);
            
            set_alert('success', _l('settings_updated'));

            redirect(admin_url('dashboardSetting'), 'refresh');
        }
        $data['box_result'] = $this->db->get_where('tbldashboard_boxsetting')->result();
        $this->load->view('admin/dashboardSettings/all', $data);
    }
    
    /* View all settings */
    public function countBox()
    {
        if (!has_permission('dashboard_settings', '', 'view')) {
            access_denied('settings');
        }

        $sheader_text = title_text('setup_menu_active', 'dashboard_settings');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        if ($this->input->post()) {
            /*
            if (!has_permission('settings', '', 'edit')) {
                access_denied('settings');
            }
            */
            $post_data = $this->input->post();
            
            $data_one['bg_color']       = $post_data['box_one_bgcolor'];
            $data_one['hover_color']    = $post_data['box_one_hovercolor'];
            $data_one['icon']           = $post_data['box_one_icon'];
            $data_one['heading_one']    = $post_data['box_one_heading_one'];
            $data_one['value']          = $post_data['box_one_heading_two'];
            $data_one['icon_color']     = $post_data['box_one_iconcolor'];
            $data_one['link']           = $post_data['box_one_Link'];
            
            $this->db->where('id', 5);
            $this->db->update('tbldashboard_boxsetting', $data_one);
            
            $data_two['bg_color']       = $post_data['box_two_bgcolor'];
            $data_two['hover_color']    = $post_data['box_two_hovercolor'];
            $data_two['icon']           = $post_data['box_two_icon'];
            $data_two['heading_one']    = $post_data['box_two_heading_one'];
            $data_two['value']          = $post_data['box_two_heading_two'];
            $data_two['icon_color']     = $post_data['box_two_iconcolor'];
            $data_two['link']           = $post_data['box_two_Link'];
            
            $this->db->where('id', 6);
            $this->db->update('tbldashboard_boxsetting', $data_two);
            
            $data_third['bg_color']       = $post_data['box_third_bgcolor'];
            $data_third['hover_color']    = $post_data['box_third_hovercolor'];
            $data_third['icon']           = $post_data['box_third_icon'];
            $data_third['heading_one']    = $post_data['box_third_heading_one'];
            $data_third['value']          = $post_data['box_third_heading_two'];
            $data_third['icon_color']     = $post_data['box_third_iconcolor'];
            $data_third['link']           = $post_data['box_third_Link'];
            
            $this->db->where('id', 7);
            $this->db->update('tbldashboard_boxsetting', $data_third);
            
            $data_fourth['bg_color']       = $post_data['box_fourth_bgcolor'];
            $data_fourth['hover_color']    = $post_data['box_fourth_hovercolor'];
            $data_fourth['icon']           = $post_data['box_fourth_icon'];
            $data_fourth['heading_one']    = $post_data['box_fourth_heading_one'];
            $data_fourth['value']          = $post_data['box_fourth_heading_two'];
            $data_fourth['icon_color']     = $post_data['box_fourth_iconcolor'];
            $data_fourth['link']           = $post_data['box_fourth_Link'];
            
            $this->db->where('id', 8);
            $this->db->update('tbldashboard_boxsetting', $data_fourth);
            
            set_alert('success', _l('settings_updated'));

            redirect(admin_url('dashboardSetting/countBox'), 'refresh');
        }
        $data['box_result'] = $this->db->get_where('tbldashboard_boxsetting', array('id >'=>4))->result();
        $this->load->view('admin/dashboardSettings/countBox', $data);
    }
    
    /**
    *   Graph
    */
    public function graphBox()
    {
        if (!has_permission('dashboard_settings', '', 'view')) {
            access_denied('settings');
        }

        $sheader_text = title_text('setup_menu_active', 'dashboard_settings');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        if ($this->input->post()) {
            $post_data = $this->input->post();
            
            $data_one['heading']        = $post_data['first_heading'];
            $data_one['name']           = $post_data['first_name'];
            $first_status               = $post_data['first_status'];
            if($first_status == 1)
            {
                $data_one['status']           = $post_data['first_status'];
            }
            else
            {
                $data_one['status']           = 0;
            }
            $this->db->where('id', 1);
            $this->db->update('tbldashboard_graphsetting', $data_one);
            
            set_alert('success', _l('settings_updated'));

            redirect(admin_url('dashboardSetting/graphBox'), 'refresh');
        }
        $data['box_result'] = $this->db->get_where('tbldashboard_graphsetting')->result();
        $this->load->view('admin/dashboardSettings/graphBox', $data);
    }
}
