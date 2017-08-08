//Rating related
var img_src = new Array();
function ratingArticleMouseOver(count, type)
{
	if(type == 'article')
		{
			var hoverimage_name = 'icon-articleratehover.gif';
			var image_name = 'icon-articlerate.gif'
		}
	for(var i=1; i<=count; i++)
		{
			var obj = document.getElementById('img'+i);
			img_src[i] = obj.src;
			obj.src = article_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+hoverimage_name;
		}
	for(; i<=total_rating_images; i++)
		{
			var obj = document.getElementById('img'+i);
			img_src[i] = obj.src;
			obj.src = article_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+image_name;
		}
}

function ratingArticleMouseOut(count)
{
	for(var i=1; i<=total_rating_images; i++)
		{
			var obj = document.getElementById('img'+i);
			obj.src = img_src[i];
		}
}

function callAjaxRate(path, div_id)
{
	result_div  = div_id;
	new jquery_ajax(path, '', 'ajaxResultRate');
	return false;
}
function ajaxResultRate(data)
{

	data = unescape(data);
	var obj = document.getElementById(result_div);
	if(data.indexOf('ERR~')>=1)
	{
		data = data.replace('ERR~','');
		alert_manual(data);
	}
	else
	{
		obj.innerHTML       = data;
		//obj.style.top       = getAbsoluteOffsetTopConfirmation(document.getElementById('dAltMulti')) + 'px';
	}
}

//flag
function callAjaxFlagGroups(path, div_id)
{
	result_div = div_id;
	hideAjaxTabs(result_div);
	var div_value = $Jq('#'+result_div).html();
	div_value = $Jq.trim(div_value);
	//arrow_img = arrow_image_id;
	if((div_value == '') || (div_value == FLAG_SUCCESS_MSG))
	{
		show_ajax_div();
		//$('flag_arrow_img').show();
		//$(result_div).innerHTML = '<div class="loader" align="center">&nbsp;</div>';
		$Jq('#'+result_div).html(view_article_scroll_loading);
		new jquery_ajax(path, '', 'ajaxResultAddGroups');

	}
	else
	{
		show_ajax_div();
		//$('flag_arrow_img').show();
	}
	return false;
}

function close_ajax_div(ajax_content_div)
{
	//$(result_div).hide();
	//Zapatec.Effects.hide(result_div, 5, 'fade')
	//Zapatec.Effects.hide(ajax_content_div, 5, 'fade');
	$Jq('#'+ajax_content_div).fadeOut("slow");
}


function show_ajax_div()
{
	//$(result_div).show();
	//fade, slide, glide, wipe, unfurl, grow, shrink, highlight
	//Zapatec.Effects.show(result_div, 5, 'fade');
	$Jq('#'+result_div).fadeIn(100);
	//slideDiv($(result_div));
}


function hideAjaxTabs(current_div)
{
	for(var i=0; i<hide_ajax_tabs.length; i++)
	{
		if(hide_ajax_tabs[i] != current_div)
		{
			$Jq('#'+hide_ajax_tabs[i]).hide();
		}
	}
}

function ajaxResultAddGroups(data)
{
	data = unescape(data);
	var obj = document.getElementById(result_div);
	obj.innerHTML='';
	hideAjaxTabs(result_div);
	show_ajax_div();
	/*if(data.indexOf(session_check)>=1)
	{
		data = data.replace(session_check_replace,'');
	}
	else
	{
		return;
	}*/
	obj.innerHTML = data;
}

/*var addToFlag = function()
{

	if(arguments[1])
		addFlagUrl = arguments[1];

	var flag = '';

	var frm = document.addFlag;
	for (var i=0;i<frm.elements.length;i++)
	{
		var e = frm.elements[i];
		//alert(e.type);
		//if (e.type=='checkbox' && e.checked)
		if (e.name=='flag')
		{
			flag = e.value;
		}
		if(e.type=='textarea')
		{
			flag_comment = e.value;
		}
	}

	var currpath = addFlagUrl+'&flag='+flag+'&flag_comment='+flag_comment;
	callAjaxUpdateGroups(currpath,'flag_content_tab');
	return false
}*/

