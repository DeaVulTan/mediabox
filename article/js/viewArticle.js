var result_div;
var session_check = 'heck|||||||||valid|||||||||login';
var session_check_replace = 'check|||||||||valid|||||||||login';
var captcha;
var more_li_id;
var arrow_img;
var playlistId;
var playlistTitle='';

//functions for get codes
function callAjax(path, div_id){
	result_div = div_id;
	new jquery_ajax(path, '','ajaxResult');
	return false;
};

function ajaxResult(data){
	var obj = $Jq('#'+result_div).get(0);
	$Jq('#'+result_div).attr('display', 'block');
	$Jq(obj).html('<h2><span>'+viewphoto_codes_to_display+'</span></h2>'+'<p class="clsAlignRight" id="close"> <a onClick=codeWindowClose("codeBlock")>'+viewphoto_close_code+'</a></p>'+data);
};

function RegularExpressionReplace(expression, subject, replaced){
  var re = new RegExp(expression, "g");
  return subject.replace(re, replaced);
}

function changeWidth(max_width_value){
	var width_value = document.formGetCode.image_width.value;
	if(parseInt(max_width_value)>=width_value && (!isNaN(width_value))){
		var expression = 'width="([0-9]+)"';
		var subject = document.formGetCode.image_code.value;
		var replaced = 'width="'+width_value+'"';
		document.formGetCode.image_code.value = RegularExpressionReplace(expression, subject, replaced);
	}
};

function changeWidthOld(){
	var width_value = document.formGetCode.image_width.value;
	if(max_width_value>=width_value && (!isNaN(width_value))){
		var code_value = document.formGetCode.image_code.value;
		var code_arr = code_value.split('width="');
		code_arr[1] = code_arr[1].substring(code_arr[1].indexOf('"'));
		var new_code = code_arr[0]+'width="'+width_value+code_arr[1];
		document.formGetCode.image_code.value = new_code;
	}
};

function codeWindowClose(div_id){
	var obj = $Jq('#'+div_id).get(0);
	$Jq(obj).html('');
	$Jq(obj).attr('display', 'none');
};

//functions for rating removed and moved to core functions.js
var img_src = new Array();
function mouseOver(count){
	for(var i=1; i<=count; i++){
		var obj = $Jq('#img'+i).get(0);
		img_src[i] = $Jq(obj).attr('src');
		//$Jq(obj).attr('src' = site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_default+'/icon-ratehover.gif');
		obj.src = site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_default+'/icon-ratehover.gif';
	}
	for(; i<=total_images; i++){
		var obj = $Jq('img'+i).get(0);
		img_src[i] = $Jq(obj).attr('src');
		$Jq(obj).attr('src', site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_default+'/icon-rate.gif');
	}
};

function mouseOut(count){
	for(var i=1; i<=total_images; i++){
		var obj = $Jq('#img'+i).get(0);
		$Jq(obj).attr('src', img_src[i]);
	}
};

//paging(next/previous link)
function callAjaxPaging(path, div_id){
	result_div = div_id;
	new jquery_ajax(path, '', 'ajaxResultPaging');
	return false;
};

function ajaxResultPaging(data){
	var obj = $Jq('#'+result_div).get(0);
	$Jq(obj).attr('display', 'block');
	data = data.split('***--***!!!');
	captcha = data[1];
	data = data[0].split('+++++--++++!+++++++');
	$Jq(obj).html(data[0]);
	flagged_status = data[1];
	hideFlaggedContent();
};

function hideFlaggedContent(){
	if(flagged_status=="Yes"){
		var obj = '';
		if(obj = $Jq('#membersAlbums').get(0)){
			$Jq(obj).attr('display', 'none');
		}
		var obj = $Jq('#addFavorite').get(0);
		$Jq(obj).attr('display', 'none');
		var obj = $Jq('#selflaggedContent').get(0);
		$Jq(obj).attr('display', 'none');
		var obj = $Jq('#confirmationDiv').get(0);
		$Jq(obj).attr('display', 'block');
	}
};

