<?php
/**
 * This file is to display profile infomation
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/profileInfo.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_inputfilter_clean.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class EditOtherInfoProfileFormHandler-------------------->>>
/**
 * EditOtherInfoProfileFormHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class EditOtherInfoProfileFormHandler extends FormHandler
	{
	 	/**
	 	 * EditOtherInfoProfileFormHandler::populateHtmlFields()
	 	 *
	 	 * @return
	 	 */
	 	public function populateHtmlFields()
			{
				$sql = 'SELECT pq.id,form_id,question,question_type,rows,order_no,width,instruction,options,answer_required,error_message,default_value,max_length,display'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].' pq INNER JOIN '.$this->CFG['db']['tbl']['users_profile_category'].' pc ON pc.id=pq.form_id'.
						' WHERE form_id='.$this->dbObj->Param('form_id').' AND pc.status=\'Yes\''.
						' ORDER BY order_no ASC ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->getFormField('id')));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			    $html_field_arr = array();
				$inc=0;
				while($row = $rs->FetchRow())
					{
						$html_field_arr[$inc]['form_id'] = $row['form_id'];
						$html_field_arr[$inc]['question'] = $row['question'];
						if($row['question_type']=='text')
							{
							  	$html_field_arr[$inc]['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
							  	$answer=$this->populateAnswer($row['id']);
							  	if(isset($this->fields_arr[$row['id']]) && isset($_POST[$row['id']]))
							  		$html_field_arr[$inc]['answer_result']=$this->fields_arr[$row['id']];
							  	else
							  		$html_field_arr[$inc]['answer_result']=((count($answer)<=0)?$row['default_value']:$answer[0]);
							}
						if($row['question_type']=='textarea')
							{
							  	$html_field_arr[$inc]['rows'] = $row['rows'];
							  	$html_field_arr[$inc]['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
							  	$answer=$this->populateAnswer($row['id']);
							  	if(isset($this->fields_arr[$row['id']]) && isset($_POST[$row['id']]))
							  		$html_field_arr[$inc]['answer_result']=$this->fields_arr[$row['id']];
							  	else
							  		$html_field_arr[$inc]['answer_result']=((count($answer)<=0)?$row['default_value']:$answer[0]);
							}
						if($row['question_type']=='password')
							{
							   	$html_field_arr[$inc]['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
							   	$answer=$this->populateAnswer($row['id']);
							   	if(isset($this->fields_arr[$row['id']]) && isset($_POST[$row['id']]))
							   		$html_field_arr[$inc]['answer_result']=$this->fields_arr[$row['id']];
							   	else
							   		$html_field_arr[$inc]['answer_result']=((count($answer)<=0)?$row['default_value']:$answer[0]);
							}
						if($row['question_type']=='select')
							{
							  	$explode_arr = explode("\n", $row['options']);
							  	$option_arr=array();
								foreach($explode_arr as $key=>$value)
									{
										if(strlen(trim($value)))
											{
									    		$option_arr[$value]=trim($value);
											}
									}
							  	$html_field_arr[$inc]['option_arr']=$option_arr;
							  	$answer=$this->populateAnswer($row['id']);
							  	if(isset($this->fields_arr[$row['id']]) && isset($_POST[$row['id']]))
							  		$html_field_arr[$inc]['answer_result']=$this->fields_arr[$row['id']];
							  	else
							  		$html_field_arr[$inc]['answer_result']=((count($answer)<=0)?$row['default_value']:trim($answer[0]));
							}
						if($row['question_type']=='checkbox')
							{
							  	$html_field_arr[$inc]['display']=($row['display']=='vertical'?'<br>':'');
							  	$html_field_arr[$inc]['option_arr'] = explode("\n", $row['options']);
							  	$html_field_arr[$inc]['checked']=array();
							  	$ans_inc=0;
								foreach($html_field_arr[$inc]['option_arr'] as $value)
									{
										if(strlen(trim($value)))
											{
									   			$answer=$this->populateAnswer($row['id']);
									   			$ans_count=count($answer);//
									   			$html_field_arr[$inc]['checked'][$ans_inc]='';
									   			if(isset($this->fields_arr[$row['id']]) && isset($_POST['update_submit']))
										  			{
										    			$html_field_arr[$inc]['checked'][$ans_inc]='';
										    			if(isset($_POST[$row['id']]))
										    				{
											    				foreach($_POST[$row['id']] as $chk_ans)
												   					{
											   	   						$html_field_arr[$inc]['checked'][$ans_inc]=(trim($value) == trim($chk_ans)?'checked':'');
											   	   						if($html_field_arr[$inc]['checked'][$ans_inc]=='checked')
											   	    						break;
											       					}
										    				}
										  			}
										  		else
										  			{
										   	  			if($this->isCheckboxDeleteDetails($row['id']))
										   	  				{
											   	  				foreach($answer as $chk_ans)
												   					{
											   	   						$html_field_arr[$inc]['checked'][$ans_inc]=(trim($value) == trim($chk_ans)?'checked':'');
											   	   						if($html_field_arr[$inc]['checked'][$ans_inc]=='checked')
											   	    						break;
											       					}
										       				}
										      			else
										         			{
												   				$html_field_arr[$inc]['checked'][$ans_inc]=(trim($value) == trim($row['default_value'])?'checked':'');
										         			}
									     			}
								    			$ans_inc++;
											}
									}
							}
						if($row['question_type']=='radio')
							{
								$html_field_arr[$inc]['display']=($row['display']=='vertical'?'<br>':'');
							    $html_field_arr[$inc]['option_arr'] = explode("\n", $row['options']);
								foreach($html_field_arr[$inc]['option_arr'] as $value)
									{
										if(strlen(trim($value)))
											{
									   			$answer=$this->populateAnswer($row['id']);
									   			if(isset($this->fields_arr[$row['id']]) && !is_array($this->fields_arr[$row['id']]))
										  			{
										  				$answer_result=$this->fields_arr[$row['id']];
										  			}
										  		else
							 		  	  			$answer_result=((count($answer)<=0)?$row['default_value']:$answer[0]);
									    		$html_field_arr[$inc][$value]=($value == $answer_result?'checked':'');
											}
									}
							}
						$html_field_arr[$inc]['id'] = $row['id'];
						$html_field_arr[$inc]['question_type'] = $row['question_type'];
						$html_field_arr[$inc]['instruction'] = $row['instruction'];
						$html_field_arr[$inc]['options'] = $row['options'];
						$html_field_arr[$inc]['answer_required'] = $row['answer_required'];
						$html_field_arr[$inc]['max_length'] = $row['max_length'];
						$html_field_arr[$inc]['default_value'] = $row['default_value'];
						$html_field_arr[$inc]['instruction'] = $row['instruction'];
						$html_field_arr[$inc]['label_cell_class']=$this->getCSSFormLabelCellClass($row['question']);
						$html_field_arr[$inc]['field_cell_class']=$this->getCSSFormFieldCellClass($row['question']);
						$this->setFormFieldErrorTip($row['question'],$row['error_message']);
						$inc++;
					}
				return $html_field_arr;
			}

		/**
		 * EditOtherInfoProfileFormHandler::populateAnswer()
		 *
		 * @param mixed $question_id
		 * @return
		 */
		public function populateAnswer($question_id)
			{
			  	$sql = 'SELECT answer FROM '.$this->CFG['db']['tbl']['users_profile_info'].
						' WHERE user_id='.$this->dbObj->Param('user_id').
						' AND question_id='.$this->dbObj->Param('question_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id'],$question_id));
				if (!$rs)
					trigger_db_error($this->dbObj);
				$answer=array();
				$inc=0;
				while($row = $rs->FetchRow())
					{
						 $answer[$inc] = $row['answer'];
						 $inc++;
					}
				return $answer;
			}

		/**
		 * EditOtherInfoProfileFormHandler::isCheckboxDeleteDetails()
		 *
		 * @param mixed $question_id
		 * @return
		 */
		public function isCheckboxDeleteDetails($question_id)
			{
		   		$sql = 'SELECT count(question_id) AS total'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_info_checkbox'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND question_id='.$this->dbObj->Param('question_id').' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id'],$question_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
				  	$total=$row['total'];
				return $total;
			}

		/**
		 * EditOtherInfoProfileFormHandler::insertCheckboxDeleteDetails()
		 *
		 * @param mixed $question_id
		 * @return
		 */
		public function insertCheckboxDeleteDetails($question_id)
		   	{
				if(!$this->isCheckboxDeleteDetails($question_id))
					{
					   	$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_info_checkbox'].'  '.
								'SET user_id='.$this->dbObj->Param('user_id').' , question_id='.$this->dbObj->Param('question_id').',date_added=now()';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id'],$question_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}
		  	}

		/**
		 * EditOtherInfoProfileFormHandler::updateAnswer()
		 *
		 * @param mixed $Post_Array
		 * @return
		 */
		public function updateAnswer($question_id_arr)
		   	{
		   	  	$respond=array();
		  	  	foreach($question_id_arr as $value)
		  	   		{
			  	   	 	$respond['question_id']=$value;
			  	   	 	$respond['answer']=$this->fields_arr[$value];
			  	   	 	if($this->getQuestionType($respond['question_id'])=='checkbox')
			  	   	 		{

			 	  	    		$this->insertCheckboxDeleteDetails($respond['question_id']);
					  	   	    $sql = 'DELETE  FROM '.$this->CFG['db']['tbl']['users_profile_info'].
										' WHERE user_id='.$this->dbObj->Param('user_id').
										' AND question_id='.$this->dbObj->Param('question_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id'], $respond['question_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								if(is_array($respond['answer']) && count($respond['answer'])>0)
								 	{
								   		foreach($respond['answer'] as $answer)
									   		{
												$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_info'].
														' SET answer='.$this->dbObj->Param('answer').
														', user_id='.$this->dbObj->Param('user_id').
														', question_id='.$this->dbObj->Param('question_id');

												$stmt = $this->dbObj->Prepare($sql);
												$rs = $this->dbObj->Execute($stmt,array($answer, $this->CFG['user']['user_id'], $respond['question_id']));
											    if (!$rs)
												    trigger_db_error($this->dbObj);
										     }
			                    	}
							}
						else
							{
								// To avoid fatal error when no values has been selected for radio button
								if($this->getQuestionType($respond['question_id'])=='radio'
									and empty($respond['answer']))
									break;

							   	if($this->chkQuestionIdExist($respond['question_id']))
							   		{
							     		$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_info'].
									 			' SET answer='.$this->dbObj->Param('answer').
												' WHERE user_id='.$this->dbObj->Param('user_id').
												' AND question_id='.$this->dbObj->Param('question_id');
							     		$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt,array($respond['answer'], $this->CFG['user']['user_id'], $respond['question_id']));
										if (!$rs)
									    	trigger_db_error($this->dbObj);
									}
								else
									{
									   	$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_info'].
										   		' SET answer='.$this->dbObj->Param('answer').
												', user_id='.$this->dbObj->Param('user_id').
												', question_id='.$this->dbObj->Param('question_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt,array($this->fields_arr[$value], $this->CFG['user']['user_id'], $respond['question_id']));
									    if (!$rs)
										    trigger_db_error($this->dbObj);
									}
							}
		  	   		}//foreach
		   	}

		/**
		 * EditOtherInfoProfileFormHandler::chkQuestionIdExist()
		 *
		 * @param mixed $question_id
		 * @return
		 */
		public function chkQuestionIdExist($question_id)
			{
                $sql = 'SELECT id FROM '.$this->CFG['db']['tbl']['users_profile_info'].
						' WHERE user_id='.$this->dbObj->Param('user_id').
						' AND question_id='.$this->dbObj->Param('question_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id'], $question_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return true;
				return false;
			}

		/**
		 * EditOtherInfoProfileFormHandler::getQuestionType()
		 *
		 * @param mixed $question_id
		 * @return
		 */
		public function getQuestionType($question_id)
			{
                $sql = 'SELECT question_type FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE id='.$this->dbObj->Param('question_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($question_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['question_type'];
			}

		/**
		 * EditOtherInfoProfileFormHandler::getPageTitle()
		 *
		 * @return
		 */
		public function getPageTitle()
			{
				$sql = 'SELECT title'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_category'].
						' WHERE id='.$this->dbObj->Param('form_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->getFormField('id')));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $title = $row['title'];
			}

		/**
		 * EditOtherInfoProfileFormHandler::chkValidCategoryId()
		 *
		 * @return
		 */
		public function chkValidCategoryId()
			{
				$sql = 'SELECT title'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_category'].
						' WHERE id='.$this->dbObj->Param('id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->getFormField('id')));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
				 	return true;
				return false;
			}

		/**
		 * EditOtherInfoProfileFormHandler::getAnswerRequiredIds()
		 *
		 * @param mixed $question_id_arr
		 * @return
		 */
		public function getAnswerRequiredIds($question_id_arr)
			{
				$ans_req_question_ids = array();
				if (!$question_id_arr)
					return $ans_req_question_ids;
			    $question_ids = implode(',',$question_id_arr);
                $sql = 'SELECT id,error_message'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE id IN ('.$question_ids.') AND answer_required=1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				while($row = $rs->FetchRow())
					{
						$ans_req_question_ids[$row['id']]=$row['error_message'];
					}
				return $ans_req_question_ids;
			}

		/**
		 * EditOtherInfoProfileFormHandler::chkIsRequiedField()
		 *
		 * @param mixed $question_id_arr
		 * @return
		 */
		public function chkIsRequiredField($question_id)
			{
                $sql = 'SELECT id,error_message'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE id IN ('.$question_id.') AND answer_required=1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()>0)
					{
						return true;
					}
				return false;
			}

		/**
		 * EditOtherInfoProfileFormHandler::getQuestionDetailsById()
		 *
		 * @param mixed $question_id_arr
		 * @return
		 */
		public function getQuestionDetailsById($question_id)
			{

                $sql = 'SELECT id, error_message, question_type, answer_required'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE id IN ('.$question_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						return $row;
					}
				return false;
			}


		/**
		 * EditOtherInfoProfileFormHandler::getProfileQeustionTypeById()
		 *
		 * @param mixed $question_id_arr
		 * @return
		 */
		public function getProfileQuestionTypeById($question_id)
			{

                $sql = 'SELECT id, question_type'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE id = ('.$question_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['question_type'];
			}

		/**
		 * EditOtherInfoProfileFormHandler::updateQuestionDetails()
		 *
		 * @param mixed $question_id_arr
		 * @return
		 */
		public function updateQuestionDetails()
			{
				$this->updateInfoDetails();
				if ($this->getFormField('infovalue') == '')
					$this->setFormField('infovalue', $this->LANG['edit_in_place_no_answer']);
				$return_value = $this->getFormField('infovalue');
				return $return_value;
			}

		/**
		 * EditOtherInfoProfileFormHandler::chkIsAnsNotEmpty()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsAnsNotEmpty($field_name, $err_tip='')
			{
				if(is_array($this->fields_arr[$field_name]))
					$answer_result=((count($this->fields_arr[$field_name])<=0)?false:true);
				else
					$answer_result=($this->fields_arr[$field_name])?true:false;
				if (!$answer_result)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $answer_result;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateInfoDetails()
			{
	  	   	 	$respond['question_id'] = $this->fields_arr['infoid'];
	  	   	 	$respond['answer'] = $this->fields_arr['infovalue'];
	  	   	 	if($this->getQuestionType($respond['question_id']) == 'checkbox')
	  	   	 		{
	  	   	 			$this->insertCheckboxDeleteDetails($respond['question_id']);
			  	   	    $sql = 'DELETE  FROM '.$this->CFG['db']['tbl']['users_profile_info'].
								' WHERE user_id='.$this->dbObj->Param('user_id').
								' AND question_id='.$this->dbObj->Param('question_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id'], $respond['question_id']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
						$this->fields_arr['infovalue'] = str_replace(',', '/',$this->fields_arr['infovalue']);
						$respond['answer'] = explode('/', $this->fields_arr['infovalue']);
						if(is_array($respond['answer']) && count($respond['answer'])>0)
						 	{
						   		foreach($respond['answer'] as $answer)
							   		{
										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_info'].
												' SET answer='.$this->dbObj->Param('answer').
												', user_id='.$this->dbObj->Param('user_id').
												', question_id='.$this->dbObj->Param('question_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($answer, $this->CFG['user']['user_id'], $respond['question_id']));
									    if (!$rs)
										    trigger_db_error($this->dbObj);
								     }
	                    	}
					}
				else
					{
						// To avoid fatal error when no values has been selected for radio button
						if($this->getQuestionType($respond['question_id'])=='radio' and empty($respond['answer']))
							break;

					   	if($this->chkQuestionIdExist($respond['question_id']))
					   		{
					     		$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_info'].
							 			' SET answer='.$this->dbObj->Param('answer').
										' WHERE user_id='.$this->dbObj->Param('user_id').
										' AND question_id='.$this->dbObj->Param('question_id');

					     		$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt,array($respond['answer'], $this->CFG['user']['user_id'], $respond['question_id']));
								if (!$rs)
							    	trigger_db_error($this->dbObj);
							}
						else
							{
							   	$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_info'].
								   		' SET answer='.$this->dbObj->Param('answer').
										', user_id='.$this->dbObj->Param('user_id').
										', question_id='.$this->dbObj->Param('question_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt,array($respond['answer'], $this->CFG['user']['user_id'], $respond['question_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}
					}
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function chkIsValidInfoDetails()
			{
			    $sql = 'SELECT id, form_id, question, question_type, rows, order_no, width, instruction'.
						', options, answer_required, error_message, default_value, max_length, display '.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE form_id = '.$this->dbObj->Param($this->fields_arr['infotype']).
						' AND id = '.$this->dbObj->Param($this->fields_arr['infoid']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['infotype'], $this->fields_arr['infoid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getInfoDetails()
			{
			    $sql = 'SELECT id, form_id, question, question_type, rows, order_no, width, instruction'.
						', options, answer_required, error_message, default_value, max_length, display '.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE form_id = '.$this->dbObj->Param($this->fields_arr['infotype']).
						' AND id = '.$this->dbObj->Param($this->fields_arr['infoid']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['infotype'], $this->fields_arr['infoid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();

						$infodetails['form_id'] = $row['form_id'];
						$infodetails['question'] = $row['question'];
						if($row['question_type']=='text')
							{
							  	$infodetails['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
							  	$answer=$this->populateAnswer($row['id']);
							  	if(isset($this->fields_arr[$row['id']]) && isset($_POST[$row['id']]))
							  		$infodetails['answer_result']=$this->fields_arr[$row['id']];
							  	else
							  		$infodetails['answer_result']=((count($answer)<=0)?$row['default_value']:$answer[0]);
							}
						if($row['question_type']=='textarea')
							{
							  	$infodetails['rows'] = $row['rows'];
							  	$infodetails['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
							  	$answer=$this->populateAnswer($row['id']);
							  	if(isset($this->fields_arr[$row['id']]) && isset($_POST[$row['id']]))
							  		$infodetails['answer_result']=$this->fields_arr[$row['id']];
							  	else
							  		$infodetails['answer_result']=((count($answer)<=0)?$row['default_value']:$answer[0]);
							}
						if($row['question_type']=='password')
							{
							   	$infodetails['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
							   	$answer=$this->populateAnswer($row['id']);
							   	if(isset($this->fields_arr[$row['id']]) && isset($_POST[$row['id']]))
							   		$infodetails['answer_result']=$this->fields_arr[$row['id']];
							   	else
							   		$infodetails['answer_result']=((count($answer)<=0)?$row['default_value']:$answer[0]);
							}
						if($row['question_type']=='select')
							{
							  	$explode_arr = explode("\r\n", $row['options']);
							  	$option_arr=array();
								foreach($explode_arr as $key=>$value)
									{
										if(strlen(trim($value)))
											{
											    $option_arr[$value]=trim($value);
											}
									}
							  	$infodetails['option_arr']=$option_arr;
							  	$answer=$this->populateAnswer($row['id']);
							  	if(isset($this->fields_arr[$row['id']]) && isset($_POST[$row['id']]))
							  		$infodetails['answer_result']=$this->fields_arr[$row['id']];
							  	else
							  		$infodetails['answer_result']=((count($answer)<=0)?$row['default_value']:trim($answer[0]));
							}
						if($row['question_type']=='checkbox')
							{
							  	$infodetails['display']=($row['display']=='vertical'?'<br>':'');
							  	$infodetails['option_arr'] = explode("\n", $row['options']);
							  	$infodetails['checked']=array();
							  	$ans_inc=0;
								foreach($infodetails['option_arr'] as $value)
									{
										if(strlen(trim($value)))
											{
												$answer=$this->populateAnswer($row['id']);
											   	$ans_count=count($answer);//
											   	$infodetails['checked'][$ans_inc]='';
											   	if(isset($this->fields_arr[$row['id']]) && isset($_POST['update_submit']))
												  	{
												    	$infodetails['checked'][$ans_inc]='';
												    	if(isset($_POST[$row['id']]))
														    {
															    foreach($_POST[$row['id']] as $chk_ans)
																	{
															   	   		$infodetails['checked'][$ans_inc]=(trim($value) == trim($chk_ans)?'checked':'');
															   	   		if($infodetails['checked'][$ans_inc]=='checked')
															   	    		break;
															       	}
														    }
												  	}
												else
													{
													   	if($this->isCheckboxDeleteDetails($row['id']))
														   	{
															   	foreach($answer as $chk_ans)
																	{
																   	   	$infodetails['checked'][$ans_inc]=(trim($value) == trim($chk_ans)?'checked':'');
																   	   	if($infodetails['checked'][$ans_inc]=='checked')
															   	    		break;
															       	}
														    }
														else
													        {
																$infodetails['checked'][$ans_inc]=(trim($value) == trim($row['default_value'])?'checked':'');
													        }
												    }
										    	$ans_inc++;
											}
									}
							}
						if($row['question_type']=='radio')
							{
								$infodetails['display']=($row['display']=='vertical'?'<br>':'');
							    $infodetails['option_arr'] = explode("\n", $row['options']);
								foreach($infodetails['option_arr'] as $value)
									{
										if(strlen(trim($value)))
											{
												$answer=$this->populateAnswer($row['id']);
											   	if(isset($this->fields_arr[$row['id']]) && !is_array($this->fields_arr[$row['id']]))
												  	{
												  		$answer_result=$this->fields_arr[$row['id']];
												  	}
												else
									 		  	  	$answer_result=((count($answer)<=0)?$row['default_value']:$answer[0]);
											    $infodetails[$value]=($value == $answer_result?'checked':'');
											}
									}
							}
						$infodetails['id'] = $row['id'];
						$infodetails['question_type'] = $row['question_type'];
						$infodetails['instruction'] = $row['instruction'];
						$infodetails['options'] = $row['options'];
						$infodetails['answer_required'] = $row['answer_required'];
						$infodetails['max_length'] = $row['max_length'];
						$infodetails['default_value'] = $row['default_value'];
						$infodetails['instruction'] = $row['instruction'];
						$infodetails['label_cell_class']=$this->getCSSFormLabelCellClass($row['question']);
						$infodetails['field_cell_class']=$this->getCSSFormFieldCellClass($row['question']);
						//$this->setFormFieldErrorTip($row['question'],$row['error_message']);
						return $infodetails;
					}
				return false;
			}

		/**
		 * EditPersonalProfileFormHandler::saveHtmlCodes()
		 *
		 * @param array $fields
		 * @return
		 */
		public function saveHtmlCodes($fields = array())
			{
				if ($fields)
				    {
				        foreach($fields as $key=>$field_name)
							{
								if (isset($this->fields_arr[$field_name]))
								    {
								        $this->fields_arr[$field_name] = html_entity_decode($this->fields_arr[$field_name]);
									}
							}
				    }
			}

	}
$profile = new EditOtherInfoProfileFormHandler();
$profile->setFormField('form_id', '');
$profile->setFormField('pg', '');
$profile->setFormField('id', '');
$profile->setFormField('infotype', '');
$profile->setFormField('infovalue', '');
$profile->setFormField('infoobj', '');
$profile->setFormField('infoid', '');
$profile->setFormField('linkId', '');

$profile->setPageBlockNames(array('block_show_htmlfields', 'show_aboutme_option', 'show_info_option', 'show_aboutme_details', 'show_info_details'));
$profile->sanitizeFormInputs($_REQUEST);

if ($profile->isFormPOSTed($_POST, 'showoption') AND isAjax())
	{
		$profile->sanitizeFormInputs($_POST);
		switch($profile->getFormField('infotype')){
			default:
				if ($infodetails = $profile->getInfoDetails())
					{
						$smartyObj->assign('infodetails', $infodetails);
						$profile->setPageBlockShow('show_info_option');
					}
				break;
		} // switch
		$profile->includeAjaxHeader();
		setTemplateFolder('members/');
		$smartyObj->display('profileAjaxEdit.tpl');
		ob_end_flush();
		die();
	}
elseif ($profile->isFormPOSTed($_POST, 'updateprofile') AND isAjax())
	{
		$profile->sanitizeFormInputs($_POST);
		$return_value='';
		switch($profile->getFormField('infotype')){
			default:
				if ($profile->chkIsValidInfoDetails())
					{
						//add code to check if the answer is valid, if not return error message ..
						if($profile->chkIsRequiredField($profile->getFormField('infoid')))
						{
							$req_field_arr = $profile->getQuestionDetailsById($profile->getFormField('infoid'));
							if($req_field_arr['question_type'] == 'select' || $req_field_arr['question_type'] == 'radio' || $req_field_arr['question_type'] == 'checkbox')
							{
								if($profile->getFormField('infovalue') == $CFG['profile']['question_no_answer'])
								{
									$error_message = (!empty($req_field_arr['error_message'])? $req_field_arr['error_message'] :$LANG['profileinfo_err_tip_required']);
									$return_value = $profile->content_separator.'error'.$profile->content_separator.$error_message;
								}
								else
								{
									$return_value = $profile->updateQuestionDetails();
								}
							}
							elseif($profile->getFormField('infovalue') == '' AND (!$profile->chkIsAnsNotEmpty('infovalue', $LANG['profileinfo_err_tip_required'])))
							{
								$error_message = (!empty($req_field_arr['error_message'])? $req_field_arr['error_message'] :$LANG['profileinfo_err_tip_required']);
								$return_value = $profile->content_separator.'error'.$profile->content_separator.$error_message;
							}
							else
							{
								$return_value = $profile->updateQuestionDetails();
							}
						}
						else
						{
							$return_value = $profile->updateQuestionDetails();
						}

					}
				break;
		} // switch
		$profile->includeAjaxHeader();
		echo $return_value;
		ob_end_flush();
		die();
		break;
	}

if($profile->chkValidCategoryId())
	{
   		$profile->setPageBlockShow('block_show_htmlfields');
	}
else
	{
		$profile->setAllPageBlocksHide();
		$profile->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$profile->setPageBlockShow('block_msg_form_error');
	}
$question_id_arr=array();
$block_show_htmlfields = $profile->populateHtmlFields();
foreach($block_show_htmlfields as $value)
	{
		$question_id_arr[]= $value['id'];
		if($value['question_type']=='text' || $value['question_type']=='textarea' || $value['question_type']=='password')
			{
		 		$profile->setFormField($value['id'], $value['answer_result']);
		 	}
		else if ($value['question_type']=='checkbox' || $value['question_type']=='radio' || $value['question_type']=='select')
		 	{
		   		$profile->setFormField($value['id'], array());
		 	}
	}

$ans_req_question_id_arr=$profile->getAnswerRequiredIds($question_id_arr);
$profile->sanitizeFormInputs($_REQUEST);
if($profile->isFormPOSTed($_POST,'update_submit'))
	{
	  	$tot_ans_req=count($ans_req_question_id_arr);
	  	$ans_true=0;
	  	foreach($ans_req_question_id_arr as $id=>$error_msg)
	  		{
	   			if($profile->chkIsAnsNotEmpty($id,($error_msg?$error_msg:$LANG['profileinfo_err_tip_required'])))
	   				$ans_true++;
	  		}
	  	if($ans_true==$tot_ans_req)
	  		{
	  			$profile->updateAnswer($question_id_arr);
		  		$profile->setCommonSuccessMsg($LANG['profileinfo_update_message']);
		  		$profile->setPageBlockShow('block_msg_form_success');
		  	}
	  	else
	   		{
	    		$profile->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$profile->setPageBlockShow('block_msg_form_error');
		   	}
	}
$profile->block_show_htmlfields = $profile->populateHtmlFields();
$profile->page_title = $profile->getPageTitle();
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$profile->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('profileInfo.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if ($CFG['feature']['jquery_validation'])
	{
		if($ans_req_question_id_arr)
			{
				$question_field_rules='';
				$question_field_messages='';
				$i=1;
				foreach($ans_req_question_id_arr as $id=>$error_msg)
					{
						$question_type = $profile->getProfileQuestionTypeById($id);
						if($question_type == "checkbox")
							$question_field_name = $id."[]";
						else
							$question_field_name = $id;

						$question_field_rules .= '"'.$question_field_name.'":{ required:true }';
						$question_field_messages .= '"'.$question_field_name.'":{ required:"'.($error_msg?$error_msg:$LANG['profileinfo_err_tip_required']).'"}';
						if($i<count($ans_req_question_id_arr))
							{
								$question_field_rules = $question_field_rules.',';
								$question_field_messages = $question_field_messages.',';
							}
						$i++;
					}
?>
				<script type="text/javascript">
					$Jq("#selFormEditOtherInfoProfile").validate({
						rules: {
						   <?php echo $question_field_rules; ?>
						},
						messages: {
							<?php echo $question_field_messages;?>
						}
					});
				</script>
<?php
			}
	}
$profile->includeFooter();
?>