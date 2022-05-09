<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table,$where)
    {
        $this->db->select('*');
        $this->db->from($table);
        if($where)
        {
            $this->db->where($where);
        }
        return $this->db->get()->row();
    }

    /**
     * Add new article
     * @param array $data article data
     */
    public function add_article($table,$data)
    {
        // echo $table;die;
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New User Added [id: ' . $insert_id . ']');
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
        $this->db->update(db_prefix() . 'advertisement', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('advertisement Updated [id: ' . $id . ']');

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
        $this->db->delete(db_prefix() . 'advertisement');
        if ($this->db->affected_rows() > 0) {
            
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'advertisement');
            $attachment = $this->db->get(db_prefix() . 'files')->row();
    
            if ($attachment) {
                if (empty($attachment->external)) {
                    $relPath  = 'uploads/advertisement/' . $attachment->rel_id . '/';
                    $fullPath = $relPath . $attachment->file_name;
                    unlink($fullPath);
                }
    
                $this->db->where('id', $attachment->id);
                $this->db->delete(db_prefix() . 'files');
                if ($this->db->affected_rows() > 0) {
                    $deleted = true;
                }
    
            }
            
            log_activity('advertisement Deleted [id: ' . $id . ']');
            return true;
        }
        return false;
    }
    
    /**
    *   @Function: Update advertisement, image remove
    */
    public function delete_image($id)
    {
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'advertisement');
        $attachment = $this->db->get(db_prefix() . 'files')->row();

        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = 'uploads/advertisement/' . $attachment->rel_id . '/';
                $fullPath = $relPath . $attachment->file_name;
                unlink($fullPath);
            }

            $this->db->where('id', $attachment->id);
            $this->db->delete(db_prefix() . 'files');
            if ($this->db->affected_rows() > 0) {
                $deleted = true;
            }

        }
        
        log_activity('advertisement Deleted [id: ' . $id . ']');
        return true;
    }


    public function update($table,$data, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('data Updated [id: ' . $id . ']');

            return true;
        }
        return false;
    }

    /* this function is for to select data count sums*/

    public function CountSums($table_name , $where_array,$column)
    {
        $this->db->select('SUM('.$column.') as '.$column.'');
        $this->db->from($table_name);
        if ($where_array!="")
        {
            $this->db->where($where_array);
        }
        $res= $this->db->get()->row($column);
        if ($res != null) {
           return $res;
        }else{
            return 0;
        }
    }

    /* this function is for to select data count any table*/

    public function Insert($table_name , $data)
    {
        return $this->db->insert($table_name,$data);
    }
}