var addToFlag = function()
{
	if(arguments[1])
		addFlagUrl = arguments[1];

	var flag=$Jq('#flag').val();
	var flag_comment=encodeURIComponent($Jq('#flag_comment').val());

		if(flag_comment)
			{
				$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
				$Jq('#clsMsgDisplay_flag').removeClass('clsErrorMessage');
				$Jq('#clsMsgDisplay_flag').addClass('clsSuccessMessage');
				$Jq('#flag_submitted').html(view_article_scroll_loading);
				$Jq('#flag_loader_row').show();
				var currpath = addFlagUrl+'&flag='+flag+'&flag_comment='+flag_comment;
				callAjaxUpdateGroups(currpath,'clsMsgDisplay_flag');
			}
		else
			{
				$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
				$Jq('#clsMsgDisplay_flag').removeClass('clsSuccessMessage');
				$Jq('#clsMsgDisplay_flag').addClass('clsErrorMessage');
				$Jq('#clsMsgDisplay_flag').html(viewarticle_flag_comment_invalid);
			}

	return false
}

function callAjaxUpdateGroups(path, div_id)
	{
		result_div = div_id;
		new jquery_ajax(path, '', 'ajaxResultUpdateGroups');
	}

function ajaxResultUpdateGroups(data)
	{
		data = unescape(data);
		if(data.indexOf('ERR~')>=1)
		{
			data = data.replace('ERR~','');
		}
		var obj = document.getElementById(result_div);
		obj.innerHTML = data;
		if(result_div == 'clsMsgDisplay_flag')
			{
				$Jq('#flag').val('');
				$Jq('#flag_comment').val('');
			}
		else if(result_div == 'favorite_content_tab')
			{
				$Jq('#selFavoriteLink').hide();
				$Jq('#selRemoveFavoriteLink').show();
			}

		if($Jq('#flag_loader_row').get(0))
			$Jq('#flag_loader_row').hide();
		//document.getElementById('selFavoriteLink').style.display = 'none';
	}

//favorites
var favorite_count = true;
function callAjaxFavoriteGroups(path, div_id)
{
	//if(!favorite_count)
	if(0)
		return false;
	result_div = div_id;
	//hideAjaxTabs(result_div);
	$Jq('#'+result_div).html(view_article_scroll_loading);
	new jquery_ajax(path, '', 'ajaxResultAddGroups');
	return false;
}

var addToFavorite = function()
	{
		if(arguments[1])
			addFavoritesUrl = arguments[1];

		if(arguments[2])
			result_div = arguments[2];

		var favorite_id = '';

		var frm = document.addFavorites;
		for (var i=0;i<frm.elements.length;i++)
		{
			var e=frm.elements[i];
			if (e.type=='checkbox' && e.checked)
			{
				favorite_id += e.value + ',';
			}
		}
		var currpath = addFavoritesUrl+'&favorite_id='+favorite_id;

		if($Jq('#selFavoriteLink').is(':hidden'))
			$Jq('#selFavoriteLink').show();
		if($Jq('#selRemoveFavoriteLink').is(':hidden'))
			$Jq('#selRemoveFavoriteLink').hide();

		if(arguments[2])
			callAjaxUpdateGroups(currpath, result_div);
		else
			callAjaxUpdateGroups(currpath,'selEditPhotoComments');

		var obj;
		if(obj = document.getElementById('totalFavorite'))
			obj.innerHTML = parseInt(obj.innerHTML)+1;
		favorite_count = false;

		return false
	}

var removeFromFavorite = function()
{
	if(arguments[1])
		removeFavoritesUrl = arguments[1];

	if(arguments[2])
		result_div = arguments[2];

	var currpath = removeFavoritesUrl;

	new jquery_ajax(currpath, '', 'removeFavorite');
	return false
}

