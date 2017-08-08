<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please contact me if you need any such web-based information system
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 *
 *
 */
	/**
	 * print out all item in the array
	 *
	 * @param array $ary
	 * @param string $dieMessage the script will die and print out this message if any
	 */
	function displayArray($ary, $dieMessage=null)
	{
		echo "<pre>";
		print_r($ary);
		echo "</pre>";
		if(!is_null($dieMessage))
		{
			die($dieMessage);
		}
	}
	function getIP()
	{
		if(!empty($_SERVER["HTTP_CLIENT_IP"]))
		$cip = $_SERVER["HTTP_CLIENT_IP"];
		else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else if(!empty($_SERVER["REMOTE_ADDR"]))
		$cip = $_SERVER["REMOTE_ADDR"];
		else
		$cip = "Unkown";
		return $cip;
	}

 	 /**
 	  * clear up file name
 	  *
 	  * @param string $string
 	  * @return string
 	  */
 	 function clearFileName($string)
 	 {
 	 	return preg_replace('/[^0-9\-_\w]/', '', $string);
 	 }
	/**
	 * get a file extension
	 *
	 * @param string $fileName the path to a file or just the file name
	 */
	function getFileExt($fileName)
	{
		return strtolower(substr(strrchr($fileName, "."), 1));
	}

	/**
	 * get file base name without the dot and the file extension
	 *
	 * @param string $fileName
	 * @return string
	 */
	function getFielBaseName($fileName)
	{

		$fileName = basename($fileName);
		$dotIndex = strrpos($fileName, '.');
		$fileExtension = '';
		$fileBaseName = '';
		if(is_int($dotIndex))
		{
			$fileExtension = substr($fileName, $dotIndex);
			$fileBaseName = substr($fileName, 0, $dotIndex);
		}else
		{
			$fileBaseName = $fileName;
		}
		return $fileBaseName;
	}
	/**
	 * permanently redirect to the specified url
	 *
	 * @param string $url
	 */
	function redirect($url, $permanently=false)
	{
		if($permanently)
		{
			header("HTTP/1.1 301 Moved Permanently");
		}

		header("Location: " . $url);
		exit;
	}

	/**
	 * private use for stripEmail
	 *
	 * @param string $emails
	 * @return string
	 */
	function __encryptEmail($emails) {
		if(is_array($emails)) {
			$string = 'document.write(\'' . $emails[0] . '\');';
			$js_encode = '';
			for ($x=0; $x < strlen($string); $x++) {
				$js_encode .= '%' . bin2hex($string[$x]);
			}
			return '<script type="text/javascript">eval(unescape(\''.$js_encode.'\'))</script>';
		}
	}

	/**
	 * replace the plain email addresses with binary codes
	 *
	 * @param string $content
	 * @return string
	 */
	function stripEmail($content) {
		$emailLinkPattern = "/<a[^>]*?href=\"mailto:[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+\"[^>]*?>.*?<\/a>/";
		return preg_replace_callback($emailLinkPattern, "__encryptEmail", stripslashes($content));;
	}




	/**
	 * check spam
	 *
	 * @param array $spammed_field
	 */
	function spamcheck($spammed_field)
	{
		$spammed_field=strtolower($spammed_field);
		if((eregi("cc: ",$spammed_field))||(eregi("subject: ",$spammed_field)))
		{
			$spamhost=$_SERVER['REMOTE_HOST'];
			$spamrefr=$_SERVER['HTTP_REFERER'];
			$spamaddr=$_SERVER['HTTP_X_FORWARDED_FOR'];
			if(strlen($spamaddr)<7) { $spamaddr=$_SERVER['HTTP_CLIENT_IP']; }
			if(strlen($spamaddr)<7) { $spamaddr=$_SERVER['REMOTE_ADDR']; }
			$thisfile=$_SERVER['SCRIPT_NAME'];
			$spamtext="FILE: $thisfile \nFROM: $spamrefr \nADDR: $spamaddr \nHOST: $spamhost \nINFO:\n$spammed_field\n";
			die();
		}
	}

