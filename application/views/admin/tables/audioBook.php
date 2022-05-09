<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'title',
    'description',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'audio_book';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['title'];
    
    $attachment_key = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => "audiobookimg"))->row();
    $fullPath = TASKS_ATTACHMENTS_FOLDER.$attachment_key->rel_id.'/'.$attachment_key->file_name;
    
    $attachment_file = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => "audiobookfile"))->row();
    $fullPathfile = TASKS_ATTACHMENTS_FOLDER.$attachment_file->rel_id.'/'.$attachment_file->file_name;
    
    $row[] = bytesToSize($fullPath);
    $row[] = bytesToSize($fullPathfile);
    
    $row[] = substr($aRow['description'], 0,200);
    $options = icon_btn('audioBook/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('audioBook/delete_audioBook/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
