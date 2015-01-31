<?php
/*
*
* ajaxfs Plugin
* Copyright 2011 mostafa shirali
* http://www.pctricks.ir
* No one is authorized to redistribute or remove copyright without my expressed permission.
*
*/

if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}
$plugins->add_hook('index_start', 'ajaxfs');
$plugins->add_hook("xmlhttp", "Ajax_fs_do_action");
// The information that shows up on the plugin manager
function ajaxfs_info()
{
global $lang;
$lang->load("ajaxfs");
return array(
		"name" => $lang->ajaxfs_name,
		"description" =>$lang->ajaxfs_dec ,
		"website" => "http://www.pctricks.ir",
		"author" => "Mostafa shirali",
		"authorsite" => "http://www.mybbhelper.ir",
		"version" => "5.0.5",
        "guid"=> "saqswdxcdfefgttvg",
		"compatibility"	=> "18*"
);
}




// This function runs when the plugin is activated.
function ajaxfs_activate()
{
global $mybb, $db, $templates,$cache,$lang;
	require_once MYBB_ROOT.'inc/adminfunctions_templates.php';
	find_replace_templatesets("index","#".preg_quote('{$forums}')."#i", '{\$ajaxfs_top_panel}{\$forums}{\$ajaxfs_down_panel}');
		$lang->load("ajaxfs");
		    $settings_group = array(
        "gid" => "",
        "name" => "ajaxfs",
        "title" => $lang->ajaxfs_settinggroup,
        "description" => $lang->ajaxfs_settinggroup_dec,
        "disporder" => "88",
        "isdefault" => "0",
        );
    $db->insert_query("settinggroups", $settings_group);
    $gid = $db->insert_id();
	$positions = "select\ntop={$lang->ajaxfs_top}\ndown={$lang->ajaxfs_down}";
	$setting[] = array("sid" => "","name" => "ajaxfs_enable","title" => $lang->ajaxfs_active,"description" => $lang->ajaxfs_active_dec,"optionscode" => "yesno","value" => "0","disporder" => 1,"gid" => intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_lastpost','title'=> $lang->ajaxfs_last_post,'description'	=> $lang->ajaxfs_last_post_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 2,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_mostview','title'=> $lang->ajaxfs_view_post,'description'	=> $lang->ajaxfs_view_post_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 3,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_hottopics','title'=> $lang->ajaxfs_most_reply,'description'	=> $lang->ajaxfs_most_reply_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 4,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_lastuser','title'=> $lang->ajaxfs_last_user,'description'	=> $lang->ajaxfs_last_user_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 5,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_mostposter','title'=> $lang->ajaxfs_most_sender,'description'	=> $lang->ajaxfs_most_sender_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 6,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_mostpoint','title'=> $lang->ajaxfs_top_point,'description'	=> $lang->ajaxfs_top_point_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 7,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_mostthanked','title'=> $lang->ajaxfs_top_thanks,'description'	=> $lang->ajaxfs_top_thanks_dec,'optionscode'=> 'yesno','value'=> '0','disporder'=> 8,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_mostthanker','title'=> $lang->ajaxfs_top_thankers,'description'	=> $lang->ajaxfs_top_thankers_dec,'optionscode'=> 'yesno','value'=> '0','disporder'=> 9,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_popularfile','title'=> $lang->ajaxfs_most_download,'description'	=> $lang->ajaxfs_most_download_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 10,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_Topreferrers','title'=> $lang->ajaxfs_most_reffer,'description'	=> $lang->ajaxfs_most_reffer_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 11,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_hitstat','title'=> $lang->ajaxfs_hitstat,'description'	=> $lang->ajaxfs_hitstat_dec,'optionscode'=> 'yesno','value'=> '1','disporder'=> 12,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_customforum','title'=> $lang->ajaxfs_customforum,'description'	=> $lang->ajaxfs_customforum_dec,'optionscode'=> 'yesno','value'=> '0','disporder'=> 13,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_customforum_in','title'=> $lang->ajaxfs_customforum_in,'description'	=> $lang->ajaxfs_customforum_in_dec,'optionscode'=> 'textarea','value'=> $lang->ajaxfs_customforum_in_value,'disporder'=> 14,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_number_post','title'=> $lang->ajaxfs_number_post,'description'	=> $lang->ajaxfs_number_post_dec,'optionscode'=> 'text','value'=> 15,'disporder'=> 15,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_number_tops','title'=> $lang->ajaxfs_number_tops,'description'	=> $lang->ajaxfs_number_tops_dec,'optionscode'=> 'text','value'=> 15,'disporder'=> 16,'gid'=> intval($gid),);
    $setting[] = array( 'sid'=> "",'name'=> 'ajaxfs_position','title'=> $lang->ajaxfs_position,'description'	=> $lang->ajaxfs_position_dec,'optionscode'=> $positions,'value'=> 'down','disporder'=> 17,'gid'=> intval($gid),);
 	foreach ($setting as $i)
	{
		$db->insert_query("settings", $i);
	}
rebuild_settings();

}






function ajaxfs()
{
	   require_once MYBB_ROOT.'inc/adminfunctions_templates.php';
	global $mybb,$lang,$db,$ajaxfs_top_panel,$ajaxfs_down_panel,$theme,$parser,$templates;
		if (!is_object($parser))
	{
		require_once MYBB_ROOT.'inc/class_parser.php';
		$parser = new postParser;
	}
if($mybb->settings['ajaxfs_enable'] ==1)
{
	$lang->load("ajaxfs");
	if($mybb->settings['ajaxfs_lastpost'] ==1)
	{
	$post_info_option .='<li><a href="#lastpost">'.$lang->ajaxfs_last_post.'</a></li>';
	}
	if($mybb->settings['ajaxfs_mostview'] ==1)
	{
	$post_info_option .='<li><a href="#mosthit">'.$lang->ajaxfs_view_post.'</a></li>';
	}
	if($mybb->settings['ajaxfs_hottopics'] ==1)
	{
	$post_info_option .='<li><a href="#hotpost">'.$lang->ajaxfs_most_reply.'</a></li>';
	}

/*********************************************** LAST POST *************************************************/
$userid=$mybb->user['uid'];
$query_group=$db->query("SELECT * FROM  ".TABLE_PREFIX."users WHERE uid='$userid'");
if($db->num_rows($query_group)==0)
{
$gid=1;
}
else
{
$fetch_group=$db->fetch_array($query_group);
$gid=$fetch_group['usergroup'];
}

	$query = $db->query ("SELECT t1.*
FROM ".TABLE_PREFIX."posts t1
JOIN (
SELECT pid
FROM ".TABLE_PREFIX."posts
WHERE visible='1' ORDER BY pid DESC
)t2 ON t1.pid = t2.pid GROUP BY tid ORDER BY pid DESC");
$lastpost="<table cellspacing='0' id='Ajxfstable'><tr><th>{$lang->ajaxfs_lastpost_title}</th><th>{$lang->ajaxfs_lastpost_writer}</th></tr>";
if($db->num_rows($query)==0)
{
$post_number=0;
}
else
{
if($db->num_rows($query)<=$mybb->settings['ajaxfs_number_post'])
{
$post_number=$db->num_rows($query);
}
else
{
$post_number=$mybb->settings['ajaxfs_number_post'];
}

}
$post_counter=0;
	while($post_counter<$post_number)
	{
		$fetch=$db->fetch_array($query);
		$fid=$fetch['fid'];
		$query_forum_permissins=$db->query ("SELECT * FROM  ".TABLE_PREFIX."forumpermissions WHERE fid='$fid' AND gid='$gid'");
		$canread=1;
		if($db->num_rows($query_forum_permissins)!=0)
		{
		$fetch_forum_permissins=$db->fetch_array($query_forum_permissins);
		if($fetch_forum_permissins['canviewthreads']==1)
		{
		$canread=1;
		}
		else
		{
		$canread=0;
		}
		}
		if($db->num_rows($query_forum_permissins)==0 AND $canread==1)
		{
		$profilelink=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$fetch['uid'];
		$lastposter=$fetch['username'];
		$lastposteruid=$fetch['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$lastposteruid'");
		$fetch_users =$db->fetch_array($query_users);
		$lastposter=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
		$profilelink_lastposter=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$lastposteruid;
		$tid=$fetch['tid'];
		$uid=$mybb->user['uid'];
		$query_view = $db->query("SELECT * FROM ".TABLE_PREFIX."threadsread WHERE tid='$tid' AND uid='$uid'");
		$threadlink = get_post_link($fetch['pid'])."#pid".$fetch['pid'];
		$post_pid=$fetch['pid'];
		if($db->num_rows($query_view)==0)
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_unread.gif">';
		}
		else
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_read.gif">';
		}
		$thread_id=$fetch['tid'];
		$query_thread_sub = $db->query ("SELECT * FROM ".TABLE_PREFIX."threads WHERE tid='$thread_id'");
		$fetch_thread_sub=$db->fetch_array($query_thread_sub);
		$thread_sub=htmlspecialchars_uni(substr($fetch_thread_sub['subject'],0,90));
		$linenumber=$post_counter+1;
		$lastpost .='<tr><td><span id="pagenumber">'.$linenumber.'</span>&nbsp;&nbsp;&nbsp;'.$read_image.'&nbsp;&nbsp;&nbsp;<a href="'.$threadlink.'" target="_blank" id="'.$post_pid.'" onmouseover="javascript:tooltip(event);" onmousemove="javascript:tooltipmove(event);"  onmouseout="javascript:tooltipout();">  '.$thread_sub.'</a></td><td><a href="'.$profilelink_lastposter.'" target="_blank" id="'.$lastposteruid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$lastposter.'</a></td></tr>';
	$post_counter++;
	}
	}
	$lastpost .='</table>';
/*********************************************** LAST POST *************************************************/
/*************************************************** Most Viewed ***************************************/

$most_hit="<table cellspacing='0' id='Ajxfstable'><tr><th>{$lang->ajaxfs_lastpost_title}</th><th>{$lang->ajaxfs_view}</th></tr>";
		$lang->load("ajaxfs");
	$query = $db->query ("SELECT * FROM ".TABLE_PREFIX."threads WHERE visible='1' ORDER BY views DESC LIMIT 0,15");
	
if($db->num_rows($query)==0)
{
$post_number=0;
}
else
{
if($db->num_rows($query)<=$mybb->settings['ajaxfs_number_post'])
{
$post_number=$db->num_rows($query);
}
else
{
$post_number=$mybb->settings['ajaxfs_number_post'];
}

}
$post_counter=0;
	while($post_counter<$post_number)
	{
		$fetch =$db->fetch_array($query);
		$fid=$fetch['fid'];
		$query_forum_permissins=$db->query ("SELECT * FROM  ".TABLE_PREFIX."forumpermissions WHERE fid='$fid' AND gid='$gid'");
		$canread=1;
		if($db->num_rows($query_forum_permissins)!=0)
		{
		$fetch_forum_permissins=$db->fetch_array($query_forum_permissins);
		if($fetch_forum_permissins['canviewthreads']==1)
		{
		$canread=1;
		}
		else
		{
		$canread=0;
		}
		}
		if($db->num_rows($query_forum_permissins)==0 AND $canread==1)
		{
		$threadlink = get_thread_link($fetch['tid']);
		$tid=$fetch['tid'];
		$uid=$mybb->user['uid'];
		$query_view = $db->query("SELECT * FROM ".TABLE_PREFIX."threadsread WHERE tid='$tid' AND uid='$uid'");
		if($db->num_rows($query_view)==0)
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_unread.gif">';
		}
		else
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_read.gif">';
		}
	$thread_sub=htmlspecialchars_uni(substr($fetch['subject'],0,90));
$linenumber=$post_counter+1;
	$most_hit .='<tr '.$even.'><td><span id="pagenumber">'.$linenumber.'</span>&nbsp;&nbsp;&nbsp;'.$read_image.'&nbsp;&nbsp;&nbsp;<a href="'.$threadlink.'" target="_blank">'.$thread_sub.'</a></td><td>'.$fetch['views'].'</td></tr>';
	$post_counter++;
	}
	}
	$most_hit .='</table>';
/************************************************ HOT POSTS **********************************************/
$hotpost="<table cellspacing='0' id='Ajxfstable'><tr><th>{$lang->ajaxfs_lastpost_title}</th><th>{$lang->ajaxfs_rep}</th></tr>";
		$lang->load("ajaxfs");
	$query = $db->query ("SELECT * FROM ".TABLE_PREFIX."threads WHERE visible='1' ORDER BY replies DESC LIMIT 0,15");
if($db->num_rows($query)==0)
{
$post_number=0;
}
else
{
if($db->num_rows($query)<=$mybb->settings['ajaxfs_number_post'])
{
$post_number=$db->num_rows($query);
}
else
{
$post_number=$mybb->settings['ajaxfs_number_post'];
}

}
$post_counter=0;
	while($post_counter<$post_number)
	{
		$fetch =$db->fetch_array($query);
		$fid=$fetch['fid'];
		$query_forum_permissins=$db->query ("SELECT * FROM  ".TABLE_PREFIX."forumpermissions WHERE fid='$fid' AND gid='$gid'");
		$canread=1;
		if($db->num_rows($query_forum_permissins)!=0)
		{
		$fetch_forum_permissins=$db->fetch_array($query_forum_permissins);
		if($fetch_forum_permissins['canviewthreads']==1)
		{
		$canread=1;
		}
		else
		{
		$canread=0;
		}
		}
		if($db->num_rows($query_forum_permissins)==0 AND $canread==1)
		{
		$threadlink = get_thread_link($fetch['tid']);
		$tid=$fetch['tid'];
		$uid=$mybb->user['uid'];
		$query_view = $db->query("SELECT * FROM ".TABLE_PREFIX."threadsread WHERE tid='$tid' AND uid='$uid'");
		if($db->num_rows($query_view)==0)
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_unread.gif">';
		}
		else
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_read.gif">';
		}
	$thread_sub=(substr($fetch['subject'],0,90));
	$linenumber=$post_counter+1;
	$hotpost .='<tr '.$even.'><td><span id="pagenumber">'.$linenumber.'</span>&nbsp;&nbsp;&nbsp;'.$read_image.'&nbsp;&nbsp;&nbsp;<a href="'.$threadlink.'" target="_blank">'.$thread_sub.'</a></td><td>'.$fetch['replies'].'</td></tr>';

	$post_counter++;
	}
	}
	$hotpost.='</table>';
