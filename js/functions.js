var divArray=new Array("generalSetting", "generalIndexSetting", "generalMember", "generalLanguage", "generalMenu", "generalAnnouncement", "generalLogin", "generalList", "generalManageBugs", "generalPlugin");
//onfocus, onblur, issues fixed
var form_name_array = new Array();
if(!block_arr) {
	var block_arr = new Array();
}
var allowChannelHide = true;
var channelDivSet = false;
var allowMenuMoreHide = true;
var menuMoreDivSet = false;
var allowHeaderSearchHide = true;
var headerSearchDivSet = false;
var allowFooterSearchHide = true;
var footerSearchDivSet = false;
var contentSeparator = '#~#';

//function for check box manage
function CheckAll(form_name,check_all,isO,noHL) {
	var trk=0;
	var frm = eval('document.'+form_name);
	var check_frm = eval('document.'+form_name+'.'+check_all);

	for (var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if ((e.name != check_all) && (e.type=='checkbox')){
			if (isO != 1){
				trk++;
				if(e.disabled!=true)
					e.checked=check_frm.checked;
			}
		}
	}
};
function deselectCheckBox(form_name,checkboxelement){
	var frm = eval('document.'+form_name);
	var check_frm = eval('document.'+form_name+'.'+checkboxelement);
	if(check_frm.checked){
		check_frm.checked=false;
	}
};
var displayLoadingImage = function(){
$Jq("#selLoading").show();
};

var hideLoadingImage = function(){
$Jq("#selLoading").hide();
};

function timeDifference(startDate,endDate){
	date1 = startDate;
	date2 = endDate;

	laterdate = date1.split('-');
	laterY=laterdate[0];
	laterM=laterdate[1];
	laterD=laterdate[2];

	earlierdate = date2.split('-');
	earlierY=earlierdate[0];
	earlierM=earlierdate[1];
	earlierD=earlierdate[2];

	var laterdate = new Date(laterY,laterM,laterD);
	var earlierdate = new Date(earlierY,earlierM,earlierD);

	var difference = laterdate.getTime() - earlierdate.getTime();

	var daysDifference = Math.floor(difference/1000/60/60/24);
	difference -= daysDifference*1000*60*60*24
	var hoursDifference = Math.floor(difference/1000/60/60);
	difference -= hoursDifference*1000*60*60
	var minutesDifference = Math.floor(difference/1000/60);
	difference -= minutesDifference*1000*60
	var secondsDifference = Math.floor(difference/1000);

	return daysDifference;
};

function urlencode( str ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Philip Peterson
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: AJ
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // %          note: info on what encoding functions to use from: http://xkr.us/articles/javascript/encode-compare/
    // *     example 1: urlencode('Kevin van Zonneveld!');
    // *     returns 1: 'Kevin+van+Zonneveld%21'
    // *     example 2: urlencode('http://kevin.vanzonneveld.net/');
    // *     returns 2: 'http%3A%2F%2Fkevin.vanzonneveld.net%2F'
    // *     example 3: urlencode('http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a');
    // *     returns 3: 'http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a'

    var histogram = {}, histogram_r = {}, code = 0, tmp_arr = [];
    var ret = str.toString();

    var replacer = function(search, replace, str) {
        var tmp_arr = [];
        tmp_arr = str.split(search);
        return tmp_arr.join(replace);
    };

    // The histogram is identical to the one in urldecode.
    histogram['!']   = '%21';
    histogram['%20'] = '+';

    // Begin with encodeURIComponent, which most resembles PHP's encoding functions
    ret = encodeURIComponent(ret);

    for (search in histogram) {
        replace = histogram[search];
        ret = replacer(search, replace, ret) // Custom replace. No regexing
    }

    // Uppercase for full PHP compatibility
    return ret.replace(/(\%([a-z0-9]{2}))/g, function(full, m1, m2) {
        return "%"+m2.toUpperCase();
    });

    return ret;
};

function urldecode( str ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Philip Peterson
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: AJ
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // %          note: info on what encoding functions to use from: http://xkr.us/articles/javascript/encode-compare/
    // *     example 1: urldecode('Kevin+van+Zonneveld%21');
    // *     returns 1: 'Kevin van Zonneveld!'
    // *     example 2: urldecode('http%3A%2F%2Fkevin.vanzonneveld.net%2F');
    // *     returns 2: 'http://kevin.vanzonneveld.net/'
    // *     example 3: urldecode('http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a');
    // *     returns 3: 'http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a'

    var histogram = {}, histogram_r = {}, code = 0, str_tmp = [];
    var ret = str.toString();

    var replacer = function(search, replace, str) {
        var tmp_arr = [];
        tmp_arr = str.split(search);
        return tmp_arr.join(replace);
    };

    // The histogram is identical to the one in urlencode.
    histogram['!']   = '%21';
    histogram['%20'] = '+';

    for (replace in histogram) {
        search = histogram[replace]; // Switch order when decoding
        ret = replacer(search, replace, ret) // Custom replace. No regexing
    }

    // End with decodeURIComponent, which most resembles PHP's encoding functions
    ret = decodeURIComponent(ret);

    return ret;
};

/******* Start Trim Functions ************/
function Trim(TRIM_VALUE) {
	if(TRIM_VALUE.length < 1){
		return "";
	}
	TRIM_VALUE = RTrim(TRIM_VALUE);
	TRIM_VALUE = LTrim(TRIM_VALUE);
	if(TRIM_VALUE==""){
		return "";
	} else {
		return TRIM_VALUE;
	}
};