function showFlaggedContent(){
	var obj = '';
	if($Jq('#membersAlbums').length){
		obj = $Jq('#membersAlbums').get(0)
		$Jq(obj).attr('display', 'block');
	}
	var obj = $Jq('#addFavorite').get(0);
	$Jq(obj).attr('display', 'block');
	var obj = $Jq('#selflaggedContent').get(0);
	$Jq(obj).attr('display', 'block');
	var obj = $Jq('#confirmationDiv').get(0);
	$Jq(obj).attr('display', 'none');
	return false
};

function callAjaxAddGroups(path, div_id){
	result_div = div_id;
	new jquery_ajax(path, '', 'ajaxResultAddGroups');
	return false;
};

function ajaxResultAddGroups(data){
	var obj = $Jq('#'+result_div).get(0);
	$Jq(obj).html('');
	hideAjaxTabs(result_div);
	show_ajax_div();
	$Jq(obj).html(data);
};

function restoreFirstValue(id){
	hideAllBlocks();
	return false;
};

var addToGroup = function(){
	if(arguments[1])
		addGroupsUrl = arguments[1];

	var group_ids = '';
	var frm = document.addGroups;
	for (var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if (e.type=='checkbox' && e.checked){
			group_ids += e.value + ',';
		}
	}
	var currpath = addGroupsUrl+'&group_ids='+group_ids;
	callAjaxUpdateGroups(currpath,'selEditPhotoComments');
	return false
};

function callAjaxUpdateGroups(path, div_id){
	result_div = div_id;
	new jquery_ajax(path, '', 'ajaxResultUpdateGroups');
};

function ajaxResultUpdateGroups(data){
	var obj = $Jq('#'+result_div).get(0);
	$Jq(obj).html(data);
	hideAnimateBlock(result_div);
	if(result_div == 'flag_content_tab'){
		$Jq('#flag').val('');
		$Jq('#flag_comment').val('');
	}else if(result_div == 'favorite_content_tab'){
		$Jq('#selFavoriteLink').hide();
		$Jq('#selRemoveFavoriteLink').show();
	}
};

//favorites
var favorite_count = true;
function callAjaxFavoriteGroups(path, div_id){
	if(0)
		return false;
	result_div = div_id;
	new jquery_ajax(path, '', 'ajaxResultAddGroups');
	return false;
};

var addToFavorite = function(){
	if(arguments[1])
		addFavoritesUrl = arguments[1];

	if(arguments[2])
		result_div = arguments[2];

	var favorite_id = '';

	var frm = document.addFavorites;
	for (var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if (e.type=='checkbox' && e.checked){
			favorite_id += e.value + ',';
		}
	}
	var currpath = addFavoritesUrl+'&favorite_id='+favorite_id;
	$Jq('#selFavoriteLink').toggle()

	if(arguments[2])
		callAjaxUpdateGroups(currpath, result_div);
	else
		callAjaxUpdateGroups(currpath,'selEditPhotoComments');

	var obj;
	if(obj = $Jq('#totalFavorite').get(0))
		$Jq(obj).html(parseInt($Jq(obj).html())+1);
	favorite_count = false;

	return false
};

//flag
function callAjaxFlagGroups(path, div_id){
	result_div = div_id;
	hideAjaxTabs(result_div);
	var div_value = jQuery.trim($Jq('#'+result_div).html());
	if((div_value == '') || (div_value == FLAG_SUCCESS_MSG)){
		show_ajax_div();
		$Jq('#'+result_div).html('<div class="loader" align="center">&nbsp;</div>');
		new jquery_ajax(path, '', 'ajaxResultAddGroups');
	}else{
		show_ajax_div();
	}
	return false;
};

function callAjaxPostVideoGroups(path, div_id){
	result_div = div_id;
	new AG_ajax(path, '', 'ajaxResultAddGroups');
	return false;
};

var addToFlag = function(){
	if(arguments[1])
		addFlagUrl = arguments[1];

	var flag = '';

	var frm = document.addFlag;
	for (var i=0;i<frm.elements.length;i++){
		var e = frm.elements[i];
		if (e.name=='flag'){
			flag = e.value;
		}
		if(e.type=='textarea'){
			flag_comment = e.value;
		}
	}

	var currpath = addFlagUrl+'&flag='+flag+'&flag_comment='+flag_comment;
	callAjaxUpdateGroups(currpath,'flag_content_tab');
	return false
};

