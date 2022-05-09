<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Communicate_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'communicate');
        if($id)
        {
            $this->db->where('id', $id);
        }
        return $this->db->get()->row();
    }

    /**
     * Add new carmake
     * @param array $data carmake data
     */
    public function add_carmake($data)
    {
        $this->db->insert(db_prefix() . 'communicate', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Make Added [id: ' . $insert_id . ']');
        }
        return $insert_id;
    }

    /**
     * Update carmake
     * @param  array $data carmake data
     * @param  mixed $id   id
     * @return boolean
     */
    public function update_carmake($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'communicate', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Make Updated [id: ' . $id . ']');
            return true;
        }
        return false;
    }

    /**
     * Delete carmake from database and all carmake connections
     * @param  mixed $id carmake ID
     * @return boolean
     */
    public function delete_carmake($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'communicate');
        if ($this->db->affected_rows() > 0) {
            
            log_activity('Make Deleted [id: ' . $id . ']');

            return true;
        }

        return false;
    }
}