function RTrim(VALUE) {
	var w_space = String.fromCharCode(32);
	var v_length = VALUE.length;
	var strTemp = "";
	if(v_length < 1){
		return "";
	}
	var iTemp = v_length -1;
	while(iTemp > -1){
		if(VALUE.charAt(iTemp) == w_space){
		} else {
			strTemp = VALUE.substring(0,iTemp +1);
			break;
		}
		iTemp = iTemp-1;
	}
	return strTemp;
};

function LTrim(VALUE) {
	var w_space = String.fromCharCode(32);
	if(v_length < 1){
		return "";
	}
	var v_length = VALUE.length;
	var strTemp = "";

	var iTemp = 0;

	while(iTemp < v_length){
		if(VALUE.charAt(iTemp) == w_space){
		} else {
			strTemp = VALUE.substring(iTemp,v_length);
			break;
		}
		iTemp = iTemp + 1;
	}
	return strTemp;
};

/***********End trim functions********/



function getAbsoluteOffsetTopConfirmation(obj){
	if(obj)
	{
	    var top = obj.offsetTop;
	    var parent = obj.offsetParent;
	    if (parent) {

			    while (parent != document.body)
					{
				        top += parent.offsetTop;
				        parent = parent.offsetParent;
				    }
		}
	    return top;
	}
}

function getAbsoluteOffsetLeftConfirmation(obj){
	if(obj){
	    var left = obj.offsetLeft;
	    var parent = obj.offsetParent;
	    if(parent){
		    while (parent != document.body)
				{
			        left += parent.offsetLeft;
			        parent = parent.offsetParent;
			    }
		}
	    return left;
	}
}
String.prototype.capitalize = function(){
   return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
  };

function RegularExpressionReplace(expression, subject, replaced) {
  var re = new RegExp(expression, "g");
  return subject.replace(re, replaced);
};

function StringReplcae(find_string, replace_string, subject) {
	return RegularExpressionReplace(find_string, subject, replace_string);
};

function replace_string(str, search_str, replace_str) {
	var condition = true;
	var inc= 1;
	while(condition){
		str = str.replace(search_str,replace_str);
		if(str.indexOf(search_str)<0)
			condition = false;
		inc++;
	}
	return str;
};

//Get multible check box value with comma seperator
var multiCheckValue='';
// form_name, check_all_name, alert_value, place
var getMultiCheckBoxValue = function(){
	var form_name = arguments[0];
	var check_all_name = arguments[1];
	if(arguments.length>2){
		var alert_value = arguments[2];
	}
	var frm = eval('document.'+form_name);
	var ids = '';
	multiCheckValue = '';
	for(var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if ((e.name != check_all_name) && (e.type=='checkbox') && e.checked){
			ids += e.value+',';
		}
	}
	if(ids){
		multiCheckValue =ids.substring(0,ids.length-1);
		return true;
	}
	if(arguments.length>2){
		alert_manual(alert_value);
	}
	return false;
};

function makeQueryAsFormFieldValues(form_name) {
	var query = '';
	var frm = eval('document.'+form_name);
	for(var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if (e.type!='button' && e.type!='checkbox'){
			if(e.type == 'password'){ //Added by Shankar to convert special characters, need to use urldecode in php
				query += e.name+'='+encodeURIComponent(e.value)+'&';
			} else {
				query += e.name+'='+e.value+'&';
			}
		}
	}
	query =query.substring(0,query.length-1);
	return query;
};

var getCheckBoxValue = function(){
	var form_name = arguments[0];
	var check_all_name = arguments[1];
	var frm = eval('document.'+form_name);
	var ids = '';
	for(var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if ((e.name != check_all_name) && (e.type=='checkbox') && e.checked){
			ids += e.value+',';
		}
	}
	if(ids){
		multiCheckValue =ids.substring(0,ids.length-1);
		return true;
	}
	return false;
};

//For sorting
function changeOrderbyElements(form_name,field_name){
 	var obj = eval("document."+form_name+".orderby_field");
 	obj.value = field_name;
 	obj = eval("document."+form_name+".orderby");
 	if(obj.value=="asc"){
 		obj.value="desc";
 	} else {
 		obj.value="asc";
 	}
 	eval("document."+form_name+".submit()");
 	return false;
};

//for postmethod to paging
function pagingSubmit(formname, start){
	var obj = eval("document."+formname);
	obj.start.value = start;
	obj.submit();
	return false;
};

function pagingSubmitViaAjax(formname, div_id, start){
	var obj = eval("document."+formname);
	obj.start.value = start;
	postAjaxForm(formname, div_id);
	return false;
};

function facebookLogout() {
	facebook_logout.document.location = cfg_site_url+'facebookLogout.php';
	return false;
};

// Open External Links as Blank Targets
function externalLinks() {
	if (!document.getElementsByTagName) { return; }
	var anchors = document.getElementsByTagName("a");
	for (var i=0; i<anchors.length; i++) {
		var anchor = anchors[i];
		var anchor_href = anchor.getAttribute("href");
		if (anchor_href && anchor_href.indexOf(cfg_site_url)==-1 && anchor_href.indexOf('http://')==0){
			//alert(anchor_href+"--"+anchor_href.indexOf(cfg_site_url));
			anchor.target = "_blank";
		}
	}
};

