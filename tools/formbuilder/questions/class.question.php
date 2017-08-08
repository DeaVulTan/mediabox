<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
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

	abstract class Question
	{
		protected $type = ''; //the question type
		protected $id = ''; //the question id in db
		protected $settings = array(); //all settings with the specified questions
		protected $order = ''; //the position of the specified question within its page
		protected $name = '';
		protected $lang = '';
		protected $info = array();
		protected $isEditable = true;
		protected $isBranchable = true;
		protected $isForPresentation = false;
		protected $msg = null;
		protected $extraSettings = array();
		protected $tableQuestion = '';
		protected $tableRespond = '';
		protected $tableRespondent ='';
		protected $formId = '';
		public function __construct($type, $id = null)
		{
			global $msg;
			$this->msg = $msg;
			$this->type = $type;
			$this->id = $id;


		}

		public function setFormId($formId)
		{
			$this->formId = $formId;
			$this->tableRespond = TBL_INFO;
			$this->tableRespondent = TBL_RESPONDENT;
			$this->tableQuestion = TBL_QUESTION;
		}
		/**
		 * get question type
		 *
		 * @return string
		 */
		public function getType()
		{
			return $this->type;
		}
		abstract public function getFields();
		/**
		 * get the question name
		 * @return string
		 */
		abstract public function getName();

		/**
		 * set the question id
		 *
		 * @param integer $id
		 */
		public function setID($id)
		{
			$this->id = $id;
		}
		abstract public function  getInstructionText();
		public function disableBranchable()
		{
			$this->isBranchable = false;
		}
		public function disableEditable()
		{
			$this->isEditable = true;
		}
		public function isForPresentation()
		{
			return $this->isForPresentation;
		}

		public function enablePresentation()
		{
			$this->isForPresentation = true;
		}

		public  function isBranchable()
		{
			return $this->isBranchable;
		}
		public function isEditable()
		{
			return $this->isEditable;
		}


		abstract public function getDefaultValues();
		/**
		 * Enter description here...
		 *
		 * @param unknown_type $id
		 */
/*		public function validate($id)
		{
			return false;
		}
		public function
		public function getFunc*/
		/**
		 * this javascript function will be called when admin click the edit button
		 * it will bring the edit form for the selected questio in left column
		 *
		 */
		abstract public function getFuncEditJS();

		/**
		 * this javascript function will be called when any changes made to the edit form
		 * so it will sync those information in the editf form with the update html in right column
		 *
		 */
		public function getFuncSyncJS()
		{
			return 'function(qID, fieldName,extraOptions) {syncJS(qID, "' . $this->getType() . '", fieldName, extraOptions);}';
		}

		protected function getFormId()
		{
			return $this->formId;
		}
		/**
		 * get information of the specified question
		 * @return array
		 *
		 */
		public function get($id = null)
		{
			global $db;
			$id = (is_null($id)?$this->id:$id);
			$query = "SELECT * FROM " . $this->tableQuestion . " WHERE id=" . $db->quote($id, 'integer') . " AND form_id=" . $db->quote($this->getFormId() , 'integer');
			$db->setLimit(1);
			$result = $db->query($query);
			if(PEAR::isError($result))
			{
				return false;
			}
			return ($result->fetchrow());



		}
		/**
		 * add a new question with same type
		 * @param integer $surveyId
		 * @param integer $surveyPageId
		 * @param string $elemRelativeTo either of question, page
		 * @param integer $elemId the id of element relative to
		 * @param boolean $isAbove will show the new elem above the relative elem if true
		 * @return boolean
		 */
		public function add($relativeTo, $position, $relativeValue)
		{
			global $db;

			if($relativeTo == 'form' || ($relativeTo == 'question' && !empty($relativeValue)))
			{

		 			$result = $db->beginTransaction();
			 		if ($db->inTransaction() && $db->supports('savepoints'))
			 		{

				 		$savepoint = 'addquestion';
			    		$result = $db->beginTransaction($savepoint);
						if(PEAR::isError($result))
						{
							return false;
						}
						$query = "LOCK TABLES " . $this->tableQuestion . " write";
			    		$result = $db->query($query);
						if(PEAR::isError($result))
						{
				    		$result = $db->query("UNLOCK TABLES");
							return false;
						}
						$questionId = $db->getBeforeID($this->tableQuestion, 'id', true, true);
						if(PEAR::isError($questionId))
						{
							$db->rollback($savepoint);
							$result = $db->query("UNLOCK TABLES");
							return false;
						}
						if($relativeTo == 'form')
						{
							if($position == 'before')
							{//insert this new question to the top one, and move the existing question downward.
								$query = "UPDATE " . $this->tableQuestion . " SET order_no = order_no + 1 WHERE form_id=" . $db->quote($this->getFormId(), 'integer');
					    		$result = $db->query($query);
								if(PEAR::isError($result))
								{
						    		$result = $db->query("UNLOCK TABLES");
									return false;
								}else
								{
									$nextOrder = 1;
								}
							}else
							{//insert this new question to the bottom
					    		$query = "SELECT MAX(order_no) order_no FROM " . $this->tableQuestion . " WHERE form_id=" . $db->quote($this->getFormId(), 'integer');
					    		$result = $db->query($query);
								if(PEAR::isError($result))
								{
									$db->rollback($savepoint);
									$result = $db->query("UNLOCK TABLES");
									return false;
								}
								if($result->numrows())
								{
									$row = $result->fetchrow();
									$nextOrder = intval($row['order_no']) + 1;
								}else
								{
									$nextOrder = 1;
								}
							}
						}elseif($relativeTo == 'question')
						{
							//get the specified question order no
							$query = "SELECT order_no FROM " . $this->tableQuestion . " WHERE form_id=" . $db->quote($this->getFormId(), 'integer') . " AND id=" . $db->quote($relativeValue, 'integer');
							$db->setLimit(1);
							$result = $db->query($query);
							if(PEAR::isError($result) || !$result->NumRows())
							{
								$db->rollback($savepoint);
								$result = $db->query("UNLOCK TABLES");
								return false;
							}else
							{
								$row = $result->fetchrow();
								$orderNo = $row['order_no'];
							}
							if($position == 'before')
							{//move all thoes questions under the relative value include the specified question
								$query = "UPDATE " . $this->tableQuestion . " SET order_no = order_no + 1
									WHERE form_id=" . $db->quote($this->getFormId(), 'integer') . " AND order_no >=" . $db->quote($orderNo, 'integer');
								$nextOrder = $orderNo;
							}else
							{//move all those question under the relative value
								$query = "UPDATE " . $this->tableQuestion . " SET order_no = order_no + 1 WHERE form_id=" . $db->quote($this->getFormId(), 'integer') . " AND order_no > " . $db->quote($orderNo, 'integer');
								$nextOrder = $orderNo + 1;
							}
				    		$result = $db->query($query);
							if(PEAR::isError($result))
							{
								$db->rollback($savepoint);
								$result = $db->query("UNLOCK TABLES");
								return false;
							}

						}
					    $d = $this->getDefaultValues();
					    $time = date('Y-m-d H:i:s');
						$query = "INSERT INTO " . $this->tableQuestion . " (id, order_no, question, question_type, instruction, options, answer_required, error_message, default_value, extra_settings, specify_allowed, rule, max_length, cdatetime, mdatetime, form_id, rows, width, specify_label) VALUES (" . $questionId . ", " . $db->quote($nextOrder, 'integer') . ", " . $db->quote($d['question'], 'text') . ", " . $db->quote($d['question_type'], 'text') .
						", " . $db->quote($d['instruction'], 'text') . ", " . $db->quote(isset($d['options'])?$d['options']:'', 'text') .
						", " . $db->quote(empty($d['answer_required'])?'0':'1', 'text') . ", " . $db->quote($d['error_message'], 'text') .
						", " . $db->quote(isset($d['default_value'])?$d['default_value']:'', 'text') .
						", " . $db->quote(isset($d['extra_settings'])?serialize($d['extra_settings']):'', 'text') .
						", " . $db->quote(empty($d['specify_allowed'])?'0':'1', 'text') .
						", " . $db->quote(isset($d['rule'])?$d['rule']:'', 'text') .
						", " . $db->quote(isset($d['max_length'])?$d['max_length']:'', 'integer') .
						", " . $db->quote($time, 'timestamp').
						", " . $db->quote($time, 'timestamp') .
						", " . $db->quote($this->getFormId(), 'integer') .
						", " . $db->quote(isset($d['rows'])?$d['rows']:'', 'integer') .
						", " . $db->quote(isset($d['width'])?$d['width']:'', 'integer') .
						", " . $db->quote(isset($d['specify_label'])?$d['specify_label']:'', 'text') .
						")";
						$result = $db->query($query);
						if(PEAR::isError($result))
						{
							$db->rollback($savepoint);
							$result = $db->query("UNLOCK TABLES");
							return false;
						}

						$questionId = $db->getAfterID($questionId, $this->tableQuestion, 'id');
						$result = $db->commit();
						if(PEAR::isError($result))
						{
							$db->rollback($savepoint);
							$result = $db->query("UNLOCK TABLES");
							return false;
						}
						$result = $db->query("UNLOCK TABLES");

						return $questionId;

			 		}

			}


			return false;
		}
		/**
		 * update information of the specified question
		 *
		 * @param array $d
		 * @return boolean
		 */
		abstract public function save($d);
		/**
		 * remove the specified question from db
		 * @return boolean
		 */
		public function delete($id)
		{
			global $db;
	 		if($db->supports('transactions'))
	 		{
	 			$result = $db->beginTransaction();
		 		if ($db->inTransaction() && $db->supports('savepoints'))
		 		{

			 		$savepoint = 'deletequestion';
		    		$result = $db->beginTransaction($savepoint);
		    		$query = "DELETE FROM `" . $this->tableQuestion . "` WHERE `id`=" . intval($id);
		    		$result = $db->query($query);
					if(PEAR::isError($result))
					{
						$db->rollback($savepoint);
						return false;
					}
					$query = "DELETE FROM `" . $this->tableRespond . '` WHERE `question_id`=' . intval($id);
		    		$result = $db->query($query);
					if(PEAR::isError($result))
					{
						$db->rollback($savepoint);
						return false;
					}
					$result = $db->commit();
					return true;

		 		}
	 		}
	 		return false;
		}
		/**
		 * reorder the specified question to new position
		 * can be moved to different survey page
		 *
		 * @param string $itemRelativeTo options: page, question
		 * @param integer $itemId
		 * @return boolean
		 */
		public function reorder($itemRelativeTo, $itemId)
		{

		}


		/**
		 * get Final question HTML for front-end user
		 * @return string
		 */
		abstract public function getHTML();
		/**
		 * get the HTML for updating question settings in Back-end
		 *
		 */
		abstract public   function getSettingHTML();
		/**
		 * get the question HTML for back-end to preview
		 *
		 */
		abstract public  function getUpdateHTML($id = null);
		/**
		 *
		 */
		abstract public function getAddHTML();

		public function getAnswerTextFromPost($id=null)
		{
			$id = is_null($id)?$this->id:$id;
			if(isset($_POST[$id]))
			{
				return $_POST[$id];
			}else
			{
				return '';
			}
		}

		public function getAnswerHTMLFromPost($id=null)
		{
			$id = is_null($id)?$this->id:$id;
			if(isset($_POST[$id]))
			{
				return htmlentities($_POST[$id]);
			}else
			{
				return '';
			}
		}
		protected  function getExtraSetting($d = array())
		{
			$extraSettings = $this->extraSettings;
			foreach ($extraSettings as $k=>$v)
			{
				if(isset($d[$k]))
				{
					$extraSettings[$k] = $d[$k];
				}
			}
			return $extraSettings;
		}
		public function getRespondAnswer($qID = null, $respondentId = null)
		{
			global $auth, $db;
			$qID = (is_null($qID)?$this->id:$qID);
			$respondentId = is_null($respondentId)?$auth->getUserId():$respondentId;
			$query = "SELECT answer FROM " . $this->tableRespond . " WHERE respondent_id=" . intval($respondentId) . " AND question_id=" . $qID;
			if(($result = $db->query($query)) )
			{
				if(PEAR::isError($result))
				{
					return false;
				}
				$row = $result->FetchRow();
				if($row)
				{
					return $row['answer'];
				}
			}
			return false;

		}
		/**
		 * this javascript function will be called when front-end users click the save and next page button
		 * it will validate the specified question and mark it red and return false if failed
		 */
		public function getFuncValidateJS(){}
		public function getFuncShowErrorJS(){}
		public function getFuncHideErrorJS(){}

		public function isValid($id)
		{
			$info = $this->getSetting($id);
			if(empty($info['answer_required']) || !empty($_POST[$id]))
			{
				return true;
			}
			return false;
		}

		public function saveAnswer($id, $respondentId)
		{
			return $this->__doSaveAnswer($id, $respondentId,  $_POST[$id]);
		}
		public function __doSaveAnswer($id, $respondentId, $answer)
		{
			global $db;
			$respondId = $db->getBeforeID(TBL_INFO, 'id', true, true);
			if(PEAR::isError($respondId))
			{
				return false;
			}
			$query = 'INSERT INTO ' . $this->tableRespond . " (id, answer, respondent_id, question_id) VALUES (" . $respondId . ", " .  $db->quote($answer, 'text') . ", " . $db->quote($respondentId, 'integer') .  ", " .   $db->quote($id) . ") ";
			$affected  = $db->exec($query);
			if(PEAR::isError($affected))
			{
				return  false;
			}
			return true;
		}


		public function getResponds($id, $startDate, $finishDate)
		{
			return $this->_doGetResponds($id, $startDate, $finishDate);
		}

		public function _doGetResponds($id, $startDate, $finishDate)
		{
			global $db;

			$query = "SELECT respondent.id respondent_id,  respond.answer
				FROM " . $this->tableRespondent .  " respondent
				LEFT JOIN " . $this->tableRespond . " respond
				ON respond.respondent_id=respondent.id
				AND respond.question_id=" . $db->quote($id, 'integer')  . " WHERE respondent.form_id=" . ($db->quote($this->getFormId(), 'integer'));

			if(!is_null($startDate) && !is_null($finishDate))
			{
				$query .= " AND respondent.cdatetime >=" . $db->quote($startDate, 'timestamp') . " AND respondent.cdatetime <=" . $db->quote($finishDate, 'timestamp');
			}elseif(!is_null($startDate))
			{
				$query .= " AND respondent.cdatetime >=" . $db->quote($startDate, 'timestamp') ;
			}elseif(!is_null($finishDate))
			{
				$query .=  " AND  respondent.cdatetime <=" . $db->quote($finishDate, 'timestamp');
			}

			$query .=  " ORDER BY respondent.id ";

			$result = $db->query($query);

			if(PEAR::isError($result))
			{
				return false;
			}
			$responds = array();
			while($row = strip_slashes2($result->fetchrow()))
			{
				$responds[$row['respondent_id']] = $row['answer'];
			}

			return $responds;
		}

		public function hasSubQuestions()
		{
			return false;
		}

		public function getSettingInfo($index=null)
		{
			return is_null($index)? $this->settings:(isset($this->settings[$index])?$this->settings[$index]:'');
		}

		public function getSetting($id = null, $forceToRetrieve = false, $extraOptions = array())
		{
			$outputs = array();
			$id = is_null($id)?$this->id:$id;
			if(!empty($this->settings) && !$forceToRetrieve)
			{
				$outputs = $this->settings;
			}else
			{
				foreach ($this->get($id) as $k=>$v)
				{


					if(array_search($k, $this->getFields()) !== false)
					{
						$outputs[$k] = $v;
					}else
					{
						switch($k)
						{
							case 'type':
								$outputs['question_type'] = $v;
								break;
							case 'extra_settings':
								if(!empty($v))
								{
									$extra = unserialize($v);

									foreach ($this->getExtraSetting($extra) as $k=>$v)
									{
										$outputs[$k] = $v;
									}
								}else
								{
									foreach ($this->getExtraSetting() as $k=>$v)
									{
										$outputs[$k] = $v;
									}
								}


								break;


						}
					}
				}
				foreach ($extraOptions as $k=>$v)
				{
					$outputs[$k]=$v;
				}
				$this->settings = $outputs;
			}

			return $outputs;
		}
	}