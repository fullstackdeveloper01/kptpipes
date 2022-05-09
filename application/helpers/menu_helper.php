<?php

defined('BASEPATH') or exit('No direct script access allowed');

function app_init_admin_sidebar_menu_items()
{
    $CI = &get_instance();

    $custommenu = $CI->db->get_where('tbloptions', array('name' => 'aside_menu_active'))->row('value');
    $M = json_decode($custommenu);
//echo '<pre>'; print_r(json_decode($custommenu)); die;

    $CI->app_menu->add_sidebar_menu_item('dashboard', [
        'name'     => _l($M->dashboard->label),
        'href'     => admin_url(),
        'position' => 1,
        'icon'     => 'fa fa-home',
        'label'    => _l($M->dashboard->label),
        'heading'  => _l($M->dashboard->heading),
    ]);
    if ($CI->session->staff_role_id==0) {
    $CI->app_menu->add_sidebar_menu_item('users', [
        'name'     => _l($M->users->label),
        'href'     => site_url('users'),
        'position' => 2,
        'icon'     => 'fa fa-home',
        'label'    => _l($M->users->label),
        'heading'  => _l($M->users->heading),
    ]);
    }

    $CI->app_menu->add_sidebar_menu_item('help', [
        'name'     => _l($M->help->label),
        'href'     => site_url('help-center'),
        'position' => 3,
        'icon'     => 'fa fa-home',
        'label'    => _l($M->help->label),
        'heading'  => _l($M->help->heading),
    ]);

    $CI->app_menu->add_sidebar_menu_item('backup', [
        'name'     => _l($M->backup->label),
        'href'     => site_url('backup'),
        'position' => 3,
        'icon'     => 'fa fa-home',
        'label'    => _l($M->backup->label),
        'heading'  => _l($M->backup->heading),
    ]);
    
    //Master
    $CI->app_menu->add_sidebar_menu_item('master', [
            'collapse' => true,
            'name'     => _l($M->master->label),
            'position' => 15,
            'icon'     => 'fa fa-user-o',
            'label'     => _l($M->master->label),
            'heading'  => _l($M->master->heading),
        ]);

    $CI->app_menu->add_sidebar_children_item('master', [
            'slug'     => 'location',
            'name'     => _l($M->master->children->location->label),
            'href'     => admin_url('location'),
            'position' => 6,
            'label'     => _l($M->master->children->location->label),
            'heading'     => _l($M->master->children->location->heading),
        ]);

    $CI->app_menu->add_sidebar_children_item('master', [
            'slug'     => 'state',
            'name'     => _l($M->master->children->state->label),
            'href'     => admin_url('state'),
            'position' => 6,
            'label'     => _l($M->master->children->state->label),
            'heading'     => _l($M->master->children->state->heading),
        ]);
        
    $CI->app_menu->add_sidebar_children_item('master', [
            'slug'     => 'city',
            'name'     => _l($M->master->children->city->label),
            'href'     => admin_url('city'),
            'position' => 6,
            'label'    => _l($M->master->children->city->label),
            'heading'  => _l($M->master->children->city->heading),
        ]); 
    
    $CI->app_menu->add_sidebar_children_item('master', [
            'slug'     => 'brand',
            'name'     => _l($M->master->children->brand->label),
            'href'     => admin_url('brand'),
            'position' => 7,
            'label'    => _l($M->master->children->brand->label),
            'heading'  => _l($M->master->children->brand->heading),
        ]);

    // $CI->app_menu->add_sidebar_children_item('master', [
    //         'slug'     => 'category',
    //         'name'     => _l($M->master->children->category->label),
    //         'href'     => admin_url('category'),
    //         'position' => 8,
    //         'label'    => _l($M->master->children->category->label),
    //         'heading'  => _l($M->master->children->category->heading),
    //     ]);

    // $CI->app_menu->add_sidebar_children_item('master', [
    //         'slug'     => 'subCategory',
    //         'name'     => _l($M->master->children->subCategory->label),
    //         'href'     => admin_url('subCategory'),
    //         'position' => 9,
    //         'label'    => _l($M->master->children->subCategory->label),
    //         'heading'  => _l($M->master->children->subCategory->heading),
    //     ]);

    // $CI->app_menu->add_sidebar_children_item('master', [
    //         'slug'     => 'tax',
    //         'name'     => _l($M->master->children->tax->label),
    //         'href'     => admin_url('tax'),
    //         'position' => 10,
    //         'label'    => _l($M->master->children->tax->label),
    //         'heading'  => _l($M->master->children->tax->heading),
    //     ]);

    //MobileApp
    // $CI->app_menu->add_sidebar_menu_item('mobileApp', [
    //         'collapse' => true,
    //         'name'     => _l($M->mobileApp->label),
    //         'position' => 15,
    //         'icon'     => 'fa fa-user-o',
    //         'label'     => _l($M->mobileApp->label),
    //         'heading'  => _l($M->mobileApp->heading),
    //     ]);

    // $CI->app_menu->add_sidebar_children_item('mobileApp', [
    //         'slug'     => 'mobileApp',
    //         'name'     => _l($M->mobileApp->children->mobileApp->label),
    //         /*'href'     => admin_url('mobileApp'),*/
    //         'href'     => '#',
    //         'position' => 6,
    //         'label'     => _l($M->mobileApp->children->mobileApp->label),
    //         'heading'     => _l($M->mobileApp->children->mobileApp->heading),
    //     ]);
    
    // Distributors
    $CI->app_menu->add_sidebar_menu_item('distributors', [
        'name'     => _l($M->distributors->label),
        'href'     => admin_url('distributors'),
        'position' => 15,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->distributors->label),
        'heading'  => _l($M->distributors->heading),
    ]);

    // Dealer
    $CI->app_menu->add_sidebar_menu_item('dealers', [
        'name'     => _l($M->dealers->label),
        'href'     => admin_url('dealers'),
        'position' => 16,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->dealers->label),
        'heading'  => _l($M->dealers->heading),
    ]);

    // Plumbers
    $CI->app_menu->add_sidebar_menu_item('plumbers', [
        'name'     => _l($M->plumbers->label),
        'href'     => admin_url('plumbers'),
        'position' => 17,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->plumbers->label),
        'heading'  => _l($M->plumbers->heading),
    ]);

    // Products
    $CI->app_menu->add_sidebar_menu_item('products', [
        'name'     => _l($M->products->label),
        'href'     => admin_url('products'),
        'position' => 18,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->products->label),
        'heading'  => _l($M->products->heading),
    ]);

    // Products stock
    $CI->app_menu->add_sidebar_menu_item('Stocks', [
        'name'     => _l($M->Stocks->label),
        'href'     => site_url('stocks'),
        'position' => 18,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->Stocks->label),
        'heading'  => _l($M->Stocks->heading),
    ]);

    // distributor stock
    $CI->app_menu->add_sidebar_menu_item('distributor_stocks', [
        'name'     => _l($M->distributor_stocks->label),
        'href'     => site_url('distributor-stocks'),
        'position' => 18,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->distributor_stocks->label),
        'heading'  => _l($M->distributor_stocks->heading),
    ]);

    // dealer stock
    $CI->app_menu->add_sidebar_menu_item('dealer_stocks', [
        'name'     => _l($M->dealer_stocks->label),
        'href'     => site_url('dealer-stocks'),
        'position' => 18,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->dealer_stocks->label),
        'heading'  => _l($M->dealer_stocks->heading),
    ]);

    // Orders
    $CI->app_menu->add_sidebar_menu_item('orders', [
        'name'     => _l($M->orders->label),
        'href'     => site_url('orders'),
        'position' => 19,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->orders->label),
        'heading'  => _l($M->orders->heading),
    ]);

    // Rewards
    $CI->app_menu->add_sidebar_menu_item('rewards', [
        'name'     => _l($M->rewards->label),
        'href'     => site_url('reward-list'),
        // 'href'     => '#',
        'position' => 19,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->rewards->label),
        'heading'  => _l($M->rewards->heading),
    ]);
    // Rewards-value set
    $CI->app_menu->add_sidebar_menu_item('rewards-value', [
        'name'     => _l('Reward-value'),
        'href'     => site_url('reward-value'),
        'position' => 19,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->rewards->label),
        'heading'  => _l($M->rewards->heading),
    ]);
    // // Rewards-assgin
    // $CI->app_menu->add_sidebar_menu_item('rewards assgin', [
    //     'name'     => _l('Rewards-assgin'),
    //     'href'     => site_url('reward-assgin'),
    //     'position' => 19,
    //     'icon'     => 'fa fa-tag',
    //     'label'    => _l($M->rewards->label),
    //     'heading'  => _l($M->rewards->heading),
    // ]);

    // Inventry
    // $CI->app_menu->add_sidebar_menu_item('inventry', [
    //     'name'     => _l($M->inventry->label),
    //     /*'href'     => admin_url('inventry'),*/
    //     'href'     => '#',
    //     'position' => 20,
    //     'icon'     => 'fa fa-tag',
    //     'label'    => _l($M->inventry->label),
    //     'heading'  => _l($M->inventry->heading),
    // ]);

    // Product enquiry
    // $CI->app_menu->add_sidebar_menu_item('productEnquiry', [
    //     'name'     => _l($M->productEnquiry->label),
    //     'href'     => admin_url('productEnquiry'),
    //     'position' => 20,
    //     'icon'     => 'fa fa-tag',
    //     'label'    => _l($M->productEnquiry->label),
    //     'heading'  => _l($M->productEnquiry->heading),
    // ]);
    
    // Discount
    // $CI->app_menu->add_sidebar_menu_item('discount', [
    //     'name'     => _l($M->discount->label),
    //     'href'     => admin_url('discount'),
    //     'position' => 35,
    //     'icon'     => 'fa fa-tag',
    //     'label'    => _l($M->discount->label),
    //     'heading'  => _l($M->discount->heading),
    // ]); 

    // Advertisement
    $CI->app_menu->add_sidebar_menu_item('advertisement', [
        'name'     => _l($M->advertisement->label),
        'href'     => admin_url('advertisement'),
        'position' => 35,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->advertisement->label),
        'heading'  => _l($M->advertisement->heading),
    ]); 

    // Slider
    $CI->app_menu->add_sidebar_menu_item('slider', [
        'name'     => _l($M->slider->label),
        'href'     => admin_url('slider'),
        'position' => 16,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->slider->label),
        'heading'  => _l($M->slider->heading),
    ]);
    
    // portfolio
    $CI->app_menu->add_sidebar_menu_item('portfolio', [
        'name'     => _l($M->portfolio->label),
        'href'     => admin_url('portfolio'),
        'position' => 17,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->portfolio->label),
        'heading'  => _l($M->portfolio->heading),
    ]);

    // Clients
    $CI->app_menu->add_sidebar_menu_item('clients', [
        'name'     => _l($M->clients->label),
        'href'     => admin_url('clients'),
        'position' => 15,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->clients->label),
        'heading'  => _l($M->clients->heading),
    ]);
    
    // Case Study
    $CI->app_menu->add_sidebar_menu_item('caseStudy', [
        'name'     => _l($M->caseStudy->label),
        'href'     => admin_url('caseStudy'),
        'position' => 18,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->caseStudy->label),
        'heading'  => _l($M->caseStudy->heading),
    ]);

    // Website
    $CI->app_menu->add_sidebar_menu_item('websiteHeading', [
        'name'     => _l($M->websiteHeading->label),
        'href'     => admin_url('websiteHeading'),
        'position' => 19,
        'icon'     => 'fa fa-tag',
        'label'    => _l($M->websiteHeading->label),
        'heading'  => _l($M->websiteHeading->heading),
    ]);
    
    //Content
    $CI->app_menu->add_sidebar_menu_item('content', [
            'collapse' => true,
            'name'     => _l($M->content->label),
            'position' => 55,
            'icon'     => 'fa fa-cogs',
            'label'    => _l($M->content->label),
            'heading'  => _l($M->content->heading),
        ]);
    
    $CI->app_menu->add_sidebar_children_item('content', [
            'slug'     => 'aboutUs',
            'name'     => _l($M->content->children->aboutUs->label),
            'href'     => admin_url('aboutUs'),
            'position' => 56,
            'label'     => _l($M->content->children->aboutUs->label),
            'heading'     => _l($M->content->children->aboutUs->heading),
        ]);
        
    $CI->app_menu->add_sidebar_children_item('content', [
            'slug'     => 'contactUs',
            'name'     => _l($M->content->children->contactUs->label),
            'href'     => admin_url('contactUs'),
            'position' => 58,
            'label'     => _l($M->content->children->contactUs->label),
            'heading'     => _l($M->content->children->contactUs->heading),
        ]);
    $CI->app_menu->add_sidebar_children_item('content', [
            'slug'     => 'privacyPolicy',
            'name'     => _l($M->content->children->privacyPolicy->label),
            'href'     => admin_url('privacyPolicy'),
            'position' => 59,
            'label'     => _l($M->content->children->privacyPolicy->label),
            'heading'     => _l($M->content->children->privacyPolicy->heading),
        ]);
    $CI->app_menu->add_sidebar_children_item('content', [
            'slug'     => 'termsAndCondition',
            'name'     => _l($M->content->children->termsAndCondition->label),
            'href'     => admin_url('termsAndCondition'),
            'position' => 60,
            'label'     => _l($M->content->children->termsAndCondition->label),
            'heading'     => _l($M->content->children->termsAndCondition->heading),
        ]);

    $customsub_menu = $CI->db->get_where('tbloptions', array('name' => 'setup_menu_active'))->row('value');
    $sM = json_decode($customsub_menu);
    //echo '<pre>'; print_r($sM); die;
    
    // Setup menu
    if (has_permission('settings', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('settings', [
                    'href'     => admin_url('settings'),
                    'name'     => _l($sM->settings->label),
                    'position' => 3,
                    'label'     => _l($sM->settings->label),
                    'heading'     => _l($sM->settings->heading),
            ]);
    }
    
    $CI->app_menu->add_setup_menu_item('dashboard_settings', [
                    'href'     => admin_url('dashboardSetting'),
                    'name'     => _l($sM->dashboard_settings->label),
                    'position' => 4,
                    'label'     => _l($sM->dashboard_settings->label),
                    'heading'     => _l($sM->dashboard_settings->heading),
            ]);

    if (has_permission('staff', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('login', [
                    'name'     => _l($sM->login->label),
                    'href'     => admin_url('loginPage'),
                    'position' => 5,
                    'label'     => _l($sM->login->label),
                    'heading'     => _l($sM->login->heading),
            ]);
    }

        $CI->app_menu->add_setup_menu_item('roles', [
                    'href'     => admin_url('roles'),
                    'name'     => _l($sM->roles->label),
                    'label'     => _l($sM->roles->label),
                    'heading'     => _l($sM->roles->heading),
                    'position' => 6,
            ]);

    if (has_permission('staff', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('staff', [
                    'name'     => _l($sM->staff->label),
                    'href'     => admin_url('staff'),
                    'position' => 7,
                    'label'    => _l($sM->staff->label),
                    'heading'    => _l($sM->staff->heading),
            ]);
    }

    if (is_admin()) {
        $CI->app_menu->add_setup_menu_item('customers', [
                    'collapse' => true,
                    'name'     => _l($sM->customers->label),
                    'position' => 10,
                    'label'     => _l($sM->customers->label),
                    'heading'     => _l($sM->customers->heading),
            ]);

        $CI->app_menu->add_setup_children_item('customers', [
                    'slug'     => 'custom_fields',
                    'name'     => _l($sM->customers->children->custom_fields->label),
                    'href'     => admin_url('clients/customFields'),
                    'position' => 5,
                    'label'     => _l($sM->customers->children->custom_fields->label),
                    'heading'     => _l($sM->customers->children->custom_fields->heading),
            ]);
            
        $CI->app_menu->add_setup_children_item('customers', [
                    'slug'     => 'customer_groups',
                    'name'     => _l($sM->customers->children->customer_groups->label),
                    'label'     => _l($sM->customers->children->customer_groups->label),
                    'heading'     => _l($sM->customers->children->customer_groups->heading),
                    'href'     => admin_url('clients/groups'),
                    'position' => 5,
            ]);

        $CI->app_menu->add_setup_menu_item('product_services', [
                    'href'     => admin_url('#'),
                    'name'     => _l('Product / Services'),
                    'label'     => _l('Product / Services'),
                    'position' => 11,
            ]);
            
        $CI->app_menu->add_setup_menu_item('gdpr', [
                    'href'     => admin_url('gdpr'),
                    'name'     => _l($sM->gdpr->label),
                    'label'     => _l($sM->gdpr->label),
                    'heading'     => _l($sM->gdpr->heading),
                    'position' => 50,
            ]);

        $CI->app_menu->add_setup_menu_item('finance', [
                    'collapse' => true,
                    'name'     => _l($sM->finance->label),
                    'label'     => _l($sM->finance->label),
                    'heading'     => _l($sM->finance->heading),
                    'position' => 25,
            ]);
        $CI->app_menu->add_setup_children_item('finance', [
                    'slug'     => 'taxes',
                    'name'     => _l($sM->finance->children->taxes->label),
                    'label'     => _l($sM->finance->children->taxes->label),
                    'heading'     => _l($sM->finance->children->taxes->heading),
                    'href'     => admin_url('taxes'),
                    'position' => 5,
            ]);
        $CI->app_menu->add_setup_children_item('finance', [
                    'slug'     => 'currencies',
                    'name'     => _l($sM->finance->children->currencies->label),
                    'label'     => _l($sM->finance->children->currencies->label),
                    'heading'     => _l($sM->finance->children->currencies->heading),
                    'href'     => admin_url('currencies'),
                    'position' => 10,
            ]);
        $CI->app_menu->add_setup_children_item('finance', [
                    'slug'     => 'payment_modes',
                    'name'     => _l($sM->finance->children->payment_modes->label),
                    'label'     => _l($sM->finance->children->payment_modes->label),
                    'heading'     => _l($sM->finance->children->payment_modes->heading),
                    'href'     => admin_url('paymentmodes'),
                    'position' => 15,
            ]);
        $CI->app_menu->add_setup_children_item('finance', [
                    'slug'     => 'expenses_categories',
                    'heading'     => _l($sM->finance->children->expenses_categories->heading),
                    'name'     => _l($sM->finance->children->expenses_categories->label),
                    'label'     => _l($sM->finance->children->expenses_categories->label),
                    'href'     => admin_url('expenses/categories'),
                    'position' => 20,
            ]);

        $CI->app_menu->add_setup_menu_item('subscription', [
                    'href'     => admin_url('settings?group=subscriptions'),
                    'name'     => _l($sM->subscription->label),
                    'label'     => _l($sM->subscription->label),
                    'heading'     => _l($sM->subscription->heading),
                    'position' => 26,
            ]);

        $CI->app_menu->add_setup_menu_item('payment_gateways', [
                    'href'     => admin_url('settings?group=payment_gateways'),
                    'name'     => _l('Payment Gateway'),
                    'label'     => _l('Payment Gateway'),
                    'position' => 27,
            ]);

        $CI->app_menu->add_setup_menu_item('_sms', [
                    'href'     => admin_url('settings?group=sms'),
                    'name'     => _l('SMS'),
                    'label'     => _l('SMS'),
                    'position' => 28,
            ]);
            
        $CI->app_menu->add_setup_menu_item('leads', [
                    'collapse' => true,
                    'name'     => _l($sM->leads->label),
                    'label'     => _l($sM->leads->label),
                    'heading'     => _l($sM->leads->heading),
                    'position' => 20,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads_sources',
                    'name'     => _l($sM->leads->children->leads_sources->label),
                    'label'     => _l($sM->leads->children->leads_sources->label),
                    'heading'     => _l($sM->leads->children->leads_sources->heading),
                    'href'     => admin_url('leads/sources'),
                    'position' => 5,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads_statuses',
                    'name'     => _l($sM->leads->children->leads_statuses->label),
                    'label'     => _l($sM->leads->children->leads_statuses->label),
                    'heading'     => _l($sM->leads->children->leads_statuses->heading),
                    'href'     => admin_url('leads/statuses'),
                    'position' => 10,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads_email_integration',
                    'name'     => _l($sM->leads->children->leads_email_integration->label),
                    'label'     => _l($sM->leads->children->leads_email_integration->label),
                    'heading'     => _l($sM->leads->children->leads_email_integration->heading),
                    'href'     => admin_url('leads/email_integration'),
                    'position' => 15,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'web_to_lead',
                    'name'     => _l($sM->leads->children->web_to_lead->label),
                    'label'     => _l($sM->leads->children->web_to_lead->label),
                    'heading'     => _l($sM->leads->children->web_to_lead->heading),
                    'href'     => admin_url('leads/forms'),
                    'position' => 20,
            ]);
        
        $CI->app_menu->add_setup_menu_item('support', [
                    'collapse' => true,
                    'name'     => _l($sM->support->label),
                    'label'     => _l($sM->support->label),
                    'heading'     => _l($sM->support->heading),
                    'position' => 15,
            ]);

        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'departments',
                    'name'     => _l($sM->support->children->departments->label),
                    'label'     => _l($sM->support->children->departments->label),
                    'heading'     => _l($sM->support->children->departments->heading),
                    'href'     => admin_url('departments'),
                    'position' => 5,
            ]);
            
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets_predefined_replies',
                    'name'     => _l($sM->support->children->tickets_predefined_replies->label),
                    'label'     => _l($sM->support->children->tickets_predefined_replies->label),
                    'heading'     => _l($sM->support->children->tickets_predefined_replies->heading),
                    'href'     => admin_url('tickets/predefined_replies'),
                    'position' => 10,
            ]);
        
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets_priorities',
                    'name'     => _l($sM->support->children->tickets_priorities->label),
                    'label'     => _l($sM->support->children->tickets_priorities->label),
                    'heading'     => _l($sM->support->children->tickets_priorities->heading),
                    'href'     => admin_url('tickets/priorities'),
                    'position' => 15,
            ]);
            
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets_statuses',
                    'name'     => _l($sM->support->children->tickets_statuses->label),
                    'label'     => _l($sM->support->children->tickets_statuses->label),
                    'heading'     => _l($sM->support->children->tickets_statuses->heading),
                    'href'     => admin_url('tickets/statuses'),
                    'position' => 20,
            ]);

        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets_services',
                    'name'     => _l($sM->support->children->tickets_services->label),
                    'label'     => _l($sM->support->children->tickets_services->label),
                    'heading'     => _l($sM->support->children->tickets_services->heading),
                    'href'     => admin_url('tickets/services'),
                    'position' => 25,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets_spam_filters',
                    'name'     => _l($sM->support->children->tickets_spam_filters->label),
                    'label'     => _l($sM->support->children->tickets_spam_filters->label),
                    'heading'     => _l($sM->support->children->tickets_spam_filters->heading),
                    'href'     => admin_url('spam_filters/view/tickets'),
                    'position' => 30,
            ]);

    //Report
    $CI->app_menu->add_sidebar_menu_item('report', [
            'collapse' => true,
            'name'     => _l($M->report->label),
            'position' => 51,
            'icon'     => 'fa fa-user-o',
            'label'     => _l($M->report->label),
            'heading'  => _l($M->report->heading),
        ]);

    $CI->app_menu->add_sidebar_children_item('report', [
            'slug'     => 'distributor',
            'name'     => _l($M->report->children->distributor->label),
            'href'     => site_url('distributor-list'),
            'position' => 52,
            'label'     => _l($M->report->children->distributor->label),
            'heading'     => _l($M->report->children->distributor->heading),
        ]);

    $CI->app_menu->add_sidebar_children_item('report', [
            'slug'     => 'dealer',
            'name'     => _l($M->report->children->dealer->label),
            'href'     => site_url('dealer-list'),
            'position' => 53,
            'label'     => _l($M->report->children->dealer->label),
            'heading'     => _l($M->report->children->dealer->heading),
        ]);
    $CI->app_menu->add_sidebar_children_item('report', [
            'slug'     => 'plumber',
            'name'     => _l($M->report->children->plumber->label),
            'href'     => site_url('plumber-list'),
            'position' => 54,
            'label'     => _l($M->report->children->plumber->label),
            'heading'     => _l($M->report->children->plumber->heading),
        ]);

    $CI->app_menu->add_sidebar_menu_item('greeting', [
        'name'     => _l($M->greeting->label),
        'href'     => site_url('greeting-list'),
        'position' => 3,
        'icon'     => 'fa fa-home',
        'label'    => _l($M->greeting->label),
        'heading'  => _l($M->greeting->heading),
    ]);

    //redeem Reward
    $CI->app_menu->add_sidebar_menu_item('redeem', [
            'collapse' => true,
            'name'     => _l($M->redeem->label),
            'position' => 55,
            'icon'     => 'fa fa-user-o',
            'label'     => _l($M->redeem->label),
            'heading'  => _l($M->redeem->heading),
        ]);

    $CI->app_menu->add_sidebar_children_item('redeem', [
            'slug'     => 'reward',
            'name'     => _l($M->redeem->children->reward->label),
            'href'     => site_url('redeem-reward'),
            'position' => 56,
            'label'     => _l($M->redeem->children->reward->label),
            'heading'     => _l($M->redeem->children->reward->heading),
        ]);

    $CI->app_menu->add_sidebar_children_item('redeem', [
            'slug'     => 'history',
            'name'     => _l($M->redeem->children->history->label),
            'href'     => site_url('redeem-history'),
            'position' => 57,
            'label'     => _l($M->redeem->children->history->label),
            'heading'     => _l($M->redeem->children->history->heading),
        ]);

