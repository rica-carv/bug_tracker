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
include_lan(e_PLUGIN . 'bug_tracker/languages/' . e_LANGUAGE . '.php');
$config_category = BUGTRACK_A90;
$config_events = array('bugpost' => BUGTRACK_A91);

if (!function_exists('notify_bugpost'))
{
    function notify_bugpost($data)
    {
        global $nt;
        $message = '<strong>' . BUGTRACK_A92 . ': </strong>' . $data['user'] . '<br />';
        $message .= '<strong>' . BUGTRACK_A94 . ':</strong> ' . $data['itemtitle'] . '<br /><br />' . BUGTRACK_A93 ;
        $message .= ' ' . BUGTRACK_A95 . ' ' . $data['catid'] . '<br /><br />';
        $nt->send('bugpost', BUGTRACK_A91, $message);
    }
}

?>