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
include_lan(e_PLUGIN . 'bug_tracker/languages/' . e_LANGUAGE . '.php');

$action = basename($_SERVER['PHP_SELF'], '.php');

$var['admin_config']['text'] = BUGTRACK_A1;
$var['admin_config']['link'] = 'admin_config.php';

$var['admin_app']['text'] = BUGTRACK_A3;
$var['admin_app']['link'] = 'admin_app.php';

$var['admin_readme']['text'] = BUGTRACK_A118;
$var['admin_readme']['link'] = 'admin_readme.php';

$var['admin_vupdate']['text'] = BUGTRACK_A96;
$var['admin_vupdate']['link'] = 'admin_vupdate.php';

show_admin_menu(BUGTRACK_A2, $action, $var);

?>