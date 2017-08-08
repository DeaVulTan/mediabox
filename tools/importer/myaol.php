<?php


/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        AOL CONTACT IMPORTING SCRIPT                                 //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////


//******************************** START OF SCRIPT - SETTING VARIABLE ****************************\\


include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
$display_array = array();

list($username,$domain) = split('@',$username);


$refering_site ='http://classic.webmail.aol.com'; //setting the site for refer

$browser_agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)"; //setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");

$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);



//******************************** OPENING LOGIN PAGE ***************************\\


$login_page = 'https://my.screenname.aol.com/_cqr/login/login.psp?mcState=initialized&seamless=novl&siteId=vatlasaol-static&siteState=OrigUrl%3dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp&authLev=2';


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $login_page);               
curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);      
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);              
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);             
curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);   
curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);     
$page_result = curl_exec ($ch);
curl_close ($ch);

                                      // DEBUG -- this will show you the whole page as you would in a broswer   

$cookie_data1 = ".aol.com	FALSE	/	FALSE	0	s_sq	%5B%5BB%5D%5D \n";
$fp2 = fopen($path_to_cookie, "a"); // "a" is to append
fwrite($fp2, $cookie_data1);
fclose($fp2);

$cookie_data2 = ".aol.com	FALSE	/	FALSE	0	s_cc	true";
$fp3 = fopen($path_to_cookie, "a"); // "a" is to append
fwrite($fp3, $cookie_data2);
fclose($fp3);

//echo "<textarea rows=30 cols=120>".$page_result."</textarea>";       //DEBUG -- this will pages html in nice box



// (1) get usrd fieled

preg_match_all("/name=\"usrd\" value=\"(.*?)\"/", $page_result, $usrd); 
//print_r($usrd);                       // DEBUG -- this will print the whole array to allow you to select the one you want e.g [1][0]
$usrd_found = $usrd[1][0];                 // stores the hidden text in a ariable to use later in POST
//echo $usrd_found;                           // DEBUG -- To show if you have selcted the correct array


// *******************  submitting login info as aquired above  ***************************



$postal_data ='sitedomain=vatlasaol-static&siteId=vatlasaol-static&lang=en&locale=us&authLev=2&siteState=OrigUrl%253Dhttp%25253a%25252f%25252fclassic.webmail.aol.com%25252f_cqr%25252fvllogin.adp&isSiteStateEncoded=true&mcState=initialized&usrd='.$usrd_found.'&loginId='.$username.'&password='.$password.'&rememberMe=off&x=33&y=10';



$login_page2 = 'https://my.screenname.aol.com/_cqr/login/login.psp';

$referer2 = 'https://my.screenname.aol.com/_cqr/login/login.psp?mcState=initialized&seamless=novl&siteId=vatlasaol-static&siteState=OrigUrl%3dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp&authLev=2';


//echo $postal_data;                 //DEBUG -- checking $postada1 above



$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$login_page2);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS,$postal_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $referer2);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 0);

    $result3 = curl_exec ($ch);
    curl_close ($ch); 

//echo $result3;

//echo "<textarea rows=30 cols=120>".$result3."</textarea>";       //DEBUG -- this will pages html in nice box


//preg_match_all("/'loginForm', 'false', '(.*?)'/", $result3, $redirected);	
//$myaol = $redirected[1][0];




// ********** START OF COOKIE CHECKS *********************************


$cookiechecker1 = 'http://my.screenname.aol.com/_cqr/login/login.psp?mcState=copyCookies&siteId=vatlasaol-static&authLev=2&siteState=OrigUrl%3Dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp&lang=en&locale=us';


	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$cookiechecker1);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $login_page2);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result5 = curl_exec ($ch);
    curl_close ($ch);

//echo $result5;

preg_match_all("/MC_CMP_SX=(.*?)\" TYPE/", $result5, $cookieurl1);

preg_match_all("/MC_CMP_S=(.*?)\" TYPE/", $result5, $cookieurl2);

$redirect_CMP_SX = $cookieurl1[1][0];
$redirect_CMP_S = $cookieurl2[1][0];

//echo "<textarea rows=30 cols=120>".$result5."</textarea>";   //DEBUG -- this will pages html in nice box

//echo $redirect_CMP_SX;

//echo "<p></p>";

//echo $redirect_CMP_S;


//************* COOKIE STEP 2 ********************

$cookiechecker2 = 'http://sns.cqr.classic.webmail.aol.com/_cqr/xdomain/final.psp?siteId=vatlasaol-static&MC_CMP_SX='.$redirect_CMP_SX;
$referer3 = 'http://my.screenname.aol.com/_cqr/login/login.psp?mcState=copyCookies&siteId=vatlasaol-static&authLev=2&siteState=OrigUrl%3Dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp&lang=en&locale=us';

	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$cookiechecker2);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $referer3);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result6 = curl_exec ($ch);
    curl_close ($ch);

//echo $result5;

//preg_match_all("/MC_CMP_SX=(.*?)\" TYPE/", $result5, $cookieurl1);

//$redirect_CMP_S = $cookieurl2[1][0];

//echo "<textarea rows=30 cols=120>".$result6."</textarea>";   //DEBUG -- this will pages html in nice box


//************* COOKIE STEP 3  ******************************************************************************

$cookiechecker3 = 'http://sns.cqr.classic.webmail.aol.com/_cqr/xdomain/final.psp?siteId=vatlasaol-static&MC_CMP_S='.$redirect_CMP_S;
$referer4 = 'http://my.screenname.aol.com/_cqr/login/login.psp?mcState=copyCookies&siteId=vatlasaol-static&authLev=2&siteState=OrigUrl%3Dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp&lang=en&locale=us';

	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$cookiechecker3);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $referer4);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result7 = curl_exec ($ch);
    curl_close ($ch);

