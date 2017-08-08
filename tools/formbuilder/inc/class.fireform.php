<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please contact US if you need any such web-based information system
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to US
 * thanks.
 * @author logan cai
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 *
 *
 */
   	require_once(DIR_INC_FF . 'class.content.base.php');

	class FireForm extends ContentBase
	{
		private $db = null;
		private $id = null;
		private $info = array();
		private $questionClasses = array();
		private $questionTypeInstances = array();
		private $questionInstances = array();
		private $funcQuestionEditJS = array();
		private $funcQuestionPresetJS = array();
		private $funcQuestionRefreshUpdateHTMLJS = array();
		private $currentQuestionTypeInstance = null;
		private $funcQuestionSynJS = array();
		private $html = '';
		private $formBodyHtml = '';
		private $mode = 'view';
		private $questions = array();
		/**
		 * Enter description here...
		 *
		 */
		public function __construct($id=null)
		{
			global $db;
			$this->db = $db;
			$this->id = $id;
		}
		/**
		 * delete the specified form
		 *
		 * @param integer $id
		 */
		public function delete($id = null)
		{

		}
		public function getId()
		{
			return $this->id;
		}
		public function getLang()
		{
			return $this->getInfo('lang');
		}
		/**
		 * init all questions or the specified question type
		 * @return boolean
		 *
		 */
		public function initQuestionTypes($type=null)
		{

			if(is_null($type))
			{
		        $fp = @opendir(DIR_QUESTION_FF);
		        while(false !== ($type = @readdir($fp)))
		        {
		            if($type != '.' && $type != '..' && is_dir(DIR_QUESTION_FF . $type) && file_exists(DIR_QUESTION_FF . $type . DIRECTORY_SEPARATOR . 'class.' . $type . '.php'))
		            {
						$this->questionClasses[$type] = DIR_QUESTION_FF . $type . DIRECTORY_SEPARATOR . 'class.' . $type . '.php';
						include_once( DIR_QUESTION_FF . $type . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR .  $this->getLang() . '.php');
						include_once($this->questionClasses[$type]);

						$this->questionTypeInstances[$type] = new $type();
						$this->questionTypeInstances[$type]->setFormId($this->getId());
						$this->funcQuestionEditJS[$type]= 	($this->questionTypeInstances[$type]->getFuncEditJS());
						$this->funcQuestionSynJS[$type] = ($this->questionTypeInstances[$type]->getFuncSyncJS());


		            }
		        }
		        @closedir($fp);
			}else
			{

				if(is_dir(DIR_QUESTION_FF . $type) && file_exists(DIR_QUESTION_FF . $type . DIRECTORY_SEPARATOR . 'class.' . $type . '.php'))
				{
						$this->questionClasses[$type] = DIR_QUESTION_FF . $type . DIRECTORY_SEPARATOR . 'class.' . $type . '.php';
						include_once( DIR_QUESTION_FF . $type . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR .  $this->getLang() . '.php');
						include_once($this->questionClasses[$type]);
						$this->questionTypeInstances[$type] = new $type();
						$this->questionTypeInstances[$type]->setFormId($this->getId());

						$this->currentQuestionTypeInstance = $this->questionTypeInstances[$type];

						return $this->currentQuestionTypeInstance ;

				}else
				{
					return false;
				}
			}



		}




		public function getQuestions()
		{
			$query = "SELECT * FROM "  . TBL_QUESTION . " WHERE form_id=" . $this->db->quote($this->getId() , 'integer') . " ORDER BY order_no";
			$result = $this->db->query($query);
			if(!PEAR::isError($result))
			{
				while($row = $result->fetchrow())
				{
					$this->questions[$row['id']] = $row;
				}
			}
			return $this->questions;

		}
		/**
		 * get the whole information of the specified form
		 *
		 * @param integer $id
		 * @return array
		 */
		public function get($id = null)
		{
			$id = is_null($id)?$this->id:$id;
			$query = "SELECT * FROM " . TBL_CATEGORY . " WHERE id=" . $this->db->quote($id, 'integer');
			$this->db->setLimit(1);
			if(($result = $this->db->query($query)) && $result->numrows())
			{
				$this->info = $result->fetchrow();
				return $this->info;
			}
			return false;


		}
		/**
		 * get whole information of the present form or the specified informaton from present form
		 *
		 * @param string $index
		 * @return mixed
		 */
		public function getInfo($index = null)
		{
			if(is_null($index))
				return $this->info;
			else
				return $this->info[$index];
		}
		/**
		 * ensure the logged user has permisson to access the specified form
		 *
		 * @param integer $id form id
		 * @return boolean
		 */
		public function isPermitted($id=null)
		{
			global $auth;
			$id = is_null($id)?$this->id:$id;
			if($auth->isSuperAdmin())
			{
				return true;
			}
			else
			{
				$query = "SELECT count(*) total FROM " . TBL_CATEGORY . " WHERE id=" . $this->db->quote($id, 'integer') . " AND creator_id=" .  $this->db->quote($auth->getUserId(), 'integer');
				if(($result = $this->db->query($query)) && $result->numrows())
				{
					$row = $result->fetchrow();
					if($row['total'])
						return true;
				}
			}

			return false;
		}

		public function set($id)
		{
			$this->__setMode('view');
			$this->id= $id;
			if($this->get($id) !== false)
			{
				$js = '';
				$config = array('url'=>array('site'=>URL_SITE), 'form_id'=>$this->getId() ,
				'error'=>array('invalid1'=>ERR_QUESTION_INVALID1, 'invalid2'=>ERR_QUESTION_INVALID2, 'unexpected'=>ERR_UNEXPECTED));
				$js  .= 'var config = ' . json_encode($config) . ";\n";
				$this->initQuestionTypes();
				foreach ($this->getQuestions() as $qId=>$question)
				{
					$this->questionInstances[$qId] = new $question['question_type']($qId);
					$this->questionInstances[$qId]->setFormId($this->getId());
				}
				$this->appendCss(URL_THEME . $this->getInfo('theme') . '/css/fireformlayout.css', true);
				$this->appendCss(URL_THEME . $this->getInfo('theme') . '/css/ie6.css', true, 'screen', 'lt IE 7');
				$this->appendJs(URL_JS . 'jquery.js', true);
				$this->appendJs(URL_JS . 'jquery.form.js', true);
				$this->appendJs(URL_JS . 'jqModal.js', true);
				$this->appendJs(URL_JS . 'common.js', true);
				$this->appendJs(URL_JS . 'fireform.js', true);
				// show up the full list of question settings
				$questions = array();
				foreach ($this->questionInstances as $qId=>$instance)
				{
					$questions[$qId] = $instance->getSetting();
				}
				$js .= 'var formInfo = ' . json_encode($this->get()) . ";\n";
				$js .= 'var questions=' . json_encode($questions) . ";\n";
				// show up the full lis of functions available for validating user inputs
				$js .= ' var  funcValidate = {';
				$i = 0;
				foreach ($this->questionTypeInstances as $type=>$instance)
				{
					$js .= ($i++?',':'') . $type . ':' . clearUpJsFunction($instance->getFuncValidateJS());
				}
				$js .= '};';

				// show up the full lis of functions available for validating user inputs
				$js .= ' var funcShowErrors = {';
				$i = 0;
				foreach ($this->questionTypeInstances as $type=>$instance)
				{
					$js .= ($i++?',':'') . $type . ':' . clearUpJsFunction($instance->getFuncShowErrorJS());
				}
				$js .= '};';
				// show up the full lis of functions available for validating user inputs
				$js .= ' var  funcHideErrors = {';
				$i = 0;
				foreach ($this->questionTypeInstances as $type=>$instance)
				{
					$js .= ($i++?',':'') . $type . ':' . clearUpJsFunction($instance->getFuncHideErrorJS());
				}
				$js .= '};';
				$js .= ' $(document).ready(
					function()<br />
					{
						$("#fireForm").jqm({modal:true});
					}
				)' . "\n";
				$this->appendJs($js, false);
				return true;
			}else
			{
				return false;
			}

		}

		public  function setSave($id)
		{
			$this->__setMode('save');
			$this->id= $id;
			if($this->get($id) !== false)
			{

				return true;
			}else
			{
				return false;
			}
		}

		public function saveQuestionAnswers()
		{
			global $db, $msg;
				$invalidQuestions = array();
				$this->initQuestionTypes();
				foreach ($this->getQuestions() as $qId=>$question)
				{
					$this->questionInstances[$qId] = new $question['question_type']($qId);
					$this->questionInstances[$qId]->setFormId($this->getId());
					if(!$this->questionInstances[$qId]->isValid($qId))
					{
						$invalidQuestions[$qId] = array();
					}
				}
				if(sizeof($invalidQuestions))
				{
					return $invalidQuestions;
				}else
				{

			 		if($db->supports('transactions'))
			 		{
			 			$result = $db->beginTransaction();
				 		if ($db->inTransaction() && $db->supports('savepoints'))
				 		{

						 		$savepoint = 'saveAnswers';
					    		$result = $db->beginTransaction($savepoint);
								if(PEAR::isError($result))
								{
									$db->rollback($savepoint);
									return false;
								}
								$respondentId = $db->getBeforeID(TBL_RESPONDENT, 'id', true, true);
								if(PEAR::isError($respondentId))
								{
									$db->rollback($savepoint);
									return false;
								}
								$time = date('Y-m-d H:i:s');
								$query = "INSERT INTO " . TBL_RESPONDENT . " (id, cdatetime, ip, form_id, user_id) VALUES (" . $respondentId . ", " . $db->quote($time, 'timestamp') . ", " . $db->quote(getIP(), 'text') . ", " . $db->quote($this->getId(), 'integer') . ", " .$_SESSION['user']['user_id']. ')';
								$result = $db->exec($query);
								if(PEAR::isError($result))
								{
									$db->rollback($savepoint);
									return false;
								}
								$respondentId =  $db->getAfterID($respondentId, TBL_RESPONDENT, 'id');



				 		}else
				 		{
				 			return false;
				 		}
			 		}else
			 		{
			 			return false;
			 		}
					if($this->getInfo('mode') == 'db' || $this->getInfo('mode') == 'both')
					{
						foreach ($this->questionInstances as $qId=>$instance)
						{
							if(!$instance->saveAnswer($qId, $respondentId))
							{
								$db->rollback($savepoint);
								return false;
							}
						}



					}
					$result = $db->commit();
					if($this->getInfo('mode') == 'email' || $this->getInfo('mode') == 'both')
					{//email the answers
						$txt = '';
						$html = '';
						foreach ($this->questionInstances as $qId=>$instance)
						{
							$txt .= $instance->getSettingInfo('question') . ': ' . $instance->getAnswerTextFromPost() . "\n";
							$html .=  '<b>' . $instance->getSettingInfo('question') . ':</b> ' . ( $instance->getAnswerHTMLFromPost()) . "<br>";
						}
						//call function to send the html and txt to email
						$query = "SELECT * FROM " . TBL_USER . " WHERE id=" . $db->quote($this->getInfo('creator_id'), 'integer');
						$this->db->setLimit(1);
						if(($result = $this->db->query($query)) && $result->numrows())
						{
							$creatorInfo = $result->fetchrow();
							include_once(DIR_INC_FF . 'class.phpmailer.php');
							$mail             = new PHPMailer();
							$mail->IsHTML(true);
							$mail->Port = EMAIL_SERVER_PORT;
							$mail->From       = $creatorInfo['email'];
							$mail->FromName = $creatorInfo['first_name'] . " " . $creatorInfo['last_name'];
							$mail->Subject    = $this->getInfo('subject');
							$mail->Body = stripslashes($html);
							$mail->AltBody = $txt;
							$mail->AddAddress($this->getInfo('email'));
							$mail->Username = EMAIL_SERVER_USERNAME;
							$mail->Password = EMAIL_SERVER_PASSWORD;
							switch (strtolower(EMAIL_SERVER_TYPE))
							{
								case 'smtp':
									$mail->IsSMTP(); // telling the class to use SMTP
									$mail->Host       = EMAIL_SERVER_HOST; // SMTP server
									if(EMAIL_SERVERY_AUTH_REQUIRED)
									{
										$mail->SMTPAuth = true;
									}else
									{
										$mail->SMTPAuth = false;
									}
									break;
								case 'sendmail':
									$mail->IsSendmail(); // telling the class to use SendMail transport
									break;
								case 'mail':
								default:
							}
							if(!$mail->Send())
							{

							}else
							{

							}
						}

					}


				}
				return true;
		}

		public function save($d)
		{
			global  $auth, $msg;
			$query = "UPDATE " . TBL_CATEGORY  . ' SET title=' . $this->db->quote($d['title'], 'text') .
				", submit_label=" . $this->db->quote($d['submit_label'], 'text') .
				", url=" . $this->db->quote($d['url'], 'text');
			if($auth->isSuperAdmin())
			{
				$query .= ", creator_id=" . $this->db->quote($d['creator_id'], 'integer');
			}
			$query .= ", theme=" . $this->db->quote($d['theme'], 'text');
			$query .= ", mode=" . $this->db->quote($d['mode'], 'text');
			switch ($d['mode'])
			{
				case 'both':
				case 'email':
					$query .= ", email=" . $this->db->quote($d['email'], 'text') . ", subject=" . $this->db->quote($d['subject'], 'text');
					break;
				case 'db':
				default:
					$query .= ", email=" . $this->db->quote('', 'text') . ", subject=" . $this->db->quote('', 'text');
			}
			$query .= ", mdatetime=NOW()";
			$query .= " WHERE id=" . $this->db->quote($this->getId(), 'integer');

			$result = $this->db->exec($query);
			if(PEAR::isError($result))
			{

				return false;
			}else
			{
				return true;
			}


		}

		public function setEdit($id)
		{
			$this->id= $id;
			$this->__setMode('edit');
			if($this->get($id) !== false)
			{
				$js = '';
				$config = array('url'=>array('site'=>URL_SITE), 'error'=>array('unexpected'=>ERR_UNEXPECTED), 'form_id'=>$this->getId(), 'delete_question'=>DELETE_QUESTION);
				$js  .= 'var config = ' . json_encode($config) . ";\n";
				$this->initQuestionTypes();
				foreach ($this->getQuestions() as $qId=>$question)
				{
					$this->questionInstances[$qId] = new $question['question_type']($qId);
					$this->questionInstances[$qId]->setFormId($this->getId());
				}
				$this->appendCss(URL_THEME . $this->getInfo('theme') . '/css/fireformlayout.css', true);
				$this->appendCss(URL_THEME . $this->getInfo('theme') . '/css/fireformpanel.css', true);
				$this->appendCss(URL_THEME . $this->getInfo('theme') . '/css/ie6.css', true, 'screen', 'lt IE 7');
				$this->appendJs(URL_JS . 'jquery.js', true);
				$this->appendJs(URL_JS . 'jquery.form.js', true);
				$this->appendJs(URL_JS . 'jquery.catfish.js', true);
				$this->appendJs(URL_JS . 'jqModal.js', true);
				$this->appendJs(URL_JS . 'jquery.tablednd.js', true);
				$this->appendJs(URL_JS . 'common.js', true);
				$this->appendJs(URL_JS . 'fireformedit.js', true);
				// show up the full list of question settings
				$questions = array();
				foreach ($this->questionInstances as $qId=>$instance)
				{
					$questions[$qId] = $instance->getSetting();
				}
				$js .= 'var formInfo = ' . json_encode($this->get()) . ";\n";
				$js .= 'var questions=' . json_encode($questions) . ";\n";
				$js .= ' $(document).ready(
					function()
					{

						$("#fireForm").jqm({modal:true});
					}
				)' . "\n";
				// show up the full lis tof functions available for call when click on each individual question
				$js .= ' var funcQEdit = {';
				$i = 0;
				foreach ($this->questionTypeInstances as $type=>$instance)
				{
					$js .= ($i++?',':'') . $type . ':' . clearUpJsFunction($instance->getFuncEditJS());
				}
				$js .= '};';
				$this->appendJs($js, false);
				$this->appendJs(URL_JS . 'fireformedit.js', true);
				return true;
			}else
			{
				return false;
			}
		}
		/**
		 * get the form html
		 * @return html;
		 *
		 */
		public function getHtml()
		{

			if($this->__isViewMode())
			{
				$this->html .= '<form id="fireFormForm' . $this->getId() .  '" action="' . URL_SITE . 'fireformsubmit.php' . '" method="POST" enctype="multipart/form-data">';
				$this->html .= '<input type="hidden" name="form_id" value="' . $this->getId() . '">';
			}
			$this->html .= '
									<h2>'  . $this->getInfo('title') . '</h2>
						<table class="tableFireForm" cellpadding="0" cellspacing="0">
						   	<tr>
						   <th class="fireFormQuestion">Label</th>
						   <th class="fireFormQBody">HTML Element</th>
						   <th class="fireFormInstruction">Instructions</th>
						   <th class="fire_form_actions">Action</th>
						</tr>
							<tbody class="tableFireFormBody">
							';

			foreach ($this->questionInstances as $questionInstance)
			{
				if($this->__isViewMode())
				{
					$this->html .= $questionInstance->getHtml() . "\n";
				}else

				{
					$this->html .= $questionInstance->getUpdateHtml() . "\n";
				}


			}

			$this->html .= '
							</tbody>

						</table>
			';
			if($this->__isViewMode())
			{
				$this->html .= '</form>';
			}
			return $this->html;
		}


		public function getQuestionSettingHtml()
		{
			$html = '';

			foreach ($this->questionTypeInstances as $questionInstance)
			{

				$html .= $questionInstance->getSettingHTML() . "\n";

			}

			return $html;
		}

		public function getQuestionAddHtml()
		{
			$html = '';
			foreach ($this->questionTypeInstances as $questionInstance)
			{

				$html .= $questionInstance->getAddHTML() . "\n";
			}
			return $html;
		}

		private function __getMode()
		{
			return $this->mode;
		}

		private function __setMode($mode)
		{
			$this->mode = $mode;
		}

		private function __isViewMode()
		{
			return ($this->__getMode() == 'view'?true:false);
		}

		public function getThemes()
		{
			$outputs = array();
			$fp = opendir(DIR_THEME_FF);
			while(false !== ($type = readdir($fp)))
			{
				if($type != '.' && $type != '..' && is_dir(DIR_THEME_FF . $type) && file_exists(DIR_THEME_FF . $type . DIRECTORY_SEPARATOR . 'css')&& file_exists(DIR_THEME_FF . $type . DIRECTORY_SEPARATOR . 'css/fireformlayout.css'))
				{
					$outputs[$type] = ucwords(strtolower(str_replace(array('-', '_'), '', $type)));
				}
			}
			return $outputs;
		}



		public function getYourForms($userId = null)
		{
			global $db;
			$outputs = array();
			if(is_null($userId))
			{

				$query = "SELECT user.*, form.*  FROM " . TBL_CATEGORY . ' form LEFT JOIN ' . TBL_USER . " user ON form.creator_id=user.id ORDER BY form.id DESC";

			}else
			{
				$query  = "SELECT * FROM " . TBL_CATEGORY . " WHERE creator_id=" . $db->quote($userId, 'integer') . ' ORDER BY id DESC';

			}

			$result = & $db->query($query);
			if(!PEAR::isError($result))
			{
				while($row = strip_slashes2($result->fetchrow()))
				{
					$outputs[] = $row;
				}
			}
			$result->free();
			return $outputs;
		}

		public function countResponds($formId=null, $startDate =null, $finishDate= null)
		{
			global $db;
			$formId = is_null($formId)?$this->id:$formId;
			$output = 0;
			$query = "SELECT count(id) total FROM " . TBL_RESPONDENT . " WHERE form_id=" . $db->quote($formId, 'integer');
			if(!is_null($startDate) && !is_null($finishDate))
			{
				$query .= " AND  cdatetime >=" . $db->quote($startDate, 'text') . " AND cdatetime <=" . $db->quote($finishDate, 'text');
			}elseif(!is_null($startDate))
			{
				$query .= " AND cdatetime >=" . $db->quote($startDate, 'text') ;
			}elseif(!is_null($finishDate))
			{
				$query .=  " AND   cdatetime <=" . $db->quote($finishDate, 'text');
			}

			$result = $db->query($query);
			if(PEAR::isError($result))
			{
				return false;
			}
			$row = $result->fetchrow();
			return $row['total'];
		}

		public function export($id, $startDate=null, $finishDate = null)
		{
			global $db;
			$this->id= $id;
			if($this->get($id) !== false)
			{
				$data = array();
				$query = "SELECT respondent.id FROM " . TBL_RESPONDENT . " respondent WHERE EXISTS (SELECT * FROM " . TBL_INFO . " respond WHERE respondent.id=respond.respondent_id) AND respondent.form_id=" . $db->quote($id, 'integer');

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

				$result = $db->query($query);
				if(PEAR::isError($result))
				{
					return false;
				}
				$respondents = array();
				while($row = $result->fetchrow())
				{
					$respondents[$row['id']] = $row['id'];
				}

				//init all question types
		       	$this->initQuestionTypes();

				foreach ($this->getQuestions() as $qId=>$question)
				{
					$this->questionInstances[$qId] = new $question['question_type']($qId);
					$this->questionInstances[$qId]->setFormId($this->getId());
				}
				$questionSettings = array();
				foreach ($this->questionInstances as $questionId =>$questionInstance)
				{
					if(($questionData =  $questionInstance->getResponds($questionId, $startDate, $finishDate)) !== false)
					{
						foreach ($respondents as $respondentId)
						{
							if(!isset($questionData[$respondentId]))
							{
								$questionData[$respondentId] = '';

							}
						}
						$data[$questionId] = $questionData;
					}
					if(($settings = $questionInstance->getSetting($questionId)) !== false)
					{
						$questionSettings[$questionId] = $settings['question'];
					}

				}


				include_once('Writer.php');

				$workbook = new Spreadsheet_Excel_Writer();
				$workbook->setVersion(8);

				$worksheet =& $workbook->addWorksheet('Form Data');
				$headerFormat =& $workbook->addFormat(array('Size' => 12,
	                                      'Align' => 'left',
											'FgColor'=>'grey',
											'Color'=>'white',
											'BorderColor'=>'white',
											'Border'=>1,
	                                     ));

				$j = 0;
				//generate the excel
				foreach ($data as $questionId=>$responds)
				{

					$worksheet->writeString(0, $j, $this->questionInstances[$questionId]->getSettingInfo('question'), $headerFormat);
					$i = 1;
					foreach ($responds as $respond)
					{
						$worksheet->write($i++, $j , $respond);
					}
					$j++;


				}
				//displayArray($data);
				$workbook->send('fireform_' . $id . date('YmdHis') . '.xls');

				$workbook->close();
			}else
			{
				return false;
			}



		}

	}