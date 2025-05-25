<?php
if (!defined('e107_INIT'))
{
    exit;
}

global $PLUGINS_DIRECTORY;
/**
 * * Get the main requires out of the way
 */
//////////include_lan(e_PLUGIN . 'bug_tracker/languages/' . e_LANGUAGE . '.php');
e107::lan('bug_tracker');
// get template

if (!defined('USER_WIDTH'))
{
    define("USER_WIDTH", 'width:100%;');
}

class bugtracker
{
    var $bugtracker_admin = false; // is user an admin
    var $bugtracker_creator = false; //
    var $bugtracker_reader = false; //
    var $bugtracker_dev = false; //
    function __construct()
    {
        global $BUGTRACK_PREF;
        $this->load_prefs();

        $this->bugtracker_admin = check_class($BUGTRACK_PREF['bugtrack_adminclass']);
        $this->bugtracker_creator = check_class($BUGTRACK_PREF['bugtrack_submitclass']);
       $this->bugtracker_reader = check_class($BUGTRACK_PREF['bugtrack_readclass']);
        $this->bugtracker_dev = check_class($BUGTRACK_PREF['bugtrack_devclass']);
    }
    // ********************************************************************************************
    // *
    // * Bugtracker load and Save prefs
    // *
    // ********************************************************************************************
    function getdefaultprefs()
    {
        global $BUGTRACK_PREF;
        $BUGTRACK_PREF = array(
			'bugtrack_perpage' => 5,
            'bugtrack_readclass' => 0,
            'bugtrack_submitclass' => 0,
            'bugtrack_adminclass' => 254,
            'bugtrack_devclass' => 0,
            'bugtrack_inmenu' => 5,
            'bugtrack_metad' => "Father Barry's Bug Tracker",
            'bugtrack_metak' => 'Bug Tracker,Father Barry,e107',
            'bugtrack_deforder' => 1,
            'bugtrack_colours' => '#FFFFFF,#D5FFBB,#DEFF98,#E1FF65,#FDEB68,#FCE123,#FEBC21,#FDA773,#FF9171,#FF4000',
            'bugtrack_notifyuser' => 2,
            'bugtrack_notifyteam' => 2,
            'bugtrack_notifyleader' => 2,
            'bugtrack_email' => 'admin@example.com',
            'bugtrack_sender' => 'Bugtracker',
            'bugtrack_pmas' => 0,
            'bugtrack_usedownloads' => 1,
            'bugtrack_useforums' => 1,
            );
    }
    function save_prefs()
    {
        global $sql, $eArrayStorage, $BUGTRACK_PREF;
        // save preferences to database
        if (!is_object($sql))
        {
            $sql = new db;
        }
        $tmp = $eArrayStorage->WriteArray($BUGTRACK_PREF);
        $sql->db_Update('core', 'e107_value="'.$tmp.'" where e107_name="bugtracker"', false);
        return ;
    }
    function load_prefs()
    {
        global $sql, $eArrayStorage, $BUGTRACK_PREF;
        // get preferences from database
        if (!is_object($sql))
        {
            $sql = new db;
        }
        $num_rows = $sql->db_Select('core', '*', 'e107_name="bugtracker"');
        $row = $sql->db_Fetch();

        if (empty($row['e107_value']))
        {
            // insert default preferences if none exist
            $this->getDefaultPrefs();
            $tmp = $eArrayStorage->WriteArray($BUGTRACK_PREF);
            $sql->db_Insert('core', "'bugtracker', '$tmp' ");
            $sql->db_Select('core', '*', 'e107_name="bugtracker"');
        }
        else
        {
            $BUGTRACK_PREF = $eArrayStorage->ReadArray($row['e107_value']);
        }
        return;
    }
}