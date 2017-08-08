<?php
session_start();ob_start();
$id = 0;
if (!isset($_SESSION['user']['is_logged_in']))
    {
        die('error');
    }
require_once('./common/configs/config.inc.php');
$dbcon = mysql_connect($CFG['db']['hostname'], $CFG['db']['username'], $CFG['db']['password']) or die('error');
mysql_select_db($CFG['db']['name'], $dbcon) or die('error');
if (isset($_POST['u']))
    {
		if (isset($_POST['login']))
		    {
		     	$sql = 'UPDATE '.$CFG['db']['tbl']['users'].' SET logged_in=\'1\', last_active=NOW() WHERE user_id='.$_POST['u'];
				mysql_query($sql, $dbcon) or die('error');
		    }
		else if (isset($_POST['logout']) )
			    {
			     	$sql = 'UPDATE '.$CFG['db']['tbl']['users'].' SET logged_in=\'0\' WHERE user_id='.$_POST['u'];
					mysql_query($sql, $dbcon) or die('error');
		    	}
		else if (isset($_POST['status']) and trim($_POST['status']))
		         {
			 		$status = $_POST['status'];
				    $status=strip_tags($status);
//					$status = str_replace('<', '', $status);
//					$status = str_replace('>', '', $status);
			     	$sql = 'UPDATE '.$CFG['db']['tbl']['users'].' SET logged_in=\'1\', last_active=NOW(),status_msg_id ='.$status.',privacy=\'Custom\' WHERE user_id='.$_POST['u'];
					mysql_query($sql, $dbcon) or die('error');
		         }
		else if (isset($_POST['astatus']) and trim($_POST['astatus']))
		         {
		             $status = $_POST['astatus'];
					 $status = str_replace('\'', '`', $status);
					 $status = str_replace('"', '``', $status);
					 $status=strip_tags($status);
//					 $status = str_replace('<', '', $status);
//					 $status = str_replace('>', '', $status);

					$sql = 'INSERT INTO '.$CFG['db']['tbl']['users_status_messages'].' SET user_id=\''.$_POST['u'].'\', date_added=NOW(),message =\''.addslashes($status).'\'';

					mysql_query($sql, $dbcon) or die('error');
					$id = mysql_insert_id($dbcon);
					if ($id > 0)
					    {
					     	$sql = 'UPDATE '.$CFG['db']['tbl']['users'].' SET logged_in=\'1\', last_active=NOW(),status_msg_id ='.$id.',privacy=\'Custom\' WHERE user_id='.$_POST['u'];
							mysql_query($sql, $dbcon) or die('error');
					    }
		         }
	}
ob_end_clean();
header('Content-Type:text/xml');
header("Pragma: no-cache");
$str = '<?xml version="1.0"?>'. "\n";
echo $str;
?>
<rayzz><times><?php echo date('h:i:s');?></times>
<?php
if ($id > 0)
    {
?><id><?php echo $id;?></id>
<?php
    }
?>
</rayzz>