function removeFavorite(data)
{
	data = unescape(data);
	var obj = document.getElementById(result_div);
	hideAjaxTabs(result_div);
	//obj.style.display = 'block';

	/*if(data.indexOf(session_check)>=1)
	{
		data = data.replace(session_check_replace,'');
	}
	else
	{
		return;
	}*/
	$Jq('#selFavoriteLink').show();
	$Jq('#selRemoveFavoriteLink').hide();

	obj.innerHTML = data;
	show_ajax_div();
	setTimeout('hideAnimateBlock(result_div)', 5000);
}

//Share the Article
function callAjaxEmail(path, div_id)
{
	//result_div = div_id;
	//$Jq('#'+result_div).html(view_article_scroll_loading);
	new jquery_ajax(path, '', 'ajaxResultEmail');
	return false;
}

function ajaxResultEmail(data)
{
	data = unescape(data);
//	var obj = $Jq('#'+result_div).get(0);
//	hideAjaxTabs(result_div);
	/*if(data.indexOf(session_check)>=1)
	{
		data = data.replace(session_check_replace,'');
	}
	else
	{
		return;
	}*/
	$Jq('#'+result_div).html(data);
	show_ajax_div();
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
			pars += '&'+e.name+'='+e.value;
	}
	var path = path+pars;

	result_div = div_id;
	$Jq('#'+div_id).html('<div class="loader" align="center">&nbsp;</div>');
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
		data = data.replace(session_check_replace,'');
	else
		return;*/

	obj.innerHTML = data;
}

//Add Comments
function callAjaxAddComments(path, div_id)
	{
		restoreFirstValue('selEditMainComments');
		//var obj = document.getElementById('selViewPostComment');
		//obj.style.display = 'none';
		result_div = div_id;
		new AG_ajax(path,'ajaxResultAddComments');
		return false;
	}
function ajaxResultAddComments(data)
	{
		data = unescape(data);
		var obj = document.getElementById(result_div);
		obj.style.display = 'block';
		/*if(data.indexOf(session_check)>=1)
			{
				data = data.replace(session_check_replace,'');
			}
		else
			{
				return;
			}*/
		//data = data.split('***--***!!!');
		obj.innerHTML = data;
		captcha = data[1];

	}

var addToComment = function()
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
								$Jq('#commentSelMsgError').html(no_comment_error_msg);
								$Jq('#selMsgError').show();
								e.value = '';
								e.focus();
								return false;
							}
					}
			}

		if(captcha!=frm.captcha_value.value)
			{
				//alert_manual('invalid captcha', 'alertHyperLink', 1000, 500);
				$Jq('#commentSelMsgError').html('invalid captcha');
				$Jq('#selMsgError').show();
				return;
			}
		var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
		callAjaxComment(currpath,'selCommentBlock');
		return false
	}

var addComment = function()
	{

		var addCommentsUrl = arguments[0];
		var f = '';
		var frm = document.frmPostComments;
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
					$Jq('#selCommentError').html(no_comment_error_msg);
					e.value = '';
					e.focus();
					return false;
				}
			}
		}


		if(captcha!=frm.captcha_value.value)
			{
				$Jq('#selCaptchaError').html(invalid_captcha_error_msg);
				return;
			}
		if(!reply_comment_id)
		{
		var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
		new jquery_ajax(currpath, '', 'ajaxCommentResult');
		}
		else
		{
			var replypath=replyUrl+'&comment_id='+reply_comment_id+'&f='+encodeURIComponent(f);
			new jquery_ajax(replypath, '', 'ajaxCommentResult');
		}
		return false
	}

