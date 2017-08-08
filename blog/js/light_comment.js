var result_div;

var light_addToComment = function()
	{
		if(arguments[0])
			{
				if(!dontUse)
					addCommentsUrl = arguments[0];
			}

		var f = '';

		var frm = document.addComments;
		for (var i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				if (e.type!='button' && e.name!='captcha_value')
					{
						var ovalue = Trim(e.value);
						if(ovalue)
							{
								ovalue = replace_string(ovalue, '\n', '<br />');
								f += ovalue;
							}
						else
							{
								e.value = '';
								e.focus();
								return false;
							}
					}
			}
		if(captcha!=frm.captcha_value.value)
			{
				$Jq('#commentSelMsgError').html('Invalid Captcha');
				$Jq('#selMsgError').show();
				return false;
			}
		if(!reply_comment_id)
		{
			var currpath = addCommentsUrl+'&page=post_comment&comment_id='+comment_id+'&type=edit&f='+encodeURIComponent(f);
			callAjaxUpdate(currpath,'selCommentBlock');
		}
		else
		{
			var replypath=replyUrl;
			var pars = '&page=post_comment&comment_id='+reply_comment_id+'&f='+encodeURIComponent(f)+'&user_id='+owner;
			new jquery_ajax(replypath, pars, 'light_ajaxResultComment');
		}
		return false;
	}


var light_addToCommentRecaptcha = function()
	{

		if(arguments[0])
			{
				if(!dontUse)
					addCommentsUrl = arguments[0];
			}

		var f = '';

		var frm = document.addComments;
		for (var i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				//if (e.type!='button' && e.name!='recaptcha_response_field'  && e.name!='recaptcha_challenge_field')
				if (e.type=='textarea')
					{
						var ovalue = Trim(e.value);
						if(ovalue)
							{
								ovalue = replace_string(ovalue, '\n', '<br />');
								f += ovalue;
							}
						else
							{
								e.value = '';
								e.focus();
								return false;
							}
					}
			}
		/*var recaptcha = '';
		recaptcha = '&recaptcha_challenge_field='+$('recaptcha_response_field').value+'&recaptcha_response_field='+$('recaptcha_challenge_field').value;*/

		var dontCheckFields = 'textarea';
		var extra_fields = '';
		extra_fields = makeQueryAsFormFieldCommentValues('addComments', dontCheckFields);
		if(extra_fields)
			extra_fields = '&'+extra_fields;


		if(!reply_comment_id)
			{
				var currpath = addCommentsUrl+'&page=post_comment&comment_id='+comment_id+extra_fields+'&type=edit&f='+encodeURIComponent(f);
				callAjaxUpdate(currpath,'selCommentBlock');
			}
		else
			{
				var replypath = replyUrl;
				var pars = '&page=post_comment&comment_id='+reply_comment_id+extra_fields+'&f='+encodeURIComponent(f);
				new jquery_ajax(replypath, pars,'light_ajaxResultComment');
			}
		return false;
	}

function makeQueryAsFormFieldCommentValues(form_name)
	{
		var query = '';
		var frm = eval('document.'+form_name);
		for(var i=0;i<frm.elements.length;i++){
				var e=frm.elements[i];
				if (e.type!='button' && e.type!='checkbox' && e.type!='textarea'){
						query += e.name+'='+e.value+'&';
					}
			}
		query =query.substring(0,query.length-1);
		return query;
	}

var light_addToCommentHoneyPot = function()
	{
		if(arguments[0])
			{
				if(!dontUse)
					addCommentsUrl = arguments[0];
			}

		var f = '';
		var frm = document.addComments;

		for (var i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				if (e.type!='button' && e.name!='captcha_value' && e.name!=arguments[1])
					{
						var ovalue = Trim(e.value);
						if(ovalue)
							{
								ovalue = replace_string(ovalue, '\n', '<br />');
								f += ovalue;
							}
						else
							{
								$Jq('#selMsgError').show();
								$Jq('#selMsgError').html(no_comment_error_msg);

								//$Jq('#commentSelMsgError').html(no_comment_error_msg);
								//$Jq('#selMsgError').show();
								e.value = '';
								e.focus();
								return false;
							}
					}
			}
		if(!$Jq("#"+arguments[1]) && $Jq("#"+arguments[1]).val() != '')
			{
				$Jq('#commentSelMsgError').html('Errors Found');
				$Jq('#selMsgError').show();
				//alert_manual('Errors Found', 'alertHyperLink', 1000, 500);
				return;
			}
	if(!reply_comment_id)
		{
			var currpath = addCommentsUrl+'&page=post_comment&comment_id='+comment_id+'&type=edit&f='+encodeURIComponent(f);
				callAjaxUpdate(currpath,'selCommentBlock');
		}
		else
		{
			var replypath=replyUrl;
			var pars = '&page=post_comment&comment_id='+reply_comment_id+'&f='+encodeURIComponent(f)+'&user_id='+owner;
			new jquery_ajax(replypath, pars, 'light_ajaxResultComment');
		}
		return false;
	}