//onfocus, onblur, issues fixed
function chkValueInArray(value) {
	if(form_name_array.length == 0){
		return false;
	}
	for (i=0; i < form_name_array.length; i++){
		if (form_name_array[i] == value){
			return true;
		}
	}
};

/**
 * attaches the tooltip to the form elements that have a corresponding
 * help tip div e.g., if the id is user_name, checks for user_name_Help and shows
 * the html of this as the tip on mouse over.
 * jQuery Plugin used: jquery.tooltip
 **/
function helpTipInitialize() {
	$Jq(":input").each(function(){
		var tip_id = $Jq(this).attr('id');
		if(tip_id){
			var tip_id = '#'+tip_id+'_Help';
			//check if the help div exists
			if($Jq(tip_id).length){
				$Jq(this).tooltip({
					bodyHandler: function() {
						return $Jq(tip_id).html();
					},
					showURL: false
					});
			}
		}
	});
};
/**
 * shows the text given in the title attibute of the div/span with class toolTipSpanClass
 * @access public
 * @return void
 **/
function showToolTipForDivs(){
	$Jq('.toolTipSpanClass').tooltip({
			track: true,
			delay: 0,
			showURL: false,
			showBody: " - ",
			fixPNG: true,
			opacity: 0.95
		});
}

function windowOpen(obj){
	window.open(obj.href,'mywindow','toolbar=no, location=no,directories=no,status=no,menubar=no,scrollbars=no,copyhistory=no, resizable=no');
	return false;
};

function setFullScreenBrowser(){
	window.moveTo(0,0);
	window.resizeTo(screen.width,screen.height);
};

function hideAnimateBlock(elmt){
	//fade, slide, glide, wipe, unfurl, grow, shrink, highlight
	$Jq("#"+elmt).fadeOut(5000);
};


function addClassNameForDataTable(){
	$Jq(this).addClass('clsDataMouseoverRow');
};

function removeClassNameForDataTable(){
	$Jq(this).removeClass('clsDataMouseoverRow');
};

function getHTML(url, pars, divname, method_type){
	//need to replace with the code using jQuery
};

var Redirect2URL = function(){
	if(arguments[0])
		location.replace(arguments[0]);
	else
		window.back();
	return false;
};

function setCookie(c_name,value,expiredays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
};

function getCookie(c_name){
	if (document.cookie.length>0){
 		c_start=document.cookie.indexOf(c_name + "=");
 		if (c_start!=-1){
		   	c_start=c_start + c_name.length+1;
			c_end=document.cookie.indexOf(";",c_start);
    		if (c_end==-1) c_end=document.cookie.length;
    		return unescape(document.cookie.substring(c_start,c_end));
    	}
  	}
	return "";
};

function chkValidTags(tags){
	var val;
	var i;
	tags = Trim(tags);
	if(tags=='')
		return true;
	tags = tags.split(' ');
	for (i=0;i<tags.length;i++){
		val = Trim(tags[i]);
		if(val=='')
			continue;
		if((val.length<min_tag_size) || (val.length>max_tag_size))
			return true;
	}
	return false;
};

/* ************** Start Search text functions ************** */
//for search text box
var displayDefaultValue = function(obj, dValue){
	var objValue = obj.value;
	if (objValue == '')
		obj.value = dValue;
};
//for search text box
var clearDefaultValue = function(obj, dValue){
	var objValue = obj.value;
	if (objValue == dValue)
		obj.value = '';
};
var checkforSearchText = function(obj, dValue, msg){
	clearDefaultValue(obj, dValue);
	var objValue = obj.value;
	if (objValue)
		return true;
	alert_manual(msg);
	obj.focus();
	return false;
};
/* ************** End Search text functions ************** */
//function for disable the select all checkbox column
function disableHeading(frmname) {
	var targetForm = document.getElementById(frmname);

	for (var i=1; i<targetForm.elements.length; i++)
		{
			if (targetForm.elements[i].type == "checkbox")
			{	//alert(i);
				if (targetForm.elements[i].checked)
				{	//alert('chekall');
					targetForm.elements[0].checked=true;
				}
				else
				{
					targetForm.elements[0].checked=false;
					break;
				}
			}
		}
};

function newTabWindow(url) {
	window.open(url,'_new');
};

function getImageDetail(photo_id){
//replace using jQuery functions
};

function hideImageDetail(photo_id){
//replace using jQuery functions
};

function ReplyCommentPopup(url,comment_id){
	reply_comment_id=comment_id;
	replyUrl=url;
	postCommentsWindow();
};

var img_src = new Array();
function mouseOver(count) {
	for(var i=1; i<=count; i++) {
		var obj = document.getElementById('img'+i);
		img_src[i] = obj.src;
		obj.src = rateimagehover_url;
	}
	for(; i<=total_images; i++) {
		var obj = document.getElementById('img'+i);
		img_src[i] = obj.src;
		obj.src = rateimage_url;
	}
};

function mouseOut(count) {
	for(var i=1; i<=total_images; i++) {
		var obj = document.getElementById('img'+i);
		obj.src = img_src[i];
	}
};
//functions for rating
var rate_click = true;
function callAjaxRate(path, div_id)
	{
		if(!rate_click)
			return false;
		rate_click = false;
		result_div = div_id;
		new jquery_ajax(path, '', 'ajaxResultRate');
		setTimeout('changeRatingStatus()',2000);
		return false;
	}
