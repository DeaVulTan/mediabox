<?php
header('Content-type:text/css');
require_once('./common/configs/config.inc.php');
if (isset($_GET) AND isset($_GET['user_id']) AND is_numeric($_GET['user_id']) AND ($user_id= $_GET['user_id']))
    {
		$dbcon = mysql_connect($CFG['db']['hostname'], $CFG['db']['username'], $CFG['db']['password']) or die('error');
		mysql_select_db($CFG['db']['name'], $dbcon) or die('error');
		$sql = 'SELECT style_tags FROM '.$CFG['db']['tbl']['users_profile_theme'].'  WHERE user_id='.$user_id;
        $res = mysql_query($sql);
		if ($res and mysql_num_rows($res) > 0)
		    {
		        $row = mysql_fetch_array($res, MYSQL_ASSOC);
				$style = $row['style_tags'];
				print urldecode($style);
		    }
	}
?>