function ajaxCommentResult(request)
	{
			if(request != '')
				{
					result = request;
					result = result.split('|||');
					var commentError =false;
					for(i=0;i<result.length;i++)
						{
							if(common = result[i].split('common_'))
								{
									if(common.length > 1)
										{
											$Jq('#selMessage').html(common[1]);
											commentError=true;
										}
								}
							if(comment = result[i].split('comment_'))
								{
									if(comment.length >1)
									{
										$Jq('#selCommentError').html(comment[1]);
										commentError=true;
									}
								}
							if(captcha = result[i].split('captcha_'))
								{
									if(captcha.length > 1)
									{
										$Jq('#selCaptchaError').html(captcha[1]);
										commentError=true;
									}
								}
						}

					//resetCaptcha('captcha_image','<?php echo $BookmarkList->CFG['site']['url'] .  "captchaSignup.php?captcha_key=" . $BookmarkList->getFormField('captcha_key');?>' );
					$Jq('#selCommentBlock').css('display', 'block');
				}

			if(!commentError)
			{
				hideAllBlocks();
			window.location.href = currentUrl;
			}
	}


var addToCommentHoneyPot = function()
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
								//$('selCommentError').innerHTML=no_comment_error_msg;
								$Jq('#commentSelMsgError').html(no_comment_error_msg);
								$Jq('#selMsgError').show();
								e.value = '';
								e.focus();
								return false;
							}
					}
			}
		if(!$Jq('#'+arguments[1]) && $Jq('#'+arguments[1]).val()!='')
			{
				alert_manual('Errors Found', 'alertHyperLink', 1000, 500);
				return;
			}
		/*if(!reply_comment_id)
		{
			var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
			new prototype_ajax(currpath,'ajaxCommentResult');
		}
		else
		{
			var replypath=replyUrl+'&comment_id='+reply_comment_id+'&f='+encodeURIComponent(f);
			new prototype_ajax(replypath,'ajaxCommentResult');
		}*/
		var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
		//alert(currpath);return;
		callAjaxComment(currpath,'selCommentBlock');
		return false;
	}

	var addToCommentNoCaptcha = function()
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
								//$('selCommentError').innerHTML=no_comment_error_msg;
								$Jq('#commentSelMsgError').html(no_comment_error_msg);
								$Jq('#selMsgError').show();
								e.value = '';
								e.focus();
								return false;
							}
					}
			}

		var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
		callAjaxComment(currpath,'selCommentBlock');

		if(!reply_comment_id)
		{
			var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
			new jquery_ajax(currpath, '', 'ajaxCommentResult');
		}
		else
		{
			var replypath=replyUrl+'&comment_id='+reply_comment_id+'&f='+encodeURIComponent(f);
			new jquery_ajax(replypath, '', 'ajaxCommentResult');
		}
		return false
	}


function clearComment()
	{
		var obj = document.getElementById('selAddComments');
		obj.style.display = 'none';
		var obj = document.getElementById('selViewPostComment');
		obj.style.display = 'block';
	}

function callAjaxComment(path, div_id)
	{
		//result_div = div_id;
		new jquery_ajax(path, '', 'ajaxResultComment');
		return false;
	}

function ajaxResultComment(data)
	{
		data = unescape(data);
		var obj = document.getElementById('selCommentBlock');
		obj.style.display = 'block';
		/*if(data.indexOf(session_check)>=1)
			{
				data = data.replace(session_check_replace,'');
			}
		else
			{
				return;
			}*/
		data = data.split('***--***!!!');
		obj.innerHTML = data[1];
		if(comment_approval == 0)
			{
				$Jq('#commentSelMsgError').html(kinda_comment_msg);
				$Jq('#selMsgError').show();
				$Jq('#selMsgError').fadeOut("slow");
			}
		setEditTimerValue(data[0]);

		//if(obj = document.getElementById('selViewPostComment'))
			//obj.style.display = 'block';
		if(comment_approval){
			if(obj = $Jq('#totalComments').get(0))
				obj.html(parseInt(obj.html())+1);
		}
		captcha = $Jq.trim(data[2]);
		return;
	}


