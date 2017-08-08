<?php

//REV 3.3.3

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        CSV - OUTLOOK  CONTACT IMPORTING SCRIPT                      //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

include_once ('includes/tbs_class.php');

// START OF FILE UPLOAD AND SECURITY CHECK

$limit_size = 2000000;//you can change this to a higher file size limit (this is in bytes = 2MB apprx)

$random = rand(150,15000);//create random number
$uniquename = $random.$HTTP_POST_FILES['ufile']['name'];//add random number to file name to create unique file
$path = "upload/".$uniquename;

if ($ufile != none) {
    // Store upload file size in $file_size
    $file_size = $HTTP_POST_FILES['ufile']['size'];

    if ($file_size >= $limit_size) {
        $show = 1;
        $error_message = "Your file exceeds the allowed file size limit - please try again";
    }
    else {

        $filetype = $HTTP_POST_FILES['ufile']['type'];
        //echo $filetype;
        if ($filetype == "application/x-csv" || $filetype == "text/csv") {

            //copy file to where you want to store file
            if (copy($HTTP_POST_FILES['ufile']['tmp_name'],$path)) {
            }
            else {
                echo "Copy Error";
                $show = 1;
                $error_message = "Copy error - please try again";
            }
        }
        else {
            $show = 1;
            $error_message = "You can only upload CSV files - please try again";
        }
    }
}
if ($show != 1) {
    //END OF FILE UPLOAD

    // OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY

    //		$fp = fopen ($username,"r");

    $fp = fopen($path,"r");

    while (!feof($fp)) {

        $data = fgetcsv($fp,4100,",");//this uses the fgetcsv function to store the quote info in the array $data

        //print_r($data);

        $dataname = $data[1];

        if (empty($dataname)) {

            $dataname = $data[2];

        }

        if (empty($dataname)) {

            $dataname = $data[3];

        }

        if (empty($dataname)) {

            $dataname = "None";

        }

        $email = $data[1];//different csv to lycos and yahoo etc

        if (empty($email)) {

            //Skip table

        }
        else {

            $email = $data[57];

            if ($dataname != "First Name") {
	
					//remove none characters
					$email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
					$dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);

                $result = array('contacts_email' => $email1,'contacts_name' => $dataname1);
                $display_array[] = $result;

            }
        }
    }
    $poweredby_bottom = $footer;//powered by
    $show_result = 1;//show results table
    unlink($path);//deleting csv file
}
$table = 2;//show table in main template (email or cvs upload)
$service = 'myexpress';
	@unlink($path); //deleting csv file
include_once ('index.php');
?>