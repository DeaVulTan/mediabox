<?php

$sendersemail = $_POST['sendersemail'];    
include_once ('includes/config.php');

//----------------------------------------------------------------------------------------------------------------------------------



$list = array();
$list = $_POST['list'];
foreach($list as $name_email) {
	
list($to,$name) = @split('x22z',$name_email);

if (ereg('@',$name)){
	$name = "";
}



//------------------------------------------------------------------------------------------------------------------------


if ($html_format == "yes"){

$headers = "From: $from\n";
$headers .= "Reply-To: $from\n";
$headers .= "Return-Path: $from\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";

mail($to,$subject,$message,$headers);

}else{
	
mail($to, $subject, $message, "From: $from");
}
}

//  [end of email sending]

header("Location: "."$redirect");

?>
