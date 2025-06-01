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
require_once('../../class2.php');
if (!defined('e107_INIT'))
{
    exit;
}
if (!getperms('P'))
{
    header('location:' . e_HTTP . 'index.php');
    exit;
}
require_once(e_HANDLER . 'userclass_class.php');
require_once(e_ADMIN . 'auth.php');
if (!is_object($bugtrack_obj))
{
	require_once(e_PLUGIN . 'bug_tracker/includes/bugtracker_class.php');
    $bugtrack_obj = new bugtracker;
}

if (e_QUERY == 'update')
{
    // Update rest
    $BUGTRACK_PREF['bugtrack_perpage'] = intval($_POST['bugtrack_perpage']);
    $BUGTRACK_PREF['bugtrack_readclass'] = intval($_POST['bugtrack_readclass']);
    $BUGTRACK_PREF['bugtrack_submitclass'] = intval($_POST['bugtrack_submitclass']);
    $BUGTRACK_PREF['bugtrack_adminclass'] = intval($_POST['bugtrack_adminclass']);
    $BUGTRACK_PREF['bugtrack_devclass'] = intval($_POST['bugtrack_devclass']);
    $BUGTRACK_PREF['bugtrack_inmenu'] = intval($_POST['bugtrack_inmenu']);
    $BUGTRACK_PREF['bugtrack_metad'] = $tp->toDB($_POST['bugtrack_metad']);
    $BUGTRACK_PREF['bugtrack_metak'] = $tp->toDB($_POST['bugtrack_metak']);
    $BUGTRACK_PREF['bugtrack_deforder'] = intval($_POST['bugtrack_deforder']);
    $BUGTRACK_PREF['bugtrack_colours'] = $tp->toDB($_POST['bugtrack_colours']);
    $BUGTRACK_PREF['bugtrack_notifyuser'] = intval($_POST['bugtrack_notifyuser']);
    $BUGTRACK_PREF['bugtrack_notifyteam'] = intval($_POST['bugtrack_notifyteam']);
    $BUGTRACK_PREF['bugtrack_notifyleader'] = intval($_POST['bugtrack_notifyleader']);
    $BUGTRACK_PREF['bugtrack_email'] = $tp->toDB($_POST['bugtrack_email']);
    $BUGTRACK_PREF['bugtrack_sender'] = $tp->toDB($_POST['bugtrack_sender']);
    $BUGTRACK_PREF['bugtrack_pmas'] = $tp->toDB($_POST['bugtrack_pmas']);
    $BUGTRACK_PREF['bugtrack_usedownloads'] = intval($_POST['bugtrack_usedownloads']);
    $BUGTRACK_PREF['bugtrack_useforums'] = intval($_POST['bugtrack_useforums']);

    $bugtrack_obj->save_prefs();
    $bugtrack_msgtext = '<strong>' . BUGTRACK_A7 . '</strong>';
}

$bugtrack_text .= '
<form method="post" action="' . e_SELF . '?update" id="confdocrep">
	<table style="' . ADMIN_WIDTH . '" class="fborder">
		<tr><td colspan="2" class="fcaption">' . BUGTRACK_A1 . '</td></tr>
		<tr><td colspan="2" class="forumheader2">' . $bugtrack_msgtext . '&nbsp;</td></tr>';
// Main admin class
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A5 . '</td>
			<td style="width:70%" class="forumheader3">' . r_userclass('bugtrack_readclass', $BUGTRACK_PREF['bugtrack_readclass'], 'off', 'guest,public,member,nobody,main,admin,classes') . '</td>
		</tr>';
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A6 . '</td>
			<td style="width:70%" class="forumheader3">' . r_userclass('bugtrack_submitclass', $BUGTRACK_PREF['bugtrack_submitclass'], 'off', 'public,nobody,member,main,admin,classes') . '</td>
		</tr>';
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A83 . '</td>
			<td style="width:70%" class="forumheader3">' . r_userclass('bugtrack_adminclass', $BUGTRACK_PREF['bugtrack_adminclass'], 'off', 'nobody,main,admin,classes') . '</td>
		</tr>';
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A44 . '</td>
			<td style="width:70%" class="forumheader3">' . r_userclass('bugtrack_devclass', $BUGTRACK_PREF['bugtrack_devclass'], 'off', 'nobody,classes') . '</td>
		</tr>';
