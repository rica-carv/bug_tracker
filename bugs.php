<?php
// **************************************************************************
// *
// *  Bug Tracker for e107 v7
// *
// **************************************************************************
require_once('../../class2.php');
if (!defined('e107_INIT'))
{
    exit;
}

if (!is_object($bugtrack_obj))
{
    require_once(e_PLUGIN . 'bug_tracker/includes/bugtracker_class.php');
    $bugtrack_obj = new bugtracker;
}
// get template
/*
if (is_readable(THEME . 'bugs_template.php'))
{
    define('BUGTRACK_THEME', THEME . 'bugs_template.php');
}
else
{
    define('BUGTRACK_THEME', e_PLUGIN . 'bug_tracker/templates/bugs_template.php');
}
*/
//$HDU_LISTTICKETS = e107::getTemplate('bug_tracker', 'bugs_template');
$bugs_template = e107::getTemplate('bug_tracker', 'bugs');

define('BUGTRACK_IMAGES', SITEURL . $PLUGINS_DIRECTORY . 'bug_tracker');
require_once(e_PLUGIN . 'bug_tracker/includes/bugs_shortcodes.php');
require_once(e_HANDLER . 'comment_class.php');
$cobj = new comment;
// $rater = new rater;
// *
$bugtrack_gen = new convert;

/*
var_dump(is_object($bugtrack_obj));
var_dump($bugtrack_obj->bugtracker_reader);
var_dump($bugtrack_obj->bugtracker_admin);
var_dump($bugtrack_obj->bugtracker_creator);
var_dump($bugtrack_obj->bugtracker_dev);
*/
if (!$bugtrack_obj->bugtracker_reader && !$bugtrack_obj->bugtracker_admin && !$bugtrack_obj->bugtracker_creator && !$bugtrack_obj->bugtracker_dev)
{
    // Check that valid user class to do this if not tell them
    // ie they must be able to read or post or admin or be a dev
    $bugtrack_text = "
<table style='" . USER_WIDTH . ";' class='fborder'>
	<tr>
		<td class='fcaption'>" . BUGTRACK_1 . "</td>
	</tr>
	<tr>
		<td class='forumheader3'>" . BUGTRACK_2 . "</td>
	</tr>
	<tr>
		<td class='forumheader2'><a href='" . SITEURL . "index.php'>" . BUGTRACK_66 . "</a></td>
	</tr>
	<tr>
		<td class='fcaption'>&nbsp;</td>
	</tr>
</table>";
    require_once(HEADERF);
    $ns->tablerender(BUGTRACK_1, $bugtrack_text);
    require_once(FOOTERF);
    exit;
}
$bugtrack_statusarray = explode(',', BUGTRACK_STATUS);
$bugtrack_resarray = explode(',', BUGTRACK_RESOLUTION);
$bugtrack_flagarray = explode(',', BUGTRACK_FLAG);
$bugtrack_colourarray = explode(",", $BUGTRACK_PREF['bugtrack_colours']);
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $bugtrack_from = intval($_POST['bugtrack_from']);
    $bugtrack_action = $_POST['bugtrack_action'];
    $bugtrack_bugid = intval($_POST['bugtrack_bugid']);
    $bugtrack_bugapp = intval($_POST['bugtrack_bugapp']);
} elseif (e_QUERY)
{
    $tmp = explode('.', e_QUERY);
    $bugtrack_from = intval($tmp[0]);
    $bugtrack_action = $tmp[1];
    $bugtrack_bugapp = intval($tmp[2]);
    $bugtrack_bugid = intval($tmp[3]);
    $bugtrack_tmpf = intval($tmp[4]);
}
$bugtrack_from = ($bugtrack_from > 0?$bugtrack_from:0);
$bugtrack_bugapp = (is_numeric($bugtrack_bugapp)?$bugtrack_bugapp:0);
$bugtrack_bugid = (is_numeric($bugtrack_bugid)?$bugtrack_bugid:0);
$bugtrack_action = (empty($bugtrack_action)?"show":$bugtrack_action);

if ($_POST['bugtrack_select'] > 0)
{
    $bugtrack_bugapp = $_POST['bugtrack_select'];
}
if (isset($_POST['commentsubmit']))
{
    $clean_authorname = $_POST['author_name'];
    $clean_comment = $_POST['comment'];
    $clean_subject = $_POST['subject'];
    $tmp = explode('.', e_QUERY);
    $bugtrack_from = $tmp[0];
    $bugtrack_action = $tmp[1];
    $bugtrack_bugapp = $tmp[2];
    $bugtrack_bugid = $tmp[3];
    $cobj->enter_comment($clean_authorname, $clean_comment, 'bugs', $bugtrack_bugid, $pid, $clean_subject);
    bugtrack_notify($bugtrack_bugid, $bugtrack_bugapp, 'comment');
    $bugtrack_action = 'item';
    $e107cache->clear('nq_bugstrack');
}