function changeRatingStatus(){
		rate_click = true;
}
function ajaxResultRate(data)
	{
		//data = unescape(data.responseText);
		var obj = $Jq('#'+result_div).get(0);
		$Jq(obj).attr('display', 'block');
		if(data.indexOf('ERR~')>=1)
		{
			data = data.replace('ERR~','');
			alert_manual(data);
		}
		else
		{
			$Jq(obj).html(data);
			$Jq(obj).css('top', getAbsoluteOffsetTopConfirmation($Jq('#dAltMulti').get(0) + 'px'));
		}
	}


function loadChangeClass(hoverElement, selector, subMenuClassName) {
	$Jq(hoverElement).find(selector).each(function(){
		if($Jq(this).css('class') !==  subMenuClassName)
		{
			$Jq(this).mouseover(function(){
				$Jq(this).addClass(subMenuClassName);
			});
			$Jq(this).mouseout(function(){
				$Jq(this).removeClass(subMenuClassName);
			});
		}
	});

};


//To select Content inside DIV element like Textarea
function fnSelect(objId) {
	fnDeSelect();
	if (document.selection) {
		var range = document.body.createTextRange();
		range.moveToElementText(document.getElementById(objId));
		range.select();
	}
	else if (window.getSelection) {
		var range = document.createRange();
		range.selectNode(document.getElementById(objId));
		window.getSelection().addRange(range);
	}
};

//To un-select selected Content inside DIV element
function fnDeSelect() {
	if (document.selection) document.selection.empty();
	else if (window.getSelection) window.getSelection().removeAllRanges();
};

function divShowHide(div_id, show_link_id, hide_link_id) {
		if($Jq('#'+div_id).css('display') == 'none')
			{
				$Jq('#'+show_link_id).hide();
				$Jq('#'+hide_link_id).show();
				$Jq('#'+div_id).show();
			}
		else
			{
				$Jq('#'+show_link_id).show();
				$Jq('#'+hide_link_id).hide();
				$Jq('#'+div_id).hide();
			}
};

function hideMoreTabsDivs(current_div) {
		for(var i=0; i<more_tabs_div.length; i++)
			{
				if(more_tabs_div[i] != current_div)
					{
						$Jq('#'+more_tabs_div[i]).hide();
						$Jq('#'+more_tabs_class[i]).removeClass(current_active_tab_class);
					}
			}
};

function showMoreTabsDivs(current_div) {
		for(var i=0; i<more_tabs_div.length; i++)
			{
				if(more_tabs_div[i] == current_div)
					{
						$Jq('#'+current_div).show();
						$Jq('#'+more_tabs_class[i]).addClass(current_active_tab_class);
						break;
					}
			}
};

function memberBlockLoginConfirmation(msg,url) {
	document.msgConfirmformMulti1.action = url;
	return Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(msg), Array('innerHTML'));
};

//Hide all confirmation blocks
var hideAllBlocks = function(){
	var obj;

	if(obj = $Jq('#selAlertbox')){
		$Jq(obj).hide();
	}

	for(var i=0;i<block_arr.length;i++){
		if(obj = $Jq("#"+block_arr[i])) {
			$Jq(obj).hide();
			$Jq(obj).dialog("close");
		}
	}
	if(obj = $Jq('#hideScreen')){
		$Jq(obj).hide();
	}

	if(obj = $Jq('#selAjaxWindow')){
		$Jq(obj).hide();
	}

	if(obj = $Jq('#selAjaxWindowInnerDiv')){
		$Jq(obj).html('');
	}

	return false;
};

var getMultiCheckBoxValue = function(){
	var form_name = arguments[0];
	var check_all_name = arguments[1];
	if(arguments.length>2){
		var alert_value = arguments[2];
	}
	var frm = eval('document.'+form_name);
	var ids = '';
	multiCheckValue = '';
	for(var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if ((e.name != check_all_name) && (e.type=='checkbox') && e.checked) {
			ids += e.value+',';
		}
	}
	if(ids){
		multiCheckValue =ids.substring(0,ids.length-1);
		return true;
	}
	if(arguments.length>2){
		alert_manual(alert_value);
	}
	return false;
};

var alert_manual = function() {
	var obj;
	var alert_value = arguments[0];
	if(obj = $Jq('#selAlertMessage')){
		obj.html(alert_value);
	}

	$Jq("#selAlertbox").dialog({
		modal: true,
		buttons: {
			Ok: function() {
				$Jq(this).dialog('close');
			}
		}
	});
	return false;
};

//Display confirmation Block for login
//Not used right now, we can remove later after confirmation
var loginConfirmation = function(){
	var obj, inc, form_field;
	hideAllBlocks();

	var block = arguments[0];
	var id_name = arguments[1];
	var value_of_id = arguments[2];
	var property_name = arguments[3];

	if(obj = $Jq("#"+id_name)){
		switch(property_name){
			case 'innerHTML':
			case 'html':
				$Jq("#"+id_name).html(value_of_id);
				break;
			case 'text':
				$Jq("#"+id_name).text(value_of_id);
				break;
			case 'val':
			case 'value':
				$Jq("#"+id_name).val(value_of_id);
				break;
			default:
				alert('This ' + property_name + ' property not added in this function. Add this ' + property_name + ' property in switch case. This is for testing.. need to remove.. ');
		} // switch
	}

	loginPopupObj = $Jq("#"+block);
	if (loginPopupObj.title == '' || loginPopupObj.title == undefined){
		loginPopupObj.attr("title", cfg_site_name);
	}
	loginPopupObj.dialog({
		modal: true,
		position: 'center'
	});
	return false;
};

