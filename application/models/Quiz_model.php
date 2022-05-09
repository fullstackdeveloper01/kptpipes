<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Quiz_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'quiz');
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
        $postdata = [];
        if($data['required'] == 'on')
        {
            $postdata['required'] = 'Yes';
        }
        else
        {
            $postdata['required'] = 'No';
        }
        /*
        if($data['category_id'] != '')
        {
            $postdata['category_id'] = $data['category_id'];
        }
        $postdata['sub_category_id'] = $data['sub_category_id'];
        */
        $postdata['question']        = $data['question'];
        $postdata['options']         = json_encode($data['options']);
        $postdata['dosha']         = json_encode($data['dosha']);
        $postdata['weightage']         = json_encode($data['weightage']);
        $postdata['answer']          = implode(',',$data['answer']);
        $postdata['category']        = implode(',',$data['category']);
        $postdata['gender']          = $data['gender'];
       // $postdata['weightage']       = $data['weightage'];
        // echo '<pre>';
        //  print_r($postdata); 
       // echo '/////y';
        //die;
         $insert_id = '';
        if($postdata['question'] != '' && $postdata['options'] != ''  && $postdata['category'] != '' && $postdata['gender'] != '' && $postdata['weightage'] != '')
        {
            $this->db->insert(db_prefix() . 'quiz', $postdata);
          //  echo $this->db->last_query(); die;
            $insert_id = $this->db->insert_id();
            if ($insert_id) {
                log_activity('New quiz added [id: ' . $insert_id . ']');
            }
        }
       // die;
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
        $postdata = [];
        if($data['required'] == 'on')
        {
            $postdata['required'] = 'Yes';
        }
        else
        {
            $postdata['required'] = 'No';
        }
        /*
        if($data['category_id'] != '')
        {
            $postdata['category_id'] = $data['category_id'];
        }
        $postdata['sub_category_id'] = $data['sub_category_id'];
        */
        $postdata['question']        = $data['question'];
        $postdata['options']         = json_encode($data['options']);
        
        $postdata['answer']          = implode(',',$data['answer']);
        $postdata['category']        = implode(',',$data['category']);
        $postdata['gender']          = $data['gender'];
        $postdata['weightage']       = $data['weightage'];
        //echo $id; echo '<pre>'; print_r($postdata); die;
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'quiz', $postdata);
        if ($this->db->affected_rows() > 0) {
            log_activity('Quiz Updated [id: ' . $id . ']');
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
        $this->db->delete(db_prefix() . 'quiz');
        if ($this->db->affected_rows() > 0) {
            log_activity('quiz Deleted [id: ' . $id . ']');
            return true;
        }
        return false;
    }
}
