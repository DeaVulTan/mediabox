<?php
require_once('../common/configs/config.inc.php');
$CFG['html']['header'] = 'general/html_header_popup.php';
$CFG['html']['footer'] = 'general/html_footer_popup.php';
$CFG['mods']['is_include_only']['html_header'] = false;

$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');

error_reporting(0);

// GET NETWORK TO IMPORT FROM
class index extends FormHandler
	{
	}

$index = new index();
$get = isset($_GET["domain"])?$_GET["domain"]:'';

if (empty($get)){

	$script = "myhotmail.php";

	$img = "myhotmail.gif";

}else{

$script = $get.'.php';

$img = $get.'.gif';

}
$fname = isset($_GET['fname'])?$_GET['fname']:'to_emails';
$frmname = isset($_GET['frmname'])?$_GET['frmname']:'form_contactus_show';
$vcopy_right_year = $CFG['admin']['coppy_rights_year'];
$vsite_name = $CFG['site']['name'];
$vsite_url = $CFG['site']['url'];
$vall_rights = $LANG['header_all_rights_reserved'];
$vdefault_template = $CFG['html']['template']['default'];
$vdefault_stylesheet = $CFG['html']['stylesheet']['screen']['default'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-Language" content="en-US" />
	<link rel="stylesheet" type="text/css" href="<?php echo $vsite_url."design/templates/".$vdefault_template."/root/css/".$vdefault_stylesheet."/header.css"; ?>" media="screen" title="Default" />
	<link rel="stylesheet" type="text/css" href="<?php echo $vsite_url."design/templates/".$vdefault_template."/root/css/".$vdefault_stylesheet."/layout.css"; ?>" media="screen" title="screen_grey" />
	<link rel="stylesheet" type="text/css" href="<?php echo $vsite_url."design/templates/".$vdefault_template."/root/css/".$vdefault_stylesheet."/common.css"; ?>" media="screen" title="screen_grey" />
	<link rel="stylesheet" type="text/css" href="<?php echo $vsite_url."design/templates/".$vdefault_template."/root/css/".$vdefault_stylesheet."/form.css"; ?>" media="screen" title="screen_grey" />
	<link rel="stylesheet" type="text/css" href="<?php echo $vsite_url."design/templates/".$vdefault_template."/root/css/".$vdefault_stylesheet."/footer.css"; ?>" media="screen" title="Default" />
	<link rel="shortcut icon" href="<?php echo $vsite_url."design/templates/".$vdefault_template."/favicon.ico"; ?>" type="image/x-icon" />

<script language="javascript" src="../js/functions.js">	
</script>
<script language="javascript">	
	/*var fname = '<?php //echo $fname;?>';
	var frmname = '<?php //echo $frmname;?>';
	function addContacts(){
		getCheckBoxValue('myform', 'check_all');
		//alert(multiCheckValue);
		//alert(frmname)
		var obj = eval("window.opener.document."+frmname+"."+fname);
		obj.value += ','+multiCheckValue;
		if(multiCheckValue == '')
			alert('please select your contact list');
		else
			alert('successfully! imported your contact list');
		window.close()
	}
*/
</script>
<SCRIPT LANGUAGE="Javascript">

<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function emailCheck (emailStr) {
/* The following pattern is used to check if the entered e-mail address
   fits the user@domain format.  It also is used to separate the username
   from the domain. */
var emailPat=/^(.+)@(.+)$/
/* The following string represents the pattern for matching all special
   characters.  We don't want to allow special characters in the address. 
   These characters include ( ) < > @ , ; : \ " . [ ]    */
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
/* The following string represents the range of characters allowed in a 
   username or domainname.  It really states which chars aren't allowed. */
var validChars="\[^\\s" + specialChars + "\]"
/* The following pattern applies if the "user" is a quoted string (in
   which case, there are no rules about which characters are allowed
   and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
   is a legal e-mail address. */
var quotedUser="(\"[^\"]*\")"
/* The following pattern applies for domains that are IP addresses,
   rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
   e-mail address. NOTE: The square brackets are required. */
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
/* The following string represents an atom (basically a series of
   non-special characters.) */
var atom=validChars + '+'
/* The following string represents one word in the typical username.
   For example, in john.doe@somewhere.com, john and doe are words.
   Basically, a word is either an atom or quoted string. */
var word="(" + atom + "|" + quotedUser + ")"
// The following pattern describes the structure of the user
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
/* The following pattern describes the structure of a normal symbolic
   domain, as opposed to ipDomainPat, shown above. */
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")


/* Finally, let's start trying to figure out if the supplied address is
   valid. */

/* Begin with the coarse pattern to simply break up user@domain into
   different pieces that are easy to analyze. */
var matchArray=emailStr.match(emailPat)
if (matchArray==null) {
  /* Too many/few @'s or something; basically, this address doesn't
     even fit the general mould of a valid e-mail address. */
	alert("Email address seems incorrect - Please type a valid email address")
	return false
}
var user=matchArray[1]
var domain=matchArray[2]

// See if "user" is valid 
if (user.match(userPat)==null) {
    // user is not valid
    alert("The username doesn't seem to be valid.")
    return false
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
   host name) make sure the IP address is valid. */
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
    // this is an IP address
	  for (var i=1;i<=4;i++) {
	    if (IPArray[i]>255) {
	        alert("Destination IP address is invalid!")
		return false
	    }
    }
    return true
}

// Domain is symbolic name
var domainArray=domain.match(domainPat)
if (domainArray==null) {
	alert("The domain name doesn't seem to be valid.")
    return false
}

/* domain name seems valid, but now make sure that it ends in a
   three-letter word (like com, edu, gov) or a two-letter word,
   representing country (uk, nl), and that there's a hostname preceding 
   the domain or country. */

/* Now we need to break up the domain to get a count of how many atoms
   it consists of. */
var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 || 
    domArr[domArr.length-1].length>3) {
   // the address must end in a two letter or three letter word.
   alert("The address must end in a three-letter domain, or two letter country.")
   return false
}

