<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'title',
    'price',
    'type',
    'status',
    'created_date'
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'product';
$where        = [];
$join = [];



array_push($where, 'AND ('.db_prefix().'product.type = "Service" )');
array_push($where, 'AND ('.db_prefix().'product.status = "1" )');
array_push($where, 'AND ('.db_prefix().'product.active = "1" )');
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id','title']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    
    $row = [];
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'product'))->row('file_name');
    $fullPath = 'uploads/product/'.$aRow['id'].'/'. $filename;
    
    $row[] = $sn++;
    $row[] = '<img src="'.site_url('uploads/product/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    // $row[] = $aRow['title'];
    $row[] = $aRow['title'];
    $row[] = $aRow['price'];
    $row[] = bytesToSize($fullPath);
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'addOnServices/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('addOnServices/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('addOnServices/delete_addOnServices/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
