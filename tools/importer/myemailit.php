<?php

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        email.it CONTACT IMPORTING SCRIPT                            //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////
$service = 'emailit';
include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
include ('includes/service.php');


//--------------------------------------------end of service------------------------------------------------\\

// CHECKING IF ANY CONTACTS EXIST 

$checkarray = $matches[2][0];
if (empty($checkarray)) {

    $show = 1;
    $error_message = "No contacts found - check your login details and try again";
}
else {

    //*********************** | START OF HTML | ***********************************\\

    $i = 0;
    while (isset($matches[2][$i])):

        //  [RESULTS - START OF CONTACTS LIST]
        $email = $matches[2][$i];
        $dataname = $matches[1][$i];

					//remove none characters
					$email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
					$dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);

        $result = array('contacts_email' => $email1,'contacts_name' => $dataname1);
        $display_array[] = $result;

        $i++;
    endwhile;
    $poweredby_bottom = $footer;//powered by
    $show_result = 1;//show results table
@unlink($mycookie);
}
$table = 1;//show table in main template (email or cvs upload)
$service = 'myemailit';
@unlink($username);//deleting csv file
@unlink($mycookie);
include_once ('index.php');
?>














