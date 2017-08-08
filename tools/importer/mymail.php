<?php

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        MAIL.COM CONTACT IMPORTING SCRIPT                            //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

//******************************* | SETTING VARIABLES | ***********************************\\
$service = 'mail';
include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
include ('includes/service.php');

//--------------------------------------------end of service------------------------------------------------\\

//WRITING THE RESULTS TO A CSV FILE ON THE SERVER

				$myFile = $username;
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $result);
				fclose($fh);

// CHECKING IF LOGIN WAS SUCCESSFUL - by search of the @ sign in the csv

				preg_match_all("/@/", $result, $array_at);	

				$at_sign = $array_at[0];

				IF (empty($at_sign)){

    $show = 1;
    $error_message = "No contacts found - check your login details and try again";

				}ELSE{

//*********************** | START OF HTML | ***********************************\\

// OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY


				$fp = fopen ($username,"r");

				while (!feof($fp)){

				$data = fgetcsv ($fp, 4100, ","); //this uses the fgetcsv function to store the quote info in the array $data



//print_r($data);

				$dataname = $data[0];

				IF (empty($dataname)){

				$dataname = $data[2];                 

				}

				IF (empty($dataname)){

				$dataname = $data[3];                

					}

				IF (empty($dataname)){

				$dataname = "None";                 

						}

				$email = $data[4];

				IF (empty($email)){

//Skip table

				}ELSE{

				$email = $data[4];    

				IF ($dataname != "First Name"){
	
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
unlink($username);//deleting csv file
@unlink($mycookie);
}
$table = 1;//show table in main template (email or cvs upload)
$service = 'mymail';
@unlink($username);//deleting csv file
@unlink($mycookie);
include_once ('index.php');
?>