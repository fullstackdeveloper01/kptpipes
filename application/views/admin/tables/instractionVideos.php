<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'name',
    'group_id',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'instraction_video';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    //$row[] = $CI->db->get_where(db_prefix().'customers_groups', array('id' => $aRow['group_id']))->row('name');
    $row[] = $aRow['name'];
    $attachment_file = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => "instractionVideofile"))->row();
    $fullPathfile = TASKS_ATTACHMENTS_FOLDER.$attachment_file->rel_id.'/'.$attachment_file->file_name;
    
    $row[] = bytesToSize($fullPathfile);
    
    $options = icon_btn('instractionVideo/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('instractionVideo/delete_instractionVideo/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