switch ($bugtrack_action)
{
    case 'subopt':
        {
            if ($bugtrack_obj->bugtracker_admin || $bugtrack_obj->bugtracker_dev)
            {
                $bugtrack_arg = "
		bugtrack_name='" . $tp->toDB($_POST['bugtrack_name']) . "',
		bugtrack_body='" . $tp->toDB($_POST['bugtrack_body']) . "',
		bugtrack_category='" . $tp->toDB($_POST['bugtrack_category']) . "',
		bugtrack_status='" . $tp->toDB($_POST['bugtrack_status']) . "',
		bugtrack_priority='" . $tp->toDB($_POST['bugtrack_priority']) . "',
		bugtrack_resolution='" . $tp->toDB($_POST['bugtrack_resolution']) . "',
		bugtrack_flag='" . $tp->toDB($_POST['bugtrack_flag']) . "',
		bugtrack_assigned='" . $tp->toDB($_POST['bugtrack_assigned']) . "',
		bugtrack_exampleurl='" . $tp->toDB($_POST['bugtrack_exampleurl']) . "',
		bugtrack_devcomment='" . $tp->toDB($_POST['bugtrack_devcomment']) . "',
		bugtrack_admincomment='" . $tp->toDB($_POST['bugtrack_admincomment']) . "'
		where bugtrack_id=$bugtrack_bugid";
                // mysql update - returns false if no update (ie duplicate post)
                $bugtrak_inserted = $sql->db_Update('bugtrack_bugs', $bugtrack_arg, false);
                if ($bugtrak_inserted)
                {
                    $bugtrack_arg = 'bugtrack_lastup=' . time() . ' where bugtrack_id=' . $bugtrack_bugid . '';
                    $sql->db_Update('bugtrack_bugs', $bugtrack_arg, false);
                    bugtrack_notify($bugtrack_bugid, $bugtrack_bugapp, 'change');
                }
////////                require_once(BUGTRACK_THEME);
////////                $bugtrack_text .= $tp->parseTemplate($BUGTRACK_OPTSUBMITTED_HEADER, false, $bugs_shortcodes);
                $bugtrack_text .= $tp->parseTemplate($bugs_template['OPTSUBMITTED_HEADER'], false, $bugs_shortcodes);
                if ($BUGTRACK_PREF['cachestatus'] == 1)
                {
                    $e107cache->clear('nq_bugstrack');
                }
            }
        }
        break;
    case 'opt':
        {
            if (!$bugtrack_obj->bugtracker_creator && !$bugtrack_obj->bugtracker_admin && !$bugtrack_obj->bugtracker_dev)
                // Check that valid user class to do this if not tell them
                {
                    require_once(HEADERF);
                $bugtrack_text = '
<table style="' . USER_WIDTH . '" class="fborder">
	<tr>
		<td class="fcaption">' . BUGTRACK_1 . '</td>
	</tr>
	<tr>
		<td class="forumheader3">' . BUGTRACK_67 . '</td>
	</tr>
	<tr>
		<td class="fcaption"><a href="' . SITEURL . 'index.php">' . BUGTRACK_66 . '</a></td>
	</tr>
</table>';
                $ns->tablerender(BUGTRACK_1, $bugtrack_text);
                require_once(FOOTERF);
                exit;
            }
            else
            {
                $bugtrack_text .= "
				<script type=\"text/javascript\">
			function bugcheckform(thisform)
			{
				var testresults=true;
				if (thisform.bugtrack_name.value=='' || thisform.bugtrack_body.value=='')
				{
					alert('" . BUGTRACK_41 . "');
					testresults=false;
				}
				if (testresults)
				{
					if (thisform.subbed.value=='no')
	  				{
						thisform.subbed.value='yes';
				   		testresults=true;
					}
					else
					{
		   				alert('" . BUGTRACK_42 . "');
				   		return false;
			   		}
				}
				return testresults;
			}
		</script>

<form id='bugtrack_form' action='" . e_SELF . "' method='post' onsubmit='return bugcheckform(this)'>
	<div>
		<input type='hidden' name='bugtrack_from' value='$bugtrack_from' />
		<input type='hidden' name='bugtrack_bugid' value='$bugtrack_bugid' />
		<input type='hidden' name='bugtrack_bugapp' value='$bugtrack_bugapp' />
		<input type='hidden' name='subbed' value='no' />
		<input type='hidden' name='bugtrack_action' value='subopt' />
	</div>";
                $bugtrack_arg = "
			select * from #bugtrack_bugs
			left join #bugtrack_apps on bugtrack_app_id=bugtrack_category
			where bugtrack_id='$bugtrack_bugid' ";
                if ($sql->db_Select_gen($bugtrack_arg, false))
                {
                    $row = $sql->db_Fetch();
                    extract($row);
                }
/////////////                require_once(BUGTRACK_THEME);
/////////////                $bugtrack_text .= $tp->parseTemplate($BUGTRACK_OPT_FORM, false, $bugs_shortcodes);
                $bugtrack_text .= $tp->parseTemplate($bugs_template['OPT_FORM'], false, $bugs_shortcodes);
                $bugtrack_text .= '</form>';
            }
        }
        break;
    case 'submitit':
        {
            if ($bugtrack_obj->bugtracker_creator || $bugtrack_obj->bugtracker_admin || $bugtrack_obj->bugtracker_dev)
            {
                $bugtrack_author = USERID . '.' . USERNAME;
                if ($sql->db_Select('bugtrack_bugs', '*',
                        "bugtrack_name='" . $tp->toDB($_POST['bugtrack_name']) . "' and
                     bugtrack_author='" . $tp->toDB($bugtrack_author) . "' and
					 bugtrack_body='" . $tp->toDB($_POST['bugtrack_body']) . "' and
					 bugtrack_priority='" . $tp->toDB($_POST['bugtrack_priority']) . "'"))
                {
                    // A record with these details exists
                    $bugtrak_inserted = -1;
                }
                else
                {
                    $bugtrack_arg = "
		0,
		'" . $tp->toDB($_POST['bugtrack_name']) . "',
		'" . $tp->toDB($bugtrack_author) . "',
		'" . $tp->toDB($_POST['bugtrack_body']) . "',
		'" . $tp->toDB($_POST['bugtrack_category']) . "',
		1,
		'" . $tp->toDB($_POST['bugtrack_priority']) . "',
		1,
		0,
		0,
		'" . $tp->toDB($_POST['bugtrack_exampleurl']) . "',
		'',
		''," . time() . ",0";
                    $bugtrak_inserted = $sql->db_Insert('bugtrack_bugs', $bugtrack_arg, false);
                }
                bugtrack_notify($bugtrak_inserted, $bugtrack_bugapp, 'new');
/////////////                require_once(BUGTRACK_THEME);
/////////////                $bugtrack_text .= $tp->parseTemplate($BUGTRACK_SUBMITTED_HEADER, false, $bugs_shortcodes);
                $bugtrack_text .= $tp->parseTemplate($bugs_template['SUBMITTED_HEADER'], false, $bugs_shortcodes);
                $bugtrack_sn = array('user' => USERNAME, 'itemtitle' => $_POST['bugtrack_name'], 'catid' => intval($bugtrak_inserted));
                $e_event->trigger('bugpost', $bugtrack_sn);
                $e107cache->clear('nq_bugstrack');
            }
        }
        break;
    case 'new':
        {
            if (!$bugtrack_obj->bugtracker_creator && !$bugtrack_obj->bugtracker_admin && !$bugtrack_obj->bugtracker_dev)
                // Check that valid user class to do this if not tell them
                {
                    require_once(HEADERF);
                $bugtrack_text = '
<table style="' . USER_WIDTH . '" class="fborder">
	<tr>
		<td class="fcaption">' . BUGTRACK_1 . '</td>
	</tr>
	<tr>
		<td class="forumheader3">' . BUGTRACK_76 . '</td>
	</tr>
	<tr>
		<td class="fcaption"><a href="' . SITEURL . 'index.php">' . BUGTRACK_66 . '</a></td>
	</tr>
</table>';
                $ns->tablerender(BUGTRACK_1, $bugtrack_text);
                require_once(FOOTERF);
                exit;
            }
            else
            {
                $bugtrack_text .= "
				<script type=\"text/javascript\">
			function bugcheckform(thisform)
			{
				var testresults=true;
				if (thisform.bugtrack_name.value=='' || thisform.bugtrack_body.value=='')
				{
					alert('" . BUGTRACK_41 . "');
					testresults=false;
				}
				if (testresults)
				{
					if (thisform.subbed.value=='no')
	  				{
						thisform.subbed.value='yes';
				   		testresults=true;
					}
					else
					{
		   				alert('" . BUGTRACK_42 . "');
				   		return false;
			   		}
				}
				return testresults;
			}
		</script>

			<form id='bugtrack_form' action='" . e_SELF . "' method='post' onsubmit='return bugcheckform(this)'>
			<div>
				<input type='hidden' name='bugtrack_from' value='$bugtrack_from' />
				<input type='hidden' name='bugtrack_bugid' value='$bugtrack_bugid' />
				<input type='hidden' name='bugtrack_bugapp' value='$bugtrack_bugapp' />
				<input type='hidden' name='subbed' value='no' />
				<input type='hidden' name='bugtrack_action' value='submitit' />
			</div>";
/////////////                require_once(BUGTRACK_THEME);
/////////////                $bugtrack_text .= $tp->parseTemplate($BUGTRACK_SUBMIT_FORM, false, $bugs_shortcodes);
                $bugtrack_text .= $tp->parseTemplate($bugs_template['SUBMIT_FORM'], false, $bugs_shortcodes);

                $bugtrack_text .= '</form>';
            }
        }
        break;
    case 'item':
        {
/////////////            require_once(BUGTRACK_THEME);
/////////////            $bugtrack_text .= $tp->parseTemplate($BUGTRACK_SUBMIT_FORM, false, $bugs_shortcodes);
            $bugtrack_text .= $tp->parseTemplate($bugs_template['ITEM_HEADER'], false, $bugs_shortcodes);
            $bugtrack_arg = '
			select * from #bugtrack_bugs
			left join #bugtrack_apps on bugtrack_app_id=bugtrack_category
			left join #user on user_id=bugtrack_assigned
			where bugtrack_id="' . $bugtrack_bugid . '"';
            if ($sql->db_Select_gen($bugtrack_arg, false))
            {
                $bugtrack_row = $sql->db_Fetch();
                extract($bugtrack_row);
                $bugtrack_tmp = explode('.', $bugtrack_author);
                $bugtrack_aname = $bugtrack_tmp[1];
/////////////                $bugtrack_text .= $tp->parseTemplate($BUGTRACK_ITEM_LIST, false, $bugs_shortcodes);
                $bugtrack_text .= $tp->parseTemplate($bugs_template['ITEM_LIST'], false, $bugs_shortcodes);
            }
            else
            {
                $bugtrack_text .= '
		<tr>
			<td class="forumheader3" colspan="5" style="width:30%;vertical-align:top;">' . BUGTRACK_55 . '</td>
		</tr>
		<tr>
			<td class="fcaption" colspan="2"><a href="?$0.show.0.0.0">' . BUGTRACK_15 . '</a></td></tr>';
            }
//////////////            $bugtrack_text .= $tp->parseTemplate($BUGTRACK_ITEM_FOOTER, false, $bugs_shortcodes);
            $bugtrack_text .= $tp->parseTemplate($bugs_template['ITEM_FOOTER'], false, $bugs_shortcodes);
            $bugtrack_page = $bugtrack_app_name . ' #' . $bugtrack_id;
            $bugtrack_comon = true;
        }
        break;
    case 'view':
        {
            $bugtrack_fresolution = -1;

            if (isset($_POST['bugtrack_fresolution']) && $_POST['bugtrack_fresolution'] >= 0)
            {
                $bugtrack_fresolution = $_POST['bugtrack_fresolution'];
                $bugtrack_fad .= " and bugtrack_resolution='" . $_POST['bugtrack_fresolution'] . "'";
            }
            $bugtrack_fstatus = -1;
            if (isset($_POST['bugtrack_fstatus']) && $_POST['bugtrack_fstatus'] >= 0)
            {
                $bugtrack_fstatus = $_POST['bugtrack_fstatus'];
                $bugtrack_fad .= " and bugtrack_status='" . $_POST['bugtrack_fstatus'] . "'";
            }
            $bugtrack_fassigned = 0;
            if (isset($_POST['bugtrack_fassigned']))
            {
                if ($_POST['bugtrack_fassigned'] == -2)
                {
                    // my posts
                    $bugtrack_fad .= " and bugtrack_assigned='" . 0 . "'";
                    $bugtrack_fassigned = -2;
                }
                if ($_POST['bugtrack_fassigned'] == -1)
                {
                    // my posts
                    $bugtrack_fad .= "and SUBSTRING_INDEX(bugtrack_author,'.',1)='" . USERID . "'";
                    $bugtrack_fassigned = -1;
                }
                if ($_POST['bugtrack_fassigned'] > 0)
                {
                    $bugtrack_fad .= " and bugtrack_assigned='" . $_POST['bugtrack_fassigned'] . "'";

                    $bugtrack_fassigned = $_POST['bugtrack_fassigned'];
                }
            }
            $sql->db_Select('bugtrack_apps', '*', 'where bugtrack_app_id=' . $bugtrack_bugapp, 'nowhere', false);
            $bugtrack_row = $sql->db_Fetch();
            extract($bugtrack_row);
            $bugtrack_text .= '
<form id="bugfilt" action="' . e_SELF . '" method="post">
	<div>
		<input type="hidden" name="bugtrack_action" value="view" />
		<input type="hidden" name="bugtrack_from" value="' . $bugtrack_from . '" />
		<input type="hidden" name="bugtrack_bugid" value="' . $bugtrack_bugid . '" />
		<input type="hidden" name="bugtrack_bugapp" value="' . $bugtrack_bugapp . '" />
	</div>
			';
/////////////            require_once(BUGTRACK_THEME);
/////////////            $bugtrack_text .= $tp->parseTemplate($BUGTRACK_SHOW_HEADER, false, $bugs_shortcodes);
            $bugtrack_text .= $tp->parseTemplate($bugs_template['SHOW_HEADER'], false, $bugs_shortcodes);
            // print $bugtrack_fad;
            $bugtrack_arg = "
			select * from #bugtrack_bugs
			left join #bugtrack_apps on bugtrack_app_id=bugtrack_category
			left join #user on user_id=bugtrack_assigned
			where bugtrack_category='$bugtrack_bugapp'" . $bugtrack_fad . "
			order by bugtrack_id desc
			limit " . $bugtrack_from . ',' . $BUGTRACK_PREF['bugtrack_perpage'];
            if ($sql->db_Select_gen($bugtrack_arg, false))
            {
                while ($bugtrack_row = $sql->db_Fetch())
                {
                    extract($bugtrack_row);
                    $bugtrack_bugapp = $bugtrack_category;
                    $bugtrack_bugid = $bugtrack_id;
                    $bugtrack_tmp = explode(".", $bugtrack_author);
                    $bugtrack_aname = $bugtrack_tmp[1];
//////////////                    $bugtrack_text .= $tp->parseTemplate($BUGTRACK_SHOW_LIST, false, $bugs_shortcodes);
                    $bugtrack_text .= $tp->parseTemplate($bugs_template['SHOW_LIST'], false, $bugs_shortcodes);
                }
            }
            else
            {
                $bugtrack_text .= '
		<tr>
			<td class="forumheader3" colspan="7" style="width:30%;vertical-align:top;">' . BUGTRACK_55 . '</td>
		</tr>';
            }
            $bugtrack_count = $sql->db_Count('bugtrack_bugs', '(*)', 'where bugtrack_category=' . $bugtrack_bugapp, false);
            $bugtrack_perpage = $BUGTRACK_PREF['bugtrack_perpage'];
            $bugtrack_npa = 'view';
//////////////            $bugtrack_text .= $tp->parseTemplate($BUGTRACK_SHOW_FOOTER, false, $bugs_shortcodes);
            $bugtrack_text .= $tp->parseTemplate($bugs_template['SHOW_FOOTER'], false, $bugs_shortcodes);
        }
        $bugtrack_text .= '
</form>';
        $bugtrack_page = $bugtrack_app_name;
        break;
    case'show':
    default:
        {
            if ($bugtrack_cache = $e107cache->retrieve('bugtrack'))
            {
                require_once(HEADERF);
                echo $bugtrack_cache;
            }
            else
            {
/////////////                require_once(BUGTRACK_THEME);
/////////////                $bugtrack_text .= $tp->parseTemplate($BUGTRACK_LIST_TABLE, false, $bugs_shortcodes);
                $bugtrack_text .= $tp->parseTemplate($bugs_template['LIST_TABLE'], false, $bugs_shortcodes);
                $bugtrack_arg = "select a.*,b.user_name from #bugtrack_apps as a
            left join #user as b on bugtrack_app_developer=user_id
            order by bugtrack_app_name
			limit " . $bugtrack_from . "," . $BUGTRACK_PREF['bugtrack_inmenu'];
                if ($sql->db_Select_gen($bugtrack_arg, false))
                {
                    while ($bugtrack_row = $sql->db_Fetch())
                    {
                        extract($bugtrack_row);
                        // Count up the statistics
                        $bugtrack_open = $sql2->db_Count('bugtrack_bugs', '(*)', 'where bugtrack_category=' . $bugtrack_app_id . ' and bugtrack_status=1', false);
                        $bugtrack_closed = $sql2->db_Count('bugtrack_bugs', '(*)', 'where bugtrack_category=' . $bugtrack_app_id . ' and bugtrack_status=3', false);
                        $bugtrack_pending = $sql2->db_Count('bugtrack_bugs', '(*)', 'where bugtrack_category=' . $bugtrack_app_id . ' and bugtrack_status=2', false);
                        $bugtrack_total = $bugtrack_open + $bugtrack_closed + $bugtrack_pending;
                        $bugtrack_bugapp = $bugtrack_app_id;
/////////////                        $bugtrack_text .= $tp->parseTemplate($BUGTRACK_LIST_LIST, false, $bugs_shortcodes);
                        $bugtrack_text .= $tp->parseTemplate($bugs_template['LIST_LIST'], false, $bugs_shortcodes);
                    } // while
                }
                else
                {
/////////////                    $bugtrack_text .= $tp->parseTemplate($BUGTRACK_LIST_NOBUG, false, $bugs_shortcodes);
                    $bugtrack_text .= $tp->parseTemplate($bugs_template['LIST_NOBUG'], false, $bugs_shortcodes);
                }

                $bugtrack_count = $sql->db_Count('bugtrack_apps', '(*)');
                $bugtrack_perpage = $BUGTRACK_PREF['bugtrack_inmenu'];
                $bugtrack_npa = 'show';
/////////////                $bugtrack_text .= $tp->parseTemplate($BUGTRACK_LIST_FOOTER, false, $bugs_shortcodes);
                $bugtrack_text .= $tp->parseTemplate($bugs_template['LIST_FOOTER'], false, $bugs_shortcodes);
                $bugtrack_page = BUGTRACK_9;
                require_once(HEADERF);

                ob_start();
                $ns->tablerender(BUGTRACK_1, $bugtrack_text);
                $bugtrack_cache = ob_get_flush();
                $e107cache->set('bugtrack', $bugtrack_cache);
            }
        }
} // switch
if ($bugtrack_action != 'show')
{
    define('e_PAGETITLE', BUGTRACK_85 . ' - ' . $bugtrack_page);
    if (!empty($BUGTRACK_PREF['bugtrack_metad']))
    {
        define('META_DESCRIPTION', $BUGTRACK_PREF['bugtrack_metad']);
    }
    if (!empty($BUGTRACK_PREF['bugtrack_metak']))
    {
        define('META_KEYWORDS', $BUGTRACK_PREF['bugtrack_metak']);
    }
    require_once(HEADERF);
    $ns->tablerender(BUGTRACK_1, $bugtrack_text);
}
if ($bugtrack_comon)
{
    $cobj->compose_comment('bugs', 'comment', $bugtrack_bugid, $width, 'Additional', $showrate = false);
}

require_once(FOOTERF);
// *
// * Functions
// *
function bugtrack_notify($bug_id, $bugg_appid, $action)
{
    global $pref, $tp, $sql2, $PLUGINS_DIRECTORY, $BUGTRACK_PREF, $sysprefs, $pm_prefs;
    require_once(e_HANDLER . 'mail.php');
    $retrieve_prefs[] = 'pm_prefs';
    require_once(e_PLUGIN . 'pm/pm_class.php');
    require_once(e_PLUGIN . 'pm/pm_func.php');
    $lan_file = e_PLUGIN . 'pm/languages/' . e_LANGUAGE . '.php';
    include_once(is_readable($lan_file) ? $lan_file : e_PLUGIN . 'pm/languages/English.php');
    $pm_prefs = $sysprefs->getArray('pm_prefs');
    $bugtrack_pmfrom = ($BUGTRACK_PREF['bugtrack_pmas'] > 0?$BUGTRACK_PREF['bugtrack_pmas']:1);
    $bugtrack_pm = new private_message;
    $bugtrack_arg = "select b.*,a.*,u.*,x.user_class as devclass,x.user_name as devname,x.user_email as devemail ,y.user_name as leadname,y.user_email as leademail,y.user_class as leadclass from #bugtrack_bugs as b
        left join #bugtrack_apps as a on bugtrack_category=bugtrack_app_id
        left join #user as u on  SUBSTRING_INDEX(bugtrack_author,'.',1) = u.user_id
        left join #user as x on bugtrack_assigned=x.user_id
        left join #user as y on bugtrack_app_developer=y.user_id
        where bugtrack_id=$bug_id";
    $sql2->db_Select_gen($bugtrack_arg, false);
    $bugtrack_data = $sql2->db_Fetch();
    extract($bugtrack_data);
    $bugtrack_head = "<h2>" . BUGTRACK_M03 . " " . SITENAME . "</h2><hr /><br /><h3>" . BUGTRACK_M04 . "</h3><br />";
    $bugtrack_link = "<br /><br />" . BUGTRACK_M01 . "<br /><a href='" . SITEURL . $PLUGINS_DIRECTORY . "bug_tracker/bugs.php?0.item.$bugg_appid.$bug_id'>" . BUGTRACK_M02 . "</a>";
    $bugtrack_tmp = explode(".", $bugtrack_author);
    $bugtrack_info = BUGTRACK_M05 . " <strong>" . $bugtrack_tmp[1] . "</strong> " . BUGTRACK_M06 . " <strong>" . $bugtrack_app_name . ".</strong><br /><br />" . BUGTRACK_M07 . " " . $bugtrack_id . "<br /><br />";
    $bugtrack_sender = (!empty($BUGTRACK_PREF['bugtrack_sender'])?$BUGTRACK_PREF['bugtrack_sender']:$BUGTRACK_PREF['siteadmin']);
    $bugtrack_email = (!empty($BUGTRACK_PREF['bugtrack_email'])?$BUGTRACK_PREF['bugtrack_email']:$BUGTRACK_PREF['siteadminemail']);
    switch ($action)
    {
        case 'comment':
            $bugtrack_message = BUGTRACK_M08 . ' ';
            break;
        case 'new':
            $bugtrack_message = BUGTRACK_M09 . " {$bug_id} " . BUGTRACK_M010;
            break;
        case 'change':
            $bugtrack_message = BUGTRACK_M02 . " {$bug_id} " . BUGTRACK_M011;
            break;
        default: ;
    } // switch
    $message = $bugtrack_head . $bugtrack_info . $bugtrack_message . $bugtrack_link;
    if ($BUGTRACK_PREF['bugtrack_notifyuser'] == 1)
    {
        // Email User
        if (!empty($user_name) && !empty($user_email))
        {
            $bug_to = $user_email;
            $subject = BUGTRACK_M02 . " " . BUGTRACK_M013;
            $bug_toname = $user_name;
            sendemail($bug_to, $subject, $message, $bug_toname, $bugtrack_email , $bugtrack_sender);
        }
    }

    if ($BUGTRACK_PREF['bugtrack_notifyuser'] == 2)
    {
        // PM User
        if ($user_id > 0)
        {
            $bugtrack_vars['pm_subject'] = BUGTRACK_M02 . " " . BUGTRACK_M013;
            $bugtrack_vars['pm_message'] = $message;
            $bugtrack_vars['to_info']['user_id'] = $user_id;
            $bugtrack_vars['from_id'] = $bugtrack_pmfrom;
            $bugtrack_vars['to_info']['user_email'] = $user_email;
            $bugtrack_vars['to_info']['user_name'] = $user_name;
            $bugtrack_vars['to_info']['user_class'] = $user_class;
            $pmsave = $pref['post_html'];
            $pref['post_html'] = 0;
            $res = $bugtrack_pm->add($bugtrack_vars);
            $pref['post_html'] = $pmsave;
        }
    }
    if ($BUGTRACK_PREF['bugtrack_notifyteam'] == 1)
    {
        // Email Team
        if (!empty($devname) && !empty($devemail))
        {
            $bug_to = $devemail;
            $subject = BUGTRACK_M02 . ' ' . BUGTRACK_M012;
            $bug_toname = $devname;
            sendemail($bug_to, $subject, $message, $bug_toname, $bugtrack_email , $bugtrack_sender);
        }
    }
    if ($BUGTRACK_PREF['bugtrack_notifyteam'] == 2)
    {
        // PM Team
        if ($bugtrack_assigned > 0)
        {
            $bugtrack_vars['pm_subject'] = BUGTRACK_M02 . " " . BUGTRACK_M012;
            $bugtrack_vars['pm_message'] = $message;
            $bugtrack_vars['to_info']['user_id'] = $bugtrack_assigned;
            $bugtrack_vars['from_id'] = $bugtrack_pmfrom;
            $bugtrack_vars['to_info']['user_email'] = $devemail;
            $bugtrack_vars['to_info']['user_name'] = $devname;
            $bugtrack_vars['to_info']['user_class'] = $devclass;
            $pmsave = $pref['post_html'];
            $pref['post_html'] = 0;
            $res = $bugtrack_pm->add($bugtrack_vars);
            $pref['post_html'] = $pmsave;
        }
    }
    if ($BUGTRACK_PREF['bugtrack_notifyleader'] == 1)
    {
        // Email Leader
        if (!empty($leadname) && !empty($leademail))
        {
            $bug_to = $leademail;
            $subject = BUGTRACK_M02 . " " . BUGTRACK_M014;
            $bug_toname = $leadname;
            sendemail($bug_to, $subject, $message, $bug_toname, $bugtrack_email , $bugtrack_sender);
        }
    }
    if ($BUGTRACK_PREF['bugtrack_notifyleader'] == 2)
    {
        // PM Leader
        if ($bugtrack_app_developer > 0)
        {
            $bugtrack_vars['pm_subject'] = BUGTRACK_M02 . " " . BUGTRACK_M014;
            $bugtrack_vars['pm_message'] = $message;
            $bugtrack_vars['to_info']['user_id'] = $bugtrack_app_developer;
            $bugtrack_vars['to_info']['user_email'] = $leademail;
            $bugtrack_vars['to_info']['user_name'] = $leadname;
            $bugtrack_vars['to_info']['user_class'] = $leadclass;
            $bugtrack_vars['from_id'] = $bugtrack_pmfrom;
            $pmsave = $pref['post_html'];
            $pref['post_html'] = 0;
            $res = $bugtrack_pm->add($bugtrack_vars);
            $pref['post_html'] = $pmsave;
            // $res = add($bugtrack_vars);
        }
    }
}
function add($vars)
{
    global $pref, $pm_prefs, $tp, $sql;
    // die("W");
    $pref['post_html'] = 0;
    $vars['options'] = "";
    $pmsize = 0;
    $attachlist = "";
    $pm_options = "";
    if (isset($vars['receipt']) && $vars['receipt'])
    {
        $pm_options .= '+rr+';
    }
    if (isset($vars['uploaded']))
    {
        foreach($vars['uploaded'] as $u)
        {
            if (!isset($u['error']))
            {
                $pmsize += $u['size'];
                $a_list[] = $u['name'];
            }
        }
        $attachlist = implode(chr(0), $a_list);
    }
    $pmsize += strlen($vars['pm_message']);
    $pm_subject = $tp->toDB($vars['pm_subject']);
    $pm_message = $tp->toDB($vars['pm_message'], false, true);
    $sendtime = time();
    if (isset($vars['to_userclass']) || isset($vars['to_array']))
    {
        if (isset($vars['to_userclass']))
        {
            require_once(e_HANDLER . 'userclass_class.php');
            $toclass = r_userclass_name($vars['pm_userclass']);
            $tolist = $this->get_users_inclass($vars['pm_userclass']);
            $ret .= LAN_PM_38 . ": {$vars['to_userclass']}<br />";
            $class = true;
        }
        else
        {
            $tolist = $vars['to_array'];
            $class = false;
        }
        foreach($tolist as $u)
        {
            set_time_limit(30);
            if ($pmid = $sql->db_Insert('private_msg', "0, '" . intval($vars['from_id']) . "', '" . $tp->toDB($u['user_id']) . "', '" . intval($sendtime) . "', '0', '{$pm_subject}', '{$pm_message}', '1', '0', '" . $tp->toDB($attachlist) . "', '" . $tp->toDB($pm_options) . "', '" . intval($pmsize) . "'"))
            {
                if ($class == false)
                {
                    $toclass .= $u['user_name'] . ', ';
                }
                if (check_class($pm_prefs['notify_class'], $u['user_class']))
                {
                    $vars['to_info'] = $u;
                    $this->pm_send_notify($u['user_id'], $vars, $pmid, count($a_list));
                }
            }
            else
            {
                $ret .= LAN_PM_39 . ": {$u['user_name']} <br />";
            }
        }
        if (!$pmid = $sql->db_Insert('private_msg', "0, '" . intval($vars['from_id']) . "', '" . $tp->toDB($toclass) . "', '" . intval($sendtime) . "', '1', '{$pm_subject}', '{$pm_message}', '0', '0', '" . $tp->toDB($attachlist) . "', '" . $tp->toDB($pm_options) . "', '" . intval($pmsize) . "'"))
        {
            $ret .= LAN_PM_41 . "<br />";
        }
    }
    else
    {
        if ($pmid = $sql->db_Insert('private_msg', "0, '" . intval($vars['from_id']) . "', '" . $tp->toDB($vars['to_info']['user_id']) . "', '" . intval($sendtime) . "', '0', '{$pm_subject}', '{$pm_message}', '0', '0', '" . $tp->toDB($attachlist) . "', '" . $tp->toDB($pm_options) . "', '" . intval($pmsize) . "'"))
        {
            if (check_class($pm_prefs['notify_class'], $vars['to_info']['user_class']))
            {
                set_time_limit(30);
                pm_send_notify($vars['to_info']['user_id'], $vars, $pmid, count($a_list));
            }
            $ret .= LAN_PM_40 . ": {$vars['to_info']['user_name']}<br />";
        }
    }

    return $ret;
}
function pm_send_notify($uid, $pminfo, $pmid, $attach_count = 0)
{
    require_once(e_HANDLER . 'mail.php');
    global $PLUGINS_DIRECTORY;
    $subject = LAN_PM_100 . SITENAME;
    $pmlink = SITEURL . $PLUGINS_DIRECTORY . "pm/pm.php?show.{$pmid}";
    $txt = LAN_PM_101 . SITENAME . "\n\n";
    $txt .= LAN_PM_102 . USERNAME . "\n";
    $txt .= LAN_PM_103 . $pminfo['pm_subject'] . "\n";
    if ($attch_count > 0)
    {
        $txt .= LAN_PM_104 . $attach_count . "\n";
    }
    $txt .= LAN_PM_105 . "\n" . $pmlink . "\n";
    sendemail($pminfo['to_info']['user_email'], $subject, $txt, $pminfo['to_info']['user_name']);
}