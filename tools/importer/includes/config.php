<?php
$default_ports = array('https' => 443, 'http' => 80);
$prefix = (!empty($_SERVER['HTTPS']) ? 'https' : 'http');
$host = '';
if (isset($_SERVER['HTTP_HOST'])) //some says that this might not be set in IIS
		$host = $_SERVER['HTTP_HOST'];
	else if (isset($_SERVER['SERVER_NAME']))
		$host = $_SERVER['SERVER_NAME'];
 $site_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://'
                       . $host
                       . str_replace(
					   			$site_url_arr,
					   			'',
								substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1)
							);

 $site_url = substr($site_url,0,strlen($site_url)-1).'/';

///////////////////////////
// WHICH TEMPLATE TO USE //
///////////////////////////

//Enter the name of the theme to use //
// Available options are::
// grad-gray
// blue-sky
// lazy-days
// pretty-pink


$theme_selected = 'lazy-days';


//////////////////////////
///YOUR EMAIL SETTINGS //
//////////////////////////

$html_format = "no";                                         //Change this to "yes" if you are sending html format email

$subject = "Join me at this amazing site!";                  // Subect of the emails sent out

$from = "webmaster@warcrimes.ltd.uk";                           //This is your email address

$redirect = "";    //(optional) Change this to your own thank you type page e.g. "http://www.yoursite.com/thankyou.html"



///////////////////////////
// EMAIL MESSAGE TO SEND //
///////////////////////////

//IMPORTANT -- DO NOT DELETE  <<<EOF  and EOF;

$message = '';/*<<<EOF


Hi $name

Come and join me at this great site that I found

www.warcrimes.tv

From $sendersemail



EOF*/;



///////////////////////
//FOR GODADDY.COM USERS
///////////////////////
$hosted_by_godaddy  = 'no';  //change this to 'yes' if you web host is Godaddy.com







///________________________________________________________DO NOT  EDIT BELOW THIS LINE_______________________________________________________________\\


// NOTES: Only edit this next item you have been asked to do so by our support team
//
// Example      $site_url = 'http://domain.com/importer';
//
// Do not put a trailling forward slash '/' at the end of the url/

$site_url .= 'importer'; //Please read note abvove

$site_url = str_replace('importerimporter','importer',$site_url);



///__________________________________________________________________________________________________________________________________________________\\
error_reporting(0);

function curl_get($url,$follow, $debug){
global $path_to_cookie, $browser_agent;
$ch=curl_init();
if ($hosted_by_godaddy =='yes'){
curl_setopt ($ch, CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
curl_setopt ($ch, CURLOPT_PROXY,"http://proxy.shr.secureserver.net:3128");
}
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch,CURLOPT_COOKIEJAR,$path_to_cookie);
curl_setopt($ch,CURLOPT_COOKIEFILE,$path_to_cookie);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,$follow);
curl_setopt($ch,CURLOPT_USERAGENT, $browser_agent);
$result=curl_exec($ch);
curl_close($ch);

if($debug==1){
echo "<textarea rows=30 cols=120>".$result."</textarea>";
}
if($debug==2){
echo "<textarea rows=30 cols=120>".$result."</textarea>";
echo $result;
}
return $result;
}

function curl_post($url,$postal_data,$follow, $debug){
global $path_to_cookie, $browser_agent;
$ch=curl_init();
if ($hosted_by_godaddy =='yes'){
curl_setopt ($ch, CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
curl_setopt ($ch, CURLOPT_PROXY,"http://proxy.shr.secureserver.net:3128");
}
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$postal_data);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch,CURLOPT_COOKIEJAR,$path_to_cookie);
curl_setopt($ch,CURLOPT_COOKIEFILE,$path_to_cookie);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,$follow);
curl_setopt($ch,CURLOPT_USERAGENT, $browser_agent);
$result=curl_exec($ch);
curl_close($ch);

if($debug==1){
echo "<textarea rows=30 cols=120>".$result."</textarea>";
}
if($debug==2){
echo "<textarea rows=30 cols=120>".$result."</textarea>";
echo $result;
}
return $result;
}


$footer =
'<table border="0" width="12%">
		<tr>
			<td bgcolor="#CCCCCC" width="61">
			<font face="Arial" size="1" color="#333333">Powered
			by</font></td>
			<td bgcolor="#EBEBEB"><font face="Arial" size="1">
			<a href="http://www.getmycontacts.com/"><font color="#333333">GetmyContacts</font></a></font></td>
		</tr>
</table>';


$username = $_POST["username"];

$password = $_POST["password"];

$sendersemail = $username;

$installation_folder = installation_part_url();



//Determine the base url for themes (used in CSS)
$themes_base_url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$installation_folder.'/themes/'.$theme_selected.'/';
$post_url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$installation_folder.'/intelilogin.php';
$base_url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$installation_folder;

//If use has specified then use their url instead.
if($site_url != ''){
$themes_base_url = $site_url.'/themes/'.$theme_selected.'/';
$post_url = $site_url.'/intelilogin.php';
$base_url = $site_url;
}

//redirect
if($redirect == ""){
$redirect = $base_url.'/thankyou.html';
}


//Calculate the folder that importer is installed in

function installation_part_url() { //by BNS - testing
$doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$script_path = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);
$install_folder = str_replace ($doc_root, '', $script_path);
$install_folder = str_replace ('includes', '', $install_folder);
$folder = preg_match ("%/(.*?)/%", $install_folder, $result);
$folder = $result[1];
return $folder;
}

//Debug Check

if($_GET['info'] =='yes'){
echo $themes_base_url;
}

?>