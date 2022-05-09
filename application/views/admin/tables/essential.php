<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'parent_id',
    'name',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'essential_phrases';
$where        = [];

array_push($where, 'AND ('.db_prefix().'essential_phrases.parent_id = 0)');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $attachment_key = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => "essential"))->row();
    $row[] = '<img src="'.site_url('download/file/taskattachment/'. $attachment_key->attachment_key).'" width="50" height="50" alt="">';
    $row[] = $aRow['name'];
    $options = icon_btn('commonPhrases/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('commonPhrases/delete_essential/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
