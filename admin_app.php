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
if (!defined("e107_INIT"))
{
    exit;
}
if (!getperms('P'))
{
    header('location:' . e_BASE . 'index.php');
    exit;
}
require_once(e_HANDLER . 'userclass_class.php');

require_once(e_PLUGIN . 'bug_tracker/includes/bugtracker_class.php');
if (!is_object($bugtrack_obj))
{
    $bugtrack_obj = new bugtracker;
}

require_once(e_ADMIN . 'auth.php');
if (!defined('ADMIN_WIDTH'))
{
    define(ADMIN_WIDTH, 'width:100%');
}
// require_once(e_HANDLER . 'ren_help.php');
$bugtrack_action = $_POST['bugtrack_action'];
$bugtrack_edit = false;
// * If we are updating then update or insert the record
if ($bugtrack_action == 'update')
{
    $bugtrack_app_id = $_POST['bugtrack_id'];
    if ($bugtrack_app_id == 0)
    {
        // New record so add it
        $bugtrack_args = '
		"0",
		"' . $tp->toDB($_POST['bugtrack_app_name']) . '",
		"' . $tp->toDB($_POST['bugtrack_app_version']) . '",
		"' . $tp->toDB($_POST['bugtrack_app_description']) . '",
		"' . $tp->toDB($_POST['bugtrack_app_dload']) . '",
		"' . $tp->toDB($_POST['bugtrack_app_forum']) . '",
		"' . $tp->toDB($_POST['bugtrack_app_developer']) . '",
		"' . $tp->toDB($_POST['bugtrack_app_icon']) . '",
		0,
		' . time();
        if ($bugtrack_app_id = $sql->db_Insert('bugtrack_apps', $bugtrack_args))
        {
            $bugtrack_msg .= '<strong>' . BUGTRACK_A26 . '</strong>';
        }
        else
        {
            $bugtrack_msg .= '<strong>' . BUGTRACK_A27 . '</strong>';
        }
    }
    else
    {
        // Update existing
        $bugtrack_args = '
		bugtrack_app_name="' . $tp->toDB($_POST['bugtrack_app_name']) . '",
		bugtrack_app_version="' . $tp->toDB($_POST['bugtrack_app_version']) . '",
		bugtrack_app_dload="' . $tp->toDB($_POST['bugtrack_app_dload']) . '",
		bugtrack_app_forum="' . $tp->toDB($_POST['bugtrack_app_forum']) . '",
		bugtrack_app_developer="' . $tp->toDB($_POST['bugtrack_app_developer']) . '",
		bugtrack_app_icon="' . $tp->toDB($_POST['bugtrack_app_icon']) . '",
		bugtrack_app_updated="' . time() . '"
		where bugtrack_app_id="'.$bugtrack_app_id.'"';
        if ($sql->db_Update('bugtrack_apps', $bugtrack_args))
        {
            // Changes saved
            $bugtrack_msg .= '<b>' . BUGTRACK_A28 . '</b>';
        }
        else
        {
            $bugtrack_msg .= '<b>' . BUGTRACK_A29 . '</b>';
        }
    }
    $e107cache->clear('nq_bugstrack');
    $e107cache->clear('bugtrack');

	if (count($_FILES) > 0)
    {
        while (list($key, $value) = each($_FILES['bugtrack_icon']['name']))
        {
            // Check if it is a blank field, if so then skip
            if (!empty($value))
            {
                $filename = $value; // filename stores the value
                $add = e_PLUGIN . 'bug_tracker/icons/' . $filename; // set the upload directory path
                $extn = strtolower(substr($_FILES['bugtrack_icon']['name'][$key], -3, 3));
                if ($extn == 'jpg' || $extn == 'gif' || $extn == 'png' || $extn == 'peg')
                {
                    move_uploaded_file($_FILES['bugtrack_icon']['tmp_name'][$key], $add); //  upload the file to the server
                    chmod('$add', 0644); // set permission to the file.
                }
                else
                {
                    print $_FILES['bugtrack_icon']['name'][$key] . ' has an invalid extention';
                }
            }
        }
    }
}
// We are creating, editing or deleting a record
if ($bugtrack_action == 'dothings')
{
    $bugtrack_app_id = $_POST['bugtrack_selcat'];
    $bugtrack_do = $_POST['bugtrack_recdel'];
    $bugtrack_dodel = false;

    switch ($bugtrack_do)
    {
        case "1": // Edit existing record
            {
                // We edit the record
                $sql->db_Select('bugtrack_apps', '*', 'bugtrack_app_id="'.$bugtrack_app_id.'"');
                $bugtrack_row = $sql->db_Fetch() ;
                extract($bugtrack_row);
                $bugtrack_cap1 = BUGTRACK_A24;
                $bugtrack_edit = true;
                break;
            }
        case "2": // New category
            {
                // Create new record
                $bugtrack_app_id = 0;
                // set all fields to zero/blank
                $bugtrack_app_name = '';
                $bugtrack_category_description = '';
                $bugtrack_cap1 = BUGTRACK_A23;
                $bugtrack_edit = true;
                break;
            }
        case "3":
            {
                // delete the record
                if ($_POST['bugtrack_okdel'] == '1')
                {
                    if ($sql->db_Select('bugtrack_bugs', 'bugtrack_id', " where bugtrack_category='$bugtrack_app_id'", 'nowhere'))
                    {
                        $bugtrack_msg .= '<strong>' . BUGTRACK_A59 . '</strong>';
                    }
                    else
                    {
                        if ($sql->db_Delete('bugtrack_apps', " bugtrack_app_id='$bugtrack_app_id'"))
                        {
                            $bugtrack_msg .= '<strong>' . BUGTRACK_A30 . '</strong>';
                        }
                        else
                        {
                            $bugtrack_msg .= '<strong>' . BUGTRACK_A32 . '</strong>';
                        }
                    }
                }
                else
                {
                    $bugtrack_msg .= '<strong>' . BUGTRACK_A31 . '</strong>';
                }

                $bugtrack_dodel = true;
                $bugtrack_edit = false;
            }
    }

    if (!$bugtrack_dodel)
    {
        $bugtrack_text .= '
<form id="deptformupdate" method="post" action="' . e_SELF . '" enctype="multipart/form-data">
	<div>
		<input type="hidden" value="' . $bugtrack_app_id . '" name="bugtrack_id" />
		<input type="hidden" value="update" name="bugtrack_action" />
	</div>
	<table style="' . ADMIN_WIDTH . '" class="fborder">
		<tr>
			<td colspan="2" class="fcaption">' . $bugtrack_cap1 . '</td>
		</tr>
		<tr>
			<td style="width:20%;vertical-align:top;" class="forumheader3">' . BUGTRACK_A21 . '</td>
			<td  class="forumheader3">
				<input type="text" style="width:60%;" class="tbox" name="bugtrack_app_name" value="' . $tp->toFORM($bugtrack_app_name) . '" />
			</td>
		</tr>
		<tr>
			<td style="width:20%;vertical-align:top;" class="forumheader3">' . BUGTRACK_A22 . '</td>
			<td  class="forumheader3">
				<textarea rows="6" cols="70%" class="tbox" name="bugtrack_app_description" >' . $tp->toFORM($bugtrack_app_description) . '</textarea><br />
			</td>
		</tr>
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A80 . '</td>
			<td style="width:70%" class="forumheader3">
				<input type="text" style="width:20%;" class="tbox" name="bugtrack_app_version" value="' . $tp->toFORM($bugtrack_app_version) . '" />
			</td>
		</tr>
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A99 . '</td>
			<td style="width:70%" class="forumheader3">
			<select class="tbox" name="bugtrack_app_developer">
				<option value="0">' . BUGTRACK_A51 . '</option>';
        $sql->db_Select('user', 'user_id,user_name', 'where find_in_set("' . $BUGTRACK_PREF['bugtrack_devclass'] . '",user_class)', 'nowhere', false);
        while ($row = $sql->db_Fetch())
        {
            $bugtrack_text .= '<option value="' . $row['user_id'] . '" ' . ($tp->toFORM($bugtrack_app_developer) == $row['user_id']?'selected="selected"':'') . '>' . $row['user_name'] . '</option>';
        } // while
        $bugtrack_text .= '</select>
			</td>
		</tr>';
        if ($BUGTRACK_PREF['bugtrack_usedownloads'])
        {
            $bugtrack_dlsel = '<select class="tbox" name="bugtrack_app_dload">';
            $sql->db_Select('download', 'download_id,download_name', 'order by download_name', 'nowhere', false);
            $bugtrack_dlsel .= '<option value="" ' . ($bugtrack_dpath == $bugtrack_app_dload?'selected="selected"':'') . '>' . BUGTRACK_A110 . '</option>';

            while ($bugtrack_row = $sql->db_Fetch())
            {
                $bugtrack_dpath = SITEURL . 'download.php?view.' . $bugtrack_row['download_id'];
                $bugtrack_dlsel .= '<option value="' . $bugtrack_dpath . '" ' . ($bugtrack_dpath == $bugtrack_app_dload?'selected="selected"':'') . '>' . $tp->toFORM($bugtrack_row['download_name']) . '</option>';
            } // while
            $bugtrack_dlsel .= '</select>';
        }
        else
        {
            $bugtrack_dlsel = '<input type="text" class="tbox" style="width:90%;" name="bugtrack_app_dload" value="' . $tp->toFORM($bugtrack_dlpath) . '" />';
        }
        if ($BUGTRACK_PREF['bugtrack_useforums'])
        {
            $bugtrack_slsel = '<select class="tbox" name="bugtrack_app_forum">';
            $sql->db_Select('forum', 'forum_id,forum_name', 'order by forum_name', 'nowhere', false);
            $bugtrack_slsel .= '<option value="" ' . ($bugtrack_spath == $bugtrack_app_forum?'selected="selected"':'') . '>' . BUGTRACK_A109 . '</option>';
            while ($bugtrack_row = $sql->db_Fetch())
            {
                $bugtrack_spath = SITEURL . $PLUGINS_DIRECTORY . 'forum/forum_viewforum.php?' . $bugtrack_row['forum_id'];
                $bugtrack_slsel .= '<option value="' . $bugtrack_spath . '" ' . ($bugtrack_spath == $bugtrack_app_forum?'selected="selected"':'') . '>' . $tp->toFORM($bugtrack_row['forum_name']) . '</option>';
            } // while
            $bugtrack_slsel .= '</select>';
        }
        else
        {
            $bugtrack_slsel = '<input type="text" class="tbox" style="width:90%;" name="bugtrack_app_forum" value="' . $tp->toFORM($bugtrack_support) . '" />';
        }
        $bugtrack_text .= '<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A56 . '</td>
			<td style="width:70%" class="forumheader3">' . $bugtrack_dlsel . '</td>
		</tr>
				<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A57 . '</td>
			<td style="width:70%" class="forumheader3">' . $bugtrack_slsel . '</td>
		</tr>';
        $bugtrack_dir = e_PLUGIN . 'bug_tracker/icons';
        $bugtrack_icons = array();
        if ($dh = opendir($bugtrack_dir))
        {
            $dynalogo_plugin = true;
            while (($file = readdir($dh)) !== false)
            {
                $filecheck = strtolower($file);
                if (strpos($filecheck, '.jpg') > 0 || strpos($filecheck, '.png') > 0 || strpos($filecheck, '.gif') > 0)
                {
                    $bugtrack_icons[] = $file;
                }
            }
            sort($bugtrack_icons);
        }
        closedir($dh);
        $bugtrack_sel = '<select name="bugtrack_app_icon" class="tbox">';
        $bugtrack_sel .= '<option value="" >' . BUGTRACK_A98 . '</option>';
        foreach($bugtrack_icons as $row)
        {
            $bugtrack_sel .= '<option value="' . $row . '" ' . ($row == $tp->toFORM($bugtrack_app_icon)?'selected="selected"':'') . '>' . $row . '</option>';
        }
        $bugtrack_sel .= '</select>';

        $bugtrack_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . BUGTRACK_A97 . '</td>
			<td style="width:70%" class="forumheader3">' . $bugtrack_sel . '<br />
				<a style="cursor: pointer; cursor: hand" onclick="expandit(this);">' . BUGTRACK_A117 . '</a>
				<div style="display: none;">
					<div id="up_container" >
						<span id="upline" style="white-space:nowrap">
							<input class="tbox" type="file" name="bugtrack_icon[]" size="50%" />'."\n".'
						</span>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="fcaption"><input type="submit" name="submits" value="' . BUGTRACK_A10 . '" class="tbox" /></td>
		</tr>';

        $bugtrack_text .= '

	</table>
</form>';
    }
}
if (!$bugtrack_edit)
{
    // Get the category names to display in combo box
    // then display actions available
    $bugtrack_yes = false;
    if ($sql2->db_Select('bugtrack_apps', 'bugtrack_app_id,bugtrack_app_name', ' order by bugtrack_app_name ', 'nowhere'))
    {
        $bugtrack_yes = true;
        while ($bugtrack_row = $sql2->db_Fetch())
        {
            extract($bugtrack_row);
            $bugtrack_catopt .= '<option value="' . $bugtrack_app_id . '"' .
            ($bugtrack_app_id == $bugtrack_app_id?' selected="selected"':'') . '>' . $tp->toFORM($bugtrack_app_name) . '</option>';
        }
    }
    else
    {
        $bugtrack_catopt .= '<option value=0">' . BUGTRACK_A19 . '</option>';
    }

    $bugtrack_text .= '
<form id="deptform" method="post" action="' . e_SELF . '">
	<div>
		<input type="hidden" value="dothings" name="bugtrack_action" />
	</div>
	<table style="' . ADMIN_WIDTH . '" class="fborder">
		<tr>
			<td colspan="2" class="fcaption">' . BUGTRACK_A11 . '</td>
		</tr>
		<tr>
			<td colspan="2" class="forumheader2">' . $bugtrack_msg . '&nbsp;</td>
		</tr>
		<tr>
			<td style="width:20%;" class="forumheader3">' . BUGTRACK_A12 . '</td>
			<td  class="forumheader3"><select name="bugtrack_selcat" class="tbox">' . $bugtrack_catopt . '</select></td>
		</tr>
		<tr>
			<td style="width:20%;" class="forumheader3">' . BUGTRACK_A18 . '</td>
			<td  class="forumheader3">
				<input type="radio" name="bugtrack_recdel" value="1" ' . ($bugtrack_yes?'checked="checked"':'disabled="disabled"') . ' /> ' . BUGTRACK_A13 . '<br />
				<input type="radio" name="bugtrack_recdel" value="2" ' . (!$bugtrack_yes?'checked="checked"':'') . '/> ' . BUGTRACK_A14 . '<br />
				<input type="radio" name="bugtrack_recdel" value="3" /> ' . BUGTRACK_A15 . '
				<input type="checkbox" name="bugtrack_okdel" value="1" />' . BUGTRACK_A16 . '
			</td>
		</tr>
		<tr>
			<td colspan="2" class="fcaption"><input type="submit" name="submits" value="' . BUGTRACK_A17 . '" class="tbox" /></td>
		</tr>
	</table>
</form>';
}

$ns->tablerender(BUGTRACK_A2, $bugtrack_text);

require_once(e_ADMIN . 'footer.php');

?>