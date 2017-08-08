$(document).ready(
	function()
	{
		$('#fireFormMenu li').click(function(){$('#fireFormMenu li').removeClass('active'); $(this).addClass('active');  clickFireFormMenu(this.id);});
		$('#fireFormPanel').catfish({
			animation: 'fade',
			closeLink: '#fireFormClose',
			height: 170
		});
		$('#fireFormMin').click(
			function()
			{
				$('#fireFormMax').toggleClass('fireFormLink').show();
				//$(this).toggleClass('fireFormLink').hide();
			    $('#fireFormPanel').height(18);						
			}
		);
		$('#fireFormMax').click(
			function()
			{
				$('#fireFormMin').toggleClass('fireFormLink').show();
				//$(this).toggleClass('fireFormLink').hide();
			    $('#fireFormPanel').height(150);					
			}
		);	
		refreshFireFormMode();	
		refreshQuestionRows();
		$('#fireForm_title').dblclick(
			function()
			{
				clickFireFormMenu('fireFormSetting');
			}
		);
	}
);

function saveForm()
{

    var options = {
    	dataType:'json',
    	type:'POST',
		error: function (data, status, e) 
		{
			var err = config.error.unexpected;
			if(typeof(e)  == 'string')
			{
				err += '\n' + e;
			}
			fireFormAjaxError(err);
		},
 	
        beforeSubmit:  function(){fireFormAjaxStart();},  // pre-submit callback 
        success:       function(json)
        {
        	if(typeof(json) != 'object' || typeof(json.error) == 'undefined')
        	{
        		
        		fireFormAjaxError(config.error.unexpected);
        	}
			else if(!empty(json.error))
			{
				fireFormAjaxError(json.error);
			}else
			{
				if(formInfo.theme != json.formInfo.theme)
				{
					//reload the page if theme changed
					window.location.reload();
				}else
				{
					for(var j in json.formInfo)
					{
						formInfo[j] = json.formInfo[j];
					}				
					fireFormAjaxComplete();					
				}
				

			}        	
        	
        }

    };
    $('#fireFormfireForm').ajaxSubmit(options);	
    return false;
}





function clickFireFormMenu(menuID)
{
	$('#fireFormPanelMC>div').hide();
	var panelId =  menuID + 'Panel';
	$('#' + panelId).show();
	switch(menuID)
	{
		case 'fireFormSetting':
			$('#' + panelId + ' input[@name=title]').val(formInfo.title);
			$('#' + panelId + ' input[@name=submit_label]').val(formInfo.submit_label);
			$('#' + panelId + ' input[@name=url]').val(formInfo.url);
			$('#' + panelId + ' input[@name=email]').val(formInfo.email);
			$('#' + panelId + ' input[@name=subject]').val(formInfo.subject);
			var creatorId = $('#' + panelId + ' select[@name=creator_id]').get(0);
			if($(creatorId).length)
			{
				for(var i = 0 ; i < creatorId.options.length; i++)
				{
					if(creatorId.options[i].value == formInfo.creator_id)
					{
						creatorId.options[i].selected = true;
					}else
					{
						creatorId.options[i].selected = false;
					}
				}
			}
			var theme = $('#' + panelId + ' select[@name=theme]').get(0);
			if($(theme).length)
			{
				for(var i = 0 ; i < theme.options.length; i++)
				{
					if(theme.options[i].value == formInfo.theme)
					{
						theme.options[i].selected = true;
					}else
					{
						theme.options[i].selected = false;
					}
				}
			}	
			$('#' + panelId + ' input[@name=mode]').each(
				function()
				{
					if(this.value == formInfo.mode)
					{
						this.checked = true;
					}else
					{
						this.checked = false;
					}
				}
			);	
			refreshFireFormMode();			
			
			break;
		case 'fireFormQuestion':
			break;
	}
	
}

