<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Immunity_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . '_immunity');
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
        $this->db->insert(db_prefix() . '_immunity', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New immunity added [id: ' . $insert_id . ']');
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
        $this->db->update(db_prefix() . '_immunity', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('immunity Updated [id: ' . $id . ']');
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
        $this->db->delete(db_prefix() . '_immunity');
        if ($this->db->affected_rows() > 0) {
            log_activity('immunity Deleted [id: ' . $id . ']');
            return true;
        }
        return false;
    }
}
