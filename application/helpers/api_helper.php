<?php

defined('BASEPATH') or exit('No direct script access allowed');

use app\services\messages\Message;
use app\services\messages\PopupMessage;

/* this function is for to check password*/
function password_verifyed($checkpassword,$password)
{
    if (md5($checkpassword)==$password) {
    	return true;
    }else{
    	return false;
    }
}

/* this function is for to check password*/

function DMY_date()
{
    return date('d-m-Y H:i:s');
}

/* this function is for to check password*/

function YMD_date()
{
    return date("Y-m-d H:i:s");
}

/* this function is for to check password*/

function YMD_only()
{
    return date("Y-m-d");
}

/* this function is for to check password*/

function HIS_only()
{
    return date("H:i:s");
}

/* this function is for to check password*/

function dmY_only()
{
    return date('d-m-Y');
}

function databasetable($postData){
	if ($postData['type']=='dealer') {
        $arr['table']=db_prefix().'dealer';
        $arr['mobile']='dealer_mobile';
        $arr['columns']='dealer_password';
        $arr['columns_pass']='dealer_pass';
        $arr['name']='dealer_name';
        $arr['dob']='dealer_dob';
        $arr['email']='dealer_email';
        $arr['gender']='dealer_gender';
        $arr['image']='dealer';
        $arr['type']='dealer';
        $arr['gst']='dealer_GST';
        $arr['pan']='dealer_pan_number';
        $arr['aadhar']='dealer_aadhar_number';
    }elseif ($postData['type']=='plumber') {
        $arr['table']=db_prefix().'plumber';
        $arr['mobile']='plumber_mobile';
        $arr['columns']='plumber_password';
        $arr['columns_pass']='plumber_pass';
        $arr['name']='plumber_name';
        $arr['dob']='plumber_dob';
        $arr['email']='plumber_email';
        $arr['gender']='plumber_gender';
        $arr['image']='plumber';
        $arr['type']='plumber';
        $arr['gst']='';
        $arr['pan']='plumber_pan_number';
        $arr['aadhar']='plumber_aadhar_number';
    }else{
        $arr['table']=db_prefix().'distributors';
        $arr['mobile']='distributor_mobile';
        $arr['columns']='distributor_password';
        $arr['columns_pass']='distributor_pass';
        $arr['name']='distributor_name';
        $arr['dob']='distributor_dob';
        $arr['email']='distributor_email';
        $arr['gender']='distributor_gender';
        $arr['image']='distributor';
        $arr['type']='distributor';
        $arr['gst']='distributor_GST';
        $arr['pan']='distributor_pan_number';
        $arr['aadhar']='distributor_aadhar_number';
    }
    return$arr;
}

/* Send Sms */
function send_sms1($data,$schedule='no')
{
    $authKey = "100878AzvmCguo9zJ5dbd8aeb";

//  $authKey    =   ($authKey!='') ? $authKey : "100878AzvmCguo9zJ5dbd8aeb";        
    $senderId   =   isset($senderId) ? $senderId : "INSTAC";         

    //Multiple mobiles numbers separated by comma
    $mobileNumber = $data['moblie_no'];

    //Your message to send, Add URL encoding here.
    $message = urlencode($data['message']);
    //Define route 
    $route = "4";
    
    $postData['authkey'] = $authKey;
    $postData['mobiles'] = $mobileNumber;
    $postData['message'] = $message;
    $postData['sender'] = $senderId;
    $postData['route'] = $route;
    $postData['unicode'] = 1;
    if($schedule=='yes'){
        $postData['schtime'] = $data['schtime'];
        
    }
    //API URL
    $url="https://control.msg91.com/api/sendhttp.php";

    // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
        //,CURLOPT_FOLLOWLOCATION => true
    ));

    //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    //get response
    $output = curl_exec($ch);

    return true;    
}

/*this is for get brand name */
function brandNames($id){
	$where['id']=$id;
	$CI = &get_instance();
	return $CI->db->get_where(db_prefix().'brand',$where)->row('brandname');
}

/*this is for get category name */
function categoryNames($id){
	$where['id']=$id;
	$CI = &get_instance();
	return $CI->db->get_where(db_prefix().'category',$where)->row('name');
}

/*this is for get sub category name */
function subcategoryNames($id){
	$where['id']=$id;
	$CI = &get_instance();
	return $CI->db->get_where(db_prefix().'category',$where)->row('name');
}

