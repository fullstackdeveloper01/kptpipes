<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Listen extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('listen_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('listen', '', 'view')) {
            access_denied('listen');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('listen');
        }
       
        $sheader_text = title_text('aside_menu_active', 'listen');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $data['category_result'] = $this->db->get_where(db_prefix().'category', array('status' => 1, 'parent_id' => 0))->result();
        $data['phrases_result'] = $this->db->get_where(db_prefix().'essential_phrases', array('status' => 1, 'parent_id' => 0))->result();
        $data['language_result'] = $this->db->get_where(db_prefix().'language', array('status' => 1))->result();
        $this->load->view('admin/listen/listens', $data);
    }

    /* selcetCategory */
    public function selcetCategory()
    {
        $profileResult = [];
        $catid = $_POST['catid'];
        $profileResult = $this->db->get_where(db_prefix().'category', array('parent_id' => $catid))->result();
        echo json_encode($profileResult);
    }
    
    /* selcetPhrases */
    public function selcetPhrases()
    {
        $profileResult = [];
        $catid = $_POST['catid'];
        $profileResult = $this->db->get_where(db_prefix().'essential_phrases', array('parent_id' => $catid))->result();
        echo json_encode($profileResult);
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('listen', '', 'view')) {
            access_denied('listen');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('listen', '', 'create')) {
                    access_denied('listen');
                }
                $id = $this->listen_model->add_article($data);
                if ($id) {
                    if($_FILES)
                    {
                        //echo '<pre>'; print_r($_FILES['listenuser1']['name']); die; 
                        if($_FILES['listenfile']['name'] != '')
                        {
                            $uploadedFiles_ = handle_task_attachments_array($id,'listenfile');
                            if ($uploadedFiles_ && is_array($uploadedFiles_)) {
                                foreach ($uploadedFiles_ as $file) {
                                    $this->misc_model->add_attachment_to_database($id, 'listenfile', [$file]);
                                }
                            }
                        }
                        /*
                        if($_FILES['listenuser1']['name'] != ''){
                            $uploadedFiles_1 = handle_task_attachments_array($id,'listenuser1');
                            if ($uploadedFiles_1 && is_array($uploadedFiles_1)) {
                                foreach ($uploadedFiles_1 as $file) {
                                    $this->misc_model->add_attachment_to_database($id, 'listenuser1', [$file]);
                                }
                            }
                        }
                        if($_FILES['listenuser2']['name'] != ''){
                            $uploadedFiles_2 = handle_task_attachments_array($id,'listenuser2');
                            if ($uploadedFiles_2 && is_array($uploadedFiles_2)) {
                                foreach ($uploadedFiles_2 as $file) {
                                    $this->misc_model->add_attachment_to_database($id, 'listenuser2', [$file]);
                                }
                            }
                        }
                        */
                    }
                    set_alert('success', _l('added_successfully', _l('Listen')));
                    redirect(admin_url('listen'));
                }
            } else {
                if (!has_permission('listen', '', 'edit')) {
                    access_denied('listen');
                }
                $success = $this->listen_model->update_article($data, $id);
                if($_FILES)
                {
                    if($_FILES['listenfile']['name'] != '')
                    {
                        $this->db->where('rel_id', $id);
                        $this->db->where('rel_type', 'listenfile');
                        $attachment = $this->db->get(db_prefix() . 'files')->row();
                
                        if ($attachment) {
                            if (empty($attachment->external)) {
                                $relPath  = get_upload_path_by_type('listenfile') . $attachment->rel_id . '/';
                                $fullPath = $relPath . $attachment->file_name;
                                unlink($fullPath);
                            }
                
                            $this->db->where('id', $attachment->id);
                            $this->db->delete(db_prefix() . 'files');
                            if ($this->db->affected_rows() > 0) {
                                $deleted = true;
                            }
                        }
                        
                        $uploadedFiles_ = handle_task_attachments_array($id,'listenfile');
                        if ($uploadedFiles_ && is_array($uploadedFiles_)) {
                            foreach ($uploadedFiles_ as $file) {
                                $this->misc_model->add_attachment_to_database($id, 'listenfile', [$file]);
                            }
                        }
                    }
                    /*
                    if($_FILES['listenuser1']['name'] != '')
                    {
                        $this->db->where('rel_id', $id);
                        $this->db->where('rel_type', 'listenuser1');
                        $attachment = $this->db->get(db_prefix() . 'files')->row();
                
                        if ($attachment) {
                            if (empty($attachment->external)) {
                                $relPath  = get_upload_path_by_type('listenuser1') . $attachment->rel_id . '/';
                                $fullPath = $relPath . $attachment->file_name;
                                unlink($fullPath);
                            }
                
                            $this->db->where('id', $attachment->id);
                            $this->db->delete(db_prefix() . 'files');
                            if ($this->db->affected_rows() > 0) {
                                $deleted = true;
                            }
                        }
                        
                        $uploadedFiles_1 = handle_task_attachments_array($id,'listenuser1');
                        if ($uploadedFiles_1 && is_array($uploadedFiles_1)) {
                            foreach ($uploadedFiles_1 as $file) {
                                $this->misc_model->add_attachment_to_database($id, 'listenuser1', [$file]);
                            }
                        }
                    }
                    if($_FILES['listenuser2']['name'] != '')
                    {
                        $this->db->where('rel_id', $id);
                        $this->db->where('rel_type', 'listenuser2');
                        $attachment = $this->db->get(db_prefix() . 'files')->row();
                
                        if ($attachment) {
                            if (empty($attachment->external)) {
                                $relPath  = get_upload_path_by_type('listenuser2') . $attachment->rel_id . '/';
                                $fullPath = $relPath . $attachment->file_name;
                                unlink($fullPath);
                            }
                
                            $this->db->where('id', $attachment->id);
                            $this->db->delete(db_prefix() . 'files');
                            if ($this->db->affected_rows() > 0) {
                                $deleted = true;
                            }
                        }
                        
                        $uploadedFiles_2 = handle_task_attachments_array($id,'listenuser2');
                        if ($uploadedFiles_2 && is_array($uploadedFiles_2)) {
                            foreach ($uploadedFiles_2 as $file) {
                                $this->misc_model->add_attachment_to_database($id, 'listenuser2', [$file]);
                            }
                        }
                    }
                     */   
                }
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Listen')));
                }
                redirect(admin_url('listen'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Listen'));
        } else {
            $article         = $this->listen_model->get($id);
           // echo '<pre>'; print_r($article); die;
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'listen');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['userlist'] = $this->db->get_where(db_prefix().'listen_name')->result(); 
        $data['category_result'] = $this->db->get_where(db_prefix().'category', array('status' => 1, 'parent_id' => 0))->result();
        $data['phrases_result'] = $this->db->get_where(db_prefix().'essential_phrases', array('status' => 1, 'parent_id' => 0))->result();
        $data['language_result'] = $this->db->get_where(db_prefix().'language', array('status' => 1))->result();
        $data['title']     = _l($subheader_text);
        $this->load->view('admin/listen/listen', $data);
    }
    
    /* addaudiofile */
    public function addaudiofile()
    {
        $data = $this->input->post();
        // echo '<pre>'; print_r($data); die;
        if($data['name1'] != '')
        {
           $post1['name'] = $data['name1'];
           $this->db->where('id', 1);
           $this->db->update(db_prefix().'listen', $post1);
        }
        if($data['name2'] != '')
        {
           $post2['name'] = $data['name2'];
           $this->db->where('id', 2);
           $this->db->update(db_prefix().'listen', $post2);
        }
        if($_FILES)
        {
            $this->db->where('rel_id', 1);
            $this->db->where('rel_type', 'listenfile');
            $attachment = $this->db->get(db_prefix() . 'files')->row();
    
            if ($attachment) {
                if (empty($attachment->external)) {
                    $relPath  = get_upload_path_by_type('listenfile') . $attachment->rel_id . '/';
                    $fullPath = $relPath . $attachment->file_name;
                    unlink($fullPath);
                }
    
                $this->db->where('id', $attachment->id);
                $this->db->delete(db_prefix() . 'files');
                if ($this->db->affected_rows() > 0) {
                    $deleted = true;
                    //log_activity('listen Attachment Deleted [listenID: ' . $attachment->rel_id . ']');
                }
            }
            
            $uploadedFiles_ = handle_task_attachments_array($id,'listenfile');
            if ($uploadedFiles_ && is_array($uploadedFiles_)) {
                foreach ($uploadedFiles_ as $file) {
                    $this->misc_model->add_attachment_to_database($id, 'listenfile', [$file]);
                }
            }
            
        }
        set_alert('success', _l('added_successfully', _l('Listen')));
        redirect(admin_url('listen'));
    }

    /* Delete article from database */
    public function delete_listen($id)
    {
        if (!has_permission('listen', '', 'delete')) {
            access_denied('listen');
        }
        if (!$id) {
            redirect(admin_url('listen'));
        }
        $response = $this->listen_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Listen')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Listen')));
        }
        redirect(admin_url('listen'));
    }
}
