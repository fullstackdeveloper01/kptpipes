<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'distributors';
$where        = [
    /*'AND rel_id=3 AND rel_type="distributors"',*/
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id','brand_id','distributor_doj','distributor_name','distributor_dob','distributor_mobile','distributor_email','distributor_gender','distributor_business_name','distributor_pan_number','distributor_aadhar_number','distributor_GST','distributor_permanent_address','distributor_state','distributor_city','status']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    /*
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'distributor'))->row('file_name');
    if($filename)
    {
        $row[] = '<img src="'.site_url('uploads/distributors/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    }
    else
    {
        $row[] = '<img width="50" height="50" alt="">';        
    }
    */
    $row[] = $aRow['distributor_name'];
    $row[] = $aRow['distributor_business_name'];
    $row[] = $aRow['distributor_mobile'];
    $row[] = $aRow['distributor_email'];
    // $row[] = _d($aRow['distributor_doj']);
    // $row[] = $aRow['distributor_permanent_address'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('Change status') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'distributors/change_status" onchange="changeDistributorstatus(' . $aRow['id'] . ')" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    // $row[] = $toggleActive;

    $options = '<a href="'.site_url('distributor-order-report').'/'.$aRow['id'].'" class="btn btn-info btn-icon"> <i class="fa fa-first-order" aria-hidden="true"></i></a>';
    $options .= '<a href="'.site_url('distributor-reward-report').'/'.$aRow['id'].'" class="btn btn-warning btn-icon"> <i class="fa fa-gift" aria-hidden="true"></i></a>';
    // $options .= icon_btn('distributors/add/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options;
    // $row[]   = $options .= icon_btn('distributors/delete_distributors/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
