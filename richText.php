<?php
require_once('./common/configs/config.inc.php');
require_once('./common/functions.php');
session_start();
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: 0"); // Date in the past
header("Content-type: text/html; charset=iso-8859-1");
$useHtmSpChars = $_REQUEST['htmSpChar'];
$source = $_SESSION[$_REQUEST['source']];
$source = urldecode($source);
if ($useHtmSpChars)
    {
    	echo $source;
    }
else
	{
		echo htmlentitydecode($source);
	}
?>