//delete comment
var tr_delete;
/*function deleteCommand(path, div_id)
	{
		if(confirm(deleteConfirmation))
			{
				tr_delete = div_id;
				new prototype_ajax(path,'deleteResult');
				beforeDeleteResult();
			}
		return false;
	}*/

function deleteCommand()
	{
		path= $Jq('#commentDelSrc').val();
		div_id= $Jq('#commentDelid').val();
		tr_delete = div_id;
		new jquery_ajax(path, '', 'deleteResult');
		beforeDeleteResult();
		return false;
	}

/*function deleteCommand()
	{
	path= $('commentDelSrc').value;
	div_id= $('commentDelid').value;

		replyComment=false;
		pars = '';
		//if(confirm(deleteConfirmation))
			{
				tr_delete = div_id;
				var myAjax = new Ajax.Request(
					path,
					{
						method: 'post',
						parameters: pars,
						onComplete: beforeDeleteResult
					});
			}
		return false;
	}*/



function hidedelCommentBlock(){
		hideAllBlocks();
		$Jq('#commentDelSrc').val('');
	    $Jq('#commentDelid').val('');
		$Jq('#selDelCommentMsgConfirm').hide();
		$Jq('#selDelCommentMsgConfirm').dialog('close');
	}


function beforeDeleteResult()
	{
		var obj;
		hidedelCommentBlock();

		if(obj = document.getElementById(tr_delete))
			obj.style.display = 'none';

		if(obj = document.getElementById(tr_delete+'_1'))
			obj.style.display = 'none';
		if(obj = document.getElementById(tr_delete+'_2'))
			obj.style.display = 'none';
		if(obj = document.getElementById(tr_delete+'_3'))
			obj.style.display = 'none';

		if(obj = document.getElementById('total_comments1'))
			{
				total_comments = parseInt(obj.innerHTML)-1;
				obj.innerHTML = total_comments;
			}

		if(obj = document.getElementById('total_comments2'))
			{
				total_comments = parseInt(obj.innerHTML)-1
				obj.innerHTML = total_comments;
			}

		if(total_comments && total_comments<=minimum_counts)
			{
				if(obj = document.getElementById('view_all_comments'))
					obj.style.display = 'none';
			}

		if(obj = document.getElementById('totalComments'))
			obj.innerHTML = parseInt(obj.innerHTML)-1;
	}

function deleteResult(data)
	{
		return;
	}

/*******for ediit comment functions started***********/
function callAjaxEdit(path, comment_id)
	{
		//result_div = div_id;
		path = path+'&type=edit&comment_id='+comment_id;
		new jquery_ajax(path, '', 'ajaxResultEdit');
		return false;
	}

function ajaxResultEdit(data)
	{
		data = unescape(data);
		if(data)
			{
				var obj;
				data=$Jq.trim(data);
				data = data.split('***--***!!!');
				var ids=data[0];
				if($Jq('#selEditCommentTxt_'+ids).get(0))
					$Jq('#selEditCommentTxt_'+ids).css('display', 'none');

				$Jq('#selEditComments_'+ids).css('display', 'block');
				var txt = replace_string(data[1], '<br>', '\n');
				txt = replace_string(txt, '<br />', '\n');
				txt = $Jq.trim(txt);
				$Jq('#selEditComments_'+ids).html(txt);
				$Jq('#selViewEditComment_'+ids).css('display', 'none');
				return true;
			}
		return false;
	}

function discardEdit(comment_id)
	{
		var obj;

		if(obj = document.getElementById('selEditCommentTxt_'+comment_id))
			obj.style.display = '';

		if(obj = document.getElementById('selEditComments_'+comment_id))
			obj.style.display = 'none';

		if(obj = document.getElementById('selViewEditComment_'+comment_id))
			obj.style.display = '';
	}

