<?php

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        YAHOO CONTACT IMPORTING SCRIPT                               //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

//******************************* | SETTING VARIABLES | ***********************************\\

$service = 'yahoo';
include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
include ('includes/service.php');



//--------------------------------------------end of service------------------------------------------------\\

if ($matches == 1){


//---------------------------------------------------STEP 9 - Start of results

//WRITING OUTPUT TO CSV FILE
				
				$myFile = $username;
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $result);
				fclose($fh);


//OPEING CSV FILE FOR PROCESSING

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

				IF (empty($email)){  //Skip table if email is blank

				}ELSE{

				$email = $data[4];    
				IF ($dataname == "None"){
					$dataname = $email;
					}
				IF ($dataname != "First"){  // skiping table to remove first line of csv file

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
$service = 'myyahoo';
@unlink($username);//deleting csv file
@unlink($mycookie);
include_once ('index.php');
?>