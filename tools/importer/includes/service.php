<?php

//loader for each network
// Version 7.1


if ($service == "emailit"){
//--------------------------------------------------------------EMAILIT.COM-------------------------------------------------------------------
$display_array = array();
list($username,$domain) = split('@',$username);
$refering_site = "http://mail.google.com/mail/";//setting the site for refer
$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";//setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);
//---------------------------------------------------STEP 1

$url = "http://email.it/";
$page_result = curl_get($url,1,0);
//---------------------------------------------------STEP 2

$url = 'http://wm.email.it/webmail/wm_5/login.php?action=login';
$postal_data = 'f_user='.$username.'&f_pass='.$password.'&LOGIN='.$username.
    '&PASSWD='.$password.'&Act_Login.x=18&Act_Login.y=6&Act_Login=Ok';
$result = curl_post($url,$postal_data,1,0);
preg_match_all('/frame src="menu.php.(.*?)"/',$result,$matches,
    PREG_PATTERN_ORDER);
$matches = $matches[1][0];
//---------------------------------------------------STEP 3

$url = 'http://wm.email.it/webmail/wm_5/addressbook.php?startp=1&'.$matches.
    '&folde=&prem=undefined';
$result = curl_get($url,1,0);
preg_match_all('/function print_abook\(\) { window.open\(\'addressbook.php(.*?)\',/',
    $result,$matches,PREG_PATTERN_ORDER);
$matches = $matches[1][0];

//---------------------------------------------------STEP 1

$url = 'http://wm.email.it/webmail/wm_5/quick_address.php'.$matches;
$result = curl_get($url,1,0);
preg_match_all('/<option value="(.*?)">.[a-zA-Z0-9]*&nbsp;&lt;(.*?)&gt;/',$result,
    $matches,PREG_PATTERN_ORDER);
//print_r($matches);
@unlink ($path_to_cookie);
//------------------------------------------------------------------EMAILIT - END -----------------------------------------------------------------
}








if ($service == "gmail"){

//------------------------------------------------------------------ GMAIL START -----------------------------------------------------------------
$display_array = array();

$refering_site = "http://mail.google.com/mail/";//setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";//setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");

$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);

//---------------------------------------------------STEP 1

$url = "http://mail.google.com/mail/";
$page_result = curl_get($url,1,0);

preg_match_all('%name="GALX"\n.*."(.*?)"%',$page_result,$matches);
$matches = $matches[1][0];

//---------------------------------------------------STEP 2

$postal_data="service=mail&ltmpl=default&ltmplcache=2&continue=http%3A%2F%2Fmail.google.com%2Fmail%2F%3Fui%3Dhtml%26zy%3Dl&service=mail&rm=false&ltmpl=default&ltmpl=default&scc=1&GALX=".$matches."&Email=".$username."&Passwd=".$password."&rmShown=1&signIn=Sign+in&asts=";
$url = 'https://www.google.com/accounts/ServiceLoginAuth';
$result = curl_post($url,$postal_data,1,0);
// [pick up forwarding url]
preg_match_all("/location.replace.\"(.*?)\"/",$result,$matches);
$matches = $matches[1][0];

//---------------------------------------------------STEP 3

$url = $matches;
$result = curl_get($url,1,0);

//---------------------------------------------------STEP 4 - html only

$url = 'https://mail.google.com/mail/?ui=html&zy=e';
$result = curl_get($url,1,0);

//---------------------------------------------------STEP 5 - open export contacts page
$url = 'https://mail.google.com/mail/?ui=1&ik=&view=sec&zx=';
$result = curl_get($url,1,0);
preg_match_all("/value=\"(.*?)\"/",$result,$matches);
$matches = $matches[1][0];
//echo $matches;

//---------------------------------------------------STEP 6 - download csv

$postal_data = 'at='.$matches.'&ecf=g&ac=Export Contacts';
$url = 'https://mail.google.com/mail/?ui=1&view=fec';
$result = curl_post($url,$postal_data,1,0);
@unlink ($path_to_cookie);

//------------------------------------------------------------------GMAIL - END -----------------------------------------------------------------
}






