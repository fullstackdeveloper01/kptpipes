<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Content extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /* List all content */
    public function index()
    {
        $this->aboutUs();
        if (!has_permission('content', '', 'view')) {
            access_denied('content');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('content');
        }
      
        $header_text = title_text('aside_menu_active', 'content');
        $data['heading_text'] = $header_text;
        $data['title']    = _l($header_text);
        $this->load->view('admin/content/content', $data);
    }
    
    /* List all About us */
    public function aboutUs()
    {
        if (!has_permission('content', '', 'view')) {
            access_denied('content');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('aboutUs');
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'content', 'aboutUs');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = $subheader_text;
        $this->load->view('admin/content/aboutUs', $data);
    }
    /* List all About us */
    public function contactUs()
    {
        if (!has_permission('content', '', 'view')) {
            access_denied('content');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('contactUs');
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'content', 'contactUs');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = $subheader_text;
        $this->load->view('admin/content/contactUs', $data);
    }
    /* List all privacy Policy */
    public function privacyPolicy()
    {
        if (!has_permission('content', '', 'view')) {
            access_denied('content');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('privacyPolicy');
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'content', 'privacyPolicy');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = $subheader_text;
        $this->load->view('admin/content/privacyPolicy', $data);
    }
    /* List all About us */
    public function termsAndCondition()
    {
        if (!has_permission('content', '', 'view')) {
            access_denied('content');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('termsAndCondition');
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'content', 'termsAndCondition');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = $subheader_text;
        $this->load->view('admin/content/termsAndCondition', $data);
    }
}