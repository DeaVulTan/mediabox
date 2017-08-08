<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please contact me if you need any such web-based information system
 * my  email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
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
				if($fireForm->setEdit(intval($_POST['form_id'])) !== false)
				{
					if(!empty($_POST['post_action']))
					{
						switch ($_POST['post_action'])
						{
							case 'save_form':
								if($fireForm->save($_POST))
								{
									$info['formInfo'] = $fireForm->get();
								}else
								{
									$msg->setErrMsg(ERR_FAILED_TO_SAVE_FROM);
								}
								//save the form information changes
								break;
							case 'save_question':
								if(empty($_POST['question_type']))
								{
									$msg->setErrMsg(ERR_Q_QUESTION_TYPE_EMPTY);
								}elseif(!preg_match('/^[a-zA-Z_]+$/', $_POST['question_type']))
								{
									$msg->setErrMsg(ERR_Q_QUESTION_TYPE_INVALID);
								}elseif(!file_exists(DIR_QUESTION_FF  . $_POST['question_type'] . DIRECTORY_SEPARATOR . 'class.' . $_POST['question_type'] . '.php'))
								{
									$msg->setErrMsg(ERR_Q_QUESTION_TYPE_NOT_FOUND);
								}else
								{
									include_once(DIR_QUESTION_FF . $_POST['question_type'] . DIRECTORY_SEPARATOR .  'class.' . $_POST['question_type'] . '.php');
									$question = new $_POST['question_type']();
									$question->setFormId($fireForm->getId());
									$questionInfo = $question->get($_POST['id']);

									if($questionInfo === false)
									{
										$msg->setErrMsg(ERR_DB_RETRIEVE_Q_FAILED);
									}elseif(empty($questionInfo))
									{
										$msg->setErrMsg(ERR_DB_RETRIEVE_Q_DENIED);
									}elseif(!$question->save($_POST))
									{

										$msg->setErrMsg(ERR_DB_SAVE_Q_FAILED);
									}else
									{
										$info['questionInfo'] = $question->get($_POST['id']);
									}



								}
								break;
							case 'delete_question':
							   	$query = "DELETE FROM " . TBL_INFO . " WHERE question_id IN (" . $db->quote(isset($_POST['question_id'])?$_POST['question_id']:0, 'integer').')';
								$result = $db->query($query);
								if(PEAR::isError($result))
								{
									$msg->setErrMsg(ERR_DB_DELETE_Q_FAILED);
								}
								$query = "DELETE FROM " . TBL_QUESTION . " WHERE id=" . $db->quote(isset($_POST['question_id'])?$_POST['question_id']:0, 'integer');
								$result = $db->query($query);
								if(PEAR::isError($result))
								{
									$msg->setErrMsg(ERR_DB_DELETE_Q_FAILED);
								}
								break;
							case 'add_question':
								if(empty($_POST['question_type']))
								{
									$msg->setErrMsg(ERR_Q_QUESTION_TYPE_EMPTY);
								}elseif(!preg_match('/^[a-zA-Z_]+$/', $_POST['question_type']))
								{
									$msg->setErrMsg(ERR_Q_QUESTION_TYPE_INVALID);
								}elseif(!file_exists(DIR_QUESTION_FF  . $_POST['question_type'] . DIRECTORY_SEPARATOR . 'class.' . $_POST['question_type'] . '.php'))
								{

									$msg->setErrMsg(ERR_Q_QUESTION_TYPE_NOT_FOUND);
								}else
								{
									$relativeTo = empty($_POST['relative_to']) || $_POST['relative_to'] != 'question'?'form':$_POST['relative_to'];
									$position = (!empty($_POST['position'])?$_POST['position']:'after');
									$relativeValue = (!empty($_POST['relative_value'])?intval($_POST['relative_value']):0);
									include_once(DIR_QUESTION_FF . $_POST['question_type'] . DIRECTORY_SEPARATOR .  'class.' . $_POST['question_type'] . '.php');
									$question = new $_POST['question_type']();
									$question->setFormId($fireForm->getId());
									if(($questionId = $question->add( $relativeTo, $position, $relativeValue)) === false)
									{
										$msg->setErrMsg(ERR_DB_CREATE_Q_FAILED);
									}else
									{
										$info['html'] = $question->getUpdateHTML($questionId);
										$info['question_info'] = $question->get($questionId);
										$info['question_id'] = $questionId;
									}


								}
								break;
							case 'reorder_question':

								if(empty($_POST['questions']) || !is_array($_POST['questions']))
								{
									$msg->setErrMsg(ERR_Q_QUESTIONS_EMPTY);
								}else
								{
						 			$result = $db->beginTransaction();
							 		if ($db->inTransaction() && $db->supports('savepoints'))
							 		{

								 		$savepoint = 'recorder_question';
							    		$result = $db->beginTransaction($savepoint);
										if(PEAR::isError($result))
										{
											$msg->setErrMsg(ERR_DB_UNEXPECTED);
											break;
										}
										$query = "LOCK TABLES " . TBL_QUESTION . " write";
							    		$result = $db->query($query);
										if(PEAR::isError($result))
										{
											$db->rollback($savepoint);
								    		$result = $db->query("UNLOCK TABLES");
											$msg->setErrMsg(ERR_DB_UNEXPECTED);
											break;
										}
										/**
										 * check if any questions in the form but not existed in the posted back question list
										 */
										$questions = $fireForm->getQuestions();
										if(is_array($questions))
										{
											if(sizeof($questions) == sizeof($_POST['questions']))
											{
												foreach ($questions as $qId=>$question)
												{
													if(array_search($qId, $_POST['questions']) === false)
													{
														$db->rollback($savepoint);
														$result = $db->query("UNLOCK TABLES");
														$msg->setErrMsg(ERR_Q_QUESTIONS_NOT_MATCHED);
														break;
													}
												}
												//start reordering the questions

												foreach ($_POST['questions'] as $no=>$qId)
												{
													$query = "UPDATE " . TBL_QUESTION . " SET order_no =" . $db->quote($no, 'integer') . " WHERE id=" . $db->quote($qId, 'integer') . " AND form_id=" . $db->quote($fireForm->getId(), 'integer');
													$result = $db->query($query);
													if(PEAR::isError($result))
													{
														$db->rollback($savepoint);
														$result = $db->query("UNLOCK TABLES");
														$msg->setErrMsg(ERR_DB_UNEXPECTED);
														break;
													}
												}

											}else
											{
												$db->rollback($savepoint);
												$result = $db->query("UNLOCK TABLES");
												$msg->setErrMsg(ERR_Q_QUESTIONS_NOT_MATCHED);
												break;
											}
										}else
										{
											$db->rollback($savepoint);
											$result = $db->query("UNLOCK TABLES");
											$msg->setErrMsg(ERR_Q_QUESTIONS_BLANK);
											break;
										}

										if(!$msg->isErrExist())
										{
											$result = $db->commit();
											if(PEAR::isError($result))
											{
												$db->rollback($savepoint);
												$result = $db->query("UNLOCK TABLES");
												$msg->setErrMsg(ERR_DB_UNEXPECTED);
												break;
											}
											$result = $db->query("UNLOCK TABLES");
										}


							 		}

								}

								break;
						}
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