// *
// * Notifications
// *
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A103 . '</td>
			<td style="width:70%" class="forumheader3">
				<select class="tbox" name="bugtrack_notifyuser" >
					<option value="0" ' . ($BUGTRACK_PREF['bugtrack_notifyuser'] == 0?'selected="selected"':'') . '>' . BUGTRACK_A100 . '</option>
					<option value="1" ' . ($BUGTRACK_PREF['bugtrack_notifyuser'] == 1?'selected="selected"':'') . '>' . BUGTRACK_A101 . '</option>
					<option value="2" ' . ($BUGTRACK_PREF['bugtrack_notifyuser'] == 2?'selected="selected"':'') . '>' . BUGTRACK_A102 . '</option>
				</select>
			</td>
		</tr>';
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A104 . '</td>
			<td style="width:70%" class="forumheader3">
				<select class="tbox" name="bugtrack_notifyteam" >
					<option value="0" ' . ($BUGTRACK_PREF['bugtrack_notifyteam'] == 0?'selected="selected"':'') . '>' . BUGTRACK_A100 . '</option>
					<option value="1" ' . ($BUGTRACK_PREF['bugtrack_notifyteam'] == 1?'selected="selected"':'') . '>' . BUGTRACK_A101 . '</option>
					<option value="2" ' . ($BUGTRACK_PREF['bugtrack_notifyteam'] == 2?'selected="selected"':'') . '>' . BUGTRACK_A102 . '</option>
				</select>
			</td>
		</tr>';
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A105 . '</td>
			<td style="width:70%" class="forumheader3">
				<select class="tbox" name="bugtrack_notifyleader" >
					<option value="0" ' . ($BUGTRACK_PREF['bugtrack_notifyleader'] == 0?'selected="selected"':'') . '>' . BUGTRACK_A100 . '</option>
					<option value="1" ' . ($BUGTRACK_PREF['bugtrack_notifyleader'] == 1?'selected="selected"':'') . '>' . BUGTRACK_A101 . '</option>
					<option value="2" ' . ($BUGTRACK_PREF['bugtrack_notifyleader'] == 2?'selected="selected"':'') . '>' . BUGTRACK_A102 . '</option>
				</select>
			</td>
		</tr>';
// *
// *
// *
// Email from
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A106 . '</td>
			<td style="width:70%" class="forumheader3">
				<input class="tbox" type="text"  size="30" name="bugtrack_sender" value="' . $tp->toFORM($BUGTRACK_PREF['bugtrack_sender']) . '" />
			</td>
		</tr>';
// Email from address
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A107 . '</td>
			<td style="width:70%" class="forumheader3">
				<input class="tbox" type="text"  size="30" name="bugtrack_email" value="' . $tp->toFORM($BUGTRACK_PREF['bugtrack_email']) . '" />
			</td>
		</tr>';
// Who to send PM as
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A108 . '</td>
			<td style="width:70%" class="forumheader3">
				<select class="tbox" name="bugtrack_pmas">';
// Sort out admin/main admin class in selection
if ($sql->db_Select('user', 'user_id,user_name', 'where user_admin > 0 or find_in_set("' . $BUGTRACK_PREF['bugtrack_adminclass'] . '",user_class)', 'nowhere', false))
{
    while ($bugtrack_row = $sql->db_Fetch())
    {
        extract($bugtrack_row);
        $bugtrack_text .= '<option value="$user_id" ' . ($user_id == $BUGTRACK_PREF['bugtrack_pmas']?'selected="selected"':'') . '>' . $tp->toFORM($user_name) . '</option>';
    } // while
}
else
{
    $bugtrack_text .= '<option value="0" >Select admin class and save first</option>';
}
$bugtrack_text .= '
				</select>
			</td>
		</tr>';

