var divToChange = '';
function getRatingDetails(url, pars, divname){
	divToChange = divname;
	$Jq.ajax({
		type: "GET",
		url: url,
		data: pars,
		success: function(originalRequest){
			$Jq("#"+divToChange).html(originalRequest);
		}
	});
};
function getBoardRatingDetails(url, pars, divname){
	divToChange = divname;
	$Jq.ajax({
		type: "GET",
		url: url,
		data: pars,
		success: function(originalRequest){
			$Jq("#"+divToChange).html(originalRequest);
		}
	});
};
function call_ajax_populate_sub_categories(url, add_pars,divname){
	a = document.form_create_discussion.category;
	divToChange = divname;
	cat = a.value;
	pars = 'cid='+cat+'&'+add_pars;
	$Jq.ajax({
		type: "GET",
		url: url,
		data: pars,
		success: function(originalRequest){
			$Jq("#"+divToChange).html(originalRequest);
		}
	});
};
function mouseOverSolutions(rating, start, rate_img_mouse_over, rate_img_mouse_out){
	for(var i=1+start; i<=rating; i++){
		var obj = document.getElementById('rate'+i);
		img_src[i] = obj.src;
		obj.src = rate_img_mouse_over;
	}
	for(; i<=4+start; i++) {
		var obj = document.getElementById('rate'+i);
		img_src[i] = obj.src;
		obj.src = rate_img_mouse_out;
	}
};
function mouseOutSolutions(start) {
	for(var i=1+parseInt(start); i<=4+parseInt(start); i++){
		var obj = document.getElementById('rate'+i);
		obj.src = img_src[i];
	}
};
function showRateToolTip(rateToolTipDiv){
	$Jq('#'+rateToolTipDiv).attr('className', 'clsRateToolTip');
};
function hideRateToolTip(rateToolTipDiv){
	$Jq('#'+rateToolTipDiv).attr('className', 'clsDisplayNone');
};
var doActionOnBoard = function(){
	var act_value = arguments[0];
	var anchorLink = arguments[1];
	var msg_confirm = arguments[2];

	var confirm_message = msg_confirm;

	$Jq('#confirmMessage').html(confirm_message);
	document.formConfirm.action.value = act_value;
	Confirmation('selMsgConfirm', 'formConfirm', Array(), Array(), Array());

	return false;
};
var doActionOnSolution = function(){
	var act_value = arguments[0];
	var anchorLink = arguments[1];
	var msg_confirm = arguments[2];
	var ansId = arguments[3];

	var confirm_message = msg_confirm;

	$Jq('#confirmMessage').html(confirm_message);
	document.formConfirm.action.value = act_value;
	document.formConfirm.aid.value = ansId;
	Confirmation('selMsgConfirm', 'formConfirm', Array(), Array(), Array());

	return false;
};
var doActionOnComment = function(){
	var act_value = arguments[0];
	var anchorLink = arguments[1];
	var msg_confirm = arguments[2];
	var comment_id = arguments[3];
	var confirm_message = msg_confirm;
	$Jq('#confirmMessage').html(confirm_message);
	document.formConfirm.action.value = act_value;
	document.formConfirm.comment_id.value = comment_id;
	Confirmation('selMsgConfirm', 'formConfirm', Array(), Array(), Array());

	return false;
};
function openCategoryAjaxWindow(url){
	pars = '';
	$Jq.ajax({
		type: "GET",
		url: url,
		data: pars,
		success: function(originalRequest){
			ajaxResultOpenAjaxWindow(originalRequest);
		}
	});
};
function ajaxResultOpenAjaxWindow(originalRequest){
	data = originalRequest;
	Confirmation('selAjaxWindow', 'frmAjaxWindow', Array('selAjaxWindowInnerDiv'), Array(data), Array('innerHTML'));
};
function ajaxSubmitIPForm(url, frmName, divname){
	var reply = document.forms[frmName].ip.value;
	if (!Trim(reply)) {
		$Jq('#validReply').html(LANG_compulsory);
		return false;
	}
	$Jq('#validReply').html('');
	var pars = $Jq('#'+frmName).serialize();
	$Jq.ajax({
		type: "POST",
		url: url,
		data: pars,
		beforeSend: displayLoadingImage(),
		success: function(originalRequest){
			$Jq('#'+divname).html(originalRequest);
		}
	});
};
function ajaxSubmitSubLevelForm(url, frmName, divname){
	var reply = document.forms[frmName].category.value;
	if (!Trim(reply)) {
		$Jq('#validReply').html(LANG_compulsory);
		return false;
	}
	$Jq('#validReply').html('');
	var pars = $Jq('#'+frmName).serialize();
	$Jq.ajax({
		type: "POST",
		url: url,
		data: pars,
		beforeSend: displayLoadingImage(),
		success: function(originalRequest){
			$Jq('#'+divname).html(originalRequest);
		}
	});
};
function showNextCategory(url, cat_id, divname){
	pars = '&cat_id='+cat_id+'&mode=showNext';
	ajaxUpdateDiv(url, pars, divname);
};
function ajaxUpdateDiv(url, pars, divname){
	$Jq.ajax({
		type: "POST",
		url: url,
		data: pars,
		success: function(originalRequest){
			$Jq('#'+divname).html(originalRequest);
		}
	});
};
function deleteBoardAttachments(url, pars){
	var info_id = document.msgInfoConfirmform.info_id.value;
	var board_id = document.msgInfoConfirmform.board_id.value;
	var fname = document.msgInfoConfirmform.filename.value;
	//divname =  'selReplyQuesId'+board_id;
	divname =  'allInfos';

	pars = pars+'&attachment_id='+info_id+'&board_id='+board_id+'&attachment_name='+fname;
	$Jq('#attach_'+info_id).remove();
	$Jq('#brsBtn').css('display', '');
	ajaxUpdateDiv(url, pars, divname);
};
var processingRequestForComment = function(){
	var btnSubmitObj = arguments[0];
	var btnResetObj = arguments[1];
	var selProcessingRequestID = arguments[2];
	$Jq('#'+btnSubmitObj).css('display', 'none');
	$Jq('#'+btnResetObj).css('display', 'none');
	$Jq('#'+selProcessingRequestID).html(processingSrc + ' ' + LANG_updating_msg);
};
function hideAnimateBlock(elmt){
	$Jq('#'+elmt).hide('slow');
};
function deleteSolutionAttachments(url, pars){
	var info_id = document.msgAttachConfirmform.attach_id.value;
	var board_id = document.msgAttachConfirmform.attach_content_id.value;
	var fname = document.msgAttachConfirmform.attach_name.value;
	divname =  'allInfos';

	pars = pars+'&attachment_id='+info_id+'&attach_content_id='+board_id+'&attachment_name='+fname;
	$Jq('#attach_'+info_id).remove();
	$Jq('#brsBtn').css('display', '');
	ajaxUpdateDiv(url, pars, divname);
};
function solutionCancel(length){
	$Jq('#solution').val('');
	$Jq('#ss').html(LANG_remaining +" :<span class ='clsCharacterLimit' > "+ length + "</span>");
};
function changeDivInnerHtml(originalRequest){
	var data = originalRequest;
	$Jq("#"+divToChange).html(data);
};
function toggleFavorites(url, pars, divname){
	$Jq("#"+divname).html(loadingSrc);
	ajaxUpdateDiv(url, pars, divname);
};
function updatelength(){
	return true;
	var ss = 'ss';
	var obj = arguments[0];
	if(arguments.length>=2)
		ss = arguments[1];
	var b =obj.form.name;
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "";
	var a;
	a= mlength- obj.value.length ;
	if(a < 0 )
		{
			LANG_remaining = LANG_exceed_limit;
		}
	else if( a >=  0)
		{
			LANG_remaining = LANG_remaining_again;
		}
	b= LANG_remaining +" :<span class ='clsCharacterLimit' > "+Math.abs(a)+"</span>";
	var classAdd = ' clsDisableButton' ;
	if (document.getElementById("post_value"+ss )!=null)
		{
			var classname = $Jq("#post_value"+ss).attr('className');
		}
	else
		{
			var classname = $Jq("#submit").attr('className');
		}
	var len_class = classname.length;
	var x;

	if(a < 0)
		{
			x = classname.split(" ");
			if(typeof(x[2]) == 'undefined' ||  x[x.length-1] != classAdd)
				{
					if (document.getElementById("post_value"+ss)!=null)
						document.getElementById("post_value"+ss).className = document.getElementById("post_value"+ss).className +  classAdd;
					else
						document.getElementById("submit").className = document.getElementById("submit").className +  classAdd;
				}
			if(document.getElementById(ss).className == 'clsZeroColour')
				document.getElementById(ss).className = 'clsNegativeColour';
			if (document.getElementById("post_value"+ss)!=null)
				document.getElementById("post_value"+ss).disabled = true;
			else
				document.getElementById("submit").disabled = true;

		}
	else
		{
			x = classname.split(" ");
			if(document.getElementById(ss).className == 'clsNegativeColour')
					document.getElementById(ss).className = 'clsZeroColour';
			if(x[x.length-1] == 'clsDisableButton')
				{
					if (document.getElementById("post_value"+ss)!=null)
						document.getElementById("post_value"+ss).className = x[0];
					else
						document.getElementById("submit").className = x[0];
				}
			if (document.getElementById("post_value"+ss)!=null)
				document.getElementById("post_value"+ss).disabled = false;
			else
				document.getElementById("submit").disabled = false;

		}
	Element.update(ss, b);
};
function makeBigger(direction, txtarea) {
	if (direction==1) {
    	txtarea.rows = txtarea.rows + 3;
  	} else {
	    txtarea.rows = txtarea.rows - 3;
  	}
};
function updatelengthMine(){
	return true;
	var ret_value = true;
	var need_process = false;
	var ss = 'ss';
	var obj = arguments[0];
	if(arguments.length>=2)
		need_process = arguments[1];

	var b =obj.form.name;
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "";
	var a;
	a= mlength- obj.value.length ;
	if(a < 0 )
		{
			LANG_remaining = LANG_exceed_limit;
		}
	else if( a >=  0)
		{
			LANG_remaining = LANG_remaining_again;
		}
	b= LANG_remaining +" :<span class ='clsCharacterLimit' > "+Math.abs(a)+"</span>";
	var classAdd = ' clsDisableButton' ;
	if (document.getElementById("post_value"+ss )!=null)
		{
			var classname = document.getElementById("post_value"+ss).className;
		}
	else
		{
			var classname = document.getElementById("submit").className;
		}
	var len_class = classname.length;
	var x;

	if(a < 0)
		{
			x = classname.split(" ");
			if(typeof(x[2]) == 'undefined' ||  x[x.length-1] != classAdd)
				{
					if (document.getElementById("post_value"+ss)!=null)
						document.getElementById("post_value"+ss).className = document.getElementById("post_value"+ss).className +  classAdd;
					else
						document.getElementById("submit").className = document.getElementById("submit").className +  classAdd;
				}
			if(document.getElementById(ss).className == 'clsZeroColour')
				document.getElementById(ss).className = 'clsNegativeColour';
			if (document.getElementById("post_value"+ss)!=null)
				document.getElementById("post_value"+ss).disabled = true;
			else
				document.getElementById("submit").disabled = true;

			ret_value = false;
		}
	else
		{
			x = classname.split(" ");
			if(document.getElementById(ss).className == 'clsNegativeColour')
					document.getElementById(ss).className = 'clsZeroColour';
			if(x[x.length-1] == 'clsDisableButton')
				{
					if (document.getElementById("post_value"+ss)!=null)
						document.getElementById("post_value"+ss).className = x[0];
					else
						document.getElementById("submit").className = x[0];
				}
			if (document.getElementById("post_value"+ss)!=null)
				document.getElementById("post_value"+ss).disabled = false;
			else
				document.getElementById("submit").disabled = false;

			ret_value = true;
		}

	Element.update(ss, b);
	if(need_process && ret_value)
		showSubmitProcess();

	return ret_value;
};
var showSubmitProcess=function(){
	var updat_div = 'hideButtons';
	if($Jq('#'+updat_div)){
		$Jq('#'+updat_div).css('display', 'none');
	}
	$Jq('#showProcessDiv').css('display', '');
	$Jq('#showProcessDiv').html(processingSrc);
};
function ajaxDiscuzzSubmitForm(url, frmName, divname, id){
	var reply = document.forms[frmName].user_reply.value;
	if(url.indexOf("cancelOptionToComment") == -1 ){
		if (!Trim(reply)){
			$Jq('#validReply'+id).html(LANG_compulsory);
			return false;
		}
	}
	$Jq('#validReply'+id).innerHTML = '';
	var pars = $Jq('#'+frmName).serialize();
	$Jq.ajax({
		type: "POST",
		url: url,
		data: pars,
		beforeSend: displayLoadingImage(),
		success: function(originalRequest){
			$Jq('#'+divname).html(originalRequest);
		}
	});
};
function getPageSizeWithScroll2(){
	if (window.innerHeight && window.scrollMaxY) {// Firefox
		yWithScroll = window.innerHeight + window.scrollMaxY;
		xWithScroll = window.innerWidth + window.scrollMaxX;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		yWithScroll = document.body.scrollHeight;
		xWithScroll = document.body.scrollWidth;
	} else { // works in Explorer 6 Strict, Mozilla (not FF) and Safari
		yWithScroll = document.body.offsetHeight;
		xWithScroll = document.body.offsetWidth;
  	}
	arrayPageSizeWithScroll = new Array(xWithScroll,yWithScroll);
	return arrayPageSizeWithScroll;
};
//function to change top menu style
var activeTopMenu = function(){
	var menuid = arguments[0];
	$Jq('#'+menuid).addClass('clsTopNavigationHover');
};
var inActiveTopMenu = function(){
	var menuid = arguments[0];
	var str = $Jq('#'+menuid).attr('className');
	$Jq('#'+menuid).attr('className', str.replace(/clsTopNavigationHover/, ""));
};

var abuseContent = function(){

	var act_value = arguments[0];
	var content_id = arguments[1];
	var anchorLink = arguments[2];
	var msg_confirm = arguments[3];

	var confirm_message = msg_confirm;

	document.getElementById('confirmAbuseMessage').innerHTML = confirm_message;
	document.formAbuseConfirm.action.value = act_value;
	document.formAbuseConfirm.content_id.value = content_id;
	Confirmation('selMsgAbuseConfirm', 'formAbuseConfirm', Array(), Array(), Array());

	return false;
}

var chkIsAbuseReasonExists = function(){
	var abuseReason = document.getElementById('reason').value;
	if (!Trim(abuseReason))
		{
			document.getElementById('validReason').innerHTML = LANG_valid_reason_for_abusing;
			return false;
		}
	document.getElementById('validReason').innerHTML = '';
}
var removeReasonErrors = function(){
	document.getElementById('validReason').innerHTML = '';
	document.getElementById('reason').value = '';
}