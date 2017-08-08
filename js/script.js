//Function for mailCompose.php, used to set value in username textbox
function listen(event, elem, func) {
    elem = document.getElementById(elem);
    if (elem.addEventListener)  // W3C DOM
        elem.addEventListener(event,func,false);
    else if (elem.attachEvent)  // IE DOM
        elem.attachEvent('on'+event, function(){ func(new W3CDOM_Event(elem)) } );
        // for IE we use a wrapper function that passes in a simplified faux Event object.
    else throw 'cannot add event listener';
}
function setUserName(frmObj)
{
	if (frmObj.contacts.value == '')
		{
			return;
		}
	email_address_value = replaceEmailAddress(frmObj.username.value, frmObj.contacts);
	email_address_value = replaceEmailFriend(email_address_value, frmObj.contacts);
	email_address_last_char = email_address_value.charAt(RTrim(email_address_value).length-1);
	if ((email_address_value.indexOf(',') == -1 || email_address_last_char != ',') && email_address_value != '')
		{
			email_address_value = email_address_value + ', ';
		}
	frmObj.username.value = email_address_value + frmObj.contacts.value + ', ';
	frmObj.username.focus();
}
function replaceEmailAddress(email_address_value, email_groups)
{
	email_address_value = email_address_value.replace(', '+email_groups.value,'');
	email_address_value = email_address_value.replace(email_groups.value+', ','');
	email_address_value = email_address_value.replace(email_groups.value,'');
	return email_address_value;
}
function replaceEmailFriend(email_address_value, email_friends)
{
	email_address_value = email_address_value.replace(', '+email_friends.value,'');
	email_address_value = email_address_value.replace(email_friends.value+', ','');
	email_address_value = email_address_value.replace(email_friends.value,'');
	return email_address_value;
}

// Function to select all check boxes
// called in mailInbox.php, mailSent.php, mailSaved.php, mailTrash.php
function selectAll(thisForm)
	{
		for (var i=0; i<thisForm.elements.length; i++)
			{
				if (thisForm.elements[i].type == "checkbox")
					{
						if(thisForm.checkall.checked)
							{
								thisForm.elements[i].checked=true;
							}
						else
							{
								thisForm.elements[i].checked=false;
							}
					}
			}
	}

function checkCheckBox(thisForm, check_all)
	{
		//need to replace with the code using jQuery
	}
function popupWindowUpload(url){
	window.open (url, "","status=0,toolbar=0,resizable=0,scrollbars=1");
}
function changeCategoryRequest(url, pars, method_type)
	{
		//need to replace with the code using jQuery
	}
function changeCategoryResponse(originalRequest){
		//need to replace with the code using jQuery
	}
function populateSubCategoryRequest(url, pars, method_type)
	{
		$Jq.ajax({
			type: method_type,
			url: url,
			data: pars,
			success: eval(populateSubCategoryResponse)
		 });
		return false;
	}
function populateSubCategoryResponse(data){
		var data = data;
		if(data)
			{
				$Jq('#selSubCategoryBox').html(data);
				helpTipInitialize();
			}
		else
			{
				return;
			}

	}
function deleteMultiCheck(check_atleast_one,anchor,delete_confirmation,formName,id,action)
{

	if(getMultiCheckBoxValue(formName, 'check_all',check_atleast_one, anchor, -100, -500))
	{
		Confirmation('selMsgConfirmMulti', 'msgConfirmformMulti', Array(id,'act', 'msgConfirmTextMulti'),
		Array(multiCheckValue, action, delete_confirmation), Array('value','value', 'innerHTML'), 50,300,anchor);
	}
}

function callAjaxGetCode(path, delLink,formName)
	{
		getCodeFormName=formName;
		delLink_value = delLink;
		new jquery_ajax(path, '','displayGetCode');
		return false;
	}

