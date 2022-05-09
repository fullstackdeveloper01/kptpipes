<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
    'name',
    'mobile',
    'dob',
    'state',
    'city',
    'address',
    'role',
    'type',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'_patient';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id','role','name','mobile']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['name'];
    $row[] = $aRow['mobile'];
    $row[] = _d($aRow['dob']);
    if($aRow['dob'] == '0000-00-00')
        $row[] = 'NA';
    else
        $row[] = todayAGE($aRow['dob']);
    $row[] = statename($aRow['state']);
    $row[] = cityname($aRow['city']);
    $row[] = $aRow['address'];
    $row[] = 'By '.$aRow['role'];
    //$row[] = $this->ci->db->get_where(db_prefix().'patient_type', array('id' => $aRow['type']))->row('name');
    $options = icon_btn('patient/add/' . $aRow['id'], 'pencil-square-o');
    //$options = '';
    $row[]   = $options .= icon_btn('patient/delete_patient/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
