<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Location_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'country');
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
    public function add_locationCountry($data)
    {
        $this->db->insert(db_prefix() . 'country', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Country Added [id: ' . $insert_id . ']');
        }
        return $insert_id;
    }

    /**
     * Update locationmake
     * @param  array $data locationmake data
     * @param  mixed $id   id
     * @return boolean
     */
    public function update_locationCountry($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'country', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Country Updated [id: ' . $id . ']');
            return true;
        }
        return false;
    }

    /**
     * Delete locationmake from database and all locationmake connections
     * @param  mixed $id locationmake ID
     * @return boolean
     */
    public function delete_locationCountry($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'country');
        if ($this->db->affected_rows() > 0) {
            
            log_activity('Country Deleted [id: ' . $id . ']');

            return true;
        }

        return false;
    }

    /**
     * Delete locationmake from database and all locationmake connections
     * @param  mixed $id locationmake ID
     * @return boolean
     */
    public function delete_state($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'state');
        if ($this->db->affected_rows() > 0) {
            
            log_activity('State Deleted [id: ' . $id . ']');

            return true;
        }

        return false;
    }
    
    /**
     * Delete locationmake from database and all locationmake connections
     * @param  mixed $id locationmake ID
     * @return boolean
     */
    public function delete_locationCity($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'city');
        if ($this->db->affected_rows() > 0) {
            
            log_activity('City Deleted [id: ' . $id . ']');

            return true;
        }

        return false;
    }
    /**
     * Delete locationmake from database and all locationmake connections
     * @param  mixed $id locationmake ID
     * @return boolean
     */
    public function delete_locationArea($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'area');
        if ($this->db->affected_rows() > 0) {
            
            log_activity('Area Deleted [id: ' . $id . ']');

            return true;
        }

        return false;
    }
}
