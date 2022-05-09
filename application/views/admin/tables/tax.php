<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'tax';
$where        = [
    /*'AND rel_id=3 AND rel_type="tax"',*/
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id','taxname','taxvalue','status']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['taxname'];
    $row[] = $aRow['taxvalue'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'tax/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('tax/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('tax/delete_tax/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