var addToEdit = function()
	{
		comment_id = arguments[0];

		if(arguments[1])
			addCommentsUrl = arguments[1];

		var f = '';

		var frm = eval("document.addEdit_"+comment_id);
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
		f = encodeURIComponent(f);
		var currpath = addCommentsUrl+'&comment_id='+comment_id+'&type=edit&f='+encodeURIComponent(f);
		callAjaxUpdate(currpath,'selCommentBlock');
		return false;
	}

function callAjaxUpdate(path, block)
	{

		path = path;
		new jquery_ajax(path, '', 'callAjaxUpdateResponse');
		return false;
	}

/*function callAjaxUpdateResponse(data)
	{
		data = unescape(data);
		if(data)
			{
				data=data;
			}
		else
			{
				return;
			}
		data = data.split('***--***!!!');
		data[0] = $Jq.trim(data[0]);
		if(obj = $Jq('#selEditCommentTxt_'+data[0]))
			obj.html(data[1]);
		discardEdit(data[0]);
		return;
	}*/
/************ edit comments end ********/
function changeTimer()
	{
		if(typeof enabled_edit_fields_comment == 'undefined')
			return;
		if(enabled_edit_fields_comment.length)
			{
				doTimerFunction();
				setTimeout('changeTimer()',1000);
			}
	}

function setEditTimerValue(comment_id)
	{
		enabled_edit_fields_comment[enabled_edit_fields_comment.length] = comment_id;
		enabled_edit_fields_time[comment_id] = max_timer;
	}

function doTimerFunction()
	{
		var val;
		var comment_id;
		for(var i in enabled_edit_fields_comment)
			{
				comment_id = enabled_edit_fields_comment[i];
				if(i!='undefined' && i!='has' && i!='find')
					{
						val = enabled_edit_fields_time[comment_id];
						if(val<=1)
							hideDeleteEditLinks(comment_id);
						else if(val!=null)
							decrementTime(comment_id);
					}
			}
	}

function decrementTime(comment_id)
	{
		var obj;
		var val = enabled_edit_fields_time[comment_id];
		if(obj = document.getElementById('selViewTimerComment_'+comment_id))
			{
				obj.innerHTML = val-1;
				obj.innerHTML = obj.innerHTML+' Sec';
			}
		enabled_edit_fields_time[comment_id] = val-1;
	}

function hideDeleteEditLinks(comment_id)
	{
		var obj;
		var val = enabled_edit_fields_time[comment_id];
		if(obj = document.getElementById('selViewDeleteComment_'+comment_id))
			obj.style.display = 'none';
		if(obj = document.getElementById('selViewEditComment_'+comment_id))
			obj.style.display = 'none';
		if(obj = document.getElementById('selViewTimerComment_'+comment_id))
			obj.style.display = 'none';
		if(obj = document.getElementById('cmd'+comment_id))
			obj.className = 'clsNotEditable';
		enabled_edit_fields_time[comment_id] = null;
	}
//Reply comment

var addToReply1 = function()
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
		callAjaxReplyFinal(currpath,'selCommentBlock');
		return false
	}

function callAjaxReplyFinal(path, block)
	{
		path = path;
		new jquery_ajax(path, '', 'ajaxResultReplyFinal');
		return false;
	}

/*function ajaxResultReplyFinal(data)
	{
		data = unescape(data);
		var obj = document.getElementById('selCommentBlock');
		obj.style.display = 'block';
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
		setEditTimerValue(data[0]);
		return;
	}*/

/*
function callAjaxReply(path, comment_id)
	{
		//result_div = div_id;
		path = path+'&comment_id='+comment_id;
		new jquery_ajax(path, '', 'ajaxResultReply');
		return false;
	}
*/
function ajaxResultReply_1(data)
	{
		data = unescape(data);
		if(data)
			{
				data = $Jq.trim(data);
				//data = data.split('***--***!!!');
				var obj = $Jq('#selAddComments_'+data).get(0);
				obj.css('display', 'block');
				obj.html(data[1]);
				obj = $Jq('#selViewPostComment_'+data).get(0);
				obj.css('display', 'none');
				return true;
			}
		return false;
	}