function displayGetCode(data)
	{
		//data = unescape(data.responseText);
		var obj = document.getElementById(getCodeFormName);

/*		if(data.indexOf(session_check)>=1)
			data = data.replace(session_check_replace,'');
		else
			return; */
		data = $Jq.trim(data);
		$Jq('#'+getCodeFormName).html('<div id="selDisplayWidth">'+data+'</div>');
		Confirmation(getCodeFormName, 'msgConfirmform', Array(getCodeFormName), Array('<div id="selDisplayWidth">'+data+'</div>'), Array('innerHTML'), -100, -500);
		return false;
	}
function setProfileImage(url){
//need to replace with the code using jQuery
}

function updateSetProfile(data){
//need to replace with the code using jQuery
}


//function to disable submit button and to show processing image
var processingRequest = function(){
	//need to replace with the code using jQuery
}

var replayDiv = '';
var div_id = '';
function ajaxSubmitForm(url, frmName, divname, id){
//need to replace with the code using jQuery

}

function ajaxRelatedResult(data)
	{
		//need to replace with the code using jQuery
	}

function ajaxReplayDiv(url, pars, divname)
	{
		//need to replace with the code using jQuery
	}

function ajaxReplayDivResult(data)
	{
		//need to replace with the code using jQuery
	}

function hideChannel()
	{
		if(channelDivSet && allowChannelHide)
			{
				hideChannelDiv();
			}
	}

function hideChannelDiv()
	{
	   var channelMoreContentDiv = $Jq('#channelMoreContent').get(0);
	    if (channelDivSet) {
		if(channelMoreContentDiv!=null)
	        //channelMoreContentDiv.style.display = 'none';
	        $Jq(channelMoreContentDiv).css('display', 'none')
	        //if (doiframe) {
	            var iframe = $Jq('selBackgroundIframe').get(0);
				if(iframe!=null){
	            	$Jq(iframe).css('display','none');
	            }
	        //}//EOF if-doiframe
	    }//EOF if-noClose
		channelDivSet = false;
	}

function hideMenuMore()
	{
		if(menuMoreDivSet && allowMenuMoreHide)
			{
				hideMenuMoreDiv();
			}
	}

function hideMenuMoreDiv()
	{
	   var menuMoreContentDiv = $Jq('#menuMoreContent').get(0);
	    if (menuMoreDivSet) {
			if(menuMoreContentDiv!=null)
		        //menuMoreContentDiv.style.display = 'none';
		        $Jq(menuMoreContentDiv).css('display', 'none')
		        var iframe = $Jq('#selBackgroundIframe').get(0);
				if(iframe!=null){
		           	$Jq(iframe).hide();
		        }
	    }
		menuMoreDivSet = false;
	}

function displayMenuMore()
	{
		menuMoreDivSet = true;
		allowMenuMoreHide = false;;
		$Jq('#'+pageId).mouseover(function(){
			hideMenuMore();
		});
		//listen('mousemove', pageId, hideMenuMore);
		//listen('mouseout', $('menuMoreContent'), hideMenuMore);
		var menu_more_anchor = $Jq('#menu_more_anchor').get(0);
		var selBackgroundIframe = $Jq('#selBackgroundIframe').get(0);
		var menuMoreContent = $Jq('#menuMoreContent').get(0);
		$Jq(menuMoreContent).show();
		$Jq(selBackgroundIframe).css('width', menuMoreContent.offsetWidth + "px");
		$Jq(selBackgroundIframe).css('height', menuMoreContent.offsetHeight + "px");
		$Jq(selBackgroundIframe).css('top', (findPosChildElementTop(menu_more_anchor) + parseInt(menu_more_top_position)) + "px");
    	$Jq(selBackgroundIframe).css('left', (findPosChildElementLeft(menu_more_anchor) + parseInt(menu_more_left_position)) +"px");
		$Jq(menuMoreContent).css('top', (findPosChildElementTop(menu_more_anchor) + parseInt(menu_more_top_position)) + "px");
    	$Jq(menuMoreContent).css('left', (findPosChildElementLeft(menu_more_anchor) + parseInt(menu_more_left_position)) + "px");
		$Jq(selBackgroundIframe).show();
	}
