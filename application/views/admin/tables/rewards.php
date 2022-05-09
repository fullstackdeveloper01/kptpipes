<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    db_prefix().'brand.brandname',
    db_prefix().'products.title',
    db_prefix().'products.product_variant',
    'tblreward.id',
    'tblreward.percent',
    'tblreward.status',
    'tblreward.user_type',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'reward';
$where        = [];

$join = [
    'LEFT JOIN '.db_prefix().'brand ON '.db_prefix().'brand.id='.db_prefix().'reward.brand_id',
    'LEFT JOIN '.db_prefix().'products ON '.db_prefix().'products.id='.db_prefix().'reward.product_id',
];

array_push($where, 'AND ('.db_prefix().'reward.isDeleted = "0" )');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,[
    db_prefix().'brand.brandname',
    db_prefix().'products.title',
    db_prefix().'products.product_variant',
    'tblreward.id',
    'tblreward.percent',
    'tblreward.status',
    'tblreward.user_type',
]);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['user_type'];
    $row[] = $aRow['brandname'];
    $row[] = $aRow['product_variant'];
    $row[] = $aRow['percent'];
    /*$row[] = $aRow['price'];*/
    // $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    // <input type="checkbox" data-switch-url="' . admin_url() . 'reward/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    // <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    // </div>';

    // $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    // $row[] = $toggleActive;
    $row[] = $options = icon_btn('reward/add/' . $aRow['id'], 'pencil-square-o');
    // $row[]   = $options .= icon_btn('reward/delete_reward/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
