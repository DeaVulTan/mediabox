function trim(str, chars) {
    return ltrim(rtrim(str, chars), chars);
}

function getLineBreakForTextarea()
{
	var lineBreak = "\n";
	if($.browser.msie)
	{
		lineBreak = "\r";
	}
	return lineBreak;
	
}

function ltrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}

function rtrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
Array.prototype.inArray = function (value,caseInsensitive)
{
	var i;
	for (i=0; i < this.length; i++) 
	{
		// use === to check for Matches. ie., identical (===),
		if(caseInsensitive)
		{ //performs match even the string is case sensitive
			if (this[i].toLowerCase() == value.toLowerCase()) 
			{
				return true;
			}
		}else
		{
			if (this[i] == value) 
			{
				return true;
			}
		}
	}
	return false;
};

function inJson(value, json)
{
	for(var i in json)
	{
		if(json[i] == value)
		{
			return true;
		}
	}
	return false;
}

function getNum(str)
{
	
	if(typeof(str) != 'undefined' && str != '')
	{
		var r = str.match(/[\d\.]+/g);	
		if(typeof(r) != 'undefined' &&  r &&  typeof(r[0]) != 'undefined')
		{
			return r[0];
		}		
	}
	return 0;
};
function tableRuler(selector, className)
{
	var className = typeof(className) == 'undefined'?'over':className;
    var rows = $(selector);
    $(rows).each(function(){
        $(this).mouseover(function(){
            $(this).addClass(className);
        });
        $(this).mouseout(function(){
            $(this).removeClass(className);
        });
    });
};

function confirmDelete(url, msg)
{
	if(window.confirm(msg))
	{
		document.location.href = url;
	}else
	{
		return false;
	}
	
};

function empty( mixed_var ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Philippe Baumann
    // +      input by: Onno Marsman
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: LH
    // +   improved by: Onno Marsman
    // +   improved by: Francesco
    // *     example 1: empty(null);
    // *     returns 1: true
    // *     example 2: empty(undefined);
    // *     returns 2: true
    // *     example 3: empty([]);
    // *     returns 3: true
    // *     example 4: empty({});
    // *     returns 4: true
    
    var key;
    
    if (mixed_var === ""
        || mixed_var === 0
        || mixed_var === "0"
        || mixed_var === null
        || mixed_var === false
        || mixed_var === undefined
    ){
        return true;
    }
    if (typeof mixed_var == 'object') {
        for (key in mixed_var) {
            if (typeof mixed_var[key] !== 'function' ) {
              return false;
            }
        }
        return true;
    }
    return false;
}
function fireFormAjaxStart()
{
	$("#fireForm>div").hide();
	 $('#fireFormAjaxProgress').show();
	 $("#fireForm").jqmShow();
}

function fireFormAjaxError(error, jqmShow)
{
	 $("#fireForm>div").hide();

	 
	 $("#fireForm>div").hide();
	 if(typeof(error) == 'array' || typeof(error) == 'object')
	 {
	 	
	 	var errors = error;
	 }else
	 {
	 	var errors = error.split('\n');
	 }
	 
	 var html = '';
	 html += '<ul class="fireFormAjaxErrorItem">';
	 for(var i in errors)
	 {
	 	if(typeof(errors[i]) == 'string' && errors[i].replace(/^\s+|\s+$/, '') != '')
	 	{
	 		html += '<li>' + errors[i] + '</li>';
	 		
	 	}
	 	
	 }
	 html += '</ul>';
	 $('#fireForm .fireFormAjaxErrorBody').empty().append(html);
	 $('#fireFormAjaxError').show();
	 $("#fireForm").jqmShow();	
	 

};

function fireFormAjaxComplete()
{
	$("#fireForm").jqmHide();
};


function confirmDelete(url, msg)
{
	if(window.confirm(msg))
	{
		document.location.href = url;
	}
	return false;
}

function refreshFireFormMode()
{

	switch($('#fireFormfireForm input[@name=mode]:checked').val())
	{
		case 'email':
		case 'both':
			$('.fireformEmail').show();
			break;
		case 'db':
		default:
			$('.fireformEmail').hide();
	}
}

function changeFireFormSelect(qId, elem)
{
	if(elem.value == 'fireFormOthers')
	{
		$('#fireFormSelectOthers' + qId).show();
	}else
	{
		$('#fireFormSelectOthers' + qId).hide();
		$('#fireFormOthers' + qId).val('');
	}
}

function changeFireFormRadio(qId, elem)
{

	if(elem.value == 'fireFormOthers')
	{
		$('#fireFormSelectOthers' + qId).show();
	}else
	{
		$('#fireFormSelectOthers' + qId).hide();
		$('#fireFormOthers' + qId).val('');
	}
}

function changeFireFormCheckbox(qId, elem)
{
	if($("#fireFormRow" + qId + " input:checked[@value=fireFormOthers][@name=\'" + qId + "[]\']").length)
	{
		$('#fireFormSelectOthers' + qId).show();
	}else
	{
		$('#fireFormSelectOthers' + qId).hide();
		$('#fireFormOthers' + qId).val('');
	}	
}

/**
*	check if the advcheckbox have been checked to be 1
*/
function isAdvCheckboxTrue(selector)
{
	var isSelected = false;
	$(selector).each(function(){
		if(typeof(this.checked) != "undefined" && this.checked && this.value == "1")
		{
			isSelected = true;

		}
	});
	return isSelected;	
};
/**
*	check if at least one of radio checkbix
*/
function isRadioSelect(selector)
{
	var isSelected = false;
	$(selector).each(function(){
		if(this.checked)
		{
			isSelected =  true;
		}
	});
	return isSelected;
};
/**
*	check if at least one of checkbox checked
*/
function isCheckboxSelect(selector)
{
	var isSelected = false;

	$(selector).each(function(){
		if(this.checked)
		{
			isSelected = true;
			
		}
	});
	return isSelected;	
};