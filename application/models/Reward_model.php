<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reward_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'reward');
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
        $this->db->insert(db_prefix() . 'reward', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New reward Added [id: ' . $insert_id . ']');
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
        $this->db->insert(db_prefix().'reward',$data);
        if ($this->db->affected_rows() > 0) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'reward', ['status'=>0,'isDeleted'=>1]);
            log_activity('reward Updated [id: ' . $id . ']');

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
        // $this->db->where('id', $id);
        // $this->db->delete(db_prefix() . 'reward');
    	$data['status'] = 0;
        $data['isDeleted'] = 1;
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'reward', $data);
        return true;
    }

    public function getrewardValue($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix().'reward_value');
        return $this->db->get()->result();
    }

    public function add_rewardValue($data)
    {
        $this->db->insert(db_prefix() . 'reward_value', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New reward value Added [id: ' . $insert_id . ']');
        }

        return $insert_id;
    }

    public function update_rewardValue($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'reward_value', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('reward value Updated [id: ' . $id . ']');

            return true;
        }

        return false;
    }
}
