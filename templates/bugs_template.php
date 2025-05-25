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
if (!defined("e107_INIT"))
{
    exit;
}

if (!isset($BUGS_TEMPLATE['LIST_TABLE']))
{
    // The main heading for the bugs list
    // displayed second
    $BUGS_TEMPLATE['LIST_TABLE'] = '
<table style="' . USER_WIDTH . '">
		<tr>
			<td class="fcaption" colspan="4">' . BUGTRACK_9 . '</td>
		</tr>
	<tr>
		<td class="forumheader3" colspan="4">{BUGTRACK_SUBMITNEW=small}&nbsp;</td>
	</tr>
		<tr>
			<td class="forumheader3" style="width:10%;">&nbsp;</td>
			<td class="forumheader3" style="width:50%;">' . BUGTRACK_3 . '</td>
			<td class="forumheader3" style="width:20%;">' . BUGTRACK_58 . '</td>
			<td class="forumheader3" style="width:20%;">' . BUGTRACK_4 . '</td>
		</tr>';
}
// *
// *
if (!isset($BUGS_TEMPLATE['LIST_LIST']))
{
    // The list of bugs number of bugs is set in admin config
    $BUGS_TEMPLATE['LIST_LIST'] = '
	<tr>
		<td class="forumheader3" style="vertical-align:center;text-align:center;" >{BUGTRACK_ICON}</td>
		<td class="forumheader3" style="vertical-align:top;" >{BUGTRACK_APPNAME=link}<br />{BUGTRACK_APPDESC}<br /><br /> {BUGTRACK_DOWNLOAD} {BUGTRACK_FORUM}</td>
		<td class="forumheader3" style="vertical-align:top;" >{BUGTRACK_DEVELOPER}</td>
		<td class="forumheader3" style="vertical-align:top;" >' . BUGTRACK_5 . ' - {BUGTRACK_OPEN}<br />' . BUGTRACK_6 . ' - {BUGTRACK_CLOSED}<br />' . BUGTRACK_7 . ' - {BUGTRACK_PENDING}<br />' . BUGTRACK_8 . ' - {BUGTRACK_TOTAL}</td>
	</tr>';
}
// *
if (!isset($BUGS_TEMPLATE['LIST_NOBUG']))
{
    // No bugs to display
    $BUGS_TEMPLATE['LIST_NOBUG'] .= '
	<tr>
		<td class="forumheader3" colspan="5">' . BUGTRACK_8 . '</td>
	</tr>';
}
// *
if (!isset($BUGS_TEMPLATE['LIST_FOOTER']))
{

    $BUGS_TEMPLATE['LIST_FOOTER'] .= '
    <tr>
		<td colspan="4" class="fcaption" >{BUGTRACK_LISTNP=show}&nbsp;</td>
	</tr>
</table>';
}
// *
// *
// * Display Bugs
// *
if (!isset($BUGS_TEMPLATE['SHOW_HEADER']))
{
    $BUGS_TEMPLATE['SHOW_HEADER'] = '
<table style="' . USER_WIDTH . '" class="fborder">
	<tr>
		<td class="fcaption" colspan="7">' . BUGTRACK_15 . ' {BUGTRACK_APPNAME}</td>
	</tr>
	<tr>
		<td class="forumheader2" colspan="7">{BUGTRACK_SHOW_UP}&nbsp;&nbsp;{BUGTRACK_SUBMITNEW=small}</td>
	</tr>
	<tr>
		<td class="forumheader3" colspan="7">{BUGTRACK_F_RESOLUTION} {BUGTRACK_F_STATUS} {BUGTRACK_F_FILTER} {BUGTRACK_F_GO}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:10%;vertical-align:top;">' . BUGTRACK_59 . '</td>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_10 . '</td>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_11 . '</td>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_14 . '</td>
		<td class="forumheader3" style="width:5%;vertical-align:top;">' . BUGTRACK_12 . '</td>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_74 . '</td>
		<td class="forumheader3" style="width:15%;vertical-align:top;">' . BUGTRACK_13 . '</td>
	</tr>';
}
// *
if (!isset($BUGS_TEMPLATE['SHOW_LIST']))
{
    $BUGS_TEMPLATE['SHOW_LIST'] .= '<tr>
		<td class="forumheader3" style="width:10%;vertical-align:top;">{BUGTRACK_ID}</td>
		<td class="forumheader3" style="width:20%;vertical-align:top;">{BUGTRACK_NAME=link}</td>
		<td class="forumheader3" style="width:20%;vertical-align:top;">{BUGTRACK_POSTER}</td>
		<td class="forumheader3" style="width:20%;vertical-align:top;">{BUGTRACK_ASSIGNEE}</td>
		<td class="forumheader3" style="width:5%;vertical-align:top;">{BUGTRACK_PRIORITY}</td>
		<td class="forumheader3" style="width:20%;vertical-align:top;">{BUGTRACK_RESOLUTION}</td>
		<td class="forumheader3" style="width:15%;vertical-align:top;">{BUGTRACK_STATUS}</td>
	</tr>
';
}
// *
if (!isset($BUGS_TEMPLATE['SHOW_FOOTER']))
{
    $BUGS_TEMPLATE['SHOW_FOOTER'] = '
    <tr>
		<td colspan="7" class="fcaption" >{BUGTRACK_LISTNP}&nbsp;</td>
	</tr>
</table>';
}
// *
// *
// *
if (!isset($BUGS_TEMPLATE['ITEM_HEADER']))
{
    $BUGS_TEMPLATE['ITEM_HEADER'] = '
<table style="' . USER_WIDTH . '" class="fborder">
	<tr>
		<td class="fcaption" colspan="2">' . BUGTRACK_44 . '</td>
	</tr>
	<tr>
		<td class="forumheader2" colspan="2">{BUGTRACK_SHOW_UP}&nbsp;&nbsp;{BUGTRACK_SHOW_PRINT}&nbsp;&nbsp;{BUGTRACK_SHOW_EMAIL}</td>
	</tr>';
}
// *
if (!isset($BUGS_TEMPLATE['ITEM_LIST']))
{
    $BUGS_TEMPLATE['ITEM_LIST'] = '
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_17 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_POSTER}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_16 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_NAME=nolink}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_18 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_19 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_EXAMPLEURL}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_12 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_PRIORITY}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_20 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_RESOLUTION}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_13 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_STATUS}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_14 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_ASSIGNEE}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_22 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_DEVCOMMENT}</td>
	</tr>	';
    if ($bugtrack_obj->bugtracker_dev || $bugtrack_obj->bugtracker_admin)
    {
        $BUGS_TEMPLATE['ITEM_LIST'] .= '
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_23 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_ADMINCOMMENT}</td>
	</tr>';
    }
    $BUGS_TEMPLATE['ITEM_LIST'] .= '
	<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_24 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_FLAG}</td>
	</tr>
		<tr>
		<td class="forumheader3" style="width:20%;vertical-align:top;">' . BUGTRACK_25 . '</td>
		<td class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_POSTED=long}</td>
	</tr>';
}
// *
if (!isset($BUGS_TEMPLATE['ITEM_FOOTER']))
{
    $BUGS_TEMPLATE['ITEM_FOOTER'] = '
	<tr>
		<td colspan="2" class="forumheader3" style="width:80%;vertical-align:top;">{BUGTRACK_OPTIONS}</td>
	</tr>
	<tr>
		<td colspan="2" class="fcaption" style="width:80%;vertical-align:top;">&nbsp;</td>
	</tr>
</table>';
}
// *

