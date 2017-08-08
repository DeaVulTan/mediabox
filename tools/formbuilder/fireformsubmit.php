<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design, 
 * Please contact me if you need any such web-based information system 
 * my email  address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai 
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 * 
 *
 */
	include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'config.admin.php');

	$info = array('error'=>array());
	if(!empty($_POST['form_id']))
	{
		if($fireForm->setSave(intval($_POST['form_id'])) !== false)
		{
			$result = $fireForm->saveQuestionAnswers();
			if($result === true)
			{
				$info['url'] = $fireForm->getInfo('url');
			}elseif($result === false)
			{
				$msg->setErrMsg(ERR_DB_SAVE_ANSWERS_FAILED);
			}elseif(sizeof($result))
			{
				$info['invalid_questions'] = array_keys($result);
				$msg->setErrMsg(ERR_QUESTION_INVALID1);
				$msg->setErrMsg(ERR_QUESTION_INVALID2);
			}

		}else 
		{
			$msg->setErrMsg(ERR_FORM_NOT_FOUND);
		}

	}else 
	{
		$msg->setErrMsg(ERR_FORM_NOT_SPECIFIED);
	}
	if($msg->isErrExist())
	{
		foreach ($msg->getMsg() as $error)
		{
			$info['error'][] = $error;
		}
	}
	echo json_encode($info);
	
	
	