function fireFormQAdd(qType, relativeTo,  position, relativeValue)
{
    var position = typeof(position)!= 'undefined'?position: 'after'; //either before or after
    var relativeTo = typeof(relativeTo)!= 'undefined'?relativeTo: 'form'; //form or question
    var relativeValue  = typeof(relativeValue)!= 'undefined'?relativeValue: 0; //question id or empty
    var settings = {'question_type':qType, 'relative_to':relativeTo, 'position':position, 'post_action':'add_question', 'form_id':config.form_id, 'relative_value':relativeValue};
	$.ajax({
		dataType:'json',
		type:'POST',
		url:config.url.site + 'fireformmanager.php',
		data:settings,
		error: function (data, status, e) 
		{
			var err = config.error.unexpected;
			if(typeof(e)  == 'string')
			{
				err += '\n' + e;
			}
			fireFormAjaxError(err);
		},
		success:function(json)
		{
        	if(typeof(json) != 'object' || typeof(json.error) == 'undefined')
        	{
        		
        		fireFormAjaxError(config.error.unexpected);
        	}
			else if(!empty(json.error))
			{
				
				fireFormAjaxError(json.error);
			}else
			{
				questions[json.question_id] = {};
				for(var i in json.question_info)
				{
					if(typeof(json.question_info[i]) != 'function')
					{
						questions[json.question_id][i] = json.question_info[i];
					}
				}
				switch(relativeTo)
				{
					case 'form':
						if(position == 'before')
						{
							$(json.html).prependTo('.tableFireFormBody');
							
						}else
						{
							$(json.html).appendTo('.tableFireFormBody');
						}					
						break;
					default:
						if(position == 'before')
						{
							$(json.html).insertBefore('#fireFormRow' + relativeTo);
						}else
						{
							$(json.html).insertAfter('#fireFormRow' + relativeTo);
						}
						//append to question
				}
				refreshQuestionRows();
				fireFormAjaxComplete();
				$('#fireFormPanelMC>div').hide();
				$('#fireFormQuestionPanel').show();
				fireFormEditQ(json.question_id);		
			}
		}	
	}
	);	
    return false;	
}


function fireFormEditQ(qId)
{
	$('#fireFormPanelMC>div').hide();
	funcQEdit[questions[qId].question_type](qId);
	$('#fireFormSettingFor' + questions[qId].question_type + ' input[@name=id]').val(qId);
	$('#fireFormSettingFor' + questions[qId].question_type + ' input[@name=form_id]').val(formInfo.id);
	$('#fireFormSettingFor' + questions[qId].question_type).show();	
}
/**
*	
*/
function fireFormRemoveQ(question_id)
{
	if(window.confirm(config.delete_question))
	{
		    var settings = {'form_id':config.form_id, 'question_id':question_id, 'post_action':'delete_question'};
			$.ajax({
				dataType:'json',
				type:'POST',
				url:config.url.site + 'fireformmanager.php',
				data:settings,
				error: function (data, status, e) 
				{
					var err = config.error.unexpected;
					if(typeof(e)  == 'string')
					{
						err += '\n' + e;
					}
					fireFormAjaxError(err);
				},
				success:function(json)
				{
		        	if(typeof(json) != 'object' || typeof(json.error) == 'undefined')
		        	{
		        		
		        		fireFormAjaxError(config.error.unexpected);
		        	}
					else if(!empty(json.error))
					{
						
						fireFormAjaxError(json.error);
					}else
					{
		
						$('#fireFormRow' + question_id).remove();
						fireFormAjaxComplete();
					}
				}	
			}
			);			
	}

	    return false;	
}


