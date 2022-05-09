<?php
//error_reporting(-1); ini_set('display_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$aColumns = [
    db_prefix().'area_new.id as aid',
    db_prefix().'area_new.time_slot  as atime_slot',
    db_prefix().'area_new.status  as astatus',
    db_prefix().'area_new.extra_charge  as aextra_charge',
    db_prefix().'area_new.areaname  as areaname',
    db_prefix().'area.name as aname',
    db_prefix().'country.name as countryname',
    db_prefix().'city.name as cityname',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'area_new';

$join = [
    'LEFT JOIN '.db_prefix().'country ON '.db_prefix().'area_new.country_id ='.db_prefix().'country.id',
    'LEFT JOIN '.db_prefix().'city ON '.db_prefix().'area_new.state_id ='.db_prefix().'city.id',
    'LEFT JOIN '.db_prefix().'area ON '.db_prefix().'area_new.city_id ='.db_prefix().'area.id',
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [
    db_prefix().'area_new.id as aid',
    db_prefix().'area_new.areaname  as areaname',
    db_prefix().'area_new.time_slot  as atime_slot',
    db_prefix().'area_new.status  as astatus',
    db_prefix().'area_new.extra_charge  as aextra_charge',
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
    $row[] = $aRow['areaname'];
    $row[] = $aRow['aextra_charge'];
    $row[] = $aRow['atime_slot'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'area/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['aid'] . '" data-id="' . $aRow['aid'] . '" ' . ($aRow['astatus'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['aid'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['astatus'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('area/add/' . $aRow['aid'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('area/delete_area/' . $aRow['aid'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
