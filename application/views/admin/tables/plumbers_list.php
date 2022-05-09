<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'tblplumber.id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'plumber';
$where        = [
    /*'AND rel_id=3 AND rel_type="plumbers"',*/
];

$join = [
    /*'LEFT JOIN '.db_prefix().'dealer ON '.db_prefix().'plumber.dealer_id ='.db_prefix().'dealer.id',*/
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['tblplumber.id as id','tblplumber.plumber_doj','tblplumber.plumber_name','tblplumber.plumber_dob','tblplumber.plumber_mobile','tblplumber.plumber_email','tblplumber.plumber_gender','tblplumber.plumber_business_name','tblplumber.plumber_pan_number','tblplumber.plumber_aadhar_number','tblplumber.plumber_permanent_address','tblplumber.plumber_state','tblplumber.plumber_city','tblplumber.status']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    /*
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'plumber'))->row('file_name');
    if($filename)
    {
        $row[] = '<img src="'.site_url('uploads/plumbers/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    }
    else
    {
        $row[] = '<img width="50" height="50" alt="">';        
    }
    */
    $row[] = $sn++;
    $row[] = $aRow['plumber_name'];
    $row[] = $aRow['plumber_mobile'];
    $row[] = $aRow['plumber_email'];
    // $row[] = _d($aRow['plumber_dob']);
    // $row[] = _d($aRow['plumber_doj']);
    // $row[] = $aRow['plumber_permanent_address'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('Change status') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'plumbers/change_status" name="onoffswitch" class="onoffswitch-checkbox" onchange="changePlumberstatus(' . $aRow['id'] . ')" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    // $row[] = $toggleActive;
    // $options = '<a href="'.site_url('plumber-view').'/'.$aRow['id'].'" class="btn btn-info btn-icon"><i class="fa fa-eye" aria-hidden="true"></i></a>';
    // $options .= icon_btn('plumbers/add/' . $aRow['id'], 'pencil-square-o');
    // $row[]   = $options .= icon_btn('plumbers/delete_plumbers/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = '<a href="'.site_url('plumber-reward-report').'/'.$aRow['id'].'" class="btn btn-warning btn-icon"><i class="fa fa-gift" aria-hidden="true"></i></a>';

    $output['aaData'][] = $row;
}