/************************************************ HOT POSTS **********************************************/
/************************************************ OTHER POSTS **********************************************/
	if($mybb->settings['ajaxfs_customforum'] ==1)
	{
	$other_cat=$mybb->settings['ajaxfs_customforum_in'];
	$category_number=explode('>>',$other_cat);
	if($category_number==1)
	{
	$category_name_part=explode('|',$other_cat);
	$category_name=$category_name_part[0];
	$forum_ids=preg_replace("#[^0-9,]#i",'', $category_name_part[1]);
	$post_info_option .='<li><a href="#other_cat">'.$category_name.'</a></li>';
		$query = $db->query ("SELECT t1.*
FROM ".TABLE_PREFIX."posts t1
JOIN (
SELECT pid
FROM ".TABLE_PREFIX."posts
WHERE fid
IN (".$forum_ids.")
AND visible='1' ORDER BY pid DESC
)t2 ON t1.pid = t2.pid GROUP BY tid ORDER BY pid DESC");
$otherposts="<table cellspacing='0' id='Ajxfstable'><tr><th>{$lang->ajaxfs_lastpost_title}</th><th>{$lang->ajaxfs_lastpost_writer}</th></tr>";
if($db->num_rows($query)==0)
{
$post_number=0;
}
else
{
if($db->num_rows($query)<=$mybb->settings['ajaxfs_number_post'])
{
$post_number=$db->num_rows($query);
}
else
{
$post_number=$mybb->settings['ajaxfs_number_post'];
}

}
$post_counter=0;
	while($post_counter<$post_number)
	{
		$fetch=$db->fetch_array($query);
		$fid=$fetch['fid'];
		$query_forum_permissins=$db->query ("SELECT * FROM  ".TABLE_PREFIX."forumpermissions WHERE fid='$fid' AND gid='$gid'");
		$canread=1;
		if($db->num_rows($query_forum_permissins)!=0)
		{
		$fetch_forum_permissins=$db->fetch_array($query_forum_permissins);
		if($fetch_forum_permissins['canviewthreads']==1)
		{
		$canread=1;
		}
		else
		{
		$canread=0;
		}
		}
		if($db->num_rows($query_forum_permissins)==0 AND $canread==1)
		{
		$profilelink=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$fetch['uid'];
		$lastposter=$fetch['username'];
		$lastposteruid=$fetch['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$lastposteruid'");
		$fetch_users =$db->fetch_array($query_users);
		$lastposter=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
		$profilelink_lastposter=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$lastposteruid;
		$tid=$fetch['tid'];
		$uid=$mybb->user['uid'];
		$query_view = $db->query("SELECT * FROM ".TABLE_PREFIX."threadsread WHERE tid='$tid' AND uid='$uid'");
		$threadlink = get_post_link($fetch['pid'])."#pid".$fetch['pid'];
		$post_pid=$fetch['pid'];
		if($db->num_rows($query_view)==0)
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_unread.gif">';
		}
		else
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_read.gif">';
		}
		$thread_id=$fetch['tid'];
		$query_thread_sub = $db->query ("SELECT * FROM ".TABLE_PREFIX."threads WHERE tid='$thread_id'");
		$fetch_thread_sub=$db->fetch_array($query_thread_sub);
		$thread_sub=htmlspecialchars_uni(substr($fetch_thread_sub['subject'],0,90));
		$linenumber=$post_counter+1;
		$otherposts .='<tr><td><span id="pagenumber">'.$linenumber.'</span>&nbsp;&nbsp;&nbsp;'.$read_image.'&nbsp;&nbsp;&nbsp;<a href="'.$threadlink.'" target="_blank" id="'.$post_pid.'" onmouseover="javascript:tooltip(event);" onmousemove="javascript:tooltipmove(event);"  onmouseout="javascript:tooltipout();">  '.$thread_sub.'</a></td><td><a href="'.$profilelink_lastposter.'" target="_blank" id="'.$lastposteruid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$lastposter.'</a></td></tr>';
	$post_counter++;
	}
	}
	$otherposts .='</table>';
	$other_cat_info .='<div id="other_cat">'.$otherposts.'</div>';
	}
	else //If Other Table More One
	{
	for($i=0;$i<count($category_number);$i++)
	{
	$category_name_part=explode('|',$category_number[$i]);
	$category_name=$category_name_part[0];
	$forum_ids=preg_replace("#[^0-9,]#i",'', $category_name_part[1]);
	$post_info_option .='<li><a href="#other_cat_'.$i.'">'.$category_name.'</a></li>';
		$query = $db->query ("SELECT t1.*
FROM ".TABLE_PREFIX."posts t1
JOIN (
SELECT pid
FROM ".TABLE_PREFIX."posts
WHERE fid
IN (".$forum_ids.")
AND visible='1' ORDER BY pid DESC
)t2 ON t1.pid = t2.pid GROUP BY tid ORDER BY pid DESC");
$otherposts="<table cellspacing='0' id='Ajxfstable'><tr><th>{$lang->ajaxfs_lastpost_title}</th><th>{$lang->ajaxfs_lastpost_writer}</th></tr>";
if($db->num_rows($query)==0)
{
$post_number=0;
}
else
{
if($db->num_rows($query)<=$mybb->settings['ajaxfs_number_post'])
{
$post_number=$db->num_rows($query);
}
else
{
$post_number=$mybb->settings['ajaxfs_number_post'];
}

}
$post_counter=0;
	while($post_counter<$post_number)
	{
		$fetch=$db->fetch_array($query);
		$fid=$fetch['fid'];
		$query_forum_permissins=$db->query ("SELECT * FROM  ".TABLE_PREFIX."forumpermissions WHERE fid='$fid' AND gid='$gid'");
		$canread=1;
		if($db->num_rows($query_forum_permissins)!=0)
		{
		$fetch_forum_permissins=$db->fetch_array($query_forum_permissins);
		if($fetch_forum_permissins['canviewthreads']==1)
		{
		$canread=1;
		}
		else
		{
		$canread=0;
		}
		}
		if($db->num_rows($query_forum_permissins)==0 AND $canread==1)
		{
		$profilelink=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$fetch['uid'];
		$lastposter=$fetch['username'];
		$lastposteruid=$fetch['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$lastposteruid'");
		$fetch_users =$db->fetch_array($query_users);
		$lastposter=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
		$profilelink_lastposter=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$lastposteruid;
		$tid=$fetch['tid'];
		$uid=$mybb->user['uid'];
		$query_view = $db->query("SELECT * FROM ".TABLE_PREFIX."threadsread WHERE tid='$tid' AND uid='$uid'");
		$threadlink = get_post_link($fetch['pid'])."#pid".$fetch['pid'];
		$post_pid=$fetch['pid'];
		if($db->num_rows($query_view)==0)
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_unread.gif">';
		}
		else
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_read.gif">';
		}
		$thread_id=$fetch['tid'];
		$query_thread_sub = $db->query ("SELECT * FROM ".TABLE_PREFIX."threads WHERE tid='$thread_id'");
		$fetch_thread_sub=$db->fetch_array($query_thread_sub);
		$thread_sub=htmlspecialchars_uni(substr($fetch_thread_sub['subject'],0,90));
		$linenumber=$post_counter+1;
		$otherposts .='<tr><td><span id="pagenumber">'.$linenumber.'</span>&nbsp;&nbsp;&nbsp;'.$read_image.'&nbsp;&nbsp;&nbsp;<a href="'.$threadlink.'" target="_blank" id="'.$post_pid.'" onmouseover="javascript:tooltip(event);" onmousemove="javascript:tooltipmove(event);"  onmouseout="javascript:tooltipout();">  '.$thread_sub.'</a></td><td><a href="'.$profilelink_lastposter.'" target="_blank" id="'.$lastposteruid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$lastposter.'</a></td></tr>';
	$post_counter++;
	}
	}
	$otherposts .='</table>';
	$other_cat_info .='<div id="other_cat_'.$i.'">'.$otherposts.'</div>';
	}
	
	}


	}