var light_addToCommentNoCaptcha = function()
	{

		if(arguments[0])
			{
				if(!dontUse)
					addCommentsUrl = arguments[0];
			}

		var f = '';
		var frm = document.addComments;
		for (var i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				if (e.type!='button' && e.name!='captcha_value')
					{
						var ovalue = Trim(e.value);
						if(ovalue)
							{
								ovalue = replace_string(ovalue, '\n', '<br />');
								f += ovalue;
							}
						else
							{
								$Jq('#selMsgError').show();
								$Jq('#selMsgError').html(no_comment_error_msg);

								e.value = '';
								e.focus();
								return false;
							}
					}
			}
		if(!reply_comment_id)
			{
				var currpath = addCommentsUrl+'&page=post_comment&comment_id='+comment_id+'&type=edit&f='+encodeURIComponent(f);
				callAjaxUpdate(currpath,'selCommentBlock');
			}
		else
			{

				var replypath=replyUrl;
				var pars = '&page=post_comment&comment_id='+reply_comment_id+'&f='+encodeURIComponent(f)+'&user_id='+owner;
				new jquery_ajax(replypath, pars, 'light_ajaxResultComment');
			}
		return false;
	}

function light_ajaxResultComment(data)
	{

		data = unescape(data);
		var obj = $Jq('#selCommentBlock').get(0);

		//var obj = document.getElementById('selCommentBlock');
		//obj.style.display = 'block';

		if(data.indexOf('ERR~')>=1)
			{
				data = data.replace('ERR~','');
				$Jq('#commentSelMsgError').html(data);
				$Jq('#selMsgError').show();
				if(captcha_recaptcha)
					Recaptcha.reload();
				return false;
			}
		/*data = data.split('***--***!!!');*/

		//document.getElementById('selCommentBlock').innerHTML =data;
		$Jq('#selCommentBlock').html(data);
		if(comment_approval == 0)
			{
				$Jq('#kindaSelMsgSuccess').html(parent.kinda_comment_msg);
				$Jq('#selMsgSuccess').show();
				$Jq('#selMsgSuccess').fade({ duration: 3.0, from: 1, to: 0 });
			}
		if(comment_approval == 1)
			{
				if(obj = $Jq('#totalComments').get(0))
					$Jq(obj).html(parseInt(obj.html())+1);
			}
		if(comment_approval == 1)
			{
				if($Jq("#selVideoCommentsCount"))
					$Jq("#selVideoCommentsCount").html(parseInt($Jq("#selVideoCommentsCount").html())+1);
			}

		$Jq('#comment').val('');
		$Jq('#commentSelMsgError').html('');
		$Jq('#selMsgError').hide();
		$Jq('#post_comment_add_block').css('display', 'none');
		$Jq('#add_comment').css('display', 'block');
		$Jq('#cancel_comment').css('display', 'none');
		$Jq('#selEditMainComments').hide();
		//parent.myLightWindow.deactivate();
		return false;
	}

var light_addToReply = function()
	{
		var comment_id = arguments[0];

		if(arguments[1])
			{
				if(!dontUse)
					addCommentsUrl = arguments[1];
			}

		var f = '';

		var frm = eval("document.addReply_"+comment_id);
		for (var i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				if (e.type!='button')
					{
						var ovalue = Trim(e.value);
						if(ovalue)
							{
								ovalue = replace_string(ovalue, '\n', '<br />');
								f += ovalue;
							}
						else
							{
								e.value = '';
								e.focus();
								return false;
							}
					}
			}
		var currpath = addCommentsUrl+'&comment_id='+comment_id+'&f='+encodeURIComponent(f);
		new jquery_ajax(currpath,'','light_ajaxResultReplyFinal');
		return false
	}

function light_ajaxResultReplyFinal(data)
	{
		data = unescape(data);
		var obj = document.getElementById('selCommentBlock');
		//obj.style.display = 'block';
		if(data.indexOf(session_check)>=1)
			{
				data = data.replace(session_check_replace,'');
			}
		else
			{
				return;
			}
		data = data.split('***--***!!!');
		obj.innerHTML = data[1];
		light_setEditTimerValue(data[0]);
		//parent.myLightWindow.deactivate();
		return;
	}

function light_setEditTimerValue(comment_id){
	parent.enabled_edit_fields_comment[parent.enabled_edit_fields_comment.length] = comment_id;
	parent.enabled_edit_fields_time[comment_id] = max_timer;
}