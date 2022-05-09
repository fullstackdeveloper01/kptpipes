<?php
//error_reporting(-1); ini_set('display_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$aColumns = [
    db_prefix().'city.id as cityid',
    db_prefix().'city.status as citystatus',
    db_prefix().'city.name as cityname',
    db_prefix().'country.name as countryname',
    db_prefix().'state.name as statename',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'city';

$join = [
    'LEFT JOIN '.db_prefix().'country ON '.db_prefix().'city.country_id ='.db_prefix().'country.id',
    'LEFT JOIN '.db_prefix().'state ON '.db_prefix().'city.state_id ='.db_prefix().'state.id',
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [ 
    db_prefix().'city.id as cityid',
    db_prefix().'city.status as citystatus',
    db_prefix().'city.name as cityname',
    db_prefix().'country.name as countryname',
    db_prefix().'state.name as statename']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    // print_r($aRow); die;
    $row[] = $aRow['countryname'];
    $row[] = $aRow['statename'];
    $row[] = '<a href="' . admin_url('city/addCity/' . $aRow['cityid']) . '" class="mbot10 display-block">' . $aRow['cityname'] . '</a>';
    
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'city/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['cityid'] . '" data-id="' . $aRow['cityid'] . '" ' . ($aRow['citystatus'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['cityid'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['citystatus'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    
    $options = icon_btn('city/addCity/' . $aRow['cityid'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('city/delete_city/' . $aRow['cityid'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