/*this is for genrate order id */
function OrderID(){
    $CI = &get_instance();
    $CI->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    $lastorder_id =$CI->db->select_max('order_id')->from(db_prefix().'orders')->group_by('order_id')->order_by('id','DESC')->get()->row('order_id');
    if ($lastorder_id=="") {
        return 'OID1';
    }else{
        $order_id_arr = explode('D', $lastorder_id);
        $order_id_arr[1]=$order_id_arr[1]+1;
        return implode('D', $order_id_arr);
    }
}

/*this is for genrate order table array  */
function PlaceOrder($data){
    $data['user_id']=$data['userid'];
    $data['created_by']=$data['userid'];
    $data['user_type']=$data['type'];
    if ($data['type']=="dealer") {
        if ($data['distributor_id']!="") {
            $data['to_user']=$data['distributor_id'];
            unset($data['distributor_id']);
        }else{
            return 'Distributor Id required';
        }
    }else{
        unset($data['distributor_id']);
    }
    unset($data['userid']);
    unset($data['type']);
    $CI = &get_instance();
    $productId = explode(',', $data['product_id']);
    $quantity = explode(',', $data['quantity']);
    foreach ($productId as $key => $value) {
        $data['product_id']=$value;
        $data['quantity']=$quantity[$key];
        $CI->api_model->Insert(db_prefix().'orders',$data);
    }
    return true;
}

/*this is for genrate order table array  */
function PlaceOrderfordealer($data){
    $data['user_id']=$data['userid'];
    $data['created_by']=$data['distributor_id'];
    if ($data['type']=="distributor") {
        $data['user_type']="dealer";
        if ($data['distributor_id']!="") {
            $data['to_user']=$data['distributor_id'];
            unset($data['distributor_id']);
        }else{
            return 'Distributor Id required';
        }
    }else{
        return 'Only Distributor Have Access';
    }
    unset($data['userid']);
    unset($data['type']);
    $CI = &get_instance();
    $productId = explode(',', $data['product_id']);
    $quantity = explode(',', $data['quantity']);
    foreach ($productId as $key => $value) {
        $data['product_id']=$value;
        $data['quantity']=$quantity[$key];
        $CI->api_model->Insert(db_prefix().'orders',$data);
    }
    return true;
}

/*this is for get order id */
function GetOrderID($id){
    $where['id']=$id;
    $CI = &get_instance();
    return $CI->db->get_where(db_prefix().'orders',$where)->row('order_id');
}

/*this is for get change order status */
function change_orderStatus($id = null,$status = null){
    $where['order_id']= $id;
    $data['status']= $status;
    // if ($data['status']==2) {
    //     $data['trash']=1;
    // }
    $CI = &get_instance();
    $response= $CI->api_model->updateData(db_prefix().'orders',$where,$data);
    if($response){
        return true;
    }else{
        return false;
    }
}

/*this is for edit dealer order  */
function editOrder($data){
    $where['order_id']= $data;
    $CI = &get_instance();
    $response= $CI->api_model->Select(db_prefix().'orders',$where);
    $data=[];
    foreach ($response as $key => $value) {
        $data[$key] = $value;
        $data[$key]['productName']=productNames($value['product_id']);

        $orderwhere['type']='dealer';
        $orderwhere['order_id']=$value['id'];
        $orderhistory = $CI->db->from(db_prefix().'orders_history')->where($orderwhere)->get()->result_array();
        $history = [];
        $history_qtysum=0;
        foreach ($orderhistory as $hk => $hv) {
            $history[$hk]=$hv;
            $history_qtysum = $history_qtysum+$hv['quantity'];
            $history[$hk]['productname'] = productNames($hv['product_id']);
            $history[$hk]['username'] = $CI->db->get_where(db_prefix().'dealer',['id'=>$hv['user_id']])->row('dealer_name');
            $history[$hk]['remaining_qty'] = 0;
        }

        $wheres['product_id']=$value['product_id'];
        $wheres['user_id']=$value['to_user'];
        $wheres['type']='distributor';
        if ($value['status']!= 3) {
            $stock = $CI->db->from(db_prefix().'user_stock')->where($wheres)->where(['quantity !=' => 0])->get()->result_array();
            // print_r($stock);
            // die;
            $stockHistory=[];
            foreach ($stock as $sk => $sv) {
                if ($sv['quantity']>0) {
                    $stockHistory[$sk]=$sv;
                    $stockHistory[$sk]['unit']='';
                    $stockHistory[$sk]['price']='';
                    $stockHistory[$sk]['remaining_qty']=$value['quantity']-$history_qtysum;
                }
                // else{
                //     $stockHistory[$sk]=[];
                // }
            }

            // print_r($stockHistory);
            // die;
            $data[$key]['stock']=$stockHistory;

        }else{
            $data[$key]['stock']=[];
        }
        
        $data[$key]['history']=$history;
        // $data[$key]['remaining_qty']=$value['quantity']-$history_qtysum;
    }
    return $data;
}

