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

function print_item($id)
{
    global $sql, $tp, $bugs_shortcodes, $bugtrack_gen,
    $bugtrack_id, $bugtrack_name, $bugtrack_aname, $bugtrack_body, $bugtrack_app_name,
    $bugtrack_status, $bugtrack_priority, $bugtrack_resolution, $bugtrack_flag, $user_name,
    $bugtrack_exampleurl, $bugtrack_devcomment, $bugtrack_admincomment, $bugtrack_posted;
    require_once('bugtracker_class.php');

    if (!is_object($bugtrack_obj))
    {
        $bugtrack_obj = new bugtracker;
    }
    require_once('bugs_shortcodes.php');
    // require_once(e_PLUGIN . "bug_tracker/bugs_shortcodes.php");
    if ($bugtrack_obj->bugtracker_reader || $bugtrack_obj->bugtracker_creator || $bugtrack_obj->bugtracker_admin || $bugtrack_obj->bugtracker_dev)
    {
        require_once(e_HANDLER . 'date_handler.php');
        $bugtrack_gen = new convert;
        $bugtrack_arg = '
			select * from #bugtrack_bugs
			left join #bugtrack_apps on bugtrack_app_id=bugtrack_category
			left join #user on user_id=bugtrack_assigned
			where bugtrack_id="' . intval($id) . '" ';
        if ($sql->db_Select_gen($bugtrack_arg, false))
        {
            $bugtrack_row = $sql->db_Fetch();
            extract($bugtrack_row);
            $bugtrack_tmp = explode(".", $bugtrack_author, 2);
            $bugtrack_aname = $bugtrack_tmp[1];
            if (!isset($BUGTRACK_PRINT_LIST))
            {
                $BUGTRACK_PRINT_LIST = '
			<h1>' . SITENAME . '</h1><br /><h2>' . BUGTRACK_60 . ' {BUGTRACK_ID}</h2><br />
			<strong>' . BUGTRACK_17 . ' - </strong>{BUGTRACK_POSTER}<br />
			' . '<strong>' . BUGTRACK_16 . ' - </strong>{BUGTRACK_NAME=nolink}<br />
			' . '<strong>' . BUGTRACK_18 . ' - </strong>{BUGTRACK_EXPLAIN}<br />
			' . '<strong>' . BUGTRACK_19 . ' - </strong>{BUGTRACK_EXAMPLEURL}<br />
			' . '<strong>' . BUGTRACK_12 . ' - </strong>{BUGTRACK_PRIORITY=nocolour}<br />
			' . '<strong>' . BUGTRACK_20 . ' - </strong>{BUGTRACK_RESOLUTION}<br />
			' . '<strong>' . BUGTRACK_13 . ' - </strong>{BUGTRACK_STATUS}<br />
			' . '<strong>' . BUGTRACK_14 . ' - </strong>{BUGTRACK_ASSIGNEE}<br />
			' . '<strong>' . BUGTRACK_22 . ' - </strong>{BUGTRACK_DEVCOMMENT}<br />';
                if ($bugtrack_obj->bugtracker_dev || $bugtrack_obj->bugtracker_admin)
                {
                    $BUGTRACK_PRINT_LIST .= '<strong>' . BUGTRACK_23 . ' - </strong>{BUGTRACK_ADMINCOMMENT}<br />';
                }
                $BUGTRACK_PRINT_LIST .= '<strong>' . BUGTRACK_24 . ' - </strong>{BUGTRACK_FLAG}<br />
			' . '<strong>' . BUGTRACK_25 . ' - </strong>{BUGTRACK_POSTED=long}<br />';
            }
            $bugtrack_text .= $tp->parseTemplate($BUGTRACK_PRINT_LIST, false, $bugs_shortcodes);
        }
        else
        {
            $bugtrack_text .= BUGTRACK_79;
        }
        // *
    }
    return $bugtrack_text;
}

function email_item($id)
{
    global $sql, $tp, $bugs_shortcodes, $bugtrack_gen,
    $bugtrack_id, $bugtrack_name, $bugtrack_aname, $bugtrack_body, $bugtrack_app_name,
    $bugtrack_status, $bugtrack_priority, $bugtrack_resolution, $bugtrack_flag, $user_name,
    $bugtrack_exampleurl, $bugtrack_devcomment, $bugtrack_admincomment, $bugtrack_posted;
    require_once('bugtracker_class.php');

    if (!is_object($bugtrack_obj))
    {
        $bugtrack_obj = new bugtracker;
    }
    require_once('bugs_shortcodes.php');

    if ($bugtrack_obj->bugtracker_reader || $bugtrack_obj->bugtracker_creator || $bugtrack_obj->bugtracker_admin || $bugtrack_obj->bugtracker_dev)
    {
        require_once(e_HANDLER . 'date_handler.php');
        $bugtrack_gen = new convert;
        $bugtrack_arg = '
			select * from #bugtrack_bugs
			left join #bugtrack_apps on bugtrack_app_id=bugtrack_category
			left join #user on user_id=bugtrack_assigned
			where bugtrack_id="' . $id . '" ';
        if ($sql->db_Select_gen($bugtrack_arg, false))
        {
            $bugtrack_row = $sql->db_Fetch();
            extract($bugtrack_row);
            $bugtrack_tmp = explode('.', $bugtrack_author, 2);
            $bugtrack_aname = $bugtrack_tmp[1];
            if (!isset($BUGTRACK_EMAIL_LIST))
            {
                $BUGTRACK_EMAIL_LIST = '
				<h1>' . SITENAME . '</h1><br /><h2>' . BUGTRACK_60 . ' {BUGTRACK_ID}</h2><br />
				<strong>' . BUGTRACK_17 . ' - </strong>{BUGTRACK_POSTER}<br />
				' . '<strong>' . BUGTRACK_16 . ' - </strong>{BUGTRACK_NAME=nolink}<br />
				' . '<strong>' . BUGTRACK_18 . ' - </strong>{BUGTRACK_EXPLAIN}<br />
				' . '<strong>' . BUGTRACK_19 . ' - </strong>{BUGTRACK_EXAMPLEURL}<br />
				' . '<strong>' . BUGTRACK_12 . ' - </strong>{BUGTRACK_PRIORITY=nocolour}<br />
				' . '<strong>' . BUGTRACK_20 . ' - </strong>{BUGTRACK_RESOLUTION}<br />
				' . '<strong>' . BUGTRACK_13 . ' - </strong>{BUGTRACK_STATUS}<br />
				' . '<strong>' . BUGTRACK_14 . ' - </strong>{BUGTRACK_ASSIGNEE}<br />
				' . '<strong>' . BUGTRACK_22 . ' - </strong>{BUGTRACK_DEVCOMMENT}<br />';
                if ($bugtrack_obj->bugtracker_dev || $bugtrack_obj->bugtracker_admin)
                {
                    $BUGTRACK_EMAIL_LIST .= '<strong>' . BUGTRACK_23 . ' - </strong>{BUGTRACK_ADMINCOMMENT}<br />';
                }
                $BUGTRACK_EMAIL_LIST .= '<strong>' . BUGTRACK_24 . ' - </strong>{BUGTRACK_FLAG}<br />
				' . '<strong>' . BUGTRACK_25 . ' - </strong>{BUGTRACK_POSTED=long}<br />';
            }
            // *
            $bugtrack_text .= $tp->parseTemplate($BUGTRACK_EMAIL_LIST, false, $bugs_shortcodes);
        }
    }
    else
    {
        $bugtrack_text .= BUGTRACK_79;
    }

    return $bugtrack_text;
}

?>