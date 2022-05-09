<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$userid =$CI->uri->segment(2);
$aColumns = [
    db_prefix().'brand.brandname',
    db_prefix().'products.title',
    db_prefix().'user_reward.id',
    db_prefix().'user_reward.user_id',
    db_prefix().'user_reward.bach_no',
    db_prefix().'user_reward.points',
    db_prefix().'user_reward.status_type',
    db_prefix().'user_reward.message',
    db_prefix().'user_reward.barcode_id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'user_reward';
$where        = [];

$join = [
    'LEFT JOIN '.db_prefix().'products ON '.db_prefix().'products.id='.db_prefix().'user_reward.product_id',
    'LEFT JOIN '.db_prefix().'brand ON '.db_prefix().'brand.id='.db_prefix().'products.brand_id',
    'LEFT JOIN '.db_prefix().'plumber ON '.db_prefix().'plumber.id='.db_prefix().'user_reward.user_id',
];

array_push($where, 'AND ('.db_prefix().'user_reward.status = "1" )');
array_push($where, 'AND ('.db_prefix().'user_reward.type = "plumber" )');
array_push($where, 'AND ('.db_prefix().'user_reward.user_id = "'.$userid.'" )');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,[
    db_prefix().'brand.brandname',
    db_prefix().'products.title',
    db_prefix().'user_reward.id',
    db_prefix().'user_reward.user_id',
    db_prefix().'user_reward.bach_no',
    db_prefix().'user_reward.points',
    db_prefix().'user_reward.status_type',
    db_prefix().'user_reward.barcode_id',
    db_prefix().'user_reward.message',
    db_prefix().'plumber.plumber_name as username',
]);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $key => $aRow) {
    $row = [];

    $row[] = $key+1;
    $row[] = ($aRow['username']);
    $row[] = ($aRow['brandname']!="")?$aRow['brandname']:'Null';
    $row[] = ($aRow['title']!="")?$aRow['title']:'Null';
    $row[] = $aRow['points'];
    $row[] = $aRow['barcode_id'];
    $row[] = ($aRow['message']!="")?$aRow['message']:'Null';
    $row[] = $aRow['status_type'];
    /*$row[] = $aRow['price'];*/
    // $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    // <input type="checkbox" data-switch-url="' . admin_url() . 'reward/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    // <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    // </div>';

    // $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    // $row[] = $toggleActive;
    // $row[] = $options = icon_btn('reward/add/' . $aRow['id'], 'pencil-square-o');
    // $row[]   = $options .= icon_btn('reward/delete_reward/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
