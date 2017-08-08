var tr_delete='';
var replyComment=false;
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

function callAjaxUpdateResponse(data)
	{
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
	}


/*function callAjaxEdit(path, comment_id)
	{
		//result_div = div_id;
		path = path+'&page=comment_edit&type=edit&comment_id='+comment_id;
		new prototype_ajax(path,'ajaxResultEdit');
		return false;
	}*/

function ajaxResultEdit(data)
	{
		data = unescape(data);
	if(data) {
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

			var txt = replace_string(data[1], '<br>', '\n');
			txt = replace_string(txt, '<br />', '\n');
			txt = jQuery.trim(txt);

			$Jq('#selEditComments_'+ids).html(txt);
			$Jq('#selViewEditComment_'+ids).css('display', 'none');
		}
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
function callAjaxEdit(path, comment_id)
	{
		//result_div = div_id;
		path = path+'&page=comment_edit&comment_id='+comment_id;
		new jquery_ajax(path, '', 'ajaxResultEdit');
		return false;
	}

function ajaxResultEdit(data)
	{

		data = unescape(data);
		var obj;
		data = data.split('***--***!!!');
		var ids=$Jq.trim(data[0]);
		if(obj = document.getElementById('selEditCommentTxt_'+ids))
			obj.style.display = 'none';

		obj = document.getElementById('selEditComments_'+ids);

		obj.style.display = 'block';
		var txt = replace_string(data[1], '<br>', '\n');
		txt = replace_string(txt, '<br />', '\n');
		txt = Trim(txt);
		obj.innerHTML = txt;
		obj = document.getElementById('selViewEditComment_'+ids);
		obj.style.display = 'none';
		return true;


	}


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
			 	$Jq("#selCommentBlock").html(response);
			 	$Jq("#total_comments").html(parseInt($Jq("#total_comments").html())-1);
			 	hideAllBlocks();
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
		 	$Jq("#selReplyForComments_"+$Jq("#maincomment_id").val()).html(response);
		 	hideAllBlocks();
		}
	});
	return false;
};

var deleteCommandOrReply = function() {
	if ($Jq("#commentorreply").val() == 'deletecomment'){
		deleteCommand();
	} else {
		deleteCommandReply();
	}
};
	/**
	 *
	 * @access public
	 * @return void
	 **/
	function hidedelCommentBlock(){
		hideAllBlocks();
		$Jq('#commentDelSrc').val('');
	    $Jq('#commentDelid').val('');
		$Jq('#selDelCommentMsgConfirm').hide();
		$Jq('#comment').val('');
		$Jq('#post_comment_add_block').css('display', 'none');
		$Jq('#add_comment').css('display', 'block');
		$Jq('#cancel_comment').css('display', 'none');
		$Jq("#selDelCommentMsgConfirm").dialog('close');


	}

	function beforeDeleteResult(data)
		{

			var obj;
			//ERROR MESSAGES
			$Jq('#selCommentBlock').show();
			$Jq('#selMsgSuccess').show();
			$Jq("#selDelCommentMsgConfirm").dialog('close');
			$Jq('#kindaSelMsgSuccess').html(comment_success_deleted_msg);
			//$Jq('#selMsgSuccess').fade({ duration: 3.0, from: 1, to: 0 });
			//CONTENT
			$Jq('#selCommentBlock').html(data);
			return false;
		}