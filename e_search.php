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
require_once(e_HANDLER . 'userclass_class.php');

include_lan(e_PLUGIN . 'bug_tracker/languages/' . e_LANGUAGE . '.php');
$bugtrack_title = BUGTRACK_75;
$search_info[]=array( 'sfile' => e_PLUGIN.'bug_tracker/search/search.php', 'qtype' => $bugtrack_title, 'refpage' => 'bugs.php');
?>