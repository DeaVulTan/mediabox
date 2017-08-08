<?php

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        ICQ    CONTACT IMPORTING SCRIPT                              //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////


$service = 'icq';
include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
include ('includes/service.php');


//--------------------------------------------end of service------------------------------------------------\\

if ($matches == 1){
//WRITING OUTPUT TO CSV FILE
				
				$myFile = $username;
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $result);
				fclose($fh);

//*********************** | START OF HTML | ***********************************\\


//OPEING CSV FILE FOR PROCESSING

				$fp = fopen ($username,"r");

				while (!feof($fp)){

				$data = fgetcsv ($fp, 4100, ","); //this uses the fgetcsv function to store the quote info in the array $data


//print_r($data);

				$dataname = $data[0];

				IF (empty($dataname)){

				$dataname = $data[1];                 

				}

				IF (empty($dataname)){

				$dataname = $data[2];                

					}

				IF (empty($dataname)){

				$dataname = "None";                 

						}

				$email = $data[3]; //different csv to lycos and yahoo etc

				IF (empty($email)){

//Skip table

				}ELSE{

				$email = $data[3];    

				IF ($dataname != "First Name"){
	
					//remove none characters
					$email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
					$dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);

                $result = array('contacts_email' => $email1,'contacts_name' => $dataname1);

                $display_array[] = $result;
            }
        }
    }
	$poweredby_bottom = $footer; //powered by
    $show_result = 1;//show results table
unlink($username);//deleting csv file
@unlink($mycookie);
}
$table = 1;//show table in main template (email or cvs upload)
$service = 'myicq';
@unlink($username);//deleting csv file
@unlink($mycookie);
include_once ('index.php');
?>