/* this is for user add user reward*/
function dealerReward($id){
    $CI = &get_instance();

    // this code is for get order details
    $orderData = $CI->db->get_where(db_prefix().'orders_history',['id'=>$id])->row_array();

    // this code is for get dealer reward point
    $discountPercent =$CI->db->select('percent,id')->get_where(db_prefix().'reward',['user_type'=>$orderData['type'],'product_id'=>$orderData['product_id'],'isDeleted'=>0,'status'=>1])->row();

    // this code is for get distributor current stock
    $totalQty =$CI->db->get_where(db_prefix().'user_stock',['bach_no'=>$orderData['bach_no'],'product_id'=>$orderData['product_id'],'type'=>'distributor'])->row('quantity');

    $updateQty['quantity']= $totalQty-$orderData['quantity'];

    // this code is for update distributor stock
    $res = $CI->db->where(['bach_no'=>$orderData['bach_no'],'product_id'=>$orderData['product_id'],'type'=>'distributor'])->Update(db_prefix().'user_stock',$updateQty);

    if ($res) {
        // this code is for substract stock in distributor stock
        $insertdata['ord_history_id']=$id;
        $insertdata['transaction_status']='less';
        $insertdata['quantity']=$orderData['quantity'];
        $insertdata['bach_no']=$orderData['bach_no'];
        $insertdata['product_id']=$orderData['product_id'];
        $insertdata['user_id']=$orderData['user_id'];
        $insertdata['order_id']=$orderData['order_id'];

        $CI->db->insert(db_prefix().'distributor_stock_history',$insertdata);
        // this is for calculating reward point
        if ($discountPercent!="") {
            $rewarddata['user_id']=$orderData['user_id'];
            $rewarddata['product_id']=$orderData['product_id'];
            $rewarddata['bach_no']=$orderData['bach_no'];
            $rewarddata['order_id']=$orderData['order_id'];
            $rewarddata['type']=$orderData['type'];
            // $rewarddata['points']=($orderData['price'] / 100) * $discountPercent;
            $rewarddata['points']=($orderData['quantity']) * $discountPercent->percent;
            $rewarddata['reward_id']=$discountPercent->id;
            $response = $CI->db->insert(db_prefix().'user_reward',$rewarddata);
        }
        return true;
    }else{
        $CI->db->where(['id'=>$id])->delete(db_prefix().'orders_history');
        $CI->db->where(['ord_history_id'=>$id])->delete(db_prefix().'dealer_stock_history');
        return false;
    }
}

/*this is for change Order status */
function ChangeDealerStatus($id){
    $where['order_id']=$id;
    $CI = &get_instance();
    $OID_id = $CI->db->get_where(db_prefix().'orders',['id'=>$id])->row('order_id');
    $orders_history_qty = $CI->db->select_sum('quantity')->from(db_prefix().'orders_history')->where($where)->get()->row('quantity');
    $request_histry_qty = $CI->db->get_where(db_prefix().'orders',['id'=>$id])->row('quantity');
    if ($request_histry_qty == $orders_history_qty) {
        $CI->db->where(['id'=>$id])->update(db_prefix().'orders',['status'=>3]);
        $CI->db->where(['order_id'=>$OID_id])->where("status !=",3)->where("status !=",2)->update(db_prefix().'orders',['status'=>1]);

    }elseif ($request_histry_qty > $orders_history_qty) {
        $CI->db->where(['id'=>$id])->update(db_prefix().'orders',['status'=>1]);
        $CI->db->where(['order_id'=>$OID_id])->where("status !=",3)->where("status !=",2)->update(db_prefix().'orders',['status'=>1]);
    }
    return true;
}

