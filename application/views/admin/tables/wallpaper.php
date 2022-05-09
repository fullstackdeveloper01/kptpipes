<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'createddate',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'wallpaper';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $attachment_key = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => "wallpaper"))->row();
    
    $fullPath = TASKS_ATTACHMENTS_FOLDER.$attachment_key->id.'/'.$attachment_key->file_name;
    
    $row[] = '<img src="'.site_url('download/file/taskattachment/'. $attachment_key->attachment_key).'" width="50" height="50" alt="">';
    $row[] = bytesToSize($fullPath);;
    $row[] = $aRow['createddate'];
    /*$options = icon_btn('wallpaper/add/' . $aRow['id'], 'pencil-square-o');*/
    $options = '';
    $row[]   = $options .= icon_btn('wallpaper/delete_wallpaper/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
