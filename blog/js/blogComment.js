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
		memberBlockLoginConfirmation(viewpost_valid_login,addCommentsUrl);
	}
	else
	{
		data = data.split('***--***!!!');
		data[0] = jQuery.trim(data[0])
		if(obj = $Jq('#selEditCommentTxt_'+data[0]).get(0))
			$Jq('#selEditCommentTxt_'+data[0]).html(data[1]);

		discardEdit(data[0]);
		return;
	}
};

function callAjaxEdit(path, comment_id) {

	path = path+'&type=edit&comment_id='+comment_id;
		new jquery_ajax(path, '', 'ajaxResultEdit');
	return false;
};

function ajaxResultEdit(data) {
	//alert(data);
	data = unescape(data);
	if(data) {
		var obj;
		data = jQuery.trim(data);
		data = data.split('***--***!!!');
		var ids=data[0];

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

function hideUserInfoPopup(divname) {
	closeUserPopupAndTimer();
};

var timeout	= 100;
var infoTimer	= 0;
var divObj	= 0;

// close showed layer
function closeUserPopup() {
	if(divObj) divObj.style.display = 'none';
};

// close user info and reset timer
function closeUserPopupAndTimer() {
	infoTimer = window.setTimeout(closeUserPopup, timeout);
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
		    response = response.replace('ERR~','');
		 	$Jq("#selCommentBlock").html(response);
		 	$Jq("#selVideoCommentsCount").html(parseInt($Jq("#selVideoCommentsCount").html())-1);
		 	hideAllBlocks();
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

// reset timer
function resetUserInfoTimer() {
	if(infoTimer) {
		window.clearTimeout(infoTimer);
		infoTimer = null;
	}
};
function afterVideoCommentDeleteResult(data) {
	$Jq("#selCommentBlock").html(data);
}
function beforeDeleteResult() {
	var obj;

	if(obj = document.getElementById('del'+tr_delete))
		obj.style.display = 'none';

	if(obj = document.getElementById(tr_delete))
		obj.style.display = 'none';

	if(obj = document.getElementById(tr_delete+'_1'))
		obj.style.display = 'none';
	if(obj = document.getElementById(tr_delete+'_2'))
		obj.style.display = 'none';
	if(obj = document.getElementById(tr_delete+'_3'))
		obj.style.display = 'none';
	if(replyComment==false) {

		if(obj = document.getElementById('total_comments1')) {
			total_comments = parseInt(obj.innerHTML)-1;
			obj.innerHTML = total_comments;
		}

		if(obj = document.getElementById('total_comments2')) {
			total_comments = parseInt(obj.innerHTML)-1
			obj.innerHTML = total_comments;
		}

		if(obj = document.getElementById('totalComments'))
			obj.innerHTML = parseInt(obj.innerHTML)-1;
	}
};

function showUserInfoPopup(url, uid, divname, viewOption) {
	// reset timer
	resetUserInfoTimer();

	// close old layer
	if(divObj) divObj.style.display = 'none';

	// get new layer and show it
	divObj = document.getElementById(divname);

	if(divObj)
		divObj.style.display = '';

	var user_div_content = $Jq("#"+divname).html();
	//user_div_content = user_div_content.strip();
	// if content exists
	if (user_div_content != '') {
		return;
	}
	pars = 'uid=' + uid + '&option=' + viewOption
	ajaxUpdateDiv(url, pars, divname);
};

function ajaxUpdateDiv(url, pars, divname) {
	result_div = divname;
	path = url+'?'+pars;

	var path = url+pars;
	$Jq.ajax({
		type: "GET",
		url: url,
		data: pars,
		success: ajaxUpdateResult
	 });
};

function ajaxUpdateResult(data) {
	data = unescape(data);
	$Jq("#"+result_div).html(data);
};