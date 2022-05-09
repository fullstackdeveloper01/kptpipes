<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'name',
    'created_date',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'medicines';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['name'];
    $row[] = _d($aRow['created_date']);
    $options = icon_btn('medicines/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('medicines/delete_medicines/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
