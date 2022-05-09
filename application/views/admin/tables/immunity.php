<?php
defined('BASEPATH') or exit('No direct script access allowed');
//$CI          = & get_instance();
$aColumns = [
    'id',
    'question_english',
    'question_hindi',
    'always',
    'sometimes',
    'never',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'_immunity';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];
$ii = 1;
foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $ii++;
    $row[] = $aRow['question_english'];
    $row[] = $aRow['question_hindi'];
    
    $row[] = $aRow['always'];
    $row[] = $aRow['sometimes'];
    $row[] = $aRow['never'];
    $options = icon_btn('immunity/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('immunity/delete_immunity/' . $aRow['id'], 'remove', 'btn-danger _delete');
    
    $output['aaData'][] = $row;
}
