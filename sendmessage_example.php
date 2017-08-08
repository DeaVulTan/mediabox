<?php
// activate full error reporting
//error_reporting(E_ALL & E_STRICT);
include './common/classes/XMPPHP/XMPP.php';
include './common/classes/XMPPHP/Log.php';

#Use XMPPHP_Log::LEVEL_VERBOSE to get more logging for error reports
#If this doesn't work, are you running 64-bit PHP with < 5.2.6?
$conn = new XMPPHP_XMPP('aiche044', 5222, 'selvaraj@aiche044', 'tester', 'xmpphp', 'aiche044', $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);
//$conn = new XMPPHP_XMPP('talk.google.com', 5222, 'viji.selva.300807@gmail.com', 'pudukkottai', 'xmpphp', 'gmail.com', $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);
//$conn = new XMPPHP_XMPP('messenger.hotmail.com', 1863, 'viji.selva.300807@hotmail.com', 'pudukkottai', 'xmpphp', 'hotmail.com', $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);
//$conn = new XMPPHP_XMPP('chat.live.yahoo.com', 5222, 'mail2vijiselva@yahoo.com', 'pudukkottai', 'xmpphp', 'yahoo.com', $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);
try {
	$conn->stop_connection = false;
    $conn->connect(30, true);
	$conn->processUntil('session_start');
    $conn->presence();
    $conn->message('test@aiche044', 'This is selvaraj!'.date("H:i:s"));
	//$conn->message('smselvaindia@hotmail.com', 'This is a test message!');
   	//$conn->disconnect();
	echo 'sent';
} catch(XMPPHP_Exception $e) {
    die($e->getMessage());
}
