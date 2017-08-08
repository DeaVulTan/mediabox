var tr_delete='';
var replyComment=false;

var addToEdit = function(){
	comment_id = arguments[0];

	if(arguments[1])
		addCommentsUrl = arguments[1];

	var f = '';
	var cmtObj = $Jq("#comment_"+comment_id);
	var ovalue = Trim(cmtObj.val());
	if(ovalue){
		ovalue = replace_string(ovalue, '\n', '<br />');
	}else{
		cmtObj.val('');
		cmtObj.focus();
		return false;
	}

	var currpath = addCommentsUrl+'&comment_id='+comment_id+'&type=edit&f='+encodeURIComponent(ovalue);
	callAjaxUpdate(currpath, 'selCommentBlock');
	return false;
};

function callAjaxUpdate(path, block) {
	new jquery_ajax(path, '', 'callAjaxUpdateResponse');
	return false;
};

function callAjaxUpdateResponse(data) {
	data = unescape(data);
	if(data.indexOf('ERR~')>=1)
	{
		data = data.replace('ERR~','');
		alert_manual(data);
	}
	else
	{
		data = data.split('***--***!!!');
		data[0] = jQuery.trim(data[0])
		if(obj = $Jq('#selEditCommentTxt_'+data[0]).get(0))
			$Jq('#selEditCommentTxt_'+data[0]).html(data[1]);

		discardEdit(data[0]);
	}
	return;
};

function discardReply(coment_block, comment_id){
	$Jq('#'+coment_block).toggle('slow');
	$Jq('#comment_'+comment_id).val('');
};

//Reply comment
var addToReply = function(){
	var comment_id = arguments[0];

	if(arguments[1]){
		if(!dontUse)
			addCommentsUrl = arguments[1];
	}

	var f = '';
	var cmtObj = $Jq("#comment_"+comment_id);
	var ovalue = Trim(cmtObj.val());
	if(ovalue){
		ovalue = replace_string(ovalue, '\n', '<br />');
	}else{
		cmtObj.val('');
		cmtObj.focus();
		return false;
	}

	var currpath = addCommentsUrl+'&comment_id='+comment_id+'&f='+encodeURIComponent(ovalue);
	callAjaxReply(currpath, comment_id);
	return false;
};

function callAjaxReply(path, comment_id){
	var pars = '';
	$Jq.ajax({
		type: "POST",
		url: path,
		data: pars,
		success: function(data){
			if(data.indexOf('ERR~')>=1)
			{
				data = data.replace('ERR~','');
				alert_manual(data);
			}
			else
			{
				$Jq('#selReplyForComments_'+comment_id).html(data);
				$Jq('#selAddComments_'+comment_id).toggle('slow');
				$Jq('#comment_'+comment_id).val('');
				return true;
			}
		}
	 });
	return false;
};

function showReplyToCommentsOption(coment_block){
	$Jq('#'+coment_block).toggle('slow');
}

function callAjaxEdit(path, comment_id) {
	path = path+'&type=edit&comment_id='+comment_id;
	new jquery_ajax(path, '', 'ajaxResultEdit');
	return false;
};

function ajaxResultEdit(data)
{
	data = unescape(data);
	if(data)
	{
		var obj;
		data = jQuery.trim(data);
		data = data.split('***--***!!!');
		var ids=data[0];

		if(data[1].indexOf('ERR~')>=1)
		{
			data[1] = data[1].replace('ERR~','');
			alert_manual(data[1]);
		}
		else
		{
			if(obj = $Jq('#selEditCommentTxt_'+ids).get(0))
				$Jq('#selEditCommentTxt_'+ids).css('display', 'none');

			$Jq('#selEditComments_'+ids).css('display', 'block');
			$Jq('#selViewDeleteComment_'+ids).removeClass('clsDeleteButton');
			$Jq('#selViewDeleteComment_'+ids).addClass('clsReplyButton');

			var txt = replace_string(data[1], '<br>', '\n');
			txt = replace_string(txt, '<br />', '\n');
			txt = jQuery.trim(txt);

			$Jq('#selEditComments_'+ids).html(txt);
			$Jq('#selViewEditComment_'+ids).css('display', 'none');
		}
		return true;
	}
	return false;
};

function discardEdit(comment_id){
	var obj;
	if(obj = $Jq('#selEditCommentTxt_'+comment_id).get(0))
		$Jq('#selEditCommentTxt_'+comment_id).css('display', 'block');

	if(obj = $Jq('#selEditComments_'+comment_id).get(0))
		$Jq('#selEditComments_'+comment_id).css('display', 'none');

	if(obj = $Jq('#selViewEditComment_'+comment_id).get(0))
		$Jq('#selViewEditComment_'+comment_id).css('display', 'block');

		$Jq('#selViewDeleteComment_'+comment_id).removeClass('clsReplyButton');
		$Jq('#selViewDeleteComment_'+comment_id).addClass('clsDeleteButton');
};