/************************************************ OTHER POSTS **********************************************/
/************************************************ Last user **********************************************/

	$query_user = $db->query ("SELECT * FROM ".TABLE_PREFIX."users ORDER BY uid DESC LIMIT 0,".(int)$mybb->settings['ajaxfs_number_tops']);
	
	for($i=0;$i<$db->num_rows($query_user);$i++)
	{
		$fetch_user =$db->fetch_array($query_user);
		$profile_user_link=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$fetch_user['uid'];
		$uid=$fetch_user['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$uid'");
		$fetch_users =$db->fetch_array($query_users);
		$username=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);

	$lastuser .='<font style="hieght:18.75px;align:right;text-align:center;float:right;vertical-align:top;"><a href="'.$profile_user_link.'" target="_blank"  id="'.$uid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$username.'</a></font><br/>';

	}
/************************************************ Last user **********************************************/
/************************************************ Top poster **********************************************/
	$query_top_poster = $db->query ("SELECT * FROM ".TABLE_PREFIX."users ORDER BY postnum DESC LIMIT 0,".(int)$mybb->settings['ajaxfs_number_tops']);
	
	for($i=0;$i<$db->num_rows($query_top_poster);$i++)
	{
		$fetch_top_poster =$db->fetch_array($query_top_poster);
		$profile_top_poster_link=get_profile_link($fetch_top_poster['uid']);
		$top_poster_post_link=$mybb->settings['bburl'].'/search.php?action=finduser&uid='.$fetch_top_poster['uid'];
		$uid=$fetch_top_poster['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$uid'");
		$fetch_users =$db->fetch_array($query_users);
		$username=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
	$top_poster .='<font style="hieght:18.75px;align:right;text-align:right;float:right;vertical-align:top;"><a href="'.$profile_top_poster_link.'" target="_blank"  id="'.$uid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$username.'</a></font><span style="hieght:20px;align:left;text-align:left;float:left;"><a href="'.$top_poster_post_link.'" target="_blank">'.$fetch_top_poster['postnum'].'</a></span><br>';
}
/************************************************ Top poster **********************************************/
/************************************************ Top ponit **********************************************/
	$query_top_reputation = $db->query ("SELECT * FROM ".TABLE_PREFIX."users ORDER BY reputation DESC LIMIT 0,".(int)$mybb->settings['ajaxfs_number_tops']);
	
	for($i=0;$i<$db->num_rows($query_top_reputation);$i++)
	{
		$fetch_top_reputation =$db->fetch_array($query_top_reputation);
		$profile_top_reputation_link=get_profile_link($fetch_top_reputation['uid']);
		$top_reputation_reputation_link=$mybb->settings['bburl'].'/reputation.php?uid='.$fetch_top_reputation['uid'];
		$uid=$fetch_top_reputation['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$uid'");
		$fetch_users =$db->fetch_array($query_users);
		$username=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
		$top_ponit .='<font style="hieght:18.75px;align:right;text-align:right;float:right;vertical-align:top;"><a href="'.$profile_top_reputation_link.'" target="_blank" id="'.$uid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$username.'</a></font><span style="hieght:20px;align:left;text-align:left;float:left;"><a href="'.$top_reputation_reputation_link.'" target="_blank">'.$fetch_top_reputation['reputation'].'</a></span><br>';
}
/************************************************ Top ponit **********************************************/
/************************************************ Top thanks **********************************************/
			if($mybb->settings['ajaxfs_mostthanked'] ==1)
	{
	$query_top_thank = $db->query ("SELECT * FROM ".TABLE_PREFIX."users ORDER BY thxcount DESC LIMIT 0,".(int)$mybb->settings['ajaxfs_number_tops']);
	
	for($i=0;$i<$db->num_rows($query_top_thank);$i++)
	{
		$fetch_top_thank =$db->fetch_array($query_top_thank);
		$profile_top_thank_link=get_profile_link($fetch_top_thank['uid']);
		$uid=$fetch_top_thank['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$uid'");
		$fetch_users =$db->fetch_array($query_users);
		$username=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
		$top_thanks .='<font style="hieght:18.75px;align:right;text-align:right;float:right;vertical-align:top;color: black;"><a href="'.$profile_top_thank_link.'" target="_blank" id="'.$uid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$username.'</a></font><span style="hieght:20px;align:left;text-align:left;float:left;">'.$fetch_top_thank['thxcount'].'</span><br>';

	}
	}
/************************************************ Top Do Thamk **********************************************/

	if($mybb->settings['ajaxfs_mostthanker'] ==1)
	{
	$query_top_thank = $db->query ("SELECT * FROM ".TABLE_PREFIX."users ORDER BY thx DESC LIMIT 0,".(int)$mybb->settings['ajaxfs_number_tops']);
	
	for($i=0;$i<$db->num_rows($query_top_thank);$i++)
	{
		$fetch_top_thank =$db->fetch_array($query_top_thank);
		$profile_top_thank_link=get_profile_link($fetch_top_thank['uid']);
		$uid=$fetch_top_thank['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$uid'");
		$fetch_users =$db->fetch_array($query_users);
		$username=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
		$top_thank_do .='<font style="hieght:18.75px;align:right;text-align:right;float:right;vertical-align:top;color: black;"><a href="'.$profile_top_thank_link.'" target="_blank" id="'.$uid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$username.'</a></font><span style="hieght:20px;align:left;text-align:left;float:left;">'.$fetch_top_thank['thx'].'</span><br>';

	}
	}
/************************************************ Top Do Thamk **********************************************/
/************************************************ Top File **********************************************/
	function SubjectLength($subject, $length="", $half=false)
	{
	global $mybb;
	$length = $length ? intval($length) : intval('25');
	$half ? $length = ceil($length/2) : NULL;
	if ($length != 0)
	{
		if (my_strlen($subject) > $length) 
		{
			$subject = my_substr($subject,0,$length) . '...';
		}
	}
	return $subject;
	}
		

	$query_top_file = $db->query ("SELECT * FROM ".TABLE_PREFIX."attachments ORDER BY downloads DESC LIMIT 0,".(int)$mybb->settings['ajaxfs_number_tops']);
	
	for($i=0;$i<$db->num_rows($query_top_file);$i++)
	{
		$fetch_top_file =$db->fetch_array($query_top_file);
		$pid=$fetch_top_file['pid'];
		$query_post = $db->query("SELECT * FROM ".TABLE_PREFIX."posts WHERE pid='$pid'");
		$query_post_fetch=$db->fetch_array($query_post);

		$subject = htmlspecialchars_uni(SubjectLength($parser->parse_badwords($query_post_fetch['subject']), NULL, true));
	$postlink = get_post_link($pid)."#pid".$pid;
	$top_file .='<font style="hieght:18.75px;align:right;text-align:right;float:right;vertical-align:top;color: black;"><a href="'.$postlink.'" target="_blank">'.$subject.'</a></font><span style="hieght:20px;align:left;text-align:left;float:left;">'.$fetch_top_file['downloads'].'</span><br>';

	}
/************************************************ Top File **********************************************/		
/************************************************ Top Reffer **********************************************/		
	$query = $db->query("
	SELECT u.uid,u.username,u.usergroup,u.displaygroup,count(*) as refcount 
	FROM ".TABLE_PREFIX."users u 
	LEFT JOIN ".TABLE_PREFIX."users r ON (r.referrer = u.uid) 
	WHERE r.referrer = u.uid 
	GROUP BY r.referrer DESC 
	ORDER BY refcount DESC 
	LIMIT 0 ,15");	
	for($i=0;$i<$db->num_rows($query );$i++)
	{
	$topreferrer=$db->fetch_array($query );
		$uid = $topreferrer['uid'];
		$refnum = $topreferrer['refcount'];
		$profilelink = get_profile_link($uid);
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$uid'");
		$fetch_users =$db->fetch_array($query_users);
		$username=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
		$top_reffer .='<font style="hieght:18.75px;align:right;text-align:right;float:right;vertical-align:top;color: black;"><a href="'.$profilelink.'" target="_blank" id="'.$uid.'"  onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$username.'</a></font><span style="hieght:20px;align:left;text-align:left;float:left;">'.$refnum.'</span><br>';

	}
/************************************************ Top Reffer **********************************************/		
/*************************************************** HIT STAT *********************************************/
$expire = 600;
$filename = "counter.txt";

if (file_exists($filename)) 
{
   $ignore = false;
   $current_agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? addslashes(trim($_SERVER['HTTP_USER_AGENT'])) : "no agent";
   $current_time = time();
   $current_ip = $_SERVER['REMOTE_ADDR']; 
      
   // daten einlesen
   $c_file = array();
   $handle = fopen($filename, "r");
   
   if ($handle)
   {
      while (!feof($handle)) 
      {
         $line = trim(fgets($handle, 4096)); 
		 if ($line != "")
		    $c_file[] = $line;		  
      }
      fclose ($handle);
   }
   else
      $ignore = true;
   
   // bots ignorieren   
   if (substr_count($current_agent, "bot") > 0)
      $ignore = true;
	  
   
   // hat diese ip einen eintrag in den letzten expire sec gehabt, dann igornieren?
   for ($i = 1; $i < sizeof($c_file); $i++)
   {
      list($counter_ip, $counter_time) = explode("||", $c_file[$i]);
	  $counter_time = trim($counter_time);
	  
	  if ($counter_ip == $current_ip && $current_time-$expire < $counter_time)
	  {
	     // besucher wurde bereits gezählt, daher hier abbruch
		 $ignore = true;
		 break;
	  }
   }
   
   // counter hochzählen
   if ($ignore == false)
   {
      if (sizeof($c_file) == 0)
      {
	     // wenn counter leer, dann füllen      
		 $add_line1 = date("z") . ":1||" . date("W") . ":1||" . date("n") . ":1||" . date("Y") . ":1||1||1||" . $current_time . "\n";
		 $add_line2 = $current_ip . "||" . $current_time . "\n";
		 
		 // daten schreiben
		 $fp = fopen($filename,"w+");
		 if ($fp)
         {
		    flock($fp, LOCK_EX);
			fwrite($fp, $add_line1);
		    fwrite($fp, $add_line2);
			flock($fp, LOCK_UN);
		    fclose($fp);
		 }
		 
		 // werte zur verfügung stellen
		 $day = $week = $month = $year = $all = $record = 1;
		 $record_time = $current_time;
		 $online = 1;
	  }
      else
	  {
	     // counter hochzählen
		 list($day_arr, $week_arr, $month_arr, $year_arr, $all, $record, $record_time) = explode("||", $c_file[0]);
		 
		 // day
		 $day_data = explode(":", $day_arr);
		 $day = $day_data[1];
		 if ($day_data[0] == date("z")) $day++; else $day = 1;
		 
		 // week
		 $week_data = explode(":", $week_arr);
		 $week = $week_data[1];
		 if ($week_data[0] == date("W")) $week++; else $week = 1;
		 
		 // month
		 $month_data = explode(":", $month_arr);
		 $month = $month_data[1];
		 if ($month_data[0] == date("n")) $month++; else $month = 1;
		 
		 // year
		 $year_data = explode(":", $year_arr);
		 $year = $year_data[1];
		 if ($year_data[0] == date("Y")) $year++; else $year = 1;
		  
		 // all
		 $all++;
		 
		 // neuer record?
		 $record_time = trim($record_time);
		 if ($day > $record)
		 {
		    $record = $day;
			$record_time = $current_time;
		 }
		 
		 // speichern und aufräumen und anzahl der online leute bestimmten
		 
		 $online = 1;
		 
		 // daten schreiben
		 $fp = fopen($filename,"w+");
		 if ($fp)
         {
		    flock($fp, LOCK_EX);
			$add_line1 = date("z") . ":" . $day . "||" . date("W") . ":" . $week . "||" . date("n") . ":" . $month . "||" . date("Y") . ":" . $year . "||" . $all . "||" . $record . "||" . $record_time . "\n";		 
		    fwrite($fp, $add_line1);
		 
		    for ($i = 1; $i < sizeof($c_file); $i++)
            {
               list($counter_ip, $counter_time) = explode("||", $c_file[$i]);
	  
	           // übernehmen
		   	   if ($current_time-$expire < $counter_time)
	           {
	              $counter_time = trim($counter_time);
				  $add_line = $counter_ip . "||" . $counter_time . "\n";
			      fwrite($fp, $add_line);
			      $online++;
	           }
            }
		    $add_line = $current_ip . "||" . $current_time . "\n";
		    fwrite($fp, $add_line);
		    flock($fp, LOCK_UN);
		    fclose($fp);
	     }
	  }
   }
   else
   {
      // nur zum anzeigen lesen
	  if (sizeof($c_file) > 0)
	     list($day_arr, $week_arr, $month_arr, $year_arr, $all, $record, $record_time) = explode("||", $c_file[0]);
	  else
		 list($day_arr, $week_arr, $month_arr, $year_arr, $all, $record, $record_time) = explode("||", date("z") . ":1||" . date("W") . ":1||" . date("n") . ":1||" . date("Y") . ":1||1||1||" . $current_time);
	  
	  // day
	  $day_data = explode(":", $day_arr);
      $day = $day_data[1];
	  
	  // week
	  $week_data = explode(":", $week_arr);
	  $week = $week_data[1];
	
	  // month
	  $month_data = explode(":", $month_arr);
	  $month = $month_data[1];
	  
	  // year
	  $year_data = explode(":", $year_arr);
	  $year = $year_data[1];
	  
	  $record_time = trim($record_time);
	  
	  $online = sizeof($c_file) - 1;
   }
   
}	
/*************************************************** HIT STAT *********************************************/	
	$Hit_stat='
<font style="align:center;text-align:center;float:right;vertical-align:top;">'.$lang->ajaxfs_user_online.$online.'</font><br/>
<font style="align:center;text-align:center;float:right;vertical-align:top;">'.$lang->ajaxfs_user_today.$day.'</font><br/>
<font style="align:center;text-align:center;float:right;vertical-align:top;">'.$lang->ajaxfs_user_week.$week.'</font><br/>
<font style="align:center;text-align:center;float:right;vertical-align:top;">'.$lang->ajaxfs_user_month.$month.'</font><br/>
<font style="align:center;text-align:center;float:right;vertical-align:top;">'.$lang->ajaxfs_user_year.$year.'</font><br/>
<font style="align:center;text-align:center;float:right;vertical-align:top;">'.$lang->ajaxfs_user_all.$all.'</font><br/>';
	if($mybb->settings['ajaxfs_hitstat'] ==1)
	{
	$user_info_option .='<h3>'.$lang->ajaxfs_hit_stat.'</h3><div id="info_stat">'.$Hit_stat.'</div>';
	}
	if($mybb->settings['ajaxfs_lastuser'] ==1)
	{
	$user_info_option .='<h3>'.$lang->ajaxfs_last_user.'</h3><div id="info_lastuser">'.$lastuser.'</div>';
	}
	if($mybb->settings['ajaxfs_mostposter'] ==1)
	{
	$user_info_option .='<h3>'.$lang->ajaxfs_most_sender.'</h3><div id="info_top_poster">'.$top_poster.'</div>';
	}
	if($mybb->settings['ajaxfs_mostpoint'] ==1)
	{
	$user_info_option .='<h3>'.$lang->ajaxfs_top_point.'</h3><div id="info_top_ponit">'.$top_ponit.'</div>';
	}
	if($mybb->settings['ajaxfs_mostthanked'] ==1)
	{
	$user_info_option .='<h3>'.$lang->ajaxfs_top_thanks.'</h3><div id="info_top_thanks">'.$top_thanks.'</div>';
	}
	if($mybb->settings['ajaxfs_mostthanker'] ==1)
	{
	$user_info_option .='<h3>'.$lang->ajaxfs_top_thankers.'</h3><div id="info_top_thank_do">'.$top_thank_do.'</div>';
	}
	if($mybb->settings['ajaxfs_popularfile'] ==1)
	{
	$user_info_option .='<h3>'.$lang->ajaxfs_most_download.'</h3><div id="info_top_file">'.$top_file.'</div>';
	}
	if($mybb->settings['ajaxfs_Topreferrers'] ==1)
	{
	$user_info_option .='<h3>'.$lang->ajaxfs_most_reffer.'</h3><div id="info_top_reffer">'.$top_reffer.'</div>';
	}	
	
	if($mybb->settings['ajaxfs_position'] =='top')
	{
		$ajaxfs_down_panel='';
	$ajaxfs_top_panel = '<head>
<link rel="stylesheet" href="'.$mybb->asset_url.'/jscripts/jquery-ui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="'.$mybb->asset_url.'/jscripts/ajaxfs.css" type="text/css" media="screen" />
<script type="text/javascript" src="'.$mybb->asset_url.'/jscripts/jquery-ui.js"></script>
<script type="text/javascript" src="'.$mybb->asset_url.'/jscripts/ajaxfs.js"></script>
<script type="text/javascript" src="'.$mybb->asset_url.'/jscripts/spin.min.js"></script></head>
<div id="spin" style="position:relative;"></div><br\><table border="0"  cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" height="300px">
<tr>
<td class="thead" colspan="2" align="right"><strong>'.$lang->ajaxfs_panel.'</strong></td>
</tr>
<tr>
<td class="tcat" colspan="2" align="right">
<img src="images/ajfs_ref.png" id="ajfs_ref_posts" alt="'.$lang->ajaxfs_lastpost_tltp.'" onmouseover="ajfs_ref_post_tooltip(event)" onmouseout="ajfs_ref_post_tooltip_out(event)" onmousemove="ajfs_ref_post_tooltip_move(event)" /><img src="images/ajfs_ref_top.png" id="ajfs_ref_top" alt="'.$lang->ajaxfs_top_tltp.'" onmouseover="ajfs_ref_top_tooltip(event)" onmouseout="ajfs_ref_top_tooltip_out(event)" onmousemove="ajfs_ref_top_tooltip_move(event)" />
</td>
</tr>
	<tr>
		<td width="25%"   class="trow2" style="padding: 5px 0px 0px 5px;vertical-align:top;">
			<div id="userrules">
			'.$user_info_option.'
			</div>
			</td>
		<td  width="75%" class="trow2" style="padding: 5px 5px 0px;vertical-align:top;">
			<div id="tabs" direction="rtl">
				<ul>
                '.$post_info_option.'
				</ul>
				<div id="lastpost">'.$lastpost.'</div>
				<div id="mosthit">'.$most_hit.'</div>
				<div id="hotpost">'.$hotpost.'</div>
				'.$other_cat_info.'
				</div></td>
			
	</tr>
</table><div style="text-align: left; font-size: 10px;"> Ajax Forum Stat by <a href="http://www.pctricks.ir" target="blank">Mostafa</a></div><br><br>';

	}	
	if($mybb->settings['ajaxfs_position'] =='down')
	{
	$ajaxfs_top_panel='';
	$ajaxfs_down_panel = '<head>
<link rel="stylesheet" href="'.$mybb->asset_url.'/jscripts/jquery-ui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="'.$mybb->asset_url.'/jscripts/ajaxfs.css" type="text/css" media="screen" />
<script type="text/javascript" src="'.$mybb->asset_url.'/jscripts/jquery-ui.js"></script>
<script type="text/javascript" src="'.$mybb->asset_url.'/jscripts/ajaxfs.js"></script>
<script type="text/javascript" src="'.$mybb->asset_url.'/jscripts/spin.min.js"></script></head>
<div id="spin" style="position:relative;"></div><br\><table border="0"  cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" height="300px">
<tr>
<td class="thead" colspan="2" align="right"><strong>'.$lang->ajaxfs_panel.'</strong></td>
</tr>
<tr>
<td class="tcat" colspan="2" align="right">
<img src="images/ajfs_ref.png" id="ajfs_ref_posts" alt="'.$lang->ajaxfs_lastpost_tltp.'" onmouseover="ajfs_ref_post_tooltip(event)" onmouseout="ajfs_ref_post_tooltip_out(event)" onmousemove="ajfs_ref_post_tooltip_move(event)" /><img src="images/ajfs_ref_top.png" id="ajfs_ref_top" alt="'.$lang->ajaxfs_top_tltp.'" onmouseover="ajfs_ref_top_tooltip(event)" onmouseout="ajfs_ref_top_tooltip_out(event)" onmousemove="ajfs_ref_top_tooltip_move(event)" />
</td>
</tr>
	<tr>
		<td width="25%"   class="trow2" style="padding: 5px 0px 0px 5px;vertical-align:top;">
			<div id="userrules">
			'.$user_info_option.'
			</div>
			</td>
		<td  width="75%" class="trow2" style="padding: 5px 5px 0px;vertical-align:top;">
			<div id="tabs" direction="rtl">
				<ul>
                '.$post_info_option.'
				</ul>
				<div id="lastpost">'.$lastpost.'</div>
				<div id="mosthit">'.$most_hit.'</div>
				<div id="hotpost">'.$hotpost.'</div>
				'.$other_cat_info.'
				</div></td>
			
	</tr>
</table><div style="text-align: left; font-size: 10px;"> Ajax Forum Stat by <a href="http://www.pctricks.ir" target="blank">Mostafa</a></div><br><br>';

	}
	

}
}
	function Ajax_fs_do_action()
	{
global $mybb, $db,$lang,$parser;
	if (!is_object($parser))
	{
		require_once MYBB_ROOT.'inc/class_parser.php';
		$parser = new postParser;
	}
	$lang->load("ajaxfs");
	if(($mybb->input['action'] != "tooltip" AND $mybb->input['action'] != "usertooltip" AND $mybb->input['action'] != "ajxfs_lastpost" AND $mybb->input['action'] != "ajxfs_Tops_lastuser" ) || $mybb->request_method != "post")
	{
		return false;
	}
 /********************************************** POST Tool TIP ***********************************************/
	if($mybb->input['action']=="tooltip")
	{
	$pid=$db->escape_string($mybb->input['pid']);
	$query_post = $db->query ("SELECT * FROM ".TABLE_PREFIX."posts WHERE pid='$pid'");
	$query_post_fetch=$db->fetch_array($query_post);
	$tid=$query_post_fetch['tid'];
	$query_thread = $db->query ("SELECT * FROM ".TABLE_PREFIX."threads WHERE tid='$tid'");
	$query_thread_fetch=$db->fetch_array($query_thread);
	$starter = $query_thread_fetch['username'];
	$views = intval($query_thread_fetch['views']);
	$replies = intval($query_thread_fetch['replies']);
	$attachment = intval($query_thread_fetch['attachmentcount']);
	$threadrating = intval($query_thread_fetch['numratings']);
	$threadsubject = htmlspecialchars_uni($query_thread_fetch['subject']);
	$startdate = my_date($mybb->settings['dateformat'],$query_thread_fetch['dateline']);
	$starttime = my_date($mybb->settings['timeformat'], $query_thread_fetch['dateline']);
	$fid=$query_thread_fetch['fid'];
	$query_forum = $db->query ("SELECT * FROM ".TABLE_PREFIX."forums WHERE fid='$fid'");
	$query_forum_fetch=$db->fetch_array($query_forum);
	$forumname=$query_forum_fetch['name'];
	$lastdate = my_date($mybb->settings['dateformat'],$query_post_fetch['dateline']);
	$lasttime = my_date($mybb->settings['timeformat'],$query_post_fetch['dateline']);
	$lastposter = $query_post_fetch['username'];
	$poll = intval($query_thread_fetch['poll']);
	if($attachment!=0)
	{
	$attachment_info=$lang->ajaxfs_attachment_true;
	}
	else
	{
	$attachment_info=$lang->ajaxfs_attachment_false;
	}
	if($poll!=0)
	{
	$poll_info=$lang->ajaxfs_poll_true;
	}
	else
	{
	$poll_info=$lang->ajaxfs_poll_false;
	}
	$tooltip='
	<p style="align:right;">'.$lang->ajaxfs_thread_subject .' : '.$threadsubject.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_forum_name .' : '.$forumname.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_start_thread .' : '.$starter.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_time_start .' : '.$startdate.','.$starttime.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_last_post .' : '.$lastposter.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_time_last .' : '.$lastdate.','.$lasttime.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_views .' : '.$views.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_replies .' : '.$replies.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_attachment .' : '.$attachment_info.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_rating .' : '.$threadrating.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_poll .' : '.$poll_info.'</p><br\>
	';
	echo $tooltip;
	exit();
	}
/********************************************** POST Tool TIP ***********************************************/
/********************************************** USER Tool TIP ***********************************************/
	if($mybb->input['action']=="usertooltip")
	{
	$uid=$db->escape_string($mybb->input['uid']);
	$query_user = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$uid'");
	$query_user_fetch=$db->fetch_array($query_user);
	$registertime_data = my_date($mybb->settings['dateformat'],$query_user_fetch['regdate']);
	$lastactive_data = my_date($mybb->settings['dateformat'],$query_user_fetch['lastactive']);
	$lastvisit_data = my_date($mybb->settings['dateformat'],$query_user_fetch['lastvisit']);
	$lastpost_data = my_date($mybb->settings['dateformat'],$query_user_fetch['lastpost']);
	$registertime_time = my_date($mybb->settings['timeformat'],$query_user_fetch['regdate']);
	$lastactive_time = my_date($mybb->settings['timeformat'],$query_user_fetch['lastactive']);
	$lastvisit_time = my_date($mybb->settings['timeformat'],$query_user_fetch['lastvisit']);
	$lastpost_time = my_date($mybb->settings['timeformat'],$query_user_fetch['lastpost']);
	$postnum=$query_user_fetch['postnum'];
	$reputation=$query_user_fetch['reputation'];
	$usertooltip='
	<p style="align:right;">'.$lang->ajaxfs_register_time .' : '.$registertime_data.','.$registertime_time.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_user_lastactive .' : '.$lastactive_data.','.$lastactive_time.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_user_lastvisit .' : '.$lastvisit_data.','.$lastvisit_time.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_user_lastpost .' : '.$lastpost_data.','.$lastpost_time.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_user_postnum .' : '.$postnum.'</p><br\>
	<p style="align:right;">'.$lang->ajaxfs_user_reputation .' : '.$reputation.'</p><br\>
	';
	echo $usertooltip;
	
	}
/********************************************** USER Tool TIP ***********************************************/
/********************************************** Refresh in forum ***********************************************/

	/*********************************************** LAST POST *************************************************/
	if($mybb->input['action']=="ajxfs_lastpost")
{
$userid=$mybb->user['uid'];
$query_group=$db->query ("SELECT * FROM  ".TABLE_PREFIX."users WHERE uid='$userid'");
if($db->num_rows($query_group)==0)
{
$gid=1;
}
else
{
$fetch_group=$db->fetch_array($query_group);
$gid=$fetch_group['usergroup'];
}

	$query = $db->query ("SELECT t1.*
FROM ".TABLE_PREFIX."posts t1
JOIN (
SELECT pid
FROM ".TABLE_PREFIX."posts
WHERE visible='1' ORDER BY pid DESC
)t2 ON t1.pid = t2.pid GROUP BY tid ORDER BY pid DESC");
$lastpost="<table cellspacing='0' id='Ajxfstable'><tr><th>{$lang->ajaxfs_lastpost_title}</th><th>{$lang->ajaxfs_lastpost_writer}</th></tr>";
if($db->num_rows($query)==0)
{
$post_number=0;
}
else
{
if($db->num_rows($query)<=$mybb->settings['ajaxfs_number_post'])
{
$post_number=$db->num_rows($query);
}
else
{
$post_number=$mybb->settings['ajaxfs_number_post'];
}

}
$post_counter=0;
	while($post_counter<$post_number)
	{
		$fetch=$db->fetch_array($query);
		$fid=$fetch['fid'];
		$query_forum_permissins=$db->query ("SELECT * FROM  ".TABLE_PREFIX."forumpermissions WHERE fid='$fid' AND gid='$gid'");
		$canread=1;
		if($db->num_rows($query_forum_permissins)!=0)
		{
		$fetch_forum_permissins=$db->fetch_array($query_forum_permissins);
		if($fetch_forum_permissins['canviewthreads']==1)
		{
		$canread=1;
		}
		else
		{
		$canread=0;
		}
		}
		if($db->num_rows($query_forum_permissins)==0 AND $canread==1)
		{
		$profilelink=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$fetch['uid'];
		$lastposter=$fetch['username'];
		$lastposteruid=$fetch['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$lastposteruid'");
		$fetch_users =$db->fetch_array($query_users);
		$lastposter=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);
		$profilelink_lastposter=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$lastposteruid;
		$tid=$fetch['tid'];
		$uid=$mybb->user['uid'];
		$query_view = $db->query("SELECT * FROM ".TABLE_PREFIX."threadsread WHERE tid='$tid' AND uid='$uid'");
		$threadlink = get_post_link($fetch['pid'])."#pid".$fetch['pid'];
		$post_pid=$fetch['pid'];
		if($db->num_rows($query_view)==0)
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_unread.gif">';
		}
		else
		{
		$read_image='<img src="'.$mybb->settings['bburl'].'/images/fs_read.gif">';
		}
		$thread_id=$fetch['tid'];
		$query_thread_sub = $db->query ("SELECT * FROM ".TABLE_PREFIX."threads WHERE tid='$thread_id'");
		$fetch_thread_sub=$db->fetch_array($query_thread_sub);
		$thread_sub=htmlspecialchars_uni(substr($fetch_thread_sub['subject'],0,90));
		$linenumber=$post_counter+1;
		$lastpost .='<tr><td><span id="pagenumber">'.$linenumber.'</span>&nbsp;&nbsp;&nbsp;'.$read_image.'&nbsp;&nbsp;&nbsp;<a href="'.$threadlink.'" target="_blank" id="'.$post_pid.'" onmouseover="javascript:tooltip(event);" onmousemove="javascript:tooltipmove(event);"  onmouseout="javascript:tooltipout();">  '.$thread_sub.'</a></td><td><a href="'.$profilelink_lastposter.'" target="_blank" id="'.$lastposteruid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$lastposter.'</a></td></tr>';
	$post_counter++;
	}
	}
	$lastpost .='</table>';
/*********************************************** LAST POST *************************************************/

	
	$feedback=$lastpost;
	echo $feedback;
	exit();
	
	}
/********************************************** Refresh in forum ***********************************************/

	if($mybb->input['action']=="ajxfs_Tops_lastuser")
	{
		$query_user = $db->query ("SELECT * FROM ".TABLE_PREFIX."users ORDER BY uid DESC LIMIT 0,".(int)$mybb->settings['ajaxfs_number_tops']);
	
	for($i=0;$i<$db->num_rows($query_user);$i++)
	{
		$fetch_user =$db->fetch_array($query_user);
		$profile_user_link=$mybb->settings['bburl'].'/member.php?action=profile&uid='.$fetch_user['uid'];
		$uid=$fetch_user['uid'];
		$query_users = $db->query ("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='$uid'");
		$fetch_users =$db->fetch_array($query_users);
		$username=format_name($fetch_users['username'],$fetch_users['usergroup'],$fetch_users['displaygroup']);

	$lastuser .='<font style="hieght:18.75px;align:right;text-align:center;float:right;vertical-align:top;"><a href="'.$profile_user_link.'" target="_blank"  id="'.$uid.'" onmouseover="javascript:usertooltip(event);" onmousemove="javascript:usertooltipmove(event);"  onmouseout="javascript:usertooltipout();">'.$username.'</a></font><br/>';

	}
		$feedback=$lastuser;
	echo $feedback;
	exit();
	
	}

	}
	function ajaxfs_deactivate()
	{

	global $mybb, $db, $templates;
	require_once MYBB_ROOT.'inc/adminfunctions_templates.php';




	find_replace_templatesets("index", '#'.preg_quote('{$ajaxfs_top_panel}').'#i', '',0);
	find_replace_templatesets("index", '#'.preg_quote('{$ajaxfs_down_panel}').'#i', '',0);
	$db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE name='ajaxfs'");
	$db->delete_query("settings","name IN ('ajaxfs_enable','ajaxfs_lastpost','ajaxfs_mostview','ajaxfs_hottopics','ajaxfs_lastuser','ajaxfs_mostposter','ajaxfs_mostpoint','ajaxfs_mostthanked','ajaxfs_mostthanker','ajaxfs_popularfile','ajaxfs_Topreferrers','ajaxfs_customforum','ajaxfs_customforum_in','ajaxfs_hitstat','ajaxfs_number_post','ajaxfs_number_tops','ajaxfs_position')");
rebuild_settings();

	}


?>