function refreshQuestionRows()
{

	$('.fireFormRow').unbind().dblclick(
		function()
		{
			
			var qId = getNum(this.id);
			fireFormEditQ(qId);

		}
	).mouseover(
		function()
		{
			$(this).addClass('fireFormMouseover');
			$(this).children('.fire_form_actions').children('.fireFormRowDelete').show();
			$(this).children('.fire_form_actions').children('.fireFormRowEdit').show();
		}
	).mouseout(
		
		function()
		{
			$(this).removeClass('fireFormMouseover');
			$(this).children('.fire_form_actions').children('.fireFormRowDelete').hide();
			$(this).children('.fire_form_actions').children('.fireFormRowEdit').hide();
		}
	).each(
		function()
		{
			//var qId = getNum(this.id);
		}
	);
	var currentRowPosition = 0;
	$(".tableFireFormBody").tableDnD(
	{onDragClass: "fireFormDrag",
    onDrop: function(tbody, row) 
    {
		var rowPosition = 0;      	
    	 var settings = {'form_id':config.form_id,  'post_action':'reorder_question'};
		for(var i = 0; i < tbody.rows.length; i++)
		{
			if(row === tbody.rows[i])
			{
				rowPosition = i;
			}
			settings['questions[' + i + ']'] = getNum(tbody.rows[i].id);
		}
	    if(rowPosition != currentRowPosition)
	    {
			$.ajax({
				dataType:'json',
				type:'POST',
				url:config.url.site + 'fireformmanager.php',
				data:settings,
				error: function (data, status, e) 
				{
					var err = config.error.unexpected;
					if(typeof(e)  == 'string')
					{
						err += '\n' + e;
					}
					fireFormAjaxError(err);
				},
				success:function(json)
				{
		        	if(typeof(json) != 'object' || typeof(json.error) == 'undefined')
		        	{
		        		
		        		fireFormAjaxError(config.error.unexpected);
		        	}
					else if(!empty(json.error))
					{
						
						fireFormAjaxError(json.error);
					}else
					{
		
						fireFormAjaxComplete();
					}
				}	
			}
			);		    	
	    }

	    return false;			
    },
    onDragStart:function(tbody, row)
    {
		for(var i = 0; i < tbody.rows.length; i++)
		{
			if(row === tbody.rows[i])
			{
				currentRowPosition = i;
			}
		}    	
    }
    
	
	}
	);
}
/**
*	save the setting for the specified question
*/
function fireFormPanelSaveQ(qType)
{
    var options = {
    	dataType:'json',    	
    	type:'POST',
    	url:config.url.site  + 'fireformmanager.php',
		error: function (data, status, e) 
		{
			var err = config.error.unexpected;
			if(typeof(e)  == 'string')
			{
				err += '\n' + e;
			}
			fireFormAjaxError(err);
		}, 	
        beforeSubmit:  function(){fireFormAjaxStart();},  // pre-submit callback 
        success:       function(json)
        {
        	if(typeof(json) != 'object' || typeof(json.error) == 'undefined')
        	{
        		
        		fireFormAjaxError(config.error.unexpected);
        	}
			else if(!empty(json.error))
			{
				fireFormAjaxError(json.error);
			}else
			{
				for(var j in json.questionInfo)
				{
					questions[json.questionInfo.id][j] = json.questionInfo[j];

				}
				
				fireFormAjaxComplete();
			}        	
        	
        }

    };
    $('#fireFormFireForm' + qType).ajaxSubmit(options);	
    return false;	
}


/**
*	set input value for one-line text type of question
*/
function setInput(qId, fieldName, onChangeCallback)
{
	var q = questions[qId];
	var value = q[fieldName] == null?'':q[fieldName];
	var type = q.question_type;
	var jquerySelector = '#fireFormSettingFor' + type + ' input[@name=' + fieldName + ']';

	$(jquerySelector).val(value).unbind().keyup(function(){
		
		if(typeof(onChangeCallback) == 'function')
		{
			onChangeCallback();
			
		}else
		{
			questionSync(qId, fieldName, this.value);
		}
		
						
		
	});
	
	
};
/**
*	set input value for one-line text type of question
*/
function setTextarea(qId, fieldName, onChangeCallback)
{
	var q = questions[qId];
	var value = q[fieldName] == null?'':q[fieldName];
	var type = q.question_type;
	var jquerySelector = '#fireFormSettingFor' + type + ' textarea[@name=' + fieldName + ']';
	$(jquerySelector).val(value).unbind('keyup').keyup(function(){
		
		if(typeof(onChangeCallback) == 'function')
		{
			onChangeCallback();
			
		}else
		{
			questionSync(qId, fieldName,this.value);		
		}
						
		
	});
	
	
};

function setYesOrNo(qId, fieldName, onChangeCallback)
{
	var q = questions[qId];
	var value = q[fieldName] == null?'0':q[fieldName];
	var type = q.question_type;
	var jquerySelector = '#fireFormSettingFor' + type + ' input[@name=' + fieldName + ']';

	$(jquerySelector).each(
		function()
		{
			if(this.value == value)
			{
				this.checked = true;
			}else
			{
				this.checked = false;
			}
		}
	).unbind().click(
		function()
		{
			if(typeof(onChangeCallback) == 'function')
			{
				onChangeCallback();				
			}else
			{
				questionSync(qId, fieldName, this.value);
			}
						
		}
	);

	
	
};

function setRadio(qId, fieldName, onChangeCallback)
{
	var q = questions[qId];
	var value = q[fieldName] == 'vertical'?'vertical':'horizontal';
	var type = q.question_type;
	var jquerySelector = '#fireFormSettingFor' + type + ' input[@name=' + fieldName + ']';

	$(jquerySelector).each(
		function()
		{
			if(this.value == value)
			{
				this.checked = true;
			}else
			{
				this.checked = false;
			}
		}
	).unbind().click(
		function()
		{
			if(typeof(onChangeCallback) == 'function')
			{
				onChangeCallback();				
			}else
			{
				questionSync(qId, fieldName, this.value);
			}
						
		}
	);	
}


