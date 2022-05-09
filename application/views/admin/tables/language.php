<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'name',
    'createddate',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'language';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['name'];
    $row[] = $aRow['createddate'];
    $options = icon_btn('language/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('language/delete_language/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
