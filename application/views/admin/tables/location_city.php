<?php

defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$aColumns = [
    db_prefix().'state.id as stateId',
    db_prefix().'state.country_id as country_id',
    db_prefix().'state.name as statename',
    db_prefix().'state.country_id as statenamecountryID',
    db_prefix().'country.name as countryname',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'state';
$join = [
    'LEFT JOIN '.db_prefix().'country ON '.db_prefix().'country.id ='.db_prefix().'state.country_id',
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [db_prefix().'state.id as stateId',db_prefix().'state.name as statename',db_prefix().'state.country_id as statenamecountryID',db_prefix().'state.status as statestatus',db_prefix().'country.name as countryname','tblstate.state_code']);
$output  = $result['output']; 
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['countryname'];
    $row[] = $aRow['state_code'];
    $row[] = '<a href="' . admin_url('state/addstate/' . $aRow['stateId']) . '" class="mbot10 display-block">' . $aRow['statename'] . '</a>';
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'state/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['stateId'] . '" data-id="' . $aRow['stateId'] . '" ' . ($aRow['statestatus'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['stateId'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['statestatus'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('state/addstate/' . $aRow['stateId'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('state/delete_state/' . $aRow['stateId'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
