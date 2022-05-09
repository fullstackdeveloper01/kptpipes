<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');
$CI          = & get_instance();
$aColumns = [
    'tblclaim_reward.id',
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'claim_reward';
$where        = [];


array_push($where, 'AND ('.db_prefix().'claim_reward.status = "0" )');

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where,[
    db_prefix().'claim_reward.id',
    db_prefix().'claim_reward.type',
    db_prefix().'claim_reward.user_id',
    db_prefix().'claim_reward.claim_type',
    db_prefix().'claim_reward.points',
    db_prefix().'claim_reward.comment',
    db_prefix().'claim_reward.status',
]);
$output  = $result['output'];
$rResult = $result['rResult'];
$CI= get_instance();
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['type'];
    $res = databasetable($aRow);
    $user =$CI->db->get_where($res['table'],['id'=>$aRow['user_id']])->row($res['name']);
    $row[] = $user;
    $row[] = $aRow['claim_type'];
    $row[] = $aRow['points'];
    if ($aRow['status']==0) {
        $row[] = 'Pending';
    }
    $row[] = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="openModel('.$aRow['id'].')"><i class="fa fa-pencil" aria-hidden="true"></i></button>';

    $output['aaData'][] = $row;
}
