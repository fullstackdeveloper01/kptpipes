<?php

defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'userid',
    'place_order_id',
    'order_status',
    'product_ids',
    'product_qtys',
    'product_prices',
    'place_order_id',
    'paidAmount',
    'created_date',
    'paymentType',
    'status'
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'_confirm_order';
$where        = [];

$reportType = $this->ci->db->escape_str($report_type);

if($reportType)
{
    $selectDate = '';
    if($reportType == 1)
    {
        $time = date('Y-m-d h:i:s');
        $selectDate = date("Y-m-d h:i:s", strtotime("-1 month"));
        
        array_push($where, 'AND '.db_prefix().'_confirm_order.created_date > "'.$selectDate.'"'); 
    }
    elseif($reportType == 2)
    {
        $time = date('Y-m-d h:i:s');
        $selectDate = date("Y-m-d h:i:s", strtotime("-7 days"));
        
        array_push($where, 'AND '.db_prefix().'_confirm_order.created_date > "'.$selectDate.'"'); 
    }
    elseif($reportType == 3)
    {
        $time = date('Y-m-d');
        //$selectDate = date("Y-m-d h:i:s", strtotime("-1 month", $time));
        
        array_push($where, 'AND '.db_prefix().'_confirm_order.created_date ="'.$time.'"'); 
    }
}

array_push($where, 'AND '.db_prefix().'_confirm_order.order_status=5');

$join = [];

// $join = [
//     'LEFT JOIN '.db_prefix().'contacts ON '.db_prefix().'contacts.userid='.db_prefix().'_confirm_order.userid',
// ];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id','paidAmount']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {

    $user_info = $CI->db->get_where(db_prefix().'contacts',array('userid' =>$aRow['userid']))->row();
    $row = [];
    
    $row[] = $aRow['id'];
    $row[] = $user_info->firstname;
    $row[] = $user_info->phonenumber;
    $row[] = $aRow['paidAmount'];
    $row[] = payment_status($aRow['status']);
    $row[] = _d($aRow['created_date']);

    $output['aaData'][] = $row;
}
