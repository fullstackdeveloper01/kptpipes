<?php
defined('BASEPATH') or exit('No direct script access allowed');
//$CI          = & get_instance();
$aColumns = [
    'id',
    'category_id',
    'sub_category_id',
    'question',
    'answer',
    'category',
    'gender',
    'weightage',
    'dosha',
    'options',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'quiz';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    //$row[] = categoryname($aRow['category_id']);
    $row[] = substr($aRow['question'], 0,200);
    $row[] = json_decode($aRow['options']);
    
    $row[] = $aRow['answer'];
    $row[] = $aRow['category'];
    $row[] = $aRow['gender'];
    $row[] = json_decode($aRow['weightage']);
    $row[] = json_decode($aRow['dosha']);
    $options = icon_btn('quiz/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('quiz/delete_quiz/' . $aRow['id'], 'remove', 'btn-danger _delete');
    
    $output['aaData'][] = $row;
}
