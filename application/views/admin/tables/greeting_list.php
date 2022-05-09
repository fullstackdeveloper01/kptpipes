<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'tblnotifications.id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'notifications';
$where        = [
    'AND isread=0',
];

$join = [
    'LEFT JOIN '.db_prefix().'  ON '.db_prefix().'dealer.distributor_id ='.db_prefix().'distributors.id',
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, 
    [
        'tblnotifications.id as id',
        'tblnotifications.type',
        'tblnotifications.description',
        'tblnotifications.touserid as user_id',
        'tblnotifications.link',
        'tblnotifications.date',
    ]);
$output  = $result['output'];
$rResult = $result['rResult'];
$sn = 1;
foreach ($rResult as $key => $aRow) {
    $row = [];
    $result = databasetable($aRow);
    // print_r($result);
    $filename = $CI->db->get_where($result['table'], ['id'=>$aRow['user_id']])->row_array();
    // print_r($filename);
    $row[] = $key+1;
    $row[] = $aRow['type'];
    $row[] = isset($filename['brand_id'])?brandNames($filename['brand_id']):'';
    $row[] = $filename[$result['name']];
    $row[] = $filename[$result['mobile']];
    $row[] = $filename[$result['email']];
    $row[] = date('d-m-Y',strtotime($aRow['date']));
    // $toggleActive = '<div class="onoffswitch" data-toggle="tooltip" data-title="' . _l('Change status') . '">
    // <input type="checkbox" data-switch-url="' . admin_url() . 'dealers/change_status" name="onoffswitch" class="onoffswitch-checkbox" onchange="changeDealerstatus(' . $aRow['id'] . ')" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['status'] == 1 ? 'checked' : '') . '>
    // <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    // </div>';

    // $toggleActive .= '<span class="hide">' . ($aRow['status'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';

    $options = '<a href="'.site_url('/').'/'.$aRow['link'].'/'.$aRow['id'].'" class="btn btn-warning btn-icon"><i class="fa fa-gift" aria-hidden="true"></i></a>';
    // $options .= '<a href="'.site_url('dealer-reward-report').'/'.$aRow['id'].'" class="btn btn-info btn-icon"><i class="fa fa-file" aria-hidden="true"></i> Reward</a>';
    $row[]  = $options;

    $output['aaData'][] = $row;
}