//Display confirmation Block
//block, form_name, id_array, value_array, property_array
var Confirmation = function(){
	var obj, inc, form_field;

	var block = arguments[0];
	var form_name = arguments[1];
	var id_array = arguments[2];
	var value_array = arguments[3];

	block_arr[block_arr.length] = block;
	hideAllBlocks();

	var property_array = new Array();
	multiCheckValue ='';

	if(arguments.length>=5){
		property_array = arguments[4];
	}

	for(inc=0; inc<value_array.length;inc++){
		if(!property_array[inc]){
			property_array[inc] = 'value';
		}
		form_field = eval('document.'+form_name+'.'+id_array[inc]);
		if(form_field && form_field[property_array[inc]]!=null){
			form_field[property_array[inc]] = value_array[inc];
		} else if(obj = $Jq("#"+id_array[inc])){
			switch(property_array[inc]){
				case 'innerHTML':
				case 'html':
					$Jq("#"+id_array[inc]).html(value_array[inc]);
					break;
				case 'text':
					$Jq("#"+id_array[inc]).text(value_array[inc]);
					break;
				case 'val':
				case 'value':
					$Jq("#"+id_array[inc]).val(value_array[inc]);
					break;
				default:
					alert('This ' + property_array[inc] + ' property not added in this function. Add this ' + property_array[inc] + ' property in switch case. This is for testing.. need to remove.. ');
			} // switch
		}
	}

	fromObj = $Jq("#"+block);
	if (fromObj.title == '' || fromObj.title == undefined){
		fromObj.attr("title", cfg_site_name);
	}
	fromObj.dialog({
		modal: true,
		position: 'center'
	});

	$Jq("#"+block).find('.clsSubmitButton').focus();
	$Jq("#"+block).find('.clsCancelButton').focus();
	$Jq("#"+block).find('.clsPopUpButtonReset').focus();

	return false;
};

var isMember = false;
var callBackArray = new Array();
var callBackArguments = new Array();
//Possible arguments and usage
//openAjaxWindow(loginRequired, actionRequested, agrs1, agrs2, agrs3, etc...)
//loginrequired = 'true' / 'false' 								*** compulsory ****
//actionRequested = 'redirect' / 'ajaxpopup' / 'ajaxupdate' 	*** compulsory ****
//agrs1 = linkID / function name to call 						*** compulsory ****
//agrs2 = pars / args to pass 									***  Optional  ****
var openAjaxWindow = function(){

	if (arguments.length < 3){
		alert_manual('Required arguments missing! Check your code');
		return false;
	}
	//Initialize callBackArray
	callBackArray = new Array();
	//Login required or not
	callBackArray[0] = arguments[0];
	//Possible values are redirect, ajaxpopup, ajaxupdate
	callBackArray[1] = arguments[1];
	//ID of the object clicked or function name to be called
	callBackArray[2] = arguments[2];
	//Stored the remaining arguments in callBackArray
	if (arguments.length > 3){
		for (var i = 3; i < arguments.length; i++){
			callBackArray[i] = arguments[i];
		}
	}

	if (callBackArray[0] == 'true' || callBackArray[0] == true){
		checkIsMember();
	} else {
		proceedRequest();
	}
	return false;
};

//This function will proccess the requested action.
var proceedRequest = function(){

	//check callBackArray contains value
	if (callBackArray.length) {

		//Possible values are redirect, ajaxpopup, ajaxupdate
		var actionRequested = callBackArray[1];

		switch(actionRequested){
			case 'redirect':
				//ID of the object clicked
				var linkID = callBackArray[2];
				//href of the url clicked
				var url = $Jq("#"+linkID).attr("href");
				//Redirect to the requested url
				window.location.href = url;
				break;
			case 'ajaxpopup':
				//Close the dialog if opened
				$Jq("#selAjaxLoginWindow").dialog('close');
				//ID of the object clicked
				var linkID = callBackArray[2];
				//href of the url clicked
				var url = $Jq("#"+linkID).attr("href");
				pars = '';
				$Jq.ajax({
				   	type: "POST",
				   	url: url,
				   	data: pars,
				   	success: function(originalRequest){
						    	Confirmation('selAjaxWindow', 'frmAjaxWindow', Array('selAjaxWindowInnerDiv'), Array(originalRequest), Array('html'));
						   	}
				 });
				break;
			case 'ajaxupdate':

				//function name to call
				var functionNameToCall = callBackArray[2];
				//Form the arguments for the function to call from callBackArray
				var agrumentsToPass = '';
				//callBackArray length
				var callBackArrayLength = callBackArray.length;

				callBackArguments = new Array();
				if (callBackArrayLength > 3){
					for (var i = 3; i < callBackArrayLength; i++){
						callBackArguments[i-3] = callBackArray[i];
					}
				}
				//Create the function call from function name and parameter.
				//var funcCall = functionNameToCall + "(" + agrumentsToPass + ");";
				var funcCall = functionNameToCall + "();";
				//Call the function
				var ret = eval(funcCall);
				break;
		} // switch

	} else {
		window.location.href = cfg_site_url;
	}
};