function questionSync(qId, fieldName, value, jsonConfig)
{

	var q = questions[qId];
	var type = q.question_type;	
	switch(fieldName)
	{
		case 'question':
			$('#fireFormRow' + qId + ' th label').html(value);
			break;
		case 'default_value':
			switch(type)
			{
				case 'text':
				case 'password':
					$('#fireFormRow' + qId + ' input[@name=' + qId + ']').val(value);
					break;
				case 'textarea':
					$('#fireFormRow' + qId + ' textarea[@name=' + qId + ']').val(value);
					
				case 'select':
					var q = document.getElementById('fireFormField' + qId);
					for(var i = q.options.length - 1; i > 0; i--)
					{
						if(q.options[i].value == value)
						{
							q.options[i].selected = true;
							
						}else
						{
							q.options[i].selected = false;
						}
					}						
					break;
				case 'radio':					
					$('#fireFormRow' + qId + ' input[@name=' + qId +']').each(
						function()
						{
							if(this.value == value)
							{
								this.checked = true;
							}else
							{
								this.checked = false;
							}
						}
					);
					break;
				case 'checkbox':
					var values = value.split(",");	
					$('#fireFormRow' + qId + ' input[@name=' + qId +']').each(
						function()
						{
							if(values.inArray(this.value, false))
							{
								this.checked = true;
							}else
							{
								this.checked = false;
							}
						}
					);					
					break;
				
					
			}
			break;
		case 'instruction':
			$('#fireFormRow' + qId + ' .fireFormInstruction').html(value);
			break;
		case 'width':			
			switch(type)
			{
				case 'text':
				case 'password':
					$('#fireFormRow' + qId + ' input[@name=' + qId + ']').width(value + 'px');
					break;
				case 'textarea':
					$('#fireFormRow' + qId + ' textarea[@name=' + qId + ']').width(value + 'px');
					break;
			}
			break;
		case 'max_length':
			$('#fireFormRow' + qId + ' input[@name=' + qId + ']').attr('max_length', value);
			break;
		case 'rows':
			$('#fireFormRow' + qId + ' textarea[@name=' + qId + ']').attr('rows', getNum(value));
			break;
		case 'options':
			var defaultValue = $('#fireFormSettingFor' + type + ' input[@name=default_value]').val();
			var display = 'vertical';
			$('#fireFormSettingFor' + type + ' input[@name=display]').each(
				function()
				{
					if(this.checked)
					{
						display = this.value;
					}
				}
			);	
			if(display == "horizontal")
			{
				var suffixWas = '<br>';
				var suffix = "&nbsp;";
			}else
			{
				var suffix = "<br>";
				var suffixWas = "&nbsp;";
			}	
			var questionOptions = value.split("\n");	
			$('#fireFormSelectOthers' + qId).remove();				
			switch(type)
			{
				case 'select':
					var q = document.getElementById('fireFormField' + qId);
					for(var i = q.options.length - 1; i > 0; i--)
					{
						q.options[i] = null;
					}	
					for(var i in questionOptions)
					{
						if(typeof(questionOptions[i]) == "string" && questionOptions[i] != "")
						{
							q.options[q.options.length] = new Option(questionOptions[i], questionOptions[i], false, (questionOptions[i] == defaultValue?true:false));
						}
					}						
													
					break;
				case 'radio':
					$('#fireFormFieldContainer' + qId).empty();
					var html = '';
					var num = 1;
					for(var i in questionOptions)
					{
						if(typeof(questionOptions[i]) == "string" && questionOptions[i] != "")
						{
							if(num++ > 1)
							{
								html += suffix;
							}
							html += '<input type="radio" onclick="changeFireFormRadio(' + qId + ', this);" name="' + qId + '" value="' + questionOptions[i] + '" class="fireFormFieldRadio"> <label class="fireFormFieldLabel">' + questionOptions[i] + '</label>';
						}
					}
					$(html).appendTo('#fireFormFieldContainer' + qId);					
					break;
				case 'checkbox':	
					$('#fireFormFieldContainer' + qId).empty();
					var html = '';
					var num = 1;
					for(var i in questionOptions)
					{
						if(typeof(questionOptions[i]) == "string" && questionOptions[i] != "")
						{
							if(num++ > 1)
							{
								html += suffix;
							}
							html += '<input type="checkbox" onclick="changeFireFormCheckbox(' + qId + ', this);" name="' + qId + '" value="' + questionOptions[i] + '" class="fireFormFieldCheckbox"> <label class="fireFormFieldLabel">' + questionOptions[i] + '</label>';
						}
					}
					$(html).appendTo('#fireFormFieldContainer' + qId);									
					break;
			}
			questionSync(qId, 'default_value', $('#fireFormSettingFor' + type + ' input[@name=default_value]').val());	
			questionSync(qId, 'specify_allowed', $('#fireFormSettingFor' + type + ' input:checked[@name=specify_allowed]').val());		
			break;
		case 'specify_allowed':			
			switch(type)
			{
				case 'select':
					$('#fireFormSelectOthers' + qId).remove();	
					var q = document.getElementById('fireFormField' + qId);
					for(var i = q.options.length - 1; i > 0; i--)
					{
						if(q.options[i].value == 'fireFormOthers')
						{
							q.options[i] = null;
							break;
						}
					}	
					if(value == '1')
					{
						q.options[q.options.length] = new Option($('#fireFormSettingFor' + type + ' input[@name=specify_label]').val(), "fireFormOthers", false, false);
						$('<span class="fireFormSelectOthers" style="display:none" id="fireFormSelectOthers' + qId  +  '"><br><input type="text" class="fireFormOthers" name="fireFormOthers[' + qId + ']" id="fireFormOthers' + qId + '"></span>').insertAfter(q);								
					}													
					break;
				case 'radio':
					$('#fireFormSelectOthers' + qId).remove();	
					$('#fireFormRow' + qId + ' .fireFormOthers').remove();
					$('#fireFormRow' + qId + ' .fireFormOtherDelimiters').remove();
					var suffix = ($('#fireFormSettingFor' + type + ' input:checked[@name=display]').val() == 'vertical'?'<br class="fireFormOtherDelimiters">':'<span class="fireFormOtherDelimiters">&nbsp;</span>');
					if(value == '1')
					{						
						
						$(suffix + '<input type="radio"  onclick="changeFireFormRadio(' + qId + ', this);" class="fireFormFieldRadio fireFormOthers" name="' + qId + '" value="fireFormOthers"> <label class="fireFormOthers">' + $('#fireFormSettingFor' + type + ' input[@name=specify_label]').val() + '</label><span class="fireFormSelectOthers" style="display:none" id="fireFormSelectOthers' + qId  +  '">' + suffix + '<input type="text" class="fireFormOthers" name="fireFormOthers[' + qId + ']" id="fireFormOthers' + qId + '"></span>').appendTo('#fireFormFieldContainer' + qId);							    
					}					
					break;
				case 'checkbox':
					$('#fireFormSelectOthers' + qId).remove();	
					$('#fireFormRow' + qId + ' .fireFormOthers').remove();
					$('#fireFormRow' + qId + ' .fireFormOtherDelimiters').remove();
					var suffix = ($('#fireFormSettingFor' + type + ' input:checked[@name=display]').val() == 'vertical'?'<br class="fireFormOtherDelimiters">':'<span class="fireFormOtherDelimiters">&nbsp;</span>');
					if(value == '1')
					{						
						
						$(suffix + '<input type="checkbox"  onclick="changeFireFormCheckbox(' + qId + ', this);" class="fireFormFieldCheckbox fireFormOthers" name="' + qId + '[]" value="fireFormOthers"> <label class="fireFormOthers">' + $('#fireFormSettingFor' + type + ' input[@name=specify_label]').val() + '</label><span class="fireFormSelectOthers" style="display:none" id="fireFormSelectOthers' + qId  +  '">' + suffix + '<input type="text" class="fireFormOthers" name="fireFormOthers[' + qId + ']" id="fireFormOthers' + qId + '"></span>').appendTo('#fireFormFieldContainer' + qId);							    
					}										
					break;
			}		
	
			break;
		case 'specify_label':
			switch(type)
			{
				case 'select':
					var q = document.getElementById('fireFormField' + qId);
					for(var i = q.options.length - 1; i > 0; i--)
					{
						if(q.options[i].value == 'fireFormOthers')
						{
							q.options[i].text = value;
						}
					}						
													
					break;
				case 'radio':
				case 'checkbox':	
					$('#fireFormRow' + qId + ' label.fireFormOthers').html(value);
					break;
			}		
			break;
		case 'display':
			switch(type)
			{
				case 'radio':
				case 'checkbox':
					questionSync(qId, 'options', $('#fireFormSettingFor' + type + ' textarea[@name=options]').val());	
					break;
			}
			break;
	}
};





