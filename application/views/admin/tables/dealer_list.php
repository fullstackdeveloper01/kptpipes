<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'tbldealer.id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'dealer';
$where        = [
    /*'AND rel_id=3 AND rel_type="dealers"',*/
];

$join = [
    'LEFT JOIN '.db_prefix().'distributors ON '.db_prefix().'dealer.distributor_id ='.db_prefix().'distributors.id',
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['tbldealer.id as id','tbldealer.distributor_id','tbldealer.brand_id','tbldealer.dealer_doj','tbldealer.dealer_name','tbldealer.dealer_dob','tbldealer.dealer_mobile','tbldealer.dealer_email','tbldealer.dealer_gender','tbldealer.dealer_business_name','tbldealer.dealer_pan_number','tbldealer.dealer_aadhar_number','tbldealer.dealer_GST','tbldealer.dealer_permanent_address','tbldealer.dealer_state','tbldealer.dealer_city','tbldealer.status','tbldistributors.distributor_name']);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $aRow) {
    $row = [];
    /*
    $filename = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['id'], 'rel_type' => 'dealer'))->row('file_name');
    if($filename)
    {
        $row[] = '<img src="'.site_url('uploads/dealers/'.$aRow['id'].'/'. $filename).'" width="50" height="50" alt="">';
    }
    else
    {
        $row[] = '<img width="50" height="50" alt="">';        
    }
    */
    $row[] = $aRow['dealer_name'];
    $row[] = $aRow['dealer_business_name'];
    $row[] = $aRow['distributor_name'];
    $row[] = $aRow['dealer_mobile'];
    $row[] = $aRow['dealer_email'];
    // $row[] = _d($aRow['dealer_doj']);
    // $row[] = $aRow['dealer_permanent_address'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('Change status') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'dealers/change_status" name="onoffswitch" class="onoffswitch-checkbox" onchange="changeDealerstatus(' . $aRow['id'] . ')" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    // $row[] = $toggleActive;
    // $options = '<a href="'.site_url('dealer-view').'/'.$aRow['id'].'" class="btn btn-info btn-icon"><i class="fa fa-eye" aria-hidden="true"></i></a>';
    // $options .= icon_btn('dealers/add/' . $aRow['id'], 'pencil-square-o');
    // $row[]   = $options .= icon_btn('dealers/delete_dealers/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $options = '<a href="'.site_url('dealer-order-report').'/'.$aRow['id'].'" class="btn btn-info btn-icon"><i class="fa fa-first-order" aria-hidden="true"></i></a>';
    $options .= '<a href="'.site_url('dealer-reward-report').'/'.$aRow['id'].'" class="btn btn-warning btn-icon"><i class="fa fa-gift" aria-hidden="true"></i></a>';
    $row[]   = $options;

    $output['aaData'][] = $row;
}
