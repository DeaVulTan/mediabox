<?php
/**
 * FireForm  is a web based form builder enpowed by jquery javascript library and PHP
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
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'config.admin.php');
	if(!empty($_GET['id']))
	{

		if($fireForm->set(intval($_GET['id'])) !== false)
		{
		?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title><?php echo $fireForm->getInfo('title'); ?></title>
					<?php
						echo $fireForm->getCSS();
					?>

				</head>
				<body>
					<div id="wrapper">
						<?php
							echo $fireForm->getHtml();
						?>
					</div>
				<?php


					echo $fireForm->getJS();
					echo HTML_AJAX_WINDOW;
				?>

				</body>
			</html>
		<?php
		}else
		{
			$msg->setErrMsg(ERR_FORM_NOT_FOUND);
		}

	}else
	{
		$msg->setErrMsg(ERR_FORM_NOT_SPECIFIED);
	}

	$msg->shownError();