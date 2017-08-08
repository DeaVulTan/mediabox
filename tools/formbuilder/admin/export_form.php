<?php

	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'config.php');
	include_once(DIR_INC_FF . 'class.fireform.php');	

	 if(!$auth->isLogin())
	 {
	 	$msg->setErrMsg(LOGIN_REQUIRED);
	 }else 
	 {
		if(!empty($_GET['form']) )
		{
			$fireForm = new FireForm();		
			if($fireForm->isPermitted(intval($_GET['form'])))
			{
	
					$fireForm->export($_GET['form'], isset($_GET['startdate'])?$_GET['startdate']:null, isset($_GET['finishdate'])?$_GET['finishdate']:null);
			
			}else 
			{
				die(PERMISSION_DENIED);
			}
	
			
		}else 
		{
			die(ERR_FORM_NOT_SPECIFIED);
		}	 	
	 }


	
	$db->disconnect();
?>
	 