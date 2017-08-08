<?php
//include("outlook.php");
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

// GET NETWORK TO IMPORT FROM
function getEmailAddress($string)
	{
		$string = trim($string);		
		$str_arr = explode(' ', $string);
		foreach($str_arr as $key=>$value)
			{
				preg_match("/^\S+@\S+\.\S+$/i", $string, $email);
				if(isset($email[0]) and $email[0])
					return $email[0];
			}			
		return false;
	}
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
// START OF FILE UPLOAD AND SECURITY CHECK
$limit_size=2000000; //you can change this to a higher file size limit (this is in bytes = 2MB apprx)
$random = rand(150, 15000); //create random number
$uniquename = $random.$_FILES['ufile']['name']; //add random number to file name to create unique file
$path= "upload/".$uniquename;
$error_msg = '';
if($ufile !=none)
	{
		// Store upload file size in $file_size
		$file_size=$_FILES['ufile']['size'];
		if($file_size >= $limit_size)
			{
				?>
				<p align="center"><font face="Verdana" size="2"><b>Error!:</b> Your file exceeds the allowed size limit.</font></p><p align="center">
				<?php
				exit;
			}
		else
			{
				$filetype = $_FILES['ufile']['type'];
				//echo $filetype;
				if ($filetype=="application/x-csv" || $filetype=="text/csv" || $filetype=="application/vnd.ms-excel")
					{
						//copy file to where you want to store file
						if(copy($_FILES['ufile']['tmp_name'], $path))
							{
							}
						else
							{
								echo "Copy Error";
								exit;
							}
					}
				else
					{
							$error_msg = 'You may only upload csv files.';
					}
			}
	}
$fname = isset($_GET['fname'])?$_GET['fname']:'to_emails';
$frmname = isset($_GET['frmname'])?$_GET['frmname']:'form_contactus_show';	
$vcopy_right_year = $CFG['admin']['coppy_rights_year'];
$vsite_name = $CFG['site']['name'];
$vsite_url = $CFG['site']['url'];
$vall_rights = $LANG['header_all_rights_reserved'];
$vdefault_template = $CFG['html']['template']['default'];
$vdefault_stylesheet = $CFG['html']['stylesheet']['screen']['default'];	
//END OF FILE UPLOAD
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
	var fname = '<?php echo $fname;?>';
	var frmname = '<?php echo $frmname;?>';
	function addContacts(){
		getCheckBoxValue('myform', 'check_all');
		//alert(multiCheckValue);
		//alert(frmname)
		var obj = eval("window.opener.document."+frmname+"."+fname);
		
		if(obj.value == '')
			obj.value = multiCheckValue+',';
		else
			obj.value += ','+multiCheckValue+',';
			
		if(multiCheckValue == '')
			{
				alert('please select your contact list');
				return false;
			}	
		else
			alert('successfully! imported your contact list');
		window.close()
	}
</script>
<script type="text/javascript"><!--
function prepare() 
	{
		formblock= document.getElementById('form_id');
		forminputs = formblock.getElementsByTagName('input');
	}
function select_all(name, value) 
	{
		for (i = 0; i < forminputs.length; i++) 
			{
				// regex here to check name attribute
				var regex = new RegExp(name, "i");
				if (regex.test(forminputs[i].getAttribute('name'))) 
				{
					if (value == '1') 
						{
							forminputs[i].checked = true;
						} 
					else 
						{
							forminputs[i].checked = false;
						}
				}
			}
	}
if (window.addEventListener) 
	{
		window.addEventListener("load", prepare, false);
	} 
else if (window.attachEvent) 
	{
		window.attachEvent("onload", prepare)
	} 
else if (document.getElementById) 
	{
		window.onload = prepare;
	}
//--></script>
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

