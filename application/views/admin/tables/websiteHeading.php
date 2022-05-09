<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'website_heading';
$where        = [];

$join = [
    /*'LEFT JOIN '.db_prefix().'technology ON '.db_prefix().'technology.id ='.db_prefix().'client.technology_id',*/
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id','heading','button_text','button_link']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['heading'];
    $row[] = $aRow['button_text'];
    $row[] = $aRow['button_link'];
    
    $row[] = icon_btn('websiteHeading/add/' . $aRow['id'], 'pencil-square-o');

    $output['aaData'][] = $row;
}
