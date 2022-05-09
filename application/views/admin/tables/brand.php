<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'brand';
$where        = [
    /*'AND rel_id=3 AND rel_type="brand"',*/
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id','brandname','website','status']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'brand'))->row('file_name');
    $fullPath = 'uploads/brand/'.$aRow['id'].'/'. $filename;
    
    $row[] = '<img src="'.site_url('uploads/brand/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    $row[] = $aRow['brandname'];
    $row[] = substr($aRow['website'],0,50).'...';
    $row[] = bytesToSize($fullPath);
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'brand/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('brand/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('brand/delete_brand/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
