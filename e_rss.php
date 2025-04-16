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
// *
// e_rss for bug_tracker
// *
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
global $tp;
// ##### e_rss.php ---------------------------------------------
// get all the categories
$feed['name'] = BUGTRACK_RSS_1;
$feed['url'] = 'bugs';
$feed['topic_id'] = '';
$feed['path'] = 'bug_tracker';
$feed['text'] = BUGTRACK_RSS_2 ;
$feed['class'] = '0';
$feed['limit'] = '9';
$eplug_rss_feed[] = $feed;
// ##### --------------------------------------------------------
// ##### create rss data, return as array $eplug_rss_data -------
$rss = array();

if ($bugtrack_obj->bugtracker_reader || $bugtrack_obj->bugtracker_creator || $bugtrack_obj->bugtracker_admin || $bugtrack_obj->bugtracker_dev)
{
    // get bugs which are visible to this class
    $BUGTRACK_args = "
		select bugtrack_name,bugtrack_body,bugtrack_posted,bugtrack_id,bugtrack_author,bugtrack_status,bugtrack_app_name,bugtrack_app_id
		from #bugtrack_bugs
		left join #bugtrack_apps on bugtrack_app_id = bugtrack_category
		where bugtrack_status =1
		order by bugtrack_posted desc
		LIMIT 0," . $this->limit;

    if ($items = $sql->db_Select_gen($BUGTRACK_args, false))
    {
        $i = 0;
        while ($rowrss = $sql->db_Fetch())
        {
            extract($rowrss);
            $tmp = explode(".", $rowrss['bugtrack_author'], 2);
            $rss[$i]['author'] = "" . $tmp[1] ;
            $rss[$i]['author_email'] = '';
            $rss[$i]['link'] = $e107->base_path . $PLUGINS_DIRECTORY . 'bug_tracker/bugs.php?0.view.' . $rowrss['bugtrack_id'] . '.' . $rowrss['bugtrack_app_id'] ;
            $rss[$i]['linkid'] = $tp->toRss($bugtrack_id, false);
            $rss[$i]['title'] = $tp->toRss($bugtrack_name, false);
            $rss[$i]['description'] = $tp->toRss($bugtrack_body, false);

            $rss[$i]['category_name'] = $tp->toRss($bugtrack_app_name, false) ;
            $rss[$i]['category_link'] = $e107->base_path . $PLUGINS_DIRECTORY . 'bug_tracker/bugs.php?0.item.' . $bugtrack_category_id ;

            $rss[$i]['datestamp'] = $bugtrack_posted;
            $rss[$i]['enc_url'] = '';
            $rss[$i]['enc_leng'] = '';
            $rss[$i]['enc_type'] = '';
            $i++;
        }
    }
    else
    {
        $rss[$i]['author'] = '' . $tmp[1];
        $rss[$i]['author_email'] = '';
        $rss[$i]['link'] = $e107->base_path . $PLUGINS_DIRECTORY . 'bug_tracker/bugs.php';
        $rss[$i]['linkid'] = '';
        $rss[$i]['title'] = BUGTRACK_RSS_5;
        $rss[$i]['description'] = BUGTRACK_RSS_6;
        $rss[$i]['category_name'] = '';
        $rss[$i]['category_link'] = '';
        $rss[$i]['datestamp'] = '';
        $rss[$i]['enc_url'] = '';
        $rss[$i]['enc_leng'] = '';
        $rss[$i]['enc_type'] = '';
    }
}
else
{
    $rss[$i]['author'] = '' . $tmp[1];
    $rss[$i]['author_email'] = '';
    $rss[$i]['link'] = $e107->base_path . $PLUGINS_DIRECTORY . 'bug_tracker/bugs.php';
    $rss[$i]['linkid'] = '';
    $rss[$i]['title'] = BUGTRACK_RSS_3;
    $rss[$i]['description'] = BUGTRACK_RSS_6;
    $rss[$i]['category_name'] = '';
    $rss[$i]['category_link'] = '';
    $rss[$i]['datestamp'] = '';
    $rss[$i]['enc_url'] = '';
    $rss[$i]['enc_leng'] = '';
    $rss[$i]['enc_type'] = '';
}

$eplug_rss_data[] = $rss;

?>