// *

// *
// *
// *
if (!isset($BUGS_TEMPLATE['SUBMITTED_HEADER']))
{
    $BUGS_TEMPLATE['SUBMITTED_HEADER'] = '
	<div class="fborder" style="' . USER_WIDTH . '" >
	<table style="' . USER_WIDTH . '" >
		<tr>
			<td class="fcaption" >' . BUGTRACK_36 . '</td>
		</tr>
		<tr>
		<td class="forumheader2" colspan="2">{BUGTRACK_SHOW_UP}</td>
		</tr>
		<tr>
			<td class="forumheader3" >{BUGTRACK_INSERTID}</td>
		</tr>
		<tr>
		<td class="fcaption" colspan="2">&nbsp;</td>
		</tr>
	</table></div>';
}
// *
// *
// *
if (!isset($BUGS_TEMPLATE['SUBMIT_FORM']))
{
    $BUGS_TEMPLATE['SUBMIT_FORM'] = '
<div class="fborder" style="' . USER_WIDTH . '" >
		<table style="' . USER_WIDTH . '">
			<tr>
				<td class="fcaption" colspan="2">' . BUGTRACK_40 . '</td>
			</tr>
			<tr>
				<td class="forumheader2" colspan="2">{BUGTRACK_SHOW_UP}</td>
			</tr>
			<tr>
				<td class="forumheader3" style="width:30%;vertical-align:top;" >' . BUGTRACK_31 . '</td>
				<td class="forumheader3" style="width:70%;vertical-align:top;" >{BUGTRACK_APPSEL}</td>
			</tr>
			<tr>
				<td class="forumheader3" style="width:30%;vertical-align:top;" >' . BUGTRACK_32 . '</td>
				<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_DESCFIELD}</td>
			</tr>
			<tr>
				<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_33 . '</td>
				<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_MAINFIELD}</td>
			</tr>
		    <tr>
				<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_34 . '</td>
				<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_EXFIELD}</td>
			</tr>
		    <tr>
				<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_35 . '</td>
				<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_PRIORITYFIELD}</td>
			</tr>
			<tr>
				<td class="fcaption" colspan="2">{BUGTRACK_SUBMIT_BUTTON}</td>
			</tr>
		</table>
		</div>';
}

