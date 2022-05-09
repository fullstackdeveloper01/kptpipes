<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'message',
    'user_id',
    'category_id',
    'sub_category_id',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'listen';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    //$row[] = $CI->db->get_where(db_prefix().'listen_name', array('id' =>$aRow['user_id']))->row('name');
    
    $row[] = categoryname($aRow['category_id']);
    $row[] = categoryname($aRow['sub_category_id']);
    $row[] = $CI->db->get_where(db_prefix().'listen_name', array('id' => $aRow['user_id']))->row('name');
    $row[] = substr($aRow['message'], 0, 200);
    $options = icon_btn('listen/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('listen/delete_listen/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