// Make sure there's a host name preceding the domain.
if (len<2) {
   var errStr="This address is missing a hostname!"
   alert(errStr)
   return false
}

// If we've gotten this far, everything's valid!

return true;
document.emailform.reset();

}
//  End -->
</script>

<script language="javascript1.3" src="js/ahah2.js" ></script>

<style type="text/css">

td.off {
background: #A4A4A4;
}

td.on {
background: #000000;
}

</style>

</head>

<body>
	<!-- starting of clsBodyContent -->
	<div class="clsBodyContent">
	<!-- starting of clsInnerBodyContent -->
	<div class="clsInnerBodyContent">
	<!-- Header -->
		<div id="header">
		  <h1><a><?php echo $vsite_name;?></a></h1>
		</div>
	</div>
	<!-- Main -->
	<div id="selOuterMainContent" class="clsPopUpHeaderContent">
		<br /><br />
    
    <div id="Main-Container">
    <div id="InputBox">
    <center>
    <form name="emailform" enctype="multipart/form-data" id="emailform" action="myoutlook.php"  method="post"> 
    <table class="clsNoBorder">
      <tr>
        <td colspan="2"><h2>INVITE MY CONTACTS</h2></td>
      </tr>
      <tr>
        <td colspan="2"><font face="Arial" size="1">Outlook CSV <strong style="font-weight: 400">&nbsp;(Limit file size 
        2MB)</strong></font></td>
      </tr>
      <tr>
        <td class="<?php echo $index->getCSSFormLabelCellClass('description');?>"><font face="Arial" size="1">Select File</font></td>
        <td><input name="ufile" type="file" id="ufile" size="28" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" value="Invite My Contacts" class="clsSubmitButton" />
          &nbsp;</td>
      </tr>
    </table>
    </form>
    </center>
    <!-- Footer -->
     <div id="footer">
       <p>&copy; <?php echo $vcopy_right_year; ?> <?php echo $vsite_name;?>. <?php echo $vall_rights?>.</p>
    </div>
        <!-- Ending of clsInnerBodyContent -->
        </div>
        <!-- Ending of clsBodyContent -->
        </div>
</body>
</html>
