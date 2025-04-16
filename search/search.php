<?php
if (!defined('e107_INIT'))
{
    exit;
}
require_once(e_PLUGIN . 'bug_tracker/includes/bugtracker_class.php');
if (!is_object($bugtrack_obj))
{
    $bugtrack_obj = new bugtracker;
}
$return_fields = 'bugtrack_name,bugtrack_author,bugtrack_body,bugtrack_id,bugtrack_posted,bugtrack_category,bugtrack_app_name,bugtrack_app_id';
$search_fields = array('bugtrack_name', 'bugtrack_author', 'bugtrack_body', 'bugtrack_app_name', 'user_name');
$weights = array('3.0', '1.0', '2.0', '3.0', '1.0');
$no_results = LAN_198;
$where = " ";
$order = array('bugtrack_name' => DESC);
$table = 'bugtrack_bugs
left join #bugtrack_apps on bugtrack_category=bugtrack_app_id
left join #user on bugtrack_assigned=user_id';

$ps = $sch->parsesearch($table, $return_fields, $search_fields, $weights, 'search_bugs', $no_results, $where, $order);
$text .= $ps['text'];
$results = $ps['results'];

function search_bugs($row)
{
    global $con;
    $datestamp = $con->convert_date($row['bugtrack_posted'], 'long');
    $title = $row['bugtrack_name'];
    $tmp = explode(".", $row['bugtrack_author'], 2);
    $link_id = $row['bugtrack_id'];
    $dept = $row['bugtrack_category'];
    $res['link'] = e_PLUGIN . 'bug_tracker/bugs.php?0.item.' . $dept . '.' . $link_id ;
    $res['pre_title'] = $title ?BUGTRACK_80 . ' ' : '';
    $res['title'] = $title ? $title : '';
    $res['summary'] = BUGTRACK_82 . ': ' . substr($row['bugtrack_name'], 0, 30) . '. ' . BUGTRACK_83 . ': ' . substr($row['bugtrack_app_name'], 0, 30);
    $res['detail'] = BUGTRACK_81 . ': ' . $datestamp . ' ' . BUGTRACK_84 . ' ' . $tmp[1];
    return $res;
}

?>