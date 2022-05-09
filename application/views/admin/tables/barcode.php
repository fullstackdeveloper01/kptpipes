<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$product_id= $CI->uri->segment(4);
$barcode= $CI->uri->segment(5);
$aColumns = [
    db_prefix().'barcode.id',
];
$sIndexColumn = 'id';
$sTable       = db_prefix().'barcode';
$where        = [
    'AND product_id='.$product_id.' AND bach_no = "'.$barcode.'" AND tblbarcode.status = 1',
];

$join = [
    // 'LEFT JOIN '.db_prefix().'brand ON '.db_prefix().'brand.id='.db_prefix().'stocks.brand_id',
    'LEFT JOIN '.db_prefix().'products ON '.db_prefix().'products.id='.db_prefix().'barcode.product_id',
];

// array_push($where, 'AND ('.db_prefix().'stocks.trash = "0" )');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,[
    db_prefix().'barcode.id',
    db_prefix().'barcode.product_id',
    db_prefix().'barcode.bach_no',
    db_prefix().'barcode.barcode_value',
    db_prefix().'barcode.image',
    db_prefix().'products.title as productname',
]);
$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $key =>  $aRow) {
    $row = [];
    
    $row[] = $key+1;
    $row[] = $aRow['productname'];
    $row[] = $aRow['bach_no'];
    $row[] = $aRow['barcode_value'];
    $row[] ='<a href="'.base_url($aRow['image']).'" target="_blank"><img src="'.base_url($aRow['image']).'" width="150" height="100"></a>';
    // $options = icon_btn('products/addstock/' . $aRow['id'], 'pencil-square-o');
    // $options = icon_btn('products/barcode/' . $aRow['id'], 'eye','btn-info');
    // $row[]   = $options .= icon_btn('products/delete_stoke/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
