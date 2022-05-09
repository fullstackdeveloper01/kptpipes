<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Essentialphrases_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'essential_phrases');
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
        $postData['name'] = $data['name'];
        $parantID = $data['parent_id'];
        if($parantID != '')
        {
            $postData['parent_id'] = $parantID;
        }
        else
        {
            $postData['parent_id'] = 0;
        }
        if($data['description'])
        {
            $postData['description'] = $data['description'];;
        }
        $this->db->insert(db_prefix() . 'essential_phrases', $postData);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New essential_phrases Added [id: ' . $insert_id . ']');
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
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'essential_phrases', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('essential_phrases Updated [id: ' . $id . ']');

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
        $this->db->delete(db_prefix() . 'essential_phrases');
        if ($this->db->affected_rows() > 0) {
            
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'essential');
            $attachment = $this->db->get(db_prefix() . 'files')->row();
    
            if ($attachment) {
                if (empty($attachment->external)) {
                    $relPath  = get_upload_path_by_type('essential') . $attachment->rel_id . '/';
                    $fullPath = $relPath . $attachment->file_name;
                    unlink($fullPath);
                }
    
                $this->db->where('id', $attachment->id);
                $this->db->delete(db_prefix() . 'files');
                if ($this->db->affected_rows() > 0) {
                    $deleted = true;
                }
            }
            log_activity('Essential Phrases Deleted [id: ' . $id . ']');
            return true;
        }
        return false;
    }
}
