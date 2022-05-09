<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    db_prefix().'stocks.id',
    db_prefix().'stocks.product_id',
    db_prefix().'stocks.brand_id',
    db_prefix().'stocks.bach_no',
    db_prefix().'stocks.quantity',
    db_prefix().'stocks.status',
    db_prefix().'products.title as productname',
    db_prefix().'products.product_variant',
    db_prefix().'brand.brandname',
];
$sIndexColumn = 'id';
$sTable       = db_prefix().'stocks';
$where        = [];

$join = [
    'LEFT JOIN '.db_prefix().'brand ON '.db_prefix().'brand.id='.db_prefix().'stocks.brand_id',
    'LEFT JOIN '.db_prefix().'products ON '.db_prefix().'products.id='.db_prefix().'stocks.product_id',
];

array_push($where, 'AND ('.db_prefix().'stocks.trash = "0" )');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,[
    db_prefix().'stocks.id',
    db_prefix().'stocks.product_id',
    db_prefix().'stocks.brand_id',
    db_prefix().'stocks.bach_no',
    db_prefix().'stocks.quantity',
    db_prefix().'stocks.status',
    db_prefix().'products.title as productname',
    db_prefix().'products.product_variant',
    db_prefix().'brand.brandname',
]);
$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $key =>  $aRow) {
    $row = [];
    
    $row[] = $key+1;
    $row[] = $aRow['brandname'];
    $row[] = $aRow['product_variant'];
    $row[] = $aRow['bach_no'];
    $row[] = $aRow['quantity'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'products/stoke_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $count = $CI->db->get_where(db_prefix().'barcode',['product_id'=>$aRow['product_id'],'bach_no'=>$aRow['bach_no'],'status'=>1])->num_rows();
    if ($count>0) {
        $options = icon_btn('products/getbarcode/' . $aRow['product_id'].'/'.$aRow['bach_no'], 'eye','btn-info');
        $options .= icon_btn('products/printbarcode/' . $aRow['product_id'].'/'.$aRow['bach_no'], 'print','btn-info');
        $row[]   = $options .= icon_btn('products/delete_stoke/' . $aRow['id'], 'remove', 'btn-danger _delete');
    }else{
        $row[]   = $options = icon_btn('products/delete_stoke/' . $aRow['id'], 'remove', 'btn-danger _delete');
    }
    // $options = icon_btn('products/addstock/' . $aRow['id'], 'pencil-square-o');
    // $options = icon_btn('products/barcode/' . $aRow['id'], 'eye','btn-info');
    // $row[]   = $options .= icon_btn('products/delete_stoke/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
