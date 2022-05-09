<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'price',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'master_price';
$where        = [
    /*'AND rel_id=3 AND rel_type="slider"',*/
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $sn++;
    $row[] = $aRow['price'];
    
    $options = icon_btn('priceRange/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('priceRange/delete_priceRange/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