$bugtrack_text .= '
		<tr>
			<td class="forumheader3" style="width:30%;">' . BUGTRACK_A111 . '</td>
			<td class="forumheader3">
				<input class="tbox" type="checkbox" name="bugtrack_usedownloads" value="1" ' . ($BUGTRACK_PREF['bugtrack_usedownloads'] > 0?'checked="checked"':'') . '" />
			</td>
		</tr>';

$bugtrack_text .= '
		<tr>
			<td class="forumheader3" style="width:30%;">' . BUGTRACK_A112 . '</td>
			<td class="forumheader3">
				<input class="tbox" type="checkbox" name="bugtrack_useforums" value="1" ' . ($BUGTRACK_PREF['bugtrack_useforums'] > 0?'checked="checked"':'') . '" />
			</td>
		</tr>';
// Number of bugs to show
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A9 . '</td>
			<td style="width:70%" class="forumheader3">
				<input class="tbox" type="text"  size="10" name="bugtrack_perpage" value="' . $tp->toFORM($BUGTRACK_PREF['bugtrack_perpage']) . '" />
			</td>
		</tr>';
// Number of bugs in menu
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A61 . '</td>
			<td style="width:70%" class="forumheader3">
				<input class="tbox" type="text"  size="10" name="bugtrack_inmenu" value="' . $tp->toFORM($BUGTRACK_PREF['bugtrack_inmenu']) . '" />
			</td>
		</tr>';
// Bug Priority Colours 10 colours to define separated by,
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A40 . '</td>
			<td style="width:70%" class="forumheader3">
				<input class="tbox" type="text"  style="width:80%" name="bugtrack_colours" value="' . $tp->toFORM($BUGTRACK_PREF['bugtrack_colours']) . '" /><br />' . BUGTRACK_A81 . '
			</td>
		</tr>';
$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A86 . '</td>
			<td style="width:70%" class="forumheader3">
				<select class="tbox" name="bugtrack_deforder" >
					<option value="0" ' . ($BUGTRACK_PREF['bugtrack_deforder'] == 0?'selected="selected"':'') . '>' . BUGTRACK_A87 . '</option>
					<option value="1" ' . ($BUGTRACK_PREF['bugtrack_deforder'] == 1?'selected="selected"':'') . '>' . BUGTRACK_A88 . '</option>
					<option value="2" ' . ($BUGTRACK_PREF['bugtrack_deforder'] == 2?'selected="selected"':'') . '>' . BUGTRACK_A89 . '</option>
				</select>
			</td>
		</tr>';

$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A84 . '</td>
			<td style="width:70%" class="forumheader3">
				<textarea name="bugtrack_metad" style="width:85%;vertical-align:top;" cols = "100" rows="6" class="tbox" >' . $tp->toFORM($BUGTRACK_PREF['bugtrack_metad']) . '</textarea>
			</td>
		</tr>';

$bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A85 . '</td>
			<td style="width:70%" class="forumheader3">
				<textarea name="bugtrack_metak" style="width:85%;vertical-align:top;" cols = "100" rows="6" class="tbox" >' . $tp->toFORM($BUGTRACK_PREF['bugtrack_metak']) . '</textarea>
			</td>
		</tr>';
// Submit button
$bugtrack_text .= '
		<tr>
			<td colspan="2" class="forumheader" style="text-align: left;"><input type="submit" name="update" value="' . BUGTRACK_A10 . '" class="button" /></td>
		</tr>';
$bugtrack_text .= '
	</table>
</form>';

$ns->tablerender(BUGTRACK_A2, $bugtrack_text);

require_once(e_ADMIN . 'footer.php');

?>