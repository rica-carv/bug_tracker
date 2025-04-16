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
return;  //bugs in here
require_once(e_HANDLER . 'userclass_class.php');

require_once(e_HANDLER . 'rate_class.php');
if (!$bugtrack_install = $sql->db_Select('plugin', '*', 'plugin_path = "bug_tracker" AND plugin_installflag = "1" '))
{
    return;
}
require_once(e_PLUGIN.'bug_tracker/includes/bugtracker_class.php');
if (!is_object($bugtrack_obj))
{
    $bugtrack_obj = new bugtracker;
}
if ($bugtrack_obj->bugtracker_reader || $bugtrack_obj->bugtracker_creator || $bugtrack_obj->bugtracker_admin || $bugtrack_obj->bugtracker_dev)
{
    require_once('bugtracker_class.php');
    if (!is_object($bugtrack_obj))
    {
        $bugtrack_obj = new bugtracker;
    }
    $LIST_CAPTION = $arr[0];
    $LIST_DISPLAYSTYLE = ($arr[2] ? '' : 'none');

    $todayarray = getdate();
    $current_day = $todayarray['mday'];
    $current_month = $todayarray['mon'];
    $current_year = $todayarray['year'];
    $current = mktime(0, 0, 0, $current_month, $current_day, $current_year);

    if ($mode == 'new_page' || $mode == 'new_menu')
    {
        $lvisit = $this->getlvisit();
        $qry = ' bugtrack_posted > ' . $lvisit ;
    }
    else
    {
        $qry = 'bugtrack_id > 0';
    }

    $bullet = $this->getBullet($arr[6], $mode);
    $qry = 'select a.*,c.* from #bugtrack_bugs as a
            left join #bugtrack_apps as c on bugtrack_category=bugtrack_app_id
            order by bugtrack_posted desc
			limit 0,' . $arr[7];

    if (!$bugtrack_items = $sql->db_Select_gen($qry, false))
    {
        $LIST_DATA = BUGTRACK_A121;
    }
    else
    {
        while ($row = $sql->db_Fetch())
        {
            $tmp = explode('.', $row['bugtrack_author'],2);
            if ($tmp[0] == '0')
            {
                $AUTHOR = $tmp[1];
            } elseif (is_numeric($tmp[0]) && $tmp[0] != '0')
            {
                $AUTHOR = (USER ? '<a href="' . e_BASE . 'user.php?id.' . $tmp[0] . '">' . $tmp[1] . '</a>' : $tmp[1]);
            }
            else
            {
                $AUTHOR = '';
            }

            $rowheading = $this->parse_heading($row['bugtrack_name'], $mode);
            $ICON = $bullet;
            $HEADING = '<a href="' . e_PLUGIN . 'bug_tracker/bugs.php?0.item.' . $row['bugtrack_category'] . '.' . $row['bugtrack_id'] . '" title="' . $row['bugtrack_name'] . '">' . $rowheading . '</a>';
            $CATEGORY = $row['bugtrack_app_name'];
            $DATE = ($arr[5] ? $this->getListDate($row['bugtrack_posted'], $mode) : '');
            $INFO = '';
            $LIST_DATA[$mode][] = array($ICON, $HEADING, $AUTHOR, $CATEGORY, $DATE, $INFO);
        }
    }
}

?>