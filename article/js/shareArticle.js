var result_div;
var session_check = 'heck|||||||||valid|||||||||login';
var session_check_replace = 'check|||||||||valid|||||||||login';
var import_contacts_link;
//function for check box manage
function CA(form_name,check_all,isO,noHL)
	{
		var frm = eval('document.'+form_name);
		//var obj_email_address = document.getElementById('email_address');
		//obj_email_address.value='';
		if(frm.check_all.checked)
			{
				for (var i=0;i<frm.elements.length;i++)
					{
						var e=frm.elements[i];
						if ((e.name != check_all) && (e.type=='checkbox'))
							{
								e.checked = true;
								checkWhichArraySelect(e);
							}
					}
			}
		else
			{
				for (var i=0;i<frm.elements.length;i++)
					{
						var e=frm.elements[i];
						if ((e.name != check_all) && (e.type=='checkbox'))
							{
								e.checked = false;
								checkWhichArraySelect(e);
							}
					}
			}
	}

/***********Trim comma seperator**********/
function TrimComma(TRIM_VALUE)
	{
		if(TRIM_VALUE.length < 1)
			{
				return "";
			}
		TRIM_VALUE = RTrimComma(TRIM_VALUE);
		TRIM_VALUE = LTrimComma(TRIM_VALUE);
		if(TRIM_VALUE=="")
			{
				return "";
			}
		else
			{
				return TRIM_VALUE;
			}
	}

function RTrimComma(VALUE)
	{
		var w_space = String.fromCharCode(44);
		var v_length = VALUE.length;
		var strTemp = "";
		if(v_length < 0)
			{
				return "";
			}
		var iTemp = v_length -1;
		while(iTemp > -1)
			{
				if(VALUE.charAt(iTemp) == w_space)
					{
					}
				else
					{
						strTemp = VALUE.substring(0,iTemp +1);
						break;
					}
				iTemp = iTemp-1;

			}
		return strTemp;
	}

function LTrimComma(VALUE)
	{
		var w_space = String.fromCharCode(44);
		if(v_length < 1)
			{
				return"";
			}
		var v_length = VALUE.length;
		var strTemp = "";

		var iTemp = 0;

		while(iTemp < v_length)
			{
				if(VALUE.charAt(iTemp) == w_space)
					{
					}
				else
					{
						strTemp = VALUE.substring(iTemp,v_length);
						break;
					}
				iTemp = iTemp + 1;
			}
		return strTemp;
	}
/***********End comma seperator**********/

function checkWhichArraySelect(e)
	{
		if(e.name=='relation_arr[]')
			updateEmailList(e);
		else
			updateEmailFriends(e);
	}

function replaceEmailAddress(email_address_value, email_groups)
	{
		email_address_value = email_address_value.replace(', ['+email_groups.value+']','');
		email_address_value = email_address_value.replace('['+email_groups.value+'], ','');
		email_address_value = email_address_value.replace('['+email_groups.value+']','');
		return email_address_value;
	}

function replaceEmailFriend(email_address_value, email_friends)
	{
		email_address_value = email_address_value.replace(', ('+email_friends.value+')','');
		email_address_value = email_address_value.replace('('+email_friends.value+'), ','');
		email_address_value = email_address_value.replace('('+email_friends.value+')','');
		return email_address_value;
	}

function updateEmailList(email_groups)
	{
		var obj_email_address = parent.document.getElementById('email_address');
		var email_address_value = Trim(obj_email_address.value)
		//email_address_value = StringReplcae(' ', '', email_address_value);
		var index = '';
		while(index<email_address_value.length)
			{
				email_address_value = StringReplcae(',,', ',', email_address_value);
				index++;
			}
		if(email_groups.checked)
			{
				if(!email_address_value)
					{
						email_address_value = replaceEmailAddress(email_address_value, email_groups);
						email_address_value = '['+email_groups.value+']';
					}
				else
					{
						email_address_value = replaceEmailAddress(email_address_value, email_groups);
						email_address_value += ', ['+email_groups.value+']';
					}
			}
		else
			email_address_value = replaceEmailAddress(email_address_value, email_groups);

		email_address_value = TrimComma(email_address_value);
		obj_email_address.value = email_address_value;
	}

function updateEmailFriends(email_friends)
	{
		var obj_email_address = parent.document.getElementById('email_address');
		var email_address_value = Trim(obj_email_address.value)
		//email_address_value = StringReplcae(' ', '', email_address_value);
		email_address_value = StringReplcae(',,', ',', email_address_value);

		if(email_friends.checked)
			{
				if(!email_address_value)
					{
						email_address_value = replaceEmailFriend(email_address_value, email_friends);
						email_address_value = '('+email_friends.value+')';
					}
				else
					{
						email_address_value = replaceEmailFriend(email_address_value, email_friends);
						email_address_value += ', ('+email_friends.value+')';
					}
			}
		else
			email_address_value = replaceEmailFriend(email_address_value, email_friends);

		email_address_value = TrimComma(email_address_value);
		obj_email_address.value = email_address_value;
	}

//
function callFriendRelation(path, div_id)
	{
		result_div = div_id;
		new jquery_ajax(path, '', 'friendRelationResult');
		return false;
	}

function friendRelationResult(data)
	{
		data = unescape(data);
		var obj = document.getElementById(result_div);
		if(data)
			{
				data = data
				obj.innerHTML = data;
				checkAlreadyChecked();
				return;
			}
		else
			{
				location.replace(replace_url);
			}
	}

