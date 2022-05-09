<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'category';
$where        = [];

array_push($where, 'AND ('.db_prefix().'category.parent_id = 0)');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id','name','brand_id','parent_id','status']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $attachment_key = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => "category"))->row('file_name');
    $row[] = '<img src="'.site_url('uploads/category/'.$aRow['id'].'/'. $attachment_key).'" width="50" height="50" alt="">';
    $row[] = $aRow['name'];
    $row[] = brandnamelist($aRow['brand_id']);
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'category/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('category/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('category/delete_category/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