<div align="center">
<center>
<table border="0" width="578"><tr>
<TD width="622"><IMG height=2 alt="" src="" width=1 border=0></TD>
</tr><tr><TD align=middle width="622"><TABLE cellSpacing=0 cellPadding=0 width=640 border=0>
<TBODY><TR><TD width=5 height=5><IMG height=5 alt="" src="" width=5 border=0></TD>
<TD background="" colSpan=2 width="716"><IMG height=1 alt="" src="" width=1 border=0></TD>
<TD width=6 height=5><IMG height=5 alt="" src="" width=5 border=0></TD></TR><TR>
<TD width=5 background="" height=5><IMG height=5 alt="" src="" width=5 border=0></TD>
<TD width=6><IMG height=1 alt="" src="" width=6 border=0></TD><TD vAlign=top width=704>
<table border="0" width="100%"><tr><td width="100%" bgcolor="#D7D8DF">
<p align="center"><font face="Arial" size="3" color="#333333">My Contacts</font></td></tr></table>
<p align="center">
    <form id="form_id" name="myform" method="post" action="postage.php" onSubmit="return false">
	<div align="center"><center>
<table border="0" cellpadding="3" cellspacing="6" width="100%">
	<tr>
		<th width="22" bgcolor="#F5F5F5"><input type="checkbox" class="clsCheckRadio" name="check_all" onClick="CheckAll(document.myform.name, document.myform.check_all.name)" /></th>
		<!--<th width="22" bgcolor="#F5F5F5">Name</th>-->
		<th width="22" bgcolor="#F5F5F5">Email</th>
	</tr>

<?php
// OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY


		//		$fp = fopen ($username,"r");
				if($error_msg == '')
					{
						$fp = fopen ($path,"r");
							while (!feof($fp))
							{
								$email = fread($fp, 8192); //different csv to lycos and yahoo etc
								IF (empty($email))
									{
										//Skip table	
									}
								ELSE
									{		
												
										IF ($dataname != "First Name")
											{		
												$email_arr = explode(',', $email);
												/*echo '<pre>';
												print_r($email_arr);
												echo '</pre>';		
												die();*/		
												$i=0;				
												foreach($email_arr as $key=>$email)
													{
														$email = getEmailAddress($email);
														if(empty($email))
															{
																continue;
															}
														else
															{
																$i=1;	
															}
			?>
					<tr>
						<td width="22" bgcolor="#F5F5F5"><input type="checkbox" name="list[]" value="<?php echo $email;?>"></td>
						<!--<td width="269" bgcolor="#F5F5F5"><p align="center"><font face="Verdana" size="2"><?php echo $dataname;?></font></td>-->
						<td width="296" bgcolor="#F5F5F5"><p align="center"><font face="Verdana" size="2"><?php echo $email;?></font></td>
					</tr>
			<?php
												}
										}
								}
							
						}
					}	
?>
	</table></center></div>
<table border="0" width="100%"><tr><td width="100%">
<?php if($i==1){?>
<p align="center"><input type="button" value="Add contacts" name="B1" style="background-color: #808080; color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold; border: 1 solid #333333" onClick="addContacts()">&nbsp;

</form></td></tr>
<?php }else{?><p align="center"><font face="Verdana" size="2"><b>Error!:</b>&nbsp;&nbsp;<?php if($error_msg !=''){echo $error_msg;}else {echo 'Sorry! No contact found';} ?></font></p>
			<center><a href="outlook.php"><font face="Verdana" size="2"><b> Back</b></font></a></center>
<?php }?>
</table><IMG height=1 alt="" src="" width=1 border=0></TD>
<TD width=6 background="" height=5><IMG height=1 alt="" src="" width=1 border=0></TD></TR>
<TR><TD width=5 height=5><IMG height=5 alt="" src="" width=5 border=0></TD>
<TD background="" colSpan=2 width="716"><IMG height=1 alt="" src="" width=1 border=0></TD>
<TD width=6 height=5><IMG height=5 alt="" src="" width=5 border=0></TD></TR></TBODY></TABLE></TD>                      </tr></table></center></div></body></html>
<?php			
				@fclose($fp);
				unlink($path) //deleting csv file
?>
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