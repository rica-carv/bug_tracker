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
require_once(e_PLUGIN . 'bug_tracker/includes/bugtracker_class.php');
if (!is_object($bugtrack_obj))
{
    $bugtrack_obj = new bugtracker;
}
global $sql, $tp, $e107cache;
if ($bugtrack_obj->bugtracker_reader || $bugtrack_obj->bugtracker_creator || $bugtrack_obj->bugtracker_admin || $bugtrack_obj->bugtracker_dev)
{
    $bugtrack_text = $e107cache->retrieve('nq_bugstrack');
    if ($bugtrack_text)
    {
        echo $bugtrack_text;
    }
    else
    {
        $bugtrack_catcount = $sql->db_Count('bugtrack_apps', '(*)');
        $bugtrack_bugopen = $sql->db_Count('bugtrack_bugs', '(*)', 'where bugtrack_status="1"');
        $bugtrack_bugpending = $sql->db_Count('bugtrack_bugs', '(*)', 'where bugtrack_status="2"');
        $bugtrack_bugclosed = $sql->db_Count('bugtrack_bugs', '(*)', 'where bugtrack_status="3"');

        $bugtrack_text =
        BUGTRACK_62 . ' - <strong>' . $bugtrack_catcount . '</strong><br />' .
        BUGTRACK_63 . ' - <strong>' . $bugtrack_bugopen . '</strong><br />' .
        BUGTRACK_64 . ' - <strong>' . $bugtrack_bugpending . '</strong><br />' .
        BUGTRACK_65 . ' - <strong>' . $bugtrack_bugclosed . '</strong><br />
	<a href="' . e_PLUGIN . 'bug_tracker/bugs.php">' . BUGTRACK_66 . '</a>';

        ob_start();
        $ns->tablerender('<img src="'.e_PLUGIN.'bug_tracker/images/bugtrack_16.png" alt="" title=""/> '.BUGTRACK_1, $bugtrack_text);
        $bugtrack_cache = ob_get_flush();
        $e107cache->set('nq_bugstrack', $bugtrack_cache);
    }
}

?>