if ($service == 'hotmail'){
//------------------------------------------------------------------HOTMAIL START -----------------------------------------------------------------
$display_array = array();

$refering_site = "http://google.com/"; //setting the site for refer

$browser_agent = "Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320)"; //setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);


//--------------------------------------------------- Login

$url = "https://mid.live.com/si/login.aspx?lc=2057&id=71570&ru=http%3a%2f%2fmobile.live.com%2fwml%2fmigrate.aspx%3freturl%3dhttp%253a%252f%252fmobile.live.com%252fhm%252ffolder.aspx%253fmkt%253den-GB%26fti%3dy&mlc=en-GB&mspsty=302&mspto=1&tw=14400&kv=2&ns=hotmail.com&ver=2.5.1027.0";

$result =curl_get($url,1,0);
preg_match('/action="(.*?)"/', $result, $regx);
$refering_site = $url;
$part_url = $regx[1];

//--------------------------------------------------- Form
$url = 'https://mid.live.com/si/'.$part_url;
$postal_data = '__EVENTTARGET=&__EVENTARGUMENT=&LoginTextBox='.$username.'&PasswordTextBox='.$password.'&SavePasswordCheckBox=0&PasswordSubmit=Sign+in';
$result =curl_post($url,$postal_data,0,0);
preg_match('%href="(.*?)"%', $result, $regx);
$refering_site = $url;
$url = $regx[1];

//--------------------------------------------------- Redirect

$result =curl_get($url,0,0);
$refering_site = $url;

//--------------------------------------------------- Redirect
$url ='http://mobile.live.com/hm/folder.aspx';
$result =curl_get($url,0,0);
$refering_site = $url;



//--------------------------------------------------- Contacts (loop)
for ($count = -1; $count <= 10; $count += 1){
$url = 'http://mpeople.live.com/default.aspx?pg='.$count;
$result_1 =curl_get($url,1,0);
$result = $result.$result_1;
}
@unlink ($path_to_cookie);


//------------------------------------------------------------------HOTMAIL - END -----------------------------------------------------------------
}








if ($service == "icq"){
//------------------------------------------------------------------ICQ START -----------------------------------------------------------------
$display_array = array();

list($username,$domain)=split('@',$username);

$refering_site = "http://icqmail.com"; //setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7"; //setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);


//---------------------------------------------------STEP 1

$url = "http://www.icqmail.com/";
$page_result =curl_get($url,1,0);


//---------------------------------------------------STEP 2

$postal_data ='faction=login&domain=icqmail.com&username='.$username.'&password='.$password;
$url = 'http://www.icqmail.com/default.asp';
$result =curl_post($url,$postal_data,1,0);

// [pick up forwarding url]
preg_match_all("/url=\/(.*?)\"/", $result, $matches);
$matches = $matches[1][0];



//---------------------------------------------------STEP 3

$url = 'http://www.icqmail.com/'.$matches;
$result =curl_get($url,1,0);


//---------------------------------------------------STEP 4 - html only

$url = 'http://www.icqmail.com/js/nojs.asp?skipjs=1';
$result =curl_get($url,1,0);


// CHECKING IF LOGIN WAS SUCCESSFUL - by search of the @ sign in the csv

preg_match_all("/ICQ Password/",$result,$array_at);

$at_sign = $array_at[0];

if (!empty($at_sign)) {

    $show = 1;
    $error_message = "No contacts found - check your login details and try again";
}
else {


$url = 'http://www.icqmail.com/contacts/contacts_import_export.asp?action=export&app=Microsoft%20Outlook';
$result =curl_get($url,1,0);
$matches = 1;
}
@unlink ($path_to_cookie);

//------------------------------------------------------------------ICQ - END -----------------------------------------------------------------
}






if ($service =="indiatimes"){
//------------------------------------------------------------------INDIATIME START -----------------------------------------------------------------
$display_array = array();

list($myusername,$domain) = split('@',$username);

$username = $myusername;


$refering_site = "http://mail.lycos.com/lycos/Index.lycos";//setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);

//---------------------------------------------------STEP 1

$url = "http://infinite.indiatimes.com/";
$page_result = curl_get($url,1,0);

preg_match_all('%action="http://(.*?)"%',$page_result,$matches);

$posturl = $matches[1][0];

//echo $posturl;

//---------------------------------------------------STEP 2

$postal_data = 'login='.$username.'&passwd='.$password.'&Sign+in.x=29&Sign+in.y=7';
$url = 'http://'.$posturl;
$result = curl_post($url,$postal_data,1,2);


//------------------------------------------------------get contacts
$url = 'http://mb.indiatimes.com/home/'.$username.'/Contacts.csv';
$result = curl_get($url,1,2);
@unlink ($path_to_cookie);

//------------------------------------------------------------------INDIATIMES - END -----------------------------------------------------------------
}










