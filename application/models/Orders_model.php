<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Orders_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $slug = '')
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'orders');
        if($id)
        {
            $this->db->where('id', $id);
        }
        
        return $this->db->get()->row();
    }

    public function getDetails($id)
    {
        if (!empty($id)) {

            $this->db->select('*');
            $this->db->from(db_prefix() . 'orders');
            $this->db->where('order_id', $id);
            $response = $this->db->get()->result_array();
            
            foreach ($response as $key => $value) {
                $response[$key]['stock']=$this->db->select('*')->from(db_prefix().'stocks')->where(['product_id'=>$value['product_id'],'quantity >'=>0])->get()->result_array();
            }
            return $response;
        }else{
            return false;
        }
    }

    /**
     * Add new article
     * @param array $data article data
     */
    public function add_article($data)
    {
        $this->db->insert(db_prefix() . 'orders', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New orders Added [id: ' . $insert_id . ']');
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
        $this->db->update(db_prefix() . 'orders', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('orders Updated [id: ' . $id . ']');

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
        // $this->db->delete(db_prefix() . 'orders');
    	$data['status'] = 0;
        $data['isDeleted'] = 1;
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'orders', $data);
        return true;
    }

    public function Insert($data)
    {
        $this->db->insert(db_prefix() . 'orders_history', $data);
        $insert_id = $this->db->insert_id();
        $type =$data['type'];
        unset($data['type']);
        unset($data['unit']);
        unset($data['price']);
        $data['ord_history_id']=$insert_id;
        $data['transaction_status']='add';
        $this->db->insert(db_prefix().'distributor_stock_history',$data);
        
        $where['user_id'] = $data['user_id'];
        $where['bach_no'] = $data['bach_no'];
        $where['product_id'] = $data['product_id'];
        $where['type'] = 'distributor';

        $stock = $this->db->get_where(db_prefix().'user_stock',$where)->row('quantity');

        if ($stock != "") {
            $update['quantity']=$stock+$data['quantity'];
            $this->db->where($where)->update(db_prefix().'user_stock',$update);
        }else{
            unset($data['ord_history_id']);
            unset($data['order_id']);
            unset($data['transaction_status']);
            $data['type']=$type;
            $this->db->insert(db_prefix().'user_stock',$data);
        }


        // if ($insert_id) {
        //     log_activity('New orders History Added [id: ' . $insert_id . ']');
        // }
        return $insert_id;
    }

    // public function getordersValue($id = '', $slug = '')
    // {
    //     $this->db->select('*');
    //     $this->db->from(db_prefix().'orders_value');
    //     return $this->db->get()->row();
    // }

    // public function add_ordersValue($data)
    // {
    //     $this->db->insert(db_prefix() . 'orders_value', $data);
    //     $insert_id = $this->db->insert_id();
    //     if ($insert_id) {
    //         log_activity('New orders value Added [id: ' . $insert_id . ']');
    //     }

    //     return $insert_id;
    // }

    // public function update_ordersValue($data, $id)
    // {
    //     $this->db->where('id', $id);
    //     $this->db->update(db_prefix() . 'orders_value', $data);
    //     if ($this->db->affected_rows() > 0) {
    //         log_activity('orders value Updated [id: ' . $id . ']');

    //         return true;
    //     }

    //     return false;
    // }
}
