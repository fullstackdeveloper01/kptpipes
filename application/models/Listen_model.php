<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Listen_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'listen');
        if($id)
        {
            $this->db->where('id', $id);
        }
        return $this->db->get()->row();
    }

    /**
     * Add new article
     * @param array $data article data
     */
    public function add_article($data)
    {
        //echo '<pre>'; print_r($data);die;
        $postData['category_id'] = $data['category_id'];
        $postData['sub_category_id'] = $data['sub_category_id'];
        $postData['phrasesID'] = $data['phrasesID'];
        $postData['subPhrasesID'] = $data['subPhrasesID'];
        $postData['user_id'] = @$data['user_id'];
        $postData['message'] = $data['message'];
        
        $this->db->insert(db_prefix() . 'listen', $postData);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $languageres = $this->db->select('id')->get_where(db_prefix().'language', array('status' => 1))->result();
            foreach($languageres as $rrr)
            {
                $post['language_id'] = $data['language_'.$rrr->id];
                $post['message'] = $data['message_'.$rrr->id];
                $post['listen_id'] = $insert_id;
                $post['category_id'] = $data['category_id'];
                $post['sub_category_id'] = $data['sub_category_id'];
                $post['user_id'] = @$data['user_id'];
                $this->db->insert(db_prefix() . 'listen_translate', $post);
                $post = '';
            }
            
            log_activity('New listen added [id: ' . $insert_id . ']');
        }
        return $insert_id;
    }

    /**
     * Update article
     * @param  array $data article data
     * @param  mixed $id   id
     * @return boolean
     */
    public function update_article($data, $id)
    {
        $postData['category_id'] = $data['category_id'];
        $postData['sub_category_id'] = $data['sub_category_id'];
        
        $postData['phrasesID'] = $data['phrasesID'];
        $postData['subPhrasesID'] = $data['subPhrasesID'];
        
        $postData['user_id'] = $data['user_id'];
        $postData['message'] = $data['message'];
        //echo '<pre>'; print_r($data); die;
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'listen', $postData);
        
        $languageres = $this->db->select('id')->get_where(db_prefix().'language', array('status' => 1))->result();
        foreach($languageres as $rrr)
        {
            $language_id = $data['language_'.$rrr->id];
            $post['message'] = $data['message_'.$rrr->id];
            $post['category_id'] = $data['category_id'];
            $post['sub_category_id'] = $data['sub_category_id'];
            $post['user_id'] = @$data['user_id'];
            $editlanguage = $this->db->get_where(db_prefix().'listen_translate', array('language_id' => $language_id, 'listen_id' => $id))->num_rows();
            if($editlanguage > 0)
            {
                $this->db->where('listen_id', $id);
                $this->db->where('language_id', $language_id);
                $this->db->update(db_prefix() . 'listen_translate', $post);
            }
            else
            {
                $post['language_id'] = $data['language_'.$rrr->id];
                $post['listen_id'] = $id;
                $this->db->insert(db_prefix() . 'listen_translate', $post);
            }
            $post = '';
            $language_id = '';
        }
        if ($this->db->affected_rows() > 0) {
            log_activity('listen Updated [id: ' . $id . ']');
            return true;
        }
        return false;
    }

    /**
     * Delete article from database and all article connections
     * @param  mixed $id article ID
     * @return boolean
     */
    public function delete_article($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'listen');
        if ($this->db->affected_rows() > 0) {
            
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
                    //log_activity('listen Attachment Deleted [listenID: ' . $attachment->rel_id . ']');
                }
            }
            
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'listenuser1');
            $attachment1 = $this->db->get(db_prefix() . 'files')->row();
    
            if ($attachment1) {
                if (empty($attachment1->external)) {
                    $relPath  = get_upload_path_by_type('listenuser1') . $attachment1->rel_id . '/';
                    $fullPath = $relPath . $attachment1->file_name;
                    unlink($fullPath);
                }
    
                $this->db->where('id', $attachment1->id);
                $this->db->delete(db_prefix() . 'files');
                if ($this->db->affected_rows() > 0) {
                    $deleted = true;
                    //log_activity('listen Attachment Deleted [listenID: ' . $attachment->rel_id . ']');
                }
            }
            
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'listenuser2');
            $attachment2 = $this->db->get(db_prefix() . 'files')->row();
    
            if ($attachment2) {
                if (empty($attachment2->external)) {
                    $relPath  = get_upload_path_by_type('listenuser2') . $attachment2->rel_id . '/';
                    $fullPath = $relPath . $attachment2->file_name;
                    unlink($fullPath);
                }
    
                $this->db->where('id', $attachment2->id);
                $this->db->delete(db_prefix() . 'files');
                if ($this->db->affected_rows() > 0) {
                    $deleted = true;
                    //log_activity('listen Attachment Deleted [listenID: ' . $attachment->rel_id . ']');
                }
            }
            
            log_activity('listen Deleted [id: ' . $id . ']');
            return true;
        }
        return false;
    }
}
