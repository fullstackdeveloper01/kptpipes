<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('order_model');
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    /* List all knowledgebase articles */
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('order');
        }
       
        $sheader_text = title_text('aside_menu_active', 'orders');
        $data['sheading_text'] = $sheader_text;
        $data['heading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $data['order_t'] = $this->db->from(db_prefix().'orders')->where(['user_type'=>'distributor','trash'=>0])->group_by('order_id')->get()->num_rows();
        $response = $this->db->from(db_prefix().'orders')->where(['user_type'=>'distributor','trash'=>0])->group_by('order_id')->get()->result_array();
        $pending=0;
        $complete=0;
        $cancelled=0;
        $accept=0;
        foreach ($response as $key => $value) {
            $ordarr = $this->db->select('status')->from(db_prefix().'orders')->where(['order_id'=>$value['order_id']])->get()->result_array();
            $statusarr=[];
            foreach ($ordarr as $key => $value) {
                $statusarr[]=$value['status'];
            }
            if (in_array(0, $statusarr)) {
                $pending++;
            }elseif (in_array(1, $statusarr)) {
                $accept++;
            }elseif (in_array(2, $statusarr)) {
                $cancelled++;
            }elseif (in_array(3, $statusarr)) {
                $complete++;
            }
        }
        $data['order_p'] = $pending;
        $data['order_a'] = $accept;
        $data['order_d'] = $complete;
        $data['order_c'] = $cancelled;
        $this->load->view('admin/order/orders', $data);
    }

     public function setOrderStatus()
    {

        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $order_id = $this->db->get_where(db_prefix().'orders', array('id' => $id))->row('order_id');
        if($status!='')
        {    
            $data['status']             =  $status;
            $this->db->where('order_id', $order_id);
            $this->db->update(db_prefix().'orders', $data);
            $status_send = true;
            $message = 'Status Changed Successfully';
        }
        else
        {
             $status_send = false;
             $message = 'Send All Parameters';
        }

        echo json_encode([
                'status' => $status_send,
                'message' => $message,
            ]);
    }
    
    public function selectFilter($para1 = '')
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('order', [
                'report_type'   => $para1
            ]);
        }
    }

    public function delete_order($id)
    {
        // echo checkPermissions('orders');die();
        if (!checkPermissions('orders')) {
            access_denied('orders');
        }
        if (!$id) {
            redirect(site_url('orders'));
        }
        $response = $this->db->where(['order_id'=>$id])->update(db_prefix().'orders',['trash'=>1]);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Orders')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Orders')));
        }
        redirect(site_url('orders'));
    }

    /* List all knowledgebase articles */
    public function update($id)
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('order');
        }
        if (!checkPermissions('orders')) {
            access_denied('orders');
        }
        if (!empty($this->input->post())) {
            $data=$this->input->post();
            unset($data['user_id']);
            $message=0;
            $orderId=[];
            // echo"<pre>";
            // print_r($data);
            // die;
            foreach ($data as $key => $value) {
                foreach ($value as $k => $v) {
                $orderId[]=$k;
                    foreach ($v as $mkey => $mvalue) {
                        if ($mvalue['quantity']!="" && $mvalue['unit']!="") {
                            $insertdata = $mvalue;
                            $insertdata['bach_no']= $mkey;
                            $insertdata['order_id'] = $k;
                            $insertdata['user_id'] =$this->input->post('user_id');
                            $insertdata['price']=$mvalue['quantity']*$mvalue['unit'];
                            // print_r($insertdata);
                             $res = $this->Orders_model->Insert($insertdata);
                             $response = userReward($res);
                            if ($response) {
                                $message++;
                            }else{
                                $message--;
                            }
                        }
                    }
                }
            }
            if (!empty($orderId)) {
                $updatedOrder =$this->db->select('order_id')->from(db_prefix().'orders_history')->where_in('order_id',$orderId)->get()->result_array();
                if (!empty($updatedOrder)) {
                    // print_r($updatedOrder);die;
                    for ($i=0; $i < count($orderId); $i++) { 
                         $status = ChangeStatus($orderId[$i]);
                    }
                }
            }

            if ($message>0) {
                set_alert('success', _l('Order Updated Successfully'));
            }
            redirect(site_url('orders'));
        }
        $sheader_text = title_text('aside_menu_active', 'Orders Details');
        $data['sheading_text'] = $sheader_text;
        $data['heading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        
        $data['response']=SelectOrder($id);
        // echo"<pre>";
        // print_r($data['response']);//die;
        // echo"</pre>";
        $this->load->view('admin/order/order', $data);
    }
}
