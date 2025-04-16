<?php
// **************************************************************************
// *
// *  BUGTRACK for e107 v7xx
// *
// **************************************************************************
require_once("../../class2.php");
if (!defined('e107_INIT'))
{
    exit;
}
if (!getperms("P"))
{
    header("location:" . e_HTTP . "index.php");
    exit;
}
include_lan(e_PLUGIN . "bug_tracker/languages/readme/" . e_LANGUAGE . ".php");
require_once(e_ADMIN . "auth.php");

$bugtrack_text="
<table class='fborder' style='width:100%'>
	<tr>
		<td class='fcaption' colspan='2'>".BUGTRACK_R01."</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >".BUGTRACK_R02."</td>
		<td class='forumheader3'>".BUGTRACK_R03."</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >".BUGTRACK_R04."</td>
		<td class='forumheader3'>".BUGTRACK_R05."</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >".BUGTRACK_R06."</td>
		<td class='forumheader3'>".BUGTRACK_R07."</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >".BUGTRACK_R08."</td>
		<td class='forumheader3'>".BUGTRACK_R09."</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >".BUGTRACK_R10."</td>
		<td class='forumheader3'>".BUGTRACK_R11."</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >".BUGTRACK_R12."</td>
		<td class='forumheader3'>".BUGTRACK_R13."</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >".BUGTRACK_R14."</td>
		<td class='forumheader3'>".BUGTRACK_R15."</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >".BUGTRACK_R16."</td>
		<td class='forumheader3'>".BUGTRACK_R17."</td>
	</tr>
	<tr>
		<td class='forumheader3' colspan='2'>
		<strong>".BUGTRACK_R18."</strong><br /><br />".BUGTRACK_R19."<br /><br />
		<strong>".BUGTRACK_R20."</strong><br /><br />".BUGTRACK_R21."<br /><br />
		<strong>".BUGTRACK_R22."</strong><br /><br />".BUGTRACK_R23."
		</td>
	</tr>
	<tr>
		<td class='fcaption' colspan='2'>&nbsp;</td>
	</tr>
</table>";


$ns->tablerender(BUGTRACK_R01, $bugtrack_text);

require_once(e_ADMIN . "footer.php");


?>