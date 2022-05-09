<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends AdminController
{
    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

    /* This is admin dashboard view */
    public function index() {
        close_setup_menu();
        $this->load->model('departments_model');
        $this->load->model('todo_model');
        $data['departments'] = $this->departments_model->get();

        $data['todos'] = $this->todo_model->get_todo_items(0);
        // Only show last 5 finished todo items
        $this->todo_model->setTodosLimit(5);
        $data['todos_finished']            = $this->todo_model->get_todo_items(1);
        $data['upcoming_events_next_week'] = $this->dashboard_model->get_upcoming_events_next_week();
        $data['upcoming_events']           = $this->dashboard_model->get_upcoming_events();
        $data['title']                     = _l('dashboard_string');
        $this->load->model('currencies_model');
        $data['currencies']    = $this->currencies_model->get();
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $data['activity_log']  = $this->misc_model->get_activity_log();
        // Tickets charts
        $tickets_awaiting_reply_by_status     = $this->dashboard_model->tickets_awaiting_reply_by_status();
        $tickets_awaiting_reply_by_department = $this->dashboard_model->tickets_awaiting_reply_by_department();

        $data['tickets_reply_by_status']              = json_encode($tickets_awaiting_reply_by_status);
        $data['tickets_awaiting_reply_by_department'] = json_encode($tickets_awaiting_reply_by_department);

        $data['tickets_reply_by_status_no_json']              = $tickets_awaiting_reply_by_status;
        $data['tickets_awaiting_reply_by_department_no_json'] = $tickets_awaiting_reply_by_department;

        $data['client_graph_by_status'] = json_encode($this->dashboard_model->client_graph_by_status());
        
        $data['projects_status_stats'] = json_encode($this->dashboard_model->projects_status_stats());
        
        //echo '<pre>'; print_r(json_decode($data['client_graph_by_status'])); die;
        
        $data['leads_status_stats']    = json_encode($this->dashboard_model->leads_status_stats());
        $data['google_ids_calendars']  = $this->misc_model->get_google_calendar_ids();
        $data['bodyclass']             = 'dashboard invoices-total-manual';
        $this->load->model('announcements_model');
        $data['staff_announcements']             = $this->announcements_model->get();
        $data['total_undismissed_announcements'] = $this->announcements_model->get_total_undismissed_announcements();

        $this->load->model('projects_model');
        $data['projects_activity'] = $this->projects_model->get_activity('', hooks()->apply_filters('projects_activity_dashboard_limit', 20));
        add_calendar_assets();
        $this->load->model('utilities_model');
        $this->load->model('estimates_model');
        $data['estimate_statuses'] = $this->estimates_model->get_statuses();

        $this->load->model('proposals_model');
        $data['proposal_statuses'] = $this->proposals_model->get_statuses();

        $wps_currency = 'undefined';
        if (is_using_multiple_currencies()) {
            $wps_currency = $data['base_currency']->id;
        }
        $data['weekly_payment_stats'] = json_encode($this->dashboard_model->get_weekly_payments_statistics($wps_currency));

        $data['dashboard'] = true;

        $data['user_dashboard_visibility'] = get_staff_meta(get_staff_user_id(), 'dashboard_widgets_visibility');

        if (!$data['user_dashboard_visibility']) {
            $data['user_dashboard_visibility'] = [];
        } else {
            $data['user_dashboard_visibility'] = unserialize($data['user_dashboard_visibility']);
        }
        $data['user_dashboard_visibility'] = json_encode($data['user_dashboard_visibility']);
        
        //$data['box_result'] = $this->db->get_where('tbldashboard_boxsetting')->result();
        $box_result = $this->db->get_where('tbldashboard_boxsetting')->result();
        if($box_result)
        {
            $ik = 0;
            foreach($box_result as $rr)
            {
                if($ik > 3)
                {
                    if($rr->value == '')
                    {
                        if($rr->link == 'clients')
                        {
                            $totalclient = $this->db->get_where(db_prefix().'clients')->num_rows();
                            $box_result[$ik]->value = $totalclient;
                        }
                        elseif($rr->link == 'proposals')
                        {
                            $totalclient = $this->db->get_where(db_prefix().'proposals')->num_rows();
                            $box_result[$ik]->value = $totalclient;
                        }
                        elseif($rr->link == 'estimates')
                        {
                            $totalclient = $this->db->get_where(db_prefix().'estimates')->num_rows();
                            $box_result[$ik]->value = $totalclient;
                        }
                        elseif($rr->link == 'invoices')
                        {
                            $totalclient = $this->db->get_where(db_prefix().'invoices')->num_rows();
                            $box_result[$ik]->value = $totalclient;
                        }
                        elseif($rr->link == 'payments')
                        {
                            $totalclient = $this->db->get_where(db_prefix().'invoicepaymentrecords')->num_rows();
                            $box_result[$ik]->value = $totalclient;
                        }
                    }
                }
                $ik++;
            }
        }
        
        $data['box_result'] = $box_result;
        $data = hooks()->apply_filters('before_dashboard_render', $data);

        // echo '<pre>'; print_r($box_result); die;
        $this->load->view('admin/dashboard/dashboard', $data);
    }

    /* Chart weekly payments statistics on home page / ajax */
    public function weekly_payments_statistics($currency) {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->dashboard_model->get_weekly_payments_statistics($currency));
            die();
        }
    }

    public function greeting($id,$notiid){
        $id= base64_decode($id);
        $id=explode('-', $id);
        $id['type']=$id[0];

        // print_r($id);die;
        $result = databasetable($id);
        if ($this->input->is_ajax_request()) {
            $uri= base64_decode($this->uri->segment(2));
            $uri=explode('-', $uri);
            $result = databasetable($uri[0]);
            $insertdata=($this->input->post());
            $insertdata['type']=$result['type'];
            $insertdata['status_type']='add';
            $insertdata['user_id']=$uri[1];
            // print_r($insertdata);die;
            unset($insertdata['greeting_msg']);
            $this->Common_model->add_article(db_prefix().'user_reward',$insertdata);
            $this->Common_model->update(db_prefix().'notifications',['isread'=>1],['id'=>$this->uri->segment(3)]);
            $userdata =  $this->db->get_where($result['table'],['id'=>$uri[1]])->row_array();
            // print_r($userdata);die;
            if ($this->input->post('greeting_msg')=="Wish You a Very happy Birthday to You") {
                $subject="Birthday Reward by Company";
            } else {
                $subject="Anniversary Reward by Company";
            }
            
            $smsdata['moblie_no'] = $userdata[$result['mobile']];
            $smsdata['message'] = 'Hi,%20%207861%20%20is%20the%20OTP%20(One%20Time%20Password)%20to%20open%20your%20application.%20For%20security%20reasons,%20do%20not%20share%20your%20OTP%20with%20anyone.%20Regards,%20KPT%20PIPES';
            // send_sms($smsdata);
            
            if ($userdata[$result['email']]!="") {
                // send_mail($userdata[$result['email']],$subject,$insertdata['message']);
            }
            if ($userdata['token']!="") {
                // echo $userdata['token'];
                sendNotifications($userdata['token'],$insertdata['message'],$subject);
            }
            // die;
            $notidata['type']=$result['type'];
            $notidata['description']=$insertdata['message'];
            $notidata['link']='greeting/'.$this->uri->segment(2);
            $notidata['touserid']=$uri[1];
            $notidata['isread_inline']=1;
            $notidata['isread']=1;
            $notidata['noti_type']='Reward';
            $this->Common_model->add_article(db_prefix().'notifications',$notidata);
            echo $data['status']='true';
            die;
        }

        $this->Common_model->update(db_prefix().'notifications',['isread_inline'=>1],['id'=>$notiid]);
        $sheader_text = title_text('aside_menu_active', 'Greetings'); 
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $res = $this->Common_model->get($result['table'],['id'=>$id[1]]);
        $res->type=$result['type'];
        $data['response'] = $res;
        $data['notification'] = $this->Common_model->get(db_prefix().'notifications',['id'=>$notiid]);
        $data['result']=$result;
        $notidata = $this->Common_model->get(db_prefix().'notifications',['isread_inline'=>1,'isread'=>1,'id'=>$notiid]);
        if (!empty($notidata)) {
            redirect('/greeting-list/', 'refresh');
        }
        $this->load->view('admin/greeting/create', $data);
    }

    /* Greeting List */
    public function greeting_list()
    {
        // if (!has_permission('distributors', '', 'view')) {
        //     access_denied('distributors');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('greeting_list');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Greetings');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/greeting/greetings', $data);
    }
}
