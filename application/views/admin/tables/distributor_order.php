<?php

defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$userid =$CI->uri->segment(2);
$aColumns = [
    'tblorders.id',
    'tblorders.order_id',
    'tblorders.user_id',
    'tblorders.product_id',
    'tblorders.quantity',
    'tblorders.user_type',
    'tblorders.status as orderstatus',
    'tblproducts.title',
    'tblproducts.category_id',
    'tblproducts.subcategory_id',
    'tblbrand.brandname',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'orders';
$where        = ['AND user_type="distributor"'];

array_push($where, 'AND '.db_prefix().'orders.trash = 0 AND '.db_prefix().'orders.user_id="'.$userid.'"');
$reportType = $this->ci->db->escape_str($report_type);

if($reportType!=""&&$reportType>=0)
{
    array_push($where, 'AND '.db_prefix().'orders.status="'.$reportType.'"');
}

// $join = [];

$join = [
    'LEFT JOIN '.db_prefix().'products ON '.db_prefix().'products.id='.db_prefix().'orders.product_id',
    'LEFT JOIN '.db_prefix().'brand ON '.db_prefix().'brand.id='.db_prefix().'products.brand_id',
    'LEFT JOIN '.db_prefix().'distributors ON '.db_prefix().'distributors.id='.db_prefix().'orders.user_id',
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'tblorders.id',
    'tblorders.order_id',
    'tblorders.user_id',
    'tblorders.product_id',
    'tblorders.quantity',
    'tblorders.user_type',
    'tblorders.status as orderstatus',
    'tblorders.created_date',
    'tblproducts.title',
    'tblproducts.category_id',
    'tblproducts.subcategory_id',
    'tblbrand.brandname',
    'tbldistributors.distributor_name as name',
    'tbldistributors.distributor_mobile',
    ]);
    // ],'GROUP BY tblorders.order_id');
$output  = $result['output'];
$rResult = $result['rResult'];
//print_r($rResult);//die;
foreach ($rResult as $aRow) {

    $row = [];
    
    $row[] = $aRow['order_id'];
    $row[] = $aRow['user_type'];

    // $user_info = $CI->db->get_where(db_prefix().'distributors',array('id' =>$aRow['user_id']))->row_array();

    $row[] = $aRow['name'];
    $row[] = $aRow['distributor_mobile'];
    // $row[] = BrandName($aRow['brand_id']);
    $row[] = ($aRow['brandname']);
    $row[] = $aRow['title'];
    $row[] = $aRow['quantity'];
    $ordarr = $CI->db->select('status')->from(db_prefix().'orders')->where(['order_id'=>$aRow['order_id']])->get()->result_array();
    $statusarr=[];
    foreach ($ordarr as $key => $value) {
        $statusarr[]=$value['status'];
    }
    if (in_array(0, $statusarr)) {
        $row[] =  'pending';
    }elseif (in_array(1, $statusarr)) {
        $row[] =  'accept';
    }elseif (in_array(2, $statusarr)) {
        $row[] =  'reject';
    }elseif (in_array(3, $statusarr)) {
        $row[] =  'complete';
    }
    // if ($aRow['orderstatus']==0) {
    //     $row[] = 'Pending';
    // }elseif ($aRow['orderstatus']==1) {
    //     $row[] = 'Accepted';
    // }elseif ($aRow['orderstatus']==2) {
    //     $row[] = 'Cancelled';
    // }elseif ($aRow['orderstatus']==3) {
    //     $row[] = 'Completed';
    // }
    $row[] = date('d-m-y',strtotime($aRow['created_date']));

    // $ordarr = $CI->db->select('status')->from(db_prefix().'orders')->where(['order_id'=>$aRow['order_id']])->get()->result_array();
    // $row[] = $aRow['created_date'];
    // $cp = '';
    // $cc = '';
    // $cpp = '';
    // $cp1 = '';
    // $id = $aRow['id'];
    // $statusck = $aRow['orderstatus'];
    // if($statusck==0)
    // {
    //     $cp = 'selected';
    // }elseif($statusck==1)
    // {
    //     $cc = 'selected';
    // }elseif($statusck==2)
    // {
    //     $cpp = 'selected';
    // }elseif($statusck==3)
    // {
    //     $cp1 = 'selected';
    // }
    // $status_btn = '<select class="form-control" name="order_status" onchange="setOrderStatus(this.value,'.$id.');" >
    //                    <option value="">Change Status</option>
    //                    <option value="0" '.$cp.'>Pending</option>
    //                    <option value="1" '.$cc.'>Accepted</option>
    //                    <option value="2" '.$cpp.'>Cancelled</option>
    //                    <option value="3" '.$cp1.'>Completed</option>
    //                </select>';
    // if ($cpp!='selected') {
    
        $status_btn =icon_btn('orders/update/' . $aRow['order_id'], 'pencil-square-o');
    // }                   
    $status_btn.=icon_btn('orders/delete_order/' . $aRow['order_id'], 'remove', 'btn-danger _delete');
    // $row[]   = $status_btn;

    $output['aaData'][] = $row;
}
