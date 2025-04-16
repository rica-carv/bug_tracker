<?php
if (!defined('e107_INIT'))
{
    exit;
}
include_once(e_HANDLER . 'shortcode_handler.php');
$bugs_shortcodes = $tp->e_sc->parse_scbatch(__FILE__);
/*
SC_BEGIN BUGTRACK_F_GO
return '<input class="tbox" name="bugfilter" type="submit" value="'.BUGTRACK_73.'" />';
SC_END

SC_BEGIN BUGTRACK_F_FILTER
global $tp,$BUGTRACK_PREF,$sql,$bugtrack_fassigned;
$retval='<select class="tbox" name="bugtrack_fassigned" onchange="this.form.submit()">';
$retval.='<option value="0" '.($bugtrack_fassigned==0?'selected="selected"':'').'>'.BUGTRACK_70.'</option>';

$retval.='<option value="-1" '.($bugtrack_fassigned==-1?'selected="selected"':'').'>'.BUGTRACK_69.'</option>';
$retval.='<option value="-2" '.($bugtrack_fassigned==-2?'selected="selected"':'').'>'.BUGTRACK_72.'</option>';

$retval.='<option value="-99" disabled="disabled">'.BUGTRACK_71.'</option>';

$sql->db_Select('user','user_name,user_id','where find_in_set("'.$BUGTRACK_PREF['bugtrack_devclass'].'",user_class) order by user_name','nowhere',false);

while ($row=$sql->db_Fetch())
{
	extract($row);
	$retval.='<option value="'.$user_id.'"  '.($bugtrack_fassigned==$user_id?'selected="selected"':'').'>'.$tp->toDB($user_name).'</option>';

}
$retval.='</select>';
return $retval;

SC_END
SC_BEGIN BUGTRACK_F_RESOLUTION
global $tp,$bugtrack_fresolution,$bugtrack_resarray;

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
SC_END

SC_BEGIN BUGTRACK_F_STATUS
global $tp,$bugtrack_fstatus,$bugtrack_statusarray;

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
SC_END

SC_BEGIN BUGTRACK_ID
global $tp,$bugtrack_id;
return $bugtrack_id;
SC_END

SC_BEGIN BUGTRACK_DEVELOPER
global $tp,$user_name;
if (empty($user_name))
{
	return BUGTRACK_77;
}
else
{
	return $tp->toHTML($user_name);
}
SC_END

SC_BEGIN BUGTRACK_DOWNLOAD
global $tp,$bugtrack_app_dload;
if (!empty($bugtrack_app_dload))
{
return  '<a href="'.$bugtrack_app_dload.'">'.BUGTRACK_56.'</a> ';
}
SC_END

SC_BEGIN BUGTRACK_FORUM
global $tp,$bugtrack_app_forum;
if (!empty($bugtrack_app_forum))
{
return  '<a href="'.$bugtrack_app_forum.'">'.BUGTRACK_57.'</a> ';
}
SC_END


SC_BEGIN BUGTRACK_LISTNP
global $tp, $bugtrack_npa,$sql,$bugtrack_tmpf,$bugtrack_perpage,$bugtrack_count,$bugtrack_action, $bugtrack_from, $bugtrack_bugid, $bugtrack_bugapp, $BUGTRACK_PREF;


$action = "$bugtrack_npa.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf";
$parms = $bugtrack_count . ',' . $bugtrack_perpage . ',' . $bugtrack_from . ',' . e_SELF . '?' . '[FROM].' . $action;
return $tp->parseTemplate("{NEXTPREV={$parms}}");
SC_END

SC_BEGIN BUGTRACK_UPDATED
global $bugtrak_inserted;
if ($bugtrak_inserted)
{
	return BUGTRACK_53;
}
else
{
	return BUGTRACK_37;
}

SC_END

SC_BEGIN BUGTRACK_OPTSUBMIT
return '<input type="submit" class="tbox" name="bugtrack_opt" value="' . BUGTRACK_52 . '" />';
SC_END

SC_BEGIN BUGTRACK_DEVFIELD
global $tp,$bugtrack_devcomment;
$retval='<textarea class="tbox" name="bugtrack_devcomment" cols="50" rows="6" style="width:80%" >'.$tp->toFORM($bugtrack_devcomment).'</textarea>';
return $retval;
SC_END

SC_BEGIN BUGTRACK_ADMINFIELD
global $tp,$bugtrack_admincomment;
$retval='<textarea class="tbox" name="bugtrack_admincomment" cols="50" rows="6" style="width:80%">'.$tp->toFORM($bugtrack_admincomment).'</textarea>';
return $retval;
SC_END

SC_BEGIN BUGTRACK_ASSIGNFIELD
global $tp,$BUGTRACK_PREF,$sql,$bugtrack_assigned;
$retval='<select class="tbox" name="bugtrack_assigned">';
	$retval.='<option value="0" '.($bugtrack_assigned==0?'selected="selected"':'').'>'.BUGTRACK_51.'</option>';
$sql->db_Select('user','user_name,user_id',"where find_in_set('".$BUGTRACK_PREF['bugtrack_devclass']."',user_class) order by user_name",'nowhere',false);

while ($row=$sql->db_Fetch())
{
	extract($row);
	$retval.='<option value="'.$user_id.'"  '.($bugtrack_assigned==$user_id?'selected="selected"':'').'>'.$tp->toDB($user_name).'</option>';

}
$retval.='</select>';
return $retval;
SC_END
SC_BEGIN BUGTRACK_SUBMIT_BUTTON
return '<input type="submit" class="tbox" name="bugtrack_submit" value="' . BUGTRACK_43 . '" />';
SC_END

SC_BEGIN BUGTRACK_FLAGFIELD
global $tp,$bugtrack_flag,$bugtrack_flagarray;

$retval = '<select class="tbox" name="bugtrack_flag">';
$i=0;
foreach($bugtrack_flagarray as $row)
{
	$retval.='<option value="'.$i.'" '.($bugtrack_flag==$i?'selected="selected"':'').' >'.$row.'</option>';
$i++;
}
$retval .= '</select>';
return $retval;
SC_END


SC_BEGIN BUGTRACK_RESFIELD
global $tp,$bugtrack_resolution,$bugtrack_resarray;

$retval = '<select class="tbox" name="bugtrack_resolution">';
$i=0;
foreach($bugtrack_resarray as $row)
{
	$retval.='<option value="'.$i.'" '.($bugtrack_resolution==$i?'selected="selected"':'').' >'.$row.'</option>';
$i++;
}
$retval .= '</select>';
return $retval;
SC_END

SC_BEGIN BUGTRACK_STATUSFIELD
global $tp,$bugtrack_status,$bugtrack_statusarray;

$retval = '<select class="tbox" name="bugtrack_status">';
$i=0;
foreach($bugtrack_statusarray as $row)
{
	$retval.='<option value="'.$i.'" '.($bugtrack_status==$i?'selected="selected"':'').' >'.$row.'</option>';
$i++;
}
$retval .= '</select>';
return $retval;
SC_END

SC_BEGIN BUGTRACK_INSERTID
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

SC_END

SC_BEGIN BUGTRACK_DESCFIELD
global $tp,$bugtrack_name;
return '<input type="text" style="width:80%" class="tbox" name="bugtrack_name" value="'.$tp->toFORM($bugtrack_name).'" />';
SC_END

SC_BEGIN BUGTRACK_EXFIELD
global $tp,$bugtrack_exampleurl;
return '<input type="text" style="width:80%" class="tbox" name="bugtrack_exampleurl" value="'.$tp->toFORM($bugtrack_exampleurl).'" />';
SC_END

SC_BEGIN BUGTRACK_MAINFIELD
global $tp,$bugtrack_body;
return '<textarea class="tbox" style="width:80%;" cols="50" rows="6" name="bugtrack_body">'.$tp->toFORM($bugtrack_body).'</textarea>';
SC_END
SC_BEGIN BUGTRACK_PRIORITYFIELD
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
SC_END

SC_BEGIN BUGTRACK_APPSEL
global $sql,$tp,$bugtrack_bugapp;
$retval ='<select name="bugtrack_category" class="tbox">';
if ($sql->db_Select('bugtrack_apps','bugtrack_app_id,bugtrack_app_name','order by bugtrack_app_name','nowhere',false))
{
	while ($row=$sql->db_Fetch())
	{
	extract($row);
	$retval .= '<option value="'.$bugtrack_app_id.'" '.($bugtrack_app_id==$bugtrack_bugapp?'selected="selected"':'').'>'.$tp->toFORM($bugtrack_app_name).'</option>';
	}
}
$retval .='</select>';
return $retval;
SC_END

SC_BEGIN BUGTRACK_SUBMITNEW
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
	else
	{
		$retval = "<a href='".e_SELF."?$bugtrack_from.new.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf' ><img src='".BUGTRACK_IMAGES."/images/bugtracknew.png' alt='".BUGTRACK_78."' title='".BUGTRACK_78."' style='border:0;'/></a>";
	}
}
return $retval;
SC_END

SC_BEGIN BUGTRACK_OPTIONS
global $BUGTRACK_PREF,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from,$bugtrack_tmpf;
if (check_class($BUGTRACK_PREF['bugtrack_devclass']) || check_class($BUGTRACK_PREF['bugtrack_adminclass']))
{
	$retval = "<a href='".e_SELF."?$bugtrack_from.opt.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf' >".BUGTRACK_26."</a>";
}
return $retval;
SC_END

SC_BEGIN BUGTRACK_POSTED
global $tp,$bugtrack_gen,$bugtrack_posted;
if ($parm=='long' || $parm=='short')
{
	return $tp->toHTML($bugtrack_gen->convert_date($bugtrack_posted,$parm),false);
}
else
{
	if (empty($parm))
	{
	return $tp->toHTML(date('d-m-Y',$bugtrack_posted),false);
	}
	else
	{
	return $tp->toHTML(date($parm,$bugtrack_posted),false);
	}
}
SC_END

SC_BEGIN BUGTRACK_RESOLUTION
global $tp,$bugtrack_resarray,$bugtrack_resolution;
return $tp->toHTML($bugtrack_resarray[$bugtrack_resolution],false);

SC_END

SC_BEGIN BUGTRACK_FLAG
global $tp,$bugtrack_flagarray,$bugtrack_flag;
return $tp->toHTML($bugtrack_flagarray[$bugtrack_flag],false);

SC_END

SC_BEGIN BUGTRACK_ADMINCOMMENT
global $tp,$bugtrack_admincomment;
return $tp->toHTML($bugtrack_admincomment,false);
SC_END

SC_BEGIN BUGTRACK_DEVCOMMENT
global $tp,$bugtrack_devcomment;
return $tp->toHTML($bugtrack_devcomment,false);
SC_END

SC_BEGIN BUGTRACK_EXPLAIN
global $tp,$bugtrack_body;
return $tp->toHTML($bugtrack_body,false);
SC_END

SC_BEGIN BUGTRACK_EXAMPLEURL
global $tp,$bugtrack_exampleurl;
return $tp->toHTML($bugtrack_exampleurl,false);
SC_END

SC_BEGIN BUGTRACK_NAME
global $tp,$bugtrack_name,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from,$bugtrack_tmpf;
if ($parm=='link')
{
	return '<a href="'.e_SELF."?$bugtrack_from.item.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf\" >".$tp->toHTML($bugtrack_name,false).'</a>';
}
else
{
	return $tp->toHTML($bugtrack_name,false);
}
SC_END

SC_BEGIN BUGTRACK_POSTER
global $tp,$bugtrack_aname;
return $tp->toHTML($bugtrack_aname,false);
SC_END

SC_BEGIN BUGTRACK_STATUS
global $tp,$bugtrack_statusarray,$bugtrack_status;
if (!is_numeric($bugtrack_status))
{
	$bugtrack_status=0;
}
$bugtrack_temp=$bugtrack_statusarray[$bugtrack_status];
return $tp->toHTML($bugtrack_temp,false);
SC_END

SC_BEGIN BUGTRACK_ASSIGNEE
global $tp,$user_name;
if (empty($user_name))
{
$bugtrack_uname=BUGTRACK_21;
}
else
{
$bugtrack_uname=$user_name;
}
return $tp->toHTML($bugtrack_uname,false);
SC_END

SC_BEGIN BUGTRACK_PRIORITY
global $tp,$bugtrack_priority,$bugtrack_colourarray;
if ($parm==nocolour)
{
$retval=$tp->toHTML($bugtrack_priority,false);
}
else
{
$retval='<div style="background-color:'.$bugtrack_colourarray[$bugtrack_priority].'">'.$tp->toHTML($bugtrack_priority,false).'</div>';
}
return $retval;
SC_END

SC_BEGIN BUGTRACK_ICON
global $bugtrack_app_icon,$tp;
if (!empty($bugtrack_app_icon) )
{
	return '<img src="'.BUGTRACK_IMAGES.'/icons/'.$tp->toFORM($bugtrack_app_icon).'" style="width:48px;height:48px;border:0;" alt="icon" />';
}
else
{
	return '<img src="'.BUGTRACK_IMAGES.'/images/blank.png" style="width:48px;height:48px;border:0;" alt="" />';
}
SC_END

SC_BEGIN BUGTRACK_APPNAME
global $tp,$bugtrack_app_name,$bugtrack_app_id,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from,$bugtrack_tmpf;
if ($parm=='link')
{
return "<a href='".e_SELF."?0.view.$bugtrack_app_id.$bugtrack_bugid.$bugtrack_from'>".$tp->toHTML($bugtrack_app_name,false)."</a>";
}
else
{
return $tp->toHTML($bugtrack_app_name,false);
}
SC_END

SC_BEGIN BUGTRACK_APPDESC
global $tp,$bugtrack_app_description;
return $tp->toHTML($bugtrack_app_description,false);
SC_END

SC_BEGIN BUGTRACK_OPEN
global $tp,$bugtrack_open;
return str_pad($tp->toHTML($bugtrack_open,false),1,'0');
SC_END

SC_BEGIN BUGTRACK_CLOSED
global $tp,$bugtrack_closed;
return str_pad($tp->toHTML($bugtrack_closed,false),1,'0');
SC_END

SC_BEGIN BUGTRACK_PENDING
global $tp,$bugtrack_pending;
return str_pad($tp->toHTML($bugtrack_pending,false),1,'0');
SC_END

SC_BEGIN BUGTRACK_TOTAL
global $tp,$bugtrack_total;
return str_pad($tp->toHTML($bugtrack_total,false),1,'0');
SC_END

SC_BEGIN BUGTRACK_SHOW_UP
global $tp,$bugtrack_action,$bugtrack_app_name,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from,$bugtrack_tmpf;
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
	return "<a href='".e_SELF."?$bugtrack_newfrom.$bugtrack_newaction.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf'>".BUGTRACK_28 . "</a>";
}
else
{
	return "<a href='".e_SELF."?$bugtrack_newfrom.$bugtrack_newaction.$bugtrack_bugapp.$bugtrack_bugid.$bugtrack_tmpf'><img src='".BUGTRACK_IMAGES."/images/updir.png' style='border:0;' alt='" . BUGTRACK_28 . "' title='" . BUGTRACK_28 . "' /></a>";
}
SC_END

SC_BEGIN BUGTRACK_SHOW_PRINT
global $tp,$bugtrack_app_name,$bugtrack_app_id,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from;
if ($parm=='noicon')
{
return "<a href='../../print.php?plugin:bug_tracker.$bugtrack_bugid' >" . BUGTRACK_29 . "</a>";
}
else
{
return "<a href='../../print.php?plugin:bug_tracker.$bugtrack_bugid' ><img src='" . e_IMAGE . "generic/" . IMODE . "/printer.png' style='border:0;' title='" . BUGTRACK_29 . "' alt='" . BUGTRACK_29 . "' /></a>";

}

SC_END

SC_BEGIN BUGTRACK_SHOW_EMAIL
global $tp,$bugtrack_app_name,$bugtrack_app_id,$bugtrack_bugapp,$bugtrack_bugid,$bugtrack_from;
if ($parm=="noicon")
{
	return "<a href='../../email.php?plugin:bug_tracker." . $bugtrack_bugid . "'>".BUGTRACK_30 . "</a>";
}
else
{
	return "<a href='../../email.php?plugin:bug_tracker." . $bugtrack_bugid . "'><img src='" . e_IMAGE . "generic/" . IMODE . "/email.png' style='border:0' alt='" . BUGTRACK_30 . "' title='" . BUGTRACK_30 . "' /></a>";
}
SC_END

SC_BEGIN JOKE_CAT_SEL
global $row, $tp, $bugtrack_db, $bugtrack_desc, $bugtrack_desc, $bugtrack_jokecat;

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
SC_END

SC_BEGIN JOKE_CAT_DESC
global $bugtrack_desc;
return $bugtrack_desc;
SC_END

SC_BEGIN JOKE_CAT_JOKE
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
SC_END

SC_BEGIN JOKE_CAT_POST
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

SC_END

SC_BEGIN JOKE_CAT_DATE
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

SC_END

SC_BEGIN JOKE_CAT_RATEING
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
        $bugtrack_view_rating .= $rater->rateselect("<br /><b>" . BUGTRACK_85, "bugtrack", $bugtrack_id) . "</b>";
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
SC_END



SC_BEGIN JOKE_CAT_JOKELIST
global $tp, $bugtrack_id, $bugtrack_from, $bugtrack_jokecat, $bugtrack_jokeorder, $bugtrack_name, $bugtrack_view_rating;
return "<a href='" . e_SELF . "?$bugtrack_from.view.$bugtrack_id.$bugtrack_jokecat.$bugtrack_jokeorder' >" . $tp->toHTML($bugtrack_name, false) . "</a><br />$bugtrack_view_rating";

SC_END

SC_BEGIN JOKE_CAT_POSTLIST
global $tp, $bugtrack_author;
$bugtrack_poster = explode(".", $bugtrack_author);
$bugtrack_postername = $bugtrack_poster[1];
return $tp->toHTML($bugtrack_postername, false);
SC_END

SC_BEGIN JOKE_CAT_DATELIST
global $bugtrack_posted, $bugtrack_gen;
$bugtrack_posted = $bugtrack_gen->convert_date($bugtrack_posted, $parm);
return $bugtrack_posted;
SC_END

SC_BEGIN JOKE_CAT_SUBMIT
global $tp, $bugtrack_id, $bugtrack_from, $bugtrack_jokecat, $bugtrack_jokeorder;
return "<a href='?$bugtrack_from.submit.$bugtrack_jokeid.$bugtrack_jokecat.$bugtrack_jokeorder'>" . BUGTRACK_11 . "</a>";
SC_END



SC_BEGIN JOKE_SHOW_NAME
global $tp, $bugtrack_name;
return $tp->toHTML($bugtrack_name, false);
SC_END

SC_BEGIN JOKE_SHOW_BODY
global $tp, $bugtrack_body;
return $tp->toHTML($bugtrack_body, true);
SC_END

SC_BEGIN JOKE_SHOW_POSTER
global $tp, $bugtrack_author;
$bugtrack_tmp=explode(".",$bugtrack_author);

return $tp->toHTML($bugtrack_tmp[1], false);
SC_END


SC_BEGIN JOKE_SUBMIT_RESULT
global $bugtrack_db, $BUGTRACK_PREF, $tp,$e_event;
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
		'" . $tp->toDB($_POST['bugtrack_name']) . "',
		'" . $tp->toDB($bugtrack_username) . "',
		'" . $tp->toDB($_POST['bugtrack_body']) . "',
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
SC_END

SC_BEGIN JOKE_SUBMIT_POSTER
 if (USER)
                {
                    $retval = USERNAME ;
                }
                else
                {
                    $retval = "<input type='text' class='tbox' name='bugtrack_username' />";
                }
return $retval;
SC_END

SC_BEGIN JOKE_SUBMIT_NAME
return "<input type='text' size='60%' maxlength='50' class='tbox' name='bugtrack_name' />";

SC_END

SC_BEGIN JOKE_SUBMIT_BODY
global $tp,$BUGTRACK_PREF;
 require_once(e_HANDLER . "ren_help.php");

$insertjs = (!$BUGTRACK_PREF['wysiwyg'])?"rows='10' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'":
            "rows='20' style='width:100%' ";
            $bugtrack_body = $tp->toForm($bugtrack_body);
            $retval .= "<textarea class='tbox' id='bugtrack_body' name='bugtrack_body' cols='80'  style='width:95%' $insertjs>" . (strstr($bugtrack_body, "[img]http") ? $bugtrack_body : str_replace("[img]../", "[img]", $bugtrack_body)) . "</textarea>";
            if (!$BUGTRACK_PREF['wysiwyg'])
            {
                $retval .= "<input id='helpb' class='helpbox' type='text' name='helpb' size='100' style='width:95%'/>
			<br />" . display_help("helpb");
            }
return $retval;
SC_END



SC_BEGIN JOKE_RSS
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

SC_END

*/
?>