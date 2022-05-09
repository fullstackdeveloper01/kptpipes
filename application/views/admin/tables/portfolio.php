<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'tblportfolio.id as id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'portfolio';
$where        = [];

$join = [
    'LEFT JOIN '.db_prefix().'technology ON '.db_prefix().'technology.id ='.db_prefix().'portfolio.technology_id',
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['tblportfolio.id as id','tblportfolio.status as status','project_name','description','technology_id','technology','featured_option']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'portfolio'))->row('file_name');
    $filename_thumbnail = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'portfolio_thumbnail'))->row('file_name');
        
    if($filename_thumbnail != '')        
        $row[] = '<img src="'.site_url('uploads/portfolio_thumbnail/'.$aRow['id'].'/'. $filename_thumbnail).'" width="50" height="50" alt="">';
    else
        $row[] = '<img width="50" height="50" alt="">';
    if($filename != '')        
        $row[] = '<img src="'.site_url('uploads/portfolio/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    else
        $row[] = '<img width="50" height="50" alt="">';
    $row[] = $aRow['project_name'];
    $row[] = technologyname($aRow['technology_id']);
    /*$row[] = '<span class="messagelimit">'.$aRow['description'].'</span>';*/
    $featuredActive = '<div class="onoffswitch" data-toggle="tooltip">
    <input type="checkbox" onclick="manageMenu('.$aRow['id'].')" class="onoffswitch-checkbox" id="f' . $aRow['id'] . '" data-id="f' . $aRow['id'] . '" ' . ($aRow['featured_option'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="f' . $aRow['id'] . '"></label>
    </div>';

    $featuredActive .= '<span class="hide">' . ($aRow['featured_option'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $featuredActive;
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'portfolio/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('portfolio/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('portfolio/delete_portfolio/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