function displayChannel()
	{
		channelDivSet = true;
		allowChannelHide = false;;
		//listen('mousemove', pageId, hideChannel);
		$Jq('#'+pageId).mouseover(function(){
			hideChannel();
		});
		var channel_menu_anchor = $Jq('channel_menu_anchor').get(0);
		var selBackgroundIframe = $Jq('selBackgroundIframe').get(0);
		var channelMoreMenuContent = $Jq('channelMoreContent').get(0);
		channelMoreMenuContent.show();
		$Jq(selBackgroundIframe).css('width', channelMoreMenuContent.offsetWidth + "px");
		$Jq(selBackgroundIframe).css('height',channelMoreMenuContent.offsetHeight + "px");
		$Jq(selBackgroundIframe).css('top', (findPosChildElementTop(channel_menu_anchor) + parseInt(menu_channel_top_position)) + "px");
    	$Jq(selBackgroundIframe).css('left', (findPosChildElementLeft(channel_menu_anchor) + parseInt(menu_channel_left_position)) +"px");
		$Jq(channelMoreMenuContent).css('top', (findPosChildElementTop(channel_menu_anchor) + parseInt(menu_channel_top_position)) + "px");
    	$Jq(channelMoreMenuContent).css('left', (findPosChildElementLeft(channel_menu_anchor) + parseInt(menu_channel_left_position)) + "px");
		$Jq(selBackgroundIframe).show();
	}

//Fix for IE 7 and IE 8 to get elements position which is inside other elements
function findPosChildElementLeft(obj)
	{
	    var curleft = 0;
	    if(obj.offsetParent)
	        while(1)
	        {
	          curleft += obj.offsetLeft;
	          if(!obj.offsetParent)
	            break;
	          obj = obj.offsetParent;
	        }
	    else if(obj.x)
	        curleft += obj.x;
	    return curleft;
	}

//Fix for IE 7 and IE 8 to get elements position which is inside other element (Child Elements)
function findPosChildElementTop(obj)
	{
	    var curtop = 0;
	    if(obj.offsetParent)
	        while(1)
	        {
	          curtop += obj.offsetTop;
	          if(!obj.offsetParent)
	            break;
	          obj = obj.offsetParent;
	        }
	    else if(obj.y)
	        curtop += obj.y;
	    return curtop;
	}

var subscription_action = function()
	{
		//need to replace with the code using jQuery
	}

function subscription_result(data)
	{
		///need to replace with the code using jQuery
	}

var sub_action = '';
var sub_confirm_top = '';
var sub_confirm_left = '';
var sub_confirm_toObj = '';
var get_subscription_options = function() {
	var sub_owner_id = arguments[0];
	sub_confirm_top = arguments[1];
	sub_confirm_left = arguments[2];
	sub_confirm_toObj = arguments[3];

	pars = 'owner_id='+sub_owner_id+'&action=get_subscription_details';

	$Jq.ajax({
		type: "POST",
		url: member_manipulation_url,
		data: pars,
		success: function(originalRequest){
					$Jq('#common_confirm_yes').hide();
					$Jq('#common_confirm_no').hide();
					Confirmation('selAjaxWindow', 'frmAjaxWindow', Array('selAjaxWindowInnerDiv'), Array(originalRequest), Array('innerHTML'));
				}
 	});
}

function toggleSubscriptionCheckBox(sub_field_id) {
	if($Jq('#sub_'+sub_field_id).is(':checked')) {
		$Jq('#sub_label_'+sub_field_id).removeClass('clsSubscriptionUnChecked');
		$Jq('#sub_label_'+sub_field_id).addClass('clsSubscriptionChecked');
		$Jq('#sub_label_'+sub_field_id).attr('title', LANG_JS_SUBSCRIBE);
	} else {
		$Jq('#sub_label_'+sub_field_id).removeClass('clsSubscriptionChecked');
		$Jq('#sub_label_'+sub_field_id).addClass('clsSubscriptionUnChecked');
		$Jq('#sub_label_'+sub_field_id).attr('title', LANG_JS_UNSUBSCRIBE);
	}
}