//Check session exists or not
var checkIsMember = function(){

	url = cfg_login_check_url;
	pars = 'check_is_member=1';
	$Jq.ajax({
	   	type: "POST",
	   	url: url,
	   	data: pars,
	   	success: function(originalRequest){
	   				if (originalRequest == 'true') {
			    		isMember = true;
			    		//Process the requested url
		    			proceedRequest();
			    	} else {
			    		//Show login form
			    		showLoginForm();
			    	}
			   	}
	 });
	return isMember;
};

//It will display login popup
var showLoginForm = function(){
	url = cfg_login_url;
	//pars = '';
	pars = '';
	$Jq.ajax({
	   	type: "POST",
	   	url: url,
	   	data: pars,
	   	success: function(originalRequest){
			    	Confirmation('selAjaxWindow', 'frmAjaxWindow', Array('selAjaxWindowInnerDiv'), Array(originalRequest), Array('html'));
			   	}
	 });
};

//Function that called in login popup to validate username & password
//On failure displays login window again
//On success proccess the requested action
var doAjaxLogin = function(frmName){
	url = cfg_login_url;
	var pars = 'login_submit=1&'+$Jq("#"+frmName).serialize();
	$Jq.ajax({
	   	type: "POST",
	   	url: url,
	   	data: pars,
	   	success: function(originalRequest){
	   				$Jq("#selAjaxWindow").dialog('close');
	   				agrs = originalRequest.split('|##|');
	   				//check logged in successfully
	   				if (agrs[1] == 'true' || agrs[1] == true) {
			    		isMember = true;
			    		//Process the requested url
			    		proceedRequest();
			    	} else {
			    		//Show login form again with error message
			    		Confirmation('selAjaxWindow', 'frmAjaxWindow', Array('selAjaxWindowInnerDiv'), Array(originalRequest), Array('html'));
			    	}
			   	}
	 });
};

function jquery_ajax(url, pars, function_name)
	{
		if(arguments.length<=0){
			var url = callBackArguments[0];
			var pars = callBackArguments[1];
			var function_name = callBackArguments[2];
		}
		$Jq.ajax({
			type: "POST",
			url: url,
			data: pars,
			//beforeSend:displayLoadingImage(),
			success: eval(function_name)
		 });
		return false;
	}

var postAjaxForm = function(){
	//form name to post
	var frmname = arguments[0];
	//div id to populate the response
	var divname = arguments[1];
	//action url change
	var action = $Jq("#"+frmname).attr('action');
	if(arguments.length>2){
		action = arguments[2];
	}
	//To remove particularElement
	var remove_element = '';
	if(arguments.length>3){
		remove_element = arguments[3];
	}
	var data = $Jq("#"+frmname).serialize();
	$Jq.ajax({
		type: "POST",
		url: action,
		data: data,
		beforeSend:displayLoadingImage(),
		success: function(html){
					if(remove_element){
						$Jq(remove_element).remove();
					}
					hideLoadingImage();
				 	$Jq("#"+divname).html(html);
				}
	 });
	 return false;
}

html2xml = function(xmlText){
	var doc = null;
	//code for IE
	if (window.ActiveXObject)  {
		doc=new ActiveXObject("Microsoft.XMLDOM");
		doc.async="false";
		doc.loadXML(xmlText);
	}
	// code for Mozilla, Firefox, Opera, etc.
	else{
		var parser=new DOMParser();
		doc=parser.parseFromString(xmlText,"text/xml");
	}
	return doc;
}

/*** content filter settings ***/
function chnageContentFilter(){
	var url = callBackArguments[0];
	var pars = callBackArguments[1];
	var method_type = callBackArguments[2];

	$Jq.ajax({
		type: method_type,
		url: url,
		data: pars,
		beforeSend:displayLoadingImage(),
		success: function(html){
					hideLoadingImage();
				 	$Jq("#selContentFilterStatus").html(html);
				}
 	});
 	return false;
}

//*** function to show option to edit info ***//
var showOptionToEdit = function(){
	var linkId = callBackArguments[0];
	var infotype = callBackArguments[1];
	var infoobj = callBackArguments[2];
	var infoid = '';
	if (callBackArguments.length > 3){
		infoid = callBackArguments[3];
	}
	var infovalue = escape($Jq("#"+infoobj).html());
	var url = 'profileInfo.php';
	var pars = 'showoption=1&linkId='+linkId+'&infotype='+infotype+'&infoobj='+infoobj+'&infovalue='+infovalue+'&infoid='+infoid;
	$Jq.ajax({
		type: "POST",
		url: url,
		data: pars,
		beforeSend: displayLoadingImage(),
		success: function(originalRequest){
					hideLoadingImage();
					if (Trim(originalRequest)) {
				 		$Jq("#"+linkId).html(originalRequest);
				 	}
				}
 	});
}

//*** function to check and call update profile function ***//
var updateProfileData = function(){
	var linkId = callBackArguments[0];
	var infotype = callBackArguments[1];
	var infoobj = callBackArguments[2];
	var infoid = '';
	if (callBackArguments.length > 3){
		infoid = callBackArguments[3];
	}
	var infovalue = '';
	var infoobjType = infoobj.type;
	switch(infoobjType){
		case 'text':
		case 'password':
		case 'textarea':
		case 'select':
		case 'select-one':
		case 'radio':
			infovalue = infoobj.value;
			break;
		case 'checkbox':
			var selectedItems = new Array();
		    $Jq("input[@name='"+infoobj.name+"']:checked").each(function(){
		    	selectedItems.push($Jq(this).val());
		    });
		    infovalue = selectedItems.join('/');
			break;
	} // switch
	infovalue = escape(infovalue);
	var url = 'profileInfo.php';
	var pars = 'updateprofile=1&linkId='+linkId+'&infotype='+infotype+'&infoobj='+infoobj.name+'&infovalue='+infovalue+'&infoid='+infoid;
	$Jq.ajax({
		type: "POST",
		url: url,
		data: pars,
		beforeSend: displayLoadingImage(),
		success: function(originalRequest){
					hideLoadingImage();
					if (Trim(originalRequest)) {
				 		$Jq("#"+linkId).html(originalRequest);
				 	}
				}
 	});
}

