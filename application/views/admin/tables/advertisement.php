<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'advertisement';
$where        = [
    /*'AND rel_id=3 AND rel_type="advertisement"',*/
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id','title','redirect_url','start_date','end_date','status']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'advertisement'))->row('file_name');
    $fullPath = 'uploads/advertisement/'.$aRow['id'].'/'. $filename;
    
    $row[] = '<img src="'.site_url('uploads/advertisement/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    $row[] = $aRow['title'];
    $row[] = _d(date('Y-m-d',$aRow['start_date']));
    $row[] = _d(date('Y-m-d',$aRow['end_date']));
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'advertisement/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('advertisement/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('advertisement/delete_advertisement/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
