<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'tblproduct_enquiry.id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'product_enquiry';
$where        = [
    /*'AND rel_id=3 AND rel_type="dealers"',*/
];

$join = [
    'LEFT JOIN '.db_prefix().'distributors ON '.db_prefix().'distributors.id ='.db_prefix().'product_enquiry.distributor_id',
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['tblproduct_enquiry.id as id','tblproduct_enquiry.distributor_id','tblproduct_enquiry.mobile_number','tblproduct_enquiry.product_title','tblproduct_enquiry.product_qty','tblproduct_enquiry.product_price','tblproduct_enquiry.status','tbldistributors.distributor_name']);
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
    $row[] = $aRow['id'];
    $row[] = $aRow['product_title'];
    $row[] = $aRow['distributor_name'];
    $row[] = $aRow['mobile_number'];
    $row[] = $aRow['product_qty'];
    $row[] = $aRow['product_price'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('Change status') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'productEnquiry/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('productEnquiry/details/' . $aRow['id'], 'eye');
    $row[]   = $options .= icon_btn('productEnquiry/delete_dealers/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