//Add Comments
function callAjaxAddComments(path, div_id){
	restoreFirstValue('selEditMainComments');
	result_div = div_id;
	new jquery_ajax(path, '', 'ajaxResultAddComments');
	return false;
};

function ajaxResultAddComments(data){
	var obj = $Jq('#'+result_div).get(0);
	$Jq(obj).attr('display', 'block');
	$Jq(obj).html(data[0]);
	captcha = data[1];
};

var addToComment = function(){
	if(arguments[0]){
		if(!dontUse)
			addCommentsUrl = arguments[0];
	}
	var f = '';
	var frm = document.addComments;
	for (var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if (e.type!='button' && e.name!='captcha_value'){
			var ovalue = Trim(e.value);
			if(ovalue){
				ovalue = replace_string(ovalue, '\n', '<br />');
				f += ovalue;
			}else{
				e.value = '';
				e.focus();
				return false;
			}
		}
	}

	if(captcha!=frm.captcha_value.value){
		alert_manual('invalid captcha', 'alertHyperLink', 1000, 500);
		return;
	}
	var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
	callAjaxComment(currpath,'selCommentBlock');
	return false
};

//todo : need to check with implementation
var addComment = function(){
	var addCommentsUrl = arguments[0];
	var f = '';
	var frm = document.frmPostComments;
	for (var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if (e.type!='button' && e.name!='captcha_value'){
			var ovalue = Trim(e.value);
			if(ovalue){
				ovalue = replace_string(ovalue, '\n', '<br />');
				f += ovalue;
			}else{
				$Jq('#selCommentError').html(no_comment_error_msg);
				e.value = '';
				e.focus();
				return false;
			}
		}
	}

	if(captcha!=frm.captcha_value.value){
		$Jq('#selCaptchaError').html(invalid_captcha_error_msg);
		return;
	}
	if(!reply_comment_id){
		var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
		new jquery_ajax(currpath, '', 'ajaxCommentResult');
	}else{
		var replypath=replyUrl+'&comment_id='+reply_comment_id+'&f='+encodeURIComponent(f);
		new jquery_ajax(replypath, '', 'ajaxCommentResult');
	}
	return false;
};

function ajaxCommentResult(request){
	if(request != ''){
		result = request;
		result = result.split('|||');
		var commentError =false;
		for(i=0;i<result.length;i++){
			if(common = result[i].split('common_')){
				if(common.length > 1){
					$Jq('#selMessage').html(common[1]);
					commentError=true;
				}
			}
			if(comment = result[i].split('comment_')){
				if(comment.length >1){
					$Jq('#selCommentError').html(comment[1]);
					commentError=true;
				}
			}
			if(captcha = result[i].split('captcha_')){
				if(captcha.length > 1){
					$Jq('#selCaptchaError').html(captcha[1]);
					commentError=true;
				}
			}
		}
		$Jq('#selCommentBlock').attr('display', 'block');;
	}

	if(!commentError){
		hideAllBlocks();
		window.location.href = currentUrl;
	}
};


var addToCommentHoneyPot = function(){
	if(arguments[0]){
		if(!dontUse)
			addCommentsUrl = arguments[0];
	}

	var f = '';
	var frm = document.addComments;
	for (var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if (e.type!='button' && e.name!='captcha_value' && e.name!=arguments[1]){
			var ovalue = Trim(e.value);
			if(ovalue){
				ovalue = replace_string(ovalue, '\n', '<br />');
				f += ovalue;
			}else{
				$Jq('#selCommentError').html(no_comment_error_msg);
				e.value = '';
				e.focus();
				return false;
			}
		}
	}
	if(!$Jq('#'+arguments[1]) && $Jq('#'+arguments[1]).val() != ''){
		alert_manual('Errors Found', 'alertHyperLink', 1000, 500);
		return;
	}
	var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
	callAjaxComment(currpath,'selCommentBlock');
	return false;
};