function discardReply(coment_block, comment_id){

	$Jq('#'+coment_block).toggle('slow');
	$Jq('#comment_'+comment_id).val('');
};

function getMoreContent(path, div_id, current_li_id)
	{
		var div_value = document.getElementById(div_id).innerHTML;
		result_div = div_id;
		more_li_id = current_li_id;
		div_value = $Jq.trim(div_value);
		if(div_value == '')
			{
				hideMoreTabsDivs(div_id);
				showMoreTabsDivs(div_id);
				$Jq('#'+div_id).html('<div class="loader" align="center">&nbsp;</div>');
				new jquery_ajax(path, '', 'insertMoreTabsContent');
			}
		else
			{
				$Jq('#'+result_div).html(view_article_scroll_loading);
				new jquery_ajax(path, '', 'insertMoreTabsContent');
				hideMoreTabsDivs(div_id);
				showMoreTabsDivs(div_id);
			}
	}

function insertMoreTabsContent(data)
	{
		data = unescape(data);

		var obj = document.getElementById(result_div);
		obj.style.display = 'block';
		/*if(data.indexOf(session_check)>=1)
			{
				data = data.replace(session_check_replace,'');
			}
		else
			{
				return;
			}*/
		obj.innerHTML = data;
		//$(obj).show();
		//setClass(more_li_id,'clsActiveMoreVideosNavLink');
	}

function showHideMenu(anchor_div_name, open_div_name, open_div_id, total_div_count, current_menu_id)
{
	if($Jq('#'+open_div_name+open_div_id).is(':hidden'))
	{
		//$(anchor_div_name+open_div_id).addClass('clsActiveLink');
		$Jq('#'+open_div_name+open_div_id).show();
		$Jq('#'+current_menu_id+open_div_id).removeClass('clsShowSubmenuLinks');
		$Jq('#'+current_menu_id+open_div_id).addClass('clsHideSubmenuLinks');
		if($Jq('#'+current_menu_id+total_div_count).get(0))
			$Jq('#'+current_menu_id+total_div_count).html('Hide');
	}
	else
	{
		//$(anchor_div_name+open_div_id).removeClass('clsActiveLink');
		$Jq('#'+open_div_name+open_div_id).hide();
		$Jq('#'+current_menu_id+open_div_id).removeClass('clsHideSubmenuLinks');
		$Jq('#'+current_menu_id+open_div_id).addClass('clsShowSubmenuLinks');
		if($Jq('#'+current_menu_id+total_div_count).get(0))
			$Jq('#'+current_menu_id+total_div_count).html('Show');
	}
}

function textareaMaxLength(field, evt, limit) {
  var evt = (evt) ? evt : event;
  var charCode =
    (typeof evt.which != "undefined") ? evt.which :
   ((typeof evt.keyCode != "undefined") ? evt.keyCode : 0);

  if (!(charCode >= 13 && charCode <= 126)) {
    return true;
  }

  return (field.value.length < limit);
}


function updatelength()
{
	var LANG_limit = 'Limit';
	var LANG_limit_exceeds = 'Description limit exceeded';
	var LANG_invalid = 'Numeric only';
	var LANG_updating_msg = 'Updating...';
	var LANG_remaining_again = 'Number of characters left ';
	var LANG_exceed_limit = 'Number of characters exceeded ';
	var LANG_remaining = 'Number of characters left ';
	var ss = 'ss';
	var obj = arguments[0];
	if(arguments.length>=2)
		ss = arguments[1];
	var b =obj.form.name;
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "";
	var a;
	a= mlength- obj.value.length;
	if(a < 0 )
		{
			LANG_remaining = LANG_exceed_limit;
		}
	else if( a >=  0)
		{
			LANG_remaining = LANG_remaining_again;
		}
	b= LANG_remaining +" :<span class ='clsCharacterLimit' > "+Math.abs(a)+"</span>";
	var x;
	if(a < 0 )
		{
			if(document.getElementById('ss').className == 'clsZeroColour')
				document.getElementById('ss').className = 'clsNegativeColour';
			/*if(document.getElementById("submit"))
				document.getElementById("submit").disabled = true;
			else if(document.getElementById("update"))
				document.getElementById("update").disabled = true;*/
		}
	else
		{
			if(document.getElementById('ss').className == 'clsNegativeColour')
				document.getElementById('ss').className = 'clsZeroColour';
			/*if(document.getElementById("submit"))
				document.getElementById("submit").disabled = false;
			else if(document.getElementById("update"))
				document.getElementById("update").disabled = false;*/
		}
	Element.update(ss, b);

}