/*this is for validate dealer */
function validation($postData){
    $validation=0;
    $message=[];
    $CI = &get_instance();

    if ($postData['pan_no']!="") {
        $where['dealer_pan_number']=$postData['pan_no'];
        $where1['distributor_pan_number']=$postData['pan_no'];
        $where2['plumber_pan_number']=$postData['pan_no'];
        $data= $CI->api_model->selectCount(db_prefix().'dealer',$where);
        $data1= $CI->api_model->selectCount(db_prefix().'distributors',$where1);
        $data2= $CI->api_model->selectCount(db_prefix().'plumber',$where2);
        if($data != 0 || $data1 != 0 || $data2 != 0){
            $validation++;
            $message[]='Pan Number';
        }
    }
    if ($postData['aadhar_no']!="") {
        $where_aadh['dealer_aadhar_number']=$postData['aadhar_no'];
        $where_aadh1['distributor_aadhar_number']=$postData['aadhar_no'];
        $where_aadh2['plumber_aadhar_number']=$postData['aadhar_no'];
        $data_aadh= $CI->api_model->selectCount(db_prefix().'dealer',$where_aadh);
        $data_aadh1= $CI->api_model->selectCount(db_prefix().'distributors',$where_aadh1);
        $data_aadh2= $CI->api_model->selectCount(db_prefix().'plumber',$where_aadh2);
        if($data_aadh != 0 || $data_aadh1 != 0 || $data_aadh2 != 0){
            $validation++;
            $message[]='Aadhar Number';
        }
    }
    if ($postData['gst_no']!="") {
        $where_gst['dealer_GST']=$postData['gst_no'];
        $where_gst1['distributor_GST']=$postData['gst_no'];
        $data_gst= $CI->api_model->selectCount(db_prefix().'dealer',$where_gst);
        $data_gst1= $CI->api_model->selectCount(db_prefix().'distributors',$where_gst1);
        if($data_gst != 0 || $data_gst1 != 0){
            $validation++;
            $message[]='GST Number';
        }
    }
    if ($postData['email']!="") {
        $where_email['dealer_email']=$postData['email'];
        $where_email1['distributor_email']=$postData['email'];
        $where_email2['plumber_email']=$postData['email'];
        $where_email3['email']=$postData['email'];
        $data_email= $CI->api_model->selectCount(db_prefix().'dealer',$where_email);
        $data_email1= $CI->api_model->selectCount(db_prefix().'distributors',$where_email1);
        $data_email2= $CI->api_model->selectCount(db_prefix().'plumber',$where_email2);
        $data_email3= $CI->api_model->selectCount(db_prefix().'staff',$where_email3);
        if($data_email != 0 || $data_email1 != 0 || $data_email2 != 0 || $data_email3 != 0){
            $validation++;
            $message[]='Email Id';
        }
    }
    if ($postData['mobile']!="") {
        $where_mobile['dealer_mobile'] = $postData['mobile'];
        $where_mobile1['distributor_mobile'] = $postData['mobile'];
        $where_mobile2['plumber_mobile'] = $postData['mobile'];
        $where_mobile3['phonenumber'] = $postData['mobile'];
        $data_mobile= $CI->api_model->selectCount(db_prefix().'dealer',$where_mobile);
        $data_mobile1= $CI->api_model->selectCount(db_prefix().'distributors',$where_mobile1);
        $data_mobile2= $CI->api_model->selectCount(db_prefix().'plumber',$where_mobile2);
        $data_mobile3= $CI->api_model->selectCount(db_prefix().'staff',$where_mobile3);
        if($data_mobile != 0 || $data_mobile1 != 0 || $data_mobile2 != 0 || $data_mobile3 != 0){
            $validation++;
            $message[]='Mobile Number';
        }
    }
    $response['validation']=$validation;
    $response['message']=implode(',', $message).' Already In Use';
    return $response;
}

/* Dealer name */
function dealerNames($id)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'dealer', array('id' => $id))->row('dealer_name');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}


/* Update User login */
function UpdateUser($table,$where,$userdata,$data)
{
    $CI = &get_instance();
    $otp = rand(1000,9999);
    $dataadd['otp'] = $otp;
    $res = $CI->api_model->updateData($table,$where,$dataadd);
    $userdata['otp']=$otp;
    $userdata['type']=$data['type'];
    if ($res) {
        $CI->db->where('id', $userdata['id']);
        $CI->db->update($table, [
            'last_ip' =>  $data['ip_address'],
            'last_login' =>  YMD_date(),
            'token' => isset($data['token'])?$data['token']:'',
        ]);
        return $msg = array('status' => true, 'message' =>'Otp Send To your registered number', 'result' => $userdata);
    }else{
        return $msg = array('status' => false, 'message' =>'Some error Found', 'result' => []);
    }
}
