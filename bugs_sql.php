CREATE TABLE bugtrack_bugs (
  bugtrack_id int(10) unsigned NOT NULL auto_increment,
  bugtrack_name varchar(50) default NULL,
  bugtrack_author varchar(100) default NULL,
  bugtrack_body TEXT NOT NULL,
  bugtrack_category int(10) unsigned NOT NULL default '0',
  bugtrack_status int(3) unsigned NOT NULL default '0',
  bugtrack_priority int(3) unsigned NOT NULL default '0',
  bugtrack_resolution int(3) unsigned NOT NULL default '0',
  bugtrack_flag int(3) unsigned NOT NULL default '0',
  bugtrack_assigned int(10) unsigned NOT NULL default '0',
  bugtrack_exampleurl varchar(200) default NULL,
  bugtrack_devcomment TEXT,
  bugtrack_admincomment TEXT,
  bugtrack_posted int(10) unsigned NOT NULL default '0',
  bugtrack_lastup int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (bugtrack_id),
  KEY bugtrack_category (bugtrack_category)
  ) TYPE=MyISAM;
CREATE TABLE bugtrack_apps (
  bugtrack_app_id int(10) NOT NULL auto_increment,
  bugtrack_app_name VARCHAR(50) default NULL,
  bugtrack_app_version VARCHAR(20) default NULL,
  bugtrack_app_description VARCHAR(250) default NULL,
  bugtrack_app_dload VARCHAR(250) default NULL,
  bugtrack_app_forum VARCHAR(250) default NULL,
  bugtrack_app_developer int(10) unsigned NOT NULL default '0',
  bugtrack_app_icon VARCHAR(250) default NULL,
  bugtrack_app_bugsug int(10) unsigned NOT NULL default '0',
  bugtrack_app_updated int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (bugtrack_app_id),
  KEY bugtrack_app_name (bugtrack_app_name)
  ) TYPE=MyISAM;


