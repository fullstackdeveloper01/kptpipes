<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'title',
    'donation_price',
    'status',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'donation';
$where        = [
    /*'AND rel_id=3 AND rel_type="donation"',*/
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'donation'))->row('file_name');
    $fullPath = 'uploads/donation/'.$aRow['id'].'/'. $filename;

    $row[] = $sn++;
    $row[] = '<img src="'.site_url('uploads/donation/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    $row[] = $aRow['title'];
    $row[] = $aRow['donation_price'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('Change status') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'donation/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('donation/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('donation/delete_donation/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
