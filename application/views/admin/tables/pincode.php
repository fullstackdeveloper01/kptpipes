<?php
//error_reporting(-1); ini_set('display_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$aColumns = [
    db_prefix().'area_pincode.id as pid',
    db_prefix().'area_pincode.pincode as ppincode',
    db_prefix().'area_pincode.status as pstatus',
    db_prefix().'area_new.areaname  as aareaname',
    db_prefix().'area.name as aname',
    db_prefix().'country.name as countryname',
    db_prefix().'city.name as cityname',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'area_pincode';

$join = [
    'LEFT JOIN '.db_prefix().'country ON '.db_prefix().'area_pincode.country_id ='.db_prefix().'country.id',
    'LEFT JOIN '.db_prefix().'city ON '.db_prefix().'area_pincode.state_id ='.db_prefix().'city.id',
    'LEFT JOIN '.db_prefix().'area ON '.db_prefix().'area_pincode.city_id ='.db_prefix().'area.id',
    'LEFT JOIN '.db_prefix().'area_new ON '.db_prefix().'area_pincode.area_id ='.db_prefix().'area_new.id',
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [
    db_prefix().'area_pincode.id as pid',
    db_prefix().'area_pincode.pincode as ppincode',
    db_prefix().'area_pincode.status as pstatus',
    db_prefix().'area_new.areaname  as aareaname',
    db_prefix().'area.name as aname',
    db_prefix().'country.name as countryname',
    db_prefix().'city.name as cityname']);


$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['countryname'];
    $row[] = $aRow['cityname'];
    $row[] = $aRow['aname'];
    $row[] = $aRow['aareaname'];
    $row[] = $aRow['ppincode'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'pincode/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['pid'] . '" data-id="' . $aRow['pid'] . '" ' . ($aRow['pstatus'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['pid'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['pstatus'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('pincode/add/' . $aRow['pid'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('pincode/delete_area/' . $aRow['pid'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
