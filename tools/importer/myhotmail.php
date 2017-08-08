<?php

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        HOTMAIL CONTACT IMPORTING SCRIPT                             //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

//******************************* | SETTING VARIABLES | ***********************************\\

$service = 'hotmail';
include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
include ('includes/service.php');


//CHECKING IF LOGIN WAS SUCCESSFUL
//////////////////////////////////

$result=@html_entity_decode($result);
$result = str_replace('%40', '@', $result);

//@preg_match_all('/to=([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-z]{2,3}))&/', $result, $matches);

@preg_match_all('/to=(.*?)&/', $result, $matches);

$loop = count($matches[1]);


//pull out a test email
$test_email = @html_entity_decode($matches[1][0]);

//check if test email was found
if ($loop < 0 || !eregi("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-z]{2,3})$", $test_email)) {

    $show = 1;
    $error_message = "No contacts found - check your login details and try again";

}
else {


//Start Building Final Array
////////////////////////////

    $display_array = array();
    $email_only_array = array();//to remove duplicates
    
    for ($count = 0; $count <= $loop; $count++) {
        $email = trim($matches[1][$count]);    
        
		//validate email and check for duplicates
		if (eregi("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-z]{2,3})$",$email) && !in_array($email, $email_only_array)) {

            list($dataname, $domain) = split('@', $email);
            $result = array('contacts_email' => $email, 'contacts_name' => $dataname);
            $display_array[] = $result;
            $email_only_array[] = $email; //to remove duplicates

        }
    }

       
    $poweredby_bottom = $footer;//powered by
    $show_result = 1;//show results table
    unlink($username);//deleting csv file
    @unlink($mycookie);
}
$table = 1;//show table in main template (email or cvs upload)
$service = 'myhotmail';
@unlink($mycookie);
include_once ('index.php');
?>