var sub_scontent_id = '';
var sub_saction = '';
var sub_smodule = '';
var sub_sstype = '';
var subscription_sep_action = function()
	{
		//need to replace with the code using jQuery
	}

function subscription_sep_result(data)
	{
		//need to replace with the code using jQuery
	}

var subscriptionOptionEle = '';
var sub_opt_delay = '';
var subscription_timeout = '';
var subscription_hover = false;
var getSubscriptionOption = function()
	{
		//need to replace with the code using jQuery
	}

function showSubscriptionOption(data)
	{
		//need to replace with the code using jQuery
	}

function hideSubscriptionOption()
	{
		//need to replace with the code using jQuery
	}

var showDefaultSubscriptionOption = function()
	{
	//need to replace with the code using jQuery
	}

var sub_cat_elem = '';
var getCategoriesForSubscription = function()
	{

		var sub_url = member_manipulation_url;
		if(arguments[1] == 'sub_category')
			{
				sub_cat_ele = '#sub_category_container';
				sub_url += '?action=get_sub_categories&sub_module='+$Jq('#sub_module').val()+'&category_id='+arguments[0];
			}
		else
			{
				var sub_module = arguments[0];
				sub_cat_ele = '#category_container';
				sub_url += '?action=get_categories&sub_module='+sub_module;
			}

		new jquery_ajax(sub_url, '', 'subscription_categories_result');
	}

function subscription_categories_result(data)
	{
		$Jq(sub_cat_ele).html(data);
	}


function checkDate(entry) {
    var mo, day, yr;
    var reDate = /\b\d{4}[-]\d{1,2}[-]\d{1,2}\b/;
    var valid = reDate.test(entry);
    if (valid) {

        var delimChar = "-";
        var delim1 = entry.indexOf(delimChar);
        var delim2 = entry.lastIndexOf(delimChar);

        yr = parseInt(entry.substring(0, delim1), 10);
        mo = parseInt(entry.substring(delim1+1, delim2), 10);
        day = parseInt(entry.substring(delim2+1), 10);

        var testDate = new Date(yr, mo-1, day);
        if (testDate.getDate() == day){
            if (testDate.getMonth() + 1 == mo){
                if (testDate.getFullYear() == yr){
                    return true;
				}
			}
		}
	}
    return false;
}


function getAge(value)
	{
		var yy, mm, dd;
		var delimChar = "-";

        var delim1 = value.indexOf(delimChar);
        var delim2 = value.lastIndexOf(delimChar);

        yy = parseInt(value.substring(0, delim1), 10);
        mm = parseInt(value.substring(delim1+1, delim2), 10);
        dd = parseInt(value.substring(delim2+1), 10);

  		days = new Date();
		gdate = days.getDate();
		gmonth = days.getMonth();
		gyear = days.getFullYear();
		if (gyear < 2000) gyear += 1900;
		age = gyear - yy;
		if ((mm == (gmonth + 1)) && (dd <= parseInt(gdate)))
			{
				age = age;
			}
		else
			{
				if (mm <= (gmonth))
					{
						age = age;
					}
				else
					{
						age = age - 1;
   					}
			}
		if (age == 0) age = age;

		return age;
	}
/*
W3CDOM_Event(currentTarget)
    is a faux Event constructor. it should be passed in IE when a function
    expects a real Event object. For now it only implements the currentTarget
    property and the preventDefault method.

    The currentTarget value must be passed as a paremeter at the moment    of
    construction.
*/
function W3CDOM_Event(currentTarget) {
    this.currentTarget  = currentTarget;
    this.preventDefault = function() { window.event.returnValue = false }
    return this;
}