/*
        $CI->app_menu->add_setup_menu_item('support', [
                    'collapse' => true,
                    'name'     => _l('support'),
                    'position' => 15,
            ]);

        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'departments',
                    'name'     => _l('acs_departments'),
                    'href'     => admin_url('departments'),
                    'position' => 5,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-predefined-replies',
                    'name'     => _l('acs_ticket_predefined_replies_submenu'),
                    'href'     => admin_url('tickets/predefined_replies'),
                    'position' => 10,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-priorities',
                    'name'     => _l('acs_ticket_priority_submenu'),
                    'href'     => admin_url('tickets/priorities'),
                    'position' => 15,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-statuses',
                    'name'     => _l('acs_ticket_statuses_submenu'),
                    'href'     => admin_url('tickets/statuses'),
                    'position' => 20,
            ]);

        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-services',
                    'name'     => _l('acs_ticket_services_submenu'),
                    'href'     => admin_url('tickets/services'),
                    'position' => 25,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-spam-filters',
                    'name'     => _l('spam_filters'),
                    'href'     => admin_url('spam_filters/view/tickets'),
                    'position' => 30,
            ]);

        $CI->app_menu->add_setup_menu_item('leads', [
                    'collapse' => true,
                    'name'     => _l('acs_leads'),
                    'position' => 20,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads-sources',
                    'name'     => _l('acs_leads_sources_submenu'),
                    'href'     => admin_url('leads/sources'),
                    'position' => 5,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads-statuses',
                    'name'     => _l('acs_leads_statuses_submenu'),
                    'href'     => admin_url('leads/statuses'),
                    'position' => 10,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads-email-integration',
                    'name'     => _l('leads_email_integration'),
                    'href'     => admin_url('leads/email_integration'),
                    'position' => 15,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'web-to-lead',
                    'name'     => _l('web_to_lead'),
                    'href'     => admin_url('leads/forms'),
                    'position' => 20,
            ]);

        $CI->app_menu->add_setup_menu_item('contracts', [
                    'collapse' => true,
                    'name'     => _l('acs_contracts'),
                    'position' => 30,
            ]);
        $CI->app_menu->add_setup_children_item('contracts', [
                    'slug'     => 'contracts-types',
                    'name'     => _l('acs_contract_types'),
                    'href'     => admin_url('contracts/types'),
                    'position' => 5,
            ]);

        $modules_name = _l('modules');

        if ($modulesNeedsUpgrade = $CI->app_modules->number_of_modules_that_require_database_upgrade()) {
            $modules_name .= '<span class="badge menu-badge bg-warning">' . $modulesNeedsUpgrade . '</span>';
        }

        $CI->app_menu->add_setup_menu_item('modules', [
                    'href'     => admin_url('modules'),
                    'name'     => $modules_name,
                    'position' => 35,
            ]);

        $CI->app_menu->add_setup_menu_item('custom-fields', [
                    'href'     => admin_url('custom_fields'),
                    'name'     => _l('asc_custom_fields'),
                    'position' => 45,
            ]);

        $CI->app_menu->add_setup_menu_item('gdpr', [
                    'href'     => admin_url('gdpr'),
                    'name'     => _l('gdpr_short'),
                    'position' => 50,
            ]);
        */

        

/*             $CI->app_menu->add_setup_menu_item('api', [
                          'href'     => admin_url('api'),
                          'name'     => 'API',
                          'position' => 65,
                  ]);*/

    }

    /*

    if (has_permission('email_templates', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('email-templates', [
                    'href'     => admin_url('emails'),
                    'name'     => _l('acs_email_templates'),
                    'position' => 40,
            ]);
    }
    */
}
