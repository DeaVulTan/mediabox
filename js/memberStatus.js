// JavaScript Document



var allowHide = true;
var curStatusElem;
var curStatus = '';

var nocolour = '';

var customMode = false;

var pickerElementId = 'dynamicStatusChanger';
var iframePickerId = 'dynamicStatusChangerIFrame';
var iframePickerId2 = 'dynamicStatusChangerIFrame2';
var iframeDivWidth = '220px';
//if (document.all) { nocolour = ''; }


var detect = navigator.userAgent.toLowerCase();// alert(detect);
var OS,browser,version,total,thestring;
if (_checkIt('konqueror')) {
	browser = "Konqueror"; OS = "Linux";
} else if (_checkIt('safari'))
	browser = "Safari"
		else if (_checkIt('opera'))
		browser = "Opera"
			else if (_checkIt('msie'))
			browser = "IE"
				else if (!_checkIt('compatible')) {
					browser = "Netscape Navigator"
					version = detect.charAt(8);
				} else browser = "Unknown";

if (!version) version = detect.charAt(place + thestring.length);
if (!OS) {
	if (_checkIt('linux')) OS = "Linux";
	else if (_checkIt('x11')) OS = "Unix";
		else if (_checkIt('mac')) OS = "Mac"
			else if (_checkIt('win')) OS = "Windows"
				else OS = "Unknown";
}
var doiframe = (browser == "IE");
function _checkIt(string) {
	place = detect.indexOf(string) + 1;
	thestring = string;
	return place;
}// EOF _checkIt()

//------------------------

function getObject(id) {
	return $Jq('#'+id).get(0);
}// EOF getObject()


function pickStatus(elem) {
	//alert(elem+status_all);
	if(status_all){
		status_array=status_all.split(',');
	} else {
		status_array='';
	}
    if (!statusDivSet) { setStatusDiv(); }
	allowHide = false;
	//listen('mousemove', pageId, hideTarget);
	$Jq('#'+pageId).mouseover(function(){
		hideTarget();
	});
	var picker = getObject(pickerElementId);
    if (elem == curStatusElem && $Jq(picker).css("display") == 'block') {
		if(picker!=null)
       		 $Jq(picker).css("display", "none");
     	return;
	}//EOF if-elem

    curStatusElem = elem;

     $Jq(picker).css('top', getAbsoluteOffsetTop(elem) + 14 + "px");
     $Jq(picker).css('left', getAbsoluteOffsetLeft(elem) + 2 + "px");
     customMode = false;
     $Jq(picker).css("display", 'block');
}

function setStatusDiv() {
    if (!document.createElement) { return; }
    var elemDiv = document.createElement('div');
    if (typeof(elemDiv.innerHTML) != 'string') { return; }
    elemDiv.id = pickerElementId;
    elemDiv.className = 'pickerElementId';
    elemDiv.style.position = 'absolute';
    elemDiv.style.display = 'none';
    elemDiv.style.zIndex = 99;
	str = '<ul id="userStatusPicker" class="clsStatusPicker">';
	for(k=0;k<status_array.length;k++){
	    status_new=status_array[k];
	    status_split=status_new.split('#~#');
	    status_id=status_split[0];
	    status_value=status_split[1];
		str += '<li class="clsCurrentStatus"><a href="#" onMouseOver="allowHide=false" onMouseOut="allowHide=true" onclick="return assign(\''+ status_id +'\', \''+ status_value +'\')">' + unescape(status_value) + '</a></li>';
	}
	/*str += '<li><a href="#" onclick="return false()" onMouseOver="allowHide=false" onMouseOut="allowHide=true"/>--------------------</a></li>';*/
	str += '<li><a href="'+ statusSettingUrl +'" onMouseOver="allowHide=false" onMouseOut="allowHide=true">'+LANG_SETTINGS+'</a></li>';
	str += '<li id="statusPickerLogout"><a href="'+ logoutUrl +'" onMouseOver="allowHide=false" onMouseOut="allowHide=true">'+LANG_LOGOUT+'</a></li>';
	str += '</ul>';
	elemDiv.innerHTML='';
	elemDiv.innerHTML = str;
	document.body.appendChild(elemDiv);
    statusDivSet = true;
}// EOF setStatusDiv()

