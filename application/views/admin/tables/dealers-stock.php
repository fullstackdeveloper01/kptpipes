<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'tbluser_stock.id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'user_stock';
$where        = [
    'AND tbluser_stock.type="dealer"',
];
$join=[
    'JOIN tbldealer ON tbldealer.id = tbluser_stock.user_id',
    'JOIN tblproducts ON tblproducts.id = tbluser_stock.product_id'
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, 
    [
        'tbluser_stock.id',
        'tbluser_stock.type',
        'tbluser_stock.user_id',
        'tbluser_stock.product_id',
        'tbluser_stock.quantity',
        'tbluser_stock.bach_no',
        'tbldealer.dealer_name as name',
        'tblproducts.title as product',
        'tblproducts.product_variant'

    ]
);
$output  = $result['output'];
$rResult = $result['rResult'];

$sn = 1;
foreach ($rResult as $key => $aRow ) {
    $row = [];

    $row[] = $key+1;
    $row[] = $aRow['name'];
    $row[] = $aRow['type'];
    $row[] = $aRow['product_variant'];
    $row[] = $aRow['bach_no'];
    $row[] = $aRow['quantity'];
    // $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('Change status') . '">
    // <input type="checkbox" data-switch-url="' . admin_url() . 'distributors/change_status" onchange="changeDistributorstatus()" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    // <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    // </div>';

    // $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    // $row[] = $toggleActive;
    // $options = icon_btn('distributors/add/' . $aRow['id'], 'pencil-square-o');
    // $row[]   = $options .= icon_btn('distributors/delete_distributors/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
