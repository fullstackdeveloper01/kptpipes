<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'type',
    'emails',
    'title',
    'description',
    'createddate',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'communicate';
$where        = [];

//array_push($where, 'AND ('.db_prefix().'category.parent_id = 0)');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id','type','title','description','emails']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['title'];
    $row[] = $aRow['description'];
    $row[] = _d($aRow['createddate']);
    $row[] = ucfirst($aRow['type']);
    //$options = icon_btn('category/add/' . $aRow['id'], 'pencil-square-o');
    //$row[]   = $options .= icon_btn('category/delete_category/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
