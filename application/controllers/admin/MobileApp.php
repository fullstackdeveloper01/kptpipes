<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MobileApp extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('mobileapp_model');
    }

    /* List all articles */
    public function index()
    {
        if (!has_permission('mobileApp', '', 'view')) {
            access_denied('mobileApp');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('mobileApp');
        }
       
        $sheader_text = title_text('aside_menu_active', 'mobileApp');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['activemenu'] = 'splash';
        $data['mobileapp_result'] = $this->db->get_where(db_prefix().'mobile_app')->row();
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/mobileApp/mobileApps', $data);
    }
    
    /**
    *   @Function: add
    **/
    public function add()
    {
        $name = $_FILES["splash_screen"]["name"];
        if($name)
        {
            $ext  = end((explode(".", $name)));
            $logoname = 'splashscreen.'.$ext;
            
            $allowed = array('pdf', 'png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'txt');
            $filename = $_FILES['splash_screen']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
               set_alert('error', _l('file extention are not allow!'));
            }
            else
            {
                move_uploaded_file($_FILES["splash_screen"]['tmp_name'], 'uploads/mobileApp/'.$logoname);
                $postData['create_at'] = date('Y-m-d h:i:s');
                $postData['splash_screen'] = $logoname;
                $lastid = $this->db->get_where(db_prefix().'mobile_app')->row('id');
                if($lastid)
                {
                    $this->db->where('id', $lastid);
                    $this->db->update(db_prefix().'mobile_app', $postData);
                }
                else
                {
                    $this->db->insert(db_prefix().'mobile_app', $postData);
                }
                
                set_alert('success', _l('Splash Screen added successful'));
            }
        }
        redirect(admin_url('mobileApp'));
    }
    
    /**
    *   @Function: introAdd
    **/
    public function introAdd()
    {
        $imgarr = $this->db->get_where(db_prefix().'mobile_app')->row();
        $imgcount = explode(',',$imgarr->intro_img);
        $textcount = explode(',',$imgarr->intro_text);
        $lastimg = count($imgcount);
        if($lastimg == '' || $lastimg == 0)
        {
            $lastimg = 1;
        }
        else
        {
            $lastimg = time();
        }
        $name = $_FILES["intro_img"]["name"];
        if($name)
        {
            $ext  = end((explode(".", $name)));
            $logoname = 'intro_img_'.$lastimg.'.'.$ext;
            
            $allowed = array('pdf', 'png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'txt');
            $filename = $_FILES['intro_img']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
               set_alert('error', _l('file extention are not allow!'));
            }
            else
            {
                move_uploaded_file($_FILES["intro_img"]['tmp_name'], 'uploads/mobileApp/'.$logoname);
                //$postData['create_at'] = date('Y-m-d h:i:s');
                
                //$lastid = $this->db->get_where(db_prefix().'mobile_app')->row('id');
                if($imgarr)
                {
                    if($imgcount)
                    {
                        $intro_text = $this->input->post('intro_text');
                        $postData['intro_img'] = $imgarr->intro_img.','.$logoname;
                        $postData['intro_text'] = $imgarr->intro_text.','.$intro_text;
                    }
                    else
                    {
                        $postData['intro_img'] = $logoname;
                        $postData['intro_text'] = $imgarr->intro_text.','.$intro_text;
                    }
                    
                    $this->db->where('id', $imgarr->id);
                    $this->db->update(db_prefix().'mobile_app', $postData);
                }
                else
                {
                    $postData['create_at'] = date('Y-m-d h:i:s');
                    $intro_text = $this->input->post('intro_text');
                    $postData['intro_img'] = $logoname;
                    $postData['intro_text'] = $intro_text;
                    $this->db->insert(db_prefix().'mobile_app', $postData);
                }
                
                set_alert('success', _l('Intro image added successful'));
            }
        }
        redirect(admin_url('mobileApp/intro'));
    }
    
    /**
    * Function intro
    **/
    public function intro()
    {
        if (!has_permission('mobileApp', '', 'view')) {
            access_denied('mobileApp');
        }
       
        $sheader_text = title_text('aside_menu_active', 'mobileApp');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['activemenu'] = 'intro';
        $data['mobileapp_result'] = $this->db->get_where(db_prefix().'mobile_app')->row();
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/mobileApp/mobileAppIntro', $data);
    }
    
    /**
    *   @Function: removeSplash
    */
    public function removeSplash($id = '')
    {
        if($id)
        {
            $path = 'uploads/mobileApp/'.$id;
            unlink($path);
            $data['splash_screen'] = '';
            $this->db->where('splash_screen', $id);
            $this->db->update(db_prefix().'mobile_app', $data);
            
            set_alert('success', _l('Splash Screen remove'));
            redirect(admin_url('mobileApp'));
        }
    }
    
    /**
    *   @Function: removeIntro
    */
    public function removeIntro($id = '', $ids = '')
    {
        if($id)
        {
            $path = 'uploads/mobileApp/'.$id;
            if($path)
            {
                unlink($path);
            }
            $intro_imgstr = $this->db->get_where(db_prefix().'mobile_app')->row('intro_img');
            $intro_imgarr = explode(',',$intro_imgstr);
            if (($key = array_search($id, $intro_imgarr)) !== false) {
                unset($intro_imgarr[$key]);
            }
            $introimgstr = implode(',',$intro_imgarr);
            $data['intro_img'] = $introimgstr;
            $this->db->where('id', $ids);
            $this->db->update(db_prefix().'mobile_app', $data);
            
            set_alert('success', _l('Intro image remove'));
            redirect(admin_url('mobileApp/intro'));
        }
    }

    /* Add new article or edit existing*//*
    public function add($id = '')
    {
        if (!has_permission('mobileApp', '', 'view')) {
            access_denied('mobileApp');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('mobileApp', '', 'create')) {
                    access_denied('mobileApp');
                }
                $id = $this->mobileapp_model->add_article($data);
                if ($id) {
                    
                    $uploadedFiles = handle_task_attachments_array($id,'mobileAppimg');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'mobileAppimg', [$file]);
                        }
                    }
                    $uploadedFiles_ = handle_task_attachments_array($id,'mobileAppfile');
                    if ($uploadedFiles_ && is_array($uploadedFiles_)) {
                        foreach ($uploadedFiles_ as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'mobileAppfile', [$file]);
                        }
                    }
                    
                    set_alert('success', _l('added_successfully', _l('Audio book')));
                    redirect(admin_url('mobileApp'));
                }
            } else {
                if (!has_permission('mobileApp', '', 'edit')) {
                    access_denied('mobileApp');
                }
                $success = $this->mobileapp_model->update_article($data, $id);
                
                $uploadedFiles = handle_task_attachments_array($id,'mobileAppimg');
                if ($uploadedFiles && is_array($uploadedFiles)) {
                    foreach ($uploadedFiles as $file) {
                        $this->misc_model->add_attachment_to_database($id, 'mobileAppimg', [$file]);
                    }
                }
                $uploadedFiles_ = handle_task_attachments_array($id,'mobileAppfile');
                if ($uploadedFiles_ && is_array($uploadedFiles_)) {
                    foreach ($uploadedFiles_ as $file) {
                        $this->misc_model->add_attachment_to_database($id, 'mobileAppfile', [$file]);
                    }
                }
                
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Audio book')));
                }
                redirect(admin_url('mobileApp'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Audio book'));
        } else {
            $article         = $this->mobileapp_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'mobileApp');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($subheader_text);
        $this->load->view('admin/mobileApp/mobileApp', $data);
    }*/

    /* Delete article from database *//*
    public function delete_mobileApp($id)
    {
        if (!has_permission('mobileApp', '', 'delete')) {
            access_denied('mobileApp');
        }
        if (!$id) {
            redirect(admin_url('mobileApp'));
        }
        $response = $this->mobileapp_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Audio book')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Audio book')));
        }
        redirect(admin_url('mobileApp'));
    }*/
}
