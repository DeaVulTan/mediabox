<?php

require_once('../../common/configs/config.inc.php');

include('openinviter.php');
$CFG['html']['header'] = 'general/html_header_no_header.php';
$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;

$CFG['html']['is_use_header'] = false;

require($CFG['site']['project_path'].'common/application_top.inc.php');

class index extends FormHandler
	{
	}

$index = new index();
$inviter = new OpenInviter();
$oi_services=$inviter->getPlugins();
if (isset($_POST['provider_box']))
	{
		if (isset($oi_services['email'][$_POST['provider_box']])) $plugType='email';
		elseif (isset($oi_services['social'][$_POST['provider_box']])) $plugType='social';
		else $plugType='';
	}
else $plugType = '';
function ers($ers)
	{
		if (!empty($ers))
			{
				$contents="<div class='clsImportContactError'><table align='center'><tr><td valign='middle'></td><td>";
				foreach ($ers as $key=>$error)
					$contents.="{$error} ,&nbsp;&nbsp;";
				$contents.="</td></tr></table></div><br >";
				return $contents;
			}
	}

function oks($oks)
	{
		if (!empty($oks))
			{
				$contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center' class='clsImportContactsTable'><tr><td valign='middle' valign='middle' class='tbInfoMsg'><img src='/images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
				foreach ($oks as $key=>$msg)
					$contents.="{$msg} ,&nbsp;&nbsp;";
				$contents.="</td></tr></table><br >";
				return $contents;
			}
	}

if (!empty($_POST['step'])) $step=$_POST['step'];
else $step='get_contacts';

$ers=array();$oks=array();$import_ok=false;$done=false;
if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		if ($step=='get_contacts')
			{
				if (empty($_POST['email_box']))
					$ers['email']="Email missing";
				if (empty($_POST['password_box']))
					$ers['password']="Password missing";
				if (empty($_POST['provider_box']))
					$ers['provider']="Provider missing";
				if (count($ers)==0)
					{
					$inviter->startPlugin($_POST['provider_box']);
					$internal=$inviter->getInternalError();
					if ($internal)
						$ers['inviter']=$internal;
					elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
						{
						$internal=$inviter->getInternalError();
						$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later");
						}
					elseif (false===$contacts=$inviter->getMyContacts())
						$ers['contacts']="Unable to get contacts.";
					else
						{
						$import_ok=true;
						$step='send_invites';
						$_POST['oi_session_id']=$inviter->plugin->getSessionID();
						$_POST['message_box']='';
						}
					}
			}
		elseif ($step=='send_invites')
			{
				if (empty($_POST['provider_box'])) $ers['provider']='Provider missing';
				else
					{
						$inviter->startPlugin($_POST['provider_box']);
						$internal=$inviter->getInternalError();
						if ($internal) $ers['internal']=$internal;
						else
							{
								if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing';
								if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session';
								if (empty($_POST['message_box']) and isset($_POST['message_box']))
									$ers['message_body']='Message missing';
								else
									$_POST['message_box']=strip_tags($_POST['message_box']);
								$selected_contacts=array();$contacts=array();
								$message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\n\rAttached message: \n\r".$_POST['message_box']);
								if ($inviter->showContacts())
									{
									foreach ($_POST as $key=>$val)
										if (strpos($key,'check_')!==false)
											$selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
										elseif (strpos($key,'email_')!==false)
											{
											$temp=explode('_',$key);$counter=$temp[1];
											if (is_numeric($temp[1])) $contacts[$val]=$_POST['name_'.$temp[1]];
											}
									if (count($selected_contacts)==0) $ers['contacts']="You haven't selected any contacts to invite";
									}
							}
					}
				if (count($ers)==0)
					{
						$sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$selected_contacts);
						$inviter->logout();
						if ($sendMessage===-1)
							{
							$message_footer="\r\n\r\nThis invite was sent using OpenInviter technology.";
							$message_subject=$_POST['email_box'].$message['subject'];
							$message_body=$message['body'].$message['attachment'].$message_footer;
							$headers="From: {$_POST['email_box']}";
							foreach ($selected_contacts as $email=>$name)
								mail($email,$message_subject,$message_body,$headers);
							$oks['mails']="Mails sent successfully";
							}
						elseif ($sendMessage===false)
							{
							$internal=$inviter->getInternalError();
							$ers['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
							}
						else $oks['internal']="Invites sent successfully!";
						$done=true;
					}
			}
	}
else
	{
	$_POST['email_box']='';
	$_POST['password_box']='';
	$_POST['provider_box']='';
	}

/*$contents="<script type='text/javascript'>
	function toggleAll(element)
	{
	var form = document.forms.openinviter, z = 0;
	for(z=0; z<form.length;z++)
		{
		if(form[z].type == 'checkbox')
			form[z].checked = element.checked;
	   	}
	}
</script>";*/
$index->includeHeader();
$contents = "";
$contents.="
<div class='clsPopUpBox-heading-tlc'>
    <div class='clsPopUpBox-heading-trc'>
    	<div class='clsPopUpBox-heading-tb'>
			<h2>Import Contacts</h2>
		</div>
	</div>
</div>
<div class='clsPopUpBox-lb'>
  <div class='clsPopUpBox-rb'>
    <div class='clsPopUpBox-blc'>
      <div class='clsPopUpBox-brc'>
        <div class='clsPopUpBox-bb'>
          <div class='clsPopUpBoxContent'> 
		   <div class='clsPopUpBoxInviterContent'>        
            <div class='clsOpenInviterForm' id='selOpenInviterScroll'>