//*** function to check and call update profile function ***//
var updateProfileDataText = function(){
	/* arguments to be passed:
	linkId -> the Id of the div to be updated with the return value ..
	infotype -> aboutMe or field_name or id for personal info related and other info related
				(users_profile_question tables id field)
	infoid -> empty for aboutMe or 1 for personal info related and 2 for other info related
				(users_profile_question tables form_id field)
	*/

	var linkId = callBackArguments[0];
	var infotype = callBackArguments[1];
	var infovalue = callBackArguments[2];
	var infoid =  callBackArguments[3];
	var orig_value =  callBackArguments[4];
	//alert('linkId'+linkId+' infotype '+infotype+' infovalue '+infovalue+' infoid'+infoid);
	infovalue = escape(infovalue);
	//in multiple select , when no value is selected. .val returns null
	if (infovalue == 'null' && linkId.indexOf('selcheck') == 0) {
		infovalue = '';
	}

	var url = 'profileInfo.php';
	if (callBackArguments.length > 5){
		url =  callBackArguments[5];
	}
	var pars = 'updateprofile=1&linkId='+linkId+'&infotype='+infotype+'&infovalue='+infovalue+'&infoid='+infoid;
	$Jq.ajax({
		type: "POST",
		url: url,
		data: pars,
		beforeSend: displayLoadingImage(),
		success: function(originalRequest){
					hideLoadingImage();
					if ($Jq.trim(originalRequest)) {
						//check if error code is returned ..
						var returned_value = $Jq.trim(originalRequest);
						var error_message = contentSeparator+'error'+contentSeparator;
						if(returned_value.indexOf(error_message)== 0)
						{
							var error_string = returned_value.substring(error_message.length);
							alert_manual(error_string);
							if($Jq("#"+linkId).hasClass('editablecalendar_basic'))
				 			{
				 			 	var id_array = 'infoarray_'+infoid;
				 			 	var orig_date =  eval(id_array).selected;
				 			 	date_arr = orig_date.split(contentSeparator);
				 			 	$Jq("#"+linkId).html(date_arr[0]);
				 			}
				 			else
				 				$Jq("#"+linkId).html(orig_value);


						}
						else
						{
							// if date picker handle it differently, it returns displayformat#~#dob
							//!!$('#mydiv').attr('class').match(/\bbar/)
							if($Jq('#'+linkId).attr('class').match(/\beditablecalendar/)  ||
								$Jq('#'+linkId).attr('class').match(/\beditableselect/) ||
								$Jq('#'+linkId).attr('class').match(/\beditablecheck/)
							)
							//if($Jq("#"+linkId).hasClass('editablecalendar_basic'))
							{
								returned_arr = returned_value.split(contentSeparator);
					 			$Jq("#"+linkId).html($Jq.trim(returned_arr[0]));
					 			var id_array = 'infoarray_'+infoid;
					 			//if date_arr[1] is set, set the selected value to it,
					 			//else set it back to date_arr[0] itself..
					 			if(!$Jq("#"+linkId).hasClass('editablecalendar_basic'))
					 			{
					 				if(returned_arr.length > 1)
					 					var selected_value = $Jq.trim(returned_arr[1]);
					 				else
					 					var selected_value = $Jq.trim(returned_arr[0]);
				 			 		eval(id_array).selected = selected_value;
					 			}
					 			else
					 					eval(id_array).selected = $Jq.trim(originalRequest);
						 	}
						 	else
						 	{
						 		//issue with special chars hence cleared and then append is used instead of hml directly
						 		$Jq("#"+linkId).html('');
						 		$Jq("#"+linkId).append(originalRequest);

						 	}

					 	}
				 	}

				}
 	});
}

function showHideLang() {
	var i=0, total_lang_li =0;
	while($Jq('#langlist li')[i++]){
		total_lang_li++;
	}
	if(total_lang_li<=0){
		return false;
	}
	$Jq('#showhidelang').toggle();
	if($Jq('#showhidetheme')){
		$Jq('showhidetheme').hide();
	}
}

function showHideTheme() {
	var k=0, total_theme_li =0;
	while($Jq('#themelist li')[k++]){
		total_theme_li++;
	}
	if(total_theme_li<=0){
		return false;
	}
	$Jq('#showhidetheme').toggle();
	if($Jq('showhidelang')){
		$Jq('showhidelang').hide();
	}
}

//argument1: id of the tab
var attachJqueryTabs = function(){
	var div_id = arguments[0];
	$Jq("#"+div_id).tabs({
			cache: true,
			fx: { opacity: 'toggle' }
		});
}

