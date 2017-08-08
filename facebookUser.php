<?php
/**
 * File to handle the welcome message
 *
 * Using this file if the user signed up by his login detail, by entering some
 * required information the user can get this message.
 *
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		WelcomeFormHandler
 * @author 		karthiselvam_58ag07
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-19
 **/
require_once('./common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'languages/%s/members/facebookUser.php';

$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';

require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');
//-------------------------class WelcomeFormHandler-------------------->>>
/**
 * WelcomeFormHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class WelcomeFormHandler extends FormHandler
	{
		/**
		 * WelcomeFormHandler::getWelcomeContent()
		 *
		 * @param mixed $content
		 * @param mixed $fieldsArr
		 * @return
		 */
		public function getWelcomeContent($content, $fieldsArr)
			{
				$content = nl2br($content);
				$chkArray = array('VAR_GUIDELINES', 'VAR_TERMS_OF_SERVICE', 'VAR_FACEBOOK_MAIL_ALERT', 'VAR_SITE_NAME');
				foreach($chkArray as $value)
					{
						$toReplace = $value;
						if(array_key_exists($value, $fieldsArr))
							$content = str_ireplace($toReplace, $fieldsArr[$value], $content);
						else
							$content = str_ireplace($toReplace, '', $content);
					}
				return $content;
			}
	}
//<<<<<--------------- Class WelcomeFormHandler ends -------------//
//-------------------- Code begins -------------->>>>>//
$welcomefrm = new WelcomeFormHandler();
$welcomefrm->setPageBlockNames(array('form_welcome'));
// Set the form fields
$welcomefrm->setFormField('url', '');
$welcomefrm->setFormField('guide', '');
$welcomefrm->setFormField('terms', '');
$welcomefrm->setFormField('facebook_alert','');
#$ref = $_SERVER['HTTP_REFERER'];
if(isset($_SERVER['HTTP_REFERER']))
	{
		$welcomefrm->setFormField('url', $_SERVER['HTTP_REFERER']);
	}

$welcomefrm->setAllPageBlocksHide();
// default page block. show it. All others hidden

$welcomefrm->sanitizeFormInputs($_REQUEST);

if (strstr($welcomefrm->getFormField('url'), 'login.php') OR strstr($welcomefrm->getFormField('url'), 'login/') or 1)
	{
		$guide = '<a href="'.$CFG['site']['relative_url'].'staticPage.php?pg=privacy'.'" target="_blank">'.$LANG['guidelines'].'</a>';
		$terms = '<a href="'.$CFG['site']['relative_url'].'staticPage.php?pg=terms'.'" target="_blank">'.$LANG['terms_of_service'].'</a>';
		$alert = '<a href="'.$CFG['site']['relative_url'].'profileBasic.php#facebook'.'">'.$LANG['facebook_mail_settings'].'</a>';

		$welcomefrm->setFormField('guide',$guide);
		$welcomefrm->setFormField('terms',$terms);
		$welcomefrm->setFormField('facebook_alert',$alert);
		$welcomefrm->sanitizeFormInputs($_REQUEST);
		$welcomefrm->setPageBlockShow('form_welcome');
	}
else //error in form inputs
	{
		$welcomefrm->setAllPageBlocksHide();
		Redirect2URL($CFG['site']['relative_url']);
	}
//<<<<<------------------- Code ends ----------------------//
//-------------------- Page block templates begins -------------------->>>>>//

if ($welcomefrm->isShowPageBlock('form_welcome'))
	{
		$welcomefrm->form_welcome['welcomemsg']	=	$welcomemsg = str_ireplace('VAR_USERNAME', $CFG['user']['name'], $LANG['welcome_message']);
		$content = $welcomefrm->getWelcomeContent($LANG['welcome_content'], array('VAR_SITE_NAME' =>$CFG['site']['name'], 'VAR_GUIDELINES'=>$welcomefrm->getFormField('guide'), 'VAR_TERMS_OF_SERVICE'=>$welcomefrm->getFormField('terms'),'VAR_FACEBOOK_MAIL_ALERT' =>$welcomefrm->getFormField('facebook_alert'), 'VAR_SITE_NAME'=>$CFG['site']['name']));
		$mail_setting_content = $welcomefrm->getWelcomeContent($LANG['welcome_content_mail_variable'], array('VAR_FACEBOOK_MAIL_ALERT' =>$welcomefrm->getFormField('facebook_alert')));
		$welcomefrm->form_welcome['content']	  =	nl2br($content);
		$welcomefrm->form_welcome['content_mail'] =	nl2br($mail_setting_content);
		$welcomefrm->form_welcome['index_url']	  =	getUrl('index');
	}
//include the header file
$welcomefrm->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('facebookUser.tpl');
//includ the footer of the page
//<<<<<<-------------------- Page block templates ends --------------------//
$welcomefrm->includeFooter();
?>