var addToCommentNoCaptcha = function(){
	if(arguments[0]){
		if(!dontUse)
			addCommentsUrl = arguments[0];
	}

	var f = '';
	var frm = document.frmPostComments;
	for (var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if (e.type!='button' && e.name!='captcha_value'){
			var ovalue = Trim(e.value);
			if(ovalue){
				ovalue = replace_string(ovalue, '\n', '<br />');
				f += ovalue;
			}else{
				$Jq('#selCommentError').html(no_comment_error_msg);
				e.value = '';
				e.focus();
				return false;
			}
		}
	}

	if(!reply_comment_id){
		var currpath = addCommentsUrl+'&f='+encodeURIComponent(f);
		new jquery_ajax(currpath, '', 'ajaxCommentResult');
	}else{
		var replypath=replyUrl+'&comment_id='+reply_comment_id+'&f='+encodeURIComponent(f);
		new jquery_ajax(replypath, '', 'ajaxCommentResult');
	}
	return false;
};


function clearComment(){
	var obj = $Jq('#selAddComments').get(0);
	$Jq(obj).attr('display', 'none');
	var obj = $Jq('#selViewPostComment').get(0);
	$Jq(obj).attr('display', 'block');
};

function callAjaxComment(path, div_id){
	new jquery_ajax(path, '', 'ajaxResultComment');
	return false;
};

function ajaxResultComment(data){
	var obj = $Jq('#selCommentBlock').get(0);
	$Jq(obj).attr('display', 'block');
	data = data.split('***--***!!!');
	$Jq(obj).html(data[1]);
	setEditTimerValue(data[0]);

	if(comment_approval){
		if($Jq('#totalComments').length){
			obj = $Jq('#totalComments').get(0)
			$Jq(obj).html(parseInt($Jq(obj).html()+1));
		}
	}
	captcha = data[2];
	//captcha = data[2].strip();
	return;
};

//delete comment
var tr_delete;
function deleteCommand(path, div_id){
	if(confirm(deleteConfirmation)){
		tr_delete = div_id;
		new jquery_ajax(path, '', 'deleteResult');
		beforeDeleteResult();
	}
	return false;
};

function beforeDeleteResult(){
	var obj;

	if($Jq('#'+tr_delete).length){
		obj = $Jq('#'+tr_delete).get(0)
		$Jq(obj).attr('display', 'none');
	}
	if($Jq('#'+tr_delete+'_1').length){
		obj = $Jq('#'+tr_delete+'_1').get(0)
		$Jq(obj).attr('display', 'none');
	}
	if($Jq('#'+tr_delete+'2').length){
		obj = $Jq('#'+tr_delete+'_2').get(0)
		$Jq(obj).attr('display', 'none');
	}
	if($Jq('#'+tr_delete+'_3').length){
		obj = $Jq('#'+tr_delete+'_3').get(0)
		$Jq(obj).attr('display', 'none');
	}

	if(obj = $Jq('#total_comments1').length){
		obj = $Jq('#total_comments1').get(0)
		total_comments = parseInt($Jq(obj).html()-1);
		$Jq(obj).html( total_comments);
	}

	if(obj = $Jq('#total_comments2').length){
		obj = $Jq('#total_comments2').get(0)
		total_comments = parseInt($Jq(obj).html()-1);
		$Jq(obj).html( total_comments);
	}

	if(total_comments && total_comments<=minimum_counts){
		if($Jq('#view_all_comments').length){
			obj = $Jq('#view_all_comments').get(0)
			$Jq(obj).attr('display', 'none');
		}
	}

	if($Jq('#totalComments').length){
		obj = $Jq('#totalComments').get(0)
		$Jq(obj).html(parseInt($Jq(obj).html()-1));
	}
};

function deleteResult(data){
	return;
};

//group video comments
function callAjaxAddCommentsGroup(path, div_id){
	result_div = div_id;
	new AG_ajax(path, '', 'ajaxResultAddComments');
	return false;
};

function clearCommentGroup(){
	var obj = $Jq('#selAddComments').get(0);
	$Jq(obj).attr('display', 'none');
};

