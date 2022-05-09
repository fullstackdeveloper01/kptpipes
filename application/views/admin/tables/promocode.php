<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'title',
    'discount_price',
    'start_date',
    'end_date',
    'code_limit',
    'updated_at',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'promocode';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id','title','discount_price','code_limit']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['title'];
    $row[] = $aRow['discount_price'];
    $row[] = date('Y-m-d', $aRow['start_date']);
    $row[] = date('Y-m-d', $aRow['end_date']);
    $row[] = $aRow['code_limit'];
    $options = icon_btn('promocode/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('promocode/delete_promocode/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