if ($service == "katamail"){
//------------------------------------------------------------------KATAMAIL START -----------------------------------------------------------------
$display_array = array();

list($username,$domain) = split('@',$username);

$refering_site = "http://mail.google.com/mail/";//setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";//setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);

//---------------------------------------------------STEP 1

$url = "http://www.kataweb.it/";
$page_result = curl_get($url,1,0);

//---------------------------------------------------STEP 2

$postal_data = 'frames=no&lang=it_IT&domain=katamail.com&login='.$username.
    '&passwd='.$password;
$url = 'http://webmail.katamail.com/cgi-bin/wm/start';
$result = curl_post($url,$postal_data,1,0);

//---------------------------------------------------STEP 3

$url = 'http://webmail.katamail.com/cgi-bin/wm/listaddr?lang=it_IT';
$result = curl_get($url,1,0);
preg_match_all('/friendA" value=\'%22(.*?)%20.*%3c(.*?)%/',$result,$matches,
    PREG_PATTERN_ORDER);
@unlink ($path_to_cookie);

//------------------------------------------------------------------KATAMAIL END -----------------------------------------------------------------
}

if ($service == "lycos"){
//------------------------------------------------------------------LYCOS START -----------------------------------------------------------------
$display_array = array();


$refering_site = "http://mail.lycos.com/lycos/Index.lycos"; //setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)"; //setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);


list($myusername,$domain) = split('@',$username);



//Load Lycons.com
if($domain == 'lycos.com'){
//---------------------------------------------------STEP 1

$url = "http://mail.lycos.com/lycos/mail/MailLeftLogin.lycos";
$page_result =curl_get($url,1,0);


//---------------------------------------------------STEP 2
$postal_data = 'm_PR=27&m_CBURL=http://mail.lycos.com&m_U='.$myusername.'&m_P='.$password.'&m_AS=1&x=42&y=8';
$url = "https://registration.lycos.com/login.php?m_PR=27";
$result =curl_post($url,$postal_data,1,0);

//---------------------------------------------------STEP 3

$url = "http://mail.lycos.com/lycos/addrbook/ExportAddr.lycos?ptype=act&fileType=OUTLOOK";
$result =curl_get($url,1,0);

@unlink ($path_to_cookie);


//Load Lycos.co.uk
}else{

$url = "http://secure.mail.lycos.co.uk/services/signin/mail.jsp";
$page_result =curl_get($url,1,0);

//---------------------------------------------------STEP 2
$postal_data = 'login='.$username.'&hiddenlogin=Username&hiddenpassword=******&password='.$password;
$url = "http://secure.mail.lycos.co.uk/lsu/signin/action.jsp";
$result =curl_post($url,$postal_data,1,0);

$url = "http://f012.mail.lycos.co.uk/lsu/signin/cookie.jsp?proxy=";
$result =curl_get($url,1,0);

$url = "http://f012.mail.lycos.co.uk/app/home/home.jsp";
$result =curl_get($url,1,0);

$url = "http://f012.mail.lycos.co.uk/app/msg/mail/compose/view.jsp?act=112";
$result =curl_get($url,1,0);


}

//------------------------------------------------------------------LYCOS END -----------------------------------------------------------------
}