//view Video
var downloadCount = true;
function increaseDownload(block_name){
	return true;
	if(!downloadCount)
	return false;

	var obj;
	if(obj = $Jq('#'+block_name).get(0)){
		download_count = download_count+1;
		$Jq(obj).html(download_count);
	}
	downloadCount = false;
	return true;
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

function callAjaxReplyFinal(path, block){
	path = path;
	new jquery_ajax(path, '', 'ajaxResultReplyFinal');
	return false;
};

function ajaxResultReplyFinal(data){
	var obj = $Jq('#selCommentBlock').get(0);
	$Jq(obj).attr('display', 'block');
	//data = data.split('***--***!!!');
	$Jq(obj).html(data[1]);
	setEditTimerValue(data[0]);
	return;
};

function callAjaxReply(path, comment_id){
	//path = path+'&comment_id='+comment_id;
	//new jquery_ajax(path, '', 'ajaxResultReply');
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

function ajaxResultReply(data){
	var obj = $Jq('#selReplyForComments_'+data[0]).get(0);
	$Jq(obj).html(data[1]);
	return true;
};

function discardReply(coment_block, comment_id){
/*	var obj = $Jq('#selAddComments_'+comment_id).get(0);
	$Jq(obj).attr('display', 'none');
	var obj = $Jq('#selViewPostComment_'+comment_id).get(0);
	$Jq(obj).attr('display', 'block');*/
	$Jq('#'+coment_block).toggle('slow');
	$Jq('#comment_'+comment_id).val('');
};

function showReplyToCommentsOption(coment_block){
	$Jq('#'+coment_block).toggle('slow');
}

/*******for ediit comment functions started***********/
function callAjaxEdit(path, comment_id){
	path = path+'&type=edit&comment_id='+comment_id;
	new jquery_ajax(path, '', 'ajaxResultEdit');
	return false;
};

function ajaxResultEdit(data){
	var obj;
	data=data.split(session_check_replace);
	data=data[1];
	//data=data[1].strip();
	data = data.split('***--***!!!');
	var ids=data[0];
	if($Jq('#selEditCommentTxt_'+ids).length){
		obj = $Jq('#selEditCommentTxt_'+ids).get(0)
		$Jq(obj).attr('display', 'none');
	}

	obj = $Jq('#selEditComments_'+ids).get(0);

	$Jq(obj).attr('display', 'block');
	var txt = replace_string(data[1], '<br>', '\n');
	txt = replace_string(txt, '<br />', '\n');
	txt = trim(txt);
	$Jq(obj).html(txt);
	obj = $Jq('#selViewEditComment_'+ids).get(0);
	$Jq(obj).attr('display', 'none');
	return true;
};

function discardEdit(comment_id){
	var obj;

	if(obj = $Jq('selEditCommentTxt_'+comment_id).get(0))
		$Jq(obj).style.display = '';

	if(obj = $Jq('selEditComments_'+comment_id).get(0))
		$Jq(obj).attr('display', 'none');

	if(obj = $Jq('selViewEditComment_'+comment_id).get(0))
		$Jq(obj).attr('display', '');
};

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

/*function callAjaxUpdate(path, block){
	path = path;
	new jquery_ajax(path, '', 'callAjaxUpdateResponse');
	return false;
};*/

function callAjaxUpdateResponse(data) {
	data = data.split('***--***!!!');
	data[0] = data[0];
	//data[0] = data[0].strip();
	if(obj = $Jq('#selEditCommentTxt_'+data[0]).get(0))
		$Jq(obj).html(data[1]);

	discardEdit(data[0]);
	return;
};
/************ edit comments end ********/
function changeTimer(){
	if(typeof enabled_edit_fields_comment == 'undefined')
		return;
	if(enabled_edit_fields_comment.length){
		doTimerFunction();
		setTimeout('changeTimer()',1000);
	}
};

function setEditTimerValue(comment_id){
	enabled_edit_fields_comment[enabled_edit_fields_comment.length] = comment_id;
	enabled_edit_fields_time[comment_id] = max_timer;
};

function doTimerFunction(){
	var val;
	var comment_id;
	for(var i in enabled_edit_fields_comment){
		comment_id = enabled_edit_fields_comment[i];
		if(i!='undefined' && i!='has' && i!='find'){
			val = enabled_edit_fields_time[comment_id];
			if(val<=1)
				hideDeleteEditLinks(comment_id);
			else if(val!=null)
				decrementTime(comment_id);
		}
	}
};

function decrementTime(comment_id){
	var obj;
	var val = enabled_edit_fields_time[comment_id];
	if($Jq('#selViewTimerComment_'+comment_id).length){
		obj = $Jq('#selViewTimerComment_'+comment_id).get(0)
		$Jq(obj).html(val-1);
		$Jq(obj).html($Jq(obj).html()+' Sec');
	}
	enabled_edit_fields_time[comment_id] = val-1;
};

function hideDeleteEditLinks(comment_id){
	var obj;
	var val = enabled_edit_fields_time[comment_id];
	if($Jq('#selViewDeleteComment_'+comment_id).length){
		obj = $Jq('#selViewDeleteComment_'+comment_id).get(0)
		$Jq(obj).attr('display', 'none');
	}
	if($Jq('#selViewEditComment_'+comment_id).length){
		obj = $Jq('#selViewEditComment_'+comment_id).get(0)
		$Jq(obj).attr('display', 'none');
	}
	if($Jq('#selViewTimerComment_'+comment_id).length){
		obj = $Jq('#selViewTimerComment_'+comment_id).get(0)
		$Jq(obj).attr('display', 'none');
	}
	if( $Jq('#cmd'+comment_id).length){
		obj = $Jq('#cmd'+comment_id).get(0)
		$Jq(obj).className = 'clsNotEditable';
	}
	enabled_edit_fields_time[comment_id] = null;
};

function hideMoreTabsDivs(current_div){
	for(var i=0; i<more_tabs_div.length; i++){
		if(more_tabs_div[i] != current_div){
			$Jq('#'+more_tabs_div[i]).hide();
			setClass(more_tabs_class[i],'');
		}
	}
};

function showMoreTabsDivs(current_div){
	for(var i=0; i<more_tabs_div.length; i++){
		if(more_tabs_div[i] == current_div){
			$Jq('#'+current_div).show();
			setClass(more_tabs_class[i], current_active_tab_class);
			break;
		}
	}
};

function getMoreContent(path, div_id, current_li_id){
	var div_value = $Jq('#'+div_id).html();
	result_div = div_id;
	more_li_id = current_li_id;
	//div_value = div_value.strip();
	if(div_value == ''){
		hideMoreTabsDivs(div_id);
		showMoreTabsDivs(div_id);
		$Jq('#'+div_id).html('<div class="loader" align="center">&nbsp;</div>');
		new jquery_ajax(path, '', 'insertMoreTabsContent');
	}else{
		hideMoreTabsDivs(div_id);
		showMoreTabsDivs(div_id);
	}
};

function insertMoreTabsContent(data){
	var obj = $Jq('#'+result_div).get(0);
	$Jq(obj).attr('display', 'block');
	$Jq(obj).html(data);
};

function close_ajax_div(ajax_content_div){
	$Jq("#"+ajax_content_div).fadeOut("slow");
};

function show_ajax_div(){
	$Jq("#"+result_div).fadeOut("slow");
};

function hideAjaxTabs(current_div){
	for(var i=0; i<hide_ajax_tabs.length; i++){
		if(hide_ajax_tabs[i] != current_div){
			$Jq('#'+hide_ajax_tabs[i]).hide();
		}
	}
};

function callAjaxEmail(path, div_id){
	result_div = div_id;
	new jquery_ajax(path, '', 'ajaxResultEmail');
	return false;
};

function ajaxResultEmail(data){
	var obj = $Jq('#'+result_div).get(0);
	hideAjaxTabs(result_div);
	$Jq(obj).html(data);
	show_ajax_div();
};

function checkFavorite(){
	if($Jq('#favorite').is(':checked') == false)
		$Jq('#add_to_favorite').attr('disabled', true);
	else
		$Jq('#add_to_favorite').attr('disabled', false);
};

var removeFromFavorite = function(){
	if(arguments[1])
		removeFavoritesUrl = arguments[1];

	if(arguments[2])
		result_div = arguments[2];

	var currpath = removeFavoritesUrl;

	new jquery_ajax(currpath, '', 'removeFavorite');
	return false
};

function removeFavorite(data){
	var obj = $Jq('#'+result_div).get(0);
	hideAjaxTabs(result_div);
	$Jq('#selFavoriteLink').show();
	$Jq('#selRemoveFavoriteLink').hide();

	$Jq(obj).html(data);
	show_ajax_div();
	setTimeout('hideAnimateBlock(result_div)', 5000);
};

function addToFeatured(path, div_id){
	result_div = div_id;
	new jquery_ajax(path, '', 'ajaxResultFeatured');
	return false;
};

function ajaxResultFeatured(data){
	var obj = $Jq('#'+result_div).get(0);
	hideAjaxTabs(result_div);
	$Jq('#selFeaturedLink').hide();
	$Jq('#selRemoveFeaturedLink').show();
	$Jq(obj).html(data);
	show_ajax_div();
	setTimeout('hideAnimateBlock(result_div)', 5000);
};

var removeFromFeatured = function(){
	if(arguments[1])
		removeFeaturedUrl = arguments[1];

	if(arguments[2])
		result_div = arguments[2];

	var currpath = removeFeaturedUrl;
	new jquery_ajax(currpath, '', 'removeFeatured');
	return false;
};

function removeFeatured(data){
	var obj = $Jq('#'+result_div).get(0);
	hideAjaxTabs(result_div);
	$Jq('#selFeaturedLink').show();
	$Jq('#selRemoveFeaturedLink').hide();

	$Jq(obj).html(data);
	show_ajax_div(result_div);
	setTimeout('hideAnimateBlock(result_div)', 5000);
};

function getPlaylist(path, div_id){
	result_div = div_id;
	new jquery_ajax(path, '', 'showPlaylist');
	return false;
};

function showPlaylist(data){
	//data = data.strip();
	var obj = $Jq('#'+result_div).get(0);
	hideAjaxTabs(result_div);
	$Jq(obj).html(data);
	show_ajax_div();
};

function chkPlaylist(obj){
	if($Jq(obj).val() == "new#"){
		$Jq('#CreatePlaylist').toggleClass('clsDisplayNone');
	}
};

function createPlayList(url){
	$Jq('#clsMsgDisplay_playlist').addClass('clsDisplayNone');
	playlist = $Jq('#playlist').val();
	var pars = '';
	if(playlist == "new#"){
		title = $Jq('#playlistTitle').val();
		var desc = $Jq('#playlistDesc').val();
		var tags = $Jq('#playlistTags').val();
		var access =$Jq('.playlistAccess');
		var accessValue='';

		access.each(function(accessRadio){
			if(accessRadio.checked ==true){
				accessValue=accessRadio.value;
			}
		});
		if(title=='' || desc=='' || accessValue=='' || tags=='' ){
			$Jq('#clsMsgDisplay_playlist').removeClass('clsDisplayNone');
			$Jq('#clsMsgDisplay_playlist').html(invalidPlaylist);
			return false;
		}
		playlistTitle = title;
		pars = 'playlist_name='+title+'&playlist_description='+desc+'&playlist_tags='+tags+'&playlist_access_type='+accessValue;
	}
	if(playlist != "new#" && playlist){
		pars = 'playlist='+playlist;
		playlistId = playlist;
	}

	if(pars){
		pars = url+'&'+pars
		new jquery_ajax(pars, '','ajaxResultPlaylist');
	}else{
		$Jq('#clsMsgDisplay_playlist').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist').html(selectionError);
	}
};

function ajaxResultPlaylist(data){
	if(data.indexOf('#$#')>=1){
		var dataTemp = data.split('#$#');
		data = dataTemp[0];
		playlistId = dataTemp[1];
	}
	$Jq('#clsMsgDisplay_playlist').removeClass('clsDisplayNone');
	if(playlistTitle){
		if(Prototype.Browser.IE){
		    var optn = document.createElement("OPTION");
	    	optn.text = playlistTitle;
		    optn.value = playlistId;
	    	el.options.add(optn);
		}else{
			document.playlistfrm.reset();
			$Jq('#playlist').append('<option value="'+playlistId+'">'+playlistTitle+'</option>');
			$Jq('#playlist').val( playlistId);
			$Jq('#CreatePlaylist').addClass('clsDisplayNone');
		}
	}
	$Jq('#clsMsgDisplay_playlist').html(data);
	$Jq('#clsMsgDisplay_playlist').show();
};