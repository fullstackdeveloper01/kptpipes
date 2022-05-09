<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Area_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'area_new');
        if($id)
        {
            $this->db->where('id', $id);
        }
        return $this->db->get()->row();
    }

    /**
     * Add new locationmake
     * @param array $data locationmake data
     */
    public function add_area($data)
    {
        $this->db->insert(db_prefix() . 'area_new', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Area Added [id: ' . $insert_id . ']');
        }
        return $insert_id;
    }

    /**
     * Update locationmake
     * @param  array $data locationmake data
     * @param  mixed $id   id
     * @return boolean
     */
    public function update_area($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'area_new', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Area Updated [id: ' . $id . ']');
            return true;
        }
        return false;
    }

    /**
     * Delete locationmake from database and all locationmake connections
     * @param  mixed $id locationmake ID
     * @return boolean
     */
    public function delete_area($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'area_new');
        if ($this->db->affected_rows() > 0) {
            
            log_activity('Area Deleted [id: ' . $id . ']');

            return true;
        }

        return false;
    }
}