if (!isset($BUGS_TEMPLATE['OPT_FORM']))
{
    $BUGS_TEMPLATE['OPT_FORM'] = '
<table style="' . USER_WIDTH . '" class="fborder">
	<tr>
		<td class="fcaption" colspan="2">' . BUGTRACK_40 . '</td>
	</tr>
	<tr>
		<td class="forumheader2" colspan="2">{BUGTRACK_SHOW_UP}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;" >' . BUGTRACK_31 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;" >{BUGTRACK_APPSEL}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;" >' . BUGTRACK_32 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_DESCFIELD}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_33 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_MAINFIELD}</td>
	</tr>
	   <tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_34 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_EXFIELD}</td>
	</tr>
	   <tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_35 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_PRIORITYFIELD}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_45 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_STATUSFIELD}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_46 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_RESFIELD}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_47 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_FLAGFIELD}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_48 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_ASSIGNFIELD}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_49 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_DEVFIELD}</td>
	</tr>
	<tr>
		<td class="forumheader3" style="width:30%;vertical-align:top;">' . BUGTRACK_50 . '</td>
		<td class="forumheader3" style="width:70%;vertical-align:top;">{BUGTRACK_ADMINFIELD}</td>
	</tr>
	<tr>
		<td class="fcaption" colspan="2">{BUGTRACK_OPTSUBMIT}</td>
	</tr>
</table>';
}
if (!isset($BUGS_TEMPLATE['OPTSUBMITTED_HEADER']))
{
    $BUGS_TEMPLATE['OPTSUBMITTED_HEADER'] = '
<table style="' . USER_WIDTH . '" class="fborder">
	<tr>
		<td class="fcaption" >' . BUGTRACK_36 . '</td>
	</tr>
	<tr>
		<td class="forumheader2" colspan="2">{BUGTRACK_SHOW_UP}</td>
	</tr>
	<tr>
		<td class="forumheader3" >{BUGTRACK_UPDATED}</td>
	</tr>
	<tr>
		<td class="fcaption" colspan="2">&nbsp;</td>
	</tr>
</table>';
}