var deleteCommandOrReply = function() {
	if ($Jq("#commentorreply").val() == 'deletecomment'){
		deleteCommand();
	} else {
		deleteCommandReply();
	}
};

var deleteCommand = function() {
	var data = $Jq("#msgConfirmform").serialize();
	data = data + '&ajax_page=true&page=deletecomment';
	$Jq.ajax({
		type: "POST",
		url: $Jq("#msgConfirmform").attr('action'),
		data: data,
		beforeSend:displayLoadingImage(),
		success: function(response){
			if(response.indexOf('ERR~')>=1)
			{
				hideAllBlocks();
				response = response.replace('ERR~','');
				alert_manual(response);
			}
			else if(response.indexOf('selLogin') > 0)
			{
				hideAllBlocks();
				document.msgConfirmformMulti1.action = member_login_url;
				if(!Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(common_delete_login_err_message), Array('innerHTML')))
				{
					return false;
				}
			}
			else
			{
				if(response.indexOf('~~DELMSG~~')>=1)
				{
					response = response.split('~~DELMSG~~');
					$Jq('#deleteCommentSuccessMsg').html(response[0]);
					$Jq('#deleteCommentSuccessMsgBlock').show();
					$Jq("#selCommentBlock").html(response[1]);
			 		$Jq("#selMusicCommentsCount").html(parseInt($Jq("#selMusicCommentsCount").html())-1);
				}
				else
				{
			 		$Jq("#selCommentBlock").html(response);
			 		$Jq("#selMusicCommentsCount").html(parseInt($Jq("#selMusicCommentsCount").html())-1);
			 	}
			 	hideAllBlocks();
			 	hideAnimateBlock('deleteCommentSuccessMsgBlock');
			}
		}
	});
	return false;
};

var deleteCommandReply = function() {
	var comment_id = arguments[1];
	var data = $Jq("#msgConfirmform").serialize();
	data = data + '&ajax_page=true&page=deletecommentreply';
	$Jq.ajax({
		type: "POST",
		url: $Jq("#msgConfirmform").attr('action'),
		data: data,
		beforeSend:displayLoadingImage(),
		success: function(response){
			if(response.indexOf('ERR~')>=1)
			{
				hideAllBlocks();
				response = response.replace('ERR~','');
				alert_manual(response);
			}
			else if(response.indexOf('selLogin') > 0)
			{
				hideAllBlocks();
				document.msgConfirmformMulti1.action = member_login_url;
				if(!Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(common_delete_login_err_message), Array('innerHTML')))
				{
					return false;
				}
			}
			else
			{
				if(response.indexOf('~~DELMSG~~')>=1)
				{
					response = response.split('~~DELMSG~~');
					$Jq('#deleteCommentSuccessMsgBlock_' + $Jq("#maincomment_id").val()).html(response[0]);
					$Jq('#deleteCommentSuccessMsgBlock_' + $Jq("#maincomment_id").val()).show();
					$Jq("#selReplyForComments_"+$Jq("#maincomment_id").val()).html(response[1]);
				}
				else
				{
					$Jq("#selReplyForComments_"+$Jq("#maincomment_id").val()).html(response);
				}
		 		hideAllBlocks();
		 		hideAnimateBlock('deleteCommentSuccessMsgBlock_' + $Jq("#maincomment_id").val());
		 	}
		}
	});
	return false;
};

function beforeDeleteResult(data) {
	var obj;

	if(data.indexOf('ERR~')>=1)
	{
		hideAllBlocks();
		data = data.replace('ERR~','');
		alert_manual(data);
	}
	else if(data.indexOf('selLogin') > 0)
	{
		hideAllBlocks();
		document.msgConfirmformMulti1.action = member_login_url;
		if(!Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(common_delete_login_err_message), Array('innerHTML')))
		{
			return false;
		}
	}
	else
	{
		//ERROR MESSAGES
		$Jq('#selCommentBlock').show();
		$Jq('#selMsgSuccess').show();
		$Jq('#kindaSelMsgSuccess').html(comment_success_deleted_msg);
		//CONTENT
		data = unescape(data);
		$Jq('#selCommentBlock').html(data);
		hideAnimateBlock('selMsgSuccess');
	}
	return false;
};


function deletePlaylistCommand(path, div_id, del_confirmed)
{
	replyComment=false;
	pars = '';
	if(!del_confirmed)
	{
		document.msgConfirmformMulti1.action = 'javascript:deletePlaylistCommand(\'' + path +'\', \'' + div_id + '\', true);';
		if(!Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(deleteConfirmation), Array('innerHTML')))
		{
			return false;
		}
	}
	else
	{
		hideAllBlocks();
		tr_delete = div_id;
		new jquery_ajax(path, '', 'beforeDeleteResult');
 	}
}