function getAbsoluteOffsetTop(obj) {
    var top = obj.offsetTop;
    var parent = obj.offsetParent;
    while (parent != document.body) {
        top += parent.offsetTop;
        parent = parent.offsetParent;
    }//EOF while-parent
    return top;
}// EOF getAbsoluteOffsetTop()

function askNewStatus(){
	var sample = 'New Status';
	var newStatus = prompt('Enter Your New Status', sample );
	if (newStatus!=null && (!stricmp(newStatus, sample)) && newStatus.length>0){
		newStatus = newStatus.substring(0, 20);
	}
}

function stricmp(str1, str2){
	return (str1.toLowerCase() === str2.toLowerCase());
}

function addNewStatus(){

}

function assign(v, txt){
	obj = getObject('onlineStatusSpan');
	if(obj!=null){
		//obj.innerHTML = txt;
		if(status_string_total_length<txt.length)
	 	   var wraped_st=txt.substring(0,status_string_total_length)+' ...';
		else
	  	  var wraped_st=txt.substring(0,status_string_total_length);
		$Jq(obj).html(wraped_st);
		$Jq('#onlineStatusFull').html(txt);
		$Jq(obj).attr('title', txt);
		curStatus = txt;
		updateUserStatus(v);

	}
	hideStatusPicker();
	return false;
}

function getAbsoluteOffsetLeft(obj) {
    var left = obj.offsetLeft;
    var parent = obj.offsetParent;
    while (parent != document.body) {
        left += parent.offsetLeft;
        parent = parent.offsetParent;
    }//EOF while-parent
    return left;
}// EOF getAbsoluteOffsetLeft()


function hideTarget(e){
	if(statusDivSet && allowHide)
		hideStatusPicker();
}

function hideAsEsc(){

}

function objListen(event, obj, func) {
	if(obj!=null){
    if (obj.addEventListener)  // W3C DOM
        obj.addEventListener(event,func,false);
    else if (elem.attachEvent)  // IE DOM
        obj.attachEvent('on'+event, function(){ func(new W3CDOM_Event(obj)) } );
	}
        // for IE we use a wrapper function that passes in a simplified faux Event object.
}

function updateUserStatus(st){
	 var isNumber = /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(st)
	 if(isNumber){
		var pars = 'u='+siteUserId+'&status=' + st;
		var url = cfg_site_url + 'online.php';
		//new Ajax.Request(url, {method:'post',parameters:pars,onComplete:newStatusUpdated});
		$Jq.ajax({
	   	type: "POST",
	   	url: url,
	   	data: pars,
	   	success: function(originalRequest){
	   				newStatusUpdated(originalRequest);
				}
		 });
	}
	else
		return;

}

function newStatusUpdated(resp){
	if (window.ActiveXObject) {
   		 var str = resp.xml;
 	}
// code for Mozilla, Firefox, Opera, etc.
	else {
   		var str = (new XMLSerializer()).serializeToString(resp);
	}
	txt = str;
	if(txt.indexOf('rror') > 0){
		clearInterval(onlineTimer);
	}
}


