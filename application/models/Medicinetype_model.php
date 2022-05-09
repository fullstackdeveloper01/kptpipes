<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Medicinetype_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'type_of_medicines');
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
        $this->db->insert(db_prefix() . 'type_of_medicines', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New type_of_medicines Added [id: ' . $insert_id . ']');
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
        $this->db->update(db_prefix() . 'type_of_medicines', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('type_of_medicines Updated [id: ' . $id . ']');

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
        $this->db->delete(db_prefix() . 'type_of_medicines');
        if ($this->db->affected_rows() > 0) {
            
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'type_of_medicines');
            $attachment = $this->db->get(db_prefix() . 'files')->row();
    
            if ($attachment) {
                if (empty($attachment->external)) {
                    $relPath  = get_upload_path_by_type('type_of_medicines') . $attachment->rel_id . '/';
                    $fullPath = $relPath . $attachment->file_name;
                    unlink($fullPath);
                }
    
                $this->db->where('id', $attachment->id);
                $this->db->delete(db_prefix() . 'files');
                if ($this->db->affected_rows() > 0) {
                    $deleted = true;
                    //log_activity('type_of_medicines Attachment Deleted [type_of_medicinesID: ' . $attachment->rel_id . ']');
                }
    
                if (is_dir(get_upload_path_by_type('type_of_medicines') . $attachment->rel_id)) {
                    // Check if no attachments left, so we can delete the folder also
                    $other_attachments = list_files(get_upload_path_by_type('type_of_medicines') . $attachment->rel_id);
                    if (count($other_attachments) == 0) {
                        // okey only index.html so we can delete the folder also
                        delete_dir(get_upload_path_by_type('type_of_medicines') . $attachment->rel_id);
                    }
                }
            }
            
            log_activity('type_of_medicines Deleted [id: ' . $id . ']');

            return true;
        }
        return false;
    }
}
