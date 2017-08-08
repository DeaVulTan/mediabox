var numberoftimes = 0;
var thetimer1 = 0;
var thetimer2 = 0;
function incrementit()
	{
		thetimer1 += 1;
		thespacer = "";
		if (thetimer1 > 59)
			{
				thetimer2 += 1;
				thetimer1 = 0;
			}
		if (thetimer1 < 10)
			{
				thespacer = "0";
			}
		var obj = document.getElementById("uploadTimer");
		obj.innerHTML = thetimer2 + ":" + thespacer + thetimer1;
		setTimeout('incrementit()',1000);
	}

function onlyonce()
	{
		document.video_upload_form.upload_video.value=uploading_file;;
		numberoftimes += 1;
		if (numberoftimes > 1)
			{
				var themessage = upload_in_progress;
				if (numberoftimes == 3)
					{
						themessage = upload_multiple_times;
					}
				alert(themessage);
				return false;
			}
		else
			{
				setTimeout('incrementit()',1000);
				return true;
			}
	}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}
function chkValidFileFormat()
	{
		var str = Trim($('video_file').value);
		var index = str.lastIndexOf('.');
		if(index>=0)
			{
				str = str.substring(index+1);
				str = str.toLowerCase();
				valid_format = valid_format.toLowerCase();
				index = valid_format.indexOf(string);
				if(index<0)
					return true;
				return false;
			}
		return true;
	}
function chkMandatoryFields()
	{
		return true;
		var flv_upload_type = getCheckedValue(document.video_upload_form.flv_upload_type);

		if((flv_upload_type=='Youtube' && $('externalsite_viewvideo_url').value=='') || (flv_upload_type=='Normal' && $('video_file').value=='') || $('video_title').value=='' || getCheckedValue(document.video_upload_form.video_category_id)=='')

			{
				alert(upload_err_msg);
				return false;
			}
		if(chkValidTags($('video_tags').value))
			{
				alert(invalid_tag);
				return false;
			}
		if(flv_upload_type=='Normal' && chkValidFileFormat())
			{
				alert(invalid_file);
				return false;
			}
		onlyonce();
		return true;
	}
function disabledFormFields(arr)
	{
		var i, obj;
		for (i=0;i<arr.length;i++)
			{
				obj = document.getElementById(arr[i]);
				obj.disabled = true;
			}
	}
function enabledFormFields(arr)
	{
		var i, obj;
		for (i=0;i<arr.length;i++)
			{
				obj = document.getElementById(arr[i]);
				obj.disabled = false;
			}
	}

if(upload_from_file)
{
	function thisMovie(movieName)
	{
		  if (navigator.appName.indexOf ("Microsoft") !=-1)
		  {
		    return window.document[movieName];
		  }
		  else {
		   return window.document[movieName];
		  }
	}

	function createJSFCommunicatorObject(playerObj)
	{
		fc = new JSFCommunicator(playerObj);
	}

	var onUploadComplete = function()
	{
		var str = arguments[0];
		var index = str.lastIndexOf('.');
		str = str.substring(index+1);
		document.video_upload_form.file_extern.value=str;
		document.video_upload_form.submit();
		//alert("Upload Completed...." + " Parametes: "+arguments[0]);
	}
	function onClickThis()
	{
			fc.callFunction("_level0","uploadSelcted");
	}
	function showNormalUpload()
	{
		var obj = document.getElementById('selUploadFlash');
		obj.style.display = 'none';
		var obj = document.getElementById('selUploadNormal');
		obj.style.display = '';
		return false;
	}
	function showFlashUpload()
	{
		var obj = document.getElementById('selUploadNormal');
		obj.style.display = 'none';
		var obj = document.getElementById('selUploadFlash');
		obj.style.display = '';
		return false;
	}

	function makeDisable()
	{
		document.getElementById('Upload').disabled = true;
		//Upload.disabled = true;
	}
	/*function makeEnable()
	{
		document.getElementById('Upload').disabled = false;
		Upload.disabled = false;
	}*/
}

function initializeFlvType()
{

	if (flv_upload_type == 'Normal')
		{
			disabledFormFields(Array('externalsite_viewvideo_url'));enabledFormFields(Array('video_file'));
		}
	else if (flv_upload_type == 'Youtube')
		{
			disabledFormFields(Array('video_file'));enabledFormFields(Array('externalsite_viewvideo_url'));
		}
}
