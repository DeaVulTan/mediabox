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
	class Textarea extends Question 
	{

		
		public function __construct($id = null)
		{
			parent::__construct('textarea', $id);
			$this->extraSettings = array('width'=>150, 'rows'=>5);
		}
		
		public function getName()
		{
			return TEXTAREA_NAME;
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
			", width = " . $db->quote($d['width'], 'integer') . 
			", rows=" . $db->quote($d['rows'], 'integer') . 
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
				'width',
				'rows'
			);
		}

		public function getFuncEditJS()
		{
	
			return 'function(qId) {
			var d = questions[qId];
			setInput(qId, "question"); 
			setInput(qId, "default_value");
			setTextarea(qId, "instruction"); 
			setInput(qId, "width");
			setInput(qId, "rows");
			setInput(qId, "error_message");
			setYesOrNo(qId, "answer_required");			
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
				'width'=>'',
				'rows'=>'',
				'rule'=>'',			
			);			
		}
		

		
		public  function getSettingHTML()
		{
			$body = '';
			$body .= '
			<tr>
				<th  valign="top"><label>' . CMM_QUESTION . '</label></th>
				<td  >' . getQSettingText('question') .'</td>
				<th  valign="top" rowspan="2"><label>' . CMM_INSTRUCTION . '</label></th>
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
				<th  valign="top" ><label>' . CMM_WIDTH . '</label></th>
				<td  >' . getQSettingText('width')  . '</td>					
			</tr>';	
			$body .= '
			<tr>
				<th  valign="top"><label>' . CMM_ERROR_MESSAGE . '</label></th>
				<td >' . getQSettingText('error_message') .'</td>
				<th  valign="top"><label>' . CMM_ROWS . '</label></th>
				<td >' . getQSettingText('rows')  . '</td>			
			</tr>';								
			return getQSetting($this->getName(), $this->getType(), $body);
		}
		

		
		public function getUpdateHTML($id = null)
		{
			$id = is_null($id)?$this->id:$id;
			$output = '';
			
			if(($info = $this->getSetting($id)) !== false)
			{
				
				return getQuestionUpdateTplHTML($id, $info['question'], '<textarea  
				style="' .   (!empty($info['width'])?'width:' . intval($info['width']) . 'px;':'')  . '" rows="' . intval($info['rows']) . '" class="fireFormTextarea" id="fireFormField' . $id . '" name="' . $info['id'] . '">' . $info['default_value'] . '</textarea>'
				, $info['instruction']); 
					

				
			}

			return false;
			
		}



		public function getAddHTML()
		{
			return getQAddHTML(TEXTAREA_BTN_ADD, $this->getType());
		}		
		
		public function getHTML($id = null)
		{
			$id = is_null($id)?$this->id:$id;
			$output = '';
			
			if(($info = $this->getSetting($id)) !== false)
			{
				
				return getQuestionTplHTML($id, $info['question'], '<textarea  
				style="' .   (!empty($info['width'])?'width:' . intval($info['width']) . 'px;':'')  . '" rows="' . intval($info['rows']) . '" class="fireFormTextarea" id="fireFormField' . $id . '" name="' . $info['id'] . '">' . $info['default_value'] . '</textarea>'
				, $info['instruction']); 
					

				
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
					if($("#fireFormField" + qId).val() == "" )
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
				$("#fireFormField" + qId).addClass("fireFormFieldError");
				if(q.error_message != "" && q.error_message != null)
				{
					$("#fireFormField" + qId).parent().append("<p class=\"fireFormErrorMsg\">" + q.error_message + "</p>");
				}
						
			}';				
			return $output;
		}
		
		public function getFuncHideErrorJS()
		{
			$output = 'function(qId){
				var q = questions[qId];
				var type = q.question_type;
				$("#fireFormField" + qId).removeClass("fireFormFieldError");
				if(q.error_message != "" && q.error_message != null)
				{
					$("#fireFormField" + qId).siblings(".fireFormErrorMsg").remove();
				}
						
			}';				
			return $output;
		}
			

		
		

		

		
		
	}