<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design, 
 * Please contact me if you need any such web-based information system 
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai 
 * @package FireForm a  Ajax Form Builder
 * @version 1.0
 * 
 *
 */

	if(!empty($_POST['form_event']))
	{
		if(function_exists($_POST['form_event']))
		{
			$_POST['form_event']();
		}
	}
	
	function login()
	{
		global $msg, $auth;
		if(empty($_POST['username']))
		{
			$msg->setErrMsg(ERR_LOGIN_USERNAME);
		}
		if(empty($_POST['password']))
		{
			$msg->setErrMsg(ERR_LOGIN_PASSWORD);
		}
		if(empty($_SESSION['validate']) || $_SESSION['validate'] != $_POST['validation'])
		{
			$msg->setErrMsg(ERR_LOGIN_VCODE);
		}
		if(!$msg->isErrExist())
		{
			if($auth->processLogin($_POST['username'], $_POST['password']))
			{
				if(isset($_GET['return_path']))
				{
					redirect($_GET['return_path']);
				}else 
				{
					redirect(URL_SITE_ADMIN_INDEX);
				}

			}else 
			{
				$msg->setErrMsg(ERR_LOGIN_FAILED);
			}
		}
		
	}
	
	function logoff()
	{
		global $auth;
		$auth->logout();
		redirect(URL_SITE_ADMIN_LOGIN);
	}