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
	include_once(CLASS_QUESTION);
	class Select extends Question 
	{

		
		public function __construct($id = null)
		{
			parent::__construct('select', $id);
			$this->extraSettings = array('width'=>150);
		}
		
		public function getName()
		{
			return SELECT_NAME;
		}

		public function  getInstructionText()
		{
			return CMM_DEFAULT_INSTRUCTION;
		}				
		public function save($d)
		{
			global $db;
			$query = "UPDATE " . $this->tableQuestion . " SET question=" . $db->quote($d['question'], 'text') . 
			", default_value=" . $db->quote($d['default_value'], 'text') . 
			", answer_required=" . $db->quote(empty($d['answer_required'])?0:1, 'text') . 
			", error_message=" . $db->quote($d['error_message']) . 
			", instruction=" . $db->quote($d['instruction']) . 
			", options = " . $db->quote($d['options'], 'text') . 
			", specify_allowed=" . $db->quote($d['specify_allowed'], 'text') . 
			", specify_label=" . $db->quote($d['specify_label'], 'text') . 
			" WHERE id=" . $db->quote($d['id'], 'integer') . " AND form_id=" . $db->quote($this->getFormId(), 'integer');
			
			$result = $db->query($query);
			if(PEAR::isError($result))
			{
				return false;
			}
			return true;			
		}
		

		
		public function getFields()
		{
			return array(
				
				'id',
				'question_type',
				'order_no',
				'form_id',
				'question',
				'instruction',
				'default_value',
				'answer_required',
				'error_message',
				'options',
				'specify_allowed',
				'specify_label',
			);
		}

		public function getFuncEditJS()
		{
	
			return 'function(qId) {
			var d = questions[qId];
			setInput(qId, "question"); 
			setInput(qId, "default_value");
			setTextarea(qId, "instruction"); 
			setInput(qId, "specify_label");
			setTextarea(qId, "options");
			setInput(qId, "error_message");
			setYesOrNo(qId, "answer_required");	
			setYesOrNo(qId, "specify_allowed");			
			}';
					
		}	

		

		

		/**
		 * get the default value when adding a new question
		 *
		 */
		public function getDefaultValues()
		{
			return array(
				'question_type'=>$this->getType(),
				'form_id'=>$this->getFormId(),
				'question'=>$this->getName(),
				'instruction'=>$this->getInstructionText(),
				'default_value'=>'',
				'answer_required'=>'0',
				'error_message'=>'',
				'options'=>CMM_OPTION1 . "\n" . CMM_OPTION2,
				'specify_allowed'=>'0',
				'specify_label'=>'',		
			);			
		}
		

		
		public  function getSettingHTML()
		{
			$body = '';
			$body .= '
			<tr>
				<th  valign="top"><label>' . CMM_QUESTION . '</label></th>
				<td >' . getQSettingText('question') .'</td>
				<td valign="top" rowspan="4">' . getQSettingTextarea('options', 5) . '</td>
				<th   valign="top" rowspan="2"><label>' . CMM_INSTRUCTION . '</label></th>
				<td    rowspan="2">' . getQSettingTextarea('instruction')  . '</td>					
			</tr>';
			$body .= '
			<tr>
				<th  valign="top"><label>' . CMM_DEFAULT_VALUE . '</label></th>
				<td  >' . getQSettingText('default_value') .'</td>
		
		
			</tr>';		
			$body .= '
			<tr>
				<th  valign="top"><label>' . CMM_ANSWER_REQUIRED . '</label></th>
				<td >' . getQSettingYesOrNo('answer_required') .'</td>
				<th  valign="top" ><label>' . CMM_SPECIFY_ALLOWED . '</label></th>
				<td  >' . getQSettingYesOrNo('specify_allowed')  . '</td>					
			</tr>';	
			$body .= '
			<tr>
				<th  valign="top"><label>' . CMM_ERROR_MESSAGE . '</label></th>
				<td >' . getQSettingText('error_message') .'</td>
				<th  valign="top"><label>' . CMM_SPECIFY_LABEL . '</label></th>
				<td >' . getQSettingText('specify_label')  . '</td>			
			</tr>';								
			return getQSetting($this->getName(), $this->getType(), $body);
		}
		

		
		public function getUpdateHTML($id = null)
		{
			$id = is_null($id)?$this->id:$id;
			$output = '';
			
			if(($info = $this->getSetting($id)) !== false)
			{
				$body = '<div class="fireFormFieldContainer" id="fireFormFieldContainer' . $info['id'] . '"><select name="' . $info['id'] . '" class="fireFormSelect" onchange="changeFireFormSelect(' . $info['id'] . ', this);" id="fireFormField' . $info['id'] . '">
						<option value="">' . CMM_PLEASE_SELECT . '</option>';
				foreach (explode("\n", $info['options']) as $v)
				{
					if(strlen(trim($v)))
					{
						$body .= '<option value="' . $v . '" ' . ($v == $info['default_value']?'selected':'') . '>'  . $v . '</option>';
					}
				}
				if($info['specify_allowed'])
				{
					$body .= '<option value="fireFormOthers">' . $info['specify_label'] . '</option>';
				}
				$body .= '</select></div>' ;
				if($info['specify_allowed'])
				{
					$body .= '<span class="fireFormSelectOthers" style="display:none" id="fireFormSelectOthers' . $info['id'] . '"><input type="text" class="fireFormOthers" name="fireFormOthers[' . $info['id'] . ']" id="fireFormOthers' . $info['id'] . '"></span>';
				}
				return getQuestionUpdateTplHTML($id, $info['question'], 
					$body, $info['instruction']); 
					

				
			}

			return false;
			
		}



		public function getAddHTML()
		{
			return getQAddHTML(SELECT_BTN_ADD, $this->getType());
		}		
		
		public function getHTML($id = null)
		{
			$id = is_null($id)?$this->id:$id;
			$output = '';
			
			if(($info = $this->getSetting($id)) !== false)
			{
				$body = '<div class="fireFormFieldContainer" id="fireFormFieldContainer' . $info['id'] . '"><select name="' . $info['id'] . '" class="fireFormSelect" onchange="changeFireFormSelect(' . $info['id'] . ', this);" id="fireFormField' . $info['id'] . '">
						<option value="">' . CMM_PLEASE_SELECT . '</option>';
				foreach (explode("\n", $info['options']) as $v)
				{
					if(strlen(trim($v)))
					{
						$body .= '<option value="' . $v . '" ' . ($v == $info['default_value']?'selected':'') . '>'  . $v . '</option>';
					}
				}
				if($info['specify_allowed'])
				{
					$body .= '<option value="fireFormOthers">' . $info['specify_label'] . '</option>';
				}
				$body .= '</select></div>' ;
				if($info['specify_allowed'])
				{
					$body .= '<span class="fireFormSelectOthers" style="display:none" id="fireFormSelectOthers' . $info['id'] . '"><input type="text" class="fireFormOthers" name="fireFormOthers[' . $info['id'] . ']" id="fireFormOthers' . $info['id'] . '"></span>';
				}
				return getQuestionTplHTML($id, $info['question'], 
					$body, $info['instruction']); 
					

				
			}

			return false;

		}
		/**
		 * this javascript function will be called when front-end users click the save and next page button
		 * it will validate the specified question and mark it red and return false if failed
		 */
		public function getFuncValidateJS()
		{


			$output = 'function(qId){
				var q = questions[qId];
				var type = q.question_type;
				funcHideErrors[type](qId);
				if(q.answer_required )
				{
					var slt = document.getElementById("fireFormField" + qId);
					if(slt.selectedIndex <= 0 || ($(slt).val() == "fireFormOthers" && $("#fireFormOthers" + qId).val() == ""))
					{
						funcShowErrors[type](qId);
						return false;
					}			
				}	
				return true;	
			}';				
			

			return $output;
		}
		
		public function getFuncShowErrorJS()
		{
			$output = 'function(qId){
				var q = questions[qId];
				var type = q.question_type;
				var slt = document.getElementById("fireFormField" + qId);
				if(slt.selectedIndex <= 0)
				{
					$("#fireFormFieldContainer" + qId).addClass("fireFormFieldContainerError");
				}else if($(slt).val() == "fireFormOthers" && $("#fireFormOthers" + qId).val() == "")
				{
					$("#fireFormOthers" + qId).addClass("fireFormFieldError");
				
				}else
				{
					$("#fireFormFieldContainer" + qId).addClass("fireFormFieldContainerError");
				}
				if(q.error_message != "" && q.error_message != null)
				{
					$("#fireFormFieldContainer" + qId).parent().append("<p class=\"fireFormErrorMsg\">" + q.error_message + "</p>");
				}	
						
			}';				
			return $output;
		}
		
		public function getFuncHideErrorJS()
		{
			$output = 'function(qId){
				var q = questions[qId];
				var type = q.question_type;
				var slt = document.getElementById("fireFormField" + qId);
				$("#fireFormOthers" + qId).removeClass("fireFormFieldError");
				$("#fireFormFieldContainer" + qId).removeClass("fireFormFieldContainerError");
				if(q.error_message != "" && q.error_message != null)
				{
					$("#fireFormFieldContainer" + qId).parent().children(".fireFormErrorMsg").remove();
				}
				
						
			}';				
			return $output;
		}
		
		public function saveAnswer($id, $respondentId)
		{
			$answer = $_POST[$id];
			if(!empty($_POST[$id]) && $_POST[$id] == 'fireFormOthers')
			{
				$answer = $_POST['fireFormOthers'][$id];
			}
			return $this->__doSaveAnswer($id, $respondentId,  $answer);		
		}		

		
		
	}