function checkAlreadyChecked()
	{
		form_name = 'formContactList';
		var frm = eval('document.'+form_name);
		var email_address_value = $jq('#email_address').val();
		email_address_value = email_address_value.split(',');

		for(var i=0;i<email_address_value.length;i++)
			{
				email_address_value[i] = Trim(email_address_value[i]);
			}
		for (i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				for(var j=0;j<email_address_value.length;j++)
					{
						if('('+frm.elements[i].value+')'==email_address_value[j])
							{
								e.checked = true;
								break;
							}
						if('['+frm.elements[i].value+']'==email_address_value[j])
							{
								e.checked = true;
								break;
							}
					}
			}
	}

//To Send mail in ajax - ShareArticle,...
function sendAjaxEmail(path, div_id)
	{

		var frm = document.formEmailList;
		var pars = '';
		for (var i=0;i<frm.elements.length;i++)
			{
				var e = frm.elements[i];
				if (e.type!='submit')
					{
						pars += '&'+e.name+'='+encodeURIComponent(e.value);
					}
			}

		var path = path+pars;
		result_div = div_id;
		//For View Article
		if(typeof(view_article_ajax_page_loading) != 'undefined')
			{
				if(view_article_ajax_page_loading)
					{
						$Jq('#share_submitted').html(view_article_ajax_page_loading);
						$Jq('#share_loader_row').show();
						if(typeof(recalculate_scroll_view_article) != 'undefined')
							{
								if(recalculate_scroll_view_article)
									{
										scrollbar.recalculateLayout();
										scrollbar.scrollTo('bottom');
									}
							}
					}
			}
		//FOR VIEW ARTICLE PAGE
		recalculateScrollAndChangeStatus();
		//document.getElementById('selShareArticle').innerHTML = loading;
		new jquery_ajax(path, '', 'ajaxEmailResult');
		return false;
	}

var sendAjaxEmailImage = function()
	{
		path = arguments[0];
		result_div = arguments[1];

		var frm = document.formEmailList;
		var pars = '';
		for (var i=0;i<frm.elements.length;i++)
			{
				var e = frm.elements[i];
				if (e.type!='button' && e.name!='captcha_value')
					{
						pars += '&'+e.name+'='+encodeURIComponent(e.value);
					}
			}
		pars += '&captcha_value='+frm.captcha_value.value;

		var path = path+pars;
		//FOR VIEW ARTICLE PAGE
		recalculateScrollAndChangeStatus();
		//document.getElementById('selShareArticle').innerHTML = loading;
		new jquery_ajax(path, '', 'ajaxEmailResult');
		return false;
	}

var sendAjaxEmailHoneyPot = function()//(path, div_id)
	{
		path = arguments[0];
		result_div = arguments[2];

		var frm = document.formEmailList;
		var pars = '';
		for (var i=0;i<frm.elements.length;i++)
			{
				var e = frm.elements[i];
				if (e.type!='button')
					{
						pars += '&'+e.name+'='+encodeURIComponent(e.value);
					}
			}
		if(!$Jq('#'+arguments[1]) && $Jq('#'+arguments[1]).val()!='')
			{
				$Jq('#commentSelMsgError').html('Errors Found');
				$Jq('#selMsgError').show();
				return false;
			}
		var path = path+pars;
		//document.getElementById('selShareArticle').innerHTML = loading;
		//FOR VIEW ARTICLE PAGE
		recalculateScrollAndChangeStatus();
		new jquery_ajax(path, '', 'ajaxEmailResult');
		return false;
	}


function ajaxEmailResult(data)
	{
		data = unescape(data);
		var obj = document.getElementById(result_div);
		//hideAjaxTabs(result_div);
		//show_ajax_div();
		//obj.style.display = 'block';
		/*if(data.indexOf(session_check)>=1)
			{
				data = data.replace(session_check_replace,'');
			}
		else
			{
				return;
			}*/
		obj.innerHTML = data;
		//For View Article
		if($Jq('#share_loader_row').get())
			$Jq('#share_loader_row').hide();
		if(typeof(recalculate_scroll_view_article) != 'undefined')
			{
				if(recalculate_scroll_view_article)
					{
						scrollbar.recalculateLayout();
						scrollbar.scrollTo('top');
					}
			}
	}

function loadImportContactsLightWindow(import_href, import_title)
	{
		//myLightWindow.activateWindow({ href: import_href, type: 'page', title: import_title, height:160, width:200 });
		$Jq.fancybox({
                    'width'				: 300,
                    'height'			: 300,
                    'autoScale'     	: false,
                    'href'              : import_href,
                    'transitionIn'		: 'none',
                    'transitionOut'		: 'none',
                    'centerOnScroll'	: true,
                    'onClosed'			: function()
											{
												$Jq('#import_contacts').css('display', 'block');
											}
                });
			$Jq('#import_contacts').css('display', 'none');
	}

//For VIEW ARTICLE PAGE
function recalculateScrollAndChangeStatus()
	{
		if(typeof(view_article_ajax_page_loading) != 'undefined')
			{
				if(view_article_ajax_page_loading)
					{
						$Jq('#share_submitted').html(view_article_ajax_page_loading);
						$Jq('#share_loader_row').show();
						if(typeof(recalculate_scroll_view_article) != 'undefined')
							{
								if(recalculate_scroll_view_article)
									{
										scrollbar.recalculateLayout();
										scrollbar.scrollTo('bottom');
									}
							}
					}
			}
	}