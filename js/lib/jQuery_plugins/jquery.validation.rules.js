/*
 * jQuery validation rules that are customizable
 *
 */
//jQuery new/modified rules to validated input fields
//To validate country select box
$Jq.validator.addMethod(
	"selectCountry",
	function(value, element) {
		if (element.value == "")
			{
				return false;
			}
		else
			{
				return true;
			}
	},
	LANG_JS_err_tip_country
);
//To validate email field
$Jq.validator.addMethod(
	"isValidEmail",
	function(value, element){
		return this.optional(element) || /^[_a-z0-9-]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i.test(value);
	},
	LANG_JS_err_tip_email
);
//To validate date field
$Jq.validator.addMethod(
  	"isValidDate",
  	function (value, element) {
    	// put your own logic here, this is just a example
    	//return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
    	return value.match(/^\d\d\d\d-\d\d?-\d\d?$/);
  	},
	LANG_JS_err_tip_date_format
);

//pass the allowed file formats
$Jq.validator.methods.isValidFileFormat = 	function (value, element, ext_param_str) {
		if(value == '')
			return true;
		//allowed upload formats ..
  		var extensions = ext_param_str.split('|');
  		var parts = value.split('.');
		var file_ext = parts[parts.length-1].toLowerCase();
		for (i = 0; i < extensions.length; i++)
		{
    		if(extensions[i] == file_ext)
    			{
    				return true;
    			}
		}
  	};

//To validate multiple email address
$Jq.validator.addMethod(
	"isValidMultiEmail",
	function(value, element){
		var emails = value.split(',');
		var result=0;
		for(var i = 0; i < emails.length; i++) {
			 /^[_a-z0-9-]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i.test(emails[i]) ? result=1 : result=0;
		}
		return (result) ? true : false;
	},
	LANG_JS_err_tip_email
);

//To validate date value
$Jq.validator.addMethod(
  	"isValidDateVal",
  	function (value, element) {
    	var result=false;
    	result = value.match(/^\d\d\d\d-\d\d?-\d\d?$/)?true:false;
    	if(result)
    		{
    			result = checkDate(value);
    		}
    	return result;
  	},
	LANG_JS_err_tip_date_format
);

//To validate minimum age limit
$Jq.validator.addMethod(
  	"isValidMinAge",
  	function (value, element, params) {
  		age = getAge(value);
		if(age < params)
    		return false;
    	else
    		return true;
  	},
	LANG_JS_err_tip_date_format
);

//To validate Maximum age limit
$Jq.validator.addMethod(
  	"isValidMaxAge",
  	function (value, element, params) {
		age = getAge(value);
		if(age > params)
    		return false;
    	else
    		return true;
  	},
	LANG_JS_err_tip_date_format
);

//To validate user type select box
$Jq.validator.addMethod(
	"selectUserType",
	function(value, element) {
		if (element.value == "")
			{
				return false;
			}
		else
			{
				return true;
			}
	},
	LANG_JS_err_tip_required
);

//To validate Special characters
$Jq.validator.addMethod(
  	"checkSpecialChr",
  	function (value, element, params) {
 	    data=element.value;
	    var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?~_";
	    for (var i = 0; i < data.length; i++) {
	  	if (iChars.indexOf(data.charAt(i)) != -1) {
	  	 	return false;
	  	}
	  	else
	  	{
	  	   return true;
	  	}
	  }
  	},
	LANG_JS_ALPHA
);

//To validate selected date not to be passed date
$Jq.validator.addMethod(
  	"chkInValidPreDate",
  	function (value, element, params)
	{
		var dateSelected = value.split('-');
		var today = new Date();
		var dd = today.getDate();
		if(dateSelected[2]<dd)
		{
			return false;
		}
		else
		{
		  return true;
		}
  	},
	LANG_JS_ALPHA
);

//To validate selected date not to be passed date
$Jq.validator.addMethod(
  	"chkValidTags",
  	function (value, element, params)
	{
		var tags_arr = $Jq.trim(value).split(' ');
		for(i=0; i<tags_arr.length; i++)
		{
			tag = tags_arr[i];
			if( ($Jq.trim(tag).length < params[0]) || ($Jq.trim(tag).length > params[1]) )
				return false;
		}
		return true;
  	},
	LANG_JS_err_tip_invalid_tag
);

//To validate Time Format like 00:00:00
$Jq.validator.addMethod(
  	"chkValidTimeFormat",
  	function (value, element, params)
	{
		var timeFormat = /^(\d{1,2}):(\d{2})(:00)?([ap]m)?$/;
		if(regs = element.value.match(timeFormat))
		 {
			 return true;
		 }
		 else
		 {
           return false;
		 }
		 return true;
  	},
	LANG_JS_time_valid_format
);