if ($service == "mail"){
//------------------------------------------------------------------MAIL START -----------------------------------------------------------------

$display_array = array();

$refering_site = "http://mail.com/"; //setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)"; //setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);


//---------------------------------------------------STEP 1

$url = "http://www.mail.com";
$page_result =curl_get($url,1,0);

//---------------------------------------------------STEP 2

$postal_data='login='.$username.'&password='.$password.'&redirlogin=1&siteselected=normal';
$url = 'http://www2.mail.com/scripts/common/proxy.main?signin=1&lang=us';
$result =curl_post($url,$postal_data,1,0);
preg_match_all("/url=(.*?)\/templates/", $result, $matches);
$base = $matches[1][0];

//---------------------------------------------------STEP 1

$url = $base.'/scripts/addr/addressbook.cgi?showaddressbook=1';
$page_result =curl_get($url,1,0);
preg_match_all("/ob=(.*?)&gab=1/", $page_result, $matches);
$ob = $matches[1][0];


//---------------------------------------------------STEP 1

$url = $base.'/scripts/addr/external.cgi?.ob='.$ob.'&gab=1';
$page_result =curl_get($url,1,0);


//---------------------------------------------------STEP 2

$postal_data ='showexport=showexport&action=export&format=csv';
$url = $base.'/scripts/addr/external.cgi?.ob='.$ob.'&gab=1';
$result =curl_post($url,$postal_data,1,0);

@unlink ($path_to_cookie);

//------------------------------------------------------------------MAIL END -----------------------------------------------------------------
}









if ($service == "rediffmail"){

//------------------------------------------------------------------REDIFF START-----------------------------------------------------------------
$display_array = array();

list($username,$domain) = split('@',$username);

$refering_site = "http://yahoo.com/";//setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);

//---------------------------------------------------start

$url = "http://www.rediff.com";
$page_result = curl_get($url,1,0);

//---------------------------------------------------login
$url = 'http://mail.rediff.com/cgi-bin/login.cgi';
$postdata = 'login='.$username.'&passwd='.$password.'&FormName=existing';
$result = curl_post($url,$postdata,1,0);
preg_match('/url=(.*?)"/', $result, $regs);
$matches = $regs[1];
//---------------------------------------------------redirect and get unique id

$url = $matches;
$result = curl_get($url,1,0);
//get sessions id
preg_match_all('/&session_id=(.*?)&/', $result, $regs);
//print_r($regs);
$matches = $regs[1][1];
//get server address
preg_match_all('%HREF="(.*?)/bn%', $result, $regs2);
//print_r($regs2);
$matches2 = $regs2[1][1];
// code added by yogaraja_090at09 hard cord the rediff mail url here.
if(empty($matches2))
	$matches2 = 'http://mail.rediff.com/';
//---------------------------------------------------load iframes address list
echo $url=$matches2.'/bn/address.cgi?login='.$username.'&FormName=export&session_id='.$matches.'&FormName=group_book';
$result = curl_get($url,1,0);

//------------------------------------------------------------------REDIFF END-----------------------------------------------------------------
}







if ($service == "yahoo"){

//------------------------------------------------------------------YAHOO START-----------------------------------------------------------------
$display_array = array();

$refering_site = "http://yahoo.com/"; //setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)"; //setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);

//---------------------------------------------------STEP 1

$url = "https://login.yahoo.com/config/mail?.intl=us";
$page_result =curl_get($url,1,0);
preg_match_all("/name=\".tries\" value=\"(.*?)\"/", $page_result, $tries);
$tries_found = $tries[1][0];
preg_match_all("/name=\".src\" value=\"(.*?)\"/", $page_result, $src);
$src_found = $src[1][0];
preg_match_all("/name=\".u\" value=\"(.*?)\"/", $page_result, $u);
$u_found = $u[1][0];
preg_match_all("/name=\".v\" value=\"(.*?)\"/", $page_result, $v);
$v_found = $v[1][0];
preg_match_all("/name=\".challenge\" value=\"(.*?)\"/", $page_result, $challenge);
$challenge_found = $challenge[1][0];

//---------------------------------------------------STEP 2 - submit login info

$postal_data ='.tries='.$tries_found.'&.src='.$src_found.'&.md5=&.hash=&.js=&.last=&promo=&.intl=us&.bypass=&.partner=&.u=6bu841h2d7p4o&.v=0&.challenge='.$challenge_found.'&.yplus=&.emailCode=&pkg=&stepid=&.ev=&hasMsgr=1&.chkP=Y&.done=http://mail.yahoo.com&.pd=ym_ver%253d0&login='.$username.'&passwd='.$password;
$url = 'https://login.yahoo.com/config/login?';
$result =curl_post($url,$postal_data,1,0);
preg_match_all("/replace\(\"(.*?)\"/", $result, $matches);
$matches = $matches[1][0];

//---------------------------------------------------STEP 3 - Redirect

$url = $matches;
$result =curl_get($url,1,0);

//---------------------------------------------------STEP 4 - Redirect

$url = 'http://us.rd.yahoo.com/mail_us/pimnav/ab/*http://address.mail.yahoo.com';
$result =curl_get($url,1,0);

//---------------------------------------------------STEP 5 - Open address book

$url = 'http://address.mail.yahoo.com';
$result =curl_get($url,1,0);
preg_match_all("/rand=(.*?)\"/", $result, $array_names);
$rand_value = str_replace('"', '', $array_names[0][0]);

//---------------------------------------------------STEP 6 - Export address book

$url = 'http://address.mail.yahoo.com/?1&VPC=import_export&A=B&.rand='.$randURL;
$result =curl_get($url,1,0);
preg_match_all("/id=\"crumb1\" value=\"(.*?)\"/", $result, $array_names);
$matches = $array_names[1][0];


//---------------------------------------------------STEP 7 - Checking if address book is empty

IF (empty($matches)){

    $show = 1;
    $error_message = "No contacts found - check your login details and try again";

}ELSE{




//---------------------------------------------------STEP 8 - submit login info

$postal_data ='.crumb='.$matches.'&VPC=import_export&A=B&submit%5Baction_export_yahoo%5D=Export+Now';
$url = 'http://address.mail.yahoo.com/index.php';
$result =curl_post($url,$postal_data,1,0);
$matches = 1;
}
@unlink ($path_to_cookie);

//------------------------------------------------------------------YAHOO END-----------------------------------------------------------------
}




