<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'group_id',
    'name',
    'url',
    'createddate',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'recommended_apps';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $CI->db->get_where(db_prefix().'customers_groups', array('id' => $aRow['group_id']))->row('name');
    $row[] = $aRow['name'];
    $row[] = $aRow['url'];
    $options = icon_btn('recommandedApps/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('recommandedApps/delete_recommandedApps/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
