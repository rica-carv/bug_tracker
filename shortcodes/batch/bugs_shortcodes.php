<?php
if (!defined('e107_INIT')) exit;

//include_once(e_HANDLER . 'shortcode_handler.php');
//$bugs_shortcodes = $this->tp->e_sc->parse_scbatch(__FILE__);

class plugin_bug_tracker_bugs_shortcodes extends e_shortcode
{
    private $sql;
    private $tp;
    private $frm;
    private $bugStats = [];
    function __construct()
    {
//  $this->pluginPrefs = e107::pref('helpdesk');
        $this->sql = e107::getDB();
        $this->tp = e107::getParser();
        $this->frm = e107::getForm();

//        var_dump($this->getVars());
//        $this->sql->count('bugtrack_bugs', '(*)', 'bugtrack_category="' . $this->var['bugtrack_app_id'] . '" and bugtrack_status=100');
/*
$bugtrack_closed = $sql2->db_Count('bugtrack_bugs', '(*)', 'bugtrack_category="' . $bugtrack_app_id . '" and bugtrack_status=3', false);
$bugtrack_pending = $sql2->db_Count('bugtrack_bugs', '(*)', 'bugtrack_category="' . $bugtrack_app_id . '" and bugtrack_status=2', false);
$bugtrack_total = $bugtrack_open + $bugtrack_closed + $bugtrack_pending;
*/
    }
/*
    public function addVars($data)
    {
        parent::addVars($data);

        if (method_exists($this, 'prepareFromVars')) {
            $this->prepareFromVars();
        }
    }
*/
/*
    public function prepareFromVars()
    {
        var_dump($this->getVars());
        var_dump($this->var['bugtrack_app_id']);
///        parent::addVars($data); // necessário para $this->var ser definido
        var_dump($this->var['bugtrack_app_id']);
        echo "<<hr>";

        $appId = $this->var['bugtrack_app_id'] ?? null;

        if ($appId) {
            $this->bugStats['open'] = $this->sql->count('bugtrack_bugs', '(*)', 'bugtrack_category="' . intval($appId) . '" AND bugtrack_status=1');
            $this->bugStats['closed'] = $this->sql->count('bugtrack_bugs', '(*)', 'bugtrack_category="' . intval($appId) . '" AND bugtrack_status=3');
            $this->bugStats['pending'] = $this->sql->count('bugtrack_bugs', '(*)', 'bugtrack_category="' . intval($appId) . '" AND bugtrack_status=2');
        }
    }
*/
function sc_bugtrack_f_go ()
{
    return '<input class="tbox" name="bugfilter" type="submit" value="'.BUGTRACK_73.'" />';
}

function sc_bugtrack_f_filter ()
{
global $BUGTRACK_PREF,$bugtrack_fassigned;
$retval='<select class="tbox" name="bugtrack_fassigned" onchange="this.form.submit()">';
$retval.='<option value="0" '.($bugtrack_fassigned==0?'selected="selected"':'').'>'.BUGTRACK_70.'</option>';

$retval.='<option value="-1" '.($bugtrack_fassigned==-1?'selected="selected"':'').'>'.BUGTRACK_69.'</option>';
$retval.='<option value="-2" '.($bugtrack_fassigned==-2?'selected="selected"':'').'>'.BUGTRACK_72.'</option>';

$retval.='<option value="-99" disabled="disabled">'.BUGTRACK_71.'</option>';

$this->sql->db_Select('user','user_name,user_id','where find_in_set("'.$BUGTRACK_PREF['bugtrack_devclass'].'",user_class) order by user_name','nowhere',false);

while ($row=$this->sql->db_Fetch())
{
	extract($row);
	$retval.='<option value="'.$user_id.'"  '.($bugtrack_fassigned==$user_id?'selected="selected"':'').'>'.$this->tp->toDB($user_name).'</option>';

}
$retval.='</select>';
return $retval;

}

function sc_bugtrack_f_resolution ()
{
global $bugtrack_fresolution,$bugtrack_resarray;

$retval = "<select class='tbox' name='bugtrack_fresolution' onchange='this.form.submit()'>";
	$retval.="<option value='-1' ".($bugtrack_fresolution==-1?"selected='selected'":"")." >".BUGTRACK_67."</option>";
$i=0;
foreach($bugtrack_resarray as $row)
{
	$retval.="<option value='$i' ".($bugtrack_fresolution==$i?"selected='selected'":"")." >".$row."</option>";
$i++;
}
$retval .= "</select>";
return $retval;
}

function sc_bugtrack_f_status ()
{
global $bugtrack_fstatus,$bugtrack_statusarray;

$retval = '<select class="tbox" name="bugtrack_fstatus" onchange="this.form.submit()">';
$retval.='<option value="-1" '.($bugtrack_fstatus==-1?'selected="selected"':'').' >'.BUGTRACK_68.'</option>';
$i=0;
foreach($bugtrack_statusarray as $row)
{
	$retval.='<option value="'.$i.'"'.($bugtrack_fstatus==$i?'selected="selected"':'').' >'.$row.'</option>';
$i++;
}
$retval .= '</select>';
return $retval;
}


function sc_bugtrack_id ()
{
global $bugtrack_id;
return $bugtrack_id;
}

function sc_bugtrack_developer ()
{
global $user_name;
if (empty($user_name))
{
	return BUGTRACK_77;
}
else
{
	return $this->tp->toHTML($user_name);
}
}

function sc_bugtrack_download ()
{
global $bugtrack_app_dload;
if (!empty($bugtrack_app_dload))
{
return  '<a href="'.$bugtrack_app_dload.'">'.BUGTRACK_56.'</a> ';
}
}

function sc_bugtrack_forum ()
{
global $bugtrack_app_forum;
if (!empty($bugtrack_app_forum))
{
return  '<a href="'.$bugtrack_app_forum.'">'.BUGTRACK_57.'</a> ';
}
}

function sc_bugtrack_listnp ($parms=null)
{
//global  $bugtrack_npa,$bugtrack_tmpf,$bugtrack_perpage,$bugtrack_count,$bugtrack_action, $bugtrack_from, $bugtrack_bugid, $bugtrack_bugapp, $BUGTRACK_PREF;

/////$action = "{$bugtrack_npa}.{$bugtrack_bugapp}.{$bugtrack_bugid}.{$bugtrack_tmpf}";
/////$parms = $bugtrack_count . ',' . $bugtrack_perpage . ',' . $bugtrack_from . ',' . e_SELF . '?' . '[FROM].' . $action;
////$parms = 'tmpl_prefix='.deftrue('BUGTRACK_NEXTPREV_TMPL', 'default').'&total='.$bugtrack_count.'&amount='.$bugtrack_perpage.'&current='.$bugtrack_from.'&url=?--FROM--.'.$action; // .'&url='.$url;
$action = "{$this->var['bugtrack_npa']}.{$this->var['bugtrack_bugapp']}.{$this->var['bugtrack_bugid']}.{$this->var['bugtrack_tmpf']}";
$parms = "tmpl_prefix=".deftrue('BUGTRACK_NEXTPREV_TMPL', 'default')."&total={$this->var['bugtrack_count']}&amount={$this->var['bugtrack_perpage']}&current={$this->var['bugtrack_from']}&url=?--FROM--.{$action}"; // .'&url='.$url;
return $this->tp->parseTemplate("{NEXTPREV={$parms}}");
}

function sc_bugtrack_updated ()
{
global $bugtrak_inserted;
if ($bugtrak_inserted)
{
	return BUGTRACK_53;
}
else
{
	return BUGTRACK_37;
}

}

function sc_bugtrack_optsubmit ()
{
return '<input type="submit" class="tbox" name="bugtrack_opt" value="' . BUGTRACK_52 . '" />';
}

function sc_bugtrack_devfield ()
{
global $bugtrack_devcomment;
$retval='<textarea class="tbox" name="bugtrack_devcomment" cols="50" rows="6" style="width:80%" >'.$this->tp->toFORM($bugtrack_devcomment).'</textarea>';
return $retval;
}

function sc_bugtrack_adminfield ()
{
global $bugtrack_admincomment;
$retval='<textarea class="tbox" name="bugtrack_admincomment" cols="50" rows="6" style="width:80%">'.$this->tp->toFORM($bugtrack_admincomment).'</textarea>';
return $retval;
}

function sc_bugtrack_assignfield ()
{
global $BUGTRACK_PREF,$bugtrack_assigned;
$retval='<select class="tbox" name="bugtrack_assigned">';
	$retval.='<option value="0" '.($bugtrack_assigned==0?'selected="selected"':'').'>'.BUGTRACK_51.'</option>';
$this->sql->db_Select('user','user_name,user_id',"where find_in_set('".$BUGTRACK_PREF['bugtrack_devclass']."',user_class) order by user_name",'nowhere',false);

while ($row=$this->sql->db_Fetch())
{
	extract($row);
	$retval.='<option value="'.$user_id.'"  '.($bugtrack_assigned==$user_id?'selected="selected"':'').'>'.$this->tp->toDB($user_name).'</option>';

}
$retval.='</select>';
return $retval;
}

function sc_bugtrack_submit_button ()
{
//////////return '<input type="submit" class="btn btn-primary" name="bugtrack_submit" value="' . BUGTRACK_43 . '" />';
return $this->frm->admin_button('bugtrack_submit', BUGTRACK_43, 'submit');

}

function sc_bugtrack_flagfield ()
{
global $bugtrack_flag,$bugtrack_flagarray;

$retval = '<select class="tbox" name="bugtrack_flag">';
$i=0;
foreach($bugtrack_flagarray as $row)
{
	$retval.='<option value="'.$i.'" '.($bugtrack_flag==$i?'selected="selected"':'').' >'.$row.'</option>';
$i++;
}
$retval .= '</select>';
return $retval;
}

function sc_bugtrack_resfield ()
{
global $bugtrack_resolution,$bugtrack_resarray;

$retval = '<select class="tbox" name="bugtrack_resolution">';
$i=0;
foreach($bugtrack_resarray as $row)
{
	$retval.='<option value="'.$i.'" '.($bugtrack_resolution==$i?'selected="selected"':'').' >'.$row.'</option>';
$i++;
}
$retval .= '</select>';
return $retval;
}

function sc_bugtrack_statusfield ()
{
global $bugtrack_status,$bugtrack_statusarray;

$retval = '<select class="tbox" name="bugtrack_status">';
$i=0;
foreach($bugtrack_statusarray as $row)
{
	$retval.='<option value="'.$i.'" '.($bugtrack_status==$i?'selected="selected"':'').' >'.$row.'</option>';
$i++;
}
$retval .= '</select>';
return $retval;
}

function sc_bugtrack_insertid ()
{
global $bugtrak_inserted;
if ($bugtrak_inserted>0)
{
	return BUGTRACK_38." ".$bugtrak_inserted;
}
elseif ($bugtrak_inserted<0)
{
	return BUGTRACK_39;
}
else
{
	return BUGTRACK_37;
}

}

function sc_bugtrack_descfield ()
{
/////////////global $bugtrack_name;
/////////////return '<input type="text" style="width:80%" class="tbox" name="bugtrack_name" value="'.$this->tp->toFORM($bugtrack_name).'" />';
global $bugtrack_name;
return $this->frm->text("bugtrack_name", $this->tp->toFORM($bugtrack_name));
}

function sc_bugtrack_exfield ()
{
/////////////global $bugtrack_exampleurl;
/////////////return '<input type="text" style="width:80%" class="tbox" name="bugtrack_exampleurl" value="'.$this->tp->toFORM($bugtrack_exampleurl).'" />';
global $bugtrack_exampleurl;
return $this->frm->text("bugtrack_exampleurl", $this->tp->toFORM($bugtrack_exampleurl));
}

function sc_bugtrack_mainfield ()
{
///////////////global $bugtrack_body;
///////////////return '<textarea class="tbox" style="width:80%;" cols="50" rows="6" name="bugtrack_body">'.$this->tp->toFORM($bugtrack_body).'</textarea>';
global $bugtrack_body;
return $this->frm->textarea("bugtrack_body", $this->tp->toFORM($bugtrack_body));
}

function sc_bugtrack_priorityfield ()
{
global $bugtrack_priority;
if (!is_numeric($bugtrack_priority))
{
	$bugtrack_priority=4;
}
return '<select class="tbox" name="bugtrack_priority">
<option value="0" '.($bugtrack_priority==0?'selected="selected"':'').'>0</option>
<option value="1" '.($bugtrack_priority==1?'selected="selected"':'').'>1</option>
<option value="2" '.($bugtrack_priority==2?'selected="selected"':'').'>2</option>
<option value="3" '.($bugtrack_priority==3?'selected="selected"':'').'>3</option>
<option value="4" '.($bugtrack_priority==4?'selected="selected"':'').'>4</option>
<option value="5" '.($bugtrack_priority==5?'selected="selected"':'').'>5</option>
<option value="6" '.($bugtrack_priority==6?'selected="selected"':'').'>6</option>
<option value="7" '.($bugtrack_priority==7?'selected="selected"':'').'>7</option>
<option value="8" '.($bugtrack_priority==8?'selected="selected"':'').'>8</option>
<option value="9" '.($bugtrack_priority==9?'selected="selected"':'').'>9</option>
</select>';
}

function sc_bugtrack_appsel ()
{
global $bugtrack_bugapp;
$retval ='<select name="bugtrack_category" class="tbox">';
if ($this->sql->db_Select('bugtrack_apps','bugtrack_app_id,bugtrack_app_name','order by bugtrack_app_name','nowhere',false))
{
	while ($row=$this->sql->db_Fetch())
	{
	extract($row);
	$retval .= '<option value="'.$bugtrack_app_id.'" '.($bugtrack_app_id==$bugtrack_bugapp?'selected="selected"':'').'>'.$this->tp->toFORM($bugtrack_app_name).'</option>';
	}
}
$retval .='</select>';
return $retval;
}

function sc_bugtrack_submitnew ($parm=null)
{
global $BUGTRACK_PREF,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from,$bugtrack_tmpf;

if (check_class($BUGTRACK_PREF['bugtrack_submitclass']) || check_class($BUGTRACK_PREF['bugtrack_devclass']) || check_class($BUGTRACK_PREF['bugtrack_adminclass']) )
{
	if ($parm=='text')
	{
		$retval = "<a href='".e_SELF."?$bugtrack_from.new.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf' title='".BUGTRACK_78."' >".BUGTRACK_27."</a>";
	}
	elseif ($parm=='small')
	{
		$retval = "<a href='".e_SELF."?$bugtrack_from.new.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf' ><img src='".BUGTRACK_IMAGES."/images/bugtrack_small.png' alt='".BUGTRACK_78."' title='".BUGTRACK_78."' style='border:0;'/></a>";

	}
	elseif ($parm=='button')
	{
		$retval = "<a href='".e_SELF."?$bugtrack_from.new.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf' class='pager-button btn btn-primary hidden-print align-self-center mb-0'>".BUGTRACK_27."</a>";

	}
    elseif ($parm=='link')
	{
		$retval = e_SELF.'?{$bugtrack_from}.new.{$bugtrack_bugapp}.{$bugtrack_bugid}.{$bugtrack_tmpf}';
	}
	else
	{
		$retval = "<a href='".e_SELF."?$bugtrack_from.new.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf' ><img src='".BUGTRACK_IMAGES."/images/bugtracknew.png' alt='".BUGTRACK_78."' title='".BUGTRACK_78."' style='border:0;'/></a>";
	}
}
return $retval;
}

function sc_bugtrack_options ()
{
global $BUGTRACK_PREF,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from,$bugtrack_tmpf;
if (check_class($BUGTRACK_PREF['bugtrack_devclass']) || check_class($BUGTRACK_PREF['bugtrack_adminclass']))
{
	$retval = "<a class='btn' href='".e_SELF."?$bugtrack_from.opt.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf' >".BUGTRACK_26."</a>";
}
return $retval;
}

function sc_bugtrack_posted ($parm=null)
{
global $bugtrack_gen,$bugtrack_posted;
if ($parm=='long' || $parm=='short')
{
	return $this->tp->toHTML($bugtrack_gen->convert_date($bugtrack_posted,$parm),false);
}
else
{
	if (empty($parm))
	{
	return $this->tp->toHTML(date('d-m-Y',$bugtrack_posted),false);
	}
	else
	{
	return $this->tp->toHTML(date($parm,$bugtrack_posted),false);
	}
}
}

function sc_bugtrack_resolution ()
{
global $bugtrack_resarray,$bugtrack_resolution;
return $this->tp->toText($bugtrack_resarray[$bugtrack_resolution]);
//return $bugtrack_resarray[$bugtrack_resolution];
}

function sc_bugtrack_flag ()
{
global $bugtrack_flagarray,$bugtrack_flag;
return $this->tp->toHTML($bugtrack_flagarray[$bugtrack_flag],false);

}

function sc_bugtrack_admincomment ()
{
global $bugtrack_admincomment;
return $this->tp->toHTML($bugtrack_admincomment,false);
}

function sc_bugtrack_devcomment ()
{
global $bugtrack_devcomment;
return $this->tp->toHTML($bugtrack_devcomment,false);
}

function sc_bugtrack_explain ()
{
global $bugtrack_body;
return $this->tp->toHTML($bugtrack_body,false);
}

function sc_bugtrack_exampleurl ()
{
global $bugtrack_exampleurl;
return $this->tp->toHTML($bugtrack_exampleurl,false);
}

function sc_bugtrack_name ($parm=null)
{
global $bugtrack_name,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from,$bugtrack_tmpf;
if ($parm=='link')
{
	return '<a href="'.e_SELF."?$bugtrack_from.item.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf\" >".$this->tp->toText($bugtrack_name).'</a>';
//	return '<a href="'.e_SELF."?{$bugtrack_from}.item.{$bugtrack_bugapp}.{$bugtrack_bugid}.{$bugtrack_tmpf}\" >".$bugtrack_name.'</a>';
}
else
{
	return $this->tp->toText($bugtrack_name);
//	return $bugtrack_name;
}
}


function sc_bugtrack_poster ()
{
global $bugtrack_aname;
return $this->tp->toText($bugtrack_aname);
//return $bugtrack_aname;
}


function sc_bugtrack_status ()
{
global $bugtrack_statusarray,$bugtrack_status;
if (!is_numeric($bugtrack_status))
{
	$bugtrack_status=0;
}
$bugtrack_temp=$bugtrack_statusarray[$bugtrack_status];
return $this->tp->toText($bugtrack_temp);
//return $bugtrack_temp;
}


function sc_bugtrack_assignee ()
{
global $user_name;
if (empty($user_name))
{
$bugtrack_uname=BUGTRACK_21;
}
else
{
$bugtrack_uname=$user_name;
}
return $this->tp->toText($bugtrack_uname);
}


function sc_bugtrack_priority ($parm=null)
{
global $bugtrack_priority,$bugtrack_colourarray;
if ($parm=="nocolour")
{
$retval=$this->tp->toText($bugtrack_priority);
//$retval=$bugtrack_priority;
}
else
{
$retval='<div style="background-color:'.$bugtrack_colourarray[$bugtrack_priority].'">'.$this->tp->toText($bugtrack_priority).'</div>';
//$retval='<div style="background-color:'.$bugtrack_colourarray[$bugtrack_priority].'">'.$bugtrack_priority.'</div>';
}
return $retval;
}

function sc_bugtrack_icon ()
{
global $bugtrack_app_icon,$tp;
if (!empty($bugtrack_app_icon) )
{
	return '<img src="'.BUGTRACK_IMAGES.'/icons/'.$this->tp->toFORM($bugtrack_app_icon).'" style="width:48px;height:48px;border:0;" alt="icon" />';
}
else
{
	return '<img src="'.BUGTRACK_IMAGES.'/images/blank.png" style="width:48px;height:48px;border:0;" alt="" />';
}
}

function sc_bugtrack_appname ($parm=null)
{
/////global $bugtrack_app_name,$bugtrack_app_id,$bugtrack_bugid,$bugtrack_from;
/*
var_dump($this->var['bugtrack_app_id']);
var_dump($this->var['bugtrack_bugid']);
var_dump($this->var['bugtrack_from']);
var_dump($this->var['bugtrack_app_name']);
echo "<hr>";
*/
//var_dump($this->var['bugtrack_app_id']);
//var_dump($this->var['bugtrack_app_name']);
//////return $this->tp->toHTML($bugtrack_app_name,false);
$app_name = $this->tp->toText($this->var['bugtrack_app_name']);
//return $this->var['bugtrack_app_name'];
if ($parm=='link')
{
    return "<a href='".e_SELF."?0.view.{$this->var['bugtrack_app_id']}.{$this->var['bugtrack_bugid']}.{$this->var['bugtrack_from']}'>".$app_name."</a>";
}
else
{
    return $app_name;
}
}

function sc_bugtrack_appdesc ()
{
global $bugtrack_app_description;
return $this->tp->toHTML($bugtrack_app_description,false);
}

function sc_bugtrack_open ()
{
//global $bugtrack_open;
//return str_pad($this->tp->toHTML($bugtrack_open,false),1,'0');
    return str_pad($this->tp->toHTML($this->var['open_bugs']),1,'0');
//    return str_pad($this->tp->toHTML($this->bugStats['open']),1,'0');
}

function sc_bugtrack_closed ()
{
//global $bugtrack_closed;
//return str_pad($this->tp->toHTML($bugtrack_closed,false),1,'0');
    return str_pad($this->tp->toHTML($this->var['closed_bugs']),1,'0');
//    return str_pad($this->tp->toHTML($this->bugStats['closed']),1,'0');
}

function sc_bugtrack_pending ()
{
//global $bugtrack_pending;
//return str_pad($this->tp->toHTML($bugtrack_pending,false),1,'0');
    return str_pad($this->tp->toHTML($this->var['pending_bugs']),1,'0');
//    return str_pad($this->tp->toHTML($this->bugStats['pending']),1,'0');
}

function sc_bugtrack_total ()
{
//global $bugtrack_total;
//return str_pad($this->tp->toHTML($bugtrack_total,false),1,'0');
    return str_pad($this->tp->toHTML($this->var['open_bugs'] + $this->var['closed_bugs'] + $this->var['pending_bugs']),1,'0');
//    $bugtrack_total = $bugtrack_open + $bugtrack_closed + $bugtrack_pending;
//    return str_pad($this->tp->toHTML($this->bugStats['open'] + $this->bugStats['closed'] + $this->bugStats['pending']),1,'0');
}

function sc_bugtrack_show_up ($parm=null)
{
global $bugtrack_action,$bugtrack_app_name,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from,$bugtrack_tmpf;
$bugtrack_newfrom=$bugtrack_from;
switch ($bugtrack_action)
{
case 'subopt':
	$bugtrack_newaction='item';
	break;
case 'view':
	$bugtrack_newaction='show';
	break;
case 'new':
	$bugtrack_newaction='show';
	break;
case 'item':
	$bugtrack_newaction='view';
	break;
case 'opt':
	$bugtrack_newaction='item';
	break;
}

if ($bugtrack_newaction=='show')
{
	$bugtrack_newfrom=$bugtrack_tmpf;
}
if ($parm=='noicon')
{
///////	return "<a class='btn' href='".e_SELF."?$bugtrack_newfrom.$bugtrack_newaction.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf'>".BUGTRACK_28 . "</a>";
	return "<a class='btn' href='".e_SELF."?$bugtrack_newfrom.$bugtrack_newaction.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf'>".LAN_BACK."</a>";
////    return $this->frm->renderValue(LAN_BACK, array("link"=>e_SELF."?$bugtrack_newfrom.$bugtrack_newaction.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf'"));
}
else
{
///////	return "<a href='".e_SELF."?$bugtrack_newfrom.$bugtrack_newaction.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf'><img src='".BUGTRACK_IMAGES."/images/updir.png' style='border:0;' alt='" . BUGTRACK_28 . "' title='" . BUGTRACK_28 . "' /></a>";
	return "<a class='btn'  href='".e_SELF."?$bugtrack_newfrom.$bugtrack_newaction.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf'><img src='".BUGTRACK_IMAGES."/images/updir.png' style='border:0;' alt='" . LAN_BACK . "' title='" . LAN_BACK . "' /></a>";
}
}

function sc_bugtrack_show_print ($parm=null)
{
global $bugtrack_app_name,$bugtrack_app_id,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from;
if ($parm=='noicon')
{
return "<a class='btn' href='../../print.php?plugin:bug_tracker.$bugtrack_bugid' >" . BUGTRACK_29 . "</a>";
}
else
{
return "<a class='btn' href='../../print.php?plugin:bug_tracker.$bugtrack_bugid' ><img src='" . e_IMAGE . "generic/" . IMODE . "/printer.png' style='border:0;' title='" . BUGTRACK_29 . "' alt='" . BUGTRACK_29 . "' /></a>";

}

}

function sc_bugtrack_show_email ($parm=null)
{
global $bugtrack_app_name,$bugtrack_app_id,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from;
if ($parm=="noicon")
{
	return "<a class='btn' href='../../email.php?plugin:bug_tracker." . $bugtrack_bugid . "'>".BUGTRACK_30 . "</a>";
}
else
{
	return "<a class='btn' href='../../email.php?plugin:bug_tracker." . $bugtrack_bugid . "'><img src='" . e_IMAGE . "generic/" . IMODE . "/email.png' style='border:0' alt='" . BUGTRACK_30 . "' title='" . BUGTRACK_30 . "' /></a>";
}
}





/*
function sc_JOKE_CAT_SEL ($parm=null)
{
global $row,  $bugtrack_db, $bugtrack_desc, $bugtrack_desc, $bugtrack_jokecat;

$bugtrack_desc = BUGTRACK_109;
print $parms;
$bugtrack_selcat = '<select class="tbox" name="bugtrack_select" ';
$bugtrack_selcat .= ($parm=='nosubmit'?'':' onchange="this.form.submit()" ');
$bugtrack_selcat .= '>';
if ($bugtrack_db->db_Select('bugtrack_category', '*', 'where find_in_set(bugtrack_category_read,"' . USERCLASS_LIST . '") order by bugtrack_category_name', 'nowhere'))
{
if ($parm!='nosubmit')
{
    $bugtrack_selcat .= '<option value="0" ' . ($bugtrack_jokecat == 0?'selected="selected"':'') . '>' . BUGTRACK_108 . '</option>';
}
    while ($bugtrack_row = $bugtrack_db->db_Fetch())
    {
        $bugtrack_selcat .= '<option value="' . $bugtrack_row['bugtrack_category_id'] . '"';
        $bugtrack_jokecat = ($bugtrack_jokecat > 0?$bugtrack_jokecat :0);
        # $bugtrack_selcat .= ($bugtrack_category_id == $bugtrack_jokecat?" selected='selected'":"");
        if ($bugtrack_row['bugtrack_category_id'] == $bugtrack_jokecat)
        {
            $bugtrack_selcat .= ' selected="selected"';

            $bugtrack_desc = $bugtrack_row['bugtrack_category_description'];
        }
        $bugtrack_selcat .= ">" . $bugtrack_row['bugtrack_category_name'] . "</option>";
    } // while
}
else
{
    $bugtrack_selcat .= '<option value="">' . BUGTRACK_4 . '</option>';
}
$bugtrack_selcat .= '</select>';
if ($bugtrack_jokecat == 0)
{
    $bugtrack_desc = BUGTRACK_109;
}
return $bugtrack_selcat;
}

function sc_JOKE_CAT_DESC ()
{
global $bugtrack_desc;
return $bugtrack_desc;
}

function sc_JOKE_CAT_JOKE ()
{
global $bugtrack_jokeorder, $bugtrack_from, $bugtrack_jokeid, $bugtrack_jokecat, $bugtrack_jokeorder;
switch ($bugtrack_jokeorder)
{
    case 1:
        $retval = "<a href='?$bugtrack_from.show.$bugtrack_jokeid.$bugtrack_jokecat.0' title='" . BUGTRACK_63 . BUGTRACK_60 . "' >  " . BUGTRACK_60 . "</a>";
        break;
    case 2:
        $retval = "<a href='?$bugtrack_from.show.$bugtrack_jokeid.$bugtrack_jokecat.0' title='" . BUGTRACK_63 . BUGTRACK_60 . "' >  " . BUGTRACK_60 . "</a>";
        break;
    case 0:
    default:
        $retval = "<strong>" . BUGTRACK_60 . "</strong>&nbsp;<img src='".BUGTRACK_IMAGES."/images/darrow.gif' style='border:0;' alt='' />";
        break;
}
return $retval;
}

function sc_JOKE_CAT_POST ()
{
global $bugtrack_jokeorder, $bugtrack_from, $bugtrack_jokeid, $bugtrack_jokecat, $bugtrack_jokeorder;

switch ($bugtrack_jokeorder)
{
    case "1":
        $retval = "<strong>" . BUGTRACK_61 . "</strong>&nbsp;<img src='".BUGTRACK_IMAGES."/images/darrow.gif' style='border:0;' alt='' />";
        break;
    case "2":
        $retval = "<a href='?$bugtrack_from.show.$bugtrack_jokeid.$bugtrack_jokecat.1' title='" . BUGTRACK_63 . BUGTRACK_61 . "' >  " . BUGTRACK_61 . "</a>";
        break;
    default:
        $retval = "<a href='?$bugtrack_from.show.$bugtrack_jokeid.$bugtrack_jokecat.1' title='" . BUGTRACK_63 . BUGTRACK_61 . "' >  " . BUGTRACK_61 . "</a>";
        break;
}
return $retval;

}

function sc_JOKE_CAT_DATE ()
{
global $bugtrack_jokeorder, $bugtrack_from, $bugtrack_jokeid, $bugtrack_jokecat, $bugtrack_jokeorder;
switch ($bugtrack_jokeorder)
{
    case "1":
        $retval = "<a href='?$bugtrack_from.show.$bugtrack_jokeid.$bugtrack_jokecat.2' title='" . BUGTRACK_63 . BUGTRACK_62 . "' >  " . BUGTRACK_62 . "</a>";
        break;
    case "2":
        $retval = "<strong>" . BUGTRACK_62 . "</strong>&nbsp;<img src='".BUGTRACK_IMAGES."/images/darrow.gif' style='border:0;' alt='' />";
        break;
    default:
        $retval = "<a href='?$bugtrack_from.show.$bugtrack_jokeid.$bugtrack_jokecat.2' title='" . BUGTRACK_63 . BUGTRACK_62 . "' >  " . BUGTRACK_62 . "</a>";
        break;
}
return $retval;

}

function sc_JOKE_CAT_RATEING ($parm=null)
{
global $bugtrack_id,$rater;


if ($ratearray = $rater->getrating("bugtrack", $bugtrack_id))
{
    for($c = 1; $c <= $ratearray[1]; $c++)
    {
        $bugtrack_view_rating .= "<img src='".BUGTRACK_IMAGES."/images/star.png' alt='' />";
    }
    if ($ratearray[2])
    {
        $bugtrack_view_rating .= "<img src='".BUGTRACK_IMAGES."/images/" . $ratearray[2] . ".png'  alt='' />";
    }
    if ($ratearray[2] == "")
    {
        $ratearray[2] = 0;
    }
    $bugtrack_view_rating .= "&nbsp;" . $ratearray[1] . "." . $ratearray[2] . " - " . $ratearray[0] . "&nbsp;";
    $bugtrack_view_rating .= ($ratearray[0] == 1 ? BUGTRACK_89 : BUGTRACK_88);
}
#if (strtolower($parm) == "none")
else
{
    $bugtrack_view_rating .= " ".BUGTRACK_87;
}
if (strtolower($parm) != "none")
{
    if (!$rater->checkrated("bugtrack", $bugtrack_id) && USER)
    {
        $bugtrack_view_rating .= $rater->rateselect("<br /><b>" . BUGTRACK_75, "bugtrack", $bugtrack_id) . "</b>";
    }
    else if (!USER)
    {
        $bugtrack_view_rating .= "&nbsp;";
    }
    else
    {
        $bugtrack_view_rating .= "&nbsp;" . BUGTRACK_86;
    }
}
return $bugtrack_view_rating;
}

function sc_JOKE_CAT_JOKELIST ()
{
global  $bugtrack_id, $bugtrack_from, $bugtrack_jokecat, $bugtrack_jokeorder, $bugtrack_name, $bugtrack_view_rating;
return "<a href='" . e_SELF . "?$bugtrack_from.view.$bugtrack_id.$bugtrack_jokecat.$bugtrack_jokeorder' >" . $this->tp->toHTML($bugtrack_name, false) . "</a><br />$bugtrack_view_rating";

}

function sc_JOKE_CAT_POSTLIST ()
{
global  $bugtrack_author;
$bugtrack_poster = explode(".", $bugtrack_author);
$bugtrack_postername = $bugtrack_poster[1];
return $this->tp->toHTML($bugtrack_postername, false);
}

function sc_JOKE_CAT_DATELIST ($parm=null)
{
global $bugtrack_posted, $bugtrack_gen;
$bugtrack_posted = $bugtrack_gen->convert_date($bugtrack_posted, $parm);
return $bugtrack_posted;
}

function sc_JOKE_CAT_SUBMIT ()
{
global  $bugtrack_id, $bugtrack_from, $bugtrack_jokecat, $bugtrack_jokeorder;
return "<a href='?$bugtrack_from.submit.$bugtrack_jokeid.$bugtrack_jokecat.$bugtrack_jokeorder'>" . BUGTRACK_11 . "</a>";
}

function sc_JOKE_SHOW_NAME ()
{
global  $bugtrack_name;
return $this->tp->toHTML($bugtrack_name, false);
}

function sc_JOKE_SHOW_BODY ()
{
global  $bugtrack_body;
return $this->tp->toHTML($bugtrack_body, true);
}

function sc_JOKE_SHOW_POSTER ()
{
global  $bugtrack_author;
$bugtrack_tmp=explode(".",$bugtrack_author);

return $this->tp->toHTML($bugtrack_tmp[1], false);
}

function sc_JOKE_SUBMIT_RESULT ()
{
global $bugtrack_db, $BUGTRACK_PREF, $e_event;
if (USER)
{
    $bugtrack_username = USERID . "." . USERNAME;
}
else
{
    $bugtrack_username = (empty($_POST['bugtrack_username'])?"Anon":$_POST['bugtrack_username']);
    $bugtrack_username = "0." . $bugtrack_username ;
}
$bugtrack_approved = (check_class($BUGTRACK_PREF['bugtrack_autoclass'])?1:0);
$bugtrack_args = "
		'0',
		'" . $this->tp->toDB($_POST['bugtrack_name']) . "',
		'" . $this->tp->toDB($bugtrack_username) . "',
		'" . $this->tp->toDB($_POST['bugtrack_body']) . "',
		'" . $_POST['bugtrack_select'] . "',
		'" . $bugtrack_approved . "',
		'" . time()."'";
$bugtrack_newid = $bugtrack_db->db_Insert("bugtrack_bugs", $bugtrack_args);
if ($bugtrack_newid)
{
    $edata_sn = array("user" => USERNAME, "itemtitle" => $_POST['bugtrack_name'], "catid" => intval($bugtrack_newid));
    $e_event->trigger("jokepost", $edata_sn);
    $retval = BUGTRACK_18;
}
else
{
    $retval = BUGTRACK_19 ;
}
return $retval;
}

function sc_JOKE_SUBMIT_POSTER ()
{
 if (USER)
                {
                    $retval = USERNAME ;
                }
                else
                {
                    $retval = "<input type='text' class='tbox' name='bugtrack_username' />";
                }
return $retval;
}

function sc_JOKE_SUBMIT_NAME ()
{
return "<input type='text' size='60%' maxlength='50' class='tbox' name='bugtrack_name' />";

}

function sc_JOKE_SUBMIT_BODY ()
{
global $BUGTRACK_PREF;
 require_once(e_HANDLER . "ren_help.php");

$insertjs = (!$BUGTRACK_PREF['wysiwyg'])?"rows='10' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'":
            "rows='20' style='width:100%' ";
            $bugtrack_body = $this->tp->toForm($bugtrack_body);
            $retval .= "<textarea class='tbox' id='bugtrack_body' name='bugtrack_body' cols='80'  style='width:95%' $insertjs>" . (strstr($bugtrack_body, "[img]http") ? $bugtrack_body : str_replace("[img]../", "[img]", $bugtrack_body)) . "</textarea>";
            if (!$BUGTRACK_PREF['wysiwyg'])
            {
                $retval .= "<input id='helpb' class='helpbox' type='text' name='helpb' size='100' style='width:95%'/>
			<br />" . display_help("helpb");
            }
return $retval;
}

function sc_JOKE_RSS ()
{
global $bugtrack_jokecat,$PLUGINS_DIRECTORY;
$retval = BUGTRACK_112."&nbsp;";
if ($bugtrack_jokecat>0)
{
	$bugtrack_rsscat = ".".$bugtrack_jokecat;
	$retval = BUGTRACK_113."&nbsp;";
}
$retval .= "<a href='".e_BASE.$PLUGINS_DIRECTORY."rss_menu/rss.php?bugs.1{$bugtrack_rsscat}'><img src='".BUGTRACK_IMAGES."/images/rss1.png' alt='RSS 1' title='RSS 1' style='border:0;' /></a>&nbsp;&nbsp;";
$retval .= "<a href='".e_BASE.$PLUGINS_DIRECTORY."rss_menu/rss.php?bugs.2{$bugtrack_rsscat}'><img src='".BUGTRACK_IMAGES."/images/rss2.png' alt='RSS 2' title='RSS 2' style='border:0;' /></a>&nbsp;&nbsp;";
$retval .= "<a href='".e_BASE.$PLUGINS_DIRECTORY."rss_menu/rss.php?bugs.3{$bugtrack_rsscat}'><img src='".BUGTRACK_IMAGES."/images/rss3.png' alt='RSS RDF' title='RSS RDF' style='border:0;' /></a>&nbsp;&nbsp;";
$retval .= "<a href='".e_BASE.$PLUGINS_DIRECTORY."rss_menu/rss.php?bugs.4{$bugtrack_rsscat}'><img src='".BUGTRACK_IMAGES."/images/rss4.png' alt='RSS ATOM' title='RSS ATOM' style='border:0;' /></a>";
return $retval;

}
*/
}