if ($service == "fastmail"){

//------------------------------------------------------------------FASTMAIL START-----------------------------------------------------------------
$display_array = array();

$refering_site = "http://fastmail.com/";//setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);

//---------------------------------------------------1

$url = "http://fastmail.fm";
$page_result = curl_get($url,1,0);
preg_match('/name="memail" action="(.*?)"/', $page_result, $regs);
$result = $regs[1];
//---------------------------------------------------2

$url = $result;
$postdata = 'MLS=LN-*&FLN-UserName='.$username.'&FLN-Password='.$password.'&MSignal_LN-AU*=Login&FLN-ScreenSize=-1';
$page_result = curl_post($url,$postdata,1,0);
preg_match('/content="0;url=(.*?)"/', $page_result, $regs);
$result = $regs[1];
preg_match('/Ust=(.*?)&MSignal/', $page_result, $regs2);
$result2 = $regs2[1];

//---------------------------------------------------3

$url = 'http://fastmail.fm/mail/?Ust='.$result2;
$postdata = 'MLS=UA-*&SAD-AL-SF=DN3_0&MSS=!AD-*&SAD-AL-DR=20&SAD-AL-TP=0&SAD-AL-SpecialSortBy=SNM:0&_charset_=ISO-8859-1&FUA-Group=0&FUA-DownloadFormat=OL&MSignal_UA-Download*=Download';
$result = curl_post($url,$postdata,1,0);

//------------------------------------------------------------------Fastmail END-----------------------------------------------------------------
}


if ($service == "rambler"){

//------------------------------------------------------------------MAIL.RU START-----------------------------------------------------------------
$display_array = array();

$refering_site = "http://rambler.ru/";//setting the site for refer

list($username,$domain) = split('@',$username);

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//setting browser type

$mycookie = $username.'.cookie';
$fh = fopen($mycookie,'w');
fclose($fh);

$path_to_cookie = realpath("$mycookie");
$setcookie = fopen($path_to_cookie,'wb');//this opens the file and resets it to zero length
fclose($setcookie);

//---------------------------------------------------1

$url = "http://rambler.ru";
$page_result = curl_get($url,1,0);

//---------------------------------------------------2

$url = 'http://mail.rambler.ru/script/auth.cgi';

$postdata = 'domain=rambler.ru&url=7&login='.$username.'&passw='.$password.'&long_session=on';
$page_result = curl_post($url,$postdata,1,0);

//---------------------------------------------------3

$url = 'http://mail.rambler.ru/mail/contacts.cgi?mode=popup;1e59';
$page_result = curl_get($url,1,0);
preg_match_all("/add_email\(\'(.*?)&lt;(.*?)&gt;/", $page_result, $matches, PREG_SET_ORDER);
@unlink ($path_to_cookie);
//------------------------------------------------------------------MAIL.RU END-----------------------------------------------------------------
}
?>