// to report users
var reportUser = function(){
	var path = callBackArguments[0];
	$Jq('#selReportUser').addClass('clsReportTag clsActive')
	pars = '';
	jquery_ajax(path, pars, 'reportUserResponse');
	return false;
};
function reportUserResponse(originalRequest){
	data = originalRequest+' ';
	//$Jq('#selReportUserOuterDiv').show();
	//$Jq('#selReportUserOuterDiv').html(data);
	Confirmation('selAjaxWindow', 'frmAjaxWindow', Array('selAjaxWindowInnerDiv'), Array(data), Array('innerHTML'));
};
var submitReporting = function()
	{
		if(callBackArguments[1])
			addReportUrl = callBackArguments[1];

		var reports = '';
		var custom_message = '';

		var frm = document.frmReportUsers;
		for (var i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				if (e.type=='checkbox' && e.checked)
					{
						reports += e.value + ',';
					}
			}
		if($Jq('#custom_message'))
			{
				custom_message = $Jq('#custom_message').val();
			}

		var currpath = addReportUrl+'&reports='+reports+'&custom_message='+custom_message;
		var data = '';

		$Jq.ajax({
			type: "POST",
			url: currpath,
			data: data,
			beforeSend:displayLoadingImage(),
			success: function(html){
						hideLoadingImage();
					 	$Jq("#selAjaxWindowInnerDiv").html(html);
					}
		 });
	};

/* apply class for first and last list in ul */
var applyClassForFirstAndLastLi = function(){
	$Jq(document).ready(function(){
		$Jq('ul').each(function(){
			var inc = 1;
			var totalli = $Jq('li', this).length;
			$Jq('li', this).each(function(){
				if(inc == 1){
					$Jq(this).addClass('clsLiFirst');
					$Jq(this).hover(
						function() { $Jq(this).addClass('clsLiFirstActive'); },
						function() { $Jq(this).removeClass('clsLiFirstActive'); }
					);
				}else if(inc == totalli){
					$Jq(this).addClass('clsLiLast');
					$Jq(this).hover(
						function() { $Jq(this).addClass('clsLiLastActive'); },
						function() { $Jq(this).removeClass('clsLiLastActive'); }
					);
				}
				else{
					$Jq(this).hover(
						function() { $Jq(this).addClass('clsLiAcive'); },
						function() { $Jq(this).removeClass('clsLiAcive'); }
					);
				}
				inc++;
			});
		});
	});
}
var hideShowDropDown = function(){
	var browserdata = getBrowser();
	if(!(browserdata[0]=='msie' && browserdata[1]=='6.0')){
		return;
	}
	var ulobj = arguments[0];
	var status = arguments[1];
	if(ulobj.attr('dropdownhide')){
		var dropdownhide = ulobj.attr('dropdownhide');
		dropdownhide = dropdownhide.split(',');
		for(var i=0; i<dropdownhide.length; i++){
			var dropdownid = $Jq.trim(dropdownhide[i]);
			if(dropdownid){
				if(status == 'hide'){
					$Jq('#'+dropdownid).addClass('clsDropDownHide');
				}
				else{
					$Jq('#'+dropdownid).removeClass('clsDropDownHide');
				}
			}
		}
	}
}
var dropDownLinkClick = function(event) {
		var $target = $Jq(event.target).parent();
		if($Jq(event.target).hasClass('clsSubLists')){
			return;
		}
		if($Jq($target[0]).hasClass('selDropDownLinkClick')){
			if($Jq('ul', $target[0]).css('display') == 'none'){
				$Jq('ul', $target[0]).css('display', 'block');
			}else{
				$Jq('ul', $target[0]).css('display', 'none');
			}
			$Jq('li', document).each(function(){
				if(this!=$target[0]){
					$Jq('ul', this).css('display', 'none');
				}
			});
			hideShowDropDown($Jq('ul', $target[0]), 'hide');
			return;
		}
		$Jq('li', document).each(function(){
			if($Jq(this).hasClass('selDropDownLinkClick')){
				var obj = this;
				setTimeout(function(){
					$Jq('ul', obj).css('display', 'none');
					hideShowDropDown($Jq('ul', obj), 'show');
				}, 500);
			}
		});
		return;
	}
$Jq(window).load(function(){
		/* drop down menu link */
		$Jq('li.selDropDownLink').hover(
			function() {
				$Jq('ul', this).css('display', 'block');
				hideShowDropDown($Jq('ul', this), 'hide');
			},
			function() {
				$Jq('ul', this).css('display', 'none');
				hideShowDropDown($Jq('ul', this), 'show');
			}
		);

		/* For input field character limiter */
		$Jq('.selInputLimiter').each(function(){
			$Jq(this).inputlimiter({
				limit: $Jq(this).attr('maxlimit'),
				remText: LANG_JS_common_remaining_char_count,
				remFullText: LANG_JS_common_stop_typing_after_reached_limit,
				limitText: LANG_JS_common_allowed_char_limit});
		});

		/* apply class for first and last list in ul */
		applyClassForFirstAndLastLi();

		/* Auto Fill text */
		$Jq('input.selAutoText').focus(function(){
				if($Jq(this).val() == $Jq(this).attr('title')){
					$Jq(this).val('');
				}
			}
		);
		$Jq('input.selAutoText').blur(function(){
				if($Jq(this).val() == ''){
					$Jq(this).val($Jq(this).attr('title'));
				}
			}
		);

		/* color picker */
		$Jq('form#colorPicker').bind('submit', function(){
          alert($(this).serialize());
          return false;
        });

        /* png fix */
        $Jq("img").pngfix();
	});