/**
 * send email
 *
 * @param string $to recipient's email address
 * @param string $from send's email address
 * @param string $returnPath the email address receive the feedback when the email failed to be sent
 * @param string $subject
 * @param string $body
 * @param string $htmlBody
 * @return boolean
 */
function sendEmail($to, $from, $returnPath, $subject, $body, $htmlBody="", $attachments = array(), $cc = null)
{

	if(strpos($_SERVER['HTTP_HOST'], 'dev3.') === false)
	{
	  	include_once("Mail.php");
		$mail_to = $to;
		$mail_from = $from;
		$mail_return_path = $returnPath;
		$mail_subject = $subject;
		$headers['From']    = $mail_from;
		$headers['Return-Path']    = $mail_return_path;
		$headers['To']      = $mail_to;
		$headers['Subject'] = $mail_subject;
		if(!is_null($cc))
		{
			$headers['Cc'] = $cc;
		}

		if(!empty($htmlBody) || sizeof($attachments))
		{
			include_once('Mail/mime.php');
			$mime = new Mail_mime("\n");

			$mime->setTXTBody($body);
			$mime->setHTMLBody($htmlBody);

		   foreach($attachments as $attachment)
		   {
		   	if(is_array($attachment))
		   	{
		   		$args = array_values($attachment);
		   		$fileName = isset($attachment[0])?$attachment[0]:'';
		   		$mimeContentType = isset($attachment[1])?$attachment[1]:@mime_content_type($fileName);
		   		$fileNameToShowUp = isset($attachment[2])?$attachment[2]:'';
		   		$isFile = isset($attachment[3])?$attachment[3]:true;
		   		$encoding = isset($attachment[4])?$attachment[4]:'base64';
		   		$mime->addAttachment($fileName, $mimeContentType, $fileNameToShowUp, $isFile, $encoding);
		   	}else
		   	{
		   		$mime->addAttachment($attachment);
		   	}

		   }
			$mail_body = $mime->get();
			$headers = $mime->headers($headers);
		}
		else
		{
			$mail_body = $body;
		}
		// Setup the headers, body of the message:
		$recipients = array('To' => $mail_to);

		// Setup the Params for the SMTP:
		$params["host"] = $GLOBALS['emailServer']["ip"];
		$params["port"] = $GLOBALS['emailServer']["port"];
		$params["auth"] = $GLOBALS['emailServer']["auth"];
		$params["username"] = $GLOBALS['emailServer']["username"];
		$params["password"] = $GLOBALS['emailServer']["password"];

		// Create the mail object using the Mail::factory method
		$mail_object =& Mail::factory('smtp', $params);
		$result = $mail_object->send($recipients, $headers, $mail_body);
		return ($result === true?true:false);
	}else
	{
		return false;
	}


}


/**
 * return true when the email address is valid
 *
 * @param string $email
 * @return boolean
 */
function validateEmail($email)
{
	$email = trim($email);
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $email))
	{
		return false;
	}
	return true;
}