//echo $result7;

//echo "<textarea rows=30 cols=120>".$result7."</textarea>";   //DEBUG -- this will pages html in nice box


// *******************  LOGGING INTO AOL CLASSIC  ***************************

$login_page3 = 'http://classic.webmail.aol.com/_cqr/login';


$postal_data2 ='siteId=vatlasaol-static&sitedomain=vatlasaol-static&authLev=2&lang=en&locale=us&siteState=OrigUrl%3Dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp';


$referer2 = 'http://my.screenname.aol.com/_cqr/login/login.psp?mcState=copyCookies&siteId=vatlasaol-static&authLev=2&siteState=OrigUrl%3Dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp&lang=en&locale=us';


$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$login_page3);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS,$postal_data2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $referer2);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result8 = curl_exec ($ch);
    curl_close ($ch); 

//echo $result8;

//echo "<textarea rows=30 cols=120>".$result8."</textarea>";       //DEBUG -- this will pages html in nice box



//***************************** OPENING INBOX PART 1***********************************



$inboxurl = 'http://classic.webmail.aol.com/_cqr/vllogin.adp';

$referer3 = 'http://my.screenname.aol.com/_cqr/login/login.psp?mcState=copyCookies&siteId=vatlasaol-static&authLev=2&siteState=OrigUrl%3Dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp&lang=en&locale=us';



	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$inboxurl);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $referer3);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result9 = curl_exec ($ch);
    curl_close ($ch);


//echo $result9;

//echo "<textarea rows=30 cols=120>".$result9."</textarea>";   //DEBUG -- this will pages html in nice box


//***************************** OPENING INBOX PART 2 ***********************************



$inboxurl2 = 'http://classic.webmail.aol.com/msglist.adp';

$referer4 = 'http://my.screenname.aol.com/_cqr/login/login.psp?mcState=copyCookies&siteId=vatlasaol-static&authLev=2&siteState=OrigUrl%3Dhttp%253a%252f%252fclassic.webmail.aol.com%252f_cqr%252fvllogin.adp&lang=en&locale=us';



	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$inboxurl2);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $referer4);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result10 = curl_exec ($ch);
    curl_close ($ch);

//echo $result10;


//echo "<textarea rows=30 cols=120>".$result10."</textarea>";   //DEBUG -- this will pages html in nice box


//***************************** OPENING ADDRESS BOOK 1 ***********************************



$addressbook1 = 'http://classic.webmail.aol.com/rab.adp?launch=main';


	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$addressbook1);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $inboxurl2);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result11 = curl_exec ($ch);
    curl_close ($ch);


//echo "<textarea rows=30 cols=120>".$result11."</textarea>";   //DEBUG -- this will pages html in nice box

preg_match_all("/main.adp\?(.*?)\"/", $result11, $addresses);

$addressredirect = $addresses[1][0];


//echo $addressredirect;




// *******************  FINAL POST TO GET INTO ADDRESS BOOK  ***************************



$postal_final = $addressredirect;

$posted = "";

$login_final = 'http://ab.classic.webmail.aol.com/main.adp?'.$postal_final;


$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$login_final);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS,$posted);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $addressbook1);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result22 = curl_exec ($ch);
    curl_close ($ch); 

//echo $result22;

//echo "<textarea rows=30 cols=120>".$result22."</textarea>";       //DEBUG -- this will pages html in nice box

//echo $login_final;


//***************************** OPENING ADDRESS PRINT ALL ***********************************



$addressbook2 = 'http://ab.classic.webmail.aol.com/print_all_information.adp?langid=0&ContactKey=100,99,98,97,96,95,94,93,92,91,90,89,88,87,86,85,84,83,82,81,80,79,78,77,76,75,74,73,72,71,70,69,68,67,66,65,64,63,62,61,60,59,58,57,56,55,54,53,52,51,50,49,48,47,46,45,44,43,42,41,40,39,38,37,36,35,34,33,32,31,30,29,28,27,26,25,24,23,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1,&mheader=0';

//put as many numbers in link abov to pull as many contacts as possible

	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$addressbook2);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $login_final);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $result23 = curl_exec ($ch);
    curl_close ($ch);


//echo $result23;


// ********************       this array pulls out the names and email using regular eaxpressions ******************************


//FULL NAME AND EMAIL IN ONE ARRAY SEARCH

preg_match_all("/size=2 color=\"#000000\"><b>(.*?)<\/b>.*E-mail: (.*?)<br>/", $result23, $array_fulldetails);	

//print_r($array_fulldetails);          //DEBUG -- this will print the whole array


$details = $array_fulldetails;

// [checking if array empty]

IF (empty($details)){

    $show = 1;
    $error_message = "No contacts found - check your login details and try again";


}ELSE{

		$i = 0;
		while (isset($details[1][$i])):
		
//  [RESULTS - START OF CONTACTS LIST]

        $email = $matches[2][$i];
        $dataname = $matches[1][$i];
        $result = array('contacts_email' => $email,'contacts_name' => $dataname);
        $display_array[] = $result;

        $i++;
    endwhile;
    $poweredby_bottom = $footer;//powered by
    $show_result = 1;//show results table
@unlink($mycookie);
}
$table = 1;//show table in main template (email or cvs upload)
$service = 'myaol';
@unlink($username);//deleting csv file
@unlink($mycookie);
include_once ('index.php');
?>


