<form action='' method='POST' name='openinviter'>".ers($ers).oks($oks);
if (!$done)
	{
	if ($step=='get_contacts')
		{
		$contents.="<div class='clsImportContactsTableContainer'><table class='clsImportContactsTable clsImportContactsTableBorder' cellspacing='0' cellpadding='0' style='border:none;'>
			<tr class='thTableRow'><td align='right'><label for='email_box'>Email</label></td><td><input class='thTextbox' type='text' name='email_box' value='{$_POST['email_box']}'></td></tr>
			<tr class='thTableRow'><td align='right'><label for='password_box'>Password</label></td><td><input class='thTextbox' type='password' name='password_box' value='{$_POST['password_box']}'></td></tr>
			<tr class='thTableRow'><td align='right'><label for='provider_box'>Email provider</label></td><td><select class='thSelect' name='provider_box'>";
		$link = "<a href=".$CFG['site']['url']."OpenInviter/outlook.php>Outlook</a>";
		foreach ($oi_services as $type=>$providers)
			{
			//$contents.="<option disabled>".$inviter->pluginTypes[$type]."</option>";
			foreach ($providers as $provider=>$details)
				$contents.="<option value='{$provider}'".($_POST['provider_box']==$provider?' selected':'').">{$details['name']}</option>";
			}

		//$contents.="</select> &nbsp;(Or)&nbsp;".$link." </td></tr>
		$contents.="</select></td></tr>
			<tr class='thTableImportantRow'><td></td><td align='center'> <div class='clsSubmitLeft'><div class='clsSubmitRight'><input class='thButton' type='submit' name='import' value='Import Contacts'></div></div></td></tr>
		</table></div><input type='hidden' name='step' value='get_contacts'>";
		}
	/*else
		$contents.="<table class='thTable' cellspacing='0' cellpadding='0' style='border:none;'>
				<tr class='thTableRow'><td align='right' valign='top'><label for='message_box'>Message</label></td><td><textarea rows='5' cols='50' 											name='message_box' class='thTextArea' style='width:300px;'>{$_POST['message_box']}</textarea></td></tr>
				<tr class='thTableRow'><td align='center' colspan='2'><input type='submit' name='send' value='Send Invites' class='thButton' ></td></tr>
			</table>";*/
	}

if (!$done)
	{
	if ($step=='send_invites')
		{
		if ($inviter->showContacts())
			{
			$counter = 0;
			$contents.="<table class='clsImportContactsTable clsImportContactsTableBorder'><tr><th class='thTableHeader' colspan='".($plugType=='email'? "3":"2")."'>Your contacts</th></tr>";
			if (count($contacts)==0)
				$contents.="<tr class='thTableOddRow'><td colspan='".($plugType=='email'? "3":"2")."'>You do not have any contacts in your address book.</td></tr>";
			else
				{
				$contents.="<tr class='thTableDesc'><th class='clsCheckListBox'><input type='checkbox' onclick='toggleAll(this)' name='toggle_all' title='Select/Deselect all' checked></th><th class='clsName'>Name</th>".($plugType == 'email' ?"<th class='clsEmail'>E-mail</th>":"")."</tr>";
				$odd=true;
				foreach ($contacts as $email=>$name)
					{
					$counter++;
					if ($odd) $class='thTableOddRow'; else $class='thTableEvenRow';
					$contents.="<tr class='{$class}'><td class='clsCheckListBoxData'><input name='check_{$counter}' id='check_{$counter}' value='{$counter}' type='checkbox' class='thCheckbox' checked><input type='hidden' id='email_{$counter}' name='email_{$counter}' value='{$email}'><input type='hidden' name='name_{$counter}' value='{$name}'></td><td class='clsNameData'>{$name}</td>".($plugType == 'email' ?"<td class='clsEmailData'>{$email}</td>":"")."</tr>";
					$odd=!$odd;
					}
				$contents.="<tr class='thTableFooter'><td colspan='".($plugType=='email'? "3":"2")."' style='padding:3px;'><div class='clsSubmitLeft'><div class='clsSubmitRight'><input type='button' name='send' value='Select invites' class='thButton' onClick='selectedEmailId()'></div></div></td></tr>";
				}
			$contents.="</table>";
			}
		$contents.="<input type='hidden' name='step' value='send_invites'>
			<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
			<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
			<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>
			<input type='hidden' name='counter' value='".$counter."'>";
		}
	}
$contents.="</form></div></div></div></div></div></div></div></div>";
echo $contents;
?>
<script language="javascript" type="text/javascript">
	function bachUrl()
		{
			window.location ='<?php echo 'openinviterIndex.php'?>';
		}
	function toggleAll(element)
		{
			var form = document.forms.openinviter, z = 0;
			for(z=0; z<form.length;z++)
				{
					if(form[z].type == 'checkbox')
						form[z].checked = element.checked;
				}
		}
	function selectedEmailId()
		{
			var val="";
			for(n=1;n<=document.openinviter.counter.value;n++)
				{
					var strVal = 'email_' + n;
					var strchkVal = 'check_' + n;


					if( document.getElementById(strchkVal).checked ==true)
						{
							val +=document.getElementById(strVal).value + ',' ;
						}
				}

			if(val)
				val = val.substring(0, val.length-1);

			if(val == '')
				{
					alert('please select your contact list');
					return false;
				}
			else
				{
					//window.opener.document.form_contactus_show.to_emails.value += val;
					parent.document.form_contactus_show.to_emails.value += val;
					alert('successfully! imported your contact list');
				}
			//window.close();
			 parent.$Jq.fancybox.close();
		}
</script>
<?php
$index->includeFooter();
?>

<script type="text/javascript">
	$Jq('#selOpenInviterScroll').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true});
</script>
