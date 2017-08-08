<?php

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        LYCOS  CONTACT IMPORTING SCRIPT                              //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

$service = 'lycos';
include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
include ('includes/service.php');

if ($domain == 'lycos.com') {
    //--------------------------------------------end of service------------------------------------------------\\
    //WRITING THE RESULTS TO A CSV FILE ON THE SERVER

    $myFile = $username;
    $fh = fopen($myFile, 'w') or die("can't open file");
    fwrite($fh, $result);
    fclose($fh);

    // CHECKING IF LOGIN WAS SUCCESSFUL - by search of the @ sign in the csv

    preg_match_all("/@/", $result, $array_at);

    //print_r($array_at);                                       //DEBUG - Show array

    $at_sign = $array_at[0];

    if (empty($at_sign)) {

        $show = 1;
        $error_message = "No contacts found - check your login details and try again";

    }
    else {

        //*********************** | START OF HTML | ***********************************\\

        // OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY

        $fp = fopen($username, "r");

        while (!feof($fp)) {

            $data = fgetcsv($fp, 4100, ",");//this uses the fgetcsv function to store the quote info in the array $data

            //print_r($data);

            $dataname = $data[0];

            if (empty($dataname)) {

                $dataname = $data[2];

            }

            if (empty($dataname)) {

                $dataname = $data[3];

            }

            if (empty($dataname)) {

                $dataname = "None";

            }

            $email = $data[4];

            if (empty($email)) {

                //Skip table

            }
            else {

                $email = $data[4];

                if ($dataname != "First Name") {

                    //remove none characters
                    $email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/", "", $email);
                    $dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/", "", $dataname);

                    $result = array('contacts_email' => $email1, 'contacts_name' => $dataname1);

                    $display_array[] = $result;
                }
            }
        }
        $poweredby_bottom = $footer;//powered by
        $show_result = 1;//show results table
        unlink($username);//deleting csv file
        @unlink($mycookie);
    }
}

//LYCOS.CO.UK
/////////////

if ($domain == 'lycos.co.uk') {
    @preg_match_all('/card.*,"(.*?)"/', $result, $matches);

    $checkarray = $matches[1][0];
    if (empty($checkarray)) {
        $show = 1;
        $error_message = "No contacts found - check your login details and try again";
    }

    //Collect all emails
    $i = 0;
    $display_array = array();
    while (isset($matches[1][$i])) {

        //  [RESULTS - START OF CONTACTS LIST]
        $email = $matches[1][$i];
        list($dataname, $domain) = split('@', $email);

        //remove none characters
        $email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/", "", $email);
        $dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/", "", $dataname);

        $result = array('contacts_email' => $email1, 'contacts_name' => $dataname1);
        $display_array[] = $result;
        $i++;
    }

    $poweredby_bottom = $footer;//powered by
    $show_result = 1;//show results table
    unlink($username);//deleting csv file
    @unlink($mycookie);

}
$table = 1;//show table in main template (email or cvs upload)
$service = 'mylycos';
@unlink($username);//deleting csv file
@unlink($mycookie);
include_once ('index.php');
?>
