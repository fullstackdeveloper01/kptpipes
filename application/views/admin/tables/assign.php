<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    db_prefix().'assign.id as id',
    'patient_id',
    'medicien_id',
    'types_of_medicines',
    'drug_dosage',
    'drug_time',
    'from_date',
    'to_date',
    db_prefix().'assign.status as status',
    db_prefix().'_patient.id as p_id',
    db_prefix().'_patient.name as p_name',
    db_prefix().'medicines.name as m_name',
    db_prefix().'assign.created_date as created_date',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix().'assign';
$join = [];

$join = [
    'LEFT JOIN '.db_prefix().'_patient ON '.db_prefix().'_patient.id='.db_prefix().'assign.patient_id',
    'LEFT JOIN '.db_prefix().'medicines ON '.db_prefix().'medicines.id='.db_prefix().'assign.medicien_id',
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [db_prefix().'assign.id as id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['p_name'];
    $row[] = $aRow['m_name'];
    $row[] = $CI->db->get_where(db_prefix().'type_of_medicines', array('id' => $aRow['types_of_medicines']))->row('name');
    $row[] = $aRow['drug_dosage'].' times a day';
    $row[] = $aRow['drug_time'];
    $row[] = _d($aRow['from_date']);
    $row[] = _d($aRow['to_date']);
    //$row[] = $aRow['status'];
    $row[] = _d($aRow['created_date']);
    $options = icon_btn('assign/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('assign/delete_assign/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
