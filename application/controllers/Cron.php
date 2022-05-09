<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends App_Controller
{
    public function index($key = '')
    {
        update_option('cron_has_run_from_cli', 1);

        if (defined('APP_CRON_KEY') && (APP_CRON_KEY != $key)) {
            header('HTTP/1.0 401 Unauthorized');
            die('Passed cron job key is not correct. The cron job key should be the same like the one defined in APP_CRON_KEY constant.');
        }

        $last_cron_run                  = get_option('last_cron_run');
        $seconds = hooks()->apply_filters('cron_functions_execute_seconds', 300);

        if ($last_cron_run == '' || (time() > ($last_cron_run + $seconds))) {
            $this->load->model('cron_model');
            $this->cron_model->run();
        }
    }
    /*-------------------------------------------------------------------
    *@function User birthday
    *-------------------------------------------------------------------*/
    public function getBirthday()
    {

        $this->db->select("id,distributor_name as name, distributor_mobile as mobile, distributor_email as email ,token");
        $this->db->from("tbldistributors");
        $this->db->where("month(distributor_dob)",date("m"));
        $this->db->where("day(distributor_dob)",date("d"));
        $distributor =  $this->db->get()->result_array();
        $this->db->select("id,dealer_name as name, dealer_mobile as mobile, dealer_email as email ,token");
        $this->db->from("tbldealer");
        $this->db->where("month(dealer_dob)",date("m"));
        $this->db->where("day(dealer_dob)",date("d"));
        $dealer =  $this->db->get()->result_array();
        $this->db->select("id,plumber_name as name, plumber_mobile as mobile, plumber_email as email ,token");
        $this->db->from("tblplumber");
        $this->db->where("month(plumber_dob)",date("m"));
        $this->db->where("day(plumber_dob)",date("d"));
        $plumber=  $this->db->get()->result_array();
        $data=[];
        if (count($distributor)>0) {
            foreach ($distributor as $value) {
                $value['type'] = "distributor";
                $data[]=$value;
            }
        }
        if (count($dealer)) {
            foreach ($dealer as $dvalue) {
                $dvalue['type'] = "dealer";
                $data[]=$dvalue;
            }
        }
        if(count($plumber)){
            foreach ($plumber as $pvalue) {
                $pvalue['type'] = "plumber";
                $data[]=$pvalue;
            }
        }
        // print_r($data);die;
        if (count($data)>0) {
            $message='Wish You a Very happy Birthday to You';
            foreach ($data as  $val) {
                $smsdata['moblie_no'] = $val['mobile'];
                $smsdata['message'] = 'Hi,%20%207861%20%20is%20the%20OTP%20(One%20Time%20Password)%20to%20open%20your%20application.%20For%20security%20reasons,%20do%20not%20share%20your%20OTP%20with%20anyone.%20Regards,%20KPT%20PIPES';
                // send_sms($smsdata);
                
                if ($val['email']!="") {
                    // send_mail($val['emal'],'Happy Birthday',$message);
                }
                if ($val['token']!="") {
                    sendNotifications($val['token'],$message,'Happy Birthday');
                }
                $notidata['type']=$val['type'];
                $notidata['description']=$message;
                $data=$val['type'].'-'.$val['id'];
                $notidata['link']='greeting/'.base64_encode($data);
                $notidata['touserid']=$val['id'];
                $notidata['noti_type']='Birthday';
                $this->Common_model->add_article(db_prefix().'notifications',$notidata);
            }
            return true;
        }else{
            return true;
        }
    }
    /*-------------------------------------------------------------------
    *@function User birthday
    *-------------------------------------------------------------------*/
    public function getAnniversary()
    {

        $this->db->select("id,distributor_name as name, distributor_mobile as mobile, distributor_email as email ,token");
        $this->db->from("tbldistributors");
        $this->db->where("month(distributor_doj)",date("m"));
        $this->db->where("day(distributor_doj)",date("d"));
        $distributor =  $this->db->get()->result_array();
        $this->db->select("id,dealer_name as name, dealer_mobile as mobile, dealer_email as email ,token");
        $this->db->from("tbldealer");
        $this->db->where("month(dealer_doj)",date("m"));
        $this->db->where("day(dealer_doj)",date("d"));
        $dealer =  $this->db->get()->result_array();
        $this->db->select("id,plumber_name as name, plumber_mobile as mobile, plumber_email as email ,token");
        $this->db->from("tblplumber");
        $this->db->where("month(plumber_doj)",date("m"));
        $this->db->where("day(plumber_doj)",date("d"));
        $plumber=  $this->db->get()->result_array();
        $data=[];
        if (count($distributor)>0) {
            foreach ($distributor as $value) {
                $value['type'] = "distributor";
                $data[]=$value;
            }
        }
        if (count($dealer)) {
            foreach ($dealer as $dvalue) {
                $dvalue['type'] = "dealer";
                $data[]=$dvalue;
            }
        }
        if(count($plumber)){
            foreach ($plumber as $pvalue) {
                $pvalue['type'] = "plumber";
                $data[]=$pvalue;
            }
        }
        if (count($data)>0) {
            $message='Wish You a Very happy Anniversary to You';
            foreach ($data as  $val) {
                $smsdata['moblie_no'] = $val['mobile'];
                $smsdata['message'] = 'Hi,%20%207861%20%20is%20the%20OTP%20(One%20Time%20Password)%20to%20open%20your%20application.%20For%20security%20reasons,%20do%20not%20share%20your%20OTP%20with%20anyone.%20Regards,%20KPT%20PIPES';
                // send_sms($smsdata);
                if ($val['email']!="") {
                    // send_mail($val['emal'],'Happy Anniversary',$message);
                }
                if ($val['token']!="") {
                    sendNotifications($val['token'],$message,'Happy Anniversary');
                }
                $notidata['type']=$val['type'];
                $notidata['description']=$message;
                $data=$val['type'].'-'.$val['id'];
                $notidata['link']='greeting/'.base64_encode($data);
                $notidata['touserid']=$val['id'];
                $notidata['noti_type']='Anniversary';
                $this->Common_model->add_article(db_prefix().'notifications',$notidata);
            }
            return true;
        }else{
            return true;
        }
    }
}
