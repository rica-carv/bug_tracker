<?php
/*
+---------------------------------------------------------------+
|        Bug Tracker for e107 v7xx - by Father Barry
|
|        This module for the e107 .7+ website system
|        Copyright Barry Keal 2004-2008
|
|        Released under the terms and conditions of the
|        GNU General Public License (http://gnu.org).
|
+---------------------------------------------------------------+
*/
if (!defined('e107_INIT'))
{
    exit;
}
e107::lan('bug_tracker');
$bugtrack_posts = $sql->db_Count('bugtrack_bugs', '(*)');
$bugtrack_undef = $sql->db_Count('bugtrack_bugs', '(*)', 'where bugtrack_status=1');
if (empty($bugtrack_posts))
{
    $bugtrack_posts = 0;
}
$text .= '<div style="padding-bottom: 2px;"><img src="' . e_PLUGIN . 'bug_tracker/images/bugtrack_16.png" style="width: 16px; height: 16px; vertical-align: bottom;border:0;" alt="" /> ' . BUGTRACK_A119 . ': ' . $bugtrack_posts . '</div>';
$text .= '<div style="padding-bottom: 2px;"><img src="' . e_PLUGIN . 'bug_tracker/images/bugtrack_16.png" style="width: 16px; height: 16px; vertical-align: bottom;border:0;" alt="" /> ' . BUGTRACK_A120 . ': ' . $bugtrack_undef . '</div>';
