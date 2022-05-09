<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'title',
    'description',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'tips';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['title'];
    $row[] = $aRow['description'];
    
    $options = icon_btn('tips/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('tips/delete_tips/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
