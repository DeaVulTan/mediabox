function submitFireForm(formId)
{
	var isValid = true;
	for(var i in questions)
	{
		if(typeof(questions[i]) != 'function')
		{
			var q = questions[i];
			if(!funcValidate[q.question_type](q.id))
			{
				isValid = false;
			}
		}
	}
	if(isValid)
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
					var invalidQuestions = [];
					if(typeof(json.invalid_questions) != 'undefined')
					{
						for(var i in json.invalid_questions)
						{
							if(typeof(json.invalid_questions[i]) != 'function')
							{

								var q = questions[json.invalid_questions[i]];

								invalidQuestions[invalidQuestions.length] = q.id;							
								funcShowErrors[q.question_type](q.id);							
							}						
	
						}
					}
					for(var i in questions)
					{
						if(typeof(questions[i]) != 'function')
						{
							if(!invalidQuestions.inArray(i, true))
							{
								var q = questions[i];
								funcHideErrors[q.question_type](q.id);	
							}
						}
					}					
					fireFormAjaxError(json.error);
				}else
				{
					document.location.href = json.url;				
					fireFormAjaxComplete();
				}        	
	        	
	        }
	
	    };
	    $('#fireFormForm' + formId).ajaxSubmit(options);			
	}else
	{
		
		var error = new Array(config.error.invalid1, config.error.invalid2);
		
		fireFormAjaxError(error);
	}

    return false;
}