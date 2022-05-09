<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    db_prefix().'products.id as pid',
    db_prefix().'products.brand_id as brand_id',
    'category_id',
    'subcategory_id',
    'isDeleted',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'products';
$where        = [];

$join = [
    'LEFT JOIN '.db_prefix().'brand ON '.db_prefix().'brand.id='.db_prefix().'products.brand_id',
    'LEFT JOIN '.db_prefix().'category ON '.db_prefix().'category.id='.db_prefix().'products.category_id',
    'LEFT JOIN '.db_prefix().'category  as tblsubcategory ON '.db_prefix().'subcategory.id='.db_prefix().'products.subcategory_id',
];

array_push($where, 'AND ('.db_prefix().'products.isDeleted = "0" )');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'products.id as pid',
    'title',
    'price',
    'HSN_code',
    'SKU_number',
    'HSN_code',
    'price',
    'measurement',
    'color',
    'tblproducts.created_date',
    'tblproducts.status as status',
    'tblcategory.name as cname',
    'tblsubcategory.name as scname',
    'tblbrand.brandname as brandname'
]);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $attachment_key = $CI->db->get_where(db_prefix().'files', array('rel_id' => $aRow['pid'], 'rel_type' => "product"))->row('file_name');
    if($attachment_key)
    {
        $row[] = '<img src="'.site_url('uploads/product/'.$aRow['pid'].'/'. $attachment_key).'" width="50" height="50" alt="">';
    }
    else
    {
        $row[] = '<img width="50" height="50" alt="">';
    }
    $row[] = $aRow['title'];
    // $row[] = $aRow['cname'];
    // $row[] = $aRow['scname'];
    $row[] = $aRow['brandname'];
    $row[] = $aRow['HSN_code'];
    $row[] = $aRow['SKU_number'];
    $row[] = $aRow['measurement'];
    $row[] = $aRow['color'];
    $row[] = date('H:i:s d-m-Y',strtotime($aRow['created_date']));

    /*$row[] = $aRow['price'];*/
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('customer_active_inactive_help') . '">
    <input type="checkbox" data-switch-url="' . admin_url() . 'products/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['pid'] . '" data-id="' . $aRow['pid'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['pid'] . '"></label>
    </div>';

    $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $row[] = $toggleActive;
    $options = icon_btn('products/add/' . $aRow['pid'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('products/delete_product/' . $aRow['pid'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
