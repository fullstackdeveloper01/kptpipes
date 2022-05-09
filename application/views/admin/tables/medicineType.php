<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'name',
    'created_date',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'type_of_medicines';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $attachment_key = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => "medicineType"))->row();
    
    $fullPath = 'uploads/medicine_icon/'.$aRow['id'].'/'. $attachment_key->file_name;
    
    $row[] = '<img src="'.site_url('uploads/medicine_icon/'.$aRow['id'].'/'. $attachment_key->file_name).'" width="50" height="50" alt="">';
    $row[] = $aRow['name'];
    $row[] = bytesToSize($fullPath);
    $row[] = $aRow['created_date'];
    /*$options = icon_btn('medicineType/add/' . $aRow['id'], 'pencil-square-o');*/
    $options = '';
    $row[]   = $options .= icon_btn('medicineType/delete_medicineType/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