function print_r(ob){
	cont = '';
	for(var i in ob){
		cont += i + '=' + ob[i];
		cont += "\n";
	}
	alert(cont);
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

//-------------------------------------
/*** Mmeber Status change ***/
var _curStatus = '';
var statusDivSet = false;

function vj(){
	sp = $Jq('#onlineStatusSpan');
	var stval = $Jq('#onlineStatusFull').html();
	if(sp.html()!=null){
		s = sp.html();
		v = $Jq('#s');
		if(v.html()==null){
			s = '<input class="clsInputMemberStatus" type="text" name="s" onkeyUp="store(this.value, event)" maxlength="20" size="' + s.length + '" id="s" value="'+ stval +'">';
			sp.html(s);
			$Jq('#s').select();
			$Jq('#s').focus();
		}
	}
}

function store(v, evt){
	sp = $Jq('#onlineStatusSpan');
	sp_full = $Jq('#onlineStatusFull');
	evt = (evt) ? evt : window.event
	curEvent = evt;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode==27){
		//sp.innerHTML = curStatus.replace(/<\/?[^>]+>/gi, '');
		var wraped_st=curStatus.replace(/<\/?[^>]+>/gi, '');
		if(status_string_total_length<wraped_st.length){
			wraped_st=wraped_st.substring(0,status_string_total_length)+' ...';
		}
		else{
			wraped_st=wraped_st.substring(0,status_string_total_length);
		}
		sp.html(wraped_st);
		sp.attr('title', curStatus);
		sp_full.html(curStatus.replace(/<\/?[^>]+>/gi, ''));
	}
	if(charCode==13){
		existing = 0
		if(status_all){
			status_array=status_all.split(',');
		}
		else{
			status_array='';
		}
		for(k=0;k<status_array.length;k++){
			status_new=status_array[k];
			status_split=status_new.split('#~#');
			status_id=status_split[0];
			status_value=status_split[1];
			if(stricmp(status_value, v)){
				existing ++;
			}
		}
		if(existing==0){
		    var RegExp=/^[A-Za-z0-9\s]+$/;
		    if(v.search(RegExp)==-1) {
				alert_manual(LANG_STATUS_ERROR_MSG);
			    return false;
			}
			openAjaxWindow('true', 'ajaxupdate', 'saveStatus', v);
		}
		else{
			//sp.innerHTML = v.replace(/<\/?[^>]+>/gi, '');
			var wraped_st=v.replace(/<\/?[^>]+>/gi, '');
		   	if(status_string_total_length<wraped_st.length){
				wraped_st=wraped_st.substring(0,status_string_total_length)+' ...';
			}
			else{
				wraped_st=wraped_st.substring(0,status_string_total_length);
			}
			sp.html(wraped_st);
			sp.attr('title', v);
			sp_full.html(v.replace(/<\/?[^>]+>/gi, ''));
		}
	};
}

var saveStatus = function(){
	var st = callBackArguments[0];
	st = st.substring(0,20);
	st=$Jq.string(st).strip().stripTags().capitalize().str;
	st=$Jq.string(st).strip().stripScripts().capitalize().str;
	_curStatus = st;
	pars = 'u='+siteUserId+'&astatus=' + st;
	url = cfg_site_url + 'online.php';
	$Jq.ajax({
		type: "POST",
		url: url,
		data: pars,
		success: function(html){
			newStatusAdded(html)
		}
	 });
}

function newStatusAdded(rep){
	if(null!==rep && 'object'== typeof(rep)){
		xmlDoc = rep;
		r = xmlDoc.documentElement.getElementsByTagName("id");
		s = r[0].childNodes[0].nodeValue
		st = _curStatus;
		if(status_all){
			status_all=status_all+','+s+'#~#'+st;
		} else {
			status_all=s+'#~#'+st;
		}
		sp = $Jq('#onlineStatusSpan');
		sp_full=$Jq('#onlineStatusFull');
		if(status_string_total_length<st.length){
			var wraped_st=st.substring(0,status_string_total_length)+' ...';
		} else {
			var wraped_st=st.substring(0,status_string_total_length);
		}
		//sp.update(st)
		sp.html(wraped_st)
		sp_full.html(st)
		sp.attr('title', st);
		curStatus = st;
		hideStatusPicker();
	} else if(rep.indexOf('rror')>0){
		clearInterval(onlineTimer);
		alert_manual('session expired');
	}
}

function hideStatusPicker(){
	var picker = $Jq('#'+pickerElementId);
    if (statusDivSet) {
		if(picker!=null){
	        picker.hide();
	    }
	    if (doiframe){
	    	var iframe = $Jq('#'+iframePickerId);
			if(iframe!=null){
	            iframe.hide();
	        }
	    }
    }
	statusDivSet = false
}