<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please  contact me if you need any such web-based information system
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 *
 *
 */

    error_reporting(0);
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'config.admin.php');

	if(!empty($_GET['id']))
	{

				if($fireForm->setEdit(intval($_GET['id'])) !== false)
				{
				?>
							<?php
								echo $fireForm->getCSS();
							?>
							<div id="wrapper">
								<?php
									echo $fireForm->getHtml();
								?>

							<div id="wrapper">
								<div id="fireFormPanerContainer">
                                	<div id="fireFormQuestionPanel" >
											<table cellpadding="0" cellspacing="0" class="firmFromPanelTable clsFireFormTable">
												<thead>
													<tr>
														<th><?php echo PANEL_MENU_QUESTIION; ?></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
										<ul id="fireFormQBtnAdd" class="fireFormButtons">
											<?php echo $fireForm->getQuestionAddHtml(); ?>
										</ul></td>
													</tr>
												</tbody>
											</table>


									</div><!--fireFormQuestionPanel ended	-->
									<div id="fireFormPanelMC">
										<div id="fireFormSettingPanel">
											<form id="fireFormfireForm" method="POST" action="<?php echo URL_SITE . 'fireformmanager.php'; ?>">
												<input type="hidden" name="post_action" value="save_form">
												<input type="hidden" name="form_id" value="<?php echo $fireForm->getInfo('id'); ?>">
											</form>
										</div><!--fireFormSettingPanel ended-->


									<?php echo $fireForm->getQuestionSettingHtml(); ?>

							</div><!--fireFormPanelMC ended-->

									</div><!--fireFormPanerContainer ended-->
									<div class="fireFormClear" ></div>
								</div>
							</div><!--fireFormPanel ended-->

						<?php


							echo $fireForm->getJS();
							echo HTML_AJAX_WINDOW;
						?>
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