/**
 * append a Query String to the specific url
 *
 * @param string $url
 * @param string $appending
 * @return string
 */
	function appendUrl($url, $appending)
	{
		if($appending != '')
		{
			if(strpos($url, "?") === false)
			{
				$url .= "?" . $appending;
			}
			else
			{
				$url .= "&" . $appending;
			}
		}

		return $url;
	}



	/**
	 * recursively add slashes
	 *
	 * @param mixed $inputs
	 */
	function add_slashes($inputs)
	{
		if(is_array($inputs))
		{
			foreach ($inputs as $k=>$v)
			{
				$inputs[$k]  = add_slashes($v);
			}
		}else
		{
			$inputs = addslashes($inputs);
		}
		return $inputs;
	}
	/**
	 * get the current Url but not the query string specified in $excls
	 *
	 * @param array $excls specify those unwanted query string
	 * @return string
	 */
	function getCurrentUrl2($excls)
	{
		$output = $_SERVER['PHP_SELF'];
		$count = 1;
		foreach($_GET as $k=>$v)
		{
			if(array_search($k, $excls) ===false)
			{
				$strAppend = "&";
				if($count == 1)
				{
					$strAppend = "?";
					$count++;
				}
				$output .= $strAppend . $k . "=" . $v;
			}
		}
		return $output;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ary
	 * @param unknown_type $excludePHPSELF
	 * @return unknown
	 */
	function appendQueryString($ary, $excludePHPSELF=true)
	{
		$d = $_GET;
		$output= "";
		foreach($ary as $k=>$v)
		{
			$d[$k] = $v;
		}
		$count = 1;
		foreach($d as $k=>$v)
		{
			if($count == 1)
			{
				$output .= "?" . $k . "=" . $v;
			}else
			{
				$output .= "&" . $k . "=" . $v;
			}
			$count++;
		}
		if(!$excludePHPSELF )
		{
			$output = $_SERVER['PHP_SELF'] . $output;
		}
		return $output;
	}

	function appendCurrentQueryString($excls=array(), $appendQueryString ='')
	{
		$output = $_SERVER['PHP_SELF'];
		$count = 1;
		foreach($_GET as $k=>$v)
		{
			if(array_search($k, $excls) ===false)
			{
				$strAppend = "&";
				if($count == 1)
				{
					$strAppend = "?";
					$count++;
				}
				$output .= $strAppend . $k . "=" . $v;
			}
		}
		if($appendQueryString != '')
		{
			if(strpos($output, "?") === false)
			{
				$output .= "?" . $appendQueryString;
			}
			else
			{
				$output .= "&" . $appendQueryString;
			}
		}


		return $output;
	}
	function appendUrlExc($excls=array(), $appendQueryString ='')
	{
		$output = $_SERVER['PHP_SELF'];
		$count = 1;
		foreach($_GET as $k=>$v)
		{
			if(array_search($k, $excls) ===false)
			{
				$strAppend = "&";
				if($count == 1)
				{
					$strAppend = "?";
					$count++;
				}
				$output .= $strAppend . $k . "=" . $v;
			}
		}
		if($appendQueryString != '')
		{
			if(strpos($output, "?") === false)
			{
				$output .= "?" . $appendQueryString;
			}
			else
			{
				$output .= "&" . $appendQueryString;
			}
		}


		return $output;
	}
	/**
	 * get the found rows after a specific select query
	 *
	 * @return integer
	 */
	function getFoundRows()
	{
		global $db;
		$output = 0;
		$query = "SELECT FOUND_ROWS() `total_items`;";
		if(($result = $db->query($query)) && $db->numrows($result))
		{
			$row = $db->fetchrow($result);
			$output = intval($row['total_items']);
		}
		return $output;


	}
	/**
	 * write data to the specified file, by default the file is debug.php under inc folder
	 *
	 * @param string $info
	 * @param string $filePath
	 */
	function writeData($info = '', $filePath='')
	{
		if(empty($info))
		{
			$info = @ob_get_flush();
		}
		if(empty($filePath))
		{
			$filePath = dirname(__FILE__) . "/debug.php";
		}
		$infoHeader = '';
		$infoHeader .= "<?php die('Permission denied.');  ?>\n";
		$infoHeader .= 'Generated at ' . date('d/M/Y H:i:s') . "\n\n\n";
		$info = $infoHeader . $info;
		$fp = @fopen($filePath, 'w+');
		if($fp)
		{
			@fwrite($fp, $info , strlen($info));
			@fclose($fp);
		}

	}

	/**
	 * Limit the number of words
	 *
	 * @param string $string the original source string
	 * @param integer $length
	 * @param string $ellipsis
	 * @return string
	 */
    function wordLimit($string, $length = 50, $ellipsis = "...")
    {
    	$string = preg_replace("/[ ]{2,}/",' ', $string);
    	$words = explode(' ', $string);
    	if (count($words) > $length)
    		return implode(' ', array_slice($words, 0, $length)) . $ellipsis;
    	else
    		return $string;
    }
    /**
     * transform string to float value
     *
     * @param string $value
     * @param integer $decimals
     * @return float
     */
    function floatValue($value, $decimals=2)
    {
    	return (number_format(preg_replace("/[^0-9.]/", '', $value), $decimals, '.', ''));
    }
    /**
     * check if https protocol has been used
     * @return boolean
     */
    function isHttps()
    {
    	IF(!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off' )
    	{
    		return true;
    	}else
    	{
    		return false;
    	}
    }
/**
 * replace slash with backslash
 *
 * @param string $value
 * @return string
 */
function slashToBackslash($value) {
	return str_replace("/", DIRECTORY_SEPARATOR, $value);
}

/**
 * replace backslash with slash
 *
 * @param string $value
 * @return string
 */
function backslashToSlash($value) {
	return str_replace(DIRECTORY_SEPARATOR, "/", $value);
}

/**
 * removes the trailing slash
 *
 * @param string $value
 * @return string
 */
function removeTrailingSlash($value) {
	if(preg_match('@^.+/$@i', $value))
	{
		$value = substr($value, 0, strlen($value)-1);
	}
	return $value;
}

/**
 * append a trailing slash
 *
 * @param string $value
 * @return string
 */
function addTrailingSlash($value) {
	if(preg_match('@^.*[^/]{1}$@i', $value))
	{
		$value .= '/';
	}
	return $value;
}




/**
 * get the specified long trailling string
 *
 * @param string $str the original string
 * @param integer $strLen the specified length
 * @return string
 */
function getTraillingString($str, $strLen = 32)
{
	return (strlen($str) > $strLen)?substr($str, strlen($str) - $strLen, $strLen):$str;
}
/**
 * get the begining string after removing the specified long trailling string
 *
 * @param string $str the original string
 * @param integer $TraillingStringLen the length of trailling string will be removed
 * @return string
 */
function getBeginingStringExtractingTraillingString($str, $TraillingStringLen = 32)
{
	return (strlen($str) > $TraillingStringLen?substr($str,0, strlen($str) - 32):'');
}



	/**
	 * generate a randon password
	 *
	 * @param integer $leng
	 * @param integer $type
	 * @return string
	 */
	function randPwd($leng=10, $type=1)
	{
		$outputs = array();
		$seeds = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		switch ($type)
		{
			case 2:
				$seeds = substr($seeds, 0, 10);
				//number only
				break;
			case 3:
				//letters only (case issensitive)
				$seeds = substr($seeds, 10, 26);
				break;
			case 4:
				//letters only (case sensitive)
				$seeds = substr($seeds, 10, 52);
				break;
			case 5:
				//number and letters mixed (case sensitive)
				$seeds = substr($seeds, 0, 62);
				break;
			case 1:
				//number and letters mixed (case insensitive)

			default:
				$seeds = substr($seeds, 0, 36);
		}
		$arySeeds = array();
		for($i=0; $i < strlen($seeds); $i++)
		{
			$arySeeds[$i] = substr($seeds, $i, 1);
		}
		for($i = 0; $i < strlen($seeds); $i++)
		{
			$outputs .= $arySeeds[array_rand($arySeeds)];
		}
		return $seeds;
	}

	function shownError($error)
	{
		echo '<table cellpadding="0" cellspacing="0" style="width:100%"><tbody><tr><td style="text-align:center; color:red; font-size:24px; padding-top:100px">';
		echo  $error  ;
		echo '</td></tbody></table>';
	}

		/**
		 *  convert orginal html to be json-safe format
		 *
		 * @param string $html
		 * @return string
		 */
		function clearUpJsFunction($html)
		{
			return preg_replace(array('/[ ]+/'), array(' '), str_replace("\n", '', $html));
		}