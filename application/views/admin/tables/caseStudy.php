<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'tblcase_study.id as id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'case_study';
$where        = [];

$join = [
    /*'LEFT JOIN '.db_prefix().'technology ON '.db_prefix().'technology.id ='.db_prefix().'caseStudy.technology_id',*/
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['tblcase_study.id as id','tblcase_study.status as status','short_description','description','featured_option','title','designation','client_name']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'caseStudy'))->row('file_name');
    if($filename != '')        
        $row[] = '<img src="'.site_url('uploads/caseStudy/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    else
        $row[] = '<img width="50" height="50" alt="">';
    $row[] = $aRow['client_name'];
    $row[] = $aRow['designation'];
    $row[] = $aRow['title'];
    $row[] = '<span class="messagelimit">'.$aRow['short_description'].'</span>';
    $featuredActive = '<div class="onoffswitch" data-toggle="tooltip">
    <input type="checkbox" onclick="manageMenu('.$aRow['id'].')" class="onoffswitch-checkbox" id="f' . $aRow['id'] . '" data-id="f' . $aRow['id'] . '" ' . ($aRow['featured_option'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="f' . $aRow['id'] . '"></label>
    </div>';

    $featuredActive .= '<span class="hide">' . ($aRow['featured_option'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $featuredActive;
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'caseStudy/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('caseStudy/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('caseStudy/delete_caseStudy/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
