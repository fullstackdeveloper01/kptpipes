<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();

$aColumns = [
    'id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'complain';

$where        = [
    'AND status=1 ',
    /*'AND rel_type="complain"',*/
];

// $join = [
//     'LEFT JOIN '.db_prefix().'distributors ON '.db_prefix().'dealer.distributor_id ='.db_prefix().'distributors.id',
// ];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id','userid','type','message','message_status','status']);

$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;

foreach ($rResult as $key=> $aRow) {
    $row = [];
    $row[] = $key+1;
    $response = databasetable($aRow);
    $row[] = $CI->db->get_where($response['table'],['id'=>$aRow['userid']])->row($response['name']);
    $row[] = $aRow['type'];
    $row[] = $aRow['message'];
    

    $row[] = ($aRow['message_status']==0)?'Reply':'Query';
    $options = icon_btn('complain/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options;

    $output['aaData'][] = $row;
}