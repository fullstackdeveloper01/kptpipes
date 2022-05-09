<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Slider_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'slider');
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
        $this->db->insert(db_prefix() . 'slider', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New slider Added [id: ' . $insert_id . ']');
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
        $this->db->update(db_prefix() . 'slider', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('slider Updated [id: ' . $id . ']');

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
        $this->db->delete(db_prefix() . 'slider');
        if ($this->db->affected_rows() > 0) {
            
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'slider');
            $attachment = $this->db->get(db_prefix() . 'files')->row();
    
            if ($attachment) {
                if (empty($attachment->external)) {
                    $relPath  = 'uploads/slider/' . $attachment->rel_id . '/';
                    $fullPath = $relPath . $attachment->file_name;
                    unlink($fullPath);
                }
    
                $this->db->where('id', $attachment->id);
                $this->db->delete(db_prefix() . 'files');
                if ($this->db->affected_rows() > 0) {
                    $deleted = true;
                }
    
            }
            
            log_activity('slider Deleted [id: ' . $id . ']');
            return true;
        }
        return false;
    }
    
    /**
    *   @Function: Update slider, image remove
    */
    public function delete_image($id)
    {
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'slider');
        $attachment = $this->db->get(db_prefix() . 'files')->row();

        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = 'uploads/slider/' . $attachment->rel_id . '/';
                $fullPath = $relPath . $attachment->file_name;
                unlink($fullPath);
            }

            $this->db->where('id', $attachment->id);
            $this->db->delete(db_prefix() . 'files');
            if ($this->db->affected_rows() > 0) {
                $deleted = true;
            }

        }
        
        log_activity('slider Deleted [id: ' . $id . ']');
        return true;
    }
}
