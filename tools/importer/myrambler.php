<?php

//CSV VERSION

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        REDIFFMAIL.COM CONTACT IMPORTING SCRIPT                      //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                               d      //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

//******************************* | SETTING VARIABLES | ***********************************\\

$service = 'rambler';
include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
include ('includes/service.php');



//--------------------------------------------end of service------------------------------------------------\\
$arraycount= count($matches);
$checkarray = $matches[1][1];

if (empty($checkarray)) {

    $show = 1;
    $error_message = "No contacts found - check your login details and try again";

}
else {

//*********************** | START OF HTML | ***********************************\\

		$i = 0;
		while (isset($matches[$i])):
		
        //  [RESULTS - START OF CONTACTS LIST]
        $email = $matches[$i][2];
        $dataname = $matches[$i][1];

					//remove bad characters thatmay be caught up in output
					$email = stripslashes(preg_replace("/&quot;/","",$email));
					$dataname = stripslashes(preg_replace("/&quot;/","",$dataname));
					
        $result = array('contacts_email' => $email,'contacts_name' => $dataname);
        $display_array[] = $result;

        $i++;
    endwhile;
    $poweredby_bottom = $footer;//powered by
    $show_result = 1;//show results table
@unlink($mycookie);
}
$table = 1;//show table in main template (email or cvs upload)
$service = 'myrambler';
@unlink($mycookie);
include_once ('index.php');
?>