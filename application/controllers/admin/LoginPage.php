<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LoginPage extends AdminController
{
    /* List all staff roles */
    public function index()
    {
        if (!has_permission('loginPage', '', 'view')) {
            access_denied('loginPage');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('login_setting');
        }
        
        $sheader_text = title_text('setup_menu_active', 'login');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        if ($this->input->post()) {
            $name = $_FILES["background_image"]["name"];
            if($name)
            {
                $ext  = end((explode(".", $name)));
                $logoname = 'back_img_'.time().'.'.$ext;
                $allowed = array('gif', 'png', 'jpg', 'jpeg');
                $filename = $_FILES['background_image']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    set_alert('warning', 'Background file extension are not allowed');
                    redirect(admin_url('loginPage'));
                }
                else
                {
                    move_uploaded_file($_FILES["background_image"]['tmp_name'], 'uploads/loginPage/'.$logoname);
                    $update_['background_image'] = $logoname;
                }     
            }
           
            $name_ = $_FILES["logo_image"]["name"];
            if($name_)
            {
                $ext_  = end((explode(".", $name_)));
                $faviconname = 'logo_'.time().'.'.$ext_;
                $filename_ = $_FILES['logo_image']['name'];
                $allowed = array('gif', 'png', 'jpg', 'jpeg');
                $ext = pathinfo($filename_, PATHINFO_EXTENSION);
                if (!in_array($ext_, $allowed)) {
                    set_alert('warning', 'Logo file extension are not allowed');
                    redirect(admin_url('loginPage'));
                }
                else
                {
                    move_uploaded_file($_FILES["logo_image"]['tmp_name'], 'uploads/loginPage/'.$faviconname);
                    $update_['logo_image'] = $faviconname;
                }
            }
            $update_['background_color'] = $this->input->post('background_color');
            $update_['background_type'] = $this->input->post('background_type');
            $update_['re_captcha_option'] = $this->input->post('re_captcha_option');
            $update_['site_key'] = $this->input->post('site_key');
            $update_['secret_key'] = $this->input->post('secret_key');

            $this->db->where('tbllogin_setting_id', 1);
            $this->db->update('tbllogin_setting', $update_);

            set_alert('success','Login page details update success');
            redirect(admin_url('loginPage'));
        }

        $data['title'] = _l($sheader_text);
       // $this->load->view('admin/loginPage', $data);
       $data['editDetails'] = $this->db->get_where('tbllogin_setting')->row();
        $this->load->view('admin/loginPage/role', $data);
    }

    /*
        @ Recaptcha function
    */
    public function recaptchaValidation($captcha)
    {
        $ch = curl_init();
        $secretKey = $this->db->get_where('site_setting', array('type' => 'captcha_private'))->row('value');
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'secret' => $secretKey,
                'response' => $captcha,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ],
            CURLOPT_RETURNTRANSFER => true
        ]);
        
        $output = curl_exec($ch);
        curl_close($ch);
        
        $json = json_decode($output);
        return $json->success;
    }
}