var updatelengthOnload=function()
{
	var ss = 'ss';
	var obje = arguments[0];
	var obj = $Jq('#'+obje).get(0);
	if(arguments.length>=2)
		ss = arguments[1];

	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "";
	if (obj.getAttribute && obj.value.length>mlength)
		{
			obj.value=obj.value.substring(0,mlength);
			alert_manual(LANG_limit_exceeds);
		}

	var a;
	a=obj.value.length + '   ('+LANG_limit+' '+mlength+')';
	Element.update(ss, a);
}

// ARTICLE ACTIVITY RELATED FUNTION //
var display_activity_div = '';
function loadActivitySetting(divName)
{
	var temp = '';
	for(knc=0;knc<article_activity_array.length;knc++)
	{
		head_div_id = 'sel'+article_activity_array[knc]+'Activity_Head';
		content_div_id = 'sel'+article_activity_array[knc]+'Activity_Content';
		if(article_activity_array[knc] == divName)
		{
			$Jq('#'+head_div_id).addClass('clsIndexActivitiesActiveMenu');
			$Jq('#'+content_div_id).show();
			var pars = '?ajax_page=true&activity_type='+article_activity_array[knc];
			var temp = content_div_id;
		}
		else
		{
			$Jq('#'+head_div_id).removeClass('clsIndexActivitiesActiveMenu');
			$Jq('#'+content_div_id).hide();
		}
	}
	// DISPLAY CONTENT //
	var div_content =  $Jq('#'+temp).html();
	if(div_content == '')
		getActivityContent(article_index_ajax_url, pars, temp);
	else
		return false;
}

function getActivityContent(url, pars, divname)
{
	display_activity_div = divname;
	var myAjax = new jquery_ajax(url, pars ,'displayArticleIndexActivity');
}

function displayArticleIndexActivity(request)
{
	data = unescape(request);
	if(data)
	{
		data=$Jq.trim(data);
		//data = data.split('***--***!!!');
		$Jq('#'+display_activity_div).html(data);
	}
}

function memberBlockLoginConfirmation(msg,url)
{
	document.msgConfirmformMulti1.action = url;
	return Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(msg), Array('innerHTML'));
}

function hidingBlocks()
{
	if(obj = $Jq('#selMsgLoginConfirmMulti').get(0))
	obj.css('display', 'none');
	if(obj = $Jq('#hideScreen').get(0))
	obj.css('display', 'none');
	if(obj = $Jq('#selAjaxWindow').get(0))
	obj.css('display', 'none');
	if(obj = $Jq('#selAjaxWindowInnerDiv').get(0))
	obj.html('');
	return false;
}
// END //

// AJAX FUNCTION TO CALL SHARE Article
function showShareArticleDiv(url){
	import_contacts_link = true;
	pars='';
	jquery_ajax(url, pars, 'ajaxResultArticleShare');
}

// FUCNTION TO DISPLAY SHARE MUSIC AJAX OUTPUT
function ajaxResultArticleShare(data){
	$Jq('#shareDiv').html(data);
	import_contacts_link = true;
	Confirmation('shareDiv', 'formEmailList', Array(), Array(), Array());
}
