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
// ***************************************************************
// *
// *		Title		:	Bug Tracker
// *
// *		Author		:	Barry Keal
// *
// *		Date		:	19 Sept 2006
// *
// *		Version		:	1.3
// *
// *		Description	: 	Bug Tracker
// *
// *		Revisions	:	19 Sept 2006
// *		Revisions	:	12 Aug 2008
// *
// *		Support at	:	www.keal.me.uk
// *
// ***************************************************************
//////////////include_lan(e_PLUGIN . 'bug_tracker/languages/' . e_LANGUAGE . '.php');
e107::lan('bug_tracker', 'admin', true);
// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = 'Bug Tracker';
$eplug_version = '1.4 RC b';
$eplug_author = 'Father Barry';
$eplug_url = 'http://keal.me.uk';
$eplug_email = '';
$eplug_description = BUGTRACK_A114." (updated & customized by rica-carv @ https://github.com/rica-carv)";
$eplug_compatible = 'e107v7';
$eplug_readme = 'admin_readme.php';	// leave blank if no readme file
$eplug_compliant=TRUE;
$eplug_status = TRUE;
$eplug_latest = false;

// Name of the plugin"s folder -------------------------------------------------------------------------------------
$eplug_folder = 'bug_tracker';

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = 'Bug Tracker';

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = 'admin_config.php';

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon_small = $eplug_folder.'/images/bugtrack_16.png';
$eplug_icon = $eplug_folder.'/images/bugtrack_32.png';
$eplug_caption = BUGTRACK_A113;

// List of preferences -----------------------------------------------------------------------------------------------
// prefs now handled in class
// create tables -----------------------------------------------------------------------------------------------
$eplug_sql = file_get_contents(e_PLUGIN . $eplug_folder.'/bugs_sql.php');
preg_match_all('/CREATE TABLE (.*?)\(/i', $eplug_sql, $matches);
$eplug_table_names = $matches[1];
// List of sql requests to create tables -----------------------------------------------------------------------------
// Apply create instructions for every table you defined in locator_sql.php --------------------------------------
// MPREFIX must be used because database prefix can be customized instead of default e107_
$eplug_tables = explode(';', str_replace('CREATE TABLE ', 'CREATE TABLE ' . MPREFIX, $eplug_sql));
for ($i = 0; $i < count($eplug_tables); $i++)
{
    $eplug_tables[$i] .= ';';
}
array_pop($eplug_tables); // Get rid of last (empty) entry



// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = TRUE;
$eplug_link_name = BUGTRACK_A116;
$eplug_link_url = e_PLUGIN.'bug_tracker/bugs.php';


// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = BUGTRACK_A115;
// upgrading ... //

$upgrade_add_prefs = '';

$upgrade_remove_prefs = '';


$upgrade_alter_tables = '';

$eplug_upgrade_done = '';
