<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'title',
    'price',
    'createddate',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'subscription';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['title'];
    $row[] = $aRow['price'];
    $row[] = $aRow['createddate'];
    $options = icon_btn('subscription/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('subscription/delete_subscription/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
